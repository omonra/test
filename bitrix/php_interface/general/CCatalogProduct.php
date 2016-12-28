<?php

if(class_exists("CCatalogProductProvider"))
{

    class CCatalogProductProviderStolnik extends CCatalogProductProvider
    {
        
        public static function GetDiscountProducts($userid)
        {
            $arIDs = Array ();
            $dbBasketItems = CSaleBasket::GetList(
                        array(
                                "PRICE" => "ASC",
                            ),
                        array(
                                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                                "LID" => SITE_ID,
                                "ORDER_ID" => "NULL"
                            ),
                        false,
                        false,
                        array("ID", "MODULE", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY", "PRICE")
             );
            //if ($_REQUEST['blackfriday'] == "y")
            //{
                $arItems = Array ();
                while ($arItem = $dbBasketItems->Fetch())
                {
                    $arItems[] = $arItem;
                    /*echo "<pre>";
                    print_r($arItems);
                    echo "</pre>";*/
                }
                
                
                if (count($arItems) >= 2)
                {
                    $qty = round(count($arItems) / 2, 0, PHP_ROUND_HALF_DOWN);
                    $count = 0;
                    
                    foreach ($arItems as $row)
                    {
                        if ($count >= $qty)
                            break;
                        
                        $arIDs[] = $row['PRODUCT_ID'];
                        $count++;
                    }
                    
                }
            //}
            
            return $arIDs;
        }
        
        public static function GetProductData($arParams)
        {
            global $USER;
            
            $arResult = parent::GetProductData($arParams);
            // <-- BlackFriday
            $ids = self::GetDiscountProducts($arParams['USER_ID']);
            //print_r($ids);
            //echo $arParams['PRODUCT_ID'];
            //echo "<br>";
            $startDate = mktime(0,0,0,11,25,2016);
            
            $endDate = mktime(23,59,59,11,27,2016);
            
            if (time() >= $startDate && time() <= $endDate)
            {
                
                if (in_array($arParams['PRODUCT_ID'], $ids))
                    $arResult['BASE_PRICE'] = $arResult['BASE_PRICE'] / 2;
            
                
            }
            // BalckFriday -->
            return $arResult;
        }
        
        public static function OrderProduct($arParams)
        {
            return CCatalogProductProviderStolnik::GetProductData($arParams);
        }

        public static function ReserveProduct($arParams) {
            //error_log( sprintf("arResult=%s, arParams=%s", print_r($arResult, true), print_r($arParams, true) ) , 3, '/var/www/tstsite/logs/init.log' );
            if ($arParams['UNDO_RESERVATION'] == 'Y') {
                $arResult = array(
                    'RESULT' => true,
                    'QUANTITY_RESERVED' => -$arParams['QUANTITY_ADD']
                );
            }
            else {
                $arResult = CCatalogProductProvider::ReserveProduct($arParams);
            }
            return $arResult;
        }

        
    }
}