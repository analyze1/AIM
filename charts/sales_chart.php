<?php

// require("check-ses.php");
session_start();
require("../inc/connectdbs.pdo.php");
if ($_SESSION['strUser'] == 'admin') {
    $sql_sea = "";
} else {
    $sql_sea = " AND user = '" . $_SESSION['strUser'] . "'";
}
$_context_suzuki = PDO_CONNECTION::fourinsure_mitsu();
$query = "SELECT user,sub,title_sub FROM tb_customer WHERE nameuser = 'Mitsubishi' $sql_sea ORDER BY user ASC";
$data_dealer = $_context_suzuki->query($query)->fetchAll(PDO::FETCH_ASSOC);

if(!$data_dealer){
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
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">

    <!--end::Fonts -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>
<!-- Styles -->
<style>
    body {
        font-family: 'Sarabun', sans-serif;
    }

    #chartdiv {
        height: 500px;
        width: 100%;
        position: relative;
    }

    #chartdiv6 {
        height: 500px;
        width: 100%;
        position: relative;
        display: block;
        margin-left: 2%;
        margin-right: 10%;
    }

    #chartdiv2 {
        width: 100%;
        height: 60rem;
    }

    #chartdiv3 {
        height: auto;
        min-height: 73rem;
    }

    #chartdiv4 {
        width: 100%;
        height: 500px;
    }

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
</style>

