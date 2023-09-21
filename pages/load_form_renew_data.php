<?php
include "check-ses.php";
include "../inc/connectdbs.pdo.php";
header('Content-Type: text/html; charset=utf-8');
$_user = $_GET['user'];

$tb_customer_sql = "SELECT emp_lastrenew,emp_titlerenew,emp_namerenew,emp_telrenew,
                emp_faxrenew,emp_emailrenew FROM tb_customer WHERE user = '$_user'";
$tb_customer_array = PDO_CONNECTION::fourinsure_mitsu()->query($tb_customer_sql)->fetch(2);

$sqlFindFiles = "SELECT PatchFile,DateUpload,DateApprove,Approve,TypeWork FROM upload_admin_telephone WHERE DealerCode = '$_user'"; //
$infoFilesObj = PDO_CONNECTION::fourinsure_mitsu()->query($sqlFindFiles)->fetchAll(2);
echo "<script> var _checkDealerCode = `{$_SESSION['strUser']}`</script>";

?>

<!-- <script src="js/js_Insurance.js" type="text/javascript"></script> -->
<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/cupertino/jquery-ui-1.9.2.custom.min.css" />
<link rel="stylesheet" type="text/css" href="assets/css/datepicker.css" />
<script type="text/javascript" src="data_table/js/jquery.dataTables.js"></script>
<link type="text/css" rel="stylesheet" type="text/css" href="data_table/css/jquery.dataTables.css">

<style>
    #uploadFile {
        border: 2px solid #000 !important;
        padding: 0.3rem !important;
        border-radius: 5px;
    }

    .custom-file-input {
        color: transparent;
        width: 180px !important;
        font-family: prompt !important;
    }

    .custom-file-input::-webkit-file-upload-button {
        visibility: hidden;
    }

    .custom-file-input::before {
        content: 'อัพโหลดไฟล์ Excel';
        color: #fff;
        display: inline-block;
        background: #0b8;
        border-radius: 5px;
        padding: 0px 8px;
        outline: none;
        white-space: nowrap;
        -webkit-user-select: none;
        cursor: pointer;
        font-weight: 700;
        font-size: 1.2rem;
        height: 20px;
    }

    .custom-file-input:hover::before {
        border-color: black;
    }

    .custom-file-input:active {
        outline: 0;
    }

    .custom-download-input {
        color: transparent;
        width: 180px !important;
        height: 30px;
        line-height: 30px;
        font-family: prompt !important;
    }

    .custom-download-input::-webkit-file-upload-button {
        visibility: hidden;
    }

    .custom-download-input::before {
        content: 'ดาวน์โหลดไฟล์ตัวอย่าง';
        color: #fff;
        display: inline-block;
        background: #666;
        border-radius: 5px;
        padding: 0px 8px;
        outline: none;
        white-space: nowrap;
        -webkit-user-select: none;
        cursor: pointer;
        font-weight: 700;
        font-size: 1.2rem;
        height: 20px;
    }

    .bookbank {
        text-align: center;
        color: red;
        font-weight: bolder;
    }
</style>

