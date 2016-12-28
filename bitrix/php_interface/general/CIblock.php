<?php

AddEventHandler("iblock", "OnAfterIBlockElementUpdate", array("CExIblock", "OnAfterIBlockElementUpdateHandler"));

class CExIblock
{
    
    function OnAfterIBlockElementUpdateHandler($arFields)
    {
        
        //echo $arFields['IBLOCK_ID'] . " - " . defined(CATALOG_IBLOCK_ID) . "\n";
        // ��������� ���������, ��� �������� ��� �������� �������
        if ($arFields['IBLOCK_ID'] == 4)
        {
            $_SESSION['BX_CML2_IMPORT']['ELEMENTS_CATALOG_UPDATE'][] = $arFields['ID'];
            /*$offers = CIBlockPriceTools::GetOffersArray(array(
                                    'IBLOCK_ID' => $arFields['IBLOCK_ID'],
                                    'HIDE_NOT_AVAILABLE' => 'Y',
                                    //'CHECK_PERMISSIONS' => 'Y'
            ), array($arFields['ID']), null, null, null, null, null, null, array('CURRENCY_ID' => 'RUB'), null, null);

            $arOffers = Array ();
            foreach ($offers as $offer)
            {
                $price = CCatalogProduct::GetOptimalPrice($offer['ID'], 1);
                $arOffers[] = $price['RESULT_PRICE']['DISCOUNT_PRICE'];
            }
            
            echo $arFields['IBLOCK_ID'] . ":" . $arFields['ID'] . "\n";
            print_r($offers);

            sort($arOffers);

            if (is_array($arOffers) && count($arOffers) > 0)
            {
                $arProps = Array (
                    'MINIMUM_PRICE' => $arOffers[0],
                    'MAXIMUM_PRICE' => end($arOffers)
                );

                // �������� ������ ����
                $rsNeedProps = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields['ID'], array("sort" => "asc"), Array("CODE"=> Array ("PRICE_OLD", "SALE") ));
                while ($arNeedProp = $rsNeedProps->fetch())
                        $arNeedProps[$arNeedProp['CODE']] = $arNeedProp;

                if ($arNeedProps['PRICE_OLD'] && !empty($arNeedProps['PRICE_OLD']['VALUE']))
                {
                    // ����� ����� �� ����� - ������ ���� �������, �������� ��������� - ���� ���� 
                    if (floatval($arNeedProps['PRICE_OLD']['VALUE']) > $arProps['MINIMUM_PRICE']
                        && $arNeedProps['SALE']['VALUE'] == '')
                    {
                        // ������ ����������
                        $arProps['SALE'] == 'Y';
                        $arProps['PRICE_OLD'] = $arProps['MINIMUM_PRICE'];
                    }
                    elseif (floatval($arNeedProps['PRICE_OLD']['VALUE']) < $arProps['MINIMUM_PRICE']
                            && $arNeedProps['SALE']['VALUE'] == 'Y'
                    )
                    {
                        // ��������� ���������� � ������� �������
                        $arProps['SALE'] == '';
                        $arProps['PRICE_OLD'] = $arProps['MINIMUM_PRICE'];
                    }
                }
                else
                {
                    $arProps['PRICE_OLD'] = $arProps['MINIMUM_PRICE'];
                }

                CIBlockElement::SetPropertyValuesEx($arFields['ID'], $arFields['IBLOCK_ID'], $arProps);
            }*/
        }
    }
    
    function DoIBlockBeforeSave($arFields) {
        if ($arFields["IBLOCK_ID"] == COMMENTS_IBLOCK_ID) {
            if (CheckURL($arFields["DETAIL_TEXT"])) {
                global $APPLICATION;
                $APPLICATION->throwException("��������� ��������� ������ � �����������");
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
                if ($item["DESCRIPTION"] == "����") {
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
                if ($item["DESCRIPTION"] == "������") {
                    CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $item["VALUE"], "SIZE");
                }
            }
        }
    }
}

AddEventHandler("iblock", "OnBeforeIBlockElementAdd", Array ("CExIblock", "DoIBlockBeforeSave"));
AddEventHandler("iblock", "OnAfterIBlockSectionAdd", array("CExIblock", "OnAfterIBlockSectionAddHandler"));
AddEventHandler("iblock", "OnAfterIBlockSectionUpdate", array("CExIblock", "OnAfterIBlockSectionUpdateHandler"));
AddEventHandler("iblock", "OnAfterIBlockElementAdd", array("CExIblock", "OnAfterIBlockElementUpdateHandler2")); // �������� �� ���������� ���������, ���� ����� � ���� �������
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", array("CExIblock", "OnAfterIBlockElementUpdateHandler2")); // �������� �� ���������� ���������, ���� ����� � ���� �������

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




