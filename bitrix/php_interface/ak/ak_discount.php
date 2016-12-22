<?
CModule::IncludeModule('iblock');

function pr_r($arr){
	global $USER;
	if ($USER->IsAdmin()){
					echo "<pre>";print_r($arr); echo "</pre>";
	}
}

function pr_r1($arr){
	global $USER;
	
					echo "<pre>";print_r($arr); echo "</pre>";
	
}

$action = array(CIBlockElement::GetByID(239744)->Fetch(), CIBlockElement::GetByID(233839)->Fetch());


if($action[0]['ACTIVE'] == 'Y' || $action[1]['ACTIVE']=='Y'){
	define('ACTION_ACTIVE', 'Y');
}else{
	define('ACTION_ACTIVE', 'N');
}


if(defined('ACTION_ACTIVE') && ACTION_ACTIVE == 'Y'){
	CModule::IncludeModule('sale');
	CSaleDiscount::Update(1, array('ACTIVE'=>'N'));
}elseif(defined('ACTION_ACTIVE') && ACTION_ACTIVE == 'N'){
	CModule::IncludeModule('sale');
	CSaleDiscount::Update(1, array('ACTIVE'=>'Y'));
}




function sort_by_price_asc($a, $b)
{
    if ($a['PRICE'] == $b['PRICE']) {
        return 0;
    }
    return ($a['PRICE'] > $b['PRICE']) ? -1 : 1;
}

//enableDisableDiscount();





function enableDisableDiscount(){
	
		
			
		
	
		CModule::IncludeModule('sale');
		CModule::IncludeModule('catalog');
		CModule::IncludeModule('iblock');

		
			/*$res = CIBlockElement::GetByID(233839);
		if($ar_res = $res->GetNext())
		 print_r($ar_res);*/
			
		$basket_items = GetCurBasketItems();
		$action_in_basket = 0;
		foreach($basket_items as $item){
			$IB_EL = CCatalogSku::GetProductInfo($item['PRODUCT_ID']);
			
			if(is_array($IB_EL)){
				$ib = CIBlockElement::GetList(array(), array('ID'=>$IB_EL['ID']), false, false, array('ID', 'PROPERTY_AKTSIYA'))->Fetch();
				if($ib['PROPERTY_AKTSIYA_VALUE'] == 'true' ) {
					$action_in_basket++;
				}
			}
			
		}
		
		if($action_in_basket > 0){
			CSaleDiscount::Update(1, array('ACTIVE'=>'N'));
		}else{
			CSaleDiscount::Update(1, array('ACTIVE'=>'Y'));
		}
		
}


