<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	//if($USER->isAdmin())echo "<pre>",print_r($arResult,1),"</pre>";
?>
<?if(count($arResult["ITEMS"])>0):?>
<h2 class="h_type_1"><span class="h_in">Популярные товары</span></h2>
<ul id="popular_list" class="item_popular_list">
<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
    <?
    $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
    ?>
    <li class="item" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
        <?if(is_array($arElement["DETAIL_PICTURE"]))
            $cfile=CFile::ResizeImageGet($arElement['DETAIL_PICTURE'], array('width'=>103, 'height'=>103), BX_RESIZE_IMAGE_PROPORTIONAL, true);
            elseif(is_array($arElement["PREVIEW_PICTURE"]))
                $cfile=CFile::ResizeImageGet($arElement['PREVIEW_PICTURE'], array('width'=>103, 'height'=>103), BX_RESIZE_IMAGE_PROPORTIONAL, true);
            else
                $cfile["src"]=SITE_TEMPLATE_PATH."/img/img_item_popular.jpg";
        ?>
        <img class="preview" src="<?=$cfile["src"]?>" width="103" height="103" alt="">
        <div class="name"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></div>
        <?$price="Нет на складе";?>
        <?$min=9999999999;
		
        foreach($arElement["OFFERS"] as $offer){
            foreach($offer["PRICES"] as $iprice){
                if ($min>$iprice["VALUE"]){
                    $price=$iprice["PRINT_VALUE"];
                    $min=$iprice["VALUE"];
                }
            }
        }?>
        <div class="price"><?=$price?></div>
    </li>
<?endforeach;?>
</ul>
<?endif;?>