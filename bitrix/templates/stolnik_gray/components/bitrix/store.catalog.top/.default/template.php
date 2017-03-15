<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="b-carousel-novelty">
    <div class="b-title">
        Новинки из коллекции
        <div class='b-arrow b-arrow__left js-carousel-novelty__prev'></div>
        <div class='b-arrow b-arrow__right js-carousel-novelty__next'></div>
    </div>
    <div class="scrollable">
    <ul class="b-list b-list_products items">
        <?
        $countElement = 0;
        foreach($arResult['ITEMS'] as $key => $arItem):
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => 'Вы уверены, что хотите удалить элемент?'));
            ?>

            <?#if ($countElement == 0){
            $arItem['COLORS'] = array();
            $arItemColors = array();
            foreach($arItem['OFFERS'] as $offer){
                if (!empty($offer['PROPERTIES']['COLOR']['VALUE'])){
                    if (!in_array($offer['PROPERTIES']['COLOR']['VALUE'], $arItemColors)) {
                        $arItemColors[] = $offer['PROPERTIES']['COLOR']['VALUE'];
                    }
                }
            }

            if (count($arItemColors) > 0) {
                foreach ($arItemColors as $color) {
                    $rsColors = CIBlockElement::GetList(array(), array(
                        "IBLOCK_ID" => COLORS_IBLOCK_ID,
                        "ACTIVE" => "Y",
                        array("LOGIC" => "OR",
                            array("PROPERTY_item_color_list" => $color),
                            array("NAME" => $color),
                        )
                    ), false, false, array(
                        "ID",
                        "IBLOCK_ID",
                        "NAME",
                        "PREVIEW_PICTURE",
                        "PROPERTY_item_color_list",
                    ));
                    if ($arColor = $rsColors->GetNext()) {

                        if (!in_array($arColor['NAME'], $arItemColors)) {
                            $arColor['NAME'] = $arColor['PROPERTY_ITEM_COLOR_LIST_VALUE'];
                        }
                        $colorName = ToUpper($arColor['NAME']);

                        if (isset($arResult['COLORS'][$colorName])) {
                            continue;
                        }
                        $arColor['PICTURE'] = GetResizedPicture($arColor['PREVIEW_PICTURE'], 50, 25);
                        $arItem['COLORS'][] = $arColor;
                    }
                }
                # }
                $countElement++;
                #echo '<div style="display: none"> <pre>'; print_r($arItemColors); echo "</pre></div>";
                #echo '<div style="display: none"> <pre>'; print_r($arItem); echo "</pre></div>";
            }?>
            <li class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="link" title="<?=$arItem["NAME"]?>" >
                    <?if (strlen($arItem['LABEL']) > 0):?>
                        <span class="<?=$arItem['LABEL']?>"></span>
                    <?endif;?>
                    <span class="img" style="background-image: url(<?=$arItem['PICTURE']['SRC']?>)" alt="<?=$arItem["NAME"]?>" />
                    </span>
                </a>
                <a class="title" href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?=$arItem["NAME"]?>"><?=$arItem["NAME"]?></a>
                <div class="cost">
                    <?if((int)$arItem["PROPERTIES"]["STARYE_TSENY"]["VALUE"] > 0 && (int)$arItem["PROPERTIES"]["STARYE_TSENY"]["VALUE"] > $arItem["PROPERTIES"]["MAXIMUM_PRICE"]["VALUE"]):?>
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
                <?if (is_array($arItem['SIZES']) && count($arItem['SIZES']) > 0 && count($arItem['COLORS']) == 0):
                    $count = count($arItem['SIZES']);
                    ?>
                    <div class="size g-clear">
                        <div class="txt">Размеры в наличии</div>
                        <div class="dimensions">
                            <?foreach ($arItem['SIZES'] as $key2 => $size):?>
                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" title="Размер <?=$size?>"><?=$size?></a><?=($key2 == $count - 1 ? '' : ' |')?>
                            <?endforeach;?>
                        </div>
                    </div>
                <?endif;?>

                <?if (is_array($arItem['COLORS']) && count($arItem['COLORS']) > 0):
                    $count = count($arItem['COLORS']);
                    ?>
                    <div class="size g-clear">
                        <div class="txt">Цвета в наличии</div>
                        <div class="dimensions">
                            <?foreach ($arItem['COLORS'] as $key2 => $color):?>
                                <img src="<?=$color['PICTURE']['SRC']?>" style="float: left; width: 10px; margin-right: 3px;" alt="Цвет <?=$color['NAME']?>" />
                                <?//=($key2 == $count - 1 ? '' : ' |')?>
                            <?endforeach;?>
                        </div>
                    </div>
                <?endif;?>
            </li>
        <?endforeach;?>
    </ul>
    </div>
</div>
