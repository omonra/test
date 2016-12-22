<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<?
/*CModule::IncludeModule("iblock");
$arSelect = Array("ID", "IBLOCK_ID", "NAME");
$arFilter = Array("IBLOCK_ID"=>53, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement()){ 
	$arFields = $ob->GetFields(); 
	$arrBrand[$arFields["ID"]] = $arFields["NAME"];  
}*/

$res = CIBlockElement::GetByID($arItem["ID"]);
if($ar_res = $res->GetNext())
	$section = $ar_res['IBLOCK_SECTION_ID'];
   $arFilter = array('IBLOCK_ID' => "4", "ID" => $section); 
   $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter, false, array("UF_CATALOG"));
   while ($arSect = $rsSect->GetNext())
   {
		$ar_section_category[$arSect["ID"]] = $arSect["UF_CATALOG"];
   }


?>
<? foreach($arResult['ITEMS'] as $arItem): 

$collection = $arItem["PROPERTIES"]["COLECTION"]["VALUE"];
$sostav = $arItem["PROPERTIES"]["SOSTAV"]["VALUE"];

	$section_category = $ar_section_category[$arItem["IBLOCK_SECTION_ID"]];
	$element_category = $arItem["PROPERTIES"]["CATALOG"]["VALUE"];


?>

        <? if (empty($arItem['OFFERS'])): ?>
                <? $arItem['OFFERS'][] = $arItem ?>
        <? endif ?>
		<?
		
		?>
        <? foreach($arItem['OFFERS'] as $arOffer): ?>
				
                <? ob_start(); ?>
                <offer id="<?= $arOffer['ID'] ?>"  type="vendor.model" available="false" group_id="<?= $arItem['ID'] ?>">
                        <url>http://stolnik24.ru<?= $arItem['DETAIL_PAGE_URL'] ?>?selected=<?= $arOffer['CODE'] ?>&amp;r1=yandext&amp;r2=</url>
                        <? 

						$offerPrice = reset($arOffer['PRICES']) ?>
                        <price><?= $offerPrice['VALUE_VAT'] ?></price>
                        <currencyId><?= $offerPrice['CURRENCY'] ?></currencyId>
                        <categoryId>100000000</categoryId>
                        <market_category>
                                <?if ($section_category){ 
                                        echo $section_category; 
								} elseif ($element_category) {
                                    echo $element_category; 
                                } else {
                                        echo "Все товары / Гардероб";
								}?>
                        </market_category>
						
						<?/*
						$i = 1;

						foreach ($arOffer["PROPERTIES"]["MORE_PHOTO"]['VALUE'] as $FILE)
							{
								if ($i<11) {
									$FILE = CFile::GetFileArray($FILE);   
									if(is_array($FILE)) { ?>
										<picture>http://stolnik24.ru<?= $FILE['SRC'] ?></picture>
									<?} else {
										$pic = true;
									}
								}
								$i++;
							}*/
							?>
								

						<?
						$i = 1;
						foreach ($arItem["PROPERTIES"]["MORE_PHOTO"]['VALUE'] as $FILE)
							{
								if ($i<11) {
									$FILE = CFile::GetFileArray($FILE);   
									if(is_array($FILE)) { ?>
										<picture>http://stolnik24.ru<?= $FILE['SRC'] ?></picture>
									<?} else {
										$pic = true;
									}
								}
								$i++;
							}
							?>
		
						<? if (($arOffer['DETAIL_PICTURE']) and ($pic == true)): ?>
                                <? if (!is_array($arOffer['DETAIL_PICTURE'])): ?>
                                        <? $arPicture = CFile::GetFileArray($arOffer['DETAIL_PICTURE']) ?>
                                <? else: ?>
                                        <? $arPicture = $arOffer['DETAIL_PICTURE'] ?>
                                <? endif ?>
                                <picture>http://stolnik24.ru<?= $arPicture['SRC'] ?></picture>
                                
                        <? endif ?>						
						
                        <store>false</store>
                        <pickup>false</pickup>
                        <delivery>true</delivery>
						<local_delivery_cost>
							<?
								if ($offerPrice['VALUE_VAT'] > 500) {
									echo "0";
								} else {
									echo "100";
								}
							?>
						</local_delivery_cost>
						<vendor>STOLNIK</vendor>
                        <?/*?><vendorCode><?= preg_replace('#[^-А-ЯЁA-Z\d\/\\\]#iu','',$arOffer['PROPERTIES']['CML2_ARTICLE']['~VALUE']) ?></vendorCode>
						<vendorCode><?= preg_replace('#[^-А-ЯЁA-Z\d\/\\\]#iu','',$arOffer["ID"]) ?></vendorCode><?*/?>
                        <model><?= str_replace("&", " ",$arOffer['NAME']) ?></model>

                        <? /*
                        <description><?= str_replace('&nbsp;','',$arItem['DETAIL_TEXT']?$arItem['DETAIL_TEXT']:$arOffer['DETAIL_TEXT']) ?></description>
                            */ ?>
							
                        <? $description = $arItem['DETAIL_TEXT']?$arItem['~DETAIL_TEXT']:$arOffer['~DETAIL_TEXT']; ?>
                        <description>
							<![CDATA[
								<?echo htmlspecialchars_decode(strip_tags($description)); ?>
								
							]]>
						</description>
						<?/*?><sales_notes>Необходиа предоплата</sales_notes><?*/?>
                        <?/*if ($arOffer['CATALOG_WEIGHT']): ?>
                        <weight><?= $arOffer['CATALOG_WEIGHT']/1000 ?></weight>
                        <? endif */?>
						<? if ($collection): ?>
								<param name="Коллекция"><?= $collection ?></param>
						<? endif ?>
						<? if ($sostav): ?>
								<param name="Состав"><?= $sostav ?></param>
						<? endif ?>
                        <? foreach ($arOffer['DISPLAY_PROPERTIES'] as $prop): ?>
                        <?// foreach ($arOffer['PROPERTIES'] as $prop): ?>
                                <? if ($prop['VALUE']): ?>
                                     <param name="<?=$prop['NAME']?>"><?=$prop['~VALUE']?></param> 
                                <? endif ?>
                        <? endforeach ?>
	
                </offer>
                <? $offer = ob_get_contents(); ?>
                <? ob_end_clean(); ?>
                <?= $offer ?>
        <? endforeach ?>
<? endforeach ?>

