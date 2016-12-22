<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach (array('NEW' => 'NOVINKA', 'SALE' => 'RASPRODAZHA') as $key => $propCode) {
    $rsFields = CIBlockElement::GetList(array(), array(
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'ACTIVE' => 'Y',
        'SECTION_ID' => $arParams['SECTION_ID'],
        'INCLUDE_SUBSECTIONS' => 'Y',
        'PROPERTY_' . $propCode => 'true',
    ), array('active'));
    if ($arFields = $rsFields->GetNext()) {
        $arResult['COUNT_' . $key] = $arFields['CNT'];
    }
}
