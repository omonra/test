<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
?>
<?
$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket",
	"main",
	Array(
		"COLUMNS_LIST" => array(0=>"NAME",1=>"PROPS",2=>"PRICE",3=>"TYPE",4=>"QUANTITY",5=>"DELETE",6=>"DELAY",),
		"PATH_TO_ORDER" => "/personal/order/make/",
		"HIDE_COUPON" => "N",
		"QUANTITY_FLOAT" => "N",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"USE_PREPAYMENT" => "N",
		"SET_TITLE" => "Y"
	)
);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
