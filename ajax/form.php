<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");?>

<?
if (!isset($_GET['form_name']) || strlen($_GET['form_name']) <= 0) {
    return;
}

$formSid = strip_tags(trim($_GET['form_name']));
?>
<?if ($_SERVER['REQUEST_METHOD'] == 'GET'):?>
<div id="ajax_form_container_<?=$formSid?>">
<?endif;?>
<?

if ($formSid == 'login') {
    ?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:system.auth.form",
        "",
        Array(
            "REGISTER_URL" => "/login/",
            "PROFILE_URL" => "/login/",
            "SHOW_ERRORS" => "Y",
        )
    );?>
    <?
} elseif ($formSid == 'registration') {
    ?>
    <?$APPLICATION->IncludeComponent("bitrix:system.auth.registration", ".default", Array(
            "SHOW_TITLE" => "Y",
        ),
        false
    );?>
    <?
} else {
    $arForm = array();
    $obCache = new CPHPCache();
    if ($obCache->InitCache(36000, $formSid, '/form/ajax')) {
        $arForm = $obCache->GetVars();
    } elseif ($obCache->StartDataCache()) {
        if (\Bitrix\Main\Loader::includeModule('form')) {
            $dbRes = CForm::GetBySid($formSid);

            if (defined('BX_COMP_MANAGED_CACHE')) {
                global $CACHE_MANAGER;
                $CACHE_MANAGER->StartTagCache('/form/ajax');

                if ($arForm = $dbRes->Fetch()) {
                    $CACHE_MANAGER->RegisterTag('form_'.$arForm['ID']);
                }
                $CACHE_MANAGER->EndTagCache();
            } // else: не гоже в наше время пользовать старенький кэш
        }
        $obCache->EndDataCache($arForm);
    }
    if (!isset($arForm['ID']) || $arForm['ID'] <= 0) {
        return;
    }
    ?>

    <?$APPLICATION->IncludeComponent("bitrix:form.result.new", ".default", Array(
            "WEB_FORM_ID" => $arForm['ID'],
            "IGNORE_CUSTOM_TEMPLATE" => "N",
            "USE_EXTENDED_ERRORS" => "N",
            "SEF_MODE" => "N",
            "SEF_FOLDER" => "/",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600",
            "LIST_URL" => "",
            "EDIT_URL" => "",
            "SUCCESS_URL" => "",
            "CHAIN_ITEM_TEXT" => "",
            "CHAIN_ITEM_LINK" => "",
            "VARIABLE_ALIASES" => array(
                "WEB_FORM_ID" => "WEB_FORM_ID",
                "RESULT_ID" => "RESULT_ID",
            )
        ),
        false
    );?>
<?}?>
<?if ($_SERVER['REQUEST_METHOD'] == 'POST'):?>
</div>
<?endif;?>

<?require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");?>
