<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<?if(empty($arResult["DELIVERY"])) return;?>

<li>
    <label for="delivery_type">Способ доставки</label>
    <select name="DELIVERY_ID" id="delivery_type">
        <?foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery):
            if ($delivery_id !== 0 && intval($delivery_id) <= 0):
                foreach ($arDelivery["PROFILES"] as $profile_id => $arProfile):?>
                    <option value="<?=$delivery_id . ':' . $profile_id?>"<?=($arProfile["CHECKED"] == "Y" ? ' selected="selected"' : '')?>><?if($arProfile["NAME"]): echo $arProfile["NAME"]; else: echo $arProfile["TITLE"];endif;?></option>
                <?endforeach;?>
            <?else:?>
                <option value="<?=$arDelivery['ID']?>"<?=($arDelivery["CHECKED"] == "Y" ? ' selected="selected"' : '')?>><?=$arDelivery['NAME']?></option>
            <?endif;?>
        <?endforeach;?>
    </select>
</li>
