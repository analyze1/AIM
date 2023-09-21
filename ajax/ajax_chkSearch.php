<?php
//include "../../inc/connectdbs.pdo.php";
include "../inc/connectdbs.pdo.php";

$_contextFour = PDO_CONNECTION::fourinsure_insured();
$cartype = $_POST['cartype'];
$YearCar = $_POST['YearCar'];
$br_car = $_POST['br_car'];
$mo_car = $_POST['mo_car'];
$mocar_price = $_POST['mocar_price'];

function filter_by_value ($array, $index, $value){ 
        if(is_array($array) && count($array)>0)  
        { 
            foreach(array_keys($array) as $key){ 
                $temp[$key] = $array[$key][$index]; 
                 
                if ($temp[$key] == $value){ 
                    $newarray[$key] = $array[$key]; 
                } 
            } 
          } 
      return $newarray; 
    }
?>
<script type="text/javascript" src="assets/js/bootstrap-tooltip.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<!-- <script src="assets/js/bootstrap-datepicker2.js"></script> -->
<!-- <script src="assets/js/bootstrap-select.js"></script> -->
<style>
.nav-tabs>li>a {
    background-color: #555555;
    padding: 10px;
    border-radius: 10px 10px 0px 0px;
    color: #FFFFFF;
    border-style: solid;
    border-color: rgb(236, 170, 30);
    border-width: 2px;
}

.nav-tabs>li>a:hover,
.nav-tabs>li>a:focus {
    background-color: #555555;
    padding: 10px;
    border-radius: 10px 10px 0px 0px;
    color: #999999;
    border-style: solid;
    border-color: rgb(236, 170, 30);
    border-width: 2px;
}

.nav-tabs>.active>a,
.nav-tabs>.active>a:hover,
.nav-tabs>.active>a:focus {
    background: #FFFFFF;
    border-width: 2px;
    border-style: solid;
    border-color: #555555;
    color: #555555;
}

.dialog_renew {
    width: 35%;
    margin-left: -16%;
}

.content_renew {

    margin-left: -50%;
    width: 200%;
}

@media only screen and (max-width: 767px) {
    .dialog_renew {
        margin-left: 27%;
        margin-top: 100px;
    }
}

@media only screen and (max-height: 905px) {
    .modal_body_renew {
        max-height: 500px;
    }
}

@media only screen and (max-height: 685px) {
    .modal_body_renew {
        max-height: 300px;
    }
}

@media only screen and (max-height: 470px) {
    .modal_body_renew {
        max-height: 180px;
    }
}

/*@font-face 
  {
    font-family: 'supermarketregular';
    src: url('font/supermarket/supermarket-webfont.woff2') format('woff2'),
         url('font/supermarket/supermarket-webfont.woff') format('woff'),
         url('font/supermarket/supermarket-webfont.ttf') format('truetype');

  }*/


.font-design,
#tabs,
button,
a {
    font-family: 'angsana_newregular';
}

/*.btn-inverse
{
  font-size:16px !important;
}*/
.border_top {
    padding: 5px;
    border-style: solid;
    border-width: 1px;
    border-color: #eee;
    border-radius: 8px 8px 0px 0px;
    background-color: rgb(250, 250, 250);
    background-image: linear-gradient(rgb(255, 255, 255), rgb(242, 242, 242));
    box-shadow: rgba(0, 0, 0, 0.0627451) 0px 1px 4px;
    background-repeat: repeat-x;
    border-bottom: 1px solid rgb(212, 212, 212);

}

.border_line {
    border-style: solid;
    border-width: 1px;
    border-top: none;
    border-color: #eee;
    background-color: rgb(250, 250, 250);
}

.border_line:hover {
    background-color: #F8F8FF;
}

.design-ti_1 {
    width: 100%;
    height: 45px;
    background-color: #555555;
    background-image: url("images_checklist/title_left_1.png"), url("images_checklist/title_right_1.png");
    background-position: left top, right top;
    background-repeat: no-repeat, no-repeat;
    background-size: 305px, 60px;
    cursor: pointer;

}

