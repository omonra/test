<?
define("DBPersistent", false);
$DBType = "mysql";
$DBHost = "localhost";
$DBLogin = "stolnilk_0";
$DBPassword = "hqJiiS4t";
$DBName = "stolnilk_0";
$DBDebug = false;
$DBDebugToFile = false;

define("DELAY_DB_CONNECT", true);
define("CACHED_b_file", 3600);
define("CACHED_b_file_bucket_size", 10);
define("CACHED_b_lang", 3600);
define("CACHED_b_option", 3600);
define("CACHED_b_lang_domain", 3600);
define("CACHED_b_site_template", 3600);
define("CACHED_b_event", 3600);
define("CACHED_b_agent", 3660);
define("CACHED_menu", 3600);

define("BX_FILE_PERMISSIONS", 0644);
define("BX_DIR_PERMISSIONS", 0755);
@umask(~BX_DIR_PERMISSIONS);
@ini_set("memory_limit", "2048M");
define("BX_DISABLE_INDEX_PAGE", true);

error_reporting(0);
@set_time_limit(800);
define("BX_COMP_MANAGED_CACHE", true);

if(!(defined("CHK_EVENT") && CHK_EVENT===true))
   define("BX_CRONTAB_SUPPORT", true);
