<?
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");
?>

<? if ($USER->IsAuthorized()): ?>
<div class="registartion form">
    <form method="post" name="regform" class="form" target="_top" enctype="multipart/form-data">
        <input type="text" placeholder="Контактный телефон *" />
        <input type="text" placeholder="Ваше имя *" />
        <input type="text" placeholder="Email" />
        <button class="btn-orange" type="submit">Зарегистрироваться</button>
    </form>
</div>
<? else: ?>
<p>Вы уже зарегистрированы на сайте</p>
<? endif; ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>