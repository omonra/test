<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixBasketComponent $component */

$curPage = $APPLICATION->GetCurPage().'?'.$arParams["ACTION_VARIABLE"].'=';
$arUrls = array(
	"delete" => $curPage."delete&id=#ID#",
	"delay" => $curPage."delay&id=#ID#",
	"add" => $curPage."add&id=#ID#",
);
unset($curPage);

$arBasketJSParams = array(
	'SALE_DELETE' => GetMessage("SALE_DELETE"),
	'SALE_DELAY' => GetMessage("SALE_DELAY"),
	'SALE_TYPE' => GetMessage("SALE_TYPE"),
	'TEMPLATE_FOLDER' => $templateFolder,
	'DELETE_URL' => $arUrls["delete"],
	'DELAY_URL' => $arUrls["delay"],
	'ADD_URL' => $arUrls["add"],
	'EVENT_ONCHANGE_ON_START' => (!empty($arResult['EVENT_ONCHANGE_ON_START']) && $arResult['EVENT_ONCHANGE_ON_START'] === 'Y') ? 'Y' : 'N'
);
?>
<script type="text/javascript">
	var basketJSParams = <?=CUtil::PhpToJSObject($arBasketJSParams);?>
</script>

<?
$APPLICATION->AddHeadScript($templateFolder."/script.js");
?>

<? if (count($arResult['ITEMS']['AnDelCanBuy']) > 0): ?>
<div class="can-buy">
    <div class="sum">Итого товаров на сумму: <?=$arResult['allSum_FORMATED']?></div>
    <table width="100%">
        <tr>
            <td width="50%"><a href="tel:88005006964" class="call"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_phone.svg" width="20"/> Позвонить</a></td>
            <td width="50%"><a href="/app/personal/order/" class="btn-orange">Оформить заказ</a></td>
        </tr>
    </table>
</div>
<? endif; ?>

<div class="basket">
<? if (count($arResult['ITEMS']['AnDelCanBuy']) > 0): ?>
    <? foreach ($arResult['ITEMS']['AnDelCanBuy'] as $arItem): ?> 
    <?
    $rsPropsSku = CIBlockElement::GetProperty(5, $arItem['PRODUCT_ID'], array("sort" => "asc"), Array());
    $arProps = Array ();
    while ($arProp = $rsPropsSku->fetch())
        $arProps[$arProp['CODE']] = $arProp;
    
    if (!empty($arProps['CML2_LINK']['VALUE']))
        $arProduct = CIBlockElement::GetByID($arProps['CML2_LINK']['VALUE'])->fetch();
    
    //echo "<pre>";
    //print_r($arProps);
    //echo "</pre>";
    ?>
    <div class="item">
        <a href="/app/catalog/?ELEMENT_ID=<?=$arProps['CML2_LINK']['VALUE']?>" class="image" style="background-image: url('<?=$arItem['DETAIL_PICTURE_SRC']?>')"></a>
        <a href="/app/catalog/?ELEMENT_ID=<?=$arProps['CML2_LINK']['VALUE']?>" class="title"><?=$arProduct['NAME']?></a>
        <div class="sku-props"><?=$arProps['SIZE']['VALUE']?>, <?=$arProps['COLOR']['VALUE']?></div>
        <div class="price"><?=$arItem['FULL_PRICE_FORMATED']?> x <?=$arItem['QUANTITY']?> шт.</div>
        <a href="/app/personal/cart/?basketAction=delete&id=<?=$arItem['ID']?>" class="delete"><img src="<?=SITE_TEMPLATE_PATH?>/images/ico_delete.png" /></a>
    </div>
    <? endforeach; ?>
<? else: ?>
    <div class="empty">
        Ваша корзина пуста. Перейдите в каталог и выберите нужные товары.
    </div>
    <a href="/app/catalog/" class="btn-orange">Перейти в каталог</a>
<? endif; ?>

</div>
<pre><? //print_r($arResult)?></pre>