<?php
include "check-ses.php";
include "../../inc/connectdbs.pdo.php"; 


$costOb = $_SESSION["Cost"];
$costObname = $_SESSION["CostName"];
$TbCost = $_SESSION["TbCost"];
$MoC = $_SESSION["MoC"];
$BrC = $_SESSION["BrC"];
$sqlMORE = "SELECT * FROM tb_acc";
$objQueryMORE = mysql_query($sqlMORE) or die ("Error Query [".$sqlMORE."]");
$costOb = array();
while($rowCost = mysql_fetch_array($objQueryMORE)){
	$costOb['name'][$rowCost['id']] = $rowCost['name'];
	$costOb['price'][$rowCost['id']] = $rowCost['price'];
	$costOb['price2'][$rowCost['id']] = $rowCost['price2'];
} 

function DateThai($datetime) {
list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
$Y = $Y+543; // เปลี่ยน ค.ศ. เป็น พ.ศ.

switch($m) {
case "01": $m = "01"; break;
case "02": $m = "02"; break;
case "03": $m = "03"; break;
case "04": $m = "04"; break;
case "05": $m = "05"; break;
case "06": $m = "06"; break;
case "07": $m = "07"; break;
case "08": $m = "08"; break;
case "09": $m = "09"; break;
case "10": $m = "10"; break;
case "11": $m = "11"; break;
case "12": $m = "12"; break;
}
return $d."/".$m."/".$Y;
} 

