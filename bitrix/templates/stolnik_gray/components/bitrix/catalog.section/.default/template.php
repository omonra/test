<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
#$APPLICATION->SetAdditionalCSS( SITE_TEMPLATE_PATH . '/css/bootstrap.min.css');
//$APPLICATION->AddHeadScript($templateFolder . '/script.js');
?>
<?if (!is_array($arResult["ITEMS"]) || count($arResult["ITEMS"]) <= 0):?>
    <?ShowNote('Не найдено ни одного товара соответствующего установленным параметрам отбора. Измените параметры и повторите отбор')?>
<?else:?>

<ul class="b-list b-list_products b-list_products_three  g-clear">
    <?
    $countElement = 0;
    foreach($arResult["ITEMS"] as $key => $arItem):
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => 'Будет удалена вся информация, связанная с этой записью. Продолжить?'));
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
                
                <?if(intval($arItem['PROPERTIES']['STARYE_TSENY']['VALUE']) > 0 && intval($arItem['PROPERTIES']['STARYE_TSENY']['VALUE']) > $arItem['PRICE']['VALUE']):?>
                    <strike><?=FormatPrice(intval($arItem['PROPERTIES']['STARYE_TSENY']['VALUE']), $arItem['CURRENCY'])?></strike>
                    <?if($arItem['PRICE']['VALUE'] > 0):?>
                        <i><?=$arItem['PRICE']['PRINT_VALUE']?></i>
                    <?endif;?>
                <?else:?>
                    <?if($arItem['PRICE']['VALUE'] > 0):?>
                        <strong><?=$arItem['PRICE']['PRINT_VALUE']?></strong>
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
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?><?=(isset($arItem['SIZE2OFFER'][$size]) ? '#offer=' . $arItem['SIZE2OFFER'][$size] : '')?>" title="Размер <?=$size?>"><?=$size?></a><?=($key2 == $count - 1 ? '' : ' |')?>
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

            <button type="button" class="btn show_fast btn-primary btn-small" data-href="<?=$arItem['DETAIL_PAGE_URL']?>?popup=y&is_ajax=y" data-toggle="modal" data-target="#myModal">
                Быстрый просмотр
            </button>
        </li>
    <?endforeach;?>
<?=$arResult["NAV_STRING"]?>
<?if (strlen($arResult['DESCRIPTION']) > 0):?>
        <li class="description">
            <?=$arResult['DESCRIPTION']?>
        </li>
    <?endif;?>
</ul>





<?//unset($arResult['ITEMS']);?>
<?//dd($arResult);?>
<?endif;?>

<!-- Modal -->
<div class="modal fade"  id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" style="width: 1000px;" role="document">
        <div class="modal-content" style="width: 1000px;">
            <div class="modal-header">
                &nbsp;
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Загрузка...
            </div>
        </div>
    </div>
</div>

<script>
$('body').on('click' ,'[data-toggle="modal"]', function(e) {
            e.preventDefault();

            if ($(this).hasClass('show_fast')) {
                $('.modal-body').html('Загрузка...');
                var href = $(this).attr('data-href');

                $.get(href, function (data) {
                    $('.modal-body').html(data);
                });
            }
        });
</script>