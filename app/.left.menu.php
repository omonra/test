<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
IncludeModuleLangFile(__FILE__);
require($_SERVER["DOCUMENT_ROOT"]."/app/catalog/menu.ext.php");

        //print_r($arCurSection);
        
$aMenuLinks[] = Array(
        "������",
        "/app/",
        Array(),
        Array(),
        ""
    );
    
foreach ($arSections as $arItem)
{
    $aMenuLinks[] = Array(
        $arItem['NAME'],
        "/app/catalog/menu.php?section_id=" . $arItem['ID'],
        Array(),
        Array(),
        ""
    );
}

  $aMenuLinks[] = Array(
        "��� QR-���",
        "/app/personal/qr/",
        Array(),
        Array(),
        ""
    );

    $aMenuLinks[] = Array(
        "�������",
        "/app/personal/cart/",
        Array(),
        Array(),
        ""
    );
    
    $aMenuLinks[] = Array(
        "��������",
        "/app/shops/",
        Array(),
        Array(),
        ""
    );
?>