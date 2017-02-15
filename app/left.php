<?

define('NO_NAVIGATION', true);
require($_SERVER["DOCUMENT_ROOT"] . "/app/headers.php");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
CModule::IncludeModule('pull');
CJSCore::Init(array('pull'));
$APPLICATION->AddHeadString('
	<script type="text/javascript">
		app.enableSliderMenu(true);
	</script>
');
?>
<?

CMobile::getInstance()->setLargeScreenSupport(false);
CMobile::getInstance()->setScreenCategory("NORMAL");
?>
<?

$APPLICATION->IncludeComponent("bitrix:menu", "left", Array(
    "ROOT_MENU_TYPE" => "left",
    "MAX_LEVEL" => "1",
    "CHILD_MENU_TYPE" => "left",
    "USE_EXT" => "N",
    "DELAY" => "N",
    "ALLOW_MULTI_SELECT" => "Y",
    "MENU_CACHE_TYPE" => "N",
    "MENU_CACHE_TIME" => "3600",
    "MENU_CACHE_USE_GROUPS" => "Y",
    "MENU_CACHE_GET_VARS" => ""
        )
);
?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php") ?>