<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?>

<? if (!$arResult['NEW_DESIGN']): ?>
<script>
    $(document).ready(function(){
        $(".color-line .item").on("click", function(){
            var offersID = $(this).data("offers-id");
            var offersSize = $(this).data("offers-size");
            QuantityDayDelivery(offersID, offersSize);
        });
        QuantityDayDelivery();
    });

    function QuantityDayDelivery(offersID, offersSize)
    {
        var xmlID = '<?=$arResult["XML_ID"]?>';
        var selectSize = "";
        var selectColor = "";
        $(".size-line .item").each(function(){
            if($(this).hasClass("active"))
                selectSize = $(this).text();
        });
        $(".color-line .item").each(function(){
            if($(this).hasClass("active"))
                selectColor = $(this).attr("title");
        });
        $.ajax({
            url: "/ajax/QuantityDayDelivery.php?getInfo=y&xmlID="+xmlID+"&offersID="+offersID+"&offersSize="+offersSize+"&selectSize="+selectSize+"&selectColor="+selectColor,
            dataType: "html",
            success: function(res)
            {
                $(".offersInfo").html(res);
            }
        });
    }
</script>
<? endif; ?>

<?$arColorSize = array();
foreach($arResult['SIZE_TO_COLORS'] as $size => $oneSize){
    foreach($oneSize as $color => $oneColor)
    {
        $arColorSize[$color]["ID"][] = $oneColor["ID"];
        $arColorSize[$color]["SIZE"][] = $size;
    }
}?>

