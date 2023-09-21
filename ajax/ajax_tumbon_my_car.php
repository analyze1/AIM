<?php 
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$amphurID=$_POST['id'];
echo "<option value=''>--เลือกตำบล--</option>";
$tb_tumbon_sql="SELECT id,name FROM tb_tumbon WHERE amphurID = '".$amphurID."'";
$tb_tumbon_query=mysql_query($tb_tumbon_sql,$cndb1);
while($tb_tumbon_array=mysql_fetch_array($tb_tumbon_query))
{ ?>
<option value='<?php echo $tb_tumbon_array['id']; ?>'><?php echo $tb_tumbon_array['name']; ?></option>
<?php } ?>