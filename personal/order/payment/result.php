<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("��������� ������");
?>
	<div style="color: green; text-align: center; font-size: 20px; line-height: 27px;">
		������ ������ ������ �������.
		�� ������ ���������� �������� ������� �� �����.<br/>
		<a href="/personal/order/cart/">��� ������</a>
	</div>

<?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment.receive",
	"",
	Array(
		"PAY_SYSTEM_ID" => "8",
		"PERSON_TYPE_ID" => "1"
	)
);?>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment.receive",
	"",
	Array(
		"PAY_SYSTEM_ID" => "16",
		"PERSON_TYPE_ID" => "1"
	)
);?>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>