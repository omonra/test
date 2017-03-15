<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
foreach($arResult["ITEMS"]["DelDelCanBuy"] as $key=>$item){
  if ($arResult["PROD"][$item["PRODUCT_ID"]])
    $arResult["ITEMS"]["DelDelCanBuy"][$key]["PICTURE_ID"] = $arResult["PROD"][$item["PRODUCT_ID"]];
}
?>
<?if(count($arResult["ITEMS"]["DelDelCanBuy"]) > 0):?>
<div class="deferred_products " style="margin-bottom: 75px;">
    <h4>���������� ������</h4>

    <div class="order_items basket_items">
        <table>
            <thead>
            <tr>
                <th class="foto">�������<!--����--></th>
                <th class="name"><!--������������--></th>
                <th class="price">����</th>
                <th class="count">����������</th>
                <th class="defer">��������</th>
                <th class="del"><!--�������--></th>
            </tr>
            </thead>
            <tbody>
                <?foreach($arResult["ITEMS"]["DelDelCanBuy"] as $arBasketItems):?>
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
                <td class="defer"><input class="checkbox" type="checkbox" name="DELAY_<?=$arBasketItems["ID"] ?>"  checked="checked" value="Y"></td>
                <td class="del"><input class="checkbox" type="checkbox" name="DELETE_<?=$arBasketItems["ID"] ?>" value="Y"></td>
            </tr>
                <?endforeach;?>
            </tbody>
        </table>
    </div>

    <input class="button button_1 button_1_1 update" type="hidden" value="Y" name="BasketRefresh">

</div>

<?endif;?>

<?
