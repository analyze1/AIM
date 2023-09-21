<?php

include "../inc/connectdbs.pdo.php";
	$list_tel = $_POST['list_tel'];
	$num_tel = $_POST['teladd'];
	
	$txt_claim =  str_replace(",","",$_POST["txt_claim"]);
	
	for($i=0;$i<count($list_tel);$i++)
	{
		if($num_tel[$i]!='')
		{
			$new_tel = $new_tel.$list_tel[$i].'/'.$num_tel[$i].'|';
		}
	}

	if($new_tel != '')
	{
		$strSQL = "UPDATE insuree SET tel_mobi_2 = '$new_tel' WHERE id_data = '$_POST[OQ]'";
		$result = PDO_CONNECTION::fourinsure_mitsu()->prepare($strSQL)->execute();
	}

if($result==true)
{
	echo json_encode('บันทึกสำเร็จ');
}
else
{
	echo json_encode('บันทึกไม่สำเร็จ');
}
