<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("iblock");

$arItemsIds = array();

foreach($arResult["ITEMS"]["AnDelCanBuy"] as $item){
	$arItemsIds[] = $item["PRODUCT_ID"];
}
foreach($arResult["ITEMS"]["DelDelCanBuy"] as $item){
  $arItemsIds[] = $item["PRODUCT_ID"];
}
foreach($arResult["ITEMS"]["nAnCanBuy"] as $item){
  $arItemsIds[] = $item["PRODUCT_ID"];
}

if(!empty($arItemsIds))
{
    $arSelect = Array("ID", "PROPERTY_CML2_LINK","PROPERTY_COLOR","IBLOCK_ID");
    $arFilter = Array("ID"=>$arItemsIds, "IBLOCK_ID"=>5, "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($arFields = $res->GetNext())
    {
		$arSKULink[$arFields["PROPERTY_CML2_LINK_VALUE"]] = $arFields["ID"];
		$arProd[$arFields["ID"]] = $arFields["PROPERTY_CML2_LINK_VALUE"];
		$arPRod[]=$arFields["PROPERTY_CML2_LINK_VALUE"];
    }

    $arResult["PROD"] = $arProd;

    if($arProd)
    {
        //wdebugClear();//wdebugAr($arProd);
        foreach($arResult["ITEMS"]["AnDelCanBuy"] as $key=>$item){
          if ($arProd[$item["PRODUCT_ID"]])
            $arResult["ITEMS"]["AnDelCanBuy"][$key]["PICTURE_ID"] = $arProd[$item["PRODUCT_ID"]];
        }
        foreach($arResult["ITEMS"]["DelDelCanBuy"] as $key=>$item){
          if ($arProd[$item["PRODUCT_ID"]])
            $arResult["ITEMS"]["DelDelCanBuy"][$key]["PICTURE_ID"] = $arProd[$item["PRODUCT_ID"]];
        }
        foreach($arResult["ITEMS"]["nAnCanBuy"] as $key=>$item){
          if ($arProd[$item["PRODUCT_ID"]])
            $arResult["ITEMS"]["nAnCanBuy"][$key]["PICTURE_ID"] = $arProd[$item["PRODUCT_ID"]];
        }
		
        $arSelect = Array("ID", "DETAIL_PICTURE");
        $arFilter = Array("ID"=>$arPRod, "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while($ob = $res->GetNextElement())
        {

          $arFields = $ob->GetFields();
          if ($arFields["DETAIL_PICTURE"])
            {
                $file = CFile::ResizeImageGet($arFields["DETAIL_PICTURE"], array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
                $arResult["PICTURES"][$arFields["ID"]]   = $file['src'];
            }

        }
    }
}

 //wdebugAr($arResult);

?>