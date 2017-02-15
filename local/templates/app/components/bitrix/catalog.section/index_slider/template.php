<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? if (count($arResult['ITEMS']) > 0): ?>
<div class="catalog-slider-title">
    <? if ($arParams['FLAG_PROPERTY_CODE']=='RASPRODAZHA'): ?>
    <h2>Распродажа</h2>
    <? else: ?>
    <h2>Новинки</h2>
    <!--<a href="">Все новинки</a>-->
    <? endif; ?>
</div>
<? $randStr = 'slider-'. rand(); ?>
<ul class="catalog-list" id="<?=$randStr?>">
    <?foreach($arResult['ITEMS'] as $key => $arItem):?>
    <li>
        <div class="labels">
            <? if (!empty($arItem['PROPERTIES']['SALE']['VALUE'])):?><span class="sale">%</span><? endif; ?>
            <? if (!empty($arItem['PROPERTIES']['NOVINKA']['VALUE'])):?><span class="new">new</span><? endif; ?>
        </div>
        
        <a href="/app/catalog/?ELEMENT_ID=<?=$arItem["ID"]?>" class="image" style="background-image: url('<?=$arItem['PICTURE']['SRC']?>');"></a>
        <a href="/app/catalog/?ELEMENT_ID=<?=$arItem["ID"]?>" class="title"><?=$arItem["NAME"]?></a>
        <div class="price"><?=$arItem['PRICE']['PRINT_VALUE']?></div>
    </li>
    <? endforeach; ?>
</ul>

<script>
$("#<?=$randStr?>").lightSlider({
                loop:false,
                keyPress:true,
                item: 2,
              controls: false,
              pager: false
});
</script>

<? endif; ?>
