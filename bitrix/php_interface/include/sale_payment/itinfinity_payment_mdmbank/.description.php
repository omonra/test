<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?><?
include(GetLangFileName(dirname(__FILE__)."/", "/payment.php"));

if( CModule::IncludeModule('main') ){
	$cdbSite = CSite::GetList( $by = "sort", $order = "asc", array('ACTIVE' => 'Y') );
	$arSite = $cdbSite->GetNext();
};


$psTitle = GetMessage("ITI_MDM_DTITLE");
$psDescription = GetMessage("ITI_MDM_DESCR");
$arPSCorrespondence = array(
		"MERCH_NAME" => array(
			"NAME" => GetMessage("MERCH_NAME"),
			"DESCR" => GetMessage("MERCH_NAME_DESCR"),
			"VALUE" => $arSite['NAME'],
			"TYPE" => ""
		),
		
		"MERCH_URL" => array(
			"NAME" => GetMessage("MERCH_URL"),
			"DESCR" => GetMessage("MERCH_URL_DESCR"),
			"VALUE" => $_SERVER["HTTP_X_FORWARDED_PROTO"] . "://" . $_SERVER["HTTP_HOST"] . '/',
			"TYPE" => ""
		),
		"ALLOW_DELIVERY" => array(
			"NAME" => GetMessage("ALLOW_DELIVERY"),
			"DESCR" => GetMessage("ALLOW_DELIVERY_DESCR"),
			"VALUE" => "",
			"TYPE" => ""
		),
		
		"ORDER_EMAIL" => array(
			"NAME" => GetMessage("EMAIL"),
			"DESCR" => GetMessage("EMAIL_DESCR"),
			"VALUE" => "EMAIL",
			"TYPE" => "PROPERTY"
		),
		
		"COUNTRY" => array(
			"NAME" => GetMessage("COUNTRY"),
			"DESCR" => GetMessage("COUNTRY_DESCR"),
			"VALUE" => "RU",
			"TYPE" => ""
		),
		
		"ORDER_ID" => array(
			"NAME" => GetMessage("ORDERID"),
			"DESCR" => GetMessage("ORDERID_DESCR"),
			"VALUE" => "ID",
			"TYPE" => "ORDER"
		),
		
		"ORDER_DESC" => array(
			"NAME" => GetMessage("ORDER_DESC"),
			"DESCR" => GetMessage("ORDER_DESC_DESCR"),
			"VALUE" => GetMessage("ORDER_DESC_VAL"),
			"TYPE" => ""
		),
		
		"SHOULD_PAY" => array(
			"NAME" => GetMessage("SHOULD_PAY"),
			"DESCR" => GetMessage("SHOULD_PAY_DESCR"),
			"VALUE" => "SHOULD_PAY",
			"TYPE" => "ORDER"
		),
		
		"CURRENCY" => array(
			"NAME" => GetMessage("CURRENCY"),
			"DESCR" => GetMessage("CURRENCY_DESCR"),
			"VALUE" => "CURRENCY",
			"TYPE" => "ORDER"
		),
		
		"TIMEZONE" => array(
			"NAME" => GetMessage("TIMEZONE"),
			"DESCR" => GetMessage("TIMEZONE_DESCR"),
			"VALUE" => "+3",
			"TYPE" => ""
		),
		
		"TERMINAL" => array(
			"NAME" => GetMessage("TERMINAL"),
			"DESCR" => GetMessage("TERMINAL_DESCR"),
			"VALUE" => "",
			"TYPE" => ""
		),
		
		"IS_TEST" => array(
			"NAME" => GetMessage("IS_TEST"),
			"DESCR" => GetMessage("IS_TEST_DESCR"),
			"VALUE" => "",
			"TYPE" => ""
		),
		
	);                                     
?>