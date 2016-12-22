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

<h1 class="b-page-title">�������</h1>
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
                    <div class="b-info-text">�������� �������� ������ � ������� 14 ���� ����� ������</div>
                </div>
            </div>
            <div class="b-info">
                <div class="b-info-content">
                    <img src="/upload/iblock/516/5169f93ab384f612890d10ba6204189c.png"/>
                    <div class="b-info-text">���������� �������� �� ���� ������<div style="font-size:0.8em">�� ������ �� 5000 ���. </div></div>
                </div>
            </div>
            <div class="b-info">
                <div class="b-info-content">
                    <img src="/upload/payments_new.png"/>
                    <div class="b-info-text">������������� ��������</div>
                </div>
            </div>
            <div class="b-info">
                <div class="b-info-content">
                    <img src="/upload/iblock/b60/b6068eef47062d399d50daabd958e6dd.png"/>
                    <div class="b-info-text">���������� ������ ���������</div>
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
            <label>�����������</label>
            <textarea name="ORDER_DESCRIPTION" id="ORDER_DESCRIPTION"><?=$arResult["USER_VALS"]["ORDER_DESCRIPTION"]?></textarea>
            <div class="text">
                ������� �� ������ "��������� �����", �� ���������� �������
                <a href="/articles/publichnaya-ofera/" class="js-fancy-all" target="_blank">��������� ������</a>
            </div>
        </li>
        <li>
            <input onClick="yaCounter26116233.reachGoal('order_make'); submitForm('Y'); return false;" type="submit" value="��������� �����"/>
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
                    <div class="b-info-text">�������� �������� ������ � ������� 14 ���� ����� ������</div>
                </div>
            </div>
            <div class="b-info">
                <div class="b-info-content">
                    <img src="/upload/iblock/516/5169f93ab384f612890d10ba6204189c.png"/>
                    <div class="b-info-text">���������� �������� �� ���� ������<div style="font-size:0.8em">�� ������ �� 5000 ���. </div></div>
                </div>
            </div>
            <div class="b-info">
                <div class="b-info-content">
                    <img src="/upload/payments_new.png"/>
                    <div class="b-info-text">������������� ��������</div>
                </div>
            </div>
            <div class="b-info">
                <div class="b-info-content">
                    <img src="/upload/iblock/b60/b6068eef47062d399d50daabd958e6dd.png"/>
                    <div class="b-info-text">���������� ������ ���������</div>
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
                    <div class="discount">������: <span class="value"><?=$arItem['DISCOUNT_PRICE_PERCENT_FORMATED']?></span></div>
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
                ��� � �������
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
                    <div class="discount">������: <span class="value"><?=$arItem['DISCOUNT_PRICE_PERCENT_FORMATED']?></span></div>
                <?endif;?>
            </td>
            <td>
                ��� � �������
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
            ��� ������ ������ �� ����� ����� 5000 ��� �������� ������ ������ � �� <br/> ���������.
            <div class="b-promo">
                <strong>��������</strong>
                <input type="text" id="COUPON" name="COUPON" value="" size="21" class="good">

                <input onClick="submitForm('N'); return false;" type="submit" value="���������"/>

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
                <div class="delivery_price">��������: <span class="value"><?=FormatPrice($arResult["DELIVERY_PRICE"], $arResult["BASE_LANG_CURRENCY"])?></span></div>
                <?
            endif;?>

            <?=FormatPrice($arResult['ORDER_TOTAL_PRICE'], $arResult["BASE_LANG_CURRENCY"])?>
            <div class="infoDelivery">
                <?if($arResult['FAST_DELIVERY'] == "Y"){?>
                    �������� �� 3 ����
                <?}else{?>
                    ��� ����� �� 7 ����
                <?}?>
            </div>
            <div class="clearall"></div>
            <input onClick="yaCounter26116233.reachGoal('order_make'); submitForm('Y'); return false;" class="btn" value="�������� �������" type="submit"/>
            <input class="button button_clear_basket" value="�������� �������" type="button" />
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
            ��������� ������
        </h1>
        <div class="news-detail">
            <p><b>�������� �������</b></p>

            <p><b>������������</b> &ndash; ���������� ����, ���������� �����, ����������� ������� ���������� ���������� � �������� ���������� ������ �� ����� <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>.</p>
            <p><b>����������</b> &ndash; ������������, ������������ ����� �� ����� <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>.</p>
            <p><b>��������</b> &ndash; �� ������ �.�. (����&nbsp; <span style="font-size: 11pt; line-height: 115%; font-family: 'Times New Roman';">313744829000028</span>&nbsp; &nbsp;&nbsp;, ���&nbsp; <span style="font-size: 11pt; line-height: 115%; font-family: 'Times New Roman';">744830169076</span>&nbsp; &nbsp;&nbsp;, ����� ����������:454080, ������ �.���������, ��.������� 88 ��������).</p>
            <p><b>��������-�������</b> &ndash; ��������-����, ������������� ��������, ������������� � ���� �������� �� ������ <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>, ��� ������������ ������, ������������ ��������� ��� ������������, � ����� ������� ������ � �������� ������� �����������.</p>
            <p><b>����</b> &ndash; <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>. </p>
            <p><b>�����</b> &ndash; �����, ������, ���������� � ���� ������, �������������� � ������� �� ����� ��������.</p>
            <p><b>�����</b> &ndash; ������� ������� ����������� ������ ���������� �� ������������ � �������� �� ���������� ����������� ������ / ����������� ���������� �������, ��������� �� �����.</p>
            <p><b><font color="#ee1d24">1. ����� ���������</font></b></p>
            <p><b>1.1.</b> �������� ������������ ������� ������� ����� ��������-������� �� ������ <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>.</p>
            <p><b>1.2.</b> ��������� ������ ����� ��������-�������, ������������ ����������� � ��������� ������� �������, ����������� ���� (����� &ndash; ������� ������� �������). � ������ ���������� � ��������� ���������������� ����������� (����� - ����������) ������������ ������ ���������� ���������� ������������� ������� � �������� ���� <a href="http://www.stolnik24.ru"><b>http://www.stolnik24.ru</b></a>.</p>
            <p><b>1.3.</b> ��������� ������� ������� �������, � ����� ���������� � ������, �������������� �� �����, �������� ��������� ������� � ������������ �� ��.435 � �.2 ��.437 ������������ ������� ���������� ���������.</p>
            <p><b>1.4.</b> ������������ ����������� � ��������� ������� ������� ����� ������������ ������� � ����� ��&nbsp;������� ��������� �������� ��� ���������� ������.</p>
            <p><b>1.5.</b> ���������� ����� ���� �������� ��������� � ������������� ������� ��� ����������� ������������/����������. ����� �������� ���������� �������� � ���� �� ��������� 10 (������) ����������� ���� � ������� �� ������������� �� �����, ���� ���� �� ������������� ��������� ���������� ����������.</p>
            <p><b>1.6.</b> ���������� �������� � ���� � ������� �������� ���������� ��������� ������������ ������������� �������� ������ ��� ���������� ����������� ������ ��� ����������� �� �����, � ����� � ������� �������� �� ���������� ������ �� �������� 8 (351) 220-12-70 (��� ������� �� ����������) � 8 (800) 33-33-019 (��� ������� �� ��������).</p>
            <p>������� �������� ���� e-mail, ������������/���������� ���� �������� �� ������������� ��� � ����� ������������� �������� ��������-��������������� ���������, ���������� ���������� � �������, ����������� � ����������� ������ � ���� ������������ ��������.</p>
            <p><b><font color="#ee1d24">2. ������� ����������</font></b></p>
            <p><b>2.1.</b> ��������� ���������� ���������� �������� �������������� ����������� ������������ ����������� ��� ������, ��������, �������� � ���� ����, �� ��������� � �������������� ������������������� ������������, ������, �������������� � �������� ��������-�������� �� ������ <a href="http://www.stolnik24.ru."><b>http://www.stolnik24.ru.</b></a></p>
            <p><b>2.2.</b> ������ ���������� ���������������� �� ��� ���� ������� � �����, �������������� �� �����, ���� ����� ����������� � ��������� ������������ � �������� ��������-��������.</p>
            <p><b><font color="#ee1d24">3. ����������� �� �����</font></b></p>
            <p><b>3.1.</b> ����������� �� ����� �������������� �� ������&nbsp;<a href="http://stolnik24.ru/login/?register=yes">http://stolnik24.ru/login/?register=yes</a></p>
            <p><b>3.2.</b> ����������� �� ����� �� �������� ������������ ��� ���������� ������.</p>
            <p><b>3.3.</b> �������� �� ����� ��������������� �� �������� � ������������ ����������, ���������������&nbsp;������������� ��� �����������.</p>
            <p><b>3.4.</b> ������������ ��������� �� �������� ������� ����� ����� � ������, ��������� ������������� ��� �����������. � ������ ������������� � ������������ ���������� ������������ ������������ ��� ������ � ������ ��� ����������� �� �������������������� ������������� �������� ������, ������������ ��������� ��������������� ��������� �� ���� ��������, �������� ��������������� ����������� ������ �� ������: info@stok-stolnik.ru.</p>
            <p><b>3.5.</b> ������� ������������/���������� � ����������� Call-������ / ����������� � ����� ��������������� �������� ������ ��������� �� ��������� ������������ ������ � ����������������� �������. ������ ��������� ������������� ����������� ����, �����, �������������� ���������, � ����� ����� � �������, � ������������� �� ����, � ����� ���� � ���� ��� ���� ����������.</p>
            <p><b><font color="#ee1d24">4. ����� � ������� ���������� �������</font></b></p>
            <p><b>4.1.</b> �������� ������������ ������� �� ����� ������ �������, �������������� �� �����. �������������� ����� ���������� �������� �������� ������������� � ���� � ����� ���������� �� ������������ �������� ���� ������. �������������� ����� ��������/�������������� �� ���������� �� ������������� ��������������� � ����� ��������� ��������. ��� ��������� ���������� �� ������ ���������� ������ ���������� � ������ ���������.���������� ����������, �������������� �� �����, ������������ ������ �����.</p>
            <p><b>4.2.</b> � ������ ���������� ���������� ����������� ������� �� ������ ��������, ��������� ������ ��������� ��������� ����� �� ������ / ������������ ����� ����������, �������� �� ���� ���������� ����� ����������� ���������������� ������������ ��������� �� ������, ���������� ����������� ��� ����������� (���� ������� ��������� Call-������ ��������).</p>
            <p><b>4.3.</b> � ������ ��������� ��������� ���� �������� ��������������� ������ ��������� ��������������� ������ ������������ ��������� ���������� ��������, ������� ����� ��� �������.</p>
            <p><b>4.4.</b> ����� ���������� ����������� � ������������ � �����������, ���������� �� ����� � ������� ����������� ������ �� ������&nbsp;<a href="http://stolnik24.ru/articles/help/">http://stolnik24.ru/articles/help/</a></p>
            <p><b>4.5.</b> ���������� ����� ������ ��������������� �� �������������� �������� ��������, ��������� �� ����� ������������� ����������� ���������� ��������� ����� ������������ ����� �����������.</p>
            <p><b>4.6.</b> ����� ���������� ������ �� �����. ��������,������������� ������ �����, � ������� 1-2 ����(�� ������ ��������� � ��\��) �������� ������ ������, ������������� ���� ��������, ������� ������� �� ������� ���������� ������� �� ������ �������� � �������, ������������ ��� ��������� � �������� ������.� ������ ��������� � �����,��������� ������ ����� ������������� �� 7 ����.</p>
            <p><b>4.7.</b> ��������� ���� �������� ������ � ������ �������� ���������� ���������� ����������, ������������� �����, �� ����������� ����� ��� ��� ����������� ������ ����������.</p>
            <p><b><font color="#ee1d24">5. �������� ������</font></b></p>
            <p><b>5.1.</b> �������, � ����� ��������� ����� �������� ������� ������� �� ����� � ������� �������� �������� �� ������&nbsp;<a href="http://stolnik24.ru/articles/dostavka/"><b>������</b></a>&nbsp;&nbsp;���������� ����� �������� ����� ���� ����������� ����������� � ���������� Call-������ ��� ������������� ������.</p>
            <p><b>5.2.</b> ���������� �������� �������, �������������� �� �����, ���������� ��������� ���������� ���������.</p>
            <p><b>5.3.</b> �������� � �������� �������� ����� �������������� �������������, ������������ �� �� ���� ��������.</p>
            <p><b>5.4.</b> ��� �������� ����� ��������� ���������� ���� �������� ����, ���������� � ������ �������� ���������� (����� ���������� � ������ ���� ��������� ������������). ��� ������������� ��������� ������, ����������� ����������� ��������� �������, ���������� ���� ������, ����� ����� ���� ������ ����, ������� ����� ������������ �������� � ������ (����� ����������� �/��� ��� ����������), � ����� �������� ��������� ������ � ������ ������ ����, ��������������� �������� ������.</p>
            <p><b>5.5.</b> �� ��������� ������� �������������, � ����� ��� ���������� ������ �� ���� ������������, ��������� � ������ 5. ���������� ����������, ��� �������� ��������������� ������ ����, �������������� �������� ������, ������ ����������� ��������, �������������� �������� ����������, � ����� ������� ��� � ����� ���������������� ����������� ��������� �� ��������� � ������. �������� ����������� ������������������ � ������ ������������ ������ ���������� (�.9.3.).</p>
            <p><b>5.6.</b> ���� ��������� ������ ��� ���������� ����������� ������ ��������� � ���������� � ������� �������� ��� ������ � ������������ ����������� ������ ������� � ����������, �������������� �������� ������. � ������ ���������� ������ �������� ��������� ���������� ��������� ��������������� ����������� ������ � �������� � ������ ������ ����� ��������� �� ������ �������� ������������� ������ ������.</p>
        </div>
    </div>
</section>
    <?}
}?>
