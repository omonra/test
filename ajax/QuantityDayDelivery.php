<?php
/**
 * Created by PhpStorm.
 * User: �������
 * Date: 26.08.2016
 * Time: 17:55
 */

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if($_REQUEST["getInfo"] == "y")
{
    $arResult = Array ();
    $arInfo1C = PControl::GetQuantityByXmlID($_REQUEST["xmlID"], true);
    foreach($arInfo1C["OFFERS_INFO"] as $oneOffer)
    {
        if($_REQUEST["selectSize"] == 99)
            $_REQUEST["selectSize"] = 0;
        $dbSizeColor = explode(", ", $oneOffer["NAME"]);
        $_size = ToLower($dbSizeColor[0]);
        $_color = ToLower($dbSizeColor[1]);
        $size = ToLower(trim($_REQUEST["selectSize"]));
        $color = ToLower(trim($_REQUEST["selectColor"]));
        if($_size == $size && $_color == $color)
        {
            $count = 0;
            foreach($oneOffer["SKLAD"] as $oneSklad)
                $count = $count + $oneSklad["QUANTITY"];
            echo "<br>���������� ���������� ������ �� ������: $count ��.<br>";
            if($oneOffer["FAST_DELIVERY"] == "Y")
            {
                echo "�������� �� 3 ����";
            }
            else
            {
                echo "��� ����� �� 7 ����";
            }
        }
    }
}
