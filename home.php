<script language="javascript">
$('#pageSearch').hide('Slow');
$("#Download").click(function() {
    $("#DLREPORT").submit();
});
$('#page-content').css({
    'background-color': '#efedef'
});
</script>

<style>
#main {
    height: 70px;
    background: #233f85;
}

.mindphp {
    text-align: center;
    font-size: 40px;
    font-weight: bold;
    padding-top: 6px;
    color: white;
}

.font_inform_new {
    color: red;
    text-shadow: -1px 0 Yellow, 0 1px Yellow, 1px 0 Yellow, 0 -1px Yellow;
}

.font_inform_new2 {
    color: red;
    font-weight: bold;
}
</style>
<?php
$D = date('d');
$M = date('m');
$Y = date('Y');
$LastDay = date('d', strtotime('last day'));
$LastMonth = date('m', strtotime('last month'));
?>
<div class="row-fluid">
    <!-- <div class="span12"> -->
    <!-- <div class="widget-box transparent">
            <div id="main">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="mindphp">
                            <h2>&nbsp;
                                <i class="icon-bullhorn"></i> Dashboard
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    <!-- </div> -->
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box transparent">
                <div class="widget-body" style="background-color: #6fb3e0">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="widget-box transparent" id="recent-box">
                                <div class="widget-body">
                                    <div class="padding-4" style="background-color: #f9f9f9;">
                                        <div class="tab-content padding-8">
                                            <div id="task-tab" class="tab-pane active">
                                                <div id="comment-tab" class="tab-pane">
                                                    <div class="comments">
                                                        <div class="itemdiv commentdiv" style="padding-left: 12px;">
                                                            <br>
                                                        <!-- <div>
                                                            <i class="icon-time green"></i>
                                                            <span class="green">20/02/2565
                                                                <img src="images/LogoNew/unnamed.gif" width="50px">
                                                            </span> 
                                                            <font style="color:red">ระบบจะปิดปรับปรุงในวันอาทิตย์ 20 กุมภาพันธ์ 2565 เวลา 12.00 น. - 15.00 น.</font>
                                                            <b>ขออภัยในความไม่สะดวก</b>
                                                            <font style="color:green">ระบบสามารถใช้งานได้ตามปกติ ใช้เวลารวม 3ชม. ขอบคุณครับ</font>
                                                            
                                                        </div>
                                                        <hr>-->
                                                        <div>
                                                            <i class="icon-time green"></i>
                                                            <span class="green">11/03/2565
                                                             
                                                            <img src="images/LogoNew/unnamed.gif" width="50px">
                                                                </span>เอกสาร การปรับเพิ่ม ลด ทุนประกันภัย      
                                                                <a target="_blank" href="https://www.viriyah.net/mitsubishi/doc/การปรับเพิ่ม ลด ทุนประกันภัย.pdf"><font color='blue'>เอกสารคลิ๊ก</font>&nbsp;
                                                                </a>
                                                                
                                                        </div>
                                                        <hr>
                                                        <div>
                                                            <i class="icon-time green"></i>
                                                            <span class="green">17/02/2565
                                                             
                                                            </span>รายชื่อศูนย์ซ่อมตัวถังและสีรถยนต์มิตซูบิชิ ดูเอกสารคลิ๊ก
                                                            <a target="_blank"
                                                                href="documents/BP_Mistu_ภาคเหนือ_1.pdf">
                                                                <font color='blue'> ภาค1 </font>
                                                            </a>
                                                            <a target="_blank"
                                                                href="documents/BP_Mistu_ภาคตะวันออกเฉียงเหนือ_2.pdf">
                                                                <font color='blue'> ภาค2</font>
                                                            </a>
                                                            <a target="_blank"
                                                                href="documents/BP_Mistu_ภาคตะวันออก_3.pdf">
                                                                <font color='blue'> ภาค3</font>
                                                            </a>
                                                            <a target="_blank"
                                                                href="documents/BP_Mistu_ตะวันตก_4.pdf">
                                                                <font color='blue'> ภาค4</font>
                                                            </a>
                                                            <a target="_blank"
                                                                href="documents/BP_Mistu_ภาคใต้_5.pdf">
                                                                <font color='blue'> ภาค5</font>
                                                            </a>
                                                            <a target="_blank"
                                                                href="documents/BP_Mistu_กรุงเทพฯและปริมณฑล_6.pdf">
                                                                <font color='blue'> ภาค6</font>
                                                            </a>
                                                        </div>
                                                        <hr>
                                                             <div>
                                                                <i class="icon-time green"></i>
                                                                <!-- <span class="green">12/01/2565 <img src="images/LogoNew/unnamed.gif" width="50px"> -->
                                                                </span>เอกสาร/ใบคำขอเอาประกันภัย กรมธรรม์ประกันภัยการขยายเวลารับประกัน (สำหรับอะไหล่รถยนต์)
                                                                <a target="_blank" href="https://www.viriyah.net/mitsubishi/doc/Extended_Warranty/EW_Brochure_2022.pdf"><font color='blue'>เอกสารคลิ๊ก</font>&nbsp;/&nbsp;
                                                                
                                                                <a target="_blank" href="https://www.viriyah.net/mitsubishi/doc/Extended_Warranty/ใบคำขอ_EW_final.pdf"><font color='blue'>ใบคำขอคลิ๊ก</font>
                                                                </a>
                                                            </div>
                                                            <hr>
                                                            <div>
                                                                <i class="icon-time green"></i>
                                                                <span class="green">15/06/2564
                                                                </span>หนังสือแต่งตั้งคณะทำงาน บริษัท วิริยะประกันภัย
                                                                จำกัด มหาชน <a target="_blank"
                                                                    href="documents/work-list.pdf">
                                                                    <font color='blue'>ดูเอกสารคลิ๊ก</font>
                                                                </a>
                                                            </div>
                                                            <!-- <hr>
                                                            <div>
                                                                <i class="icon-time green"></i>
                                                                <span class="green">15/06/2564
                                                                    <img src="images/LogoNew/unnamed.gif" width="50px">
                                                                </span> หนังสือมอบอำนาจชำระเบี้ย บริษัท วิริยะประกันภัย
                                                                จำกัด มหาชน <a target="_blank"
                                                                    href="documents/nv-12-vib.pdf">
                                                                    <font color='blue'>ดูเอกสารคลิ๊ก</font>
                                                                </a>
                                                            </div> -->
                                                            <hr>
                                                            <div>
                                                                <i class="icon-time green"></i>
                                                                <span class="green">13/09/2562</span> ประกาศ!
                                                                บริการโทรฟรี (Toll Free)
                                                                ช่องทางใหม่ในการติดต่อหรือสอบถามปัญหาด้านการแจ้งงานให้สะดวกรวดเร็วขึ้น
                                                                <font id='color_hotline2' style="font-weight: bold;">
                                                                    เพียงกดรูป โทรศัพท์ /พิมพ์ชื่อท่าน/กดโทร </font>
                                                                ท่านจะได้รับการบริการทันทีไม่มีค่าใช้จ่าย
                                                                <a target="_blank" href="form_login/manutollfree.pdf">
                                                                    <font color='blue'>วิธีการใช้งานคลิ๊ก</font>
                                                                </a>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <iframe id="myIframeXXX" style="width: 100%;" frameborder="0" scrolling="no" onload="resizeIframeRenew(this)"
        src="./charts/dash-board-renew.php" frameborder="0"></iframe>
</div>

<script>
    function resizeIframeRenew(obj) {
    obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
}
var inset = 0;
setInterval(function() {
    if (inset == 0) {
        $('#color_infinity').addClass('font_inform_new');
        $('#color_hotline').addClass('font_inform_new');
        inset++;
    } else {
        $('#color_infinity').removeClass('font_inform_new');
        $('#color_hotline').removeClass('font_inform_new');
        inset--;
    }

}, 500);
var inset2 = 0;
setInterval(function() {
    if (inset2 == 0) {
        $('#color_infinity2').addClass('font_inform_new2');
        $('#color_hotline2').addClass('font_inform_new2');
        $('#color_hotline3').addClass('font_inform_new2');
        inset2++;
    } else {
        $('#color_infinity2').removeClass('font_inform_new2');
        $('#color_hotline2').removeClass('font_inform_new2');
        $('#color_hotline3').removeClass('font_inform_new2');
        inset2--;
    }

}, 500);
</script>