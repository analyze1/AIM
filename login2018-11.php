<?php session_start(); // this MUST be called prior to any output including whitespaces and line breaks!
$GLOBALS['ct_recipient']   = 'supinya@my4ib.com'; // Change to your email address!
$GLOBALS['ct_msg_subject'] = 'Securimage Test Contact Form';

$GLOBALS['DEBUG_MODE'] = 1;
// CHANGE TO 0 TO TURN OFF DEBUG MODE
// IN DEBUG MODE, ONLY THE CAPTCHA CODE IS VALIDATED, AND NO EMAIL IS SENT


// Process the form, if it was submitted
// process_si_contact_form();
//echo  dirname(__FILE__) . '/captcha/securimage.php';
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
	<body>    
    <!--     	<div class="snowflakes" aria-hidden="true">
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
</div>   -->
    <!--<div id="dialog" title="Promotion Suzuki!!!">
              <img src="images/new_suzuki_2015.jpg" width="800" />
            </div>-->
                <!--<div class="bgNew"></div>-->
    <div  class="bgNewLogin">
        <div class="boxHead">
            <img src="form_login/images/boxLogo.png">
        </div>
        <div class="loginNew">
                    <div  id="postCheck">
                        <div class="bgInsure" onclick="$('#optClaim').val('1');$('#postCheck').css('display','none');$('#container').css('display','block');$('#headIns').css('display','block');$('#headClaim').css('display','none');">
                            <div class="bannerIH"></div>
                        </div>
                        <div class="bgClaim"  onclick="$('#optClaim').val('2');$('#postCheck').css('display','none');$('#container').css('display','block');$('#headIns').css('display','none');$('#headClaim').css('display','block');">
                            <div class="bannerCH"></div> 
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
            <div class="fHotline"><img src="form_login/images/hotlineN.png"></div>
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
            <div class="newsPos"  style="margin-top:-25px;">
          <!--   <a href="form_login/images/pdf70y.pdf" style='padding:10px;' target='_blank'><img src="form_login/images/link_url.jpg" width='550' height='200'></a>-->
           <!-- <marquee class="newsPos" style="line-height:25px;text-align: center;color:#254661; margin-top:50px;" direction="left" class=TextArea onmouseover=this.stop() onmouseout=this.start() scrollAmount=10 scrollDelay=100 >
                
                <strong>
                     <font size='4' color='BLUE'>ขออวยพรให้ทุกท่านพบกับความเจริญรุ่งเรืองและ จงประสบความสำเร็จในทุกๆสิ่งในปีใหม่นี้ สุขสันต์วันคริสต์มาส และวันปีใหม่</font>
                </strong>
               <!-- <div class="nline" style="margin-top:5px;"></div> -->
                
                <!--<iframe style="padding-top:10px;margin-left:6.3px;" src="form_login/loveking.mp4"  width="560" height="315" frameborder="1" allowfullscreen></iframe>-->
             <!--</marquee>-->
            <!--<marquee class="newsPos" style="line-height:25px;text-align: center;color:#254661;"  direction="right" class=TextArea onmouseover=this.stop() onmouseout=this.start() scrollAmount=3 scrollDelay=100 >-->
                
<!-- 				<strong>

				</strong>
                <div class="nline" style="margin-top:10px;"></div>
				<iframe style="padding-top:10px;margin-left:6.3px;" src="form_login/full.mp4"  width="560" height="315" frameborder="1" allowfullscreen></iframe> -->
			<!--</marquee>-->
