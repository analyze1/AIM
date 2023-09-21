<?php
include "check-ses.php";
// include "../inc/connectdbs.pdo.php";
header('Content-Type: text/html; charset=utf-8');

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <style type="text/css">
        body {
            font-family: "Angsana New" !important;
        }

        .textcenter {
            text-align: center;
            font-size: 25px;
        }

        .date_P1 {
            text-align: right;
            font-size: 21px;
        }

        .head_P1 {
            text-align: left;
            font-size: 21px;
        }

        .number1 {
            margin-bottom: 0;
            font-size: 21px;
            text-indent: 3.5em;
            margin-top: 0;
            line-height: 25px !important;
        }

        .number2 {
            text-align: center;
            font-size: 21px;
            line-height: 30px !important;
        }

        .powero_1 {
            margin-bottom: 0;
            font-size: 21px;
            text-indent: 3.5em !important;
            line-height: 25px !important;
        }

        .sign {
            font-size: 21px !important;
            line-height: 25px !important;
        }
    </style>
    <?php
    header("Content-type: application/vnd.ms-word");
    header("Content-Disposition: attachment;Filename=PRB_Police.doc");
    ?>
    <title>Page Title</title>
</head>

<body>
    <div class="body">
        <div class="panel panel-default">
            <!-- <div class="panel-heading">
				<h3 class="panel-title">เอกสารแบบแบบฟอร์ม</h3>
			</div> -->
            <div class="panel-body">
                <center>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="width: 60%">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading" role="tab" id="headingOne">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										แบบฟอร์มแจ้งความ
									</a>
									<span style="float: right; color: green; cursor: pointer;" alt="ดาวน์โหลดเอกสาร" title="ดาวน์โหลดเอกสาร">
										<i class="icon-download-alt fa-lg"> Download...</i>
									</span>
								</h4>
							</div> -->
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">

                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td height="0" colspan="2" class="textcenter">
                                                <strong>แจ้งความกรมธรรม์ประกันภัยคุ้มครองผู้ประสบภัยภาคบังคับ (พ.ร.บ.) สูญหาย</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="line-height: 50px;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="15%">&nbsp;</td>
                                            <td width="85%" class="date_P1">วันที่..............................................</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="line-height: 45px;">&nbsp;</td>
                                        </tr>
                                        <tr class="head_P1">
                                            <td>เรื่อง</td>
                                            <td>แจ้งกรมธรรม์ประกันภัยคุ้มครองผู้ประสบภัยภาคบังคับ (พ.ร.บ.) สูญหาย</td>
                                        </tr>
                                        <tr class="head_P1">
                                            <td>เรียน  </td>
                                            <td>ท่านเจ้าพนักงานสอบสวน สถานีตำรวจนครบาล/ภูธร .........................</td>
                                        </tr>
                                        <tr class="head_P1">
                                            <td>สิ่งที่แนบมา</td>
                                            <td><label style="font-size: 14px;">1.</label> หนังสือมอบอำนาจ</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="line-height: 25px;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="powero_1">เนื่องด้วยข้าพเจ้าผู้จำหน่ายรถยนต์มิตซูบิชิโดย <?php echo $_SESSION["strName"]; ?> ได้รับมอบหมายให้ดูแลการแจ้งงานกรมธรรม์ประกันภัยคุ้มครองผู้ประสบภัยภาคบังคับ (พ.ร.บ.) ให้ลูกค้ารถยนต์ยี่ห้อซูซูกิมีความประสงค์แจ้งกรมธรรม์ประกันภัยคุ้มครองผู้ประสบภัยภาคบังคับ (พ.ร.บ.) สูญหายรายการดังต่อไปนี้</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="line-height: 5px;">&nbsp;</td>
                                        </tr>
                                        <tr class="number1">
                                            <td colspan="2">1.&nbsp;&nbsp;เลขที่ พ.ร.บ………………………………………
                                            </td>
                                        </tr>
                                        <tr class="number1">
                                            <td colspan="2">2.&nbsp;&nbsp;เลขที่ พ.ร.บ………………………………………
                                            </td>
                                        </tr>
                                        <tr class="number1">
                                            <td colspan="2">3.&nbsp;&nbsp;เลขที่ พ.ร.บ………………………………………
                                            </td>
                                        </tr>
                                        <tr class="number1">
                                            <td colspan="2">4.&nbsp;&nbsp;เลขที่ พ.ร.บ………………………………………
                                            </td>
                                        </tr>
                                        <tr class="number1">
                                            <td colspan="2">5.&nbsp;&nbsp;เลขที่ พ.ร.บ………………………………………
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="line-height: 10px;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="powero_1">ขอยืนยันว่ากรมธรรม์ประกันภัยคุ้มครองผู้ประสบภัยภาคบังคับ (พ.ร.บ.) ข้างต้นสูญหาย มิได้นำไปแจ้งคุ้มครองเพื่อทำประกันแต่อย่างใด จึงขอแจ้งความไว้เป็นหลักฐาน</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="line-height: 50px;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td align="center" class="sign">ลงชื่อ....................................................... ผู้แจ้ง</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td align="center" class="sign">(.......................................................)</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td align="center" class="sign">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงชื่อ.......................................................กรรมการผู้มีอำนาจ</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td align="center" class="sign">(.......................................................)</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td align="center" class="sign">&nbsp;&nbsp;<?php echo $_SESSION["strName"]; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </center>
            </div>
        </div>

</body>

</html>