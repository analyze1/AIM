<?php
include './services/getiddealer.service.php';
include '../../../inc/connectdbs.pdo.php';

$params = (array)json_decode(base64_decode($_GET['id']));
$GetDealercode = $params['id'];
$GetKey = $params['key'];
// $GetDealercode = '110166';
// $GetKey ='62806';

$_contextMit = PDO_CONNECTION::fourinsure_mitsu();
$_service  =  new getiddealer();
$check =  $_service->recheckid($GetKey, $_contextMit);
if ($check['Approve'] == 'Y') {
    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
    echo '<script>alert("มีการอนุมัติเเล้ว")</script>';
    exit();
}
$res = $_service->getkey($GetDealercode, $GetKey, $_contextMit);
$data = $_service->getdatacustomber($GetDealercode, $_contextMit);
if ($res['PatchFile'] != '') {
    $doc = "อัพโหลดเอกสารเเล้ว";
} else {
    $doc = "ยังไม่ได้อัพโหลดเอกสาร";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แบบฟอร์มวิริยะยกเลิก พ.ร.บ.</title>
    <link rel="shortcut icon" href="../assets/img/ico/viriyah.jpg" type="image/png">
    <link rel="stylesheet" href="../assets/css/cancel-policy.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;1,100;1,200;1,300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"
        integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<style>
.loading-container {
    position: absolute;
    background: #000000bf;
    width: 100%;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000 !important;
}

.lds-ripple {
    display: inline-block;
    position: relative;
    width: 80px;
    height: 80px;
}

.lds-ripple div {
    position: absolute;
    border: 4px solid #fff;
    opacity: 1;
    border-radius: 50%;
    animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
}

.lds-ripple div:nth-child(2) {
    animation-delay: -0.5s;
}

@keyframes lds-ripple {
    0% {
        top: 36px;
        left: 36px;
        width: 0;
        height: 0;
        opacity: 1;
    }

    100% {
        top: 0px;
        left: 0px;
        width: 72px;
        height: 72px;
        opacity: 0;
    }
}
</style>

<body class="bg-gray-200">
    <div>
        <div class="payment">
            <div class="loading-container" id="load" style="display: none;">
                <div class="lds-ripple">
                    <div></div>
                    <div></div>
                </div>
            </div>
            <nav class="navbar navbar-dark bg-yellow-500 absolute w-full">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img src="../assets/img/ico/viriyah-header.png" alt="" width="160"
                            class="d-inline-block align-top">
                    </a>
                </div>
            </nav>
            <main>
                <div class="flex justify-center h-screen px-6">
                    <div class="mt-12 max-w-lg w-full">
                        <div class="text-center my-6" id="title">
                            <h4>แบบฟอร์มเปลียนผู้ดูแลต่ออายุ Mitsubishi</h4>
                        </div>
                        <form class="needs-validation" novalidate>
                            <div class="p-3 min-w-full w-full bg-white shadow-md rounded-md">
                                <div class="tab-content">
                                    <div class="p-2">
                                        <div class="flex mb-1">
                                            <label class="text-gray-700 mx-1" for="">บริษัท :
                                            </label>
                                            <span
                                                class="mx-1 text-blue-700 font-thin"><?php echo  $data['sub']   ?></span>
                                        </div>
                                        <div class="flex mb-1">
                                            <label class="text-gray-700 mx-1" for="">สาขา :
                                            </label>
                                            <span
                                                class="mx-1 text-blue-700 font-thin"><?php echo $res['DealerCode'] ?></span>
                                        </div>
                                        <div class="flex mb-1">
                                            <label class="text-gray-700 mx-1" for="">สถานะเอกสาร :
                                            </label>
                                            <span class="mx-1 text-blue-700 font-thin"><?php echo $doc ?></span>
                                        </div>
                                        <div class="flex mb-1">
                                            <label class="text-gray-700 mx-1" for="">วันที่เเจ้งเปลียนผู้ดูแลต่ออายุ:
                                            </label>
                                            <span class="mx-1 text-blue-700 font-thin"> <?php echo $res['DateUpload'] ?>
                                            </span>
                                        </div>
                                        <div class="flex mb-1">
                                            <label class="text-gray-700 mx-1" for="">เอกสารแนบ:
                                            </label>
                                            <span class="mx-1 text-blue-700 font-thin">
                                                <a target="_blank" id="linkfile" rel="noopener noreferrer">ดูเอกสาร
                                                    คลิ๊กที่นี่</a>
                                            </span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group text-center my-3">
                                        <label class="text-center">
                                            <h6 class="text-xl">ยืนยันการเปลียนผู้ดูแลต่ออายุ</h6>
                                        </label>
                                    </div>
                                    <div class=" grid-cols-1 mt-4 sm:grid-cols-2 gap-2">
                                        <div class="flex">
                                            <div class="form-check w-full">
                                                <input class="form-check-input" type="radio" value="D" id="accept_D"
                                                    required name="follow">
                                                <label class="form-check-label" for="accept_D">
                                                    <h6>ดีลเลอร์ตามเอง</h6>
                                                </label>
                                            </div>
                                            <div class="form-check w-full">
                                                <input class="form-check-input" type="radio" value="F" id="dismiss_F"
                                                    required name="follow">
                                                <label class="form-check-label" for="dismiss_F">
                                                    <h6>มอบหมายให้โฟร์</h6>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="grid-cols-1 sm:grid-cols-2 gap-2" id="dealer-detail">
                                        <div class=" w-full">
                                            <label class="form-check-label" for="accept">
                                                <h6>ชื่อผุ้รับผิดชอบ</h6>
                                            </label>
                                            <div class="w-full">
                                                <input type="text" class="form-control" value="" id="namefull" required
                                                    name="namefull" placeholder="คุณ...">
                                            </div>
                                        </div>
                                        <div class=" w-full">
                                            <label class="form-check-label" for="dismiss">
                                                <h6>เบอร์โทรศัพท์(ไม่ต้องใส่ขีด)</h6>
                                            </label>
                                            <div class="w-full">
                                                <input type="text" class="form-control" value="" id="numbertel" required
                                                    name="numbertel" placeholder="ตัวเลขเท่านั้น">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-4">
                                        <div class="flex">
                                            <div class="form-check w-full">
                                                <input class="form-check-input" type="radio" value="Y" id="accept"
                                                    required name="status">
                                                <label class="form-check-label" for="accept">
                                                    <h6>ยืนยัน</h6>
                                                </label>
                                            </div>
                                            <div class="form-check w-full">
                                                <input class="form-check-input" type="radio" value="N" id="dismiss"
                                                    required name="status">
                                                <label class="form-check-label" for="dismiss">
                                                    <h6>ไม่ยืนยัน</h6>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            <input type="text" class="form-control" value="" id="become" required
                                                name="become" placeholder="โปรดระบุเหตุผล">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group text-center my-3">
                                        <label class="text-center">
                                            <h6 class="text-xl">ยืนยันการออกใบเสร็จ</h6>
                                        </label>
                                    </div>
                                    <div class=" grid-cols-1 mt-2 sm:grid-cols-2 gap-2">
                                        <div class="flex">
                                            <div class="form-check w-full">
                                                <input class="form-check-input" type="radio" value="N" checked
                                                    id="accept_receipt" name="receipt" require>
                                                <label class="form-check-label" for="accept_receipt">
                                                    <h6>ออกใบเสร็จ</h6>
                                                </label>
                                            </div>
                                            <div class="form-check w-full">
                                                <input class="form-check-input" type="radio" value="Y"
                                                    id="reject_receipt" name="receipt" require>
                                                <label class="form-check-label" for="reject_receipt">
                                                    <h6>ไม่ออกใบเสร็จ</h6>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full flex justify-center">
                                    <input type="submit" name="handlesave" id="handlesave" value="ยืนยัน"
                                        class="py-2 px-4 my-3 text-center underline-none bg-blue-600 rounded-md w-full text-white text-sm hover:bg-blue-600 border-none">
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer justify-content-center">
                            <span class="Footer__Text-sc-18yfspe-1 hBQbPo">©2021 4 Insurance Broker Co.,Ltd.</span>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script type="text/javascript">
    var _pathFile = '<?php echo $res['PatchFile']; ?>';
    (function() {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    } else {
                        handleMitsubishiApprove();
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()

    handleMitsubishiApprove = () => {
        document.getElementById("load").style.display = "flex";
        const _surway = {
            key: '<?php echo  $GetKey ?>',
            confirm: $("input[name=status]:checked").val(),
            follow: $("input[name=follow]:checked").val(),
            receipt: $("input[name=receipt]:checked").val(),
            dealercode: '<?php echo $res['DealerCode'] ?>',
            become: $("input[id=become]").val(),
            namefull: $('#namefull').val(),
            phone: $('#numbertel').val(),
            controller: "MitsubishiApprove",
        }

        $.ajax({
            url: 'controller/Approve-Mitsubishi.controller.php',
            type: 'post',
            dataType: 'json',
            data: _surway,
            success: (data) => {
                document.getElementById("load").style.display = "none";
                Swal.fire({
                    title: 'ดำเนินการเรียบร้อย',
                    icon: 'success',
                    text: data.message,
                }).then((e) => {
                    // location.href="https://www.fourinsured.com/policy/Authentication?token=2b64dfed-c593-438f-8636-7b2fd18aa0f3";
                })
            },
            error: (err) => {
                document.getElementById("load").style.display = "none";
                Swal.fire(
                    'การยกเลิกเกิดข้อผิดพลาด!',
                    err.message,
                    'error'
                )
                //   location.href="https://www.fourinsured.com/policy/Authentication?token=2b64dfed-c593-438f-8636-7b2fd18aa0f3";
            }
        });
    };

    function loadPathFilesOnHref() {
        const x = document.getElementById('linkfile');
        x.setAttribute('href', `../../../DocAdminTelephone/${_pathFile}`);
        x.style = 'text-decoration: none;';
    }
    loadPathFilesOnHref();
    </script>
</body>

</html>