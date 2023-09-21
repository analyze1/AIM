<?php
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$br_id=$_POST['br_id'];
$select_mo_car_sql="SELECT tb_mo_car.id,tb_mo_car.name FROM tb_mo_car
INNER JOIN tb_mo_car_sub ON (tb_mo_car.id = tb_mo_car_sub.mo_car)
WHERE tb_mo_car.br_id = '".$br_id."' AND tb_mo_car_sub.status_subcar = 'T' GROUP BY tb_mo_car.id";
$select_mo_car_query=mysql_query($select_mo_car_sql,$cndb1); ?>
<option value=''>--กรุณาเลือกรุ่นรถ--</option>
<?php while($select_mo_car_array=mysql_fetch_array($select_mo_car_query))
{ ?>
<option value='<?php echo $select_mo_car_array['id']; ?>'><?php echo $select_mo_car_array['name']; ?></option>
<?php } ?>