.design-ti_2 {
    width: 100%;
    height: 45px;
    background-color: #555555;
    background-image: url("images_checklist/title_left_1.png"), url("images_checklist/title_right_2.png");
    background-position: left top, right top;
    background-repeat: no-repeat, no-repeat;
    background-size: 305px, 5px;


}

.design-ti_3 {

    width: 100%;
    background-color: #555555;
    background-image: url("images_checklist/title_table_1.png");
    background-position: left top;
    background-repeat: no-repeat;
    background-size: 100% 100%;

}

.design-ti_4 {

    width: 100%;

    background-color: #555555;
    background-image: url("images_checklist/title_left_2.png"), url("images_checklist/title_right_2.png");
    background-position: left top, right top;
    background-repeat: no-repeat, no-repeat;
    background-size: 200px 40px, 4px;

}

.design-ti_5 {

    width: 100%;
    height: 40px;
    background-color: #555555;
    background-image: url("images_checklist/title_left_2.png"), url("images_checklist/title_right_2.png");
    background-position: left top, right top;
    background-repeat: no-repeat, no-repeat;
    background-size: 250px 40px, 4px;

}

.color_font_ti {
    text-align: center;
    border-style: none solid none none;
    border-width: 2.5px;
    border-color: #FFFFFF;
    color: #FFFFFF;
    padding: 5px 0px 5px 0px;
    border-radius: 0px !important;
}

.color_font_ti_stop {
    text-align: center;
    color: #FFFFFF;
    padding: 5px 0px 5px 0px;
    border-radius: 0px !important;
}

.color_font_ti-2 {
    text-align: center;
    border-style: none solid none none;
    border-width: 2.5px;
    border-color: #FFFFFF;
    color: #FFFFFF;
    padding: 10px 0px 10px 0px;
    border-radius: 0px !important;
}

.color_font_ti_stop-2 {
    text-align: center;
    color: #FFFFFF;
    padding: 10px 0px 10px 0px;
    border-radius: 0px !important;
}

.color_font_ti-3 {
    text-align: left;
    border-style: none solid none none;
    border-width: 2.5px;
    border-color: #FFFFFF;
    color: #FFFFFF;
    padding: 10px 0px 10px 10px;
    border-radius: 0px !important;
}

.color_font_ti_stop-3 {
    text-align: left;
    color: #FFFFFF;
    padding: 10px 0px 10px 10px;
    border-radius: 0px !important;
}

.color_font_all_border {

    border-color: #555555;
    border-width: 2.5px;
    border-style: solid;
    color: #000000;
    background: #FFFFFF;
    padding: 7px 7px 7px 7px;
    border-radius: 0px !important;
}

.color_font_form {

    border-color: #555555;
    border-width: 2.5px;
    border-style: none solid solid solid;
    color: #000000;
    background: #FFFFFF;
    padding: 7px 7px 7px 7px;
    border-radius: 0px !important;
}

.border-ti_1-1 {
    font-size: 16px;
    text-align: center;
    padding-top: 8px;
    color: #FFFFFF;
    border-style: none solid none none;
    border-width: 2.5px 1.25px 2.5px 2.5px;
    border-color: #FFFFFF;
}

.border-ti_1-2 {
    font-size: 16px;
    text-align: center;
    padding-top: 8px;
    color: #FFFFFF;
    border-style: none none none solid;
    border-width: 2.5px 2.5px 2.5px 1.25px;
    border-color: #FFFFFF;
}

.border-form_1-1 {
    font-size: 16px;
    text-align: center;
    padding-left: 15px;
    color: #000000;
    /* //background:#FFFFFF; */
}

.border-form_1-2 {
    border-style: none none none solid;
    border-width: 2.5px;
    border-color: #555555;
    font-size: 16px;
    text-align: center;
    padding-left: 15px;
    color: #000000;
    /* background:#FFFFFF; */
}

.border-bottom_1-1 {
    border-style: none solid solid solid;
    border-width: 2.5px;
    border-color: #555555;
    background: #FFFFFF;
}

.design-form {
    width: 100%;
    border-radius: 0px 0px 0px 0px;
    padding-top: 5px;
    padding-bottom: 10px;
    background-color: rgb(209, 209, 209);
}

