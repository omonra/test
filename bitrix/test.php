<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/*$arStoresSite = Array ();
$rsStores = CCatalogStore::GetList(Array (), Array (), false);
while ($arItem = $rsStores->Fetch())
       $arStoresSite[$arItem['XML_ID']] = $arItem['ID']; */

$productXMLID = "ecb0b875-7dff-11e5-bb05-001e678b46f8";
$arResult = PControl::GetQuantityByXmlID($productXMLID, true);


//while ($iblock = $res->fetch())
//        print_r($iblock);







echo "<pre>";
print_r($arResult);
exit();
?>

