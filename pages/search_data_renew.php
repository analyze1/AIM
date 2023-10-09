<?php
include "check-ses.php";
include "../inc/connectdbs.pdo.php";
include "../inc/function.php";

$_contextMitsu = PDO_CONNECTION::fourinsure_mitsu();
$_contextFour = PDO_CONNECTION::fourinsure_insured();

if ($_SESSION['log_type'] == 'TIP') {
    $condition = "data.work_type = 'TIP' AND";
} elseif ($_SESSION['log_type'] == 'AIM') {
    $condition = '';
} else {
    $condition = "data.work_type IS NULL OR data.work_type = '' AND";
}

if ($_SESSION["strUser"] != 'admin' && $_SESSION['claim'] != 'ADMIN') {
    $sqltext = " AND userdetail='DEALER' ";
}

$EndYear = date('Y');
$StartYear = $EndYear - 3;

if ($_POST['otp'] == 'iddata') {
    $new_iddata = explode("-", $_POST['txtsearch']);

    if ($new_iddata[1] == '') {
        $search = " AND `data`.id_data  like '%" . $_POST['txtsearch'] . "%' ";
    } else {
        $search = " AND (`data`.id_data" . " LIKE '%" . $new_iddata[0] . "/รย/" . $new_iddata[1] . "%' OR data.id_data LIKE '%" . $new_iddata[0] . "/FOUR/" . $new_iddata[1] . "%' ) ";
    }
} else if ($_POST['otp'] == 'policy') {
    $search = " AND `data`.n_insure  like '%" . $_POST['txtsearch'] . "%' ";
} else if ($_POST['otp'] == 'namesearch') {
    $search = " AND ((insuree.name" . " LIKE '%" . $_POST['txtsearch'] . "%' OR insuree.last LIKE '%" . $_POST['txtsearch'] . "%' ) OR (req.Cus_name" . " LIKE '%" . $_POST['txtsearch'] . "%' OR req.Cus_last LIKE '%" . $_POST['txtsearch'] . "%' ) ) ";
} else if ($_POST['otp'] == 'prb') {
    $search = " AND (`data`.p_act LIKE '%" . $_POST['txtsearch'] . "%' OR req.EditAct_id LIKE '%" . $_POST['txtsearch'] . "%' ) ";
} else if ($_POST['otp'] == 'carbody') {
    $search = " AND (detail.car_body  LIKE  '%" . $_POST['txtsearch'] . "%' OR req.Edit_CarBody LIKE '%" . $_POST['txtsearch'] . "%' ) ";
} else if ($_POST['otp'] == 'phone') {
    $search = " AND insuree.tel_home" . " LIKE '%" . $_POST['txtsearch'] . "%' OR insuree.tel_mobi LIKE '%" . $_POST['txtsearch'] . "%' OR insuree.tel_mobi_2 LIKE '%" . $_POST['txtsearch'] . "%' OR insuree.tel_mobi_3 LIKE '%" . $_POST['txtsearch'] . "%' ";
} else if ($_POST['otp'] == 'regis') {
    $search = " AND detail.car_regis LIKE '%" . $_POST['txtsearch'] . "%' ";
} else if ($_POST['otp'] == 'n_motor') {
    $search = " AND detail.n_motor LIKE '%" . $_POST['txtsearch'] . "%' ";
}

$query = "SELECT ";
$query .= "req.EditAct_id,act.PactOnline,act.p_act,insuree.id_data,insuree.title,insuree.last,insuree.name As cus_name,data.id_data,detail.id_data,data.com_data,data.n_insure,data.login,data.send_date,data.start_date,data.end_date,data.costCost,data.p_act,detail.br_car,detail.mo_car,detail.add_price,detail.cat_car,detail.car_regis,detail.car_body,detail.n_motor,detail.car_id,detail.price_total,req.EditTime,req.EditTime_StartDate ";
$query .= "FROM data ";
$query .= "INNER JOIN act ON (`data`.id_data = act.id_data) ";
$query .= "INNER JOIN detail ON (`data`.id_data = detail.id_data) ";
$query .= "INNER JOIN insuree ON (`data`.id_data  = insuree.id_data) ";
$query .= "INNER JOIN req ON (`data`.id_data  = req.id_data) ";
$query .= "WHERE $condition insuree.name!='' AND req.EditCancel <> 'Y' ";


if ($_SESSION["strUser"] != 'admin' && $_SESSION['claim'] != 'ADMIN') {
    $query .= "AND `data`.`login`='" . $_SESSION["strUser"] . "' ";
}
$limit = $_POST['showList'];
$whereLimit = '10';
if ($limit) {
    $whereLimit = $limit;
}
echo "<script> var _pageLength = '$whereLimit'</script>";

$query .= " $search ORDER BY data.send_date DESC LIMIT $whereLimit";

