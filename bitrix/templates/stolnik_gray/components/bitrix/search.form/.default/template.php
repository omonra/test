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

$query = '';
if (isset($_GET['q']) && strlen(trim($_GET['q'])) > 0) {
    $query = htmlspecialcharsbx(trim($_GET['q']));
}

?>
<!-- <input type="text" placeholder="Поиск по каталогу"/> -->

<form action="<?=$arResult["FORM_ACTION"]?>" class="b-header__search">
	<?if($arParams["USE_SUGGEST"] === "Y"):?><?$APPLICATION->IncludeComponent(
				"bitrix:search.suggest.input",
				"",
				array(
					"NAME" => "q",
					"VALUE" => $query,
					"INPUT_SIZE" => 15,
					"DROPDOWN_SIZE" => 10,
				),
				$component, array("HIDE_ICONS" => "Y")
	);?><?else:?><input type="text" name="q" value="<?=$query?>" size="15" maxlength="50" placeholder="Поиск по каталогу" /><?endif;?>
	<input name="s" type="submit" value="" />
</form>
