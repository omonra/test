<?
/*$section_ids = array();
foreach($arResult['ITEMS'] as $arItem)
	if (!empty($arItem['OFFERS']))
		foreach($arItem['OFFERS'] as $arOffer)
			if ($arOffer['IBLOCK_SECTION_ID'])
				$section_ids[$arOffer['IBLOCK_ID']][$arOffer['IBLOCK_SECTION_ID']] = true;
	else
		if ($arItem['IBLOCK_SECTION_ID'])
			$section_ids[$arItem['IBLOCK_ID']][$arItem['IBLOCK_SECTION_ID']] = true;

$iblock_info = array();
$sections_info = array();
if ($section_ids) {
	foreach($section_ids as $iblock_id => $sections) {
		$db_section = CIBlockSection::GetList(
			Array(),
			array('IBLOCK_ID' => $iblock_id, 'ID' => array_keys($sections), '!UF_YM_CATEGORY' => false),
			true, array('UF_YM_CATEGORY')
		);
		while ($arSection = $db_section->Fetch()) {
			$sections_info[$arSection['ID']] = $arSection['UF_YM_CATEGORY'];
		}
	}
	$db_iblock = CIBlock::GetList(
		Array(), 
		Array(
			'SITE_ID'=>SITE_ID, 
			'ACTIVE'=>'Y', 
			'ID' => array_keys( $section_ids )
		)
	);
	while($arIblock = $db_iblock->Fetch())
		$iblock_info[$arIblock['ID']] = $arIblock['DESCRIPTION'];
}

$arResult['IBLOCK_INFO'] = $iblock_info;
$arResult['SECTIONS_INFO'] = $sections_info;*/
?>
