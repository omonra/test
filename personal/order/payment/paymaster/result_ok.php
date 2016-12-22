<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<div class="news-detail">
    <h1>Paymaster</h1>
    <div class="text-center">
        <h3> Оплата прошла успешно! Спасибо за заказ.</h3>
        <p><a href="/personal/order/cart/">Вернуться в списку заказов</a></p>
    </div>
    <br><br><br>
</div>
<?if(!empty($_REQUEST['LMI_PAYMENT_NO']) && (intval($_REQUEST['LMI_PAYMENT_NO']) > 0)){
    CSaleOrder::PayOrder($_REQUEST['LMI_PAYMENT_NO'], 'Y', false, true, 0, array('STATUS_ID' => 'P'));
}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
