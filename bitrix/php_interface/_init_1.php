<?
if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/local_settings.php')) {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/local_settings.php');
}

if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/functions.php')) {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/functions.php');
}

if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/specialcond.php')) {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/specialcond.php');
}

require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/classes/CExFunctions.php');

/*if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/include/import1c.php')) {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/include/import1c.php');
}*/

define('CDEK_WEIGHT', 3000);
define('CDEK_FREE_PRICE', 5000);


define('SPECIAL_IBLOCK_ID', 62);

define('CATALOG_IBLOCK_ID', 4);
define('CATALOG_OFFERS_IBLOCK_ID', 5);
define('URL_1C', 'http://83.142.166.84/torgovlya/ws/Quantity?wsdl');

define('BANNERS_IBLOCK_ID', 6);
define('ARTICLES_IBLOCK_ID', 7);
define('COLORS_IBLOCK_ID', 10);
define('COMMENTS_IBLOCK_ID', 11);
define('SIZES_IBLOCK_ID', 13);
define('NEWS_IBLOCK_ID', 19);
define('ADVANTAGES_IBLOCK_ID', 54);

define('SMSLOG_HLBLOCK_ID', 1);

define('RUSSIANPOST_DELIVERY_ID', 7);

define('CATALOG_SECTION_NOPHOTO_FILE_ID', 965037); // TODO: change to real file id
define('CATALOG_SECTION_PICTURE_WIDTH', 220);
define('CATALOG_SECTION_PICTURE_HEIGHT', 276);
define('CATALOG_DETAIL_PICTURE_WIDTH', 300);
define('CATALOG_DETAIL_PICTURE_HEIGHT', 385);
// define('CATALOG_DETAIL_SMALL_PICTURE_WIDTH', 42);
// define('CATALOG_DETAIL_SMALL_PICTURE_HEIGHT', 52);
define('CATALOG_DETAIL_BIG_PICTURE_WIDTH', 1000);
define('CATALOG_DETAIL_BIG_PICTURE_HEIGHT', 800);
define('CATALOG_RECOMMENDED_PRODUCTS_PICTURE_WIDTH', 140);
define('CATALOG_RECOMMENDED_PRODUCTS_PICTURE_HEIGHT', 175);
define('CATALOG_VIEWED_PRODUCTS_PICTURE_WIDTH', 220);
define('CATALOG_VIEWED_PRODUCTS_PICTURE_HEIGHT', 276);
define('BASKET_PICTURE_WIDTH', 60);
define('BASKET_PICTURE_HEIGHT', 88);
define('CATALOG_SECTIONS_PICTURE_WIDTH', 298);
define('CATALOG_SECTIONS_PICTURE_HEIGHT', 438);

define('ACTION_ENABLED_ORDER_PROP_ID', 30);

define('CONTENT_MANAGERS_GROUP_ID', 11);



CModule::AddAutoloadClasses (
    '', // не указываем имя модуля
    array(
        "USubscribe" => "/bitrix/php_interface/classes/USubscribe.php",                             // Инструменты по работе с Подписками
        "UTools" => "/bitrix/php_interface/classes/UTools.php",                                     // Инструменты по работе с Пользователями
        "PControl" => "/bitrix/php_interface/classes/ProductControl.php",                           // Инструменты по работе с Товарами
    )
);



function GetCurBasketItems($fromOrder = false, $user_id = false) {

    if($fromOrder)
        $order_id = $fromOrder;
    else
        $order_id = NULL;



    CModule::IncludeModule('sale');
    $arBasketItems = array();

    $arFilt = array(

                    "ORDER_ID" => $order_id
            );

    if(!$order_id)
        $arFilt["FUSER_ID"] = CSaleBasket::GetBasketUserID();


    $dbBasketItems = CSaleBasket::GetList(
            array(
                    "NAME" => "ASC",
                    "ID" => "ASC"
            ),
            $arFilt,
            false,
            false,
            array()
    );
    while ($arItems = $dbBasketItems->Fetch())
    {
        $arBasketItems[$arItems['ID']] = $arItems;
    }

    return $arBasketItems;
}


// include_once('ak/ak_discount.php');

////

function pre($array) {
    dd($array);
}
function wdebug($what) {
    df($what);
}
function wdebugAr($what) {
    df($what);
}
function wdebugClear() {}







/*Version 0.3 2011-04-25*/


function CheckURL($check)
{
    if (!$check) return false;
    if (strpos($check, "href=")!==false):
        return true;
    elseif (strpos($check, "<a")!==false):
        return true;
    else:
        return false;
    endif;
}









function convertDate($date) {
    $components = explode (" ", $date, 2);
    $monthes = array(
        'января',
        'февраля',
        'марта',
        'апреля',
        'мая',
        'июня',
        'июля',
        'августа',
        'сентября',
        'октября',
        'ноября',
        'декабря'
    );
    $date = explode ('.', $components[0], 3);
    return ($date[0]." ".$monthes[((int)($date[1])-1)]." ".$date[2]);
}


