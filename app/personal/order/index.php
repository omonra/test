<?
define('NO_BOTTOMBAR', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�������� �����");
?>

<?$APPLICATION->IncludeComponent(
"bitrix:sale.order.ajax",
    "main",
    Array(
        "ADDITIONAL_PICT_PROP_8" => "-",
        "ALLOW_AUTO_REGISTER" => "Y",
        "ALLOW_NEW_PROFILE" => "Y",
        "ALLOW_USER_PROFILES" => "N",
        "BASKET_IMAGES_SCALING" => "standard",
        //"BASKET_POSITION" => "after",
        "COMPATIBLE_MODE" => "Y",
        "DELIVERIES_PER_PAGE" => "8",
        "DELIVERY_FADE_EXTRA_SERVICES" => "Y",
        "DELIVERY_NO_AJAX" => "Y",
        "DELIVERY_NO_SESSION" => "Y",
        "DELIVERY_TO_PAYSYSTEM" => "d2p",
        "DISABLE_BASKET_REDIRECT" => "N",
        "MESS_DELIVERY_CALC_ERROR_TEXT" => "�� ������ ���������� ���������� ������, � ���� ����� �������� �������� �������� � ���� � ������� ���������� �� ��������.",
        "MESS_DELIVERY_CALC_ERROR_TITLE" => "�� ������� ���������� ��������� ��������.",
        "MESS_FAIL_PRELOAD_TEXT" => "�� ���������� � ����� ��������-��������, ������� �� ��������� ��� ������ �������������. �������� �������� �� ����������� ���� � ����������� � ������. ����� �� ������ ������ ����������� ��������� ��� �������� ��� ���� � ������ ������ \"#ORDER_BUTTON#\".",
        "MESS_SUCCESS_PRELOAD_TEXT" => "�� ���������� � ����� ��������-��������, ������� �� ��������� ��� ������ �������������. ���� ��� ��������� �����, ������� ������ \"#ORDER_BUTTON#\".",
        "ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
        "PATH_TO_AUTH" => "/auth/",
        "PATH_TO_BASKET" => "/app/personal/cart/",
        "PATH_TO_PAYMENT" => "payment.php",
        "PATH_TO_PERSONAL" => "index.php",
        "PAY_FROM_ACCOUNT" => "Y",
        "PAY_SYSTEMS_PER_PAGE" => "8",
        "PICKUPS_PER_PAGE" => "5",
        "PRODUCT_COLUMNS_HIDDEN" => array("PROPERTY_MATERIAL"),
        "PRODUCT_COLUMNS_VISIBLE" => array("PREVIEW_PICTURE","PROPS"),
        "PROPS_FADE_LIST_1" => array("17","19"),
        "SEND_NEW_USER_NOTIFY" => "Y",
        "SERVICES_IMAGES_SCALING" => "standard",
        "SET_TITLE" => "N",
        "SHOW_BASKET_HEADERS" => "N",
        "SHOW_COUPONS_BASKET" => "Y",
        "SHOW_COUPONS_DELIVERY" => "Y",
        "SHOW_COUPONS_PAY_SYSTEM" => "Y",
        "SHOW_DELIVERY_INFO_NAME" => "Y",
        "SHOW_DELIVERY_LIST_NAMES" => "Y",
        "SHOW_DELIVERY_PARENT_NAMES" => "Y",
        "SHOW_MAP_IN_PROPS" => "N",
        "SHOW_NEAREST_PICKUP" => "N",
        "SHOW_ORDER_BUTTON" => "final_step",
        "SHOW_PAY_SYSTEM_INFO_NAME" => "Y",
        "SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",
        "SHOW_STORES_IMAGES" => "Y",
        "SHOW_TOTAL_ORDER_BUTTON" => "Y",
        "SKIP_USELESS_BLOCK" => "Y",
        "TEMPLATE_LOCATION" => "popup",
        "TEMPLATE_THEME" => "site",
        "USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",
        "USE_CUSTOM_ERROR_MESSAGES" => "Y",
        "USE_CUSTOM_MAIN_MESSAGES" => "N",
        "USE_PREPAYMENT" => "N",
        "USE_YM_GOALS" => "N"
    )
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>