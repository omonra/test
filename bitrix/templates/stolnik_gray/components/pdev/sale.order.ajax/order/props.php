<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();
?>
	<input id="ORDER_PROP_25" class="text_input text_input_1" type="hidden" value="<?if(!empty($arUser['UF_BLACK']))echo "в чёрном списке";?>" name="ORDER_PROP_25">
<?

function PrintPropsForm($arSource=array(), $arPropCodes=array(), $arParams) {
	if (empty($arSource)) {
		return false;
	}

	foreach ($arSource as $arProperties) {
		if (!in_array($arProperties['CODE'], $arPropCodes)) {
			continue;
		}

		if (isset($arParams['require_zip']) && $arParams['require_zip'] && $arProperties['CODE'] == 'ZIP') {
			$arProperties['REQUIED_FORMATED'] = 'Y';
		}
		?>
		<li>
		<label for="<?=$arProperties["FIELD_NAME"]?>"><?= $arProperties["NAME"] ?><?if($arProperties["REQUIED_FORMATED"]=="Y"):?>&nbsp;<span class="footnote">*</span><?endif;?></label>
		<?
		if($arProperties["TYPE"] == "CHECKBOX")
		{
			?>

		<input type="hidden" name="<?=$arProperties["FIELD_NAME"]?>" value="">
		<input type="checkbox" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" value="Y"<?if ($arProperties["CHECKED"]=="Y") echo " checked";?>>
		<?
		}
		elseif($arProperties["TYPE"] == "TEXT")
		{
		if ($arProperties['CODE'] == 'DATE'):?>
			<select name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties['FIELD_ID']?>">
				<?
				$currentDate = time();
				for ($i = 1; $i < 5; $i++):
					$val = FormatDate('l, d F', $currentDate + 3600*24*$i);
					?>
					<option<?=(isset($arProperties['VALUE']) && $arProperties['VALUE'] == $val ? ' selected="selected"' : '')?>><?=$val?></option>
				<?endfor;?>
			</select>
		<?else:?>
		<input id="<?=$arProperties["FIELD_NAME"]?>" class="text_input text_input_1<?if($arProperties['CODE'] == 'CITY'):?> input_autocomplete<?endif;?>" type="text" name="<?=$arProperties["FIELD_NAME"]?>" value="<?=$arProperties["VALUE"]?>"<?if (strlen($arProperties["DESCRIPTION"]) > 0):?> placeholder="<?=$arProperties["DESCRIPTION"]?>"<?endif;?> />

			<?if ($arProperties['CODE'] == 'EMAIL'):?>
			<span class="b-checkbox-wrap">
                            <label><input type="checkbox" name="subscribe"<?=($arParams['subscribe'] == 1 ? ' checked="checked"' : '')?> />Получать актуальную информацию</label>
                        </span>
		<?endif;?>
		<?endif;
		}
		elseif($arProperties["TYPE"] == "SELECT")
		{
		?>
			<select name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
				<?
				foreach($arProperties["VARIANTS"] as $arVariants)
				{
					?>
					<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
					<?
				}
				?>
			</select>
		<?
		}
		elseif ($arProperties["TYPE"] == "MULTISELECT")
		{
		?>
			<select multiple name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
				<?
				foreach($arProperties["VARIANTS"] as $arVariants)
				{
					?>
					<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
					<?
				}
				?>
			</select>
		<?
		}
		elseif ($arProperties["TYPE"] == "TEXTAREA")
		{
		?>
			<textarea rows="<?=$arProperties["SIZE2"]?>" cols="<?=$arProperties["SIZE1"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>"><?=$arProperties["VALUE"]?></textarea>
		<?
		}
		elseif ($arProperties["TYPE"] == "LOCATION")
		{
		$value = 0;
		if (is_array($arProperties["VARIANTS"]) && count($arProperties["VARIANTS"]) > 0)
		{
			foreach ($arProperties["VARIANTS"] as $arVariant)
			{
				if ($arVariant["SELECTED"] == "Y")
				{
					$value = $arVariant["ID"];
					break;
				}
			}
		}
		?>
			<?
			$GLOBALS["APPLICATION"]->IncludeComponent(
				"bitrix:sale.ajax.locations",
				"popup",
				array(
					"AJAX_CALL" => "N",
					"COUNTRY_INPUT_NAME" => "COUNTRY",
					"REGION_INPUT_NAME" => "REGION",
					"CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
					"CITY_OUT_LOCATION" => "Y",
					"LOCATION_VALUE" => $value,
					"ORDER_PROPS_ID" => $arProperties["ID"],
					"ONCITYCHANGE" => ($arProperties["IS_LOCATION"] == "Y" || $arProperties["IS_LOCATION4TAX"] == "Y") ? "submitForm()" : "",
					"SIZE1" => $arProperties["SIZE1"],
				),
				null,
				array('HIDE_ICONS' => 'Y')
			);
			?><span class="city_info" style="    width: 15px;    height: 15px;    padding-top: 0px;        background: url('/bitrix/templates/stolnik_gray/img/znak-vop-3.png');
    background-size: 100%;    display: inline-block;position: relative;"><div style="display:none;    position: absolute;    top: 0;    left: 20px;    background: white;    padding: 5px;    border-radius: 5px;    width: 100px;">Начните вводить название города и выберите его из выпадающего списка</div></span>
			<script>
				$('.city_info').hover(function(){
					$(this).find('div').show();
				},function(){
					$(this).find('div').hide();
				})
			</script>
			<div style="    width: 230px;    margin-left: 160px;">Начните вводить название города и выберите его из выпадающего списка</div>
		<?
		}
		elseif ($arProperties["TYPE"] == "RADIO")
		{
		foreach($arProperties["VARIANTS"] as $arVariants)
		{
		?>
		<input type="radio" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>" value="<?=$arVariants["VALUE"]?>"<?if($arVariants["CHECKED"] == "Y") echo " checked";?>> <label for="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"><?=$arVariants["NAME"]?></label><br />
			<?
		}
		}
		?>
		</li><?
	}
	return true;
}