AddEventHandler("iblock", "OnAfterIBlockElementUpdate", array("Handlers", "OnAfterIBlockElementUpdate"));
AddEventHandler("iblock", "OnBeforeIBlockElementDelete", array("Handlers", "OnBeforeIBlockElementDelete"));

AddEventHandler("sale", "OnSaleStatusOrder", array("Handlers", "OnSaleStatusOrder"));

AddEventHandler("sale", "OnOrderAdd", array("Handlers", "OnOrderAdd"));

//AddEventHandler("catalog", "OnSuccessCatalogImport1C", array("Handlers", "SuccessCatalogImport"));
AddEventHandler("catalog", "OnSuccessCatalogImport1C", array("Handlers", "OnSuccessCatalogImport1CHandler"));

AddEventHandler("iblock", "OnAfterIBlockElementUpdate", array("Handlers", "DoIBlockAfterSave"));
AddEventHandler("iblock", "OnAfterIBlockElementAdd", array("Handlers", "DoIBlockAfterSave"));
AddEventHandler("catalog", "OnPriceAdd", array("Handlers", "DoIBlockAfterSave"));
AddEventHandler("catalog", "OnPriceUpdate", array("Handlers", "DoIBlockAfterSave"));

//AddEventHandler("catalog", "OnGetOptimalPrice", array("Handlers", "OnGetOptimalPrice"));

AddEventHandler("iblock", "OnBeforeIBlockElementAdd", array("Handlers", "OnBeforeIBlockElementAdd"));
AddEventHandler("iblock", "OnBeforeIBlockSectionAdd", array("Handlers", "OnBeforeIBlockSectionAdd"));
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", array("Handlers", "OnBeforeIBlockElementUpdate"));
AddEventHandler("iblock", "OnBeforeIBlockSectionUpdate", array("Handlers", "OnBeforeIBlockSectionUpdate"));

AddEventHandler("sale", "OnSaleComponentOrderOneStepProcess", array("Handlers", "OnSaleComponentOrderOneStepProcess"));

class Handlers {
    private static $catalogImport = false;

    function OnAfterIBlockElementUpdate(&$arFields) {
        if ($arFields['IBLOCK_ID'] == COMMENTS_IBLOCK_ID) {
            $elementId = 0;
            if (!isset($arFields['PROPERTY_VALUES'])) {
                $rsFields = CIBlockElement::GetList(array(), array(
                    'IBLOCK_ID' => $arFields['IBLOCK_ID'],
                    'ID' => $arFields['ID'],
                ), false, array('nTopCount' => 1), array('ID', 'PROPERTY_PRODUCT_ID'));
                if ($arFields = $rsFields->GetNext()) {
                    $elementId = $arFields['PROPERTY_PRODUCT_ID_VALUE'];
                }
            } else {
                $propId = GetPropertyId($arFields['IBLOCK_ID'], 'PRODUCT_ID');
                $keys = array_keys($arFields['PROPERTY_VALUES'][$propId]);
                $elementId = $arFields['PROPERTY_VALUES'][$propId][$keys[0]]['VALUE'];
            }
            if ($elementId > 0) {
                UpdateCommentsCount($elementId);
            }
        } elseif ($arFields['IBLOCK_ID'] == BANNERS_IBLOCK_ID) {
            $propId = GetPropertyId($arFields['IBLOCK_ID'], 'TYPE');
            $siteId = 's1';
            foreach ($arFields['PROPERTY_VALUES'][$propId] as $key => $val) {
                $rsEnum = CIBlockPropertyEnum::GetList(array("SORT"=>"ASC", "VALUE"=>"ASC"), array(
                    'CODE' => 'TYPE',
                    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                    'ID' => $val,
                ));

                if ($arEnum = $rsEnum->Fetch()) {
                    BXClearCache(true, '/' . $siteId . '/dx/banner/'.$arEnum['XML_ID']);
                    BXClearCache(true, '/' . $siteId . '/dx/banners/'.$arEnum['XML_ID']);
                }
            }
        }
    }

    function OnBeforeIBlockElementDelete($id) {
        $rsFields = CIBlockElement::GetList(array(), array(
            'IBLOCK_ID' =>  COMMENTS_IBLOCK_ID,
            'ID' => $id,
        ), false, array('nTopCount' => 1), array('ID', 'PROPERTY_PRODUCT_ID'));
        if ($arFields = $rsFields->GetNext()) {
            UpdateCommentsCount($arFields['PROPERTY_PRODUCT_ID_VALUE'], $id);
        }
    }

    function OnSaleStatusOrder($orderId, $status) {
        if ($orderId <= 0) {
            return;
        }
        OrderStatusHandler($orderId);
    }

