<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResult['NEW_DESIGN'] = true;
$arSizes = GetSizes();
$arColors = array();

//$arInfo1C = PControl::GetQuantityByXmlID($arResult["XML_ID"], true);
$arResult["REAL_COUNT"] = $arInfo1C["COUNT"];



if ($arResult['NEW_DESIGN'])
{

    $arColors = Array ();
    $rsColors = CIBlockElement::GetList(array(), array(
            "IBLOCK_ID" => COLORS_IBLOCK_ID,
            "ACTIVE" => "Y",
        ), false, false, array(
            "ID",
            "IBLOCK_ID",
            "NAME",
            "PREVIEW_PICTURE",
            "PROPERTY_item_color_list",
        ));
    
    while ($arColor = $rsColors->fetch())
    {
        $arColors[$arColor['NAME']] = $arColor['PREVIEW_PICTURE'];
        //print_r($arColor);
    }
    
    $arResult['OFFERS_LIST'] = Array ();
    $arOffers = CCatalogSKU::getOffersList(Array ($arResult['ID']), CATALOG_IBLOCK_ID, Array('ACTIVE' => 'Y', '>CATALOG_QUANTITY' => 0), Array (
        'NAME', 'ID', 'XML_ID', 'CATALOG_QUANTITY'
    ), Array (
        'CODE' => Array (
            'SIZE',
            'COLOR'
        )
    ));
    
    $bFirst = true;
    /*echo "<pre>";
    print_r($arInfo1C);
    echo "</pre>";*/
    
    foreach ($arOffers[$arResult['ID']] as $offerId => $arItem)
    {
        if ($bFirst)
        {
            $arResult['COLOR_SELECTED'] = $arItem['PROPERTIES']['COLOR']['VALUE'];
            $arResult['SIZE_SELECTED'] = $arItem['PROPERTIES']['SIZE']['VALUE'];
            $arResult['OFFER_SELECTED'] = $arItem['ID'];
            $arResult['OFFER_QTY'] = $arItem['CATALOG_QUANTITY'];
            $bFirst = false;
        }
        
        $arFields = Array (
            'ID' => $arItem['ID'],
            'COLOR' => $arItem['PROPERTIES']['COLOR']['VALUE'],
            'COLOR_PICTURE' => CFile::GetPath($arColors[$arItem['PROPERTIES']['COLOR']['VALUE']]),
            'SIZE' => $arItem['PROPERTIES']['SIZE']['VALUE'],
            'QTY' => $arItem['CATALOG_QUANTITY']
        );
        
        $arResult['OFFERS_LIST']['COLOR'][$arItem['PROPERTIES']['COLOR']['VALUE']][$arFields['SIZE']] = $arFields;
        $arResult['OFFERS_LIST']['SIZE'][$arItem['PROPERTIES']['SIZE']['VALUE']][$arFields['COLOR']] = $arFields;
    }
    
   
    //$offersExist = CCatalogSKU::getExistOffers($productList);
}


/*if ($_REQUEST['debug'])
{
    echo "<pre>";
    print_r($arResult['OFFERS']);
    echo "</pre>";
}*/
$arItemSizes = array();
$arItemColors = array();
$arSizeToColors = array();

foreach ($arResult['OFFERS'] as $key => $arOffer) {
    if (!in_array($arOffer['PROPERTIES']['SIZE']['VALUE'], $arItemSizes)) {
        $arItemSizes[] = $arOffer['PROPERTIES']['SIZE']['VALUE'];
    }

    if (!in_array($arOffer['PROPERTIES']['COLOR']['VALUE'], $arItemColors)) {
        $arItemColors[] = $arOffer['PROPERTIES']['COLOR']['VALUE'];
    }

    $arSizeToColors[$arOffer['PROPERTIES']['SIZE']['VALUE']][ToUpper($arOffer['PROPERTIES']['COLOR']['VALUE'])] = array(
        'FAST_DELIVERY' => $arInfo1C["OFFERS_INFO"][$arOffer['ID']]["FAST_DELIVERY"],
        'QUANTITY' => $arInfo1C["OFFERS_COUNT"][$arOffer['ID']], //$arOffer['CATALOG_QUANTITY'],
        'COLOR' => $arOffer['PROPERTIES']['COLOR']['VALUE'],
        'PRICE' => $arOffer['MIN_PRICE']['VALUE'],
        'ID' => $arOffer['ID'],
    );
}

