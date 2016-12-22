<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!is_array($arResult) || count($arResult) <= 0) return;?>

<div class="b-nav">
    <?foreach($arResult as $key => $arItem):?>
    <div class="item">
        <a href="javascript:void(0);" class="link<?if($arItem["SELECTED"]):?> active<?endif;?>" title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?></a>
        <?if (is_array($arItem['CHILDREN']) && count($arItem['CHILDREN']) > 0):?>
            <div class="subitem g-clear">
                <div class="wrapper g-clear">
                    <?
                    $pol = 'men';
                    $sectionCodes = explode('/', $arItem['LINK']);
                    $pol = $sectionCodes[2];
                    ?>
                    <a href="/catalog/news_<?=$pol?>/" title="" class="item-link orange">Новинки<?if ($arItem['COUNT_NEW'] > 0):?> <span class="count">(<?=$arItem['COUNT_NEW']?>)</span><?endif;?></a>
                    <a href="/catalog/spec_<?=$pol?>/" title="" class="item-link orange">Распродажа<?if ($arItem['COUNT_SALE'] > 0):?> <span class="count">(<?=$arItem['COUNT_SALE']?>)</span><?endif;?></a>
                    <a href="<?=$arItem['LINK']?>" title="Все категории" class="item-link orange">Все категории<?if ($arItem['PARAMS']['CNT'] > 0):?> <span class="count">(<?=$arItem['PARAMS']['CNT']?>)</span><?endif;?></a>

                    <?$arActions = GetActiveActions();
                    if (is_array($arActions) && count($arActions) > 0 && $arItem['COUNT_ACTION'] > 0):?>
                        <a class="item-link orange"></a>
                        <a href="/catalog/action_<?=$pol?>/" title="" class="item-link red">Акция<?if ($arItem['COUNT_ACTION'] > 0):?> <span class="count">(<?=$arItem['COUNT_ACTION']?>)</span><?endif;?></a>
                    <?endif;?>

                    <p></p>
                    <ul>
                        <?
                        $count = count($arItem['CHILDREN']);
                        $third = round($count / 3);
                        $secondThird = $third * 2;
                        if ($count % 3 == 1) {
                            $third += 1;
                            $secondThird += 1;
                        }
                        foreach($arItem['CHILDREN'] as $key2 => $arItem2):?>
                            <?if ($key2 == $third || $key2 == $secondThird):?>
                                </ul><ul>
                            <?endif;?>
                            <li><a href="<?=$arItem2["LINK"]?>"<?if($arItem2["SELECTED"]):?> class=" active"<?endif;?> title="<?=$arItem2["TEXT"]?>"><?=$arItem2["TEXT"]?><?if ($arItem2['PARAMS']['CNT'] > 0):?> <span class="count">(<?=$arItem2['PARAMS']['CNT']?>)</span><?endif;?></a></li>
                        <?endforeach;?>
                    </ul>
                </div>
            </div>
        <?endif;?>
    </div>
    <?endforeach;?>
</div>
