<?php
require('./DefineMain2021.php');

define('_USERNAME_MY4IB',_USER_NEW_MY4IB); 	//fourinsure_mitsu
define('_PASS_MY4IB',_PASS_NEW_MY4IB); 		//kalanchoe

define('_USERNAME_FOUR',_USER_NEW_FOUR); 	//fourinsure_new
define('_PASS_FOUR',_PASS_NEW_FOUR); 		//kalanchoe

$hostname_conn = _HOST_CONNECT;
$username_conn = _USERNAME_MY4IB;
$password_conn = _PASS_MY4IB;
$database_conn = _DB_MY4IB_NEW;
$obj_connect = mysql_connect( $hostname_conn , $username_conn , $password_conn );
$obj_select = mysql_select_db( $database_conn ); 
mysql_set_charset('utf8');

if(!defined('_WEBNAME_FOUR_OLD')) define('_WEBNAME_FOUR_OLD','บริษัท โฟร์ อินชัวร์ โบรกเกอร์ จำกัด');
if(!defined('_WEBNAME_FOUR_OLD_EN')) define('_WEBNAME_FOUR_OLD_EN','FOUR INSURED BROKER CO.,LTD.');

if(!defined('_WEBNAME_FOUR')) define('_WEBNAME_FOUR','บริษัท โฟร์ อินชัวรันส์ โบรกเกอร์ จำกัด');
if(!defined('_WEBNAME_FOUR_EN')) define('_WEBNAME_FOUR_EN','FOUR INSURANCE BROKER CO.,LTD.');
if(!defined('_WEBNAME_FOUR_ADDR')) define('_WEBNAME_FOUR_ADDR','62/11 หมู่ที่ 1 ถนนราชพฤกษ์ ตำบลอ้อมเกร็ด อำเภอปากเกร็ด จังหวัดนนทบุรี 11120');
if(!defined('_WEBNAME_FOUR_TAX')) define('_WEBNAME_FOUR_TAX','0125551001457');
if(!defined('_WEBNAME_FOUR_TEL')) define('_WEBNAME_FOUR_TEL','02-196-8234');
if(!defined('_WEBNAME_FOUR_FAX')) define('_WEBNAME_FOUR_FAX','02-196-8235');
if(!defined('_WEBNAME_FOUR_ASSIST')) define('_WEBNAME_FOUR_ASSIST','assist@my4ib.com');
if(!defined('_AEON_STATUS')) define('_AEON_STATUS','Y');
?>