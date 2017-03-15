<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (is_array($arResult['PICTURE']) && $arResult['PICTURE']['WIDTH'] > 0):?>
    <li class='item'>
        <?if (strlen($arResult['URL']) > 0):
            ?><a href="<?=$arResult['URL']?>" title="<?=$arResult['NAME']?>" target="_blank"><?
        endif;?><img src="<?=$arResult['PICTURE']['SRC']?>" width="<?=$arResult['PICTURE']['WIDTH']?>" height="<?=$arResult['PICTURE']['HEIGHT']?>" alt="<?=$arResult['NAME']?>" /><?
        if (strlen($arResult['URL']) > 0):
            ?></a><?
        endif;?>
    </li>
<?endif;?>
