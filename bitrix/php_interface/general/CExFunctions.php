<?php

class CExFunctions
{
    static function GetOptimalPrice($item_id, $sale_currency = 'RUB')
    {
        global $USER;

        $currency_code = 'RUB';
        $arResult = Array();
        $arPrice = Array ();
        // Do item have offers?
        if (CCatalogSku::IsExistOffers($item_id))
        {

            // Пытаемся найти цену среди торговых предложений
            $res = CIBlockElement::GetByID($item_id);

            if ($ar_res = $res->GetNext())
            {

                if (isset($ar_res['IBLOCK_ID']) && $ar_res['IBLOCK_ID'])
                {
                    $offers = CIBlockPriceTools::GetOffersArray(array(
                                'IBLOCK_ID' => $ar_res['IBLOCK_ID'],
                                'HIDE_NOT_AVAILABLE' => 'Y',
                                'CHECK_PERMISSIONS' => 'Y'
                                    ), array($item_id), null, null, null, null, null, null, array('CURRENCY_ID' => $sale_currency), $USER->getId(), null);

                    foreach ($offers as $offer)
                    {

                        $price = CCatalogProduct::GetOptimalPrice($offer['ID'], 1, $USER->GetUserGroupArray(), 'N');
                        if (isset($price['PRICE']))
                        {
                            $arPrice = $price;
                            break;
                        }
                    }
                }
            }
        }
        else
        {

            // Simple product, not trade offers
            $price = CCatalogProduct::GetOptimalPrice($item_id, 1, $USER->GetUserGroupArray(), 'N');

            // Got price?
            if (!$price || !isset($price['PRICE']))
            {
                return false;
            }

            // Change currency code if found
            if (isset($price['CURRENCY']))
            {
                $currency_code = $price['CURRENCY'];
            }
            if (isset($price['PRICE']['CURRENCY']))
            {
                $currency_code = $price['PRICE']['CURRENCY'];
            }

            // Get final price
            $arPrice = $price;

            
        }
        
        $arResult = Array (
                        'VALUE' => $arPrice['RESULT_PRICE']['BASE_PRICE'],
                        'DISCOUNT_VALUE' => $arPrice['RESULT_PRICE']['DISCOUNT_PRICE'],
                        'PRINT_VALUE' => CCurrencyLang::CurrencyFormat($arPrice['RESULT_PRICE']['BASE_PRICE'], $arPrice['RESULT_PRICE']['CURRENCY']),
                        'PRINT_DISCOUNT_VALUE' => CCurrencyLang::CurrencyFormat($arPrice['RESULT_PRICE']['DISCOUNT_PRICE'], $arPrice['RESULT_PRICE']['CURRENCY']),
                        'DISCOUNT_DIFF' => '',
                        'PRINT_DISCOUNT_DIFF' => '',
                        'DISCOUNT_DIFF_PERCENT' => '',
                        'CURRENCY' => $arPrice['RESULT_PRICE']['CURRENCY'],
                    );
                            
                    if ($arResult['VALUE'] > $arResult['DISCOUNT_VALUE'])
                    {
                        $arResult['DISCOUNT_DIFF'] = $arResult['VALUE'] - $arResult['DISCOUNT_VALUE'];
                        $arResult['PRINT_DISCOUNT_DIFF'] = CCurrencyLang::CurrencyFormat($arResult['DISCOUNT_DIFF'], $arResult['CURRENCY']);
                        $arResult['DISCOUNT_DIFF_PERCENT'] = roundEx(100*$arResult['DISCOUNT_DIFF'] / $arResult['VALUE'], 0);
                    }

        // Convert to sale currency if needed
        if ($currency_code != $sale_currency)
        {
            $final_price = CCurrencyRates::ConvertCurrency($arResult['DISCOUNT_VALUE'], $currency_code, $sale_currency);
            $value_price = CCurrencyRates::ConvertCurrency($arResult['VALUE'], $currency_code, $sale_currency);
            $currency_code = $sale_currency;
            $arResult['DISCOUNT_VALUE'] = $final_price;
            $arResult['PRINT_DISCOUNT_VALUE'] = CurrencyFormat($final_price, $currency_code);
            $arResult['VALUE'] = $value_price;
            $arResult['PRINT_VALUE'] = CurrencyFormat($value_price, $currency_code);
            
        }
        
        // Получаем старые цены
        $rsNeedProps = CIBlockElement::GetProperty($ar_res['IBLOCK_ID'], $ar_res['ID'], array("sort" => "asc"), Array("CODE"=> Array ("PRICE_OLD", "SALE") ));
        while ($arNeedProp = $rsNeedProps->fetch())
            $arNeedProps[$arNeedProp['CODE']] = $arNeedProp;
        
        if (!empty($arNeedProps['PRICE_OLD']['VALUE']) && floatval($arNeedProps['PRICE_OLD']['VALUE']) > floatval($arResult['VALUE']))
        {
            $arResult['OLD'] = Array (
                'VALUE' => $arNeedProps['PRICE_OLD']['VALUE'],
                'PRINT_VALUE' => CurrencyFormat($arNeedProps['PRICE_OLD']['VALUE'], $currency_code)
            );
            
            $arResult['DISCOUNT_DIFF'] = $arResult['OLD']['VALUE'] - $arResult['VALUE'];
            $arResult['PRINT_DISCOUNT_DIFF'] = CCurrencyLang::CurrencyFormat($arResult['DISCOUNT_DIFF'], $arResult['CURRENCY']);
            $arResult['DISCOUNT_DIFF_PERCENT'] = roundEx(100*$arResult['DISCOUNT_DIFF'] / $arResult['VALUE'], 0);
        }

        return $arResult;
    }
}
