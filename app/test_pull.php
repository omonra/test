<?php

define('STOP_STATISTICS', true);
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if (CModule::IncludeModule("pull"))
{
    $arMessages = array();
    $message = Array(
        "USER_ID" => 28123, //Идентификатор пользователя
        "TITLE" => "Title", //заголовок, только для Android
        "APP_ID" => BX_APP_NAME, //Идентификатор приложения
        "MESSAGE" => "Жена привет!",
        "EXPIRY" => 0, //время жизни уведомления на сервере Apple и Google
        "PARAMS"=>array("PARAMS"=>array("tst"=>"1")),
        "BADGE" => 1 //счетчик на иконке приложения
    );


    $arMessages[] = $message;
    $manager = new CPushManager();
    $res = $manager->SendMessage($arMessages);
    print_r($res);
    echo "Ok";
    echo '<pre>';
    $dbres = CPullPush::GetList(Array(), Array());
    while ($ar = $dbres->fetch())
    {
        print_r($ar);
    }
}