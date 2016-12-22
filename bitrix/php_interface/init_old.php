<?
function pre($array)
{
    return '<pre>'.print_r($array,true).'</pre>';
}

function pr($obj,$mode=1)
{
	if($mode)
	{
		global $USER;
		if($USER->IsAdmin()||$mode==2||($mode==3&&$_COOKIE["pr"]=="Y"))
		{
			echo "<pre>";
			print_r($obj);
			echo "</pre>";
		}
	}
}

function wdebug($what)
{
    $f=fopen($_SERVER["DOCUMENT_ROOT"].'/debug.html',"a+t");
    if($f){
        fwrite($f,$what.'<br/><br/>');
        fclose($f);
    }
}

function wdebugAr($what)
{
    $what = pre($what);
    $f=fopen($_SERVER["DOCUMENT_ROOT"].'/debug.html',"a+t");
    if($f){
        fwrite($f,$what.'<br/><br/>');
        fclose($f);
    }
}

function wdebugClear()
{
    $f=fopen($_SERVER["DOCUMENT_ROOT"].'/debug.html',"w");
    if($f){
        fwrite($f,"");
        fclose($f);
    }
}

AddEventHandler("sale", "OnOrderStatusSendEmail", "OnSaleStatusOrder_mail"); 

function OnSaleStatusOrder_mail($ID, &$eventName, &$arFields, $val)
{
    if ($val=="O")
    {
        $arOrder = CSaleOrder::GetByID($arFields["ORDER_ID"]);
        if ($arOrder["PAY_SYSTEM_ID"]==8)
            $arFields["TEXT"] = "Для оплаты заказа перейдите по ссылке: https://rbkmoney.ru/acceptpurchase.aspx?eShopId=2016418&recipientAmount=".$arOrder["PRICE"]."&recipientCurrency=RUB&orderId=".$arFields["ORDER_ID"];
    }
}

AddEventHandler("sale", "OnSaleComponentOrderOneStepFinal", "ModifDeliveryAddress");

function ModifDeliveryAddress($ID, $arOrder)
{
    $db_props = CSaleOrderPropsValue::GetOrderProps($ID);
    while ($arProps = $db_props->Fetch())
    {
        $arOrderProps[$arProps["CODE"]] = $arProps["VALUE"];
    }
    $arDeliv = CSaleDelivery::GetByID($arOrder["DELIVERY_ID"]);
    $arPaySys = CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"]);
    $arFields = array(
       "ORDER_ID" => $ID,
       "ORDER_PROPS_ID" => 24,
       "NAME" => "Фактический адрес доставки",
       "CODE" => "FACT_ADDRESS",
       "VALUE" => $arOrderProps["CITY"].", ул. ".$arOrderProps["STREET"].", дом ".$arOrderProps["HOUSE"].", кв. ".$arOrderProps["KW"].", индекс ".$arOrderProps["ZIP"].", доставка: ".$arDeliv["NAME"].", оплата: ".$arPaySys["NAME"]
    );

    CSaleOrderPropsValue::Add($arFields);
}


/*Version 0.3 2011-04-25*/


function CheckURL($check)
{
    if (!$check) return false;
    if (strpos($check, "href=")!==false):
        return true;
    elseif (strpos($check, "<a")!==false):
        return true;
    else:
        return false;
    endif;
}

AddEventHandler("iblock", "OnBeforeIBlockElementAdd", "DoIBlockBeforeSave");
function DoIBlockBeforeSave($arFields)
{
    if($arFields["IBLOCK_ID"]==11)
    {
        if (CheckURL($arFields["DETAIL_TEXT"]))
        {
            global $APPLICATION;
            $APPLICATION->throwException("Запрещено вставлять ссылки в комментарий");
            return false;
        }
    }
}



AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "DoIBlockAfterSave");
AddEventHandler("iblock", "OnAfterIBlockElementAdd", "DoIBlockAfterSave");
AddEventHandler("catalog", "OnPriceAdd", "DoIBlockAfterSave");
AddEventHandler("catalog", "OnPriceUpdate", "DoIBlockAfterSave");
function DoIBlockAfterSave($arg1, $arg2 = false)
{
	$ELEMENT_ID = false;
	$IBLOCK_ID = false;
	$OFFERS_IBLOCK_ID = false;
	$OFFERS_PROPERTY_ID = false;
	if (CModule::IncludeModule('currency'))
		$strDefaultCurrency = CCurrency::GetBaseCurrency();
	
	//Check for catalog event
	if(is_array($arg2) && $arg2["PRODUCT_ID"] > 0)
	{
		//Get iblock element
		$rsPriceElement = CIBlockElement::GetList(
			array(),
			array(
				"ID" => $arg2["PRODUCT_ID"],
			),
			false,
			false,
			array("ID", "IBLOCK_ID")
		);
		if($arPriceElement = $rsPriceElement->Fetch())
		{
			$arCatalog = CCatalog::GetByID($arPriceElement["IBLOCK_ID"]);
			if(is_array($arCatalog))
			{
				//Check if it is offers iblock
				if($arCatalog["OFFERS"] == "Y")
				{
					//Find product element
					$rsElement = CIBlockElement::GetProperty(
						$arPriceElement["IBLOCK_ID"],
						$arPriceElement["ID"],
						"sort",
						"asc",
						array("ID" => $arCatalog["SKU_PROPERTY_ID"])
					);
					$arElement = $rsElement->Fetch();
					if($arElement && $arElement["VALUE"] > 0)
					{
						$ELEMENT_ID = $arElement["VALUE"];
						$IBLOCK_ID = $arCatalog["PRODUCT_IBLOCK_ID"];
						$OFFERS_IBLOCK_ID = $arCatalog["IBLOCK_ID"];
						$OFFERS_PROPERTY_ID = $arCatalog["SKU_PROPERTY_ID"];
					}
				}
				//or iblock which has offers
				elseif($arCatalog["OFFERS_IBLOCK_ID"] > 0)
				{
					$ELEMENT_ID = $arPriceElement["ID"];
					$IBLOCK_ID = $arPriceElement["IBLOCK_ID"];
					$OFFERS_IBLOCK_ID = $arCatalog["OFFERS_IBLOCK_ID"];
					$OFFERS_PROPERTY_ID = $arCatalog["OFFERS_PROPERTY_ID"];
				}
				//or it's regular catalog
				else
				{
					$ELEMENT_ID = $arPriceElement["ID"];
					$IBLOCK_ID = $arPriceElement["IBLOCK_ID"];
					$OFFERS_IBLOCK_ID = false;
					$OFFERS_PROPERTY_ID = false;
				}
			}
		}
	}
	//Check for iblock event
	elseif(is_array($arg1) && $arg1["ID"] > 0 && $arg1["IBLOCK_ID"] > 0)
	{
		//Check if iblock has offers
		$arOffers = CIBlockPriceTools::GetOffersIBlock($arg1["IBLOCK_ID"]);
		if(is_array($arOffers))
		{
			$ELEMENT_ID = $arg1["ID"];
			$IBLOCK_ID = $arg1["IBLOCK_ID"];
			$OFFERS_IBLOCK_ID = $arOffers["OFFERS_IBLOCK_ID"];
			$OFFERS_PROPERTY_ID = $arOffers["OFFERS_PROPERTY_ID"];
		}
	}

	if($ELEMENT_ID)
	{
		static $arPropCache = array();
		if(!array_key_exists($IBLOCK_ID, $arPropCache))
		{
			//Check for MINIMAL_PRICE property
			$rsProperty = CIBlockProperty::GetByID("MINIMUM_PRICE", $IBLOCK_ID);
			$arProperty = $rsProperty->Fetch();
			if($arProperty)
				$arPropCache[$IBLOCK_ID] = $arProperty["ID"];
			else
				$arPropCache[$IBLOCK_ID] = false;
		}

		if($arPropCache[$IBLOCK_ID])
		{
			//Compose elements filter
			if($OFFERS_IBLOCK_ID)
			{
				$rsOffers = CIBlockElement::GetList(
					array(),
					array(
						"IBLOCK_ID" => $OFFERS_IBLOCK_ID,
						"PROPERTY_".$OFFERS_PROPERTY_ID => $ELEMENT_ID,
					),
					false,
					false,
					array("ID")
				);
				while($arOffer = $rsOffers->Fetch())
					$arProductID[] = $arOffer["ID"];
					
				if (!is_array($arProductID))
					$arProductID = array($ELEMENT_ID);
			}
			else
				$arProductID = array($ELEMENT_ID);

			$minPrice = false;
			$maxPrice = false;
			//Get prices
			$rsPrices = CPrice::GetList(
				array(),
				array(
                    "BASE" => "Y",
					"PRODUCT_ID" => $arProductID,
				)
			);
			while($arPrice = $rsPrices->Fetch())
			{
				if (CModule::IncludeModule('currency') && $strDefaultCurrency != $arPrice['CURRENCY'])
					$arPrice["PRICE"] = CCurrencyRates::ConvertCurrency($arPrice["PRICE"], $arPrice["CURRENCY"], $strDefaultCurrency);
				
				$PRICE = $arPrice["PRICE"];

				if($minPrice === false || $minPrice > $PRICE)
					$minPrice = $PRICE;

				if($maxPrice === false || $maxPrice < $PRICE)
					$maxPrice = $PRICE;
			}

			//Save found minimal price into property
			if($minPrice !== false)
			{
                CIBlockElement::SetPropertyValuesEx(
                    $ELEMENT_ID,
                    $IBLOCK_ID,
                    array(
                        "PRICE" => $minPrice,
                        "MINIMUM_PRICE" => $minPrice,
                        "MAXIMUM_PRICE" => $maxPrice,
                    )
                );

                /*
                 * ТАНЦИ С БУБНОМ ЗАКАНЧИВАЕМ
                //берем значение цены у товара. и записываем ее в поле "Предыдущая цена"
                $star_price='';
                $db_props= CIBlockElement::GetProperty(4, $ELEMENT_ID, Array("sort"=>"asc"), Array("CODE"=>"PRICE"));
                if($ar_props = $db_props->Fetch())
                {
                    $star_price=$ar_props["VALUE"];
                }
                if(intval($star_price)>0 && intval($star_price)>$minPrice){
                    CIBlockElement::SetPropertyValuesEx(
                        $ELEMENT_ID,
                        $IBLOCK_ID,
                        array(
                            "PRICE" => $minPrice,
                            "MINIMUM_PRICE" => $minPrice,
                            "MAXIMUM_PRICE" => $maxPrice,
                            "BEST"=>"true",
                            "PRICE_OLD"=>$star_price,
                            "PRICE_LAST"=>$star_price,
                        )
                    );
                }else{
                    CIBlockElement::SetPropertyValuesEx(
                        $ELEMENT_ID,
                        $IBLOCK_ID,
                        array(
                            "PRICE" => $minPrice,
                            "MINIMUM_PRICE" => $minPrice,
                            "MAXIMUM_PRICE" => $maxPrice,
                            "BEST"=>"",
                            "PRICE_OLD"=>'',
                            "PRICE_LAST"=>$star_price,
                        )
                    );
                }*/
			}
		}
	}
}

