<?php
session_start();
$idUser = $_SESSION['idUser'];
@session_destroy();
include "../inc/connectdbs.pdo.php";

$sqlOnline = "select * from useronline where iduser = '".$idUser."'";
$resultOnline = PDO_CONNECTION::fourinsure_mitsu()->query($sqlOnline);
$num = $resultOnline->rowCount();

if($num > 0){
    $val = "update useronline set statusonline = '0' where iduser = '$idUser'";
    PDO_CONNECTION::fourinsure_mitsu()->prepare($val)->execute();
}


?>
<?php
// session_start();
// session_destroy();
?>
<script>
alert("ออกจากระบบสำเร็จ");
<?php if($_GET['log']=='sip'){ ?>
location.href = 'sip_login.php';
<?php }else{ ?>
location.href = 'login.php';
<?php } ?>
</script>