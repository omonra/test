<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/phpqrcode/qrlib.php");
if ($USER->IsAuthorized())
{
    $arUser = CUser::GetByID($USER->GetID())->fetch();
    $str = $arUser['XML_ID'] . ";" . $arUser['NAME'] . ";" . $arUser['LAST_NAME'] . ";" . $arUser['EMAIL'];
    //print_r($str);
    //exit();
    
    QRcode::png($str, false, "H", 4, 4);
}
    
