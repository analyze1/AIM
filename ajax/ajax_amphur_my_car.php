<?php 
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$provinceID=$_POST['id'];
echo "<option value=''>--เลือกอำเภอ--</option>";
$tb_amphur_sql="SELECT id,name FROM tb_amphur WHERE provinceID = '".$provinceID."'";
$tb_amphur_query=mysql_query($tb_amphur_sql,$cndb1);
while($tb_amphur_array=mysql_fetch_array($tb_amphur_query))
{ ?>
<option value='<?php echo $tb_amphur_array['id']; ?>'><?php echo $tb_amphur_array['name']; ?></option>
<?php } ?>