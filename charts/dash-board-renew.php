<?php

// require("check-ses.php");
session_start();
require("../inc/connectdbs.pdo.php");
if ($_SESSION['strUser'] == 'admin') {
    $sql_sea = "";
} else {
    $sql_sea = "WHERE user = '" . $_SESSION['strUser'] . "'";
}
echo "<script> var checkDealerCode = `{$_SESSION['strUser']}`</script>";
$_context_mitsubishi = PDO_CONNECTION::fourinsure_mitsu();
$query = "SELECT user,uname FROM tb_login $sql_sea ORDER BY user ASC";
$data_dealer = $_context_mitsubishi->query($query)->fetchAll(2);

if (!$data_dealer) {
    header('Location: ../load_logout.php');
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!--begin::Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@200&family=Prompt:wght@500&display=swap"
        rel="stylesheet">

    <!--end::Fonts -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>
<!-- Styles -->
<style>
body {
    font-family: 'prompt', sans-serif;
}

.kt-portlet .kt-portlet__body {
    background-color: #eef1f529;
}

#chartdiv6 {
    height: 500px;
    width: 100%;
    position: relative;
    display: block;
    margin-left: 2%;
    margin-right: 10%;
}

#chartdiv,
#chartdiv2,
#chartdiv4 {
    width: 100%;
    height: 310px;
}

#chartdiv3 {
    height: auto;
    min-height: 73rem;
}

/* #chartdiv4 {
    width: 100%;
    height: 500px;
} */

#chartdiv7 {
    width: 100%;
    height: 500px;
}


.max-140 {
    max-width: 136rem;
    margin-left: 4%;
    margin-top: 1%;
}

.font-2rem {
    font-size: 1.5rem !important
}

.head_sub {
    font-size: 1.2rem !important;
    margin-left: 1.5rem;
    margin-bottom: 0;
}

.all-center {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 95%;
    height: 80%;
}

.form-control {
    width: 94% !important;
}

body {
    overflow: hidden;
}

.kt-widget14 .kt-widget14__header .kt-widget14__desc {
    display: inline-block;
    margin-top: 1.2rem;
    font-size: 1.4rem !important;
    color: #74788d;
}

.font-green-sharp {
    font-size: 2.5rem !important;
    font-weight: 400 !important;
    color: #2ab4c0 !important;
}

.font-red-haze {
    font-size: 2.5rem !important;
    font-weight: 400 !important;
    color: #f36a5a !important;
}

.font-blue-sharp {
    font-size: 2.5rem !important;
    font-weight: 400 !important;
    color: #5C9BD1 !important;
}

.font-purple-soft {
    font-size: 2.5rem !important;
    font-weight: 400 !important;
    color: #8877a9 !important;
}

.font-pink-soft {
    font-size: 2.5rem !important;
    font-weight: 400 !important;
    color: #f35a97 !important;
}

.font-orange-soft {
    font-size: 2.5rem !important;
    font-weight: 400 !important;
    color: #f3b75a !important;
}


.dlf-c {
    font-size: 50px !important;
    text-align: center !important;
    justify-content: center !important;
}

.kt-widget14 .kt-widget14__header {
    margin: 0 !important;
    padding: 0 !important;
}

.kt-widget-green {
    background: url('../images/abstract-green-smooth-wave-lines.jpg');
}

.kt-widget-red {
    background: url('../images/line-blue.jpg');
    background-size: cover;
}
</style>