/*AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("DopClassUpd", "OnAfterIBlockElementAddHandler"));
class DopClassUpd
{
    function OnAfterIBlockElementAddHandler(&$arFields){
        if($arFields["IBLOCK_ID"]==4){
            $db_props=$db_props = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields["ID"], Array("sort"=>"asc"), Array("CODE"=>"PRICE"));
            if($ar_props = $db_props->Fetch())
            {
                CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $ar_props["VALUE"], "PRICE_LAST");
            }
        }
    }
}
*/

AddEventHandler("iblock", "OnAfterIBlockSectionAdd", Array("DopClassSec", "OnAfterIBlockSectionAddHandler"));
AddEventHandler("iblock", "OnAfterIBlockSectionUpdate", Array("DopClassSec", "OnAfterIBlockSectionUpdateHandler"));

class DopClassSec
{
    function OnAfterIBlockSectionAddHandler(&$arFields){
        $res = CIBlockSection::GetByID($arFields["ID"]);
        if($ar_res = $res->GetNext()){
            if($arFields["IBLOCK_SECTION_ID"]==284){
                //men
                if(!(strpos($arFields["CODE"],'_men')>0)){
                    $bs = new CIBlockSection;
                    $bs->Update($arFields["ID"], array("CODE"=>$arFields["CODE"].'_men'));
                }
            }
            if($arFields["IBLOCK_SECTION_ID"]==314){
                //women
                if(!(strpos($arFields["CODE"],'_women')>0)){
                    $bs = new CIBlockSection;
                    $bs->Update($arFields["ID"], array("CODE"=>$arFields["CODE"].'_women'));
                }
            }
        }
    }

