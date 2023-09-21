<?php
/* set the cache limiter to 'verify_user' */
@session_cache_limiter('verify_user');
$cache_limiter = session_cache_limiter();

/* set the cache expire to 60 minutes */
@session_cache_expire(60);
$cache_expire = session_cache_expire();
/* start the session */

session_start();
header('Content-Type: text/html; charset=utf-8');
include "./inc/connectdbs.pdo.php";
$_contextMitSu = PDO_CONNECTION::fourinsure_mitsu();
$_contextAccount = PDO_CONNECTION::fourinsure_account();

$xuser = trim($_POST["f_user"]);
$xpass = trim($_POST["f_pass"]);

$ip_address = $_SERVER['REMOTE_ADDR'];
$optClaim = $_POST["optClaim"];
if ($_GET['log'] == 'sip') {
	$where_sql = "AND lg.log_type = 'sip' ";
} else {
	$where_sql = "AND lg.log_type != 'sip' ";
}
if ($optClaim == '1') {
	$sqlPS = " and c.pw = '$xpass' ";
	$sesClaim = '1';
	$query = "SELECT c.*,lg.id_log,lg.user as lguser ,lg.uname,lg.ulname,lg.mn_prb,lg.mn_red,lg.mn_year,lg.mn_new,lg.mn_stock,lg.logo_images,lg.icon_logo FROM tb_customer c INNER JOIN tb_login lg ON (c.user = lg.code_dealer) WHERE st_active ='Y' AND lg.user ='" . $xuser . "' AND lg.pass='" . $xpass . "' " . $where_sql . " ";
	$resBL = $_contextMitSu->query($query);
	$total = $resBL->rowCount();
	$row = $resBL->fetch(2);
} else if ($optClaim == '2') {

	$sqlPS = " and c.pwclaim = '$xpass' ";
	$sesClaim = '2';
	$claim_sql = "SELECT * FROM tb_customer c  WHERE c.user = '$xuser' $sqlPS";
	$claim_query = $_contextMitSu->query($claim_sql);
	$total = $claim_query->rowCount();
	$row = $claim_query->fetch(2);
	$_SESSION['claim'] = $row['claim'];
} else { ?>
	<script>
		alert("กรุณาเลือกฝ่าย");
		<?php if ($_GET['log'] == 'sip') { ?>
			location.href = 'sip_login.php';
		<?php } else { ?>
			location.href = 'login.php';
		<?php } ?>
	</script>
<?php }

$codedealer = $row['user'];
$custpw = $row['pw'];
$idUser = $row['id'];
$area = $row['area'];
$name = $row['title_sub'] . " " . $row['sub'];
$company = $row['nameuser'];
$saka = $row['saka'];
$location = $row['location'];
$menu_prb = $row['mn_prb'];
$menu_red = $row['mn_red'];
$menu_year = $row['mn_year'];
$menu_new = $row['mn_new'];
$menu_stock = $row['mn_stock'];
$menu_viewsale = $row['viewsale'];
$logo_images = $row['logo_images'];
$icon_logo = $row['icon_logo'];
$uname = $row['uname'];
$ulname = $row['ulname'];
$idtb_login = $row['id_log'];
$lguser = $row['lguser'];
$group_pv = $row['group_pv'];
$TeleNumber = $row['Telephone'];

