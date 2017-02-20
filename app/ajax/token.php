<?php

use Bitrix\Main\Web\Json;
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$result = Array("status" => "failed");

if (!\Bitrix\Main\Loader::includeModule("pull"))
{
    $result["error"] = "Module 'pull' is not installed";
}
else
{
    /**
     * @var $DB CAllDatabase
     * @var $USER CALLUser
     */
    $data = null;
    $userId = $USER->GetID();
    if (!$userId)
    {
        $userId = BX_ANONYMOUS_USER_ID;
    }

    if ($_REQUEST["device_token"])
    {
        $res = array("status" => "failed", "error" => "some unknown error");
        $data = array(
            "DEVICE_TOKEN" => $_REQUEST["device_token"],
            "DEVICE_ID" => $_REQUEST["uuid"],
            "DEVICE_TYPE" => $_REQUEST["device_type"],
            "APP_ID" => $_REQUEST["app_id"],
            "DATE_AUTH" => ConvertTimeStamp(getmicrotime(), "FULL"),
            "USER_ID" => $userId
        );

        $dbres = CPullPush::GetList(Array(), Array("DEVICE_ID" => $data["DEVICE_ID"]));
        $arToken = $dbres->Fetch();
        $status = "failed";

        if ($arToken["ID"])
        {
            CPullPush::Update($arToken["ID"], $data);
            $status = "updated";
        }
        else
        {
            if ($res = CPullPush::Add($data))
            {
                $status = "registered";
            }
        }


        $result = array(
            "token_status" => $status
        );
    }
}
$result["data"] = $data != null ? $data : array();

header("Content-Type: application/x-javascript");
echo Json::encode($result);
die();