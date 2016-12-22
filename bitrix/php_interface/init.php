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

if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/include/import1c.php')) {
    require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/include/import1c.php');
}

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
    '', // �� ��������� ��� ������
    array(
        "USubscribe" => "/bitrix/php_interface/classes/USubscribe.php",                             // ����������� �� ������ � ����������
        "UTools" => "/bitrix/php_interface/classes/UTools.php",                                     // ����������� �� ������ � ��������������
        "PControl" => "/bitrix/php_interface/classes/ProductControl.php",                           // ����������� �� ������ � ��������
    )
);


//AddEventHandler("sale", "OnBasketAdd", Array ("BlackFridayClass" ,"OnBasketAddHandler"));
//AddEventHandler("sale", "OnBeforeBasketAdd", Array ("BlackFridayClass" ,"OnBeforeBasketAddHandler"));

CModule::IncludeModule("catalog");

// �������� ������
$cache = new CPHPCache();
$cache_time = 3600;
$cache_id = 'arStoresList';
$cache_path = '/arStoresList/';
if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path))
{
    $res = $cache->GetVars();
    if (is_array($res["arStoresList"]) && (count($res["arStoresList"]) > 0))
      $GLOBALS['arStores'] = $res["arStoresList"];
}

if (!is_array($GLOBALS['arStores']))
{
    $GLOBALS['arStores'] = Array ();
    $rsStores = CCatalogStore::GetList(Array (), Array (), false);
    while ($arItem = $rsStores->Fetch())
           $GLOBALS['arStores'][$arItem['XML_ID']] = $arItem['ID']; 
    
    $cache->StartDataCache($cache_time, $cache_id, $cache_path);
    $cache->EndDataCache(array("arStoresList"=>$GLOBALS['arStores']));
}


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




AddEventHandler("main", "OnBeforeUserUpdate", "OnBeforeUserUpdateHandler");
AddEventHandler("main", "OnBeforeUserAdd", "OnBeforeUserAddRegisterHandler");
AddEventHandler("main", "OnBeforeUserRegister", "OnBeforeUserAddRegisterHandler");

AddEventHandler("main", "OnAfterUserAdd", "OnAfterUserAddHandler");

AddEventHandler("main", "OnAfterUserAdd", "OnAfterUserRegisterHandler");
AddEventHandler("main", "OnAfterUserRegister", "OnAfterUserRegisterHandler");




function SendUserInfo($userID)
{
    global $_REQUEST;

    if($userID > 0)
    {
        $rsUser = CUser::GetByID($userID);
        $arUser = $rsUser->Fetch();

        if($arUser["ACTIVE"] == "Y")
        {
            $toSend = array();
            $toSend["EMAIL"] = $arUser["EMAIL"];
            $toSend["USER_ID"] = $arUser["ID"];
            $toSend["LOGIN"] = $arUser["LOGIN"];
            $toSend["NAME"] = (trim ($arUser["NAME"]) == "")? $toSend["NAME"] = htmlspecialchars('<�� �������>'): $arUser["NAME"];
            $toSend["LAST_NAME"] = (trim ($arUser["LAST_NAME"]) == "")? $toSend["LAST_NAME"] = htmlspecialchars('<�� �������>'): $arUser["LAST_NAME"];
            CEvent::SendImmediate ("MY_NEW_USER", SITE_ID, $toSend);
        }
    }
}

function OnAfterUserRegisterHandler(&$arFields) {
    if (intval($arFields["ID"]) > 0)
    {
        $arEvent = $arFields;
        $arEvent["USER_ID"] = $arFields["ID"];
        $arEvent["CONFIRM_CODE"] = randString(8);
        CEvent::SendImmediate("NEW_USER_CONFIRM", SITE_ID, $arEvent);

        if($arFields["USER_SUBSCRIBE"] == "Y")
        {
            USubscribe::Add($arFields["USER_ID"], $arFields["LOGIN"]);
        }
    }
    return $arFields;
}

function OnBeforeUserUpdateHandler(&$arFields)
{
    if(check_email($arFields["EMAIL"]))
    {
        $arFields["LOGIN"] = $arFields["EMAIL"];
    }
}

