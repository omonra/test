<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script type="text/javascript" xmlns="http://www.w3.org/1999/html" src="/bitrix/templates/stolnilk/js/jquery.form.js"></script>
<script type="text/javascript" src="/bitrix/templates/stolnilk/js/jquery.autocomplete.js"></script>
<?
global $USER;
//if($USER->isAdmin())echo "<pre>",print_r($arResult,1),"</pre>";
//print_r($_REQUEST);exit();
if ( $_REQUEST['AJAX_CALL'] != 'Y' )
{

    ?>

<script>
    <!--
   /*function submitForm(val)
    {
        if(val != 'Y')
            document.getElementById('confirmorder').value = 'N';

        var orderForm = document.getElementById('ORDER_FORM_ID_NEW');

        jsAjaxUtil.InsertFormDataToNode(orderForm, 'order_form_div', true);
        orderForm.submit();

        return true;
    }*/

    function submitForm(val)
    {
        if(val != 'Y')
            document.getElementById('confirmorder').value = 'N';

        $('#AJAX_CALL').val('Y');
        $('#AJAX_CALL_UTF').val('Y');

        var options = {
            target: "#order_form_div",
            url: "/personal/order/make/index.php",
            success: function(data, textStatus, jqXHR) {
                console.log(data)
                $('#order_form_div').html(data);
                $('#order_form_div').css('opacity', 1);
                $('input:checkbox, input:radio').c_check();
                $('.c_radio').click(function(){submitForm();});
            }
        };
        $('#order_form_div').css('opacity', 0.5);

        // �������� ����� �  ajaxSubmit
        $("#ORDER_FORM_ID_NEW").ajaxSubmit(options);
        return true;
    }
    //-->
</script>
<a name="order_form"></a>
<div id="order_form_div">
<?
}
?>
    <NOSCRIPT>
        <div class="errortext"><?=GetMessage("SOA_NO_JS")?></div>
    </NOSCRIPT>
