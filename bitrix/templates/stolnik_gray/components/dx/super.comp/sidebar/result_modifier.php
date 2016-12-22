<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();?>
<?

$arParams['IBLOCK_ID'] = intval($arParams['IBLOCK_ID']);
$arParams['SECTION_ID'] = intval($arParams['SECTION_ID']);
$arParams['CURRENT_SECTION_ID'] = intval($arParams['CURRENT_SECTION_ID']);
$arParams['COUNT_ELEMENTS'] = $arParams['COUNT_ELEMENTS'] == 'Y';


if ($arParams['IBLOCK_ID'] <= 0) {
    ShowMessage('Не указан инфоблок.');
    return;
}

if ($arParams['SECTION_ID'] <= 0) {
    return;
}

if (!\Bitrix\Main\Loader::includeModule('iblock'))
    return false;

$arFilter = array(
    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
    'ACTIVE' => 'Y',
    'ID' => $arParams['SECTION_ID'],
    'GLOBAL_ACTIVE' => 'Y',
    '<=DEPTH_LEVEL' => 2,
);

$rsFields = CIBlockSection::GetList(array('name' => 'asc'), $arFilter, false, array(
    'ID',
    'NAME',
    'LEFT_MARGIN',
    'RIGHT_MARGIN',
    'DEPTH_LEVEL',
    'IBLOCK_ID',
    'IBLOCK_SECTION_ID',
    'LIST_PAGE_URL',
    'SECTION_PAGE_URL',
));
if ($arFields = $rsFields->GetNext()) {
    $arFields['ELEMENT_CNT'] = 0;
    $arResult['SECTION'] = $arFields;
    $arResult['SECTIONS'] = array();

    $arFilter = array(
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'ACTIVE' => 'Y',
        'SECTION_ID' => $arParams['SECTION_ID'],
        'GLOBAL_ACTIVE' => 'Y',
        'LEFT_MARGIN' => $arResult["SECTION"]["LEFT_MARGIN"] + 1,
        'RIGHT_MARGIN' => $arResult["SECTION"]["RIGHT_MARGIN"],
        '<=DEPTH_LEVEL' => $arResult["SECTION"]["DEPTH_LEVEL"] + 1,
    );

    $rsSection = CIBlockSection::GetList(array('name' => 'asc'), $arFilter, false, array('ID', 'NAME', 'SECTION_PAGE_URL'));
    while ($arSection = $rsSection->GetNext()) {
        $arResult['SECTIONS'][] = $arSection;
    }

    if ($arParams['COUNT_ELEMENTS']) {
        CountSpecialProducts($arResult, $arParams['SECTION_ID'], $arParams['IBLOCK_ID']);

        $childrenIds = array_map(function($item) {
            return $item['ID'];
        }, $arResult['SECTIONS']);
        sort($childrenIds);

        $arSectionIds2Count = CountSectionsProducts($childrenIds, $arParams['IBLOCK_ID']);

        foreach ($arResult['SECTIONS'] as $key => $arItem) {
            if (isset($arSectionIds2Count[$arItem['ID']]) && $arSectionIds2Count[$arItem['ID']] > 0) {
                $arResult['SECTIONS'][$key]['ELEMENT_CNT'] = $arSectionIds2Count[$arItem['ID']];
                $arResult['SECTION']['ELEMENT_CNT'] += $arSectionIds2Count[$arItem['ID']];
            }
        }
    }
}



// saving template name to cache array
$arResult['__TEMPLATE_FOLDER'] = $this->__folder;

// writing new $arResult to cache file
$this->__component->arResult = $arResult;
