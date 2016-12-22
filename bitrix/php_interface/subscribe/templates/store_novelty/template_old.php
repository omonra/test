<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $SUBSCRIBE_TEMPLATE_RUBRIC;
$SUBSCRIBE_TEMPLATE_RUBRIC=$arRubric;
global $APPLICATION;
define('DOMAIN', 'http://stolnik24.ru');
define('TIME_WEEKLY', ConvertTimeStamp(time()-(86400*14), "FULL"));
define('IBLOCK_ID', 4);
?>
<div style="width: 1000px; overflow: hidden;">
	<div style="text-align: center;">
		<img src="<?= DOMAIN ?>/images/subscribe/header.png" />
	</div>
	<div style="text-align: center;">
		<div  style="width: 700px; background-image: url('data:image/jpg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQAB…prEKuHXvDbW62dblZWNSt2aOXAZ+3aP3SD5W0espwDc3uftuWvtnn3UBwFv8A42fjHx3Af//Z'); background-position: center left; background-repeat: no-repeat; display: inline-block; vertical-align: top; margin: 20px 0 0; position: relative;">
			<div  style="display: inline-block;">
				<a href="<?= DOMAIN ?>/catalog/news_zhenskaya_odezhda/?utm_source=newsletter&utm_medium=email&utm_campaign=novinki20-01-16" style=" display: inline-block; margin: 0 0 0 10px; font-size: 12px; font-weight: bold; color: #353535; text-decoration: none; text-transform: uppercase; border-bottom: 1px solid #fff; line-height: 16px;"  title="Женская одежда">Женская одежда</a>
			</div>
			<div  style="display: inline-block;">
				<a href="<?= DOMAIN ?>/catalog/news_zhenskaya_obuv/?utm_source=newsletter&utm_medium=email&utm_campaign=novinki20-01-16" style=" display: inline-block; margin: 0 0 0 10px; font-size: 12px; font-weight: bold; color: #353535; text-decoration: none; text-transform: uppercase; border-bottom: 1px solid #fff; line-height: 16px;"  title="Женская обувь">Женская обувь</a>
			</div>
			<div  style="display: inline-block;">
				<a href="<?= DOMAIN ?>/catalog/news_muzhskaya_odezhda/?utm_source=newsletter&utm_medium=email&utm_campaign=novinki20-01-16" style=" display: inline-block; margin: 0 0 0 10px; font-size: 12px; font-weight: bold; color: #353535; text-decoration: none; text-transform: uppercase; border-bottom: 1px solid #fff; line-height: 16px;"  title="Мужская одежда">Мужская одежда</a>
			</div>
			<div  style="display: inline-block;">
				<a href="<?= DOMAIN ?>/catalog/news_muzhskaya_obuv_1/?utm_source=newsletter&utm_medium=email&utm_campaign=novinki20-01-16" style=" display: inline-block; margin: 0 0 0 10px; font-size: 12px; font-weight: bold; color: #353535; text-decoration: none; text-transform: uppercase; border-bottom: 1px solid #fff; line-height: 16px;"  title="Мужская обувь">Мужская обувь</a>
			</div>
			<div  style="display: inline-block;">
				<a href="<?= DOMAIN ?>/catalog/news_aksessuary/?utm_source=newsletter&utm_medium=email&utm_campaign=novinki20-01-16" style=" display: inline-block; margin: 0 0 0 10px; font-size: 12px; font-weight: bold; color: #353535; text-decoration: none; text-transform: uppercase; border-bottom: 1px solid #fff; line-height: 16px;"  title="Аксессуары">Аксессуары</a>
			</div>
		</div>
		<img src="<?= DOMAIN ?>/images/subscribe/top_line.png" />

		<br/>

		<div style="margin-top: 30px; font-family: Arial; color: #ff4200; text-transform: uppercase; font-size: 30px;" >Новинки этой недели</div>

		<?
		#	<span style="background-image: url('data:image/png;base64,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'); width: 60px; height: 60px; display: block; position: absolute; z-index: 9; top: 18px; right: 10px;"></span>
		?>
		<?
		$girls_dress = array();
		$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_PAGE_URL", "PROPERTY_51", "DETAIL_PICTURE");
		$arFilter = Array("IBLOCK_ID"=>IntVal(IBLOCK_ID),
			"ACTIVE_DATE"=>"Y",
			"ACTIVE"=>"Y",
			"PROPERTY_NOVINKA" => "true",
			"SUBSECTION" => 314,
			//">=DATE_CREATE" => TIME_WEEKLY
		);
		$res = CIBlockElement::GetList(Array("ID" => "DESC"), $arFilter, false, Array("nPageSize"=>8), $arSelect);
		while($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			$file = CFile::ResizeImageGet($arFields['DETAIL_PICTURE'], array('width'=>220, 'height'=>276), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			$girls_dress[] = array(
				"NAME" => $arFields['NAME'],
				"DETAIL_PAGE_URL" => $arFields['DETAIL_PAGE_URL'],
				"PICTURE" => $file['src'],
				"PRICE" => $arFields['PROPERTY_51_VALUE'],
			);
		}
		?>
		<? if (count($girls_dress) > 0):?>
			<a href="http://stolnik24.ru/catalog/news_zhenskaya_odezhda/?utm_source=newsletter&utm_medium=email&utm_campaign=novinki20-01-16" style="display: block; font-family: Tahoma; font-size: 18px; line-height: 30px; color: #230808; text-transform: uppercase; margin-top: 30px; text-decoration: underline;">Женская одежда</a>

			<table style="margin: auto; width: 750px;" cellpadding="0" cellspacing="0">
				<tr>
					<?
					$column = 1;
					foreach($girls_dress as $arItem):?>
						<td  style="text-align: left; width: 190px; padding: 0px; vertical-align: top;">
							<a href="<?= DOMAIN ?><?=$arItem["DETAIL_PAGE_URL"]?>"
							   style="background: url('<?= DOMAIN ?>/<?=$arItem['PICTURE']?>') center center; margin-bottom: 10px; height: 276px; width: 190px; display: block;"
							   title="<?=$arItem["NAME"]?>">
							</a>
							<a style="color: #555; height: 37px; font-size: 13px; padding: 0 16px 6px 10px; margin: 0 0 0px; display: block;"
							   href="<?= DOMAIN ?><?=$arItem["DETAIL_PAGE_URL"]?>"
							   title="<?=$arItem["NAME"]?>">
								<?=$arItem["NAME"]?>
							</a>
							<div>
								<?if($arItem['PRICE'] > 0):?>
									<strong style="font-weight: bold; color: #353535; padding-left: 10px;"><?= $arItem['PRICE'] . ' руб'?></strong>
								<?endif;?>
							</div>
						</td>
						<?
						$column++;
						if ($column%5 == 0){ echo "</tr><tr>";}
						?>
					<?endforeach;?>
				</tr>
			</table>
		<?endif;?>

		<?
		$mens_dress = array();
		$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_PAGE_URL", "PROPERTY_51", "DETAIL_PICTURE");
		$arFilter = Array("IBLOCK_ID"=>IntVal(IBLOCK_ID),
			"ACTIVE_DATE"=>"Y",
			"ACTIVE"=>"Y",
			"PROPERTY_NOVINKA" => "true",
			"SUBSECTION" => 284,
			//">=DATE_CREATE" => TIME_WEEKLY
		);
		$res = CIBlockElement::GetList(Array("ID" => "DESC"), $arFilter, false, Array("nPageSize"=>8), $arSelect);
		while($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			$file = CFile::ResizeImageGet($arFields['DETAIL_PICTURE'], array('width'=>220, 'height'=>276), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			$mens_dress[] = array(
				"NAME" => $arFields['NAME'],
				"DETAIL_PAGE_URL" => $arFields['DETAIL_PAGE_URL'],
				"PICTURE" => $file['src'],
				"PRICE" => $arFields['PROPERTY_51_VALUE'],
			);
		}
		?>
		<? if (count($mens_dress) > 0):?>
			<a href="http://stolnik24.ru/catalog/news_muzhskaya_odezhda/?utm_source=newsletter&utm_medium=email&utm_campaign=novinki20-01-16" style="display: block; font-family: Tahoma; font-size: 18px; line-height: 30px; color: #230808; text-transform: uppercase; margin-top: 30px; text-decoration: underline;">Мужская одежда</a>

			<table style="margin: auto; width: 750px;">
				<tr>
					<?
					$column = 1;
					foreach($mens_dress as $arItem):?>
						<td  style="text-align: left; width: 190px;  padding: 0px; vertical-align: top;">
							<a href="<?= DOMAIN ?><?=$arItem["DETAIL_PAGE_URL"]?>"
							   style="background: url('<?= DOMAIN ?>/<?=$arItem['PICTURE']?>') center center; margin-bottom: 10px; height: 276px; width: 190px; display: block;"
							   title="<?=$arItem["NAME"]?>">
							</a>
							<a style="color: #555; height: 37px; font-size: 13px; padding: 0 16px 6px 10px; margin: 0 0 0px; display: block;"
							   href="<?= DOMAIN ?><?=$arItem["DETAIL_PAGE_URL"]?>"
							   title="<?=$arItem["NAME"]?>">
								<?=$arItem["NAME"]?>
							</a>
							<div>
								<?if($arItem['PRICE'] > 0):?>
									<strong style="font-weight: bold; color: #353535; padding-left: 10px;"><?= $arItem['PRICE'] . ' руб'?></strong>
								<?endif;?>
							</div>
						</td>
						<?
						$column++;
						if ($column%5 == 0){ echo "</tr><tr>";}
						?>
					<?endforeach;?>
				</tr>
			</table>
		<?endif;?>


		<?
		$girls_shoes = array();
		$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_PAGE_URL", "PROPERTY_51", "DETAIL_PICTURE");
		$arFilter = Array("IBLOCK_ID"=>IntVal(IBLOCK_ID),
			"ACTIVE_DATE"=>"Y",
			"ACTIVE"=>"Y",
			"PROPERTY_NOVINKA" => "true",
			"SUBSECTION" => 716,
			//">=DATE_CREATE" => TIME_WEEKLY
		);
		$res = CIBlockElement::GetList(Array("ID" => "DESC"), $arFilter, false, Array("nPageSize"=>4), $arSelect);
		while($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			$file = CFile::ResizeImageGet($arFields['DETAIL_PICTURE'], array('width'=>220, 'height'=>276), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			$girls_shoes[] = array(
				"NAME" => $arFields['NAME'],
				"DETAIL_PAGE_URL" => $arFields['DETAIL_PAGE_URL'],
				"PICTURE" => $file['src'],
				"PRICE" => $arFields['PROPERTY_51_VALUE'],
			);
		}
		?>
		<? if (count($girls_shoes) > 0):?>
			<a href="http://stolnik24.ru/catalog/news_zhenskaya_obuv/?utm_source=newsletter&utm_medium=email&utm_campaign=novinki20-01-16" style=" display: block; font-family: Tahoma; font-size: 18px; line-height: 30px; color: #230808; text-transform: uppercase; margin-top: 30px; text-decoration: underline;">Женская обувь</a>

			<table style="margin: auto; width: 750px;">
				<tr>
					<?
					$column = 1;
					foreach($girls_shoes as $arItem):?>
						<td  style="text-align: left; width: 190px;  padding: 0px; vertical-align: top;">
							<a href="<?= DOMAIN ?><?=$arItem["DETAIL_PAGE_URL"]?>"
							   style="background: url('<?= DOMAIN ?>/<?=$arItem['PICTURE']?>') center center; margin-bottom: 10px; height: 276px; width: 190px; display: block;"
							   title="<?=$arItem["NAME"]?>">
							</a>
							<a style="color: #555; height: 37px; font-size: 13px; padding: 0 16px 6px 10px; margin: 0 0 0px; display: block;"
							   href="<?= DOMAIN ?><?=$arItem["DETAIL_PAGE_URL"]?>"
							   title="<?=$arItem["NAME"]?>">
								<?=$arItem["NAME"]?>
							</a>
							<div>
								<?if($arItem['PRICE'] > 0):?>
									<strong style="font-weight: bold; color: #353535; padding-left: 10px;"><?= $arItem['PRICE'] . ' руб'?></strong>
								<?endif;?>
							</div>
						</td>
						<?
						$column++;
						if ($column%5 == 0){ echo "</tr><tr>";}
						?>
					<?endforeach;?>
				</tr>
			</table>
		<?endif;?>

		<?
		$mens_shoes = array();
		$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_PAGE_URL", "PROPERTY_51", "DETAIL_PICTURE");
		$arFilter = Array("IBLOCK_ID"=>IntVal(IBLOCK_ID),
			"ACTIVE_DATE"=>"Y",
			"ACTIVE"=>"Y",
			"PROPERTY_NOVINKA" => "true",
			"SUBSECTION" => 722,
			">=DATE_CREATE" => TIME_WEEKLY
		);
		$res = CIBlockElement::GetList(Array("ID" => "DESC"), $arFilter, false, Array("nPageSize"=>4), $arSelect);
		while($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			$file = CFile::ResizeImageGet($arFields['DETAIL_PICTURE'], array('width'=>220, 'height'=>276), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			$mens_shoes[] = array(
				"NAME" => $arFields['NAME'],
				"DETAIL_PAGE_URL" => $arFields['DETAIL_PAGE_URL'],
				"PICTURE" => $file['src'],
				"PRICE" => $arFields['PROPERTY_51_VALUE'],
			);
		}
		?>
		<? if (count($mens_shoes) > 0):?>
			<a href="http://stolnik24.ru/catalog/news_muzhskaya_obuv_1/?utm_source=newsletter&utm_medium=email&utm_campaign=novinki20-01-16" style="display: block; font-family: Tahoma; font-size: 18px; line-height: 30px; color: #230808; text-transform: uppercase; margin-top: 30px; text-decoration: underline;">Мужская обувь</a>

			<table style="margin: auto; width: 750px;">
				<tr>
					<?
					$column = 1;
					foreach($mens_shoes as $arItem):?>
						<td  style="text-align: left; width: 190px;  padding: 0px; vertical-align: top;">
							<a href="<?= DOMAIN ?><?=$arItem["DETAIL_PAGE_URL"]?>"
							   style="background: url('<?= DOMAIN ?>/<?=$arItem['PICTURE']?>') center center; margin-bottom: 10px; height: 276px; width: 190px; display: block;"
							   title="<?=$arItem["NAME"]?>">
							</a>
							<a style="color: #555; height: 37px; font-size: 13px; padding: 0 16px 6px 10px; margin: 0 0 0px; display: block;"
							   href="<?= DOMAIN ?><?=$arItem["DETAIL_PAGE_URL"]?>"
							   title="<?=$arItem["NAME"]?>">
								<?=$arItem["NAME"]?>
							</a>
							<div>
								<?if($arItem['PRICE'] > 0):?>
									<strong style="font-weight: bold; color: #353535; padding-left: 10px;"><?= $arItem['PRICE'] . ' руб'?></strong>
								<?endif;?>
							</div>
						</td>
						<?
						$column++;
						if ($column%5 == 0){ echo "</tr><tr>";}
						?>
					<?endforeach;?>
				</tr>
			</table>
		<?endif;?>
	1
		<div style="text-align: left;">
			<div style="background: #73716c; padding: 30px 0 25px; width: 100%; min-width: 980px;">
				<div style="width: 940px; margin: 0 auto; overflow: hidden; text-align: left;">
					<div style="width: 150px; display: inline-block; vertical-align: top; font-family: Helvetica, Arial,Verdana, sans-serif; font-size: 13px;" >
						<div style="font-size: 16px; font-weight: bold; margin: 0 0 15px; color: #fff;" >Информация</div>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; display: block; line-height: 20px; text-decoration: none;" href="<?= DOMAIN ?>/articles/publichnaya-ofera/" title="Публичная оферта">Публичная оферта</a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; display: block; line-height: 20px; text-decoration: none;" href="<?= DOMAIN ?>/articles/dostavka/" title="Доставка">Доставка</a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; display: block; line-height: 20px; text-decoration: none;" href="<?= DOMAIN ?>/articles/garantiya/" title="Гарантия">Гарантия</a>
					</div>
					<div style="width: 150px; display: inline-block; vertical-align: top; font-family: Helvetica, Arial,Verdana, sans-serif; font-size: 13px;"  >
						<div style="font-size: 16px; font-weight: bold; margin: 0 0 15px; "  >&nbsp;</div>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; display: block; line-height: 20px; text-decoration: none;" href="<?= DOMAIN ?>/articles/oplata/" title="Оплата">Оплата</a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; display: block; line-height: 20px; text-decoration: none;" href="<?= DOMAIN ?>/articles/help/" title="Помощь">Помощь</a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; display: block; line-height: 20px; text-decoration: none;" href="<?= DOMAIN ?>/faq/" title="Частые вопросы">Частые вопросы</a>
					</div>
					<div style="width: 160px; display: inline-block; vertical-align: top; font-family: Helvetica, Arial,Verdana, sans-serif; font-size: 13px;"  >
						<div style="font-size: 16px; font-weight: bold; margin: 0 0 15px; "  >&nbsp;</div>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; display: block; line-height: 20px; text-decoration: none;" href="<?= DOMAIN ?>/articles/vozvrat-tovara/" title="Возврат товара">Возврат товара</a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; display: block; line-height: 20px; text-decoration: none;" href="<?= DOMAIN ?>/articles/proizvoditel/" title="Производитель">Производитель</a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; display: block; line-height: 20px; text-decoration: none;" href="<?= DOMAIN ?>/articles/bezopasnost-platezhey/" title="Безопасность платежей">Безопасность платежей</a>
					</div>

					<div style="width: 150px; display: inline-block; vertical-align: top; font-family: Helvetica, Arial,Verdana, sans-serif; font-size: 13px;"  >
						<div style="font-size: 16px; font-weight: bold; margin: 0 0 15px; color: #fff;"  >Ассортимент</div>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; display: block; line-height: 20px; text-decoration: none;" href="<?= DOMAIN ?>/catalog/zhenskaya_odezhda/" title="Для женщин">Для женщин</a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; display: block; line-height: 20px; text-decoration: none;" href="<?= DOMAIN ?>/catalog/muzhskaya_odezhda/" title="Для мужчин">Для мужчин</a>
					</div>
					<div style="width: 130px; display: inline-block; vertical-align: top; font-family: Helvetica, Arial,Verdana, sans-serif; font-size: 13px;"  >
						<div style="font-size: 16px; font-weight: bold; margin: 0 0 15px; color: #fff;"  >О магазине</div>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; display: block; line-height: 20px; text-decoration: none;" href="<?= DOMAIN ?>/articles/pomoshch-i-kontakty/" title="О компании">О компании</a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; display: block; line-height: 20px; text-decoration: none;" href="<?= DOMAIN ?>/magaziny-stolnik.php" title="Магазины">Магазины</a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; display: block; line-height: 20px; text-decoration: none;" href="<?= DOMAIN ?>/articles/rezhim-raboty/" title="Контакты">Контакты</a>

					</div>
					<div style="width: 100px; display: inline-block; vertical-align: top; font-family: Helvetica, Arial,Verdana, sans-serif; font-size: 13px;"   style="width: 100px;">
						<div style="font-size: 16px; font-weight: bold; margin: 0 0 15px; "  >&nbsp;</div>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; display: block; line-height: 20px; text-decoration: none;" href="<?= DOMAIN ?>/articles/optovikam/" title="Оптовикам">Оптовикам</a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; display: block; line-height: 20px; text-decoration: none;" href="<?= DOMAIN ?>/articles/partnerstvo/" title="Партнерство">Партнерство</a>
					</div>
					<hr>

					<div style="color: #fff; width: 460px; display: inline-block; vertical-align: top; font-family: Helvetica, Arial,Verdana, sans-serif; font-size: 13px;" >
						Оставайтесь с нами –
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; line-height: 20px; text-decoration: none; display: inline;" href="http://vk.com/stolnik24"  title="Оставайтесь с нами - ВКонтакте" target="_blank" id="bx_3966226736_19448"><img src="<?= DOMAIN ?>/upload/iblock/fb5/fb54a58dc89cb91ea97ff46607617d7b.png" width="22" height="23" alt="ВКонтакте"></a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; line-height: 20px; text-decoration: none; display: inline;" href="https://www.facebook.com/stokstolnik"  title="Оставайтесь с нами - Facebook" target="_blank" id="bx_3966226736_19447"><img src="<?= DOMAIN ?>/upload/iblock/21e/21ef77605dc45c16448acb1a44fe8cdf.png" width="22" height="23" alt="Facebook"></a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; line-height: 20px; text-decoration: none; display: inline;" href="https://twitter.com/sstolnik"  title="Оставайтесь с нами - Twitter" target="_blank" id="bx_3966226736_19450"><img src="<?= DOMAIN ?>/upload/iblock/681/6810e11c1644009867a200e98ebcea4b.png" width="22" height="23" alt="Twitter"></a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; line-height: 20px; text-decoration: none; display: inline;" href="https://instagram.com/stolnik_official"  title="Оставайтесь с нами - Instagram" target="_blank" id="bx_3966226736_371779"><img src="<?= DOMAIN ?>/upload/iblock/c78/c78ce516b3358d810e92feb970a3f6b5.png" width="22" height="23" alt="Instagram"></a>
					</div>

					<div style=" color: #fff; display: inline-block; vertical-align: top; font-family: Helvetica, Arial,Verdana, sans-serif; font-size: 13px;" >
						Мы принимаем к оплате -
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; line-height: 20px; text-decoration: none; display: inline;" href=""  title="Мы принимает к оплате - qiwi" target="_blank" id="bx_1970176138_34265"><img src="<?= DOMAIN ?>/upload/iblock/1a4/1a4245491620c9fdc613defe2fbe6a28.png" width="25" height="26" alt="qiwi"></a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; line-height: 20px; text-decoration: none; display: inline;" href="http://www.sbrf.ru/chelyabinsk/ru/"  title="Мы принимает к оплате - sber" target="_blank" id="bx_1970176138_34268"><img src="<?= DOMAIN ?>/upload/iblock/a43/a433e11276aac8bb8b1f03c8a826fe49.png" width="24" height="25" alt="sber"></a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; line-height: 20px; text-decoration: none; display: inline;" href="https://www.paypal.com/cy"  title="Мы принимает к оплате - PayPal" target="_blank" id="bx_1970176138_236723"><img src="<?= DOMAIN ?>/upload/iblock/385/3851aa7d765e32d5f92482fb567d3abe.png" width="41" height="26" alt="PayPal"></a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; line-height: 20px; text-decoration: none; display: inline;" href="http://www.mastercard.com/ru/consumer/index.html"  title="Мы принимает к оплате - mc" target="_blank" id="bx_1970176138_34270"><img src="<?= DOMAIN ?>/upload/iblock/54d/54d4868cb9f49e6b7bd1f77f76385fc7.png" width="40" height="25" alt="mc"></a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; line-height: 20px; text-decoration: none; display: inline;" href=""  title="Мы принимает к оплате - maestro" target="_blank" id="bx_1970176138_34271"><img src="<?= DOMAIN ?>/upload/iblock/ced/ced2d9bb980561de13abb15052f06cb9.png" width="31" height="19" alt="maestro"></a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; line-height: 20px; text-decoration: none; display: inline;" href="http://www.visa.com.ru/main.jsp"  title="Мы принимает к оплате - visa" target="_blank" id="bx_1970176138_34272"><img src="<?= DOMAIN ?>/upload/iblock/440/4404460beee65fbb14f68b897622b518.png" width="37" height="11" alt="visa"></a>
						<a style="font-family: Helvetica, Arial,Verdana, sans-serif; color: #fff; font-size: 13px; line-height: 20px; text-decoration: none; display: inline;" href="http://www.rbkmoney.ru"  title="Мы принимает к оплате - RBK Money" target="_blank" id="bx_1970176138_37365"><img src="<?= DOMAIN ?>/upload/iblock/1c6/1c6adfcbfbba784f4c5fbe356f8201fd.png" width="56" height="24" alt="RBK Money"></a>
					</div>
				</div>
			</div>
		</div>
	</div>

		<div style="font-size: 12px; line-height: 15px;">
			Вы получили это письмо, поскольку выразили согласие на получение новостей и предложений от компании STOLNIK.
			Если Вы считаете, что настоящее письмо было направлено Вам по ошибке, пожалуйста, проигнорируйте его содержание.
			Вы можете <a href="#" style="color:#73716c;text-decoration:underline;" target="_blank">отказаться от получения предложений </a>
			и <a href="#" style="color:#73716c;text-decoration:underline;" target="_blank">подписаться на них вновь</a>,
			если поменяли свое решение.
		</div>
	</div>
<?

if($SUBSCRIBE_TEMPLATE_RESULT)
	return array(
		"SUBJECT"=>$SUBSCRIBE_TEMPLATE_RUBRIC["NAME"],
		"BODY_TYPE"=>"html",
		"CHARSET"=>"windows-1251",
		"DIRECT_SEND"=>"Y",
		"FROM_FIELD"=>$SUBSCRIBE_TEMPLATE_RUBRIC["FROM_FIELD"],
	);
else
	return false;
?>