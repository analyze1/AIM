<?php
// include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";
include "../services/Log/log_login.php";
session_start();
if (!empty($_SESSION["strUser"])) {
	// $log_user = $_SESSION["strUser"];
	// $log_ip = $_SERVER['REMOTE_ADDR'];
	// $log_url = $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];

	// $str = "INSERT INTO log_url (log_url,log_date,log_ip,log_user,log_value_post,log_value_get) 
	// VALUES (:log_url,:log_date,:log_ip,:log_user,:log_value_post,:log_value_get)";
	// $param = [
	// 	'log_url' => $log_url,
	// 	'log_date' => date('Y-m-d H:i:s'),
	// 	'log_ip' => $log_ip,
	// 	'log_user' => $log_user,
	// 	'log_value_post' => json_encode($_POST),
	// 	'log_value_get' => json_encode($_GET)
	// ];
	// PDO_CONNECTION::fourinsure_mitsu()
	// 	->prepare($str)
	// 	->execute($param);

	/*$log_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$log_date = date('Y-m-d');
	$log_page = $_POST['log_page'];
	$log_url_array = explode('/', $log_url);
	$log_page_next = "";
	$logbrowser = $user_browser;
	$logos = $user_os;
	$check_log_sql = "SELECT log_ip,log_id,UserBrowser,OS,log_page FROM log_url WHERE log_user = '" . $log_user . "' AND log_ip = '" . $log_ip . "' AND UserBrowser = '$logbrowser' AND OS = '$logos' AND log_name = '" . $log_name . "' AND DATE(log_date) = '" . $log_date . "' AND log_url LIKE '%" . $log_url_array[1] . "%'";
	$check_log_array = PDO_CONNECTION::fourinsure_account()->query($check_log_sql)->fetch(2);

	if ($check_log_array == null) {
		$insert_log_sql = "INSERT INTO log_url (log_user,log_ip,UserBrowser,OS,log_name,log_date,log_url,log_page) VALUES ('$log_user','$log_ip','$logbrowser','$logos','$log_name',NOW(),'$log_url','$log_page')";
		PDO_CONNECTION::fourinsure_account()->prepare($insert_log_sql)->execute();
	} else {
		$check_page_sql = "SELECT log_id FROM log_url  WHERE log_id = '$check_log_array[log_id]' AND log_page LIKE '%" . $log_page . "%'";
		$check_page_array = PDO_CONNECTION::fourinsure_account()->query($check_page_sql)->fetch(2);
		if ($check_page_array == null) {
			if ($check_log_array['log_page'] != '') {
				$log_page_next = $check_log_array['log_page'] . "|" . $log_page;
			} else {
				$log_page_next = $log_page;
			}

			$update_log_sql = "UPDATE log_url SET log_page = '" . $log_page_next . "' WHERE log_id = '" . $check_log_array['log_id'] . "'";
			PDO_CONNECTION::fourinsure_account()->prepare($update_log_sql)->execute();
		}
	}*/
}