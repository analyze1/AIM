<?
include "../../inc/connectdbs.pdo.php"; 
include "../pages/check-ses.php";
//require("../email/class.phpmailer.php");  // เรียกไฟล์ class.phpmailer.php
require("../email/PHPMailer/PHPMailerAutoload.php");  // เรียกไฟล์ class.phpmailer.php
$USER = $_SESSION["strUser"];
$name_company = $_POST['name_company'];
$AddCompany = $_POST['AddCompany'];
$ceo_fax=$_POST['ceo_fax'];
$ceo_name=$_POST['ceo_name'];
$ceo_mobile=$_POST['ceo_mobile'];
$ceo_tel=$_POST['ceo_tel'];
$sale1_email=$_POST['sale1_email'];
$sale1_name=$_POST['sale1_name'];
$sale1_tel1=$_POST['sale1_tel1'];
$sale1_tel2=$_POST['sale1_tel2'];
$sale2_email=$_POST['sale2_email'];
$sale2_name=$_POST['sale2_name'];
$sale2_tel1=$_POST['sale2_tel1'];
$sale2_tel2=$_POST['sale2_tel2'];
$finance1_name=$_POST['finance1_name'];
$finance1_email=$_POST['finance1_email'];
$finance1_tel1=$_POST['finance1_tel1'];
$finance1_tel2=$_POST['finance1_tel2'];
$finance2_email=$_POST['finance2_email'];
$finance2_name=$_POST['finance2_name'];
$finance2_tel1=$_POST['finance2_tel1'];
$finance2_tel2=$_POST['finance2_tel2'];
$finance2_tel2=$_POST['finance2_tel2'];
$email_company=$_POST['email_company'];
$image_company=$_POST['image_company'];
$tel_company=$_POST['tel_company'];
$fax_company=$_POST['fax_company'];
	
	

						
					$sql = "SELECT * FROM profile_customer WHERE username ='$USER'";
					$result = mysql_query($sql);
					$COUNT = mysql_num_rows($result);
					
				//----------------------------------------------------------------------------
							
							
					if($COUNT!=0){
					$id_data = $fetcharr["num_inform"];
					$strSQL = "UPDATE profile_customer SET edit_date = now(), username = '$USER', name_company = '$name_company', add_company='$AddCompany', tel_company='$tel_company', email_company='$email_company', fax_company='$fax_company', sale1_name='$sale1_name', sale1_tel1='$sale1_tel1', sale1_tel2='$sale1_tel2', sale1_email='$sale1_email', sale2_name='$sale2_name', sale2_tel1='$sale2_tel1',sale2_tel2='$sale2_tel2', sale2_email='$sale2_email', finance1_name='$finance1_name',finance1_tel1='$finance1_tel1', finance1_tel2='$finance1_tel2', finance1_email='$finance1_email',finance2_name='$finance2_name',finance2_tel1='$finance2_tel1',finance2_tel2='$finance2_tel2', finance2_email='$finance2_email', ceo_name='$ceo_name' WHERE username = '$USER' ";
					$objQuery = mysql_query($strSQL);	
					}
					else{
					$strSQL = "INSERT INTO profile_customer (`id`, `username`) VALUES (NULL, '$USER')"; 							
					$objQuery = mysql_query($strSQL);
					}
							
					// 	$mail = new PHPMailer();  // กำหนดตัวแปร  $mail
					// 	$mail->CharSet = 'UTF-8';                                                                
					// 	$mail->From = "admin@my4ib.com"; // กำหนดอีเมล์ที่ใช้ในการส่ง
					// 	$mail->FromName = $USER; // กำหนดชื่อผู้ส่ง
					// 	$mail->Host = _MAIL_MY4IB; //"mail.my4ib.com"; // กำหนดที่อยู่โฮส
					// 	$mail->Mailer = "smtp"; 
					// 	$mail->AddAddress('montree_r@my4ib.com'); // กำหนดอีเมล์ผู้รับ
					// 	$mail->Subject = $USER." แก้ไขข้อมูลผ่านระบบ"; // กำหนดหัวข้ออีเมล์
					// 	$mail->Body = "แก้ไขเมื่อ : ".date('d/m/Y H:i:s'); // กำหนดเนื้อหาอีเมล์
					
					// 	$mail->IsHTML(false); 
					
					// 	$mail->SMTPAuth = "false"; 
					// 	$mail->Host = "mail.my4ib.com";
					// 	$mail->Username = "montree_r@my4ib.com"; // กำหนดusername ของโฮส
					// 	$mail->Password = "my4ib"; // กำหนด password ของโฮส
						
					   
					// if(!$mail->Send()) {
					// 	echo $mail->Send();
					// }		
				
							
							$returnedArray['msg'] = "บันทึกข้อมูลเรียบร้อยแล้ว! : ".$_POST['name_company'];
                               	echo json_encode($returnedArray);
							//------------------------------------------------------------------
				
			
				mysql_close();
?>