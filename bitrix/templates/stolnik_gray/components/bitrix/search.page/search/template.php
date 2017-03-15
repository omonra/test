<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
$IBLOCK_ID_OFFERS = CATALOG_OFFERS_IBLOCK_ID;
$IBLOCK_ID_COLOR = COLORS_IBLOCK_ID;
?>
<h1>Результаты поиска: <span class="q"><?=$arResult["REQUEST"]["QUERY"]?></span></h1>



<div class="paging">
    <?=$arResult["NAV_STRING"]?>
</div>

<?if(count($arResult["SEARCH"])>0):?>
    <ul class="search_results">
        <?$i=0;foreach($arResult["SEARCH"] as $arItem):?>
            <?if($arItem["MODULE_ID"]=="iblock" && $arItem["PARAM1"]=="catalog" && $arItem["PARAM2"]=="4"):?>
                <?
                $arFilter = Array(
                    "IBLOCK_ID"=>4,
                    "ID"=>$arItem["ITEM_ID"],
                );
                $arSelect=array("ID","CODE","NAME","DETAIL_PICTURE","DETAIL_PAGE_URL","PREVIEW_TEXT","DETAIL_TEXT","PROPERTY_PRICE","PROPERTY_MAXIMUM_PRICE");
                $res = CIBlockElement::GetList(Array(), $arFilter,false,false,$arSelect);
                if($ar_fields = $res->GetNext())
                {
                    $item=$ar_fields;
                    $arFilter2 = Array(
                        "IBLOCK_ID"=>$IBLOCK_ID_OFFERS,
                        "ACTIVE"=>"Y",
                        "PROPERTY_CML2_LINK"=>$item["ID"],
                    );
                    $res2 = CIBlockElement::GetList(Array(), $arFilter2,false,false,array("ID","IBLOCK_ID","PROPERTY_COLOR"));
                    $arColor=array();
                    while($ar_fields2 = $res2->GetNext())
                    {
                        if(array_search($ar_fields2["PROPERTY_COLOR_VALUE"],$arColor)===false){
                            $arColor[]=$ar_fields2["PROPERTY_COLOR_VALUE"];
                        }
                    }
                    //Обработка цветов
                    $temp=array();
                    foreach($arColor as $item2){
                        if(strlen($item2)==0) continue;
                        $arFilter3 = Array(
                            "IBLOCK_ID"=>$IBLOCK_ID_COLOR,
                            "ACTIVE"=>"Y",
                            "PROPERTY_item_color_list" => $item2,
                        );
                        $res3 = CIBlockElement::GetList(Array(), $arFilter3,false,false,array("ID","NAME","IBLOCK_ID","PREVIEW_PICTURE"));
                        $url='';$title='';
                        while($ar_fields3 = $res3->GetNext())
                        {
                            $title=$ar_fields3["NAME"];
                            $url=CFile::GetPath($ar_fields3["PREVIEW_PICTURE"]);
                        }
                        $temp[]=array("NAME"=>$title,"URL"=>$url);
                    }
                    $arColor=$temp;
                }
                ?>
                <li class="item<?if($i==0):?> item_first<?endif;?>">
                    <?if($item["DETAIL_PICTURE"]>0):?>
                        <? $cfile=CFile::ResizeImageGet($item["DETAIL_PICTURE"], array('width'=>230, 'height'=>320), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
                        <img class="preview" src="<?=$cfile["src"]?>" width="230" height="<?=round($cfile["height"]*(230/$cfile["width"]))?>" alt="">
                    <?else:?>
                        <img class="preview" src="<?=SITE_TEMPLATE_PATH?>/images/nopic.jpg" width="230" alt="">
                    <?endif;?>
                    <div class="name"><a href="<?=$item["DETAIL_PAGE_URL"]?>"><?=$item["NAME"]?></a></div>
                    <?if($item["PROPERTY_PRICE_VALUE"]>0):?>
                        <dl class="price"><dt>Цена</dt> <dd><span class="val"><?=substr(FormatCurrency($item['PROPERTY_MAXIMUM_PRICE_VALUE']/*$item["PROPERTY_PRICE_VALUE"]*/, "RUB"),0,-4);?></span> руб.</dd></dl>
                    <?endif;?>
                    <div class="description"><?=$item["PREVIEW_TEXT"]?></div>

                    <?if(count($arColor)>0):?>
                        <ul class="color_list">
                            <?foreach($arColor as $it):?>
                                <li><img src="<?=$it["URL"]?>" width="10" height="10" alt="<?=$it["NAME"]?>" title="<?=$it["NAME"]?>"></li>
                            <?endforeach;?>
                        </ul>
                    <?endif;?>

                    <div class="go_to_cat"><a class="button_1" href="<?=$item["DETAIL_PAGE_URL"]?>">Перейти в каталог</a></div>
                </li>
            <?elseif($arItem["MODULE_ID"]=="iblock" && $arItem["PARAM1"]=="catalog" && $arItem["PARAM2"]=="5"):?>
                <?
                $arFilterpre = Array(
                    "IBLOCK_ID"=>5,
                    "ID"=>$arItem["ITEM_ID"],
                );
                $arSelectpre=array("ID","PROPERTY_CML2_LINK");
                $respre = CIBlockElement::GetList(Array(), $arFilterpre,false,false,$arSelectpre);
                if($ar_fieldspre = $respre->GetNext())
                {
                    $arFilter = Array(
                        "IBLOCK_ID"=>4,
                        "ID"=>$ar_fieldspre["PROPERTY_CML2_LINK_VALUE"],
                    );
                    $arSelect=array("ID","CODE","NAME","DETAIL_PICTURE","DETAIL_PAGE_URL","PREVIEW_TEXT","DETAIL_TEXT","PROPERTY_PRICE");
                    $res = CIBlockElement::GetList(Array(), $arFilter,false,false,$arSelect);
                    if($ar_fields = $res->GetNext())
                    {
                        $item=$ar_fields;
                        $arFilter2 = Array(
                            "IBLOCK_ID"=>$IBLOCK_ID_OFFERS,
                            "ACTIVE"=>"Y",
                            "PROPERTY_CML2_LINK"=>$item["ID"],
                        );
                        $res2 = CIBlockElement::GetList(Array(), $arFilter2,false,false,array("ID","IBLOCK_ID","PROPERTY_COLOR"));
                        $arColor=array();
                        while($ar_fields2 = $res2->GetNext())
                        {
                            if(array_search($ar_fields2["PROPERTY_COLOR_VALUE"],$arColor)===false){
                                $arColor[]=$ar_fields2["PROPERTY_COLOR_VALUE"];
                            }
                        }
                        //Обработка цветов
                        $temp=array();
                        foreach($arColor as $item2){
                            if(strlen($item2)==0) continue;
                            $arFilter3 = Array(
                                "IBLOCK_ID"=>$IBLOCK_ID_COLOR,
                                "ACTIVE"=>"Y",
                                "PROPERTY_item_color_list" => $item2,
                            );
                            $res3 = CIBlockElement::GetList(Array(), $arFilter3,false,false,array("ID","NAME","IBLOCK_ID","PREVIEW_PICTURE"));
                            $url='';$title='';
                            while($ar_fields3 = $res3->GetNext())
                            {
                                $title=$ar_fields3["NAME"];
                                $url=CFile::GetPath($ar_fields3["PREVIEW_PICTURE"]);
                            }
                            $temp[]=array("NAME"=>$title,"URL"=>$url);
                        }
                        $arColor=$temp;
                    }
                    ?>
                    <li class="item<?if($i==0):?> item_first<?endif;?>">
                        <?if($item["DETAIL_PICTURE"]>0):?>
                            <? $cfile=CFile::ResizeImageGet($item["DETAIL_PICTURE"], array('width'=>230, 'height'=>320), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
                            <img class="preview" src="<?=$cfile["src"]?>" width="230" height="<?=round($cfile["height"]*(230/$cfile["width"]))?>" alt="">
                        <?else:?>
                            <img class="preview" src="<?=SITE_TEMPLATE_PATH?>/images/nopic.jpg" width="230" alt="">
                        <?endif;?>
                        <div class="name"><a href="<?=$item["DETAIL_PAGE_URL"]?>"><?=$arItem["SEARCHABLE_CONTENT"]?></a></div>
                        <?if($item["PROPERTY_PRICE_VALUE"]>0):?>
                            <dl class="price"><dt>Цена</dt> <dd><span class="val"><?=substr(FormatCurrency($item["PROPERTY_PRICE_VALUE"], "RUB"),0,-4);?></span> руб.</dd></dl>
                        <?endif;?>
                        <div class="description"><?=$item["PREVIEW_TEXT"]?></div>

                        <?if(count($arColor)>0):?>
                            <ul class="color_list">
                                <?foreach($arColor as $it):?>
                                    <li><img src="<?=$it["URL"]?>" width="10" height="10" alt="<?=$it["NAME"]?>" title="<?=$it["NAME"]?>"></li>
                                <?endforeach;?>
                            </ul>
                        <?endif;?>

                        <div class="go_to_cat"><a class="button_1" href="<?=$item["DETAIL_PAGE_URL"]?>">Перейти в каталог</a></div>
                    </li>
                <?
                }

                ?>
            <?elseif(($arItem["MODULE_ID"]=="iblock" && $arItem["PARAM1"]=="news") ||
                ($arItem["MODULE_ID"]=="iblock" && $arItem["PARAM1"]=="services")   ):?>
                <?$res = CIBlockElement::GetByID($arItem["ITEM_ID"]);?>
                <?if($ar_res = $res->GetNext()):?>
                    <li class="item<?if($i==0):?> item_first<?endif;?>">
                        <?if($item["PREVIEW_PICTURE"]>0):?>
                            <? $cfile=CFile::ResizeImageGet($item["PREVIEW_PICTURE"], array('width'=>230, 'height'=>320), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
                            <img class="preview" src="<?=$cfile["src"]?>" width="230" height="320" alt="">
                        <?elseif($item["DETAIL_PICTURE"]>0):?>
                            <? $cfile=CFile::ResizeImageGet($item["DETAIL_PICTURE"], array('width'=>230, 'height'=>320), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
                        <?else:?>
                            <img class="preview" src="<?=SITE_TEMPLATE_PATH?>/images/nopic.jpg" width="230" alt="">
                        <?endif;?>

                        <div class="name"><a href="<?=$item["DETAIL_PAGE_URL"]?>"><?=$arItem["TITLE"]?></a></div>
                        <div class="description"><?=$item["PREVIEW_TEXT"]?></div>

                        <div class="go_to_cat"><a class="button_1" href="<?=$item["DETAIL_PAGE_URL"]?>">Перейти</a></div>
                    </li>
                <?endif;?>
            <?else:?>
                <li class="item">
                    <img class="preview" src="<?=SITE_TEMPLATE_PATH?>/images/nopic.jpg" width="230" alt="">
                    <div class="name"><a href="<?=$item["URL"]?>"><?=$arItem["TITLE"]?></a></div>
                    <div class="description"><?=$arItem["PREVIEW_TEXT"]?></div>

                    <div class="go_to_cat"><a class="button_1" href="<?=$item["URL"]?>">Перейти</a></div>
                </li>
            <?endif;?>
            <?$i++;endforeach;?>
    </ul>
<?else:?>
    <?ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND"));?>
<?endif;?>
