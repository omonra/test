<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

	

$APPLICATION->AddChainItem($arResult["NAME"]);
$ListColor=array();
$ListColorName=array();
$arColorCount=array();
$arFilter = Array(
    "IBLOCK_ID"=>10,
    "ACTIVE"=>"Y",
);
$res = CIBlockElement::GetList(Array(), $arFilter,false,false,array("ID","IBLOCK_ID","NAME","PREVIEW_PICTURE","PROPERTY_item_color_list"));
while($ar_fields = $res->GetNext())
{
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
foreach($arResult["ITEMS"] as $cell=>$arElement){
    $arColor=array();

    ?>

        <?
    foreach($arElement["OFFERS"] as $item){
        $key=array_search("Цвет",$item["PROPERTY_CML2_ATTRIBUTES_DESCRIPTION"]);
        if(!($key===false) && $item["PROPERTY_CML2_ATTRIBUTES_VALUE"][$key]!='0'){
            if(array_search($item["PROPERTY_CML2_ATTRIBUTES_VALUE"][$key],$arColor)===false){
                $arColor[]=$item["PROPERTY_CML2_ATTRIBUTES_VALUE"][$key];
                if($item["CATALOG_QUANTITY"]>0)
                    $arColorCount[$item["PROPERTY_CML2_ATTRIBUTES_VALUE"][$key]]=$item["CATALOG_QUANTITY"];
            }
        }

        /*$_key_color=$item["PROPERTIES_COLOR_VALUE"];
        if(strlen($_key_color)>0){
            if(array_search($_key_color,$arColor)===false){
                $arColor[]=$_key_color;
                if($item["CATALOG_QUANTITY"]>0)
                    $arColorCount[$_key_color]=$item["CATALOG_QUANTITY"];
            }
        }*/
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
        $arColor2[]=array("NAME"=>$item,"SRC"=>$src,"TITLE"=>$ListColorName[$item],"COUNT"=>$count);
    }
    $arResult["ITEMS"][$cell]["COLOR"]=$arColor2;
}

?>
