<?
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/../..");
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define('CHK_EVENT', true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

@set_time_limit(0);
@ignore_user_abort(true);

CAgent::CheckAgents();
define("BX_CRONTAB_SUPPORT", true);
define("BX_CRONTAB", true);
CEvent::CheckEvents();

return;
?>


<?
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../..');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

//����������� ������ ������
if(CModule::IncludeModule('search'))
{
    //� ���� ������� ����� ������������ ������ "���������". �� �� �������� ����������� ��������� ����������.
    $NS=Array();
    //������ ������������ ������������ ����� �������� ������ "�������������".
    $sm_max_execution_time = 0;
    //��� ������������ ���������� ������ �������������� �� ���� ���.
    //��������� ������� �������� �������� �������� � ������������ ������� ������������������.
    $sm_record_limit = 5000;
    do {
        $cSiteMap = new CSiteMap;
        //��������� �������� ��������,
        $NS = $cSiteMap->Create("s1", array($sm_max_execution_time, $sm_record_limit), $NS);
        //���� ����� ����� �� ����� �������.
    } while(is_array($NS));
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
