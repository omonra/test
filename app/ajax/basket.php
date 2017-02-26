<?php

define('STOP_STATISTICS', true);
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->IncludeComponent(
        "bitrix:sale.basket.basket.line", "header", array(
    "PATH_TO_BASKET" => "/app/personal/cart/",
    "PATH_TO_ORDER" => "/app/personal/order/make/",
    "SHOW_NUM_PRODUCTS" => "Y",
    "SHOW_TOTAL_PRICE" => "Y",
    "SHOW_EMPTY_VALUES" => "Y",
    "SHOW_PERSONAL_LINK" => "N",
    "PATH_TO_PERSONAL" => "/app/personal/",
    "SHOW_AUTHOR" => "N",
    "PATH_TO_REGISTER" => SITE_DIR . "login/",
    "PATH_TO_PROFILE" => SITE_DIR . "personal/",
    "SHOW_PRODUCTS" => "N",
    "POSITION_FIXED" => "N",
    "SHOW_DELAY" => "N",
    "SHOW_NOTAVAIL" => "N",
    "SHOW_SUBSCRIBE" => "N",
    "SHOW_IMAGE" => "Y",
    "SHOW_PRICE" => "Y",
    "SHOW_SUMMARY" => "Y"
        ), false
);