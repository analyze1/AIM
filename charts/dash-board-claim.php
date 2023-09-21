<?php
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
#chartClaim {
    width: 100%;
    height: 264px;
}

#chartdiv3 {
    height: auto;
    min-height: 73rem;
}

/* #chartClaim {
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
            <div class="col-xl-12">
                <div class="kt-portlet kt-portlet--tabs">
                    <div class="kt-portlet__body">
                        <div class="tab-content">
                            <div class="row" id="kt_portlet_tab_3_chart1">
                                <div class="col-xl-12">
                                    <!--begin:: Widgets/Profit Share-->
                                    <div class="kt-portlet kt-portlet--height">
                                        <div class="kt-widget14">
                                            <div class="kt-widget14__header">
                                                <h3 class="kt-widget14__title">
                                                    กราฟเปรียบเทียบข้อมูลค่าแรง + ค่าอะไหล่
                                                </h3>
                                            </div>
                                            <hr>
                                            <div class="kt-widget14__content">
                                                <div id="chartClaim"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end:: Widgets/Profit Share-->
                                </div>
                            </div>
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
    async function genDataSpareParts() {
        let req = {
            type: "POST",
            dataType: "json",
            url: "../services/DashBoardRenew/dash-board-renew.controller.php",
            data: {
                Controller: 'genDataSpareParts',
                dealerCode: checkDealerCode
            },
            success: function(x) {
                return x;
            },
            error: function(e) {
                $('#chartClaim').empty();
                $('#chartClaim').html(`
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <h5 class="m-0 text-danger">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>
                    </div>
                `);
                return false;
            }
        };

        let res = await $.ajax(req);

        if (res.Status !== 200) {
            $('#chartClaim').empty();
            $('#chartClaim').html(`
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
            let chart4 = am4core.create("chartClaim", am4charts.XYChart);
            chart4.data = dataAllService;

            let model = [{
                'totalSpareParts': 'รวมค่าอะไหล่'
            }, {
                'totalWages': 'รวมค่าแรง'
            }, {
                'totalSupply': 'รวมค่าอะไหล่ Supply'
            }, {
                'totalClaims': 'รวมสินไหมจ่าย'
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
                series.columns.template.width = am4core.percent(40);
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

    try {
        genDataSpareParts();
    } catch (error) {
        console.log(error);
    }
    </script>


</body>

</html>