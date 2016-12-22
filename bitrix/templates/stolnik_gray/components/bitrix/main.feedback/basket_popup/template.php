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
<div class="mfeedback">


<form action="<?=POST_FORM_ACTION_URI?>" method="POST" id="basket_popup_form">
<?=bitrix_sessid_post()?>
	<div class="mf-text">
		<?=GetMessage('MFT_QUESTION');?>
		<?if(!empty($arResult["ERROR_MESSAGE"]))
		{
			foreach($arResult["ERROR_MESSAGE"] as $v)
				ShowError($v);
		}
		if(strlen($arResult["OK_MESSAGE"]) > 0)
		{
			?>
			<div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div><?
		}
		?>
	</div>
	<div class="mf-name">
		<input type="text" name="user_name" placeholder="<?=GetMessage("MFT_NAME")?>" value="<?=$arResult["AUTHOR_NAME"]?>">
	</div>
	<div class="mf-email">
		<input type="text" name="user_email" placeholder="<?=GetMessage("MFT_EMAIL")?>" value="<?=$arResult["AUTHOR_EMAIL"]?>">
	</div>
	<div class="mf-email">
		<input type="text" name="user_phone" placeholder="<?=GetMessage("MFT_PHONE")?>" value="">
	</div>

	<div class="mf-name">
		<textarea name="MESSAGE" rows="5" placeholder="<?=GetMessage("MFT_YOUR_QUESTION")?>"><?=$arResult["MESSAGE"]?></textarea>
	</div>

	<?/*if($arParams["USE_CAPTCHA"] == "Y"):?>
	<div class="mf-name">
		<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
		<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="245" height="40" alt="CAPTCHA">
		<input type="text" placeholder="<?=GetMessage("MFT_CAPTCHA_CODE")?>" name="captcha_word" size="30" maxlength="50" value="">
	</div>
	<?endif;*/?>
	<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
	<input type="hidden" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
</form>
</div>