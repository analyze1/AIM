<?php
include "../inc/connectdbs.pdo.php";

$useredcmp = 'N';

function doComparison($a, $operator, $b)
{
	switch ($operator) {
		case '<':
			return ($a <  $b);
			break;
		case '<=':
			return ($a <= $b);
			break;
		case '=':
			return ($a == $b);
			break; // SQL way
		case '==':
			return ($a == $b);
			break;
		case '!=':
			return ($a != $b);
			break;
		case '>=':
			return ($a >= $b);
			break;
		case '>':
			return ($a >  $b);
			break;
	}
}

?>
<style>
.q-table {
    border-style: solid;
    border-width: 1px;
    border-color: #cccccc;
}

.q-tr {
    border-style: solid;
    border-width: 1px;
    border-color: #cccccc;
    background-color: #fff;
}

.q-tr:hover {
    background-color: #cccccc;

}



.q-td {

    font-size: 14px;
    border-style: solid;
    border-width: 1px;
    border-color: #cccccc;
}

.q-image {
    height: 35px;
}

.dataTables_empty {
    color: red !important;
    font-size: larger !important;
    font-weight: 700 !important;
}
table.dataTable { 
    border-collapse: collapse !important;
}
</style>
<?php
$claimall = $_POST['claimall'];
$regis_date = $_POST['regis_date'];
$mo_car = $_POST['mo_car'];
$end_date = $_POST['end_date'];
$Cost_NEW = $_POST['cost_new'];
$insured_type = $_POST['insured_type'];
$carid = $_POST['carid'];
$useLoss = $moneytotalprereqpay = floatval(preg_replace("/[^-0-9\.]/", "", $_POST['txt_loss']));;  // %claim
$claim_po = $_POST['txt_policy'];  //จำนวนเคลม
$tprovince = $_POST['car_regis_pro'];  //จำนวนเคลม
$dateN = date("Y-m-d");  //วันที่ปัจจุบัน
$nowYear = date('Y'); //ปีปัจจุบัน
$yearOld = number_format($nowYear - $regis_date) + 1;
$checkDate = explode('-',$end_date);

//กรณีขายล่วงหน้า รถปี 1
if($checkDate[0] == '2022' && $checkDate[1] == '01'){
	$regis_date = $regis_date+1;
}

?>

