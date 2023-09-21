<?php
session_start();
include "../inc/connectdbs.pdo.php";
$_res = $_GET['formFour'];

if($_res == 'true') {
    $dealerCode = $_GET['dealercode'];
    $hidden = 'display: none;';
} else {
    $dealerCode = $_SESSION['strUser'];
    $hidden = '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mitsubishi</title>
    <!-- Resources -->
    <script src="js/amcharts/core.js"></script>
    <script src="js/amcharts/charts.js"></script>
    <script src="js/amcharts/animated.js"></script>
    <script src="js/amcharts/material.js"></script>
    <script src="js/amcharts/jquery-3.4.1.min.js"></script>
    <script src="js/amcharts/jquery-3.4.1.js"></script>

    <!--begin::Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@200&family=Prompt:wght@500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--end::Fonts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!-- begin::Global Config(global config for global JS sciprts) -->

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="sweetalert2.all.min.js"></script>

    <script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "light": "#ffffff",
                "dark": "#282a3c",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "red": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
    </script>

    <style>
    body {
        font-family: 'Kanit', sans-serif;
        font-weight: bold;
        font-size: 14px;
        background: #fff;
    }

    #chartCountCallPerEmp,
    #chartTelUserDetail {
        height: 312px;
    }

    #show_content {
        width: 100%;
        height: 469px;
    }

    #chartUserBlackList,
    #chartUserCantConnect,
    #chartUserWrongTel {
        height: 176px;
    }

    .text-red {
        color: #f44336 !important;
    }

    .text-green {
        color: #4caf50 !important;
    }

    .mini-card {
        background: url(../images/61769.png);
        height: 120px;
        background-size: cover;
    }

    h4,
    h5 {
        margin: 0;
    }

    .form-control {
        font-size: 1.2rem !important;
        font-weight: bolder !important;
    }

    .text-status {
        font-weight: bolder;
        font-size: 1.4rem;
    }

    .card-header {
        background: #233f85;
        color: #fff;
    }

    .sk-chase {
        width: 30px;
        height: 30px;
        position: relative;
        animation: sk-chase 2.5s infinite linear both;
    }

    .sk-chase-dot {
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        animation: sk-chase-dot 2.0s infinite ease-in-out both;
    }

    .sk-chase-dot:before {
        content: '';
        display: block;
        width: 25%;
        height: 25%;
        background-color: #000;
        border-radius: 100%;
        animation: sk-chase-dot-before 2.0s infinite ease-in-out both;
    }

    .sk-chase-dot:nth-child(1) {
        animation-delay: -1.1s;
    }

    .sk-chase-dot:nth-child(2) {
        animation-delay: -1.0s;
    }

    .sk-chase-dot:nth-child(3) {
        animation-delay: -0.9s;
    }

    .sk-chase-dot:nth-child(4) {
        animation-delay: -0.8s;
    }

    .sk-chase-dot:nth-child(5) {
        animation-delay: -0.7s;
    }

    .sk-chase-dot:nth-child(6) {
        animation-delay: -0.6s;
    }

    .sk-chase-dot:nth-child(1):before {
        animation-delay: -1.1s;
    }

    .sk-chase-dot:nth-child(2):before {
        animation-delay: -1.0s;
    }

    .sk-chase-dot:nth-child(3):before {
        animation-delay: -0.9s;
    }

    .sk-chase-dot:nth-child(4):before {
        animation-delay: -0.8s;
    }

    .sk-chase-dot:nth-child(5):before {
        animation-delay: -0.7s;
    }

    .sk-chase-dot:nth-child(6):before {
        animation-delay: -0.6s;
    }

    @keyframes sk-chase {
        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes sk-chase-dot {

        80%,
        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes sk-chase-dot-before {
        50% {
            transform: scale(0.4);
        }

        100%,
        0% {
            transform: scale(1.0);
        }
    }
    </style>
</head>

<body>
    <div class="card border-0">
        <div class="card-header">
            <h4 class="font-weight-bolder">แผนภูมิติดตามงาน (Mitsubishi)</h4>
        </div>
        <div class="card-body">
            <div class="row" style="margin: 0;">
                <div class="col-12">
                    <div class="row" style="margin: 0; display: flex !important;">
                        <?php if($dealerCode == 'admin'){ ?>
                        <div class="col-auto" style="margin-right: 5px;">
                            <label class="font-weight-bolder" for="login">ชื่อตัวแทน</label>
                            <select name="login" id='login' class="form-control">
                                <option value='ALL'>ALL</option>
                                <?php
                            $dealer_sql = "SELECT user,sub FROM tb_customer WHERE claim = 'DEALER' AND user LIKE '3%'";
                            $dealer_query =  PDO_CONNECTION::fourinsure_mitsu()->query($dealer_sql)->fetchAll(2);
                            foreach ($dealer_query as $dealer_array) { ?>
                                <option value='<?= $dealer_array['user']; ?>'>
                                    <?= "[" . $dealer_array['user'] . "] " . $dealer_array['sub']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php } else { ?>
                        <input style="display: none" type="text" name="login" id="login"
                            value="<?php echo $dealerCode ?>">
                        <?php } ?>
                        <div class="col-auto" style="margin-right: 5px;">
                            <label for="mounth_renew">เลือกเดือน</label>
                            <select name="mounth_renew" id="mounth_renew" class="form-control">
                                <!-- <option value="" selected disabled>เลือก</option> -->
                                <!-- <option value="Jan">มกราคม</option>
                            <option value="Feb">กุมภาพันธ์</option>
                            <option value="Mar">มีนาคม</option>
                            <option value="Apr">เมษายน</option>
                            <option value="May">พฤษภาคม</option>
                            <option value="Jun">มิถุนายน</option>
                            <option value="Jul">กรกฎาคม</option> -->
                                <option value="08">สิงหาคม</option>
                                <option value="09">กันยายน</option>
                                <option value="10">ตุลาคม</option>
                                <option value="11">พฤศจิกายน</option>
                                <option value="12">ธันวาคม</option>
                            </select>
                        </div>
                        <div class="col-auto" style="margin-right: 5px;">
                            <label for="year_renew">เลือกปีค้นหา</label>
                            <input type="text" id="year_renew" name="year_renew" class="form-control"
                                value="<?php echo date('Y'); ?>" readonly>
                        </div>
                        <div class="col-auto" style="margin-top: 2.3rem;">
                            <a type='button' class='btn btn-small btn-success' onclick='handelSearch();'>
                                <h5 class="font-weight-bolder">ค้นหา</h5>
                            </a>
                        </div>
                        <div class="col-auto" id="loading_graph" style="display: none;margin-top: 2rem;">
                            <div class="sk-chase">
                                <div class="sk-chase-dot"></div>
                                <div class="sk-chase-dot"></div>
                                <div class="sk-chase-dot"></div>
                                <div class="sk-chase-dot"></div>
                                <div class="sk-chase-dot"></div>
                                <div class="sk-chase-dot"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="row" style="margin: 0;margin-top: 2rem;">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header">
                                    <h4><i class="fas fa-chart-pie"></i> กราฟติดตามงาน</h4>
                                </div>
                                <div class="card-body">
                                    <div id="show_content"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <div class="row">
                        <div class="col-3">
                            <div class="card border-0 shadow-sm" style="margin-top: 2rem;">
                                <div class="card-header">
                                    <h4>SMS</h4>
                                </div>
                                <div class="card-body p-2 mini-card">
                                    <div class="row">
                                        <div class="col-12 text-left">
                                            <h5 class="font-weight-bolder" id="totalSMS"></h5>
                                        </div>
                                        <div class="col-12 text-center mt-3">
                                            <h5 class="text-status text-red" id="noSMS"></h5>
                                        </div>
                                        <div class="col-12 text-center mt-3">
                                            <h5 class="text-status text-green" id="sms"></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card border-0 shadow-sm" style="margin-top: 2rem;">
                                <div class="card-header">
                                    <h4>โทร</h4>
                                </div>
                                <div class="card-body p-2 mini-card">
                                    <div class="row">
                                        <div class="col-12 text-left">
                                            <h5 class="font-weight-bolder" id="callTotal"></h5>
                                        </div>
                                        <div class="col-12 text-center mt-3">
                                            <h4 class="text-status text-red" id="noCall"></h4>
                                        </div>
                                        <div class="col-12 text-center mt-3">
                                            <h4 class="text-status text-green" id="calls"></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card border-0 shadow-sm" style="margin-top: 2rem;">
                                <div class="card-header">
                                    <h4>การโทรทั้งหมด</h4>
                                </div>
                                <div class="card-body p-2 mini-card">
                                    <div class="d-flex w-100 h-100 align-items-center justify-content-center">
                                        <h2 class="font-weight-bolder" id="totalCall"></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card border-0 shadow-sm" style="margin-top: 2rem;">
                                <div class="card-header">
                                    <h4>ค่าเฉลี่ยการโทร</h4>
                                </div>
                                <div class="card-body p-2 mini-card">
                                    <div class="d-flex w-100 h-100 align-items-center justify-content-center">
                                        <h2 class="font-weight-bolder" id="average"></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card border-0 shadow-sm" style="margin-top: 2rem;">
                                <div class="card-header">
                                    <h4><i class="fas fa-chart-line"></i> กราฟจำนวนการโทร</h4>
                                </div>
                                <div class="card-body p-3" id="chartCountCallPerEmp"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12" style="<?php echo $hidden; ?>">
                    <div class="row">
                        <div class="col-4">
                            <div class="card border-0 shadow-sm" style="margin-top: 2rem;">
                                <div class="card-header">
                                    <h4><i class="fas fa-chart-pie"></i> ระงับการใช้</h4>
                                </div>
                                <div class="card-body p-3" id="chartUserBlackList"></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card border-0 shadow-sm" style="margin-top: 2rem;">
                                <div class="card-header">
                                    <h4><i class="fas fa-chart-pie"></i> ติดต่อไม่ได้</h4>
                                </div>
                                <div class="card-body p-3" id="chartUserCantConnect"></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card border-0 shadow-sm" style="margin-top: 2rem;">
                                <div class="card-header">
                                    <h4><i class="fas fa-chart-pie"></i> เบอร์ผิด</h4>
                                </div>
                                <div class="card-body p-3" id="chartUserWrongTel"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
    <script src="assets/js/scripts.bundle.js" type="text/javascript"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    async function postApiChartAsync(_url, _data) {
        return await $.ajax({
            type: "POST",
            url: _url,
            data: _data,
            dataType: "JSON",
            success: (response) => {
                return response;
            },
            error: (err) => {
                return err;
            }
        });
    }

    async function genDataRenews() {
        let _url = "../services/DashBoardRenew/dash-board-renew.controller.php";
        let _data = {
            Controller: 'genDataRenew',
            year: $("#year_renew").val(),
            monthRenew: $("#mounth_renew").val(),
            typeData: $("#type_data").val(),
            dealerCode: $("#login").val()
        };

        let res = await postApiChartAsync(_url, _data);

        if (res.Status == 200) {
            await showChartAllService(res.Data);

        } else {
            $('#show_content').empty();
            $('#show_content').html(`
                <div class="d-flex align-items-center justify-content-center h-100">
                    <h5 class="m-0 text-red">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>
                </div>
            `);
        }
    }

    async function genDataSMSAverage() {
        let _url = "../services/DashBoardRenew/dash-board-renew.controller.php";
        let _data = {
            Controller: 'genDataSMSAverage',
            year: $("#year_renew").val(),
            monthRenew: $("#mounth_renew").val(),
            dealerCode: $("#login").val()
        };

        let res = await postApiChartAsync(_url, _data);

        if (res.Status !== 200) {
            $('#totalSMS').empty();
            $('#totalSMS').html(
                `<h5 class="m-0 text-white">.</h5>`);

            $('#noSMS').empty();
            $('#noSMS').html(
                `<h5 class="m-0 text-red">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>`);

            $('#sms').empty();
            $('#sms').html(
                `<h5 class="m-0 text-red"></h5>`);
        } else {
            getSMS(res);
        }
    }

    async function getDataUserBlackList() {
        let _url = "../services/DashBoardRenew/dash-board-renew.controller.php";
        let _data = {
            Controller: 'getDataUserBlackList',
            year: $("#year_renew").val(),
            monthRenew: $("#mounth_renew").val(),
            dealerCode: $("#login").val()
        };

        let res = await postApiChartAsync(_url, _data);

        if (res.Status !== 200) {
            $('#chartUserBlackList').empty();
            $('#chartUserBlackList').html(`
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <h5 class="m-0 text-red">ไม่พบข้อมูลระงับการใช้ <i class="far fa-folder-open"></i></h5>
                    </div>
                `);
        } else {
            await showUserBlackList(res.Data);
        }
    }

    async function getDataUserCantConnect() {
        let _url = "../services/DashBoardRenew/dash-board-renew.controller.php";
        let _data = {
            Controller: 'getDataUserCantConnect',
            year: $("#year_renew").val(),
            monthRenew: $("#mounth_renew").val(),
            dealerCode: $("#login").val()
        };

        let res = await postApiChartAsync(_url, _data);

        if (res.Status !== 200) {
            $('#chartUserCantConnect').empty();
            $('#chartUserCantConnect').html(`
                <div class="d-flex align-items-center justify-content-center h-100">
                    <h5 class="m-0 text-red">ไม่พบข้อมูลติดต่อไม่ได้ <i class="far fa-folder-open"></i></h5>
                </div>
            `);



        } else {
            await showUserCantConnect(res.Data);
        }

        // let res = await $.ajax(req);
    }

    async function getDataUserWrongTel() {
        let _url = "../services/DashBoardRenew/dash-board-renew.controller.php";
        let _data = {
            Controller: 'getDataUserWrongTel',
            year: $("#year_renew").val(),
            monthRenew: $("#mounth_renew").val(),
            dealerCode: $("#login").val()
        };

        let res = await postApiChartAsync(_url, _data);

        if (res.Status !== 200) {
            $('#chartUserWrongTel').empty();
            $('#chartUserWrongTel').html(`
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <h5 class="m-0 text-red">ไม่พบข้อมูลเบอร์ผิด <i class="far fa-folder-open"></i></h5>
                    </div>
                `);
        } else {
            await showUserWrongTel(res.Data);
        }
    }

    async function genDataCallAverage() {
        let _url = "../services/DashBoardRenew/dash-board-renew.controller.php";
        let _data = {
            Controller: 'genDataCallAverage',
            year: $("#year_renew").val(),
            monthRenew: $("#mounth_renew").val(),
            dealerCode: $("#login").val()
        };

        let res = await postApiChartAsync(_url, _data);

        if (res.Status !== 200) {
            $('#totalCall').empty();
            $('#totalCall').html(
                `<h5 class="m-0 text-red">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>`);

            $('#average').empty();
            $('#average').html(
                `<h5 class="m-0 text-red">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>`);

            $('#callTotal').empty();
            $('#callTotal').html(
                `<h5 class="m-0 text-white">.</h5>`);

            $('#noCall').empty();
            $('#noCall').html(
                `<h5 class="m-0 text-red">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>`);

            $('#calls').empty();
            $('#calls').html(
                `<h5 class="m-0 text-red"></h5>`);
        } else {
            // TOTAL CALL
            await getTotalCall(res.Data['total']);
            // AVERAGE
            await getAverage(res.Data['average']);
            // CALL
            await getCall(res);
        }
    }

    async function genDataCallCount() {
        let _url = "../services/DashBoardRenew/dash-board-renew.controller.php";
        let _data = {
            Controller: 'genDataCallCount',
            year: $("#year_renew").val(),
            monthRenew: $("#mounth_renew").val(),
            dealerCode: $("#login").val()
        };

        let res = await postApiChartAsync(_url, _data);

        if (res.Status !== 200) {
            $('#chartCountCallPerEmp').empty();
            $('#chartCountCallPerEmp').html(`
                <div class="d-flex align-items-center justify-content-center h-100">
                    <h5 class="m-0 text-red">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>
                </div>
            `);
        } else {
            const list = res.Data.sort((a, b) => a.callNo - b.callNo).map((data, index, array) => data);
            await showCountCallPerEmp(list);
        }
    }

    async function getTotalCall(val) {
        await val != '' || val != 0 ? document.getElementById('totalCall').innerHTML =
            `${numberWithCommas(val)} ครั้ง` : document.getElementById('totalCall').innerHTML =
            `<h5 class="m-0 text-red">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>`;
    }

    async function getAverage(val) {
        await val != '' || val != 0 ? document.getElementById('average').innerHTML =
            `เฉลี่ย ${numberWithCommas(val)}` :
            document.getElementById('average').innerHTML =
            `<h5 class="m-0 text-red">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>`;
    }

    async function getCall(res) {
        let _total = await res.Data['called'] + res.Data['notCalled'];
        let _call = (res.Data['called'] / _total) * 100;
        let _noCall = (res.Data['notCalled'] / _total) * 100;

        await res.Data['called'] != '' ? document.getElementById('calls').innerHTML =
            `โทร ${numberWithCommas(res.Data['called'])} (${_call.toFixed(2)}%)` :
            document.getElementById('calls').innerHTML =
            `<h5 class="m-0 text-red">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>`;

        await res.Data['notCalled'] != '' ? document.getElementById('noCall').innerHTML =
            `ไม่โทร ${numberWithCommas(res.Data['notCalled'])} (${_noCall.toFixed(2)}%)` :
            document.getElementById('noCall').innerHTML = ``;

        document.getElementById('callTotal').innerHTML = _total != '' ?
            `จำนวนที่ต้องโทร ${await numberWithCommas(_total)}` : document.getElementById('callTotal').innerHTML =
            `<h4 class="m-0 text-red">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h4>`;
    }

    async function getSMS(res) {
        let _total = await res.Data['notSMS'] + res.Data['sms'];
        let _sms = (res.Data['sms'] / _total) * 100;
        let _noSMS = (res.Data['notSMS'] / _total) * 100;

        await res.Data['sms'] != '' ? document.getElementById('sms').innerHTML =
            `ส่ง ${numberWithCommas(res.Data['sms'])} (${_sms.toFixed(2)}%)` :
            document.getElementById('sms').innerHTML =
            `<h5 class="m-0 text-red">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>`;

        await res.Data['notSMS'] != '' ? document.getElementById('noSMS').innerHTML =
            `ไม่ส่ง ${numberWithCommas(res.Data['notSMS'])} (${_noSMS.toFixed(2)}%)` :
            document.getElementById('noSMS').innerHTML = ``;

        document.getElementById('totalSMS').innerHTML = _total != '' ?
            `จำนวนที่ต้องส่ง ${await numberWithCommas(_total)}` :
            document.getElementById('totalSMS').innerHTML =
            `<h4 class="m-0 text-red">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h4>`;
    }

    function handleEmptyHtml() {
        document.getElementById('calls').innerHTML = '';
        document.getElementById('noCall').innerHTML = '';
        document.getElementById('callTotal').innerHTML = '';
        document.getElementById('sms').innerHTML = '';
        document.getElementById('noSMS').innerHTML = '';
        document.getElementById('totalSMS').innerHTML = '';
        document.getElementById('totalCall').innerHTML = '';
        document.getElementById('average').innerHTML = '';
    }

    async function showChartAllService(dataAllService) {
        am4core.ready(function() {
            // Themes begin
            am4core.useTheme(am4themes_animated);
            am4core.addLicense("ch-custom-attribution"); // hide logo amchart
            // Themes end

            // Create chart instance
            var chart = am4core.create("show_content", am4charts.PieChart);

            // Add and configure Series
            var pieSeries = chart.series.push(new am4charts.PieSeries());
            pieSeries.dataFields.value = "value";
            pieSeries.dataFields.category = "key";

            // Let's cut a hole in our Pie chart the size of 30% the radius
            chart.innerRadius = am4core.percent(30);

            // Put a thick white border around each Slice
            pieSeries.slices.template.stroke = am4core.color("#fff");
            pieSeries.slices.template.strokeWidth = 2;
            pieSeries.slices.template.strokeOpacity = 1;
            pieSeries.labels.template.text = "{category}: {value.value}";
            pieSeries.slices.template
                // change the cursor on hover to make it apparent the object can be interacted with
                .cursorOverStyle = [{
                    "property": "cursor",
                    "value": "pointer"
                }];

            pieSeries.alignLabels = false;
            pieSeries.labels.template.bent = false;

            // Add a legend
            chart.legend = new am4charts.Legend();
            // chart.legend.valueLabels.template.disabled = true;

            chart.data = dataAllService;
        });
    }

    async function showCountCallPerEmp(dataAllService) {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        am4core.addLicense("ch-custom-attribution"); // hide logo amchart
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartCountCallPerEmp", am4charts.XYChart);

        // Add data
        chart.data = dataAllService;

        // Create category axis
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "callNo";
        categoryAxis.renderer.grid.template.disabled = true;
        categoryAxis.cursorTooltipEnabled = false;
        categoryAxis.renderer.minGridDistance = 20;

        // Create value axis
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.renderer.grid.template.disabled = false;
        valueAxis.cursorTooltipEnabled = false;
        valueAxis.min = 0; // start y at zero
        valueAxis.maxPrecision = 0;
        valueAxis.integersOnly = true;

        // Create series
        var series1 = chart.series.push(new am4charts.LineSeries());
        series1.dataFields.valueY = "callCount";
        series1.dataFields.categoryX = "callNo";
        series1.name = "showCountCallPerEmp";
        series1.bullets.push(new am4charts.CircleBullet());
        series1.tooltipText = "โทร {categoryX} ครั้ง จำนวน {valueY} ราย";
        // series1.legendSettings.valueText = "{valueY}";
        series1.visible = false;


        // Add chart cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.lineY.disabled = true;


        let hs1 = series1.segments.template.states.create("hover")
        hs1.properties.strokeWidth = 5;
        series1.segments.template.strokeWidth = 1;
    }

    async function showUserBlackList(dataAllService) {
        am4core.ready(function() {
            // Themes begin
            am4core.useTheme(am4themes_animated);
            am4core.addLicense("ch-custom-attribution"); // hide logo amchart
            // Themes end

            // Create chart instance
            var chart = am4core.create("chartUserBlackList", am4charts.PieChart);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            chart.data = dataAllService;
            chart.radius = am4core.percent(70);
            chart.innerRadius = am4core.percent(30);
            chart.startAngle = 180;
            chart.endAngle = 360;

            var pieSeries = chart.series.push(new am4charts.PieSeries());
            pieSeries.dataFields.value = "value";
            pieSeries.dataFields.category = "key";

            // Put a thick white border around each Slice
            pieSeries.slices.template.stroke = am4core.color("#fff");
            pieSeries.slices.template.strokeWidth = 2;
            pieSeries.slices.template.strokeOpacity = 1;
            pieSeries.labels.template.text = "{category}: {value.value}";

            // pieSeries.alignLabels = false;
            // pieSeries.labels.template.bent = true;
            // pieSeries.labels.template.radius = 3;
            // pieSeries.labels.template.padding(0, 0, 0, 0);

            var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
            shadow.opacity = 0;

        }); // end am4core.ready()
    }

    async function showUserCantConnect(dataAllService) {
        am4core.ready(function() {
            // Themes begin
            am4core.useTheme(am4themes_animated);
            am4core.addLicense("ch-custom-attribution"); // hide logo amchart
            // Themes end

            // Create chart instance
            var chart = am4core.create("chartUserCantConnect", am4charts.PieChart);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            chart.data = dataAllService;
            chart.radius = am4core.percent(70);
            chart.innerRadius = am4core.percent(30);
            chart.startAngle = 180;
            chart.endAngle = 360;

            var pieSeries = chart.series.push(new am4charts.PieSeries());
            pieSeries.dataFields.value = "value";
            pieSeries.dataFields.category = "key";

            // Put a thick white border around each Slice
            pieSeries.slices.template.stroke = am4core.color("#fff");
            pieSeries.slices.template.strokeWidth = 2;
            pieSeries.slices.template.strokeOpacity = 1;
            pieSeries.labels.template.text = "{category}: {value.value}";

            // pieSeries.alignLabels = false;
            // pieSeries.labels.template.bent = true;
            // pieSeries.labels.template.radius = 3;
            // pieSeries.labels.template.padding(0, 0, 0, 0);

            var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
            shadow.opacity = 0;

        }); // end am4core.ready()
    }

    async function showUserWrongTel(dataAllService) {
        am4core.ready(function() {
            // Themes begin
            am4core.useTheme(am4themes_animated);
            am4core.addLicense("ch-custom-attribution"); // hide logo amchart
            // Themes end

            // Create chart instance
            var chart = am4core.create("chartUserWrongTel", am4charts.PieChart);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            chart.data = dataAllService;
            chart.radius = am4core.percent(70);
            chart.innerRadius = am4core.percent(30);
            chart.startAngle = 180;
            chart.endAngle = 360;

            var pieSeries = chart.series.push(new am4charts.PieSeries());
            pieSeries.dataFields.value = "value";
            pieSeries.dataFields.category = "key";

            // Put a thick white border around each Slice
            pieSeries.slices.template.stroke = am4core.color("#fff");
            pieSeries.slices.template.strokeWidth = 2;
            pieSeries.slices.template.strokeOpacity = 1;
            pieSeries.labels.template.text = "{category}: {value.value}";

            // pieSeries.alignLabels = false;
            // pieSeries.labels.template.bent = true;
            // pieSeries.labels.template.radius = 3;
            // pieSeries.labels.template.padding(0, 0, 0, 0);

            var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
            shadow.opacity = 0;

        }); // end am4core.ready()
    }

    async function handelSearch() {
        document.getElementById('loading_graph').style.display = 'block';
        await handleEmptyHtml();
        await genDataRenews();
        await genDataSMSAverage();
        await genDataCallAverage();
        await genDataCallCount();
        await getDataUserBlackList();
        await getDataUserCantConnect();
        await getDataUserWrongTel();
        document.getElementById('loading_graph').style.display = 'none';
    }

    async function handleLoadAllData() {
        try {
            await handleEmptyHtml();
            await genDataRenews();
            await genDataSMSAverage();
            await genDataCallAverage();
            await genDataCallCount();
            await getDataUserBlackList();
            await getDataUserCantConnect();
            await getDataUserWrongTel();
        } catch (err) {
            Swal.fire(
                'เกิดข้อผิดพลาด?',
                'ไม่พบข้อมูล',
                'error'
            )
        }

    }

    handleLoadAllData();
    </script>
</body>

</html>