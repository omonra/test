<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
/*CModule::IncludeModule("sale");
global $USER;
	if($USER->isAdmin()){
		echo "<pre>",print_r($arResult,1),"</pre>";
		//$res=CSaleOrder::GetList(array(),array("USER_ID" => $USER->GetID(),"ID"=>3333));
		//while($ar_res=$res->GetNext())
	}*/
?>
<div class="orders_block">
    <h1>Ваши заказы</h1>

<form method="GET" action="<?= $arResult["CURRENT_PAGE"] ?>" name="bfilter">
    <div class="orders_filter">
        <ul class="items">
            <li class="item item_1">
                <div class="l">Код заказа</div>
                <input class="text_input text_input_1" type="text" name="filter_id" value="<?=htmlspecialchars($_REQUEST["filter_id"])?>">
            </li>
            <li class="item item_2">
                <div class="l">Статус</div>
                <select name="filter_status">
                    <option value=""><?=GetMessage("SPOL_T_F_ALL")?></option>
                    <?
                    foreach($arResult["INFO"]["STATUS"] as $val)
                    {
                        if ($val["ID"]!="F")
                        {
                            ?><option value="<?echo $val["ID"]?>"<?if($_REQUEST["filter_status"]==$val["ID"]) echo " selected"?>>[<?=$val["ID"]?>] <?=$val["NAME"]?></option><?
                        }
                    }
                    ?>
                </select>
            </li>
            <li class="item item_3">
                <div class="l">Дата</div>
                <?$APPLICATION->IncludeComponent(
                "bitrix:main.calendar",
                "",
                Array(
                    "SHOW_INPUT" => "Y",
                    "FORM_NAME" => "bfilter",
                    "INPUT_NAME" => "filter_date_from",
                    "INPUT_NAME_FINISH" => "filter_date_to",
                    "INPUT_VALUE" => $_REQUEST["filter_date_from"],
                    "INPUT_VALUE_FINISH" => $_REQUEST["filter_date_to"],
                    "SHOW_TIME" => "N"
                )
            );?>
            </li>
            <li class="item item_4">
                <div class="l">Оплачен</div>
                <select name="filter_payed">
                    <option value=""><?echo GetMessage("SPOL_T_F_ALL")?></option>
                    <option value="Y"<?if ($_REQUEST["filter_payed"]=="Y") echo " selected"?>><?=GetMessage("SPOL_T_YES")?></option>
                    <option value="N"<?if ($_REQUEST["filter_payed"]=="N") echo " selected"?>><?=GetMessage("SPOL_T_NO")?></option>
                </select>
            </li>
            <li class="item item_5">
                <div class="l">Отменен</div>
                <select name="filter_canceled">
                    <option value=""><?=GetMessage("SPOL_T_F_ALL")?></option>
                    <option value="Y"<?if ($_REQUEST["filter_canceled"]=="Y") echo " selected"?>><?=GetMessage("SPOL_T_YES")?></option>
                    <option value="N"<?if ($_REQUEST["filter_canceled"]=="N") echo " selected"?>><?=GetMessage("SPOL_T_NO")?></option>
                </select>
            </li>
            <li class="item item_6">
                <div class="l">В том числе доставленные</div>
                <select name="filter_history">
                    <option value="N"<?if($_REQUEST["filter_history"]=="N") echo " selected"?>><?=GetMessage("SPOL_T_NO")?></option>
                    <option value="Y"<?if($_REQUEST["filter_history"]=="Y") echo " selected"?>><?=GetMessage("SPOL_T_YES")?></option>
                </select>
            </li>
        </ul>
        <ul class="options">
            <li class="submit"><input type="submit" class="button button_1"  name="filter" value="Применить фильтр"></li>
            <li class="reset"><input type="submit" class="button button_1 button_1_1" name="del_filter" value="Сбросить"></li>
        </ul>
    </div>
</form>

<?if(strlen($arResult["NAV_STRING"]) > 0):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>
<?if(count($arResult["ORDERS"])>0):?>
<div class="order_table">