.font-resize-ti {

    font-size: 18px;
    margin-top: 10px;
    margin-left: 10px;
}

.desing-form-insuree {
    width: 95.5%;
    background-color: #FFFFFF;

    border-color: #555555;
    border-style: solid;
}

.design-value-insuree {
    display: inline-block;
    width: 130px;
    height: 130px;
    background: linear-gradient(135deg, #555555 46%, rgb(204, 138, 50) 45.5%, rgb(232, 189, 33) 47.0%, #555555 0%, #555555 49%, #FFFFFF 0%, #FFFFFF 100%);
}

.desize-font-deg {
    width: 200px;
    height: 60px;
    transform: rotate(-45deg);

}

.custom-file-input {
    color: RED;
    font-weight: bold;
}

.custom-file-input::-webkit-file-upload-button {
    visibility: hidden;
}

.custom-file-input::before {
    content: 'เลือกไฟร์';
    color: #fff;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    background-color: #363636;
    background-image: -moz-linear-gradient(top, #444, #222);
    background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#444), to(#222));
    background-image: -webkit-linear-gradient(top, #444, #222);
    background-image: -o-linear-gradient(top, #444, #222);
    background-image: linear-gradient(to bottom, #444, #222);
    background-repeat: repeat-x;
    border-color: #222 #222 #000;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff444444', endColorstr='#ff222222', GradientType=0);
    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
    padding: 8px;

}

.custom-file-input:hover::before {
    background: #444444;
}

.custom-file-input:active::before {
    background: -webkit-linear-gradient(top, #777777, #555555);
}

.borimg-color {
    border-style: solid;
    border-width: 2.5px;
    border-color: #555555;
}

.e-span1 {
    width: 8.33% !important;
}

.e-span2 {
    width: 16.66% !important;
}

.e-span3 {
    width: 25.00% !important;
}

.e-span4 {
    width: 33.33% !important;
}

.e-span5 {
    width: 41.66% !important;
}

.e-span6 {
    width: 50% !important;
}

.e-span8 {
    width: 66.66% !important;
}

.e-span9 {
    width: 75.00% !important;
}

.e-span10 {
    width: 83.33% !important;
}

.e-span12 {
    font-size: 16px;
    padding-left: 0px;
    width: 100% !important;
}

@media only screen and (max-width: 767px) {
    .e-span1 {
        display: block;
        width: 100% !important;
    }

    .e-span2 {
        display: block;
        width: 100% !important;
    }

    .e-span3 {
        display: block;
        width: 100% !important;
    }

    .e-span4 {
        display: block;
        width: 100% !important;
    }

    .e-span5 {
        display: block;
        width: 100% !important;
    }

    .e-span6 {
        display: block;
        width: 100% !important;
    }

    .e-span8 {
        display: block;
        width: 100% !important;
    }

    .e-span9 {
        display: block;
        width: 100% !important;
    }

    .e-span10 {
        display: block;
        width: 100% !important;
    }

    .font-design select {
        display: block;
        width: 100% !important;
    }
}

.bk-event {
    padding-top: 10px;
    background-color: #999999;
    border-style: solid;
    border-width: 2px;
    border-color: #555555;
    border-radius: 10px;
}

.bk-event-2 {
    padding-top: 10px;
    background-color: #CCCCCC;
    border-style: solid;
    border-width: 2px;
    border-radius: 10px 10px 0px 0px;
    border-color: #777777;
}

.font-design input,
.font-design select,
.font-design textarea {
    border-style: solid;
    border-color: #999999;
    border-width: 2px;
}

.font-design input {
    height: 20px;
    margin-bottom: 3px;
}

.font-design select {
    width: 87.5%;
    height: 32px;
    margin-bottom: 3px;
}

.move-icon {
    -webkit-transition-duration: 1s;
    -moz-transition-duration: 1s;
    transition-duration: 1s;
}

.rotate-icon-90 {
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    transform: rotate(-90deg);
}

/*//css tab----------------------------------------------------------------------------------------------------*/

/*- Menu Tabs--------------------------- */
#content {
    background-color: #f5f5f5;
}

#tabs {
    float: left;
    min-width: 935px;
    /* background:#003366  ;*/
    background: -webkit-linear-gradient(#f5f5f5, #ffffff);
    /* For Safari 5.1 to 6.0 */
    background: -o-linear-gradient(#f5f5f5, #ffffff);
    /* For Opera 11.1 to 12.0 */
    background: -moz-linear-gradient(#f5f5f5, #ffffff);
    /* For Firefox 3.6 to 15 */
    background: linear-gradient(#f5f5f5, #ffffff);
    /* Standard syntax (must be last) */
    font-size: 93%;
    line-height: normal;

}

#tabs ul {
    margin: 0;
    padding: 5px 10px 0 5px;
    list-style: none;
}

#tabs li {
    display: inline;
    margin: 0;
    padding: 0;
}

#tabs a {
    float: left;
    margin: 0;
    padding: 0 0 0 1px;
    text-decoration: none;

}

#tabs a span {
    border-width: 2px;
    float: left;
    display: block;
    color: #FFFFFF;
    background-color: #555555;
    /* //background:url("icon/tabright.gif") no-repeat right top; */
    padding: 10px;
    border-radius: 10px 10px 0px 0px;
    color: #FFFFFF;
    border-style: solid;
    border-color: rgb(236, 170, 30);

}

/* Commented Backslash Hack hides rule from IE5-Mac \*/
#tabs a span {
    float: none;
}

/* End IE5-Mac hack */
#tabs a:hover span {
    color: #999999;
}

#tabs a:hover {
    background-position: 0% -42px;
}

#tabs a:hover span {
    background-position: 100% -42px;
}

