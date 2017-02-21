<?
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Магазины");
if (!isset($_REQUEST['id']))
{
    $rsSections = CIBlockSection::GetList(Array('SORT' => 'ASC'), Array ('IBLOCK_ID' => '64', 'GLOBAL_ACTIVE' => 'Y'));
    $arResult = Array ();
    while ($arSection = $rsSections->fetch())
    {
        $rsItems = CIBlockElement::GetList(Array('SORT' => 'ASC'), Array ('IBLOCK_ID' => '64', 'SECTION_ID' => $arSection['ID'], 'ACTIVE' => 'Y'), false, Array(), Array ('ID', 'IBLOCK_ID', 'NAME', 'PROPERTY_ADDRESS', 'PROPERTY_PHONE', 'PROPERTY_WORK'));
        while ($arItem = $rsItems->fetch())
        {
            $arResult[$arSection['NAME']][] = $arItem;
        }

    }
}
else
{
    $rsItem = CIBlockElement::GetList(Array('SORT' => 'ASC'), Array ('ID' => $_REQUEST['id'], 'ACTIVE' => 'Y'), false, Array(), Array ('ID', 'IBLOCK_ID', 'NAME', 'PROPERTY_ADDRESS', 'PROPERTY_PHONE', 'PROPERTY_WORK'));
    if (!$arResult = $rsItem->fetch())
            die('Error 404');
}
?>
<? if (!isset($_REQUEST['id'])): ?>
<div class="shops">
<? foreach ($arResult as $key => $arItems): ?>
    <div class="item">
        <div class="title"><?=$key?></div>
        <ul>
        <? foreach ($arItems as $arItem): ?>
            <li><a href="/app/shops/?id=<?=$arItem['ID']?>"><?=$arItem['NAME']?> <span><?=$arItem['PROPERTY_ADDRESS_VALUE']?></span></a></li>
        <? endforeach; ?>
        </ul>
    </div>
<? endforeach; ?>
</div>
<? else: ?>
<div class="shop">
    <div class="title"><?=$arResult['NAME']?></div>
    <div class="info">
        <?=$arResult['PROPERTY_ADDRESS_VALUE']?><br/>
        <?=$arResult['PROPERTY_PHONE_VALUE']?><br/>
        <?=$arResult['PROPERTY_WORK_VALUE']?><br/>
    </div>
    <a href="tel:<?=$arResult['PROPERTY_PHONE_VALUE']?>" class="call"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/ico_phone.svg" width="20"/> Позвонить</a>
</div>
<? endif; ?>

<pre>
<? //print_r($arResult) ?>
</pre>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>