<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!is_array($arResult["ITEMS"]) || count($arResult["ITEMS"]) <= 0):?>
    <?ShowNote('Не найдено ни одного товара соответствующего установленным параметрам отбора. Измените параметры и повторите отбор')?>
<?else:?>
<ul class="b-list b-list_products b-list_products_three  g-clear">
    <?foreach($arResult["ITEMS"] as $key => $arItem):
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => 'Будет удалена вся информация, связанная с этой записью. Продолжить?'));
        ?>
        <li class="item" id="<?=$this->GetEditAreaId($arItem['ID'])?>" data-id="<?=$arItem['ID']?>">
            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="link" title="<?=$arItem["NAME"]?>" >
                <?if (strlen($arItem['LABEL']) > 0):?>
                    <span class="<?=$arItem['LABEL']?>"></span>
                <?endif;?>
                <span class="img" style="background-image: url(<?=$arItem['PICTURE']['SRC']?>)" alt="<?=$arItem["NAME"]?>" />
                </span>
            </a>
            <a class="title" href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?=$arItem["NAME"]?>"><?=$arItem["NAME"]?></a>
            <div class="cost">
                <?if((int)$arItem["PROPERTIES"]["STARYE_TSENY"]["VALUE"] > 0):?>
                    <strike><?=intval($arItem["PROPERTIES"]["STARYE_TSENY"]["VALUE"])?> руб.</strike>
                    <?if($arItem["PROPERTIES"]["PRICE"]["VALUE"]>0):?>
                        <i><?=$arItem["PROPERTIES"]["PRICE"]["VALUE"]?> руб.</i>
                    <?endif;?>
                <?else:?>
                    <?if($arItem["PROPERTIES"]["MAXIMUM_PRICE"]["VALUE"]>0):?>
                        <?$max = explode(".",$arItem["PROPERTIES"]["MAXIMUM_PRICE"]['VALUE']);?>
                        <strong><?=$max[0]?> руб.</strong>
                    <?endif;?>
                <?endif;?>
            </div>
            <span class="stars">
                <?for ($i = round(intval($arItem['PROPERTIES']['comments_sum']['VALUE']) / intval($arItem['PROPERTIES']['comments_count']['VALUE'])); $i > 0; $i--):?>
                    <i></i>
                <?endfor;?>
            </span>
            <span class="reviews">(<?=intval($arItem['PROPERTIES']['comments_count']['VALUE'])?>)</span>
            <?if (is_array($arItem['SIZES']) && count($arItem['SIZES']) > 0):
                $count = count($arItem['SIZES']);
                ?>
                <div class="size g-clear">
                    <div class="txt">Размеры в наличии</div>
                    <div class="dimensions">
                        <?foreach ($arItem['SIZES'] as $key2 => $size):?>
                            <a title="Размер <?=$size?>"><?=$size?></a><?=($key2 == $count - 1 ? '' : ' |')?>
                        <?endforeach;?>
                    </div>
                </div>
            <?endif;?>
        </li>
    <?endforeach;?>
</ul>
<?=$arResult["NAV_STRING"]?>
<?endif;?>
