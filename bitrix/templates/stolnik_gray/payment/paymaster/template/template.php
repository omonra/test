<?
use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_after.php");
Loc::loadMessages(__FILE__);

?>
<?if(CSite::InDir('/personal/order/make/')){?>
    <?
    $arOrder = CSaleOrder::GetByID($_REQUEST['ORDER_ID']);
    ?>
    <div id="order_form_content">

        <noscript>
            &lt;div class="errortext"&gt;��� ���������� ������ ���������� �������� JavaScript. ��-��������, JavaScript ���� �� �������������� ���������, ���� ��������. �������� ��������� �������� � ����� &lt;a href=""&gt;��������� �������&lt;/a&gt;.&lt;/div&gt;
        </noscript>

        <h1 class="b-page-title">�������</h1>
        <b>����� �����������</b><br><br>
        <table class="sale_order_full_table">
            <tbody>
            <tr>
                <td>
                    ��� ����� <b>�<?=$arOrder['ID']?></b> �� <?=$DB->FormatDate($arOrder['DATE_INSERT'], 'YYYY-MM-DD HH:MI:SS', 'DD.MM.YYYY HH:MI:SS');?> ������� ������.<br><br>
                    �� ������ ������� �� ����������� ������ ������ � <a href="/personal/order/">������������ ������� �����</a>. �������� ��������, ��� ��� ����� � ���� ������ ��� ���������� ����� ������ ����� � ������ ������������ �����.			</td>
            </tr>
            </tbody></table>
        <!-- END content -->
    </div>
    <style>
        #order_form_div {
            display: none;
        }
    </style>
<?}else{?>
    <h4>������ �� ������ �������������� �� ��������� ������ Paymaster.</h4>
    <p>���� ����� �� ��������� ���������� ������� ������ "��������".</p>
    <form id="pay" name="pay" method="POST" action="<?=$params['URL']?>">
        <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="<?=$params["PAYMENT_SHOULD_PAY"];?>">
        <input type="hidden" name="LMI_CURRENCY" value="<?=$params['PAYMENT_CURRENCY']?>">
        <input type="hidden" name="LMI_PAYMENT_DESC" value="<?=str_replace(array('#PAYMENT_ID#', '#DATE_INSERT#'), array($params['PAYMENT_ID'], $params['PAYMENT_DATE_INSERT']), Loc::getMessage('SALE_HPS_PAYMASTER_TEMPLATE_DESC_PAYMENT'))?>">
        <input type="hidden" name="LMI_PAYMENT_NO" value="<?= $params["PAYMENT_ID"] ?>">
        <input type="hidden" name="LMI_MERCHANT_ID" value="<?= htmlspecialcharsbx($params["PAYMASTER_SHOP_ACCT"]) ?>">
        <?if ($params["PS_IS_TEST"] == 'Y'): ?>
            <input type="hidden" name="LMI_SIM_MODE" value="0">
        <?endif;?>
        <input type="hidden" name="LMI_RESULT_URL" value="<?=$params["PAYMASTER_RESULT_URL"]?>">
        <input type="hidden" name="LMI_SUCCESS_URL" value="<?=$params["PAYMASTER_SUCCESS_URL"]?>">
        <input type="hidden" name="LMI_FAIL_URL" value="<?=$params["PAYMASTER_FAIL_URL"]?>">
        <input type="hidden" name="LMI_PAYER_EMAIL" value="<?=$params["BUYER_PERSON_EMAIL"]?>">
        <input type="hidden" name="LMI_PAYER_PHONE_NUMBER" value="<?=$params["BUYER_PERSON_PHONE"]?>">
        <input type="hidden" name="LMI_SUCCESS_METHOD" value="1">
        <input type="hidden" name="LMI_FAIL_METHOD" value="1">
        <input type="hidden" name="BX_HANDLER" value="PAYMASTER">
        <input type="hidden" name="BX_PAYSYSTEM_CODE" value="<?=$params['BX_PAYSYSTEM_CODE'];?>">
        <input type="submit" class="inputsubmit button button_1" value="<?=Loc::getMessage('SALE_HPS_PAYMASTER_TEMPLATE_BUTTON_PAID');?>" style="    float: left; margin: 0 0 20px;">
    </form>
    <script>
        //$('#pay').submit();
    </script>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_before.php");?>