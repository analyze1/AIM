<?php
include "check-ses.php";
header('Content-Type: text/html; charset=utf-8');
// mysql_select_db($db1,$cndb1);
?>
<!DOCTYPE html>
<html>

<head>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>  -->

    <style type="text/css">
        .textcenter {
            text-align: center;
            font-size: 20px;
        }

        .date_P1 {
            text-align: right;
            font-size: 16px;
        }

        .head_P1 {
            text-align: left;
            font-size: 16px;
        }

        .number1 {
            margin-bottom: 0;
            font-size: 16px;
            text-indent: 3.5em;
            margin-top: 0;
            line-height: 25px !important;
        }

        .number2 {
            text-align: center;
            font-size: 16px;
            line-height: 30px !important;
        }

        .powero_1 {
            margin-bottom: 0;
            font-size: 16px;
            text-indent: 3.5em !important;
            line-height: 25px !important;
        }

        .sign {
            font-size: 16px !important;
            line-height: 25px !important;
        }

        .description_1 {
            font-size: 16px !important;
            line-height: 25px !important;
        }
    </style>
    <title>Page Title</title>
</head>

<body>
    <div class="body">
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">แบบฟอร์มแจ้งความ</a></li>
            <li class=""><a href="#profile" data-toggle="tab">หนังสือมอบอำนาจ</a></li>
        </ul>
        <div id="myTabContent" class="tab-content" style="background-color: white;">
            <div class="tab-pane fade active in" id="home">
                <div>
                    <a href="pages/document_police.php">
                        <span style="float: right; color: green; cursor: pointer; font-size: 19px;" alt="ดาวน์โหลดเอกสาร" title="ดาวน์โหลดเอกสาร">
                            <i class="icon-download-alt"> Download...</i>
                        </span>
                    </a>
                </div>
                <center>
                    <table style="width: 60%;" border="1">
                        <tr>
                            <td style="padding: 50px !important;">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="0" colspan="2" class="textcenter">
                                            <strong>แบบฟอร์ม</strong>
                                            <br /><br />
                                            <strong>แจ้งความกรมธรรม์ประกันภัยคุ้มครองผู้ประสบภัยภาคบังคับ (พ.ร.บ.)
                                                สูญหาย</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="line-height: 40px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="10%">&nbsp;</td>
                                        <td width="90%" class="date_P1">
                                            วันที่..............................................</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="line-height: 35px;">&nbsp;</td>
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
                                        <td>1. หนังสือมอบอำนาจ</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="line-height: 25px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="powero_1">เนื่องด้วยข้าพเจ้าผู้จำหน่ายรถยนต์มิตซูบิชิโดย
                                            <?php echo $_SESSION["strName"]; ?>
                                            ได้รับมอบหมายให้ดูแลการแจ้งงานกรมธรรม์ประกันภัยคุ้มครองผู้ประสบภัยภาคบังคับ
                                            (พ.ร.บ.)
                                            ให้ลูกค้ารถยนต์ยี่ห้อมิตซูบิชิมีความประสงค์แจ้งกรมธรรม์ประกันภัยคุ้มครองผู้ประสบภัยภาคบังคับ
                                            (พ.ร.บ.) สูญหายรายการดังต่อไปนี้</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="line-height: 5px;">&nbsp;</td>
                                    </tr>
                                    <tr class="number1">
                                        <td colspan="2">1.&nbsp;&nbsp;เลขที่ พ.ร.บ………………………………………</td>
                                    </tr>
                                    <tr class="number1">
                                        <td colspan="2">2.&nbsp;&nbsp;เลขที่ พ.ร.บ………………………………………</td>
                                    </tr>
                                    <tr class="number1">
                                        <td colspan="2">3.&nbsp;&nbsp;เลขที่ พ.ร.บ………………………………………</td>
                                    </tr>
                                    <tr class="number1">
                                        <td colspan="2">4.&nbsp;&nbsp;เลขที่ พ.ร.บ………………………………………</td>
                                    </tr>
                                    <tr class="number1">
                                        <td colspan="2">5.&nbsp;&nbsp;เลขที่ พ.ร.บ………………………………………</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="line-height: 10px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="powero_1">
                                            ขอยืนยันว่ากรมธรรม์ประกันภัยคุ้มครองผู้ประสบภัยภาคบังคับ (พ.ร.บ.)
                                            ข้างต้นสูญหาย มิได้นำไปแจ้งคุ้มครองเพื่อทำประกันแต่อย่างใด
                                            จึงขอแจ้งความไว้เป็นหลักฐาน</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="line-height: 50px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td align="center" class="sign">
                                            ลงชื่อ....................................................... ผู้แจ้ง</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td align="center" class="sign">
                                            (.......................................................)</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td align="center" class="sign">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงชื่อ.......................................................กรรมการผู้มีอำนาจ
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td align="center" class="sign">
                                            (.......................................................)</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td align="center" class="sign">&nbsp;&nbsp;<?php echo $_SESSION["strName"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="line-height: 50px;">&nbsp;</td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                    </table>
                </center>
            </div>
            <div class="tab-pane fade" id="profile">
                <div>
                    <a href="pages/document_police_2.php">
                        <span style="float: right; color: green; cursor: pointer; font-size: 19px" alt="ดาวน์โหลดเอกสาร" title="ดาวน์โหลดเอกสาร">
                            <i class="icon-download-alt fa-lg"> Download...</i>
                        </span>
                    </a>
                </div>
                <center>
                    <table style="width: 60%;" border="1">
                        <tr>
                            <td style="padding: 50px !important;">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="0" colspan="2" align="center" class="textcenter">
                                            <strong>หนังสือมอบอำนาจ</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="line-height: 40px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p align="right" class="date_P1">
                                                วันที่................................................... </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="line-height: 35px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="powero_1">
                                            โดยหนังสือฉบับนี้
                                            ข้าพเจ้า...................................................................................................................................................................................
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="description_1">
                                            โดย..............................................................................................................ตำแหน่ง.........................................................................................................
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="description_1">
                                            สำนักงานตั้งอยู่เลขที่.........................................................................................................................................................................................................
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="description_1">
                                            ขอมอบอำนาจให้.........................................................................................เลขประจำตัวประชาชน..................................................................................
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="description_1">
                                            อยู่บ้านเลขที่......................................................................................................................................................................................................................
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="description_1">เป็นผู้รับมอบอำนาจที่จะกระทำการแทน
                                            เฉพาะในกิจการตามที่จะกล่าวต่อไปนี้ คือ
                                            .........................................................................................................
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="description_1">
                                            ...........................................................................................................................................................................................................................................
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="powero_1">
                                            ข้าพเจ้าขอรับรองว่าเป็นลายมือชื่อของผู้มอบอำนาจจริง 
                                            และการที่ผู้รับมอบอำนาจได้กระทำไปภายในขอบอำนาจดังระบุในหนังสือนี้ถือเสมือนหนึ่งว่าได้กระทำโดยข้าพเจ้าเอง 
                                            เพื่อเป็นหลักฐานจึงได้ลงลายมือชื่อไว้เป็นสำคัญต่อหน้าพยาน</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="line-height: 50px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="56%">&nbsp;</td>
                                        <td width="44%">
                                            <div align="left" class="sign">
                                                ลงชื่อ.................................................................ผู้มอบอำนาจ
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                            <div align="left" class="sign" style="margin-left: 31px;">
                                                (..................................................................)
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                            <div align="left" class="sign">
                                                ลงชื่อ.................................................................ผู้มอบอำนาจ
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                            <div align="left" class="sign" style="margin-left: 31px;">
                                                (..................................................................)
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                            <div align="left" class="sign">
                                                ลงชื่อ.................................................................พยาน
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                            <div align="left" class="sign" style="margin-left: 31px;">
                                                (..................................................................)
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                            <div align="left" class="sign">
                                                ลงชื่อ.................................................................พยาน
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                            <div align="left" class="sign" style="margin-left: 31px;">
                                                (..................................................................)
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                    </table>
                </center>
            </div>
        </div>
    </div>
</body>

</html>