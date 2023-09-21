<?php session_start(); // this MUST be called prior to any output including whitespaces and line breaks!
  // include "pages/check-ses.php"; 

  include "../inc/connectdbs.pdo.php"; 
$GLOBALS['ct_recipient']   = 'supinya@my4ib.com'; // Change to your email address!
$GLOBALS['ct_msg_subject'] = 'Securimage Test Contact Form';

$GLOBALS['DEBUG_MODE'] = 1;
?>
<!DOCTYPE HTML>
<html dir="ltr" lang="en-US" style='background-image: linear-gradient(to bottom right,#007C99, #0B2143);'>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="https://fonts.googleapis.com/css?family=Barlow:700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="images/logo_sip.jpg" />
    <title>Sale Intelligent Platform</title>
    <link rel="stylesheet" href="form_login/style.css" type="text/css" />
    <script type="text/javascript" src="form_login/jquery-1.7.1.min.js"></script>



    <script type="text/javascript" src="form_login/selectivizr.js"></script> 
        <script type="text/javascript" src="js/jquery-1.8.3.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/cupertino/jquery-ui-1.9.2.custom.min.css" />

    <link rel="stylesheet" href="form_login/css_popup/style.css">
       <!-- <script src="js/snow-background.js"></script>-->
        <script>
          /*  window.onload = function() {
              try {
                snow.count = 50;   // number of flakes
                snow.delay = 20;   // timer interval
                snow.minSpeed = 2; // minimum movement/time slice
                snow.maxSpeed = 5; // maximum movement/time slice
                snow.start();
              } catch(e) {
                // no snow :(
              }
            };*/
           
        </script>
         <!--<link rel="stylesheet" href="css/snowcss/style.css">-->
        <script>
      $(function() 
      {
        $( "#dialog" ).dialog({
        resizable: false,
        width:830,
        height:650,
        modal: true
        });
      });
    </script>

    <link rel="stylesheet" type="text/css" href="css/select2.css" />
    <script type="text/javascript" src="js/select2.min.js"></script>
    <style>
      .form-control {
  display: block;
  width: 100%;
  height: @input-height-base; // Make inputs at least the height of their button counterpart (base line-height + padding + border)
  padding: @padding-base-vertical @padding-base-horizontal;
  font-size: @font-size-base;
  line-height: @line-height-base;
  color: @input-color;
  background-color: @input-bg;
  background-image: none; // Reset unusual Firefox-on-Android default style; see https://github.com/necolas/normalize.css/issues/214
  border: 1px solid @input-border;
  border-radius: @input-border-radius; // Note: This has no effect on <select>s in some browsers, due to the limited stylability of <select>s in CSS.
  .box-shadow(inset 0 1px 1px rgba(0,0,0,.075));
  .transition(~"border-color ease-in-out .15s, box-shadow ease-in-out .15s");
  .form-control-focus();

}

    </style>
         <style>
            /*html,body{filter:grayscale(30%);}*/
/*            .bgNew{
                        position:absolute;
                        top:10px;
                        right:20px;
                        width:100px;
                        height:200px;
                        background:url('form_login/images/ribbon.png');
                        
                        
                    }*/
                    .bgNew{
                        position:absolute;
                        top:10px;
                        right:20px;
                        width:60px;
                        height:200px;
                        background:url('form_login/images/ribbon.png') no-repeat;
                        /*transform: rotate(45deg);*/
                        
                    }
          ////////////////////////////////////////////////////////////////////////////////
          body{
 
}
/* customizable snowflake styling */
.snowflake {
  color: #fff;
  font-size: 1em;
  font-family: Arial;
  text-shadow: 0 0 1px #000;
}