$arResult['SIZE_TO_COLORS'] = $arSizeToColors;
$arResult['SIZE_TO_QUANTITY'] = array_map(function($el) {
    $quantity = 0;
    foreach ($el as $item) {
        $quantity += $item['QUANTITY'];
    }
    return $quantity;
}, $arResult['SIZE_TO_COLORS']);

usort($arItemSizes, function($a, $b) use ($arSizes) {
    if ($a == $b) {
        return 0;
    }

    $a = !isset($arSizes[$a]) ? 500 : $arSizes[$a];
    $b = !isset($arSizes[$b]) ? 500 : $arSizes[$b];

    return $a > $b;
});
$arResult['SIZES'] = $arItemSizes;

if (count($arItemColors) > 0) {
    $arResult['COLORS'] = array();
    foreach ($arItemColors as $color) {
        $rsColors = CIBlockElement::GetList(array(), array(
            "IBLOCK_ID" => COLORS_IBLOCK_ID,
            "ACTIVE" => "Y",
            array("LOGIC" => "OR",
                array("PROPERTY_item_color_list" => $color),
                array("NAME" => $color),
            )
        ), false, false, array(
            "ID",
            "IBLOCK_ID",
            "NAME",
            "PREVIEW_PICTURE",
            "PROPERTY_item_color_list",
        ));
        if ($arColor = $rsColors->GetNext()) {
            if (!in_array($arColor['NAME'], $arItemColors)) {
                $arColor['NAME'] = $arColor['PROPERTY_ITEM_COLOR_LIST_VALUE'];
            }
            $colorName = ToUpper($arColor['NAME']);

            if (isset($arResult['COLORS'][$colorName])) {
                continue;
            }
            $arColor['PICTURE'] = GetResizedPicture($arColor['PREVIEW_PICTURE'], 50, 25);
            $arColor['SIZES'] = array();
            foreach ($arResult['SIZE_TO_COLORS'] as $size => $arColors) {
                if (isset($arColors[$colorName])) {
                    $arColor['SIZES'][] = array(
                        'SIZE' => $size,
                        'QUANTITY' => $arResult['SIZE_TO_COLORS'][$size][$colorName]['QUANTITY'],
                        'PRICE' => $arResult['SIZE_TO_COLORS'][$size][$colorName]['PRICE'],
                        'ID' => $arResult['SIZE_TO_COLORS'][$size][$colorName]['ID'],
                    );
                }
            }
            $arResult['COLORS'][$colorName] = $arColor;
        }
    }
}

$arColors = array_flip(array_keys($arResult['COLORS']));
$arResult['PRICE'] = CExFunctions::GetOptimalPrice($arResult['ID']);;
$arResult['CURRENCY'] = 'RUB';
foreach ($arResult['OFFERS'] as $key => $row) {
    $size_fare[$key] = !isset($arSizes[$row['PROPERTIES']['SIZE']['VALUE']]) ? 500 : $arSizes[$row['PROPERTIES']['SIZE']['VALUE']];
    $color_fare[$key] = $arColors[ToUpper($row['PROPERTIES']['COLOR']['VALUE'])];
}
array_multisort($size_fare, SORT_ASC, $color_fare, SORT_ASC, $arResult['OFFERS']);

