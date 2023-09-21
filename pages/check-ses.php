<?php

session_start();

if (empty($_SESSION["strName"])) {
	session_destroy();
	echo "<script>location.href = 'login.php';</script>";
	exit();
}

if ($_SESSION["name"] != 'Mitsubishi' && $_SESSION["name"] != 'My4ib') {
	session_destroy();
	echo "<script>location.href = 'login.php';</script>";
	exit();
}