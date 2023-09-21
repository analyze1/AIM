<?php
include "check-ses.php";
// include "../inc/connectdbs.inc.php";	
require("../inc/connectdbs.pdo.php");
// header('Content-Type: text/html; charset=utf-8');
// mysql_select_db($db1,$cndb1);

/*header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=document_name.doc");
echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo "<b>My first document</b>";
echo "</body>";
echo "</html>";*/

?>
<script src="js/js_Insurance_Act_new.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>

<script type="text/javascript">
// function checkText()
// {
// 	var elem = document.getElementById('car_body').value;
// 	if(!elem.match(/^([a-z0-9\_])+$/i))
// 	{
// 		alert("กรอกได้เฉพาะ A-Z, 0-9 ");
// 		document.getElementById('car_body').value = "";
// 	}
// }
// 	function checkText2()
// {
// 	var elem = document.getElementById('n_motor').value;
// 	if(!elem.match(/^([a-z0-9\_])+$/i))
// 	{
// 		alert("กรอกได้เฉพาะ A-Z, 0-9 ");
// 		document.getElementById('n_motor').value = "";
// 	}

// }
</script>

<form name="Insurance" id="Insurance">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-header widget-header-flat">
                    <h4>แบบฟอร์ม !!!</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row-fluid">
                            <div class="span12">


                                <!-- <a href="javascript:void(0);" data-file="PRB_Police.docx">แบบฟอร์มแจ้งความ</a><br/>
              <a href="javascript:void(0);" data-file="Powerofattorney.docx">หนังสือมอบอำนาจ</a><br/> -->
                                <style>
                                .myofficeviewer {
                                    box-shadow: 0 0.25em 0.25em rgba(0, 0, 0, 0.1);
                                    border: 1px solid #ECECEC;
                                }
                                </style>
                                <?php
                                include 'police_new_word.php';
                                ?>
                                <!-- <iframe  class="myofficeviewer" name="officeviewer" id="officeviewer1" frameborder="0" height="750" width="100%"
             src=""  >  
           </iframe>   -->
                                <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
                                <script type="text/javascript">
                                $(function() {
                                    $("a[data-file]").on("click", function() {
                                        var viewerAgent =
                                            'https://view.officeapps.live.com/op/view.aspx?src=';
                                        var fileUrl = 'https://viriyah.net/mitsubishi/doc/';
                                        var fileData = $(this).data(
                                            'file'); // ได้ชื่อไฟล์ที่เรากำหนดใน data-file
                                        var fullPathFile = viewerAgent + fileUrl + fileData;
                                        // console.log(fullPathFile);
                                        $("#officeviewer1").attr("src", fullPathFile);
                                        // alert($(this).data('file'));
                                    });
                                });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>
</div>