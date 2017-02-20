<?php

$cache = new CPHPCache();
$cache_time = 3600;
$cache_id = 'arSectionsList';
$cache_path = '/iblock/catalog';
if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path))
{
    $res = $cache->GetVars();
    if (is_array($res["arSectionsList"]) && (count($res["arSectionsList"]) > 0))
        $arSections = $res["arSectionsList"];
}

if (!is_array($arSections))
{
    $arFilter = array(
		"IBLOCK_ID" => 4,
		"ACTIVE" => "Y",
                ">DEPTH_LEVEL" => "1",
                "GLOBAL_ACTIVE" => "Y",
	);
    $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID", "NAME", "IBLOCK_ID", "IBLOCK_SECTION_ID", "DEPTH_LEVEL"));
    while ($arCategory = $dbRes->Fetch())
    {
        $arSections[$arCategory['ID']] = $arCategory;
    }
    
    $arNewResult = Array ();
    $parentId = -1;
    foreach($arSections as $key => $arItem)
    {
        if ($arItem['DEPTH_LEVEL'] == 3)
        {
            $arSections[$arItem['IBLOCK_SECTION_ID']]['SUB'][] = $arItem;
            unset($arSections[$key]);
        }
    }


    if ($cache_time > 0)
    {
        $cache->StartDataCache($cache_time, $cache_id, $cache_path);
        $cache->EndDataCache(array("arSectionsList" => $arSections));
    }
}



//echo "<pre>";
//print_r($arSections);