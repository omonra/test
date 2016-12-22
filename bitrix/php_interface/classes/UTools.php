<?php
/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 07.06.2016
 * Time: 3:09
 */

class UTools
{
    public static function GeInfoByID($ID)
    {
        $cUser = new CUser;
        $sort_by = "ID";
        $sort_ord = "ASC";
        $arFilter = array("ID" => $ID);
        $dbUsers = $cUser->GetList($sort_by, $sort_ord, $arFilter);
        if($arUser = $dbUsers->Fetch())
        {
            return $arUser;
        }
        return false;
    }

    public static function Update($ID, $arFields)
    {
        $user = new CUser;
        $user->Update($ID, $arFields);
        return $user->LAST_ERROR;
    }
}