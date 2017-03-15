<?
//echo "<pre>",print_r($arResult,1),"</pre>";
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->AddChainItem($arResult["SECTION"]["NAME"], $arResult["SECTION"]["SECTION_PAGE_URL"]);
$APPLICATION->AddChainItem($arResult["NAME"]);
CModule::IncludeModule("iblock");
$ListColor=array();
$ListColorName=array();
$arFilter = Array(
    "IBLOCK_ID"=>10,
    "ACTIVE"=>"Y",
);
$res = CIBlockElement::GetList(Array(), $arFilter,false,false,array("ID","IBLOCK_ID","NAME","PREVIEW_PICTURE","PROPERTY_item_color_list"));
while($ar_fields = $res->GetNext())
{
    /*$cfile=CFile::ResizeImageGet($ar_fields['PREVIEW_PICTURE'], array('width'=>10, 'height'=>10), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    $ListColor[$ar_fields["NAME"]]=$cfile["src"];*/
    $cfile=CFile::ResizeImageGet($ar_fields['PREVIEW_PICTURE'], array('width'=>25, 'height'=>25), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    if(strlen($ar_fields["PROPERTY_ITEM_COLOR_LIST_VALUE"])>0){
        $ListColor[$ar_fields["PROPERTY_ITEM_COLOR_LIST_VALUE"]]=$cfile["src"];
        $ListColorName[$ar_fields["PROPERTY_ITEM_COLOR_LIST_VALUE"]]=$ar_fields["NAME"];
    }
    else{
        $ListColor[$ar_fields["NAME"]]=$cfile["src"];
        $ListColorName[$ar_fields["PROPERTY_ITEM_COLOR_LIST_VALUE"]]=$ar_fields["NAME"];
    }
}
//print_r($ListColor);
$of=array();
$id_list=array();
foreach($arResult["OFFERS"] as $item){
    $id_list[]=$item["ID"];
    //if($item["CATALOG_QUANTITY"]==0) continue;
    $_key_size='';
    $_key_color='';
    /*$key=array_search("Размер",$item["PROPERTIES"]["CML2_ATTRIBUTES"]["DESCRIPTION"]);
    if(!($key===false) && $item["PROPERTIES"]["CML2_ATTRIBUTES"]["VALUE"][$key]!='0'){
        $_key_size=$item["PROPERTIES"]["CML2_ATTRIBUTES"]["VALUE"][$key];
    }
    $key=array_search("Цвет",$item["PROPERTIES"]["CML2_ATTRIBUTES"]["DESCRIPTION"]);
    if(!($key===false) && $item["PROPERTIES"]["CML2_ATTRIBUTES"]["VALUE"][$key]!='0'){
        $_key_color=$item["PROPERTIES"]["CML2_ATTRIBUTES"]["VALUE"][$key];
    }*/
    $_key_size=$item["PROPERTIES"]["SIZE"]["VALUE"];
    $_key_color=$item["PROPERTIES"]["COLOR"]["VALUE"];

    if(strlen($_key_size)>0 && strlen($_key_color)>0){
        $key=array_key_exists($_key_color,$ListColor);
        $src='';
        if(isset($ListColor[$_key_color])){
            $src=$ListColor[$_key_color];
        }
        $arColor2[]=array("NAME"=>$item,"SRC"=>$src);
        if(isset($of[$_key_size][$_key_color])){
            $q=$of[$_key_size][$_key_color]["QUANTITY"];
            $p=$of[$_key_size][$_key_color]["CATALOG_PRICE_" . GetPriceId()];
            $of[$_key_size][$_key_color]=array("ID"=>$item["ID"],"TITLE"=>$ListColorName[$_key_color],"SRC"=>$src,"ADD"=>$item["ADD_URL"],"QUANTITY"=>$item["CATALOG_QUANTITY"]+$q,"CATALOG_PRICE_" . GetPriceId()=>$item["CATALOG_PRICE_" . GetPriceId()]+$p);
        }
        else
            $of[$_key_size][$_key_color]=array("ID"=>$item["ID"],"TITLE"=>$ListColorName[$_key_color],"SRC"=>$src,"ADD"=>$item["ADD_URL"],"QUANTITY"=>$item["CATALOG_QUANTITY"], "CATALOG_PRICE_" . GetPriceId()=>$item["CATALOG_PRICE" . GetPriceId()]+$p);
    }



}
$arResult["STORE"]=array();
    $db_res=CCatalogStoreProduct::GetList(array(),array("PRODUCT_ID"=>$id_list,">AMOUNT"=>0));
    while($ar_res=$db_res->getNext()){
        $arResult["STORE"][]=$ar_res;
    }


$arResult["OF"]=$of;

$VISITED = $APPLICATION->get_cookie("VISITED");

if (isset($VISITED) && strlen($VISITED)>0)
    $VISITED=unserialize($VISITED);
else
    $VISITED=array();

if (!in_array($arResult["ID"],$VISITED))
{
    array_unshift($VISITED,$arResult["ID"]);

    if (count($VISITED)>10)
        array_pop($VISITED);
    $APPLICATION->set_cookie("VISITED", serialize($VISITED), time()+60*60*24*30*12*2);
}
else
{
    $key=array_search($arResult["ID"],$VISITED);
    unset($VISITED[$key]);
    array_unshift($VISITED,$arResult["ID"]);
    $APPLICATION->set_cookie("VISITED", serialize($VISITED), time()+60*60*24*30*12*2);
}

//Определяем идентификатор статьи из разделов
//print_r($arResult["IBLOCK_SECTION_ID"]);
if(intval($arResult["PROPERTIES"]["ARTICLES"]["VALUE"])>0){
    $p_id=intval($arResult["PROPERTIES"]["ARTICLES"]["VALUE"]);
}else{
    $p_id=recursection($arResult["IBLOCK_ID"],$arResult["IBLOCK_SECTION_ID"]);
}
if($p_id){
    $res = CIBlockElement::GetByID($p_id);
    if($ar_res = $res->GetNext())
        $arResult["ARTICLES"]=$ar_res;
}

$arResult["ARTICLES_LINK"]=recursectionLINK($arResult["IBLOCK_ID"],$arResult["IBLOCK_SECTION_ID"]);;
if(!empty($arResult["ARTICLES_LINK"])){
    foreach($arResult["ARTICLES_LINK"] as $item){
        $res = CIBlockElement::GetByID($item);
        if($ar_res = $res->GetNext())
            $temp[]=$ar_res;
    }
    $arResult["ARTICLES_LINK"]=$temp;
}

function recursection($IBLOCK_ID,$ID){
    $ar_result=CIBlockSection::GetList(Array("SORT"=>"ASC"), Array('IBLOCK_ID'=>$IBLOCK_ID, 'ID'=>$ID),false, Array("UF_ARTICLES"));
    if($res=$ar_result->GetNext())
    {
        if($res["IBLOCK_SECTION_ID"]!=0 && intval($res["UF_ARTICLES"])==0){
            return recursection($IBLOCK_ID,$res["IBLOCK_SECTION_ID"]);
        }
        return $res["UF_ARTICLES"];
    }
    return 0;
}

function recursectionLink($IBLOCK_ID,$ID){
    $ar_result=CIBlockSection::GetList(Array("SORT"=>"ASC"), Array('IBLOCK_ID'=>$IBLOCK_ID, 'ID'=>$ID),false, Array("UF_ARTICLES_LINK"));
    $result=array();
    if($res=$ar_result->GetNext())
    {
        if($res["IBLOCK_SECTION_ID"]!=0 && empty($res["UF_ARTICLES_LINK"])){
            $result=recursectionLink($IBLOCK_ID,$res["IBLOCK_SECTION_ID"]);
        }else{
            return $res["UF_ARTICLES_LINK"];
        }
    }
    return $result;
}
//Работаем со складами
/*$arResult["WAREHOUSE"]=array();
$arFilter = Array(
        "IBLOCK_ID"=>12,
        "ACTIVE"=>"Y",
);
$res = CIBlockElement::GetList(Array('SORT'=>'ASC'), $arFilter,false,false,array("ID","IBLOCK_ID","NAME","CODE","PROPERTY_ADDRESS"));
while($ar_fields = $res->GetNext())
{
    if(isset($arResult["PROPERTIES"][$ar_fields["CODE"]]["VALUE"]) && intval($arResult["PROPERTIES"][$ar_fields["CODE"]]["VALUE"])>0){
       $ar_fields["COUNT"]=$arResult["PROPERTIES"][$ar_fields["CODE"]]["VALUE"];
       $arResult["WAREHOUSE"][]=$ar_fields;
    }
}*/

//Сортируем размеры согласно ИБ 13
$ListSize=array();
$arFilter = Array(
    "IBLOCK_ID"=>13,
    "ACTIVE"=>"Y",
);
$res = CIBlockElement::GetList(Array("SORT"=>"asc"), $arFilter,false,false,array("ID","IBLOCK_ID","NAME","SORT"));
while($ar_fields = $res->GetNext())
{
    $ListSize[]=$ar_fields;
}

if(!empty($ListSize)){
    $temp=$arResult["OF"];
    $new_of=array();
    foreach($ListSize as $item){
        if(isset($temp[$item["NAME"]])){
            $new_of[$item["NAME"]]=$temp[$item["NAME"]];
            unset($temp[$item["NAME"]]);
        }
    }
    if(!empty($temp)){
        foreach($temp as $tkey=>$titem){
            $new_of[$tkey]=$temp[$tkey];
        }

    }
    $arResult["OF"]=$new_of;
}

?>


