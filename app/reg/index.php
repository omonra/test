<?
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�����������");
?>

<? if ($USER->IsAuthorized()): ?>
<div class="registartion form">
    <form method="post" name="regform" class="form" target="_top" enctype="multipart/form-data">
        <input type="text" placeholder="���������� ������� *" />
        <input type="text" placeholder="���� ��� *" />
        <input type="text" placeholder="Email" />
        <button class="btn-orange" type="submit">������������������</button>
    </form>
</div>
<? else: ?>
<p>�� ��� ���������������� �� �����</p>
<? endif; ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>