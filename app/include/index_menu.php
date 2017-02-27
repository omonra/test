<?php

$arNavigations = Array ();
$rsSections = CIBlockSection::GetList(Array('SORT'=>'ASC'), Array ('IBLOCK_ID' => IBLOCK_MOBILE_NAVIGATION, 'GLOBAL_ACTIVE'=>'Y'), false, Array ('ID', 'IBLOCK_ID', 'NAME', 'PICTURE', 'UF_CATEGORY'));
while ($arSection = $rsSections->fetch())
{
    $rsItems = CIBlockElement::GetList(Array("SORT"=>"ASC"),
            Array ("ACTIVE"=>"Y", "IBLOCK_ID" => IBLOCK_MOBILE_NAVIGATION, 'SECTION_ID' => $arSection['ID']),
            Array("NAME", 'IBLOCK_ID', 'ID', 'PROPERTY_LINK', 'PROPERTY_COLOR'));
    
    while ($arItem = $rsItems->fetch())
    {
        $arSection['ITEMS'][] = $arItem;
    }
    
    if (!empty($arSection['UF_CATEGORY']))
    {
        
    }
    
    $arNavigations[] = $arSection;
}
?>
<div class="index-menu">
    <? foreach ($arNavigations as $arNav): ?>
    <div class="item">
        <a href="/app/catalog/?parent_id=<?=$arNav['UF_CATEGORY']?>" style="background-image: url('<?=CFile::GetPath($arNav['PICTURE'])?>')"><span><?=$arNav['NAME']?></span></a>
        <div class="items">
        <? foreach($arNav['ITEMS'] as $arItem): ?>
            <a <?if(!empty($arItem['PROPERTY_COLOR_VALUE'])):?>style="color:<?=$arItem['PROPERTY_COLOR_VALUE']?>"<?endif;?> href="<?=$arItem['PROPERTY_LINK_VALUE']?>"><?=$arItem['NAME']?></a>
        <? endforeach; ?>
        </div>
    </div>
    <? endforeach; ?>
</div>
<script>
$("body").on('click', ".index-menu .item > a", function (event) {
    var items = $(this).parent().find('.items');
    if (items.find(">a").length > 0)
    {
        event.preventDefault();
        var offsetTop = $(this).offset().top;
        
        items.slideDown('slow', function () {
            
            var body = $("html, body");
            body.stop().animate({scrollTop:offsetTop}, '500', 'swing');
        });
        
        return false;
    }
});
</script>