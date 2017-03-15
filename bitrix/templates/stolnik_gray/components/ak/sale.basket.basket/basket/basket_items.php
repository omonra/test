<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
foreach($arResult["ITEMS"]["AnDelCanBuy"] as $key=>$item){
  if ($arResult["PROD"][$item["PRODUCT_ID"]])
    $arResult["ITEMS"]["AnDelCanBuy"][$key]["PICTURE_ID"] = $arResult["PROD"][$item["PRODUCT_ID"]];
}
?>
<div class="order_items basket_items" xmlns="http://www.w3.org/1999/html">
    <?if(count($arResult["ITEMS"]["AnDelCanBuy"]) > 0):?>
    <table>
        <thead>
        <tr>
            <th class="foto">Покупка</th>
            <th class="name"><!--Наименование--></th>
            <th class="price">Цена</th>
            <th class="count">Количество</th>
            <?/*<th class="act">Акция</th>*/?>
            <th class="defer">Отложить</th>
            <th class="del"><!--Удалить--></th>
        </tr>
        </thead>
        <tbody>
            <?foreach($arResult["ITEMS"]["AnDelCanBuy"] as $arBasketItems):?>
        <tr>
            <td class="foto"><img src="<?=$arResult["PICTURES"][$arBasketItems["PICTURE_ID"]]?>" alt="<?=$arBasketItems["NAME"]?>" title="<?=$arBasketItems["NAME"]?>"/></td>
            <td class="name"><?
                if (strlen($arBasketItems["DETAIL_PAGE_URL"])>0):
                    ?><a href="<?=$arBasketItems["DETAIL_PAGE_URL"] ?>"><?
                endif;
                ?><?=$arBasketItems["NAME"]?><?
                if (strlen($arBasketItems["DETAIL_PAGE_URL"])>0):
                    ?></a><?
                endif;
                ?></td>
            <td class="price"><?=$arBasketItems["PRICE_FORMATED"]?></td>
            <td class="count"><input class="text_input text_input_3" type="text" name="QUANTITY_<?=$arBasketItems["ID"] ?>" value="<?=$arBasketItems["QUANTITY"]?>"></td>
            <?/*<td><?=$arBasketItems["PROPS"][0]["NAME"]?> <?=$arBasketItems["PROPS"][0]["VALUE"]?></td>*/?>
            <td class="defer"><input class="checkbox" name="DELAY_<?=$arBasketItems["ID"] ?>" value="Y" type="checkbox"></td>
            <td class="del"><input class="checkbox" name="DELETE_<?=$arBasketItems["ID"] ?>" value="Y" type="checkbox"></td>
        </tr>
            <?endforeach;?>
        </tbody>
    </table>
    <?else:?>
    <?echo ShowNote(GetMessage("SALE_NO_ACTIVE_PRD"));?>
    <?endif;?>
</div>

<div class="ordering_options">

	<div class ="ordering_options_left">
		<p class="info">Минимальной суммы заказа - нет. </p>
		<p class="info">Обработка заказов 1-7 рабочих дней. </p>
		<p class="info">При заказе товара на сумму свыше 5000 руб доставка по России бесплатно. </p>
		<? $disc=0;
		foreach($arResult["ITEMS"]["AnDelCanBuy"] as $arBasketItems){
			if(!empty($arBasketItems["PROPS"])){
				$disc++;
			}
			
		}
		if($disc==0):?>
			<!--<p class="info">Скидка 5% за полную предоплату заказа. </p> -->
		 <?endif?>
	</div>
	
	<div class ="ordering_options_right">
        <?if($arResult['DISCOUNT_PERCENT_FORMATED'] > 0){?>
            <?//echo "<pre>";print_r($arResult);echo "</pre>";?>
            <?echo "<p class='disc_val'>Скидка: ".$arResult['DISCOUNT_PRICE_FORMATED']."  (".$arResult['DISCOUNT_PERCENT_FORMATED'].")</p>";?>
        <?}?>


		<dl class="summ"><dt>Итого:</dt><dd><span class="val"><?=substr($arResult["allSum_FORMATED"],0,-4)?></span> руб.</dd></dl>

		<input class="button button_1 submit" type="submit" value="Оформить заказ" name="BasketOrder"  id="basketOrderButton2">
		<input class="button button_1 update" type="hidden" value="Y" name="BasketRefresh">
		<a id="basketClearButton2" href="#clearBasketModal" class="button button_1 gray submit">Очистить корзину</a>
		<div style="clear:both"></div>
	</div>
<div style="clear:both"></div>
  

    <br />

   <?
   /*	global $USER;
if ($USER->IsAdmin()) echo "<pre>"; print_r($arResult); echo "</pre>";*/
   ?> 

</div>
<?