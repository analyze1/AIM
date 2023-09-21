<script>
//alert("ปิดปรับปรุงระบบ");
//location.href = 'login.php';
</script>
<?php
/* set the cache limiter to 'verify_user' */
session_cache_limiter('verify_user');
$cache_limiter = session_cache_limiter();
/* set the cache expire to 60 minutes */
session_cache_expire(60);
$cache_expire = session_cache_expire();
/* start the session */

	session_start();
	header('Content-Type: text/html; charset=utf-8');
	include "inc/connectdbs.inc.php"; 
	mysql_select_db($db1,$cndb1);
	$xuser = trim($_POST["f_user"]);
	$xpass = trim($_POST["f_pass"]);
	
	
	$ip_address = $_SERVER['REMOTE_ADDR'];
        $optClaim = $_POST["optClaim"];
        if($optClaim=='1'){
            $sqlPS = " and c.pw = '$xpass' ";
            $sesClaim = '1';
        }else if($optClaim=='2'){
            $sqlPS = " and c.pwclaim = '$xpass' ";
            $sesClaim = '2';
        }else{ ?>
            <script>
            	alert("กรุณาเลือกฝ่าย");
            	location.href = 'login.php';
            </script>
       <?php }
	   $claim_sql="SELECT c.claim  FROM tb_customer c  WHERE c.user = '$xuser' $sqlPS";
	   $claim_query=mysql_query($claim_sql,$cndb1);
	   $claim_array=mysql_fetch_array($claim_query);
	   $_SESSION['claim']=$claim_array['claim'];
		if($xuser == "admin" || $_SESSION['claim']=='ADMIN'){
			$query = "SELECT c.*  FROM tb_customer c  WHERE 1=1  $sqlPS  AND c.nameuser='My4ib'";
		}else{
			$query = "SELECT c.* FROM tb_customer c  WHERE c.user = '$xuser' $sqlPS AND c.nameuser='Suzuki'";
		}
                
	$objQuery = mysql_query($query,$cndb1) or die ("Error Query [".$query."]");
	$total = mysql_num_rows($objQuery);
	$row = mysql_fetch_array($objQuery);
	if(empty($row))
	{
		if($xuser == "admin" || $_SESSION['claim']=='ADMIN'){
			$query = "SELECT c.*  FROM tb_customer_stock c  WHERE 1=1  $sqlPS  AND c.nameuser='My4ib'";
		}else{
			$query = "SELECT c.* FROM tb_customer_stock c  WHERE c.user = '$xuser' $sqlPS AND c.nameuser='Suzuki'";
		}
	$objQuery = mysql_query($query,$cndb1) or die ("Error Query [".$query."]");
	$total = mysql_num_rows($objQuery);
	$row = mysql_fetch_array($objQuery);
	}
        $idUser = $row['id'];
        $area = $row['area'];
	$name = $row['title_sub']." ".$row['sub'];
	$company = $row['nameuser'];
	$saka = $row['saka'];
	$location = $row['location'];
		$menu_prb=$row['menu_prb']; 
		$menu_red=$row['menu_red'];
		$menu_year=$row['menu_year'];
		$menu_new=$row['menu_new'];
		$menu_stock=$row['menu_stock'];
		$menu_viewsale=$row['viewsale'];
		$logo_images=$row['logo_images'];
		$icon_logo=$row['icon_logo'];
		if($total=='0'){
	?>
            <script>
            	alert("ท่านกรอกรหัสผ่านไม่ถูกต้อง");
            	location.href = 'login.php';
            </script>
	<?php 
		}else{
		$_SESSION["strArea"] = $area;
		$_SESSION["idUser"] = $idUser;
		$_SESSION["strName"] = $name;
		$_SESSION["strUser"] = $xuser;
		$_SESSION["strPass"] = $xpass;
		$_SESSION["name"] = $company; 
		$_SESSION["saka"] = $saka; 
		$_SESSION["location"] = $location; 
		$_SESSION["sesClaim"] = $sesClaim;
		$_SESSION["menu_prb"] = $menu_prb; 
		$_SESSION["menu_red"] = $menu_red;
		$_SESSION["menu_year"] = $menu_year;
		$_SESSION["menu_new"] = $menu_new;
		$_SESSION["menu_stock"] = $menu_stock;
		$_SESSION["viewsale"] = $menu_viewsale;
		$_SESSION["logo_images"] = $logo_images;
		$_SESSION['icon_logo']=$icon_logo;
		$expire=time()+60*60*24*30;
		//---------------------------ราคาอุปกรณ์ตกแต่ง และเบี้ยเพิ่ม-------------------------------
		$sqlMORE = "SELECT * FROM tb_acc";
		$objQueryMORE = mysql_query($sqlMORE,$cndb1) or die ("Error Query [".$sqlMORE."]");
		$costOb = array();
			while($rowCost = mysql_fetch_array($objQueryMORE)){
				$costOb['name'][$rowCost['id']] = $rowCost['name'];
				$costOb['price'][$rowCost['id']] = $rowCost['price'];
				$costOb['price2'][$rowCost['id']] = $rowCost['price2'];
			}
			$_SESSION["Cost"] = $costOb; //ราคาอุปกรณ์ตกแต่ง และเบี้ยเพิ่ม
		//---------------------------รายการอุปกรณ์ตกแต่ง-------------------------------
		$sqlMOREname = "SELECT * FROM tb_acc_new";
		$objQueryMOREname = mysql_query($sqlMOREname,$cndb1) or die ("Error Query [".$sqlMOREname."]");
		$costObname = array();
			while($rowCostname = mysql_fetch_array($objQueryMOREname)){
				$costObname['name']['0'.$rowCostname['idcar']][$rowCostname['id']] = $rowCostname['name'];
			}
			$_SESSION["CostName"] = $costObname; //รายการอุปกรณ์ตกแต่ง
		
		//---------------------------ทุน เบี้ยสุทธิ อากร ภาษี เบี้ยรวม-------------------------------
		$Pre = array();
		$queryPre = "SELECT id,cost,pre,stamp,tax,net FROM tb_cost";
		$objQueryPre = mysql_query($queryPre,$cndb1) or die ("Error Query [".$queryPre."]");
			while($rowPre = mysql_fetch_array($objQueryPre)) {
				$Pre['PreCost'][$rowPre['id']]= $rowPre['cost'];
				$Pre['pre'][$rowPre['id']]= $rowPre['pre'];
				$Pre['stamp'][$rowPre['id']]= $rowPre['stamp'];
				$Pre['tax'][$rowPre['id']]= $rowPre['tax'];
				$Pre['net'][$rowPre['id']]= $rowPre['net'];
			}
			$_SESSION["CostPre"] = $Pre; //ทุน เบี้ยสุทธิ อากร ภาษี เบี้ยรวม
		
		//---------------------------ชื่อรุ่น-------------------------------			
		$MoC = array();
		$queryMoC = "SELECT id,name,cost_group,listchose FROM tb_mo_car";
		$objQueryMoC = mysql_query($queryMoC,$cndb1) or die ("Error Query [".$queryMoC."]");
			while($rowMoC = mysql_fetch_array($objQueryMoC)) {
				$MoC[$rowMoC['id']]=$rowMoC['name'];
	$MoCd[$rowMoC['id']]=$rowMoC['cost_group'];
	$MoList[$rowMoC['id']]=$rowMoC['listchose'];
}
$_SESSION["MoC"] = $MoC; //ชื่อรุ่น
$_SESSION["MoCd"] = $MoCd;
$_SESSION["MoList"] = $MoList;
		
		//---------------------------จังหวัด-------------------------------		
		$Pro = array();
		$queryPro = "SELECT id,name FROM tb_province";
		$objQueryPro = mysql_query($queryPro,$cndb1) or die ("Error Query [".$queryPro."]");
			while($rowPro = mysql_fetch_array($objQueryPro)) {
				$Pro[$rowPro['id']]=$rowPro['name'];
			}
			$_SESSION["Pro"] = $Pro; //จังหวัด
		
		//---------------------------อำเภอ-------------------------------	
		$Amp = array();
		$queryAmp = "SELECT id,name FROM tb_amphur";
		$objQueryAmp = mysql_query($queryAmp,$cndb1) or die ("Error Query [".$queryAmp."]");
			while($rowAmp = mysql_fetch_array($objQueryAmp)) {
				$Amp[$rowAmp['id']]=$rowAmp['name'];
			}
			$_SESSION["Amp"] = $Amp; //อำเภอ
		
		//---------------------------ตำบล-------------------------------	
		$Tum = array();
		$queryTum = "SELECT id,name FROM tb_tumbon";
		$objQueryTum = mysql_query($queryTum,$cndb1) or die ("Error Query [".$queryTum."]");
			while($rowTum = mysql_fetch_array($objQueryTum)) {
				$Tum[$rowTum['id']]=$rowTum['name'];
			}
			$_SESSION["Tum"] = $Tum; //ตำบล

			$_SESSION["Alert"] = 1;
			
			//check_login
			$log_user=$xuser;
			$log_ip=$_SERVER['REMOTE_ADDR'];
			$log_name=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$log_date=date('Y-m-d');
			$log_url = $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
			mysql_select_db($db3,$cndb3);
			$check_log_sql="SELECT log_ip FROM log_url WHERE log_user = '".$log_user."' AND log_ip = '".$log_ip."' AND log_name = '".$log_name."' AND DATE(log_date) = '".$log_date."' AND log_url = '".$log_url."'";
			$check_log_query=mysql_query($check_log_sql,$cndb3);
			$check_log_array=mysql_fetch_array($check_log_query);
			if(empty($check_log_array))
			{
			$insert_log_sql="INSERT INTO log_url (log_user,log_ip,log_name,log_date,log_url) VALUES ('".$log_user."','".$log_ip."','".$log_name."',NOW(),'".$log_url."')";
			mysql_query($insert_log_sql,$cndb3);
			}
		?>
			<script>
				location.href = 'index.php';
			</script>
		<?php
		}