function OnBeforeUserAddRegisterHandler(&$arFields)
{
    $arFields["LOGIN"] = $arFields["EMAIL"];

    $resText = "";
    if (strlen($arFields['NAME']) <= 0)
    {
        $resText .= "��� �������� ������������ �����.";
    }
    if (strlen($arFields['LAST_NAME']) <= 0)
    {
        if(strlen($resText) > 0)
            $resText .= "<br>";
        $resText .= "������� �������� ������������ �����.";
    }
    if(strlen($resText) > 0)
    {
        $GLOBALS['APPLICATION']->ThrowException($resText);
        return false;
    }
}

function OnAfterUserAddHandler(&$arFields)
{
    if($arFields["ID"] > 0)
    {
        USubscribe::Add($arFields["ID"], $arFields["LOGIN"]);
    }
}

























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



AddEventHandler("sale", "OnOrderStatusSendEmail", "OnSaleStatusOrder_mail");

function OnSaleStatusOrder_mail($ID, &$eventName, &$arFields, $val)
{
    if ($val=="O")
    {
        $arOrder = CSaleOrder::GetByID($arFields["ORDER_ID"]);
        if ($arOrder["PAY_SYSTEM_ID"]==8)
            $arFields["TEXT"] = "��� ������ ������ ��������� �� ������:: https://rbkmoney.ru/acceptpurchase.aspx?eShopId=2016418&recipientAmount=".$arOrder["PRICE"]."&recipientCurrency=RUB&orderId=".$arFields["ORDER_ID"];
        elseif($arOrder['PAY_SYSTEM_ID'] == 11)
            $arFields["TEXT"] = "��� ������ ������ ��������� �� ������:: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&currency_code=RUB&business=info@stok-stolnik.com&amount=".$arOrder["PRICE"]."&item_name=Invoice_".$ID;

    }
}

AddEventHandler("sale", "OnSaleComponentOrderOneStepFinal", "OnSaleComponentOrderOneStepFinal");

function OnSaleComponentOrderOneStepFinal($ID, $arOrder) {
    global $DB;
    $db_props = CSaleOrderPropsValue::GetOrderProps($ID);
    while ($arProps = $db_props->Fetch()) {
        $arOrderProps[$arProps["CODE"]] = $arProps["VALUE"];
    }
    $deliveryName = '';
    if (strlen($arOrder["DELIVERY_ID"]) > 0 && strpos($arOrder["DELIVERY_ID"], ":") !== false) {
        $delivery = explode(":", $arOrder["DELIVERY_ID"]);
        $obDeliveryHandler = CSaleDeliveryHandler::GetBySID($delivery[0]);
        $arDeliv = $obDeliveryHandler->Fetch();
        $deliveryName = $arDeliv['PROFILES'][$delivery[1]]['TITLE'];
    } else {
        //$arDeliv = CSaleDelivery::GetByID($arOrder["DELIVERY_ID"]);
        $deliveryName = $DB->Query('SELECT * FROM b_sale_order_delivery WHERE ORDER_ID='.$ID)->GetNext();
        $deliveryName = htmlspecialchars_decode($deliveryName['DELIVERY_NAME']);
    }
    $arPaySys = CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"]);

    if ($arOrderProps['LOCATION'] > 0) {
        $arCity = CSaleLocation::GetByID($arOrderProps['LOCATION']);
        $arOrderProps['CITY'] = $arCity['CITY_NAME_LANG'];
    }
    //pr($ID);
    //pr($arOrder);
    //pr($arOrderProps);
    //pr($deliveryName);die;

    $arFields = array(
       "ORDER_ID" => $ID,
       "ORDER_PROPS_ID" => 24,
       "NAME" => "����������� ����� ��������",
       "CODE" => "FACT_ADDRESS",
       "VALUE" => $arOrderProps["CITY"].", ��. ".$arOrderProps["STREET"].", ���  ".$arOrderProps["HOME"].", ��. ".$arOrderProps["KW"].", ������ ".$arOrderProps["ZIP"].", ��������: ".$deliveryName.", ������: ".$arPaySys["NAME"]
    );

    if(CSaleOrderPropsValue::Add($arFields)){
        pr('Y');
    }else{
        pr('N');
    }

    $arActions = GetActiveActions();
    if (count($arActions) > 0) {
        $arCodes = array();
        foreach ($arActions as $actionCode => $arAction) {
            $arCodes[] = $arAction['CODE'];
        }
        CSaleOrderPropsValue::Add(array(
            'ORDER_ID' => $ID,
            'ORDER_PROPS_ID' => ACTION_ENABLED_ORDER_PROP_ID,
            'NAME' => '����� ��������',
            'CODE' => 'action_enabled',
            'VALUE' => implode(';', $arCodes),
        ));
    }
}


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

