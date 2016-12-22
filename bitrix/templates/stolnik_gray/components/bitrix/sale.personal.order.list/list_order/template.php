<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if(!empty($arResult['ERRORS']['FATAL'])):?>

	<?foreach($arResult['ERRORS']['FATAL'] as $error):?>
		<?=ShowError($error)?>
	<?endforeach?>

<?else:?>

	<?if(!empty($arResult['ERRORS']['NONFATAL'])):?>

		<?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
			<?=ShowError($error)?>
		<?endforeach?>

	<?endif?>

	<div class="bx_my_order_switch">

		<?$nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);?>

		<?if($nothing || isset($_REQUEST["filter_history"])):?>
			<a class="bx_mo_link" href="<?=$arResult["CURRENT_PAGE"]?>?show_all=Y"><?=GetMessage('SPOL_ORDERS_ALL')?></a>
		<?endif?>

		<?if($_REQUEST["filter_history"] == 'Y' || $_REQUEST["show_all"] == 'Y'):?>
			<a class="bx_mo_link" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=N"><?=GetMessage('SPOL_CUR_ORDERS')?></a>
		<?endif?>

		<?if($nothing || $_REQUEST["filter_history"] == 'N' || $_REQUEST["show_all"] == 'Y'):?>
			<a class="bx_mo_link" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=Y"><?=GetMessage('SPOL_ORDERS_HISTORY')?></a>
		<?endif?>

	</div>

	<?if(!empty($arResult['ORDERS'])):?>

		<?foreach($arResult["ORDER_BY_STATUS"] as $key => $group):?>

			<?foreach($group as $k => $order):?>

				<?if(!$k):?>

					<div class="bx_my_order_status_desc">

						<h2><?=GetMessage("SPOL_STATUS")?> "<?=$arResult["INFO"]["STATUS"][$key]["NAME"] ?>"</h2>
						<div class="bx_mos_desc"><?=$arResult["INFO"]["STATUS"][$key]["DESCRIPTION"] ?></div>

					</div>

				<?endif?>

				<div class="bx_my_order">
					
					<table class="bx_my_order_table">
						<thead>
							<tr>
								<td>
									<?=GetMessage('SPOL_ORDER')?> <?=GetMessage('SPOL_NUM_SIGN')?><?=$order["ORDER"]["ACCOUNT_NUMBER"]?>
									<?if(strlen($order["ORDER"]["DATE_INSERT_FORMATED"])):?>
										<?=GetMessage('SPOL_FROM')?> <?=$order["ORDER"]["DATE_INSERT_FORMATED"];?>
									<?endif?>
								</td>
								<td style="text-align: right;">
									<a href="<?=$order["ORDER"]["URL_TO_DETAIL"]?>"><?=GetMessage('SPOL_ORDER_DETAIL')?></a>
								</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<strong><?=GetMessage('SPOL_PAY_SUM')?>:</strong> <?=$order["ORDER"]["FORMATED_PRICE"]?> <br />

									<strong><?=GetMessage('SPOL_PAYED')?>:</strong> <?=GetMessage('SPOL_'.($order["ORDER"]["PAYED"] == "Y" ? 'YES' : 'NO'))?> <br />

									<? // PAY SYSTEM ?>
									<?if(intval($order["ORDER"]["PAY_SYSTEM_ID"])):?>
										<strong><?=GetMessage('SPOL_PAYSYSTEM')?>:</strong> <?=$arResult["INFO"]["PAY_SYSTEM"][$order["ORDER"]["PAY_SYSTEM_ID"]]["NAME"]?> <br />
									<?endif?>


									<? // DELIVERY SYSTEM ?>
									<?if($order['HAS_DELIVERY']):?>

										<strong><?=GetMessage('SPOL_DELIVERY')?>:</strong>

										<?if(intval($order["ORDER"]["DELIVERY_ID"])):?>
										
											<?=$arResult["INFO"]["DELIVERY"][$order["ORDER"]["DELIVERY_ID"]]["NAME"]?> <br />
										
										<?elseif(strpos($order["ORDER"]["DELIVERY_ID"], ":") !== false):?>
										
											<?$arId = explode(":", $order["ORDER"]["DELIVERY_ID"])?>
											<?=$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["NAME"]?> (<?=$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["PROFILES"][$arId[1]]["TITLE"]?>) <br />

										<?endif?>

									<?endif?>

									<strong><?=GetMessage('SPOL_BASKET')?>:</strong>
									<ul class="bx_item_list">

										<?foreach ($order["BASKET_ITEMS"] as $item):?>

											<li>
												<?if(strlen($item["DETAIL_PAGE_URL"])):?>
													<a href="<?=$item["DETAIL_PAGE_URL"]?>" target="_blank">
												<?endif?>
													<?=$item['NAME']?>
												<?if(strlen($item["DETAIL_PAGE_URL"])):?>
													</a> 
												<?endif?>
												<nobr>&nbsp;&mdash; <?=$item['QUANTITY']?> <?=(isset($item["MEASURE_NAME"]) ? $item["MEASURE_NAME"] : GetMessage('SPOL_SHT'))?></nobr>
											</li>

										<?endforeach?>

									</ul>

								</td>
								<td>
									<?=$order["ORDER"]["DATE_STATUS_FORMATED"];?>
									<div class="bx_my_order_status <?=$arResult["INFO"]["STATUS"][$key]['COLOR']?><?/*yellow*/ /*red*/ /*green*/ /*gray*/?>"><?=$arResult["INFO"]["STATUS"][$key]["NAME"]?></div>

									<?if ($order['ORDER']['STATUS_ID'] == 'O'):?>

										<?if ($order['ORDER']['PAY_SYSTEM_ID'] != ""):?>
											<a  style="min-width:140px" href="/personal/order/payment/?ORDER_ID=<?=$order["ORDER"]['ID']?>" class="bx_big bx_bt_button_type_2 bx_cart bx_order_action">
												Оплатить заказ
											</a>
											<br/>
										<?else:?>
											<?if ($order['ORDER']['PAY_SYSTEM_ID'] == 17):?>
											<style>
												.jsloadPaysystem_<?=$order["ORDER"]['ID']?>.paymentInfo *{
													display: none;
												}
												.jsloadPaysystem_<?=$order["ORDER"]['ID']?>.paymentInfo .b-container_bordered:before {
													display: none;
												}
												.jsloadPaysystem_<?=$order["ORDER"]['ID']?>.paymentInfo .b-wrapper,
												.jsloadPaysystem_<?=$order["ORDER"]['ID']?>.paymentInfo .b-wrapper .b-container,
												.jsloadPaysystem_<?=$order["ORDER"]['ID']?>.paymentInfo .onlinedengi-form-block,
												.jsloadPaysystem_<?=$order["ORDER"]['ID']?>.paymentInfo .onlinedengi-form-block *{
													display: block;
												}
												.jsloadPaysystem_<?=$order["ORDER"]['ID']?>.paymentInfo .onlinedengi-form-block table {
													display: table;
												}
												.jsloadPaysystem_<?=$order["ORDER"]['ID']?>.paymentInfo .onlinedengi-form-block tr {
													display: block;
													float: left;
												}
												.jsloadPaysystem_<?=$order["ORDER"]['ID']?>.paymentInfo .onlinedengi-form-block td {
													display: block;
													padding: 0 !important;
												}
												.jsloadPaysystem_<?=$order["ORDER"]['ID']?>.paymentInfo .onlinedengi-form-block td:first-child {
													width: auto !important;
												}
												.jsloadPaysystem_<?=$order["ORDER"]['ID']?>.paymentInfo .b-container {
													width: auto;
												}
												.jsloadPaysystem_<?=$order["ORDER"]['ID']?>.paymentInfo .onlinedengi-form-block input[type=radio] {
													display: none;
												}
												.jsloadPaysystem_<?=$order["ORDER"]['ID']?>.paymentInfo .onlinedengi-form-block input[type=radio]:checked ~ label{
													border: 1px solid #e9e9e9;
													box-shadow: 0 0 3px #e9e9e9;
												}
												.jsloadPaysystem_<?=$order["ORDER"]['ID']?>.paymentInfo .onlinedengi-form-block td label{
													padding: 5px;
													margin: 0 0 10px;
													border-radius: 3px;
													border: 1px solid #fff;
													cursor: pointer;
												}
												.jsloadPaysystem_<?=$order["ORDER"]['ID']?>.paymentInfo .inputsubmit {
													max-width: 168px;
													float: left;
													font-size: 13px;
													line-height: 13px !important;
													font-family: Helvetica, Arial, Verdana, sans-serif;
												}
												.jsloadPaysystem_<?=$order["ORDER"]['ID']?>.paymentInfo .onlinedengi-pay-table {
													margin: 20px 0;
												}
											</style>
											<?endif;?>
											<span class="paymentInfo jsloadPaysystem_<?=$order["ORDER"]['ID']?>"></span>
											<script>
												$('.jsloadPaysystem_<?=$order["ORDER"]['ID']?>').load('/personal/order/payment/?ORDER_ID=<?=$order["ORDER"]['ID']?>',function(){
													$('.jsloadPaysystem_<?=$order["ORDER"]['ID']?> input[type=submit]').addClass('bx_big bx_bt_button_type_2 bx_cart bx_order_action');
													$('.jsloadPaysystem_<?=$order["ORDER"]['ID']?> input[type=submit]').css('min-width', '140px');
													<?if ($order['ORDER']['PAY_SYSTEM_ID'] == 17):?>
													$('.jsloadPaysystem_<?=$order["ORDER"]['ID']?> .inputsubmit').val('пїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅ пїЅпїЅпїЅпїЅпїЅпїЅ');
													<?endif;?>
												});
											</script>
										<?endif;?>

									<?endif;?>
									<?/*if($order["ORDER"]["CANCELED"] != "Y"):?>
										<a href="<?=$order["ORDER"]["URL_TO_CANCEL"]?>" style="min-width:140px"class="bx_big bx_bt_button_type_2 bx_cart bx_order_action"><?=GetMessage('SPOL_CANCEL_ORDER')?></a>
									<?endif*/?>

									<a href="<?=$order["ORDER"]["URL_TO_COPY"]?>" style="min-width:140px"class="bx_big bx_bt_button_type_2 bx_cart bx_order_action"><?=GetMessage('SPOL_REPEAT_ORDER')?></a>
								</td>
							</tr>
						</tbody>
					</table>

				</div>

			<?endforeach?>

		<?endforeach?>

		<?if(strlen($arResult['NAV_STRING'])):?>
			<?=$arResult['NAV_STRING']?>
		<?endif?>

	<?else:?>
		<?=GetMessage('SPOL_NO_ORDERS')?>
	<?endif?>

<?endif?>