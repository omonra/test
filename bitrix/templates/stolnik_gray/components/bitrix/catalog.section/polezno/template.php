<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(count($arResult["ITEMS"])>0):?>
<div class="side_block side_block_good_to_know">
    <h2>Полезно знать</h2>
    <ul class="side_menu">
        <?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
        <li><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></li>
        <?endforeach;?>
    </ul>
</div>
<?endif;?>