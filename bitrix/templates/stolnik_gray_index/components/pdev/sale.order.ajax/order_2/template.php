<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script type="text/javascript"  src="/bitrix/templates/stolnilk/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" xmlns="http://www.w3.org/1999/html" src="/bitrix/templates/stolnik_gray/js/jquery.form.js"></script>
<script type="text/javascript" src="/bitrix/templates/stolnik_gray/js/jquery.autocomplete.js"></script>

<script type="text/javascript" src="/bitrix/templates/stolnik_gray/js/jquery.fancybox.js"></script>
<!-- script type="text/javascript" src="/bitrix/templates/stolnilk/js/jquery.jcarousel.js"></script>
<script type="text/javascript" src="/bitrix/templates/stolnilk/js/jquery.simple-carousel.js"></script -->
<script type="text/javascript" src="/bitrix/templates/stolnik_gray/js/jquery.tipTip.minified.js"></script>
<script type="text/javascript" src="/bitrix/templates/stolnik_gray/js/j.js"></script>

<? if(0 > 1) { ?>
<script type="text/javascript">
	mswidget.ready(function(){
		mswidget.initCartWidget({})
	})
</script>
<? } ?>
<?
global $USER;
if($USER->isAdmin()){
	//sheepla::GetModuleRightList();

}
//pr_r($arResult);
//echo "<pre>",print_r($arResult,1),"</pre>";
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
var continue_flag;
/*
var msg = "���������� ��������� ��������� ���� �.�.�. �� ������� (������ ���� ��������).";

$(function(){
		fio = $('#ORDER_PROP_1');
		str = $.trim(fio.val());
			re = /(\s)/ig;
			found = str.match(re);
			if (found==null || found.length<2){
				continue_flag = false;
			}
			else{
				continue_flag = true;
			}

    	$('#order_form_div').on('change', '#ORDER_PROP_1', function(){
    		t = $(this);
    		str = $.trim(t.val());
				re = /(\s)/ig;
				found = str.match(re);
				if (found==null || found.length<2){
					alert(msg);
					t.css('border', "1px solid red");
					continue_flag = false;
				}
				else{
					continue_flag = true;
					t.css('border', "1px solid #999");
				}

    	});
    });
*/
function submitForm(val)
    {
    	if(continue_flag == false && val=='Y'){
    			alert(msg);
    			$('#ORDER_FORM_ID_NEW').submit(function(event){
    				event.preventDefault();
    			});
    		}
    	else{
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
	                if(!continue_flag){$('#ORDER_PROP_1').css('border', "1px solid black");}
	            }
	        };
	        $('#order_form_div').css('opacity', 0.5);

	        // �������� ����� �  ajaxSubmit
	        $("#ORDER_FORM_ID_NEW").ajaxSubmit(options);
	        return true;
        }
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
		if($arResult["ERROR"]['reg_error'])
		echo "<a href=\"/login/\">�������������</a>, ����� �������� �����, ��� ������� ���� e-mail.<br />";
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
			if($arResult["ERROR"]['reg_error'])
		echo "<a href=\"/login/\" style=\"color:red;\">�������������</a>, ����� �������� �����, ��� ������� ���� e-mail.<br /><br />";
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
					<div class="ordering_sections">
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
						<div class="ordering_section ordering_section_icos">
							<div class="ordering_section_ico"><img src="/bitrix/templates/stolnik_gray/images/basket/itsok.png"></div>
							<div class="ordering_section_ico"><p style="padding-top:5px;">�� ����������� ������������ �������.</p></div>
							<div class="ordering_section_ico"><img src="/bitrix/templates/stolnik_gray/images/basket/delivery.png"></div>
							<div class="ordering_section_ico"><p>�������� �� ������ ���������.</p></div>
							<div class="ordering_section_ico"><img src="/bitrix/templates/stolnik_gray/images/basket/hanger.png"></div>
							<div class="ordering_section_ico"><p style="padding-top:12px;">�������� ����� ��������</p></div>
						</div>
					</div>
					<? //echo $arResult["disc"];//global $USER; if ($USER->IsAdmin()) echo "<pre>"; print_r($arResult); echo "</pre>";
					?>
<? if(0 > 1) { ?>
					<p style="color:red;">��� ������ ������ �� ����� ����� 1000 ��� �������� �� ������ ���������. </p>
<? } ?>


	<?if(!$arResult["disc"]):?>
	<?endif?>

					<div class="ordering_sections">
						<?
						include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
						?>
						<?
						include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
						?>
					</div>
					<?
					include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");
					?>
					<input type="hidden" name="confirmorder" id="confirmorder" value="Y">
					<input type="hidden" name="profile_change" id="profile_change" value="N">
					<div class="ordering_options">
<? if(0 > 1) { // �������� ��������� ��������... �� ��� ���� � "�� �� ������" ?>
						<?if($arResult["DELIVERY_PRICE"]>0):?><dl class="summ"><dt>��������:</dt><dd><span class="val"><?=substr($arResult["DELIVERY_PRICE_FORMATED"],0,strlen($arResult["DELIVERY_PRICE_FORMATED"])-4)?></span> ���.</dd></dl><br /><?endif;?>
<? } ?>
						<?
							$discount=0;
							foreach($arResult['BASKET_ITEMS'] as $bask){
								$discount+=$bask['QUANTITY']*$bask['DISCOUNT_PRICE'];
							}
						?>
						<?/*if($discount > 0){?>
							<?//echo "<pre>";print_r($arResult);echo "</pre>";?>
							<?echo "<p class='disc_val'>������: ".$arResult["BASKET_ITEMS"][0]['DISCOUNT_PRICE_PERCENT_FORMATED']."  (".$discount." ���.)</p>";?>
							$arResult["ORDER_TOTAL_PRICE_FORMATED"]
						<?}*/?>

						<dl class="summ"><dt>�����:</dt><dd><span class="val"><?=substr($arResult["ORDER_PRICE_FORMATED"],0,strlen($arResult["ORDER_PRICE_FORMATED"])-4)?></span> ���.</dd></dl>

						<input id="but_of_zak" style="color: #F55;" class="button button_1 submit" type="button" name="submitbutton"  onclick="submitForm('Y')" value="�������� �����">
						<dl style="float:right;margin: 0px 20px 0 0px;"><!--input type="checkbox" id="yes_dogowor" onchange="if($(this).attr('checked')=='checked') { $('#but_of_zak').removeAttr('disabled'); $('#but_of_zak').css('color','#FFF')}else{$('#but_of_zak').attr('disabled','disabled'); $('#but_of_zak').css('color','#F55')}"--> ������� �� ������ "�������� �����", �� ���������� ������� <a href="/articles/publichnaya-ofera/">��������� ������</a></dl>
					</div>


					<?//echo "<p class='disc_info'>��� ������ ������ �� ����� ����� 10000 ��� ��������������� ������ � ������� 5% �� ����� ����� ������.</p>";?>
					<?//echo "<p class='disc_info2'>��� ������ ������ �� ����� ����� 1000 ��� �������� �� ������ ���������. �� ���������� ���������� �������� ��� ������ �� ����� ����� 500 ���.</p>";?>


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
