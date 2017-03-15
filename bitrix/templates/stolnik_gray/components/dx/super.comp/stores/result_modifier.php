<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();?>
<?

$arParams['IBLOCK_ID'] = intval($arParams['IBLOCK_ID']);
$arParams['ELEMENT_ID'] = intval($arParams['ELEMENT_ID']);


if ($arParams['IBLOCK_ID'] <= 0) {
    ShowMessage('Не указан инфоблок.');
    return;
}

if (!\Bitrix\Main\Loader::includeModule('iblock'))
    return false;


$rsFields = CIBlockElement::GetList(array(), array(
    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
    'ACTIVE' => 'Y',
    'ACTIVE_DATE' => 'Y',
    'ID' => $arParams['ELEMENT_ID']
), false, array('nTopCount' => 1), array('ID', 'NAME'));
if ($arFields = $rsFields->GetNext()) {
    $arResult = $arFields;

    $arOffersSettings = CIBlockPriceTools::GetOffersIBlock(CATALOG_IBLOCK_ID);

    $rsOffers = CIBlockElement::GetList(array(), array(
        'IBLOCK_ID' => $arOffersSettings['OFFERS_IBLOCK_ID'],
        'PROPERTY_' . $arOffersSettings['OFFERS_PROPERTY_ID'] => $arFields['ID'],
    ), false, false, array('ID'));
    $arOffersIds = array();
    while ($arOffer = $rsOffers->GetNext()) {
        $arOffersIds[] = $arOffer['ID'];
    }
    $arResult['STORES'] = array();
    $rsStores = CCatalogStoreProduct::GetList(array(), array(
        'PRODUCT_ID' => $arOffersIds,
        '>AMOUNT' => 0
    ));
    while ($arItem = $rsStores->getNext()) {
        if (!isset($arResult['STORES'][$arItem['PRODUCT_ID']])) {
            $arResult['STORES'][$arItem['PRODUCT_ID']] = array();
        }
        $arResult['STORES'][$arItem['PRODUCT_ID']][] = $arItem;
    }
}


// saving template name to cache array
$arResult['__TEMPLATE_FOLDER'] = $this->__folder;

// writing new $arResult to cache file
$this->__component->arResult = $arResult;
