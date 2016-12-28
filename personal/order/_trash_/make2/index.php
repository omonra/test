<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?
$APPLICATION->IncludeComponent(
	"bitrix:sale.order.ajax",	"",
	Array(
		"PAY_FROM_ACCOUNT" => "Y",
		"COUNT_DELIVERY_TAX" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"ALLOW_AUTO_REGISTER" => "Y",
		"SEND_NEW_USER_NOTIFY" => "Y",
		"DELIVERY_NO_AJAX" => "N",
		"DELIVERY_NO_SESSION" => "N",
		"TEMPLATE_LOCATION" => ".default",
		"DELIVERY_TO_PAYSYSTEM" => "d2p",
		"DELIVERY2PAY_SYSTEM" =>  array(
            array(
                "sheepla:sheepla_1_3702" => array(5,14),
         		"sheepla:sheepla_2_6101" => array(13),
                "1" => array(11,1,9,5,14),
                "5" => array(11,1,9,5,14),
                "6" => array(11,5,14),
                "8" => array(11,5,14)
              )
              ),
		"USE_PREPAYMENT" => "N",
		"PROP_1" => array(0 => "25"),
		"PROP_2" => array(),
		"PATH_TO_BASKET" => "/",
		"PATH_TO_PERSONAL" => "/personal/order/",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"PATH_TO_AUTH" => "/auth/",
		"SET_TITLE" => "Y"
	)
);?>
<?/*$APPLICATION->IncludeComponent(
	"vvi:main.feedback",
	".default",
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"USE_CAPTCHA" => "N",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"EMAIL_TO" => "info@stolnik24.ru",
		"REQUIRED_FIELDS" => array(
		),
		"EVENT_MESSAGE_ID" => array(
			0 => "47",
		)
	),
	false
);*/?>
<script>

/* $(document).ready(function () {
        $('.count-input').addClass('ignore');
        $('.button_clear_basket').addClass('ignore');
        $('.button_clear_basket').addClass('ignore');
        $('#ORDER_PROP_5_val').addClass('ignore');
       $.validator.addMethod("ruPhoneFormat", function (value, element) {
            return this.optional(element) || /^\d \(\d{3}\) \d{3}\ \d{4}( x\d{1,6})?$/.test(value);
        });
     $('#ORDER_FORM').validate({
            ignore: ".ignore",
            rules:{
                ORDER_PROP_2: {
                  required: true,
                  email: true
                },
                ORDER_PROP_3: {
                  required: true,
                  ruPhoneFormat: true
                }

            },
            onkeyup: function(element){
                $(element).valid()
            },
            errorPlacement: function(e){
                return e;  // suppresses error message text
            },invalidHandler: function(e, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors == 1 ? 'You missed 1 field. It has been highlighted below' : 'You missed ' + errors + ' fields.  They have been highlighted below';
                    console.log(message);
                } else {
                    $("div.error").hide();
                }
            },
        });
}); */
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
