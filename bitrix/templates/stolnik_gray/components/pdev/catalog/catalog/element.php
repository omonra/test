<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$ElementID=$APPLICATION->IncludeComponent(
    "bitrix:catalog.element",
    "",
        
    Array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "COMMENTS" => $comments,
        "CAPTCHA" =>$code,
        "TAB"=>$tab,
        "PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
        "META_KEYWORDS" => $arParams["DETAIL_META_KEYWORDS"],
        "META_DESCRIPTION" => $arParams["DETAIL_META_DESCRIPTION"],
        "BROWSER_TITLE" => $arParams["DETAIL_BROWSER_TITLE"],
        "BASKET_URL" => $arParams["BASKET_URL"],
        "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
        "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
        "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
        "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => "86400", // 1 день
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "SET_TITLE" => $arParams["SET_TITLE"],
        "SET_STATUS_404" => $arParams["SET_STATUS_404"],
        "PRICE_CODE" => $arParams["PRICE_CODE"],
        "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
        "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
        "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
        "PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
        "LINK_IBLOCK_TYPE" => $arParams["LINK_IBLOCK_TYPE"],
        "LINK_IBLOCK_ID" => $arParams["LINK_IBLOCK_ID"],
        "LINK_PROPERTY_SID" => $arParams["LINK_PROPERTY_SID"],
        "LINK_ELEMENTS_URL" => $arParams["LINK_ELEMENTS_URL"],
        "ADD_SECTIONS_CHAIN" => "Y",
        "ADD_ELEMENT_CHAIN" => "Y",
        "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
        "OFFERS_FIELD_CODE" => $arParams["DETAIL_OFFERS_FIELD_CODE"],
        "OFFERS_PROPERTY_CODE" => $arParams["DETAIL_OFFERS_PROPERTY_CODE"],
        "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
        "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],

        "ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
        "ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
        "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
        "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
    ),
    $component
);?>

<?if($arParams["USE_REVIEW"]=="Y" && $ElementID):?>
    <div class="b-product-reviews" id="reviews_form">
        <div class="title active" data-el="#comments-block">Отзывы и вопросы</div>
        <?/*<div class="title" data-el="#stores-block">Наличие в магазинах</div>*/?>
        <?$APPLICATION->IncludeComponent("dx:super.comp", "comments", array(
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "IBLOCK_ID1" => $arParams["IBLOCK_ID"],
            "IBLOCK_ID2" => COMMENTS_IBLOCK_ID,
            "ELEMENT_ID" => $ElementID,
            "PAGE_ELEMENT_COUNT" => "3",
            "PAGER_NAME" => $arParams["PAGER_TEMPLATE"],
            "ACTIVE_DATE_FORMAT" => "j F, Y",
            "USE_CAPTCHA" => "Y",
            "NAV_IN_SESSION" => "N",
            ),
            false
        );?>

        <?/*<div class="body g-clear" id="stores-block" style="display: none;">
            <?$APPLICATION->IncludeComponent("dx:super.comp", "stores", array(
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "ELEMENT_ID" => $ElementID,
                ),
                false
            );?>
        </div>*/?>
    </div>
<?endif?>
<?
$arVisitedProductsIds = $APPLICATION->get_cookie("VISITED");
if (isset($arVisitedProductsIds) && strlen($arVisitedProductsIds) > 0) {
    $arVisitedProductsIds = unserialize($arVisitedProductsIds);
} else {
    $arVisitedProductsIds = array();
}

if (is_array($arVisitedProductsIds) && count($arVisitedProductsIds) > 0) {
    if (!\Bitrix\Main\Loader::includeModule('iblock')) {
        echo 'iblock module not found';
        die();
    }
    $arVisitedProductsIds = array_unique($arVisitedProductsIds);
    $rsFields = CIBlockElement::GetList(array(), array(
        'ACTIVE' => 'Y',
        'ID' => $arVisitedProductsIds,
    ), false, array('nTopCount' => count($arVisitedProductsIds)), array('ID'));
    $arTmpVisitedProductsIds = array();
    while ($arFields = $rsFields->GetNext()) {
        $arTmpVisitedProductsIds[] = $arFields['ID'];
    }
    foreach ($arVisitedProductsIds as $key => $id) {
        if (!in_array($id, $arTmpVisitedProductsIds)) {
            unset($arVisitedProductsIds[$key]);
        }
    }
    $GLOBALS['arrVisitedProductsFilter']['ID'] = $arVisitedProductsIds;
    ?><?$APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        "visited_products",
        array(
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ELEMENT_SORT_FIELD" => "rand",
            "ELEMENT_SORT_ORDER" => "rand",
            "SHOW_ALL_WO_SECTION" => "Y",
            "INCLUDE_SUBSECTIONS" => "Y",
            "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
            "BASKET_URL" => $arParams["BASKET_URL"],
            "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
            "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
            "FILTER_NAME" => "arrVisitedProductsFilter",
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_FILTER" => "Y",
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "SET_TITLE" => "N",
            "SET_STATUS_404" => "N",
            "DISPLAY_COMPARE" => "N",
            "PAGE_ELEMENT_COUNT" => "4",
            "PRICE_CODE" => $arParams["PRICE_CODE"],
            "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],

            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "N",
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

            "SECTION_ID" => "0",
            "SECTION_CODE" => "",
            // "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
            // "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
            "COUNT_ELEMENTS" => "N",
            "ADD_SECTIONS_CHAIN" => "N",
            "ELEMENTS_IDS4SORT" => $arVisitedProductsIds,
        ),
        $this->__component
    );?><?
}
