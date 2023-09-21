<?php
include "../../inc/connectdbs.pdo.php";
	//car_seat
	if($_POST['TYPE']=='SEAT')
	{
	$se_protect_sql="SELECT people FROM protect_09712 WHERE car_id = '".$_POST['idprp'].$_POST['id_car']."'";
		$se_protect_query=mysql_query($se_protect_sql);
		$se_protect_array=mysql_fetch_array($se_protect_query);
		$people=$se_protect_array['people']+1;
	if(!empty($_POST['idprp']) && !empty($_POST['id_car']) && !empty($people))
	{
		$car_seat='<option value="'.$people.'" selected="selected">ไม่เกิน '.$people.' ที่นั่ง</option>';
	}
	else
	{
		$car_seat='<option value="0" selected="selected">กรุณาเลือก</option>';
	}
	$car_seat.='<option value="3">ไม่เกิน 3 ที่นั่ง</option><option value="7">ไม่เกิน 7 ที่นั่ง</option>';
	
	}
$returnedArray['seat']=$car_seat;
echo json_encode($returnedArray);

mysql_close();
?>