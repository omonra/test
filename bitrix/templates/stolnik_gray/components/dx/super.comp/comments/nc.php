<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();?>
<?
$arResult['ERRORS'] = array();
$arResult['VARS'] = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && (!isset($_POST['PARAMS_HASH']) || $arResult['PARAMS_HASH'] === $_POST['PARAMS_HASH'])) {
    if (check_bitrix_sessid()) {

        if (isset($_POST['name']) && strlen($_POST['name'])) {
            $arResult['VARS']['name'] = htmlspecialcharsEx($_POST['name']);
        } else {
            $arResult['ERRORS'][] = 'Заполните поле: "Ваше имя"';
        }

        if (isset($_POST['email']) && strlen($_POST['email'])) {
            $arResult['VARS']['email'] = htmlspecialcharsEx($_POST['email']);
            if (!check_email($arResult['VARS']['email'])) {
                $arResult['ERRORS'][] = 'Укажите корректный адрес электронной почты';
            }
        } else {
            $arResult['ERRORS'][] = 'Заполните поле: "Электронная почта"';
        }

        if (isset($_POST['text']) && strlen($_POST['text'])) {
            $arResult['VARS']['text'] = htmlspecialcharsbx(strip_tags($_POST['text']));
        } else {
            $arResult['ERRORS'][] = 'Заполните поле: "Сообщение"';
        }

        if (isset($_POST['rating']) && strlen($_POST['rating'])) {
            $arResult['VARS']['rating'] = htmlspecialcharsEx($_POST['rating']);
        } else {
            $arResult['ERRORS'][] = 'Оцените товар';
        }

        if ($arResult['USE_CAPTCHA'] == 'Y') {
            include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/classes/general/captcha.php');
            $captcha_code = $_POST['captcha_sid'];
            $captcha_word = $_POST['captcha_word'];
            $cpt = new CCaptcha();
            $captchaPass = COption::GetOptionString('main', 'captcha_password', '');
            if (strlen($captcha_word) > 0 && strlen($captcha_code) > 0)
            {
                if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass))
                    $arResult['ERRORS'][] = 'Указан не верный проверочный код.';
            }
            else
                $arResult['ERRORS'][] = 'Не указан проверочный код.';
        }

        if (is_array($arResult['ERRORS']) && count($arResult['ERRORS']) <= 0) {
            $arProps = array(
                'PRODUCT_ID' => $arParams['ELEMENT_ID'],
                'NAME' => $arResult['VARS']['name'],
                'EMAIL' => $arResult['VARS']['email'],
                'RATING' => $arResult['VARS']['rating'],
            );
            if (isset($USER) && $USER->IsAuthorized()) {
                $arProps['user'] = $USER->GetId();
            }
            $arFields = array(
                'ACTIVE' => 'N',
                'IBLOCK_ID' => $arParams['IBLOCK_ID2'],
                'ACTIVE_FROM' => ConvertTimeStamp(time(), 'FULL'),
                'NAME' => 'comment_' . $arParams['ELEMENT_ID'] . '_' . rand(0, 99999),
                'DETAIL_TEXT' => $arResult['VARS']['text'],
                'DETAIL_TEXT_TYPE' => 'text',
                'PROPERTY_VALUES' => $arProps,
            );
            $ib = new CIblockElement;
            $id = $ib->Add($arFields);
            if ($id) {
                UpdateCommentsCount($arParams['ELEMENT_ID']);
                $name = $arResult['VARS']['name'];
                $email = $arResult['VARS']['email'];

                $arResult['SITE'] = array();
                $db_res = CSite::GetByID(SITE_ID);
                if ($db_res && $res = $db_res->GetNext()) {
                    $arResult['SITE'] = $res;
                }

                $arEventFields = array(
                    'ELEMENT_NAME' => $arResult['ELEMENT']['NAME'],
                    'AUTHOR' => $name,
                    'EMAIL' => $email,
                    'COMMENT_DATE' => $arFields['ACTIVE_FROM'],
                    'COMMENT_TEXT' => $arResult['VARS']['text'],
                    'COMMENT_PATH' => 'http://' . $arResult["SITE"]['SERVER_NAME'] . $arResult['ELEMENT']['DETAIL_PAGE_URL'] . '#comments-block',
                    'EDIT_URL' => 'http://' . $arResult["SITE"]['SERVER_NAME'] . '/bitrix/admin/iblock_element_edit.php?WF=Y&ID=' . $id . '&type=service&lang=ru&IBLOCK_ID=' . $arParams['IBLOCK_ID2'] . '&find_section_section=0',
                );
                CEvent::Send('COMMENTS_NEW', SITE_ID, $arEventFields);

                LocalRedirect($APPLICATION->GetCurPageParam('success='.$arResult['PARAMS_HASH'], array('success')) . '#reviews_form');
            } else {
                $arResult['ERRORS'][] = $ib->LAST_ERROR;
            }
        }
    }
} elseif ($_REQUEST['success'] == $arResult['PARAMS_HASH']) {
    $arResult['OK_MESSAGE'] = 'Ваше сообщение добавлено.';
    if ($arResult['USE_CAPTCHA'] == 'Y') {
        $arResult['OK_MESSAGE'] .= ' После проверки модератором, оно появится на сайте.';
    }
}

if($arResult['USE_CAPTCHA'] == 'Y') {
    $arResult['capCode'] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode());
}
?>
