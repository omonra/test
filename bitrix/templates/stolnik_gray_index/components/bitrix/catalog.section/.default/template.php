<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
#$APPLICATION->SetAdditionalCSS( SITE_TEMPLATE_PATH . '/css/bootstrap.min.css');
#$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/bootstrap.min.js');
?>
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
                <?if(intval($arItem['PROPERTIES']['STARYE_TSENY']['VALUE']) > 0 && intval($arItem['PROPERTIES']['STARYE_TSENY']['VALUE']) > $arItem['PRICE']):?>
                    <strike><?=FormatPrice(intval($arItem['PROPERTIES']['STARYE_TSENY']['VALUE']), $arItem['CURRENCY'])?></strike>
                    <?if($arItem['PRICE'] > 0):?>
                        <i><?=FormatPrice($arItem['PRICE'], $arItem['CURRENCY'])?></i>
                    <?endif;?>
                <?else:?>
                    <?if($arItem['PRICE'] > 0):?>
                        <strong><?=FormatPrice($arItem['PRICE'], $arItem['CURRENCY'])?></strong>
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
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?><?=(isset($arItem['SIZE2OFFER'][$size]) ? '#offer=' . $arItem['SIZE2OFFER'][$size] : '')?>" title="Размер <?=$size?>"><?=$size?></a><?=($key2 == $count - 1 ? '' : ' |')?>
                        <?endforeach;?>
                    </div>
                </div>
            <?endif;?>
            <button type="button" class="btn show_fast btn-primary btn-small" data-id="<?=$arItem['ID']?>" data-toggle="modal" data-target="#myModal">
                Быстрый просмотр
            </button>
        </li>
    <?endforeach;?>

    <?if (strlen($arResult['DESCRIPTION']) > 0):?>
        <li class="description">
            <?=$arResult['DESCRIPTION']?>
        </li>
    <?endif;?>
</ul>

<?=$arResult["NAV_STRING"]?>

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
                Loading...
            </div>
        </div>
    </div>
</div>
