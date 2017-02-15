<?
define('NO_BACKLINE', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
LocalRedirect('/app/catalog/?ELEMENT_ID=392510');
//$APPLICATION->SetPageProperty("BodyClass", "main");
?>

<? include(__DIR__."/include/index_menu.php"); ?>

<? include(__DIR__."/include/index_new.php"); ?>
<hr/>
<? include(__DIR__."/include/index_sale.php"); ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>