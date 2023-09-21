<?php
header('Content-Type: text/html; charset=UTF-8');
include "../inc/connectdbs.pdo.php";
include '../services/PHPMailer/PHPMailerAutoload.php';
$_contextMitSu = PDO_CONNECTION::fourinsure_mitsu();

$send_date = $_POST["send_date"];

if ($_POST['xuser'] == 'admin') {
    $login = $_POST["Dxuser"];
    $query_D = "SELECT * FROM `tb_customer` WHERE `user` = '$login' and `nameuser` = 'Mitsubishi'";
    $objQueryD = $_contextMitSu->query($query_D)->fetchAll(2);
    foreach ($objQueryD as $objResultD) {
        $name_inform = $objResultD['title_sub'] . ' ' . $objResultD['sub'];
    }
} else {
    $login = $_POST["xuser"];
    $name_inform = $_POST["name_inform"];
}

$query_userMK = "SELECT * FROM `tb_customer` WHERE `user` = '$login' and `nameuser` = 'Mitsubishi'";
$row_userMK = $_contextMitSu->query($query_userMK)->fetchAll(2);

$storetotal = $_POST['total'];
$contact = $_POST['contact'];
$tel_contact = $_POST['tel_contact'];
$email_re = $_POST['email_re'];
$suj = "ขอเบิก พ.ร.บ. ของ " . $name_inform;

if (!empty($_POST['add_contact'])) {
    $ti_add = 'ที่อยู่ : ';
} else {
    $ti_add = '';
}

$add_contact = $ti_add . $_POST['add_contact'];

/*if($row_userMK['saka'] == '205' || $row_userMK['saka'] == '207' || $row_userMK['saka'] == '208' || $row_userMK['saka'] == '210')
	{
		$zone = 'ภาคตะวันออก';
	}
	else if($row_userMK['saka'] == '203' || $row_userMK['saka'] == '213' || $row_userMK['saka'] == '401')
	{
		$zone = 'ภาคกลาง';
	}
	else if($row_userMK['saka'] == '301' || $row_userMK['saka'] == '302' || $row_userMK['saka'] == '303' || $row_userMK['saka'] == '304')
	{
		$zone = 'ภาคอีสาน';
		$staff_4ib = 'My Staff 4Insured : คุณธนันพัชร์ วงษ์คำจันทร์';
	}
	else if($row_userMK['saka'] == '501' || $row_userMK['saka'] == '502' || $row_userMK['saka'] == '504' || $row_userMK['saka'] == '506')
	{
		$zone = 'ภาคเหนือ';
		$staff_4ib = 'My Staff 4Insured : คุณพันธ์รัศม์ ด่านพัฒนาดิลก';
	}
	else if($row_userMK['saka'] == '701' || $row_userMK['saka'] == '702' || $row_userMK['saka'] == '703' || $row_userMK['saka'] == '705' || $row_userMK['saka'] == '709')
	{
		$zone = 'ภาคใต้';
	}*/
if ($row_userMK['group_pv'] == '1') {
    $zone = 'ภาคเนือ';
} elseif ($row_userMK['group_pv'] == '2') {
    $zone = 'ภาคตะวันออกเฉียงเหนือ';
} elseif ($row_userMK['group_pv'] == '3') {
    $zone = 'ภาคตะวันออก';
} elseif ($row_userMK['group_pv'] == '4') {
    $zone = 'ภาคตะวันตก';
} elseif ($row_userMK['group_pv'] == '5') {
    $zone = 'ภาคใต้';
} elseif ($row_userMK['group_pv'] == '6') {
    $zone = 'กรุงเทพมหานคร';
}

// ผู้จัดการภาค
if ($row_userMK['manager_zone'] != '') {
    if ($row_userMK['manager_zone_tel'] != '') {
        //$zone_tel = ' โทร : '.$row_userMK['manager_zone_tel'];
    }
    //$manager_zone = 'ผู้จัดการ'.$zone.' : '.$row_userMK['manager_zone'].$zone_tel;
}
// ผู้จัดการสาขา
if ($row_userMK['manager_branch'] != '') {
    if ($row_userMK['manager_branch_tel'] != '') {
        //$branch_tel = ' โทร : '.$row_userMK['manager_branch_tel'];
    }
    //$manager_branch = 'ผู้จัดการสาขา : '.$row_userMK['manager_branch'].$branch_tel;
}
// เจ้าหน้าที่การตลาด
if ($row_userMK['mk_username'] != '') {
    if ($row_userMK['mk_tel'] != '') {
        //$mk_tel = ' โทร : '.$row_userMK['mk_tel'];
    }
    //$mk_username = 'เจ้าหน้าที่การตลาดวิริยะประกันภัย : '.$row_userMK['mk_username'].$mk_tel;
}

$mail = new PHPMailer(); // กำหนดตัวแปร  $mail
$mail->CharSet = 'UTF-8';
$mail->From = 'admin@viriyah.net'; // กำหนดอีเมล์ที่ใช้ในการส่ง
$mail->FromName = "เบิก พ.ร.บ." . $name_inform; // กำหนดชื่อผู้ส่ง
$mail->IsSMTP();
$mail->SMTPDebug = 0;
$mail->SMTPAuth = true;
$mail->Host = _SMTP_MY4IB_TLS; // "localhost"; // SMTP servermail.my4ib.com
$mail->Port = _SMTP_MY4IB_POST; // พอร์ท
$mail->Username = _SMTP_MY4IB_USERNAME_ADMIN; // account SMTP
$mail->Password = _SMTP_MY4IB_PASSWORD_ADMIN; // รหัสผ่าน SMTP
$mail->IsHTML(false);
$mail->AddAddress('underwrite_prb@my4ib.com', ""); 
$mail->AddAddress('pothai@my4ib.com', ""); 
$mail->AddAddress('marketing_support2@my4ib.com', "");
$mail->AddAddress('marketing_support3@my4ib.com', "");
$mail->AddAddress('marketing_support6@my4ib.com', "");
$mail->AddAddress('theedanai@my4ib.com', "");
// $mail->AddAddress('info_support2@my4ib.com');/

if (!empty($_POST['email_re']) && $_POST['email_re'] != '-') {
    $mail->AddAddress($_POST['email_re'], "");
}
$mail->Subject = "ขอเบิก พ.ร.บ. " . $name_inform; // กำหนดหัวข้ออีเมล์
$mail->Body = "ขอเบิก พ.ร.บ. ของ " . $name_inform . "\n" . "จำนวน " . $storetotal . " ฉบับ" . "\n" . "ติดต่อ " . $contact . "\n" . $add_contact . "\n" . "โทร. " . $tel_contact . "\n" . "E-Mail " . $email_re . "\n" . "\n" . $manager_zone . "\n" . $manager_branch . "\n" . $mk_username . "\n" . "\n" . $staff_4ib . "\n"; // กำหนดเนื้อหาอีเมล

if ($mail->Send()) {
    $data = [
        'login' => $login,
        'name_inform' => $name_inform,
        'send_date' => $send_date,
        'store_total' => $storetotal,
    ];
    $strSQL = "INSERT INTO store (`login`, `name_inform`, `send_date`, `store_total`) VALUES (:login, :name_inform, :send_date, :store_total)";
    $res = $_contextMitSu->prepare($strSQL)->execute($data);

    $returnedArray['status'] = true;
    $returnedArray['msg'] = "บันทึกข้อมูลเรียบร้อยแล้ว! ";
} else {
    $returnedArray['status'] = false;
    $returnedArray['msg'] = "บันทึกข้อมูลผิดพลาด !!!!!!!";
}
echo json_encode($returnedArray);
