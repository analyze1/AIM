<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";

$_contextMitsu = PDO_CONNECTION::fourinsure_mitsu();
$list_tel = $_POST['list_tel'];
$num_tel = $_POST['teladd'];

$txt_claim =  str_replace(",", "", $_POST["txt_claim"]);

$strSQL = "UPDATE detail SET car_regis='" . $_POST['car_regis'] . "',car_regis_pro='" . $_POST['car_regis_pro'] . "' WHERE id_data='" . $_POST['OQ'] . "'";
$result = $_contextMitsu->prepare($strSQL)->execute();

$strSQL = "UPDATE insuree SET person='" . $_POST['person'] . "',icard='" . $_POST['icard'] . "',icard_niti='" . $_POST['icard_niti'] . "',insuree.add='" . $_POST['add'] . "',insuree.group='" . $_POST['group'] . "'
	,town='" . $_POST['town'] . "',lane='" . $_POST['lane'] . "',road='" . $_POST['road'] . "',province='" . $_POST['province'] . "',amphur='" . $_POST['amphur'] . "',tumbon='" . $_POST['tumbon'] . "'
	,postal='" . $_POST['postal'] . "'
	,claim_amount='" . $txt_claim . "'
	,policy_amount='" . $_POST['txt_policy'] . "'
	 WHERE id_data='" . $_POST['OQ'] . "'";

$result = $_contextMitsu->prepare($strSQL)->execute();

for ($i = 0; $i < count($list_tel); $i++) {
	if ($num_tel[$i] != '') {
		$new_tel = $new_tel . $list_tel[$i] . '/' . $num_tel[$i] . '|';
	}
}

if ($_POST['idline'] != '') {
	$strSQL = "UPDATE insuree SET id_line='" . $_POST['idline'] . "' WHERE id_data='" . $_POST['OQ'] . "'";

	$result = $_contextMitsu->prepare($strSQL)->execute();
}
if ($_POST['email'] != '') {
	$strSQL = "UPDATE insuree SET email='" . $_POST['email'] . "' WHERE id_data='" . $_POST['OQ'] . "'";

	$result = $_contextMitsu->prepare($strSQL)->execute();
}
if ($new_tel != '') {
	$strSQL = "UPDATE insuree SET tel_mobi_2='" . $new_tel . "' WHERE id_data='" . $_POST['OQ'] . "'";

	$result = $_contextMitsu->prepare($strSQL)->execute();
}

if ($_POST['blist1'] != '') {
	$strSQL = "insert into tb_blacklist (bl_id,bl_name,bl_data,bl_remark,bl_type,bl_cusstatus,addby,bl_status) values ('','','" . $_POST['blist1'] . "','" . $_POST['blist_remark1'] . "','Tel','C','" . $_SESSION["strUser"] . "','1')";

	$result = $_contextMitsu->prepare($strSQL)->execute();
	$strSQLD = "insert into tb_blacklist_detail (bd_id,bd_data,bd_remark,bd_addby) values ('','" . $_POST['blist1'] . "','" . $_POST['blist_remark1'] . "','" . $_SESSION["strUser"] . "')";

	$resultD = $_contextMitsu->prepare($strSQL)->execute();
}
if ($_POST['blist2'] != '') {
	$strSQL = "insert into tb_blacklist (bl_id,bl_name,bl_data,bl_remark,bl_type,bl_cusstatus,addby,bl_status) values ('','','" . $_POST['blist2'] . "','" . $_POST['blist_remark2'] . "','Email','C','" . $_SESSION["strUser"] . "','1')";

	$result = $_contextMitsu->prepare($strSQL)->execute();
	$strSQLD = "insert into tb_blacklist_detail (bd_id,bd_data,bd_remark,bd_addby) values ('','" . $_POST['blist2'] . "','" . $_POST['blist_remark1'] . "','" . $_SESSION["strUser"] . "')";

	$resultD = $_contextMitsu->prepare($strSQL)->execute();
}

$claim_status = $_POST['claim_status'];
$claim_no = $_POST['claim_no'];
$claim_location = $_POST['claim_location'];
$estimate = $_POST['estimate'];

for ($n = 0; $n < count($estimate); $n++) {
	$claim_sql = "INSERT INTO tb_claim (id_data,n_insure,claim_amount,claim_status,car_body,dateentry,dateupdate,claim_no,claim_location,estimate,emp_save,claim_use)
	VALUES ('" . $_POST['OQ'] . "','" . $_POST['n_insure'] . "','" . str_replace(',', '', $estimate[$n]) . "','" . $claim_status[$n] . "','" . $_POST['car_body'] . "',NOW(),NOW(),'" . $claim_no[$n] . "','" . $claim_location[$n] . "','" . str_replace(',', '', $estimate[$n]) . "','" . $_SESSION["strUser"] . "','9')";
	$claim_query = $_contextMitsu->prepare($claim_sql)->execute();
}
/*
	$strSQL = "UPDATE insuree SET tel_mobi_2='".$new_tel."',id_line='".$_POST['idline']."',email='".$_POST['email']."' WHERE id_data='".$_POST['OQ']."'";
	mysql_select_db($db1,$cndb1);
	$result = mysql_query( $strSQL ,$cndb1);
	*/
$_contextMitsu = null;
if ($result == true) {
	echo json_encode('บันทึกสำเร็จ');
} else {
	echo json_encode('บันทึกไม่สำเร็จ');
}