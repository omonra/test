<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="b-title">
    Новостной блог
</div>
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<ul class="b-list b-list_four b-list_news g-clear">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
	    <li class="item g-clear" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
	    	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PICTURE"])):?>
		        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?echo $arItem["NAME"]?>"><img
		        		class="img"
		        		src="<?=$arItem["PICTURE"]["SRC"]?>"
		        		width="<?=$arItem["PICTURE"]["WIDTH"]?>"
		        		height="<?=$arItem["PICTURE"]["HEIGHT"]?>"
		        		alt="<?echo $arItem["NAME"]?>"
		        		/></a>
		    <?endif;?>
	        <span class="txt">
	        	<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
	        		<span class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
	        	<?endif?>
	        	<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
	        		<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
	        			<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="title" title="<?echo $arItem["NAME"]?>"><?echo $arItem["NAME"]?></a>
	        		<?else:?>
	        			<a class="title" title="<?echo $arItem["NAME"]?>"><?echo $arItem["NAME"]?></a>
	        		<?endif;?>
	        	<?endif;?>
	        </span>
	        <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
	        	<div class="text"><?echo $arItem["PREVIEW_TEXT"];?></div>
	        <?endif;?>
	    </li>
	<?endforeach;?>
</ul>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
