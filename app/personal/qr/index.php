<?
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/local/phpqrcode/qrlib.php");
$APPLICATION->SetTitle('��� QR-���');
?>

<div class="my-qrcode">
    <div class="title">��� ���������� ������ �������� ���� ��� ������� � ��������� ��������:</div>
    <img src="image.php" />
    
    <div class="sub-text">����������� ������ ��� � ��������� ��������� ��� ��������� ������ �� �������</div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>