<div class="b-product-card g-clear item" data-id="<?=$arResult['ID']?>" data-offer-id="<?=$arResult['OFFER_ID']?>">
    <div class="b-product-card__info g-clear">
        <h1 class="title"><?=$arResult['NAME']?></h1>
        <div class="product-code"><?if (strlen($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']) > 0):?>Артикул: <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?>   |   <?endif;?><a href="<?=$arResult['SECTION']['SECTION_PAGE_URL']?>" title="<?=$arResult['SECTION']['NAME']?>"><?=$arResult['SECTION']['NAME']?></a></div>
        
        <? if ($arResult['NEW_DESIGN']): ?>
        <div id="ajax-offers">
        
           
            <? if ($_REQUEST['is_ajax'] == "y") $APPLICATION->RestartBuffer(); ?>
        <script>
        var offersList = <?=CUtil::PhpToJSObject($arResult['OFFERS_LIST'])?>,
            currentColor = '<?=$arResult['COLOR_SELECTED']?>',
            currentSize = '<?=$arResult['SIZE_SELECTED']?>',
            currentOffer = '<?=$arResult['OFFER_SELECTED']?>';
    
        function getColorItems(obj) {
            obj = (obj) || [];
            var tpl = $('<div data-type="color" class="item"></div>'), html = $("<div></dvi>"), counter = 0;
            $.each(obj, function (index, value) {
                var row = tpl.clone();
                row.css('background-image', 'url('+value['COLOR_PICTURE']+')');
                row.attr({
                    'data-value': value['COLOR'],
                    'title': value['COLOR'],
                });

                if (obj[currentColor] == undefined && counter == 0) {
                    row.addClass('active');
                    currentColor = value['COLOR'];
                }
                
                if (currentColor == value['COLOR']) {
                    row.addClass('active');
                }

                html.append(row);
                
                counter++;
            });

            return html.html();
        }
        
        $("body").on('click', '.sizes .item, .colors .item', function () {
            $(this).parent().find(">div").removeClass('active');
            $(this).addClass('active');
            if ($(this).data('type') == "size")
                currentSize = $(this).data('value');
            
            if ($(this).data('type') == "color")
                currentColor = $(this).data('value');
            
            $(".colors").html(getColorItems(offersList['SIZE'][currentSize]));
            
            var offer = offersList['SIZE'][currentSize][currentColor];
            if (offer !== undefined) {
                currentOffer = offer['ID'];
                $(".offer-qty").text(offer['QTY']);
            }
            
            $("a.btn-buy").removeClass('in_basket').text('Добавить в корзину');
            
            
            console.log(currentOffer);
        });
        
        (function() {
            $("body").on('click', 'a.btn-buy', function (event) {
                
                
                $(this).text('Перейти в корзину');
                $(this).attr('href', '/personal/cart/');
                if (!$(this).hasClass('in_basket')) {
                    event.preventDefault();
                    stolnik.AddToBasket(currentOffer);
                    $(this).addClass('in_basket');
                    return false;
                }
                
            });
        })();
        
        </script>
        <div class="description">
            <div class="realCount">
                <b>Количество на складе:</b>
                <? if (!empty($arResult["OFFER_QTY"])): ?>
                <span class="offer-qty"><?=$arResult["OFFER_QTY"]?></span> шт.
                <? else: ?>
                <span class="offer-qty">нет в наличии</span>
                <? endif; ?>
            </div>
            <div class="cost">
                <?if($arResult["PROPERTY_119"] > $arResult['PRICE']){?>
                    <div class="cost">
                        
                        <strike><?=floor($arResult["PROPERTY_119"])?> руб.</strike>
                        <i class="value"><?=FormatPrice($arResult['PRICE'], $arResult['CURRENCY'])?></i>
                        <div class="discountPlace">
                            -<?=round(($arResult["PROPERTY_119"]-$arResult['PRICE'])/$arResult["PROPERTY_119"]*100)?>%
                        </div>
                        
                    </div>
                <?}else{?>
                    <? if (floatval($arResult['PRICE']) > 0): ?>
                        <strong class="value"><?=FormatPrice($arResult['PRICE'], $arResult['CURRENCY'])?></strong>
                    <? else: ?>
                        <i class="value">Нет в наличии</i>
                    <? endif; ?>
                <?}?>
                
            </div>
            <? if (count($arResult['OFFERS_LIST']['SIZE']) > 0): ?>
            Выберите размер
            <div class="sizes g-clear">
                <?foreach ($arResult['OFFERS_LIST']['SIZE'] as $key => $val):?>
                        <div data-type="size" data-value="<?=$key?>" class="item <?=($arResult['SIZE_SELECTED'] == $key) ? "active" : ""?>"><?=$key?></div>
                <?endforeach;?>
            </div>
            <?foreach($arResult["ARTICLES_LINK"] as $item):?>
                <a href="#" class="link size-ruler" data-code="<?=$item['CODE']?>"><?=$item["NAME"]?></a>
            <?endforeach;?>
            
                <div id="size-ruler-base" class="size-popup" style="display:none;">
                    <div class="close"></div>
                    <div id="size-ruler-base-in"></div>
                </div>
                <script>
                    $(document).ready(function() {
                        $('.size-ruler').on('click', function() {
                            $('#size-ruler-base-in').load('/articles/' + $(this).data('code') + '/ .news-detail');
                            $('#size-ruler-base').show();
                            return false;
                        });
                        $('#size-ruler-base .close').on('click', function() {
                            $('#size-ruler-base').hide();
                            return false;
                        });
                    });
                </script>
                
            <div class="clearall"></div>
            
            <div class="colors g-clear">
                <?foreach ($arResult['OFFERS_LIST']['SIZE'][$arResult['SIZE_SELECTED']] as $key => $val):?>
                        <div data-type="color" data-value="<?=$val['COLOR']?>" style="background-image: url(<?=$val['COLOR_PICTURE']?>);" title="<?=$val['COLOR']?>" class="item <?=($arResult['COLOR_SELECTED'] == $val['COLOR']) ? "active" : ""?>"></div>
                <?endforeach;?>
            </div>
            
            <div class="clearall"></div>
            <a href="#added-to-basket" class="b-btn btn-buy">Добавить в корзину</a>
            
            <div class="clearall"></div>
            
            <? endif; ?>
                
        </div>
            <? if ($_REQUEST['is_ajax'] == "y") exit(); ?>
        </div>
        
        
        <div class="b-social" style="margin:0;">
                    <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script><div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="link" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir"></div>
            </div>
        <? else: ?>
        <div class="description">
            <div class="realCount">
                <b>Количество на складе:</b> <?=$arResult["REAL_COUNT"]?>
                <div class="offersInfo"></div>
            </div>
            <div class="cost">
                <?if($arResult["PROPERTY_119"] > $arResult['PRICE']){?>
                    <div class="cost"><strike><?=floor($arResult["PROPERTY_119"])?> руб.</strike>
                        <i class="value"><?=FormatPrice($arResult['PRICE'], $arResult['CURRENCY'])?></i>
                        <div class="discountPlace">
                            -<?=round(($arResult["PROPERTY_119"]-$arResult['PRICE'])/$arResult["PROPERTY_119"]*100)?>%
                        </div>
                    </div>
                <?}else{?>
                    <strong class="value"><?=FormatPrice($arResult['PRICE'], $arResult['CURRENCY'])?></strong>
                <?}?>
                <?/*?>
                <div style="float: right; margin-right: 215px; position: relative; top: -10px;">
                    <img src="/images/30_percent.png" style="width: 90px;" />
                </div>
                <?*/?>
            </div>
            <?
            if (is_array($arResult['SIZES']) && count($arResult['SIZES']) > 0):?>
                Выберите размер
                <div class="size-line g-clear">
                    <?foreach ($arResult['SIZES'] as $key => $val):?>
                        <div class="item<?=($val == $arResult['CURRENT_SIZE'] ? ' active' : '')?><?=($arResult['SIZE_TO_QUANTITY'][$val] <= 0 ? ' empty' : '')?>"><?=$val?></div>
                    <?endforeach;?>
                </div>
                <?foreach($arResult["ARTICLES_LINK"] as $item):?>
                    <a href="#" class="link size-ruler" data-code="<?=$item['CODE']?>"><?=$item["NAME"]?></a>
                <?endforeach;?>

                <div id="size-ruler-base" class="size-popup" style="display:none;">
                    <div class="close"></div>
                    <div id="size-ruler-base-in"></div>
                </div>
                <script>
                    $(document).ready(function() {
                        $('.size-ruler').on('click', function() {
                            $('#size-ruler-base-in').load('/articles/' + $(this).data('code') + '/ .news-detail');
                            $('#size-ruler-base').show();
                            return false;
                        });
                        $('#size-ruler-base .close').on('click', function() {
                            $('#size-ruler-base').hide();
                            return false;
                        });
                    });
                </script>
            <?endif;?>
                
            <?if (is_array($arResult['COLORS']) && count($arResult['COLORS']) > 0):?>
                <div class="clearall"></div>
                Доступные цвета
                <div class="color-line g-clear">
                    <?
                    $activeFound = false;
                    foreach ($arResult['COLORS'] as $key => $val):

                        $offersIDByColor = implode(",", $arColorSize[ToUpper($val['NAME'])]["ID"]);
                        $offersSizeByColor = implode(",", $arColorSize[ToUpper($val['NAME'])]["SIZE"]);

                        $disabled = strlen($arResult['CURRENT_SIZE']) > 0 && $arResult['SIZE_TO_COLORS'][$arResult['CURRENT_SIZE']][ToUpper($val['NAME'])]['QUANTITY'] <= 0;
                        if (!$activeFound && $arResult['SIZE_TO_COLORS'][$arResult['CURRENT_SIZE']][ToUpper($val['NAME'])]['QUANTITY'] > 0) {
                            $activeFound = true;
                            $active = true;
                        } else {
                            $active = false;
                        }
                        ?>
                        <div data-offers-id="<?=$offersIDByColor?>" data-offers-size="<?=$offersSizeByColor?>" class="item<?=($disabled ? ' disabled' : '') . ($active ? ' active' : '')?>" style="background-image: url(<?=$val['PICTURE']['SRC']?>);" title="<?=$val['NAME']?>" data-sizes="<?=implode(';', array_map(function($a) {
                                return $a['SIZE'] . ':' . $a['QUANTITY'] . ':' . $a['PRICE'] . ':' . $a['ID'];
                            }, $val['SIZES']))?>"></div>
                    <?endforeach;?>
                </div>
                <p>Цвета зачеркнутые красной линией отсутствуют в продаже</p>
            <?endif;?>
            <div class="clearall"></div>
            <a href="#added-to-basket" class="b-btn button-buy">Купить</a>
            <div class="b-social">
                <?if (!IsDev()):?>
                    <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script><div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="link" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir"></div>
                <?else:?>
                    Поделиться:<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir"></div>
                <?endif;?>

            </div>
            <div class="clearall"></div>
        </div>
        <? endif; ?>
        <div class="additional">
            <span class="stars">
                <?for ($i = round(intval($arResult['PROPERTIES']['comments_sum']['VALUE']) / intval($arResult['PROPERTIES']['comments_count']['VALUE'])); $i > 0; $i--):?>
                    <i></i>
                <?endfor;?>
            </span>
            <span class="reviews">(<?=intval($arResult['PROPERTIES']['comments_count']['VALUE'])?>)</span>

            <a href="#reviews_form" title="Посмотреть или оставить отзывы">Посмотреть или оставить отзывы</a>
            <img src="<?=SITE_TEMPLATE_PATH?>/img/delivery.jpg"/>
            <a href="<?=SITE_DIR?>articles/dostavka/" title="Бесплатная и быстрая доставка" target="_blank">Бесплатная и быстрая доставка</a>
            <img src="<?=SITE_TEMPLATE_PATH?>/img/100.jpg"/>
            <a href="<?=SITE_DIR?>articles/garantiya/" title="Бесплатная и быстрая доставка" target="_blank">Гарантия высокого качества</a>

        </div>
    </div>
    <div class="b-product-card__img">
        <div class="b-img-pager">
            <?if (count($arResult['PICTURE']) > 5):?>
                <a href="#" class="prev"></a>
                <a href="#" class="next disabled"></a>
            <?endif;?>
            <div class="pager_container">
                <div class="js-pager"></div>
            </div>
        </div>
        <ul class="b-img-gallery js-img-gallery">
            <?foreach ($arResult['PICTURE'] as $key => $arPicture):?>
                <li class="b-img-gallery__item">
                    <a href="<?=$arResult['BIG_PICTURE'][$key]['SRC']?>" rel="gal" class="js-fancy"><img src="<?=$arPicture['SRC']?>" alt="<?=$arResult['NAME']?>" /><span class="zoomin">Увеличить</span></a>
                </li>
            <?endforeach;?>
        </ul>
    </div>
    <div class="b-product-card__about">
        <?if (is_array($arResult['RECOMMENDED_PRODUCTS_IDS']) && count($arResult['RECOMMENDED_PRODUCTS_IDS']) > 0):?>
            <?
            $GLOBALS['arrRecommendedProductsFilter']['ID'] = $arResult['RECOMMENDED_PRODUCTS_IDS'];
            ?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "recommended_products",
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
                    "FILTER_NAME" => "arrRecommendedProductsFilter",
                    "CACHE_TYPE" => "N",
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
                    "OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
                    "OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
                    "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                    "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                    "OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],

                    "SECTION_ID" => "0",
                    "SECTION_CODE" => "",
                    // "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                    // "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
                    "COUNT_ELEMENTS" => "N",
                    "ADD_SECTIONS_CHAIN" => "N"
                ),
                $this->__component
            );?>
        <?endif;?>

        <div class="b-product-card__text">
            <div class="b-title">
                ОПИСАНИЕ И ХАРАКТЕРИСТИКИ
            </div>
            <?if (strlen($arResult['DETAIL_TEXT']) > 0):?>
                <?if ($arResult['DETAIL_TEXT_TYPE'] == 'text'):?>
                    <p><?=$arResult['DETAIL_TEXT']?></p>
                <?else:?>
                    <?=$arResult['DETAIL_TEXT']?>
                <?endif;?>
            <?endif;?>
            <?if (is_array($arResult['DISPLAY_PROPERTIES']) && count($arResult['DISPLAY_PROPERTIES']) > 0):?>
                <table>
                    <?foreach ($arResult['DISPLAY_PROPERTIES'] as $key => $arProp):?>
                        <tr>
                            <td><?=$arProp['NAME']?></td>
                            <td><?=(is_array($arProp['VALUE']) ? implode(', ', $arProp['VALUE']) : $arProp['VALUE'])?></td>
                        </tr>
                    <?endforeach;?>
                </table>
            <?endif;?>
			<!---a href="#added-to-basket" class="b-btn button-buy double" style="background: rgb(255, 155, 0);">Добавить в корзину</a>
        </div>
    </div>
</div>

<section class="hidden">
    <div id="added-to-basket">
        <div class="b-fancy-added">
            <div class="title">Товар успешно добавлен в корзину</div>
            <div class="g-clear b-btn-group">
                <a title="продолжить" class="b-btn close" href="">Продолжить</a>
                <a title="в корзину" class="b-btn" href="/personal/order/make/">В корзину</a-->
            </div>
        </div>
    </div>
</section>