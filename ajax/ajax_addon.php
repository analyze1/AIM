<?php
	include "../pages/check-ses.php";
	include "../../inc/connectdbs.pdo.php";

	$data_id = $_POST['data_id'];
	$data_select = $_POST['data_select'];

	$query_addon = "SELECT * from tb_addon where 1=1 ";
	$query_addon .= " AND code_addon = '".$data_id."' ";
        if(!empty($data_select)){
	$query_addon .= " AND id = '".$data_select."' ";
        }
	$query_addon .= "  order by id";
	$objQuery_addon = mysql_query($query_addon) or die (mysql_error());
	$i=0;
	while($fetcharr = mysql_fetch_array($objQuery_addon))
	{ 
		$returnedArray[$i]['id'] = $fetcharr[id];
		$returnedArray[$i]['code_addon'] = $fetcharr[code_addon];
		$returnedArray[$i]['name_addon'] = $fetcharr[name_addon];
		$returnedArray[$i]['id_add'] = $fetcharr[id_add];
		$returnedArray[$i]['detail_insuran_inbody_text'] = '1. การเสียชีวิต การสูญเสียอวุยวะ สายา หรือทุพพลภาพสิ้นเชิงอันเนื่องมาจากอุบัติเหตุรถยนต์';
		$returnedArray[$i]['detail_insuran_inbody'] = $fetcharr[detail_insuran_inbody].' บาท/คน';
		$returnedArray[$i]['detail_insuran_incar_text'] = '2. เงินชดเชยค่าใช้จ่ายในการเดินทางระหว่างเข้าซ่อมจากอุบัติเหตุ';
		$returnedArray[$i]['detail_insuran_incar'] = $fetcharr[detail_insuran_incar].' บาท/ครั้ง';
		$returnedArray[$i]['detail_insuran_outbody'] = $fetcharr[detail_insuran_outbody];
		$returnedArray[$i]['detail_insuran_outcar'] = $fetcharr[detail_insuran_outcar];
		$returnedArray[$i]['cost_insuran'] = $fetcharr[cost_insuran];
		$i++;
	};

	echo json_encode($returnedArray);

	mysql_close();
?>
