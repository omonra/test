<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(!$arResult["NavShowAlways"])
{
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
        return;
}
?>
<div class="cat_count">
    <?/*<span class="count"><strong><?=$arResult["NavRecordCount"]?></strong> товаров</span> /*/?>
    <?if ($arResult["NavShowAll"]):?>
    <a href="<?=$APPLICATION->GetCurPageParam("SHOWALL_".$arResult["NavNum"]."=0", array("SHOWALL_".$arResult["NavNum"]))?>">по странично</a>
    <?else:?>
    <a href="<?=$APPLICATION->GetCurPageParam("SHOWALL_".$arResult["NavNum"]."=1", array("SHOWALL_".$arResult["NavNum"]))?>">все</a>
    <?endif;?>
</div>
<?
if($arResult["NavPageCount"]>1){
    $start=$arResult["NavPageNomer"]-2;
    if($start<1) $start=1;
    $end=$arResult["NavPageNomer"]+2;
    if($end>$arResult["NavPageCount"]) $end=$arResult["NavPageCount"];
    $strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
    $strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
    ?><ul><?
    if($start>1):
        ?><li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>">1</a></li><?
        ?><li>...</li><?
    endif;
    for($i=$start;$i<=$end;$i++){
        if($arResult["NavPageNomer"]==$i):
            ?><li class="active"><?=$i?></li><?
        else:
            ?><li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$i?>"><?=$i?></a></li><?
        endif;?>
        <?
    }
    if($end<$arResult["NavPageCount"]):
        ?><li>...</li><?
        ?><li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"]?></a></li><?
    endif;
    ?>
</ul>
<?}?>