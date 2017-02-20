<?
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/phpqrcode/qrlib.php");
$APPLICATION->SetTitle('Мой QR-код');
?>

<div class="my-qrcode">
    <div class="title">Для накопления баллов покажите этот код кассиру в розничном магазине:</div>
    <img src="image.php" />
    
    <div class="sub-text">Используйте данный код в розничных магазинах для получения баллов за покупки</div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>