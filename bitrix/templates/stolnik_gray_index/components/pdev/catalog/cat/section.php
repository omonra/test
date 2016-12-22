<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?CModule::IncludeModule("iblock")?>

<?
$preFilter=array();
if(in_array($arResult["VARIABLES"]["SECTION_CODE"],array("news_women"))){
    $arResult["VARIABLES"]["SECTION_CODE"]='';
    $preFilter=array(
        //дев
        //"SECTION_ID"=>105,
        //прод
        "SECTION_ID"=>314,
        "INCLUDE_SUBSECTIONS"=>"Y",
        "ACTIVE"=>"Y",
        array(
            "LOGIC"=>"OR",
            ">=DATE_CREATE"=>ConvertTimeStamp(time()-3600*24*7,"FULL"),
            "PROPERTY_NOVINKA"=>"true",
        ),
    );
}
if(in_array($arResult["VARIABLES"]["SECTION_CODE"],array("spec_women"))){
    $arResult["VARIABLES"]["SECTION_CODE"]='';
    $preFilter=array(
        //дев
        //"SECTION_ID"=>105,
        //прод
        "SECTION_ID"=>314,
        "ACTIVE"=>"Y",
        "PROPERTY_RASPRODAZHA"=>"true",
        "INCLUDE_SUBSECTIONS"=>"Y"
    );
}
if(in_array($arResult["VARIABLES"]["SECTION_CODE"],array("news_men"))){
    $arResult["VARIABLES"]["SECTION_CODE"]='';
    $preFilter=array(
        //дев
        //"SECTION_ID"=>127,
        //прод
        "SECTION_ID"=>284,
        "INCLUDE_SUBSECTIONS"=>"Y",
        "ACTIVE"=>"Y",
        array(
            "LOGIC"=>"OR",
            ">DATE_CREATE"=>ConvertTimeStamp(time()-3600*24*7,"FULL"),
            "PROPERTY_NOVINKA"=>"true",
        ),
    );
}
if(in_array($arResult["VARIABLES"]["SECTION_CODE"],array("spec_men"))){
    $arResult["VARIABLES"]["SECTION_CODE"]='';
    $preFilter=array(
        //дев
        //"SECTION_ID"=>127,
        //прод
        "SECTION_ID"=>284,
        "ACTIVE"=>"Y",
        "PROPERTY_RASPRODAZHA"=>"true",
        "INCLUDE_SUBSECTIONS"=>"Y"
    );
}

if(in_array($arResult["VARIABLES"]["SECTION_CODE"],array("news_aksessuary"))){
    $arResult["VARIABLES"]["SECTION_CODE"]='';
    $preFilter=array(
        //дев
        //"SECTION_ID"=>274,
        //прод
        "SECTION_ID"=>308,
        "INCLUDE_SUBSECTIONS"=>"Y",
        "ACTIVE"=>"Y",
        array(
            "LOGIC"=>"OR",
            ">DATE_CREATE"=>ConvertTimeStamp(time()-3600*24*7,"FULL"),
            "PROPERTY_NOVINKA"=>"true",
        ),
    );
}
if(in_array($arResult["VARIABLES"]["SECTION_CODE"],array("spec_aksessuary"))){
    $arResult["VARIABLES"]["SECTION_CODE"]='';
    $preFilter=array(
        //дев
        //"SECTION_ID"=>274,
        //прод
        "SECTION_ID"=>308,
        "ACTIVE"=>"Y",
        "PROPERTY_RASPRODAZHA"=>"true",
        "INCLUDE_SUBSECTIONS"=>"Y"
    );
}

if(isset($_SESSION["CAT_URL"]) && $_SESSION["CAT_URL"]!=$APPLICATION->GetCurPage()){
    unset($_SESSION["arrFSize"]);
    unset($_SESSION["arrFColor"]);
    unset($_SESSION["arrFBrand"]);
    unset($_SESSION["arrFCollection"]);
    unset($_SESSION["arrFPricemax"]);
    unset($_SESSION["arrFPricemin"]);
    $arrFPricemax=0;
}

