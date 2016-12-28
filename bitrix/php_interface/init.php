<?php
CModule::IncludeModule("catalog");

require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/general/Defines.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/local_settings.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/functions.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/specialcond.php');

// Required general functions with events
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/general/CExFunctions.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/general/CCatalogImport.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/general/CCatalogProduct.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/general/CUser.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/general/CSaleOrder.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/general/CIblock.php');




// Кешируем склады
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
            $toSend["NAME"] = (trim ($arUser["NAME"]) == "")? $toSend["NAME"] = htmlspecialchars('<Не указано>'): $arUser["NAME"];
            $toSend["LAST_NAME"] = (trim ($arUser["LAST_NAME"]) == "")? $toSend["LAST_NAME"] = htmlspecialchars('<Не указано>'): $arUser["LAST_NAME"];
            CEvent::SendImmediate ("MY_NEW_USER", SITE_ID, $toSend);
        }
    }
}