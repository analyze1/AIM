<?php

// header('Content-Type: application/json');
// http_response_code(200);

$UrlA = explode('/', $_SERVER['REQUEST_URI']);
require($_SERVER['DOCUMENT_ROOT'] . "/{$UrlA[1]}/DefineMain2021.php");
// require($_SERVER['DOCUMENT_ROOT'] . "/DefineMain2021.php");

define('_USERNAME_MY4IB', _USER_NEW_MY4IB);
define('_PASS_MY4IB', _PASS_NEW_MY4IB);

define('_USERNAME_FOUR', _USER_NEW_FOUR);
define('_PASS_FOUR', _PASS_NEW_FOUR);

// define('_MitsubishiUser', _USER_NEW_MITSU);
// define('_MitsubishiPass', _PASS_NEW_MITSU);

PDO_CONNECTION::$hostnameRenew = _HOST_CONNECT;
PDO_CONNECTION::$usernameRenew = _USER_NEW_MITSU;
PDO_CONNECTION::$passwordRenew = _PASS_NEW_MITSU;
PDO_CONNECTION::$baseNameRenew = _DB_MitSu_ACCOUNT;

PDO_CONNECTION::$hostname_connMy4ib = _HOST_CONNECT;
PDO_CONNECTION::$username_connMy4ib = _USERNAME_MY4IB;
PDO_CONNECTION::$password_connMy4ib = _PASS_MY4IB;
PDO_CONNECTION::$db_My4ib = _DB_MY4IB_NEW;

PDO_CONNECTION::$hostname_connFour = _HOST_CONNECT;
PDO_CONNECTION::$username_connFour = _USERNAME_FOUR;
PDO_CONNECTION::$password_connFour = _PASS_FOUR;
PDO_CONNECTION::$db_Four = _DB_FOUR_INSURED;

PDO_CONNECTION::$hostname_connAccount = _HOST_CONNECT;
PDO_CONNECTION::$username_connAccount = _FourinsureAcountUser;
PDO_CONNECTION::$password_connAccount = _FourinsureAcountPass;
PDO_CONNECTION::$db_Account = _DB_FOUR_ACCOUNT;

PDO_CONNECTION::$hostname_ConnMitSu = _HOST_CONNECT;
PDO_CONNECTION::$username_ConnMitSu = _USER_NEW_MITSU;
PDO_CONNECTION::$password_ConnMitSu = _PASS_NEW_MITSU;
PDO_CONNECTION::$db_MisSu = _DB_MitSu_ACCOUNT;

class PDO_CONNECTION
{
    public static $hostname_connMy4ib;
    public static $username_connMy4ib;
    public static $password_connMy4ib;
    public static $db_My4ib;

    public static $hostname_connFour;
    public static $username_connFour;
    public static $password_connFour;
    public static $db_Four;

    public static $hostname_connAccount;
    public static $username_connAccount;
    public static $password_connAccount;
    public static $db_Account;

    public static $hostnameRenew;
    public static $usernameRenew;
    public static $passwordRenew;
    public static $baseNameRenew;

    /******** mitsubishi **************/
    public static $hostname_ConnMitSu;
    public static $username_ConnMitSu;
    public static $password_ConnMitSu;
    public static $db_MisSu;

    public static function my4ibRenew()
    {
        $fourinsure_mitsu = new PDO("mysql:dbname=" . PDO_CONNECTION::$baseNameRenew . ";host=" . PDO_CONNECTION::$hostnameRenew . ";", PDO_CONNECTION::$usernameRenew, PDO_CONNECTION::$passwordRenew);
        $fourinsure_mitsu->exec("set names utf8");
        return $fourinsure_mitsu;
    }

    public static function my4ib_new()
    {
        $fourinsure_mitsu = new PDO("mysql:dbname=" . PDO_CONNECTION::$db_My4ib . ";host=" . PDO_CONNECTION::$hostname_connMy4ib . ";", PDO_CONNECTION::$username_connMy4ib, PDO_CONNECTION::$password_connMy4ib);
        $fourinsure_mitsu->exec("set names utf8");
        return $fourinsure_mitsu;
    }

    public static function fourinsure_insured()
    {
        $fourinsure_insured = new PDO("mysql:dbname=" . PDO_CONNECTION::$db_Four . ";host=" . PDO_CONNECTION::$hostname_connFour . ";", PDO_CONNECTION::$username_connFour, PDO_CONNECTION::$password_connFour);
        $fourinsure_insured->exec("set names utf8");
        return $fourinsure_insured;
    }

    public static function fourinsure_account()
    {
        $fourinsure_account = new PDO("mysql:dbname=" . PDO_CONNECTION::$db_Account . ";host=" . PDO_CONNECTION::$hostname_connAccount . ";", PDO_CONNECTION::$username_connAccount, PDO_CONNECTION::$password_connAccount);
        $fourinsure_account->exec("set names utf8");
        return $fourinsure_account;
    }
    public static function fourinsure_mitsu()
    {
        $fourinsure_mitsu = new PDO("mysql:dbname=" . PDO_CONNECTION::$db_MisSu . ";host=" . PDO_CONNECTION::$hostname_ConnMitSu . ";", PDO_CONNECTION::$username_ConnMitSu, PDO_CONNECTION::$password_ConnMitSu);
        $fourinsure_mitsu->exec("set names utf8");
        return $fourinsure_mitsu;
    }
}
