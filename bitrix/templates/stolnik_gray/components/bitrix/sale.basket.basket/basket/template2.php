<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(CUSER::isAdmin()){
	$ID = array();
	foreach($arResult["ITEMS"]['AnDelCanBuy'] as $arElement){
		$ID[]=$arElement['PRODUCT_ID'];
	}
	
		echo "<pre>",print_r($ID,1),"</pre>";
	$res=CIBlockElement::GetList(array(),array("IBLOCK_ID"=>'5',"ID"=>$ID),false,false,array("PROPERTY_CML2_LINK"));
	while($ar_res=$res->GetNext()){
		echo "<pre>",print_r($ar_res,1),"</pre>";
	}
}
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