<div id="myTabContent" class="tab-content" style="border:none !important;padding:10px !important">
    <div class="tab-pane fade active in" id="full-width">
        <div class="content-wrap">
            <div class="car_listings">
                <?php
				$costInsureType1 = '';
				if ($insured_type == 1) {
					$costInsureType1 .= " AND ((cost <= " . $Cost_NEW . "  AND cost_end >=" . $Cost_NEW . ") ) ";
				}
				$sqlCost = "SELECT
										cp.name,
										cm.comp_sort,
										cm.namegroup,
										cm.ins_type,
										cm.cmocar,
										cm.cmocar_sz,
										c.* 
									FROM
										tb_cost c
										INNER JOIN tb_cost_mocar cm ON ( c.mocargroup = cm.namegroup )
										INNER JOIN tb_comp cp ON ( c.comp = cp.sort ) 
									WHERE
										c.comp = 'VIB_S'
										AND car_old <= {$regis_date} AND car_old_end >= {$regis_date}										
										AND cm.cmocar IN ( '{$mo_car}', 'ALL' ) 
										AND ( c.create_date <= '{$dateN}' AND c.date_expired >= '{$dateN}' ) 
										$costInsureType1
										AND c.car_id = '{$carid}' 
										AND c.used_four IN ( 'N', 'Y' ) 
										AND c.mocargroup != '' 
										AND c.insured_type = '{$insured_type}' 
									GROUP BY
										c.prod_name,
										pre,
										cm.cmocar_sz 
									ORDER BY
										`repair` ASC,
										c.`comp` DESC";
				$resSql = PDO_CONNECTION::fourinsure_insured()->query($sqlCost)->fetchAll(2);
				// if($_SESSION["lguser"] == 'admin'){
				// 	var_dump($sqlCost);
				// }
				$runc = 1;
				$firstrepair = 0;
				?>

                <table class="dataTable" name="viewdata" id="dataTable_package" width="100%" border="1"
                    style='background-color:#ffffff;'>
                    <thead>
                        <tr>
                            <th class="span4">บริษัทประกันภัย</th>
                            <th class="span1">ประเภท</th>
                            <th class="span1">ซ่อม</th>
                            <th class="span2">กลุ่มผลิตภัณฑ์</th>
                            <th class="span2">เบี้ย</th>
                            <th class="span2">เสนอราคา</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if ($claimall < 1 && $insured_type == 1 && $useredcmp == 'Y') {
							$costdataOld = $_POST['costdataOld'];
							$expData = explode('|', $costdataOld);
							$ins_cost = $Cost_NEW - 30000;
							$ins_cost_end  = $Cost_NEW + 30000;
							$ins_cost_range = 10000;
							$comp_sort = 'VIB_S';
							$ins_comp = 'บมจ. วิริยะประกันภัย ';
							$ins_type = '1';
							$trepair = 1;

							$ins_pre = $expData[0];
							$ins_net = $expData[3];

							$ins_prod_name = 'Campaing เบี้ยป้ายแดง';
							if ($carid == '110') {
								$ins_prod_remark = '';
								$ins_protect_type = 'VIB1101005';
								$inscost_id = '99999';
							} else if ($carid == '320') {
								$ins_prod_remark = '';
								$ins_protect_type = 'VIB3201006';
								$inscost_id = '99999';
							}

							if ($trepair == '1') {
								$tservice =  '<span style="color: blue;">ซ่อมห้าง</span>';
							} else if ($trepair == '2') {
								$tservice =  '<span style="color: red;">ซ่อมอู่</span>';
							}

							$ins_focusOld = $comp_sort . '|' . $ins_type . '|' . $Cost_NEW . '|' . $ins_cost . '|' . $ins_cost_end . '|' . $ins_cost_range . '|' . $trepair . '|' . $ins_pre . '|' . $ins_net . '|' . $ins_prod_name . '|' . $ins_prod_remark . '|' . $ins_comp . '|' . $ins_protect_type . '|' . $inscost_id;
						?>

                        <tr>
                            <td>
                                <span><img src="images/logo_insured/<?php echo $comp_sort; ?>.png"
                                        style="height:35px;"></span>
                                <span style="font-size:14px;padding-left:5px;"><?php echo $ins_comp; ?></span>
                            </td>
                            <td style="text-align: center;"><?php echo $ins_type; ?></td>
                            <td style="text-align: center;"><?php echo $tservice; ?></td>
                            <td style="text-align: center; white-space: nowrap;"><p style='display:inline-block;' <?php echo $ins_prod_remark!=""?"data-tooltip='".$ins_prod_remark."'":""; ?>><?php echo $ins_prod_remark!=""?"<i class='fa fa-search' style='display:inline-block; font-size: 19px; color: green;  font-style: ; font-weight: 600;'></i>":"";?> <?php echo $ins_prod_name;?></p></td>
                            <td><span>เบี้ย </span>: <?php echo number_format($ins_net, 2); ?> บาท</td>
                            <td class="td-center " style="border: none !important;">
                                <input type="hidden" name="datause0" id="datause0" value="<?php echo $ins_focusOld; ?>">
                                <div onclick="funcQuatation('0');" class="btn-omaewa cursor-pointer">เสนอราคา</div>
                            </td>
                        </tr>
                        <?php } ?>


                        <?php
						function mitsuCompanyName($name){
                           if(!empty($name))
						   {
							$res = explode('[',$name);
							return $res[0];
						   }
						   else
						   {
							 return  $name;
						   }
							
						}
					
						foreach ($resSql as $arrRes) {
							$comp_sort = $arrRes['comp_sort'];
							$ins_comp = mitsuCompanyName($arrRes['name']);
							$ins_type = $arrRes['ins_type'];
							$ins_cost = $arrRes['cost'];
							$ins_cost_end = $arrRes['cost_end'];
							$ins_cost_range = $arrRes['cost_range'];
							$ins_pre = $arrRes['pre'];
							$ins_net = $arrRes['net'];
							$ins_prod_name = $arrRes['prod_name'];
							$ins_prod_remark = $arrRes['prod_remark'];
							$trepair = $arrRes['repair'];
							$ins_protect_type = $arrRes['protect_type'];
							$inscost_id = $arrRes['id'];

							if ($trepair == '1') {
								$tservice =  '<span style="color: blue;">ซ่อมห้าง</span>';
							} else if ($trepair == '2') {
								$tservice =  '<span style="color: red;">ซ่อมอู่</span>';
								$firstrepair = $firstrepair + 1;
							}


							$ins_focus = $comp_sort . '|' . $ins_type . '|' . $Cost_NEW . '|' . $ins_cost . '|' . $ins_cost_end . '|' . $ins_cost_range . '|' . $trepair . '|' . $ins_pre . '|' . $ins_net . '|' . $ins_prod_name . '|' . $ins_prod_remark . '|' . $ins_comp . '|' . $ins_protect_type . '|' . $inscost_id;

							$prod_condition = $arrRes['prod_condition'];
							$excond = '';

							$chkL = 0;
							$chkLALL = 0;
							$chkA = 0;
							$chkA1 = 0;
							$chkALLA = 0;
							$chkALLN = 0;
							$chkALLF = 0;

							$chkC = 0;
							$TmpC = 0;
							$TmpR = 0;
							$chkR = 0;


							if (empty($prod_condition)) {
								$excond = explode('|', $prod_condition);
								for ($ic = 0; $ic < count($excond); $ic++) {
									$firstcheck = 	substr($excond[$ic], 0, 1);
									// เช็คจำนวน PO เคลมก่อน
									if ($firstcheck == 'C') {  //นับแค่เคลม ผิด 
										// $chkC+=1;
										$TmpC += 1; // มีเงื่อนไข C ให้เช็ค
										$chkdataC = explode(",", $excond[$ic]);
										if (doComparison($claim_po, $chkdataC[1], $chkdataC[2])) {
											$chkC += 1;
										}
									}
									if ($firstcheck == 'R') {
										$TmpR += 1; // มีเงื่อนไข R เช็คมีเคลมทั้งถูกและผิด
										$chkdataR = explode(",", $excond[$ic]);
										if (doComparison($claimall, $chkdataR[1], $chkdataR[2])) {
											$chkR += 1;
										}
									}
									if ($firstcheck == 'L') {
										$chkLALL += 1;
										$chkdataL = explode(",", $excond[$ic]);
										if (doComparison($useLoss, $chkdataL[1], $chkdataL[2])) {
											$chkL += 1;
										}
									}
									if ($firstcheck == 'A') {
										$chkALLA += 1;
										$chkdataA = explode(",", $excond[$ic]);
										if (doComparison($tprovince, $chkdataA[1], $chkdataA[2])) {
											if ($chkdataA[1] == '!=') {
												$chkA1 += 1;
												$chkA = 1;
											} else {
												$chkA1 = 5;
												$chkA += 1;
											}
										}
									}
									if ($firstcheck == 'N') {
										$chkALLN += 1;
									}
									if ($firstcheck == 'F') {
										$chkALLF += 1;
									}
								}
							}


							$CvalData = '';
							$CvalSet = '';
							if ($chkLALL != 0 and $chkLALL == $chkL and $TmpC == $chkC and $TmpR == $chkR) {

								if ($chkC > 0 || $chkR > 0) { //
									$CvalData .= "C/R condition :USE";
								} else {
									$CvalData .=  "Lตรงเงื่อนไข ";
								}

						?>

                        <tr>
                            <td>
                                <span><img src="images/logo_insured/<?php echo $comp_sort; ?>.png"
                                        style="height:35px;"></span>
                                <span style="font-size:12px;padding-left:5px;"><?php echo $ins_comp; ?></span>
                            </td>
                            <td style="text-align: center;"><?php echo $ins_type; ?></td>
                            <td style="text-align: center;"><?php echo $tservice; ?></td>
                            <td style="text-align: center; white-space: nowrap;"><p style='display:inline-block;' <?php echo $ins_prod_remark!=""?"data-tooltip='".$ins_prod_remark."'":""; ?>><?php echo $ins_prod_remark!=""?"<i class='fa fa-search' style='display:inline-block; font-size: 19px; color: green;  font-style: ; font-weight: 600;'></i>":"";?> <?php echo $ins_prod_name;?></p></td>
                            <td><span>เบี้ย </span>: <?php echo number_format($ins_net, 2); ?> บาท</td>
                            <td class="td-center"style="border: none !important;">
                                <input type="hidden" name="datause<?php echo $runc; ?>" id="datause<?php echo $runc; ?>"
                                    value="<?php echo $ins_focus; ?>">
                                <div onclick="funcQuatation('<?php echo $runc; ?>');" class="btn-omaewa cursor-pointer">
                                    เสนอราคา</div>

                            </td>
                        </tr>

                        <?php
							} else if ($chkALLA > 0  && $chkA > 0 && $chkA1 > 4) {
							?>
                        <tr>
                            <td>
                                <span><img src="images/logo_insured/<?php echo $comp_sort; ?>.png"
                                        style="height:35px;"></span>
                                <span style="font-size:12px;padding-left:5px;"><?php echo $ins_comp; ?></span>
                            </td>
                            <td style="text-align: center;"><?php echo $ins_type; ?></td>
                            <td style="text-align: center;"><?php echo $tservice; ?></td>
                            <td style="text-align: center; white-space: nowrap;"><p style='display:inline-block;' <?php echo $ins_prod_remark!=""?"data-tooltip='".$ins_prod_remark."'":""; ?>><?php echo $ins_prod_remark!=""?"<i class='fa fa-search' style='display:inline-block; font-size: 19px; color: green;  font-style: ; font-weight: 600;'></i>":"";?> <?php echo $ins_prod_name;?></p></td>
                            <td><span>เบี้ย </span>: <?php echo number_format($ins_net, 2); ?> บาท</td>
                            <td class="td-center" style="border: none !important;">
                                <input type="hidden" name="datause<?php echo $runc; ?>" id="datause<?php echo $runc; ?>"
                                    value="<?php echo $ins_focus; ?>">
                                <div onclick="funcQuatation('<?php echo $runc; ?>');" class="btn-omaewa cursor-pointer">
                                    เสนอราคา</div>
                            </td>
                        </tr>
                        <?php
							} else if ($chkALLN > 0) {
							?>

                        <tr>
                            <td><span><img src="images/logo_insured/<?php echo $comp_sort; ?>.png"
                                        style="height:35px;"></span>
                                <span style="font-size:12px;padding-left:5px;"><?php echo $ins_comp; ?></span>
                            </td>
                            <td style="text-align: center;"><?php echo $ins_type; ?></td>
                            <td style="text-align: center;"><?php echo $tservice; ?></td>
                            <td style="text-align: center; white-space: nowrap;"><p style='display:inline-block;' <?php echo $ins_prod_remark!=""?"data-tooltip='".$ins_prod_remark."'":""; ?>><?php echo $ins_prod_remark!=""?"<i class='fa fa-search' style='display:inline-block; font-size: 19px; color: green;  font-style: ; font-weight: 600;'></i>":"";?> <?php echo $ins_prod_name;?></p></td>
                            <td><span>เบี้ย </span>: <?php echo number_format($ins_net, 2); ?> บาท</td>
                            <td class="td-center" style="border: none !important;">
                                <input type="hidden" name="datause<?php echo $runc; ?>" id="datause<?php echo $runc; ?>"
                                    value="<?php echo $ins_focus; ?>">
                                <div onclick="funcQuatation('<?php echo $runc; ?>');" class="btn-omaewa cursor-pointer">
                                    เสนอราคา</div>

                            </td>
                        </tr>

                        <?php
							} else {  // ไม่มีเงื่อนไขพิเศษ 
							?>
                        <tr>
                            <td><span><img src="images/logo_insured/<?php echo $comp_sort; ?>.png"
                                        style="height:35px;"></span>
                                <span style="font-size:12px;padding-left:5px;"><?php echo $ins_comp; ?></span>
                            </td>
                            <td style="text-align: center;"><?php echo $ins_type; ?></td>
                            <td style="text-align: center;"><?php echo $tservice; ?></td>
                            <td style="text-align: center; white-space: nowrap;"><p style='display:inline-block;' <?php echo $ins_prod_remark!=""?"data-tooltip='".$ins_prod_remark."'":""; ?>><?php echo $ins_prod_remark!=""?"<i class='fa fa-search' style='display:inline-block; font-size: 19px; color: green;  font-style: ; font-weight: 600;'></i>":"";?> <?php echo $ins_prod_name;?></p></td>
                            <td><span>เบี้ย </span>: <?php echo number_format($ins_net, 2); ?> บาท</td>
                            <td class="td-center" style="border: none !important;">
                                <input type="hidden" name="datause<?php echo $runc; ?>" id="datause<?php echo $runc; ?>"
                                    value="<?php echo $ins_focus; ?>">
                                <div onclick="funcQuatation('<?php echo $runc; ?>');" class="btn-omaewa cursor-pointer">
                                    เสนอราคา</div>

                            </td>
                        </tr>


                        <?php }
							$runc++;
						} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>


<script>
async function loadRenewDataTablePackage() {
    $('#dataTable_package').DataTable({
        "language": {
            "emptyTable": "ไม่มีข้อมูล Package !"
        },
        "pageLength": 50
    });
}
loadRenewDataTablePackage();
</script>