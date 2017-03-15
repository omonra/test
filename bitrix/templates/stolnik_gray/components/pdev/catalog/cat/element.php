<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?CModule::IncludeModule("iblock");?>
<?$APPLICATION->SetPageProperty("catalog_product", "product_content");?>
<div class="base_content in_card product_content product_content_a">
    <?/*$APPLICATION->IncludeComponent(
    "bitrix:breadcrumb",
    "",
    Array(
        "START_FROM" => "0",
        "PATH" => "",
        "SITE_ID" => "s1"
    ),
    false
);*/?>
    <?
    $dbElement = CIBlockElement::GetList(
        array('SORT' => 'ASC'),
        array(
            'IBLOCK_ID' => $arParams["IBLOCK_ID"],
            "ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
            "CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
        ),
        false,
        false,
        array('ID','IBLOCK_ID')
    );
    if($arElement = $dbElement->Fetch()){
        $ID=$arElement["ID"];
    }
    $tab=1;
//���������� �������
    if(isset($_REQUEST["action"]) && $_REQUEST["action"]=="comment_add" && $ID>0){
        $tab=2;
        if ($APPLICATION->CaptchaCheckCode($_POST["captcha_word"], $_POST["captcha_sid"]))
        {
            if(strlen($_REQUEST["NAME"])>0 && strlen($_REQUEST["review_voted"])>0 && strlen($_REQUEST["MESSAGE"])>0 ){
                $el = new CIBlockElement;

                $PROP = array();
                $PROP[52] = $_REQUEST["NAME"];  // NAME
                $PROP[53] = $_REQUEST["LAST_NAME"];  // LAST_NAME
                $PROP[54] = $_REQUEST["EMAIL"];  // EMAIL
                $PROP[55] = $_REQUEST["review_voted"];  // RATING
                $PROP[56] = $ID;  // PRODUCT_ID

                $arLoadProductArray = Array(
                    "MODIFIED_BY"    => $USER->GetID(), // ������� ������� ������� �������������
                    "IBLOCK_SECTION_ID" => false,          // ������� ����� � ����� �������
                    "IBLOCK_ID"      => 11,
                    "PROPERTY_VALUES"=> $PROP,
                    "NAME"           => "Comment ".$ID." ".$_REQUEST["LAST_NAME"]." ".$_REQUEST["NAME"]." ".$_REQUEST["EMAIL"],
                    "ACTIVE"         => "Y",            // �������
                    "DETAIL_TEXT"    => $_REQUEST["MESSAGE"],
                );

                $COMMENT_ID = $el->Add($arLoadProductArray);
                unset($_REQUEST["NAME"]);
                unset($_REQUEST["LAST_NAME"]);
                unset($_REQUEST["EMAIL"]);
                unset($_REQUEST["review_voted"]);
                unset($_REQUEST["MESSAGE"]);
            }else{
                global $er;
                $er='��������� ��� ������������ ����';
            }
        }else{
            global $er;
            $er='�� ��������� ������� �����';
        }
    }

//����� ��������


    $comments=array();
    $dbElement = CIBlockElement::GetList(
        array('SORT' => 'ASC'),
        array(
            'IBLOCK_ID' => 11,
            'ACTIVE' => 'Y',
            'PROPERTY_PRODUCT_ID'=>$ID,
        ),
        false,
        false,
        array('ID','IBLOCK_ID','NAME','DETAIL_TEXT','DATE_CREATE','PROPERTY_NAME','PROPERTY_LAST_NAME','PROPERTY_EMAIL','PROPERTY_RATING','PROPERTY_PRODUCT_ID')
    );
    while($arElement = $dbElement->Fetch()){
        $comments[]=$arElement;
    }

    include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
    $code=$APPLICATION->CaptchaGetCode();

    ?>
    <?$ElementID=$APPLICATION->IncludeComponent(
    "bitrix:catalog.element",
    "",
    Array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "COMMENTS" => $comments,
        "CAPTCHA" =>$code,
        "TAB"=>$tab,
        "PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
        "META_KEYWORDS" => $arParams["DETAIL_META_KEYWORDS"],
        "META_DESCRIPTION" => $arParams["DETAIL_META_DESCRIPTION"],
        "BROWSER_TITLE" => $arParams["DETAIL_BROWSER_TITLE"],
        "BASKET_URL" => $arParams["BASKET_URL"],
        "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
        "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
        "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
        "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "SET_TITLE" => $arParams["SET_TITLE"],
        "SET_STATUS_404" => $arParams["SET_STATUS_404"],
        "PRICE_CODE" => $arParams["PRICE_CODE"],
        "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
        "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
        "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
        "PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
        "LINK_IBLOCK_TYPE" => $arParams["LINK_IBLOCK_TYPE"],
        "LINK_IBLOCK_ID" => $arParams["LINK_IBLOCK_ID"],
        "LINK_PROPERTY_SID" => $arParams["LINK_PROPERTY_SID"],
        "LINK_ELEMENTS_URL" => $arParams["LINK_ELEMENTS_URL"],
        "ADD_SECTIONS_CHAIN" => "N",
        "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
        "OFFERS_FIELD_CODE" => $arParams["DETAIL_OFFERS_FIELD_CODE"],
        "OFFERS_PROPERTY_CODE" => $arParams["DETAIL_OFFERS_PROPERTY_CODE"],
        "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
        "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],

        "ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
        "ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
        "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
        "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
    ),
    $component
);?>
    <?if($arParams["USE_REVIEW"]=="Y" && IsModuleInstalled("forum") && $ElementID):?>
    <br />
    <?$APPLICATION->IncludeComponent(
        "bitrix:forum.topic.reviews",
        "",
        Array(
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "MESSAGES_PER_PAGE" => $arParams["MESSAGES_PER_PAGE"],
            "USE_CAPTCHA" => $arParams["USE_CAPTCHA"],
            "PATH_TO_SMILE" => $arParams["PATH_TO_SMILE"],
            "FORUM_ID" => $arParams["FORUM_ID"],
            "URL_TEMPLATES_READ" => $arParams["URL_TEMPLATES_READ"],
            "SHOW_LINK_TO_FORUM" => $arParams["SHOW_LINK_TO_FORUM"],
            "ELEMENT_ID" => $ElementID,
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "AJAX_POST" => $arParams["REVIEW_AJAX_POST"],
            "POST_FIRST_MESSAGE" => $arParams["POST_FIRST_MESSAGE"],
            "URL_TEMPLATES_DETAIL" => $arParams["POST_FIRST_MESSAGE"]==="Y"? $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"] :"",
        ),
        $component
    );?>
    <?endif?>
    <?if($arParams["USE_ALSO_BUY"] == "Y" && IsModuleInstalled("sale") && $ElementID):?>

    <?$APPLICATION->IncludeComponent("bitrix:sale.recommended.products", ".default", array(
            "ID" => $ElementID,
            "MIN_BUYES" => $arParams["ALSO_BUY_MIN_BUYES"],
            "ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
            "LINE_ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
            "DETAIL_URL" => $arParams["DETAIL_URL"],
            "BASKET_URL" => $arParams["BASKET_URL"],
            "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
            "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "PRICE_CODE" => $arParams["PRICE_CODE"],
            "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
        ),
        $component
    );

    ?>
    <?endif?>
</div>
