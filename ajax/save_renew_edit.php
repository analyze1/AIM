<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";
$user = $_GET['user'];
$emp_titlerenew = $_POST['title'];
$emp_namerenew = $_POST['name'];
$emp_lastrenew = $_POST['last'];
$emp_telrenew = $_POST['tel'];
$emp_faxrenew = $_POST['fax'];
$emp_emailrenew = $_POST['email'];

if (!empty($user)) {
    $tb_customer_sql = "UPDATE tb_customer SET emp_titlerenew = '$emp_titlerenew',emp_namerenew = '$emp_namerenew',
    emp_lastrenew = '$emp_lastrenew',emp_telrenew = '$emp_telrenew',emp_faxrenew = '$emp_faxrenew',
    emp_emailrenew = '$emp_emailrenew' WHERE user = '$user'";

    $tb_customer_query = PDO_CONNECTION::fourinsure_mitsu()->prepare($tb_customer_sql)->execute();
    $messagebox['status'] = "T";
    $messagebox['alert'] = "บันทึกข้อมูลเรียบร้อยแล้วครับ";
    $messagebox['user'] = $user;
} else {
    $messagebox['status'] = "N";
    $messagebox['alert'] = "บันทึกข้อมูลไม่สำเร็จครับ";
}
echo json_encode($messagebox);