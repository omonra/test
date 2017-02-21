<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$APPLICATION->SetTitle($arResult['NAME']);

$priceHtml = "";
if (!empty($arResult['PRICE']['PRINT_VALUE']))
{
    if (!empty($arResult['PRICE']['OLD']))
        $priceHtml = '<div class="price"><strike>'.$arResult['PRICE']['OLD']['PRINT_VALUE'].'</strike> '.$arResult['PRICE']['PRINT_VALUE'].'</strike></div>';
    else
        $priceHtml = '<div class="price">'.$arResult['PRICE']['PRINT_VALUE'].'</div>';
}

$APPLICATION->SetPageProperty('BackLineRight', $priceHtml);
?>
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

$productSelected = $arResult['OFFERS_LIST']['COLOR'][$arResult['COLOR_SELECTED']][$arResult['SIZE_SELECTED']];

?>

<script>
    window.offersList = <?= CUtil::PhpToJSObject($arResult['OFFERS_LIST']) ?>;
    window.currentColor = '<?= $arResult['COLOR_SELECTED'] ?>';
    window.currentSize = '<?= $arResult['SIZE_SELECTED'] ?>';
    window.currentOffer = '<?= $arResult['OFFER_SELECTED'] ?>';
</script>
<div class="product-toolbar">
    
    
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td class="info">
                <a href="">����</a>
            </td>
            <? if (!empty($productSelected['COLOR_PICTURE'])): ?>
            <td class="color">
                
                
                <a href="" class="color">
                    <img src="<?=$productSelected['COLOR_PICTURE']?>" />
                </a>
               
            </td>
            <? endif; ?>
            <td>
                <a href="">������� ��������</a>
            </td>
            <td class="<? if (count($arResult['OFFERS_LIST']) > 0): ?>to-cart<?else:?>not-avaliable<?endif;?>">
                <? if (count($arResult['OFFERS_LIST']) > 0): ?>
                <a href="#" onclick="MobileApp.BasketAdd(); return false;" class="to-cart">� �������</a>
                <? else: ?>
                <a href="#" onclick="return false;" class="not-avaliable">��� � �������</a>
                <? endif; ?>
            </td>
        </tr>
    </table>
</div>

<div class="product-item">
    <div class="product-photos">
    <ul class="items">
        <? foreach ($arResult['BIG_PICTURE'] as $arPhoto): ?>
        <li>
            <img src="<?=$arPhoto['SRC']?>" />
        </li>
        <? endforeach; ?>
    </ul>
    </div>
</div>

<div class="success-basket-add" style="display: none;">
    <div class="modal">
    ����� ������� �������� � �������!<br/><br/>
    <table width="100%">
        <tr>
            <td><a href="#" onclick="$('.success-basket-add').hide(); return false;">���������� �������</a></td>
            <td><a href="/app/personal/order/make/" class="orange">�������� �����</a></td>
        </tr>
    
    
    </table>
    
    </div>
</div>

<pre>
    <? //print_r($arResult['OFFERS_LIST']); ?>
</pre>

<script>
    
    var MobileApp = {
        
        UpdateBasket: function () {
            
            $.get('/app/ajax/basket.php', function (data) {
                $("#basket-ajax").html(data);
            });
        },
        
        Query: function(options) {
            var defaultOptions = {
                url: '/app/ajax/',
                html: false,
                error: function(error) {
                    console.log(error);
                },
                data: {}
            };

            return (function(options) {
                var opt = $.extend({}, defaultOptions, options);

                if (typeof opt.action !== 'undefined') {
                    opt.data['tag'] = opt.action;
                }
                $.ajax({
                    type: "POST",
                    url: opt.url,
                    data: opt.data,
                    timeout: 10000,
                    dataType : opt.html ? 'html' : 'json',
                    success: function(data) {
                        if (typeof data !== 'undefined' && data !== null) {
                            if (typeof data.error !== 'undefined' && typeof opt.error !== 'undefined') {
                                opt.error(data.error);
                            } else {
                                if (typeof opt.success !== 'undefined') {
                                    opt.success(data);
                                }
                            }

                            if (typeof data.log !== 'undefined') {
                                console.log('log: ' + data.log);
                            }
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrow) {
                        if (textStatus == 'parsererror') {
                            console.log(XMLHttpRequest.responseText);
                        }
                        if (typeof opt.error !== 'undefined') {
                            opt.error(textStatus);
                        }
                        return true;
                    }
                });
            })(options);
        },
                
        BasketAdd: function() {
            if (typeof offersList.SIZE == 'object') {
                var sizes = [];
                $.each(offersList.SIZE, function (key, value) {
                    sizes.push(key);
                });

                if (sizes.length > 0)
                {
                    BXMobileApp.UI.SelectPicker.show({
                        values: sizes,
                        callback: function (data) {
                            window.currentSize = data.values[0];
                            
                            var currentOffer = window.offersList['SIZE'][window.currentSize][window.currentColor]['ID'];
                            if (currentOffer !== undefined) {
                                var data = {id: currentOffer};

                                MobileApp.Query({
                                    action: 'AddToBasket',
                                    data: data,
                                    success: function(response) {
                                        if (response.ok) {
                                            $('.success-basket-add').show();
                                            MobileApp.UpdateBasket();
                                        }
                                    }
                                });
                            }
                        }
                    });

                }
            }

        },
        
        SelectColor: function () {
            if (typeof offersList.COLOR == 'object') {
                var colors = [];
                $.each(offersList.COLOR, function (key, value) {
                    colors.push(key);
                });

                if (colors.length > 0)
                {
                    BXMobileApp.UI.SelectPicker.show({
                        values: colors,
                        callback: function (data) {
                            window.currentColor = data.values[0];
                            var color_picture = window.offersList['COLOR'][window.currentColor][window.currentSize]['COLOR_PICTURE'];
                            $("#color-picture").attr('src', color_picture);
                        }
                    });

                }
            }
        }
    };
    
    
   
             
$(".product-photos ul.items").lightSlider({
                loop:false,
                keyPress:true,
                item: 1,
              controls: false,
              pager: true
});
</script>