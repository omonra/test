<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="b-header__basket">
    <?if ($arResult['NUM_PRODUCTS'] > 0):?>
        <a href="<?=$arParams['PATH_TO_BASKET']?>" class="icon"></a>
    <?else:?>
        <div class="icon"></div>
    <?endif;?>
    <div class="title"><?if ($arResult['NUM_PRODUCTS'] > 0):?><a href="<?=$arParams['PATH_TO_BASKET']?>">Ваша корзина</a><?else:?>Ваша корзина<?endif;?></div>
    <div class="count">
    	<?if ($arResult['NUM_PRODUCTS'] > 0):?>
			<div class="txt"><a href="<?=$arParams['PATH_TO_BASKET']?>">В корзине <?=$arResult['NUM_PRODUCTS']?> <?=$arResult['PRODUCT(S)']?></a></div>
    	<?else:?>
	        <div class="txt"><?=$arResult['ERROR_MESSAGE']?></div>
        <?endif;?>
    </div>
</div>

<script id="basket-template" type="text/x-handlebars-template">
    {{#if basket_count }}
        <a href="<?=$arParams['PATH_TO_BASKET']?>" class="icon"></a>
    {{else}}
        <div class="icon"></div>
    {{/if}}

    <div class="title">{{#if basket_count }}<a href="<?=SITE_DIR?>personal/cart/">Ваша корзина</a>{{else}}Ваша корзина{{/if}}</div>
    <div class="count">
        {{#if basket_count }}
            <div class="txt"><a href="<?=SITE_DIR?>personal/cart/">В корзине {{basket_count_formated}}</a></div>
        {{else}}
            <div class="txt"><?=$arResult['ERROR_MESSAGE']?></div>
        {{/if}}
    </div>
</script>
