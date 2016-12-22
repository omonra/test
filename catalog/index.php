<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$cururl = $APPLICATION->GetCurPageParam();
$pagecode = explode("/",$cururl);

$pagecode = $pagecode[2];

$section_men = COption::GetOptionString("stolnik", "ss_code_men", "2");
$section_women = COption::GetOptionString("stolnik", "ss_code_wom", "2");
$section_acc = COption::GetOptionString("stolnik", "ss_code_aks", "2");

if (strpos($sectionCode[2], 'muzhskaya') !== false || strpos($sectionCode[2], $section_men) !== false) {
    $APPLICATION->SetTitle("stok-stolnik.ru :: интернет магазин стильной мужской одежды \"Стольник\". купить одежду для мужчин.");
    $APPLICATION->SetPageProperty("keywords", "интернет магазин женской одежды, одежда для женщин, интернет магазин модной одежды, женская одежда недорого, одежда для девушек, купить модную женскую одежду недорого, купить модную молодежную одежду оптом, купить модную одежду через интернет, купить недорого модную женскую одежду, купить модную одежду со скидкой");
} elseif (strpos($sectionCode[2], 'zhenskaya') !== false || strpos($sectionCode[2], $section_women) !== false) {
    $APPLICATION->SetTitle("stok-stolnik.ru :: интернет магазин модной женской одежды \"Стольник\".");
    $APPLICATION->SetPageProperty("keywords", "интернет магазин женской одежды, одежда для женщин, интернет магазин модной одежды, женская одежда недорого, одежда для девушек, купить модную женскую одежду недорого, купить модную молодежную одежду оптом, купить модную одежду через интернет, купить недорого модную женскую одежду, купить модную одежду со скидкой");
} else {
    $APPLICATION->SetTitle("Каталог");
}

global $arrFilterCat;
$arrFilterCat = array();
$arrFilterCat['!DETAIL_PICTURE'] = false;
//$arrFilterCat['>CATALOG_QUANTITY'] = 0;
//$arrFilterCat['>catalog_PRICE_1'] = 0;
$arrFilterCat['CATALOG_CAN_BUY_17'] = 'Y';
$arrFilterCat['CATALOG_AVAILABLE'] = 'Y';
//$arrFilterCat['>CATALOG_PRICE_17'] = '0';

?><?$APPLICATION->IncludeComponent(
	"pdev:catalog", 
	"catalog", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => CATALOG_IBLOCK_ID,
		"BASKET_URL" => "/personal/cart/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "/catalog/",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"SET_TITLE" => "Y",
		"SET_STATUS_404" => "Y",
		"USE_FILTER" => "Y",
		"FILTER_NAME" => "arrFilterCat",
		"USE_REVIEW" => "Y",
		"USE_COMPARE" => "N",
		"PRICE_CODE" => array(
			0 => "Розничная",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"SHOW_TOP_ELEMENTS" => "N",
		"PAGE_ELEMENT_COUNT" => "24",
		"LINE_ELEMENT_COUNT" => "3",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"LIST_PROPERTY_CODE" => array(
			0 => "CML2_ARTICLE",
			1 => "",
		),
		"INCLUDE_SUBSECTIONS" => "N",
		"LIST_META_KEYWORDS" => "UF_KEYWORDS",
		"LIST_META_DESCRIPTION" => "UF_DESCRIPTION",
		"LIST_BROWSER_TITLE" => "UF_TITLE",
		"LIST_OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"LIST_OFFERS_PROPERTY_CODE" => array(
			0 => "CML2_ATTRIBUTES",
			1 => "",
		),
		"LIST_OFFERS_LIMIT" => "0",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "COLECTION",
			1 => "SOSTAV",
			2 => "CML2_ARTICLE",
			3 => "DLINA_PO_VNUTRENNEMU_SHVU",
			4 => "DLINA_PO_SPINE",
			5 => "COMPANY_BRAND",
			6 => "CML2_MANUFACTURER",
			7 => "SEZON",
			8 => "KROY",
			9 => "STIL",
			10 => "BREND",
			11 => "BRAND",
			12 => "",
		),
		"DETAIL_META_KEYWORDS" => "KEYWORDS",
		"DETAIL_META_DESCRIPTION" => "DESCRIPTION",
		"DETAIL_BROWSER_TITLE" => "TITLE",
		"DETAIL_OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_OFFERS_PROPERTY_CODE" => array(
			0 => "CML2_ARTICLE",
			1 => "",
		),
		"LINK_IBLOCK_TYPE" => "catalog",
		"LINK_IBLOCK_ID" => "5",
		"LINK_PROPERTY_SID" => "CML2_LINK",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"USE_ALSO_BUY" => "N",
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"PAGER_TEMPLATE" => "arrows",
		"DISPLAY_TOP_PAGER" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"FILTER_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_PRICE_CODE" => array(
		),
		"FILTER_OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"MESSAGES_PER_PAGE" => "10",
		"USE_CAPTCHA" => "Y",
		"REVIEW_AJAX_POST" => "Y",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"FORUM_ID" => "",
		"URL_TEMPLATES_READ" => "",
		"SHOW_LINK_TO_FORUM" => "Y",
		"POST_FIRST_MESSAGE" => "N",
		"COMPONENT_TEMPLATE" => "catalog",
		"SEF_URL_TEMPLATES" => array(
			"sections" => "",
			"section" => "#SECTION_CODE#/",
			"element" => "#SECTION_CODE#/#ELEMENT_CODE#/",
			"compare" => "compare.php?action=#ACTION_CODE#",
		),
		"VARIABLE_ALIASES" => array(
			"compare" => array(
				"ACTION_CODE" => "action",
			),
		)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
