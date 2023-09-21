<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
if (empty($_SESSION["strName"])) {
	session_destroy();
	echo '<script>location.href = \'../login.php\';</script>';
}
if ($_SESSION["name"] != 'Mitsubishi' && $_SESSION["name"] != 'My4ib') {
	session_destroy();
	echo '<script>location.href = \'../login.php\';</script>';
}