$_SESSION["CAT_URL"]=$APPLICATION->GetCurPage();

if(isset($_SESSION["arrFNews"]))
    $arrFNews=$_SESSION["arrFNews"];
else
    $arrFNews=false;

if(isset($_SESSION["arrFSpec"]))
    $arrFSpec=$_SESSION["arrFSpec"];
else
    $arrFSpec=false;

if(isset($_SESSION["arrFCategory"]))
    $arrFCategory=$_SESSION["arrFCategory"];
else
    $arrFCategory=array();

if(isset($_SESSION["arrFCollection"]))
    $arrFCollection=$_SESSION["arrFCollection"];
else
    $arrFCollection=array();

if(isset($_SESSION["arrFSize"]))
    $arrFSize=$_SESSION["arrFSize"];
else
    $arrFSize=array();

if(isset($_SESSION["arrFColor"]))
    $arrFColor=$_SESSION["arrFColor"];
else
    $arrFColor=array();

if(isset($_SESSION["arrFBrand"]))
    $arrFBrand=$_SESSION["arrFBrand"];
else
    $arrFBrand=array();

if(isset($_SESSION["arrFPricemin"]))
    $arrFPricemin=$_SESSION["arrFPricemin"];
else
    $arrFPricemin=0;

?>
<?$APPLICATION->IncludeComponent(
    "bitrix:breadcrumb",
    "",
    Array(
        "START_FROM" => "0",
        "PATH" => "",
        "SITE_ID" => "s1"
    ),
    false
);?>
<?
//Обрабатываем фильтр
global $arrFilterCat;

//if(isset($_SESSION["arrFilterCat"]))
//    $arrFilterCat=$_SESSION["arrFilterCat"];
//else
$arrFilterCat=array();



/*-----------------filter size-------------------*/
if (isset($_REQUEST["size"])){
    if(isset($_REQUEST["set"]) && $_REQUEST["set"]=="checked")
        $arrFSize[]=$_REQUEST["size"];
    else{
        $key=array_search($_REQUEST["size"],$arrFSize);
        unset($arrFSize[$key]);
    }
}


if(isset($_REQUEST["clear_size"])){
    $arrFSize=array();
}

if(count($arrFSize)>0){
    $arrFilterCat["OFFERS"]["PROPERTY_SIZE"]=$arrFSize;
}

/*-----------------filter color-------------------*/
if (isset($_REQUEST["color"])){
    if(isset($_REQUEST["set"]) && $_REQUEST["set"]=="checked")
        $arrFColor[]=$_REQUEST["color"];
    else{
        $key=array_search($_REQUEST["color"],$arrFColor);
        unset($arrFColor[$key]);
    }
}

if(isset($_REQUEST["clear_color"])){
    $arrFColor=array();
}

if(count($arrFColor)>0){
    $arrFilterCat["OFFERS"]["PROPERTY_ITEM_COLOR_LIST"]=$arrFColor;
}

/*-----------------filter brand-------------------*/
if (isset($_REQUEST["brand"])){
    if(isset($_REQUEST["set"]) && $_REQUEST["set"]=="checked")
        $arrFBrand[]=iconv('UTF-8','CP1251',$_REQUEST["brand"]);
    else{
        $key=array_search($_REQUEST["brand"],$arrFBrand);
        unset($arrFBrand[$key]);
    }
}

if(isset($_REQUEST["clear_brand"])){
    $arrFBrand=array();
}

if(count($arrFBrand)>0){
    $arrFilterCat["PROPERTY_BRAND"]=$arrFBrand;
}

/*-----------------filter new spec--------------------*/

if (isset($_REQUEST["product_news"])){
    if(isset($_REQUEST["set"]) && $_REQUEST["set"]=="checked")
        $arrFNews=$_REQUEST["product_news"];
    else{
        $arrFNews=false;
    }
}

if (isset($_REQUEST["product_spec"])){
    if(isset($_REQUEST["set"]) && $_REQUEST["set"]=="checked")
        $arrFSpec=$_REQUEST["product_spec"];
    else{
        $arrFSpec=false;
    }
}

