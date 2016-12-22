<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (is_array($arResult['PAY_SYSTEM']) && count($arResult['PAY_SYSTEM']) > 0):?>
    <li>
        <label>Способы оплаты</label>
        <span class="b-radio-group">
            <?foreach ($arResult['PAY_SYSTEM'] as $key => $paySystem):?>
                <label><input type="radio" name="PAY_SYSTEM_ID" value="<?=$paySystem['ID']?>"<?=($paySystem["CHECKED"] == "Y" ? ' checked="checked"' : '')?> /> <?=$paySystem['NAME']?></label>
            <?endforeach;?>
        </span>
    </li>
<?endif;?>
