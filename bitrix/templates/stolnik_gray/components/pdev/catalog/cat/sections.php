<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="sidebar">
    <?
    $section_men = COption::GetOptionString("stolnik", "ss_code_men", "2");
    $section_women = COption::GetOptionString("stolnik", "ss_code_wom", "2");
    $section_acc = COption::GetOptionString("stolnik", "ss_code_aks", "2");
    ?>
    <?/*<div class="side_block side_block_first side_block_new">
        <div>Новинки</div>
        <div><strong>Распродажа</strong></div>
    </div>*/?>
<?$k=$APPLICATION->IncludeComponent(
	"pdev:catalog.section.list",
	"",
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
        "SECTION_CODE"=>$arResult["VARIABLES"]["SECTION_CODE"],
        "COUNT_ELEMENTS" => "N",
	),
	$component
);
?>
    <?
    global $arrFilterSections;
    if($arResult["VARIABLES"]["SECTION_CODE"]==$section_men){
        $arrFilterSections=array(
            "PROPERTY_TYPE"=>array(43),
        );
    }elseif($arResult["VARIABLES"]["SECTION_CODE"]==$section_women){
        $arrFilterSections=array(
            "PROPERTY_TYPE"=>array(42),
        );
    }else{//аксессуары
        $arrFilterSections=array(
            "PROPERTY_TYPE"=>array(102),
        );
    }

    ?>

    <?$APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "action_list",
    Array(
        "AJAX_MODE" => "N",
        "IBLOCK_TYPE" => "services",
        "IBLOCK_ID" => "6",
        "SECTION_ID" => "",
        "SECTION_CODE" => "",
        "SECTION_USER_FIELDS" => array(),
        "ELEMENT_SORT_FIELD" => "sort",
        "ELEMENT_SORT_ORDER" => "asc",
        "FILTER_NAME" => "arrFilterSections",
        "INCLUDE_SUBSECTIONS" => "N",
        "SHOW_ALL_WO_SECTION" => "Y",
        "SECTION_URL" => "",
        "DETAIL_URL" => "",
        "BASKET_URL" => "/personal/basket.php",
        "ACTION_VARIABLE" => "action",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "META_KEYWORDS" => "-",
        "META_DESCRIPTION" => "-",
        "BROWSER_TITLE" => "-",
        "ADD_SECTIONS_CHAIN" => "N",
        "DISPLAY_COMPARE" => "N",
        "SET_TITLE" => "Y",
        "SET_STATUS_404" => "N",
        "PAGE_ELEMENT_COUNT" => "30",
        "LINE_ELEMENT_COUNT" => "",
        "PROPERTY_CODE" => array("LINK", "TYPE"),
        "PRICE_CODE" => array(),
        "USE_PRICE_COUNT" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "PRICE_VAT_INCLUDE" => "Y",
        "PRODUCT_PROPERTIES" => array(),
        "USE_PRODUCT_QUANTITY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TITLE" => "Товары",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => "",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "COUNT_ELEMENTS" => "N",
    ),
    false
);?>
    <?
    global $arrFilterPages;
    if($arResult["VARIABLES"]["SECTION_CODE"]==$section_men){
        $arrFilterPages=array(
            "PROPERTY_LIST"=>array(44),
        );
    }else{
        $arrFilterPages=array(
            "PROPERTY_LIST"=>array(45),
        );
    }

    ?>
    <?$APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "polezno",
    Array(
        "AJAX_MODE" => "N",
        "IBLOCK_TYPE" => "services",
        "IBLOCK_ID" => "7",
        "SECTION_ID" => "",
        "SECTION_CODE" => "",
        "SECTION_USER_FIELDS" => array(),
        "ELEMENT_SORT_FIELD" => "sort",
        "ELEMENT_SORT_ORDER" => "asc",
        "FILTER_NAME" => "arrFilterPages",
        "INCLUDE_SUBSECTIONS" => "N",
        "SHOW_ALL_WO_SECTION" => "Y",
        "SECTION_URL" => "",
        "DETAIL_URL" => "/articles/#ELEMENT_CODE#/",
        "BASKET_URL" => "/personal/basket.php",
        "ACTION_VARIABLE" => "action",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "META_KEYWORDS" => "-",
        "META_DESCRIPTION" => "-",
        "BROWSER_TITLE" => "-",
        "ADD_SECTIONS_CHAIN" => "N",
        "DISPLAY_COMPARE" => "N",
        "SET_TITLE" => "Y",
        "SET_STATUS_404" => "N",
        "PAGE_ELEMENT_COUNT" => "30",
        "LINE_ELEMENT_COUNT" => "",
        "PROPERTY_CODE" => array("LINK"),
        "PRICE_CODE" => array(),
        "USE_PRICE_COUNT" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "PRICE_VAT_INCLUDE" => "Y",
        "PRODUCT_PROPERTIES" => array(),
        "USE_PRODUCT_QUANTITY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TITLE" => "Товары",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => "",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "COUNT_ELEMENTS" => "N",
    ),
    false
);?>
    </div>

    <div class="base_content">
    <?
    global $arrFilterIndexBanner;
    if($arResult["VARIABLES"]["SECTION_CODE"]==$section_men){
        $arrFilterIndexBanner=array(
            "PROPERTY_TYPE"=>array(36,88),
        );
    }elseif($arResult["VARIABLES"]["SECTION_CODE"]==$section_women){
        $arrFilterIndexBanner=array(
            "PROPERTY_TYPE"=>array(38,89),
        );
    }else{//аксессуары
        $arrFilterIndexBanner=array(
            "PROPERTY_TYPE"=>array(143,145),
        );
    }
    ?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        "inner_bigbanner",
        Array(
            "AJAX_MODE" => "N",
            "IBLOCK_TYPE" => "services",
            "IBLOCK_ID" => "6",
            "SECTION_ID" => "",
            "SECTION_CODE" => "",
            "SECTION_USER_FIELDS" => array(),
            "ELEMENT_SORT_FIELD" => "sort",
            "ELEMENT_SORT_ORDER" => "asc",
            "FILTER_NAME" => "arrFilterIndexBanner",
            "INCLUDE_SUBSECTIONS" => "N",
            "SHOW_ALL_WO_SECTION" => "Y",
            "SECTION_URL" => "",
            "DETAIL_URL" => "",
            "BASKET_URL" => "/personal/basket.php",
            "ACTION_VARIABLE" => "action",
            "PRODUCT_ID_VARIABLE" => "id",
            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
            "PRODUCT_PROPS_VARIABLE" => "prop",
            "SECTION_ID_VARIABLE" => "SECTION_ID",
            "META_KEYWORDS" => "-",
            "META_DESCRIPTION" => "-",
            "BROWSER_TITLE" => "-",
            "ADD_SECTIONS_CHAIN" => "N",
            "DISPLAY_COMPARE" => "N",
            "SET_TITLE" => "N",
            "SET_STATUS_404" => "N",
            "PAGE_ELEMENT_COUNT" => "300",
            "LINE_ELEMENT_COUNT" => "1",
            "PROPERTY_CODE" => array("LINK", "TYPE"),
            "PRICE_CODE" => array(),
            "USE_PRICE_COUNT" => "N",
            "SHOW_PRICE_COUNT" => "1",
            "PRICE_VAT_INCLUDE" => "Y",
            "PRODUCT_PROPERTIES" => array(),
            "USE_PRODUCT_QUANTITY" => "N",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "PAGER_TITLE" => "Товары",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => "",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
            "COUNT_ELEMENTS" => "N",
        ),
        false
    );?>

    <?
    global $arrFilterIndexBanner2;
    if($arResult["VARIABLES"]["SECTION_CODE"]==$section_men){
        $arrFilterIndexBanner2=array(
            "PROPERTY_TYPE"=>array(37),
        );
    }elseif($arResult["VARIABLES"]["SECTION_CODE"]==$section_women){
        $arrFilterIndexBanner2=array(
            "PROPERTY_TYPE"=>array(39),
        );
    }else{//аксессуары
        $arrFilterIndexBanner2=array(
            "PROPERTY_TYPE"=>array(144),
        );
    }
    ?>
	<?/*if($USER->isAdmin())
	{
		echo "<pre>",print_r($arrFilterIndexBanner2,1),"</pre>";
	}*/
	?>
	
	
    <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
        "AREA_FILE_SHOW" => "file",
        "PATH" => "/include/".$arResult["VARIABLES"]["SECTION_CODE"]."_section_text.php",
        "EDIT_TEMPLATE" => ""
        ),
        false
    );?>
