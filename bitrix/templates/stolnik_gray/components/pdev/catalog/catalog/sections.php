<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$arCurSection = array();
$arFilter = array(
    'IBLOCK_ID' => CATALOG_IBLOCK_ID,
    'ACTIVE' => 'Y',
    'GLOBAL_ACTIVE' => 'Y',
);
if (isset($arResult['VARIABLES']['SECTION_CODE']) && strlen($arResult['VARIABLES']['SECTION_CODE']) > 0) {
    $arFilter['=CODE'] = $arResult['VARIABLES']['SECTION_CODE'];
} else {
    $arFilter['DEPTH_LEVEL'] = '1';
}
$obCache = new CPHPCache();
if ($obCache->InitCache(36000, serialize($arFilter), '/iblock/catalog_sections')) {
    $arCurSection = $obCache->GetVars();
} elseif ($obCache->StartDataCache()) {
    if (\Bitrix\Main\Loader::includeModule('iblock')) {
        $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array('ID', 'NAME'));

        if (defined('BX_COMP_MANAGED_CACHE')) {
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache('/iblock/catalog_sections');

            if ($arCurSection = $dbRes->Fetch()) {
                $CACHE_MANAGER->RegisterTag('iblock_id_'.$arParams['IBLOCK_ID']);
            }
            $CACHE_MANAGER->EndTagCache();
        } // else: не гоже в наше время пользовать старенький кэш
    }
    $obCache->EndDataCache($arCurSection);
}
?>

<?$APPLICATION->IncludeComponent(
    "dx:catalog.section.list",
    "",
    array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
        "SECTION_ID" => $arCurSection['ID'],
        "COUNT_ELEMENTS" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "TOP_DEPTH" => "2",
        "LOAD_IPROPS" => "N",
    ),
    $component
);?>

<?$APPLICATION->IncludeComponent(
    "dx:banner",
    "",
    array(
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "CACHE_GROUPS" => "N",
        "IBLOCK_TYPE" => "services",
        "IBLOCK_ID" => BANNERS_IBLOCK_ID,
        "BANNER_TYPE" => "catalog_1_bottom"
    ),
    false
);?>

    </section>
</section>
<section class="b-wrapper b-wrapper_light-grey">
    <section class="b-container">

        <ul class="b-list b-list_three b-list_mb-40 g-clear">
            <?$APPLICATION->IncludeComponent(
                "dx:banner",
                "small",
                array(
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "600",
                    "CACHE_GROUPS" => "N",
                    "IBLOCK_TYPE" => "services",
                    "IBLOCK_ID" => BANNERS_IBLOCK_ID,
                    "BANNER_TYPE" => "catalog_3_bottom_1"
                ),
                false
            );?>
            <?$APPLICATION->IncludeComponent(
                "dx:banner",
                "small",
                array(
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "600",
                    "CACHE_GROUPS" => "N",
                    "IBLOCK_TYPE" => "services",
                    "IBLOCK_ID" => BANNERS_IBLOCK_ID,
                    "BANNER_TYPE" => "catalog_3_bottom_2"
                ),
                false
            );?>
            <?$APPLICATION->IncludeComponent(
                "dx:banner",
                "small",
                array(
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "600",
                    "CACHE_GROUPS" => "N",
                    "IBLOCK_TYPE" => "services",
                    "IBLOCK_ID" => BANNERS_IBLOCK_ID,
                    "BANNER_TYPE" => "catalog_3_bottom_3"
                ),
                false
            );?>
        </ul>

