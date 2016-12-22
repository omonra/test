<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?><?
include(GetLangFileName(dirname(__FILE__)."/", "/payment.php"));



$p_res = $_POST["Result"];
$p_rc = $_POST["RC"];
$p_amount = $_POST["Amount"];
$p_currency = $_POST["Currency"];
$p_order = $_POST["Order"];
$p_rrn = $_POST["RRN"];
$p_int_ref = $_POST["IntRef"];
$p_auth_code = $_POST["AuthCode"];
$p_trtype = $_POST["TrType"];
$p_terminal = $_POST["Terminal"];
$p_back_ref = $_POST["BackRef"];
$p_rc_text = $_POST["TextMessage"];

$arAllowPaySystemFile = array(
	'/bitrix/php_interface/include/sale_payment/itinfinity_payment_mdmbank',
	'/local/php_interface/include/sale_payment/itinfinity_payment_mdmbank'
);

$arOrder = CSaleOrder::GetByID( IntVal($p_order) );

$arPaySystem = CSalePaySystem::GetByID( $arOrder['PAY_SYSTEM_ID'], $arOrder['PERSON_TYPE_ID'] );

if( in_array($arPaySystem['PSA_ACTION_FILE'], $arAllowPaySystemFile) ){
	$paySystemParams = unserialize( $arPaySystem['PSA_PARAMS'] );
};

if($p_rc_text == "Approved" && ( $p_trtype == 0 || $p_trtype == 21 ) ){
		
	$ALLOW_DELIVERY = $paySystemParams["ALLOW_DELIVERY"]["VALUE"];
	
	if(($p_amount == $arOrder["PRICE"]) && ($p_currency == "RUB")){
		
		switch ($p_res){
			case "0" : $p_result_msg = "Операция одобрена"; break;
			case "1" : $p_result_msg = "Повторная транзакция"; break;
			case "2" : $p_result_msg = "Технические проблемы"; break;
			case "3" : $p_result_msg = "Операция отклонена"; break;
		}
						
		$time = date("d.m.Y H:i:s", time());
		$arFields["PS_STATUS"] = "Y";
		$arFields = array(
			"PS_STATUS" => "Y",
			"PS_STATUS_MESSAGE" => $p_rc_text,
			"PS_SUM" => $p_amount,
			"PS_CURRENCY" => $p_currency,
			"PS_STATUS_CODE" => $p_res,
			"PS_STATUS_DESCRIPTION" => $p_result_msg,
			"PS_RESPONSE_DATE" => $time,
			"PS_RRN" => $p_rrn,
			"PS_INT_REF" => $p_int_ref
		);
		
		if($arOrder["PAYED"] != "Y") CSaleOrder::PayOrder($arOrder["ID"], "Y", true, true);

		if( $ALLOW_DELIVERY == "Y") CSaleOrder::DeliverOrder($arOrder["ID"], "Y");				
		
	}
	else $arFields["PS_STATUS_MESSAGE"] .= GetMessage("ERROR_SUM").". ";
	
	CSaleOrder::Update($arOrder["ID"], $arFields);

	if(CModule::IncludeModule('itinfinity.mdmbank')){
		CITMdmBank::RNNSave( $arOrder, $p_rrn );
	};
	

	if(CModule::IncludeModule('itinfinity.mdmbank')){
		CITMdmBank::INTREFSave( $arOrder, $p_int_ref );
	};

		
		
	
	$arOrder = CSaleOrder::GetByID(IntVal($p_order));
	
	
	if($p_rc_text == "Approved" && $p_trtype == 0){
		$arFields = array(
			'AMOUNT' => $p_amount,
			'CURRENCY' => $p_currency,
			'ORDER' => $p_order,
			'RRN' => $p_rrn,
			'INT_REF' => $p_int_ref,
			'TRTYPE' => 21,
			'TERMINAL' => $p_terminal,
			'TIMESTAMP' => gmdate("YmdHis", time()),
			'MERC_GMT' => $paySystemParams["TIMEZONE"]["VALUE"]
		);
		if($p_res == '0' && $p_rc == '00'){
			CSaleOrder::PayOrder($p_order, 'Y', false, true, 0, array('STATUS_ID' => 'P'));
		}
		if(strlen($paySystemParams["IS_TEST"]["VALUE"]) > 0)
			$server_url = "https://3dstest.mdmbank.ru:443/cgi-bin/cgi_link";
		else
			$server_url = "https://3ds.mdmbank.ru/cgi-bin/cgi_link";

		if(CModule::IncludeModule('itinfinity.mdmbank')){
			CITMdmBank::PayInit( $server_url,  $arFields);
		};
	};
				
}
?>