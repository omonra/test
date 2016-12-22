<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>
<div class="mfeedback" id="faq_feedback">
<?if(!empty($arResult["ERROR_MESSAGE"]))
{
	foreach($arResult["ERROR_MESSAGE"] as $v)
		ShowError($v);
}
if(strlen($arResult["OK_MESSAGE"]) > 0)
{
	?><div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div><?
}
?>

<form action="<?=$APPLICATION->GetCurPage()?>" method="POST">
<?=bitrix_sessid_post()?>
	<div class="mf-container">
		<div class="mf-name">
			<div class="mf-text">
				<?=GetMessage("MFT_NAME")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
			</div>
			<input class="text_input text_input_1" type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>">
		</div>
		<div class="mf-email">
			<div class="mf-text">
				<?=GetMessage("MFT_EMAIL")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
			</div>
			<input class="text_input text_input_1" type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>">
		</div>

		<div class="mf-message">
			<div class="mf-text">
				<?=GetMessage("MFT_MESSAGE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
			</div>
			<textarea class="textarea textarea_1" name="MESSAGE" rows="5" cols="40"><?=$arResult["MESSAGE"]?></textarea>
		</div>
	</div>
	<?if($arParams["USE_CAPTCHA"] == "Y"):?>
	<div class="captcha_block">
		<h2>¬пишите код если вы не робот<span class="footnote">*</span></h2>
		<dl class="form_list">
			<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
			<dt class="captcha"><label for="reg_chaptcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA"></label></dt>
			<dd class="captcha"><input class="text_input text_input_1"  type="text" name="captcha_word" value=""></dd>
		</dl>
	</div>
	<div class="submit">
		<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
		<input class="button button_1_2" type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
	</div>
	<?else:?>
	<div class="submit_notcapcha">
		<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
		<input class="button button_1_2" type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
	</div>
	<?endif;?>
	

</form>
</div>
