<?php
// require($_SERVER['DOCUMENT_ROOT'].'/allCon2018.php');

require('../DefineMain2021.php');

define('_USERNAME_MY4IB',_USER_NEW_MY4IB); 	//fourinsure_mitsu
define('_PASS_MY4IB',_PASS_NEW_MY4IB); 		//kalanchoe

define('_USERNAME_FOUR',_USER_NEW_FOUR); 	//fourinsure_new
define('_PASS_FOUR',_PASS_NEW_FOUR); 		//kalanchoe

$hostname_conn1 = _HOST_CONNECT;
$username_conn1 = _USERNAME_MY4IB;
$password_conn1 = _PASS_MY4IB;
$db1 = _DB_MY4IB_NEW;
$GLOBALS['cndb1'] = mysqli_connect($hostname_conn1,$username_conn1,$password_conn1);
mysql_select_db($db1,$cndb1);
mysql_set_charset('utf8');

$hostname_conn2=_HOST_CONNECT;
$username_conn2=_USERNAME_FOUR;
$password_conn2=_PASS_FOUR;
$db2=_DB_FOUR_INSURED;
$GLOBALS['cndb2'] = mysqli_connect($hostname_conn2,$username_conn2,$password_conn2);
mysql_select_db($db2,$cndb2);
mysql_set_charset('utf8');


$hostname_conn3= _HOST_CONNECT;
$username_conn3= _FourinsureAcountUser;
$password_conn3= _FourinsureAcountPass;
$db3=_DB_FOUR_ACCOUNT;
$GLOBALS['cndb3'] = mysqli_connect($hostname_conn3,$username_conn3,$password_conn3);
mysql_select_db($db3,$cndb3);
mysql_set_charset('utf8');

$hostname_conn4=_HOST_CONNECT;
$username_conn4=_USERNAME_MY4IB;
$password_conn4=_PASS_MY4IB;
$db4=_DB_MY4IB_SUBARU;
$GLOBALS['cndb4'] = mysqli_connect($hostname_conn4,$username_conn4,$password_conn4);
mysql_select_db($db4,$cndb4);
mysql_set_charset('utf8');

$hostname_conn5=_HOST_CONNECT;
$username_conn5=_USERNAME_FOUR;
$password_conn5=_PASS_FOUR;
$db5=_DB_FOUR_MBLT;
$GLOBALS['cndb5'] = mysqli_connect($hostname_conn5,$username_conn5,$password_conn5);
mysql_select_db($db5,$cndb5);
mysql_set_charset('utf8');

$hostname_conn6=_HOST_CONNECT;
$username_conn6=_USERNAME_MY4IB;
$password_conn6=_PASS_MY4IB;
$db6=_DB_MY4IB_BIGBIKE;
$GLOBALS['cndb6'] = mysqli_connect($hostname_conn6,$username_conn6,$password_conn6);
mysql_select_db($db6,$cndb6);
mysql_set_charset('utf8');
  
$hostname_connHr=_HOST_CONNECT;
$username_connHr=_USERNAME_FOUR;
$password_connHr=_PASS_FOUR;
$db_hr=_DB_FOUR_HR;
$GLOBALS['cndb_hr'] = mysqli_connect($hostname_connHr,$username_connHr,$password_connHr);
mysql_select_db($db_hr,$cndb_hr);
mysql_set_charset('utf8');

$hostname_conn_PayOnl=_HOST_CONNECT;
$username_conn_PayOnl=_USERNAME_FOUR;
$password_conn_PayOnl=_PASS_FOUR;
$db_PayOnl=_DB_FOUR_PAYMENTONLINE;
$GLOBALS['cndb_PayOnl'] = mysqli_connect($hostname_conn_PayOnl,$username_conn_PayOnl,$password_conn_PayOnl);
mysql_select_db($db_PayOnl,$cndb_PayOnl);
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