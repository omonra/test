<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CModule::IncludeModule("iblock");


if (!isset($GLOBALS[$arParams['FILTER_NAME']])) {
    $GLOBALS[$arParams['FILTER_NAME']] = array();
}

$arActions = GetActiveActions();

if (substr($arResult["VARIABLES"]['SECTION_CODE'], 0, strlen('news_')) == 'news_' || substr($arResult["VARIABLES"]['SECTION_CODE'], 0, strlen('spec_')) == 'spec_' || (is_array($arActions) && count($arActions) > 0 && substr($arResult["VARIABLES"]['SECTION_CODE'], 0, strlen('action_')) == 'action_')) {
    $onlyActionProducts = false;
    if (is_array($arActions) && count($arActions) > 0 && substr($arResult["VARIABLES"]['SECTION_CODE'], 0, strlen('action_')) == 'action_') {
        $onlyActionProducts = true;
    } else {
        if (substr($arResult["VARIABLES"]['SECTION_CODE'], 0, strlen('news_')) == 'news_') {
            $onlyNewProducts = true;
        } else {
            $onlyNewProducts = false;
        }
    }

    $arResult["VARIABLES"]['SECTION_CODE'] = substr($arResult["VARIABLES"]['SECTION_CODE'], strpos($arResult["VARIABLES"]['SECTION_CODE'], '_') + 1);
    if (strlen($arResult["VARIABLES"]['SECTION_CODE']) <= 0) {
        Show404();
    }

    $rsFields = CIBlockSection::GetList(array(), array(
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'ACTIVE' => 'Y',
        '=CODE' => $arResult["VARIABLES"]['SECTION_CODE'],
    ), false, array('ID'));
    if ($arFields = $rsFields->GetNext()) {
        $GLOBALS[$arParams['FILTER_NAME']]['SECTION_ID'] = $arFields['ID'];
        $GLOBALS[$arParams['FILTER_NAME']]['ACTIVE'] = 'Y';
        if (is_array($arActions) && count($arActions) > 0 && $onlyActionProducts) {
            $GLOBALS[$arParams['FILTER_NAME']]['PROPERTY_' . $arActions[0]['PROPERTY_CODE']] = 'true';
        } else {
            if ($onlyNewProducts) {
                $GLOBALS[$arParams['FILTER_NAME']][] = array(
                    'LOGIC' => 'OR',
                    '>=DATE_CREATE' => ConvertTimeStamp(time()-3600*24*7, 'FULL'),
                    'PROPERTY_NOVINKA' => 'true',
                );
            } else {
                $GLOBALS[$arParams['FILTER_NAME']]['PROPERTY_RASPRODAZHA'] = 'true';
            }
        }
        $arParams["INCLUDE_SUBSECTIONS"] = 'Y';
    } else {
        Show404();
    }
}

$arParams['CACHE_FILTER'] = 'Y';

$GLOBALS[$arParams['FILTER_NAME']] = array_merge($GLOBALS[$arParams['FILTER_NAME']], GetCatalogSectionFilter());
?>

<h1 class="b-page-title b-page-title_bordered"><?=$APPLICATION->ShowTitle(false)?></h1>

<?
list($sort, $order, $sort2, $order2) = GetSortOrder((!$onlyActionProducts && $onlyNewProducts ? 'new_desc' : ''));?>
<?=GetSortOrderControls($sort, $order)?>

<div class="g-clear">
    <?
    $sectionId = 0;
    $currentSectionId = 0;
    $rsFields = CIBlockSection::GetList(array(), array(
        'IBLOCK_ID' => CATALOG_IBLOCK_ID,
        'ACTIVE' => 'Y',
        '=CODE' => $arResult["VARIABLES"]["SECTION_CODE"],
    ), false, array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'DEPTH_LEVEL', 'SECTION_PAGE_URL'));
    if ($arFields = $rsFields->GetNext()) {
        $currentSectionId = $arFields['ID'];
        if ($arFields['DEPTH_LEVEL'] == 3) {
            $sectionId = $arFields['IBLOCK_SECTION_ID'];
        } else {
            $sectionId = $arFields['ID'];
        }
    }
    if ($sectionId > 0):?>
        <?$APPLICATION->IncludeComponent(
            "dx:super.comp",
            "sidebar",
            array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "SECTION_ID" => $sectionId,
                "COUNT_ELEMENTS" => "Y",
            ),
            $component
        );?>
    <?endif;?>

    <?if($arParams["USE_FILTER"]=="Y"):?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.smart.filter",
            "",
            array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "FILTER_NAME" => $arParams["FILTER_NAME"],
                "FIELD_CODE" => $arParams["FILTER_FIELD_CODE"],
                "PROPERTY_CODE" => $arParams["FILTER_PROPERTY_CODE"],
                "PRICE_CODE" => $arParams["FILTER_PRICE_CODE"],
                "OFFERS_FIELD_CODE" => $arParams["FILTER_OFFERS_FIELD_CODE"],
                "OFFERS_PROPERTY_CODE" => $arParams["FILTER_OFFERS_PROPERTY_CODE"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "SECTION_ID" => $arFields['ID'],
            ),
            $component
        );
        ?>
    <?endif;?>

    <?$APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        "",
        array(
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ELEMENT_SORT_FIELD" => GetIblockSort($sort, $order),
            "ELEMENT_SORT_ORDER" => $order,
            "ELEMENT_SORT_FIELD2" => $sort2,
            "ELEMENT_SORT_ORDER2" => $order2,
            "SHOW_ALL_WO_SECTION"=>"Y",
            "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
            "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
            "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
            "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
            "INCLUDE_SUBSECTIONS" => "Y", // $arParams["INCLUDE_SUBSECTIONS"],
            "BASKET_URL" => $arParams["BASKET_URL"],
            "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
            "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
            "FILTER_NAME" => $arParams["FILTER_NAME"],
            "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_FILTER" => $arParams["CACHE_FILTER"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "SET_TITLE" => $arParams["SET_TITLE"],
            "SET_STATUS_404" => $arParams["SET_STATUS_404"],
            "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
            "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
            "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
            "PRICE_CODE" => $arParams["PRICE_CODE"],
            "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],

            "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
            "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
            "PAGER_TITLE" => $arParams["PAGER_TITLE"],
            "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
            "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
            "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
            "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
            "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

            "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
            "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
            "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
            "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
            "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
            "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

            "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
            "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
            "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
            "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
            "COUNT_ELEMENTS" => "N",
            "ADD_SECTIONS_CHAIN" => "Y"
        ),
        $component
    );?>
</div>
