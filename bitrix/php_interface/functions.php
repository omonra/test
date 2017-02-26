<?
// for debug
function dd() {
    $args = func_get_args();
    $bt =  debug_backtrace();
    $file = explode('www', $bt[0]['file']);
    $file = is_array($file) && count($file) > 1 ? $file[1] : $file;

    echo '<pre style="outline: 1px solid green; font-size: 10px; font-family: Arial; line-height: 1em; text-align: left;"><b>' . $file . ':'. $bt[0]['line'] . "</b>\n";
    $showKey = count($args) > 1;
    foreach ($args as $key => $value) {
        if ($showKey) {
            echo ($key + 1) . ': ';
        }
        print_r($value);
        if ($showKey) {
                echo '<br />';
        }
    }
    echo '</pre>';
}

function colored($str, $color = NULL) {
    $foreground_colors = array(
        'green' => '0;32',
        'cyan' => '0;36',
        'red' => '0;31',
        'white' => '1;37',
        'yellow' => '1;33',
        'blue' => '0;34',
    );

    $result = '';
    if (isset($foreground_colors[$color])) {
        $result .= "\033[".$foreground_colors[$color].'m';
    }
    $result .=  $str."\033[0m";
    return $result;
}

function df() {
    static $first = true;
    $args = func_get_args();

    $out = '';
    $showKey = count($args) > 1;
    foreach ($args as $key => $value) {
        $out .= "\n" . ($showKey ? ($key + 1) . ': ' : '') . print_r($value, true);
    }
    $out = toutf8($out);

    $bt =  debug_backtrace();
    $file = explode('www', $bt[0]['file']);
    $file = is_array($file) && count($file) > 1 ? $file[1] : $file;

    $f = fopen($_SERVER["DOCUMENT_ROOT"] . "/fifo", "a");
    if ($first) {
        fputs($f, "\n" . colored('###############################################################################', 'yellow'));
        $first = false;
    }
    fputs($f, "\n" . colored($file . ':' . $bt[0]['line'] . ': ', 'cyan') . $out ."\n");
    fclose($f);
}


function IsDev() {
    return is_object($GLOBALS["USER"]) && $GLOBALS["USER"]->IsAdmin() && $GLOBALS["USER"]->GetID() == 13464;
}

/*--------------------------------------------------------------------------*/
// common functions
/**
 * Возвращает изображение нужного размера
 */