if(isset($_REQUEST["clear_news_spec"])){
    $arrFNews=false;
    $arrFSpec=false;
}


/*-----------------filter category-------------------*/
if (isset($_REQUEST["category"])){
    if(isset($_REQUEST["set"]) && $_REQUEST["set"]=="checked")
        $arrFCategory[]=$_REQUEST["category"];
    else{
        $key=array_search($_REQUEST["category"],$arrFCategory);
        unset($arrFCategory[$key]);
    }
}

if(isset($_REQUEST["clear_category"])){
    $arrFCategory=array();
}
if(count($arrFCategory)>0){
    $arrFilterCat["SECTION_ID"]=$arrFCategory;
    //$arResult["VARIABLES"]["SECTION_ID"]=$arrFCategory;
}

/*-----------------filter kollection-------------------*/
if (isset($_REQUEST["collection"])){
    if(isset($_REQUEST["set"]) && $_REQUEST["set"]=="checked")
        $arrFCollection[]=$_REQUEST["collection"];
    else{
        $key=array_search($_REQUEST["collection"],$arrFCollection);
        unset($arrFCollection[$key]);
    }
}

if(isset($_REQUEST["clear_collection"])){
    $arrFCollection=array();
}
if(count($arrFCollection)>0){
    $arrFilterCat["PROPERTY_COLECTION"]=$arrFCollection;
}

/*-----------------filter pricemin-------------------*/
if (isset($_REQUEST["pricemin"])){
    $arrFPricemin=$_REQUEST["pricemin"];
}

if($arrFPricemin>0){
    $arrFilterCat[">=PROPERTY_PRICE"]=$arrFPricemin;
}


/*-----------------filter pricemax-------------------*/
if (isset($_REQUEST["pricemax"])){
    $arrFPricemax=$_REQUEST["pricemax"];
}



if($arrFPricemax>0){
    $arrFilterCat["<=PROPERTY_PRICE"]=$arrFPricemax;
}


/*-------news--------*/
/*if (isset($_REQUEST["product_news"])){
    $arrFilterCat["PROPERTY_NEWS"]='true';
}*/



if ($arrFNews=="Y"){
    $arrFilterCat["PROPERTY_NEWS"]='true';
}

/*-------news--------*/
/*if (isset($_REQUEST["product_spec"])){
    $arrFilterCat["PROPERTY_SPEC"]='true';
}*/

if ($arrFSpec=="Y"){
    $arrFilterCat["PROPERTY_SPEC"]='true';
}

$_SESSION["arrFNews"]=$arrFNews;
$_SESSION["arrFSpec"]=$arrFSpec;
$_SESSION["arrFSize"]=$arrFSize;
$_SESSION["arrFColor"]=$arrFColor;
$_SESSION["arrFBrand"]=$arrFBrand;
$_SESSION["arrFCategory"]=$arrFCategory;
$_SESSION["arrFCollection"]=$arrFCollection;
$_SESSION["arrFPricemax"]=$arrFPricemax;
$_SESSION["arrFPricemin"]=$arrFPricemin;


$arAvailableSort = array(
    "price" => Array("PROPERTY_PRICE", "asc"),
);

//$sort = array_key_exists("sort", $_REQUEST) && array_key_exists(ToLower($_REQUEST["sort"]), $arAvailableSort) ? $arAvailableSort[ToLower($_REQUEST["sort"])][0] : "PROPERTY_PRICE";
//$sort_order = array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ? ToLower($_REQUEST["order"]) : $arAvailableSort[$sort][1];

if ($arrFNews!="Y")
{
    $sort = array_key_exists("sort", $_REQUEST) && array_key_exists(ToLower($_REQUEST["sort"]), $arAvailableSort) ? $arAvailableSort[ToLower($_REQUEST["sort"])][0] : "created_date";
    $sort_order = array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ? ToLower($_REQUEST["order"]) : "desc";
}
else
{
    $sort = array_key_exists("sort", $_REQUEST) && array_key_exists(ToLower($_REQUEST["sort"]), $arAvailableSort) ? $arAvailableSort[ToLower($_REQUEST["sort"])][0] : "PROPERTY_PRICE";
    $sort_order = array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ? ToLower($_REQUEST["order"]) : $arAvailableSort[$sort][1];
}

