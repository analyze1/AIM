<?php
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$id=$_POST['id'];
$tb_postal_sql="SELECT id_post FROM tb_tumbon WHERE id = '".$id."'";
$tb_postal_query=mysql_query($tb_postal_sql,$cndb1);
$tb_postal_array=mysql_fetch_array($tb_postal_query);
echo $tb_postal_array['id_post'];
?>