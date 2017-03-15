

<div  class="b-product-card g-clear item" data-id="<?=$arResult['ID']?>" data-offer-id="<?=$arResult['OFFER_ID']?>">
	<div class="b-product-card__info g-clear">
		<a class="title" href="<?=$arResult['DETAIL_PAGE_URL']?>"><?=$arResult['NAME']?></a>
		<div class="product-code"><?if (strlen($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']) > 0):?>Артикул: <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?>   |   <?endif;?><a href="<?=$arResult['SECTION']['SECTION_PAGE_URL']?>" title="<?=$arResult['SECTION']['NAME']?>"><?=$arResult['SECTION']['NAME']?></a></div>
		<div class="description">
			<div class="cost">
				<? if (!empty($arResult['PRICE']['OLD'])): ?>
                                <div class="cost">
                                    <strike><?=$arResult['PRICE']['OLD']['PRINT_VALUE']?></strike>
                                    <i class="value"><?=$arResult['PRICE']['PRINT_VALUE']?></i>
                                    <? if (!empty($arResult['PRICE']['DISCOUNT_DIFF_PERCENT'])): ?>
                                    <div class="discountPlace"><?=$arResult['PRICE']['DISCOUNT_DIFF_PERCENT']?>%</div>
                                    <? endif; ?>
                                </div>
                                <? else: ?>
                                <strong class="value"><?=$arResult['PRICE']['PRINT_VALUE']?></strong>
                                <? endif; ?>
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
		<div class="additional">
            <span class="stars">
                <?for ($i = round(intval($arResult['PROPERTIES']['comments_sum']['VALUE']) / intval($arResult['PROPERTIES']['comments_count']['VALUE'])); $i > 0; $i--):?>
					<i></i>
				<?endfor;?>
            </span>
			<span class="reviews">(<?=intval($arResult['PROPERTIES']['comments_count']['VALUE'])?>)</span>

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
					<a href="<?=$arResult['BIG_PICTURE'][$key]['SRC']?>" rel="gal" class="js-fancy">
						<img src="<?=$arPicture['SRC']?>" alt="<?=$arResult['NAME']?>" />
						<span class="zoomin">Увеличить</span>
					</a>
				</li>
			<?endforeach;?>
		</ul>
	</div>
	<div class="b-product-card__about">
		

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
			<a href="<?=$arResult['DETAIL_PAGE_URL']?>" style="color: #000; font-size: 15px;" >Более подробная информация >>></a>
		</div>
	</div>
</div>
<?
if (file_exists(__DIR__ . "/script.js"))
{
    $js = file_get_contents(__DIR__ . "/script.js");
    ?>
    <script><?=$js?> ImgGallery($('.b-img-gallery'));</script>
    <?
}

?>