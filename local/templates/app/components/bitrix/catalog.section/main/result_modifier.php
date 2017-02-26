<?
use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

foreach ($arResult['ITEMS'] as $key => $arItem)
{
    $arPrices = CExFunctions::GetOptimalPrice($arItem['ID']);
    $arResult['ITEMS'][$key]['PRICE'] = $arPrices;
}