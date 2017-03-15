<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$arAvailableSort = array(
    "price" => Array("PROPERTY_PRICE", "asc"),
);
$sort = $arParams["ELEMENT_SORT_FIELD"];
$sort_order = $arParams["ELEMENT_SORT_ORDER"];
?>
<?if(count($arResult["ITEMS"])>0):?>
<div class="paging" style="position:relative;">
    <div class="sort">
        <dl>
			<dt>Сортировать по:</dt>
            <dd class="selected"><?if($_REQUEST["sort"]=="price" && $_REQUEST["order"]=="desc"):?>убыванию цены<?else:?>возрастанию цены<?endif;?></dd>
        </dl>
        <ul class="list">
            <li <?if($_REQUEST["sort"]=="price" && $_REQUEST["order"]=="desc"):?>class="current"<?endif;?>><label><input onchange="location.href='<?=$APPLICATION->GetCurPageParam("sort=price&order=desc", array("sort", "order"))?>'" type="radio" <?if($_REQUEST["sort"]=="price" && $_REQUEST["order"]=="desc"):?>checked="checked"<?endif;?> name="sort" class="form_hidden"><span class="c_radio c_checked"></span> убыванию цены</label></li>
            <li <?if(!($_REQUEST["sort"]=="price" && $_REQUEST["order"]=="desc")):?>class="current"<?endif;?>><label><input onchange="location.href='<?=$APPLICATION->GetCurPageParam("sort=price&order=asc", array("sort", "order"))?>'" type="radio" <?if(!($_REQUEST["sort"]=="price" && $_REQUEST["order"]=="desc")):?>checked="checked"<?endif;?> name="sort" class="form_hidden"><span class="c_radio"></span> возрастанию цены</label></li>
        </ul>
    </div>

    <?=$arResult["NAV_STRING"]?>
</div>
<ul class="catalog_list">
    <?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
    <?
    $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
    ?>
    <li class="item" style="position:relative;">
	<span class="item_in">
        <span class="preview">
            <!-- Блок EXCLUSIVE -->
            <? if($arElement["PROPERTIES"]['EKSKLYUZIV']['VALUE']=='true') echo "<a href=".$arElement["DETAIL_PAGE_URL"]."><span class='exclusive'>EXCLUSIVE</span></a>";?>
            <!-- Блок EXCLUSIVE -->
        	<a href="<?=$arElement["DETAIL_PAGE_URL"]?>">
	            <?if(is_array($arElement["PREVIEW_PICTURE"])):?>
	                <? $cfile=CFile::ResizeImageGet($arElement['PREVIEW_PICTURE'], array('width'=>'390', 'height'=>'500'), BX_RESIZE_IMAGE_EXACT, true, Array("name" => "sharpen", "precision" => 0));?>
	                <img border="0" src="<?=$cfile["src"]?>" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" width="230" />
	            <?elseif(is_array($arElement["DETAIL_PICTURE"])):?>
	                <? $cfile=CFile::ResizeImageGet($arElement['DETAIL_PICTURE'], array('width'=>'390', 'height'=>'500'), BX_RESIZE_IMAGE_EXACT, true, Array("name" => "sharpen", "precision" => 0));?>
	                <img border="0" src="<?=$cfile["src"]?>" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" width="230" />
	            <?else:?>
	                <img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/nopic.jpg" width="230" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" />
	            <?endif?>
	            
	            <?if($arElement["PROPERTIES"]["SPEC"]["VALUE"]=="true"):?>
	            <?/*<span class="icon icon_product_hit"></span>*/?>
                <span class="icon_discount"></span>
                <?else:?>
                    <?if($arElement["PROPERTIES"]["NOVINKA"]["VALUE"]=="true" || MakeTimeStamp($arElement["DATE_CREATE"], "DD.MM.YYYY HH:MI:SS")>time()-3600*24*7):?>
                        <?/*<span class="icon icon_product_new"></span>*/?>
                        <?/*<span class="icon_new"></span>*/?>
                    <?endif;?>
	            <?endif;?>

	            <?if(!empty($arElement["PROPERTIES"]["SALE"]["VALUE"])):?>
	            <span class="icon icon_product_sale"></span>
	            <?endif;?>
            </a>
        </span>
		<span class="quick_view"><span class="<?=$arElement["DETAIL_PAGE_URL"]?>"></span></span>
		<a href="/cat/element.php?ID=<?=$arElement["ID"]?>&S_ID=<?=$arElement["IBLOCK_SECTION_ID"]?>" class="modalbox dnone">--------------------</a>
		<a href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="modalbox dnone">++++++++++++++</a>
		<div class="name"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></div>

        <div class="price">
            <!--<?print_r($arElement["PROPERTIES"])?>-->
			<? // if(strlen($arElement["PROPERTIES"]["STARYE_TSENY"]["VALUE"])>0):?>
            <?if((int)$arElement["PROPERTIES"]["STARYE_TSENY"]["VALUE"] > 0):?>
                <div class="old"><span class="val"><?=intval($arElement["PROPERTIES"]["STARYE_TSENY"]["VALUE"])?><span class="red_line"></span></span></div>
                <?if($arElement["PROPERTIES"]["PRICE"]["VALUE"]>0):?>
                    <div class="new"><span class="val"><?=$arElement["PROPERTIES"]["PRICE"]["VALUE"]?></span> руб.</div>
                <?endif;?>
            <?else:?>
                <?if($arElement["PROPERTIES"]["MAXIMUM_PRICE"]["VALUE"]>0):?>
                    <?$max = explode(".",$arElement["PROPERTIES"]["MAXIMUM_PRICE"]['VALUE']);?>
                    <div class="price"><span class="val"><?=$max[0]?></span> рб.</div>
                <?endif;?>
            <?endif;?>
        </div>
		<ul class="color_list">
            <?foreach($arElement["COLOR"] as $item):?>
                <?if($item["COUNT"]>0):?>
                    <li><img src="<?=$item["SRC"]?>" width="25" height="25" title="<?=$item["TITLE"]?>"></li>
                <?else:?>
                    <li><img src="<?=$item["SRC"]?>" width="25" height="25"><img src="<?=SITE_TEMPLATE_PATH?>/images/nosc.png" style="position: absolute;left:-1px;top:-1px;" title="<p align='center'><b><?=$item["TITLE"]?></b><br /><span style='color:red;'>отсутствует</span></p>"></li>
                <?endif;?>
            <?endforeach;?>
        </ul>
	</span>
    </li>
    <?endforeach;?>
</ul>
	<div class="description">
		<?if($arResult['NAV_RESULT']->NavPageNomer==1):?>
		   <?=$arResult['DESCRIPTION']?>
		<?endif?>
	</div>
<div class="paging">
    <?=$arResult["NAV_STRING"]?>
</div>
<?else:?>
<p>Не найдено ни одного товара соответствующего установленным параметрам отбора. Измените параметры и повторите отбор</p>
<?endif;?>