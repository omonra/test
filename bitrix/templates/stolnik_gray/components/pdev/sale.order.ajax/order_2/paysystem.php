<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="ordering_section ">
    <h2>Выберете способ оплаты</h2>
    <ul class="list_type_1">
        <?foreach($arResult["PAY_SYSTEM"] as $arPaySystem):?>
            <li class="item"><label for="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>"><input id="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>" type="radio" name="PAY_SYSTEM_ID" value="<?= $arPaySystem["ID"] ?>"<?if ($arPaySystem["CHECKED"]=="Y") echo " checked=\"checked\"";?> > <?=$arPaySystem["PSA_NAME"] ?> <?if (strlen($arPaySystem["DESCRIPTION"])>0):?><span class="description"><?=$arPaySystem["DESCRIPTION"]?></span><?endif;?></label></li>
        <?endforeach;?>
    </ul>
</div>

