<?
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мой аккаунт");
?>

<div class="personal-my">
    <? include(__DIR__ . "/user_info.php"); ?>
    
    <ul class="left-nav catalog">
        <li><a href="/app/personal/qr/"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_bonuses.svg" width="20" height="20" /> Накопить баллы</a></li>
        <li><a href="/app/personal/my/bonus-pay.php"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_cart.svg" width="20" height="20" /> Оплатить баллами</a></li>
        <li><a href="/app/personal/my/bonus-history.php"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_history.svg" width="20" height="20" /> История операций</a></li>
        <li><a href="/app/?logout=yes"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_logout.svg" width="20" height="20" /> Выйти</a></li>
    </ul>
    
</div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>