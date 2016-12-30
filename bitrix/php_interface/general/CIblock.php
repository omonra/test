<?php

AddEventHandler("iblock", "OnAfterIBlockElementUpdate", array("CExIblock", "OnAfterIBlockElementUpdateHandler"));

class CExIblock
{
    
    function OnAfterIBlockElementUpdateHandler($arFields)
    {
        
        // Костыльно проверяем, что инфоблок это основной каталог
        if ($arFields['IBLOCK_ID'] == 4)
        {
            $_SESSION['BX_CML2_IMPORT']['ELEMENTS_CATALOG_UPDATE'][] = $arFields['ID'];
            
        }
    }
    
    function DoIBlockBeforeSave($arFields) {
        if ($arFields["IBLOCK_ID"] == COMMENTS_IBLOCK_ID) {
            if (CheckURL($arFields["DETAIL_TEXT"])) {
                global $APPLICATION;
                $APPLICATION->throwException("Запрещено вставлять ссылки в комментарий");
                return false;
            }
        }
    }
    
    function OnAfterIBlockSectionAddHandler(&$arFields){
        $res = CIBlockSection::GetByID($arFields["ID"]);
        if($ar_res = $res->GetNext()){
            if($arFields["IBLOCK_SECTION_ID"]==284){
                //men
                if(!(strpos($arFields["CODE"],'_men')>0)){
                    $bs = new CIBlockSection;
                    $bs->Update($arFields["ID"], array("CODE"=>$arFields["CODE"].'_men'));
                }
            }
            if($arFields["IBLOCK_SECTION_ID"]==314){
                //women
                if(!(strpos($arFields["CODE"],'_women')>0)){
                    $bs = new CIBlockSection;
                    $bs->Update($arFields["ID"], array("CODE"=>$arFields["CODE"].'_women'));
                }
            }
        }
    }

    function OnAfterIBlockSectionUpdateHandler2(&$arFields)
    {
        $res = CIBlockSection::GetByID($arFields["ID"]);
        if($ar_res = $res->GetNext()){
            if($arFields["IBLOCK_SECTION_ID"]==284){
                //men
                if(!(strpos($arFields["CODE"],'_men')>0)){
                    $bs = new CIBlockSection;
                    $bs->Update($arFields["ID"], array("CODE"=>$arFields["CODE"].'_men'));
                }
            }
            if($arFields["IBLOCK_SECTION_ID"]==314){
                //women
                if(!(strpos($arFields["CODE"],'_women')>0)){
                    $bs = new CIBlockSection;
                    $bs->Update($arFields["ID"], array("CODE"=>$arFields["CODE"].'_women'));
                }
            }
        }
    }
    
    function OnAfterIBlockElementUpdateHandler2(&$arFields)
    {
        if ($arFields["IBLOCK_ID"] == CATALOG_OFFERS_IBLOCK_ID) {
            $VALUES = array();
            $res = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields["ID"], "sort", "asc", array("CODE" => "CML2_ATTRIBUTES"));
            while ($ob = $res->GetNext()) {
                $VALUES[] = $ob;
            }
            foreach ($VALUES as $item) {
                if ($item["DESCRIPTION"] == "Цвет") {
                    CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $item["VALUE"], "COLOR");
                    $arFilter = array(
                        "IBLOCK_ID" => 10,
                        "ACTIVE" => "Y",
                        array(
                            "LOGIC" => "OR",
                            "NAME" => $item["VALUE"],
                            "PROPERTY_ITEM_COLOR_LIST" => $item["VALUE"],
                        ),
                    );
                    $res = CIBlockElement::GetList(array(), $arFilter);
                    if ($ar_fields = $res->GetNext()) {
                        CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $ar_fields["NAME"], "item_color_list");
                    }
                }
                if ($item["DESCRIPTION"] == "Размер") {
                    CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $item["VALUE"], "SIZE");
                }
            }
        }
    }
}

AddEventHandler("iblock", "OnBeforeIBlockElementAdd", Array ("CExIblock", "DoIBlockBeforeSave"));
AddEventHandler("iblock", "OnAfterIBlockSectionAdd", array("CExIblock", "OnAfterIBlockSectionAddHandler"));
AddEventHandler("iblock", "OnAfterIBlockSectionUpdate", array("CExIblock", "OnAfterIBlockSectionUpdateHandler"));
AddEventHandler("iblock", "OnAfterIBlockElementAdd", array("CExIblock", "OnAfterIBlockElementUpdateHandler2")); // осталось от предыдущих рукожопов, надо слить в одну функцию
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", array("CExIblock", "OnAfterIBlockElementUpdateHandler2")); // осталось от предыдущих рукожопов, надо слить в одну функцию

class CExIblockCatalog
{
    function DoStoreSave2($arg,$arg2) {
        if(CModule::IncludeModule("sale")){
            $buffer = 0;
            $buffer = array();
            if (is_array($arg2)) {
                $store_res = CCatalogStoreProduct::GetList(array(), array("PRODUCT_ID" => $arg2['PRODUCT_ID']));
                while ($arStoreRes = $store_res->GetNext()) {
                    $buffer[] = $arStoreRes['AMOUNT'];
                }
                $tmp = 0;
                foreach ($buffer as $val) {
                    $tmp += $val;
                }
                $arFields = array(
                    "QUANTITY" => $tmp
                );
                CCatalogProduct::Update($arg2['PRODUCT_ID'], $arFields);
            }
        }
    }
}

AddEventHandler("catalog", "OnStoreProductAdd", Array ("CExIblockCatalog", "DoStoreSave2"));
AddEventHandler("catalog", "OnStoreProductUpdate", Array ("CExIblockCatalog", "DoStoreSave2"));




