<?
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("История операций");
?>

<div class="personal-my">
    
    <div class="bonus-history">
        <div class="count">+ 30 баллов</div>
        <div class="comment">28.01.2017 | Накопление бонусов</div>
    </div>
    
    <div class="bonus-history minus">
        <div class="count">- 5 баллов</div>
        <div class="comment">12.01.2017 | Списание бонусов</div>
    </div>
    
    
</div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>