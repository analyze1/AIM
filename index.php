<?php
// header('Content-Type: application/json');
// http_response_code(200);
// $x = ['คุณ', 'นาย', 'นางสาว', 'นาง'];
// $xx = [
//     'Typecar'=>array(array('id'=>10,'name'=>'รถยนต์'));
// ]
// echo json_encode(['Status' => 200, 'Data' => $x]);
// exit();

session_start();
include "./inc/connectdbs.pdo.php";

include "pages/check-ses.php";

?>
<!DOCTYPE html>
<html lang="th">
<!-- ตั้งค่า font 13 px พร้อมเปลียนประเภท font เท่ากับเมนูตามที่คุณหมู่สั่งไว้ -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@200&family=Prompt:wght@400&display=swap" rel="stylesheet">

<head>

    <meta charset="utf-8" />
    <?php if (!empty($_SESSION['icon_logo'])) { ?>
        <link rel="shortcut icon" href="images/logo_sip.jpg" />
        <title>Sale Intelligent Platform</title>
    <?php } else { ?>
        <link rel="shortcut icon" href="img4/AIM_mini.png" />
        <title>ประกันภัยออนไลน์ MVinsurance</title>
    <?php } ?>


    <meta name="description" content="This is page-header (.page-header &gt; h1)" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <style>
        td,
        span {
            font-family: 'prompt' !important;
            font-weight: 400 !important;
            font-size: 15px !important;

        }

        body,
        div,
        li,
        ul,
        input,
        span,
        select,
        button,
        table,
        marquee,
        iframe,
        th,
        header {
            font-family: prompt !important;
            font-size: 15px !important;
        }

        .btn-omaewa {
            font-size: 15px !important;
        }

        table {
            font-size: 15px !important;
            font-family: prompt !important;
        }

        td {
            padding: 2px !important;
        }

        button {
            font-size: 15px !important;
            font-family: prompt !important;
        }

        a {
            font-size: 15px !important;
            font-family: prompt !important;
        }

        label {
            font-size: 15px !important;
            font-family: prompt !important;
        }

        input {
            font-size: 15px !important;
            font-family: prompt !important;
        }

        select {
            font-size: 15px !important;
            font-family: prompt !important;
        }

        textarea {
            font-size: 15px !important;
            font-family: prompt !important;
        }

        a {
            color: #000000 !important;
        }

        div {
            color: #000000;
        }

        li {
            color: #000000 !important;
        }

        .widget-header-flat {
            border-style: none !important;
            color: #FFFFFF !important;
            background: linear-gradient(to left, #778ab9, #003973) !important;
        }

        h4 {
            color: #FFFFFF !important;
        }

        .widget-body {
            background-color: #e0e0e0;
        }

        .table tr:nth-child(even) {
            background: #e0e0e0 !important;
        }

        .table tr:nth-child(odd) {
            background: #e0e0e0 !important;
        }

        /*.table tr:nth-child(odd) {background: #e0e0e0!important; }*/
        .addontable tr:nth-child(even) {
            background: #e0e0e0 !important;
        }

        .addontable tr:nth-child(odd) {
            background: #e0e0e0 !important;
        }

        .widget-main {
            background: #e0e0e0 !important;
        }

        .close {
            zoom: 2;
        }

        #callus-734 {
            --call-us-form-header-background: #71d307;
            --call-us-header-text-color: #ffffff;
            --call-us-form-width: 250px;
            --call-us-form-height: 470px;
        }
    </style>


    <script type="text/javascript" src="js/jquery-1.8.3.js"></script>
    <script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="themes/font-awesome/css/font-awesome.min.css" />

    <!--[if IE 7]>
		  <link rel="stylesheet" href="themes/font-awesome/css/font-awesome-ie7.min.css" />
		<![endif]-->

    <!--page specific plugin styles-->

    <link rel="stylesheet" href="themes/css/prettify.css" />

    <!--fonts-->
    <?php if ($_SESSION['strUser'] != '3000098') { ?>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300" />
    <?php } ?>
    <!--ace styles-->

    <link rel="stylesheet" href="themes/css/w8.css" />
    <link rel="stylesheet" href="themes/css/w8-responsive.css" />
    <link rel="stylesheet" href="themes/css/w8-skins.css" />


    <!--[if lte IE 8]>
		  <link rel="stylesheet" href="themes/css/ace-ie.min.css" />
		<![endif]-->

    <!--inline styles if any-->
    <script type="text/javascript">
        window.jQuery || document.write("<script src='themes/js/jquery-1.9.1.min.js'>" + "<" + "/script>");
    </script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="themes/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/locales/bootstrap-datepicker.th.js"></script>
    <link type="text/css" rel="stylesheet" media="all" href="chat/css/chat.css" />

    <script src="js/callus_out.js" charset="UTF-8"></script>
    <script type="text/javascript" src="js/sweetalert2.js"></script>
    <style>
        /*html,body{filter:grayscale(30%);}*/
    </style>
    <!-- <script type="text/javascript" src="js/select2.min.js"></script> -->

    <call-us id="callus-734" style="position: fixed; bottom:20px; z-index:9999;right:65px;" phonesystem-url="https://4insurance.3cx.asia:5001/" party="click2talk168898" minimized="true" allow-call="true" allow-video="true" allow-soundnotifications="true" invite-message="ยินดีให้บริการค่ะ คุณสามารถโทรหรือแชท สอบถามกับเจ้าหน้าที่ได้โดยไม่เสียค่าโทร" window-title="ติดต่อสอบถาม โทรฟรี" operator-name="เจ้าหน้าที่" window-icon="" operator-icon="" popout="false" authentication="name" enable-onmobile="true" minimized-style="bubble"></call-us>
