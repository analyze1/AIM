<?php

include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";
//แผนที่1
/*$sqlClaim = "select claim_damage_list from tb_claim where id_data ='".$_POST['id_data']."' AND claim_no = '".$_POST['claim_no']."'";
$resClaim = mysql_query($sqlClaim, $cndb1) or die(mysql_error() . "Error Query [" . $query . "]");
$arrayClaim=mysql_fetch_array($resClaim);
if(!empty($arrayClaim['claim_damage_list']))
{
	$text=$arrayClaim['claim_damage_list'];
	$status='Y';
}
else
{
	$text='';
	$status='N';
}*/
//END แผนที่1
//แผนที่2
$sqlClaim = "SELECT claim_damage_list FROM tb_claim WHERE id_data ='$_POST[id_data]' AND id = '$_POST[id]'";

$resClaim = PDO_CONNECTION::fourinsure_mitsu()->query($sqlClaim);
$arrayClaim = $resClaim->fetch(2);

if(!empty($arrayClaim['claim_damage_list']))
{
	$text=$arrayClaim['claim_damage_list'];
	$status='Y';
}
else
{
	$text='';
	$status='N';
}
//END แผนที่2
$message['text'] = $text;
$message['status'] = $status;
echo json_encode($message);
?>