<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
?>

<?$APPLICATION->IncludeComponent(
    "bitrix:catalog.element",
    "popup_detail",
    array(
        "COMPONENT_TEMPLATE" => ".default",
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => "4",
        //"ELEMENT_ID" => "384810",
        "ELEMENT_ID" => $_REQUEST["ID"],
        "ELEMENT_CODE" => "",
        "SECTION_ID" => $_REQUEST["SECTION_ID"],
        "SECTION_CODE" => "",
        "HIDE_NOT_AVAILABLE" => "N",
        "PROPERTY_CODE" => array(
            0 => "COLECTION",
            1 => "SOSTAV",
            2 => "CML2_ARTICLE",
            3 => "SEZON",
            4 => "STIL",
            5 => "KROY",
            6 => "BREND",
            7 => "DLINA_PO_VNUTRENNEMU_SHVU",
            8 => "DLINA_PO_SPINE",
            9 => "CML2_MANUFACTURER",
            10 => "BRAND",
            11 => "COMPANY_BRAND",
        ),
        "OFFERS_LIMIT" => "0",
        "TEMPLATE_THEME" => "blue",
        "DISPLAY_NAME" => "Y",
        "DETAIL_PICTURE_MODE" => "IMG",
        "ADD_DETAIL_TO_SLIDER" => "N",
        "DISPLAY_PREVIEW_TEXT_MODE" => "E",
        "PRODUCT_SUBSCRIPTION" => "N",
        "SHOW_DISCOUNT_PERCENT" => "N",
        "SHOW_OLD_PRICE" => "N",
        "SHOW_MAX_QUANTITY" => "N",
        "SHOW_CLOSE_POPUP" => "N",
        "MESS_BTN_BUY" => "Купить",
        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
        "MESS_BTN_SUBSCRIBE" => "Подписаться",
        "MESS_NOT_AVAILABLE" => "Нет в наличии",
        "USE_VOTE_RATING" => "N",
        "USE_COMMENTS" => "N",
        "BRAND_USE" => "N",
        "SECTION_URL" => "",
        "DETAIL_URL" => "",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "CHECK_SECTION_ID_VARIABLE" => "N",
        "SEF_MODE" => "N",
        "CACHE_TYPE" => "N",
        "CACHE_TIME" => "36000000",
        "CACHE_GROUPS" => "Y",
        "SET_TITLE" => "Y",
        "SET_CANONICAL_URL" => "N",
        "SET_BROWSER_TITLE" => "Y",
        "BROWSER_TITLE" => "-",
        "SET_META_KEYWORDS" => "Y",
        "META_KEYWORDS" => "-",
        "SET_META_DESCRIPTION" => "Y",
        "META_DESCRIPTION" => "-",
        "SET_LAST_MODIFIED" => "N",
        "USE_MAIN_ELEMENT_SECTION" => "N",
        "ADD_SECTIONS_CHAIN" => "Y",
        "ADD_ELEMENT_CHAIN" => "N",
        "USE_ELEMENT_COUNTER" => "Y",
        "SHOW_DEACTIVATED" => "N",
        "ACTION_VARIABLE" => "action",
        "PRODUCT_ID_VARIABLE" => "id",
        "DISPLAY_COMPARE" => "N",
        "PRICE_CODE" => array(
            0 => "Розничная",
            1 => "Розничная Сток(Интернет)",
        ),
        "USE_PRICE_COUNT" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "PRICE_VAT_INCLUDE" => "Y",
        "PRICE_VAT_SHOW_VALUE" => "N",
        "CONVERT_CURRENCY" => "N",
        "BASKET_URL" => "/personal/basket.php",
        "USE_PRODUCT_QUANTITY" => "N",
        "PRODUCT_QUANTITY_VARIABLE" => "",
        "ADD_PROPERTIES_TO_BASKET" => "Y",
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PARTIAL_PRODUCT_PROPERTIES" => "N",
        "PRODUCT_PROPERTIES" => array(
        ),
        "ADD_TO_BASKET_ACTION" => array(
            0 => "BUY",
        ),
        "LINK_IBLOCK_TYPE" => "catalog",
        "LINK_IBLOCK_ID" => "5",
        "LINK_PROPERTY_SID" => "CML2_LINK",
        "LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
        "SET_STATUS_404" => "N",
        "SHOW_404" => "N",
        "MESSAGE_404" => "",
        "ADD_PICT_PROP" => "MORE_PHOTO",
        "LABEL_PROP" => "-",
        "MESS_BTN_COMPARE" => "Сравнить",
        "OFFERS_FIELD_CODE" => array(
            0 => "",
            1 => "",
        ),
        "OFFERS_PROPERTY_CODE" => array(
            0 => "item_color_list",
            1 => "SIZE",
            2 => "",
        ),
        "OFFERS_SORT_FIELD" => "sort",
        "OFFERS_SORT_ORDER" => "asc",
        "OFFERS_SORT_FIELD2" => "id",
        "OFFERS_SORT_ORDER2" => "desc",
        "OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
        "OFFER_TREE_PROPS" => array(
            0 => "-",
        ),
        "OFFERS_CART_PROPERTIES" => array(
        )
    ),
    false
);?>

