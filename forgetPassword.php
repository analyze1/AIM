<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="VIBM.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ลืมรหัสผ่าน</title>
<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<link href="css/suzuki.css" rel="stylesheet" type="text/css" />

</head>
<body style="width:570px; height:300px; top:0;">
<?
function createRandomPassword() { // ฟังก์ชั่นสำหรับสุ่มรหัสลับ<br>
	srand( date("s") );
	    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; // ตัวแปรที่จะทำการสุ่ม จะเป็นตัวเลข ตัวเล็ก ตัวใหญ่ หรือผสมกันไปก็ใส่เพิ่มเอาเอง<br>
	    $ret_str = "";
	    $num = strlen($chars);
	    for($i=0; $i < 6; $i++) {
	        $ret_str.= $chars[rand()%$num]." ";// สุ่มเอามาสัก 6 ตัว 0 ถึง 5 ก็ 6 นั่นหล่ะน่าาา<br>
	    }
	    return $ret_str;
	}
	     $text = createRandomPassword(); // เรียกใช้หังก์ชั้นสุ่มรหัสลับ แล้วมาเก็บค่าไว้ในตัวแปร $text
	     echo '<input name="code_chk" id="code_chk" value="'.ereg_replace(" ","",$text).'"="" type="hidden">'; // ตรงนี้สำหรับเก็บค่าตัวแปรที่ได้เพื่อส่งไปทำการตรวจเช็คกับ รหัสลับ ที่ผู้ใช้กรอก ว่าถูกต้องตรงกันหรือไม่<br>
	     $font_size = 20;
	     $height = 20;
	     $width = 100;
	   // ข้างล่างนี้เป็นการสร้างภาพและเอารหัสลับที่ได้ยัดใส่เข้าไปอยู่ในภาพที่สร้าง สามารถปรับเปลี่ยนได้นะครับ
	     $im = ImageCreate($width, $height);
	     $grey = ImageColorAllocate($im, 230, 230, 230);
	     $black = ImageColorAllocate($im, 0, 0, 0);
	     $text_bbox = ImageTTFBBox($font_size, 0, "ANGSAZ.TTF", $text); // อย่าลืมก๊อปไฟล์ฟอร์นมาไว้ในโฟลเดอร์ด้วยนะ ไม่งั้นจะไม่แสดงผล<br>
	     $image_centerx = $width / 2;
	     $image_centery = $height / 2;
	     $text_x = $image_centerx - round(($text_bbox[4]/2));
	     $text_y = $image_centery + 5;
	     //$text_y = $image_centery;
	     ImageTTFText($im, $font_size, 0, $text_x, $text_y, $black, "ANGSAZ.TTF", $text);
	     ImagePng($im,"i/image-code.png");
	     ImageDestroy ($im);
	    // และสุดท้ายก็แสดงผลรูปภาพออกมา
?>
<img style="position:absolute; float:left; margin:5px;" src="i/VIBM.gif" width="300" />
<BR /><BR /><BR />
<div align="center" style="width:100%; height:100%;">
<form id="forget">

<table width="320" border="0" cellspacing="0" cellpadding="0">
  <tr height="30">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr height="30">
    <td width="100">E-Mail </td>
    <td width="220">:      <input style="width:180px;" id="mail" name="mail" type="text" /><span class="warn"> *</span></td>
  </tr>
  <tr height="30">
    <td>ชื่อผู้ติดต่อ</td>
    <td>:      <input style="width:180px;" id="admin_name" name="admin_name" type="text" /><span class="warn" > *</span></td>
  </tr>
  <tr height="1">
    <td><? echo "<img src='i/image-code.png'>"; ?></td>
     <td>: <input type="text" id="code" style="width:100px;" maxlength="6"  /> <span class="warn">*</span></td>
    </tr>
  <tr height="30">
    <td align="center" colspan="2"><input onclick="Check_txt();" type="button" name="button" id="button" value="ขอรหัสผ่าน" />
      <input type="button" name="eshow" id="eshow" value="แจ้งเปลี่ยนอีเมล" />
      <input type="reset" onclick="window.close();" name="button2" id="button2" value="ยกเลิก" /></td>
    </tr>
</table>

</form>
<div style="width:580px; margin:10px;" class="warn" align="left">
  <p>หมายเหตุ : หากท่านต้องการเปลี่ยนอีเมล กรุณากดปุ่มแจ้งเปลี่ยนอีเมล<BR />
  </p>
  <p>
    <span class="comment">02-196-8234 (ติดต่อคุณ วันวิสา)</span></p>
</div>

</div>
<div align="center" id="changemail" style="position:absolute; display:none; z-index:999; background:#FFF; width:100%; height:100%; line-height:100%;">
<img style="float:left; margin:5px; position:absolute; left:0px; top:0px;" src="i/VIBM.gif" width="300" />
<table align="center" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="middle" height="100%">
    <td align="center">
    <form id="changemailMail">
