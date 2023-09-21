<?php
include "../check-ses.php";
include "../../inc/connectdbs.pdo.php";


	$CHECKCARBODY = $_POST['CHECKCARBODY'];
	
	
	$sql = "SELECT COUNT(*) FROM detail WHERE car_body='$CHECKCARBODY'";
	$result = mysql_query( $sql );
	$total = mysql_fetch_array($result);
		$returnedArray['STATUS']=$total[0];
		$returnedArray['TEXT']="เลขตัวถังนี้ ".$CHECKCARBODY." ได้มีการแจ้งงานอยู่ในระบบแล้วครับ";
	if($total[0]==0 && $_SESSION['strUser']!='admin')
	{
	$sql = "SELECT COUNT(*) FROM tb_blacklist_car WHERE car_body='$CHECKCARBODY'";
	$result = mysql_query( $sql );
	$total = mysql_fetch_array($result);
	$returnedArray['STATUS']=$total[0];
	$returnedArray['TEXT']="เลขตัวถังนี้ ".$CHECKCARBODY." เป็นรถทดลองขับ\n**โปรดติดต่อเจ้าหน้าที่เพื่อจัดการแจ้งประกันภัยให้\n093-323-8814,085-921-5454";
	}
		
echo json_encode($returnedArray);

?>