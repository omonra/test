<?
define('NO_BACKLINE', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/app/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//LocalRedirect('/app/catalog/?ELEMENT_ID=452105');
//$APPLICATION->SetPageProperty("BodyClass", "main");
?>

<? include(__DIR__."/include/index_menu.php"); ?>

<? include(__DIR__."/include/index_new.php"); ?>
<hr/>
<? include(__DIR__."/include/index_sale.php"); ?>

<script>
app.exec("getToken", {
    callback:function(token)
    {
    var platform = (window.platform == "ios"? "APPLE": "GOOGLE");
    
    var config =
    {
        url: "/app/ajax/token.php" ,
        method: "POST",
        data: {
            device_name: (typeof device.name == "undefined" ? device.model : device.name),
            uuid: device.uuid,
            device_token: token,
            app_id: "<?=BX_APP_NAME?>",
            device_type: platform,
            sessid: BX.bitrix_sessid()
        }
    };

    BX.ajax(config);
}

});    
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>