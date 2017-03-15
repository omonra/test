<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//if($USER->isAdmin())echo "<pre>", print_r($arResult, 1) ,"</pre>";
foreach($arResult["ITEMS"] as $cell=>$arElement){
    if(isset($arElement["PROPERTIES"]["LINK"]["VALUE"][0])){
        $res = CIBlockSection::GetByID($arElement["PROPERTIES"]["LINK"]["VALUE"][0]);
        if($ar_res = $res->GetNext()){
            $arResult["ITEMS"][$cell]["PROPERTIES"]["LINK"]["VALUE"]="/catalog/".$ar_res["CODE"]."/";
        }
    }else{
        $arResult["ITEMS"][$cell]["PROPERTIES"]["LINK"]["VALUE"]=$arResult["ITEMS"][$cell]["PROPERTIES"]["LINK_STR"]["VALUE"];
    }
}
?>