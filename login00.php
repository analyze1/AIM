<?php session_start(); // this MUST be called prior to any output including whitespaces and line breaks!
  // include "pages/check-ses.php"; 

  include "../inc/connectdbs.pdo.php"; 
$GLOBALS['ct_recipient']   = 'supinya@my4ib.com'; // Change to your email address!
$GLOBALS['ct_msg_subject'] = 'Securimage Test Contact Form';

$GLOBALS['DEBUG_MODE'] = 1;
?>
<!DOCTYPE HTML>
<html dir="ltr" lang="en-US">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="themes/img/VIBM.ico" />
    <title>แบบฟอร์มประกันภัยออนไลน์ MY4IB.COM</title>
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
 .smartfoot{
 	color:#fff;
 	font-size: 16px;
 	text-align: center;
 }

    </style>
  </head>
  <body>
<!-- POPUP Modal วันแรงงาน-->
<?php
 
$date_zone = date("m d");
$date_start = date("d H:i:s");
if($date_zone >="07 15" && $date_zone <="07 16"  && $date_start >= "15 07:00:01" && $_SESSION["OFF_UP"] != "OFF_UP"){
  ?>  
  <a href="#"  id="btnpopup" style="display:none;" data-modal="#modal" class="modal__trigger"><span>Modal 1</span></a>
<!-- Modal -->
  <div id="modal" class="modal modal--align-top modal__bg" role="dialog" aria-hidden="true">
    <div class="modal__dialog">
      <div class="modal__content">
        <img src="images/2562-16-07.jpg" border="0" width="100%" height="100%">
        <!-- modal close button -->
        <a href="" class="modal__close demo-close">
          <svg class="" viewBox="0 0 24 24"><path d="M19 6.41l-1.41-1.41-5.59 5.59-5.59-5.59-1.41 1.41 5.59 5.59-5.59 5.59 1.41 1.41 5.59-5.59 5.59 5.59 1.41-1.41-5.59-5.59z"/><path d="M0 0h24v24h-24z" fill="none"/></svg>
        </a> 
      </div>
<div style="color: #fff; font-size: 12px; margin-top: 1.5px; text-align:right; zoom: 1.2;"><input name="OFF_UP" id="OFF_UP" type="checkbox" value="OFF_UP"  onclick="myFunction()">ไม่แสดงหน้านี้อีก
</div><!-- <p id="demo"></p> -->

    </div>
  </div>

<?
}
?> 
<!-- END POPUP Modal -->

<!-- POPUP Modal วันราชการที่ 10-->
<?php
 
