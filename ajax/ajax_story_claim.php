<?php
include "../inc/connectdbs.pdo.php";
$claim_sql = "SELECT * FROM tb_claim WHERE id_data = '" . $_GET['id_data'] . "' ORDER BY dateentry ASC";
$claim_query = PDO_CONNECTION::my4ibRenew()->query($claim_sql)->fetchAll(2);
?>
<style>
#claim_table tr {
    border-style: solid;
    border-color: #ffffff;
    border-width: 2px;
    background-color: #ffffff;
}

#claim_table tr:hover {
    background-color: #b3e0ff;
}

#claim_table th {
    border-style: solid;
    border-width: 2px;
    border-color: #ffffff;
}

#claim_table td {
    border-style: solid;
    border-width: 2px;
    border-color: #ffffff;
}

.txt {
    border: 1px solid #000 !important;
    color: #000 !important;
}

.txt-st {
    border: 1px solid #000 !important;
    color: #000 !important;
}
</style>
<table id='claim_table' width='100%'>
    <tr>
        <th class='span1'><a type='button' class='btn btn-mini btn-primary' onclick='add_claim();'
                style='background-color: #4db90a !important; border: none; padding: 5px 5px; width: 100px;'>
                <i class="icon-plus-sign" style="font-size: 20px;"></i> เพิ่มข้อมูล</a>
        </th>
        <th class='span2' style="background-color: #c5c5c5;">ถูก/ผิด</th>
        <th class='span2' style="background-color: #c5c5c5;">เลขที่เคลม</th>
        <th class='span5' style="background-color: #c5c5c5;">สถานที่เกิดเหตุ</th>
        <th class='span2' style="background-color: #c5c5c5;">จำนวนเงิน</th>
    </tr>
    <?php
	$n = 0;
	$sum = 0;
	$num_w = 0;
	$sum_total = 0;
	foreach ($claim_query as $claim_array) {
		$n++; ?>
    <tr>
        <td><?php echo $n; ?></td>
        <td><?php
				if ($claim_array['claim_status'] == "R") {
					echo "ฝ่ายถูก";
				} else if ($claim_array['claim_status'] == "W") {
					echo "ฝ่ายผิด";
				} else if ($claim_array['claim_status'] == "C") {
					echo "รอผลคดี";
				} else if ($claim_array['claim_status'] == "N") {
					echo "ประมาทร่วม";
				} else {
				}
				?></td>
        <td><?php echo $claim_array['claim_no']; ?></td>
        <td><?php echo $claim_array['claim_location']; ?></td>
        <td><?php if (!empty($claim_array['estimate']) || $claim_array['estimate'] != 0) {
					echo $sum = number_format($claim_array['estimate'], 2, '.', ',');
				} else {
					echo $sum = number_format($claim_array['claim_amount'], 2, '.', ',');
				}
				if ($claim_array['claim_status'] == "W") {
					$sum_total += str_replace(',', '', $sum);
					$num_w++;
				} ?></td>
    </tr>
    <?php }
	if ($n <= 0) { ?>
    <tr>
        <td colspan='5' align='center'>
            <font color='red' size='4'>ไม่มีประวัติการเคลม!</font>
        </td>
    </tr>
    <?php } ?>
</table>
<script>
var row_story = 0;

function add_claim() {
    var html_story = "";

    html_story += "<tr id='claim_row" + row_story + "'>";
    html_story +=
        "<td align='center'><a type='button' class='btn btn-mini btn-danger' style='background-color: #2283c5 !important; border: none; padding: 5px 5px; width: 100px;' onclick='del_claim(\"" +
        row_story + "\");'><i class='icon-remove-circle' style='font-size: 20px;'></i>ลบข้อมูล</a></td>";
    html_story += "<td>";
    html_story += "<select name='claim_status[]' id='claim_status" + row_story +
        "' class='span12 txt-st' onchange='cal_claim();'>";
    html_story += "<option value=''>กรุณาเลือก</option>";
    html_story += "<option value='R'>ฝ่ายถูก</option>";
    html_story += "<option value='W'>ฝ่ายผิด</option>";
    html_story += "<option value='C'>รอผลคดี</option>";
    html_story += "<option value='N'>ประมาทร่วม</option>";
    html_story += "</td>";
    html_story += "<td><input type='text'  name='claim_no[]' class='span12 txt' id='claim_no" + row_story +
        "' value=''></td>";
    html_story += "<td><input type='text' name='claim_location[]' class='span12 txt' id='claim_location" + row_story +
        "' value=''></td>";
    html_story += "<td><input type='text' name='estimate[]' class='span12 txt' id='estimate" + row_story +
        "' onkeyup='cal_claim();' value='0.00'></td>";
    html_story += "</tr>";
    $("#claim_table").append(html_story);
    $('#estimate' + row_story).iMask({
        type: 'number'
    });
    row_story++;
}

function del_claim(row) {
    $("#claim_row" + row).remove();
    cal_claim();
}

function cal_claim() {
    var sum = 0;
    var sum_claim = parseFloat(<?= $sum_total; ?>);
    var sum_w = <?= $num_w; ?>;
    for (var n = 0; n < document.getElementsByName("estimate[]").length; n++) {
        if (document.getElementsByName("claim_status[]")[n].value == 'W') {
            sum = document.getElementsByName("estimate[]")[n].value.replace(/,/g, "");
            sum_claim += parseFloat(sum);
            sum_w++;
        }
    }
    $("#txt_policy").val(sum_w);
    $('#txt_claim').val(addCommas(sum_claim.toFixed(2)));
    var newClaim = parseFloat($('#txt_claim').val().replace(/,/g, ""));
    var newchkpre = parseFloat($('#txt_claimpre').val().replace(/,/g, ""));
    var newLoss = (newClaim * 100) / newchkpre;
    if (newchkpre > 0) {
        $('#txt_loss').val(newLoss.toFixed(2));
    }
}
//cal_claim();
</script>