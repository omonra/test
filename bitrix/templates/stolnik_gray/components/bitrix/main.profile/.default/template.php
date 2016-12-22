<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="profile_block">
    <h1>��� ��� �������</h1>

    <h2>��������������� ������</h2>
    <?=ShowError($arResult["strProfileError"]);?>
    <?
    if ($arResult['DATA_SAVED'] == 'Y')
        echo ShowNote(GetMessage('PROFILE_DATA_SAVED'));
    ?>
    <form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>?" enctype="multipart/form-data" class="form">
        <?=$arResult["BX_SESSION_CHECK"]?>
        <input type="hidden" name="lang" value="<?=LANG?>" />
        <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />

        <div class="field">
            <label for="profile_name">��� <span class="footnote">*</span></label>
            <input  id="profile_name" class="text_input text_input_1" type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" />
        </div>


        <div class="field">
            <label for="profile_last_name">������� <span class="footnote">*</span></label>
            <input id="profile_last_name" class="text_input text_input_1" type="text" name="LAST_NAME" maxlength="50" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
            <div class="helpModal">
                ������ ��������� ��������� ���, ��� ��� ��� ����� ���������� � ������ �������� �������� �������. ����������� ���������.
            </div>
        </div>

        <div class="field">
            <label for="profile_middle_name">��������</label>
            <input id="profile_middle_name" class="text_input text_input_1" type="text" name="SECOND_NAME" maxlength="50" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
        </div>

        <div class="field">
            <label for="profile_tel">�������</label>
            <input id="profile_tel" class="text_input text_input_1" type="text" name="PERSONAL_PHONE" maxlength="50" value="<?=$arResult["arUser"]["PERSONAL_MOBILE"]?>" />
            <div class="helpModal">
                ������� ���� ����� ��������, ����� �������� ��� ��������� � ���� �� ������.
            </div>
        </div>

        <div class="field">
            <label for="profile_gender">���</label>
            <label style="width: auto; margin-right: 15px;">
                <input class="text_input text_input_1" type="radio" name="PERSONAL_GENDER" maxlength="50" value="M" <?if($arResult["arUser"]["PERSONAL_GENDER"] == "M"){echo "checked";}?> />
                �������
            </label>
            <label style="width: auto">
                <input class="text_input text_input_1" type="radio" name="PERSONAL_GENDER" maxlength="50" value="F" <?if($arResult["arUser"]["PERSONAL_GENDER"] == "F"){echo "checked";}?> />
                �������
            </label>
            <div class="helpModal">
                ������� ���, ����� �������� ���������� ��� ��� ���������� �� ���������� ��� ������ ��� ������.
            </div>
        </div>

        <div class="field">
            <label for="profile_email">E-mail <span class="footnote">*</span></label>
            <input id="profile_email" class="text_input text_input_1" type="text" name="EMAIL" maxlength="50" value="<? echo $arResult["arUser"]["EMAIL"]?>" />
        </div>

        <input type="hidden" name="LOGIN" maxlength="50" value="<? echo $arResult["arUser"]["LOGIN"]?>" />

        <div class="field">
            <label for="profile_new_pass">����� ������ <span class="footnote">*</span></label>
            <input id="profile_new_pass" class="text_input text_input_1" type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off" />
            <div class="helpModal">
                ������ �������� ������� �� 8 ��������, ��������� ��� ������� 1 ����� � 1 �����. ����� ������������ ����� ����� (��������� � ���������, ��������� � ��������),
                ����� � ������ �������������. ��� ��������� �������, � �.�. ������, ������������ ������.
            </div>
        </div>

        <div class="field">
            <label for="profile_new_pass_repeat">��� ��� ����� ������ <span class="footnote">*</span></label>
            <input id="profile_new_pass_repeat" class="text_input text_input_1" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off" />
        </div>

        <?$arSubsribe = USubscribe::GetArray();
        if($arSubsribe["ID"] > 0 && $arSubsribe["ACTIVE"] == "Y"){$checked = "checked";}?>
        <div class="field">
            <label for="profile_subscribe">����������� �� ��������</label>
            <input id="profile_subscribe" class="text_input text_input_1" type="checkbox" name="SUBSCRIBE" value="Y" <?=$checked?>/>
        </div>


        <div class="controls clearfix">
            <input class="button button_1" type="submit" name="save" value="��������� ���������" />
        </div>
    </form>

</div>
