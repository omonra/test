<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
IncludeModuleLangFile(__FILE__);


$aMenuLinks[] = Array(
        "Накопить баллы",
        "/app/personal/qr/",
        Array(),
        Array(),
        ""
    );

$aMenuLinks[] = Array(
        "Оплатить баллами",
        "bonus-pay.php",
        Array(),
        Array(),
        ""
    );

$aMenuLinks[] = Array(
        "История операций",
        "bonus-history.php",
        Array(),
        Array(),
        ""
    );

$aMenuLinks[] = Array(
        "Выход",
        "?logout=y",
        Array(),
        Array(),
        ""
    );
 
?>