<div style="margin-left:auto;margin-right:auto;" class="row-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-header widget-header-flat">
                    <h4>เปลียนผู้ดูแลต่ออายุ <?php echo "(" . $user . ")"; ?></h4>
                </div>
                <div class='span6' style="background:#fff;margin: 0;padding: 1rem;">
                <div class='span12'><b>อัพโหลดเอกสารแต่งตั้งได้ที่นี่</b></div>
                    <div class='span12' style="margin: 0">(ท่านสามารถอัพโหลดไฟล์ได้อีกครั้งกรณีมีการเปลี่ยนแปลงผู้รับผิดชอบ โดยสามารถโหลดเอกสารจากแบบฟอร์มด้านล่าง)</div>
                    <div class="span12" style="margin: 0;">
                        <!-- <input type="file" name="uploadFile" id="uploadFile"
                            accept="application/pdf,application/vnd.ms-excel"> -->
                        <!-- <div class="mr-5"> -->
                        <input type="file" id="uploadFile" name="uploadFile" accept="application/pdf,application/vnd.ms-excel" style="display:none;">
                        <button type="button" class="btn btn-success btn-small" style="border-radius:5px;height: 43px;" onclick="handleUploadFile()">
                            <i class="icon-file"></i> เลือกไฟล์</button>
                        <!-- </div> -->
                        <!-- <a href="./print/print_admin_telnumber.php?id=<?php //echo $_user; ?>" target="_blank" type="button" class="btn btn-secondary" style="border-radius: 5px;padding: 0.1rem;">
                            <i class="icon-download"></i> แบบฟอร์ม
                        </a> -->

                        <a href="./print/print_admin_telnumber_update_2022.php?id=<?php echo $_user; ?>" target="_blank" type="button" class="btn btn-secondary" style="border-radius: 5px;padding: 0.1rem;">
                            <i class="icon-download"></i> แบบฟอร์ม
                        </a>
                    </div>
                    <div class="span12" style="margin: 0;">
                        <span id="showFileName" style="display: flex;padding: 12px 0;"></span>
                        <button type="button" class="btn btn-primary" style="border-radius: 5px;display:none;" id="BtnUploadFile" name="BtnUploadFile" onclick="saveDataDoc()">
                            <i class="icon-cloud-upload"></i> นำส่งข้อมูล
                        </button>
                    </div>
                </div>
                <div class='span6' style="margin: 0;padding: 1rem;">
                    <div class='span12 bookbank'>ระบบอัพโหลดเอกสารทางการเงิน (BookBank) กำลังพัฒนา</div>
                    <!-- <div class="span12" style="margin: 0;">
                            <input type="file" id="uploadFile" name="uploadFile" accept="application/pdf,application/vnd.ms-excel,image/png, image/jpeg" style="display:none;">
                            <button type="button" class="btn btn-success btn-small" style="border-radius:5px;height: 43px;" onclick="handleUploadFile()">
                                <i class="icon-file"></i> เลือกไฟล์</button>
                        
                            <a href="./print/print_admin_telnumber.php?id=<?php echo $_user; ?>" target="_blank" type="button" class="btn btn-secondary" style="border-radius: 5px;padding: 0.1rem;">
                                <i class="icon-download"></i> แบบฟอร์ม
                            </a>
                        </div>
                        <div class="span12" style="margin: 0;">
                            <span id="showFileName" style="display: flex;padding: 12px 0;"></span>
                            <button type="button" class="btn btn-primary" style="border-radius: 5px;display:none;" id="BtnUploadFile" name="BtnUploadFile" onclick="saveDataDoc()">
                                <i class="icon-cloud-upload"></i> นำส่งข้อมูล
                            </button>
                        </div> -->
                </div>
                <div class='span12' style="background:#fff;margin: 0;padding: 1rem;" id="showFileAccept">
                    <h5 style="color: red;text-align:center;">ไม่พบไฟล์</h5>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row-fluid">
        <div class="span12" style="">
            <div class="widget-box">
                <div class="widget-header widget-header-flat">
                    <h4>คำถามที่ผมบ่อย</h4>
                </div>
                <div class='span12' style="background:#fff;margin: 0;">
                    <div class="tab-pane fade active in">

                        <li style='width:50%; display:none;' align='center'><a data-toggle="tab" onclick="open_faq('ti_tab1');" id='ti_tab1' href="#">ปัญหา product knowledge ที่พบบ่อย</a></li>

                        <div id="myfaq">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var files = <?php echo json_encode($infoFilesObj); ?>;

    handleAcceptFile = () => {
        if (files.length > 0) {
            document.getElementById('showFileAccept').innerHTML = '';
        }
        for (const x of files) {
            console.log(x.Approve);
            const typeApprove = x.Approve;
            if (x.TypeWork == 'DocAdmin') {
                if (typeApprove == 'N') {
                    $('#showFileAccept').append(`
            <div class="alert alert-danger" role="alert">
            ไม่อนุมัติ วันที่ ${new Date(x.DateApprove).toLocaleString()} <a href="DocAdminTelephone/${x.PatchFile}" class="alert-link" target="_blank">ดูใบคำสั่งแต่งตั้งผู้รับผิดชอบต่ออายุ คลิ๊ก</a>
            </div>
        `);
                }

                if (typeApprove == 'Y') {
                    $('#showFileAccept').append(`
            <div class="alert alert-success" role="alert">
            อนุมัติแล้ว วันที่ ${new Date(x.DateApprove).toLocaleString()} <a href="DocAdminTelephone/${x.PatchFile}" class="alert-link" target="_blank">ดูใบคำสั่งแต่งตั้งผู้รับผิดชอบต่ออายุ คลิ๊ก</a>
            </div>
        `);
                }

                if (typeApprove == 'P') {
                    $('#showFileAccept').append(`
            <div class="alert alert-primary" role="alert">
            รอการอนุมัติ วันที่ ${new Date(x.DateUpload).toLocaleString()} <a href="DocAdminTelephone/${x.PatchFile}" class="alert-link" target="_blank">ดูใบคำสั่งแต่งตั้งผู้รับผิดชอบต่ออายุ คลิ๊ก</a>
            </div>
        `);
                }
            }
        }
    }
    handleAcceptFile();

    handleUploadFile = () => {
        document.getElementById('uploadFile').click();
    }

    $("#uploadFile").change(function() {
        let _fileName = $(this).val().replace(/\\/g, '/').replace(/.*\//, '');
        $('#showFileName').empty();
        $('#showFileName').append(`ไฟล์ที่เลือก:&nbsp;&nbsp;<h5 style="color:green;margin:0;"> ${_fileName}</h5>`);
        document.getElementById('BtnUploadFile').style.display = 'block';
    });

    const postImageApiAsync = async (_url, _data, type = "json") => {
        try {
            return await $.ajax({
                type: "POST",
                url: _url,
                data: _data,
                dataType: type,
                cache: false,
                contentType: false,
                processData: false,
                success: (res) => {
                    return res;
                },
                error: (err) => {
                    console.log(err);
                    return err;
                }
            });
        } catch (error) {
            console.log(error);
            return false;
        }
    }

    saveDataDoc = async () => {
        console.log('asyncSaveDataDoc');
        try {
            let oData = new FormData();
            oData.append("Controller", "save-doc-file");
            oData.append("dealerCode", _checkDealerCode);
            oData.append("document", $(`#uploadFile`)[0].files[0]);

            let res = await postImageApiAsync("services/FileUpload/file-upload-doc.controller.php", oData);
            if (res.Status == 201) {
                Swal.fire(
                    'สำเร็จ',
                    res.Data,
                    'success'
                ).then(() => {
                    // location.reload();
                })
            } else {
                Swal.fire(
                    'ผิดพลาด',
                    res.Data,
                    'error'
                ).then(() => {
                    location.reload();
                })
            }
        } catch (error) {
            console.log(error);
            Swal.fire(
                'ผิดพลาด!',
                error.responeseText,
                'error'
            )
        }
    }

    function open_faq(id) {

        $("#myfaq").load("ajax/ajax_faq_" + id + ".php");

    }

    function open_faq1() {
        document.getElementById('loadingIcon').style.display = 'flex';

        $("#ti_tab1").trigger("click");
        document.getElementById('loadingIcon').style.display = 'none';
    }
    open_faq1();
</script>