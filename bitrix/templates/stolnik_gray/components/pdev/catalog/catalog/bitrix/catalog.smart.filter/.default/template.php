<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

if (!$arResult['FOUND_PROPS']) {
    return;
}

?>
<div class="b-filter">
    <form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
        <?foreach($arResult["HIDDEN"] as $arItem):?>
        <input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
        <?endforeach;?>
        <strong>Фильтр:</strong>
        <?foreach($arResult["ITEMS"] as $key => $arItem):
            $key = md5($key);
            if(isset($arItem["PRICE"])):
                if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
                    continue;
                ?>
                <div class="b-btn js-filter">
                    <?=$arItem['NAME']?>
                    <div class="b-sort__list b-sort__list_w216">
                        <div class="b-filer__item">
                            <div class="b-filer__item__range">
                                <input
                                    class="min-price minCost"
                                    type="text"
                                    name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                    id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                    value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                                    size="5"
                                    onkeyup="smartFilter.keyup(this)"
                                    placeholder=""
                                />
                                <span class="deliter">
                                    -
                                </span>
                                <input
                                    class="max-price maxCost"
                                    type="text"
                                    name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                    id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                    value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                    size="5"
                                    onkeyup="smartFilter.keyup(this)"
                                />
                            </div>
                            <div class="slider"></div>
                        </div>
                        <input type="submit" value="Применить" class="b-button"/>
                    </div>
                </div>
            <?endif;
        endforeach;
        foreach($arResult["ITEMS"] as $key=>$arItem):
            if($arItem["PROPERTY_TYPE"] == "N" ):
                if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
                    continue;
                ?>
                <div class="b-btn js-filter">
                    <?=$arItem['NAME']?>
                    <div class="b-sort__list b-sort__list_w216">
                        <div class="b-filer__item">
                            <div class="b-filer__item__range">
                                <input
                                    class="min-price minCost"
                                    type="text"
                                    name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                    id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                    value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                                    data-min-value="<?=$arItem['VALUES']['MIN']['VALUE']?>"
                                    size="5"
                                    onkeyup="smartFilter.keyup(this)"
                                    placeholder="<?=$arItem['VALUES']['MIN']['VALUE']?>"
                                />
                                <span class="deliter">
                                    -
                                </span>
                                <input
                                    class="max-price maxCost"
                                    type="text"
                                    name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                    id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                    value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                    data-max-value="<?=$arItem['VALUES']['MAX']['VALUE']?>"
                                    size="5"
                                    onkeyup="smartFilter.keyup(this)"
                                    placeholder="<?=$arItem['VALUES']['MAX']['VALUE']?>"
                                />
                            </div>
                            <div class="slider"></div>
                        </div>
                        <input class="b-button" type="submit" id="set_filter" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" />
                    </div>
                </div>

            <?elseif(!empty($arItem["VALUES"]) && !isset($arItem["PRICE"])):?>
                <div class="b-btn js-filter">
                    <?=$arItem['NAME']?>
                    <div class="b-sort__list b-sort__list_scrollable ">
                        <div class="scroll-pane">
                            <ul>
                                <?foreach($arItem["VALUES"] as $val => $ar):?>
                                    <li><input
                                        class='js-checkbox'
                                        type="checkbox"
                                        value="<?echo $ar["HTML_VALUE"]?>"
                                        name="<?echo $ar["CONTROL_NAME"]?>"
                                        id="<?echo $ar["CONTROL_ID"]?>"
                                        <?echo $ar["CHECKED"]? 'checked="checked"': ''?>
                                        onclick="smartFilter.click(this)"
                                        /> <label for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];?></label></li>
                                <?endforeach;?>
                            </ul>
                        </div>
                        <div class="b-lined-btn">
                            <input class="b-button" type="submit" id="set_filter" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" />
                        </div>
                    </div>
                </div>
            <?endif;
        endforeach;?>

        <button class="b-btn float-right" type="submit" id="del_filter" name="del_filter"><?=GetMessage("CT_BCSF_DEL_FILTER")?></button>
    </form>
</div>
