<?
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�����������");

// �� ����� �������� ������������ ����� ���� PERSONAL_PHONE
// � ����� ���������� ����� ���������� � ������� +7 (123) 456-78-90
// ���� �������� ���������� � PERSONAL_BIRTHDAY_1
// ���� � ������������ �� ��������� ���� ���� �� �����: PERSONAL_PHONE, NAME, PERSONAL_BIRTHDAY_1 �� ������ ����� ��� �� ����������

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
        <label>���������� ������� <sup>*</sup></label>
        <input type="text" name="phone" required="required" placeholder="+7 (123) 456-78-90" />
        <label>���� ��� <sup>*</sup></label>
        <input type="text" name="name" required="required" placeholder="����" />
        <label>Email <sup>*</sup></label>
        <input type="email" name="email" required="required" placeholder="my@mail.ru" />
        <label>���� �������� <sup>*</sup></label>
        <input type="text" name="birthday" required="required" placeholder="��.��.����" />
        <button class="btn-orange" name="regform" value="y" type="submit">������������������</button>
    </form>
</div>
<? else: ?>
<div class="registartion form">
<p>�� ��� ���������������� �� �����</p>
</div>
<? endif; ?>

<script>
    $("input[name=phone]").mask("+7 (999) 999-99-99");
    $("input[name=birthday]").mask("99.99.9999");
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>