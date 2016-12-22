<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="side_block">
    <ul class="side_menu">
        <?foreach($arResult["SECTIONS"] as $arSection):?>
        <li<?if($arParams["SECTION_CODE"]==$arSection["CODE"]):?> class="active"<?endif;?>><a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a><?if(strlen($arSection["UF_NEWS"])>0):?> <img class="icon_new" src="<?=SITE_TEMPLATE_PATH?>/images/icon_new.gif" width="19" height="5" alt=""><?endif;?></li>
        <?endforeach;?>
    </ul>
</div>
