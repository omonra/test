<?php
/**
 * Created by PhpStorm.
 * User: Àëåêñåé
 * Date: 07.06.2016
 * Time: 3:09
 */

class PControl
{
    /**
     * ÔÓÍÊÖÈß ÏÎËÓ×ÅÍÈß ÎÑÒÀÒÊÎÂ ÏÐÅÄËÎÆÅÍÈß ÏÎ XML_ID ÒÎÂÀÐÀ
     * @param $XML_ID
     * @return mixed
     */
    public static function GetQuantityByXmlID($XML_ID, $UpdateActive = false, $disabled_cache = false)
    {
        $response = "Íåò â íàëè÷èè";
        
        if (!$disabled_cache)
        {
            $cache = new CPHPCache();
            $cache_time = 120;
            $cache_id = $XML_ID;
            $cache_path = '/GetQuantityByXmlID/';
            if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path))
            {
                $res = $cache->GetVars();
                if (is_array($res))
                    return $res;
            }
        }
        
        
        $arParams["GoodsUid"] = $XML_ID;
        try
        {
            $client = new SoapClient(URL_1C);
            
            $arRes["COUNT"] = 0;
            $arCountOffers = array();
            $arOfferInfo = array();
            $response = get_object_vars($client->GetQuantity($arParams)->return);
            $response["Goods"] = get_object_vars($response["Goods"]);

            // ÑÏÈÑÎÊ ÈÑÊËÞ×ÀÅÌÛÕ ÑÊËÀÄÎÂ
            $arLockedSklad = array(
                "0d667641-21ec-11e3-b5ad-e0b9a56800b3",
                "4a859516-7411-11e1-baa3-002454a8ccdc",
                "64909b68-21e7-11e3-8032-e0b9a56800b3",
                "458af3fa-97af-11da-862a-0014851f9f28",
                "4e1c1e26-e4cb-11e4-a1e3-000c29270397"
            );
            
            $arStoresInclude = Array (
                "0d667646-21ec-11e3-b5ad-e0b9a56800b3", //Ñåâåðíûå Âîðîòà
                "f4768549-fa22-11e5-b06f-001e678b46f8", //Ôîêóñ
                "24e8b501-2970-11de-afe0-00e04d085d2b", //ÑÒÎËÜÍÈÊ - 5 (×ÒÇ)
                "95d96f18-11a6-11e1-ac3c-001e101f2500", //ABC(Ôèåñòà)
                "658230f9-5445-11e0-a550-002454a8ccdc", //Ñòîê 6 (ÁÊ)
                "76421a5c-4197-11e1-a06c-001e101f82a7", //Ñòîê(Ôèåñòà)
                "406776e9-835d-11db-877d-0014851f9f28", //ABC 2
                //"406776e6-835d-11db-877d-0014851f9f28", //ABC 1
                "3090dde5-5380-11db-85fe-00142a963ee2", //×ÌÇ ÑÒÎÊ
                
            );

            foreach($response["Goods"]["Properties"] as $oneOffer)
            {
                $oneOffer = get_object_vars($oneOffer);
                $offerID = self::GetID($oneOffer["UID"]);
                $count = 0;
                $fastDeliveryGlobal = "N";

                // ÅÑËÈ ÒÎËÜÊÎ 1 ÑÊËÀÄ
                if(is_object($oneOffer["Balances"]))
                {
                    $oneOffer["Balances"] = array(
                        $oneOffer["Balances"]
                    );
                }

                foreach($oneOffer["Balances"] as $oneSklad)
                {
                    $oneSklad = get_object_vars($oneSklad);

                    // ÈÑÊËÞ×ÅÍÈß ÏÎÄÑ×ÅÒÊÀ ÊÎËÈ×ÅÑÒÂÀ ÏÎ ÍÅÊÎÒÎÐÛÌ ÑÊËÀÄÀÌ
                    /*if(!in_array($oneSklad["UID"], $arLockedSklad))
                    {
                        $count = $count + $oneSklad["Quatity"];
                    }*/
                    
                    if(!in_array($oneSklad["UID"], $arStoresInclude))
                            continue;
                    
                    //if(in_array($oneSklad["UID"], $arStoresInclude))
                    //{
                        $count = $count + $oneSklad["Quatity"];
                    //}

                    // ÈÍÔÎÌÐÀÖÈß ÏÎ ÑÊËÀÄÀÌ
                    $fastDelivery = "N";
                    if($oneSklad["UID"] == "0d667646-21ec-11e3-b5ad-e0b9a56800b3" || $oneSklad["UID"] == "406776e9-835d-11db-877d-0014851f9f28")
                    {
                        $fastDelivery = "Y";
                        $fastDeliveryGlobal = "Y";
                    }
                    $arOfferInfo[$offerID]["SKLAD"][$oneSklad["UID"]] = array(
                        "NAME" => iconv("UTF-8", "CP1251", $oneSklad["Shop"]),
                        "QUANTITY" => $oneSklad["Quatity"],
                        "FAST_DELIVERY" => $fastDelivery
                    );
                    $arOfferInfo[$offerID]["FAST_DELIVERY"] = $fastDeliveryGlobal;
                }
                $arOfferInfo[$offerID]["NAME"] = iconv("UTF-8", "CP1251", $oneOffer["Name"]);
                $arCountOffers[$offerID] = $count;
                $arRes["COUNT"] = $arRes["COUNT"] + $count;
            }

            //if($arRes["COUNT"] <= 0)
                //self::DeactivatedByXmlID($XML_ID);
            if($arRes["COUNT"] < "9999999999"){
                $arRes["COUNT"] = $arRes["COUNT"]." øò.";
            }

            $arRes['PRODUCT_ID'] = self::GetID($XML_ID);
            $arRes["OFFERS_COUNT"] = $arCountOffers;
            $arRes["OFFERS_INFO"] = $arOfferInfo;
            
            if ($UpdateActive)
                self::UpdateActiveElement ($arRes);
            
            if (!$disabled_cache)
            {
                $cache->StartDataCache($cache_time, $cache_id, $cache_path);
                $cache->EndDataCache($arRes);
            }
            
        }
        catch(Exception $e)
        {
            return false;
            //$arRes["COUNT"] =  "<span style='color: red;'>".$e->getMessage()."</span>";
        }
        return $arRes;
    }

    /**
     * ÔÓÍÊÖÈß ÏÎËÓ×ÅÍÈß XML_ID ÏÎ ID ÒÎÂÀÐÀ È ÏÐÅÄËÎÆÅÍÈß
     * @param $ID
     * @return bool
     */
    public static function GetXmlID($ID)
    {
        global $DB;
        $dbRes = $DB->Query("select XML_ID from b_iblock_element where ID = ".$ID . " LIMIT 1");
        if($arRes = $dbRes->Fetch())
        {
            return $arRes["XML_ID"];
        }
        return false;
    }

    /**
     * ÔÓÍÊÖÈß ÏÎËÓ×ÅÍÈ ID ÏÐÅÄËÎÆÅÍÈß ÏÎ ÅÃÎ XML_ID
     * @param $XML_ID
     * @return bool
     */
    public static function GetID($XML_ID)
    {
        global $DB;
        $dbRes = $DB->Query("select ID from b_iblock_element where XML_ID LIKE '%".$XML_ID."' LIMIT 1");
        if($arRes = $dbRes->Fetch())
        {
            return $arRes["ID"];
        }
        return false;
    }

    /**
     * ÔÓÍÊÖÈß ÏÎËÓ×ÅÍÈß ID ÏÐÎÄÓÊÒÀ ÏÎ ÅÃÎ XML_ID
     * @param $XML_ID
     * @return bool
     */
    public static function GetProductID($XML_ID)
    {
        global $DB;
        $dbRes = $DB->Query("select ID from b_iblock_element where XML_ID = '".$XML_ID."'");
        if($arRes = $dbRes->Fetch())
        {
            return $arRes["ID"];
        }
        return false;
    }

    /**
     * ÔÓÍÊÖÈß ÄÅÀÊÒÈÂÀÖÈÈ ÏÎ XML_ID
     * @param $XML_ID
     */
    public static function DeactivatedByXmlID($XML_ID)
    {
        global $DB;
        $ID = self::GetProductID($XML_ID);
        if($ID > 0)
        {
            //$DB->Query("update b_iblock_element set ACTIVE = 'N' where ID = ".$ID);
        }
    }
    
    public static function UpdateActiveElement($arResult)
    {
        global $DB;
        $el = new CIBlockElement;
        
        if (isset($arResult['PRODUCT_ID']))
        {
            $arOffers = CCatalogSKU::getOffersList(Array ($arResult['PRODUCT_ID']), CATALOG_IBLOCK_ID);
            if (is_array($arOffers[$arResult['PRODUCT_ID']]))
            {
                foreach ($arOffers[$arResult['PRODUCT_ID']] as $offer_id => $offer)
                {
                    // Ïî óìîë÷àíèþ, âñå òîðãîâûå ïðåäëîæåíèÿ íå àêòèâíû
                    //$DB->Query("update b_iblock_element set ACTIVE = 'N' where ID = ".$offer_id);
                    $el->Update($offer_id, Array('ACTIVE' => 'N'));
                }
            }

            foreach ($arResult['OFFERS_INFO'] as $product_id => $arStores)
            {
                if (!empty($product_id) && is_numeric($product_id))
                {
                    // Óäàëÿåì âñå çàïèñè î îñòàòêàõ
                    $rsStoreList = CCatalogStoreProduct::GetList(array(), array('PRODUCT_ID' => $product_id), false, false, array('ID')); 
                    while ($arStoreList = $rsStoreList->fetch())
                            CCatalogStoreProduct::Delete($arStoreList['ID']);
                    
                    if (is_array($arStores['SKLAD']))
                    {
                        foreach ($arStores['SKLAD'] as $store_xml_id => $arStore)
                        {
                            if (intval($arStore['QUANTITY']) > 0)
                            {
                                $arFields = Array (
                                    'PRODUCT_ID' => $product_id,
                                    'STORE_ID' => $GLOBALS['arStores'][$store_xml_id],
                                    'AMOUNT' => (intval($arStore['QUANTITY']) > 0) ? intval($arStore['QUANTITY']) : 0
                                );
                                $resultUpdate = CCatalogStoreProduct::UpdateFromForm($arFields);
                                $el->Update($product_id, Array('ACTIVE' => 'Y'));
                                //$DB->Query("update b_iblock_element set ACTIVE = 'Y' where ID = ".$product_id);
                            }
                            //exit();
                        }
                    }

                }
            }
            
            /*if (intval($arResult['COUNT']) > 0)
                $DB->Query("update b_iblock_element set ACTIVE = 'Y' where ID = ".$arResult['PRODUCT_ID']);
            else
                $DB->Query("update b_iblock_element set ACTIVE = 'N' where ID = ".$arResult['PRODUCT_ID']);*/
        }
    }
}