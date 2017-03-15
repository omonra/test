<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if ($arParams["AJAX_CALL"] != "Y"):?><div id="LOCATION_<?=$arParams["CITY_INPUT_NAME"];?>"><?endif?>

<input type='hidden' name="<?=$arParams["COUNTRY_INPUT_NAME"]?>" value="<?=$arParams["COUNTRY"]?>">

<input type='hidden' class="hidden_city" name="<?=$arParams["CITY_INPUT_NAME"]?>" value="<?=$arParams["CITY"]?>" >

</div>