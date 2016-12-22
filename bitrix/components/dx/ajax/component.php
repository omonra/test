<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$answer = array();

if($_POST['tag'] == 'AddToBasket') {
    if (isset($_POST['id']) && intval($_POST['id']) > 0) {
        AjaxIncModule('catalog');
        if (isset($_POST['count']) && intval($_POST['count'] > 0)) {
            $count = intval($_POST['count']);
        } else {
            $count = 1;
        }

        $id = intval($_POST['id']);
        $rsFields = CIBlockElement::GetList(array(), array(
            'IBLOCK_TYPE' => 'catalog',
            'ACTIVE' => 'Y',
            'ACTIVE_DATE' => 'Y',
            'ID' => $id,
        ), false, array('nTopCount' => 1), array('ID'));
        if ($arFields = $rsFields->GetNext()) {
            if(class_exists("CCatalogProductProviderStolnik"))
                $ret = Add2BasketByProductID($id, $count, array('PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProviderStolnik'), array());
            else
                $ret = Add2BasketByProductID($id, $count);
            
            if ($ret) {
                $answer = GetBasketJson();
                $answer['basket_id'] = $ret;
                $answer['ok'] = true;
            }
        } else {
            $answer['error'][] = 'product not found';
        }
    }
} elseif ($_POST['tag'] == 'DeleteFromBasket') {
    AjaxIncModule('sale');
    $id = intval($_POST['id']);
    if ($id > 0) {
        $deleted = false;
        $dbBasketItems = CSaleBasket::GetList( array("NAME" => "ASC"), array(
            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
            "LID" => 's1',
            "ORDER_ID" => "NULL",
            "ID" => $id,
        ), false, false, array("ID", "PRODUCT_ID", "QUANTITY"));
        if ($arBasketItems = $dbBasketItems->Fetch()) {
            if (CSaleBasket::Delete($id)) {
                $deleted = $arBasketItems['PRODUCT_ID'];
            }
        }
        $answer = GetBasketJson();
        $answer['id'] = $id;
        $answer['product_id'] = $deleted;
    }
} elseif ($_REQUEST['tag'] == 'ChangeBasketCount') {
    if (isset($_POST['id']) && intval($_POST['id']) > 0 && isset($_POST['count']) && intval($_POST['count']) > 0) {

        $id = intval($_POST['id']);
        $count = intval($_POST['count']);

        AjaxIncModule('sale');

        $arEl = CSaleBasket::GetByID($id);
        if ($arEl["QUANTITY"] > 0) {
            $arFields = array(
                "QUANTITY" => $count,
                "DELAY" => "N"
            );
            CSaleBasket::Update($id, $arFields);

            $answer = GetBasketJson();
            $answer['element_id'] = $id;
            $answer['count'] = $count;
        }
    }
} elseif ($_REQUEST['tag'] == 'ClearBasket') {
    $saleUserId = CSaleBasket::GetBasketUserID();
    if ($saleUserId > 0) {
        CSaleBasket::DeleteAll($saleUserId);
        $answer['ok'] = true;
    } else {
        $answer['error'] = 'Корзина не найдена';
    }
}

$APPLICATION->RestartBuffer();
header('Content-Type: application/json; charset='.LANG_CHARSET);


print(json_encode(toutf8_deep($answer)));
die();
?>
