<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<? 
$mobile_redirect=COption::GetOptionString('svc.mobile','mobile_redirect','');
if(empty($_SESSION['main_version'])&&$mobile_redirect=="Y") {
	$url=$_REQUEST['URL'];
	$mobile_folder=COption::GetOptionString('svc.mobile','mobile_folder','');
	$mobile_url=COption::GetOptionString('svc.mobile','mobile_url','');
	if(empty($mobile_url)) {
		$mobile_url=$_SERVER['HTTP_HOST'].'/'.$mobile_folder.'/';
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/svc.mobile/mobiledetect/Mobile_Detect.php';
	$detect = new Mobile_Detect();
	if(strpos($url,$mobile_url)===false) {
		if ( $detect->isMobile()||$detect->isTablet()) {
			$arReturn="Y";
			header('Content-type: application/json');
			echo json_encode($arReturn);
		}
	}
}
?>