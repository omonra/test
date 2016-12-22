<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
global $USER;
if (!$USER->IsAuthorized()) {
	$user = new CUser;
	$arFields = Array(
		"NAME"              => $_REQUEST['first_name'],
		"EMAIL"             => "anonymous@anonymous.ru",
		"LOGIN"             => "anonymous".rand(-100000, 100000),
		"LID"               => "s1",
		"ACTIVE"            => "Y",
		"PASSWORD"          => "123456",
		"CONFIRM_PASSWORD"  => "123456",
		"PERSONAL_PHONE"    => $_REQUEST['telephone']
		);

	$ID = $user->Add($arFields);
	$USER->Authorize($ID);
} 


	if (CModule::IncludeModule("sale"))
	{
		$arFields = array(
			"PRODUCT_ID" => $_REQUEST['product_id'],
			"PRODUCT_PRICE_ID" => 0,
			"PRICE" => $_REQUEST['product_price'],
			"CURRENCY" => "RUB",
			"QUANTITY" => 1,
			"LID" => LANG,
			"DELAY" => "N",
			"CAN_BUY" => "Y",
			"NAME" => $_REQUEST['product_name'],
			"DETAIL_PAGE_URL" => "/".LANG."/detail.php?ID=".$_REQUEST['product_id']
			);

		CSaleBasket::Add($arFields);

		$arFields = array(
			"LID" => "s1",
			"PERSON_TYPE_ID" => 1,
			"PAYED" => "N",
			"CANCELED" => "N",
			"STATUS_ID" => "N",
			"PRICE" => $_REQUEST['product_price'],
			"CURRENCY" => "RUB",
			"USER_ID" => IntVal($USER->GetID()),
			"PAY_SYSTEM_ID" => 1,
			"PRICE_DELIVERY" => 0,
			"DELIVERY_ID" => 1,
			"DISCOUNT_VALUE" => 0,
			"TAX_VALUE" => 0.0,
			"USER_DESCRIPTION" => ""
			);

		$ORDER_ID = CSaleOrder::Add($arFields);
		$ORDER_ID = IntVal($ORDER_ID);
		//CSaleBasket::OrderBasket($ORDER_ID);
		
	}
?>