</head>

<body>

    <style>
        .sk-cube-grid {
            width: 80px;
            height: 80px;
            margin: 0px auto;
        }

        .sk-cube-grid .sk-cube {
            width: 33.333333%;
            height: 33.333333%;
            background-color: #5984b1;
            float: left;
            -webkit-animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out;
            animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out;
        }

        .sk-cube-grid .sk-cube1 {
            -webkit-animation-delay: 0.2s;
            animation-delay: 0.2s;
        }

        .sk-cube-grid .sk-cube2 {
            -webkit-animation-delay: 0.3s;
            animation-delay: 0.3s;
        }

        .sk-cube-grid .sk-cube3 {
            -webkit-animation-delay: 0.4s;
            animation-delay: 0.4s;
        }

        .sk-cube-grid .sk-cube4 {
            -webkit-animation-delay: 0.1s;
            animation-delay: 0.1s;
        }

        .sk-cube-grid .sk-cube5 {
            -webkit-animation-delay: 0.2s;
            animation-delay: 0.2s;
        }

        .sk-cube-grid .sk-cube6 {
            -webkit-animation-delay: 0.3s;
            animation-delay: 0.3s;
        }

        .sk-cube-grid .sk-cube7 {
            -webkit-animation-delay: 0s;
            animation-delay: 0s;
        }

        .sk-cube-grid .sk-cube8 {
            -webkit-animation-delay: 0.1s;
            animation-delay: 0.1s;
        }

        .sk-cube-grid .sk-cube9 {
            -webkit-animation-delay: 0.2s;
            animation-delay: 0.2s;
        }

        @-webkit-keyframes sk-cubeGridScaleDelay {

            0%,
            70%,
            100% {
                -webkit-transform: scale3D(1, 1, 1);
                transform: scale3D(1, 1, 1);
            }

            35% {
                -webkit-transform: scale3D(0, 0, 1);
                transform: scale3D(0, 0, 1);
            }
        }

        @keyframes sk-cubeGridScaleDelay {

            0%,
            70%,
            100% {
                -webkit-transform: scale3D(1, 1, 1);
                transform: scale3D(1, 1, 1);
            }

            35% {
                -webkit-transform: scale3D(0, 0, 1);
                transform: scale3D(0, 0, 1);
            }
        }

        .loading-background {
            position: fixed;
            left: 0px;
            right: 0px;
            top: 0px;
            bottom: 0px;
            z-index: 10;
            width: 100%;
            height: 100%;
            background-color: #111111b8;
        }

        .loading-icon {
            margin-top: 22.5%;
            margin-bottom: 20%;
        }

        /* width */
        ::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
    <!--loadding Icon DIV-->
    <div class='loading-background' style='display:none; z-index:9999;' id="loadingIcon">
        <div class="sk-cube-grid loading-icon">
            <div class="sk-cube sk-cube1"></div>
            <div class="sk-cube sk-cube2"></div>
            <div class="sk-cube sk-cube3"></div>
            <div class="sk-cube sk-cube4"></div>
            <div class="sk-cube sk-cube5"></div>
            <div class="sk-cube sk-cube6"></div>
            <div class="sk-cube sk-cube7"></div>
            <div class="sk-cube sk-cube8"></div>
            <div class="sk-cube sk-cube9"></div>
        </div>
    </div>
    <!--loadding Icon DIV-->
    <div class="navbar ">
        <!-- <?php if ($_GET['log'] == 'sip') {
                    $color_title = "background-image: linear-gradient(to bottom right,#0D71BA, #29AAE2);";
                } else {
                    $color_title = "background-image: url('images/header_bg.jpg');";
                }
                ?> -->
        <div class="navbar-inner" style="height:70px;">
            <div class="container-fluid" style="margin-top: 5px;">
                <a href="#">
                    <small>
                        <?php if (!empty($_SESSION['logo_images'])) { ?>
                            <div style="margin-top: 22px;display: inline-block;width: 84px;height: 84px;">
                                <center>
                                    <font style='font-size: 40pt;color:#FFFFFF;'>SIP</font>
                                </center>
                            </div>
                            <!--<i class="icon"><img src="<?php echo $_SESSION['logo_images']; ?>"   border="0" alt="" style="height:70px; margin-left:-20px;"></i>-->
                        <?php } else { ?>
                            <!-- <i class="icon"><img src="./form_login/images/logo viriyah suzuki web.png" width="220"></i> -->
                            <img src="img4/AIM.png" width="100px" alt="">
                        <?php } ?>
                    </small>
                </a>
                <!--/.brand-->

                <ul class="nav ace-nav pull-right">

                    <li class="light-blue user-profile" style="width:auto;">
                        <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
                            <img class="nav-user-photo" src="themes/images/user.png" alt="Jason's Photo" />
                            <span id="user_info">
                                <small>Welcome</small>
                                <?php
                                if (!empty($_SESSION["uname"])) {
                                    echo $_SESSION["uname"] . ' ' . $_SESSION["ulname"];
                                } else {
                                    echo $_SESSION["strName"];
                                }

                                ?>
                            </span>

                            <i class="icon-caret-down"></i>
                        </a>

                        <ul class="pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer" id="user_menu">
                            <!--<li>
									<a href="#">
										<i class="icon-cog"></i>
										Settings
									</a>
								</li>

								<li>
									<a href="#">
										<i class="icon-user"></i>
										Profile
									</a>
								</li>

								<li class="divider"></li>-->

                            <li>
                                <?php if ($_GET['log'] == 'sip') { ?>
                                    <a href="#" onclick="load_page('pages/load_logout.php?log=<?php echo $_GET['log']; ?>');"><i class="icon-off"></i>Logout</a>
                                <?php } else { ?>
                                    <a href="#" onclick="load_page('pages/load_logout.php');"><i class="icon-off"></i>Logout</a>
                                <?php } ?>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!--/.w8-nav-->
            </div>
            <!--/.container-fluid-->
        </div>
        <!--/.navbar-inner-->
    </div>

    <div class="container-fluid" id="main-container">
        <a id="menu-toggler" href="#">
            <span></span>
        </a>

        <div id="sidebar">
            <div id="sidebar-shortcuts">
                <div id="sidebar-shortcuts-large">
                    <button class="btn btn-small btn-success">
                        <i class="icon-signal"></i>
                    </button>

                    <button class="btn btn-small btn-info">
                        <i class="icon-pencil"></i>
                    </button>

                    <button class="btn btn-small btn-warning">
                        <i class="icon-group"></i>
                    </button>

                    <button class="btn btn-small btn-danger">
                        <i class="icon-cogs"></i>
                    </button>
                </div>

                <div id="sidebar-shortcuts-mini">
                    <span class="btn btn-success"></span>

                    <span class="btn btn-info"></span>

                    <span class="btn btn-warning"></span>

                    <span class="btn btn-danger"></span>
                </div>
            </div>
            <!--#sidebar-shortcuts-->

            <?php include "menu.php"; ?>

            <div id="sidebar-collapse">
                <i class="icon-double-angle-left"></i>
            </div>
        </div>


        <div id="main-content" class="clearfix">
            <div id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i> <?php echo $_SESSION["strUser"]; ?> :
                        <!-- <?php echo $_SESSION; ?> -->
                        <?php echo $_SESSION["strUser"]; ?>
                        <span class="divider">
                            <i class="icon-angle-right"></i>
                        </span>
                    </li>
                    <li class="active"><span style="color:#008AE6;font-weight:bold" id="txt_nlink">หน้าแรก</span></li>
                </ul>
                <b><span>Ext. <?php echo $_SESSION['telephone']; ?> (เบอร์ภายในของท่าน)</span></b>
                <!--.breadcrumb-->

                <?php
                $sqlAct1 = "SELECT act_no FROM z_act WHERE act_use='" . $_SESSION["strUser"] . "' and act_status = '1'";

                $resultAct1 = PDO_CONNECTION::fourinsure_mitsu()->query($sqlAct1);

                $sqlAct2 = "SELECT act_no FROM z_act WHERE act_use='" . $_SESSION["strUser"] . "' and act_status = 'C' OR act_status = 'R'";

                $resultAct2 = PDO_CONNECTION::fourinsure_mitsu()->query($sqlAct2);

                if ($_SESSION["strUser"] != 'admin' && $_SESSION['claim'] != 'ADMIN') {
                    if (!empty($resultAct1)) {
                        $fetcharr_act = $resultAct1->rowCount();
                    } else {
                        $fetcharr_act = '0';
                    }
                    if (!empty($resultAct2)) {
                        $fetcharr_act_2 = $resultAct2->rowCount();
                    } else {
                        $fetcharr_act_2 = '0';
                    }
                } else {
                    $fetcharr_act = '0';
                    $fetcharr_act_2 = '0';
                }
                ?>
                <?php if ($_SESSION["saka"] == '113' || $_SESSION["strUser"] == 'admin' || $_SESSION['claim'] == 'ADMIN') { ?>
                    <div id="nav-search">
                        <form class="form-search">
                            <font color="339900">พรบ. คงเหลือ = <?php echo $fetcharr_act; ?> ฉบับ</font> | <font color="ff0000">ชำรุดเสียหาย/ยกเลิก = <?php echo $fetcharr_act_2; ?> ฉบับ</font>
                        </form>
                    </div>
                    <!--#nav-search -->
                <?php } ?>
            </div>
            <div id="page-content" class="clearfix">
                <div class="page-header position-relative">
                    <h1>
                        สถานะแจ้งประกัน
                        <small>
                            <i class="icon-double-angle-right"></i>
                            24 Hr.
                        </small>
                    </h1>
                </div>
                <!--/.page-header-->


            </div>
            <!--/#page-content-->


        </div>
        <!--/#main-content-->
    </div>
    <!--/.fluid-container#main-container-->

    <a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse">
        <i class="icon-double-angle-up icon-only bigger-110"></i>
    </a>

    <!--basic scripts-->


    <script src="themes/js/jquery.ui.touch-punch.min.js"></script>

    <script src="themes/js/jquery.slimscroll.min.js"></script>
    <script src="themes/js/jquery.easy-pie-chart.min.js"></script>
    <script src="themes/js/jquery.sparkline.min.js"></script>

    <script src="themes/js/jquery.flot.min.js"></script>
    <script src="themes/js/jquery.flot.pie.min.js"></script>
    <script src="themes/js/jquery.flot.resize.min.js"></script>

    <!--w8 scripts-->


    <!-- 		<?php
                    $date_m = date("m");
                    $date_d = date("d");
                    if ($date_m == 12 && $date_d >= 06 && $date_d <= 25) {
                    ?>
			<script type="text/javascript" src="js/effect_merry_hristmas.js"></script>
			<?php
                    }
            ?> -->
    <script src="themes/js/w8-elements.min.js"></script>
    <script src="themes/js/w8.min.js"></script>
    <script src='highcharts/highcharts.js' type='text/javascript'></script>
    <script src='highcharts/exporting.js' type='text/javascript'></script>
    <!--inline scripts related to this page-->
    <script type="text/javascript">
        $(document).ready(function() {
            <?php if ($_GET['log'] == 'sip') { ?>
                $('#page-content').html(
                    '<p><br><br><center><img src="img4/loadingIcon.gif"  /> <img src="img4/loadingIcon.gif"  /> <img src="img4/loadingIcon.gif"  /></center></p>'
                ).load('pages/form_stock_suzuki.php', 'สต๊อกรถยนต์/สั่งซื้อรถยนต์');
            <?php } else { ?>
                $('#page-content').html(
                    '<p><br><br><center><img src="img4/loadingIcon.gif"  /> <img src="img4/loadingIcon.gif"  /> <img src="img4/loadingIcon.gif"  /></center></p>'
                ).load("home.php");
            <?php } ?>
        });
        $('#page-content').css({
            'background-color': '#efedef'
        });
    </script>

    <?php // include('incChat.php');
    ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-112024909-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-112024909-1');
    </script>
</body>

</html>