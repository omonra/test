<?
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�������� ����������");
?>

<div class="personal-my">
    <? include(__DIR__ . "/user_info.php"); ?>
    
    <p>����� � ���, ��� ����� �������� ����� � ��������� ��� ���� �������.</p>
    <p>����� � ���, ��� ����� �������� ����� � ��������� ��� ���� �������.</p>
    
</div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>