<table>
    <thead>
	<tr>
		<th><?=GetMessage("SPOL_T_ID")?><br /><?=SortingEx("ID")?></th>
		<th><?=GetMessage("SPOL_T_PRICE")?><br /><?=SortingEx("PRICE")?></th>
		<th><?=GetMessage("SPOL_T_STATUS")?><br /><?=SortingEx("STATUS_ID")?></th>
		<th><?=GetMessage("SPOL_T_BASKET")?><br /></th>
		<th><?=GetMessage("SPOL_T_PAYED")?><br /><?=SortingEx("PAYED")?></th>
		<th><?=GetMessage("SPOL_T_CANCELED")?><br /><?=SortingEx("CANCELED")?></th>
		<th><?=GetMessage("SPOL_T_PAY_SYS")?><br /></th>
		<th><?=GetMessage("SPOL_T_ACTION")?></th>
	</tr>
    <tbody>
	<?foreach($arResult["ORDERS"] as $val):?>
		<tr>
			<td class="first code">
                <div class="code_number"><?=$val["ORDER"]["ID"]?></div>
                <div><?=$val["ORDER"]["DATE_INSERT_FORMAT"]?></div>
            </td>
			<td class="price"><?=$val["ORDER"]["FORMATED_PRICE"]?></td>
			<td<?
				if($val["ORDER"]['CANCELED']=="Y")echo " style='text-decoration: line-through;'";
			?>><?=$arResult["INFO"]["STATUS"][$val["ORDER"]["STATUS_ID"]]["NAME"]?><br /><?=$val["ORDER"]["DATE_STATUS"]?></td>
			<td class="items"><ul><?
				$bNeedComa = False;
				foreach($val["BASKET_ITEMS"] as $vval)
				{
					?><li><?
					if (strlen($vval["DETAIL_PAGE_URL"])>0)
						echo '<a href="'.$vval["DETAIL_PAGE_URL"].'">';
					echo $vval["NAME"];
					if (strlen($vval["DETAIL_PAGE_URL"])>0)
						echo '</a>';
						echo ' / <span class="count">'.$vval["QUANTITY"].' '.GetMessage("STPOL_SHT").'</span>';
					?></li><?
				}
			?></ul></td>
			<td class="pay_status"><?=(($val["ORDER"]["PAYED"]=="Y") ? GetMessage("SPOL_T_YES") : GetMessage("SPOL_T_NO"))?></td>
			<td class="pay_status"><?=(($val["ORDER"]["CANCELED"]=="Y") ? GetMessage("SPOL_T_YES") : GetMessage("SPOL_T_NO"))?>
			<?
				$res=CSaleOrder::GetList(array(),array("USER_ID" => $USER->GetID(),"ID"=>$val["ORDER"]['ID']));
				if($ar_res=$res->GetNext()){
					if(!empty($ar_res['REASON_CANCELED']))echo "<span style='font-size: 12px; font-weight: normal;color:grey;'>причина: ".$ar_res['REASON_CANCELED'].'</span>';
				}
			?>
			</td>
			<td class="pay_delivery">
				<?=$arResult["INFO"]["PAY_SYSTEM"][$val["ORDER"]["PAY_SYSTEM_ID"]]["NAME"]?> /
				<?if (strpos($val["ORDER"]["DELIVERY_ID"], ":") === false):?>
					<?=$arResult["INFO"]["DELIVERY"][$val["ORDER"]["DELIVERY_ID"]]["NAME"]?>
				<?else:
					$arId = explode(":", $val["ORDER"]["DELIVERY_ID"]);
				?>
					<?=$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["NAME"]?> (<?=$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["PROFILES"][$arId[1]]["TITLE"]?>)
				<?endif?>
			</td>
			<td class="action"><a title="<?=GetMessage("SPOL_T_DETAIL_DESCR")?>" href="<?=$val["ORDER"]["URL_TO_DETAIL"]?>"><?=GetMessage("SPOL_T_DETAIL")?></a><br />
				<a title="<?=GetMessage("SPOL_T_COPY_ORDER_DESCR")?>" href="<?=$val["ORDER"]["URL_TO_COPY"]?>"><?=GetMessage("SPOL_T_COPY_ORDER")?></a><br />
                <?if($val["ORDER"]["CAN_CANCEL"] == "Y"):?>
                    <a title="<?=GetMessage("SPOL_T_DELETE_DESCR")?>" href="<?=$val["ORDER"]["URL_TO_CANCEL"]?>"><?=GetMessage("SPOL_T_DELETE")?></a>
                <?endif;?>
                <?if($val["ORDER"]["STATUS_ID"]=="O"):?>
                    <?
                    if ($val["ORDER"]["PAY_SYSTEM"]["PSA_NEW_WINDOW"] == "Y")
                    {
                        ?>
                        <a href="<?=$val["ORDER"]["PAY_SYSTEM"]["PSA_ACTION_FILE"]?>" target="_blank">Оплатить</a>
                    <?
                    }
                    else
                    {
                        $ORDER_ID = $val["ORDER"]["ID"];
                        include($val["ORDER"]["PAY_SYSTEM"]["PSA_ACTION_FILE"]);
                    }
                    ?>
                <?endif;?>
			</td>
		</tr>
	<?endforeach;?>
    </tbody>
</table>
</div>
<?else:?>
    <p>Не найдено ни одного заказа соответствующего установленным параметрам отбора. Измените параметры и повторите отбор</p>
<?endif;?>
    </div>
<?if(strlen($arResult["NAV_STRING"]) > 0):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>
