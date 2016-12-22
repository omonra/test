<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$curPage = $APPLICATION->GetCUrPage();?>
<div class="b-collections-list__item b-collections-list__item_subcatalog">
    <div class="b-collections-list__links">
        <a href="<?=SITE_DIR?>catalog/news_<?=$arResult['SECTION']['CODE']?>/" title="" class="item orange">Новинки<?if ($arResult['COUNT_NEW'] > 0):?> <span class="count">(<?=$arResult['COUNT_NEW']?>)</span><?endif;?></a>
        <a href="<?=SITE_DIR?>catalog/spec_<?=$arResult['SECTION']['CODE']?>/" title="" class="item orange">Распродажа<?if ($arResult['COUNT_SALE'] > 0):?> <span class="count">(<?=$arResult['COUNT_SALE']?>)</span><?endif;?></a>

        <?$arActions = GetActiveActions();
        if (is_array($arActions) && count($arActions) > 0 && $arResult['COUNT_ACTION'] > 0):?>
            <a href="<?=SITE_DIR?>catalog/action_<?=$arResult['SECTION']['CODE']?>/" title="" class="item orange">Акция<?if ($arResult['COUNT_ACTION'] > 0):?> <span class="count">(<?=$arResult['COUNT_ACTION']?>)</span><?endif;?></a>
        <?endif;?>

        <a href="<?=$arResult['SECTION']['SECTION_PAGE_URL']?>" title="" class="item orange">Все категории<?if ($arResult['SECTION']['ELEMENT_CNT'] > 0):?> <span class="count">(<?=$arResult['SECTION']['ELEMENT_CNT']?>)</span><?endif;?></a>
        <p></p>
        <?foreach($arResult["SECTIONS"] as $arItem):?>
            <a href="<?=$arItem['SECTION_PAGE_URL']?>" title="<?=$arItem["NAME"]?>" class="item<?=($curPage == $arItem['SECTION_PAGE_URL'] ? ' current' : '')?>"><?=$arItem["NAME"]?><?if ($arItem['ELEMENT_CNT'] > 0):?> <span class="count">(<?=$arItem['ELEMENT_CNT']?>)</span><?endif;?></a>
        <?endforeach;?>
        <a href="<?=$arResult['SECTION']['SECTION_PAGE_URL']?>" title="" class="item">Все категории<?if ($arResult['SECTION']['ELEMENT_CNT'] > 0):?> <span class="count">(<?=$arResult['SECTION']['ELEMENT_CNT']?>)</span><?endif;?></a>
    </div>
</div>