    function OnOrderAdd($orderId, $arFields) {
        if ($orderId <= 0) {
            return;
        }
        OrderStatusHandler($orderId);
    }
    
    // gleb@nextype <!--
    
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
                        array(
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
                    if ($stepInterval > 0 && (time() - $startTime) > $stepInterval)
                    {
                        Handlers::Import1CResult("progress", "Обработано " . $NS['custom']['counter'] . ' элементов, деактивируем торговые предложения с нулевой ценой или без цвета и размера');
                    }
                    
                    $el->Update($arElement['ID'], array('ACTIVE' => 'N'), false, false);
                    
                    $NS['custom']['lastId'] = $arElement['ID'];
                    $NS['custom']['action'] = "action1";
                    $NS['custom']['counter']++;
                }
                
                $NS['custom']['action'] = "action2";
                
                break;
                
             case 'action2':
                 
                 // активируем торговые предложения с положительной ценой и не пустыми цветом и размером
                $dbElement = CIBlockElement::GetList(
                    array(),
                    array(
                        'IBLOCK_ID'=> CATALOG_OFFERS_IBLOCK_ID,
                        'ACTIVE' => 'N',
                        '>ID' => $NS['custom']['lastId'],
                        //'>CATALOG_QUANTITY'=>0,
                        '>CATALOG_PRICE_' . GetPriceId()=>0,
                        '!PROPERTY_COLOR' => false,
                        '!PROPERTY_SIZE' => false,
                    ),
                    false,
                    false,
                    array('ID')
                );
                while ($arElement = $dbElement->Fetch())
                {
                    
                    if ($stepInterval > 0 && (time() - $startTime) > $stepInterval)
                    {
                        Handlers::Import1CResult("progress", "Обработано " . $NS['custom']['counter'] . ' элементов, активируем торговые предложения с положительной ценой и не пустыми цветом и размером');                    }
                    
                    $el->Update($arElement['ID'], array('ACTIVE' => 'Y'), false, false);
                    
                    $NS['custom']['lastId'] = $arElement['ID'];
                    $NS['custom']['action'] = "action2";
                    $NS['custom']['counter']++;
                }
                
                $NS['custom']['action'] = "action3";
                 
                 break;
                 
             case 'action3':
                 
                 // деактивируем товары которые не надо "Выгружать на сайт" или без картинок
                    $dbElement = CIBlockElement::GetList(
                        array(),
                        array(
                            'IBLOCK_ID'=>CATALOG_IBLOCK_ID,
                            '>ID' => $NS['custom']['lastId'],
                            'ACTIVE' => 'Y',
                            array(
                                'LOGIC'=>"OR",
                                'PROPERTY_UPLOAD' => 'false',
                                array(
                                    'PREVIEW_PICTURE'=>false,
                                    'DETAIL_PICTURE'=>false,
                                ),
                            ),
                        ),
                        false,
                        false,
                        array('ID')
                    );
                    while ($arElement = $dbElement->Fetch())
                    {
                        if ($stepInterval > 0 && (time() - $startTime) > $stepInterval)
                        {
                            Handlers::Import1CResult("progress", "Обработано " . $NS['custom']['counter'] . ' элементов, деактивируем товары которые не надо "Выгружать на сайт" или без картинок');
                        }
                        
                        $el->Update($arElement['ID'], array('ACTIVE' => 'N'), false, false);
                        
                        $NS['custom']['lastId'] = $arElement['ID'];
                        $NS['custom']['action'] = "action3";
                        $NS['custom']['counter']++;
                    }
                 
                    $NS['custom']['action'] = "action4";
                    
                 break;
                 
            case 'action4':
                // активируем товары с картинками и которые надо "Выгружать на сайт" и у которых есть торговые предложения
                $dbElement = CIBlockElement::GetList(array(),
                    array(
                        'IBLOCK_ID' => CATALOG_IBLOCK_ID,
                        '>ID' => $NS['custom']['lastId'],
                        'ACTIVE' => 'N',
                        array(
                            'LOGIC' => 'OR',
                            array(
                                'LOGIC' => 'AND',
                                array(
                                    'LOGIC' => 'OR',
                                    '!PREVIEW_PICTURE' => false,
                                    '!DETAIL_PICTURE' => false,

                                ),
                                '!PROPERTY_UPLOAD' => 'false',
                            ),
                            array(
                                'LOGIC' => 'AND',
                                'PROPERTY_UPLOAD' => 'true',
                                array(
                                    'LOGIC' => 'OR',
                                    '!PREVIEW_PICTURE' => false,
                                    '!DETAIL_PICTURE' => false,

                                ),

                            ),
                        ),

                    ),
                    false,
                    false,
                    array('ID')
                );
                // активируем товары с активными торговыми предложениями
                $i = 0;
                while ($arElement = $dbElement->Fetch())
                {
                    if ($stepInterval > 0 && (time() - $startTime) > $stepInterval)
                        {
                            Handlers::Import1CResult("progress", "Обработано " . $NS['custom']['counter'] . ' элементов, активируем товары с активными торговыми предложениями');
                        }
                    
                    $rsOffers = CIBlockElement::GetList(array(),
                        array(
                            'IBLOCK_ID' => $arOffers['OFFERS_IBLOCK_ID'],
                            'PROPERTY_'.$arOffers['OFFERS_PROPERTY_ID'] => $arElement['ID'],
                            'ACTIVE' => 'Y',
                        ),
                        false,
                        array('nTopCount' => 1),
                        array('ID')
                    );
                    if ($arOffer = $rsOffers->Fetch()) {
                        $i++;
                        $el->Update($arElement['ID'], array('ACTIVE' => 'Y'), false, false, false, false);
                    }
                    
                    $NS['custom']['lastId'] = $arElement['ID'];
                    $NS['custom']['action'] = "action4";
                    $NS['custom']['counter']++;
                        
                }
                