function recountPricesDiscount(){
	
	$stop = false;
	
		//echo "<pre>"; print_r($basket_items); echo "</pre>";
		CModule::IncludeModule('sale');
		CModule::IncludeModule('catalog');
		CModule::IncludeModule('iblock');
			
		$basket_items = GetCurBasketItems();
		
		
		//echo "<pre>"; print_r($basket_items); echo "</pre>";
		
		//CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
		//echo "<pre>"; print_r($basket_items); echo "</pre>";
		
		foreach($basket_items as $k=>$arItem){
			
					$IB_EL = CCatalogSku::GetProductInfo($arItem['PRODUCT_ID']);
					if(is_array($IB_EL)){
						$ib = CIBlockElement::GetList(array(), array('ID'=>$IB_EL['ID']), false, false, array('ID', 'PROPERTY_AKTSIYA'))->Fetch();
						
					}
					
			if(trim($ib['PROPERTY_AKTSIYA_VALUE']) == 'true'){
				$iToDelWithAct[] = $arItem;
				CSaleBasket::Delete($arItem['ID']);
				
			}
		}
		
		unset($basket_items);
		$basket_items = $iToDelWithAct;
		
		foreach($basket_items as $l=>&$item){
			
			
			
			$actual = CPrice::GetBasePrice($item['PRODUCT_ID']);	
			$item['PRICE'] = $actual['PRICE'];	
			if($item['QUANTITY'] > 1){
				
				$tmpQ = $item['QUANTITY'];
				//echo "<pre>"; print_r($tmpQ); echo "</pre>";
				//$item['QUANTITY'] = 1;
				for($i = 0; $i < $tmpQ; $i++){
					$tmp_i[] = $item;
				}
				
				//unset($basket_items[$l]);
			}else{
				$tmp_i[] = $item;
			}
		}
		$basket_items = array();
		$basket_items = $tmp_i;
		//echo "<pre>"; print_r($basket_items); echo "</pre>";
		if(count($basket_items) == 1){
			Add2BasketByProductID($basket_items[0]['PRODUCT_ID'], $basket_items['QUANTITY']);
		}else{
			
		usort($basket_items, "sort_by_price_asc");
		//echo "<pre>"; print_r($basket_items); echo "</pre>";
		//echo "<pre>"; print_r($basket_items); echo "</pre>";
		if(count($basket_items) % 2 != 0 && count($basket_items) != 1):
			$extra_first = $basket_items[0];
			unset($basket_items[0]);
			
		
		endif;
		
		if(count($basket_items) > 0 && count($basket_items) != 1){
			
			$half = count($basket_items)/2;
			$second_part = array_slice($basket_items, $half);
			$first_part = array_slice($basket_items, 0, $half);
			
			
			foreach($first_part as $fpart){
				
				$first_part_org[$fpart['PRODUCT_ID']][] = $fpart;
				
				
				
			}
			
			
			
			if(is_array($extra_first) && $extra_first){
				$first_part_org[$extra_first['PRODUCT_ID']][] = $extra_first;
			}
			pr_r($first_part_org);
			//echo "<pre>"; print_r($first_part_org); echo "</pre>";
			foreach ($first_part_org as $fpID => $fp) {
				 
				  //CSaleBasket::Delete($fp[0]['ID']);	
				 
				  $id = Add2BasketByProductID(
									 $fpID,
									 count($fp)
				  );
				  //echo "<pre>"; print_r($id); echo "</pre>";
				 pr_r($id);
			}
			
			
			foreach($second_part as $bItem){
				
				$sec_part_org[$bItem['PRODUCT_ID']][] = $bItem;
				
				
			}
			
			
			pr_r($sec_part_org);
			
			foreach($sec_part_org as $spID=>$sItem){
				$quan = count($sItem);	
				
				//global $USER;
				
					$arSelect = Array("PROPERTY_SIZE_DISCOUNT");
					$arFilter = Array("IBLOCK_ID"=>49, "ACTIVE"=>"Y");
					$res = CIBlockElement::GetList(false, $arFilter, false, false, $arSelect);
					while($ob = $res->GetNextElement())
					{
					  $arFields = $ob->GetFields();				  
					}
					 $discount = $arFields["PROPERTY_SIZE_DISCOUNT_VALUE"];
				
				
					
						$price = $sItem[0]['PRICE']*(100-$discount)/100;
						pr_r($price);
						//echo "<pre>"; print_r($price); echo "</pre>";
						$id = Add2BasketByProductID(
										 $spID,
										 count($sItem),
										 array( 
											'PRODUCT_PROVIDER_CLASS' => false, 
											'CALLBACK_FUNC' => 'CatalogBasketCallback',
											'ORDER_CALLBACK_FUNC' => 'CatalogBasketOrderCallback',
											'CANCEL_CALLBACK_FUNC' => 'CatalogBasketCancelCallback',
											'PAY_CALLBACK_FUNC' => 'CatalogPayOrderCallback',
											'CUSTOM_PRICE' => 'Y',
											'PRICE' => $price),
										 array(array("CODE"=>"AKT","NAME"=>"Скидка по акции на второй товар","VALUE"=>$discount,"SORT"=>500))
										 
											 
					  	);	
						pr_r($id);
						//echo "<pre>"; print_r($id); echo "</pre>";
						
			}
		}
		}
		
}
	
///////