<body>

    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="kt-portlet kt-portlet--tabs">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="kt-portlet__head-title" id="title"></div>
                            <div class="head_sub"><small class="byline"></small></div>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <form name='form_dealer' id='form_dealer'>
                                <ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand  nav-tabs-line-right nav-tabs-line-success" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" style="display: none;" data-toggle="tab" href="#kt_portlet_tab_3_chart1" role="tab">
                                            <i class="la la-comment"></i>
                                            กราฟ
                                        </a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link " role="button" aria-haspopup="true" aria-expanded="true">
                                            <i class="la la-cog"></i>
                                            ดิลเลอร์ :
                                            <div style="width: 12rem">
                                                <select name='id_dealer' id='id_dealer' class="form-control" style="margin-left: 1rem;">
                                                    <option>กรุณาเลือก...</option>
                                                    <?php
                                                    if ($_SESSION['strUser'] == 'admin') {
                                                        foreach ($data_dealer as $r) {
                                                            echo "<option value='" . $r['user'] . "'>" . '[' . $r['user'] . ']' . ' ' . $r['title_sub'] . ' ' . $r['sub'] . "</option>";
                                                        }
                                                    } else {
                                                        foreach ($data_dealer as $r) {
                                                            echo "<option value='" . $r['user'] . "'selected>" . '[' . $r['user'] . ']' . ' ' . $r['title_sub'] . ' ' . $r['sub'] . "</option>";
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
                                                <select name='date_year' id='date_year' class="form-control" style="margin-left: 1rem;">
                                                    <option>กรุณาเลือก...</option>
                                                    <?php
                                                    for ($i = date('Y'); $i >= 2016; $i--) {
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
                                            <a onclick='get_sales_chart();' class="btn btn-outline-success btn-sm btn-icon btn-icon-md">
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
                            <div class="tab-pane active" id="kt_portlet_tab_3_chart1">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">

                                        <!--begin:: Widgets/Profit Share-->
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-widget14">
                                                <div class="kt-widget14__header">
                                                    <h3 class="kt-widget14__title">
                                                        กราฟแสดงข้อมูล แบ่งกลุ่มรถยนต์
                                                    </h3>
                                                    <span class="kt-widget14__desc">

                                                    </span>
                                                </div>
                                                <div class="kt-widget14__content">
                                                    <div id="chartdiv"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end:: Widgets/Profit Share-->
                                    </div>
                                    <div class="col-xl-6 col-lg-6">

                                        <!--begin:: Widgets/Profit Share-->
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-widget14">
                                                <div class="kt-widget14__header">
                                                    <h3 class="kt-widget14__title">
                                                        กราฟแสดงยอดขายรวม แบ่งกลุ่มบริษัทไฟแนนซ์
                                                    </h3>
                                                    <span class="kt-widget14__desc">

                                                    </span>
                                                </div>
                                                <div class="kt-widget14__content">
                                                    <div id="chartdiv6"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end:: Widgets/Profit Share-->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">

                                        <!--begin:: Widgets/Profit Share-->
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-widget14">
                                                <div class="kt-widget14__header">
                                                    <h3 class="kt-widget14__title">
                                                        กราฟแสดงยอดขายในแต่ละเดือน
                                                    </h3>
                                                    <span class="kt-widget14__desc">

                                                    </span>
                                                </div>
                                                <div class="kt-widget14__content">
                                                    <div id="chartdiv4"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end:: Widgets/Profit Share-->
                                    </div>
                                    <div class="col-xl-12 col-lg-12">

                                        <!--begin:: Widgets/Profit Share-->
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-widget14">
                                                <div class="kt-widget14__header">
                                                    <h3 class="kt-widget14__title">
                                                        กราฟแสดงการเปรียบเทียบยอดขายรวม แบ่งกลุ่มปี
                                                    </h3>
                                                    <span class="kt-widget14__desc">

                                                    </span>
                                                </div>
                                                <div class="kt-widget14__content">
                                                    <div id="chartdiv2"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end:: Widgets/Profit Share-->
                                    </div>
                                    <div class="col-xl-12 col-lg-12">

                                        <!--begin:: Widgets/Profit Share-->
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-widget14">
                                                <div class="kt-widget14__header">
                                                    <h3 class="kt-widget14__title">
                                                        กราฟแสดงยอดขายรวม แบ่งกลุ่มจังหวัด
                                                    </h3>
                                                    <span class="kt-widget14__desc">

                                                    </span>
                                                </div>
                                                <div class="kt-widget14__content">
                                                    <div id="chartdiv7"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end:: Widgets/Profit Share-->
                                    </div>
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
        // var year = new Date();
        // var x = year.toLocaleDateString("th-TH");
        

        async function get_sales_chart() {
            $('.byline').empty();
            $('#title').empty();
            $.post('../ajax/ajax_data_sales_chart.php', $("#form_dealer").serialize(), function(data) {
                let array = JSON.parse(data);
                let total = 0;
                array.forEach(element => total += Number(element.count));
                $('.byline').append('  จำนวนรายการขายทั้งหมด ' + total + ' รายการ');
                $('#title').append('กราฟแสดงยอดขาย [Suzuki] ประจำปี ' + $("#date_year").val());
                show_chart(array);
            });

            let req = {
                            type: "POST",
                            dataType: "json",
                            url: "ajax/ajax_data_sales_chart.php",
                            data: {
                                type_inform: 'FOUR',
                                key_search: person
                            },
                            success: function(x) {
                                return x;
                            },
                            error: function(e){
                                console.log(e);
                                return false;
                            }
                        };

            let res = await $.ajax(req);

            // get_gain_chart();
            // get_compare_month_chart();
            // get_compare_years_chart();
            // get_province_chart();
        }

        function show_chart(data) {
            am4core.ready(function() {

                // Themes begin
                // am4core.useTheme(am4themes_material);
                am4core.useTheme(am4themes_material);
                am4core.useTheme(am4themes_animated);
                // Themes end

                var chart = am4core.create("chartdiv", am4charts.PieChart3D);
                chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

                chart.legend = new am4charts.Legend();
                chart.legend.useDefaultMarker = true;
                var markerTemplate = chart.legend.markers.template;
                markerTemplate.width = 15;
                markerTemplate.height = 15;
                markerTemplate.stroke = am4core.color("#ccc");

                chart.data = data;
                //console.log(data);

                chart.innerRadius = 100;

                var series1 = chart.series.push(new am4charts.PieSeries3D());
                series1.dataFields.value = "count";
                series1.dataFields.category = "name";
                chart.logo.opacity = 0;
                chart.logo.disabled = true;

                chart.exporting.menu = new am4core.ExportMenu();

            }); // end am4core.ready()

        }

        function get_gain_chart() {
            $.post('../ajax/ajax_data_sales_gain_chart.php', $("#form_dealer").serialize(), function(data) {
                var arrays = JSON.parse(data);
                show_chart6(arrays);
            });
        }

        function get_province_chart() {
            $.post('../ajax/ajax_data_sales_compare_province.php', $("#form_dealer").serialize(), function(data) {
                var arrays = JSON.parse(data);
                show_chart7(arrays);
            });
        }

        function get_compare_years_chart() {
            $.post('../ajax/ajax_data_sales_compare_years.php', $("#form_dealer").serialize(), function(data) {
                var arrays = JSON.parse(data);
                //console.log('show_chart2y', JSON.stringify(arrays));

                let index_year = arrays["length"];
                delete arrays["length"];
                var str = '';
                var xx = true;
                index_year.forEach(i => {
                    if (arrays[i]) {
                        if (xx === true) {
                            str += JSON.stringify(arrays[i]);
                            xx = false;
                        } else {
                            str += ',' + JSON.stringify(arrays[i]);
                        }
                    } else {
                        console.log('arrays[i] :' + i, arrays[i]);
                    }
                });
                let obj_year = '[' + str + ']';
                console.log('obj_year', str);

                show_chart2(JSON.parse(obj_year));
            });
        }

        function get_compare_month_chart() {
            $.post('../ajax/ajax_data_sales_compare_month.php', $("#form_dealer").serialize(), function(data) {
                var arrays = JSON.parse(data);
                var sss = String(arrays["allRegion"]).split('|').filter(function(value, index, self) {
                    return self.indexOf(value) === index;
                })
                sss.splice(sss.length - 1, 1);
                let index_month = arrays["length"];
                delete arrays["allRegion"];
                delete arrays["length"];
                var text = '';
                var x = true;
                index_month.forEach(i => {
                    if (arrays[i]) {
                        if (x === true) {
                            text += JSON.stringify(arrays[i]);
                            x = false;
                        } else {
                            text += ',' + JSON.stringify(arrays[i]);
                        }
                    } else {
                        console.log('arrays[i] :' + i, arrays[i]);
                    }
                });
                let aaa = '[' + text + ']';

                show_chart3(JSON.parse(aaa), sss);
            });
        }

        function show_chart2(data2) {
            am4core.ready(function() {

                // Themes begin
                am4core.useTheme(am4themes_material);
                am4core.useTheme(am4themes_animated);
                // Themes end

                var chart2 = am4core.create('chartdiv2', am4charts.XYChart)
                chart2.colors.step = 2;

                chart2.legend = new am4charts.Legend()
                chart2.legend.position = 'top'
                chart2.legend.paddingBottom = 20
                chart2.legend.labels.template.maxWidth = 95
                chart2.legend.useDefaultMarker = true;
                var markerTemplate2 = chart2.legend.markers.template;
                markerTemplate2.width = 15;
                markerTemplate2.height = 15;
                markerTemplate2.stroke = am4core.color("#ccc");

                chart2.logo.opacity = 0;
                chart2.logo.disabled = true;

                var xAxis = chart2.xAxes.push(new am4charts.CategoryAxis())
                xAxis.dataFields.category = 'category'
                xAxis.renderer.cellStartLocation = 0.1
                xAxis.renderer.cellEndLocation = 0.9
                xAxis.renderer.grid.template.location = 0;

                var yAxis = chart2.yAxes.push(new am4charts.ValueAxis());
                yAxis.min = 0;

                function createSeries(value, name) {
                    var series = chart2.series.push(new am4charts.ColumnSeries())
                    series.columns.template.tooltipText = "จำนวนยอดขาย: [bold]{valueY}[/]";
                    series.columns.template.width = am4core.percent(100);
                    series.sequencedInterpolation = true;
                    series.dataFields.valueY = value
                    series.dataFields.categoryX = 'category'
                    series.name = name

                    series.events.on("hidden", arrangeColumns);
                    series.events.on("shown", arrangeColumns);

                    // var bullet = series.bullets.push(new am4charts.LabelBullet())
                    // bullet.interactionsEnabled = false
                    // bullet.dy = 30;
                    // bullet.label.text = '{valueY}'
                    // bullet.label.fill = am4core.color('#ffffff')

                    return series;
                }

                chart2.data = data2;


                var year1 = 'ประจำปี ' + $("#date_year").val();
                var year2 = 'ประจำปี ' + ($("#date_year").val() - 1);


                createSeries('year', year1);
                createSeries('lastYear', year2);

                function arrangeColumns() {

                    var series = chart2.series.getIndex(0);

                    var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
                    if (series.dataItems.length > 1) {
                        var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
                        var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
                        var delta = ((x1 - x0) / chart2.series.length) * w;
                        if (am4core.isNumber(delta)) {
                            var middle = chart2.series.length / 2;

                            var newIndex = 0;
                            chart2.series.each(function(series) {
                                if (!series.isHidden && !series.isHiding) {
                                    series.dummyData = newIndex;
                                    newIndex++;
                                } else {
                                    series.dummyData = chart2.series.indexOf(series);
                                }
                            })
                            var visibleCount = newIndex;
                            var newMiddle = visibleCount / 2;

                            chart2.series.each(function(series) {
                                var trueIndex = chart2.series.indexOf(series);
                                var newIndex = series.dummyData;

                                var dx = (newIndex - trueIndex + middle - newMiddle) * delta

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

        function show_chart3(data3, model) {
            am4core.ready(function() {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance
                var chart4 = am4core.create("chartdiv4", am4charts.XYChart);

                chart4.data = data3;

                // Create axes
                var categoryAxis4 = chart4.xAxes.push(new am4charts.CategoryAxis());
                categoryAxis4.dataFields.category = "year";
                categoryAxis4.title.text = "ประเภทรถยนต์";
                categoryAxis4.renderer.grid.template.location = 0;
                categoryAxis4.renderer.minGridDistance = 20;
                categoryAxis4.renderer.cellStartLocation = 0.1;
                categoryAxis4.renderer.cellEndLocation = 0.9;

                var valueAxis4 = chart4.yAxes.push(new am4charts.ValueAxis());
                valueAxis4.min = 0;
                valueAxis4.title.text = "ยอดขายรวมในแต่ละเดือน";

                // Create series
                function createSeries(field, name, stacked) {
                    var series = chart4.series.push(new am4charts.ColumnSeries());
                    series.dataFields.valueY = field;
                    series.dataFields.categoryX = "year";
                    series.name = name;
                    series.columns.template.tooltipText = "{name}: [bold]{valueY}[/]";
                    series.stacked = stacked;
                    series.columns.template.width = am4core.percent(95);
                }
                model.forEach(x => {
                    createSeries(x, x, true);
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

        function show_chart6(data6) {
            am4core.ready(function() {

                // Themes begin
                am4core.useTheme(am4themes_material);
                am4core.useTheme(am4themes_animated);
                // Themes end

                var chart6 = am4core.create("chartdiv6", am4charts.PieChart);
                chart6.hiddenState.properties.opacity = 0; // this creates initial fade-in

                chart6.data = data6;
                chart6.radius = am4core.percent(70);
                chart6.innerRadius = am4core.percent(40);
                chart6.startAngle = 180;
                chart6.endAngle = 360;

                var series6 = chart6.series.push(new am4charts.PieSeries());
                series6.dataFields.value = "count";
                series6.dataFields.category = "name";
                series6.ticks.template.disabled = true;
                series6.labels.template.disabled = true;

                series6.slices.template.cornerRadius = 10;
                series6.slices.template.innerCornerRadius = 7;
                series6.slices.template.draggable = true;
                series6.slices.template.inert = true;
                series6.alignLabels = false;

                series6.hiddenState.properties.startAngle = 90;
                series6.hiddenState.properties.endAngle = 90;

                chart6.legend = new am4charts.Legend();
                chart6.legend.useDefaultMarker = true;
                var markerTemplate6 = chart6.legend.markers.template;
                markerTemplate6.width = 15;
                markerTemplate6.height = 15;
                markerTemplate6.stroke = am4core.color("#ccc");
                chart6.logo.opacity = 0;
                chart6.logo.disabled = true;

                chart6.exporting.menu = new am4core.ExportMenu();

            });
        }

        function show_chart7(data7) {
            am4core.ready(function() {

                // Themes begin
                am4core.useTheme(am4themes_material);
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance
                var chart7 = am4core.create("chartdiv7", am4charts.PieChart);

                // Add data
                chart7.data = data7;

                // Add and configure Series
                var pieSeries7 = chart7.series.push(new am4charts.PieSeries());
                pieSeries7.dataFields.value = "litres";
                pieSeries7.dataFields.category = "country";
                pieSeries7.slices.template.stroke = am4core.color("#fff");
                pieSeries7.slices.template.strokeWidth = 2;
                pieSeries7.slices.template.strokeOpacity = 1;
                pieSeries7.ticks.template.disabled = true;
                pieSeries7.labels.template.disabled = true;

                // This creates initial animation
                pieSeries7.hiddenState.properties.opacity = 1;
                pieSeries7.hiddenState.properties.endAngle = -90;
                pieSeries7.hiddenState.properties.startAngle = -90;

                chart7.logo.opacity = 0;
                chart7.logo.disabled = true;

                chart7.exporting.menu = new am4core.ExportMenu();

            });
        }

        get_sales_chart();
    </script>


</body>

</html>