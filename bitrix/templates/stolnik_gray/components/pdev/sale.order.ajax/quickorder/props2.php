<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
function PrintPropsForm($arSource=Array())
{
	if (!empty($arSource))
	{
		?>

		<?
		foreach($arSource as $arProperties)
		{
			if($arProperties["SHOW_GROUP_NAME"] == "Y")
			{
				?>
                <?if($arProperties["PROPS_GROUP_ID"]==2):?>
                    <div class="addr_info">
                        <h2><?=$arProperties["GROUP_NAME"]?></h2>
                            <dl class="form_list">
                <?endif;?>
                <?if($arProperties["PROPS_GROUP_ID"]==1):?>
                            </dl>
                    </div>
                    <div class="contacts_info">
                        <h2><?=$arProperties["GROUP_NAME"]?></h2>
                            <dl class="form_list">
                <?endif;?>
				<?
			}
			?>
            <dt <?if($arProperties['CODE'] == 'LOCATION'):?>style="display:none"<?endif;?>><label for="<?=$arProperties["FIELD_NAME"]?>"><?= $arProperties["NAME"] ?><?if (strlen($arProperties["DESCRIPTION"]) > 0):?><span class="description">(<?=$arProperties["DESCRIPTION"]?>)</span><?endif;?></label><?if($arProperties["REQUIED_FORMATED"]=="Y"):?><span class="footnote">*</span><?endif;?></dt>
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
						?>
                        <dd><input id="<?=$arProperties["FIELD_NAME"]?>" class="text_input text_input_1<?if($arProperties['CODE'] == 'CITY'):?> input_autocomplete<?endif;?>" type="text" name="<?=$arProperties["FIELD_NAME"]?>" value="<?=$arProperties["VALUE"]?>"></dd>
                        <?if($arProperties['CODE'] == 'CITY'):?>
                    <script type="text/javascript">
                        $(document).ready(function() {

                            FillAutocompleter();
                        });

                        function FillAutocompleter()
                        {
                            CITIES = new Array();

                            <?foreach($arSource as $arPropCity)
                        {
                            if($arPropCity['TYPE']=='LOCATION')
                            {
                                foreach($arPropCity['VARIANTS'] as $arCity)
                                {
                                    print "CITIES[".$arCity['ID']."] = '".$arCity['CITY_NAME']."'\r\n";
                                }
                            }
                        }
                            ?>

                            $(".input_autocomplete").autocompleteArray([<?foreach($arSource as $arPropCity)
                            {

                                if($arPropCity['TYPE']=='LOCATION')
                                {

                                    $city_i = 1;
                                    foreach($arPropCity['VARIANTS'] as $arCity)
                                    {
                                        $arCity['CITY_NAME'] = trim($arCity['CITY_NAME']);
                                        if(strlen($arCity['CITY_NAME'])>0)
                                        {
                                            if($city_i>1) print ', ';
                                            print "'".$arCity['CITY_NAME']."'";
                                            $city_i++;
                                        }

                                    }
                                }
                            }
                                ?>],
                                {
                                    delay:10,
                                    minChars:1,
                                    matchSubset:1,
                                    autoFill:false,
                                    matchContains:1,
                                    cacheLength:10,
                                    selectFirst:false,
                                    lineSeparator: ',',
                                    maxItemsToShow:10
                                }
                            );
                            var CITY_VAL = '';
                            $(".input_autocomplete").focusin(function(){
                                CITY_VAL = $(this).val();
                            });

                            $(".input_autocomplete").focusout(function(){
                                // сверяем сменилось ли значение

                                setTimeout(function(){handleCityChange()}, 150);

                            });

                            function handleCityChange(input)
                            {

                                if(CITY_VAL != $(".input_autocomplete").val() )
                                {

                                    for ( keyVar in CITIES ) {
                                        if( $(".input_autocomplete").val().toUpperCase() == CITIES[keyVar].toUpperCase() )
                                        {
                                            $('.hidden_city').val(keyVar);
                                            submitForm();
                                            return;
                                        }
                                    }
                                    // не нашли совпадения, выбираем пустой город
                                    for ( keyVar in CITIES ) {
                                        if( '' == CITIES[keyVar] )
                                        {
                                            $('.hidden_city').val(keyVar);
                                            submitForm();
                                            return;
                                        }
                                    }

                                }

                            }
                        }
                    </script>
                        <?endif;?>
						<?
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
						foreach ($arProperties["VARIANTS"] as $arVariant) 
						{
							if ($arVariant["SELECTED"] == "Y") 
							{
								$value = $arVariant["ID"]; 
								break;
							}
						}

						$GLOBALS["APPLICATION"]->IncludeComponent(
							'bitrix:sale.ajax.locations', 
							'invisible',
							array(
								"AJAX_CALL" => "N", 
								"COUNTRY_INPUT_NAME" => "COUNTRY_".$arProperties["FIELD_NAME"],
								"CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
								"CITY_OUT_LOCATION" => "Y",
								"LOCATION_VALUE" => $value,
								"ONCITYCHANGE" => ($arProperties["IS_LOCATION"] == "Y" || $arProperties["IS_LOCATION4TAX"] == "Y") ? "submitForm()" : "",
							),
							null,
							array('HIDE_ICONS' => 'Y')
						);
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
		}
		return true;
	}
	return false;
}
?>

<div style="display:none;">
<?
	$APPLICATION->IncludeComponent(
		'bitrix:sale.ajax.locations', 
		'', 
		array(
			"AJAX_CALL" => "N", 
			"COUNTRY_INPUT_NAME" => "COUNTRY_tmp",
			"CITY_INPUT_NAME" => "tmp",
			"CITY_OUT_LOCATION" => "Y",
			"LOCATION_VALUE" => "",
			"ONCITYCHANGE" => "",
		),
		null,
		array('HIDE_ICONS' => 'Y')
	);
?>
</div>
<div class="ordering_section ordering_section_info">
<?
//PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_N"]);
PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"]);
?>
        </dl>
    </div>
</div>