    function OnAfterIBlockSectionUpdateHandler(&$arFields){
        $res = CIBlockSection::GetByID($arFields["ID"]);
        if($ar_res = $res->GetNext()){
            if($arFields["IBLOCK_SECTION_ID"]==284){
                //men
                if(!(strpos($arFields["CODE"],'_men')>0)){
                    $bs = new CIBlockSection;
                    $bs->Update($arFields["ID"], array("CODE"=>$arFields["CODE"].'_men'));
                }
            }
            if($arFields["IBLOCK_SECTION_ID"]==314){
                //women
                if(!(strpos($arFields["CODE"],'_women')>0)){
                    $bs = new CIBlockSection;
                    $bs->Update($arFields["ID"], array("CODE"=>$arFields["CODE"].'_women'));
                }
            }
        }
    }
}

AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("DopClass", "OnAfterIBlockElementAddHandler"));

AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("DopClass", "OnAfterIBlockElementUpdateHandler"));

class DopClass
{
    function OnAfterIBlockElementAddHandler(&$arFields){
        if($arFields["IBLOCK_ID"]==5){
            $VALUES = array();
            $res = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields["ID"], "sort", "asc", array("CODE" => "CML2_ATTRIBUTES"));
            while ($ob = $res->GetNext())
            {
                $VALUES[] = $ob;
            }
            foreach($VALUES as $item){
                if($item["DESCRIPTION"]=="Цвет"){
                    CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $item["VALUE"], "COLOR");
                    //поиск среди списков
                    $arFilter = Array(
                        "IBLOCK_ID"=>10,
                        "ACTIVE"=>"Y",
                        array(
                            "LOGIC"=>"OR",
                            "NAME"=>$item["VALUE"],
                            "PROPERTY_ITEM_COLOR_LIST"=>$item["VALUE"],
                        ),
                    );
                    $res = CIBlockElement::GetList(Array(), $arFilter);
                    if($ar_fields = $res->GetNext())
                    {
                        CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $ar_fields["NAME"], "item_color_list");
                    }
                }
                if($item["DESCRIPTION"]=="Размер"){
                    CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $item["VALUE"], "SIZE");
                }
            }
        }
    }

    function OnAfterIBlockElementUpdateHandler(&$arFields){
        if($arFields["IBLOCK_ID"]==5){
            $VALUES = array();
            $res = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields["ID"], "sort", "asc", array("CODE" => "CML2_ATTRIBUTES"));
            while ($ob = $res->GetNext())
            {
                $VALUES[] = $ob;
            }
            foreach($VALUES as $item){
                if($item["DESCRIPTION"]=="Цвет"){
                    CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $item["VALUE"], "COLOR");
                    //поиск среди списков
                    $arFilter = Array(
                        "IBLOCK_ID"=>10,
                        "ACTIVE"=>"Y",
                        array(
                            "LOGIC"=>"OR",
                            "NAME"=>$item["VALUE"],
                            "PROPERTY_ITEM_COLOR_LIST"=>$item["VALUE"],
                        ),
                    );
                    $res = CIBlockElement::GetList(Array(), $arFilter);
                    if($ar_fields = $res->GetNext())
                    {
                        CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $ar_fields["NAME"], "item_color_list");
                    }
                }
                if($item["DESCRIPTION"]=="Размер"){
                    CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $item["VALUE"], "SIZE");
                }
            }
        }
    }
}


