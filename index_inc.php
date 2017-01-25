<section class="b-wrapper">
    <section class="b-container" style="margin-top: 30px;">

        <?
        $GLOBALS['arrNewProductsFilter']['!PROPERTY_NOVINKA'] = false;
        $GLOBALS['arrNewProductsFilter']['!DETAIL_PICTURE'] = false;
        $GLOBALS['arrNewProductsFilter'] = array_merge($GLOBALS['arrNewProductsFilter'], GetCatalogSectionFilter());
        ?>

        <?$APPLICATION->IncludeComponent(
            "bitrix:store.catalog.top",
            ".default",
            array(
                "IBLOCK_TYPE_ID" => "catalog",
                "IBLOCK_ID" => array(
                    0 => "",
                    1 => CATALOG_IBLOCK_ID,
                    2 => "",
                ),
                "ELEMENT_SORT_FIELD" => "id",
                "ELEMENT_SORT_ORDER" => "desc",
                "ELEMENT_COUNT" => "20",
                "LINE_ELEMENT_COUNT" => "4",
                "PROPERTY_CODE" => array(
                    0 => "",
                    1 => "",
                ),
                "FLAG_PROPERTY_CODE" => "NOVINKA",
                "OFFERS_FIELD_CODE" => array(
                    0 => "",
                    1 => "",
                ),
                "OFFERS_PROPERTY_CODE" => array(
                    0 => "SIZE",
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
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600",
                "CACHE_GROUPS" => "Y",
                "DISPLAY_COMPARE" => "N",
                "DISPLAY_IMG_WIDTH" => "75",
                "DISPLAY_IMG_HEIGHT" => "225",
                "SHARPEN" => "30",
                "PRICE_CODE" => array(
                    0 => "Розничная",
                ),
                "USE_PRICE_COUNT" => "N",
                "SHOW_PRICE_COUNT" => "1",
                "PRICE_VAT_INCLUDE" => "Y",
                "USE_PRODUCT_QUANTITY" => "N",
                "FILTER_NAME" => "arrNewProductsFilter",
                "CACHE_FILTER" => "Y",
                "COMPONENT_TEMPLATE" => ".default"
            ),
            false
        );?>

		<?
        $GLOBALS['arrSaleFilter']['!PROPERTY_SALE'] = false;
        $GLOBALS['arrSaleFilter']['ACTIVE'] = 'Y';
        //$GLOBALS['arrSaleFilter']['>CATALOG_QUANTITY'] = 0;
        //$arrNewProductsFilter['!PROPERTY_NOVINKA'] = 'true';
        ?>

        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.section",
            "index_slider",
            Array(
                    "ACTION_VARIABLE" => "action",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "BACKGROUND_IMAGE" => "-",
                    "BASKET_URL" => "/personal/basket.php",
                    "BROWSER_TITLE" => "-",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "CONVERT_CURRENCY" => "N",
                    "DETAIL_URL" => "",
                    "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "ELEMENT_SORT_FIELD" => "timestamp_x",
                    "ELEMENT_SORT_FIELD2" => "id",
                    "ELEMENT_SORT_ORDER" => "desc",
                    "ELEMENT_SORT_ORDER2" => "desc",
                    "FILTER_NAME" => "arrSaleFilter",
                    "HIDE_NOT_AVAILABLE" => "Y",
                    "IBLOCK_ID" => "4",
                    "IBLOCK_TYPE" => "catalog",
                    "INCLUDE_SUBSECTIONS" => "A",
                    "LINE_ELEMENT_COUNT" => "20",
                    "MESSAGE_404" => "",
                    "META_DESCRIPTION" => "-",
                    "META_KEYWORDS" => "-",
                    "OFFERS_CART_PROPERTIES" => array(),
                    "OFFERS_FIELD_CODE" => array("",""),
                    "OFFERS_LIMIT" => "5",
                    "OFFERS_PROPERTY_CODE" => array("RAZMER","TSVET","CML2_ARTICLE","CML2_BASE_UNIT","MORE_PHOTO","MARCET","item_color_list","CML2_MANUFACTURER","SIZE","CML2_TRAITS","CML2_TAXES","FILES","CML2_ATTRIBUTES","COLOR","CML2_BAR_CODE",""),
                    "OFFERS_SORT_FIELD" => "sort",
                    "OFFERS_SORT_FIELD2" => "id",
                    "OFFERS_SORT_ORDER" => "asc",
                    "OFFERS_SORT_ORDER2" => "desc",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_TITLE" => "Товары",
                    "PAGE_ELEMENT_COUNT" => "20",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRICE_CODE" => array("Розничная"),
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRODUCT_PROPERTIES" => array(),
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PRODUCT_QUANTITY_VARIABLE" => "",
                    "PROPERTY_CODE" => array("COLECTION","SOSTAV","CML2_ARTICLE","CML2_BASE_UNIT","DLINA_PO_VNUTRENNEMU_SHVU","DLINA_PO_SPINE","DLINA_RUKAVA","CATALOG","COMPANY_BRAND","MAXIMUM_PRICE","MINIMUM_PRICE","POPULAR","PRICE_LAST","CML2_MANUFACTURER","SALE","CML2_TRAITS","SEZON","CML2_TAXES","ARTICLES","CML2_ATTRIBUTES","PRICE","CML2_BAR_CODE","EXCLUSIVE","UPLOAD","VYGRUZKA_NA_MARKET","KOMPLEKTNOST","KROY","STIL","ALT","TITLE","BREND","DESCRIPTION","DETALI_ODEZHDY","KEYWORDS","NEWS","RASPRODAZHA","SPEC","DEAKTIVIROVAT_POZITSIYU","SWYAZ","PRICE_OLD","SWYAZ2","BEST","NOVINKA","VYSOTA_KABLUKA","STARYE_TSENY","OBKHVAT_GOLENISHCHA","EKSKLYUZIV","VYSOTA_GOLENISHCHA_ZADNIKA","VYSOTA_PLATFORMY","WH_ABC_1","WH_AWERS","WH_ABC_2","WH_STOK_AP","WH_ABC_F","WH_STOK_KOLCO","WH_STOK_6_BK","WH_IM","WH_STOK_FIESTA","WH_STOLNIK5","WH_CHMZ_STOK","AKTSIYA","comments_count","comments_sum","STOK_LENIN","RAZMER_LINK",""),
                    "SECTION_CODE" => "",
                    "SECTION_CODE_PATH" => "",
                    "SECTION_ID" => "",
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "SECTION_URL" => "",
                    "SECTION_USER_FIELDS" => array("",""),
                    "SEF_MODE" => "Y",
                    "SEF_RULE" => "",
                    "SET_BROWSER_TITLE" => "Y",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "Y",
                    "SET_META_KEYWORDS" => "Y",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "Y",
                    "SHOW_404" => "N",
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "SHOW_PRICE_COUNT" => "1",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "USE_PRICE_COUNT" => "N",
                    "USE_PRODUCT_QUANTITY" => "N",
                "FLAG_PROPERTY_CODE" => "RASPRODAZHA",
            )
    );?>

    </section>
</section>