function GetResizedPicture($arImage, $width, $height=0) {
    if ($width > 0 && (intval($arImage) > 0 || is_array($arImage))) {
        if ($height <= 0) {
            $height = $width;
        }
        $resizedImage = CFile::ResizeImageGet($arImage,
            array(
                "width" => $width,
                "height" => $height
            ), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        return array('SRC' => $resizedImage['src'], 'WIDTH' => $resizedImage['width'], 'HEIGHT' => $resizedImage['height']);
    }
    return false;
}

function AjaxIncModule($module) {
    if (!CModule::IncludeModule($module)) {
        $answer['log'] = 'module ' . $module . ' not found';
        print(json_encode($answer));
        die();
    }
}

function Show404() {
    global $APPLICATION, $USER;
    @define("ERROR_404", "Y");
    CHTTP::SetStatus("404 Not Found");
    $APPLICATION->RestartBuffer();
    require($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/header.php");
    require($_SERVER['DOCUMENT_ROOT'] . '/404.php');
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
    die();
}

function ShowTemplateJs($arJs) {
    global $APPLICATION;
    foreach ($arJs as $item) {
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/' . $item);
    }
}
function ShowTemplateCss($arJs) {
    global $APPLICATION;
    foreach ($arJs as $item) {
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/' . $item);
    }
}

function GetPriceCodes() {
    return array('Розничная');
}

function GetPriceId() {
    return '17'; // Розничная
}
/*
function GetElementLabel($arItem) {
    if ($arItem['PROPERTIES']['NOVINKA']['VALUE'] == 'true' || $arItem['PROPERTY_NOVINKA_VALUE'] == 'true') {
        return 'new';
    } elseif ($arItem['PROPERTIES']['RASPRODAZHA']['VALUE'] == 'true' || $arItem['PROPERTY_RASPRODAZHA_VALUE'] == 'true') {
        return 'sale';
    }
}
*/
function GetElementLabel($arItem) {
    if ($arItem['PROPERTIES']['RASPRODAZHA']['VALUE'] == 'true' || $arItem['PROPERTY_RASPRODAZHA_VALUE'] == 'true') {
        return 'sale';
    } elseif ($arItem['PROPERTIES']['NOVINKA']['VALUE'] == 'true' || $arItem['PROPERTY_NOVINKA_VALUE'] == 'true') {
        return 'new';
    }
}
function GetSizes() {
    static $arSizes = array();
    if (count($arSizes) <= 0) {
        $rsSizes = CIBlockElement::GetList(array('SORT' => 'asc'), array(
            'IBLOCK_ID' => SIZES_IBLOCK_ID,
            'ACTIVE' => 'Y',
        ), false, false, array(
            'ID',
            'IBLOCK_ID',
            'NAME',
            'SORT'
        ));
        while ($arSize = $rsSizes->GetNext()) {
            $arSizes[$arSize['NAME']] = $arSize['SORT'];
        }
    }
    return $arSizes;
}

// function GetColors() {
//     static $arColors = array();
//     if (count($arSizes) <= 0) {
//         $rsColors = CIBlockElement::GetList(array(), array(
//             "IBLOCK_ID" => 10,
//             "ACTIVE" => "Y",
//         ), false, false, array(
//             "ID",
//             "IBLOCK_ID",
//             "NAME",
//             "PREVIEW_PICTURE",
//             "PROPERTY_item_color_list"
//         ));
//         while ($arColor = $rsColors->GetNext()) {
//             dd($arColor);
//             // $cfile=CFile::ResizeImageGet($ar_fields['PREVIEW_PICTURE'], array('width'=>25, 'height'=>25), BX_RESIZE_IMAGE_PROPORTIONAL, true);
//             // if(strlen($ar_fields["PROPERTY_ITEM_COLOR_LIST_VALUE"])>0){
//             //     $ListColor[$ar_fields["PROPERTY_ITEM_COLOR_LIST_VALUE"]]=$cfile["src"];
//             //     $ListColorName[$ar_fields["PROPERTY_ITEM_COLOR_LIST_VALUE"]]=$ar_fields["NAME"];
//             // }
//             // else{
//             //     $ListColor[$ar_fields["NAME"]]=$cfile["src"];
//             //     $ListColorName[$ar_fields["PROPERTY_ITEM_COLOR_LIST_VALUE"]]=$ar_fields["NAME"];
//             // }
//         }
//     }
//     return $arColors;
// }

function PrepareSectionItems(&$arItems, $arParams) {
    $arSizes = GetSizes();

    foreach ($arItems as $key => $arItem) {
        // sort offers by colors and sizes and get price of first item
        $arItemSizes = array();
        $arItemColors = array();
        foreach ($arItem['OFFERS'] as $key2 => $arOffer) {
            if (!in_array($arOffer['PROPERTIES']['SIZE']['VALUE'], $arItemSizes)) {
                $arItemSizes[] = $arOffer['PROPERTIES']['SIZE']['VALUE'];
            }

            if (!in_array($arOffer['PROPERTIES']['COLOR']['VALUE'], $arItemColors)) {
                $arItemColors[] = $arOffer['PROPERTIES']['COLOR']['VALUE'];
            }
        }

        usort($arItemSizes, function($a, $b) use ($arSizes) {
            if ($a == $b) {
                return 0;
            }

            $a = !isset($arSizes[$a]) ? 500 : $arSizes[$a];
            $b = !isset($arSizes[$b]) ? 500 : $arSizes[$b];

            return $a > $b;
        });

        if (count($arItemColors) > 0) {
            $arColors = array();
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
                    if (isset($arColors[$colorName])) {
                        continue;
                    }
                    $arColors[$colorName] = 1;
                }
            }
        }

        $arColors = array_flip(array_keys($arColors));
        $arItem['PRICE'] = 0;
        $arItem['CURRENCY'] = 'RUB';
        foreach ($arItem['OFFERS'] as $key2 => $row) {
            $size_fare[$key2] = !isset($arSizes[$row['PROPERTIES']['SIZE']['VALUE']]) ? 500 : $arSizes[$row['PROPERTIES']['SIZE']['VALUE']];
            $color_fare[$key2] = $arColors[ToUpper($row['PROPERTIES']['COLOR']['VALUE'])];
        }
        array_multisort($size_fare, SORT_ASC, $color_fare, SORT_ASC, $arItem['OFFERS']);

        $priceFound = false;
        $arSize2Offer = array();
        foreach ($arItem['OFFERS'] as $key2 => $arOffer) {
            if ($arOffer['CATALOG_QUANTITY'] > 0) {
                if (!$priceFound) {
                    $priceFound = true;
                    $arItems[$key]['PRICE'] = $arOffer['MIN_PRICE']['VALUE'];
                    $arItems[$key]['CURRENCY'] = $arOffer['MIN_PRICE']['CURRENCY'];
                    $arItems[$key]['OFFER_ID'] = $arOffer['ID'];
                }

                if (!isset($arSize2Offer[$arOffer['PROPERTIES']['SIZE']['VALUE']])) {
                    $arSize2Offer[$arOffer['PROPERTIES']['SIZE']['VALUE']] = $arOffer['ID'];
                }
            }
        }
        // END sort offers by colors and sizes and get price of first item

        if (is_array($arItem['PREVIEW_PICTURE']) && $arItem['PREVIEW_PICTURE']['WIDTH'] > 0 || $arItem['PREVIEW_PICTURE'] > 0) {
            $arItems[$key]['PICTURE'] = GetResizedPicture($arItem['PREVIEW_PICTURE'], $arParams['PICTURE_WIDTH'], $arParams['PICTURE_HEIGHT']);
        } elseif (is_array($arItem['DETAIL_PICTURE']) && $arItem['DETAIL_PICTURE']['WIDTH'] > 0 || $arItem['DETAIL_PICTURE'] > 0) {
            $arItems[$key]['PICTURE'] = GetResizedPicture($arItem['DETAIL_PICTURE'], $arParams['PICTURE_WIDTH'], $arParams['PICTURE_HEIGHT']);
        } else {
            $arItems[$key]['PICTURE'] = GetResizedPicture(CATALOG_SECTION_NOPHOTO_FILE_ID, $arParams['PICTURE_WIDTH'], $arParams['PICTURE_HEIGHT']);
        }

        $arItemSizes = array();
        foreach ($arItem['OFFERS'] as $key2 => $arOffer) {
            if ($arOffer['CATALOG_QUANTITY'] <= 0) {
                continue;
            }
            if (!in_array($arOffer['PROPERTIES']['SIZE']['VALUE'], $arItemSizes)) {
                $arItemSizes[] = $arOffer['PROPERTIES']['SIZE']['VALUE'];
            }
        }
        usort($arItemSizes, function($a, $b) use ($arSizes) {
            if ($a == $b) {
                return 0;
            }
            return $arSizes[$a] > $arSizes[$b];
        });

        $arItems[$key]['SIZES'] = $arItemSizes;
        $arItems[$key]['SIZE2OFFER'] = $arSize2Offer;

        $arItems[$key]['LABEL'] = GetElementLabel($arItem);
    }
}

