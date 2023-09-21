<?php
include "../check-ses.php"; 
//include "../inc/checksession.inc.php";
include "../inc/connectdbs.inc.php"; 

	$sql_renew = "SELECT * FROM detail_renew WHERE detail_renew.lastrenew='1' AND detail_renew.status!='N' AND detail_renew.status!='E' AND DATE(date_alert) < DATE_SUB(CURDATE(), INTERVAL 5 DAY) ";
	//echo 'path : inc/session_renew.php <br>'.$sql_renew;
        mysql_select_db($db1,$cndb1);
		$objQuery_renew = mysql_query($sql_renew,$cndb1) or die ("Error query_onl [".$sql_renew."]");
				while($row_renew=mysql_fetch_array($objQuery_renew)){

					$sql_renew_in = "SELECT checkuser FROM data WHERE data.id_data='".$row_renew['id_data']."' AND renewuse!=''";
				mysql_select_db($db1,$cndb1);
				$objQuery_renew_in = mysql_query($sql_renew_in,$cndb1) or die ("Error query_onl [".$sql_renew_in."]");
				$row_renew_in=mysql_fetch_array($objQuery_renew_in);
						if($row_renew_in['checkuser']!=''){

						$textrenew = $row_renew_in['checkuser']."|".$row_renew["userdetail"];
						}else{
						$textrenew = $row_renew["userdetail"];
						}

				$sql_up = "UPDATE data SET checkuser='$textrenew' WHERE data.id_data='".$row_renew['id_data']."' AND checkuser NOT LIKE '%".$row_renew["userdetail"]."%' ";
				mysql_select_db($db1,$cndb1);
				$objQuery_up = mysql_query($sql_up,$cndb1) or die ("Error query_onl [".$sql_up."]");

				$sql_unlock = "UPDATE data SET renewuse='' WHERE data.id_data='".$row_renew['id_data']."'";
				mysql_select_db($db1,$cndb1);
				$objQuery_unlock = mysql_query($sql_unlock,$cndb1) or die ("Error query_onl [".$sql_unlock."]");
				
				}

//ต่ออายุ ตัดไม่สนใจ

				$sql_renew = "SELECT * FROM detail_renew WHERE detail_renew.lastrenew='1' AND status='N' AND detail_renew.status!='E' AND DATE(date_alert) < DATE_SUB(CURDATE(), INTERVAL 15 DAY) ";
                                //echo 'path : inc/session_renew.php <br>'.$sql_renew;
				mysql_select_db($db1,$cndb1);
				$objQuery_renew = mysql_query($sql_renew,$cndb1) or die ("Error query_onl [".$sql_renew."]");
				while($row_renew=mysql_fetch_array($objQuery_renew)){

						$sql_renew_in = "SELECT checkuser FROM data WHERE data.id_data='".$row_renew['id_data']."' AND renewuse!=''";
					mysql_select_db($db1,$cndb1);
					$objQuery_renew_in = mysql_query($sql_renew_in,$cndb1) or die ("Error query_onl [".$sql_renew_in."]");
					$row_renew_in=mysql_fetch_array($objQuery_renew_in);
							if($row_renew_in['checkuser']!=''){

							$textrenew = $row_renew_in['checkuser']."|".$row_renew["userdetail"];
							}else{
							$textrenew = $row_renew["userdetail"];
							}

				$sql_up = "UPDATE data SET checkuser='$textrenew' WHERE data.id_data='".$row_renew['id_data']."' AND checkuser NOT LIKE '%".$row_renew["userdetail"]."%' ";
				mysql_select_db($db1,$cndb1);
				$objQuery_up = mysql_query($sql_up,$cndb1) or die ("Error query_onl [".$sql_up."]");

				$sql_unlock = "UPDATE data SET renewuse='' WHERE data.id_data='".$row_renew['id_data']."'";
				mysql_select_db($db1,$cndb1);
				$objQuery_unlock = mysql_query($sql_unlock,$cndb1) or die ("Error query_onl [".$sql_unlock."]");
			}
?>
