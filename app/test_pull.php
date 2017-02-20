<?php

define('STOP_STATISTICS', true);
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if (CModule::IncludeModule("pull"))
{
    $arMessages = array();
    $message = Array(
        "USER_ID" => 28123, //������������� ������������
        "TITLE" => "Title", //���������, ������ ��� Android
        "APP_ID" => BX_APP_NAME, //������������� ����������
        "MESSAGE" => "���� ������!",
        "EXPIRY" => 0, //����� ����� ����������� �� ������� Apple � Google
        "PARAMS"=>array("PARAMS"=>array("tst"=>"1")),
        "BADGE" => 1 //������� �� ������ ����������
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