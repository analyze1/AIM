<link type="text/css" rel="stylesheet" href="assets/css/modal.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
    crossorigin="anonymous" />
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@200&family=Prompt:ital,wght@0,100;1,100&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="css/renew-page.css" type="text/css">
<script type="text/javascript" src="js/jquery.imask.js"></script>
<script src="js/jquery.maskedinput-1.2.2.js"></script>
<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<style type="text/css">
.bg-close {
    z-index: 999999;
    -webkit-border-radius: 5px 5px 0px 0px;
    border: 0px solid #000000;
    background-color: #000;
    color: #fff !important;
    padding: 10px 50px;
    position: absolute;
    right: 0%;
    top: 3%;
    cursor: pointer;
    z-index: 999999;
}

.bg-close-renew {
    border-radius: 50px;
    border: 0px solid #000000;
    background-color: #000;
    color: #fff !important;
    padding: 5px;
    width: 21px;
    font-size: 1.5rem;
    cursor: pointer;
    text-align: center;

    margin-right: 5px;
}

.font-search {
    font-family: prompt !important;
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

.custom-download-input:hover::before {
    border-color: black;
}

.custom-download-input:active {
    outline: 0;
}

.btn-upload {
    height: 30px;
    background: #62a8d1;
    border: 0;
    border-radius: 5px;
}

.upload {
    background: #0b8;
    width: 214px;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    height: 30px;
    outline: none;
    border-color: #0b8;
}

.btn-down-load {
    background: #666;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    height: 30px;
    outline: none;
    border-color: #666;
}

.mr-5 {
    margin-right: 5px;
}

.loader {
    color: #000;
    font-size: 20px;
    margin: 100px auto;
    width: 1em;
    height: 1em;
    border-radius: 50%;
    position: relative;
    text-indent: -9999em;
    -webkit-animation: load4 1.3s infinite linear;
    animation: load4 1.3s infinite linear;
    -webkit-transform: translateZ(0);
    -ms-transform: translateZ(0);
    transform: translateZ(0);
}


@-webkit-keyframes load4 {

    0%,
    100% {
        box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0;
    }

    12.5% {
        box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
    }

    25% {
        box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
    }

    37.5% {
        box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em;
    }

    50% {
        box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em;
    }

    62.5% {
        box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em;
    }

    75% {
        box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0;
    }

    87.5% {
        box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em;
    }
}

@keyframes load4 {

    0%,
    100% {
        box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0;
    }

    12.5% {
        box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
    }

    25% {
        box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
    }

    37.5% {
        box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em;
    }

    50% {
        box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em;
    }

    62.5% {
        box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em;
    }

    75% {
        box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0;
    }

    87.5% {
        box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em;
    }
}

.upload-f {

    background: #7388b7 !important;
    width: auto !important;
    border-radius: 5px !important;
    cursor: pointer !important;
    height: 38px !important;

}

.toppic-upload {
    display: flex;
    justify-content: center;
    margin-left: 6.5rem;
}
</style>

<div class="container-fluid outer">
    <div class="row-fluid">
        <!-- .inner -->
        <div class="span12 inner">
            <!--Begin Datatables-->
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <header>
                            <div class="widget-header widget-header-flat"
                                style="text-align:left;border:solid thin #5098c9;">&nbsp;&nbsp; <h4><i
                                        class="icon-search"></i> ข้อมูลต่ออายุ ( Mitsubishi )</h4>
                                <div style="float:right; z-index:999;" id="closepop" class="bg-close">X</div>
                            </div>
                        </header>
                        <div id="collapse4" class="body" style="background-color:#f5f5f5;padding:10px;">
                            <form name="ajaxform" id="ajaxform" method="POST" onsubmit='return search_car();'>
                                <div class="control-group" style="display: flex;">
                                    <select name="otp" class="mr-5">
                                        <option value="iddata">เลขที่รับแจ้ง</option>
                                        <option value="policy">เลขที่กรมธรรม์</option>
                                        <option value="namesearch">ชื่อผู้เอาประกัน</option>
                                        <option value="prb">พ.ร.บ</option>
                                        <option value="carbody">เลขตัวถัง</option>
                                        <option value="n_motor">เลขตัวเครื่อง</option>
                                        <option value="phone">เบอร์โทรศัพท์</option>
                                        <option value="regis">ทะเบียน</option>

                                    </select>
                                    <input type="text" name="txtsearch" id="txtsearch" class="mr-5 " value=""
                                        placeholder="คำค้นหา" required />

                                    <div class="mr-5">
                                        <button class="btn btn-primary btn-small mr-5 font-search"
                                            style="border-radius: 5px;" id="search_post">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        <input type="hidden" name="txtcomdata" value="<?php echo $_GET["cdata"] ?>" />
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-success btn-small"
                                            style="border-radius:5px;" id="chkDMS" onclick="selectUploadFlies('DMS')">
                                            <i class="fas fa-file-excel"></i> อัพโหลดไฟล์
                                            จากระบบ DMS</button>

                                        <button type="button" class="btn btn-success btn-small"
                                            style="border-radius:5px;" id="chkOther"
                                            onclick="selectUploadFlies('other')">
                                            <i class="fas fa-file-excel"></i> อัพโหลดไฟล์
                                            จากที่อื่น (ลูกค้าสัมพันธ์)</button>
                                    </div>
                                </div>

                                <div style="display:flex">
                                    <div style="width:450px">

                                    </div>
                                    <div class="control-group toppic-upload">
                                        <div id='uploadDMS' style='display:none'>
                                            <div class="mr-5">
                                                <input type="file" id="fileup" name="fileup"
                                                    accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                                    style="display:none;">
                                                <button type="button" class="btn btn-success btn-small"
                                                    style="border-radius:5px;" onclick="handleUpload('DMS')">
                                                    <i class="fas fa-file-excel"></i> เลือกไฟล์เพื่อ อัพโหลด
                                                    Excel DMS</button>
                                            </div>

                                            <div class=" mr-5">
                                                <a href="example-excel/demo.xlsx" class="btn btn-danger btn-small"
                                                    style="border-radius:5px;">
                                                    <i class="fas fa-download"></i>
                                                    ดาวน์โหลดเอกสารตัวอย่าง DMS
                                                    <!-- <input type="file" id="fileup" name="fileup" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="custom-file-input"> -->
                                                </a>
                                            </div>
                                            <div class=" mr-5">
                                                <a target='_blank' href="example-excel/howToExportCustomer.pdf"
                                                    class="btn btn-warning btn-small" style="border-radius:5px;">
                                                    <i class="fas fa-download"></i>
                                                    ขั้นตอนการดึงข้อมูล DMS
                                                    <!-- <input type="file" id="fileup" name="fileup" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="custom-file-input"> -->
                                                </a>
                                            </div>
                                        </div>

                                        <div id='uploadLine' style='display:none'>
                                            <div class="mr-5">
                                                <input type="file" id="fileupOther" name="fileupOther"
                                                    accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                                    style="display:none;">
                                                <button type="button" class="btn btn-success btn-small"
                                                    style="border-radius:5px;" onclick="handleUpload('other')">
                                                    <i class="fas fa-file-excel"></i> เลือกไฟล์เพื่อ อัพโหลด
                                                    Excel ลูกค้าสัมพันธ์</button>
                                            </div>

                                            <div class=" mr-5">
                                                <a onclick="demoDocOther()" class="btn btn-danger btn-small"
                                                    style="border-radius:5px;">
                                                    <i class="fas fa-download"></i>
                                                    ดาวน์โหลดเอกสารตัวอย่าง
                                                    <!-- <input type="file" id="fileup" name="fileup" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="custom-file-input"> -->
                                                </a>
                                            </div>
                                            <div class=" mr-5">
                                                <a onclick="demoOther()"
                                                    class="btn btn-warning btn-small" style="border-radius:5px;">
                                                    <i class="fas fa-download"></i>
                                                    ขั้นตอนการดึงข้อมูล
                                                    <!-- <input type="file" id="fileup" name="fileup" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="custom-file-input"> -->
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="loader" id="loader" style="display: none;"></div>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <a href="#" class="close" data-dismiss="alert" style='margin: auto 10px;'
                                    aria-label="close">&times;</a>
                                <p>*** คำเตือนในการอัพโหลดไฟล์ ***</p>
                                <div style="padding-left: 50px;">
                                    <p>- ชื่อรุ่นรถยนต์ กรุณาพิมพ์เป็นอักษรพิมพ์ใหญ่</p>
                                    <p>- วันหมดอายุวันคุ้มครอง กรุณาใช้ฟอร์แมต วัน/เดือน/ปี เช่น 12/06/2021
                                        (ปีคริสต์ศักราช)</p>
                                    <p>- ชื่อลูกค้า ไม่ต้องใส่คำนำหน้า ระบบจะใส่คำว่า คุณ ให้อัตโนมัติ </p>
                                    <p>- ข้อมูลที่อยู่ ไม่ควรมีช่องว่าง และ ท่านสามารถดูข้อมูลตัวอย่างได้ <button
                                            class='btn btn-success btn-small' type='button'
                                            id='showAddress'>คลิก</button> </p>
                                    <p>- ไม่ควรอัพโหลดข้อมูลเกิน 200 รายการ </p>
                                    <p>- ระบบรองรับสกุลไฟล์ .xlsx (2007 ขึ้นไป)</p>

                                </div>
                            </div>
                            <div class="alert alert-info alert-dismissible" role="alert" id='checkAddress'
                                style='display:none;'>
                                <a href="#" class="close" data-dismiss="alert" style='margin: auto 10px;'
                                    aria-label="close">&times;</a>
                                <h3>ตัวอย่างที่อยู่</h3>
                                <select name="proviceID" id="proviceID"></select>
                                <select name="amphurID" id="amphurID"></select>
                                <select name="tumBonID" id="tumBonID"></select>
                                <!-- <select name="postOfficeID" id="postOfficeID"></select> -->
                                <input type="text" id="postOfficeID" name="postOfficeID" value="" readonly>
                                <dd>
                                    <p id="textAddressProvice"></p>
                                    <p id="textAddressAmphur"></p>
                                    <p id="textAddressTumbon"></p>
                                    <p id="textAddressPost"></p>
                                </dd>
                            </div>
                            <div style="display: none;">
                            </div>
                            <div id="content_search" style="display:none;"></div>
                        </div>
                        <div id="pload" style="margin-left: 46%; margin-top: 10px;">
                        </div>
                        <div id="content_pop"></div>
                        <!--End Datatables-->
                        <hr>
                        <!-- /.row-fluid -->
                    </div>
                    <!-- /.inner -->
                </div>
                <!-- /.row-fluid -->
            </div>
            <!-- /.outer -->
        </div>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;</button>
                <h4 class="modal-title">ใบคำขอประกันภัยรถยนต์</h4>
            </div>
            <div class="modal-body">
                Load Data...
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script type='text/javascript'>
function demoOther()
{
    alert('กำลังอยู่ระหว่างจัดทำคู่มือ ขออภัยในความไม่สะดวก');
}

function demoDocOther()
{
    alert('กำลังอยู่ระหว่างจัดทำไฟล์ตัวอย่าง ขออภัยในความไม่สะดวก');
}

$(document).on('click', 'a[data-toggle=modal]', function() {
    event.preventDefault();
    var $modal = $($(this).data('target'));
    $('.modal-body', $modal).empty();
    $modal.show();
    $('.modal-body', $modal).load($(this).attr('href'));

});

handleUpload = (e) => {
    console.log('handle upload', e)
    if (e == 'DMS') {
        document.getElementById('fileup').click();
    } else if (e == 'other') {
        document.getElementById('fileupOther').click();
    } else {
        return false;
    }

}

function selectUploadFlies(chk) {
    if (chk === 'DMS') {
        $('#chkDMS').removeClass('btn-success');
        $('#chkOther').removeClass('btn-success');
        $('#chkDMS').addClass('btn-success');
        document.getElementById('uploadDMS').style.display = 'flex';
        document.getElementById('uploadLine').style.display = 'none';
    } else {
        document.getElementById('uploadDMS').style.display = 'none';
        document.getElementById('uploadLine').style.display = 'flex';
        $('#chkDMS').removeClass('btn-success');
        $('#chkOther').removeClass('btn-success');
        $('#chkOther').addClass('btn-success');

    }
}

function search_car(lenght = '') {
    let divContent = document.getElementById('content_pop');
    divContent.innerHTML = '';

    $('#txtsearch').attr('readonly', false);
    $("#content_search").html("<img src='img4/loadingIcon.gif'/>");

    var postData = $("#ajaxform").serialize();
    const strLen = lenght && `&showList=${lenght}`;
    console.log('strLen', strLen);
    $.ajax({
        url: "pages/search_data_renew.php",
        type: "POST",
        data: postData + strLen,
        success: function(data, textStatus, jqXHR) {
            $("#content_search").html('<div class="prettyprint">' + data + '</div>');

        },
        error: function(jqXHR, textStatus, errorThrown) {
            $("#content_search").html('<div class="prettyprint">AJAX Request Failed<br/> textStatus=' +
                textStatus + ', errorThrown=' + errorThrown + '</div>');
        }
    });

    if (document.getElementById('content_search').style.display == 'none') {
        document.getElementById('content_search').style.display = 'block';
    }
    return false;
}

$('#closepop').css('display', 'none');

$('#closepop').click(function() {
    $('#collapse4').css('display', 'block');
    $('#content_pop').empty();
    $('#closepop').css('display', 'none');
});

const showAddressElement = document.getElementById('showAddress');
const fileupElement = document.querySelector('#fileup');
const fileupOtherElem = document.querySelector('#fileupOther');

showAddressElement.addEventListener('click', async (event) => {
    await $("#checkAddress").toggle();
    let req = {
        type: "POST",
        dataType: "json",
        url: "services/Address/Address.controller.php",
        data: {
            controller: 'getAllProvince'
        },
        success: function(res) {
            return res;
        },
        error: function(e) {
            return false;
        }
    };
    let res = await $.ajax(req);
    if (!res) {
        return false;
    }
    let divProvice = document.querySelector('#proviceID');
    res.forEach(element => {
        const option = document.createElement("option");
        option.text = element.Name;
        option.value = element.Id;
        divProvice.add(option);
    });
    document.getElementById("proviceID").selectedIndex = "1";
    await addTextAddress();
    await getAmPhur();
});

const proviceElements = document.querySelector('#proviceID');
proviceElements.addEventListener('change', async (event) => {
    await getAmPhur();
});

const amPhurElements = document.querySelector('#amphurID');
amPhurElements.addEventListener('change', async (event) => {
    await getTumBon();
});
const tumBonElements = document.querySelector('#tumBonID');
tumBonElements.addEventListener('change', async (event) => {
    await getPostOffice();
});

fileupElement.addEventListener('change', async (event) => {
    document.getElementById('content_search').innerHTML = '';
    document.getElementById('loader').style.display = 'flex';
    const multiFile = document.querySelector('#fileup').files;
    //สร้าง FormData object
    let formData = new FormData();
    formData.append(`fileExcel`, multiFile[0]);
    formData.append(`Controller`, 'importExcelFileRenew');
    let req = {
        type: "POST",
        enctype: 'multipart/form-data',
        dataType: "json",
        contenttype: false,
        url: "services/ImportExcelFileRenew/import-excel-file-renew.controller.php",
        data: formData,
        processData: false, //สำคัญมาก
        contentType: false,
        cache: false,
        success: function(res) {
            return res;
        },
        error: function(e) {
            return false;
        }
    };
    let res = await $.ajax(req);
    if (res.Status === 201) {
        let reqTable = {
            type: "POST",
            dataType: "html",
            url: "excel-upload-file/index.php",
            data: {
                pathFile: res.Data,
                Controller: 'FilesDMS'
            },
            success: function(res) {
                document.getElementById('loader').style.display = 'none';
                return res;
            },
            error: function(e) {
                console.log(e);
                document.getElementById('loader').style.display = 'none';
                return false;
            }
        }
        let resTable = await $.ajax(reqTable);
        let divContent = document.getElementById('content_pop');
        divContent.innerHTML = resTable;
    };
});

fileupOtherElem.addEventListener('change', async (event) => {
    document.getElementById('content_search').innerHTML = '';
    document.getElementById('loader').style.display = 'flex';
    const multiFile = document.querySelector('#fileupOther').files;
    //สร้าง FormData object
    let formData = new FormData();
    formData.append(`fileExcel`, multiFile[0]);
    formData.append(`Controller`, 'importExcelFileRenew');
    let req = {
        type: "POST",
        enctype: 'multipart/form-data',
        dataType: "json",
        contenttype: false,
        url: "services/ImportExcelFileRenew/import-excel-file-renew.controller.php",
        data: formData,
        processData: false, //สำคัญมาก
        contentType: false,
        cache: false,
        success: function(res) {
            return res;
        },
        error: function(e) {
            return false;
        }
    };
    let res = await $.ajax(req);
    if (res.Status === 201) {
        let reqTable = {
            type: "POST",
            dataType: "html",
            url: "excel-upload-file/index.php",
            data: {
                pathFile: res.Data,
                Controller: 'FilesOther'
            },
            success: function(res) {
                document.getElementById('loader').style.display = 'none';
                return res;
            },
            error: function(e) {
                console.log(e);
                document.getElementById('loader').style.display = 'none';
                return false;
            }
        }
        let resTable = await $.ajax(reqTable);
        let divContent = document.getElementById('content_pop');
        divContent.innerHTML = resTable;
    };
});

function open_inform_renew() {
    $("#title_informs").html("<font color='BLACK'>แจ้งงานต่ออายุ (สำหรับ เเจ้งงานเเบบเดี่ยว)</font>");
    $.post("ajax/ajax_infrom_mitsu_renew.php", {}, function(data) {
        $("#html_informrenew").html(data);
    });
}

async function getAmPhur() {
    let id = document.getElementById('proviceID').value;
    let req = {
        type: "POST",
        dataType: "json",
        url: "services/Address/Address.controller.php",
        data: {
            controller: 'getAmPhur',
            province: id
        },
        success: function(res) {
            return res;
        },
        error: function(e) {
            return false;
        }
    };
    let res = await $.ajax(req);
    if (!res) {
        return false;
    }
    let divAmphur = document.querySelector('#amphurID');
    divAmphur.innerHTML = '';
    res.forEach(element => {
        const option = document.createElement("option");
        option.text = element.Name;
        option.value = element.Id;
        divAmphur.add(option);
    });
    await addTextAddress();
    await getTumBon();
}

async function getTumBon() {
    let id = document.getElementById('amphurID').value;
    let req = {
        type: "POST",
        dataType: "json",
        url: "services/Address/Address.controller.php",
        data: {
            controller: 'getTumBon',
            amphur: id
        },
        success: function(res) {
            return res;
        },
        error: function(e) {
            return false;
        }
    };
    let res = await $.ajax(req);
    if (!res) {
        return false;
    }
    let divTumBon = document.querySelector('#tumBonID');
    divTumBon.innerHTML = '';
    res.forEach(element => {
        const option = document.createElement("option");
        option.text = element.Name;
        option.value = element.Id;
        divTumBon.add(option);
    });
    await addTextAddress();
    await getPostOffice();
}

async function getPostOffice() {
    let id = document.getElementById('tumBonID').value;
    let req = {
        type: "POST",
        dataType: "json",
        url: "services/Address/Address.controller.php",
        data: {
            controller: 'getPostOffice',
            tumbon: id
        },
        success: function(res) {
            return res;
        },
        error: function(e) {
            return false;
        }
    };
    let res = await $.ajax(req);
    if (!res) {
        return false;
    }
    console.log(res);
    let divAmphur = document.querySelector('#postOfficeID');
    divAmphur.value = res.Name;
    await addTextAddress();
}

async function addTextAddress() {
    let sel = document.getElementById("proviceID");
    let text = sel.options[sel.selectedIndex].text;
    document.getElementById("textAddressProvice").innerText = `จังหวัด : ${text}`;

    let selAmphur = document.getElementById("amphurID");
    let textAmphur = selAmphur.value && selAmphur.options[selAmphur.selectedIndex].text;
    if (textAmphur) {
        document.getElementById("textAddressAmphur").innerText = `อำเภอ : ${textAmphur}`;
    }

    let selTumbon = document.getElementById("tumBonID");
    let textTunBon = selTumbon.value && selTumbon.options[selTumbon.selectedIndex].text;
    if (textTunBon) {
        document.getElementById("textAddressTumbon").innerText = `ตำบล : ${textTunBon}`;
    }

    let selPost = document.getElementById("postOfficeID");
    let textPost = selPost.value || 0;
    if (textPost) {
        document.getElementById("textAddressPost").innerText = `รหัสไปรษณีย์ : ${textPost}`;
    }
}
</script>