                $NS['custom']['action'] = "action5";
                
                break;
                
            case "action5":
                
                // деактивируем товары без торговых предложений (с наличием > 0)
                $dbElement = CIBlockElement::GetList(
                    array(),
                    array(
                        'IBLOCK_ID' => CATALOG_IBLOCK_ID,
                        'ACTIVE' => 'Y',
                    ),
                    false,
                    false,
                    array('ID')
                );
                while ($arElement = $dbElement->Fetch())
                {
                        if ($stepInterval > 0 && (time() - $startTime) > $stepInterval)
                        {
                            Handlers::Import1CResult("progress", "Обработано " . $NS['custom']['counter'] . ' элементов, деактивируем товары без торговых предложений (с наличием > 0)');
                        }
                        
                    $rsOffers = CIBlockElement::GetList(
                        array(),
                        array(
                            'IBLOCK_ID' => $arOffers['OFFERS_IBLOCK_ID'],
                            'PROPERTY_' . $arOffers['OFFERS_PROPERTY_ID'] => $arElement['ID'],
                            'ACTIVE' => 'Y',
                            '>CATALOG_QUANTITY'=>0,
                        ),
                        false,
                        array('nTopCount' => 1),
                        array('ID')
                    );
                    if (!($arOffer = $rsOffers->Fetch()))
                    {
                        
                        
                        $el->Update($arElement['ID'], array('ACTIVE' => 'N'), false, false);
                        
                        $NS['custom']['lastId'] = $arElement['ID'];
                        $NS['custom']['action'] = "action5";
                        $NS['custom']['counter']++;
                    }
                }
                
                $NS['custom']['action'] = "action6";
                
                break;
                
            case "action6":
                YmlExport();

                $GLOBALS['CACHE_MANAGER']->ClearByTag('/iblock/catalog_count_sections_products');
                BXClearCache(true, '/s1/dx/super.comp/sidebar');
                BXClearCache(true, '/s1/bitrix/menu');
                
                $NS['custom']['action'] = "finish";
                