@-webkit-keyframes snowflakes-fall{0%{top:-10%}100%{top:100%}}@-webkit-keyframes snowflakes-shake{0%{-webkit-transform:translateX(0px);transform:translateX(0px)}50%{-webkit-transform:translateX(80px);transform:translateX(80px)}100%{-webkit-transform:translateX(0px);transform:translateX(0px)}}@keyframes snowflakes-fall{0%{top:-10%}100%{top:100%}}@keyframes snowflakes-shake{0%{transform:translateX(0px)}50%{transform:translateX(80px)}100%{transform:translateX(0px)}}.snowflake{position:fixed;top:-10%;z-index:9999;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;cursor:default;-webkit-animation-name:snowflakes-fall,snowflakes-shake;-webkit-animation-duration:10s,3s;-webkit-animation-timing-function:linear,ease-in-out;-webkit-animation-iteration-count:infinite,infinite;-webkit-animation-play-state:running,running;animation-name:snowflakes-fall,snowflakes-shake;animation-duration:10s,3s;animation-timing-function:linear,ease-in-out;animation-iteration-count:infinite,infinite;animation-play-state:running,running}.snowflake:nth-of-type(0){left:1%;-webkit-animation-delay:0s,0s;animation-delay:0s,0s}.snowflake:nth-of-type(1){left:10%;-webkit-animation-delay:1s,1s;animation-delay:1s,1s}.snowflake:nth-of-type(2){left:20%;-webkit-animation-delay:6s,.5s;animation-delay:6s,.5s}.snowflake:nth-of-type(3){left:30%;-webkit-animation-delay:4s,2s;animation-delay:4s,2s}.snowflake:nth-of-type(4){left:40%;-webkit-animation-delay:2s,2s;animation-delay:2s,2s}.snowflake:nth-of-type(5){left:50%;-webkit-animation-delay:8s,3s;animation-delay:8s,3s}.snowflake:nth-of-type(6){left:60%;-webkit-animation-delay:6s,2s;animation-delay:6s,2s}.snowflake:nth-of-type(7){left:70%;-webkit-animation-delay:2.5s,1s;animation-delay:2.5s,1s}.snowflake:nth-of-type(8){left:80%;-webkit-animation-delay:1s,0s;animation-delay:1s,0s}.snowflake:nth-of-type(9){left:90%;-webkit-animation-delay:3s,1.5s;animation-delay:3s,1.5s}
/* Demo Purpose Only*/
.demo {
  font-family: 'Raleway', sans-serif;
  color:#fff;
    display: block;
    margin: 0 auto;
    padding: 15px 0;
    text-align: center;
}
.demo a{
  font-family: 'Raleway', sans-serif;
color: #000;    
}

    </style>
  </head>
  <body >
<!-- POPUP Modal -->
<?php

$date_m = date("m");
$date_d = date("d");
$dateAll = date("d H:i:s");
$popset = 'OFF';
if($date_m ==03 && $date_d >=01 && $date_d <=03  && $dateAll >= "01 09:00:01" && $_SESSION["OFF_UP"] != "OFF_UP"  && $popset=="ON"){
  ?>  
  <a href="#"  id="btnpopup" style="display:none;" data-modal="#modal" class="modal__trigger"><span>Modal 1</span></a>
<!-- Modal -->
  <div id="modal" class="modal modal--align-top modal__bg" role="dialog" aria-hidden="true">
    <div class="modal__dialog">
      <div class="modal__content">
        <img src="images/restore_backup.jpg" border="2" width="100%" height="100%">
        <!-- modal close button -->
        <a href="" class="modal__close demo-close">
          <svg class="" viewBox="0 0 24 24"><path d="M19 6.41l-1.41-1.41-5.59 5.59-5.59-5.59-1.41 1.41 5.59 5.59-5.59 5.59 1.41 1.41 5.59-5.59 5.59 5.59 1.41-1.41-5.59-5.59z"/><path d="M0 0h24v24h-24z" fill="none"/></svg>
        </a> 
      </div>
<div style="color: #fff; font-size: 12px; margin-top: 1.5px; text-align:right; zoom: 1.2;"><input name="status_box" id="status_box" type="checkbox" value="OFF_UP"  onclick="myFunction()">ไม่แสดงหน้านี้อีก
</div><!-- <p id="demo"></p> -->

    </div>
  </div>

<?
}
?> 
<!-- END POPUP Modal -->
<style>
body
{
	font-family: 'Barlow', sans-serif;
}
  .sip-img-background
	{
	  background-image:url("sip_images/SIP_background1.png");width:960px;ackground-repeat: no-repeat;background-size: 1000px 550px;
	  background-color: #fff0 !important;
	}
	.sip_color_title
	{
		font-size: 30pt;
		color:#2BA9E1;
	
	}
	.sip_color_title1
	{
		font-size: 20pt;
		color:#FFFFFF;

		opacity: 0.8; 
	
	}
	.sip_color_title2
	{
		font-size: 10pt;
		color:#FFFFFF;
		margin-top:7px;
		opacity: 0.8; 
	
	}
	.sip_button1
	{
		font-size: 40pt;
		color:#FFFFFF;
	
	}
	.sip_input1
	{
		background-color:#2BA9E1;
		font-size:20px;
		width:150px;
		display:block;
		margin-bottom:8px;
		padding-left:8px;
		color:#FFFFFF;
	}
	.sip_button2
	{
		font-size: 16pt;
		color:#FFFFFF;
		background-color:#2BA9E1;
		padding:3px;
		cursor: pointer;
	}
	.sip_button2:hover
	{
		font-size: 16pt;
		color:#FFFFFF;
		background-color:#007C99;
		
		padding:3px;
		
	}
	.sip_button2:active
	{
		font-size: 16pt;
		color:#FFFFFF;
		background-color:#0B2143;
		padding:3px;
		
	}
