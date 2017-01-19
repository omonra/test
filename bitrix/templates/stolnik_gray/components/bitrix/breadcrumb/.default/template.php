<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(empty($arResult) || count($arResult) <= 1) {
	return "";
}

$strReturn = '<ul class="b-breadscrumbs">';

for ($index = 0, $itemSize = count($arResult); $index < $itemSize; $index++) {

	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	if ($arResult[$index]["LINK"] <> "" && $index < $itemSize - 1) {
		$strReturn .= '<li>' . '<a href="' . $arResult[$index]["LINK"] . '" title="' . $title . '">' . $title . '</a></li>';
    } else {
		$strReturn .= '<li>' . $title . '</li>';
    }
}

$strReturn .= '</ul>';
return $strReturn;
