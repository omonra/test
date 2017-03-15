<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $listsection;
$listsection=array();
foreach($arResult["SECTIONS"] as $key=>$arSection){
    $arFilter = Array('IBLOCK_ID'=>$arSection["IBLOCK_ID"], 'ID'=>$arSection["ID"]);
    $db_list = CIBlockSection::GetList(Array(), $arFilter, false,array('ID','IBLOCK_ID','UF_NEWS'));
    if($ar_result = $db_list->GetNext())
    {
        $arResult["SECTIONS"][$key]["UF_NEWS"]=$ar_result["UF_NEWS"];
    }
    $listsection[]=$arSection["ID"];
}
?>