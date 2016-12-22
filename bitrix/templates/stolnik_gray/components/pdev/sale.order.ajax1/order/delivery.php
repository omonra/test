<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(!empty($arResult["DELIVERY"])):?>
<?/*
global $USER;
if ($USER->IsAdmin()):
?>
<pre><?print_r($arResult)?></pre>
<?endif*/?>
<div class="ordering_section ">
    <h2>Выберете способ доставки</h2>

    <ul class="list_type_1">
        <?foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery):?>
            <li class="item"><label for="delivery_type_<?= $arDelivery["ID"] ?>"><input type="radio" id="ID_DELIVERY_ID_<?= $arDelivery["ID"] ?>" name="<?=$arDelivery["FIELD_NAME"]?>" value="<?= $arDelivery["ID"] ?>"<?if ($arDelivery["CHECKED"]=="Y") echo " checked";?> onclick="submitForm();"> <? if($arDelivery["NAME"]) echo $arDelivery["NAME"]; else echo $arDelivery["TITLE"]?> <?if (strlen($arDelivery["DESCRIPTION"]) > 0):?><span class="description"><?=nl2br($arDelivery["DESCRIPTION"])?></span><?endif;?></label></li>
        <?endforeach;?>
    </ul>
</div>
<?endif;?>