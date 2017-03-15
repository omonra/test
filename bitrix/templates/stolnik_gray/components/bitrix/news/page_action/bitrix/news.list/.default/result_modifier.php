<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach($arResult["ITEMS"] as $key=>$arItem){
    $arFilter = Array('IBLOCK_ID'=>$arItem["IBLOCK_ID"], 'ID'=>$arItem["IBLOCK_SECTION_ID"]);
    $db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, true);
    while($ar_result = $db_list->GetNext())
    {
        $arResult["ITEMS"][$key]["SECTION_NAME"]=$ar_result["NAME"];
    }
}


?>