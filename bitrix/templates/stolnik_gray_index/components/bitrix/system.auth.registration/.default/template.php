<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>


<div class="reg_block">
    <h1>Регистрация</h1>

    <?if (isset($APPLICATION->arAuthResult) && is_array($APPLICATION->arAuthResult) && $APPLICATION->arAuthResult['TYPE'] == 'ERROR'):?>
        <?ShowError($APPLICATION->arAuthResult['MESSAGE']);?>
    <?endif;?>

    <?
    ShowMessage($arParams["~AUTH_RESULT"]);
    ?>
    <noindex>
    <form method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform" class="form" onsubmit="return stolnik.AjaxFormSubmit(this, 'ajax_form_container_registration')" target="_top">
        <?
        if (strlen($arResult["BACKURL"]) > 0)
        {
            ?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?
        }
        ?>
        <input type="hidden" name="AUTH_FORM" value="Y" />
        <input type="hidden" name="TYPE" value="REGISTRATION" />

        <div class="field">
            <label for="reg_name">Имя <span class="footnote">*</span></label>
            <input id="reg_name" class="text_input text_input_1" name="USER_NAME" type="text" value="<?=$arResult["USER_NAME"]?>">
        </div>
        <div class="field">
            <label for="reg_last_name">Фамилия <span class="footnote">*</span></label>
            <input id="reg_last_name" class="text_input text_input_1" name="USER_LAST_NAME" type="text" value="<?=$arResult["USER_LAST_NAME"]?>">
        </div>

        <div class="field">
            <label for="reg_email">E-mail <span class="footnote">*</span></label>
            <input id="reg_email" class="text_input text_input_1" name="USER_EMAIL" type="text" value="<?=$arResult["USER_EMAIL"]?>">
        </div>

        <?/*div class="field">
            <label for="reg_login">Логин для входа <span class="description">(минимум 6 символов)</span> <span class="footnote">*</span></label>
            <input id="reg_login" class="text_input text_input_1" name="USER_LOGIN" type="text" value="<?=$arResult["USER_LOGIN"]?>">
        </div*/?>

        <div class="field">
            <label for="reg_new_pass">Пароль <span class="footnote">*</span></label>
            <input id="reg_new_pass" class="text_input text_input_1 text_input_1_err" name="USER_PASSWORD" type="password" value="<?=$arResult["USER_PASSWORD"]?>">
        </div>

        <div class="field">
            <label for="reg_new_pass_repeat">Ещё раз пароль <span class="footnote">*</span></label>
            <input id="reg_new_pass_repeat" class="text_input text_input_1" name="USER_CONFIRM_PASSWORD" type="password" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>">
        </div>

        <div class="field">
            <label for="reg_subscribe">Подписаться на рассылку</label>
            <input id="reg_subscribe" class="text_input text_input_1" name="USER_SUBSCRIBE" type="checkbox" value="Y" checked>
        </div>

        <?
        /* CAPTCHA */
        if ($arResult["USE_CAPTCHA"] == "Y")
        {
        ?>
        <div class="field">
            <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />

            <label for="reg_chaptcha">Впишите код если вы не робот <span class="footnote">*</span></label>
            <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
            <br />
            <label></label>
            <input id="reg_chaptcha" class="text_input text_input_1" name="captcha_word" type="text" value="">
        </div>
        <?
        }
        ?>
        <div class="controls">
            <input class="button" name="Register" type="submit" value="Зарегистрироваться" />
        </div>
        <div class="clearing">&nbsp;</div>
    </form>
    </noindex>
    <script type="text/javascript">
        document.bform.USER_NAME.focus();
    </script>
</div>