<body>

    <div class="kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-sm-12 col-xl-12">
                <div class="kt-portlet kt-portlet--tabs">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="kt-portlet__head-title" id="title"></div>
                            <div class="head_sub"><small class="byline"></small></div>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <form name='form_dealer' id='form_dealer'>
                                <ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand  nav-tabs-line-right nav-tabs-line-success"
                                    role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" style="display: none;" data-toggle="tab"
                                            href="#kt_portlet_tab_3_chart1" role="tab">
                                            <i class="la la-comment"></i>
                                            กราฟ
                                        </a>
                                    </li>
                                    <li class="nav-item dropdown" id="dealerCodeDiv">
                                        <a class="nav-link " role="button" aria-haspopup="true" aria-expanded="true">
                                            <i class="la la-cog"></i>
                                            ดิลเลอร์ :
                                            <div style="width: 12rem">
                                                <select name='dealerCode' id='dealerCode' class="form-control"
                                                    style="margin-left: 1rem;">
                                                    <option>กรุณาเลือก...</option>
                                                    <?php
                                                    if ($_SESSION['strUser'] == 'admin') {
                                                        foreach ($data_dealer as $r) {
                                                            echo "<option value='" . $r['user'] . "'>" . '[' . $r['user'] . ']' . ' ' . $r['uname'] . "</option>";
                                                        }
                                                    } else {
                                                        foreach ($data_dealer as $r) {
                                                            echo "<option value='" . $r['user'] . "'selected>" . '[' . $r['user'] . ']' . ' ' . $r['uname'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link " role="button" aria-haspopup="true" aria-expanded="true">
                                            <i class="la la-cog"></i>
                                            ประจำปี :
                                            <div>
                                                <select name='year' id='year' class="form-control"
                                                    style="margin-left: 1rem;">
                                                    <option>กรุณาเลือก...</option>
                                                    <?php
                                                    for ($i = date('Y') + 1; $i >= 2016; $i--) {
                                                        if ($i == date('Y')) {
                                                            $sel_y = "selected";
                                                        } else {
                                                            $sel_y = "";
                                                        }
                                                        echo "<option value='" . $i . "' " . $sel_y . ">" . $i . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <div style="margin: auto;">
                                            <a onclick='genChart();'
                                                class="btn btn-outline-success btn-sm btn-icon btn-icon-md">
                                                <i class="flaticon2-search-1"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="tab-content">
                            <div class="row" id="kt_portlet_tab_3_chart1">
                                <div class="col-sm-2 col-xl-2">
                                    <!--begin:: Widgets/Profit Share-->
                                    <div class="kt-portlet kt-portlet--height">
                                        <div class="kt-widget14 kt-widget-green">
                                            <div class="kt-widget14__header dlf-c">
                                                <h3 id='totalRenew' class="kt-widget14__title font-green-sharp counter"
                                                    data-count="0">
                                                </h3>
                                                <span class="kt-widget14__desc ">
                                                    ลูกค้าทั้งหมด <p class="yearSelect"></p>
                                                </span>
                                            </div>
                                            <div class="kt-widget14__content">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end:: Widgets/Profit Share-->
                                </div>
                                <div class="col-sm-2 col-xl-2">
                                    <!--begin:: Widgets/Profit Share-->
                                    <div class="kt-portlet kt-portlet--height dlf-c">
                                        <div class="kt-widget14 kt-widget-green">
                                            <div class="kt-widget14__header">
                                                <h3 id="totalSMS" class="kt-widget14__title font-orange-soft counter"
                                                    data-count="0">
                                                </h3>
                                                <span class="kt-widget14__desc dlf-c">
                                                    SMS ทั้งหมด <p class="yearSelect"></p>
                                                </span>
                                            </div>
                                            <div class="kt-widget14__content">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end:: Widgets/Profit Share-->
                                </div>
                                <div class="col-sm-2 col-xl-2">
                                    <!--begin:: Widgets/Profit Share-->
                                    <div class="kt-portlet kt-portlet--height">
                                        <div class="kt-widget14 kt-widget-green">
                                            <div class="kt-widget14__header dlf-c">
                                                <h3 id='totalFollow' class="kt-widget14__title font-red-haze counter"
                                                    data-count="0">
                                                </h3>
                                                <span class="kt-widget14__desc dlf-c">
                                                    ยอดรวมติดตาม <p class="yearSelect"></p>
                                                </span>
                                            </div>
                                            <div class="kt-widget14__content">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end:: Widgets/Profit Share-->
                                </div>
                                <div class="col-sm-2 col-xl-2">
                                    <!--begin:: Widgets/Profit Share-->
                                    <div class="kt-portlet kt-portlet--height">
                                        <div class="kt-widget14 kt-widget-green">
                                            <div class="kt-widget14__header dlf-c">
                                                <h3 id='totalQuotation'
                                                    class="kt-widget14__title font-blue-sharp counter" data-count="0">
                                                </h3>
                                                <span class="kt-widget14__desc dlf-c">
                                                    ยอดรวมเสนอราคา <p class="yearSelect"></p>
                                                </span>
                                            </div>
                                            <div class="kt-widget14__content">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end:: Widgets/Profit Share-->
                                </div>
                                <div class="col-sm-2 col-xl-2">
                                    <!--begin:: Widgets/Profit Share-->
                                    <div class="kt-portlet kt-portlet--height dlf-c">
                                        <div class="kt-widget14 kt-widget-green">
                                            <div class="kt-widget14__header">
                                                <h3 id="totalNotice" class="kt-widget14__title font-purple-soft counter"
                                                    data-count="0">
                                                </h3>
                                                <span class="kt-widget14__desc dlf-c">
                                                    ยอดรวมแจ้งงาน <p class="yearSelect"></p>
                                                </span>
                                            </div>
                                            <div class="kt-widget14__content">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end:: Widgets/Profit Share-->
                                </div>
                                <div class="col-sm-2 col-xl-2">
                                    <!--begin:: Widgets/Profit Share-->
                                    <div class="kt-portlet kt-portlet--height dlf-c">
                                        <div class="kt-widget14 kt-widget-green">
                                            <div class="kt-widget14__header">
                                                <h3 id="totalPremium" class="kt-widget14__title font-pink-soft counter"
                                                    data-count="0">
                                                </h3>
                                                <span class="kt-widget14__desc dlf-c">
                                                    เบี้ยสุทธิแจ้งงาน <p class="yearSelect"></p>
                                                </span>
                                            </div>
                                            <div class="kt-widget14__content">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end:: Widgets/Profit Share-->
                                </div>

                                <div class="col-sm-6 col-xl-6">
                                    <!--begin:: Widgets/Profit Share-->
                                    <div class="kt-portlet kt-portlet--height">
                                        <div class="kt-widget14">
                                            <div class="kt-widget14__header">
                                                <h3 class="kt-widget14__title">
                                                    กราฟแสดงข้อมูล แบ่งกลุ่มรถยนต์
                                                </h3>
                                            </div>
                                            <hr>
                                            <div class="kt-widget14__content">
                                                <div id="chartdiv2"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--end:: Widgets/Profit Share-->
                                </div>
                                <div class="col-sm-6 col-xl-6">
                                    <!--begin:: Widgets/Profit Share-->
                                    <div class="kt-portlet kt-portlet--height">
                                        <div class="kt-widget14">
                                            <div class="kt-widget14__header">
                                                <h3 class="kt-widget14__title">
                                                    กราฟแสดงเปรียบเทียบข้อมูล แบ่งกลุ่มเดือน
                                                </h3>
                                            </div>
                                            <hr>
                                            <div class="kt-widget14__content">
                                                <div id="chartdiv4"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--end:: Widgets/Profit Share-->
                                </div>
                                <div class="col-sm-2 col-xl-2">
                                    <!--begin:: Widgets/Profit Share-->
                                    <div class="kt-portlet kt-portlet--height">
                                        <div class="kt-widget14 kt-widget-red">
                                            <div class="kt-widget14__header dlf-c">
                                                <h3 id='totalRenewInMonth'
                                                    class="kt-widget14__title font-green-sharp counter" data-count="0">
                                                </h3>
                                                <span class="kt-widget14__desc ">
                                                    ลูกค้าที่หมดอายุในเดือน <p class="InMonth"></p>
                                                </span>
                                            </div>
                                            <div class="kt-widget14__content">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end:: Widgets/Profit Share-->
                                </div>
                                <div class="col-sm-2 col-xl-2">
                                    <!--begin:: Widgets/Profit Share-->
                                    <div class="kt-portlet kt-portlet--height dlf-c">
                                        <div class="kt-widget14 kt-widget-red">
                                            <div class="kt-widget14__header">
                                                <h3 id="totalSMSInMonth"
                                                    class="kt-widget14__title font-orange-soft counter" data-count="0">
                                                </h3>
                                                <span class="kt-widget14__desc dlf-c">
                                                    SMS ในเดือน <p class="InMonth"></p>
                                                </span>
                                            </div>
                                            <div class="kt-widget14__content">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end:: Widgets/Profit Share-->
                                </div>
                                <div class="col-sm-2 col-xl-2">
                                    <!--begin:: Widgets/Profit Share-->
                                    <div class="kt-portlet kt-portlet--height">
                                        <div class="kt-widget14 kt-widget-red">
                                            <div class="kt-widget14__header dlf-c">
                                                <h3 id='totalFollowInMonth'
                                                    class="kt-widget14__title font-red-haze counter" data-count="0">
                                                </h3>
                                                <span class="kt-widget14__desc dlf-c">
                                                    ยอดรวมติดตามในเดือน <p class="InMonth"></p>
                                                </span>
                                            </div>
                                            <div class="kt-widget14__content">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end:: Widgets/Profit Share-->
                                </div>
                                <div class="col-sm-2 col-xl-2">
                                    <!--begin:: Widgets/Profit Share-->
                                    <div class="kt-portlet kt-portlet--height">
                                        <div class="kt-widget14 kt-widget-red">
                                            <div class="kt-widget14__header dlf-c">
                                                <h3 id='totalQuotationInMonth'
                                                    class="kt-widget14__title font-blue-sharp counter" data-count="0">
                                                </h3>
                                                <span class="kt-widget14__desc dlf-c">
                                                    ยอดรวมเสนอราคาในเดือน <p class="InMonth"></p>
                                                </span>
                                            </div>
                                            <div class="kt-widget14__content">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end:: Widgets/Profit Share-->
                                </div>
                                <div class="col-sm-2 col-xl-2">
                                    <!--begin:: Widgets/Profit Share-->
                                    <div class="kt-portlet kt-portlet--height dlf-c">
                                        <div class="kt-widget14 kt-widget-red">
                                            <div class="kt-widget14__header">
                                                <h3 id="totalNoticeInMonth"
                                                    class="kt-widget14__title font-pink-soft counter" data-count="0">
                                                </h3>
                                                <span class="kt-widget14__desc dlf-c">
                                                    ยอดรวมแจ้งงานในเดือน <p class="InMonth"></p>
                                                </span>
                                            </div>
                                            <div class="kt-widget14__content">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end:: Widgets/Profit Share-->
                                </div>
                                <div class="col-sm-2 col-xl-2">
                                    <!--begin:: Widgets/Profit Share-->
                                    <div class="kt-portlet kt-portlet--height dlf-c">
                                        <div class="kt-widget14 kt-widget-red">
                                            <div class="kt-widget14__header">
                                                <h3 id="totalPremiunInMonth"
                                                    class="kt-widget14__title font-purple-soft counter" data-count="0">
                                                </h3>
                                                <span class="kt-widget14__desc dlf-c">
                                                    เบี้ยสุทธิแจ้งงานในเดือน <p class="InMonth"></p>
                                                </span>
                                            </div>
                                            <div class="kt-widget14__content">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end:: Widgets/Profit Share-->
                                </div>

                                <div class="col-sm-12 col-xl-12">
                                    <!--begin:: Widgets/Profit Share-->
                                    <div class="kt-portlet kt-portlet--height">
                                        <div class="kt-widget14">
                                            <div class="kt-widget14__header">
                                                <h3 class="kt-widget14__title">
                                                    กราฟแสดงเปรียบเทียบข้อมูลวันหมดอายุกรมธรรม์ แบ่งกลุ่มเดือน
                                                </h3>
                                            </div>
                                            <hr>
                                            <div class="kt-widget14__content">
                                                <div id="chartdiv"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--end:: Widgets/Profit Share-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div>
                            <!-- <form name='form_dealer' id='form_dealer'>
                                <ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand  nav-tabs-line-right nav-tabs-line-success" role="tablist">

                                </ul>
                            </form> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- begin::Global Config(global config for global JS sciprts) -->
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
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
    </script>

    <!-- end::Global Config -->

    <!--begin::Global Theme Bundle(used by all pages) -->
    <script src="assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
    <script src="assets/js/scripts.bundle.js" type="text/javascript"></script>

    <!--end::Global Theme Bundle -->

    <!-- Chart code -->
    <script type="text/javascript">
    if (checkDealerCode !== 'admin') {
        $('#dealerCodeDiv').hide();
    } else {
        $('#dealerCodeDiv').show();
    }

    $(document).ready(function() {
        $('#dealerCode').select2({
            dropdownAutoWidth: true
        });
    });

    genTextMonthTH();
    async function genTextMonthTH() {
        const d = new Date();
        let id = d.getUTCMonth() + 1;

        switch (id) {
            case 1:
                str = "มกราคม";
                break;
            case 2:
                str = "กุมภาพันธ์";
                break;
            case 3:
                str = "มีนาคม";
                break;
            case 4:
                str = "เมษายน";
                break;
            case 5:
                str = "พฤษภาคม";
                break;
            case 6:
                str = "มิถุนายน";
                break;
            case 7:
                str = "กรกฎาคม";
                break;
            case 8:
                str = "สิงหาคม";
                break;
            case 9:
                str = "กันยายน";
                break;
            case 10:
                str = "ตุลาคม";
                break;
            case 11:
                str = "พฤษจิกายน";
                break;
            case 12:
                str = "ธันวาคม";
                break;
        }
        await $('.InMonth').text(`${str}`);
    }

    async function getCompareYearsChart() {
        let dealerCode = document.getElementById('dealerCode').value;
        let year = document.getElementById('year').value;

        let req = {
            type: "POST",
            dataType: "json",
            url: "../services/DashBoardRenew/dash-board-renew.controller.php",
            data: {
                Controller: 'genDataExpirationDate',
                dealerCode: dealerCode,
                year: year

            },
            success: function(x) {
                return x;
            },
            error: function(e) {
                console.log(e);
                return false;
            }
        };

        let res = await $.ajax(req);

        if (res.Data.oninfo != 200) {
            $('#chartdiv').empty();
            $('#chartdiv').html(`
                <div class="d-flex align-items-center justify-content-center h-100">
                    <h5 class="m-0 text-danger">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>
                </div>
            `);
            return false;
        }
        await showChartExpirationDate(res.Data);
    }

    async function getCompareModelCar() {
        let dealerCode = document.getElementById('dealerCode').value;
        let year = document.getElementById('year').value;

        let req = {
            type: "POST",
            dataType: "json",
            url: "../services/DashBoardRenew/dash-board-renew.controller.php",
            data: {
                Controller: 'getDataModelCar',
                dealerCode: dealerCode,
                year: year

            },
            success: function(x) {
                return x;
            },
            error: function(e) {
                console.log(e);
                return false;
            }
        };

        let res = await $.ajax(req);
        console.log('getDataModelCar', res);

        if (!res || res.Status !== 200) {
            $('#chartdiv2').empty();
            $('#chartdiv2').html(`
                <div class="d-flex align-items-center justify-content-center h-100">
                    <h5 class="m-0 text-danger">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>
                </div>
            `);
            return false;
        }

        await showChartModelCar(res.Data);
    }

    async function showChartExpirationDate(data) {
        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            let chart2 = am4core.create('chartdiv', am4charts.XYChart)
            chart2.colors.step = 2;

            chart2.legend = new am4charts.Legend()
            chart2.legend.position = 'top'
            chart2.legend.paddingBottom = 20
            chart2.legend.labels.template.maxWidth = 95
            chart2.legend.useDefaultMarker = true;
            let markerTemplate2 = chart2.legend.markers.template;
            markerTemplate2.width = 15;
            markerTemplate2.height = 15;
            markerTemplate2.stroke = am4core.color("#ccc");

            chart2.logo.opacity = 0;
            chart2.logo.disabled = true;

            let xAxis = chart2.xAxes.push(new am4charts.CategoryAxis())
            xAxis.dataFields.category = 'category'
            // xAxis.renderer.cellStartLocation = 0.1
            // xAxis.renderer.cellEndLocation = 0.9
            xAxis.renderer.grid.template.location = 0;
            xAxis.renderer.labels.template.rotation = -45;
            xAxis.renderer.labels.template.horizontalCenter = "right";
            xAxis.renderer.labels.template.location = 0.5;

            let yAxis = chart2.yAxes.push(new am4charts.ValueAxis());
            yAxis.min = 0;

            function createSeries(value, name) {
                let series = chart2.series.push(new am4charts.ColumnSeries())
                series.columns.template.tooltipText = "จำนวน: [bold]{valueY}[/]";
                series.columns.template.width = am4core.percent(90);
                series.sequencedInterpolation = true;
                series.dataFields.valueY = value
                series.dataFields.categoryX = 'category'
                series.name = name

                series.events.on("hidden", arrangeColumns);
                series.events.on("shown", arrangeColumns);

                return series;
            }

            chart2.data = data.dataRender;

            let year1 = 'ประจำปี ' + $("#year").val();
            let year2 = 'ประจำปี ' + ($("#year").val() - 1);

            if (data.dataYear === true) {
                createSeries('year', year1);
            }
            if (data.dataLastyear === true) {
                createSeries('lastYear', year2);
            }

            function arrangeColumns() {

                let series = chart2.series.getIndex(0);

                let w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
                if (series.dataItems.length > 1) {
                    let x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
                    let x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
                    let delta = ((x1 - x0) / chart2.series.length) * w;
                    if (am4core.isNumber(delta)) {
                        let middle = chart2.series.length / 2;

                        let newIndex = 0;
                        chart2.series.each(function(series) {
                            if (!series.isHidden && !series.isHiding) {
                                series.dummyData = newIndex;
                                newIndex++;
                            } else {
                                series.dummyData = chart2.series.indexOf(series);
                            }
                        })
                        let visibleCount = newIndex;
                        let newMiddle = visibleCount / 2;

                        chart2.series.each(function(series) {
                            let trueIndex = chart2.series.indexOf(series);
                            let newIndex = series.dummyData;

                            let dx = (newIndex - trueIndex + middle - newMiddle) * delta

                            series.animate({
                                property: "dx",
                                to: dx
                            }, series.interpolationDuration, series.interpolationEasing);
                            series.bulletsContainer.animate({
                                property: "dx",
                                to: dx
                            }, series.interpolationDuration, series.interpolationEasing);
                        })
                    }
                }
            }
            chart2.exporting.menu = new am4core.ExportMenu();

        }); // end am4core.ready()
    }

    async function showChartModelCar(data) {
        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            // Create chart instance
            let chart = am4core.create("chartdiv2", am4charts.PieChart);

            // Add and configure Series
            let pieSeries = chart.series.push(new am4charts.PieSeries());
            pieSeries.dataFields.value = "litres";
            pieSeries.dataFields.category = "category";

            // Let's cut a hole in our Pie chart the size of 30% the radius
            chart.innerRadius = am4core.percent(30);

            // Put a thick white border around each Slice
            pieSeries.slices.template.stroke = am4core.color("#fff");
            pieSeries.slices.template.strokeWidth = 2;
            pieSeries.slices.template.strokeOpacity = 1;
            pieSeries.slices.template
                // change the cursor on hover to make it apparent the object can be interacted with
                .cursorOverStyle = [{
                    "property": "cursor",
                    "value": "pointer"
                }];

            pieSeries.alignLabels = true;
            pieSeries.labels.template.disabled = false;
            pieSeries.ticks.template.disabled = false;

            // Create a base filter effect (as if it's not there) for the hover to return to
            let shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
            shadow.opacity = 0;

            // Create hover state
            let hoverState = pieSeries.slices.template.states.getKey(
                "hover"); // normally we have to create the hover state, in this case it already exists

            // Slightly shift the shadow and make it more prominent on hover
            let hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
            hoverShadow.opacity = 0.7;
            hoverShadow.blur = 5;

            // Add a legend
            // chart.legend = new am4charts.Legend();
            // chart.legend.maxWidth = 100;

            chart.logo.opacity = 0;
            chart.logo.disabled = true;

            chart.data = data;
            chart.exporting.menu = new am4core.ExportMenu();

        }); // end am4core.ready()
    }

    async function genTotalData() {
        let dealerCode = document.getElementById('dealerCode').value;
        let year = document.getElementById('year').value;
        let req = {
            type: "POST",
            dataType: "json",
            url: "../services/DashBoardRenew/dash-board-renew.controller.php",
            data: {
                Controller: 'genTotalData',
                dealerCode: dealerCode,
                year: year

            },
            success: function(x) {
                return x;
            },
            error: function(e) {
                console.log(e);
                return false;
            }
        };

        let res = await $.ajax(req);
        console.log('genTotalData', res);

        if (res.Status !== 200) {
            console.log('error genTotalData');
            return false;
        }
        console.log('return API', res.Data);

        await $('#totalRenew').attr('data-count', res.Data.resRenewCount);
        await $('#totalFollow').attr('data-count', res.Data.resFollowCount);
        await $('#totalQuotation').attr('data-count', res.Data.resQuotationCount);
        await $('#totalNotice').attr('data-count', res.Data.resNoticeCount);
        await $('#totalPremium').attr('data-count', res.Data.resPremiumSum);
        await $('#totalSMS').attr('data-count', res.Data.resSmsSum);

        await $('#totalRenewInMonth').attr('data-count', res.Data.resRenewCountInMonth);
        await $('#totalFollowInMonth').attr('data-count', res.Data.resFollowCountInMonth);
        await $('#totalQuotationInMonth').attr('data-count', res.Data.resQuotationCountInMonth);
        await $('#totalNoticeInMonth').attr('data-count', res.Data.resNoticeCountInMonth);
        await $('#totalPremiunInMonth').attr('data-count', res.Data.resPremiunCountInMonth);
        await $('#totalSMSInMonth').attr('data-count', res.Data.resSmsCountInMonth);

        await reloadCalculate();
    }

    async function genTotalDataByMonth() {
        let dealerCode = document.getElementById('dealerCode').value;
        let year = document.getElementById('year').value;
        let req = {
            type: "POST",
            dataType: "json",
            url: "../services/DashBoardRenew/dash-board-renew.controller.php",
            data: {
                Controller: 'genTotalDataByMonth',
                dealerCode: dealerCode,
                year: year

            },
            success: function(x) {
                return x;
            },
            error: function(e) {
                console.log(e);
                return false;
            }
        };

        let res = await $.ajax(req);

        if (res.Status !== 200) {
            $('#chartdiv4').empty();
            $('#chartdiv4').html(`
                <div class="d-flex align-items-center justify-content-center h-100">
                    <h5 class="m-0 text-danger">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>
                </div>
            `);
            return false;
        }

        await showChartAllService(res.Data)
    }

    async function showChartAllService(dataAllService) {
        am4core.ready(function() {
            console.log('showChartAllService', dataAllService);
            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            // Create chart instance
            let chart4 = am4core.create("chartdiv4", am4charts.XYChart);
            chart4.data = dataAllService;
            let model = [{
                'totalSMS': 'ยอดส่ง SMS'
            }, {
                'totalFollow': 'ยอดติดตาม'
            }, {
                'totalQuotation': 'ยอดเสนอราคา'
            }, {
                'totalNotice': 'ยอดแจ้งงาน'
            }, {
                'totalCallAverage': 'ค่าเฉลี่ยการโทร'
            }, {
                'totalEndDate': 'ข้อมูลลูกค้า'
            }];

            // Create axes
            let categoryAxis4 = chart4.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis4.dataFields.category = "year";
            // categoryAxis4.title.text = "ประเภทยอดรวม";
            categoryAxis4.renderer.grid.template.location = 0;
            categoryAxis4.renderer.minGridDistance = 20;
            // categoryAxis4.renderer.cellStartLocation = 0.1;
            // categoryAxis4.renderer.cellEndLocation = 0.9;
            categoryAxis4.renderer.labels.template.rotation = -45;
            categoryAxis4.renderer.labels.template.horizontalCenter = "right";
            categoryAxis4.renderer.labels.template.location = 0.5;

            let valueAxis4 = chart4.yAxes.push(new am4charts.ValueAxis());
            valueAxis4.min = 0;
            valueAxis4.title.text = "";

            // Create series
            function createSeries(field, name, stacked) {
                var series = chart4.series.push(new am4charts.ColumnSeries());
                series.dataFields.valueY = field;
                series.dataFields.categoryX = "year";
                series.name = `${name}`;
                series.columns.template.tooltipText = "{name}: [bold]{valueY.formatNumber('#,###')}[/]";
                series.stacked = stacked;
                series.columns.template.width = am4core.percent(95);

                // var bullet1 = series.bullets.push(new am4charts.LabelBullet());
                // bullet1.interactionsEnabled = false;
                // bullet1.name = `${name}`;
                // bullet1.label.text = "[bold]{valueY.formatNumber('#,###')}[/]";
                // bullet1.label.fill = am4core.color("#ffffff");
                // bullet1.locationY = 0.5;
            }
            model.forEach(val => {
                createSeries(Object.keys(val), Object.values(val), true);
            });

            // Add legend
            chart4.legend = new am4charts.Legend();
            chart4.legend.useDefaultMarker = true;
            var markerTemplate4 = chart4.legend.markers.template;
            markerTemplate4.width = 15;
            markerTemplate4.height = 15;
            markerTemplate4.stroke = am4core.color("#ccc");
            chart4.logo.opacity = 0;
            chart4.logo.disabled = true;

            chart4.exporting.menu = new am4core.ExportMenu();

        });
    }

    async function reloadCalculate() {
        await $('.counter').each(function() {
            var $this = $(this),
                countTo = $this.attr('data-count');

            $({
                countNum: $this.text()
            }).animate({
                    countNum: countTo
                },

                {
                    duration: 2000,
                    easing: 'linear',
                    step: function() {
                        $this.text(commaSeparateNumber(Math.floor(this.countNum)));
                    },
                    complete: function() {
                        $this.text(commaSeparateNumber(this.countNum));
                        //alert('finished');
                    }
                }
            );
        });
    }

    async function genChart() {
        try
        {
            await genTextMonthTH();
            await showChartAllService();
            await getCompareYearsChart();
            await getCompareModelCar();
            await genTotalData();
            await genTotalDataByMonth();
        }
        catch(err)
        {
            console.log(err);
            alert(err.responseJSON.Data);
            await clearAll();            
        }
    }

    async function clearAll(){
        $('#chartdiv').empty();
        $('#chartdiv').html(`
            <div class="d-flex align-items-center justify-content-center h-100">
                <h5 class="m-0 text-danger">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>
            </div>
        `);


        $('#chartdiv2').empty();
        $('#chartdiv2').html(`
            <div class="d-flex align-items-center justify-content-center h-100">
                <h5 class="m-0 text-danger">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>
            </div>
        `);

        $('#chartdiv4').empty();
        $('#chartdiv4').html(`
            <div class="d-flex align-items-center justify-content-center h-100">
                <h5 class="m-0 text-danger">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>
            </div>
        `);

        await $('#totalRenew').attr('data-count', 0);
        await $('#totalFollow').attr('data-count', 0);
        await $('#totalQuotation').attr('data-count', 0);
        await $('#totalNotice').attr('data-count', 0);
        await $('#totalPremium').attr('data-count', 0);
        await $('#totalSMS').attr('data-count', 0);

        await $('#totalRenewInMonth').attr('data-count', 0);
        await $('#totalFollowInMonth').attr('data-count', 0);
        await $('#totalQuotationInMonth').attr('data-count', 0);
        await $('#totalNoticeInMonth').attr('data-count', 0);
        await $('#totalPremiunInMonth').attr('data-count', 0);
        await $('#totalSMSInMonth').attr('data-count', 0);
        await reloadCalculate();
    }

    try {
        $('#dealerCode').val(checkDealerCode);

        genChart();

        function commaSeparateNumber(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }

    } catch (error) {
        console.log(error);
    }
    </script>


</body>

</html>