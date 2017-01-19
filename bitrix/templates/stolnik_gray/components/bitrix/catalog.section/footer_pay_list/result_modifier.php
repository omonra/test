<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach ($arResult['ITEMS'] as $key => $arItem) {
    if (is_array($arItem['DETAIL_PICTURE']) && $arItem['DETAIL_PICTURE']['WIDTH'] > 0) {
        $arResult['ITEMS'][$key]['PICTURE'] = GetResizedPicture($arItem['DETAIL_PICTURE'], 62, 30);
    }
}

