<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$id_data = $_POST['id_data'];
$list_tel=$_POST['list_tel'];
$teladd=$_POST['teladd'];
$select_tel_sql="SELECT tel_mobi_2 FROM insuree WHERE id_data = '".$id_data."'";
$select_tel_query=mysql_query($select_tel_sql,$cndb1);
$select_tel_array=mysql_fetch_array($select_tel_query);
$detail_tel='';
for($n=0;$n<count($list_tel);$n++)
{
	$detail_tel.=$list_tel[$n]."/".$teladd[$n]."|";
}
$update_tel_sql="UPDATE insuree SET tel_mobi_2 = '".$select_tel_array['tel_mobi_2'].$detail_tel."' WHERE id_data = '".$id_data."'";
$update_tel_query=mysql_query($update_tel_sql,$cndb1);
if($update_tel_query)
{
	$olo['alert']='บันทึกเบอร์โทรเรียบร้อยแล้ว!';
	$olo['status']='Y';
}
else
{
	$olo['alert']='บันทึกผิดพลาด เนื่องจาก session หมดอายุ ล็อกอินเข้าระบบใหม่ครับ';
	$olo['status']='N';
}
echo json_encode($olo);
?>
