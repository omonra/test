<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("��������� ������");

?>
<?
//pr($_REQUEST);
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
        "PAY_SYSTEM_ID" => "20",
        "PAY_SYSTEM_ID_NEW" => "20",
        "PERSON_TYPE_ID" => "1"
    )
);?>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>