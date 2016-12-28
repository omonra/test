<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();



PrepareSectionItems($arResult['ITEMS'], array('PICTURE_WIDTH' => CATALOG_SECTION_PICTURE_WIDTH, 'PICTURE_HEIGHT' => CATALOG_SECTION_PICTURE_HEIGHT));

// ѕолучаем минимальную цену по позици
foreach ($arResult['ITEMS'] as $key => $arItem)
{
    $arPrices = CExFunctions::GetOptimalPrice($arItem['ID']);
    $arResult['ITEMS'][$key]['PRICE'] = $arPrices;
}