$date_zone2 = date("m d");
$date_start2 = date("d H:i:s");
if($date_zone2 >="07 17" && $date_zone2 <="07 17"  && $date_start2 >= "17 07:30:00" && $_SESSION["OFF_UP"] != "OFF_UP"){
  ?>  
  <a href="#"  id="btnpopup" style="display:none;" data-modal="#modal" class="modal__trigger"><span>Modal 1</span></a>
<!-- Modal -->
  <div id="modal" class="modal modal--align-top modal__bg" role="dialog" aria-hidden="true">
    <div class="modal__dialog">
      <div class="modal__content">
        <img src="images/2562-17-07.jpg" border="2" width="100%" height="100%">
        <!-- modal close button -->
        <a href="" class="modal__close demo-close">
          <svg class="" viewBox="0 0 24 24"><path d="M19 6.41l-1.41-1.41-5.59 5.59-5.59-5.59-1.41 1.41 5.59 5.59-5.59 5.59 1.41 1.41 5.59-5.59 5.59 5.59 1.41-1.41-5.59-5.59z"/><path d="M0 0h24v24h-24z" fill="none"/></svg>
        </a> 
      </div>
<div style="color: #fff; font-size: 12px; margin-top: 1.5px; text-align:right; zoom: 1.2;"><input name="OFF_UP" id="OFF_UP" type="checkbox" value="OFF_UP"  onclick="myFunction()">ไม่แสดงหน้านี้อีก
</div><!-- <p id="demo"></p> -->

    </div>
  </div>

<?
}
?> 
<!-- END POPUP Modal -->

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
            <img src="form_login/images/boxLogo.png">
        </div>
        <div class="loginNew">
                    <div  id="postCheck" style="margin-top:30px;">
                        <div class="bgInsure" onclick="$('#optClaim').val('1');$('#postCheck').css('display','none');$('#container').css('display','block');$('#headIns').css('display','block');$('#headClaim').css('display','none');">
                            <!--classเดิมเรียกใช้รูปฝ่ายประกัน  .bannerIH -->
              <div class="" style='width: 276px;height: 224px;margin: 0 auto;' align='center'><img src='form_login/images/ins_2018_edit1.png' style='zoom:21.5%;cursor: pointer;'></div>
                        </div>
                        <div class="bgClaim"  onclick="$('#optClaim').val('2');$('#postCheck').css('display','none');$('#container').css('display','block');$('#headIns').css('display','none');$('#headClaim').css('display','block');">
                           <!--classเดิมเรียกใช้รูปฝ่ายเคลม .bannerCH -->
               <div class="" style='width: 276px;height: 224px;margin: 0 auto;' align='center'><img src='form_login/images/claimBanner_2018_edit1.png' style='zoom:21.5%;cursor: pointer;'></div>
                        </div>
                    </div>
    <div id="container"  style="display:none;padding:20px;">
                    <div id="headIns" style="display:none;"> <img src="form_login/images/insText.png"></div>
                    <div id="headClaim" style="display:none;"><img src="form_login/images/claText.png"></div>
                    <div class="nline"></div>
      <form   id="contact_form" method="POST" onsubmit="return processForm();">
        <!-- <form  id="frmLogin" action="ChkLog.php" method="POST"> -->
        <div class="username-text">Username:</div>
                                <div class="username-field">
          <input type="text" name="f_user"  />
        </div>
        <div class="password-text">Password:</div>
        
        <div class="password-field">
          <input type="password" name="f_pass"  />
        </div>
       
                                <!--<div class="username-option">-->
                                    <input type="hidden" name="optClaim" id="optClaim">
<!--                                    <select class="selcted" name="optClaim">
                                        <option value="0">กรุณาเลือก</option>
                                        <option value="1">ฝ่ายแจ้งประกันภัย</option>
                                        <option value="2">ฝ่ายเคลม</option>
                                    </select>-->
                                <!--</div>-->
        <div class="forgot-usr-pwd"> <!--<a style="color:#FFFFFF;" href="javascript:void(0)" onclick="window.open('forgetPassword.php','forget','menubar=no,status=no,scrollbars=no,width=570,height=350')">Forgot Password</a> --></div>
         <div class="" style="margin-top: 10px;">
          <input type="hidden" name="do" value="contact" />
          <?php require_once 'captcha/securimage.php'; echo Securimage::getCaptchaHtml(array('input_name' => 'ct_captcha')); ?>
        </div>
                                
                                <input class="btnGo" id='btnSub' type="submit" name="submit" value="" />
                                <div class="btnBack" onclick="$('#optClaim').val('');$('#container').css('display','none');$('#postCheck').css('display','block');"></div>
      </form>
      <div id="error-browser" style="display:none; background:#333;">
        <div style="margin:16px auto;font-size:160%;padding:1em;">
          <h1>ระบบรองรับ เบราว์เซอร์ (<img src="images/GG_C.png" width="5%"> Google Chrome) เท่านั้น</h1>
          <a href="https://www.google.com/intl/th/chrome/browser/desktop/" style="color: #09f;">
            <h3>กรุณาคลิ๊กที่นี่!!!!เพื่อ ดาวน์โหลด เบราว์เซอร์ ที่รองรับการใช้งาน</h3>
          </a>
        </div>
      </div>
    </div>
            <div class="fHotline"><img src="form_login/images/hotlineN_2019.jpg" width='389px' height='91px'></div>
        </div>
        <div class="newW">