if ($total == '0') {
?>
	<script>
		alert("ท่านกรอกรหัสผ่านไม่ถูกต้อง");
		<?php if ($_GET['log'] == 'sip') { ?>
			location.href = 'sip_login.php';
		<?php } else { ?>
			location.href = 'login.php';
		<?php } ?>
	</script>
<?php
} else {

	$_SESSION["strArea"] = $area;
	$_SESSION["idUser"] = $idUser;
	$_SESSION["strName"] = $name;
	$_SESSION["strUser"] = $codedealer;
	$_SESSION["strPass"] = $custpw;
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
	$_SESSION['icon_logo'] = $icon_logo;
	$_SESSION['telephone'] = $TeleNumber;
	$_SESSION["idtb_login"] = $idtb_login;
	$_SESSION["lguser"] = $lguser;
	$_SESSION["uname"] = $uname;
	$_SESSION["ulname"] = $ulname;
	$_SESSION["group_pv"] = $group_pv; //แยกภาค

	if ($_SESSION["lguser"] == 'MART') {
		$_SESSION["use_prb"] = 'Y';
	} else {
		$_SESSION["use_prb"] = 'N';
	}

	$expire = time() + 60 * 60 * 24 * 30;
	//---------------------------ราคาอุปกรณ์ตกแต่ง และเบี้ยเพิ่ม-------------------------------
	$sqlMORE = "SELECT * FROM tb_acc";

	$objQueryMORE = $_contextMitSu->query($sqlMORE);
	$costOb = array();
	foreach ($objQueryMORE->fetchAll() as $rowCost) {
		$costOb['name'][$rowCost['id']] = $rowCost['name'];
		$costOb['price'][$rowCost['id']] = $rowCost['price'];
		$costOb['price2'][$rowCost['id']] = $rowCost['price2'];
	}
	$_SESSION["Cost"] = $costOb; //ราคาอุปกรณ์ตกแต่ง และเบี้ยเพิ่ม
	//---------------------------รายการอุปกรณ์ตกแต่ง-------------------------------
	$sqlMOREname = "SELECT * FROM tb_acc_new";
	$objQueryMOREname = $_contextMitSu->query($sqlMOREname);
	$costObname = array();
	foreach ($objQueryMOREname->fetchAll() as $rowCostname) {
		$costObname['name']['0' . $rowCostname['idcar']][$rowCostname['id']] = $rowCostname['name'];
	}
	$_SESSION["CostName"] = $costObname; //รายการอุปกรณ์ตกแต่ง

	//---------------------------ทุน เบี้ยสุทธิ อากร ภาษี เบี้ยรวม-------------------------------
	$Pre = array();
	$queryPre = "SELECT id,cost,pre,stamp,tax,net FROM tb_cost";
	$objQueryPre = $_contextMitSu->query($queryPre);
	foreach ($objQueryPre->fetchAll() as $rowPre) {
		$Pre['PreCost'][$rowPre['id']] = $rowPre['cost'];
		$Pre['pre'][$rowPre['id']] = $rowPre['pre'];
		$Pre['stamp'][$rowPre['id']] = $rowPre['stamp'];
		$Pre['tax'][$rowPre['id']] = $rowPre['tax'];
		$Pre['net'][$rowPre['id']] = $rowPre['net'];
	}
	$_SESSION["CostPre"] = $Pre; //ทุน เบี้ยสุทธิ อากร ภาษี เบี้ยรวม

	//---------------------------ชื่อรุ่น-------------------------------			
	$MoC = array();
	$queryMoC = "SELECT id,name FROM tb_mo_car";
	$objQueryMoC = $_contextMitSu->query($queryMoC);
	foreach ($objQueryMoC->fetchAll() as $rowMoC) {
		$MoC[$rowMoC['id']] = $rowMoC['name'];
	}
	$_SESSION["MoC"] = $MoC; //ชื่อรุ่น
	$_SESSION["MoCd"] = $MoCd;
	$_SESSION["MoList"] = $MoList;

	//---------------------------จังหวัด-------------------------------		
	$Pro = array();
	$queryPro = "SELECT id,name FROM tb_province";
	$objQueryPro = $_contextMitSu->query($queryPro);
	foreach ($objQueryPro->fetchAll() as $rowPro) {
		$Pro[$rowPro['id']] = $rowPro['name'];
	}
	$_SESSION["Pro"] = $Pro; //จังหวัด

	//---------------------------อำเภอ-------------------------------	
	$Amp = array();
	$queryAmp = "SELECT id,name FROM tb_amphur";
	$objQueryAmp = $_contextMitSu->query($queryAmp);
	foreach ($objQueryAmp->fetchAll() as $rowAmp) {
		$Amp[$rowAmp['id']] = $rowAmp['name'];
	}
	$_SESSION["Amp"] = $Amp; //อำเภอ

	//---------------------------ตำบล-------------------------------	
	$Tum = array();
	$queryTum = "SELECT id,name FROM tb_tumbon";
	$objQueryTum = $_contextMitSu->query($queryTum);
	foreach ($objQueryTum->fetchAll() as $rowTum) {
		$Tum[$rowTum['id']] = $rowTum['name'];
	}
	$_SESSION["Tum"] = $Tum; //ตำบล

	$_SESSION["Alert"] = 1;

	//check_login
	$log_user = $xuser;
	$log_ip = $_SERVER['REMOTE_ADDR'];
	$log_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$log_date = date('Y-m-d');
	$log_url = $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];

	$check_log_sql = "SELECT log_ip FROM log_url WHERE log_user = '" . $log_user . "' AND log_ip = '" . $log_ip . "' AND log_name = '" . $log_name . "' AND DATE(log_date) = '" . $log_date . "' AND log_url = '" . $log_url . "'";
	// echo $check_log_sql;exit;
	$check_log_query = $_contextAccount->query($check_log_sql);
	$check_log_array = $check_log_query->fetch();
	if (empty($check_log_array)) {
		$insert_log_sql = "INSERT INTO log_url (log_user,log_ip,log_name,log_date,log_url) VALUES ('" . $log_user . "','" . $log_ip . "','" . $log_name . "',NOW(),'" . $log_url . "')";
		$_contextAccount->prepare($insert_log_sql)->execute();
	}
