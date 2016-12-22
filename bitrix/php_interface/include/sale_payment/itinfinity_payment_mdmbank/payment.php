<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?><?
include(GetLangFileName(dirname(__FILE__)."/", "/payment.php"));


$amount = CSalePaySystemAction::GetParamValue("SHOULD_PAY"); 
$amount = number_format($amount, 2, ".", "");

$currency = CSalePaySystemAction::GetParamValue("CURRENCY");
if(strlen($currency) <= 0)
	$currency = "RUB";


$order = CSalePaySystemAction::GetParamValue("ORDER_ID"); 
if(strlen($order) < 6)
{
	$n = 6-strlen($order);
	for($i = 0; $i < $n; $i++)
		$order = "0".$order;
}

$desc = trim( CSalePaySystemAction::GetParamValue("ORDER_DESC") );
$desc = str_replace( '#ID#', CSalePaySystemAction::GetParamValue("ORDER_ID"), CSalePaySystemAction::GetParamValue("ORDER_DESC") );

$merchant_name = CSalePaySystemAction::GetParamValue("MERCH_NAME");

$merchant_url = CSalePaySystemAction::GetParamValue("MERCH_URL");

$terminal = CSalePaySystemAction::GetParamValue("TERMINAL");

$email = CSalePaySystemAction::GetParamValue("ORDER_EMAIL");

$tr_type = 0;

$country = CSalePaySystemAction::GetParamValue("COUNTRY");

$timezone = CSalePaySystemAction::GetParamValue("TIMEZONE");

$timestamp = gmdate("YmdHis", time());


$arFields = array(
	"ADDITIONAL_INFO" => $timestamp
);

CSaleOrder::Update(CSalePaySystemAction::GetParamValue("ORDER_ID"), $arFields);


$APPLICATION->set_cookie("ITINFINITY_MDM_LAST_ORDER", CSalePaySystemAction::GetParamValue("ORDER_ID"), time()+60*15, "/");


if(strlen(CSalePaySystemAction::GetParamValue("IS_TEST")) > 0)
	$server_url = "https://3dstest.mdmbank.ru:443/cgi-bin/cgi_link";
else
	$server_url = "https://3ds.mdmbank.ru/cgi-bin/cgi_link";
?>

 


<form name="cardform" action="<?=$server_url?>" method="post">
	<input type="hidden" name="AMOUNT" VALUE="<?=$amount?>">
	<input type="hidden" name="CURRENCY" VALUE="<?=$currency?>">
	<input type="hidden" name="ORDER" VALUE="<?=$order?>">
	<input type="hidden" name="DESC" VALUE="<?=$desc?>">
	<input type="hidden" name="MERCH_NAME" VALUE="<?=$merchant_name?>">
	<input type="hidden" name="MERCH_URL" VALUE="<?=$merchant_url?>">
	<input type="hidden" name="TERMINAL" VALUE="<?=$terminal?>">
	<input type="hidden" name="EMAIL" VALUE="<?=$email?>">
	<input type="hidden" name="TRTYPE " VALUE="<?=$tr_type?>">
	<input type="hidden" name="COUNTRY" VALUE="<?=$country?>">
	<input type="hidden" name="MERC_GMT" VALUE="<?=$timezone?>">
	<input type="hidden" name="TIMESTAMP" VALUE="<?=$timestamp?>">
	<input type="submit" value="<?=GetMessage("PAY_BUTTON")?>" name="send_button">
</form>