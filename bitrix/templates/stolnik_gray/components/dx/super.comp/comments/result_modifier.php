<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();?>
<?
$arResult = array('ITEMS' => array());
$arResult['PARAMS_HASH'] = md5(serialize($arParams).$this->__component->__template->__name);

$arParams['PAGE_ELEMENT_COUNT'] = intval($arParams['PAGE_ELEMENT_COUNT']);
if ($arParams['PAGE_ELEMENT_COUNT'] <= 0) {
    $arParams['PAGE_ELEMENT_COUNT'] = 4;
}
$arParams['ELEMENT_ID'] = intval($arParams['ELEMENT_ID']);
$arParams['PAGER_NAME'] = trim($arParams['PAGER_NAME']);

$arResult['USE_CAPTCHA'] = $arParams['USE_CAPTCHA'];


if (!\Bitrix\Main\Loader::includeModule('iblock'))
    return false;

if (intval($arParams['IBLOCK_ID1']) <= 0 || intval($arParams['IBLOCK_ID2']) <= 0) {
    ShowMessage('Не указан инфоблок.');
    return;
}

if ($arParams['ELEMENT_ID'] <= 0) {
    return;
}

$arNavParams = array(
    'nPageSize' => $arParams['PAGE_ELEMENT_COUNT'],
    'bDescPageNumbering' => false,
    'bShowAll' => false,
);

$rsFields = CIBlockElement::GetList(array(), array(
    'IBLOCK_ID' => $arParams['IBLOCK_ID1'],
    'ACTIVE' => 'Y',
    'ACTIVE_DATE' => 'Y',
    'ID' => $arParams['ELEMENT_ID'],
), false, array('nTopCount' => 1), array('ID', 'NAME', 'DETAIL_PAGE_URL'));
if ($arFields = $rsFields->GetNext()) {
    $arResult['ELEMENT'] = $arFields;

    $rsFields = CIBlockElement::GetList(array('ACTIVE_FROM' => 'DESC'), array(
        'IBLOCK_ID' => $arParams['IBLOCK_ID2'],
        'ACTIVE' => 'Y',
        'ACTIVE_DATE' => 'Y',
        'PROPERTY_PRODUCT_ID' => $arResult['ELEMENT']['ID'],
    ), false, $arNavParams, array(
        'ID',
        'NAME',
        'DATE_CREATE',
        'DETAIL_TEXT',
        'PROPERTY_NAME',
        'PROPERTY_LAST_NAME',
        'PROPERTY_EMAIL',
        'PROPERTY_RATING',
        'PROPERTY_ADMIN_REPLY',
        'PROPERTY_PRODUCT_ID'
    ));
    while ($arFields = $rsFields->GetNext()) {
        if (strlen($arFields['DATE_CREATE']) > 0) {
            $arFields['DISPLAY_ACTIVE_FROM'] = CIBlockFormatProperties::DateFormat($arParams['ACTIVE_DATE_FORMAT'], MakeTimeStamp($arFields['DATE_CREATE'], CSite::GetDateFormat()));
        } else {
            $arFields['DISPLAY_ACTIVE_FROM'] = '';
        }
        if (strlen($arFields['PROPERTY_LAST_NAME_VALUE']) > 0) {
            $arFields['PROPERTY_NAME_VALUE'] = $arFields['PROPERTY_LAST_NAME_VALUE'] . ' ' . $arFields['PROPERTY_NAME_VALUE'];
        }

        $arResult['ITEMS'][] = $arFields;
    }
    $arResult['NAV_STRING'] = $rsFields->GetPageNavStringEx($navComponentObject, 'Комментарии', $arParams['PAGER_NAME'], false);
    $arResult['NAV_CACHED_DATA'] = $navComponentObject->GetTemplateCachedData();
    $arResult['NAV_RESULT'] = $rsFields;
}




// saving template name to cache array
$arResult['__TEMPLATE_FOLDER'] = $this->__folder;

// writing new $arResult to cache file
$this->__component->arResult = $arResult;
?>
