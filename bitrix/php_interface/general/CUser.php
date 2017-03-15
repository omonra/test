<?php

AddEventHandler("main", "OnBeforeUserUpdate", array("CExUser" ,"OnBeforeUserUpdateHandler"));
AddEventHandler("main", "OnBeforeUserAdd", array("CExUser" ,"OnBeforeUserAddRegisterHandler"));
AddEventHandler("main", "OnBeforeUserRegister", array("CExUser" ,"OnBeforeUserAddRegisterHandler"));

AddEventHandler("main", "OnAfterUserAdd", array("CExUser" ,"OnAfterUserAddHandler"));

AddEventHandler("main", "OnAfterUserAdd", array("CExUser" ,"OnAfterUserRegisterHandler"));
AddEventHandler("main", "OnAfterUserRegister", array("CExUser" ,"OnAfterUserRegisterHandler"));

class CExUser
{
    function OnBeforeUserUpdateHandler(&$arFields)
    {
        if(check_email($arFields["EMAIL"]))
        {
            $arFields["LOGIN"] = $arFields["EMAIL"];
        }
    }
    
    function OnBeforeUserAddRegisterHandler(&$arFields)
    {
        $arFields["LOGIN"] = $arFields["EMAIL"];

        $resText = "";
        if (strlen($arFields['NAME']) <= 0)
        {
            $resText .= "Имя является обязательным полем.";
        }
        if (strlen($arFields['LAST_NAME']) <= 0)
        {
            if(strlen($resText) > 0)
                $resText .= "<br>";
            $resText .= "Фамилия является обязательным полем.";
        }
        if(strlen($resText) > 0)
        {
            $GLOBALS['APPLICATION']->ThrowException($resText);
            return false;
        }
    }
    
    function OnAfterUserAddHandler(&$arFields)
    {
        if($arFields["ID"] > 0)
        {
            USubscribe::Add($arFields["ID"], $arFields["LOGIN"]);
        }
    }
    
    function OnAfterUserRegisterHandler(&$arFields) {
        if (intval($arFields["ID"]) > 0)
        {
            $arEvent = $arFields;
            $arEvent["USER_ID"] = $arFields["ID"];
            $arEvent["CONFIRM_CODE"] = randString(8);
            CEvent::SendImmediate("NEW_USER_CONFIRM", SITE_ID, $arEvent);

            if($arFields["USER_SUBSCRIBE"] == "Y")
            {
                USubscribe::Add($arFields["USER_ID"], $arFields["LOGIN"]);
            }
        }
        return $arFields;
    }
}