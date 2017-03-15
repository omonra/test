<?php
/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 07.06.2016
 * Time: 3:09
 */

class USubscribe
{
    public static function Add($userId, $userEmail)
    {
        if(CModule::IncludeModule("subscribe"))
        {
            $arFields = Array(
                "USER_ID" => trim($userId),
                "FORMAT" => ("text"),
                "EMAIL" => trim($userEmail),
                "ACTIVE" => "Y",
                "RUB_ID" => array(1,2),
                "SEND_CONFIRM" => "N",
                "ALL_SITES" => "Y"
            );
            $subscr = new CSubscription;
            $ID = $subscr->Add($arFields);

            return $ID;
        }
    }

    public static function GetArray()
    {
        if(CModule::IncludeModule("subscribe"))
        {
            $aSubscr = CSubscription::GetUserSubscription();
            return $aSubscr;
        }
    }
}