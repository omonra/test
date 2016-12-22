<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="paging">
    <?=$arResult["NAV_STRING"]?>
</div>
<ul class="catalog_list">
    <?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
    <?
    $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
    ?>
    <li class="item" >
        <span class="preview">
            <?if(is_array($arElement["PREVIEW_PICTURE"])):?>
                <? $cfile=CFile::ResizeImageGet($arElement['PREVIEW_PICTURE'], array('width'=>230, 'height'=>320), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
                <a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img border="0" src="<?=$cfile["src"]?>" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" /></a>
            <?elseif(is_array($arElement["DETAIL_PICTURE"])):?>
                <? $cfile=CFile::ResizeImageGet($arElement['DETAIL_PICTURE'], array('width'=>230, 'height'=>320), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
                <a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img border="0" src="<?=$cfile["src"]?>" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" /></a>
            <?else:?>
                <a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/nopic.jpg" width="230" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" /></a>
            <?endif?>
            <?
            /*
            <span class="icon icon_product_hit"></span>
            <span class="icon icon_product_new"></span>
            <span class="icon icon_product_sale"></span>
            */
            ?>
        </span>
        <ul class="color_list">
            <?foreach($arElement["COLOR"] as $item):?>
            <?if($item["COUNT"]>0):?>
                <li><img src="<?=$item["SRC"]?>" width="10" height="10" ></li>
                <?else:?>
                <li><img src="<?=$item["SRC"]?>" width="10" height="10" ></li>
                <?endif;?>
            <?endforeach;?>
        </ul>
        <div class="name"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></div>
        <div class="price">
            <?if($arElement["PRICE_MAX"]>0):?>
            <?if (intval($arElement["PRICE_MIN"])!=intval($arElement["PRICE_MAX"])):?>
            <div class="price"><span class="val"><?=intval($arElement["PRICE_MIN"])?> - <?=intval($arElement["PRICE_MAX"])?></span> руб.</div>
            <?else:?>
            <div class="price"><span class="val"><?=$arElement["PRICE_MIN"]?><span class="red_line"></span></span></div>
            <?endif;?>
            <?endif;?>
            <?

            /*
            <div class="old"><span class="val">3599</span> руб.</div>
            <div class="new"><span class="val">2599</span> руб.</div>

            */
            ?>
        </div>
    </li>
    <?endforeach;?>
</ul>
<div class="paging">
    <?=$arResult["NAV_STRING"]?>
</div>