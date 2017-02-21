<?
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");

// За номер телефона пользователя берем поле PERSONAL_PHONE
// В логин записываем номер мобильного в формате +7 (123) 456-78-90
// Дату рождения записываем в PERSONAL_BIRTHDAY_1
// Если у пользователя не заполнено хоть одно из полей: PERSONAL_PHONE, NAME, PERSONAL_BIRTHDAY_1 то выдаем форму для их заполнения

if ($_POST['regform'])
{
    $password = rand(111111, 999999);
    $user = new CUser;
    $arFields = Array (
        'NAME' => $_POST['name'],
        'LOGIN' => $_POST['phone'],
        'EMAIL' => $_POST['email'],
        'PASSWORD' => $password,
        'ACTIVE' => 'Y',
        'GROUP_ID' => Array (12),
        'CONFIRM_PASSWORD' => $password,
        'PERSONAL_PHONE' => $_POST['phone'],
        'PERSONAL_BIRTHDAY_1' => $_POST['birthday'],
    );
    
    $ID = $user->Add($arFields);
    if (intval($ID) > 0)
    {
        $redirect = !empty($_REQUEST['redirect']) ? $_REQUEST['redirect'] : $APPLICATION->GetCurDir();
        $USER->Authorize($ID);
        LocalRedirect($redirect);
    }
    else       
        $arErrors[] = $user->LAST_ERROR;
}

?>

<? if (!$USER->IsAuthorized()): ?>
<div class="registartion form">
    <? if (count($arErrors) > 0): ?>
    <div class="error-label"><?=implode('<br/>', $arErrors)?></div>
    <? endif; ?>
    <form method="post" class="form" target="_top" enctype="multipart/form-data">
        <label>Контактный телефон <sup>*</sup></label>
        <input type="text" name="phone" required="required" placeholder="+7 (123) 456-78-90" />
        <label>Ваше имя <sup>*</sup></label>
        <input type="text" name="name" required="required" placeholder="Иван" />
        <label>Email <sup>*</sup></label>
        <input type="email" name="email" required="required" placeholder="my@mail.ru" />
        <label>Дата рождения <sup>*</sup></label>
        <input type="text" name="birthday" required="required" placeholder="дд.мм.гггг" />
        <button class="btn-orange" name="regform" value="y" type="submit">Зарегистрироваться</button>
    </form>
</div>
<? else: ?>
<div class="registartion form">
<p>Вы уже зарегистрированы на сайте</p>
</div>
<? endif; ?>

<script>
    $("input[name=phone]").mask("+7 (999) 999-99-99");
    $("input[name=birthday]").mask("99.99.9999");
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>