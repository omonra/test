<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock")) return;

$arIBlockType = CIBlockParameters::GetIBlockTypes();
$arIBlock=array();
$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
{
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
}

$arTemplateParameters = array(
	"IBLOCK_TYPE" => array(
		"PARENT" => "DATA_SOURSE",
		"NAME" => "Тип инфоблока",
		"TYPE" => "LIST",
		"VALUES" => $arIBlockType,
		"REFRESH" => "Y",
	),
	"IBLOCK_ID1" => array(
		"PARENT" => "DATA_SOURSE",
		"NAME" => "Код инфоблока статей",
		"TYPE" => "LIST",
		"ADDITIONAL_VALUES" => "Y",
		"VALUES" => $arIBlock,
		"REFRESH" => "Y",
	),
	"IBLOCK_ID2" => array(
		"PARENT" => "DATA_SOURSE",
		"NAME" => "Код инфоблока комментариев",
		"TYPE" => "LIST",
		"ADDITIONAL_VALUES" => "Y",
		"VALUES" => $arIBlock,
		"REFRESH" => "Y",
	),
	"ELEMENT_ID" => array(
	    "PARENT" => "DATA_SOURSE",
	    "NAME" => "ID элемента",
	    "TYPE" => "STRING",
	    "DEFAULT" => "",
	),
	"PAGE_ELEMENT_COUNT" => array(
	    "PARENT" => "OVERALL",
	    "NAME" => "Количество выводимых элементов",
	    "TYPE" => "STRING",
	    "DEFAULT" => "4",
	),
	"PAGER_NAME" => array(
	    "PARENT" => "OVERALL",
	    "NAME" => "Шаблон для постраничной навигации",
	    "TYPE" => "STRING",
	    "DEFAULT" => "",
	),
    "ACTIVE_DATE_FORMAT" => CIBlockParameters::GetDateFormat(GetMessage("T_IBLOCK_DESC_ACTIVE_DATE_FORMAT"), "ADDITIONAL_SETTINGS"),
    "USE_CAPTCHA" => array(
        "NAME" => "Использовать Captch'у",
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
);
?>
