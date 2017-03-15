<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach($arResult["ITEMS"] as $cell=>$arElement){
    $res = CIBlockSection::GetByID($arElement["PROPERTIES"]["LINK"]["VALUE"]);
    if($ar_res = $res->GetNext())
        $arResult["ITEMS"][$cell]["PROPERTIES"]["LINK"]["VALUE"]="/catalog/".$ar_res["CODE"]."/";
}
?>