<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//global $USER;
//if ($USER->IsAdmin()){

   $useQuick = false;
   global $USER;
   if (isset($_GET['quick']) && $USER->IsAdmin()){
      $useQuick = true;
   }

$IBLOCK_ID = $arParams["IBLOCK_ID"];
$arInfo = CCatalogSKU::GetInfoByProductIBlock($IBLOCK_ID);
if (is_array($arInfo))
{
     $rsOffers = CIBlockElement::GetList(array(),array('IBLOCK_ID' => $arInfo['IBLOCK_ID'], 'PROPERTY_'.$arInfo['SKU_PROPERTY_ID'] => $arResult["ID"], ">=".'CATALOG_QUANTITY' =>1), false, false, false);
	  while ($arOffer = $rsOffers->GetNext()){
				  $ar_res = CPrice::GetBasePrice($arOffer["ID"]);
				  if($ar_res["PRICE"])
				  break;
			  }
}




//}
$arFiltersRes = Array(
    array("name" => "watermark", 'type'=>'image', "position" => "bottomright",   "size"    => "small", 'alpha_level'=>'70', "file"=>$_SERVER['DOCUMENT_ROOT']."/bitrix/templates/stolnilk/images/logo_w.png")
);
?>
<div class="photos">
    <ul class="img_big">
            <?
            $i=1;
            $ltd='';
            $std='';
            /*if($arResult["PROPERTIES"]["SPEC"]["VALUE"]=="true"){
                $std.='<span class="icon icon_product_hit"></span>';
            }*/
            /*if($arResult["PROPERTIES"]["NOVINKA"]["VALUE"]=="true" || MakeTimeStamp($arResult["DATE_CREATE"], "DD.MM.YYYY HH:MI:SS")>time()-3600*24*7){
                $std.='<span class="icon_new"></span>';
            }*/
            /*if($arResult["PROPERTIES"]["RASPRODAZHA"]["VALUE"]=="true"){
                $std.='<span class="icon icon_product_sale"></span>';
            }*/
            ?>

        <?

        $arFiltersFile = Array(
            Array( 'name' => 'watermark',
                'position' => 'bottomcenter',
                'size'=>'real',
                'type'=>'image',
                'alpha_level'=>'100',
                'file'=>$_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/stolnilk/images/watermark_3.png',

            ),
        );

        $arFiltersFileBig = Array(
            Array( 'name' => 'watermark',
                'position' => 'bottomcenter',
                'size'=>'real',
                'type'=>'image',
                'alpha_level'=>'100',
                'file'=>$_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/stolnilk/images/watermark_big.png',

            ),
        );


        ?>

            <?if(is_array($arResult["DETAIL_PICTURE"])):?>
                <? $cfile=CFile::ResizeImageGet($arResult["DETAIL_PICTURE"], array('width'=>200, 'height'=>292), BX_RESIZE_IMAGE_EXACT, true,$arFiltersFile);?>
                <? $cfile2=CFile::ResizeImageGet($arResult["DETAIL_PICTURE"]["ID"], array('width'=>$arResult["DETAIL_PICTURE"]["WIDTH"], 'height'=>$arResult["DETAIL_PICTURE"]["HEIGHT"]), BX_RESIZE_IMAGE_EXACT, true,$arFiltersFileBig);?>
            <li class="active"><a id="img_big_<?=$i?>" class="cloud-zoom" href="<?=$cfile2["src"]?>" rel="zoomHeight:290, zoomWidth:450, adjustX: 10, adjustY: -5"><?=$std?><img src="<?=$cfile["src"]?>" width="200" height="<?=round($cfile["height"]*(200/$cfile["width"]))?>" alt="<?=$arResult["PROPERTIES"]["ALT"]["VALUE"]?>"></a>
                <div class="arrow arrow-left"><a href="<?=$cfile2["src"]?>">1</a></div>
                <div class="arrow arrow-right"><a href="<?=$cfile2["src"]?>">1</a></div>
            </li>
                <?$i++;?>
            <?elseif(is_array($arResult["PREVIEW_PICTURE"])):?>
                <? $cfile=CFile::ResizeImageGet($arResult["PREVIEW_PICTURE"], array('width'=>200, 'height'=>292), BX_RESIZE_IMAGE_EXACT, true,$arFiltersFile);?>
                <? $cfile2=CFile::ResizeImageGet($arResult["PREVIEW_PICTURE"]["ID"], array('width'=>$arResult["PREVIEW_PICTURE"]["WIDTH"], 'height'=>$arResult["PREVIEW_PICTURE"]["HEIGHT"]), BX_RESIZE_IMAGE_EXACT, true,$arFiltersFileBig);?>
            <li class="active"><a id="img_big_<?=$i?>" class="cloud-zoom" href="<?=$cfile2["src"]?>" rel="zoomHeight:290, zoomWidth:450, adjustX: 10, adjustY: -5"><?=$std?><img src="<?=$cfile["src"]?>" width="200" height="<?=round($cfile["height"]*(200/$cfile["width"]))?>" alt="<?=$arResult["PROPERTIES"]["ALT"]["VALUE"]?>"></a>
                <div class="arrow arrow-left"><a href="<?=$cfile2["src"]?>">1</a></div>
                <div class="arrow arrow-right"><a href="<?=$cfile2["src"]?>">1</a></div>
            </li>
                <?$i++;?>
            <?endif;?>
        <?if(count($arResult["MORE_PHOTO"])>0):?>
        <?foreach($arResult["MORE_PHOTO"] as $PHOTO):?>
            <? $cfile=CFile::ResizeImageGet($PHOTO["ID"], array('width'=>200, 'height'=>292), BX_RESIZE_IMAGE_EXACT, true,$arFiltersFile);?>
                <?$cfile2=CFile::ResizeImageGet($PHOTO["ID"], array(), BX_RESIZE_IMAGE_EXACT, true,$arFiltersFileBig);?>
            <li><a id="img_big_<?=$i?>" class="cloud-zoom" href="<?=$cfile2["src"]?>" rel="zoomHeight:290, zoomWidth:450, adjustX: 10, adjustY: -5"><?=$std?><img src="<?=$cfile['src']?>" width="200" height="<?=round($cfile["height"]*(200/$cfile["width"]))?>" alt="<?=$arResult["PROPERTIES"]["ALT"]["VALUE"]?>"></a>
                <div class="arrow arrow-left"><a href="<?=$cfile2["src"]?>">1</a></div>
                <div class="arrow arrow-right"><a href="<?=$cfile2["src"]?>">1</a></div>
            </li>
            <?$i++;endforeach;?>
        <?endif;?>
    </ul>
    <?
    $arFiltersFile2 = Array(
        Array( 'name' => 'watermark',
            'position' => 'bottomcenter',
            //'size'=>'small',
           'coefficient'=>'0.8',
            'fill'=> 'resize',
            'type'=>'image',
            'alpha_level'=>'100',
            'file'=>$_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/stolnilk/images/watermark_3.png',

        ),
    );
    ?>
	<!--script type="text/javascript" src="/bitrix/templates/stolnik_gray/js/script.js"></script>
	<script type="text/javascript" src="/bitrix/templates/stolnik_gray/js/script2.js"></script-->