foreach ($arResult['OFFERS'] as $key => $arOffer) {
    if ($arOffer['CATALOG_QUANTITY'] > 0) {
        $arResult['CURRENT_SIZE'] = $arOffer['PROPERTIES']['SIZE']['VALUE'];
        //$arResult['PRICE'] = $arOffer['MIN_PRICE']['VALUE'];
        $arResult['CURRENCY'] = $arOffer['MIN_PRICE']['CURRENCY'];
        $arResult['OFFER_ID'] = $arOffer['ID'];
        break;
    }
}

$arResult['PICTURE'] = array();
$arResult['SMALL_PICTURE'] = array();
$arResult['BIG_PICTURE'] = array();
if (is_array($arResult['DETAIL_PICTURE']) && $arResult['DETAIL_PICTURE']['WIDTH'] > 0) {
    $arResult['PICTURE'][] = GetResizedPicture($arResult['DETAIL_PICTURE'], CATALOG_DETAIL_PICTURE_WIDTH, CATALOG_DETAIL_PICTURE_HEIGHT);
    $arResult['BIG_PICTURE'][] = GetResizedPicture($arResult['DETAIL_PICTURE'], CATALOG_DETAIL_BIG_PICTURE_WIDTH, CATALOG_DETAIL_BIG_PICTURE_HEIGHT);
}

if (is_array($arResult['MORE_PHOTO']) && count($arResult['MORE_PHOTO']) > 0) {
    foreach ($arResult['MORE_PHOTO'] as $picture) {
        if (!is_array($picture) || $picture['WIDTH'] <= 0) {
            continue;
        }
        $arResult['PICTURE'][] = GetResizedPicture($picture, CATALOG_DETAIL_PICTURE_WIDTH, CATALOG_DETAIL_PICTURE_HEIGHT);
        $arResult['BIG_PICTURE'][] = GetResizedPicture($picture, CATALOG_DETAIL_BIG_PICTURE_WIDTH, CATALOG_DETAIL_BIG_PICTURE_HEIGHT);
    }
}


function recursectionLink($IBLOCK_ID, $ID) {
    $ar_result = CIBlockSection::GetList(array('SORT' => 'ASC'), array(
        'IBLOCK_ID' => $IBLOCK_ID,
        'ID' => $ID
    ), false, array('UF_ARTICLES_LINK'));
    $result = array();
    if ($res = $ar_result->GetNext()) {
        if ($res['IBLOCK_SECTION_ID'] != 0 && empty($res['UF_ARTICLES_LINK'])) {
            $result = recursectionLink($IBLOCK_ID, $res['IBLOCK_SECTION_ID']);
        } else {
            return $res['UF_ARTICLES_LINK'];
        }
    }
    return $result;
}

$arResult['ARTICLES_LINK'] = recursectionLINK($arResult['IBLOCK_ID'], $arResult['IBLOCK_SECTION_ID']);
if (!empty($arResult['ARTICLES_LINK'])) {
    foreach ($arResult['ARTICLES_LINK'] as $item) {
        $res = CIBlockElement::GetByID($item);
        if ($ar_res = $res->GetNext()) {
            $temp[] = $ar_res;
        }
    }
    $arResult['ARTICLES_LINK'] = $temp;
}


foreach ($arResult['DISPLAY_PROPERTIES'] as $key => $arProp) {
    if (is_array($arProp['VALUE']) && count($arProp['VALUE']) <= 0 || !is_array($arProp['VALUE']) && strlen($arProp['VALUE']) <= 0) {
        unset($arResult['DISPLAY_PROPERTIES'][$key]);
    }
}


