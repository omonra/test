<?php
/**
 * Created by PhpStorm.
 * User: Àëåêñåé
 * Date: 07.06.2016
 * Time: 3:17
 */

$arSubsribe = USubscribe::GetArray();

// ÓÑÒÀÍÎÂÊÀ ÏÎÄÏÈÑÎÊ
if($_REQUEST["SUBSCRIBE"] == "Y")
{
    if($arSubsribe["ID"] <= 0)
    {
        if(check_email($_REQUEST["LOGIN"]))
        {
            USubscribe::Add($_REQUEST["ID"], $_REQUEST["LOGIN"]);
        }
    }
    else
    {
        USubscribe::UpdateActive($arSubsribe["ID"], "Y");
    }
}
else
{
    if($arSubsribe["ID"] > 0 && isset($_REQUEST["LOGIN"]))
    {
        USubscribe::UpdateActive($arSubsribe["ID"], "N");
    }
}