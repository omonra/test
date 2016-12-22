<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?foreach($arResult as $key => $item):?>
    <a href="<?=$item["LINK"]?>"<?if($item["SELECTED"]):?> class="active"<?endif;?>><?=$item["TEXT"]?></a>
<?endforeach;?>
