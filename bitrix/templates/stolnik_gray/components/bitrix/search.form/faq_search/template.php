<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="search-form">
	<form action="<?=$arResult["FORM_ACTION"]?>">
		<div class="search-input-text">
			<?if($arParams["USE_SUGGEST"] === "Y"):?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:search.suggest.input",
					"",
					array(
						"NAME" => "q",
						"VALUE" => "",
						"INPUT_SIZE" => 15,
						"DROPDOWN_SIZE" => 10,
					),
					$component, array("HIDE_ICONS" => "Y")
				);?>
			<?else:?>
				<input type="text" name="q" value="" size="15" maxlength="50" />
			<?endif;?>
		</div>
		<div class="search-button">
			<input class="button_1_2" name="s" type="submit" value="<?=GetMessage("BSF_T_SEARCH_BUTTON");?>" />
		</div>
	</form>
</div>
