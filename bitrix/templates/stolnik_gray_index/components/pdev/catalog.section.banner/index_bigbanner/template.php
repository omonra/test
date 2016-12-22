<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="top_slider">
<ul class="items">
<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
    <?
    $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
    ?>
    <li class="item" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
        <? $cfile=CFile::ResizeImageGet($arElement['DETAIL_PICTURE'], array('width'=>976, 'height'=>436), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
        <a href="<?=$arElement["PROPERTIES"]["LINK"]["VALUE"]?>"><img class="img" src="<?=$cfile["src"]?>" width="976" height="436" alt=""></a>
        <div class="title"><a href="<?=$arElement["PROPERTIES"]["LINK"]["VALUE"]?>"><?=$arElement["DETAIL_TEXT"]?></a></div>
    </li>
<?endforeach;?>
</ul>
</div>
