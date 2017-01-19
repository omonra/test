<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->AddChainItem($arResult["NAME"]);
$ListColor=array();
$arFilter = Array(
    "IBLOCK_ID"=>10,
    "ACTIVE"=>"Y",
);
$res = CIBlockElement::GetList(Array(), $arFilter);
while($ar_fields = $res->GetNext())
{
    $cfile=CFile::ResizeImageGet($ar_fields['PREVIEW_PICTURE'], array('width'=>10, 'height'=>10), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    $ListColor[$ar_fields["NAME"]]=$cfile["src"];
}
foreach($arResult["ITEMS"] as $cell=>$arElement){
    $arColor=array();
    $arColorCount=array();
    $price_min=99999999999;
    $price_max=0;
    foreach($arElement["OFFERS"] as $item){

        $_key_color=$item["PROPERTIES"]["COLOR"]["VALUE"];
        if(strlen($_key_color)>0){
            if(array_search($_key_color,$arColor)===false){
                $arColor[]=$_key_color;
                if($item["CATALOG_QUANTITY"]>0)
                    $arColorCount[$_key_color]=$item["CATALOG_QUANTITY"];
            }
        }
        /*$key=array_search("Цвет",$item["PROPERTIES"]["CML2_ATTRIBUTES"]["DESCRIPTION"]);
        if(!($key===false) && $item["PROPERTIES"]["CML2_ATTRIBUTES"]["VALUE"][$key]!='0'){
            if(array_search($item["PROPERTIES"]["CML2_ATTRIBUTES"]["VALUE"][$key],$arColor)===false){
                $arColor[]=$item["PROPERTIES"]["CML2_ATTRIBUTES"]["VALUE"][$key];
            }
        }*/
        if(intval($item["PRICES"]["Розничная"]["VALUE"])>0){
            if ($item["PRICES"]["Розничная"]["VALUE"]<$price_min) $price_min=$item["PRICES"]["Розничная"]["VALUE"];
            if ($item["PRICES"]["Розничная"]["VALUE"]>$price_max) $price_max=$item["PRICES"]["Розничная"]["VALUE"];
        }
    }
    $arColor2=array();
    foreach($arColor as $item){
        $key=array_key_exists($item,$ListColor);
        $src='';
        if(isset($ListColor[$item])){
            $src=$ListColor[$item];
        }
        $count=0;
        if(isset($arColorCount[$item]))
            $count=$arColorCount[$item];
        $arColor2[]=array("NAME"=>$item,"SRC"=>$src,"COUNT"=>$count);
    }
    $arResult["ITEMS"][$cell]["COLOR"]=$arColor2;
    $arResult["ITEMS"][$cell]["PRICE_MIN"]=$price_min;
    $arResult["ITEMS"][$cell]["PRICE_MAX"]=$price_max;


}


?>