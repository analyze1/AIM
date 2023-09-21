<?php
session_start();

include "./inc/connectdbs.pdo.php";

$GLOBALS['ct_recipient']   = 'info_support@my4ib.com'; // Change to your email address!
$GLOBALS['ct_msg_subject'] = 'Securimage Test Contact Form';

$GLOBALS['DEBUG_MODE'] = 1;
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv='cache-control' content='no-cache'>
    <meta http-equiv="Pragma" content="no-cache" />
    <link rel="shortcut icon" href="themes/img/VIBM.ico" />
    <title>ประกันภัยออนไลน์ MVinsurance</title>
    <!-- particles.js container -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@200&family=Prompt:wght@400&display=swap" rel="stylesheet">
    <link href="css/christmas.css" rel="stylesheet">
    <link rel="stylesheet" href="form_login/style.css" type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script type="text/javascript" src="js/jquery-1.8.3.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="js/callus_out.js" charset="UTF-8"></script>

    <style>
        #callus-734 {
            --call-us-form-header-background: #71d307;
            --call-us-header-text-color: #ffffff;
            --call-us-form-width: 250px;
            --call-us-form-height: 470px;
        }

        .myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .myImg:hover {
            opacity: 0.7;
        }

        .modal-body {
            padding: 0 !important;
        }

        .btn-close {
            position: fixed;
            z-index: 1;
            top: 43px;
            right: 70px;
        }

        .input-group-text {
            padding: 0.625rem 0.75rem;
        }
    </style>

</head>
<call-us id="callus-734" style="position: fixed; bottom:58px; z-index:9999;right:5px;" phonesystem-url="https://4insurance.3cx.asia:5001/" party="click2talk310285" minimized="true" allow-call="true" allow-video="true" allow-soundnotifications="true" invite-message="สามารถแชทสอบถามกับเจ้าหน้าที่ได้เลย โดยไม่เสียค่าใช้จ่าย" window-title="ติดต่อสอบถาม แชทฟรี" operator-name="Operator" window-icon="" operator-icon="" popout="false" authentication="name" enable-onmobile="true" minimized-style="bubble"></call-us>