function FormatPrice($price, $currency) {
    if (!CModule::IncludeModule('sale')) {
        echo 'sale module not found';
        die();
    }
    return SaleFormatCurrency($price, $currency);
}

function UpdateCommentsCount($elementId, $deleteCommentId=0) {
    if (!CModule::IncludeModule('iblock')) {
        echo 'iblock module not found';
        die();
    }

    $rsElementFields = CIBlockElement::GetList(array(), array(
        'ID' => $elementId
    ), false, array('nTopCount' => 1), array('ID', 'IBLOCK_ID'));
    if ($arElementFields = $rsElementFields->GetNext()) {
        $arProps = array();
        foreach (array('comments_count', 'comments_sum') as $code) {
            $rsProp = CIBlockProperty::GetList(array(), array(
                'IBLOCK_ID' => $arElementFields['IBLOCK_ID'],
                'CODE' => $code,
            ));
            if ($arProp = $rsProp->Fetch()) {
                $arProps[$code] = $arProp;
            } else {
                $arPropFields = array(
                    'NAME' => $code,
                    'CODE' => $code,
                    'ACTIVE' => 'Y',
                    'SORT' => '1000',
                    'PROPERTY_TYPE' => 'N',
                    'IBLOCK_ID' => $arElementFields['IBLOCK_ID'],
                );
                $ibp = new CIBlockProperty;
                $propId = $ibp->Add($arPropFields);
                if ($propId > 0) {
                    $arPropFields['ID'] = $propId;
                    $arProps[$code] = $arPropFields;
                }
            }
        }

        if (count($arProps) == 2) {
            $rsFields = CIBlockElement::GetList(array(), array(
                'IBLOCK_ID' => COMMENTS_IBLOCK_ID,
                'ACTIVE' => 'Y',
                'ACTIVE_DATE' => 'Y',
                'PROPERTY_PRODUCT_ID' => $elementId,
                '!ID' => $deleteCommentId, // этот элемент еще не удален (OnBeforeIBlockElementDelete) но мы его уже не считаем
            ), false, false, array('ID', 'IBLOCK_ID', 'PROPERTY_RATING'));
            $count = 0;
            $rating_sum = 0;
            while ($arFields = $rsFields->GetNext()) {
                $count++;
                $rating_sum += intval($arFields['PROPERTY_RATING_VALUE']);
            }


            CIBlockElement::SetPropertyValuesEx($elementId, $arElementFields['IBLOCK_ID'], array($arProps['comments_count']['ID'] => $count));
            CIBlockElement::SetPropertyValuesEx($elementId, $arElementFields['IBLOCK_ID'], array($arProps['comments_sum']['ID'] => $rating_sum));

            if(defined("BX_COMP_MANAGED_CACHE")) {
                global $CACHE_MANAGER;
                $CACHE_MANAGER->ClearByTag("iblock_id_" . $arElementFields['IBLOCK_ID']);
            }
        }
    }
}

function GetPropertyId($iblockId, $code) {
    static $arProps = array();
    $key = $iblockId . '_' . $code;
    if (isset($arProps[$key])) {
        return $arProps[$key];
    }
    $rsFields = CIBlockProperty::GetList(array(), array(
        'IBLOCK_ID' => $iblockId,
        'CODE' => $code,
    ));
    if ($arFields = $rsFields->GetNext()) {
        $arProps[$key] = $arFields['ID'];
        return $arFields['ID'];
    }
}

function GetBasketJson() {
    if (!CModule::IncludeModule('iblock') || !CModule::IncludeModule('sale')) {
        echo 'iblock or sale module not found';
        die();
    }

    $arItems = array_filter(GetBasketList(), function($arItem) {
        return $arItem['DELAY'] != 'Y' && $arItem['CAN_BUY'] == 'Y';
    });

    $basket_count = 0;
    $total_price = 0;
    $currency = '';
    foreach ($arItems as $key => $arItem) {
        if ($currency == '' && strlen($arItem['CURRENCY']) > 0) {
            $currency = $arItem['CURRENCY'];
        }
        if ($arItem["CAN_BUY"] == "Y") {
            $total_price += $arItem['PRICE'] * $arItem['QUANTITY'];
            $basket_count += 1;
        }
    }
    $arRet = array(
        'ret' => $ret,
        'price' => $total_price,
        'price_formated' => FormatPrice($total_price, $currency),
        'all_price_formated' => FormatPrice($total_price, $currency),
        'basket_count' => $basket_count,
        'basket_count_formated' => $basket_count . ' ' . GetWordForm($basket_count, 'товар', 'товара', 'товаров'),
    );
    return $arRet;
}

