<?php
error_reporting(1);
session_start();
date_default_timezone_set("Asia/Bangkok");
set_time_limit(36000);

require '../vendor/autoload.php';
require '../inc/connectdbs.pdo.php';
require '../services/ImportExcelFileRenew/model/import-excel-file-renew.model.php';
require '../services/ImportExcelFileRenew/service/import-data.service.php';
require('../services/Resolve/services/resolve-end-date.service.php');


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$inputFileName = $_POST['pathFile']; //ชื่อไฟล์ Excel ที่ต้องการอ่านข้อมูล

$spreadsheet = IOFactory::load($inputFileName);
$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
// unset($sheetData[1], $sheetData[2]);
unset($sheetData[1]);


try {
    $service = new ImportData(
        PDO_CONNECTION::fourinsure_mitsu(),
        PDO_CONNECTION::fourinsure_insured(),
        $_SESSION['lguser'],
        $_SESSION['strUser']
    );
    if($_POST['Controller']=='FilesDMS')
    {
        $res = $service->readData($sheetData);
    }
    else
    {
        $res = $service->readOtherData($sheetData);
    }
} catch (Exception $th) {
    throw $th;
}

?>

<style>
.grid-container {
    display: grid;
    grid-template-columns: auto auto 30%;
    grid-gap: 5px;
    /* background-color: #2196F3; */
    padding: 10px;
}

.grid-container>div {
    /* background-color: rgba(255, 255, 255, 0.8); */
    text-align: center;
    padding: 8px 0;
    font-size: 16px;
}
.btn-12-em{
    width: 12em;
}
table tr td,th{
    text-align: center!important;
}
</style>

<div class='grid-container'>
    <div></div>    
    <div>
        <p class="btn btn-success" style="padding: 0;">บันทึกข้อมูลสำเร็จ <?php echo $res['totalSuccess']?> รายการ</p>
        <p class="btn btn-warning" style="padding: 0;">ไม่พบข้อมูลเบี้ยประกันภัย <?php echo $res['totalNotfoundCost']?> รายการ</p>
        <p class="btn btn-danger" style="padding: 0;">ไม่พบข้อมูลรถรุ่นนี้ <?php echo $res['totalNotfoundModelCar']?> รายการ</p>
        <p class="btn btn-secondary" style="padding: 0;">พบเลขตัวถังซ้ำ <?php echo $res['totalDuplicateChassis']?> รายการ</p>
    </div>
    <div></div>
    <div></div>
    <div><table id="TableImportDataRenew" class="table table-striped table-bordered dataTable no-footer">
            <tr>
                <th style="background: #365e93;color: #fff;">ลำดับ</th>
                <th style="background: #365e93;color: #fff;">เลขรับแจ้ง</th>
                <th style="background: #365e93;color: #fff;">เลขตัวถัง</th>
                <th style="background: #365e93;color: #fff;">สถานะ</th>
            </tr>
            <?php
                $i = 1;

                foreach ($res as $key => $val) {

                    if ($val['notfoundModelCar']) {
                        echo "<tr>";
                        echo "<td>$i</td>";
                        echo "<td>{$val['idData']}</td>";
                        echo "<td>$key</td>";
                        echo "<td><p class='btn btn-danger btn-12-em' style='padding: 0;'>ไม่พบข้อมูลรถรุ่นนี้</p></td>";
                        echo "</tr>";
                    }

                    if ($val['notfoundCost']) {
                        echo "<tr>";
                        echo "<td>$i</td>";
                        echo "<td>{$val['idData']}</td>";
                        echo "<td>$key</td>";                        
                        echo "<td><p class='btn btn-warning btn-12-em' style='padding: 0;'>ไม่พบข้อมูลเบี้ยประกันภัย</p></td>";
                        echo "</tr>";
                    }

                    if ($val['duplicateChassis']) {
                        echo "<tr>";
                        echo "<td>$i</td>";
                        echo "<td>{$val['idData']}</td>";
                        echo "<td>$key</td>";                        
                        echo "<td><p class='btn btn-secondary btn-12-em' style='padding: 0;'>พบเลขตัวถังซ้ำ</p></td>";
                        echo "</tr>";
                    }

                    if ($val['notfoundModelCar'] == false && $val['notfoundCost'] == false && $val['duplicateChassis'] == false && $key != 'totalNotfoundModelCar' && $key != 'totalNotfoundCost' && $key != 'totalSuccess' && $key != 'totalDuplicateChassis') {
                        echo "<tr>";
                        echo "<td>$i</td>";
                        echo "<td>{$val['idData']}</td>";
                        echo "<td>$key</td>";
                        echo "<td><p class='btn btn-success btn-12-em' style='padding: 0;'>บันทึกข้อมูลสำเร็จ</p></td>";
                        echo "</tr>";
                    }
                    $i++;
                }
                ?>
        </table></div>
    <div></div>
</div>