AddEventHandler("iblock", "OnBeforeIBlockElementAdd", "DoIBlockBeforeSave");
function DoIBlockBeforeSave($arFields) {
    if ($arFields["IBLOCK_ID"] == COMMENTS_IBLOCK_ID) {
        if (CheckURL($arFields["DETAIL_TEXT"])) {
            global $APPLICATION;
            $APPLICATION->throwException("��������� ��������� ������ � �����������");
            return false;
        }
    }
}


AddEventHandler("catalog", "OnStoreProductAdd", "DoStoreSave2");
AddEventHandler("catalog", "OnStoreProductUpdate", "DoStoreSave2");
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


AddEventHandler("iblock", "OnAfterIBlockSectionAdd", array("DopClassSec", "OnAfterIBlockSectionAddHandler"));
AddEventHandler("iblock", "OnAfterIBlockSectionUpdate", array("DopClassSec", "OnAfterIBlockSectionUpdateHandler"));

class DopClassSec
{
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

    function OnAfterIBlockSectionUpdateHandler(&$arFields){
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
}

AddEventHandler("iblock", "OnAfterIBlockElementAdd", array("DopClass", "OnAfterIBlockElementUpdateHandler"));
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", array("DopClass", "OnAfterIBlockElementUpdateHandler"));

class DopClass {
    function OnAfterIBlockElementUpdateHandler(&$arFields){
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


function convertDate($date) {
    $components = explode (" ", $date, 2);
    $monthes = array(
        '������',
        '�������',
        '�����',
        '������',
        '���',
        '����',
        '����',
        '�������',
        '��������',
        '�������',
        '������',
        '�������'
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
        
        // ��������� ��� ��������� ������ ����� �������� ���������� *.xml �����
        $arFiles = glob($_SERVER["DOCUMENT_ROOT"] . '/upload/1c_catalog/*.xml');
        if (!is_array($arFiles) || count($arFiles) <= 0) {
            return;
        }
        $lastFileName = substr(strrchr(array_pop($arFiles), '/'), 1);
        if ($_REQUEST['filename'] != $lastFileName) {
            return;
        }
        
        $startTime = time();
        // ���� ������� ����� �������� �����������
        $isOffers = strpos($_REQUEST['filename'], 'offers') !== false;
        $NS = &$_SESSION["BX_CML2_IMPORT"]["NS"];

        if (!isset($NS['custom']['lastId'])) {
            // ��������� ������������ ������� ��� �����������.
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
                // ������������ �������� ����������� � ������� ����� ��� ��� ����� � �������
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
                        Handlers::Import1CResult("progress", "���������� " . $NS['custom']['counter'] . ' ���������, ������������ �������� ����������� � ������� ����� ��� ��� ����� � �������');
                    }
                    
                    $el->Update($arElement['ID'], array('ACTIVE' => 'N'), false, false);
                    
                    $NS['custom']['lastId'] = $arElement['ID'];
                    $NS['custom']['action'] = "action1";
                    $NS['custom']['counter']++;
                }
                
                $NS['custom']['action'] = "action2";
                
                break;
                
             case 'action2':
                 
                 // ���������� �������� ����������� � ������������� ����� � �� ������� ������ � ��������
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
                        Handlers::Import1CResult("progress", "���������� " . $NS['custom']['counter'] . ' ���������, ���������� �������� ����������� � ������������� ����� � �� ������� ������ � ��������');                    }
                    
                    $el->Update($arElement['ID'], array('ACTIVE' => 'Y'), false, false);
                    
                    $NS['custom']['lastId'] = $arElement['ID'];
                    $NS['custom']['action'] = "action2";
                    $NS['custom']['counter']++;
                }
                