function GetWordForm($num, $one, $two, $five) {
    $mod10 = $num % 10;
    $mod10div10 = $num % 100 / 10;
    if ($mod10 == 1 && ($mod10div10 > 2 || $mod10div10 < 1)) {
        return $one;
    } elseif ($mod10 > 1 && $mod10 < 5 && ($mod10div10 > 2 || $mod10div10 < 1)) {
        return $two;
    } else {
        return $five;
    }
}

function toutf8($str) {
    return mb_convert_encoding($str, "utf-8", "windows-1251");
}

function toutf8_deep($value) {
    if (is_array($value)) {
        $item = null;
        foreach ($value as &$item) {
            $item = toutf8_deep($item);
        }
        unset($item);
    } else {
        if (is_string($value)) {
            $value = toutf8($value);
        }
    }
    return $value;
}

function GetAvailableSortOrder() {
    return array(
        'price_asc' => array('PROPERTY_PRICE', 'по возрастанию цены'),
        'price_desc' => array('PROPERTY_PRICE', 'по убыванию цены'),
        'popularity_desc' => array('SHOW_COUNTER', 'по популярности'),
        'name_asc' => array('NAME', 'по названию'),
        'new_desc' => array('PROPERTY_NOVINKA', 'по новинкам'),
        'sale_desc' => array('PROPERTY_RASPRODAZHA', 'по скидке'),
    );
}

function GetSortOrder($defaultValue) {
    if (!isset($defaultValue) || strlen($defaultValue) <= 0) {
        $defaultValue = 'new_desc'; // price_asc
    }
    $arAvailableSortOrder = GetAvailableSortOrder();

    if ($defaultValue == 'new_desc') {
        $sort2 = 'created';
        $order2 = 'desc';
    } else {
        $sort2 = 'id';
        $order2 = 'desc';
    }

    if (isset($_GET['sort']) && strlen($_GET['sort']) > 0 && isset($arAvailableSortOrder[$_GET['sort']])) {
        list($sort, $order) = explode('_', $_GET['sort']);
    } else {
        $defaultValue = explode('_', $defaultValue);
        $sort = $defaultValue[0];
        $order = $defaultValue[1];
    }
    return array($sort, $order, $sort2, $order2);
}

function GetSortOrderControls($sort, $order) {
    $arAvailableSortOrder = GetAvailableSortOrder();
    $currentKey = $sort . '_' . $order;
    $ret = '<div class="b-sort">
    Сортировать: <div class="b-sort__name">';
    foreach ($arAvailableSortOrder as $key => $arSort) {
        if ($key != $currentKey) {
            continue;
        }
        $name = $arSort[1];
        $ret .= '<span>' . $name . '</span>';
    }
    $ret .= '<div class="b-sort__list js-sort__list">
            <ul>';
    foreach ($arAvailableSortOrder as $key => $arSort) {
        if ($key == $currentKey) {
            continue;
        }
        $name = $arSort[1];
        $ret .= '<li data-value="' . $key . '"">' . $name . '</li>';
    }
    $ret .= '</ul>
        </div>
    </div>
</div>';
    return $ret;
}

function GetIblockSort($sort, $order) {
    $arAvailableSortOrder = GetAvailableSortOrder();
    $currentKey = $sort . '_' . $order;
    if (isset($arAvailableSortOrder[$currentKey])) {
        return $arAvailableSortOrder[$currentKey][0];
    } else {
        $first = array_shift($arAvailableSortOrder);
        return $first[0];
    }
}

function CancelOrdersAgent() {
    global $DB, $USER;
    if (!CModule::IncludeModule('sale')) {
        echo 'sale module not found';
        die();
    }

    if (!$USER) {
        $USER = new CUser;
    }

    // O - Собран,Ожидается оплата
    // S - Обработан,ожидается подтверждение от Покупателя
    $rsFields = CSaleOrder::GetList(array(), array(
        '<DATE_STATUS' => date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), time() - 3600 * 24 * 5),
        'CANCELED' => 'N',
        '@STATUS_ID' => array('O', 'S'),
    ));
    $i = 0;
    while ($arFields = $rsFields->Fetch()) {
        CSaleOrder::CancelOrder($arFields['ID'], 'Y', 'Автоматическая отмена заказа.');
    }

    return "CancelOrdersAgent();";
}

