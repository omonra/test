<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
CModule::IncludeModule("catalog");
echo "<pre>";

$arFilter = Array(
    "ACTIVE" => 'Y',
    'IBLOCK_ID' => CATALOG_IBLOCK_ID
);

//$arFilter = Array('ID' => 390786);
$rsProducts = CIBlockElement::GetList(array(), $arFilter, false, false, array('ID', 'IBLOCK_ID', 'PROPERTY_PRICE_OLD', 'PROPERTY_SALE', 'PROPERTY_RASPRODAZHA'));
//echo "fff";
while ($arProduct = $rsProducts->Fetch())
{
    //print_r($arProduct);
    $offers = CIBlockPriceTools::GetOffersArray(array(
                'IBLOCK_ID' => $arProduct['IBLOCK_ID'],
                'HIDE_NOT_AVAILABLE' => 'Y',
                    //'CHECK_PERMISSIONS' => 'Y'
                    ), array($arProduct['ID']), null, null, null, null, null, null, array('CURRENCY_ID' => 'RUB'), null, null);

    $arOffers = Array();
    foreach ($offers as $offer)
    {
        $price = CCatalogProduct::GetOptimalPrice($offer['ID'], 1);
        $arOffers[] = $price['RESULT_PRICE']['DISCOUNT_PRICE'];
    }

    sort($arOffers);

    if (is_array($arOffers) && count($arOffers) > 0)
    {
        $arProps = Array(
            'MINIMUM_PRICE' => $arOffers[0],
            'MAXIMUM_PRICE' => end($arOffers)
        );


        if ($arProduct['PROPERTY_RASPRODAZHA_VALUE'] == "Да")
            $arProps['SALE'] = "Y";

        $arProps['PRICE_OLD'] = $arProps['MINIMUM_PRICE'];


        CIBlockElement::SetPropertyValuesEx($arProduct['ID'], $arProduct['IBLOCK_ID'], $arProps);
    }


    echo $arProduct['ID'] . "\n";
}
?>

