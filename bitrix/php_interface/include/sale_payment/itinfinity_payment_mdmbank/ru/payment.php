<?
global $MESS;

$MESS["ITI_MDM_DTITLE"] = "МДМ Банк";
$MESS["ITI_MDM_DESCR"] = "<br/><a href=\"http://www.mdm.ru\" target=\"_blank\"><img src=\"/bitrix/php_interface/include/sale_payment/itinfinity_payment_mdmbank/logo.jpg\" /></a>
							</br>
							<ul>
								<li>Сайт банка: <a href=\"https://www.mdm.ru/\" target=\"_blank\">www.mdm.ru</a> <sup><b>(откроется в новом окне)</b></sup></li>
								<li><a href=\"http://www.mdm.ru/moscow/corporate/acquiring/\" target=\"_blank\">Заявка на подключение к интернет-эквайрингу</a> <sup><b>(откроется в новом окне)</b></sup></li>
								<li>Техническая поддержка по вопросам работы платёжного модуля: <a href=\"mailto:support@it-infinity.ru\" target=\"_blank\">support@it-infinity.ru</a> <sup><b>(откроется в новом окне)</b></sup></li>
								<li>Сайт разработчика модуля: <a href=\"http://www.it-infinity.ru\" target=\"_blank\">www.it-infinity.ru</a> <sup><b>(откроется в новом окне)</b></sup></li>
							</ul>";

$MESS["MERCH_NAME"] = "Название вашего магазина (на латинице)";
$MESS["MERCH_NAME_DESCR"] = "";

$MESS["MERCH_URL"] = "Страница на которую будет возвращён пользователь после оплаты";
$MESS["MERCH_URL_DESCR"] = "URL, который подставляется по ссылке «Назад в магазин»";

$MESS["TERMINAL"] = "Код терминала, присваиваемый Банком";
$MESS["TERMINAL_DESCR"] = "";

$MESS["COUNTRY"] = "Страна";
$MESS["COUNTRY_DESCR"] = "Двухзначный код страны, для России RU";

$MESS["IS_TEST"] = "Тестовый режим";
$MESS["IS_TEST_DESCR"] = "Если пустое значение - магазин будет работать в обычном режиме";

$MESS["ORDERID"] = "ID заказа для передачи банку";
$MESS["ORDERID_DESCR"] = "";

$MESS["EMAIL"] = "Адрес электронной почты для уведомления об операции";
$MESS["EMAIL_DESCR"] = "";

$MESS["SHOULD_PAY"] = "Сумма заказа";
$MESS["SHOULD_PAY_DESCR"] = "Сумма к оплате";

$MESS["CURRENCY"] = "Валюта";
$MESS["CURRENCY_DESCR"] = "Валюта заказа";

$MESS["ORDER_DESC"] = "Описание заказа (передаётся службе эквайринга)";
$MESS["ORDER_DESC_DESCR"] = "<br/><br/>Доступные значения:<br/>#ID# - Номер заказа";
$MESS["ORDER_DESC_VAL"] = "Payment order #ID#";

$MESS["TIMEZONE"] = "Часовой пояс относительно Гринвича";
$MESS["TIMEZONE_DESCR"] = "Для Москвы +3";

$MESS["ALLOW_DELIVERY"] = "Разрешать доставку";
$MESS["ALLOW_DELIVERY_DESCR"] = "Если Y, то при получении оплаты заказа разрешиться его доставка";

$MESS["PAY_BUTTON"] = "Оплатить";

?>