function CountSpecialProducts(&$arItem, $sectionId, $iblockId) {
    $arCurVal = array();
    $arFilter = array(
        'IBLOCK_ID' => $iblockId,
        'ACTIVE' => 'Y',
        'SECTION_ID' => intval($sectionId),
        'INCLUDE_SUBSECTIONS' => 'Y',
    );
    $arFilter = array_merge($arFilter, GetCatalogSectionFilter());

    $obCache = new CPHPCache();
    if ($obCache->InitCache(36000, serialize($arFilter), '/iblock/catalog_count_products')) {
        $arCurVal = $obCache->GetVars();
    } elseif ($obCache->StartDataCache()) {
        if (\Bitrix\Main\Loader::includeModule('iblock')) {
            if (defined('BX_COMP_MANAGED_CACHE')) {
                global $CACHE_MANAGER;
                $CACHE_MANAGER->StartTagCache('/iblock/catalog_count_products');

                $arSpec = array('NEW' => 'NOVINKA', 'SALE' => 'SALE');
                $arActions = GetActiveActions();
                if (is_array($arActions) && count($arActions) > 0) {
                    $keys = array_keys($arActions);
                    $arSpec['ACTION'] = $arActions[$keys[0]]['PROPERTY_CODE'];
                }

                foreach ($arSpec as $key2 => $propCode) {
                    if (strlen($propCode) <= 0) {
                        continue;
                    }
                    if ($key2 == 'NEW')
                        $arFilter['PROPERTY_' . $propCode] = 'true';
                    else
                        $arFilter['!PROPERTY_' . $propCode] = false;
                    
                    $rsFields = CIBlockElement::GetList(array(), $arFilter, array('ACTIVE'));
                    if ($arFields = $rsFields->GetNext()) {
                        $arCurVal['COUNT_' . $key2] = $arFields['CNT'];
                    }
                    unset($arFilter['PROPERTY_' . $propCode]);
                }

                if (count($arCurVal) > 0) {
                    $CACHE_MANAGER->RegisterTag('iblock_id_'.$iblockId);
                }
                $CACHE_MANAGER->EndTagCache();
            } // else: не гоже в наше время пользовать старенький кэш
        }
        $obCache->EndDataCache($arCurVal);
    }
    foreach ($arCurVal as $key => $val) {
        $arItem[$key] = $val;
    }
}

function CountSectionsProducts($arSectionIds, $iblockId) {
    $arResult = array();
    $arFilter = array(
        'IBLOCK_ID' => $iblockId,
        'ACTIVE' => 'Y',
        'INCLUDE_SUBSECTIONS' => 'Y',
    );
    $arFilter = array_merge($arFilter, GetCatalogSectionFilter());

    $obCache = new CPHPCache();
    if ($obCache->InitCache(36000, serialize(array($iblockId, $arSectionIds)), '/iblock/catalog_count_sections_products')) {
        $arResult = $obCache->GetVars();
    } elseif ($obCache->StartDataCache()) {
        if (\Bitrix\Main\Loader::includeModule('iblock')) {
            if (defined('BX_COMP_MANAGED_CACHE')) {
                global $CACHE_MANAGER;
                $CACHE_MANAGER->StartTagCache('/iblock/catalog_count_sections_products');

                foreach ($arSectionIds as $key => $sectionId) {
                    $arFilter['SECTION_ID'] = $sectionId;
                    $rsFields = CIBlockElement::GetList(array(), $arFilter, array('ACTIVE'));
                    if ($arFields = $rsFields->GetNext()) {
                        $arResult[$sectionId] = $arFields['CNT'];

                        // clear menu and sidebar cache
                        // не понятко как, но иногда колечество товаров в
                        // меню и левой панели различается,
                        // поэтому есть этот костыль
                        BXClearCache(true, '/s1/dx/super.comp/sidebar');
                        BXClearCache(true, '/s1/bitrix/menu');
                    }
                }

                if (count($arResult) > 0) {
                    $CACHE_MANAGER->RegisterTag('iblock_id_'.$iblockId);
                }
                $CACHE_MANAGER->EndTagCache();
            } // else: не гоже в наше время пользовать старенький кэш
        }
        $obCache->EndDataCache($arResult);
    }
    return $arResult;
}

function GetCatalogSectionFilter() {
    return array(
        // '>CATALOG_PRICE_' . GetPriceId() => '0',
         'CATALOG_AVAILABLE' => 'Y',
        '!DETAIL_PICTURE' => false,
        'ACTIVE' => 'Y'
    );
}

function SendSms($phone, $text, $sender='STOLNIK') {
    if (strlen($phone) < 7 || strlen($text) <= 0 || strlen(SMS_API_ID) <= 0) {
        return;
    }
    if (!CanSendSms($phone, $text, $sender)) {
        return;
    }
    df('sms: ' . $phone . ': ' , $text);
    $url = 'https://sms.ru/sms/send';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
        'api_id' => SMS_API_ID,
        'to' => $phone,
        'from' => $sender,
        'text' =>  iconv('windows-1251', 'utf-8', $text),
        'partner_id' => 41468,
    ));
    $body = curl_exec($ch);
    curl_close($ch);

    $status = explode("\n", $body);
    $status = intval($status[0]);
    if ($status !== 100) {
        df('sms sending error', $body);
    } else {
        SmsWriteLog($phone, $text, $sender);
    }
}

function GetSmsKey($phone, $text, $sender) {
    return md5(implode('|', array($phone, $text, $sender)));
}

function SmsWriteLog($phone, $text, $sender) {
    df('SmsWriteLog');
    if (!\Bitrix\Main\Loader::includeModule('highloadblock')) {
        return false;
    }

    $hlblock = Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter' => array('ID' => SMSLOG_HLBLOCK_ID)))->fetch();
    if (count($hlblock) <= 0) {
        df('error: empty hlblock');
        return;
    }
    $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
    $SmsLogDataClass = $entity->getDataClass();
    $result = $SmsLogDataClass::add(array(
        'UF_DATE' => new Bitrix\Main\Type\DateTime(),
        'UF_PHONE' => $phone,
        'UF_TEXT' => $text,
        'UF_SENDER' => $sender,
        'UF_KEY' => GetSmsKey($phone, $text, $sender),
    ));
    if(!$result->isSuccess()) {
        $errors = $result->getErrorMessages();
        df($errors);
    }
}

