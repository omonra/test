<?php

AddEventHandler("catalog", "OnSuccessCatalogImport1C", array("CExCatalogImport", "OnSuccessCatalogImport1CHandler"));

class CExCatalogImport
{
    
    static function Import1CResult($type = 'progress', $msg)
    {
        if ($type == 'progress')
                {
                    echo "progress\n";
                    echo $msg;
                }
                else
                {
                    echo "failure\n" . $msg;
                }

                $contents = ob_get_contents();
                ob_end_clean();

                if (toUpper(LANG_CHARSET) != "WINDOWS-1251") {
                    $contents = $GLOBALS['APPLICATION']->ConvertCharset($contents, LANG_CHARSET, "windows-1251");
                }

                header("Content-Type: text/html; charset=windows-1251");
                print $contents;
                exit;
    }
    
    function OnSuccessCatalogImport1CHandler()
    {
        CModule::IncludeModule("catalog");
        //echo "OnSuccessCatalogImport1CHandler\n";
        if (is_array($_SESSION['BX_CML2_IMPORT']['ELEMENTS_CATALOG_UPDATE']))
        {
            foreach ($_SESSION['BX_CML2_IMPORT']['ELEMENTS_CATALOG_UPDATE'] as $id)
            {
                $offers = CIBlockPriceTools::GetOffersArray(array(
                                        'IBLOCK_ID' => CATALOG_IBLOCK_ID,
                                        'HIDE_NOT_AVAILABLE' => 'Y',
                                        //'CHECK_PERMISSIONS' => 'Y'
                ), array($id), null, null, null, null, null, null, array('CURRENCY_ID' => 'RUB'), null, null);

                $arOffers = Array ();
                foreach ($offers as $offer)
                {
                    $price = CCatalogProduct::GetOptimalPrice($offer['ID'], 1);
                    $arOffers[] = $price['RESULT_PRICE']['DISCOUNT_PRICE'];
                }

                
                print_r($offers);

                sort($arOffers);

                if (is_array($arOffers) && count($arOffers) > 0)
                {
                    $arProps = Array (
                        'MINIMUM_PRICE' => $arOffers[0],
                        'MAXIMUM_PRICE' => end($arOffers)
                    );

                    // Получаем старую цену
                    $rsNeedProps = CIBlockElement::GetProperty(CATALOG_IBLOCK_ID, $id, array("sort" => "asc"), Array("CODE"=> Array ("PRICE_OLD", "SALE") ));
                    while ($arNeedProp = $rsNeedProps->fetch())
                            $arNeedProps[$arNeedProp['CODE']] = $arNeedProp;

                    if ($arNeedProps['PRICE_OLD'] && !empty($arNeedProps['PRICE_OLD']['VALUE']))
                    {
                        // Товар точно не новый - старая цена указана, проводим сравнение - если есть 
                        if (floatval($arNeedProps['PRICE_OLD']['VALUE']) > floatval($arProps['MINIMUM_PRICE'])
                            && $arNeedProps['SALE']['VALUE'] == '')
                        {
                            // Ставим распродажу
                            $arProps['SALE'] = 'Y';
                            $arProps['PRICE_OLD'] = $arProps['MINIMUM_PRICE'];
                        }
                        elseif (floatval($arNeedProps['PRICE_OLD']['VALUE']) < floatval($arProps['MINIMUM_PRICE'])
                                && $arNeedProps['SALE']['VALUE'] == 'Y'
                        )
                        {
                            // Произошла переоценка в большую сторону
                            $arProps['SALE'] = '';
                            $arProps['PRICE_OLD'] = $arProps['MINIMUM_PRICE'];
                        }
                    }
                    else
                    {
                        $arProps['PRICE_OLD'] = $arProps['MINIMUM_PRICE'];
                    }

                    CIBlockElement::SetPropertyValuesEx($id, $arFields['IBLOCK_ID'], $arProps);
                }
            }
        }
    }
    
    /*function OnSuccessCatalogImport1CHandler()
    {
        CModule::IncludeModule("catalog");
        CModule::IncludeModule("iblock");
        
        $stepInterval = (int) COption::GetOptionString("catalog", "1C_INTERVAL", "-");
        $errorMessage = null;
        
        // запускаем эти обработки только после загрузки последнего *.xml файла
        $arFiles = glob($_SERVER["DOCUMENT_ROOT"] . '/upload/1c_catalog/*.xml');
        if (!is_array($arFiles) || count($arFiles) <= 0) {
            return;
        }
        $lastFileName = substr(strrchr(array_pop($arFiles), '/'), 1);
        if ($_REQUEST['filename'] != $lastFileName) {
            return;
        }
        
        $startTime = time();
        // Флаг импорта файла торговых предложений
        $isOffers = strpos($_REQUEST['filename'], 'offers') !== false;
        $NS = &$_SESSION["BX_CML2_IMPORT"]["NS"];

        if (!isset($NS['custom']['lastId'])) {
            // Последний отработанный элемент для пошаговости.
            $NS['custom']['lastId'] = 0;
            $NS['custom']['counter'] = 0;
            $NS['custom']['action'] = "action1";
        }

        $iblockID = $NS['IBLOCK_ID'];
        
        $el = new CIBlockElement;
        $arOffers = GetOffersSettings(CATALOG_IBLOCK_ID);
            
        switch($NS['custom']['action'])
        {
            case 'action1':
            default:    
                // деактивируем торговые предложения с нулевой ценой или без цвета и размера
                $dbElement = CIBlockElement::GetList(
                    array(),
                    array(
                        'IBLOCK_ID'=> CATALOG_OFFERS_IBLOCK_ID,
                        'ACTIVE' => 'Y',
                        '>ID' => $NS['custom']['lastId'],
                        /*array(
                            'LOGIC' => 'OR',
                            //'CATALOG_QUANTITY' => 0,
                            'CATALOG_PRICE_' . GetPriceId() => 0,
                            array(
                                'LOGIC' => 'AND',
                                'PROPERTY_COLOR' => false,
                                'PROPERTY_SIZE' => false,
                            )
                        ),

                    ),
                    false,
                    false,
                    array('ID')
                );
                while ($arElement = $dbElement->Fetch())
                {
                    CIBlockElement::SetPropertyValuesEx(
                        $arElement['ID'],
                        $arElement['IBLOCK_ID'],
                        array(
                            "MINIMUM_PRICE" => '444',
                            "MAXIMUM_PRICE" => '555',
                        )
                    );
                    // MINIMUM_PRICE, MAXIMUM_PRICE
                    if ($stepInterval > 0 && (time() - $startTime) > $stepInterval)
                    {
                        CExCatalogImport::Import1CResult("progress", "CExCatalogImport: Обработано " . $NS['custom']['counter'] . ' элементов, определяем минимальную и максимальную цену');
                    }
                    
                    //$el->Update($arElement['ID'], array('ACTIVE' => 'N'), false, false);
                    
                    $NS['custom']['lastId'] = $arElement['ID'];
                    $NS['custom']['action'] = "action1";
                    $NS['custom']['counter']++;
                }
                
                $NS['custom']['action'] = "finish";
                //die('asdasd');
                break;
                
             
        }
               
            if ($NS['custom']['action'] != "finish")
            {
                if ($errorMessage === null)
                    CExCatalogImport::Import1CResult('progress', "CExCatalogImport: Обработано " . $NS['custom']['counter'] . ' элементов');
                else
                    CExCatalogImport::Import1CResult('failure', $errorMessage);

            }
    }*/
}