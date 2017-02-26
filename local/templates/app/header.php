<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("iblock");
if (CModule::IncludeModule("mobileapp"))
   CMobile::Init();
?>
<!DOCTYPE html>
<html<?=$APPLICATION->ShowProperty("Manifest");?> class="<?=CMobile::$platform;?>">
<head>
	<?$APPLICATION->ShowHead();?>
	<meta http-equiv="Content-Type" content="text/html;charset=<?=SITE_CHARSET?>"/>
	<meta name="format-detection" content="telephone=no">
	<!--<link href="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH."/template_styles.css")?>" type="text/css" rel="stylesheet" />-->
	<?//$APPLICATION->ShowHeadStrings();?>
        <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-3.1.1.min.js");?>
        <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.maskedinput.min.js");?>
        <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/lightslider.min.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/script.js");?>
        <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/lightslider.css");?>
	<?CJSCore::Init('ajax');?>
	<title><?$APPLICATION->ShowTitle()?></title>
        <script>
        
        </script>
</head>
<body id="body" class="<?=$APPLICATION->ShowProperty("BodyClass");?>">
<?if (!CMobile::getInstance()->getDevice()) $APPLICATION->ShowPanel();?>
<? if (!defined("NO_NAVIGATION")): ?>
    <div class="topbar">
        <table width="100%">
            <tr>
                <td class="left">
                    <a href="#" onclick="BXMobileApp.UI.Slider.setState(BXMobileApp.UI.Slider.state.LEFT); return false;" class="btn-small"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_topbar_menu.svg" /></a>
                </td>
                <td class="center">
                    <?if($APPLICATION->GetCurDir() == "/app/"): ?>
                    <img src="<?=SITE_TEMPLATE_PATH?>/images/logo_topbar.png" />
                    <? else: ?>
                    <span class="h1"><?$APPLICATION->ShowTitle(false)?></span>
                    <? endif; ?>
                </td>
                <td class="right two">
                    <? if ($APPLICATION->GetCurDir() == "/app/"): ?>
                     <a href="tel:+78005006964" class="btn-small hide-320px"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_topbar_phone.svg" /></a>
                     <? endif; ?>
                     
                     <?$APPLICATION->IncludeComponent(
                    "bitrix:sale.basket.basket.line",
                    "header",
                    array(
                        "PATH_TO_BASKET" => "/app/personal/cart/",
                        "PATH_TO_ORDER" => "/app/personal/order/",
                        "SHOW_NUM_PRODUCTS" => "Y",
                        "SHOW_TOTAL_PRICE" => "Y",
                        "SHOW_EMPTY_VALUES" => "Y",
                        "SHOW_PERSONAL_LINK" => "N",
                        "PATH_TO_PERSONAL" => "/app/personal/",
                        "SHOW_AUTHOR" => "N",
                        "PATH_TO_REGISTER" => SITE_DIR."login/",
                        "PATH_TO_PROFILE" => SITE_DIR."personal/",
                        "SHOW_PRODUCTS" => "N",
                        "POSITION_FIXED" => "N",
                        "SHOW_DELAY" => "N",
                        "SHOW_NOTAVAIL" => "N",
                        "SHOW_SUBSCRIBE" => "N",
                        "SHOW_IMAGE" => "Y",
                        "SHOW_PRICE" => "Y",
                        "SHOW_SUMMARY" => "Y",
                        "HIDE_ON_BASKET_PAGES" => "N"
                    ),
                    false
                );?>
                     
                    
                </td>
            </tr>
        </table>
        <? if (!defined("NO_SEARCH")): ?>
        <form class="search">
            <input type="text" placeholder="Поиск по каталогу" />
            <button type="submit"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_search_input.svg" /></button>
        </form>
        <? endif; ?>
        
        <hr/>
        
        <? if (!defined("NO_BACKLINE")): ?>
        
        <div class="back-topbar">
            <table width="100%">
                <tr>
                    <td class="left">
                        <a class="back" href="#" onclick="BXMobileApp.PageManager.goBack(); return false;">Назад</a>
                    </td>
                    <td class="right">
                        <?=$APPLICATION->ShowProperty("BackLineRight");?>
                    </td>
                </tr>
            </table>
        </div>
        <? endif; ?>

    </div>
    
    
    <? if (!defined("NO_BOTTOMBAR")): ?>
    <div class="bottombar">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td <?if($APPLICATION->GetCurDir() == "/app/catalog/"): ?>class="active"<?endif;?>><a href="/app/catalog/"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_bottombar_catalog.svg" /><br/>Каталог</a></td>
                <td <?if($APPLICATION->GetCurDir() == "/app/personal/my/"): ?>class="active"<?endif;?>><a href="/app/personal/my/"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_bottombar_account.svg" /><br/>Аккаунт</a></td>
                <td <?if($APPLICATION->GetCurDir() == "/app/personal/qr/"): ?>class="active"<?endif;?>><a href="/app/personal/qr/"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_bottombar_qr.svg" /><br/>Мой QR-код</a></td>
                <td <?if($APPLICATION->GetCurDir() == "/app/shops/"): ?>class="active"<?endif;?>><a href="/app/shops/"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_bottombar_shops.svg" /><br/>Магазины</a></td>
            </tr>
        </table>
    </div>
    <? endif; ?>
    
    <? if (!defined("NO_WRAPPER")): ?>
    <div class="wrapper <? if (defined("NO_BACKLINE")): ?>no-backline<?endif;?> <? if (defined("NO_SEARCH")): ?>no-search<?endif;?>">
    <? endif; ?>   
<? endif; ?>