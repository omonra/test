<?php

$arNewResult = Array ();
$parentId = -1;
foreach($arResult as $arItem)
{
    if ($arItem['DEPTH_LEVEL'] == 1)
    {
        $parentId++;
        $arNewResult[$parentId] = $arItem;
    }
    elseif ($arItem['DEPTH_LEVEL'] == 2)
    {
        $arNewResult[$parentId]['SUB'][] = $arItem;
    }
}

$arResult = $arNewResult;
