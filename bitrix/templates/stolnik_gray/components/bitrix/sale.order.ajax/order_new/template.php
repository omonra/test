<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Sale\DiscountCouponsManager;
if($arResult["DELIVERY"][84]!="")
    unset($arResult["DELIVERY"][84]);

//echo "<pre style='display: none'>";
//print_r($arResult);
//echo "</pre>";

?>
<a name="order_form"></a>
<div id="order_form_div">
<?if($_POST["is_ajax_post"] != "Y")
{
    ?>
    <script>
        function submitForm(val)
        {
            if(val != 'Y')
                BX('confirmorder').value = 'N';
            if(val == 'Y' && !$('#ORDER_FORM').valid()){
                return false;
            }
            if($('#ORDER_PROP_5').val() == 0){
                $('#ORDER_PROP_5_val').removeClass("valid").addClass("error");
                return false;
            }
            var orderForm = BX('ORDER_FORM');

            BX.ajax.submitComponentForm(orderForm, 'order_form_content', true);

            BX.addCustomEvent('onAjaxSuccess', function() {
                stolnik.initiallizeOrderPage();
            });

            BX.submit(orderForm);

            return true;
        }
    </script>
    <form action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data">

        <input type="hidden" name="confirmorder" id="confirmorder" value="Y">
        <input type="hidden" name="profile_change" id="profile_change" value="N">
        <input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
        <div id="order_form_content">
    <?
}
else
{
    $APPLICATION->RestartBuffer();

    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/vendors/jq.1.11.1.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/vendors/jquery.carouFredSel-6.2.1-packed.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/vendors/jquery.fancybox.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/vendors/jquery.rating.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/vendors/jquery.formstyler.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/main.js');
    
    if ($USER->IsAdmin())
{
        //echo $arResult["ORDER_PROP"]["USER_PROPS_Y"];
    //echo "<pre>";
    //print_r($arResult["ORDER_PROP"]["USER_PROPS_Y"]);
    //echo "</pre>";
}
}
?>

<NOSCRIPT>
    <div class="errortext"><?=GetMessage("SOA_NO_JS")?></div>
</NOSCRIPT>

