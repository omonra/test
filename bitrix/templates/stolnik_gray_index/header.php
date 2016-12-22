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
        <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">



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
            'js/main.js',
            'js/cycle.min.js',
        ));?>

        <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script>
        <link rel="shortcut icon" type="image/x-icon" href="/bitrix/templates/stolnik_gray/favicon.png" />
<!-- bx head -->
<?$APPLICATION->ShowHead();?>
<!-- END bx head -->
<script type="text/javascript">;(function(){if(window.wit_inited)return; window.wit_inited=true; var b=(typeof this.href!="undefined")?this.href:document.location; b=b.toString().toLowerCase(); var c=(window.WitgetData)?"&userdata="+JSON.stringify(window.WitgetData):''; var a=document.createElement("script"); a.type="text/javascript"; a.async=true;a.src="//loader.witget.com/v2.4/7576da1c7fb36a909d27647cfdffad41?ref="+document.referrer+"&url="+b+"&nc="+Math.random()+c; var s=document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(a,s)})(); </script>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '545296665642070');
fbq('track', "PageView");</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=545296665642070&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = location.protocol + '//vk.com/rtrg?r=oM8d1MbOEfcQ631NcJxTmcf4Bk40vUm4rxkfuQ3Uu1cQuDf8*Lw6x5K4Msy2ygz4VYqzHj3TaRfe1TX60bRCOcD/fkDgYPCkg7UljQqgwnlTBWwaUBW1Xx22VlSgmgACTCh61p9kcqlUHHoxtD3CFp/2z//ql4vUB4kuw5J2j60-';</script>    
</head>
    <body>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>

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
                    <!--
                    <a href="#SIMPLE_FORM_2" title="Перезвоните мне" class="b-header__phone__link jsform">Перезвоните мне</a>
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

            <?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "header_basket", array(
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

        <?
        #TODO
        if ($APPLICATION->GetCurDir() == '/new_template/') $isIndexPage = true;

        $bannersBig = Array();
        $bannersMiddle = Array();
        $bannersSmall = Array();
        $arSelectBanners = Array("ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_PICTURE",  "PROPERTY_LINKS", "PROPERTY_TYPE");
        $arFilterBanners = Array("IBLOCK_ID"=>IntVal(61), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
        $BannersDBR = CIBlockElement::GetList(Array("sort" => "asc"), $arFilterBanners, false, Array("nPageSize"=>50), $arSelectBanners);
        while($banners = $BannersDBR->GetNextElement())
        {
            $arFields = $banners->GetFields();
            switch($arFields['PROPERTY_TYPE_ENUM_ID']){
                case "1577": $bannersBig[] = $arFields; break;
                case "1578": $bannersMiddle[] = $arFields; break;
                case "1579": $bannersSmall[] = $arFields; break;
            }
        }
        ?>
        <?if ($isIndexPage && count($bannersBig) > 0):?>
            <section class="header-banners" style=" margin-top: 10px; width: 100%; height: 450px; overflow: hidden; text-align: center; ">
                <div class="header-banners__box cycle-slideshow" data-cycle-fx="fade" data-cycle-speedIn='1000' data-cycle-speedOut='1000' data-cycle-slides="> a"  data-cycle-auto-height="4:3" data-cycle-sped='1000' data-cycle-delay="-2000" style=" overflow: hidden;">
                    <? foreach ($bannersBig as $bBig):?>
                        <a href="<?=$bBig['PROPERTY_LINKS_VALUE']?>" style="background: url('<?= CFile::GetPath($bBig['DETAIL_PICTURE'])?>') center center; display: block; width: 100%; height: 450px;"></a>
                    <?endforeach;?>
                </div>
            </section>
        <?endif;?>

        <section class="b-wrapper<?//=($isIndexPage ? ' b-wrapper_grey' : '')?>">
            <section class="b-container <?=($isIndexPage ? 'g-clear' : 'b-container_bordered')?>">
                <?if ($isIndexPage):?>
                    <section class="h-banner" style="float: left; width: 625px; margin-top: 10px;">
                        <section style="margin-bottom: 10px;">
                            <a href="<?= $bannersMiddle[0]['PROPERTY_LINKS_VALUE']?>">
                                <img src="<?=CFile::GetPath($bannersMiddle[0]['DETAIL_PICTURE']);?>" />
                            </a>
                        </section>
                        <section class="">
                            <a href="<?= $bannersMiddle[1]['PROPERTY_LINKS_VALUE']?>">
                                <img src="<?=CFile::GetPath($bannersMiddle[1]['DETAIL_PICTURE']);?>" />
                            </a>
                        </section>
                    </section>
                    <section class="h-banner" style="float: left;  margin-top: 10px; width: 286px; height: 485px; margin-left: 10px; border: 9px solid red;">
                        <?
                        $arSelect = Array("ID", "NAME","SECTION_ID", "PROPERTY_PRODUCT", "PROPERTY_END_DATE");
                        $arFilter = Array("IBLOCK_ID"=>IntVal(62), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
                        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
                        while($ob = $res->GetNextElement())
                        {
                            $arFields = $ob->GetFields();
                            #var_dump($arFields);
                            $arElSelect = Array("ID", "NAME","DETAIL_PAGE_URL","DETAIL_PICTURE","PROPERTY_PRICE","PROPERTY_STARYE_TSENY","PROPERTY_MAXIMUM_PRICE","PROPERTY_comments_sum");
                            $arElFilter = Array("IBLOCK_ID"=>IntVal(4), "ID"=>$arFields["PROPERTY_PRODUCT_VALUE"]);
                            $resEl = CIBlockElement::GetList(Array(), $arElFilter, false, Array("nPageSize"=>1), $arElSelect);
                            while($obEl = $resEl->GetNextElement()) {
                                #var_dump($obEl);
                                $ar_res = $obEl->GetFields();
                            ?>

                                <div class="h-banner__title">Спецпредложение</div>
                                <ul class="b-list b-list_products items" style="margin-left: 35px;">
                                    <li class="item" id="bx_2125679677_395707">
                                        <a href="<?=$ar_res['DETAIL_PAGE_URL']?>" class="link" title="<?=$ar_res['NAME']?>">
                                            <span class="new"></span>
                                            <?$img = CFile::ResizeImageGet($ar_res['DETAIL_PICTURE'], Array("width" => 220, "height" => 276));?>
                                            <span class="img" style="background-image: url(<?=$img['src']?>)" alt="<?=$ar_res['NAME']?>">
                                    </span>
                                        </a>
                                        <a class="title" href="<?=$ar_res['DETAIL_PAGE_URL']?>" title="<?=$ar_res['NAME']?>"><?=$ar_res['NAME']?></a>
                                        <div class="cost">
                                            <?if((int)$ar_res["PROPERTY_STARYE_TSENY_VALUE"] > 0):?>
                                                <strike><?=intval($ar_res["PROPERTY_STARYE_TSENY_VALUE"])?> руб.</strike>
                                                <?if($ar_res["PROPERTY_PRICE_VALUE"]>0):?>
                                                    <i><?=$ar_res["PROPERTY_PRICE_VALUE"]?> руб.</i>
                                                <?endif;?>
                                            <?else:?>
                                                <?if($ar_res["PROPERTY_MAXIMUM_PRICE_VALUE"]>0):?>
                                                    <?$max = explode(".",$ar_res["PROPERTY_MAXIMUM_PRICE_VALUE"]);?>
                                                    <strong><?=$max[0]?> руб.</strong>
                                                <?endif;?>
                                            <?endif;?>
                                        </div>
                                        <span class="stars">
                                            <?for ($i = round(intval($arItem['PROPERTY_COMMENTS_SUM_VALUE']) / intval($arItem['PROPERTY_COMMENTS_SUM_VALUE'])); $i > 0; $i--):?>
                                                <i></i>
                                            <?endfor;?>
                                        </span>
                                        <span class="reviews">(<?=intval($arItem['PROPERTY_COMMENTS_SUM_VALUE'])?>)</span>
                                        <?if (is_array($arItem['SIZES']) && count($arItem['SIZES']) > 0):
                                            $count = count($arItem['SIZES']);
                                            ?>
                                            <div class="size g-clear">
                                                <div class="txt">Размеры в наличии</div>
                                                <div class="dimensions">
                                                    <?foreach ($arItem['SIZES'] as $key2 => $size):?>
                                                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>" title="Размер <?=$size?>"><?=$size?></a><?=($key2 == $count - 1 ? '' : ' |')?>
                                                    <?endforeach;?>
                                                </div>
                                            </div>
                                        <?endif;?>
                                    </li>
                                </ul>
                                <div style="clear: both"></div>
                                <div class="jsTimer">
                                </div>

                            <?}?>
                            <script>
                                var upgradeTime = <?=intval(MakeTimeStamp($arFields['PROPERTY_END_DATE_VALUE'], "DD.MM.YYYY HH:MI:SS")-getmicrotime())?>;
                                var seconds = upgradeTime;
                                function timer() {
                                    var days        = Math.floor(seconds/24/60/60);
                                    var hoursLeft   = Math.floor((seconds) - (days*86400));
                                    var hours       = Math.floor(hoursLeft/3600);
                                    var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
                                    var minutes     = Math.floor(minutesLeft/60);
                                    var remainingSeconds = seconds % 60;
                                    if(days<10){ days = "0"+days}
                                    if(hours<10){ hours = "0"+hours}
                                    if(minutes<10){ minutes = "0"+minutes}
                                    if(remainingSeconds<10){ remainingSeconds = "0"+remainingSeconds}
                                    document.querySelector('.jsTimer').innerHTML = '<span class="jsTimerHour">' + hours + "</span>" +
                                        '<span class="jsTimerMinute">' + minutes + "</span><span class='jsTimerSecon'>" + remainingSeconds + "</span>";
                                    if (seconds == 0) {
                                        clearInterval(countdownTimer);
                                        document.querySelector('.jsTimer').innerHTML = "Completed";
                                    } else {
                                        seconds--;
                                    }
                                }
                                var countdownTimer = setInterval('timer()', 1000);

                            </script>
                        <?}?>


                    </section>
                    <div style="clear: both"></div>
                    <section class="h-banner" style="float: left;">
                        <a href="<?= $bannersSmall[0]['PROPERTY_LINKS_VALUE']?>">
                            <img src="<?=CFile::GetPath($bannersSmall[0]['DETAIL_PICTURE']);?>" />
                        </a>
                    </section>
                    <section class="h-banner" style="float: left; margin-left: 6px;">
                        <a href="<?= $bannersMiddle[2]['PROPERTY_LINKS_VALUE']?>">
                            <img src="<?=CFile::GetPath($bannersMiddle[2]['DETAIL_PICTURE']);?>" />
                        </a>
                    </section>
                    <div style="clear: both"></div>
                <?endif;?>
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