//// ------ Check Url ----------//
//	$url = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
//
//function get_client_ip() {
//     $ipaddress = '';
//     if ($_SERVER['HTTP_CLIENT_IP'])
//         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
//     else if($_SERVER['HTTP_X_FORWARDED_FOR'])
//         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
//     else if($_SERVER['HTTP_X_FORWARDED'])
//         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
//     else if($_SERVER['HTTP_FORWARDED_FOR'])
//         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
//     else if($_SERVER['HTTP_FORWARDED'])
//         $ipaddress = $_SERVER['HTTP_FORWARDED'];
//     else if($_SERVER['REMOTE_ADDR'])
//         $ipaddress = $_SERVER['REMOTE_ADDR'];
//     else
//         $ipaddress = 'UNKNOWN';
//
//     return $ipaddress; 
//}
//
//	$strSQL_log = "INSERT INTO log_url (log_url,log_date,log_ip,log_user) VALUES ('$url','".date("Y-m-d H:i:s")."', '".get_client_ip()."','".$_SESSION["strUser"]."')";
//	$objQuery_log = mysql_query($strSQL_log) or die ("Error Query [".$strSQL_log."]");
//
////--- End Check Url--------//
//
//
//	session_write_close();
//	mysql_close();
?>
<?php
###########################
## Check User Online ##
############################
function get_client_ip() {
     $ipaddress = '';
     if ($_SERVER['HTTP_CLIENT_IP'])
         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
     else if($_SERVER['HTTP_X_FORWARDED_FOR'])
         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
     else if($_SERVER['HTTP_X_FORWARDED'])
         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
     else if($_SERVER['HTTP_FORWARDED_FOR'])
         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
     else if($_SERVER['HTTP_FORWARDED'])
         $ipaddress = $_SERVER['HTTP_FORWARDED'];
     else if($_SERVER['REMOTE_ADDR'])
         $ipaddress = $_SERVER['REMOTE_ADDR'];
     else
         $ipaddress = 'UNKNOWN';

     return $ipaddress; 
}
mysql_select_db($db1,$cndb1);
$useronline = session_id();
$time = time();
$idUser = $_SESSION['idUser'];
$_SESSION['stimeOnline'] = time()+ (120);

$sqlOnline = "select * from useronline where iduser = '".$idUser."'";
$resultOnline = mysql_query($sqlOnline,$cndb1);
$num = mysql_num_rows($resultOnline);
//echo $sqlOnline;
if($num > 0){
    mysql_query("update useronline set time_online = '$time',statusonline = '1'
    where iduser = '$idUser'");
}
else{
    mysql_query("insert into useronline (tsession,time_online,iduser,statusonline) values
    ('$useronline','$time','$idUser','1')");
}

?>
                        
<?php 

###########################
## END Check User Online ##
############################
?>