<h1 class="b-page-title">Корзина</h1>
<?if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
{
    if(!empty($arResult["ERROR"]))
    {
        foreach($arResult["ERROR"] as $v)
            echo ShowError($v);
    }
    elseif(!empty($arResult["OK_MESSAGE"]))
    {
        foreach($arResult["OK_MESSAGE"] as $v)
            echo ShowNote($v);
    }

    include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
}
else
{
    if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
    {
        if(strlen($arResult["REDIRECT_URL"]) > 0)
        {
            ?>
            <script type="text/javascript">
            window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';

            </script>
            <?
            die();
        }
        else
        {
            include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");
        }
    } else {?>

<? if (count($arResult['BASKET_ITEMS']) > 0): ?>            
<div class="b-basket">
    <?=bitrix_sessid_post()?>
    <input type="hidden" name="PERSON_TYPE" value="<?=$arResult['USER_VALS']['PERSON_TYPE_ID']?>">
    <input type="hidden" name="PERSON_TYPE_OLD" value="<?=$arResult['USER_VALS']['PERSON_TYPE_ID']?>">

    <?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");?>

    <?if (!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y") {
        foreach ($arResult["ERROR"] as $v) {
            echo ShowError($v);
        }?>
        <script type="text/javascript">
            top.BX.scrollToNode(top.BX('ORDER_FORM'));
        </script>
    <?}?>

    <?	function check_mobile_device() {
        $mobile_agent_array = array('ipad', 'iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        // var_dump($agent);exit;
        foreach ($mobile_agent_array as $value) {
            if (strpos($agent, $value) !== false) return true;
        }
        return false;
    }?>
    <?if (is_array($arResult['DELIVERY']) && count($arResult['DELIVERY']) > 0):?>

		<style>
        .b-info-text {
            font-size: 1.2em;
            margin-top: 5px;
            font-weight: 600;
        }
        .b-info-content {
            padding: 0px 20px 10px;
        }
        .b-info {
            float: left;
            width: 50%;
            min-height: 130px;
        }
        </style>
		<? $is_mobile_device = check_mobile_device();
			if($is_mobile_device){
			}else{ ?>
				<div class="b-form__right" style="clear: both;">
            <ul>
                <?
                include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
                $arDeliveryProps = array('STREET', 'HOME', 'KW', 'DATE', 'TIME');
                $arParams = array();
                if ($arResult['USER_VALS']['DELIVERY_ID'] == RUSSIANPOST_DELIVERY_ID) {
                    $arParams['require_zip'] = true;
                    $arDeliveryProps[] = 'ZIP';
                }

                PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"], $arDeliveryProps, $arParams);
                ?>
                <?foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery):
                    if ($delivery_id !== 0 && intval($delivery_id) <= 0):
                        foreach ($arDelivery["PROFILES"] as $profile_id => $arProfile):
                            if ($arProfile["CHECKED"] != "Y" || strlen($arProfile['DESCRIPTION']) <= 0) {
                                continue;
                            }
                            ?>
                            <li >
                                <div class="text"><?=$arProfile['DESCRIPTION']?></div>
                            </li>
                        <?endforeach;?>
                    <?else:
                        if ($arDelivery["CHECKED"] != "Y" || strlen($arDelivery['DESCRIPTION']) <= 0) {
                            continue;
                        }
                        ?>
                        <li >
                            <div class="text"><?=$arDelivery['DESCRIPTION']?></div>
                        </li>
                    <?endif;?>
                <?endforeach;?>
            </ul>

        </div>

		<div class="b-form__right" style="clear: both;margin-top: 30px;">
            <div class="b-info">
                <div class="b-info-content">
                    <img src="/upload/iblock/498/4981ef093bf8b2da16495719d48b97d3.png"/>
                    <div class="b-info-text">Гарантия возврата товара в течение 14 дней после оплаты</div>
                </div>
            </div>
            <div class="b-info">
                <div class="b-info-content">
                    <img src="/upload/iblock/516/5169f93ab384f612890d10ba6204189c.png"/>
                    <div class="b-info-text">Бесплатная доставка по всей России<div style="font-size:0.8em">На заказы от 5000 руб. </div></div>
                </div>
            </div>
            <div class="b-info">
                <div class="b-info-content">
                    <img src="/upload/payments_new.png"/>
                    <div class="b-info-text">Безопастность платежей</div>
                </div>
            </div>
            <div class="b-info">
                <div class="b-info-content">
                    <img src="/upload/iblock/b60/b6068eef47062d399d50daabd958e6dd.png"/>
                    <div class="b-info-text">Актуальные модные коллекции</div>
                </div>
            </div>
        </div>
		<?	}
		?>





    <?endif;?>
    <div class="b-form__left" style="width:445px">
    <ul >
        <?
        $subscribe = $arResult['user']['UF_SUBSCRIBE'];
        if (isset($_POST['confirmorder'])) {
            $subscribe = $_POST['subscribe'] == 'on';
        }
        PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"], array('LOCATION', 'PHONE', 'CITY', 'FIO', 'EMAIL'), array('subscribe' => $subscribe));

        include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
        ?>
        <li>
            <label>Комментарии</label>
            <textarea name="ORDER_DESCRIPTION" id="ORDER_DESCRIPTION"><?=$arResult["USER_VALS"]["ORDER_DESCRIPTION"]?></textarea>
            <div class="text">
                Нажимая на кнопку "Отправить заказ", вы принимаете условия
                <a href="/articles/publichnaya-ofera/" class="js-fancy-all" target="_blank">Публичной оферты</a>
            </div>
        </li>
        <li>
            <input onClick="yaCounter26116233.reachGoal('order_make'); submitForm('Y'); return false;" type="submit" value="Отправить заказ"/>
        </li>
    </ul>
    </div>
	<?$is_mobile_device = check_mobile_device();
		if($is_mobile_device){?>
		<style>
        .b-info-text {
            font-size: 1.2em;
            margin-top: 5px;
            font-weight: 600;
        }
        .b-info-content {
            padding: 0px 20px 10px;
        }
        .b-info {
            float: left;
            width: 50%;
        }
        </style>
			<div class="b-form__right b-form-double" style="clear: both;">
            <ul>
                <?
                include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
                $arDeliveryProps = array('STREET', 'HOME', 'KW', 'DATE', 'TIME');
                $arParams = array();
                if ($arResult['USER_VALS']['DELIVERY_ID'] == RUSSIANPOST_DELIVERY_ID) {
                    $arParams['require_zip'] = true;
                    $arDeliveryProps[] = 'ZIP';
                }

                PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"], $arDeliveryProps, $arParams);
                ?>
                <?foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery):
                    if ($delivery_id !== 0 && intval($delivery_id) <= 0):
                        foreach ($arDelivery["PROFILES"] as $profile_id => $arProfile):
                            if ($arProfile["CHECKED"] != "Y" || strlen($arProfile['DESCRIPTION']) <= 0) {
                                continue;
                            }
                            ?>
                            <li >
                                <div class="text"><?=$arProfile['DESCRIPTION']?></div>
                            </li>
                        <?endforeach;?>
                    <?else:
                        if ($arDelivery["CHECKED"] != "Y" || strlen($arDelivery['DESCRIPTION']) <= 0) {
                            continue;
                        }
                        ?>
                        <li >
                            <div class="text"><?=$arDelivery['DESCRIPTION']?></div>
                        </li>
                    <?endif;?>
                <?endforeach;?>
            </ul>

        </div>
		<div class="b-form__right b-form-double" style="clear: both;margin-top: 30px;">
            <div class="b-info">
                <div class="b-info-content">
                    <img src="/upload/iblock/498/4981ef093bf8b2da16495719d48b97d3.png"/>
                    <div class="b-info-text">Гарантия возврата товара в течение 14 дней после оплаты</div>
                </div>
            </div>
            <div class="b-info">
                <div class="b-info-content">
                    <img src="/upload/iblock/516/5169f93ab384f612890d10ba6204189c.png"/>
                    <div class="b-info-text">Бесплатная доставка по всей России<div style="font-size:0.8em">На заказы от 5000 руб. </div></div>
                </div>
            </div>
            <div class="b-info">
                <div class="b-info-content">
                    <img src="/upload/payments_new.png"/>
                    <div class="b-info-text">Безопастность платежей</div>
                </div>
            </div>
            <div class="b-info">
                <div class="b-info-content">
                    <img src="/upload/iblock/b60/b6068eef47062d399d50daabd958e6dd.png"/>
                    <div class="b-info-text">Актуальные модные коллекции</div>
                </div>
            </div>
        </div>
		<?}else{
		}?>

    <div class="clear"></div>
</div>
<? endif; ?>


<table class="b-basket-table" <? if (count($arResult['BASKET_ITEMS']) == 0):?>style="margin-bottom: 30px;"<? endif; ?>>
    <?
    foreach ($arResult['BASKET_ITEMS'] as $key => $arItem):
        
        ?>
        <tr class="item" data-id="<?=$arItem['ID']?>">
            <td class="image">
                <?if (is_array($arItem['DETAIL_PICTURE']) && $arItem['DETAIL_PICTURE']['WIDTH'] > 0):?>
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" title="<?=$arItem['NAME']?>"><img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" width="<?=$arItem['DETAIL_PICTURE']['WIDTH']?>" height="<?=$arItem['DETAIL_PICTURE']['HEIGHT']?>" alt="<?=$arItem['NAME']?>" /></a>
                <?endif;?>
            </td>
            <td class="name">
                <? if ($arItem['CAN_BUY'] == "Y"): ?>
                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" title="<?=$arItem['NAME']?>"><?=$arItem['NAME']?></a>
                <? else: ?>
                <span style="color:#999; font-size: 16px;"><?=$arItem['NAME']?></span>
                <? endif; ?>
            </td>
            <? if ($arItem['CAN_BUY'] == "Y"): ?>
            <td class="cost">
                <?=FormatPrice($arItem['PRICE'], $arItem['CURRENCY'])?>
                <?if ($arItem['DISCOUNT_PRICE_PERCENT'] > 0):?>
                    <div class="discount">Скидка: <span class="value"><?=$arItem['DISCOUNT_PRICE_PERCENT_FORMATED']?></span></div>
                <?endif;?>
            </td>
            <td class="count">
                <div class="counter">
                    <span class="minus">-</span>
                    <input class="count-input" type="text" value="<?=$arItem['QUANTITY']?>" maxlength="4" />
                    <span class="plus">+</span>
                </div>
            </td>
            <td class="mass"><?=FormatPrice($arItem['PRICE'] * $arItem['QUANTITY'], $arItem['CURRENCY'])?></td>
            <? else: ?>
            <td colspan="3">
                Нет в наличии
            </td>
            <? endif; ?>
            <td class="remove">
                <i></i>
            </td>
        </tr>
    <?endforeach;?>
        
    <?foreach ($arResult['BASKET_ITEMS_NOT_AVALIABLE'] as $key => $arItem):
        
        ?>
        <tr class="item" data-id="<?=$arItem['ID']?>">
            <td class="image">
                <?if (is_array($arItem['DETAIL_PICTURE']) && $arItem['DETAIL_PICTURE']['WIDTH'] > 0):?>
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" title="<?=$arItem['NAME']?>"><img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" width="<?=$arItem['DETAIL_PICTURE']['WIDTH']?>" height="<?=$arItem['DETAIL_PICTURE']['HEIGHT']?>" alt="<?=$arItem['NAME']?>" /></a>
                <?endif;?>
            </td>
            <td class="name">
                <span style="color:#999; font-size: 16px;"><?=$arItem['NAME']?></span>
            </td>
            
            <td class="cost">
                <?=FormatPrice($arItem['PRICE'], $arItem['CURRENCY'])?>
                <?if ($arItem['DISCOUNT_PRICE_PERCENT'] > 0):?>
                    <div class="discount">Скидка: <span class="value"><?=$arItem['DISCOUNT_PRICE_PERCENT_FORMATED']?></span></div>
                <?endif;?>
            </td>
            <td>
                Нет в наличии
            </td>
            <td class="mass"><?=FormatPrice($arItem['PRICE'] * $arItem['QUANTITY'], $arItem['CURRENCY'])?></td>
            <td class="remove">
                <i></i>
            </td>
        </tr>
    <?endforeach;?>
</table>

<? if (count($arResult['BASKET_ITEMS']) > 0):?>
<table class="b-summary">
    <tr>
        <td class="text-left">
            При заказе товара на сумму свыше 5000 руб доставка Почтой России и ТК <br/> бесплатно.
            <div class="b-promo">
                <strong>Промокод</strong>
                <input type="text" id="COUPON" name="COUPON" value="" size="21" class="good">

                <input onClick="submitForm('N'); return false;" type="submit" value="Применить"/>

                <?
                if (!empty($arResult['COUPON_LIST'])) {
                    foreach ($arResult['COUPON_LIST'] as $oneCoupon) {
                        $couponClass = 'disabled';
                        switch ($oneCoupon['STATUS']) {
                            case DiscountCouponsManager::STATUS_NOT_FOUND:
                            case DiscountCouponsManager::STATUS_FREEZE:
                                $couponClass = 'bad';
                                break;
                            case DiscountCouponsManager::STATUS_APPLYED:
                                $couponClass = 'good';
                                break;
                        }
                        ?><div class="bx_ordercart_coupon"><?=htmlspecialcharsbx($oneCoupon['COUPON']);?><?
                            if (isset($oneCoupon['CHECK_CODE_TEXT'])) {
                                echo ' - ' . (is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']);
                            }
                        ?><span class="<? echo $couponClass; ?>" data-coupon="<? echo htmlspecialcharsbx($oneCoupon['COUPON']); ?>"></span></div><?
                    }
                    unset($couponClass, $oneCoupon);
                }
                ?>
            </div>
        </td>
        <td class="text-right bold g-clear">
            <?if ($arResult["DELIVERY_PRICE"] > 0):
                ?>
                <div class="delivery_price">Доставка: <span class="value"><?=FormatPrice($arResult["DELIVERY_PRICE"], $arResult["BASE_LANG_CURRENCY"])?></span></div>
                <?
            endif;?>

            <?=FormatPrice($arResult['ORDER_TOTAL_PRICE'], $arResult["BASE_LANG_CURRENCY"])?>
            <div class="infoDelivery">
                <?if($arResult['FAST_DELIVERY'] == "Y"){?>
                    Отправка до 3 дней
                <?}else{?>
                    Под заказ до 7 дней
                <?}?>
            </div>
            <div class="clearall"></div>
            <input onClick="yaCounter26116233.reachGoal('order_make'); submitForm('Y'); return false;" class="btn" value="Оформить покупку" type="submit"/>
            <input class="button button_clear_basket" value="Очистить корзину" type="button" />
        </td>
    </tr>
</table>
<? endif; ?>
<?

// dd(array_keys($arResult));
// dd($arResult['USER_VALS']);
// dd($arResult["DELIVERY_PRICE"]);

?>

</div>
<?if($_POST["is_ajax_post"] != "Y") {
    ?>

    </form>
    <?
    // if($arParams["DELIVERY_NO_AJAX"] == "N")
    // {
    //     $APPLICATION->AddHeadScript("/bitrix/js/main/cphttprequest.js");
    //     $APPLICATION->AddHeadScript("/bitrix/components/bitrix/sale.ajax.delivery.calculator/templates/.default/proceed.js");
    // }
} else {
    ?>
        <script type="text/javascript">
            top.BX('confirmorder').value = 'Y';
            top.BX('profile_change').value = 'N';
        </script>
    <?
    die();
}?>
</div>

<section class="hidden">
    <div id="oferta">
        <h1 class="title">
            Публичная оферта
        </h1>
        <div class="news-detail">
            <p><b>ОСНОВНЫЕ ПОНЯТИЯ</b></p>

            <p><b>Пользователь</b> &ndash; физическое лицо, посетитель Сайта, принимающий условия настоящего Соглашения и желающий разместить Заказы на сайте <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>.</p>
            <p><b>Покупатель</b> &ndash; Пользователь, разместивший Заказ на сайте <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>.</p>
            <p><b>Продавец</b> &ndash; ИП Экшиян Д.В. (ОГРН&nbsp; <span style="font-size: 11pt; line-height: 115%; font-family: 'Times New Roman';">313744829000028</span>&nbsp; &nbsp;&nbsp;, ИНН&nbsp; <span style="font-size: 11pt; line-height: 115%; font-family: 'Times New Roman';">744830169076</span>&nbsp; &nbsp;&nbsp;, место нахождения:454080, Россия г.Челябинск, ул.Коммуны 88 «Лакитур»).</p>
            <p><b>Интернет-магазин</b> &ndash; Интернет-сайт, принадлежащий Продавцу, расположенный в сети интернет по адресу <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>, где представлены Товары, предлагаемые Продавцом для приобретения, а также условия оплаты и доставки Товаров Покупателям.</p>
            <p><b>Сайт</b> &ndash; <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>. </p>
            <p><b>Товар</b> &ndash; обувь, одежда, аксессуары и иные товары, представленные к продаже на Сайте Продавца.</p>
            <p><b>Заказ</b> &ndash; должным образом оформленный запрос Покупателя на приобретение и доставку по указанному Покупателем адресу / посредством самовывоза Товаров, выбранных на Сайте.</p>
            <p><b><font color="#ee1d24">1. ОБЩИЕ ПОЛОЖЕНИЯ</font></b></p>
            <p><b>1.1.</b> Продавец осуществляет продажу Товаров через Интернет-магазин по адресу <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>.</p>
            <p><b>1.2.</b> Заказывая Товары через Интернет-магазин, Пользователь соглашается с условиями продажи Товаров, изложенными ниже (далее &ndash; Условия продажи товаров). В случае несогласия с настоящим Пользовательским соглашением (далее - Соглашение) Пользователь обязан немедленно прекратить использование сервиса и покинуть сайт <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>.</p>
            <p><b>1.3.</b> Настоящие Условия продажи товаров, а также информация о Товаре, представленная на Сайте, являются публичной офертой в соответствии со ст.435 и п.2 ст.437 Гражданского кодекса Российской Федерации.</p>
            <p><b>1.4.</b> Пользователь соглашается с Условиями продажи товаров путем проставления отметки в графе «С&nbsp;данными условиями согласен» при оформлении Заказа.</p>
            <p><b>1.5.</b> Соглашение может быть изменено Продавцом в одностороннем порядке без уведомления Пользователя/Покупателя. Новая редакция Соглашения вступает в силу по истечении 10 (Десяти) календарных дней с момента ее опубликования на Сайте, если иное не предусмотрено условиями настоящего Соглашения.</p>
            <p><b>1.6.</b> Соглашение вступает в силу с момента отправки Покупателю Продавцом электронного подтверждения принятия Заказа при оформлении Покупателем Заказа без авторизации на Сайте, а также с момента принятия от Покупателя Заказа по телефону 8 (351) 220-12-70 (для звонков из Челябинска) и 8 (800) 33-33-019 (для звонков из регионов).</p>
            <p>Сообщая Продавцу свой e-mail, Пользователь/Покупатель дает согласие на использование его в целях осуществления рассылок рекламно-информационного характера, содержащих информацию о скидках, предстоящих и действующих акциях и иных мероприятиях Продавца.</p>
            <p><b><font color="#ee1d24">2. ПРЕДМЕТ СОГЛАШЕНИЯ</font></b></p>
            <p><b>2.1.</b> Предметом настоящего Соглашения является предоставление возможности Пользователю приобретать для личных, семейных, домашних и иных нужд, не связанных с осуществлением предпринимательской деятельности, Товары, представленные в каталоге Интернет-магазина по адресу <a href="http://www.stolnik24.ru."><b>http://www.stolnik24.ru.</b></a></p>
            <p><b>2.2.</b> Данное Соглашение распространяется на все виды Товаров и услуг, представленных на Сайте, пока такие предложения с описанием присутствуют в каталоге Интернет-магазина.</p>
            <p><b><font color="#ee1d24">3. РЕГИСТРАЦИЯ НА САЙТЕ</font></b></p>
            <p><b>3.1.</b> Регистрация на Сайте осуществляется по адресу&nbsp;<a href="http://stolnik24.ru/login/?register=yes">http://stolnik24.ru/login/?register=yes</a></p>
            <p><b>3.2.</b> Регистрация на Сайте не является обязательной для оформления Заказа.</p>
            <p><b>3.3.</b> Продавец не несет ответственности за точность и правильность информации, предоставляемой&nbsp;Пользователем при регистрации.</p>
            <p><b>3.4.</b> Пользователь обязуется не сообщать третьим лицам логин и пароль, указанные Пользователем при регистрации. В случае возникновения у Пользователя подозрений относительно безопасности его логина и пароля или возможности их несанкционированного использования третьими лицами, Пользователь обязуется незамедлительно уведомить об этом Продавца, направив соответствующее электронное письмо по адресу: info@stok-stolnik.ru.</p>
            <p><b>3.5.</b> Общение Пользователя/Покупателя с операторами Call-центра / менеджерами и иными представителями Продавца должно строиться на принципах общепринятой морали и коммуникационного этикета. Строго запрещено использование нецензурных слов, брани, оскорбительных выражений, а также угроз и шантажа, в независимости от того, в каком виде и кому они были адресованы.</p>
            <p><b><font color="#ee1d24">4. ТОВАР И ПОРЯДОК СОВЕРШЕНИЯ ПОКУПКИ</font></b></p>
            <p><b>4.1.</b> Продавец обеспечивает наличие на своем складе Товаров, представленных на Сайте. Сопровождающие Товар фотографии являются простыми иллюстрациями к нему и могут отличаться от фактического внешнего вида Товара. Сопровождающие Товар описания/характеристики не претендуют на исчерпывающую информативность и могут содержать опечатки. Для уточнения информации по Товару Покупатель должен обратиться в Службу поддержки.Обновление информации, представленной на Сайте, производится каждые сутки.</p>
            <p><b>4.2.</b> В случае отсутствия заказанных Покупателем Товаров на складе Продавца, последний вправе исключить указанный Товар из Заказа / аннулировать Заказ Покупателя, уведомив об этом Покупателя путем направления соответствующего электронного сообщения по адресу, указанному Покупателем при регистрации (либо звонком оператора Call-центра Продавца).</p>
            <p><b>4.3.</b> В случае аннуляции полностью либо частично предоплаченного Заказа стоимость аннулированного Товара возвращается Продавцом Покупателю способом, которым Товар был оплачен.</p>
            <p><b>4.4.</b> Заказ Покупателя оформляется в соответствии с процедурами, указанными на Сайте в разделе «Оформление Заказа» по адресу&nbsp;<a href="http://stolnik24.ru/articles/help/">http://stolnik24.ru/articles/help/</a></p>
            <p><b>4.5.</b> Покупатель несет полную ответственность за предоставление неверных сведений, повлекшее за собой невозможность надлежащего исполнения Продавцом своих обязательств перед Покупателем.</p>
            <p><b>4.6.</b> После оформления Заказа на Сайте. Менеджер,обслуживающий данный Заказ, в течении 1-2 дней(не считая праздники и сб\вс) уточняет детали Заказа, согласовывает дату доставки, которая зависит от наличия заказанных Товаров на складе Продавца и времени, необходимого для обработки и доставки Заказа.В период распродаж и акций,обработка заказа может задерживаться до 7 дней.</p>
            <p><b>4.7.</b> Ожидаемая дата передачи Заказа в Службу доставки сообщается Покупателю менеджером, обслуживающим Заказ, по электронной почте или при контрольном звонке Покупателю.</p>
            <p><b><font color="#ee1d24">5. ДОСТАВКА ЗАКАЗА</font></b></p>
            <p><b>5.1.</b> Способы, а также примерные сроки доставки Товаров указаны на Сайте в разделе «Способы доставки» по адресу&nbsp;<a href="http://stolnik24.ru/articles/dostavka/"><b>ссылка</b></a>&nbsp;&nbsp;Конкретные сроки доставки могут быть согласованы Покупателем с оператором Call-центра при подтверждении заказа.</p>
            <p><b>5.2.</b> Территория доставки Товаров, представленных на Сайте, ограничена пределами Российской Федерации.</p>
            <p><b>5.3.</b> Задержки в доставке возможны ввиду непредвиденных обстоятельств, произошедших не по вине Продавца.</p>
            <p><b>5.4.</b> При доставке Заказ вручается Покупателю либо третьему лицу, указанному в Заказе качестве получателя (далее Покупатель и третье лицо именуются «Получатель»). При невозможности получения Заказа, оплаченного посредством наличного расчета, указанными выше лицами, Заказ может быть вручен лицу, который может предоставить сведения о Заказе (номер отправления и/или ФИО Получателя), а также оплатить стоимость Заказа в полном объеме лицу, осуществляющему доставку Заказа.</p>
            <p><b>5.5.</b> Во избежание случаев мошенничества, а также для выполнения взятых на себя обязательств, указанных в пункте 5. настоящего Соглашения, при вручении предоплаченного Заказа лицо, осуществляющее доставку Заказа, вправе затребовать документ, удостоверяющий личность Получателя, а также указать тип и номер предоставленного Получателем документа на квитанции к Заказу. Продавец гарантирует конфиденциальность и защиту персональных данных Получателя (п.9.3.).</p>
            <p><b>5.6.</b> Риск случайной гибели или случайного повреждения Товара переходит к Покупателю с момента передачи ему Заказа и проставления Получателем Заказа подписи в документах, подтверждающих доставку Заказа. В случае недоставки Заказа Продавец возмещает Покупателю стоимость предоплаченного Покупателем Заказа и доставки в полном объеме после получения от Службы доставки подтверждения утраты Заказа.</p>
        </div>
    </div>
</section>
    <?}
}?>
