<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="side_block">
    <ul class="side_menu">
        <?foreach($arResult["SECTIONS"] as $arSection):?>
        <li<?if($arParams["SECTION_CODE"]==$arSection["CODE"]):?> class="active"<?endif;?>><a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a><?if (isset($arSection['ELEMENT_CNT']) && $arSection['ELEMENT_CNT'] > 0):?> <span class="count">(<?=$arSection['ELEMENT_CNT']?>)</span><?endif;?></li>
        <?endforeach;?>
    </ul>
</div>