</div>




<div class="base">
<h1><?=$arResult["NAME"]?></h1>
<!--

    <div class="print"><a href="<?=$APPLICATION->GetCurPageParam("PRINT=Y", array("PRINT"))?>"><img class="icon" src="<?=SITE_TEMPLATE_PATH?>/images/icon_print.gif" width="17" height="15" alt=""> Для печати</a></div>
-->

		<?if($_GET["yandex"]):?>
			<dl class="price">
			        <dt>Цена</dt>

			        <dd><span class="val"><?=$ar_res["PRICE"]?></span> руб.</dd>
			</dl>
		<?else:?>
			<?if($arResult["PROPERTIES"]["PRICE"]["VALUE"]>0):?>
			<dl class="price">
			        <dt>Цена</dt>
			        <?if(strlen($arResult["PROPERTIES"]["PRICE_OLD"]["VALUE"])>0):?><dd class="old"><span class="val"><?=$arResult["PROPERTIES"]["PRICE_OLD"]["VALUE"]?><span class="red_line"></span></span></dd><?endif;?>
			        <dd><span class="val"><?=$arResult["PROPERTIES"]["PRICE"]["VALUE"]?></span> руб.</dd>
			</dl>
			    <?endif;?>
		<?endif?>



<!--

-->

<?if(!empty($arResult["PROPERTIES"]["RAZMER_LINK"]["VALUE"])):?>
	<?
		$res = CIBlockElement::GetByID($arResult["PROPERTIES"]["RAZMER_LINK"]["VALUE"]);
		if($ar_res = $res->GetNext()):
	?>
		<a target="_blank" class="button button_1 button_1_2" href="<?=$ar_res["DETAIL_PAGE_URL"]?>">Таблица размеров</a><br><br>
	<?endif?>