?>
<?
$banner=array();
$arFilter = Array(
    'IBLOCK_ID'=>$arParams["IBLOCK_ID"],
    'CODE'=>$arResult["VARIABLES"]["SECTION_CODE"],
);
$db_list = CIBlockSection::GetList(Array(), $arFilter,false,array("UF_BANNER_NAME"));
while($ar_result = $db_list->GetNext())
{
    if(strlen($ar_result["UF_BANNER_NAME"])>0){
        $banner[]=array(
            "NAME"=>$ar_result["UF_BANNER_NAME"],
            "DETAIL_PICTURE"=>$ar_result["PICTURE"],
            "PREVIEW_TEXT" =>$ar_result["DESCRIPTION"],
        );
    }else{
        $arFilter2 = Array(
            "IBLOCK_ID"=>6,
            "ACTIVE"=>"Y",
            "PROPERTY_TYPE"=>46,
            "PROPERTY_LINK"=>$ar_result['ID']
        );

        $res2 = CIBlockElement::GetList(Array("rand"=>"ASC"), $arFilter2, false,array("nTopCount"=>1),array("ID","NAME","DETAIL_PICTURE","PREVIEW_TEXT"));
        while($ar_fields2 = $res2->GetNext())
        {
            $banner[]=$ar_fields2;
        }
    }
	global $USER;
	if ($USER->IsAdmin()){
		//print_r($ar_result);
	}
}
//Если выбраны новинки или распродажи и выбрана категория то обрезаем секцию из префильтра

if(isset($preFilter["INCLUDE_SUBSECTIONS"]) && $preFilter["INCLUDE_SUBSECTIONS"]=="Y" && !empty($arrFCategory))
    unset($preFilter["SECTION_ID"]);
$arrFilterCat=array_merge($arrFilterCat,$preFilter);
/*if($USER->IsAdmin()){


echo "<pre>";
print_r($arrFilterCat);
echo "</pre>";

}*/
?>

<div class="base_content" id="product_html"><!-- PRODUCT_START -->
    <?if(count($banner)>0):?>
        <? $cfile=CFile::ResizeImageGet($banner[0]['DETAIL_PICTURE'], array('width'=>726, 'height'=>136), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
        <img width="726" height="136" alt="" src="<?=$cfile["src"]?>" class="collection_head_img">
        <h1><?=$banner[0]["NAME"]?></h1>
        <div class="collection_description"><?=$banner[0]["PREVIEW_TEXT"]?></div>
    <?endif;?>

    <?
    /*if($USER->IsAdmin()){
    echo "<pre>";
    print_r($arrFilterCat);
        print_r($_REQUEST);
    echo "</pre>";
    }*/
	
    ?>
    <?$APPLICATION->IncludeComponent(
        "pdev:catalog.section",
        "",
        Array(
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ELEMENT_SORT_FIELD" => $sort,
            "ELEMENT_SORT_ORDER" => $sort_order,
            "SHOW_ALL_WO_SECTION"=>"Y",
            "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
            "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
            "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
            "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
            "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
            "BASKET_URL" => $arParams["BASKET_URL"],
            "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
            "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
            "FILTER_NAME" => "arrFilterCat",
            "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_FILTER" => $arParams["CACHE_FILTER"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "SET_TITLE" => $arParams["SET_TITLE"],
            "SET_STATUS_404" => $arParams["SET_STATUS_404"],
            "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
            "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
            "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
            "PRICE_CODE" => $arParams["PRICE_CODE"],
            "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],

            "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
            "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
            "PAGER_TITLE" => $arParams["PAGER_TITLE"],
            "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
            "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
            "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
            "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
            "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

            "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
            "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
            "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
            "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
            "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
            "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

            "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
            "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
            "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
            "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
            "COUNT_ELEMENTS" => "N",
        ),
        $component
    );

    ?>

    <!-- PRODUCT_END --></div>