<!--            <div class="item">
                <div class="nImg"><img src="form_login/images/claImg.png" width="107" height="86"></div>
                <div class="nDetail">
                    <p class="headT">จะดีกว่าไหม ถ้ามีคนดูแลคุณ ? </p>
                    เชื่อมั่นให้ลูกค้า ด้วยสโลแกนที่ว่า "รวดเร็ว  ถูกต้อง เป็นธรรม ตรวจสอบได้"
                </div>
                <div style="clear:both;"></div>
                <div class="nRead">Read More</div>
                <div class="nline"></div>
            </div>-->
            <div class="newsHead"><img src="form_login/images/head_news10.jpg"></div>
              <!-- START check cost acc -->
          <div id="frmcheck">

      <div style="width:578px;height:50px;margin:0px 0px;">
                    <div style='padding-top:12px;'>
      <div style='padding:3px;'><b><u>แจ้งฟรีอุปกรณ์ตกแต่ง</u></b></div>
      <div style='padding-top:3px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เพื่อลดภาระค่าติดตั้งอุปกรณ์ตกแต่ง ทางบริษัทแจ้งให้อนุโลมเรียกเก็บเบี้ยเพิ่ม</div>
      <div style='padding:0px;'> ส่วนที่ขึ้นต้นคําว่า "<font size='5' id='color_infinity'><b>@</b></font>" คือรายการฟรี</div>
      <br>
      </div>
             <span>การใช้งาน :</span>
              <span><select name="cartype" id="cartype" style="height:30px;" class="">
                <option value="0">กรุณาเลือก</option>
                <option value="1">รถยนต์นั่ง</option>
                <option value="3">รถยนต์บรรทุก</option>
              </select></span>
  
              
             <span> รุ่นรถ :</span>
                <span><select name="mo_car" id="mo_car" style="height:30px;" class="">
                  <option value="0">กรุณาเลือก</option>
                </select></span>
              
               
                <span>รุ่นย่อย :</span>
                
                  <span><select name="mo_car_sub" id="mo_car_sub" style="height:30px;width: 185px;" onchange="mo_sub_start();"><option value="0">กรุณาเลือกรุ่นรถย่อย</option>
                   </select></span>
                  <br>
              
              
                <span>อุปกรณ์ตกแต่งเพิ่มเติม :</span>
                
                  <span><select name="id_acc" id="id_acc" style="height:30px;width:320px;"><option value="0">กรุณาเลือกอปุกรณืตกแต่งเพิ่มเติม</option>
                  </select></span>
                  
              
              
                <div href="javascript:0;" style="float:right;margin:0px;" class="btncheck" onclick="fnccheckacc();"></div>
              
            </div>
      <div style='width:560px;height:300px;'>

      
      <!--<img src="images/HNY_2019_suzuki.jpg" style="padding-top:10px;margin-left:6.3px;width:560px;height:260px;margin-top:10px;-webkit-filter: brightness(100%);" title="">-->
            </div>
            <div class="newsIcon"> 
              <img src="form_login/images/QR_CODE_2019.jpg" style="padding-button:0px;margin-left:-15px;width:600px;height:130px;" title="">
            </div>
         </div>   
            <div id="frmcheck_result" style="width:578px;min-height:320px;margin:10px 0px;display:none">
              
            </div>
            <!-- END check cost acc -->

            <!-- <div class="newsPos"  style="margin-top:-25px;"> -->
          <!--   <a href="form_login/images/pdf70y.pdf" style='padding:10px;' target='_blank'><img src="form_login/images/link_url.jpg" width='550' height='200'></a>-->
           <!-- <marquee class="newsPos" style="line-height:25px;text-align: center;color:#254661; margin-top:50px;" direction="left" class=TextArea onmouseover=this.stop() onmouseout=this.start() scrollAmount=10 scrollDelay=100 >
                
                <strong>
                     <font size='4' color='BLUE'>ขออวยพรให้ทุกท่านพบกับความเจริญรุ่งเรืองและ จงประสบความสำเร็จในทุกๆสิ่งในปีใหม่นี้ สุขสันต์วันคริสต์มาส และวันปีใหม่</font>
                </strong>
               <!-- <div class="nline" style="margin-top:5px;"></div> -->
                
                <!--<iframe style="padding-top:10px;margin-left:6.3px;" src="form_login/loveking.mp4"  width="560" height="315" frameborder="1" allowfullscreen></iframe>-->
             <!--</marquee>-->
            <!--<marquee class="newsPos" style="line-height:25px;text-align: center;color:#254661;"  direction="right" class=TextArea onmouseover=this.stop() onmouseout=this.start() scrollAmount=3 scrollDelay=100 >-->
                
