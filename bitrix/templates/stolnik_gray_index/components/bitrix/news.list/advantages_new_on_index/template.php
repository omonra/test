<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="b-title" style="text-align: left;color:black;">
    »Õ“≈–Õ≈“-Ã¿√¿«»Õ STOLNIK24.RU†
</div>
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<ul class="b-list b-list_six g-clear">
	<?foreach($arResult["ITEMS"] as $key => $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
	    <li class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>" style="width: 165px;position: relative;">
        	<?/*if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PICTURE"])):*/?><!--
    	        <img
            		src="<?/*=$arItem["PICTURE"]["SRC"]*/?>"
            		width="<?/*=$arItem["PICTURE"]["WIDTH"]*/?>"
            		height="<?/*=$arItem["PICTURE"]["HEIGHT"]*/?>"
            		alt="<?/*echo $arItem["NAME"]*/?>"
            		/>
    	    --><?/*endif;*/?>
			<span style="opacity: 0.13; color: #838383; font-family: Helvetica; font-size: 80px; font-weight: 700; line-height: 16px; text-transform: uppercase;"><?="0".($key+1);?></span>
    	    <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
    	    	<span class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
    	    <?endif?>
    	    <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
    	    	<p class="bold" style="position: absolute;
    top: 0px;
    color: #838383;
    font-family: Helvetica;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    max-width: 120px;"><?echo $arItem["NAME"]?></p>
    	    <?endif;?>
	        <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
	        	<p style="color: #838383;
font-family: Helvetica;
font-size: 10px;
font-weight: 400;
    margin-top: 10px;"><?echo $arItem["PREVIEW_TEXT"];?></p>
	        <?endif;?>
	    </li>
	<?endforeach;?>
</ul>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