function CanSendSms($phone, $text, $sender) {
    $key = GetSmsKey($phone, $text, $sender);

    if (!\Bitrix\Main\Loader::includeModule('highloadblock')) {
        return false;
    }

    $hlblock = Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter' => array('ID' => SMSLOG_HLBLOCK_ID)))->fetch();
    if (count($hlblock) <= 0) {
        df('error: empty hlblock');
        return;
    }
    $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
    $SmsLogDataClass = $entity->getDataClass();
    $iterator = $SmsLogDataClass::getList(array(
        'filter' => array(
            '>UF_DATE' => Bitrix\Main\Type\DateTime::createFromTimestamp(time() - 3600),
            'UF_KEY' => $key,
        ),
        'limit' => 1,
        'select' => array('ID'),
    ));

    if ($item = $iterator->Fetch()) {
        return false;
    }

    return true;
}

function OrderStatusHandler($orderId) {
    $rsOrder = CSaleOrder::GetList(array(), array('ID' => $orderId), false, array('nTopCount' => 1), array('ID', 'USER_ID', 'STATUS_ID'));
    if ($arOrder = $rsOrder->Fetch()) {
        $arFields = array(
            'STATUS' => $arOrder['STATUS_ID'],
            'ORDER_ID' => $arOrder['ID'],
            'SENDER' => 'STOLNIK'
        );
        if (strlen($_POST['ORDER_PROP_3'])) {
            $phone = preg_replace('/[^0-9]/', '', $_POST['ORDER_PROP_3']);
            $arFields['PHONE'] = $phone;
        } else {
            $db_sales = CSaleOrderUserProps::GetList(
                array('DATE_UPDATE' => 'DESC'),
                array('USER_ID' => $arOrder['USER_ID'])
            );
            if ($ar_sales = $db_sales->Fetch()) {
                $db_propVals = CSaleOrderUserPropsValue::GetList(array('ID' => 'ASC'), array(
                    'USER_PROPS_ID' => $ar_sales['ID'],
                    'CODE' => 'PHONE',
                ));
                if ($arPropVals = $db_propVals->Fetch()) {
                    $phone = preg_replace('/[^0-9]/', '', $arPropVals['VALUE']);
                    $arFields['PHONE'] = $phone;
                }
            }
        }
        if (strlen($arFields['PHONE']) > 0) {
            $rsMessageTemplate = CEventMessage::GetList($by="ID", $order="DESC", array(
                'TYPE_ID' => 'SMS_SALE_STATUS_CHANGED_' . $arOrder['STATUS_ID'],
            ));
            if ($arMessageTemplate = $rsMessageTemplate->Fetch()) {
                $replaceKeys = array_map(function($key) {
                    return '#' . $key . '#';
                }, array_keys($arFields));
                $arMessageTemplate['EMAIL_FROM'] = trim(str_replace($replaceKeys, $arFields, $arMessageTemplate['EMAIL_FROM']));
                $arMessageTemplate['EMAIL_TO'] = trim(str_replace($replaceKeys, $arFields, $arMessageTemplate['EMAIL_TO']));
                $arMessageTemplate['MESSAGE'] = trim(str_replace($replaceKeys, $arFields, $arMessageTemplate['MESSAGE']));

                SendSms($arMessageTemplate['EMAIL_TO'], $arMessageTemplate['MESSAGE'], $arMessageTemplate['EMAIL_FROM']);
            }
        }
    }
}

function GetOffersSettings($iblockId) {
    static $arOffers = array();
    if (count($arOffers) <= 0) {
        $arOffers = CIBlockPriceTools::GetOffersIBlock($iblockId);
    }
    return $arOffers;
}

