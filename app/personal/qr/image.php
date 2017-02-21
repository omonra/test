<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/phpqrcode/qrlib.php");
if ($USER->IsAuthorized())
{
    $arUser = CUser::GetByID($USER->GetID())->fetch();
    $str = $arUser['ID'] . ";" . $arUser['NAME'] . ";" . $arUser['PERSONAL_PHONE'] . ";" . $arUser['EMAIL'] . ";" . $arUser['PERSONAL_BIRTHDAY_1'];
    QRcode::png($str, false, "H", 4, 4);
}
    