#tabs #current a {
    background-position: 0% -42px;
}

#tabs #current a span {
    background-position: 100% -42px;
}

#tabs ul li.active a {
    background-position: 0% -42px;
    color: #FF9834;
    font-weight: bold;
}

#tabs ul li.active a span {
    float: left;
    display: block;
    background: #FFFFFF;
    background-position: 0% -42px;
    padding: 5px 15px 15px 6px;
    color: #555555;
    border-width: 2px;
    border-style: solid;
    border-color: #555555;
}

#tabs .texthead {
    color: #333;
    height: 80px;
    margin-top: 0px;
}

#tabs .texthead h1 {
    margin-left: 50px;
    font-size: 16px;
}

#tabs .texthead h2 {
    margin-left: 50px;
    margin-top: -25px;
    padding-bottom: 0px;
    font-size: 16px;
}

#tabs .texthead h3 {
    float: right;
    margin-top: -65px;
    margin-right: 10px;
    font-size: 16px;
}

#tabs .texthead h4 {
    margin-right: 10px;
    margin-top: -10px;
    font-size: 16px;
    text-align: right;

}

.headTab {
    background: #ffffff;
    color: #000;
    padding: 10px;
    cursor: pointer;
}



@media screen and (max-width: 600px) {
    .smartphone-1 table {
        border: 0;
    }

    .smartphone-1 table caption {
        font-size: 1.3em;
    }

    .smartphone-1 table thead {
        border: none;
        clip: rect(0 0 0 0);
        height: 1px;
        margin: -1px;
        overflow: hidden;
        padding: 0;
        position: absolute;
        width: 1px;
    }

    .smartphone-1 table tr {
        border-bottom: 3px solid #ddd;
        display: block;
        margin-bottom: .625em;
    }

    .smartphone-1 table td {
        border-bottom: 1px solid #ddd;
        display: block;
        font-size: .8em;
        text-align: right;
    }

    .smartphone-1 table td:before {
        /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
        content: attr(data-label);
        float: left;
        font-weight: bold;
        text-transform: uppercase;
    }

    .smartphone-1 table td:last-child {
        border-bottom: 0;
    }
}
</style>

