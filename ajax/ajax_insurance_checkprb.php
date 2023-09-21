<?php
@include "../pages/check-ses.php";
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
					$user = $_SESSION["strUser"];
					$checked_prb=$_POST['prb'];
						$query_actck ="SELECT *  FROM z_act WHERE act_use = '".$user."' AND act_status = '2' AND act_no = '".$checked_prb."' AND act_return = ''";
                        $objQuery_actck = mysql_query($query_actck,$cndb1) or die ("Error Query [".$query_actck."]");
                        $row_actck = mysql_fetch_array($objQuery_actck);
						if(!empty($row_actck))
						{
						$query_act ="SELECT *  FROM z_act WHERE act_use = '".$user."' AND act_status = '1' AND act_return = '' ORDER BY act_id limit 5";
                        $objQuery_act = mysql_query($query_act,$cndb1) or die ("Error Query [".$query_act."]");
                        $row_act = mysql_fetch_array($objQuery_act);
						$act_no=$row_act['act_no'];
						$act_check='T';
						}
						else
						{
						$act_no=$_POST['prb'];
						$act_check='F';
						}
						$act_array['act_no1']=$act_no;
						$act_array['act_checked1']=$act_check;
						echo json_encode($act_array);
?>
