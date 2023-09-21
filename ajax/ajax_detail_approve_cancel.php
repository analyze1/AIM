<?php
include "../check-ses.php";
include "../inc/connectdbs.pdo.php";
$dbmy4ib_new = PDO_CONNECTION::fourinsure_mitsu();
class start_fun
{
	public function name_approve($id)
	{
		switch ($id) {
			case "R":
				$name = "<b><font color='orange'>รออนุมัติ</font></b>";
				break;
			case "N":
				$name = "<b><font color='red'>ไม่อนุมัติ</font></b>";
				break;
			case "Y":
				$name = "<b><font color='green'>อนุมัติ</font></b>";
				break;
			default:
				$name = "<b><font>ไม่ระบุ</font></b>";
				break;
		}
		return $name;
	}
}
$start_fun = new start_fun;
$approve_sql = "SELECT * FROM approve_cancel WHERE id = '" . $_POST['id'] . "' ORDER BY date_cancel DESC LIMIT 0,1";
$approve_query = $dbmy4ib_new->query($approve_sql);
$approve_array = $approve_query->fetch();

?>
<div class='span12' style='margin:0;'>
    <div class='span12' style='margin:0;'>
        <div class='span4' style='margin:0;'>
            <b>สถานะอนุมัติ :</b>
        </div>
        <div class='span8' style='margin:0;'>
            <?= $start_fun->name_approve($approve_array['status_approve']); ?>
        </div>
    </div>
    <div class='span12' style='margin:0;'>
        <div class='span4' style='margin:0;'>
            <b>เวลายืนยัน :</b>
        </div>
        <div class='span8' style='margin:0;'>
            <?php if (!empty($approve_array['date_approve'])) {
				echo $approve_array['date_approve'];
			} else {
				echo "ไม่ระบุ";
			} ?>
        </div>
    </div>
    <div class='span12' style='margin:0;'>
        <div class='span4' style='margin:0;'>
            <b>รายละเอียดยืนยัน :</b>
        </div>
        <div class='span8' style='margin:0;'>
            <?php if (!empty($approve_array['detail_approve'])) {
				echo $approve_array['detail_approve'];
			} else {
				echo "ไม่ระบุ";
			} ?>
        </div>
    </div>
</div>