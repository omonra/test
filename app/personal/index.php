<?
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мой аккаунт");
LocalRedirect('/app/personal/my/');
?>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>