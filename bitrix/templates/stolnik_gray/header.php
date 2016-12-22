<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$curPage = $APPLICATION->GetCurPage(true);
$isIndexPage = $curPage == SITE_DIR . 'index.php';
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
    <!--<![endif]-->
    <head>
        <title><?$APPLICATION->ShowTitle()?></title>
        <meta name='yandex-verification' content='755e2298e3e7776b' />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="msthemecompatible" content="no"/>
        <meta http-equiv="cleartype" content="on"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">



        <?ShowTemplateCss(array(
            'vendors/jquery.fancybox.css',
            'vendors/jquery-ui.css',
            'vendors/jquery.formstyler.css',
            'vendors/jquery.jscrollpane.css',
            'css/core.css',
            'css/bootstrap.min.css',

        ));?>
        <?ShowTemplateJs(array(
            'vendors/jq.1.11.1.js',
            'vendors/jquery-ui.js',
            'vendors/jquery.carouFredSel-6.2.1-packed.js',
            'vendors/jquery.fancybox.js',
            'vendors/jquery.rating.js',
            'vendors/jquery.formstyler.js',
            'vendors/jquery.mousewheel.js',
            'vendors/jquery.jscrollpane.js',
            'vendors/handlebars.js',
            'vendors/underscore-min.js',
            'vendors/jquery.maskedinput.min.js',
            'js/plugins.js',
            'js/validate.js',
            'js/bootstrap.min.js',
            'js/main.js?v=1',
        ));?>

        <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script>
        <link rel="shortcut icon" type="image/x-icon" href="/bitrix/templates/stolnik_gray/favicon.png" />
<!-- bx head -->
<?$APPLICATION->ShowHead();?>
<!-- END bx head -->
<script type="text/javascript">;(function(){if(window.wit_inited)return; window.wit_inited=true; var b=(typeof this.href!="undefined")?this.href:document.location; b=b.toString().toLowerCase(); var c=(window.WitgetData)?"&userdata="+JSON.stringify(window.WitgetData):''; var a=document.createElement("script"); a.type="text/javascript"; a.async=true;a.src="//loader.witget.com/v2.4/7576da1c7fb36a909d27647cfdffad41?ref="+document.referrer+"&url="+b+"&nc="+Math.random()+c; var s=document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(a,s)})(); </script>
<script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = location.protocol + '//vk.com/rtrg?r=oM8d1MbOEfcQ631NcJxTmcf4Bk40vUm4rxkfuQ3Uu1cQuDf8*Lw6x5K4Msy2ygz4VYqzHj3TaRfe1TX60bRCOcD/fkDgYPCkg7UljQqgwnlTBWwaUBW1Xx22VlSgmgACTCh61p9kcqlUHHoxtD3CFp/2z//ql4vUB4kuw5J2j60-';</script>
</head>
    <body>
    <?
    global $USER;
    if (!defined('USER_URDER_HIDE') && $USER->IsAuthorized()):?>
        <div id="panel"><?$APPLICATION->ShowPanel();?></div>
    <?endif;?>

        <header>
            <nav>
                <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "header_top",
                array(
                    "ROOT_MENU_TYPE" => "header",
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "",
                    "USE_EXT" => "N",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array()
                ),
                false);?>

                <?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "header_auth", array(
                        "REGISTER_URL" => SITE_DIR."login/",
                        "PROFILE_URL" => SITE_DIR."personal/profile/",
                        "SHOW_ERRORS" => "N"
                    ),
                    false,
                    array()
                );?>
            </nav>
            <a href="<?=SITE_DIR?>" class="b-logo" title="<?=COption::GetOptionString('main', 'site_name', 'Интернет-магазин STOLNIK')?>">Stolnik</a>
            <div class="b-header__phone">
                <i class="phone"></i>
                <span class="wrapper">
                    <span class="number"><?$APPLICATION->IncludeFile(
                        SITE_DIR."include/phone.php",
                        array(),
                        array("MODE" => "html")
                    )?></span>
                    <!-- <a href="#SIMPLE_FORM_2" title="Перезвоните мне" class="b-header__phone__link jsform">Перезвоните мне</a> -->
                    <!--<a href="#" title="Перезвоните мне" class="b-header__phone__link" onclick="convead('widget', 'show', {id: 10577});return false;">Перезвоните мне</a>-->
                </span>
            </div>
            <div class="b-header__delivery">
                <i class="icon"></i>
                <span class="text">
                    <?$APPLICATION->IncludeFile(
                        SITE_DIR."include/header_delivery.php",
                        array(),
                        Array("MODE" => "html")
                    );?>
                </span>
            </div>

            <?$APPLICATION->IncludeComponent(
                "bitrix:sale.basket.basket.line",
                "header_basket",
                array(
                    "PATH_TO_BASKET" => "/personal/cart/",
                    "PATH_TO_ORDER" => "/personal/order/make/",
                    "SHOW_NUM_PRODUCTS" => "Y",
                    "SHOW_TOTAL_PRICE" => "Y",
                    "SHOW_EMPTY_VALUES" => "Y",
                    "SHOW_PERSONAL_LINK" => "N",
                    "PATH_TO_PERSONAL" => SITE_DIR."personal/",
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
                    "SHOW_SUMMARY" => "Y"
                ),
                false
            );?>

            <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "catalog",
                array(
                    "ROOT_MENU_TYPE" => "top",
                    "MAX_LEVEL" => "2",
                    "CHILD_MENU_TYPE" => "top",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "N",
                    "MENU_CACHE_GET_VARS" => array()
                ), false
            );?>
            <?$APPLICATION->IncludeComponent("bitrix:search.form", ".default", array(
                "PAGE" => "/search/",
                "USE_SUGGEST" => "Y",
                ),
                false,
                array(
                "ACTIVE_COMPONENT" => "Y"
                )
            );?>


        </header>

        <section class="b-wrapper<?=($isIndexPage ? ' b-wrapper_grey' : '')?>">
            <section class="b-container <?=($isIndexPage ? 'g-clear' : 'b-container_bordered')?>">
                <?
                if (!$isIndexPage):?>
                    <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", array(
                        "START_FROM" => "0",
                        "PATH" => "",
                        "SITE_ID" => "-"
                        ),
                        false,
                        array('HIDE_ICONS' => 'Y')
                    );?>
                <?endif;?>
                <!-- content -->