<table width="300" height="100" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Username</td>
    <td>:
      <input type="text" name="username" id="username" /> <span class="warn" > *</span></td>
  </tr>
  <tr>
    <td>ชื่อผู้ติดต่อ</td>
    <td>:
      <input type="text" name="nameUSER" id="nameUSER" /> <span class="warn" > *</span></td>
  </tr>
  <tr>
    <td>เบอร์โทรผู้ติดต่อ</td>
    <td>:
      <input name="telUSER" type="text" id="telUSER" maxlength="10" /> <span class="warn" > *</span></td>
  </tr>
  <tr>
    <td ><? echo "<img src='i/image-code.png'>"; ?></td>
    <td>: <input style="width:100px;" type="text" name="code2" id="code2" maxlength="6" /> <span class="warn" > *</span></td>
    </tr>
  <tr>
    <td colspan="2"><input onclick="Check_txt2();" type="button" name="button4" id="button4" value="แจ้งเปลี่ยนอีเมล" />
    <input type="button" id="ECLOSE" value="กลับ" /></td>
    
  </tr>
</table>
</form>
<div align="left" style="width:100%; margin-left:50px;">
<p class="warn">หมายเหตุ : <BR />
  </p>
  <p>
    <span class="comment">085-921-3636 คุณโสภาพรรณ (นาย)<BR />
      085-921-5454 คุณรณกร (เอก)</span></p>
      </div>
</td>
  </tr>
</table>

</div>
<script type="text/javascript">
$('#ECLOSE').click(function(){
	$('#changemail').hide();
});
$('#eshow').click(function(){
	$('#changemail').show();
});
$('#changemail').css("position", "fixed");
$('#changemail').css("top", ($(window).height() - $('#changemail').height())/ 2  + "px");
$('#changemail').css("left", ($(window).width() - $('#changemail').width()) / 2  + "px");

	 
function Check_txt(){
	if(document.getElementById('code').value==""){ // ตรงนี้เช็คว่าได้กรอกรหัสหรือยัง
	 alert("กรุณาระบุ CODE ด้วยครับ");
	 document.getElementById('code').focus();
	 return false;
	}
 if(document.getElementById('code').value.toUpperCase()!=document.getElementById('code_chk').value){ // ถ้ากรอกแล้ว รหัสถูกต้องไหม>
	 alert("Code ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง"); // ถ้าไม่ถูกต้องก็แจ้งให้เขาทราบ
	 document.getElementById('code').value=""; // ล้างค่าในเท็กซ์ออกเพื่อพร้อมสำหรับการกรอกรหัสลับใหม่
	 document.getElementById('code').focus();
	 return false;
	}
if($("#mail").val()==""){
			alert("กรุณากรอกอีเมล")
			$("#mail").focus();
			return false;
		}
if($("#admin_name").val()==""){
			alert("กรุณากรอกชื่อผู้ติดต่อ")
			$("#admin_name").focus();
			return false;
		}

			S_M();
	}
	
function S_M(val) {
	 var url = "ajax/Ajax_Forget.php"; // the script where you handle the form input.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#forget").serialize(), // serializes the form's elements.
           success: function(data)
           {
               alert('ขอบคุณที่ใช้บริการเจ้าหน้าที่จะติดต่อกลับไปภายใน 30 นาที'); // show response from the php script.
			   //window.close();
           }
         });
    return false; // avoid to execute the actual submit of the form.
}
function S_M2(val) {
	 var url = "ajax/Ajax_Forget.php"; // the script where you handle the form input.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#changemailMail").serialize(), // serializes the form's elements.
           success: function(data)
           {
               alert('ขอบคุณที่ใช้บริการเจ้าหน้าที่จะติดต่อกลับไปภายใน 30 นาที'); // show response from the php script.
			   //window.close();
           }
         });
    	 return false; // avoid to execute the actual submit of the form.
}
function Check_txt2(){
	if(document.getElementById('code2').value==""){ // ตรงนี้เช็คว่าได้กรอกรหัสหรือยัง
	 alert("กรุณาระบุ CODE ด้วยครับ");
	 document.getElementById('code2').focus();
	 return false;
	}
 if(document.getElementById('code2').value.toUpperCase()!=document.getElementById('code_chk').value){ // ถ้ากรอกแล้ว รหัสถูกต้องไหม>
	 alert("Code ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง"); // ถ้าไม่ถูกต้องก็แจ้งให้เขาทราบ
	 document.getElementById('code2').value=""; // ล้างค่าในเท็กซ์ออกเพื่อพร้อมสำหรับการกรอกรหัสลับใหม่
	document.getElementById('code2').focus();
	 return false;
	}
if($("#nameUSER").val()==""){
			alert("กรุณากรอก USERNAME")
			$("#nameUSER").focus();
			return false;
		}
if($("#nameUSER").val()==""){
			alert("กรุณากรอกชื่อผู้ติดต่อ")
			$("#nameUSER").focus();
			return false;
		}

			S_M2();
	}
</script>

</body>
</html>