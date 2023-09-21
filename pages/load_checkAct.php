<?php
include "check-ses.php";
include "../inc/connectdbs.pdo.php";
header('Content-Type: text/html; charset=utf-8');
?>
<link type="text/css" rel="stylesheet" href="assets/css/modal.css">
<link rel="stylesheet" type="text/css" href="data_table/css/jquery.dataTables.min.css">
<style type="text/css">
    body.modal-open .datepicker {
        z-index: 100000 !important;
    }
    body.modal-open {
        overflow: hidden;
    }
    /*.quote.modal {
        position: fixed;
        top: 0px !important;
        left: 0px !important;
        right: 0px !important;
        bottom: 0px !important;
        width: 80% !important;
        height: 100% !important;
        margin: 0px !important;
        padding: 0px !important;
        display: none;
        border-radius: 0px !important;
        border:none;
        overflow: hidden;
    }*/
    
    .quote.modal {
        position: absolute;
        left: auto !important;
        right: auto !important;
        width: 80% !important;
        height: 80% !important;
        margin: 0px auto !important;
        padding: 0px !important;
        display: none;
        border-radius: 0px !important;
        border:none;
        overflow: hidden;
    }

    .quote .modal-dialog {
        position: relative;
        width: 100% !important;
        height: 100% !important;
        margin: 0px auto !important;
        padding: 0px !important;
        border-radius: 0px !important;
    }

    .quote .modal-content {
        position: relative !important;
        margin: 0px auto !important;
        width: 100% !important;
        height: 100% !important;
        max-width: none;
        max-height: none;
        top: 0px !important;
        left: 0px !important;
        right: 0px !important;
        bottom: 0px !important;
    }
    
    .quote .modal-header {

    }

    .quote .modal-title {

    }
    
    .quote .modal-body {
        max-height: 85% !important;
        
    }

    .quote .modal-footer {
        position: absolute !important;
        margin: 0px !important;
        left: 0px !important;
        right: 0px !important;
        bottom: 0px !important;
    left: 0;
    }
    .quote .btn-disable {
        display: none;
    }
    .quote.modal table {
        font-size: 100%;
        font-weight:bold;
        box-shadow:1px 1px 1px 1px #D8D8D8;
    }

    .quote.modal th {
        font-size: 100%;
        background-color:#5098c9; 
        color: #FFFFFF;
    }

    .quote.modal input[value='0.00'] {
        float:right;

    }
    .quote.modal table tr th, .quote.modal table tr td {
        padding: 4px 6px;
        vertical-align: middle;
    }
    .quote .modal tr.info th {
        color: #fff;
        text-shadow: 0 -1px 0 rgba(0,0,0,0.25) !important;
        background-color: #006dcc !important;
        background-image: -moz-linear-gradient(top,#08c,#04c) !important;
        background-image: -webkit-gradient(linear,0 0,0 100%,from(#08c),to(#04c)) !important;
        background-image: -webkit-linear-gradient(top,#08c,#04c) !important;
        background-image: -o-linear-gradient(top,#08c,#04c) !important;
        background-image: linear-gradient(to bottom,#08c,#04c) !important;
        background-repeat: repeat-x !important;
        border-color: #04c #04c #002a80 !important;
        border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25) !important;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff0088cc',endColorstr='#ff0044cc',GradientType=0) !important;
        filter: progid:DXImageTransform.Microsoft.gradient(enabled=false) !important;
    }
    .quote.modal table tr td input[type="text"], .quote.modal table tr th input[type="text"] {
        display: inline-block;
        height: 20px;
        padding: 4px 6px;
        margin-bottom: 0px;
        font-size: 90%;
        line-height: 20px;
        color: #555;
        vertical-align: middle;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }
    .quote.modal table tr td select {
        display: inline-block;
        height: 30px;
        padding: 4px 6px;
        margin-bottom: 0px;
        font-size: 90%;
        line-height: 20px;
        color: #555;
        vertical-align: middle;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }
    .quote.modal table tr th input[type="checkbox"] {
        display: inline-block;
        width: 14px;
        height: 14px;
        margin: 0px;
        margin-top: -4px;
        font-size: 90%;
        line-height: 20px;
        color: #555;
        vertical-align: middle;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }
    .span2 {
        width: 120px;
    }
    *[data-align="right"] {
        text-align: right !important;
    }
    *[data-align="left"] {
        text-align: left !important;
    }
    *[data-align="center"] {
        text-align: center !important;
    }
    .search.modal table {
        font-size: 90%;
    }
    .search.modal table tr th, .search.modal table tr td {
        padding: 4px 6px;
        vertical-align: middle;
    }
    .search.modal {
        width: 60% !important;
        margin-left: -30% !important;
    }

    .search .modal-dialog {
        width: 70% !important;
    }

    .search .modal-content {
        width: auto;
    }
    .search .modal tr.info th {
        color: #fff;
        text-shadow: 0 -1px 0 rgba(0,0,0,0.25) !important;
        background-color: #006dcc !important;
        background-image: -moz-linear-gradient(top,#08c,#04c) !important;
        background-image: -webkit-gradient(linear,0 0,0 100%,from(#08c),to(#04c)) !important;
        background-image: -webkit-linear-gradient(top,#08c,#04c) !important;
        background-image: -o-linear-gradient(top,#08c,#04c) !important;
        background-image: linear-gradient(to bottom,#08c,#04c) !important;
        background-repeat: repeat-x !important;
        border-color: #04c #04c #002a80 !important;
        border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25) !important;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff0088cc',endColorstr='#ff0044cc',GradientType=0) !important;
        filter: progid:DXImageTransform.Microsoft.gradient(enabled=false) !important;
    }
    .search.modal table tr td input[type="text"], .search.modal table tr th input[type="text"] {
        display: inline-block;
        height: 20px;
        padding: 4px 6px;
        margin-bottom: 0px;
        font-size: 90%;
        line-height: 20px;
        color: #555;
        vertical-align: middle;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }
    .search.modal table tr td select {
        display: inline-block;
        height: 30px;
        padding: 4px 6px;
        margin-bottom: 0px;
        font-size: 90%;
        line-height: 20px;
        color: #555;
        vertical-align: middle;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }
    .search.modal table tr th input[type="checkbox"] {
        display: inline-block;
        width: 14px;
        height: 14px;
        margin: 0px;
        margin-top: -4px;
        font-size: 90%;
        line-height: 20px;
        color: #555;
        vertical-align: middle;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }
</style>
<script src="js/js_Insurance_chkAct_02.js" type="text/javascript"></script>

<!--<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
        <script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
        <script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>-->
<style>
    .bgwhite{background:#fff;}
</style>
<div class="row-fluid">
    <div class="alert alert-block alert-danger" align="center"><strong><font color="#FF0000"> เช็คเบี้ย </u>!!!</font></strong></div>
</div>
<div class="widget-header widget-header-flat">
    <h4 class="lighter">
        <i class="icon-signal"></i>
        เช็คเบี้ยออนไลน์
    </h4>
      <div class="widget-toolbar">
        <a href="#" data-action="collapse">
            <i class="icon-chevron-up"></i>
        </a>
    </div>
</div>
<div class="row-fluid bgwhite"  style="padding:20px 0 0 0;">
    <div style="padding:0 10px;">
        <div class="span2"> </div>
        <div class="span4"> 
            <div class="span4">ปีรุ่น</div><div class="vspw8"></div> 
            <div class="span8">
                 <select name="YearCar" id="YearCar" class="form-control">
                    <option value="0">ปีรถ</option>
                    <?php 
                    $y = date('Y');
                    for ($i = 1; $i <= 29; $i++) {
                        $th = $y + 543;
                        ?>
                    <option value="<?=$i;?>"><?=$y;?> = รถอายุ <?=$i;?> ปี</option>
                    <?php $y--; } ?>
                    <?php 
//                    $chkYear = chkYear();
//                    $showY = $chkYear['arrData'];
//                    foreach($showY as $row){
                    ?>
                    <!--<option value="<?=$row['dYear'];?>"><?=$row['dYear'];?></option>-->
                    <?php // } ?>
                </select>
            </div>
        </div>
        <div class="span4">            
            <div class="span4">ประเภทการใช้</div><div class="vspw8"></div> 
            <div class="span8">
                <span id="cartypeDiv">
                <select name="cartype" id="cartype"  class="span7">
                <option value="0">กรุณาเลือก</option>
                </select>
                </span>
            </div> 
        </div>
        <div class="span2"> </div>
        </div>
    
    </div>
        <div class="row-fluid bgwhite">
        <div style="padding:0 10px;">   
        <div class="span2"> </div>
        <div class="span4">
            <div class="span4">ยี่ห้อรถยนต์</div><div class="vspw8"></div>
            <div class="span8">
                    
                    <span id="br_carDiv">
                        <select name="br_car" id="br_car" class="span7" ><option value="0">กรุณาเลือก</option></select>
                    </span>
            </div> 
        </div>
        
        <div class="span4">
            <div class="span4">รุ่น</div>
            <div class="vspw8"></div><div class="span8">
                <select name="mo_car" id="mo_car" class="span5"><option value="0">กรุณาเลือก</option></select>
                <select name="mo_car_sub" id="mo_car_sub" class="span5" style="display:none;"><option value="0">กรุณาเลือก</option></select></span>
            </div> 
        </div>
             <div class="span2"> </div>
    </div>
</div>
         <div class="row-fluid bgwhite" style="padding:10px 0 0 0;">
         <div style="padding:0 10px;">   
             <div class="span2"> </div>
        <div class="span4">
            <div class="span4">ราคารถ&nbsp;</div><div class="vspw8"></div>
            <div class="span8">
                    <input type="text" id="mo_carprice" style="background-color:#6e6e6e; color:#FAFCFE;">                   
            </div> 
        </div>
        <div class="span4">
            <!-- <div class="span4">ปี</div>
            <div class="vspw8"></div><div class="span8">
               <input type="text" id="mo_carprice">
            </div>  -->
        </div>
             <div class="span2"> </div>
        <div class="vspw8"></div>
    </div>
</div>
        


<div class="row-fluid bgwhite">
    <div class="span12"  style="padding:10px;text-align: center;">
        <!-- <input type="hidden" id="mo_carprice"> -->
        <button class="btn btn-small btn-info no-radius" id="searchAct" style="font-size:20px;padding:15px;" onclick="sodata('1');"><span class="hidden-phone">คำนวณเบี้ย</span></button>
    </div>
    <div style="clear:both;border-bottom:solid thin #ccc;"></div>
</div>
<div id="showSearch" class="row-fluid bgwhite">

</div>
</div>

