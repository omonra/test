<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arNewResult = Array ();

// Поиск корневого узла
$root = $arResult['SECTIONS'][0];
$section_id = (!empty($_REQUEST['parent_id'])) ? intval($_REQUEST['parent_id']) : $root['ID'];


foreach ($arResult['SECTIONS'] as $arItem)
{
    if ($arItem['ID'] == $section_id)
    {
        $current = $arItem;
    }
    
    if ($arItem['IBLOCK_SECTION_ID'] == $section_id)
    {
        if (empty($arItem['ELEMENT_CNT'])) continue;
        $arNewItem = Array (
            'ID' => $arItem['ID'],
            'NAME' => $arItem['NAME'],
            'DEPTH_LEVEL' => $arItem['DEPTH_LEVEL'],
            'SORT' => $arItem['SORT'],
            'SECTION_PAGE_URL' => $arItem['SECTION_PAGE_URL'],
            'ELEMENT_CNT' => $arItem['ELEMENT_CNT'],
        );
        
        if ($arItem['DEPTH_LEVEL'] < 3)
        {
            $arNewItem['SECTION_PAGE_URL'] = $APPLICATION->GetCurDir() . "?parent_id=" . $arItem['ID'];
        }
        
        $arNewResult[] = $arNewItem;
    }
}

if ($arNewResult[0]['DEPTH_LEVEL'] == 3)
{
    $arFilters = Array (
        'new' => Array (
            'CODE' => 'NOVINKA',
            'NAME' => 'Новинки',
        ),
        'sale' => Array (
            'CODE' => 'SALE',
            'NAME' => 'Распродажа',
        ),
    );
    foreach ($arFilters as $key => $propCode)
    {
        $rsCounter = CIBlockElement::GetList(false, array(
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'ACTIVE' => 'Y',
            'SECTION_ID' => $section_id,
            '!PROPERTY_' . $propCode['CODE'] => false,
            'INCLUDE_SUBSECTIONS' => 'Y',
        ), array('IBLOCK_ID'));
        
        if ($arCounter = $rsCounter->Fetch())
        {
            $arResult['SUB_SECTIONS'][$key] = $propCode;
            $arResult['SUB_SECTIONS'][$key]['ELEMENT_CNT'] = $arCounter['CNT'];
            $arResult['SUB_SECTIONS'][$key]['SECTION_PAGE_URL'] = $APPLICATION->GetCurDir() . "?SECTION_ID=" . $section_id . "&" . $key . "=y";
        }
            
        
    }
    
    $APPLICATION->SetPageProperty("back-url", "/app/catalog/");
    $APPLICATION->SetTitle($current['NAME']);
}
else
{
    $APPLICATION->SetPageProperty("back-url", "/app/");
}



$arResult['SECTIONS'] = $arNewResult;