.sip_input1::placeholder {
  color: #FFFFFF;
  opacity: 0.5; /* Firefox */
}
</style>
  <?php
$date_m = date("m");
$date_d = date("d");
if($date_m == 12 && $date_d >=19 && $date_d <=25){
  ?>  
          <div class="snowflakes" aria-hidden="true">
  <div class="snowflake" style='color: #fff !important'>
  ❅
  </div>
  <div class="snowflake" style='color: #fff !important'>
  ❅
  </div>
  <div class="snowflake" style='color: #fff !important'>
  ❆
  </div>
  <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
  <div class="snowflake" style='color: #fff !important'>
  ❅
  </div>
  <div class="snowflake" style='color: #fff !important'>
  ❆
  </div>
  <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
  <div class="snowflake" style='color: #fff !important'>
  ❅
  </div>
  <div class="snowflake" style='color: #fff !important'>
  ❆
  </div>
  <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
    <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
    <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
    <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
    <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
  <div class="snowflake" style='color: #fff !important'>
  ❅
  </div>
   <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
     <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
     <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
     <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
     <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
     <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
  <div class="snowflake" style='color: #fff !important'>
  ❅
  </div>
     <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
     <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
     <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
     <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
     <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
     <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
  <div class="snowflake" style='color: #fff !important'>
  ❅
  </div>
     <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
     <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
     <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
     <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
     <div class="snowflake" style='color: #fff !important'>
  ❄
  </div>
</div> 
<?
}
?> 
    <!--<div id="dialog" title="Promotion Suzuki!!!">
              <img src="images/HNY2019.jpg" width="800" />
            </div>-->
                <!--<div class="bgNew"></div>-->
    <div  class="bgNewLogin">
        <div class="boxHead">
          
        </div>

        <div class="newW sip-img-background">
		
		<div style='width:600px;margin-left:80px;margin-top:30px;display:inline-block;'>
		<font class='sip_color_title'>Sale Intelligent Platform</font>
		&nbsp;&nbsp;&nbsp;
		<div style='display: inline-block;width: 84px;height: 54px;background-color: #2BA9E1;'><center><font class='sip_button1'>SIP</font></center></div>
		</div>
		
		<div style='margin-top:60px;width:150px;float:right;display: inline-block;'>
		
		<form   id="contact_form" method="POST" onsubmit="return processForm();" action='ChkLog.php?log=sip'>
		<center>
		<input type="hidden" name="optClaim" id="optClaim" value='1'>
		<input type='text' class='sip_input1' name="f_user" id='f_user' placeholder='User'>
		<input type='password' class='sip_input1' name="f_pass" id='f_pass'  placeholder='Pass'>
		<input class="sip_button2" id="btnSub" type="submit" name="submit" value="Login">
		</center>
		</form>
		
		</div>
		<div style='margin-top:210px; margin-left:80px;'>
		<font class='sip_color_title1' style='display:block;'>Sale Intelligent Platform</font>
		<font class='sip_color_title2' style='display:block;'>
		ระบบปฎิบัติการขายอัจฉริยะ
		</font>
		</div>
        </div>   
        <div style="clear:both;"></div>
        <div class="boxFoot">
           <!-- <img src="form_login/images/boxfoot.png"> -->
      <font color='WHITE'></font>
        </div>
        </div>
    <script type="text/javascript">
      if(navigator.userAgent.indexOf('Chrome') < 0) {
        //window.location.href = "error-browser.php";
        // $('form').hide();
        // $('.error-browser').show();
        //document.getElementById('frmLogin').style.display = "none";
        document.getElementById('error-browser').style.display = "";
      }
    </script>
<?php $pop = 0;
if($pop=='1'){ ?>
    <script src="bootstrap/js/bootstrap.min.js"></script>
   <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<style type="text/css">
          input{height:16px !important;padding:1px !important;}
          input[type="submit"]{width:95px !important;height:73px !important;}
        </style>
<a id="popUP" data-toggle="modal" href="images/popholiday.jpg" aria-hidden="true"   data-target="#modal"></a>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="min-width:700px;max-width:800px;" >
     <div class="modal-dialog">
         <div class="modal-content">
             <button type="button" class="close" id="close" style="position:absolute;right:0px;font-size:30px;" data-dismiss="modal" aria-hidden="true">&times;</button>
             <img style="cursor:pointer;" src="images/popholiday.jpg" onclick="$('#close').trigger('click');">
         </div><!-- /.modal-content -->

     </div><!-- /.modal-dialog -->
 </div>
  <!-- Modal -->

 <script type='text/javascript'>
    $(document).ready(function(){
        $('#popUP').trigger("click");
    });
$(document).on('click','a[data-toggle=modal]', function() {
       // event.preventDefault();
        var $modal=$($(this).data('target'));
        $('.modal-body',$modal).empty();
        $modal.show();
        $('.modal-body',$modal).load($(this).attr('href'));
});

</script>
<?php } 

