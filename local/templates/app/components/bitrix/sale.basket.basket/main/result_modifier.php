<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
use Bitrix\Main;
//echo "<pre>";
foreach ($arResult['ITEMS'] as $cat_key => $category)
{
    foreach ($category as $key => $arItem)
    {
        if (!empty($arItem['PREVIEW_PICTURE']))
        {
            $arResult["GRID"]["ROWS"][$arItem['ID']]['PREVIEW_PICTURE_SRC'] = CFile::GetPath($arItem['PREVIEW_PICTURE']);
        }
        if (!empty($arItem['DETAIL_PICTURE']))
        {
            $arResult["GRID"]["ROWS"][$arItem['ID']]['DETAIL_PICTURE_SRC'] = CFile::GetPath($arItem['DETAIL_PICTURE']);
        }
        
    }
}
//print_r($arResult['ITEMS']);
//echo "</pre>";
/*
print_r($arResult);";*/