<?/*?><script src="/bitrix/templates/stolnik_gray/js/main.js" charset="windows-1251"></script><?*/?>
<script>
    (function() {
        var el = $('.b-img-gallery');
        if (el.length > 0) {
            el.carouFredSel({
                items: 1,
                auto: false,
                scroll: {
                    items: 1,
                    fx: 'crossfade',
                    duration: 1000,
                    pauseOnHover: true
                },
                pagination: {
                    container: '.js-pager',
                    event: 'mouseover',
                    duration: 0,
                    anchorBuilder: function (nr) {
                        var src = $('.js-img-gallery a').find('img').eq(nr - 1).attr('src');
                        var url_full = $('.js-img-gallery a').eq(nr - 1).attr('href');
                        return '<a class="js-fancy" rel="gallery1" href="' + url_full + '"><img width="40"  src="' + src + '" border="0" /></a>';
                    }
                },
                onCreate: function(a) {
                    var pagerBlock = $('.b-img-pager');
                    var pager = pagerBlock.find('.js-pager');
                    var prev = pagerBlock.find('.prev');
                    var next = pagerBlock.find('.next');
                    prev.on('click', function() {
                        var length = pager.find('a').length;
                        var pos = pager.data('pos');
                        if (typeof pos === 'undefined') {
                            pos = 0;
                        }
                        if (pos < Math.ceil(length / 5) - 1) {
                            pos += 1;
                            next.removeClass('disabled');
                        }
                        if (pos >= Math.ceil(length / 5) - 1) {
                            prev.addClass('disabled');
                        }
                        pager.data('pos', pos);
                        pager.animate({'margin-top':  '-' + pos * 370 + 'px'});
                        return false;
                    });
                    next.on('click', function() {
                        var length = pager.find('a').length;
                        var pos = pager.data('pos');
                        if (typeof pos === 'undefined') {
                            pos = 0;
                        }
                        if (pos > 0) {
                            pos -= 1;
                            prev.removeClass('disabled');
                        }
                        if (pos <= 0) {
                            next.addClass('disabled');
                        }
                        pager.data('pos', pos);
                        pager.animate({'margin-top':  '-' + pos * 370 + 'px'});
                        return false;
                    });
                }
            });
        }
    })();

    (function() {
        $('.b-product-card__info .button-buy').on('click', function() {

            $(this).css('background', 'green');
            $(this).text('Перейти в корзину');
            $(this).attr('href', '/personal/order/make/');
            if (!$(this).hasClass('in_basket')){
                stolnik.AddToBasket(parseInt($(this).closest('.item').data('offer-id'), 10));
                $(this).addClass('in_basket');
                return false;
            }
        });
    })();

    (function() {
        var GetItemSizes = function(el) {
            var data = el.data('sizes_calculated');
            var i, val;
            if (typeof data === 'undefined') {
                data = el.data('sizes').split(';');
                for (i = 0; i < data.length; i++) {
                    val = data[i];
                    val = val.split(':');
                    data[i] = {
                        size: val[0],
                        quantity: parseInt(val[1], 10),
                        price: parseFloat(val[2]),
                        id: parseInt(val[3], 10),
                    };
                }
                el.data('sizes_calculated', data);
            }
            return data;
        };

        var ShowStores = function (offerId) {
            var tr = $('#stores-block').find('.stores tr')
            tr.removeClass('active');
            tr.filter('[data-offer_id="' + offerId + '"]').addClass('active');
        }

        $('.size-line .item').on('click', function () {
            if (!$(this).hasClass('empty')) {
                $('.size-line .item').removeClass('active');
                $(this).addClass('active');

                var currentSize = $(this).text().trim();
                var activeFound = false;
                $(this).closest('.b-product-card__info').find('.color-line .item').removeClass('disabled').removeClass('active').each(function() {
                    var data = GetItemSizes($(this));
                    var i, val;

                    for (i = 0; i < data.length; i++) {
                        val = data[i];
                        if (val.size == currentSize) {
                            if (val.quantity <= 0) {
                                $(this).addClass('disabled');
                            } else if (!activeFound) {
                                activeFound = true;
                                $(this).trigger('click');
                            }
                            break;
                        }
                    }
                });


                var buy_basket = $('.b-product-card__info .button-buy');

                buy_basket.css('background', '#ff9b00');
                buy_basket.text('Добавить в корзину');
                buy_basket.attr('href', '#added-to-basket');
                buy_basket.removeClass('in_basket');


            }
        });
        $('.color-line .item').on('click', function () {
            if (!$(this).hasClass('empty') && !$(this).hasClass('disabled')) {
                $('.color-line .item').removeClass('active');
                $(this).addClass('active');

                var data = GetItemSizes($(this));
                var currentSize = $(this).closest('.b-product-card__info').find('.size-line .active').text();
                var i, val;

                for (i = 0; i < data.length; i++) {
                    val = data[i];
                    if (val.size == currentSize && val.quantity > 0) {
                        var item = $(this).closest('.color-line').closest('.item');
                        item.find('.b-product-card__info .cost .value').text(FormatPrice(val.price));
                        item.data('offer-id', val.id);

                        ShowStores(val.id);

                        break;
                    }
                }

                var buy_basket = $('.b-product-card__info .button-buy');

                buy_basket.css('background', '#ff9b00');
                buy_basket.text('Добавить в корзину');
                buy_basket.attr('href', '#added-to-basket');
                buy_basket.removeClass('in_basket');
            }
        });

        $('.color-line .item.active').trigger('click');
    })();
</script>

