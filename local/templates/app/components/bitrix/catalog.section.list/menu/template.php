<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<ul class="left-nav catalog">
    <? foreach ($arResult['SUB_SECTIONS'] as $key => $arSubItem): ?>
    <li class="<?=$key?>"><a href="<?=$arSubItem['SECTION_PAGE_URL']?>"><?=$arSubItem['NAME']?> <span><?=$arSubItem['ELEMENT_CNT']?></span></a></li>
    <? endforeach; ?>
<? foreach ($arResult['SECTIONS'] as $arSection): ?>
    <li><a href="<?=$arSection['SECTION_PAGE_URL']?>"><?=$arSection['NAME']?> <span><?=$arSection['ELEMENT_CNT']?></span></a></li>
<? endforeach; ?>
</ul>
