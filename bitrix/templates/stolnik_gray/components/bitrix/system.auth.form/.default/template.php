<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
	ShowMessage($arResult['ERROR_MESSAGE']);
?>

<?if($arResult["FORM_TYPE"] == "login"):?>

	<form name="system_auth_form<?=$arResult["RND"]?>" method="post" onsubmit="return stolnik.AjaxFormSubmit(this, 'ajax_form_container_login')" target="_top" action="<?=$arResult["AUTH_URL"]?>" class="form">
	<?if($arResult["BACKURL"] <> ''):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<?endif?>
	<?foreach ($arResult["POST"] as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
	<?endforeach?>
		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="AUTH" />
		<div class="field">
			<label for="field_USER_LOGIN"><?=GetMessage("AUTH_LOGIN")?></label>
			<input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" id="field_USER_LOGIN" size="17" />
		</div>
		<div class="field">
			<label for="field_USER_PASSWORD"><?=GetMessage("AUTH_PASSWORD")?></label>
			<input type="password" name="USER_PASSWORD" maxlength="50" size="17" id="field_USER_PASSWORD" />
	<?if($arResult["SECURE_AUTH"]):?>
			<span class="bx-auth-secure" id="bx_auth_secure<?=$arResult["RND"]?>" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
				<div class="bx-auth-secure-icon"></div>
			</span>
			<noscript>
			<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
				<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
			</span>
			</noscript>
	<script type="text/javascript">
	document.getElementById('bx_auth_secure<?=$arResult["RND"]?>').style.display = 'inline-block';
	</script>
	<?endif?>
		</div>
	<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
		<div class="field">
			<label></label>
			<input type="checkbox" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y" />
			<label for="USER_REMEMBER_frm" title="<?=GetMessage("AUTH_REMEMBER_ME")?>" class="text"><?echo GetMessage("AUTH_REMEMBER_SHORT")?></label>
		</div>
	<?endif?>
	<?if ($arResult["CAPTCHA_CODE"]):?>
		<div class="field">
			<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
			<label for="captcha_auth"><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?></label>
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" /><br />
			<label for=""></label>
			<input type="text" name="captcha_word" id="captcha_auth" size="30" maxlength="50" value="" class="inputtext captcha" />
		</div>
	<?endif?>
		<div class="controls"><input type="submit" name="Login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>" class="button" /></div>
	<?if($arResult["NEW_USER_REGISTRATION"] == "Y"):?>
		<noindex><a href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a></noindex><br />
	<?endif?>
		<noindex><a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a></noindex>
	</form>

	<?if($arResult["AUTH_SERVICES"]):?>
	<?
	$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
		array(
			"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
			"AUTH_URL"=>$arResult["AUTH_URL"],
			"POST"=>$arResult["POST"],
			"POPUP"=>"Y",
			"SUFFIX"=>"form",
		),
		$component,
		array("HIDE_ICONS"=>"Y")
	);
	?>
	<?endif?>

<?
elseif($arResult["FORM_TYPE"] == "otp"):
?>

	<form name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
	<?if($arResult["BACKURL"] <> ''):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<?endif?>
		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="OTP" />
		<table width="95%">
			<tr>
				<td colspan="2">
				<?echo GetMessage("auth_form_comp_otp")?><br />
				<input type="text" name="USER_OTP" maxlength="50" value="" size="17" autocomplete="off" /></td>
			</tr>
	<?if ($arResult["CAPTCHA_CODE"]):?>
			<tr>
				<td colspan="2">
				<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:<br />
				<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /><br /><br />
				<input type="text" name="captcha_word" maxlength="50" value="" /></td>
			</tr>
	<?endif?>
	<?if ($arResult["REMEMBER_OTP"] == "Y"):?>
			<tr>
				<td valign="top"><input type="checkbox" id="OTP_REMEMBER_frm" name="OTP_REMEMBER" value="Y" /></td>
				<td width="100%"><label for="OTP_REMEMBER_frm" title="<?echo GetMessage("auth_form_comp_otp_remember_title")?>"><?echo GetMessage("auth_form_comp_otp_remember")?></label></td>
			</tr>
	<?endif?>
			<tr>
				<td colspan="2"><input type="submit" name="Login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>" /></td>
			</tr>
			<tr>
				<td colspan="2"><noindex><a href="<?=$arResult["AUTH_LOGIN_URL"]?>" rel="nofollow"><?echo GetMessage("auth_form_comp_auth")?></a></noindex><br /></td>
			</tr>
		</table>
	</form>

<?
else:
?>
	<?$APPLICATION->ShowHead();?>
    <script>
        BX.reload(false);
    </script>
    Вы успешно авторизованы.
<?endif?>
