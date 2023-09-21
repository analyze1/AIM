<?php
include "check-ses.php";
include "../../inc/connectdbs.pdo.php"; 

?>
<script src="js/Profile.js" type="text/javascript"></script>
<link href="css/profile.css" rel="stylesheet" type="text/css" />
<?
$query = "SELECT 
*
FROM tb_customer ";
$query .= " WHERE  tb_customer.user='".$_SESSION["strUser"]."'";
$objQuery = mysql_query($query) or die ("Error Query [".$query."]");
$row = mysql_fetch_array($objQuery);


$query2 = "SELECT 
*
FROM profile_customer ";
$query2 .= " WHERE  username='".$_SESSION["strUser"]."'";
$objQuery2 = mysql_query($query2) or die ("Error Query [".$query2."]");
$row2 = mysql_fetch_array($objQuery2);
if($row2['image_company']==''){
	$picturess='images/nophoto.png';
}
else{
	$picturess=$row2['image_company'];
}
if($row2['image_ceo']==''){
	$picturess1='images/no_photo.jpg';
}
else{
	$picturess1=$row2['image_ceo'];
}
if($row2['image_sale1']==''){
	$picturess2='images/no_photo.jpg';
}
else{
	$picturess2=$row2['image_sale1'];
}
if($row2['image_sale2']==''){
	$picturess3='images/no_photo.jpg';
}
else{
	$picturess3=$row2['image_sale2'];
}
if($row2['image_finance1']==''){
	$picturess4='images/no_photo.jpg';
}
else{
	$picturess4=$row2['image_finance1'];
}
if($row2['image_finance2']==''){
	$picturess5='images/no_photo.jpg';
}
else{
	$picturess5=$row2['image_finance2'];
}
?>
<style type="text/css">
<!--
.style1 {color: #999999}
-->
</style>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<br />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td width="10%">
        <div style="margin-left:20px; height:150px; width:150px;">
        <img style="position:absolute; margin:5px" id="pictures" src="<?=$picturess?>"/>    </div>
    </div>
    </td>
    <td>
    
    <div align="left" style="width:100%; padding-left:30px; height:150px;">
    	<span style="color:#000066; font-weight:600; font-size:16px; line-height:30px;">
			<?=$row2['name_company']?><BR />
            ที่อยู่ <?=$row2['add_company']?><BR />
            โทร. <?=$row2['tel_company']?> แฟกซ์ <?=$row2['fax_company']?><BR />
            E-mail : <?=$row2['email_company']?>
        </span>        </div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><div align="center"><a href="#load_Search_TotalSale"><img src="images/money.jpg" border="0" style="cursor:pointer;"/></a></div>
          </td>
        </tr>
        </table>
  
	
    
<form class="semantic" enctype="multipart/form-data" method="post" name="Insurance" id="Insurance">
<input name="name_company" id="name_company" type="hidden" value="<?=$row2['name_company']?>" />
<!-- ---------------------------- ข้อมูลการแจ้งประกันภัย SUZUKI ---------------------------------/// -->
<fieldset>
  <legend>ข้อมูลการแจ้งประกันภัย Mitsubishi</legend>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="15%" rowspan="2" valign="top">
         
    <img style="position:absolute; margin:5px" id="pictures1" width="150" height="150" src="<?=$picturess1?>"/>
   
          </td>
          <td width="35%" valign="top">
          <div>
          <label for="first_name">เจ้าของบริษัท </label>
   	  <input type="text" name="ceo_name" value="<?=$row2['ceo_name']?>" size="30" id="ceo_name"></div>
  
    <div>
      <label for="last_name">ที่อยู่บริษัท</label>
      <textarea name="AddCompany" id="AddCompany" rows="5" cols="50"><?=$row['location']?></textarea>
    </div>          
          </td>
          <td width="35%">
          <div>
              <label for="phone_number">รหัสตัวแทน :</label>
             <input type="text" name="IdDealer" value="<?=$row['user']?>" size="8" id="IdDealer" readonly="readonly">
           </div>
          
           <div>
              <label for="phone_number">โทรศัพท์บริษัท :</label>
             <input type="text" name="tel_company" value="<?=$row2['tel_company']?>" size="15" id="tel_company">
           </div>
           <div>
              <label for="phone_number">โทรสารบริษัท :</label>
              <input type="text" name="fax_company" value="<?=$row2['fax_company']?>" size="15" id="fax_company">
           </div>
          <div>
      <label for="last_name">Email :</label>
      <input type="text" name="email_company" value="<?=$row2['email_company']?>" size="30" id="email_company" >
    </div>          
    </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
  </fieldset>

<!-- --------------------------------ข้อมูลฝ่ายการเงิน / บัญชี---------------------------// --> 
<fieldset>
  <legend>ข้อมูลฝ่ายแจ้งประกันภัย</legend>
  	
    
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="15%" rowspan="2" valign="top">
          <img style="position:absolute; margin:5px" id="pictures2" width="150" height="150" src="<?=$picturess2?>"/>
    </td>
          <td width="30%" valign="top">
          <div>
          <label for="first_name">ชื่อผู้ติดต่อ 1 :</label>
          <input type="text" name="sale1_name" value="<?=$row2['sale1_name']?>" size="30" id="sale1_name">
          <div>
            <label for="label">มือถือผู้ติดต่อ 1 :</label>
            <input type="text" name="sale1_tel1" value="<?=$row2['sale1_tel1']?>" size="15" id="sale1_tel1" class="error" />
          </div>
          </div>
  
          <div>
            <label for="label2">เบอร์โทรติดต่อ 1 :</label>
            <input type="text" name="sale1_tel2" value="<?=$row2['sale1_tel2']?>" size="15" id="sale1_tel2" />
            </div>
          <div>
          <label for="last_name">Email(ติดต่อ 1) :</label>
          <input type="text" name="sale1_email" value="<?=$row2['sale1_email']?>" size="30" id="sale1_email" >
        </div>
          </td>
          <td align="left" valign="top" width="15%" rowspan="2">
          <img style="position:absolute; margin:5px" id="pictures3" width="150" height="150" src="<?=$picturess3?>"/>
    
          </td>
          <td width="30%">
          <div>
          <label for="first_name">ชื่อติดต่อ 2 :</label>
          <input type="text" name="sale2_name" value="<?=$row2['sale2_name']?>" size="30" id="sale2_name">
          <div>
            <label for="label">มือถือติดต่อ 2 :</label>
            <input type="text" name="sale2_tel1" value="<?=$row2['sale2_tel1']?>" size="15" id="sale2_tel1" class="error" />
           </div>
          </div>
  
          <div>
            <label for="label2">เบอร์โทรติดต่อ 2 :</label>
            <input type="text" name="sale2_tel2" value="<?=$row2['sale2_tel2']?>" size="15" id="sale2_tel2" />
          </div>
          <div>
          <label for="last_name">Email(ติดต่อ 2) :</label>
          <input type="text" name="sale2_email" value="<?=$row2['sale2_email']?>" size="30" id="sale2_email" >
        </div>
        </td>
        </tr>
        <tr style="line-height:45px;">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
  </fieldset>

  
<!-- --------------------------------ข้อมูลฝ่ายการเงิน / บัญชี---------------------------// --> 
<fieldset>
  <legend>ข้อมูลฝ่ายการเงิน / บัญชี</legend>
  	
    
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="15%" rowspan="2" valign="top"><img style="position:absolute; margin:5px" id="pictures4" width="150" height="150" src="<?=$picturess4?>"/>
    </td>
          <td width="30%" valign="top">
          <div>
          <label for="first_name">ชื่อเจ้าหน้าที่การเงิน </label>
          <input type="text" name="finance1_name" value="<?=$row2['finance1_name']?>" size="30" id="finance1_name">
          <div>
            <label for="label">มือถือการเงิน :</label>
            <input type="text" name="finance1_tel1" value="<?=$row2['finance1_tel1']?>" size="15" id="finance1_tel1" class="error" />
          </div>
          </div>
  
          <div>
            <label for="label2">เบอร์โทรการเงิน :</label>
            <input type="text" name="finance1_tel2" value="<?=$row2['finance1_tel2']?>" size="15" id="finance1_tel2" />
          </div>
          <div>
          <label for="last_name">Email :</label>
          <input type="text" name="finance1_email" value="<?=$row2['finance1_email']?>" size="30" id="finance1_email" >
        </div>          </td>
          <td align="left" valign="top" width="15%" rowspan="2"><img style="position:absolute; margin:5px" id="pictures5" width="150" height="150" src="<?=$picturess5?>"/>
   </td>
          <td width="30%">
          <div>
          <label for="first_name">ชื่อเจ้าหน้าที่บัญชี </label>
          <input type="text" name="finance2_name" value="<?=$row2['finance2_name']?>" size="30" id="finance2_name">
          <div>
            <label for="label">มือถือบัญชี :</label>
            <input type="text" name="finance2_tel1" value="<?=$row2['finance2_tel1']?>" size="15" id="finance2_tel1" class="error" />
           </div>
          </div>
  
          <div>
            <label for="label2">เบอร์โทรบัญชี :</label>
            <input type="text" name="finance2_tel2" value="<?=$row2['finance2_tel2']?>" size="15" id="finance2_tel2" />
          </div>
          <div>
          <label for="last_name">Email :</label>
          <input type="text" name="finance2_email" value="<?=$row2['finance2_email']?>" size="30" id="finance2_email" >
        </div>        </td>
        </tr>
        <tr style="line-height:45px;">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
  </fieldset>


 

  <div align="center">
   <img style="cursor:pointer;" id="SaveProfile" name="SaveProfile" src="images/save.png" width="222" height="57" />
  </div> 
</form>


<? mysql_close(); ?>