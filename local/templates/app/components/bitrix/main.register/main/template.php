<?
// bitrix/templates/stolnik_gray/components/bitrix/main.register/main
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */
/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
?>

<? if (!$USER->IsAuthorized()): ?>
<div class="registartion">
    <form method="post" action="<?= POST_FORM_ACTION_URI ?>" name="regform" class="form" target="_top" enctype="multipart/form-data">
        
    </form>
</div>
<? else: ?>

<? endif; ?>

<div class="reg_block">
    <h1>Регистрация</h1>
<? if ($USER->IsAuthorized()): ?>

        <p style=" text-align: center;padding: 20px 0 30px 0;"><? echo GetMessage("MAIN_REGISTER_AUTH") ?><br/><br/>
<a href="/" style="float: none;color: #fff;text-decoration: none; padding: 8px 30px 10px;" class="button">Войти на сайт</a>
        </p>


<? else: ?>

        <?
        if (count($arResult["ERRORS"]) > 0):
            foreach ($arResult["ERRORS"] as $key => $error)
                if (intval($key) == 0 && $key !== 0)
                    $arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;" . GetMessage("REGISTER_FIELD_" . $key) . "&quot;", $error);

            ShowError(implode("<br />", $arResult["ERRORS"]));

        elseif ($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
            ?>
            <p><? echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT") ?></p>
        <? endif ?>

        <form method="post" action="<?= POST_FORM_ACTION_URI ?>" name="regform" class="form" onsubmit="return stolnik.AjaxFormSubmit(this, 'ajax_form_container_registration')" target="_top" enctype="multipart/form-data">
            <? if ($arResult["BACKURL"] <> ''): ?>
            <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>" />
            <? endif;?>
            <? $arResult["SHOW_FIELDS"] = Array ('NAME', 'LAST_NAME', 'EMAIL', 'PASSWORD', 'CONFIRM_PASSWORD', 'LOGIN'); ?>
            <? foreach ($arResult["SHOW_FIELDS"] as $FIELD): ?>
            	<? if ($FIELD == 'LOGIN'): ?>
            		<input type="hidden" id="REGISTER-LOGIN" name="REGISTER[LOGIN]" value="<?= $arResult["VALUES"]['EMAIL'] ?>" />
            	<? continue; endif; ?>
                <div class="field">
                    <label for="reg_name"><?= GetMessage("REGISTER_FIELD_" . $FIELD) ?>:<? if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"): ?><span class="footnote">*</span><? endif ?></label>
        <?
        switch ($FIELD)
        {
            case "PASSWORD":?>

            	<input size="30" type="password" class="text_input text_input_1" required name="REGISTER[<?= $FIELD ?>]" value="<?= $arResult["VALUES"][$FIELD] ?>" autocomplete="off" />
                            <? if ($arResult["SECURE_AUTH"]): ?>
                                <span class="bx-auth-secure" id="bx_auth_secure" title="<? echo GetMessage("AUTH_SECURE_NOTE") ?>" style="display:none">
                                    <div class="bx-auth-secure-icon"></div>
                                </span>
                                <noscript>
                                <span class="bx-auth-secure" title="<? echo GetMessage("AUTH_NONSECURE_NOTE") ?>">
                                    <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                                </span>
                                </noscript>
                                <script type="text/javascript">
                                    document.getElementById('bx_auth_secure').style.display = 'inline-block';
                                </script>
                				<? endif ?>
                            <?
                            break;
                        case "CONFIRM_PASSWORD":
                            ?><input size="30" type="password" class="text_input text_input_1" required name="REGISTER[<?= $FIELD ?>]" value="<?= $arResult["VALUES"][$FIELD] ?>" autocomplete="off" /><?
                            break;

                        case "PERSONAL_GENDER":
                            ?><select name="REGISTER[<?= $FIELD ?>]">
                                <option value=""><?= GetMessage("USER_DONT_KNOW") ?></option>
                                <option value="M"<?= $arResult["VALUES"][$FIELD] == "M" ? " selected=\"selected\"" : "" ?>><?= GetMessage("USER_MALE") ?></option>
                                <option value="F"<?= $arResult["VALUES"][$FIELD] == "F" ? " selected=\"selected\"" : "" ?>><?= GetMessage("USER_FEMALE") ?></option>
                            </select><?
                break;

            case "PERSONAL_COUNTRY":
            case "WORK_COUNTRY":
                            ?><select name="REGISTER[<?= $FIELD ?>]"><?
                            foreach ($arResult["COUNTRIES"]["reference_id"] as $key => $value)
                            {
                                ?><option value="<?= $value ?>"<? if ($value == $arResult["VALUES"][$FIELD]): ?> selected="selected"<? endif ?>><?= $arResult["COUNTRIES"]["reference"][$key] ?></option>
                                    <?
                                }
                                ?></select><?
                                break;

                            case "PERSONAL_PHOTO":
                            case "WORK_LOGO":
                                ?><input size="30" type="file" name="REGISTER_FILES_<?= $FIELD ?>" /><?
                            break;

                        case "PERSONAL_NOTES":
                        case "WORK_NOTES":
                            ?><textarea cols="30" rows="5" class="text_input text_input_1" name="REGISTER[<?= $FIELD ?>]"><?= $arResult["VALUES"][$FIELD] ?></textarea><?
                                break;
                            default:
                                if ($FIELD == "PERSONAL_BIRTHDAY"):?><small><?= $arResult["DATE_FORMAT"] ?></small><br /><? endif;?>

                                <input <? if ($FIELD == 'EMAIL'):?>onkeyup='$("#REGISTER-LOGIN").val($(this).val());'<?endif;?> autocomplete="off" size="30" type="text" class="text_input text_input_1" <? if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"): ?>required<?endif;?> name="REGISTER[<?= $FIELD ?>]" value="<?= $arResult["VALUES"][$FIELD] ?>" /><?
                            

                            if ($FIELD == "PERSONAL_BIRTHDAY")
                                $APPLICATION->IncludeComponent(
                                        'bitrix:main.calendar', '', array(
                                    'SHOW_INPUT' => 'N',
                                    'FORM_NAME' => 'regform',
                                    'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
                                    'SHOW_TIME' => 'N'
                                        ), null, array("HIDE_ICONS" => "Y")
                                );
                            ?><? }
                    ?></div>
                <? endforeach; ?>
                <? // ********************* User properties ***************************************************?>
                <? if ($arResult["USER_PROPERTIES"]["SHOW"] == "Y"): ?>
                    <? foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField): ?>
                    <div class="field">
                        <label><?= $arUserField["EDIT_FORM_LABEL"] ?><? if ($arUserField["MANDATORY"] == "Y"): ?><span class="footnote">*</span><? endif; ?></label>
                    <?
                    $APPLICATION->IncludeComponent(
                            "bitrix:system.field.edit", $arUserField["USER_TYPE"]["USER_TYPE_ID"], array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS" => "Y"));
                    ?></td></tr>
                    </div>
                    <? endforeach; ?>

                <? endif; ?>
                <? // ******************** /User properties ***************************************************?>
            <?
            /* CAPTCHA */
            if ($arResult["USE_CAPTCHA"] == "Y")
            {
                ?>
                <div class="field">
                    <label><?= GetMessage("REGISTER_CAPTCHA_PROMT") ?><span class="footnote">*</span></label>

                    <input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>" />
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>" width="180" height="40" alt="CAPTCHA" /><br/>


                    
                </div>
                <div class="field">
                	<label>&nbsp;</label>
                	<input type="text" name="captcha_word" class="text_input text_input_1" maxlength="50" value="" />
                </div>
        <?
    }
    /* !CAPTCHA */
    ?>
            <div class="controls">
                <input class="button" type="submit" name="register_submit_button" value="<?= GetMessage("AUTH_REGISTER") ?>" />
            </div>
            <div class="clearing">&nbsp;</div>


        </form>
<? endif; ?>
</div>