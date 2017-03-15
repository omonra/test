<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="change_pass">
    <h1>Смена пароля</h1>
    <?
    ShowMessage($arParams["~AUTH_RESULT"]);
    ?>
    <div class="forgot_pass_form">
        <form method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform" class="form">

            <?if (strlen($arResult["BACKURL"]) > 0): ?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <? endif ?>
            <input type="hidden" name="AUTH_FORM" value="Y">
            <input type="hidden" name="TYPE" value="CHANGE_PWD">

            <div class="field">
                <label for="field_changepasswd_login">Логин</label>
                <input id="field_changepasswd_login" class="text_input text_input_1" type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" />
            </div>
            <div class="field">
                <label for="field_changepasswd_checkword">Контрольная строка</label>
                <input id="field_changepasswd_checkword" class="text_input text_input_1" type="text" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" />
            </div>
            <div class="field">
                <label for="field_changepasswd_password">Новый пароль</label>
                <input id="field_changepasswd_password" class="text_input text_input_1" type="password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" />
            </div>
            <div class="field">
                <label for="field_changepasswd_password2">Подтверждение пароля</label>
                <input id="field_changepasswd_password2" class="text_input text_input_1" type="password" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" />
            </div>

            <div class="controls">
                <input class="button button_1" type="submit" name="change_pwd" value="Сменить" />
            </div>

        </form>
    </div>
</div>
<script type="text/javascript">
    document.bform.USER_LOGIN.focus();
</script>
