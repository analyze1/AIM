<?php
include "../../inc/connectdbs.pdo.php";
echo base64_encode($hostname_conn.$username_conn.$password_conn.$database_conn);
?>