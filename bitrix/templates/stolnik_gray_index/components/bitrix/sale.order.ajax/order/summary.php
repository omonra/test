<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="ordering_section ordering_section_items">
    <div class="items">
        <h2>Состав заказа</h2>

        <div class="order_items">
            <table>
                <?foreach($arResult["BASKET_ITEMS"] as $arBasketItems):?>
                <tr>
                    <td class="name"><?=$arBasketItems["NAME"]?></td>
                    <td class="count"><input class="text_input text_input_2" type="text" value="<?=$arBasketItems["QUANTITY"]?>"></td>
                    <td class="price"><?=$arBasketItems["PRICE_FORMATED"]?></td>
                </tr>
                <?endforeach;?>
            </table>
        </div>

    </div>

    <div class="coments">
        <h2>Дополнительныйе комментарии к заказу</h2>
        <textarea rows="6" cols="50" name="ORDER_DESCRIPTION"><?=$arResult["USER_VALS"]["ORDER_DESCRIPTION"]?></textarea>
    </div>
</div>