/**
 * Скрипт выгрузки падает на этой процедуре. Надо из 1С сразу устанавливать параметр, что позиция неактивна. Им там
 * проще и быстрее это определить. Тогда необходимости в данной процедуре вообще нет. Пока ее отрубаю.
 */

//AddEventHandler("catalog", "OnSuccessCatalogImport1C", "SuccessCatalogImport");
/*AddEventHandler("catalog", "OnSuccessCatalogImport1C", Array("ClassImportCat", "SuccessCatalogImport"));
class ClassImportCat
{
    function SuccessCatalogImport()
    {
        $arOffers = CIBlockPriceTools::GetOffersIBlock(4);

        $handle = fopen($_SERVER["DOCUMENT_ROOT"]."/log_import.txt","a-");

        $log = print_r("-------------- Начало обработки после импорта ".date("Y-m-d H:i:s")." --------------
",1);
        fwrite($handle, $log);

        CModule::IncludeModule("catalog");CModule::IncludeModule("iblock");



        /*--------------------------------------------------------------------------
       *
       *      деактивируем предложения у которых
       *      н*или нет количества* или нет одновременно цвета и размера
       *       *
       * --------------------------------------------------------------------------*/
/*$dbElement = CIBlockElement::GetList(
    array('SORT' => 'ASC'),
    array(
        'IBLOCK_ID'=>5,
        'ACTIVE' => 'Y',
        array(
            'LOGIC'=>"OR",
            //'CATALOG_QUANTITY'=>0,
            'CATALOG_PRICE_14'=>0,
            array(
                'LOGIC'=>"AND",
                'PROPERTY_COLOR'=>false,
                'PROPERTY_SIZE'=>false,
            )
        ),

    ),
    false,
    false,
    array('ID','IBLOCK_ID','ACTIVE','NAME')
);
while($arElement = $dbElement->Fetch()){
    $el = new CIBlockElement;
    $el->Update($arElement["ID"], Array("ACTIVE" => "N"));
    $log = print_r("    Деактивировано предложение ".$arElement["ID"].": нет цены или нет количества или нет одновременно цвета и размера
",1);
    fwrite($handle, $log);
}
$dbElement = CIBlockElement::GetList(
    array('SORT' => 'ASC'),
    array(
        'IBLOCK_ID'=>5,
        'ACTIVE' => 'N',
        //'>CATALOG_QUANTITY'=>0,
        '>CATALOG_PRICE_14'=>0,
        '!PROPERTY_COLOR'=>false,
        '!PROPERTY_SIZE'=>false,
    ),
    false,
    false,
    array('ID','IBLOCK_ID','ACTIVE','NAME')
);
while($arElement = $dbElement->Fetch()){
    $el = new CIBlockElement;
    $el->Update($arElement["ID"], Array("ACTIVE" => "Y"));
    $log = print_r("    Активировано предложение ".$arElement["ID"].": найдена и цена и количество и свойства цвет и разме рустановлены
",1);
    fwrite($handle, $log);
}


//пробегаем по всем элементам и деактивируем те у которых нет картинок.
$dbElement = CIBlockElement::GetList(
    array('SORT' => 'ASC'),
    array(
        'IBLOCK_ID'=>4,
        'ACTIVE' => 'Y',
        array(
            'LOGIC'=>"OR",
            'PROPERTY_DEAKTIVIROVAT_POZITSIYU' => 'true',
            array(
                'PREVIEW_PICTURE'=>false,
                'DETAIL_PICTURE'=>false,
            ),
        ),
    ),
    false,
    false,
    array('ID','IBLOCK_ID','ACTIVE','NAME')
);
while($arElement = $dbElement->Fetch()){
    $el = new CIBlockElement;
    $el->Update($arElement["ID"], Array("ACTIVE" => "N"));
    $log = print_r("    Деактивирован товар ".$arElement["ID"].": нет картинки или установлено в выгрузке
",1);
    fwrite($handle, $log);
}
$dbElement = CIBlockElement::GetList(
    array('SORT' => 'ASC'),
    array(
        'IBLOCK_ID'=>4,
        'ACTIVE' => 'N',
        array(
            'LOGIC'=>'OR',
            array(
                'LOGIC'=>'AND',
                array(
                    'LOGIC'=>'OR',
                    '!PREVIEW_PICTURE'=>false,
                    '!DETAIL_PICTURE'=>false,

                ),
                '!PROPERTY_DEAKTIVIROVAT_POZITSIYU' => 'true',
            ),
            array(
                'LOGIC'=>'AND',
                'PROPERTY_DEAKTIVIROVAT_POZITSIYU' => 'false',
                array(
                    'LOGIC'=>'OR',
                    '!PREVIEW_PICTURE'=>false,
                    '!DETAIL_PICTURE'=>false,

                ),

            ),
        ),

    ),
    false,
    false,
    array('ID','IBLOCK_ID','ACTIVE','NAME')
);
while($arElement = $dbElement->Fetch()){

    $c=0;
    $rsOffers = CIBlockElement::GetList(
        array(),
        array(
            "IBLOCK_ID" => $arOffers["OFFERS_IBLOCK_ID"],
            "PROPERTY_".$arOffers["OFFERS_PROPERTY_ID"] => $arElement["ID"],
            "ACTIVE"=>"Y",
        ),
        false,
        false,
        array("ID")
    );
    while($arOffer = $rsOffers->Fetch())
        $c++;

    if($c>0){
        $el = new CIBlockElement;
        $el->Update($arElement["ID"], Array("ACTIVE" => "Y"));
        $log = print_r("    Активирован товар ".$arElement["ID"].": картинки найдены и в выгрузке установлено активировать и предложения имеются
",1);
        fwrite($handle, $log);
    }
}




//Прбегаем по всем товарам у которых нет активных предложений и деактивируем их
$dbElement = CIBlockElement::GetList(
    array('SORT' => 'ASC'),
    array(
        'IBLOCK_ID'=>4,
    ),
    false,
    false,
    array('ID','IBLOCK_ID','ACTIVE','NAME','DETAIL_PICTURE','PREVIEW_PICTURE','PROPERTY_DEAKTIVIROVAT_POZITSIYU')
);
while($arElement = $dbElement->Fetch()){
    $c=0;
    //$listcolor=array();
    //$listsize=array();
    $rsOffers = CIBlockElement::GetList(
        array(),
        array(
            "IBLOCK_ID" => $arOffers["OFFERS_IBLOCK_ID"],
            "PROPERTY_".$arOffers["OFFERS_PROPERTY_ID"] => $arElement["ID"],
            "ACTIVE"=>"Y",
            '>CATALOG_QUANTITY'=>0,
        ),
        false,
        false,
        array("ID","PROPERTY_COLOR","PROPERTY_SIZE")
    );
    while($arOffer = $rsOffers->Fetch()){
        $c++;
    }
    if($c==0 && $arElement["ACTIVE"]=="Y"){
        $el = new CIBlockElement;
        $el->Update($arElement["ID"], Array("ACTIVE" => "N"));
        $log = print_r("    Деактивирован товар ".$arElement["ID"].": нет предложений
",1);
        fwrite($handle, $log);
    }
}

$log = print_r("-------------- Окончание обработки после импорта ".date("Y-m-d H:i:s")." --------------


",1);
fwrite($handle, $log);
fclose($handle);
}
}*/


function
convertDate($date)
{
    $components = explode (" ", $date, 2);
    $monthes    = array
    (
        'января',
        'февраля',
        'марта',
        'апреля',
        'мая',
        'июня',
        'июля',
        'августа',
        'сентября',
        'октября',
        'ноября',
        'декабря'
    );
    $date = explode ('.', $components[0], 3);
    return ($date[0]." ".$monthes[((int)($date[1])-1)]." ".$date[2]);
    //return (trim($date[0], '0')." ".$monthes[((int)($date[1])-1)]." ".$date[2]);
}
?>