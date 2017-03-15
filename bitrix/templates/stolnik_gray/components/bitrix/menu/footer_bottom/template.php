<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
    <?foreach ($arResult as $key => $arItem):?>
        <div class="b-footer__column b-footer__column_small<?=($key == 2 ? '' : ' last')?>">
            <div class="b-footer__title"><?=$arItem["TEXT"]?></div>
            <?foreach ($arItem["PARAMS"]["ITEMS"] as $arItem2):?>
                <?if (strlen($arItem2["PROPERTY_LINK_VALUE"]) > 0):?>
                    <a href="<?=$arItem2["PROPERTY_LINK_VALUE"]?>" title="<?=$arItem2["NAME"]?>"><?=$arItem2["NAME"]?></a>
                <?else:?>
                    <a href="/articles/<?=$arItem2["CODE"]?>/" title="<?=$arItem2["NAME"]?>"><?=$arItem2["NAME"]?></a>
                <?endif;?>
            <?endforeach;?>
        </div>
    <?endforeach;?>
<?endif?>
