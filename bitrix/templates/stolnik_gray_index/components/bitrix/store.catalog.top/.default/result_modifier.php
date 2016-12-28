<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

PrepareSectionItems($arResult['ITEMS'], array('PICTURE_WIDTH' => CATALOG_SECTION_PICTURE_WIDTH, 'PICTURE_HEIGHT' => CATALOG_SECTION_PICTURE_HEIGHT));

foreach ($arResult['ITEMS'] as &$arItem)
{
    $arItem['PRICE'] = CExFunctions::GetOptimalPrice($arItem['ID']);
    AddEditButtons($arItem);
}
unset($arItem);


