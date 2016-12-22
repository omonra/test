<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<div class="auth_block">
    <h1>Вход в магазин</h1>

    <h2>Войдите под своим логином и паролем</h2>

    <?
    ShowMessage($arParams["~AUTH_RESULT"]);
    ShowMessage($arResult['ERROR_MESSAGE']);
    ?>

    <form name="form_auth" class="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">

        <input type="hidden" name="AUTH_FORM" value="Y" />
        <input type="hidden" name="TYPE" value="AUTH" />
        <?if (strlen($arResult["BACKURL"]) > 0):?>
        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <?endif?>
        <?foreach ($arResult["POST"] as $key => $value):?>
        <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
        <?endforeach?>

        <dl class="form_list">
            <dt><label for="reg_name">Логин</label></dt>
            <dd><input id="reg_name" class="text_input text_input_1" type="text" name="USER_LOGIN" value="<?=$arResult["LAST_LOGIN"]?>" /></dd>


            <dt><label for="reg_new_pass_repeat">Пароль</label></dt>
            <dd><input id="reg_new_pass_repeat" class="text_input text_input_1" type="password" name="USER_PASSWORD" /></dd>

        </dl>

        <ul class="options">
            <li class="forgot_pass_link"><a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>">Клик если забыли пароль?</a></li>
            <li class="submit"><input class="button button_1" type="submit" name="Login" value="Войти"></li>
        </ul>

    </form>

        <?if($arResult["AUTH_SERVICES"]):?>
        <?
        $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
            array(
                "AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
                "CURRENT_SERVICE"=>$arResult["CURRENT_SERVICE"],
                "AUTH_URL"=>'/login/',
                "POST"=>$arResult["POST"],
            ),
            $component,
            array("HIDE_ICONS"=>"Y")
        );
        ?>
        <?endif?>
</div>
