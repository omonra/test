<?
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/app/catalog/menu.ext.php");

if (isset($_REQUEST['SECTION_ID']) && isset($arSections[$_REQUEST['SECTION_ID']]))
{
    $arSections = "";
}

?>

<ul class="left-nav">
<? foreach ($arSections as $arSection): ?>
    <? if ($arSection['DEPTH_LEVEL'] == "2"): ?>
    <li><a href="/app/catalog/menu.php?SECTION_ID=<?=$arSection['ID']?>"><?=$arSection['NAME']?> <span><?=$arSection['ELEMENT_CNT']?></span></a></li>
    <? elseif ($arSection['DEPTH_LEVEL'] == "3"): ?>
    <li><a href="/app/catalog/index.php?SECTION_ID=<?=$arSection['ID']?>"><?=$arSection['NAME']?> <span><?=$arSection['ELEMENT_CNT']?></span></a></li>
    <? endif; ?>
<? endforeach; ?>
</ul>