<!--        <strong>

        </strong>
                <div class="nline" style="margin-top:10px;"></div>
        <iframe style="padding-top:10px;margin-left:6.3px;" src="form_login/full.mp4"  width="560" height="315" frameborder="1" allowfullscreen></iframe> -->
      <!--</marquee>-->
<!-- <img src="form_login/images/valentine_web2018.jpg" style="padding-top:10px;margin-left:6.3px;width:560px;height:315px;margin-top:30px;" title=""> -->
 <!-- <img src="form_login/images/new_year_ply.gif" style="padding-top:10px;margin-left:6.3px;width:560px;height:315px;margin-top:20px;" title="">
          <marquee class="newsPos" style="line-height:25px;text-align: center;color:#254661; margin-top:0px;" direction="left" class=TextArea onmouseover=this.stop() onmouseout=this.start() scrollAmount=10 scrollDelay=100 >
        <font size='4' color='RED' style='font-weight: bold;'>***ขออวยพรให้ทุกท่านพบกับความเจริญรุ่งเรืองและ จงประสบความสำเร็จในทุกๆสิ่งในปีใหม่นี้ สุขสันต์วันคริสต์มาส และวันปีใหม่2561***</font>
        </marquee>-->
        <!--images_suzuki--> <!-- ปีใหม่2019 -->
        <!-- <img src="images/HNY_2019_suzuki.jpg" style="padding-top:10px;margin-left:6.3px;width:560px;height:315px;margin-top:35px;-webkit-filter: brightness(100%);" title=""> -->
            <!-- </div> -->
      
        </div>   
        <div style="clear:both;"></div>
        <div class="boxFoot">
           <!-- <img src="form_login/images/boxfoot.png"> -->
      <font class='smartfoot'>สงวนลิขสิทธิ์ © 2016 - 2019 บริษัท โฟร์ อินชัวรันส์ โบรกเกอร์ จำกัด</font>
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
       // alert('1 not  error data');
        if($("#captcha_code").val()=='')
        {
          alert('คีย์ตัวอักษรตามรูปภาพด้านล่าง ด้วยครับ!');
          $("#captcha_code").focus();
          return false;
        }

        jQuery.ajax({
            url: 'logincheck_captcha.php',
            type: 'POST',
            data: jQuery('#contact_form').serialize(),
            dataType: 'json'
        }).done(function(data) { 
      
            if (data.error === 0) {
                // if(data.message=='OK'){
                //   return true;

                // }
                 // alert('not  error data :'+data.message);

                 // alert(data.message.indexOf('Incorrect security code'));
                 //  if (data.message.indexOf('Incorrect security code') <1) {
                 //    return true;
                 //  }
                // //jQuery('#success_message').show();
                // jQuery('#contact_form')[0].reset();
                // reloadCaptcha();
                if(data.message=='OK'){
                  jQuery("#contact_form").attr("action","ChkLog.php");
                  jQuery("#contact_form").attr("onsubmit","");
                   jQuery('#btnSub').trigger("click");
                   // alert('เข้า OK');
                  return true;
                  
                }
                reloadCaptcha();
                //setTimeout("jQuery('#success_message').fadeOut()", 12000);
                  // return true;

              
        
            } else {
               jQuery("#contact_form").attr("onsubmit","return processForm()");
                alert('  '+data.message);
                 // alert('ท่านคีย์ตัวอักษรไม่ถูกต้อง กรุณาคีย์ใหม่นะจ๊ะ');
                // alert("There was an error with your submission.\n\n" + data.message);
        
                // alert(data.message.indexOf('Incorrect security code'));
                if (data.message.indexOf('Incorrect security code') >= 0) {
                    jQuery('#captcha_code').val('');
                    jQuery("#captcha_code").focus();
                   // return false; 
                }
              
               // return true;
            }
              // return false;
        });
       
      return false;
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


