<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>



<div class="authorize">
    <?
    ShowMessage($arParams["~AUTH_RESULT"]);
    ShowMessage($arResult['ERROR_MESSAGE']);
    ?>
    <b>� ��� ������� �������������</b>
    <form name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
        <input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="AUTH" />
		<?if (strlen($arResult["BACKURL"]) > 0):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<?endif?>
		<?foreach ($arResult["POST"] as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
		<?endforeach?>
                <input type="text" placeholder="������� ��� email" name="USER_LOGIN" value="<?=$arResult["LAST_LOGIN"]?>" />
                <input type="password" name="USER_PASSWORD" placeholder="������" maxlength="255" autocomplete="off" />
                <?if($arResult["CAPTCHA_CODE"]):?>
		<div class="captcha">
                    <input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" /><br/>
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                    <input type="text" placeholder="������� ��� � ��������" name="captcha_word" maxlength="50" value="" size="15" />
                </div>
		<?endif;?>
                <input type="hidden" name="USER_REMEMBER" value="Y" />
                <table width="100%">
                    <tr>
                        <td width="50%"><button class="btn-orange" type="submit" name="Login" value="Y">��������������</button></td>
                        <td width="50%" align="right"><a class="forgot" href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>">������ ������?</a></td>
                    </tr>
                </table>
                <hr/>
                
                <a href="/app/reg/" class="btn-gray" rel="nofollow">������������������</a>
    </form>
</div>

