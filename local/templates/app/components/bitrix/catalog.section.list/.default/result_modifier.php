<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arNewResult = Array ();
$parentId = -1;
foreach($arResult['SECTIONS'] as $arItem)
{
    if ($arItem['DEPTH_LEVEL'] == 2)
    {
        $parentId++;
        $arNewResult[$parentId] = $arItem;
    }
    elseif ($arItem['DEPTH_LEVEL'] == 3)
    {
        $arNewResult[$parentId]['SUB'][] = $arItem;
    }
}

$arResult['SECTIONS'] = $arNewResult;
