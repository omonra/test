<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$product_name = '';
$res = CIBlockElement::GetByID($arParams["ELEMENT_ID"]);
if($ar_res = $res->GetNext())
    $product_name = $ar_res['NAME'];

?>
<div class="body g-clear" id="comments-block">
    <div class="b-reviews" >
        <?foreach ($arResult['ITEMS'] as $arItem):?>
            <p id='prod_review_<?=$arItem['ID']?>' itemscope itemtype="http://schema.org/Review">
                <a class='b-reviews__review_link' itemprop="url" href="<?=$APPLICATION->GetCurPage()?>#prod_review_<?=$arItem['ID']?>">
                    <strong itemprop="author" itemscope itemtype="http://schema.org/Person">
                          <span itemprop="name"><?=$arItem['PROPERTY_NAME_VALUE']?></span>
                    </strong>
                </a>
                <?if (strlen($arItem['DISPLAY_ACTIVE_FROM']) > 0):?>
                    <span class="clearall block"></span>
                    <?=$arItem['DISPLAY_ACTIVE_FROM']?>
                <?endif;?>
                <?if ($arItem['PROPERTY_RATING_VALUE'] > 0):?>
                    <span itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                        <span class="clearall block"></span>
                        <span class="stars"><?=str_repeat('<i></i>', $arItem['PROPERTY_RATING_VALUE'])?></span>
                        <span itemprop="ratingValue" style='display: none'><?=$arItem['PROPERTY_RATING_VALUE']?></span>
                    </span>
                <?endif;?>
                <?//Для микроразметки?>
                <span itemprop="itemReviewed" itemscope itemtype="http://schema.org/Product">
                    <span itemprop="name"><?=$product_name?></span>
                </span>
                <?if (strlen($arItem['DETAIL_TEXT']) > 0):?>
                    <span itemprop="reviewBody"><?=$arItem['DETAIL_TEXT']?></span>
                <?endif;?>
                <?/*
                echo '<div style="display: none">';
                print_r($arItem);
                echo '</div>';*/
                ?>
            </p>
            <?if($arItem['PROPERTY_ADMIN_REPLY_VALUE']['TEXT']):?>
                <p class='b-reviews-admin-reply'>
                    <strong>Администрация</strong>
                    <span class="clearall block"></span>
                    <span><?=$arItem['PROPERTY_ADMIN_REPLY_VALUE']['TEXT']?></span>
                </p>
            <?endif;?>
        <?endforeach;?>
        <?if (strlen($arResult['NAV_STRING']) > 0):?>
            <?=$arResult['NAV_STRING']?>
        <?endif;?>
    </div>
    <form class="b-reviews-form" action="#reviews_form" method="post">
        <?=bitrix_sessid_post()?>
        <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">

        <?if (is_array($arResult['ERRORS']) && count($arResult['ERRORS']) > 0){
            ShowError(implode('<br />', $arResult['ERRORS']));
        }
        if(strlen($arResult["OK_MESSAGE"]) > 0) {
            ShowNote($arResult["OK_MESSAGE"]);
        }
        ?>

        <label for="comments-field-name">Имя</label>
        <input type="text" id="comments-field-name" name="name" value="<?=(strlen($arResult['VARS']['name']) > 0 ? $arResult['VARS']['name'] : $USER->GetFirstName())?>"/>

        <label for="comments-field-email">Электронная почта</label>
        <input type="text" id="comments-field-email" name="email" value="<?=(strlen($arResult['VARS']['email']) > 0 ? $arResult['VARS']['email'] : $USER->GetEmail())?>"/>

        <label for="comments-field-text">Сообщение</label>
        <textarea name="text" id="comments-field-text"><?=(strlen($arResult['VARS']['text']) > 0 ? $arResult['VARS']['text'] : '')?></textarea>

        <?if($arResult["USE_CAPTCHA"] == "Y"):?>
            <label for="comments-field-captcha">Проверочный код</label>
            <input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>" id="captcha_sid" />
            <img class="captcha" src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="170" height="40" alt="CAPTCHA" id="captcha_img" />
            <input type="text" name="captcha_word" size="17" maxlength="50" id="comments-field-captcha" class="comments-field-captcha" />
            <a href="#" class="renewCaptcha js-renewCaptcha">обновить</a>
        <?endif;?>

        <input value="Отправить" type="submit"/>
        <label>Оценить</label>
        <div id="rating_1">
            <input type="hidden" name="val" value="<?=$arResult['VARS']['rating']?>" />
        </div>
        <input type="hidden" name="rating" id="rating" value="<?=$arResult['VARS']['rating']?>" />
    </form>
</div>
