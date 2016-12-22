<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
echo "<div class='call-phone'>";
$APPLICATION->IncludeComponent("bitrix:form.result.new", "", $arParams, $component);
echo "</div>";
?>