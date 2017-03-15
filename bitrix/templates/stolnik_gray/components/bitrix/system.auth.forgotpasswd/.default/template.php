<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
?>

<form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>" class="form">
    <?
    if (strlen($arResult["BACKURL"]) > 0)
    {
        ?>
        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <?
    }
    ?>
    <input type="hidden" name="AUTH_FORM" value="Y">
    <input type="hidden" name="TYPE" value="SEND_PWD">

    <h1>Восстановление пароля</h1>
    <?ShowMessage($arParams["~AUTH_RESULT"]);?>
    <div class="forgot_pass">
        <h2>Введите логин или e-mail</h2>


        <div class="description">
            <p>Ссылка для смены пароля, а так же ваши регистрационные данные будут отправлены вам на E-mail</p>
        </div>

        <div class="field">
            <label for="field_forgotpasswd_login">Логин</label>
            <input class="text_input text_input_1" id="field_forgotpasswd_login" type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" /> или
        </div>
        <div class="field">
            <label for="field_forgotpasswd_email">E-mail</label>
            <input class="text_input text_input_1" id="field_forgotpasswd_email" type="text" name="USER_EMAIL" maxlength="255" />
        </div>
        <div class="controls">
        <input class="button button_1" type="submit" name="send_account_info" value="Выслать" />
        </div>

    </div>

    <?
    $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
        array(
            "AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
            "CURRENT_SERVICE"=>$arResult["CURRENT_SERVICE"],
            "AUTH_URL"=>$arResult["AUTH_URL"],
            "POST"=>$arResult["POST"],
        ),
        $component,
        array("HIDE_ICONS"=>"Y")
    );?>

</form>
<script type="text/javascript">
    document.bform.USER_LOGIN.focus();
</script>