$objQuery = $_contextMitsu->query($query)->fetchAll(2);
?>

<link type="text/css" rel="stylesheet" type="text/css" href="data_table/css/jquery.dataTables.css">

<style type="text/css">
    .table th,
    .table td {
        text-align: center !important;
        line-height: 20px !important;
    }

    table.dataTable thead th,
    table.dataTable thead td {
        padding: 10px 0px !important;
        border-bottom: 1px solid #111111;
    }
</style>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="detail_table" style="font-size:12px;">
    <thead>
        <tr>
            <th width="8%"></th>
            <th width="7%">วันที่แจ้ง</th>
            <!-- <th width="4%">สาขา</th> -->
            <!-- <th width="5%">ดีลเลอร์</th> -->
            <th width="13%">เลขที่รับแจ้ง/กธ.</th>
            <th width="14%">ชื่อผู้เอาประกัน</th>
            <th width="6%">วันที่คุ้มครอง</th>
            <th width="7%">ยี่ห้อ/รุ่น</th>
            <th width="10%">เลขตัวถัง</th>
            <th width="8%">ทุนประกันภัย</th>
            <th width="6%">พ.ร.บ</th>
            <th width="6%">เบี้ยรวม</th>
            <th width="6%">เบี้ยเพิ่ม</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // $totalRows = $n;
        foreach ($objQuery as $row) {
            if ($row['com_data'] == "VIB_S") {
                $idcom_data = "09712";
            } else if ($row['com_data'] == "VIB_F") {
                $idcom_data = "11678";
            } else if ($row['com_data'] == "VIB_C" && $row['saka'] == '113') {
                $idcom_data = "08829";
            } else if ($row['com_data'] == "VIB_C" && $row['saka'] != '113') {
                $idcom_data = "10320";
            }

            $query_cost = "SELECT id,cost,net FROM tb_cost WHERE  tb_cost.id='" . $row['costCost'] . "' ";
            $objQuery_cost = $_contextMitsu->query($query_cost);
            $row_decost = $objQuery_cost->fetch(2);

            // $query_costCost = "SELECT id_data,costCost FROM data WHERE  data.id_data='" . $row['id_data'] . "' ";
            // $objQuery_costCost = $_contextMitsu->query($query_costCost);
            // $row_decostCost = $objQuery_costCost->fetch(2);


            $query_detailRenew = "SELECT status,timecall FROM detail_renew WHERE detail_renew.id_data ='" . $row['id_data'] . "' order by id_detail desc limit 1 ";
            $objQuery_detailRenew = $_contextMitsu->query($query_detailRenew);
            $row_detailRenew = $objQuery_detailRenew->fetch(2);

            $query_detailRenew_f = "SELECT detailcost FROM detail_renew WHERE detail_renew.id_data ='" . $row['id_data'] . "' AND status = 'F' limit 1 ";
            $objQuery_detailRenew_f = $_contextMitsu->query($query_detailRenew_f);
            $row_detailRenew_f = $objQuery_detailRenew_f->fetch(7);

            $status_email_sql = "SELECT insuree.status_insured FROM insuree, detail,`data` WHERE detail.id_data = insuree.id_data  AND `data`.id_data = insuree.id_data AND detail.car_body = '$row[car_body]' ORDER BY `data`.send_date DESC LIMIT 1";
            $status_email_query = $_contextFour->query($status_email_sql);
            $status_email_array = $status_email_query->fetch(7);

        ?>

            <tr align="center">
                <?php
                $sql_check_e_sql = "SELECT id_data FROM detail_renew WHERE  status ='E' AND id_data = '" . $row['id_data'] . "' ";
                $sql_check_e_query = $_contextMitsu->query($sql_check_e_sql);
                $sql_check_e_array = $sql_check_e_query->fetch(2);
                ?>
                <td>
                    <?php
                    if ($row_detailRenew['status'] != 'E' && empty($sql_check_e_array)) { ?>
                        <a class="btn btn-success" style="white-space: nowrap" onclick="funcrenew('<?php echo $row['id_data']; ?>')" data-original-title="ดูข้อมูล">
                            ดูข้อมูล</a>

                        <?php } else {
                        if (
                            $status_email_array == 'Y' ||
                            $status_email_array == 'C' ||
                            $status_email_array == 'N'
                        ) {
                        ?>
                            <button class="btn btn-success" id="prints" style="white-space: nowrap" onclick="renewInsureBtn()">แจ้งงานแล้ว</button>

                        <?php } else { ?>
                            <a class='btn btn-warning btn-small' title='รออนุมัติ' rel='tooltip' id='prints'>
                                <i class='icon-white icon-time'></i>รออนุมัติ...</a>
                        <?php
                        }
                    }

                    $renew_sql = "SELECT id_data,pages FROM detail_renew WHERE id_data = '" . $row['id_data'] . "'  AND pages != '' " . $sqltext . " ORDER BY pages DESC LIMIT 0,1";
                    $renew_query = $_contextMitsu->query($renew_sql);
                    $renew_array = $renew_query->fetch(2);
                    if (!empty($renew_array)) {
                        ?>

                        <a class="btn btn-info " rel="tooltip" href='print/quotation_renew.php?id_data=<?php echo $row['id_data']; ?>&pages=<?php echo $renew_array['pages']; ?>' target='_blank' title="ดูใบเสนอราคา" rel="tooltip"><i class="icon-white icon-print"></i>
                            ดูข้อมูลเสนอราคา</a>
                    <?php } ?>
                </td>
                <td>
                    <?php
                    echo DateThai($row['send_date']);
                    // if (!empty($row_detailRenew)) {
                    // 	$edit_daterenew = explode(" ", $row_detailRenew['timecall']);
                    // 	echo DateThai($edit_daterenew[0]);
                    // } else {
                    // 	echo DateThai($row['send_date']);
                    // }
                    ?>
                </td>
                <!-- <td>
                <?php
                $query_saka = "SELECT saka FROM tb_customer WHERE  tb_customer.user='" . $row['login'] . "' ";
                $objQuery_saka = $_contextMitsu->query($query_saka);
                $row_desaka = $objQuery_saka->fetch(2);
                ?>
                <?php echo $row_desaka['saka']; ?>
            </td>
            <td><?php echo $row['login']; ?></td> -->
                <td>
                    <?php echo $row['id_data']; ?></br><?php echo '<font color="#FF0000">' . $row['n_insure'] . '</font>'; ?>
                </td>
                <td>
                    <div align="left" style="text-indent: 10px;">
                        <?php echo $row['title'] . " " . $row['cus_name'] . " " . $row['last'] ?></br>
                        <?php if ($row['Cus_name'] != '') {
                            echo "( " . $row['Cus_title'] . $row['Cus_name'] . " " . $row['Cus_last'] . " )";
                        }
                        ?>
                    </div>
                </td>
                <td>
                    <?php
                    if ($row['EditTime'] == 'Y') {
                        echo DateThai($row['EditTime_StartDate']);
                    } else {
                        echo DateThai($row['start_date']);
                    }
                    ?>
                </td>
                <?php
                $query_mocar = "SELECT `name` FROM tb_mo_car WHERE  tb_mo_car.id='" . $row['mo_car'] . "' ";
                $objQuery_mocar = $_contextFour->query($query_mocar);
                $row_democar = $objQuery_mocar->fetch(2);
                ?>
                <td><?php echo $row_democar['name']; ?></td>
                <td><?php echo $row['car_body']; ?></br>
                    <?php if ($row['Edit_CarBody'] != '') {
                        echo '<font color="#FF0000">' . $row['Edit_CarBody'] . '</font>';
                    }
                    ?>
                </td>
                <td><?php $cost_f = explode('|', $row_detailRenew_f);
                    echo $cost_f[0]; ?></td>
                <td>
                    <?php echo $row['PactOnline'] != '' ? $row['PactOnline'] : $row['p_act']; ?></br>
                    <?php if ($row['EditAct_id'] != '') {
                        echo '<font color="#FF0000">' . $row['EditAct_id'] . '</font>';
                    } ?>
                </td>
                <td>
                    <div align="right"> <?php echo number_format($row_decost['net'], 2); ?> </div>
                </td>
                <td>
                    <div align="right">
                        <?php if ($row['CostProduct'] != 0.00) {
                            echo number_format($row['CostProduct'], 2);
                        } else {
                            echo number_format($row['add_price'], 2);
                        }
                        ?>
                    </div>
                </td>
            </tr>
        <?php }  ?>
    </tbody>
</table>




<script type="text/javascript" src="data_table/js/jquery.dataTables.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#detail_table').DataTable({
            "order": [
                [4, "DESC"]
            ],
            "pageLength": _pageLength
        });
    });

    document.querySelectorAll('select').forEach(function(el) {
        el.addEventListener('change', function() {
            let name = this.name;
            if (name === 'detail_table_length') {
                console.log('select', this.value);
                search_car(this.value);
            }
            console.log('select', name);
        });
    })

    function funcrenew(a) {
        $("#pload").html("<img src='img4/loadingIcon.gif'/ style='text-align:center;'>");
        $("#pload").css('display', 'block');
        $('#collapse4').css('display', 'none');

        $('#content_pop').load('pages/renew_suzuki_select.php?id=' + a);
    }

    function renewInsureBtn() {
        alert('ลูกค้าแจ้งงานต่ออายุแล้ว กรุณาตรวจสอบที่เมนู [ตรวจสอบ/แจ้งต่ออายุ]');
    }
</script>