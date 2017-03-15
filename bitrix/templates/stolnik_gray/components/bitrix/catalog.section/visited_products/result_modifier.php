<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

PrepareSectionItems($arResult['ITEMS'], array('PICTURE_WIDTH' => CATALOG_VIEWED_PRODUCTS_PICTURE_WIDTH, 'PICTURE_HEIGHT' => CATALOG_VIEWED_PRODUCTS_PICTURE_HEIGHT));

$arElementsIds4Sort = array_flip($arParams['ELEMENTS_IDS4SORT']);
usort($arResult['ITEMS'], function($a, $b) use($arElementsIds4Sort) {
    return $arElementsIds4Sort[$a['ID']] - $arElementsIds4Sort[$b['ID']];
});
