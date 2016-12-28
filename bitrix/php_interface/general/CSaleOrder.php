<?php

AddEventHandler("sale", "OnOrderStatusSendEmail", "OnSaleStatusOrder_mail");
AddEventHandler("sale", "OnSaleComponentOrderOneStepFinal", "OnSaleComponentOrderOneStepFinal");

function OnSaleStatusOrder_mail($ID, &$eventName, &$arFields, $val)
{
    if ($val=="O")
    {
        $arOrder = CSaleOrder::GetByID($arFields["ORDER_ID"]);
        if ($arOrder["PAY_SYSTEM_ID"]==8)
            $arFields["TEXT"] = "Для оплаты заказа перейдите по ссылке:: https://rbkmoney.ru/acceptpurchase.aspx?eShopId=2016418&recipientAmount=".$arOrder["PRICE"]."&recipientCurrency=RUB&orderId=".$arFields["ORDER_ID"];
        elseif($arOrder['PAY_SYSTEM_ID'] == 11)
            $arFields["TEXT"] = "Для оплаты заказа перейдите по ссылке:: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&currency_code=RUB&business=info@stok-stolnik.com&amount=".$arOrder["PRICE"]."&item_name=Invoice_".$ID;

    }
}



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
       "NAME" => "Фактический адрес доставки",
       "CODE" => "FACT_ADDRESS",
       "VALUE" => $arOrderProps["CITY"].", ул. ".$arOrderProps["STREET"].", дом  ".$arOrderProps["HOME"].", кв. ".$arOrderProps["KW"].", индекс ".$arOrderProps["ZIP"].", доставка: ".$deliveryName.", оплата: ".$arPaySys["NAME"]
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
            'NAME' => 'Акция включена',
            'CODE' => 'action_enabled',
            'VALUE' => implode(';', $arCodes),
        ));
    }
}