<?
if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
{
    if(!empty($arResult["ERROR"]))
    {
        foreach($arResult["ERROR"] as $v)
            echo ShowError($v);
    }
    elseif(!empty($arResult["OK_MESSAGE"]))
    {
        foreach($arResult["OK_MESSAGE"] as $v)
            echo "<p class='sof-ok'>".$v."</p>";
    }
    echo "<br />";
    include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
}
else
{
    if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y")
    {
        if(strlen($arResult["REDIRECT_URL"]) > 0)
        {
            ?>
            <script>
                <!--
                //top.location.replace = '<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
                window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
                //setInterval("window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';",2000);
                //-->
            </script>
            <?
            die();
        }
        else
            include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");
    }
    else
    {
        $FORM_NAME = 'ORDERFORM_'.RandString(5);
        if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y")
        {
            foreach($arResult["ERROR"] as $v)
                echo ShowError($v);
            ?>
            <script>
                top.location.hash = '#order_form';
            </script>
            <?
        }
        ?>

        <script>
            <!--
            function SetContact(profileId)
            {
                document.getElementById("profile_change").value = "Y";
                submitForm();
            }
            //-->
        </script>
        <form id="ORDER_FORM_ID_NEW" name="<?=$FORM_NAME?>" method='post' action=''>
            <input type="hidden" id="AJAX_CALL" name="AJAX_CALL" value=''>
            <input type="hidden" id="AJAX_CALL_UTF" name="AJAX_CALL_UTF" value=''>


            <div class="orders_block">
                <h1>���������� ������</h1>

                <div id="order_form_id">
                    &nbsp;
                    <?
                    if(count($arResult["PERSON_TYPE"]) > 1)
                    {
                        ?>

                        <b><?=GetMessage("SOA_TEMPL_PERSON_TYPE")?></b>
                        <table class="sale_order_full_table">
                            <tr>
                                <td>
                                    <?
                                    foreach($arResult["PERSON_TYPE"] as $v)
                                    {
                                        ?><input type="radio" id="PERSON_TYPE_<?= $v["ID"] ?>" name="PERSON_TYPE" value="<?= $v["ID"] ?>"<?if ($v["CHECKED"]=="Y") echo " checked=\"checked\"";?> onClick="submitForm()"> <label for="PERSON_TYPE_<?= $v["ID"] ?>"><?= $v["NAME"] ?></label><br /><?
                                    }
                                    ?>
                                    <input type="hidden" name="PERSON_TYPE_OLD" value="<?=$arResult["USER_VALS"]["PERSON_TYPE_ID"]?>">
                                </td></tr></table>
                        <br /><br />
                        <?
                    }
                    else
                    {
                        if(IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"]) > 0)
                        {
                            ?>
                            <input type="hidden" name="PERSON_TYPE" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>">
                            <input type="hidden" name="PERSON_TYPE_OLD" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>">
                            <?
                        }
                        else
                        {
                            foreach($arResult["PERSON_TYPE"] as $v)
                            {
                                ?>
                                <input type="hidden" id="PERSON_TYPE" name="PERSON_TYPE" value="<?=$v["ID"]?>">11
                                <input type="hidden" name="PERSON_TYPE_OLD" value="<?=$v["ID"]?>">
                                <?
                            }
                        }
                    }

                    include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");
                    ?>
 <p style="color:red;">��� ������ ������ �� ����� ����� 5000 ��� �������� �� ������ ���������. </p>
    <p style="color:red;">��� ������ ������ ����������� �������� ������ 5%. </p><br />
                    <?
                    include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
                    ?>
                    <?
                    include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
                    ?>
                    <br /><br />
                    <?
                    include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");
                    ?>
                    <input type="hidden" name="confirmorder" id="confirmorder" value="Y">
                    <input type="hidden" name="profile_change" id="profile_change" value="N">
                    <div class="ordering_options">
                        <?if($arResult["DELIVERY_PRICE"]>0):?><dl class="summ" style="margin: -14px 0 -12px 0px;"><dt>��������:</dt><dd><span class="val"><?=substr($arResult["DELIVERY_PRICE_FORMATED"],0,strlen($arResult["DELIVERY_PRICE_FORMATED"])-4)?></span> ���.</dd></dl><br /><?endif;?>
						<?
							$discount=0;
							foreach($arResult['BASKET_ITEMS'] as $bask){
								$discount+=$bask['QUANTITY']*$bask['DISCOUNT_PRICE'];
							}
						?>
                        <?/*if($discount > 0){?>
                            <?//echo "<pre>";print_r($arResult);echo "</pre>";?>
                            <?echo "<p class='disc_val'>������: ".$arResult["BASKET_ITEMS"][0]['DISCOUNT_PRICE_PERCENT_FORMATED']."  (".$discount." ���.)</p>";?>
                        <?}*/?>

                        <dl class="summ"><dt>�����:</dt><dd><span class="val"><?=substr($arResult["ORDER_TOTAL_PRICE_FORMATED"],0,strlen($arResult["ORDER_TOTAL_PRICE_FORMATED"])-4)?></span> ���.</dd></dl>
                        <input disabled="disabled" id="but_of_zak" style="color: #F55;" class="button button_1 submit" type="button" name="submitbutton" onClick="submitForm('Y');" value="�������� �����">
                        <dl style="float:right;margin: -20px 0 0 0px;"><input type="checkbox" id="yes_dogowor" onchange="if($(this).attr('checked')=='checked') { $('#but_of_zak').removeAttr('disabled'); $('#but_of_zak').css('color','#FFF')}else{$('#but_of_zak').attr('disabled','disabled'); $('#but_of_zak').css('color','#F55')}"> �������� � ��������� <a href="/articles/publichnaya-ofera/">��������� ������</a></dl>
                    </div>


					<?//echo "<p class='disc_info'>��� ������ ������ �� ����� ����� 5000 ��� ��������������� ������ � ������� 5% �� ����� ����� ������.</p>";?>
					<?//echo "<p class='disc_info2'>��� ������ ������ �� ����� ����� 3000 ��� �������� �� ������ ���������. �� ���������� ���������� �������� ��� ������ �� ����� ����� 500 ���.</p>";?>

                    

                </div>
            </div>
        </form>

        <div id="form_new"></div>

        <?
    }
}
?>
<?if ( $_REQUEST['AJAX_CALL'] != 'Y' ):?>
</div>
<?endif;?>