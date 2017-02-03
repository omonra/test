<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

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
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/script.js");?>
	<?CJSCore::Init('ajax');?>
	<title><?$APPLICATION->ShowTitle()?></title>
        <script>
        
        </script>
</head>
<body id="body" class="<?=$APPLICATION->ShowProperty("BodyClass");?>">
<?//if (!CMobile::getInstance()->getDevice()) $APPLICATION->ShowPanel();?>
    <div class="topbar">
        <table width="100%">
            <tr>
                <td class="left">
                    <a href="#" onclick="BXMobileApp.UI.Slider.setState(BXMobileApp.UI.Slider.state.LEFT); return false;" class="btn-small"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_topbar_menu.svg" /></a>
                </td>
                <td class="center">
                    <img src="<?=SITE_TEMPLATE_PATH?>/images/logo_topbar.png" />
                </td>
                <td class="right two">
                     <a href="#" class="btn-small"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_topbar_phone.svg" /></a>
                    <a href="#" class="btn-small"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_topbar_basket.svg" /></a>
                </td>
            </tr>
        </table>
        <form class="search">
            <input type="text" placeholder="Поиск по каталогу" />
            <button type="submit"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_search_input.svg" /></button>
        </form>
    </div>
    <div class="bottombar">
        <table>
            <tr>
                <td><a href=""><img width="42" height="42" src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_bottombar_catalog.svg" /><br/>Каталог</a></td>
                <td><a href=""><img width="42" height="42" src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_bottombar_account.svg" /><br/>Аккаунт</a></td>
                <td><a href=""><img width="42" height="42" src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_bottombar_qr.svg" /><br/>Мой QR-код</a></td>
                <td><a href=""><img width="42" height="42" src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_bottombar_shops.svg" /><br/>Магазины</a></td>
            </tr>
        </table>
    </div>
    <div class="wrapper">