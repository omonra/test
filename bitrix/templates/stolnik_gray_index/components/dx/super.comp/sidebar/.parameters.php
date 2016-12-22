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
	"IBLOCK_ID" => array(
		"PARENT" => "DATA_SOURSE",
		"NAME" => "Код инфоблока статей",
		"TYPE" => "LIST",
		"ADDITIONAL_VALUES" => "Y",
		"VALUES" => $arIBlock,
		"REFRESH" => "Y",
	),
	"SECTION_ID" => array(
	    "PARENT" => "DATA_SOURSE",
	    "NAME" => "ID элемента",
	    "TYPE" => "STRING",
	    "DEFAULT" => "",
	),
	"COUNT_ELEMENTS" => array(
	    "PARENT" => "DATA_SOURSE",
	    "NAME" => "Выводить количество",
	    "TYPE" => "CHECKBOX",
	    "DEFAULT" => "Y",
	),
    "CURRENT_SECTION_ID" => array(
        "PARENT" => "DATA_SOURSE",
        "NAME" => "Идентификатор текущего раздела",
        "TYPE" => "STRING",
        "DEFAULT" => "",
    ),
);
?>
