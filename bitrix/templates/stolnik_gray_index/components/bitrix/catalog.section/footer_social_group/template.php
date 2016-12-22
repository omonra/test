<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!isset($arResult['ITEMS']) || !is_array($arResult['ITEMS']) || count($arResult['ITEMS']) <= 0) return;?>

<div class="b-footer__column b-footer__column_big last" style="text-align: center;position: relative;">
    <div style="position: absolute;left: 55%">
        <div style="color: #838383; font-family: Helvetica; font-size: 12px; font-weight: 400; line-height: 20px;margin-bottom: 8px;margin-left: 5px;">Оставайтесь с нами</div>
        <?foreach($arResult['ITEMS'] as $cell=>$arItem):
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
            ?>
            <a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" class='inline'  title="Оставайтесь с нами - <?=$arItem['NAME']?>" target="_blank" id="<?=$this->GetEditAreaId($arItem['ID']);?>"><img src="<?=$arItem['PICTURE']['SRC']?>" width="<?=$arItem['PICTURE']['WIDTH']?>" height="<?=$arItem['PICTURE']['HEIGHT']?>" alt="<?=$arItem['NAME']?>" /></a>
        <?endforeach;?>
    </div>
</div>
