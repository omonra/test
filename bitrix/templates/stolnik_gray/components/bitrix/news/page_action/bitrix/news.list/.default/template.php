<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<ul class="articles_list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<li class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <div class="item_in">
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                <? $cfile=CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>109, 'height'=>100), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
            <div class="preview">
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img class="preview_picture" border="0" src="<?=$cfile["src"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>"  /></a>
            </div>
			<?else:?>
            <? $cfile=CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>109, 'height'=>100), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
            <div class="preview">
				<img class="preview_picture" border="0" src="<?=$cfile["src"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>"  />
            </div>
			<?endif;?>
        <?else:?>
            <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
            <div class="preview">
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img style="margin: 32px 0 0 0;" class="logo" src="/bitrix/templates/stolnilk/images/logo.png" width="100"  alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>"></a>
            </div>
            <?else:?>
            <div class="preview">
                <img style="margin: 32px 0 0 0;" class="logo" src="/bitrix/templates/stolnilk/images/logo.png" width="100"  alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" >
            </div>
            <?endif;?>
		<?endif?>
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
				<h4><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a></h4>
			<?else:?>
                </h4><?echo $arItem["NAME"]?></h4>
			<?endif;?>
		<?endif;?>
            <p class="rubric">Рубрика: <?=$arItem["SECTION_NAME"]?></p>
		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
            <p class="announce"><?=$arItem["PREVIEW_TEXT"];?></p>
		<?endif;?>
		<?foreach($arItem["FIELDS"] as $code=>$value):?>
			<small>
			<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
			</small><br />
		<?endforeach;?>
		<?foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
			<small>
			<?=$arProperty["NAME"]?>:&nbsp;
			<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
				<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
			<?else:?>
				<?=$arProperty["DISPLAY_VALUE"];?>
			<?endif?>
			</small><br />
		<?endforeach;?>
            <div class="more"><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>">Подробнее</a></div>
    </div>
	</li>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</ul>