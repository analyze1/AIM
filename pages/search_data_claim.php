<?php
include "check-ses.php"; 
include "../inc/connectdbs.inc.php"; 
include "../inc/function.php";
include "../inc/session_car.php";

$costOb = $_SESSION["Cost"];
$costObname = $_SESSION["CostName"];
$TbCost = $_SESSION["TbCost"];
$MoC = $_SESSION["MoC"];
$BrC = $_SESSION["BrC"]; 

?>

<?php
$EndYear = date('Y');
$dateN = date('Y-m-d'); 
$StartYear = $EndYear-3;

if(empty($_POST['txtsearch']))
{
	echo "กรุณากรอกข้อมูลให้ครบถ้วน";
}
else
{
	if($_POST['otp']=='iddata')
	{
		$new_iddata = split("-", $_POST['txtsearch']);
		
		if($new_iddata[1] == '')
		{
			$search = " AND data.id_data  like '%".$_POST['txtsearch']."%' ";
		}
		else
		{
			$search = " AND (data.id_data"." LIKE '%".$new_iddata[0]."/รย/".$new_iddata[1]."%' OR data.id_data LIKE '%".$new_iddata[0]."/FOUR/".$new_iddata[1]."%' ) ";
		}
	}
	else if($_POST['otp']=='policy')
	{
		$search = " AND data.n_insure  like '%".$_POST['txtsearch']."%' ";
	}
	else if($_POST['otp']=='namesearch')
	{
		$search = " AND ((insuree.name"." LIKE '%".$_POST['txtsearch']."%' OR insuree.last LIKE '%".$_POST['txtsearch']."%' ) OR (req.Cus_name"." LIKE '%".$_POST['txtsearch']."%' OR req.Cus_last LIKE '%".$_POST['txtsearch']."%' ) ) ";
	}
	else if($_POST['otp']=='prb')
	{
		$search = " AND (data.p_act LIKE '%".$_POST['txtsearch']."%' OR req.EditAct_id LIKE '%".$_POST['txtsearch']."%' ) ";
	}
	else if($_POST['otp']=='carbody')
	{
		$search = " AND (detail.car_body  LIKE  '%".$_POST['txtsearch']."%' OR req.Edit_CarBody LIKE '%".$_POST['txtsearch']."%' ) ";
	}
	else if($_POST['otp']=='phone')
	{
		$search = " AND insuree.tel_home"." LIKE '%".$_POST['txtsearch']."%' OR insuree.tel_mobi LIKE '%".$_POST['txtsearch']."%' OR insuree.tel_mobi_2 LIKE '%".$_POST['txtsearch']."%' OR insuree.tel_mobi_3 LIKE '%".$_POST['txtsearch']."%' ";
	}
	else if($_POST['otp']=='regis')
  	{
    	$search = " AND detail.car_regis LIKE '%".$_POST['txtsearch']."%' ";
  	}


$query = "SELECT ";
$query .= " insuree.name As cus_name,data.id_data,detail.id_data,insuree.id_data,data.com_data,data.n_insure,detail.br_car,detail.mo_car,detail.add_price,detail.cat_car,data.login,detail.car_regis,detail.regis_date,insuree.title,insuree.last,data.send_date,data.start_date,data.end_date,detail.car_body,detail.n_motor,data.costCost,detail.car_id,data.p_act, req.CostProduct, req.Cus_title, req.Cus_name, req.Cus_last, req.EditAct_id, req.Edit_CarBody, req.CostProduct, tb_customer.saka ";
$query .= " FROM data ";
$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query .= "INNER JOIN tb_customer ON (data.login  = tb_customer.user) ";
$query .= "INNER JOIN req ON (data.id_data  = req.id_data) ";
$query .= "INNER JOIN tb_claim ON (data.id_data  = tb_claim.id_data) ";

$query .= "WHERE 1=1 ";
//$query .= " AND  regis_date>".intval(date('Y')-3)." AND insuree.name!='' ";
if($_SESSION["strUser"]!='admin'){
$query .= "AND data.login='".$_SESSION["strUser"]."' ";
}
$query .= " $search order by data.send_date DESC ";
//$objQuery = mysql_query($query) or die ("Error Query [".$query."]");
mysql_select_db($db1,$cndb1);
$objQuery = mysql_query($query,$cndb1) or die ("Error Query tb_data [".$query."]");

?>         
<?php
        
        function dateChkdiff($str_start, $str_end) {
            
            $str_start = strtotime($str_start); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
            $str_end = strtotime($str_end); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
            $nseconds = $str_end - $str_start; // วันที่ระหว่างเริ่มและสิ้นสุดมาลบกัน
            $ndays = round($nseconds / 86400); // หนึ่งวันมี 86400 วินาที
            
            return $ndays;
        }
?>
<link type="text/css" rel="stylesheet" type="text/css" href="data_table/css/jquery.dataTables.css">
<script type="text/javascript" src="data_table/js/jquery.dataTables.js"></script> 
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="example" style="font-size:12px">
  <thead>

      <tr height="50" >
                                                        
                                                        <th width="6%">เลขกรมธรรม์</th>
                                                        <th width="8%">เลขที่รับแจ้ง</th>
                                                        <th width="11%">ชื่อผู้เอาประกัน</th>
                                                        <th width="7%" >ยี่ห้อ/รุ่น</th>
                                                        <th width="9%">ทะเบียน</th>
                                                        <th width="12%">เลขตัวถัง</th>

                                                    </tr>
  </thead>
  <tbody>
    <?php
$totalRows=$n;
while($row = mysql_fetch_array($objQuery))
	{ 
    
    	mysql_select_db($db2,$cndb2);
	//$sqlc = "SELECT id_data FROM detail WHERE car_body = '".$row['car_body']."'";
	$sqlc = "SELECT id,id_data,car_body FROM detail WHERE detail.car_body ='".$row['car_body']."' order by detail.id desc limit 1";
	$qc = mysql_query($sqlc,$cndb2) or die ("Error Query cndb2 [Error QUERY!!!!]");
	$rowc = mysql_fetch_array($qc);

	$cost_renew = explode('|',$row['detailcost']);
	
        
        //  check ค่า เลขรับแจ้งของฝั่ง policy กับ suzuki
        $id_data_my4ib = explode("/", $row['id_data']);
        $id_data_four = explode("/", $rowc['id_data']);
        
        
	

        
        $yearOld = number_format($EndYear - $row['regis_date'])+1 ;
        $dfcount = '';
        $dfcount = dateChkdiff($dateN, $row['end_date']);
		if($row['com_data']== "VIB_S"){
 			$idcom_data = "09712";
		}else if($row['com_data']=="VIB_F"){
			$idcom_data = "11678";
		}else if($row['com_data']=="VIB_C" && $row['saka'] == '113'){
			$idcom_data = "08829";
		}else if($row['com_data']=="VIB_C" && $row['saka'] != '113'){
			$idcom_data = "10320";
		}
                
        $query_detailRenew = "SELECT * FROM detail_renew WHERE detail_renew.id_data ='".$row['id_data']."' order by id_detail desc limit 1 ";
        mysql_select_db($db1,$cndb1);
        $objQuery_detailRenew = mysql_query($query_detailRenew,$cndb1);
	$row_detailRenew = mysql_fetch_array($objQuery_detailRenew);	
        $status = $row_detailRenew['status'];
      
  ?>

      <tr align="center">
                  
          <td height="36" valign="top"><a href="#" onclick="load_page('pages/load_ClaimDetail.php?id=<?=$row['id_data'];?>','รายงานเคลม');"><? echo '<font color="#FF0000">'.$row['n_insure'].'</font>';?></a></td>
                  <td height="36" align="center" valign="top"><?= $row['id_data']; ?></td>
                  <td height="36" align="left" valign="top"><?= $row['title'] . " " . $row['cus_name'] . " " . $row['last'] ?></br><?php if ($row['Cus_name'] != '') {
                      echo "( " . $row['Cus_title'] . $row['Cus_name'] . " " . $row['Cus_last'] . " )";
                  }
                  ?></td>
                  <td height="36" valign="top"><?= $MoC['name'][$row['mo_car']]; ?></td>
                  <td height="36" valign="top"><?= $row['car_regis']; ?></td>
                  <td height="36" valign="top"><?= $row['car_body']; ?></td>
              </tr>
    
                                                        
    <?php }?>
  </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function() {

    var tables = $('#example').DataTable({
        "order": [[ 1, "asc" ]]
    });
    
    });
</script>
<?php }?>