AddEventHandler('sale', 'OnOrderUpdate', 'recountOnOrderUpdate');	
	
	
function recountOnOrderUpdate($ID, $arOrder){
	
	global $APPLICATION;
	if(!CSite::InDir('/bitrix/'))
		return;
	
	
	global $USER;
	
	if(!$USER->IsAdmin()){
		return;
	}
	
	if($_SERVER['REQUEST_METHOD'] != 'POST'):
	
	//die();
	$user_id = $arOrder['USER_ID'];
	
	$stop = false;
	
		//echo "<pre>"; print_r($basket_items); echo "</pre>";
		CModule::IncludeModule('sale');
		CModule::IncludeModule('catalog');
		CModule::IncludeModule('iblock');
			
		$basket_items = GetCurBasketItems($ID);
		
	
		
		foreach($basket_items as $k=>$arItem){
			
					$IB_EL = CCatalogSku::GetProductInfo($arItem['PRODUCT_ID']);
					if(is_array($IB_EL)){
						$ib = CIBlockElement::GetList(array(), array('ID'=>$IB_EL['ID']), false, false, array('ID', 'PROPERTY_AKTSIYA'))->Fetch();
						
					}
					
			if(trim($ib['PROPERTY_AKTSIYA_VALUE']) == 'true'){
				$iToDelWithAct[] = $arItem;
				CSaleBasket::Delete($arItem['ID']);
				
			}
		}
		
		unset($basket_items);
		$basket_items = $iToDelWithAct;
		
		foreach($basket_items as $l=>&$item){
			
			
			
			$actual = CPrice::GetBasePrice($item['PRODUCT_ID']);	
			$item['PRICE'] = $actual['PRICE'];	
			if($item['QUANTITY'] > 1){
				
				$tmpQ = $item['QUANTITY'];
				//echo "<pre>"; print_r($tmpQ); echo "</pre>";
				//$item['QUANTITY'] = 1;
				for($i = 0; $i < $tmpQ; $i++){
					$tmp_i[] = $item;
				}
				
				//unset($basket_items[$l]);
			}else{
				$tmp_i[] = $item;
			}
		}
		$basket_items = array();
		$basket_items = $tmp_i;
		//echo "<pre>"; print_r($basket_items); echo "</pre>";
		if(count($basket_items) == 1){
			
			$arAdd['ORDER_ID'] = $ID;
			$arAdd['LID'] = 's1';
			//$arAdd['FUSER_ID'] = $user_id;
			$idd = Add2BasketByProductID($basket_items[0]['PRODUCT_ID'], $basket_items['QUANTITY'],  $arAdd,  array(array("CODE"=>"NO_ACT","NAME"=>"Первый товар по акции","VALUE"=>"без скидки","SORT"=>500))
			);
			//var_dump($idd);
			$ex = $APPLICATION->GetException();
				  if($ex){
				  	echo $ex->GetString();
					die();
				  }

		}else{
			
		usort($basket_items, "sort_by_price_asc");
		
		if(count($basket_items) % 2 != 0 && count($basket_items) != 1):
			$extra_first = $basket_items[0];
			unset($basket_items[0]);
			
		
		endif;
		
		if(count($basket_items) > 0 && count($basket_items) != 1){
			
			$half = count($basket_items)/2;
			$second_part = array_slice($basket_items, $half);
			$first_part = array_slice($basket_items, 0, $half);
			
			
			foreach($first_part as $fpart){
				
				$first_part_org[$fpart['PRODUCT_ID']][] = $fpart;
				
				
				
			}
			
			
			
			if(is_array($extra_first) && $extra_first){
				$first_part_org[$extra_first['PRODUCT_ID']][] = $extra_first;
			}
			
			
			foreach ($first_part_org as $fpID => $fp) {
				  //CSaleBasket::Delete($fp[0]['ID']);	
				 
				 $arAdd = array();
				 
				 if($ID){
							//$arAdd['FUSER_ID'] = $user_id;
							$arAdd['ORDER_ID'] = $ID;
							$arAdd['LID'] = 's1';
						}
					//echo "<pre>"; print_r($arAdd); echo "</pre>";
				 
				  $id = Add2BasketByProductID(
									 $fpID,
									 count($fp),
									 $arAdd,
									 array(array("CODE"=>"NO_ACT","NAME"=>"Первый товар по акции","VALUE"=>"без скидки","SORT"=>500))
									 
				  );
				//  var_dump($id);
				  $ex = $APPLICATION->GetException();
				  if($ex){
				  	echo $ex->GetString();
					die();
				  }
				
				 
			}
			
			
			foreach($second_part as $bItem){
				
				$sec_part_org[$bItem['PRODUCT_ID']][] = $bItem;
				
				
			}
			
			
			
			foreach($sec_part_org as $spID=>$sItem){
				$quan = count($sItem);	
				
				//global $USER;
				
					$arSelect = Array("PROPERTY_SIZE_DISCOUNT");
					$arFilter = Array("IBLOCK_ID"=>49, "ACTIVE"=>"Y");
					$res = CIBlockElement::GetList(false, $arFilter, false, false, $arSelect);
					while($ob = $res->GetNextElement())
					{
					  $arFields = $ob->GetFields();				  
					}
					 $discount = $arFields["PROPERTY_SIZE_DISCOUNT_VALUE"];
				
				
				

					
						$price = $sItem[0]['PRICE']*(100-$discount)/100;
						//echo "<pre>"; print_r($price); echo "</pre>";
						
						$arAdd =  array('PRICE' => $price, 
										'PRODUCT_PROVIDER_CLASS' => false, 
										'CALLBACK_FUNC' => 'CatalogBasketCallback',
										'ORDER_CALLBACK_FUNC' => 'CatalogBasketOrderCallback',
										'CANCEL_CALLBACK_FUNC' => 'CatalogBasketCancelCallback',
										'PAY_CALLBACK_FUNC' => 'CatalogPayOrderCallback');
						
						if($ID){
							//$arAdd['FUSER_ID'] = $user_id;
							$arAdd['ORDER_ID'] = $ID;
							$arAdd['LID'] = 's1';
						}
							
						
						$id = Add2BasketByProductID(
										 $spID,
										 count($sItem),
										$arAdd,
										 array(array("CODE"=>"AKT","NAME"=>"Скидка по акции на второй товар","VALUE"=>$discount."%","SORT"=>500))
					  	);	
					  	//pr_r($id);
						//var_dump($id);
						
						$ex = $APPLICATION->GetException();
				  if($ex){
				  	echo $ex->GetString();
					die();
				  }
						
					
						
			}
		}
		}
		ENDIF;
}	






?>
