<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $APPLICATION->SetPageProperty("BodyClass","menu-page"); ?>
<? if (!empty($arResult)): ?>
    <ul class="left-nav">

        <? foreach ($arResult as $arItem): ?>
            <? if ($arItem['DEPTH_LEVEL'] == 1): ?>
                <li>
                    <a href="<?= $arItem['LINK'] ?>"><?= $arItem['TEXT'] ?></a>
                    
                </li>
            <? endif; ?>
        <? endforeach; ?>
    </ul>
    <?
endif?>