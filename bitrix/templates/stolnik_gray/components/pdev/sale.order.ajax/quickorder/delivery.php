<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<?  //pr_r($arResult);

if(!empty($arResult["DELIVERY"]))
{


	?>
	<div class="ordering_section ">
    <h2>Выберете способ доставки</h2>

    <ul class="list_type_1">
		<?
		foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery)
		{
			if ($delivery_id !== 0 && intval($delivery_id) <= 0)
			{

						foreach ($arDelivery["PROFILES"] as $profile_id => $arProfile)
						{
							$cdek_price=$APPLICATION->IncludeComponent('pdev:sale.ajax.delivery.calculator', 'empty', array(
										"NO_AJAX" => $arParams["DELIVERY_NO_AJAX"],
										"DELIVERY" => $delivery_id,
										"PROFILE" => $profile_id,
										"ORDER_WEIGHT" => $arResult["ORDER_WEIGHT"],
										"ORDER_PRICE" => $arResult["ORDER_PRICE"],
										"LOCATION_TO" => $arResult["USER_VALS"]["DELIVERY_LOCATION"],
										"LOCATION_ZIP" => $arResult["USER_VALS"]["DELIVERY_LOCATION_ZIP"],
										"CURRENCY" => $arResult["BASE_LANG_CURRENCY"],
									), null, array('HIDE_ICONS' => 'Y'));
							if($cdek_price["RESULT"]["VALUE"]):
							?>

									<li class="item" ><label for="delivery_type_<?=$delivery_id?>_<?=$profile_id?>"><input type="radio" id="ID_DELIVERY_ID_<?=$delivery_id?>_<?=$profile_id?>" name="<?=$arProfile["FIELD_NAME"]?>" value="<?=$delivery_id.":".$profile_id;?>"<?if ($arProfile["CHECKED"]=="Y" && $arResult["DELIVERY_PRICE"]) echo " checked";?> onclick="submitForm();"> <? if($arProfile["NAME"]) echo $arProfile["NAME"]; else echo $arProfile["TITLE"]?> <?if (strlen($arProfile["DESCRIPTION"]) > 0):?><span class="description"><?=nl2br($arProfile["DESCRIPTION"])?></span><?endif;?></label>
									&nbsp&nbsp&nbsp&nbsp
									<?
								//	echo GetMessage('SALE_SADC_RESULT').": <b>".(strlen($cdek_price["RESULT"]["VALUE_FORMATTED"]) > 0 ? $cdek_price["RESULT"]["VALUE_FORMATTED"] : number_format($cdek_price["RESULT"]["VALUE"], 2, ',', ' '))."</b>";
									?>
									</li>

					<?endif;
						} // endforeach
			}
			else
			{
				?>
				<li class="item"><label for="delivery_type_<?= $arDelivery["ID"] ?>"><input type="radio" id="ID_DELIVERY_ID_<?= $arDelivery["ID"] ?>" name="<?=$arDelivery["FIELD_NAME"]?>" value="<?= $arDelivery["ID"] ?>"<?if ($arDelivery["CHECKED"]=="Y") echo " checked";?> onclick="submitForm();"> <? if($arDelivery["NAME"]) echo $arDelivery["NAME"]; else echo $arDelivery["TITLE"]?> <?if (strlen($arDelivery["DESCRIPTION"]) > 0):?><span class="description"><?=nl2br($arDelivery["DESCRIPTION"])?></span><?endif;?></label></li>
				<?
			}
		}

}
?>
    </ul>
</div>