<?endif?>


<?
$rel='';
$i=1;foreach($arResult["OF"] as $key=>$item){
    foreach($item as $key2=>$item2){
        if($i==1)$rel=$item2["ADD"];
        $i++;
    }
}
?>
<?/*if(strlen($rel)>0):*/?>
<div class="to_basket">
    <form action="#">

		<!-- size & color -->
		<?/*<ul class="size-color">
			<li class="size" style="border:none;">Razmeri</li>
			<?$i=1;$g=1;$rel='';$st=true;foreach($arResult["OF"] as $key=>$item):?>
			<li class="size">

				<div>
					<?=$key?>
				</div>

				<ul class="product_color_list" style="display:none;">
					<?foreach($item as $key2=>$item2):?>
					<?if($i==1)$rel=$item2["ADD"]?>
					<?if($item2["QUANTITY"]>0):?>
						<li class="group_<?=$key?> <?if($st): $st=false;?>active<?endif;?>" rel="<?=$item2["ID"]?>"><label for="product_color_<?=$i?>"><input data-price="<?=$item2['CATALOG_PRICE_' . GetPriceId()]?>" rel="<?=$item2["ADD"]?>" id="product_color_<?=$i?>" class="radio" type="radio" name="product_color" value="product_color_<?=$i?>" <?if($i==1):?>checked="checked"<?endif;?>><img class="color_icon" src="<?=$item2["SRC"]?>" title="<?=$item2["TITLE"]?>" width="20" height="20" alt="<?=$key2?>"></label></li>
						<?else:?>
						<li class="group_<?=$key?>" rel="<?=$item2["ID"]?>"><label for="product_color_<?=$i?>"><img class="color_icon" src="<?=$item2["SRC"]?>" title="<?=$item2["TITLE"]?>" width="20" height="20" alt="<?=$key2?>"><img src="<?=SITE_TEMPLATE_PATH?>/images/nosc.png" style="position: absolute;left:0;top:0;"></label></li>
						<?endif;?>
					<?$i++;endforeach;?>
				</ul>
			</li>
			<?$g++;endforeach;?>
		</ul>*/?>
		<!-- /size & color -->

		<!--p class="ruler">
			<?foreach($arResult["ARTICLES_LINK"] as $item):?>
				<span id="size-ruler"><?=$item["NAME"]?></span>
			<?endforeach;?>
		</p>
		<div id="size-ruler-base" class="size-popup" style="display:none;">
			<div class="close"></div>
			<div id="size-ruler-base-in"></div>
		</div-->
		<script>
			$(document).ready(function(){
				$('#size-ruler').click(function(){
					$('#size-ruler-base-in').load('/articles/<?=$item["CODE"]?>/ .news-detail');
					$('#size-ruler-base').show();
				});
				$('#size-ruler-base .close').click(function(){
					$('#size-ruler-base').hide();
				});
			});
		</script>

        <!-- size & color old -->
        <ul id="size-change" class="size-color">
			<?foreach($arResult["OF"] as $key=>$item):?>
				<li class="group_<?=$key?>"><?=$key?></li>
			<?endforeach;?>
		</ul>


		<ul class="product_color_list">
			<?$st=1;$i=1;$g=1;$rel='';foreach($arResult["OF"] as $key=>$item):?>
				<?foreach($item as $key2=>$item2):?>
				<?if($i==1)$rel=$item2["ADD"]?>
					<?if($item2["QUANTITY"]>0):?>
						<li class="group_<?=$key?><?if($st): $st=false;?> active<?endif;?>" rel="<?=$item2["ID"]?>" style="display:none">
							<label for="product_color_<?=$i?>"><input data-price="<?=$item2['CATALOG_PRICE_' . GetPriceId()]?>" rel="<?=$item2["ADD"]?>" id="product_color_<?=$i?>" class="radio" type="radio" name="product_color" value="product_color_<?=$i?>" <?if($i==1):?>checked="checked"<?endif;?>>
								<img class="color_icon" src="<?=$item2["SRC"]?>" title="<?=$item2["TITLE"]?>" width="25" height="25" alt="<?=$key2?>">
							</label>
						</li>
						<?else:?>
						<li class="group_<?=$key?>" rel="<?=$item2["ID"]?>" style="display:none">
							<label for="product_color_<?=$i?>">
								<img class="color_icon" src="<?=$item2["SRC"]?>" title="<?=$item2["TITLE"]?>" width="25" height="25" alt="<?=$key2?>">
								<img src="<?=SITE_TEMPLATE_PATH?>/images/nosc.png" style="position: absolute;left:0;top:0;">
							</label>
						</li>
					<?endif;?>
				<?$i++;endforeach;?>
			<?$g++;endforeach;?>
		</ul>

		<script>
			$(document).ready(function() {

				$("#size-change li").click(function() {
					$("#size-change li").removeClass("active");
					var ggg=$(this).attr('class');
					$(this).toggleClass("active");
					$(this).parent().next('.product_color_list').children().hide();
					$(this).parent().next('.product_color_list').children("."+ggg).show();
					$(this).parent().next('.product_color_list').children().removeClass("active");
					$(this).parent().next('.product_color_list').children("."+ggg).first().children().click();
				});
			});
		</script>

        <!-- /size & color old -->
		<!--p class="info">Цвета зачеркнутые <span style="color:red;">красной</span> линией отсутствуют в продаже.</p-->
		<!-- <input class="button button_1 submit" type="submit" value="В корзину">-->
		<?if(strlen($rel)>0):?>
		<?
			if ($useQuick){?>
			<?/*<a id="quick_url" rel="<?=$rel?>" class="button button_1 button_1_2" href="#item_in_basket" style="margin:0 206px 0 0; width:100px;float: right;">Быстрый заказ</a>*/?>
			<?}/*global $USER;
			if ($USER->IsAuthorized()){?>
				<a id="add_url" rel="<?=$rel?>" class="button button_1 button_1_2 submit" href="#item_in_basket" style="margin:0 206px 0 0;">Быстрый заказ</a>
<?}*/
		?>
		<a id="add_url" rel="<?=$rel?>" class="button button_1 button_1_2 submit" href="#item_in_basket">Купить</a>
		<?endif;?>
    </form>
</div>
    <?/*endif;*/?>



<?/*if(!empty($arResult["ARTICLES_LINK"])):?>
<div class="good_to_know" style="margin: -20px 0 0 0;">
        <h2 style="font-weight: normal;">Полезная информация</h2>
    <ul style="list-style: none;color: #000000;">
        <?foreach($arResult["ARTICLES_LINK"] as $item):?>
        <li>- <a href="/articles/<?=$item["CODE"]?>/"><?=$item["NAME"]?></a></li>
        <?endforeach;?>
    </ul>
</div>
    <?endif;?>
<?if(!empty($arResult["ARTICLES"])):?>
<div class="good_to_know">
    <h2><?=$arResult["ARTICLES"]["NAME"]?></h2>
    <p><?=$arResult["ARTICLES"]["DETAIL_TEXT"]?></p>
</div>
    <?endif;*/?>


<script>
    $(document).ready(function(){
        $('.to_basket .product_color_list li label').bind('click',function(){
            $('#add_url').attr('rel',$(this).parent().find('input').attr('rel'));
        });
    });
</script>
</div>
