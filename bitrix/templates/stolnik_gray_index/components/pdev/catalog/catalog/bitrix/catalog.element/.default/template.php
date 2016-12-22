<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="b-product-card g-clear item" data-id="<?=$arResult['ID']?>" data-offer-id="<?=$arResult['OFFER_ID']?>">
    <div class="b-product-card__info g-clear">
        <h1 class="title"><?=$arResult['NAME']?></h1>
        <div class="product-code"><?if (strlen($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']) > 0):?>Артикул: <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?>   |   <?endif;?><a href="<?=$arResult['SECTION']['SECTION_PAGE_URL']?>" title="<?=$arResult['SECTION']['NAME']?>"><?=$arResult['SECTION']['NAME']?></a></div>
        <div class="description">
            <div class="cost">
                <strong class="value"><?=FormatPrice($arResult['PRICE'], $arResult['CURRENCY'])?></strong>
                <?/*?>
                <div style="float: right; margin-right: 215px; position: relative; top: -10px;">
                    <img src="/images/30_percent.png" style="width: 90px;" />
                </div>
                <?*/?>
            </div>
            <?/*?><div class="cost"><strike>#1099 руб.</strike>  <i class="value">599 руб.</i></div><?//*/?>
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
                        $disabled = strlen($arResult['CURRENT_SIZE']) > 0 && $arResult['SIZE_TO_COLORS'][$arResult['CURRENT_SIZE']][ToUpper($val['NAME'])]['QUANTITY'] <= 0;
                        if (!$activeFound && $arResult['SIZE_TO_COLORS'][$arResult['CURRENT_SIZE']][ToUpper($val['NAME'])]['QUANTITY'] > 0) {
                            $activeFound = true;
                            $active = true;
                        } else {
                            $active = false;
                        }
                        ?>
                        <div class="item<?=($disabled ? ' disabled' : '') . ($active ? ' active' : '')?>" style="background-image: url(<?=$val['PICTURE']['SRC']?>);" title="<?=$val['NAME']?>" data-sizes="<?=implode(';', array_map(function($a) {
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
        </div>
    </div>
</div>

<section class="hidden">
    <div id="added-to-basket">
        <div class="b-fancy-added">
            <div class="title">Товар успешно добавлен в корзину</div>
            <div class="g-clear b-btn-group">
                <a title="продолжить" class="b-btn close" href="">Продолжить</a>
                <a title="в корзину" class="b-btn" href="/personal/order/make/">В корзину</a>
            </div>
        </div>
    </div>
</section>