<body>
    <div id="particles-js"></div>
    <div class="container-chrismas">
        <div class="wrap-login100">
            <div class="login100-form-title">
                <span class="login100-form-title-1 w-100-p">
                    <img src="form_login/images/logo viriyah suzuki web.png" class="mg-t-l" width="30%" alt="">
                </span>
            </div>
            <!-- <div style="display: flex;justify-content: center;">
                <span style="color: green;font-size: 22px;">ระบบสามารถใช้ได้ตามปกติแล้ว<br>
                    <p style="color: black;font-weight: bold; font-size: 1rem;text-align: center;font-size: 18px;">ขออภัยในความไม่สะดวก</p>
                </span> -->

                <!-- <span style="color: green;font-size: 22px;">ระบบสามารถใช้งานได้ตามปกติ ใช้เวลารวม 3ชม. ขอบคุณครับ<br>
                </span> -->
            <!-- </div> -->
            <div class="flex-container">
                <div class="flex-item-left">
                    <div id="postCheck">
                        <div class="bgInsure open" onclick="$('#optClaim').val('1');$('#postCheck').css('display','none');$('#container').css('display','block');$('#headIns').css('display','flex');$('#headClaim').css('display','none');">
                            <!--classเดิมเรียกใช้รูปฝ่ายประกัน  .bannerIH -->
                            <div class="" style='width: 276px;margin: 0 auto;' align='center'><img src='images/ins_2018_edit1.png' style='width: 247px;cursor: pointer;'>
                            </div>
                        </div>
                        <div class="bgClaim open" onclick="$('#optClaim').val('2');$('#postCheck').css('display','none');$('#container').css('display','block');$('#headIns').css('display','none');$('#headClaim').css('display','flex');">
                            <!--classเดิมเรียกใช้รูปฝ่ายเคลม .bannerCH -->
                            <div class="" style='width: 276px;height: 224px;margin: 0 auto;' align='center'><img src='images/claimBanner_2018_edit1.png' style='width: 247px;cursor: pointer;'>
                            </div>
                        </div>
                        <b>
                            <div class="hotline">
                                <div class="text-group"><span class="text-hotline"><i class="fas fa-phone-alt"></i>
                                        สายด่วน</span></div>
                                <div style="text-align: center;
                                width: 100%;"> <span class="title-text">ฝ่ายการตลาด</span></div>
                                <div class="text-center"> 063-906-3563 ,
                                093-323-8814 , 063-906-3561</div>
                            </div>
                        </b>
                    </div>
                    <div id="container" style="display:none;">
                        <div id="headIns" style="display:none;justify-content: space-around;margin-bottom: 15px;">
                            <img src="images/ฝ่ายรับประกันด้านในมิตซู.png" width="100%">
                        </div>
                        <div id="headClaim" style="display:none;justify-content: space-around;margin-bottom: 15px;">
                            <img src="images/ฝ่ายเคลมด้านในมิตซู.png" width="100%">
                        </div>
                        <form id="contact_form" method="POST" onsubmit="return processForm();">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Username" id="f_user" name="f_user">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" placeholder="Password" id="f_pass" name="f_pass">
                            </div>
                            <input type="hidden" name="optClaim" id="optClaim">
                            <div class="bg-capt">
                                <input type="hidden" name="do" value="contact" />
                                <?php require_once 'captcha/securimage.php';
                                echo Securimage::getCaptchaHtml(array('input_name' => 'ct_captcha')); ?>
                            </div>
                            <button class="btnGo" id='btnSub' type="submit" name="submit"><i class="fas fa-sign-in-alt"></i>&nbsp;&nbsp;LOGIN</button>
                            <div class="btnBack" onclick="$('#optClaim').val('');$('#container').css('display','none');$('#postCheck').css('display','block');">
                                <i class="fas fa-chevron-left"></i>&nbsp;&nbsp;BACK
                            </div>
                            <div class="btnForget" onclick="forgetPassword()">
                                <i class="fas fa-key"></i>&nbsp;&nbsp;Forgot Password
                            </div>
                        </form>
                    </div>
                </div>
                <div class="flex-item-right ">
                    <div class="white">
                        <div>
                            <!-- <img src="./images/MVinsurance.jpg" alt=""> -->
                            <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active" data-bs-interval="2000">
                                        <img src="./images/MVinsurance.jpg" class="d-block w-100 myImg" width="611" height="365" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="./images/slideshow/1.png" class="d-block w-100 myImg" data-bs-toggle="modal" data-bs-target="#staticBackdrop" width="611" height="365" alt="..." onclick="handleOpenModal('./images/slideshow/EM_MV_1.jpg')">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="./images/slideshow/2.png" class="d-block w-100 myImg" data-bs-toggle="modal" data-bs-target="#staticBackdrop" width="611" height="365" alt="..." onclick="handleOpenModal('./images/slideshow/EM_MV_2.jpg')">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="./images/slideshow/3.png" class="d-block w-100 myImg" data-bs-toggle="modal" data-bs-target="#staticBackdrop" width="611" height="365" alt="..." onclick="handleOpenModal('./images/slideshow/EM_MV_3.jpg')">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="./images/slideshow/4.png" class="d-block w-100 myImg" data-bs-toggle="modal" data-bs-target="#staticBackdrop" width="611" height="365" alt="..." onclick="handleOpenModal('./images/slideshow/EM_MV_4.jpg')">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="./images/slideshow/5.png" class="d-block w-100 myImg" data-bs-toggle="modal" data-bs-target="#staticBackdrop" width="611" height="365" alt="..." onclick="handleOpenModal('./images/slideshow/EM_MV_5.jpg')">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="./images/slideshow/6.png" class="d-block w-100 myImg" data-bs-toggle="modal" data-bs-target="#staticBackdrop" width="611" height="365" alt="..." onclick="handleOpenModal('./images/slideshow/EM_MV_6.jpg')">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="./images/slideshow/EM_MV_7.png" class="d-block w-100 myImg" data-bs-toggle="modal" data-bs-target="#staticBackdrop" width="611" height="365" alt="..." onclick="handleOpenModal('./images/slideshow/EM_MV_7.png')">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <div class="newsIcon">
                            <label class="qrcode">QR CODE HOTLINE</label>
                            <img width="150" height="150" src="form_login/images/QR_Jeab.png" class="img-fluid" title=""  onclick="window.open(`https://line.me/ti/p/M55URwo8xZ`)">
                            <img width="150" height="150" src="form_login/images/QR_Aoae.png" class="img-fluid" title=""  onclick="window.open(`https://line.me/ti/p/n-5iMc61-F`)">
                            <img width="150" height="150" src="form_login/images/QR_Big.png" class="img-fluid" title=""  onclick="window.open(`https://line.me/ti/p/Sl-vjCCDbr`)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    <script src="captcha/jquery-1.10.1.min.js"></script>
    <script type="text/javascript">
        if (navigator.userAgent.indexOf('Chrome') < 0) {
            document.getElementById('error-browser').style.display = "";
        }

        function handleOpenModal(link) {
            $('.modal-body').empty();
            $('.modal-body').append(`
                <img src="${link}" class="d-block w-100" alt="...">
            `);
        }

        $("#captcha_code").attr('placeholder', 'พิมพ์ตัวเลขตามรูป');
        $("#captcha_code").attr('style',
            'width:155px;height:50px;background-color: #FFFFFF;font-size:15px; padding: 0px 17px;display: flex;'
        );

        $.noConflict();

        function reloadCaptcha() {
            jQuery('#siimage').prop('src', 'captcha/securimage_show.php?sid=' + Math.random());
        }

        function processForm() {
            if ($("#captcha_code").val() == '') {
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
                    if (data.message == 'OK') {
                        jQuery("#contact_form").attr("action", "ChkLog.php");
                        jQuery("#contact_form").attr("onsubmit", "");
                        jQuery('#btnSub').trigger("click");
                        return true;
                    }
                    reloadCaptcha();
                } else {
                    jQuery("#contact_form").attr("onsubmit", "return processForm()");
                    alert('  ' + data.message);

                    if (data.message.indexOf('Incorrect security code') >= 0) {
                        jQuery('#captcha_code').val('');
                        jQuery("#captcha_code").focus();
                    }
                }
            });
            return false;
        }

        var inset = 0;
        setInterval(function() {
            if (inset == 0) {
                $('#color_infinity').attr('color', 'red');
                inset++;
            } else {
                $('#color_infinity').attr('color', 'black');
                inset--;
            }

        }, 2000);

        $(document).ready(function() {
            $("#btnpopup").find("span").trigger("click");
            //เปิด modal offline
            // Swal.fire({
            //     imageUrl: 'images/warming-mvinsurance.jpg',
            //     imageWidth: 600,
            //     width: 600,
            //     imageAlt: 'Custom image',
            // });
        });

        function myFunction() {
            window.location.href = "login_freedate.php";
        }

        async function postApiAsync(_url, _params) {
            return await $.ajax({
                type: "POST",
                url: _url,
                data: _params,
                dataType: "JSON",
                success: (res) => {
                    return res;
                },
                error: (err) => {
                    return err;
                }
            });
        }

        async function sendPassWord(id, tel) {
            const url = './services/ForgetPassword/forget.controller.php';
            let param = {
                Controller: 'SendPassSMS',
                DealerCode: id,
                Number: tel
            };
            return await postApiAsync(url, param);
        }

        async function forgetPassword() {
            try {

                let userElm = document.querySelector('#f_user').value;
                if (userElm == '') {
                    Swal.fire({
                        title: 'Username รหัสดีลเลอร์',
                        text: 'กรุณากรอก Username',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'เข้าใจ'
                    });
                    return false;
                }
                const url = './services/ForgetPassword/forget.controller.php';
                let params = {
                    Controller: 'CheckUser',
                    UserCode: userElm
                };

                let chktelinfo = await postApiAsync(url, params);
                if (chktelinfo.Status === 200) {
                    let number = chktelinfo.Data[0];
                    const textApi = `ท่านต้องการส่ง SMS เพื่อรับรหัสผ่านที่เบอร์มือถือ ${number.numberX}`
                    Swal.fire({
                        title: 'ต้องการส่ง SMS?',
                        text: textApi,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ต้องการส่ง',
                        cancelButtonText: 'ไม่'
                    }).then(async (result) => {
                        console.log('กดส่ง', result);
                        if (result.isConfirmed) {

                            let sendRes = await sendPassWord(number.userCode, number.numberFull);
                            console.log('หลังส่งsmsสำเร็จ', sendRes);
                            if (sendRes.Status === 200) {
                                Swal.fire({
                                    text: 'ดำเนินการส่งเสร็จสิ้น',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ปิด'
                                });
                            } else {
                                Swal.fire({
                                    text: 'ไม่สามารถส่ง SMS ได้กรุณาติดต่อเจ้าหน้าที่',
                                    icon: 'error',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ปิด'
                                });
                            }
                        }
                    });
                } else {
                    Swal.fire({
                        text: chktelinfo.Data,
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ปิด'
                    });
                }
            } catch (err) {
                Swal.fire({
                    text: err.responseText,
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ปิด'
                });
            }
        }
    </script>

</body>

</html>