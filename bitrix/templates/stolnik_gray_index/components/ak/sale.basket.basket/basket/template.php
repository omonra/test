<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
/*if(CUSER::isAdmin()){
	function sortbyprice($arr){
		for($i=0;$i<sizeof($arr);$i++){
			for($j=0;$j<sizeof($arr);$j++){
				if($arr[$i]["PRICE"] < $arr[$j]["PRICE"]){
					$tmp=$arr[$j];
					$arr[$j] = $arr[$i];
					$arr[$i] = $tmp;
				}
			}
		}
		return $arr;
	}
			echo "<pre>",print_r($arResult,1),"</pre>";
	$ID = array();
	foreach($arResult["ITEMS"]['AnDelCanBuy'] as $arElement){
		$ID[]=$arElement['PRODUCT_ID'];
		$BASKET_ID[$arElement['PRODUCT_ID']]=$arElement["ID"];
	}
	if(!empty($ID)){
		$res=CIBlockElement::GetList(array(),array("IBLOCK_ID"=>'5',"ID"=>$ID),false,false,array("ID","PROPERTY_CML2_LINK"));
		while($ar_res=$res->GetNext()){
			$ID_EL[]=$ar_res["PROPERTY_CML2_LINK_VALUE"];
			$ID_SKU[$ar_res["PROPERTY_CML2_LINK_VALUE"]]=$ar_res['ID'];
		}
		if(!empty($ID_EL)){
			$DISC_EL = array();
			$res=CIBlockElement::GetList(array(),array("IBLOCK_ID"=>'4',"ID"=>$ID_EL),false,false,array("ID","PROPERTY_DISC50","PROPERTY_PRICE"));
			$i=0;
			while($ar_res=$res->GetNext()){
				
				if($ar_res['PROPERTY_DISC50_VALUE']=='Y'){
					$DISC_EL[$i]["PRICE"] = $ar_res["PROPERTY_PRICE_VALUE"];
					$DISC_EL[$i]["ID"] = $ar_res["ID"];
					$i++;
				}
			}
			$DISC_EL=sortbyprice($DISC_EL);
			
		}
		$BASKET_ID_DISC=array();
		for($i=0; $i < floor(sizeof($DISC_EL)/2); $i++){
			//	echo "<pre>",print_r($DISC_EL[$i],1),"</pre>";
			$BASKET_ID_DISC[$i]["ID"]=$BASKET_ID[$ID_SKU[$DISC_EL[$i]["ID"]]];
			if($i < floor(sizeof($DISC_EL)/2)){
				$BASKET_ID_DISC[$i]["PRICE"]=$DISC_EL[$i]["PRICE"]/2;
			}
			else{
				$BASKET_ID_DISC[$i]["PRICE"]=$DISC_EL[$i]["PRICE"];
			}
		}
		foreach($BASKET_ID_DISC as $v){
			$arFields = array(
			   "QUANTITY" => 2,
			   "PRICE" => "Y"
			);
			CSaleBasket::Update($v, array arFields);
		}
		echo "<pre>",print_r($BASKET_ID_DISC,1),"</pre>";
	}
}*/
if (StrLen($arResult["ERROR_MESSAGE"])<=0)
{
    ?>
    <div class="basket_block_page">
        <h1>Ваша корзина</h1>
    <?
	if(is_array($arResult["WARNING_MESSAGE"]) && !empty($arResult["WARNING_MESSAGE"]))
	{
		foreach($arResult["WARNING_MESSAGE"] as $v)
		{
			echo ShowError($v);
		}
	}
	
	?>

	<form method="post" action="<?=POST_FORM_ACTION_URI?>" id="basket_form" name="basket_form">
		<?
		if ($arResult["ShowReady"]=="Y")
		{
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
		}

		if ($arResult["ShowDelay"]=="Y")
		{
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_delay.php");
		}

		if ($arResult["ShowNotAvail"]=="Y")
		{
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_notavail.php");
		}
		?>
	</form>
    </div>
	<?
}
else
	ShowError($arResult["ERROR_MESSAGE"]);
?>