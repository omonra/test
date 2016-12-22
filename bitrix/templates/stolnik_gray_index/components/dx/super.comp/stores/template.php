<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<table class="stores">
    <tr>
        <th>Адрес</th>
        <th>Наличие</th>
        <th>Режим работы</th>
    </tr>
    <?foreach ($arResult['STORES'] as $offerId => $arItems):?>
        <?foreach ($arItems as $key => $arItem):
            if ($arItem['AMOUNT'] <= 0) {
                continue;
            }
            ?>
            <tr data-offer_id="<?=$offerId?>">
                <td><?=$arItem['STORE_ADDR']?></td>
                <td><?=($arItem['AMOUNT'] > 16 ? '<span title="много" class="large"></span>' : ($arItem['AMOUNT'] <= 15 && $arItem['AMOUNT'] >= 6 ? '<span title="средне" class="medium"></span>' : ($arItem['AMOUNT'] <= 5 ? '<span title="мало" class="small"></span>' : '')))?></td>
                <td><?=$arItem['STORE_DESCR']?></td>
            </tr>
        <?endforeach?>
    <?endforeach?>
</table>
