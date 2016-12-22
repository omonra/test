<section class="b-wrapper">
    <section class="b-container" style="margin-top: 30px;">

        <?
        $GLOBALS['arrNewProductsFilter']['PROPERTY_NOVINKA'] = 'true';
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
        global $arrSaleFilter;
        $arrSaleFilter['PROPERTY_RASPRODAZHA'] = 'true';
        //$arrNewProductsFilter['!PROPERTY_NOVINKA'] = 'true';
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
                "ELEMENT_SORT_FIELD" => "timestamp_x",
                "ELEMENT_SORT_ORDER" => "desc",
                "ELEMENT_COUNT" => "20",
                "LINE_ELEMENT_COUNT" => "4",
                "PROPERTY_CODE" => array(
                    0 => "",
                    1 => "",
                ),
                "FLAG_PROPERTY_CODE" => "RASPRODAZHA",
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
                "FILTER_NAME" => "arrSaleFilter",
                "CACHE_FILTER" => "Y",
                "COMPONENT_TEMPLATE" => ".default"
            ),
            false
        );?>

    </section>
</section>
