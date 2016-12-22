<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (isset($arParams["TEMPLATE_THEME"]) && !empty($arParams["TEMPLATE_THEME"]))
{
	$arAvailableThemes = array();
	$dir = trim(preg_replace("'[\\\\/]+'", "/", dirname(__FILE__)."/themes/"));
	if (is_dir($dir) && $directory = opendir($dir))
	{
		while (($file = readdir($directory)) !== false)
		{
			if ($file != "." && $file != ".." && is_dir($dir.$file))
				$arAvailableThemes[] = $file;
		}
		closedir($directory);
	}

	if ($arParams["TEMPLATE_THEME"] == "site")
	{
		$solution = COption::GetOptionString("main", "wizard_solution", "", SITE_ID);
		if ($solution == "eshop")
		{
			$theme = COption::GetOptionString("main", "wizard_eshop_adapt_theme_id", "blue", SITE_ID);
			$arParams["TEMPLATE_THEME"] = (in_array($theme, $arAvailableThemes)) ? $theme : "blue";
		}
	}
	else
	{
		$arParams["TEMPLATE_THEME"] = (in_array($arParams["TEMPLATE_THEME"], $arAvailableThemes)) ? $arParams["TEMPLATE_THEME"] : "blue";
	}
}
else
{
	$arParams["TEMPLATE_THEME"] = "blue";
}

$arResult['FOUND_PROPS'] = false;
foreach($arResult["ITEMS"] as $key => $arItem) {
	if (isset($arItem["PRICE"])) {
		if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"]) {
			continue;
		}
		$arResult['FOUND_PROPS'] = true;
		break;
	} else {
		if (empty($arItem["VALUES"]) || isset($arItem["PRICE"])) {
			continue;
		}
		if (
			$arItem["DISPLAY_TYPE"] == "A"
			&& (
				!$arItem["VALUES"]["MIN"]["VALUE"]
				|| !$arItem["VALUES"]["MAX"]["VALUE"]
				|| $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"]
			)
		) {
			continue;
		}
		$arResult['FOUND_PROPS'] = true;
		break;
	}
}