?>

	<script>
		<?php if ($_GET['log'] == 'sip') { ?>
			location.href = 'index.php?log=<?php echo  $_GET['log']; ?>';
		<?php } else { ?>
			location.href = 'index.php';
		<?php } ?>
	</script>
<?php
}

$check_log_sql = "SELECT log_ip FROM log_url WHERE log_user = '" . $log_user . "' AND log_ip = '" . $log_ip . "' AND log_name = '" . $log_name . "' AND DATE(log_date) = '" . $log_date . "' AND log_url = '" . $log_url . "'";
// echo $check_log_sql;exit;
$check_log_query = $_contextAccount->query($check_log_sql);
$check_log_array = $check_log_query->fetch();
if (empty($check_log_array)) {
	$insert_log_sql = "INSERT INTO log_url (log_user,log_ip,log_name,log_date,log_url) VALUES ('" . $log_user . "','" . $log_ip . "','" . $log_name . "',NOW(),'" . $log_url . "')";
	$_contextAccount->prepare($insert_log_sql)->execute();
}
?>
<script>
	<?php if ($_GET['log'] == 'sip') { ?>
		location.href = 'index.php?log=<?php echo  $_GET['log']; ?>';
	<?php } else { ?>
		//goto login success!
		location.href = 'index.php';
	<?php } ?>
</script>
<?php
###########################
## Check User Online ##
############################
function get_client_ip()
{
	$ipaddress = '';
	if ($_SERVER['HTTP_CLIENT_IP'])
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if ($_SERVER['HTTP_X_FORWARDED_FOR'])
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if ($_SERVER['HTTP_X_FORWARDED'])
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if ($_SERVER['HTTP_FORWARDED_FOR'])
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if ($_SERVER['HTTP_FORWARDED'])
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if ($_SERVER['REMOTE_ADDR'])
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'UNKNOWN';

	return $ipaddress;
}

$useronline = session_id();
$time = time();
$idUser = $_SESSION['idUser'];
$_SESSION['stimeOnline'] = time() + (120);

$sqlOnline = "select * from useronline where iduser = '" . $idUser . "'";
$resultOnline = $_contextMitSu->query($sqlOnline);
$num = $resultOnline->rowCount();
//echo $sqlOnline;
if ($num > 0) {
	$val = "update useronline set time_online = '$time',statusonline = '1'
    where iduser = '$idUser'";
	$_contextMitSu->prepare($val)->execute();
} else {
	$val2 = "insert into useronline (tsession,time_online,iduser,statusonline) values
    ('$useronline','$time','$idUser','1')";
	$_contextMitSu->prepare($val2)->execute();
}
###########################
## END Check User Online ##
############################
?>