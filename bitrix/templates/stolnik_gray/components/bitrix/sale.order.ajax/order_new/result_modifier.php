<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$arResult["POST"] = array();
foreach ($_POST as $vname => $vvalue)
{
    if (!array_key_exists($vname, $arVarExcl) && !is_array($vvalue))
        $arResult["POST"][htmlspecialchars($vname)] = htmlspecialchars($vvalue);
}

$arResult["AUTH_SERVICES"] = false;
$arResult["CURRENT_SERVICE"] = false;
if (!$USER->IsAuthorized() && CModule::IncludeModule("socialservices"))
{
    $oAuthManager = new CSocServAuthManager();
    $arServices = $oAuthManager->GetActiveAuthServices($arResult);

    if (!empty($arServices))
    {
        $arResult["AUTH_SERVICES"] = $arServices;
        if (isset($_REQUEST["auth_service_id"]) && $_REQUEST["auth_service_id"] <> '' && isset($arResult["AUTH_SERVICES"][$_REQUEST["auth_service_id"]]))
        {
            $arResult["CURRENT_SERVICE"] = $_REQUEST["auth_service_id"];
            if (isset($_REQUEST["auth_service_error"]) && $_REQUEST["auth_service_error"] <> '')
            {
                $arResult['ERROR_MESSAGE'] = $oAuthManager->GetError($arResult["CURRENT_SERVICE"], $_REQUEST["auth_service_error"]);
            }
            elseif (!$oAuthManager->Authorize($_REQUEST["auth_service_id"]))
            {
                $ex = $APPLICATION->GetException();
                if ($ex)
                    $arResult['ERROR_MESSAGE'] = $ex->GetString();
            }
        }
    }
}

global $USER;
if (isset($_REQUEST['USER']) && $_REQUEST['USER'] == 'Y')
{
    //  $USER->Logout();
}


foreach ($arResult['BASKET_ITEMS'] as $key => $arItem)
{
    if ($arItem['DETAIL_PICTURE'] > 0)
    {
        
    }
    $arResult['BASKET_ITEMS'][$key]['DETAIL_PICTURE'] = GetResizedPicture($arItem['DETAIL_PICTURE'], BASKET_PICTURE_WIDTH, BASKET_PICTURE_HEIGHT);
}

$hasRedirect = false;
$arResult['FAST_DELIVERY'] = "Y";

foreach ($arResult['BASKET_ITEMS'] as $key => $arItem)
{
    $canBuy = false;
    $arXmlID = explode("#", $arItem['PRODUCT_XML_ID']);
    if (count($arXmlID) == 2)
    {
        // Добавить вывод доступного кол-ва для заказа
        /*$arQty = PControl::GetQuantityByXmlID($arXmlID[0], true);
        if ($_REQUEST['debug']=="y") {
        echo "<pre>";
        print_r($arQty);
        echo "</pre>";
        }*/
        /*if (is_array($arQty))
        {
            if ($arQty["OFFERS_INFO"][$arItem["PRODUCT_ID"]]["FAST_DELIVERY"] == "N")
                $arResult['FAST_DELIVERY'] = "N";

            if (is_array($arQty['OFFERS_COUNT']) && intval($arQty['OFFERS_COUNT'][$arItem['PRODUCT_ID']]) > 0)
                $canBuy = true;
            
            
        }*/
    }
    
    /*if (!$canBuy)
                {
                    $isUpdate = CSaleBasket::Update($arItem['ID'], Array(
                                'CAN_BUY' => 'N',
                                'DELAY' => 'Y'
                    ));
                    $hasRedirect = true;
                }*/
    
}

//if ($hasRedirect)
//    LocalRedirect($APPLICATION->GetCurPageParam());

// Получаем позиции "ПОД ЗАКАЗ"
$arSelFields = array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "DELAY",
    "CAN_BUY", "PRICE", "WEIGHT", "NAME", "CURRENCY", "CATALOG_XML_ID", "VAT_RATE",
    "NOTES", "DISCOUNT_PRICE", "PRODUCT_PROVIDER_CLASS", "DIMENSIONS", "TYPE", "SET_PARENT_ID", "DETAIL_PAGE_URL"
);

$arBasketFilter = array(
    "FUSER_ID" => CSaleBasket::GetBasketUserID(),
    "LID" => SITE_ID,
    "ORDER_ID" => "NULL",
    "CAN_BUY" => "N",
    "DELAY" => "Y"
);


$dbBasketItems = CSaleBasket::GetList(
    array("ID" => "ASC"), $arBasketFilter, false, false, $arSelFields
);
while ($arItem = $dbBasketItems->GetNext())
{
    $arResult['BASKET_ITEMS_NOT_AVALIABLE'][] = $arItem;
}

//if (count($arResult['BASKET_ITEMS_NOT_AVALIABLE']) == 0 && count($arResult['BASKET_ITEMS']) == 0)
//    LocalRedirect($arParams["PATH_TO_BASKET"]);

if ($USER->IsAdmin())
{
    /*echo "<pre>";
    print_r($arResult['BASKET_ITEMS']);
    echo "</pre>";*/
}

// Проверка на Челябинск

if ($arResult["ORDER_PROP"]["USER_PROPS_Y"][5]["VALUE"] == 17257)
{
    $arNewDelivery = Array(
        2 //Самовывоз из магазина
    );

    foreach ($arResult["DELIVERY"] as $key => $arDelivery)
    {
        if (!in_array($arDelivery['ID'], $arNewDelivery))
            unset($arResult["DELIVERY"][$key]);
    }
}
?>