<?
$css_margin='margin:0;';
$css_margin_font='margin-top:0px;';
$css_margin_font_tab='margin-left:30px;';
$css_margin_font_tab_right='margin-right:30px; float: right;';
$css_margin_left_resize_ti='margin-left:0px; margin-top:7px; text-align: center; width:300px;';
$css_margin_right_resize_ti='margin:0px;text-align:center;width:30px;height:30px;float: right;color:#FFFFFF;line-height: normal;';
$css_padding_left='padding-left:30px;';
$css_padding_right='padding-right:30px;';
$css_font_right='padding-right:30px;text-align:right';
?>

<div class="row-fluid">
    <div class="span12">
        <div class="widget-box transparent" id="recent-box">
            <div class="widget-header">

                <div class="span12">
                    <div class="widget-toolbar no-border" style="float:left;">
                        <ul class="nav nav-tabs" id="recent-tab">
                            <li class="active">
                                <a data-toggle="tab" href="#1" class="bgblue" id="showP1"
                                    onclick="sodata('1');">ประกันภัยประเภท ชั้น 1</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#2+" class="bggreen" onclick="sodata('2+');">ประกันภัยประเภท
                                    2+</a>
                            </li>

                            <li>
                                <a data-toggle="tab" href="#3" class="bgred" onclick="sodata('3');">ประกันภัยประเภท
                                    3</a>
                            </li>

                            <li>
                                <a data-toggle="tab" href="#3+" class="bgred" onclick="sodata('3+');">ประกันภัยประเภท
                                    3+</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  Test  555-->
<div id='showdata' class="loading-img"></div>

<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<script type="text/javascript">
function sodata(data1) {
    var so = {
        url: "ajax/ajaxtest.php",
        type: 'POST',
        data: {
            type_inform: data1,
            year: $("#YearCar").val(),
            yearcar: $("#YearCar option:selected").text(),
            cartypee: $("#cartype").val(),
            br_car1: $("#br_car").val(),
            mo_car1: $("#mo_car").val(),
            mo_carprice1: $("#mo_carprice").val()
        },
        success: function(mes) {
            $('#showdata').html(mes);
            // $('#showP1').trigger("click");
        }
    };
    $.ajax(so);

}
sodata(1);
</script>

<style type="text/css">
.modal-header h3 {
    margin: 0;
    line-height: 25px;
}

.modal-body {
    position: relative;
    max-height: 600px;
    padding: 7px 7px 0px;
    overflow-y: auto;
}

.modal-form {
    margin-bottom: 4px;
}

.modal-footer {
    padding: 4px 4px 4px;
    margin-bottom: 10;
    text-align: right;
    background-color: #f5f5f5;
    border-top: 1px solid #ddd;
    -webkit-border-radius: 0 0 6px 6px;
    -moz-border-radius: 0 0 6px 6px;
    border-radius: 0 0 6px 6px;
    *zoom: 1;
    -webkit-box-shadow: inset 0 1px 0 #ffffff;
    -moz-box-shadow: inset 0 1px 0 #ffffff;
    box-shadow: inset 0 1px 0 #ffffff;
}
</style>


<div id="story_send" class="modal fade" role="dialog"
    style="display:none; width: 40%; height: 60%; margin-top: -25px; margin-left:-20%;">
    <div class="modal-dialog">

        <!-- Modal content-->

        <div class="modal-header">
            <h3>รายละเอียดความคุ้มครอง
                <button type="button" class="close" data-dismiss="modal">X</button><!-- &times; -->
            </h3>
            <h4 class="modal-title" id="send_title"></h4>
        </div>
        <div class="modal-body" id="send_body" style='background-color:#ffffff;'>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>
    </div>
</div>

<div id="myquotation" class="modal fade" role="dialog"
    style="display:none; width: 70%; height: 72%; margin-top: -40px; margin-left:-35%;">
    <div class="modal-dialog">

        <!-- Modal content-->

        <div class="modal-header">
            <h3>ทำใบเสนอราคา&nbsp;&nbsp;&nbsp
                <button type="button" class="close" data-dismiss="modal">X</button><!-- &times; -->
            </h3>
            <h4 class="modal-title" id="send_title"></h4>
        </div>
        <div class="modal-body" id="data_quote_renew" style='background-color:#ffffff;'>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-inverse" onclick="SaveI();">บันทึก</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>
    </div>
</div>