// recommended products
$arRecommendedProductsArticles = array();
$linkPropValue = str_replace(' ', '', $arResult['PROPERTIES']['SWYAZ']['VALUE']);
if (strlen($linkPropValue) > 0) {
    if (is_array(explode(';', $linkPropValue))) {
        $arRecommendedProductsArticles = array_merge($arRecommendedProductsArticles, explode(';', $linkPropValue));
    } else {
        $arRecommendedProductsArticles[] = $linkPropValue;
    }
}
$linkPropValue = str_replace(' ', '', $arResult['PROPERTIES']['SWYAZ2']['VALUE']);
if (strlen($linkPropValue) > 0) {
    if (is_array(explode(';', $linkPropValue))) {
        $arRecommendedProductsArticles = array_merge($arRecommendedProductsArticles, explode(';', $linkPropValue));
    } else {
        $arRecommendedProductsArticles[] = $linkPropValue;
    }
}

$arRecommendedProductsIds = array();
if (count($arRecommendedProductsArticles) > 0 && strlen($arRecommendedProductsArticles[0]) > 0) {
    $rsFields = CIBlockElement::GetList(array(), array(
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'ACTIVE' => 'Y',
        'PROPERTY_CML2_ARTICLE' => $arRecommendedProductsArticles
    ), false, array('nTopCount' => 4), array('ID'));
    while ($arFields = $rsFields->GetNext()) {
        $arRecommendedProductsIds[] = $arFields['ID'];
    }
}

if (count($arRecommendedProductsIds) <= 0) {
    if (strlen($arResult['PROPERTIES']['COLECTION']['VALUE_ENUM_ID']) > 0) {
        //Определяем свойство категории для отображения. если есть то их используем если нето то берем все категории муж или жен

        //Определяем категории муж или жен
        $db_list = CIBlockSection::GetList(array($by => $order), array(
            'IBLOCK_ID' => CATALOG_IBLOCK_ID,
            '=CODE' => $arParams['SECTION_CODE'],
        ), false, array('UF_SECTION_RECOMEND'));
        while ($ar_result = $db_list->GetNext()) {
            $s_list = array();
            if (!empty($ar_result['UF_SECTION_RECOMEND'])) {
                $s_list = $ar_result['UF_SECTION_RECOMEND'];
            } else {
                $db_list2 = CIBlockSection::GetList(array($by => $order), array('IBLOCK_ID' => CATALOG_IBLOCK_ID, 'SECTION_ID' => $ar_result['IBLOCK_SECTION_ID']), false);
                while ($ar_result2 = $db_list2->GetNext()) {
                    $s_list[] = $ar_result2['ID'];
                }
            }
        }

        if (count($s_list) > 0) {
            $rsFields = CIBlockElement::GetList(array('rand' => 'rand'), array(
                'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                'ACTIVE' => 'Y',
                'PROPERTY_COLECTION' => $arResult['PROPERTIES']['COLECTION']['VALUE_ENUM_ID'],
                'SECTION_ID' => $s_list,
            ), false, array('nTopCount' => 4), array('ID'));
            while ($arFields = $rsFields->GetNext()) {
                $arRecommendedProductsIds[] = $arFields['ID'];
            }
        }
    }
}
$arResult['RECOMMENDED_PRODUCTS_IDS'] = $arRecommendedProductsIds;


$arVisitedProductsIds = $APPLICATION->get_cookie("VISITED");
if (isset($arVisitedProductsIds) && strlen($arVisitedProductsIds) > 0) {
    $arVisitedProductsIds = unserialize($arVisitedProductsIds);
} else {
    $arVisitedProductsIds = array();
}

if (!in_array($arResult["ID"], $arVisitedProductsIds)) {
    array_unshift($arVisitedProductsIds, $arResult["ID"]);

    if (count($arVisitedProductsIds) > 4) {
        array_pop($arVisitedProductsIds);
    }
    $APPLICATION->set_cookie("VISITED", serialize($arVisitedProductsIds), time() + 3600*24*30*12*2);
} else {
    $key = array_search($arResult["ID"], $arVisitedProductsIds);
    unset($arVisitedProductsIds[$key]);
    array_unshift($arVisitedProductsIds, $arResult["ID"]);
    $APPLICATION->set_cookie("VISITED", serialize($arVisitedProductsIds), time() + 3600*24*30*12*2);
}