function GetBasketItemsForAction($propertyCode, $quantity, $arUserGroups, $orderId) {
    static $arBasketItems = array();
    if (count($arBasketItems) <= 0) {
        $arBaketIdsToAction = array();
        $arBasketFilter = array(
            'ORDER_ID' => $orderId,
            'DELAY' => 'N',
            'CAN_BUY' => 'Y',
        );
        if ($orderId == 'NULL') {
            $arBasketFilter['FUSER_ID'] = CSaleBasket::GetBasketUserID();
        }

        $dbBasketItems = CSaleBasket::GetList(array(), $arBasketFilter, false, false, array('ID', 'PRODUCT_ID', 'QUANTITY')
        );
        while ($arItem = $dbBasketItems->Fetch()) {
            if (!isset($arBaketIdsToAction[$arItem['PRODUCT_ID']])) {
                $arOffers = GetOffersSettings(CATALOG_IBLOCK_ID);
                $rsFields = CIBlockElement::GetList(array(), array(
                    'ACTIVE' => 'Y',
                    'ID' => $arItem['PRODUCT_ID'],
                ), false, array('nTopCount' => 1), array(
                    'ID',
                    'IBLOCK_ID',
                    'PROPERTY_' . $arOffers['OFFERS_PROPERTY_ID'],
                ));
                if ($arFields = $rsFields->GetNext()) {
                    if ($arFields['IBLOCK_ID'] == $arOffers['OFFERS_IBLOCK_ID']) {
                        if ($arFields['PROPERTY_' . $arOffers['OFFERS_PROPERTY_ID'] . '_VALUE'] > 0) {
                            $rsFields = CIBlockElement::GetList(array(), array(
                                'IBLOCK_ID' => CATALOG_IBLOCK_ID,
                                'ACTIVE' => 'Y',
                                'ID' => $arFields['PROPERTY_' . $arOffers['OFFERS_PROPERTY_ID'] . '_VALUE'],
                            ), false, array('nTopCount' => 1), array(
                                'ID',
                                'PROPERTY_' . $propertyCode,
                            ));
                            if ($arFields = $rsFields->GetNext()) {
                                $arBaketIdsToAction[$arItem['PRODUCT_ID']] = array(
                                    'ACTION' => strlen($arFields['PROPERTY_' . $propertyCode . '_VALUE']) > 0 && $arFields['PROPERTY_' . $propertyCode . '_VALUE'] !== 'false',
                                    'QUANTITY' => $arItem['QUANTITY'],
                                );
                            }
                        }
                    } elseif ($arFields['IBLOCK_ID'] == CATALOG_IBLOCK_ID) {
                        $rsFields = CIBlockElement::GetList(array(), array(
                            'IBLOCK_ID' => CATALOG_IBLOCK_ID,
                            'ACTIVE' => 'Y',
                            'ID' => $arItem['PRODUCT_ID'],
                        ), false, array('nTopCount' => 1), array(
                            'ID',
                            'PROPERTY_' . $propertyCode,
                        ));
                        if ($arFields = $rsFields->GetNext()) {
                            $arBaketIdsToAction[$arItem['PRODUCT_ID']] = array(
                                'ACTION' => strlen($arFields['PROPERTY_' . $propertyCode . '_VALUE']) > 0 && $arFields['PROPERTY_' . $propertyCode . '_VALUE'] !== 'false',
                                'QUANTITY' => $arItem['QUANTITY'],
                            );
                        }
                    }
                }
            }
            $arItem['ACTION'] = strlen($arBaketIdsToAction[$arItem['PRODUCT_ID']]['ACTION']) > 0;

            $dbPriceList = CPrice::GetListEx(
                array(),
                array(
                        'PRODUCT_ID' => $arItem['PRODUCT_ID'],
                        'GROUP_GROUP_ID' => $arUserGroups,
                        'GROUP_BUY' => 'Y',
                        '+<=QUANTITY_FROM' => $quantity,
                        '+>=QUANTITY_TO' => $quantity,
                        'CATALOG_GROUP_ID' => GetPriceId(),
                    ),
                false,
                false,
                array('ID', 'CATALOG_GROUP_ID', 'PRICE', 'CURRENCY')
            );
            $arPrices = array();
            if ($arPriceList = $dbPriceList->Fetch()) {
                $arItem['PRICE'] = $arPriceList['PRICE'];

            }

            $arBasketItems[$arItem['PRODUCT_ID']] = $arItem;
        }
    }

    return $arBasketItems;
}

function GetActionItemsFromOrder($propertyCode, $quantity, $arUserGroups, $orderId, $actionProductNum) {
    $arBasketItems = GetBasketItemsForAction($propertyCode, $quantity, $arUserGroups, $orderId);

    $arActionsItems = array_filter($arBasketItems, function($arItem) {
        return $arItem['ACTION'];
    });

    $arActionProducts = array();
    if (count($arActionsItems) > 0) {
        usort($arActionsItems, function($a, $b) {
            if ($a['PRICE'] == $b['PRICE']) {
                return 0;
            }
            return $a['PRICE'] > $b['PRICE'] ? 1 : -1;
        });
        $actionCount = 0;

        $productInfo = GetProductInfoFromPOST($orderId);
        foreach ($arActionsItems as $key => $arItem) {
            if (isset($productInfo[$arItem['ID']])) {
                $arItem['QUANTITY'] = $productInfo[$arItem['ID']]['QUANTITY'];
            }
            $actionCount += $arItem['QUANTITY'];
        }
        $actionCount = floor($actionCount / $actionProductNum);
        $arActionProducts = array_map(function($el) use (&$actionCount) {
            if ($actionCount > 0) {
                $quantity = $actionCount > $el['QUANTITY'] ? $el['QUANTITY'] : $actionCount;
                $actionCount -= $quantity;
            } else {
                $quantity = 0;
            }
            return array(
                'PRODUCT_ID' => $el['PRODUCT_ID'],
                'QUANTITY' => $quantity,
            );
        }, $arActionsItems);
    }

    return $arActionProducts;
}

function GetActionPriceForProduct($price, $propertyCode, $orderId, $intProductID, $quantity, $arUserGroups, $actionProductNum, $actionDiscount) {

    $actionDiscount /= 100;

    $arActionProducts = GetActionItemsFromOrder($propertyCode, $quantity, $arUserGroups, $orderId, $actionProductNum);

    foreach ($arActionProducts as $key => $arItem) {
        if ($arItem['QUANTITY'] > 0 && $arItem['PRODUCT_ID'] == $intProductID) {
            // $arItem['QUANTITY'] - на это количество товара начисляется скидка
            $oldPrice = $price['RESULT_PRICE']['BASE_PRICE'];
            $price['RESULT_PRICE']['DISCOUNT_PRICE'] = $oldPrice * (1 - $actionDiscount * $arItem['QUANTITY'] / $quantity);
            $price['RESULT_PRICE']['DISCOUNT'] = $oldPrice - $price['RESULT_PRICE']['DISCOUNT_PRICE'];
        }
    }

    return $price;
}

