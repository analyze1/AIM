<?php
	include "../inc/checksession.inc.php";
	include "../inc/connectdbs.inc.php";
?>
<html>
<head>
<title>TEST</title>
</head>
<body>
<?
$wps=1;
		require_once("lib/nusoap.php");
        $client = new nusoap_client("http://wsdev.viriyah.co.th/TcsPolicy/CmiService.asmx?wsdl",true); 
  //       $wsdlFile = "http://wsdev.viriyah.co.th/TcsPolicy/CmiService.asmx";
  //       $client = new nusoap_client($wsdlFile, 'wsdl', '', '', '', '');
		$client->soap_defencoding = 'UTF-8';
		// $client->debug_flag = false;
if($wps=='1'){

		//////////////////////
$params = array(
                   'Username' => "Tuser1",
                   'Password' => "daif1928",
                   'tcspolicy' => array(
	                   'AgentCode' => "99999",//08829
					   'ApplicationNo' => "", //2รหัสอ้างอิง
					   'SaleName' => "ทดสอบ ทดสอบ", //3ผู้แจ้งงาน
					   'AppSignDate' => "20181001 08.30", //4วันที่แจ้งงาน
					   'EffectiveDate' => "20181001",//5วันเริ่มคุ้มครอง
					   'ExpiredDate' => "20191001", //6สิ้นสุดวันคุ้มครอง
					   'PolicyNo' => "99999-60100-1234568",  //7เลขที่ กธ
					   'Barcode' => "123456780", //8บาร์โค้ด
					   'CardType' => "C", //9ประเภทบัตร P C L A Z
					   'CardNo' => "1234567890123", //10หมายเลขบัตร
					   'InsuredType' => "P", //11P บุคคล C นิติ
					   'InsuredBranchCode' => "", //12รหัสสาขาของผู้เอาประกัน
					   'InsuredTitleName' => "คุณ", //13คำนำหน้าชื่อ
					   'InsuredName' => "ทดสอบ", //14ชื่อผู้เอาประกัน
					   'InsuredLastName' => "เว็บเซอร์วิส", //15นามสกุลผูเอาประกัน
					   'Gender' => "F", //16เพศ M F
					   'BirthDate' => "19841019", //17วันเกิด
					   'Telephone' => "021964521",  //18เบอร์โทร
					   'MobileNo' => "0951212222",  //19มือถือ
					   'HomeNo' => "1234",  //20เบอร์บ้าน
					   'Building' => "",  //21ตึก
					   'Moo' => "2", //22หมู่ที่
					   'Moobarn' => "หน้าไม้", //23หมู่บ้าน
					   'RoomNo' => "78/24", //24เบอร์ห้อง
					   'Trok' => "",  //25ตรอก
					   'Soi' => "6",  //26ซอย
					   'Road' => "ตลิ่งชัน-สุพรรณบุรี",  //27ถนน
					   'Tambol' => "ลาดหลุมแก้ว",  //28ตำบล
					   'Amphur' => "ลาดหลุมแก้ว",  //29อำเภอ
					   'Postcode' => "12140",  //30รหัสไปรษณีย์
					   'Province' => "13",  //31จังหวัด
					   'LicenseNo' => "กม1234",  //32ทะเบียนรถ
					   'LicenseProvince' => "10",  //33จดทะเบียนจังหวัด
					   'Chassis' => "MTH09PU5M7107259",  //34เลขถัง
					   'Engine' => "B20B3WP11645",  //35เลขเครื่อง
					   'VehicleType' => "1.10",//36ประเภทรถ1.30
					   'VehicleMake' => "HONDA",  //37ยี่ห้อรถ
					   'VehicleModel' => "Accord",  //38รุ่นรถ
					   'VehicleRegYear' => "2012", //39ปีที่จดทะเบียน
					   'Seat' => "4",  //40จำนวนที่นั่ง
					   'CC' => "1500",  //41ซีซี
					   'VehicleWeight' => "1",  //42น้ำหนัก
					   'VehicleUseCode' => "P",  //43การใช้รถ
					   'NetPremium' => "600.00",  //44สุทธิ
					   'Vat' => "3.00",  //45ภาษี
					   'Stamp' => "42.21",  //46อากร
					   'GrossPremium' => "645.21",  //47เบี้ยรวม
					   'OnlinePayment_amt' => "0.00",  //48จำวนการจ่ายเงิน
					   'OnlinePayment_no' => "",  //49เลขที่การจ่ายเงิน
					   'isOnline' => "N",  //50Yonline N offline
					   'email_customer' => "om",  //51อีเมล์ลูกค้า
					   'email_agent' => "",  //52อีเมล์ตัวแทน
					   'onlinemerchant_id' => "" //53เลขที่การจ่าย
	        		)
               );


       $data = $client->call("SendPolicyCTPRealTime",$params); 
		//////////////////////
}
       
       print_r($params);
       $soapError = $client->getError();

		if (! empty($soapError)) {
		    $errorMessage = 'SOAP method invocation (verifyT) failed: ' . $s6oapError;
		    throw new Exception($errorMessage);
		}
		// if ($client->fault) {
		//     $fault = "{$client->faultcode}: {$client->faultdetail} ";
		//     // handle fault situation
		// }

       echo "<br> <br>".print_r($data)."<br>";
       
?>
</body>
</html>