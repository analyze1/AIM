<?php
include $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/define_connect.php";
class Context {
    public static function fourinsure_insured() {
        try {
            $nameDataBase = fourinsured;
            $hostIP = _LOCAL_HOST;
            $username = username_conn2;
            $password = password_conn2;
            $fourinsure_insured = new PDO("mysql:host=$hostIP; dbname=$nameDataBase", $username, $password);
            $fourinsure_insured->exec("set names utf8");
            return $fourinsure_insured;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>