<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(count($arResult["ITEMS"])>0):?>
<h2 class="h_type_1"><span class="h_in">���������� �����������</span></h2>
<ul class="action_list">
<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
    <?
    $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
    ?>
    <li class="item" id="<?=$this->GetEditAreaId($arElement['ID']);?>"><div class="item_in">
        <? $cfile=CFile::ResizeImageGet($arElement['DETAIL_PICTURE'], array('width'=>228, 'height'=>318), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
        <div class="preview"><a href="<?=$arElement["PROPERTIES"]["LINK"]["VALUE"]?>"><img src="<?=$cfile["src"]?>" width="228" height="318" alt=""></a></div>
        <div class="item_content">
            <h3><?=$arElement["NAME"]?> <br><a href="<?=$arElement["PROPERTIES"]["LINK"]["VALUE"]?>"><?=$arElement["PREVIEW_TEXT"]?></a></h3>
            <div class="description"><a href="<?=$arElement["PROPERTIES"]["LINK"]["VALUE"]?>"><?=$arElement["DETAIL_TEXT"]?></a></div>
        </div>
    </div></li>
<?endforeach;?>
</ul>
<?endif;?>