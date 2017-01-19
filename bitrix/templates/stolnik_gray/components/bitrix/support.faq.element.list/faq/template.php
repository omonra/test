<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//elements list?>
<a name="top"></a>
<div class="faq_list">
	<div class="faq_list_item faq_order">
		<h3>Заказ</h3>
		<ul>
			<li><a href="#">Изменить заказ</a></li>
			<li><a href="#">Анулировать заказ</a></li>
			<li><a href="#">Таблиица размеров и уход</a></li>
		</ul>
	</div>
	<div class="faq_list_item faq_card">
		<h3>Оплата</h3>
		<ul>
			<li><a href="#">Типы оплаты</a></li>
			<li><a href="#">Скидка</a></li>
			<li><a href="#">Когда произойдет списание денежных средств</a></li>
		</ul>
	</div>
	<div class="faq_list_item faq_delivery">
		<h3>Доставка</h3>
		<ul>
			<li><a href="#">Стандартная доставка</a></li>
			<li><a href="#">Экспресс доставка</a></li>
			<li><a href="#">Где мой заказ?</a></li>
		</ul>
	</div>
	<div class="faq_list_item faq_return">
		<h3>Возвраты</h3>
		<ul>
			<li><a href="#">Вы получили мой заказ?</a></li>
			<li><a href="#">Как я могу произвести возврат</a></li>
			<li><a href="#">Наши правила возврата</a></li>
		</ul>
	</div>
</div>
<?/*
<ul>
	<?foreach ($arResult['ITEMS'] as $key=>$val):?>
		<li class="point-faq"><a href="#<?=$val["ID"]?>"><?=$val['NAME']?></a><br/></li>
	<?endforeach;?>
</ul>
*/?>
<div class="faq_container">
	<?foreach ($arResult['ITEMS'] as $key=>$val):?>
	<?
		$this->AddEditAction($val['ID'],$val['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($val['ID'],$val['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BSFE_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="faq_item" id="<?=$val["ID"]?><?/*=$this->GetEditAreaId($val['ID']);*/?>">
	<a name="<?=$val["ID"]?>"></a>
	<h3><?=$val['NAME']?></h3>
		<div id="preview_<?=$val["ID"]?>"><?=$val['PREVIEW_TEXT']?></div>
		<div id="detail_<?=$val["ID"]?>" style="display:none;"><?=$val['DETAIL_TEXT']?></div>
		<?/*<div style="float: left"><a href="#top"><?=GetMessage("SUPPORT_FAQ_GO_UP")?></a></div>*/?>
		<?if ($arParams["SHOW_RATING"] == "Y"):?>
			<div class="faq-rating" style="float: right">
			<?
			$GLOBALS["APPLICATION"]->IncludeComponent(
				"bitrix:rating.vote", $arParams["RATING_TYPE"],
				Array(
					"ENTITY_TYPE_ID" => "IBLOCK_ELEMENT",
					"ENTITY_ID" => $val['ID'],
					"OWNER_ID" => $val['CREATED_BY'],
					"USER_VOTE" => $arResult['RATING'][$val['ID']]["USER_VOTE"],
					"USER_HAS_VOTED" => $arResult['RATING'][$val['ID']]["USER_HAS_VOTED"],
					"TOTAL_VOTES" => $arResult['RATING'][$val['ID']]["TOTAL_VOTES"],
					"TOTAL_POSITIVE_VOTES" => $arResult['RATING'][$val['ID']]["TOTAL_POSITIVE_VOTES"],
					"TOTAL_NEGATIVE_VOTES" => $arResult['RATING'][$val['ID']]["TOTAL_NEGATIVE_VOTES"],
					"TOTAL_VALUE" => $arResult['RATING'][$val['ID']]["TOTAL_VALUE"],
					"PATH_TO_USER_PROFILE" => $arParams["PATH_TO_USER"],
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);?>
			</div>
		<?endif;?>
	</div>
	<?endforeach;?>
</div>
<script>
	$(document).ready(function() {
		$(".faq_item").click(function() {
			var ggg=$(this).attr('id');
			console.log(ggg);
			$('[id ^= detail_]').hide();
			$(this).children('#detail_'+ggg).show();
			
		});
	});
</script>