<!-- <img src="form_login/images/valentine_web2018.jpg" style="padding-top:10px;margin-left:6.3px;width:560px;height:315px;margin-top:30px;" title=""> -->
 <!-- <img src="form_login/images/new_year_ply.gif" style="padding-top:10px;margin-left:6.3px;width:560px;height:315px;margin-top:20px;" title="">
  				<marquee class="newsPos" style="line-height:25px;text-align: center;color:#254661; margin-top:0px;" direction="left" class=TextArea onmouseover=this.stop() onmouseout=this.start() scrollAmount=10 scrollDelay=100 >
				<font size='4' color='RED' style='font-weight: bold;'>***ขออวยพรให้ทุกท่านพบกับความเจริญรุ่งเรืองและ จงประสบความสำเร็จในทุกๆสิ่งในปีใหม่นี้ สุขสันต์วันคริสต์มาส และวันปีใหม่2561***</font>
				</marquee>-->
				<!--images_suzuki-->
				<!--<img src="form_login/images/ro5_2018.jpg" style="padding-top:10px;margin-left:6.3px;width:560px;height:315px;margin-top:35px;" title="">-->
            </div>
            <div class="newsIcon">
			<!--<img src='form_login/new_year_2561/1000.png' style='position:absolute;width:200px;margin-top:-480px;margin-left:-480px;'>
			<img src='form_login/new_year_2561/2000.png' style='position:absolute;width:350px;margin-top:155px;margin-left:80px;'>
			<img src='form_login/new_year_2561/3000.png' style='position:absolute;width:300px;margin-top:65px;margin-left:550px;z-index:1;'>
			<img src='form_login/new_year_2561/4000.png' style='position:absolute;width:300px;margin-top:-275px;margin-left:635px;'>
			<img src='form_login/new_year_2561/5000.png' style='position:absolute;width:300px;margin-top:20px;margin-left:-710px;z-index:1;'>
			<img src='form_login/new_year_2561/6000.png' style='position:absolute;width:250px;margin-top:-270px;margin-left:-790px;'>
			<img src='form_login/new_year_2561/7000.png' style='position:absolute;width:220px;margin-top:-560px;margin-left:780px;z-index:1'>
			<img src='form_login/new_year_2561/9000.png' style='position:absolute;width:300px;margin-top:-580px;margin-left:-760px;'>-->

                <!--<div class="nline"></div>
                <a href="http://www.siamsport.co.th/" target="_blank"><img class="newsLink" src="form_login/images/1.jpg"></a>
                <a href="http://www.bangkokpost.com/" target="_blank"><img class="newsLink" src="form_login/images/2.png"></a>
                <a href="http://www.bangkokbiznews.com/" target="_blank"><img class="newsLink" src="form_login/images/3.jpg"></a>
                <a href="http://www.dailynews.co.th/" target="_blank"><img class="newsLink" src="form_login/images/4.jpg"></a>
                <a href="http://www.thairath.co.th/" target="_blank"><img class="newsLink" src="form_login/images/5.jpg"></a>
                <a href="http://www.nationtv.tv/" target="_blank"><img class="newsLink" src="form_login/images/6.jpg"></a>
                <a href="http://www.thansettakij.com/" target="_blank"><img class="newsLink" src="form_login/images/7.jpg"></a>
                <a href="http://pantip.com/" target="_blank"><img class="newsLink" src="form_login/images/8.jpg"></a>
                <a href="http://www.sanook.com/" target="_blank"><img class="newsLink" src="form_login/images/9.jpg"></a>
                <a href="http://www.manager.co.th/" target="_blank"><img class="newsLink" src="form_login/images/10.jpg"></a>-->
  
				<img src="form_login/images/QR_CODE.jpg" style="padding-button:0px;margin-left:-15px;width:600px;height:130px;" title="">
			</div>
        </div>   
        <div style="clear:both;"></div>
        <div class="boxFoot">
           <!-- <img src="form_login/images/boxfoot.png"> -->
			<font color='WHITE'>สงวนลิขสิทธ์ พ.ศ.2559 บริษัท โฟร์ อินชัวรันส์ โบรกเกอร์ จำกัด</font>
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
<?php } ?>

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

<?php

// The form processor PHP code
// function process_si_contact_form()
// {
 
// } // function process_si_contact_form()
?>