ob_end_flush();
?>

  </body>
</html>
<script  src="captcha/jquery-1.10.1.min.js"></script>
<script type="text/javascript">
$("label").hide();
$("#captcha_code").attr('placeholder','พิมพ์ตัวอักษรตามรูปภาพ');
$("#captcha_code").attr('style','display:inline-block;margin-left: 157px;margin-top: -50px;position: absolute;display: inline-block;width:155px;height:50px;background-color: #FFFFFF;font-size:15px; padding: 0px 17px;');
$("#captcha_image_audio_controls").attr('style','width:155px;');
    $.noConflict();
    function reloadCaptcha()
    {
        jQuery('#siimage').prop('src', 'captcha/securimage_show.php?sid=' + Math.random());
    }

    function processForm()
    {
       if(jQuery('#f_user').val()=='')
	   {
		   alert("กรุณาคีย์ Username ด้วยครับ");
		   jQuery('#f_user').focus();
		   return false;
	   }
	    if(jQuery('#f_pass').val()=='')
	   {
		   alert("กรุณาคีย์ Password ด้วยครับ");
		   jQuery('#f_pass').focus();
		   return false;
	   }
    }
</script>
<script>
  function backsearch(){

    $('#frmcheck').css('display','');
    $('#frmcheck_result').css('display','none');
  }
  function fnccheckacc(){
    if($("#cartype").val()=='0')
    {
      alert('กรุณาเลือกการใช้งานด้วยครับ');
      $("#cartype").focus();
      return false;
    }
    if($("#mo_car").val()=='0')
    {
      alert('กรุณาเลือกรุ่นรถด้วยครับ');
      $("#mo_car").focus();
      return false;
    }
    if($("#mo_car_sub").val()=='0')
    {
      alert('กรุณาเลือกรุ่นย่อยด้วยครับ');
      $("#mo_car_sub").focus();
      return false;
    }
    if($("#id_acc").val()=='0')
    {
      alert('กรุณาเลือกอุปกรณ์ตกแต่งด้วยครับ');
      $("#id_acc").focus();
      return false;
    }
    var TRADD = $('#frmcheck_result');
    TRADD.css('display','none');
    TRADD.empty();

    var _select = '';
    var CALLLIST = {
          type: "POST",
          dataType: "json",
          url: "ajax/Ajax_More.php",
         data: {callajax:'COST_NEW_LOGIN',
              countmore:'0',
              cartype:$("#cartype").val(),
              mo_car:$("#mo_car").val(),
              type:_select[1],
              id_acc:$("#id_acc").val(),
              mo_car_sub:$("#mo_car_sub").val()
        },
        success: function(msg) {
          var returnedArray = msg;
          
          
          if(returnedArray!=null){
           $('#frmcheck').css('display','none');
              TRADD.css('display','');
              TRADD.append("<div style='padding:10px 0px;width:100%;text-align:center;font-weight:700;'>ผลการเช็คเบี้ย</div><hr>");
              TRADD.append("<div style='width:20%;float:left;font-weight:700;'>รุ่นรถ</div><div style='width:30%;float:left'>: " + $("#mo_car option:selected").text() + "</div>");
              TRADD.append("<div style='width:20%;float:left;font-weight:700;'>รุ่นย่อย</div><div style='width:30%;float:left'>: " + $("#mo_car_sub option:selected").text() + "</div>");
      TRADD.append("<div style='width:100%;float:left;padding:5px 0px;'><font style='font-weight:700;'>อุปกรณ์ตกแต่งเพิ่มเติม </font>: "+ $("#id_acc option:selected").text() +"</div><div style='clear:both;height:10px;'></div>");
       
        TRADD.append("<div style='color:#FFFFFF;width:40%;float:left;text-align:center;padding:10px 0px 10px 0px;background:#39729c;border-top-left-radius: 10px;'>ทุน</div><div style='color:#FFFFFF;width:60%;float:left;text-align:left;padding:10px 0px 10px 0px;background:#39729c; border-top-right-radius: 10px;'>เบี้ยอุปกรณ์ตกแต่ง</div>");
            TRADD.append("<div style='clear:both;height:0px;'></div><div style='border-style:none solid none solid;border-width:2px;border-color:#39729c;'>");
      if(returnedArray[0].status_free=='Y')
      {
        TRADD.append("<div style='border-left:solid 3px #39729c;border-right:solid 3px #39729c; #padding:1px;border-bottom:dotted thin #39729c;position:relative;'><div style='width:100%;float:left;text-align:center;padding:10px 0px 10px 0px;'><font size='4' color='red'>" + returnedArray[0].name + "</font></div><div style='clear:both;'></div></div>");
      }
      else
      {
      for (i = 0; i < returnedArray.length; i++) {
              TRADD.append("<div style='border-left:solid 3px #39729c;border-right:solid 3px #39729c; #padding:1px;border-bottom:dotted thin #39729c;position:relative;'><div style='width:40%;float:left;text-align:center'>" + returnedArray[i].name + "</div><div style='width:60%;float:left;text-align:left'>" + returnedArray[i].price + "</div><div style='clear:both;'></div></div>");
             
            }
      }
      TRADD.append("</div>");
            TRADD.append("</div><div style='clear:both;height:10px;'></div>");
             TRADD.append('<div style="margin-right:10px;padding-top:0px;"><div href="javascript:0;" style="float:right;" class="btnBack" onclick="backsearch();"></div></div>');
       
      }else{
            $('#frmcheck').css('display','');
            TRADD.css('display','none');
            return false;
          }
     
        }
      };
      $.ajax(CALLLIST);

  }