?>
<style type="text/css">

    body {
        padding: 0px;
    }

    table {
        border-collapse: separate;
        border-spacing: 0 5px;
    }

    thead th {
        background-color: #003366;
        color: white;
    }

    tbody td {
        background-color: #;
    }

    tr td:first-child,
    tr th:first-child {
        border-top-left-radius: 6px;
        border-bottom-left-radius: 6px;
    }

    tr td:last-child,
    tr th:last-child {
        border-top-right-radius: 6px;
        border-bottom-right-radius: 6px;
    }

    .btn_print {
        -moz-box-shadow: inset 0px 1px 0px 0px #ffffff;
        -webkit-box-shadow: inset 0px 1px 0px 0px #ffffff;
        box-shadow: inset 0px 1px 0px 0px #ffffff;
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #f9f9f9), color-stop(1, #dbd8db));
        background: -moz-linear-gradient(top, #f9f9f9 5%, #dbd8db 100%);
        background: -webkit-linear-gradient(top, #f9f9f9 5%, #dbd8db 100%);
        background: -o-linear-gradient(top, #f9f9f9 5%, #dbd8db 100%);
        background: -ms-linear-gradient(top, #f9f9f9 5%, #dbd8db 100%);
        background: linear-gradient(to bottom, #f9f9f9 5%, #dbd8db 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f9f9f9', endColorstr='#dbd8db', GradientType=0);
        background-color: #f9f9f9;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        border-radius: 6px;
        border: 1px solid #dcdcdc;
        display: inline-block;
        cursor: pointer;
        color: #666666;
        font-family: Arial;
        font-size: 12px;
        font-weight: bold;
        padding: 4px 20px;
        text-decoration: none;
        text-shadow: 0px 1px 0px #ffffff;
    }

    .btn_print:hover {
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #dbd8db), color-stop(1, #f9f9f9));
        background: -moz-linear-gradient(top, #dbd8db 5%, #f9f9f9 100%);
        background: -webkit-linear-gradient(top, #dbd8db 5%, #f9f9f9 100%);
        background: -o-linear-gradient(top, #dbd8db 5%, #f9f9f9 100%);
        background: -ms-linear-gradient(top, #dbd8db 5%, #f9f9f9 100%);
        background: linear-gradient(to bottom, #dbd8db 5%, #f9f9f9 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#dbd8db', endColorstr='#f9f9f9', GradientType=0);
        background-color: #dbd8db;
    }

    .btn_print:active {
        position: relative;
        top: 1px;
    }

    .bg_tr {
        background-color: #888888;
        text-decoration: none;
        color: #000000;
    }

    .bg_tr a {
        color: #000000;

    }

    .bg_tr_nexpire {
        background-color: #CD853F;
        text-decoration: none;
        color: #000000;

    }

    .bg_tr_nexpire a {
        color: #000000;
    }

    .bg_tr_expire {
        background-color: #A52A2A;
        text-decoration: none;
        color: #000000;

    }

    .bg_tr_expire a {
        color: #000000;
    }

    .bg_tr_cancel {
        background-color: #808080;
        text-decoration: none;
        color: #000000;

    }

    .bg_tr_cancel a {
        color: #000000;
    }


</style>
<?php
$EndYear = date('Y');
$StartYear = $EndYear-10;


	$txtsearch = $_POST['txtsearch'];
	if($_POST['otp']=='senddate')
	{
		$arr_id = explode("/",$_POST['txtstartdate']);
		$arr_id2 = explode("/",$_POST['txtenddate']);
		$search = " AND data.send_date BETWEEN '".$arr_id[2]."-".$arr_id[1]."-".$arr_id[0]."' AND '".$arr_id2[2]."-".$arr_id2[1]."-".$arr_id2[0]."' ";
		$txtsearch = $_POST['txtstartdate'].'&txtsearch2='.$_POST['txtenddate'];
		//$txtsearch2 = $_POST['txtenddate'];

	}else if($_POST['otp']=='iddata')
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
		
		$legtxt=strlen($_POST['txtsearch']);
		if($legtxt>=13)
		{
			$lowtxt=$legtxt-7;
			$subtxt=substr($_POST['txtsearch'],$lowtxt,7);
		}
		else
		{
			$subtxt=$_POST['txtsearch'];
		}
		$search = " AND (data.p_act LIKE '%".$subtxt."%' OR req.EditAct_id LIKE '%".$subtxt."%' ) ";
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

if($_SESSION['strUser']=='ADMIN' || $_SESSION["strUser"]=='admin')
{
	$sqlPmuser= '';
}
else
{
	$sqlPmuser=  " AND data.login = '".$_SESSION['strUser']."' ";
}

// $strPage = $_POST["myPage"];
$query = "SELECT ";
$query .= " insuree.name As cus_name,detail.car_detail,data.id_data,detail.id_data,insuree.id_data,data.com_data,data.n_insure,detail.br_car,detail.mo_car,detail.add_price,detail.cat_car,data.login,detail.car_regis,insuree.title,insuree.last,data.send_date,data.start_date,data.end_date,detail.car_body,detail.n_motor,data.costCost,detail.car_id,data.p_act, req.CostProduct, req.Cus_title, req.Cus_name as reqcusname, req.Cus_last, req.EditAct_id, req.Edit_CarBody, req.CostProduct, tb_customer.saka, req.Req_Status,detail.mo_sub,detail.car_cat_acc_total,detail.car_cat_acc,detail.equit,req.EditProduct,tb_br_car.name as brname ,tb_mo_car.name as moname ";
$query .= ",insuree.add,insuree.group,insuree.town,insuree.lane,insuree.road,insuree.tumbon,insuree.amphur,insuree.province,insuree.postal ";
$query .= ",req.EditCustomer,req.Cus_add,req.Cus_group,req.Cus_town,req.Cus_lane,req.Cus_road,req.Cus_tumbon,req.Cus_tumbon,req.Cus_amphur,req.Cus_province,req.Cus_postal,req.EditCar,req.Edit_CarBody,req.EditTime,req.EditTime_StartDate,req.EditTime_EndDate , ";
$query .= "tb_tumbon.name as tumbon_name, "; 
$query .= "tb_amphur.name as amphur_name, "; 
$query .= "tb_province.name as province_name "; // จังหวัด
$query .= " FROM data ";
$query .= " INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query .= " INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query .= " INNER JOIN tb_br_car ON (detail.br_car = tb_br_car.id) ";
$query .= " INNER JOIN tb_mo_car ON (detail.mo_car = tb_mo_car.id) ";
$query .= " INNER JOIN tb_customer ON (data.login  = tb_customer.user) ";
$query .= " INNER JOIN req ON (data.id_data  = req.id_data) ";
$query .= " INNER JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
$query .= " INNER JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
$query .= " INNER JOIN tb_province ON (tb_province.id = insuree.province) ";
$query .= " WHERE req.EditCancel !='Y'  $sqlPmuser $search order by data.send_date DESC";
//echo $query;
$objQuery = mysql_query($query) or die ("Error Query tb_data [".$query."]");
$arrData = array();
$arrSumData = array();
$anc = 1;
//echo $query;
//$objQuery = mysql_query($query) or die ("Error Query [".$query."]");
$objQuery = mysql_query($query) or die ("Error Query tb_data [".$query."]");
$countD = mysql_num_rows($objQuery);
?>         
<span style="padding:10px;">พบข้อมูลจำนวน <?=$countD ;?> รายการ</span> 
<a target="_blank" href="report/report_insure_data_xls.php?otp=<?=$_POST['otp'];?>&txtsearch=<?=$txtsearch;?>" class="btn">Export Excel</a>
<a onclick="printletter()" class="btn">ซองจดหมาย</a>
<a onclick="printpaper()" class="btn">กระดาษ A4</a>
<div id="checkboxlist">
<form  id="frmPrint"  method="POST" target="_blank">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <thead>
    <tr height="30" style="font-size:12px;text-align:center; color:#fff; vertical-align:top;background-color:#848484; margin-top:10px;" >
    	  <th width="80"><input onchange="checkAll(this)" type="checkbox" name="chkall[]"></th>
	      <th>วันที่แจ้ง</th>
<!-- 	      <th  width="4%" height="16">รหัส</th>
	      <th  width="4%" height="16">สาขา</th> 
	      <th width="5%">ดีลเลอร์</th> -->
	      <th>เลขที่รับแจ้ง/กธ.</th>
	      <th>ชื่อผู้เอาประกัน</th>
	      <!-- <th width="6%">วันที่คุ้มครอง</th> -->
	      <th>ยี่ห้อ/รุ่น</th>
	      <th>เลขตัวถัง</th>
	      <!-- <th width="9%">ที่อยู่</th> -->
<!-- 	      <th width="12%">ทุนประกันภัย</th>
	      <th width="6%">พ.ร.บ</th>
	      <th width="8%">เบี้ยรวม</th>
	      <th width="8%">เบี้ยเพิ่ม</th> -->
    </tr>
  </thead>
  <tbody>
    <?php

$totalRows=$n;
//$totalRows = COUNT($dataall)-1;

//for($iall=0;$iall<$totalRows;$iall++) { 

while($row = mysql_fetch_array($objQuery))
	{

// start สลักหลังที่อยู่ผู้เอาประกัน    
$ShowReq = '';
$saddr = '';
$saddr1 = '';
$saddr2 = '';
$insureename='';
    $query1 = "SELECT ";
    $query1 .= "tb_tumbon.name as tumbon, "; 
    $query1 .= "tb_amphur.name as amphur, "; 
    $query1 .= "tb_province.name as province "; // จังหวัด
    $query1 .= "FROM req ";
    $query1 .= "INNER JOIN tb_tumbon ON (tb_tumbon.id = req.Cus_tumbon) ";
    $query1 .= "INNER JOIN tb_amphur ON (tb_amphur.id = req.Cus_amphur) ";
    $query1 .= "INNER JOIN tb_province ON (tb_province.id = req.Cus_province) ";
    $query1 .= "WHERE req.id_data='".$row['id_data']."'";
    $objQuery1 = mysql_query($query1) or die ("Error Query [".$query1."]");
    $row1 = mysql_fetch_array($objQuery1);
    
if($row['EditCustomer'] == 'Y')
{

    $insureename .= $row['Cus_title']." ".$row['reqcusname']." ".$row['Cus_last'];
    $ShowReq .= $row['Cus_add']; 
    $saddr = $row['Cus_add'];
    if($row['Cus_group'] !="-" && $row['Cus_group'] !=""){
        $saddr .= " หมู่".$row['Cus_group'];
        $ShowReq .= " หมู่".$row['Cus_group'];
    }
    if($row['Cus_town'] !="-" && $row['Cus_town'] !=""){
        $saddr .= " ".$row['Cus_town'];
        $ShowReq .= " ".$row['Cus_town'];
    }
    if($row['Cus_lane'] !="-" && $row['Cus_lane'] !=""){
        $saddr .=" ซอย".$row['Cus_lane'];
        $ShowReq .= " ซอย".$row['Cus_lane'];
    }
    if($row['Cus_road'] !="-"){
        $saddr .= " ถนน".$row['Cus_road'];
        $ShowReq .= " ถนน".$row['Cus_road'];
    }
    if($row1['Cus_province'] != "102"){
        $dataaddr = $saddr;
        $dataaddr1="ต.".$row1['tumbon']." อ.".$row1['amphur'];
        $dataaddr2="จ.".$row1['province']." ".$row['Cus_postal']; 
        $ShowReq .= "ต.".$row1['tumbon']." อ.".$row1['amphur']." จ.".$row1['province']." ".$row['Cus_postal']; 
    }else{
        $dataaddr = $saddr;
        $dataaddr1 ="แขวง".$row1['tumbon']."  ".$row1['amphur'];
        $dataaddr2 =$row1['province']." ".$row['Cus_postal'];
        $ShowReq .= "แขวง".$row1['tumbon']."  ".$row1['amphur']." ".$row1['province']." ".$row['Cus_postal'];
    }
    
}else{
        $insureename .= $row['title'].$row['cus_name'].' '.$row['last'];
        $ShowReq .= "".$row['add']; 
        $saddr = $row['add']; 
        if($row['group'] !="-" && $row['group'] !="")
        {
            $saddr .=    " หมู่".$row['group'];
            $ShowReq .= " หมู่".$row['group'];
        }
        if($row['town'] !="-" && $row['town'] !="")
        {
            $saddr .= " ".$row['town'];
            $ShowReq .= " ".$row['town'];
        }
        if($row['lane'] !="-" && $row['lane'] !="")
        {
             $saddr .= " ซอย".$row['lane'];
            $ShowReq .= " ซอย".$row['lane'];
        }
        if($row['road'] !="-" && $row['road'] !="")
        {
             $saddr .=" ถนน".$row['road'];
            $ShowReq .= " ถนน".$row['road'];
        }

        if($row['province'] != "102"){
            $dataaddr = $saddr;
            $dataaddr1 = 'ต.'.$row['tumbon_name'].' อ.'.$row['amphur_name'] ;
            $dataaddr2 = 'จ.'.$row['province_name'].' '.$row['postal'];

            $ShowReq .= 'ต.'.$row['tumbon_name'].' อ.'.$row['amphur_name'].' จ.'.$row['province_name'].' '.$row['postal'];
        }
        else{
            $dataaddr = $saddr;
            $dataaddr1 ='แขวง'.$row['tumbon_name'].'  '.$row['amphur_name'];
            $dataaddr2 = $row['province_name'].' '.$row['postal'];
       
            $ShowReq .= 'แขวง'.$row['tumbon_name'].'  '.$row['amphur_name'].' '.$row['province_name'].' '.$row['postal'];
        }
}

// start สลักหลังเลขตัวถัง  
if($row['EditCar'] == 'Y'){
    $car_body = "เลขตัวถัง : ".$row['Edit_CarBody'];
}else{
    $car_body = $row['car_body'];
}
// end สลักหลังเลขตัวถัง

// start สลักหลังเลขตัวถัง  
if($row['EditTime'] == 'Y'){
    $insdate = DateThai($row['EditTime_StartDate']).' - '.DateThai($row['EditTime_EndDate']) ;
}else{
    $insdate = DateThai($row['start_date']).' - '.DateThai($row['end_date']) ;
}
// end สลักหลังเลขตัวถัง

    $carmodel = $row['moname'];
    

		if($row['com_data']== "VIB_S"){
 			$idcom_data = "09712";
		}else if($row['com_data']=="VIB_F"){
			$idcom_data = "11678";
		}else if($row['com_data']=="VIB_C" && $row['saka'] == '113'){
			$idcom_data = "08829";
		}else if($row['com_data']=="VIB_C" && $row['saka'] != '113'){
			$idcom_data = "10320";
		}

  ?>
      <?php if(!empty($row['mo_sub']))
          { 
          $mo_car_sub_sql="SELECT name FROM tb_mo_car_sub WHERE id = '".$row['mo_sub']."'";
          $mo_car_sub_query=mysql_query($mo_car_sub_sql);
          $mo_car_sub_array=mysql_fetch_array($mo_car_sub_query);
              if(!empty($mo_car_sub_array))
              {
                $mo_sub_name=" (".$mo_car_sub_array['name'].")";
              }
          }
      ?>
    <tr align="center">
      <td style='vertical-align:top;'><input type="checkbox" id="chkid<?=$n;?>" name="chkid[]" value="<?=$row['id_data'].'|'.$insureename.'|'.$dataaddr.'|'.$dataaddr1.'|'.$dataaddr2;?>"></td>
      <td align="center" valign="top"  ><?=DateThai($row['send_date'])?></td>
      <td height="36" align="center" valign="top"><a data-toggle="modal" href="pages/viewSuzuki.php?IDDATA=<?=$row['id_data'];?>" aria-hidden="true"   data-target="#modal"><?=$row['id_data'];?></a></br><? echo '<font color="#FF0000">'.$row['n_insure'].'</font>';?></td>
      <td height="36" align="left" valign="top"><?=$row['title']." ".$row['cus_name']." ".$row['last']?></br><? if($row['Cus_name'] != '') {
echo "( ".$row['Cus_title'].$row['reqcusname']." ".$row['Cus_last']." )";}?></td>
      <!-- <td height="36" valign="top"><?=$insdate;?></td> -->

      <td height="36" valign="top"><?=$MoC['name'][$row['mo_car']].$mo_sub_name;?></td>
      <td height="36" valign="top" ><?=$row['car_body'];?></br><? if($row['Edit_CarBody'] != '' ){ echo '<font color="#FF0000">'.$row['Edit_CarBody'].'</font>'; } ?>
      </td>
      <!-- <td height="36" valign="top"><?=$ShowReq;?></td> -->
      
    </tr>
    <?php  } ?>
  </tbody>
</table>
<input type="submit" id="btnfrmPrint"  name="btnfrmPrint">
</form>
</div>
<script>

    function checkAll(ele) {
     var checkboxes = document.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             // console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
 }

 function  printletter(){
     $('#frmPrint').attr('action', 'print/print_letter_multi.php');
    $('#frmPrint').submit();
 }
  function  printpaper(){
    $('#frmPrint').attr('action', 'print/print_paper_multi.php');
    $('#frmPrint').submit();
 }

</script>