                $NS['custom']['action'] = "action3";
                 
                 break;
                 
             case 'action3':
                 
                 // ������������ ������ ������� �� ���� "��������� �� ����" ��� ��� ��������
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
                            Handlers::Import1CResult("progress", "���������� " . $NS['custom']['counter'] . ' ���������, ������������ ������ ������� �� ���� "��������� �� ����" ��� ��� ��������');
                        }
                        
                        $el->Update($arElement['ID'], array('ACTIVE' => 'N'), false, false);
                        
                        $NS['custom']['lastId'] = $arElement['ID'];
                        $NS['custom']['action'] = "action3";
                        $NS['custom']['counter']++;
                    }
                 
                    $NS['custom']['action'] = "action4";
                    
                 break;
                 
            case 'action4':
                // ���������� ������ � ���������� � ������� ���� "��������� �� ����" � � ������� ���� �������� �����������
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
                // ���������� ������ � ��������� ��������� �������������
                $i = 0;
                while ($arElement = $dbElement->Fetch())
                {
                    if ($stepInterval > 0 && (time() - $startTime) > $stepInterval)
                        {
                            Handlers::Import1CResult("progress", "���������� " . $NS['custom']['counter'] . ' ���������, ���������� ������ � ��������� ��������� �������������');
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
                
                // ������������ ������ ��� �������� ����������� (� �������� > 0)
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
                            Handlers::Import1CResult("progress", "���������� " . $NS['custom']['counter'] . ' ���������, ������������ ������ ��� �������� ����������� (� �������� > 0)');
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
                    Handlers::Import1CResult('progress', "���������� " . $NS['custom']['counter'] . ' ���������');
                else
                    Handlers::Import1CResult('failure', $errorMessage);

            }
    }
    
    
    
    // --!> gleb@nextype

    function SuccessCatalogImport() {
        df('OnSuccessCatalogImport1C: ' . date('Y-m-d H:i:s'));

        // ��������� ��� ��������� ������ ����� �������� ���������� *.xml �����
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

        // ������������ �������� ����������� � ������� ����� ��� ��� ����� � �������
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

        // ���������� �������� ����������� � ������������� ����� � �� ������� ������ � ��������
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

        // ������������ ������ ������� �� ���� "��������� �� ����" ��� ��� ��������
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

        // ���������� ������ � ���������� � ������� ���� "��������� �� ����" � � ������� ���� �������� �����������
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
        // ���������� ������ � ��������� ��������� �������������
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

        // ������������ ������ ��� �������� ����������� (� �������� > 0)
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
            // ����� ������� ������� �� 1� �������� ������ ���������� �������, ������� �� ��������� ����������� ����
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
                $APPLICATION->throwException('��� ������ ��������� ������');
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
                $APPLICATION->throwException('��� ������ ��������� ������� ��������');
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
                $arResult['ERROR'][] = '��������� ���� "' . $arResult['ORDER_PROP']['USER_PROPS_Y'][$indexPropertyId]['NAME'] . '"';
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


    //// ��������� ���������� ������ ������ ��� ������ � ����������� ////
    $elementRaw = $cibe->GetList(
        array('rand' => 'ASC'),
        array(
            'IBLOCK_ID' => CATALOG_IBLOCK_ID,
            array(
                'LOGIC' => 'OR',
                'PROPERTY_NOVINKA_VALUE' => '��',
                'PROPERTY_RASPRODAZHA_VALUE' => '��',
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

    //// ��������� ID ���� ��������� �� ��������� ��������������� ////
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

    //// �������� ���� ��������� �� ��������� ��������������� ////
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

    //// ���������� ���������� �������� �� ��������� ��������������� ////
    $newSpecialProductID = $cibe->Add(array(
        'IBLOCK_ID' => SPECIAL_IBLOCK_ID,
        'XML_ID' => 0,
        'NAME' => '���������������',
        'PROPERTY_VALUES' => array(
            'PRODUCT' => $productID,
            // ������� ������ �� ����� �����
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