$("#mo_car_sub").change(function()
{
      var CALLMORE = {
          type: "POST",
          dataType: "json",
          url: "ajax/Ajax_More.php",
          data: {callajax:'MORE_NEW_LOGIN',
          cartype:$("#cartype").val(),
          mo_car:$("#mo_car").val(),
          mo_car_sub:$("#mo_car_sub").val()
        },

        success: function(msg) {
          var returnedArray = msg;
          var TRADD = $('#id_acc');
          if(returnedArray!=null){
            TRADD.html(returnedArray.html_acc);
            TRADD.attr('style','width:320px;');
            TRADD.select2();
          }else{
            return false;
          }
        }
      };
      $.ajax(CALLMORE);

});

$("#cartype").change(function()
{

  var _mocar =  $('#mo_car').val();
  var _cartype = $("#cartype").val();
  var CallCom = {
    type: "POST",
    dataType: "json",
    url: "ajax/Ajax_Car.php",
    data: {callajax:'TYPE',
    br_car:'0'+_cartype},
    success: function(msg) {
      var returnedArray = msg;
      // $("#mo_car").html(returnedArray.mo_sub_show);
      mo_car = $("#mo_car");
      mo_car.empty(); 
      mo_car.append("<option value='0'>--กรุณาเลือก--</option>");
      if(returnedArray!=null){

        for (i = 0; i < returnedArray.length; i++) {
          mo_car.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");

          if($('#cartype').val()==0){
            $("#mo_car").empty(); 
            $("#mo_car").append("<option value='0'>กรุณาเลือก</option>");
            $("#mo_car_sub").empty(); 
            $("#mo_car_sub").append("<option value='0'>กรุณาเลือก</option>");
          }
        }
      }
      

    }
  };
  $.ajax(CallCom);

});


$("#mo_car").change(function()
{

  var _mocar =  $('#mo_car').val();
  var _cartype = $("#cartype").val();
  var CallCom = {
    type: "POST",
    dataType: "json",
    url: "ajax/Ajax_Cost_No_login.php",
    data: {callajax:'START',
    status_sub:'1',
    mo_car:_mocar,
    cartype:_cartype},
    success: function(msg) {
      var returnedArray = msg;
      $("#mo_car_sub").html(returnedArray.mo_sub_show);

    }
  };
  $.ajax(CallCom);

});
var inset=0;
setInterval(function(){
if(inset==0)
{
$('#color_infinity').attr('color','red');
inset++;
}
else
{
  $('#color_infinity').attr('color','black');
inset--;
}

},2000);
</script>

<!-- JS POPUP Modal -->
 <script src="form_login/js_popup/index.js"></script>
 <script type="text/javascript">
$(document).ready(function(){
      $("#btnpopup").find("span").trigger("click");
});

</script>
<script>
function myFunction() {
  //document.getElementById("demo").innerHTML = "off";
 // document.getElementById("demo").$_SESSION['off'];
 window.location.href="login_freedate.php";
                
}
</script>
<!-- END JS POPUP Modal -->


