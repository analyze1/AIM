<?php @include "../pages/check-ses.php";
include "../inc/connectdbs.inc.php";
mysql_select_db($db2,$cndb2);
//$USER = 'PATT';
//if(!empty($_POST['tel']) && !empty($_POST['message']) && !empty($USER)){
	if($_SESSION['claim']=='ADMIN')
	{
		$name_user=$_SESSION['strUser'];
	}
	else
	{
		$name_user='DEALER';
	}
	
							
	$strsql = "INSERT INTO smsdetail (`sms_id` ,`sms_user` ,`sms_text` ,`sms_tel` ,`smsid_data`,`sms_time`) VALUES (NULL, '".$name_user."','".$_POST['message']."','".$_POST['tel']."','".$_POST['tdataid']."','".date('Y-m-d h:m:i')."')";							
	if($objQuery = mysql_query($strsql,$cndb2)){
		$ACCOUNT="post@fourinsura";
		$PASSWORD="C699D09939D5BBF231EF67D073E3373C170F03D33C74FC1495F2B42744CE324E"; //"C699D09939D5BBF231EF67D073E3373C9C5A971CBEBCC45575CDB52CF9C3AEE4";
		$MOBILE= $_POST['tel'];
		$smstext = $_POST['message'];
		$MESSAGE= iconv('UTF-8','TIS-620',$smstext);
		$LANGUAGE = "T";
		$ch = curl_init("https://sc4msg.com/bulksms/SendMessage");  //curl_init("https://203.146.102.26/smartcomm2/SendMessage");      
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,"ACCOUNT=".$ACCOUNT."&PASSWORD=".$PASSWORD."&MOBILE=".$MOBILE."&MESSAGE=".$MESSAGE."&LANGUAGE=T");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$data = curl_exec($ch);
//	}
		echo "ส่ง sms ถึงลูกค้าเรียบร้อยแล้วครับ";
}
else
{
	echo "ส่ง sms ล้มเหลวครับ";
}
?>