                break;
        }
               
            if ($NS['custom']['action'] != "finish")
            {
                if ($errorMessage === null)
                    Handlers::Import1CResult('progress', "Обработано " . $NS['custom']['counter'] . ' элементов');
                else
                    Handlers::Import1CResult('failure', $errorMessage);

            }
    }
    
    
    
    // --!> gleb@nextype

    function SuccessCatalogImport() {
        df('OnSuccessCatalogImport1C: ' . date('Y-m-d H:i:s'));

        // запускаем эти обработки только после загрузки последнего *.xml файла
        $arFiles = glob($_SERVER["DOCUMENT_ROOT"] . '/upload/1c_catalog/*.xml');
        if (!is_array($arFiles) || count($arFiles) <= 0) {
            return;
        }
        $lastFileName = substr(strrchr(array_pop($arFiles), '/'), 1);
        if ($_REQUEST['filename'] != $lastFileName) {
            return;
        }

        self::$catalogImport = true;
        
        $stepInterval = (int) COption::GetOptionString("catalog", "1C_INTERVAL", "-");
        $start = time();

        CModule::IncludeModule('catalog');
        CModule::IncludeModule('iblock');

        $el = new CIBlockElement;

        $arOffers = GetOffersSettings(CATALOG_IBLOCK_ID);

        // деактивируем торговые предложения с нулевой ценой или без цвета и размера
        $dbElement = CIBlockElement::GetList(
            array(),
            array(
                'IBLOCK_ID'=> CATALOG_OFFERS_IBLOCK_ID,
                'ACTIVE' => 'Y',
                array(
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
        while ($arElement = $dbElement->Fetch()) {
            $el->Update($arElement['ID'], array('ACTIVE' => 'N'), false, false);
        }

        // активируем торговые предложения с положительной ценой и не пустыми цветом и размером
        $dbElement = CIBlockElement::GetList(
            array(),
            array(
                'IBLOCK_ID'=> CATALOG_OFFERS_IBLOCK_ID,
                'ACTIVE' => 'N',
                //'>CATALOG_QUANTITY'=>0,
                '>CATALOG_PRICE_' . GetPriceId()=>0,
                '!PROPERTY_COLOR' => false,
                '!PROPERTY_SIZE' => false,
            ),
            false,
            false,
            array('ID')
        );
        while ($arElement = $dbElement->Fetch()) {
            $el->Update($arElement['ID'], array('ACTIVE' => 'Y'), false, false);
        }

        // деактивируем товары которые не надо "Выгружать на сайт" или без картинок
        $dbElement = CIBlockElement::GetList(
            array(),
            array(
                'IBLOCK_ID'=>CATALOG_IBLOCK_ID,
                'ACTIVE' => 'Y',
                array(
                    'LOGIC'=>"OR",
                    'PROPERTY_UPLOAD' => 'false',
                    array(
                        'PREVIEW_PICTURE'=>false,
                        'DETAIL_PICTURE'=>false,
                    ),
                ),
            ),
            false,
            false,
            array('ID')
        );
        while ($arElement = $dbElement->Fetch()) {
            $el->Update($arElement['ID'], array('ACTIVE' => 'N'), false, false);
        }

        // активируем товары с картинками и которые надо "Выгружать на сайт" и у которых есть торговые предложения
        $dbElement = CIBlockElement::GetList(array(),
            array(
                'IBLOCK_ID' => CATALOG_IBLOCK_ID,
                'ACTIVE' => 'N',
                array(
                    'LOGIC' => 'OR',
                    array(
                        'LOGIC' => 'AND',
                        array(
                            'LOGIC' => 'OR',
                            '!PREVIEW_PICTURE' => false,
                            '!DETAIL_PICTURE' => false,

                        ),
                        '!PROPERTY_UPLOAD' => 'false',
                    ),
                    array(
                        'LOGIC' => 'AND',
                        'PROPERTY_UPLOAD' => 'true',
                        array(
                            'LOGIC' => 'OR',
                            '!PREVIEW_PICTURE' => false,
                            '!DETAIL_PICTURE' => false,

                        ),

                    ),
                ),

            ),
            false,
            false,
            array('ID')
        );
        // активируем товары с активными торговыми предложениями
        $i = 0;
        while ($arElement = $dbElement->Fetch()) {
            $rsOffers = CIBlockElement::GetList(array(),
                array(
                    'IBLOCK_ID' => $arOffers['OFFERS_IBLOCK_ID'],
                    'PROPERTY_'.$arOffers['OFFERS_PROPERTY_ID'] => $arElement['ID'],
                    'ACTIVE' => 'Y',
                ),
                false,
                array('nTopCount' => 1),
                array('ID')
            );
            if ($arOffer = $rsOffers->Fetch()) {
                $i++;
                $el->Update($arElement['ID'], array('ACTIVE' => 'Y'), false, false, false, false);
            }
        }

        // деактивируем товары без торговых предложений (с наличием > 0)
        $dbElement = CIBlockElement::GetList(
            array(),
            array(
                'IBLOCK_ID' => CATALOG_IBLOCK_ID,
                'ACTIVE' => 'Y',
            ),
            false,
            false,
            array('ID')
        );
        while ($arElement = $dbElement->Fetch()) {
            $rsOffers = CIBlockElement::GetList(
                array(),
                array(
                    'IBLOCK_ID' => $arOffers['OFFERS_IBLOCK_ID'],
                    'PROPERTY_' . $arOffers['OFFERS_PROPERTY_ID'] => $arElement['ID'],
                    'ACTIVE' => 'Y',
                    '>CATALOG_QUANTITY'=>0,
                ),
                false,
                array('nTopCount' => 1),
                array('ID')
            );
            if (!($arOffer = $rsOffers->Fetch())) {
                $el->Update($arElement['ID'], array('ACTIVE' => 'N'), false, false);
            }
        }

        self::$catalogImport = false;

        YmlExport();

        $GLOBALS['CACHE_MANAGER']->ClearByTag('/iblock/catalog_count_sections_products');
        BXClearCache(true, '/s1/dx/super.comp/sidebar');
        BXClearCache(true, '/s1/bitrix/menu');

        $end = time();
        df('END: ' . ($end - $start));
    }

    function DoIBlockAfterSave($arg1, $arg2 = false) {
        $ELEMENT_ID = false;
        $IBLOCK_ID = false;
        $OFFERS_IBLOCK_ID = false;
        $OFFERS_PROPERTY_ID = false;
        if (CModule::IncludeModule('currency'))
            $strDefaultCurrency = CCurrency::GetBaseCurrency();

        //Check for catalog event
        if (is_array($arg2) && $arg2["PRODUCT_ID"] > 0) {
            //Get iblock element
            $rsPriceElement = CIBlockElement::GetList(
                array(),
                array(
                    "ID" => $arg2["PRODUCT_ID"],
                ),
                false,
                false,
                array("ID", "IBLOCK_ID")
            );
            if ($arPriceElement = $rsPriceElement->Fetch()) {
                $arCatalog = CCatalog::GetByID($arPriceElement["IBLOCK_ID"]);
                if(is_array($arCatalog)) {
                    //Check if it is offers iblock
                    if($arCatalog["OFFERS"] == "Y")
                    {
                        //Find product element
                        $rsElement = CIBlockElement::GetProperty(
                            $arPriceElement["IBLOCK_ID"],
                            $arPriceElement["ID"],
                            "sort",
                            "asc",
                            array("ID" => $arCatalog["SKU_PROPERTY_ID"])
                        );
                        $arElement = $rsElement->Fetch();
                        if($arElement && $arElement["VALUE"] > 0)
                        {
                            $ELEMENT_ID = $arElement["VALUE"];
                            $IBLOCK_ID = $arCatalog["PRODUCT_IBLOCK_ID"];
                            $OFFERS_IBLOCK_ID = $arCatalog["IBLOCK_ID"];
                            $OFFERS_PROPERTY_ID = $arCatalog["SKU_PROPERTY_ID"];
                        }
                    }
                    //or iblock which has offers
                    elseif($arCatalog["OFFERS_IBLOCK_ID"] > 0)
                    {
                        $ELEMENT_ID = $arPriceElement["ID"];
                        $IBLOCK_ID = $arPriceElement["IBLOCK_ID"];
                        $OFFERS_IBLOCK_ID = $arCatalog["OFFERS_IBLOCK_ID"];
                        $OFFERS_PROPERTY_ID = $arCatalog["OFFERS_PROPERTY_ID"];
                    }
                    //or it's regular catalog
                    else
                    {
                        $ELEMENT_ID = $arPriceElement["ID"];
                        $IBLOCK_ID = $arPriceElement["IBLOCK_ID"];
                        $OFFERS_IBLOCK_ID = false;
                        $OFFERS_PROPERTY_ID = false;
                    }
                }
            }
        }
        //Check for iblock event
        elseif(is_array($arg1) && $arg1["ID"] > 0 && $arg1["IBLOCK_ID"] > 0) {
            // после импорта товаров из 1С меняется только активность товаров, поэтому не обновляем минимальную цену
            if (self::$catalogImport) {
                return;
            }
            //Check if iblock has offers
            $arOffers = CIBlockPriceTools::GetOffersIBlock($arg1["IBLOCK_ID"]);
            if (is_array($arOffers)) {
                $ELEMENT_ID = $arg1["ID"];
                $IBLOCK_ID = $arg1["IBLOCK_ID"];
                $OFFERS_IBLOCK_ID = $arOffers["OFFERS_IBLOCK_ID"];
                $OFFERS_PROPERTY_ID = $arOffers["OFFERS_PROPERTY_ID"];
            }
        }

        if ($ELEMENT_ID) {
            static $arPropCache = array();
            if (!array_key_exists($IBLOCK_ID, $arPropCache)) {
                //Check for MINIMAL_PRICE property
                $rsProperty = CIBlockProperty::GetByID("MINIMUM_PRICE", $IBLOCK_ID);
                $arProperty = $rsProperty->Fetch();
                if ($arProperty) {
                    $arPropCache[$IBLOCK_ID] = $arProperty["ID"];
                } else {
                    $arPropCache[$IBLOCK_ID] = false;
                }
            }

            if ($arPropCache[$IBLOCK_ID]) {
                //Compose elements filter
                if ($OFFERS_IBLOCK_ID) {
                    $rsOffers = CIBlockElement::GetList(
                        array(),
                        array(
                            "IBLOCK_ID" => $OFFERS_IBLOCK_ID,
                            "PROPERTY_".$OFFERS_PROPERTY_ID => $ELEMENT_ID,
                        ),
                        false,
                        false,
                        array("ID")
                    );
                    while ($arOffer = $rsOffers->Fetch()) {
                        $arProductID[] = $arOffer["ID"];
                    }

                    if (!is_array($arProductID)) {
                        $arProductID = array($ELEMENT_ID);
                    }
                } else {
                    $arProductID = array($ELEMENT_ID);
                }

                $minPrice = false;
                $maxPrice = false;
                //Get prices
                $rsPrices = CPrice::GetList(
                    array(),
                    array(
                        "BASE" => "Y",
                        "PRODUCT_ID" => $arProductID,
                    )
                );
                while ($arPrice = $rsPrices->Fetch()) {
                    if (CModule::IncludeModule('currency') && $strDefaultCurrency != $arPrice['CURRENCY']) {
                        $arPrice["PRICE"] = CCurrencyRates::ConvertCurrency($arPrice["PRICE"], $arPrice["CURRENCY"], $strDefaultCurrency);
                    }

                    $PRICE = $arPrice["PRICE"];

                    if ($minPrice === false || $minPrice > $PRICE) {
                        $minPrice = $PRICE;
                    }

                    if ($maxPrice === false || $maxPrice < $PRICE) {
                        $maxPrice = $PRICE;
                    }
                }

                //Save found minimal price into property
                if ($minPrice !== false) {
                    CIBlockElement::SetPropertyValuesEx(
                        $ELEMENT_ID,
                        $IBLOCK_ID,
                        array(
                            "PRICE" => $minPrice,
                            "MINIMUM_PRICE" => $minPrice,
                            "MAXIMUM_PRICE" => $maxPrice,
                        )
                    );
                }
            }
        }
    }

    function OnGetOptimalPrice($intProductID, $quantity, $arUserGroups, $renewal, $arPrices, $siteID, $arDiscountCoupons) {

        // fix editing product quantity in admin
        $orderId = GetOrderIdFromPOST();
        $productInfo = GetProductInfoFromPOST($orderId);
        if (count($productInfo) > 0) {
            foreach ($productInfo as $basketId => $arItem) {
                if ($arItem['PRODUCT_ID'] == $intProductID) {
                    if (isset($arItem['QUANTITY'])) {
                        $quantity = $arItem['QUANTITY'];
                    }
                    break;
                }
            }
        }

        if (is_array($arPrices) && count($arPrices) <= 0) {
            $dbPriceList = CPrice::GetListEx(
                array(),
                array(
                        'PRODUCT_ID' => $intProductID,
                        'GROUP_GROUP_ID' => $arUserGroups,
                        'GROUP_BUY' => 'Y',
                        '+<=QUANTITY_FROM' => $quantity,
                        '+>=QUANTITY_TO' => $quantity,
                        'CATALOG_GROUP_ID' => GetPriceId(),
                    ),
                false,
                false,
                array('ID', 'CATALOG_GROUP_ID', 'PRICE', 'CURRENCY')
            );
            while ($arPriceList = $dbPriceList->Fetch())
            {
                $arPriceList['ELEMENT_IBLOCK_ID'] = $intIBlockID;
                $arPrices[] = $arPriceList;
            }
            if (is_array($arPrices) && count($arPrices) > 0) {
                $price = CCatalogProduct::GetOptimalPrice($intProductID, $quantity, $arUserGroups, $renewal, $arPrices);

                $arActions = GetActiveActions($orderId);
                foreach ($arActions as $key => $arAction) {
                    $price = GetActionPriceForProduct($price, $arAction['PROPERTY_CODE'], $orderId, $intProductID, $quantity, $arUserGroups, $arAction['COUNT'], $arAction['DISCOUNT']);
                }
                return $price;
            }
            return false;
        }
        return true;
    }

    function OnBeforeIBlockElementAdd(&$arFields) {
        global $USER;
        if ($arFields['IBLOCK_ID'] == CATALOG_IBLOCK_ID && isset($USER) && $USER->IsAuthorized()) {
            $arGroupIds = $USER->GetUserGroupArray();
            if (in_array(CONTENT_MANAGERS_GROUP_ID, $arGroupIds)) {
                global $APPLICATION;
                $APPLICATION->throwException('Вам нельзя добавлять товары');
                return false;
            }
        }
    }

    function OnBeforeIBlockSectionAdd(&$arFields) {
        global $USER;
        if ($arFields['IBLOCK_ID'] == CATALOG_IBLOCK_ID && isset($USER) && $USER->IsAuthorized()) {
            $arGroupIds = $USER->GetUserGroupArray();
            if (in_array(CONTENT_MANAGERS_GROUP_ID, $arGroupIds)) {
                global $APPLICATION;
                $APPLICATION->throwException('Вам нельзя добавлять разделы каталога');
                return false;
            }
        }
    }

    function OnBeforeIBlockElementUpdate(&$arFields) {
        global $USER;
        if ($arFields['IBLOCK_ID'] == CATALOG_IBLOCK_ID && isset($USER) && $USER->IsAuthorized()) {
            $arGroupIds = $USER->GetUserGroupArray();
            if (in_array(CONTENT_MANAGERS_GROUP_ID, $arGroupIds)) {
                $arEditFields = array(
                    'PROPERTY_VALUES',
                );
                foreach ($arFields as $field => $val) {
                    if (!in_array($field, $arEditFields)) {
                        unset($arFields[$field]);
                    }
                }
                $arEditFields = array(
                    GetPropertyId(CATALOG_IBLOCK_ID, 'TITLE'),
                    GetPropertyId(CATALOG_IBLOCK_ID, 'KEYWORDS'),
                    GetPropertyId(CATALOG_IBLOCK_ID, 'DESCRIPTION'),
                );
                foreach ($arFields['PROPERTY_VALUES'] as $key => $val) {
                    if (!in_array($key, $arEditFields)) {
                        unset($arFields['PROPERTY_VALUES'][$key]);
                    }
                }
            }
        }
    }

    function OnBeforeIBlockSectionUpdate(&$arFields) {
        global $USER;
        if ($arFields['IBLOCK_ID'] == CATALOG_IBLOCK_ID && isset($USER) && $USER->IsAuthorized()) {
            $arGroupIds = $USER->GetUserGroupArray();
            if (in_array(CONTENT_MANAGERS_GROUP_ID, $arGroupIds)) {
                $arEditFields = array(
                    'UF_TITLE',
                    'UF_KEYWORDS',
                    'UF_DESCRIPTION',
                );
                foreach ($arFields as $field => $val) {
                    if (!in_array($field, $arEditFields)) {
                        unset($arFields[$field]);
                    }
                }
            }
        }
    }

    function OnSaleComponentOrderOneStepProcess(&$arResult, &$arUserResult, &$arParams) {
        if ($arUserResult["CONFIRM_ORDER"] == "Y") {
            $indexPropertyId = 0;
            foreach ($arResult['ORDER_PROP']['USER_PROPS_Y'] as $key => $arProp) {
                if ($arProp['CODE'] == 'ZIP') {
                    $indexPropertyId = $key;
                    break;
                }
            }

            if ($indexPropertyId > 0 && $arUserResult['DELIVERY_ID'] == RUSSIANPOST_DELIVERY_ID && strlen($arUserResult['ORDER_PROP'][$indexPropertyId]) <= 0) {
                $arResult['ERROR'][] = 'Заполните поле "' . $arResult['ORDER_PROP']['USER_PROPS_Y'][$indexPropertyId]['NAME'] . '"';
            }
        }
    }
}

function pr($o, $showEveryone = false) {
  global $USER;
  if (!$USER->IsAdmin() and !$showEveryone) return;
  echo '<pre style="font-size: 10pt; background-color: #fff; color: #000; margin: 10px; padding: 10px; border: 1px solid red; text-align: left; max-width: 800px; max-height: 600px; overflow: scroll">';
    echo htmlspecialcharsEx(print_r($o, true));
  echo '</pre>';
}

function specialOffer($show = false){
    global $DB;
    CModule::IncludeModule('iblock');

    $cibe = new CIBlockElement;


    //// Получение случайного нового товара или товара с распродажей ////
    $elementRaw = $cibe->GetList(
        array('rand' => 'ASC'),
        array(
            'IBLOCK_ID' => CATALOG_IBLOCK_ID,
            array(
                'LOGIC' => 'OR',
                'PROPERTY_NOVINKA_VALUE' => 'Да',
                'PROPERTY_RASPRODAZHA_VALUE' => 'Да',
            )
        ),
        false,
        false,
        array(
            'ID',
            'NAME',
            'PROPERTY_NOVINKA',
            'PROPERTY_RASPRODAZHA',
        )
    );

    $elementHandled = $elementRaw->GetNext();

    if(!$elementHandled) return 'specialOffer();';

    $productID = $elementHandled['ID'];

    //// Получение ID всех элементов из инфоблока спецпредложения ////
    $listRaw = $cibe->GetList(
        array(),
        array(
            'IBLOCK_ID' => SPECIAL_IBLOCK_ID
        ),
        false,
        false,
        array('ID')
    );

    $deprecatedSpecialOffersID = array();
    while($listItemData = $listRaw->Fetch())
    {
        $deprecatedSpecialOffersID[] = $listItemData['ID'];
    }

    //// Удаление всех элементов из инфоблока спецпредложения ////
    $DB->StartTransaction();
    foreach($deprecatedSpecialOffersID as $specialProductID)
    {
        if(!$cibe->Delete($specialProductID))
        {
            $DB->Rollback();
            return 'specialOffer();';
        }
    }
    $DB->Commit();

    //// Добавление случайного элемента из инфоблока спецпредложения ////
    $newSpecialProductID = $cibe->Add(array(
        'IBLOCK_ID' => SPECIAL_IBLOCK_ID,
        'XML_ID' => 0,
        'NAME' => 'Спецпредложение',
        'PROPERTY_VALUES' => array(
            'PRODUCT' => $productID,
            // Заводим таймер на целые сутки
            'END_DATE' => date('d.m.Y H:i:s', time() + 24 * 60 * 60)
        )
    ));

    if($show)
    {
        echo '<pre>';
        var_dump($deprecatedSpecialOffersID);
        echo '<br><br><br>';

        var_dump($newSpecialProductID);
        echo '<pre>';
    }

    return 'specialOffer();';
}

?>
