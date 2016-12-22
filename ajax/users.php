<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); ?>

<?
global $USER;
if(!is_object($USER))
	$USER = new CUser;
if ($_REQUEST['mode'] == 'LOGIN') {
	$res = $USER->Login($_REQUEST['email'], $_REQUEST['password'], "Y");
	if(empty($res['MESSAGE']))
		$result['status'] = true;
	else
		$result['message'] = strip_tags($res['MESSAGE']);
}

if ($_REQUEST['mode'] == 'EXIT') {
	     $USER->logout();
      $result['status'] = true;
}

if ($_REQUEST['mode'] == 'REGISTER') {
$arFields = Array(
  "NAME"              => $_REQUEST['reg_login'],
  "LAST_NAME"         => $_REQUEST['reg_login'],
  "PERSONAL_PHONE"    => $_REQUEST['reg_phone'],
  "LOGIN"             => $_REQUEST['reg_login'],
  "LID"               => SITE_ID,
  "ACTIVE"            => "Y",
  "PASSWORD"          => $_REQUEST['reg_pass'],
  "CONFIRM_PASSWORD"  => $_REQUEST['reg_pass']
);
if(!empty($_REQUEST['reg_email'])) {
  $arFields['EMAIL']=$_REQUEST['reg_email'];

}

$ID = $USER->Add($arFields);
CUser::SendUserInfo($ID, SITE_ID, "");
      if($ID)
       {
          $result['status'] = true;
          $res = $USER->Login($_REQUEST['reg_login'],$_REQUEST['reg_pass'],"Y");
       } 
      else
        //$result['message']=  'error';
        $result['message']=$USER->LAST_ERROR;

	}
exit(json_encode($result));
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>