<?$APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "index_smallbanner",
    Array(
        "AJAX_MODE" => "N",
        "IBLOCK_TYPE" => "services",
        "IBLOCK_ID" => "6",
        "SECTION_ID" => "",
        "SECTION_CODE" => "",
        "SECTION_USER_FIELDS" => array(),
        "ELEMENT_SORT_FIELD" => "rand",
        "ELEMENT_SORT_ORDER" => "rand",
        "FILTER_NAME" => "arrFilterIndexBanner2",
        "INCLUDE_SUBSECTIONS" => "N",
        "SHOW_ALL_WO_SECTION" => "Y",
        "SECTION_URL" => "",
        "DETAIL_URL" => "",
        "BASKET_URL" => "/personal/basket.php",
        "ACTION_VARIABLE" => "action",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "META_KEYWORDS" => "-",
        "META_DESCRIPTION" => "-",
        "BROWSER_TITLE" => "-",
        "ADD_SECTIONS_CHAIN" => "N",
        "DISPLAY_COMPARE" => "N",
        "SET_TITLE" => "N",
        "SET_STATUS_404" => "N",
        "PAGE_ELEMENT_COUNT" => "3",
        "LINE_ELEMENT_COUNT" => "1",
        "PROPERTY_CODE" => array("LINK", "TYPE"),
        "PRICE_CODE" => array(),
        "USE_PRICE_COUNT" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "PRICE_VAT_INCLUDE" => "Y",
        "PRODUCT_PROPERTIES" => array(),
        "USE_PRODUCT_QUANTITY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TITLE" => "Товары",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => "",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "COUNT_ELEMENTS" => "N",
    ),
    false
);?>

        <?
        global $listsection;
        global $arrFilterIndexPopuar2;
        $arrFilterIndexPopuar2=array(
            "SECTION_ID"=>$listsection,
            "!PROPERTY_POPULAR"=>false,
        );
        ?>
        <?$APPLICATION->IncludeComponent("bitrix:catalog.section", "index_popular", array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "SECTION_ID" => "",
            "SECTION_CODE" => "",
            "SECTION_USER_FIELDS" => array(
                0 => "",
                1 => "",
            ),
            "ELEMENT_SORT_FIELD" => "sort",
            "ELEMENT_SORT_ORDER" => "asc",
            "FILTER_NAME" => "arrFilterIndexPopuar2",
            "INCLUDE_SUBSECTIONS" => "N",
            "SHOW_ALL_WO_SECTION" => "Y",
            "PAGE_ELEMENT_COUNT" => "300",
            "LINE_ELEMENT_COUNT" => "1",
            "PROPERTY_CODE" => array(
                0 => "",
                1 => "",
            ),
            "OFFERS_FIELD_CODE" => array(
                0 => "",
                1 => "",
            ),
            "OFFERS_PROPERTY_CODE" => array(
                0 => "CML2_LINK",
                1 => "",
            ),
            "OFFERS_SORT_FIELD" => "sort",
            "OFFERS_SORT_ORDER" => "asc",
            "SECTION_URL" => "",
            "DETAIL_URL" => "",
            "BASKET_URL" => "/personal/basket.php",
            "ACTION_VARIABLE" => "action",
            "PRODUCT_ID_VARIABLE" => "id",
            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
            "PRODUCT_PROPS_VARIABLE" => "prop",
            "SECTION_ID_VARIABLE" => "SECTION_ID",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_GROUPS" => "Y",
            "META_KEYWORDS" => "-",
            "META_DESCRIPTION" => "-",
            "BROWSER_TITLE" => "-",
            "ADD_SECTIONS_CHAIN" => "N",
            "DISPLAY_COMPARE" => "N",
            "SET_TITLE" => "N",
            "SET_STATUS_404" => "N",
            "CACHE_FILTER" => "N",
            "PRICE_CODE" => array(
                0 => "Розничная (ЧМЗ)",
                1 => "BASE",
                2 => "Оптовая",
                3 => "Розничная",
                4 => "Розничная (Аверс)",
                5 => "Розничная (ABC 1)",
                6 => "Розничная (ABC 2)",
                7 => "Розничная Сток(Фиеста)",
                8 => "Розничная (Кольцо)",
                9 => "Розничная Сток 6 (БК)",
                10 => "Розничная Сток (АП)",
                11 => "Розничная СТОК-5 (ЧТЗ)",
            ),
            "USE_PRICE_COUNT" => "N",
            "SHOW_PRICE_COUNT" => "1",
            "PRICE_VAT_INCLUDE" => "Y",
            "USE_PRODUCT_QUANTITY" => "N",
            "OFFERS_CART_PROPERTIES" => array(
            ),
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "PAGER_TITLE" => "Товары",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => "",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "COUNT_ELEMENTS" => "N",
        ),
        false
    );?>

    <?//if($USER->IsAdmin()):?>
        <?if($arResult["VARIABLES"]["SECTION_CODE"]==$section_men){?>
        <div class="section_text_catalog">
            <h2 class="h_type_1"><span class="h_in">ИНФОРМАЦИЯ</span></h2>
            <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => SITE_DIR."include/includecatalog_men2.php",
                    "EDIT_TEMPLATE" => ""
                ),
                false
            );?>
        </div>
        <?}elseif($arResult["VARIABLES"]["SECTION_CODE"]==$section_women){?>
        <div class="section_text_catalog">
            <h2 class="h_type_1"><span class="h_in">ИНФОРМАЦИЯ</span></h2>
            <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => SITE_DIR."include/includecatalog_women2.php",
                    "EDIT_TEMPLATE" => ""
                ),
                false
            );?>
        </div>
        <?}?>
    <?//endif;?>

    </div>
