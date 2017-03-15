<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="auth_end_reg">

    <div class="block_description">Для продолжения оформления заказа, необходимо зарегистрироваться в интернет магазине или авторизоваться под своим логином и паролем.</div>

    <div class="auth_block">
        <h1>Вернувшимся покупателям</h1>

        <h2>Войдите под своим логином и паролем</h2>

        <form method="post" action="" name="order_auth_form">
            <?
            foreach ($arResult["POST"] as $key => $value)
            {
                ?>
                <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
                <?
            }
            ?>
            <dl class="form_list">
                <dt><label for="reg_name">Логин</label></dt>
                <dd><input id="reg_name" class="text_input text_input_1" type="text" name="USER_LOGIN" maxlength="30" value="<?=$arResult["AUTH"]["USER_LOGIN"]?>"></dd>

                <dt><label for="reg_new_pass_repeat">Пароль</label></dt>
                <dd><input type="password" id="reg_new_pass_repeat"  class="text_input text_input_1" name="USER_PASSWORD" maxlength="30" ></dd>

            </dl>

            <ul class="options">
                <li class="forgot_pass_link"><a href="<?=$arParams["PATH_TO_AUTH"]?>?forgot_password=yes&back_url=<?= urlencode($APPLICATION->GetCurPageParam()); ?>">Клик если забыли пароль?</a></li>
                <input type="hidden" name="do_authorize" value="Y">
                <li class="submit"><input class="button button_1" type="submit" value="Войти"></li>
            </ul>

        </form>


        <?
        $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
            array(
                "AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
                "CURRENT_SERVICE"=>$arResult["CURRENT_SERVICE"],
                "AUTH_URL"=>"/login/",
                "POST"=>$arResult["POST"],
            ),
            $component,
            array("HIDE_ICONS"=>"Y")
        );?>
    </div>


    <div class="reg_block">
        <h1>Новым покупателям</h1>

        <h2>Если вы в первые оформляете покупку, пожалуйста зарегистрируйтесь</h2>
        <form method="post" action="" name="order_reg_form">
            <?
            foreach ($arResult["POST"] as $key => $value)
            {
                ?>
                <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
                <?
            }
            ?>
            <dl class="form_list">
                <dt><label for="reg_name2">Имя</label></dt>
                <dd><input type="text" id="reg_name2" name="NEW_NAME" class="text_input text_input_1" value="<?=$arResult["AUTH"]["NEW_NAME"]?>"></dd>

                <dt><label for="reg_last_name">Фамилие</label></dt>
                <dd><input id="reg_last_name" class="text_input text_input_1" type="text" name="NEW_LAST_NAME" value="<?=$arResult["AUTH"]["NEW_LAST_NAME"]?>"></dd>

                <dt><label for="reg_email">E-mail</label><span class="footnote">*</span></dt>
                <dd><input id="reg_email" class="text_input text_input_1" type="text" name="NEW_EMAIL" size="40" value="<?=$arResult["AUTH"]["NEW_EMAIL"]?>"></dd>

                <dt style="display:none;"><label for="reg_login">Логин для входа <span class="description">(минимум 6 символов)</span></label><span class="footnote">*</span></dt>
                <dd style="display:none;"><input id="reg_login" class="text_input text_input_1" type="text" name="NEW_LOGIN" value="<?=$arResult["AUTH"]["NEW_LOGIN"]?>"></dd>

                <dt><label for="reg_new_pass">Пароль</label><span class="footnote">*</span></dt>
                <dd><input id="reg_new_pass" class="text_input text_input_1 text_input_1_err" type="password" name="NEW_PASSWORD"></dd>

                <dt><label for="reg_new_pass_repeat2">Ещё раз пароль</label><span class="footnote">*</span></dt>
                <dd><input id="reg_new_pass_repeat2" class="text_input text_input_1" type="password" name="NEW_PASSWORD_CONFIRM"></dd>

            </dl>
            <?if($arResult["AUTH"]["captcha_registration"] == "Y"): //CAPTCHA?>
            <h2>Впишите код если вы не робот</h2>
            <dl class="form_list">
                <input type="hidden" name="captcha_sid" value="<?=$arResult["AUTH"]["capCode"]?>">
                <dt class="captcha"><label for="reg_chaptcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["AUTH"]["capCode"]?>" width="180" height="40" alt="CAPTCHA"></label></dt>
                <dd class="captcha"><input id="reg_chaptcha" class="text_input text_input_1" type="text" name="captcha_word" maxlength="50" value=""></dd>
            </dl>
            <?endif;?>
            <input type="hidden" name="do_register" value="Y">
            <ul class="to_form_list">
                <li><input class="button button_1" type="submit" value="Зарегистрироваться" onclick="$('input[name=\'NEW_LOGIN\']').val($('input[name=\'NEW_EMAIL\']').val());$('#form_registration').click()"></li>
            </ul>
        </form>
    </div>
</div>