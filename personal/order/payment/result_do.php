<?
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("Результат оплаты");
?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment.receive",
	"",
	Array(
		//"PAY_SYSTEM_ID" => "14",
		"PAY_SYSTEM_ID_NEW" => "17",
		//"PERSON_TYPE_ID" => "1"
	)
);?><?//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
