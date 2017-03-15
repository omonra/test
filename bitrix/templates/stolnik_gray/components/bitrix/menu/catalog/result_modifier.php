<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arTmp = array();
$lastParent = 0;
foreach ($arResult as $key => $arItem) {
    if ($arItem['DEPTH_LEVEL'] == 1) {
        continue;
    }
    if ($arItem['DEPTH_LEVEL'] == 2) {
        CountSpecialProducts($arItem, $arItem['PARAMS']['ID'], CATALOG_IBLOCK_ID);

        $arItem['CHILDREN'] = array();
        $arTmp[$key] = $arItem;
        $lastParent = $key;
    } else {
        $arTmp[$lastParent]['CHILDREN'][] = $arItem;
    }
}

foreach ($arTmp as $key => $arItem) {
    $childrenIds = array_map(function($item) {
        return $item['PARAMS']['ID'];
    }, $arItem['CHILDREN']);
    sort($childrenIds);

    $arSectionIds2Count = CountSectionsProducts($childrenIds, CATALOG_IBLOCK_ID);
    $arTmp[$key]['PARAMS']['CNT'] = 0;

    foreach ($arItem['CHILDREN'] as $key2 => $arItem2) {
        if (isset($arSectionIds2Count[$arItem2['PARAMS']['ID']]) && $arSectionIds2Count[$arItem2['PARAMS']['ID']] > 0) {
            $arTmp[$key]['CHILDREN'][$key2]['PARAMS']['CNT'] = $arSectionIds2Count[$arItem2['PARAMS']['ID']];
            $arTmp[$key]['PARAMS']['CNT'] += $arSectionIds2Count[$arItem2['PARAMS']['ID']];
        }
    }

    usort($arTmp[$key]['CHILDREN'], function($a, $b) {
        return strcmp($a['TEXT'], $b['TEXT']);
    });
}

$arResult = $arTmp;