function GetActiveActions($orderId) {
    static $arActions = array();
    static $actionsLoaded = false;
    $check = isset($orderId) && strlen($orderId) > 0 && $orderId !== 'NULL' ? $orderId : true;
    if ($actionsLoaded !== $check) {

        $orderActionEnabled = array();
        if (isset($orderId) && strlen($orderId) > 0 && $orderId !== 'NULL') {
            $rsProp = CSaleOrderPropsValue::GetList(array(), array(
                "ORDER_ID" => $orderId,
                "ORDER_PROPS_ID" => ACTION_ENABLED_ORDER_PROP_ID
            ));
            if ($arProp = $rsProp->Fetch()) {
                $orderActionEnabled = explode(';', $arProp['VALUE']);
            }
        }

        $arCurrentActions = array(
            '50_2' => array(
                'COUNT' => 2,
                'DISCOUNT' => 50
            ),
            '100_3' => array(
                'COUNT' => 3,
                'DISCOUNT' => 100
            )
        );
        if (count($orderActionEnabled) > 0) {
            foreach ($orderActionEnabled as $actionCode) {
                $arAction = $arCurrentActions[$actionCode];
                $arActions[$actionCode] = array(
                    'PROPERTY_CODE' => COption::GetOptionString('stolnik', 'ss_action_' . $actionCode . '_property_code', 'AKTSIYA'),
                    'SORT' => COption::GetOptionString('stolnik', 'ss_action_' . $actionCode . '_sort', '100'),
                    'COUNT' => $arAction['COUNT'],
                    'DISCOUNT' => $arAction['DISCOUNT'],
                    'CODE' => $actionCode,
                );
            }
        } else {
            foreach ($arCurrentActions as $actionCode => $arAction) {
                if (COption::GetOptionString('stolnik', 'ss_action_' . $actionCode . '_active', 'N') == 'Y') {
                    $arActions[$actionCode] = array(
                        'PROPERTY_CODE' => COption::GetOptionString('stolnik', 'ss_action_' . $actionCode . '_property_code', 'AKTSIYA'),
                        'SORT' => COption::GetOptionString('stolnik', 'ss_action_' . $actionCode . '_sort', '100'),
                        'COUNT' => $arAction['COUNT'],
                        'DISCOUNT' => $arAction['DISCOUNT'],
                        'CODE' => $actionCode,
                    );
                }
            }
        }

        uasort($arActions, function($a, $b) {
            if ($a['SORT'] == $b['SORT']) {
                return 0;
            }
            return $a['SORT'] > $b['SORT'] ? 1 : -1;
        });
        $actionsLoaded = isset($orderId) && strlen($orderId) > 0 && $orderId !== 'NULL' ? $orderId : true;
    }
    return $arActions;
}

function CheckActionIsApplyed($row, $value) {
    $arActions = GetActiveActions();
    $orderId = GetOrderIdFromPOST();
    $arUserGroups = GetUserGroupsByOrderId($orderId);
    foreach ($arActions as $arAction) {
        $arActionProducts = GetActionItemsFromOrder($arAction['PROPERTY_CODE'], 1, $arUserGroups, $orderId, $arAction['COUNT']);
        foreach ($arActionProducts as $arItem) {
            if ($arItem['QUANTITY'] > 0 && $row['PRODUCT_ID'] == $arItem['PRODUCT_ID']) {
                return true;
            }
        }

    }
    return false;
}

function GetOrderIdFromPOST() {
    $orderId = 'NULL';
    if (isset($_POST['ORDER_AJAX']) && isset($_POST['id']) && intval($_POST['id']) > 0) {
        $orderId = intval($_POST['id']);
    } elseif (isset($_POST['save_order_data']) && isset($_POST['ID']) && intval($_POST['ID']) > 0) {
        $orderId = intval($_POST['ID']);
    }
    return $orderId;
}

function GetUserGroupsByOrderId($orderId) {
    static $arUserGroups = array();
    if (!isset($arUserGroups[$orderId])) {
        $userId = 0;
        if (isset($orderId) && intval($orderId) > 0) {
            $arUserGroups[$orderId] = array();
            if ($arOrder = CSaleOrder::GetById($orderId)) {
                $userId = $arOrder['USER_ID'];
            }
        } else {
            $userId = $GLOBALS['USER']->GetId();
        }
        $rsGroup = CUser::GetUserGroupList($userId);
        while ($arGroup = $rsGroup->Fetch()) {
            $arUserGroups[$orderId][] = $arGroup['GROUP_ID'];
        }
    }
    return $arUserGroups[$orderId];
}

function GetProductInfoFromPOST($orderId) {
    $inAdmin = intval($orderId) > 0;
    $productInfo = array();
    if ($inAdmin) {
        if (strlen($_POST['product']) > 0) {
            $productInfo = CUtil::JsObjectToPhp($_POST['product']);
        } elseif (is_array($_POST['PRODUCT']) && count($_POST['PRODUCT']) > 0) {
            $productInfo = $_POST['PRODUCT'];
        }
    }
    return $productInfo;
}

function AddEditButtons(&$arFields) {
    $arButtons = CIBlock::GetPanelButtons(
        $arFields["IBLOCK_ID"],
        $arFields["ID"],
        0,
        array("SECTION_BUTTONS"=>false, "SESSID"=>false)
    );
    $arFields["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
    $arFields["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];
}

function YmlExport() {
    CAgent::AddAgent("YmlExport_();");
}

function YmlExport_() {
    df('yml export ' . date('Y-m-d H:i:s'));
    require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/echange/yandex3.php');
    df('yml export done ' . date('Y-m-d H:i:s'));
}
