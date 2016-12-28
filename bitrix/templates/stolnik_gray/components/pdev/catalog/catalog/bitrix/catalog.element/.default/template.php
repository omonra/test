<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if ($_REQUEST['is_ajax'] == "y") $APPLICATION->RestartBuffer();?>
<?
$arColorSize = array();
foreach ($arResult['SIZE_TO_COLORS'] as $size => $oneSize)
{
    foreach ($oneSize as $color => $oneColor)
    {
        $arColorSize[$color]["ID"][] = $oneColor["ID"];
        $arColorSize[$color]["SIZE"][] = $size;
    }
}
?>

<script>
    window.offersList = <?= CUtil::PhpToJSObject($arResult['OFFERS_LIST']) ?>;
    window.currentColor = '<?= $arResult['COLOR_SELECTED'] ?>';
    window.currentSize = '<?= $arResult['SIZE_SELECTED'] ?>';
    window.currentOffer = '<?= $arResult['OFFER_SELECTED'] ?>';
</script>

<? if ($_REQUEST['popup'] == 'y'): ?>
    <? include (__DIR__ . "/popup.php"); ?>
<? else: ?>
    <? include (__DIR__ . "/standart.php"); ?>
<? endif; ?>
<? if ($_REQUEST['is_ajax'] == "y") exit();?>