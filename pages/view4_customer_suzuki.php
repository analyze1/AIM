<?php ini_set('display_errors', 0);
        include "check-ses.php"; 
	//include "../inc/checksession.inc.php";
	include "../inc/connectdbs.inc.php"; 




  //----------------- Condition Statistic Customer----------------------//
	$sql_ins = 
	"SELECT *
	FROM insuree
	INNER JOIN data ON (insuree.id_data=data.id_data)
	INNER JOIN tb_cost ON (data.costCost=tb_cost.id)
	
	WHERE insuree.id_data='".$_GET["iddata"]."'  GROUP BY insuree.id_data  ";
	mysql_select_db($db1,$cndb1);
	$obj_ins = mysql_query($sql_ins,$cndb1) or die ("Error sql_ins [".$sql_ins."]");
	$row_ins = mysql_fetch_array($obj_ins);

	$sql_cerf = 
	"SELECT certificate_datestamp,invoice_detail.id_data
	FROM certificate
	INNER JOIN invoice_detail ON certificate.inv_no=invoice_detail.inv_no
	WHERE invoice_detail.id_data='".$_GET["iddata"]."' Group By invoice_detail.id_data ORDER BY idC ASC LIMIT 1 ";
	mysql_select_db($db3,$cndb3);
	$obj_cerf = mysql_query($sql_cerf,$cndb3) or die ("Error sql_cerf [".$sql_cerf."]");
	$row_cerf = mysql_fetch_array($obj_cerf);

	$sql_year = 
	"SELECT count(id_data) AS count_year FROM insuree WHERE id_data='".$_GET["iddata"]."' Group By id_data ";
	mysql_select_db($db1,$cndb1);
	$obj_year = mysql_query($sql_year,$cndb1) or die ("Error sql_year [".$sql_year."]");
	$row_year = mysql_fetch_array($obj_year);

//echo $_GET["iddata"];
	



//----------------- Condition ----------------------//

if(trim($row_ins["tel_mobi"])!='' && trim($row_ins["tel_mobi"])!='-'){
	$tel_mobile='10';
}
if(trim($row_ins["tel_mobi2"])!=''  && trim($row_ins["tel_mobi2"])!='-'){
	$tel_mobile2='20';
}
if(trim($row_ins["tel_mobi3"])!=''  && trim($row_ins["tel_mobi3"])!='-' ){
	$tel_mobile3='20';
}
if(trim($row_ins["tel_home"])!=''  && trim($row_ins["tel_home"])!='-'){
	$tel_home='25';
}
if(trim($row_ins["fax"])!=''  && trim($row_ins["fax"])!='-'){
	$tel_office='25';
}

if(trim($row_ins["email"])!=''  && trim($row_ins["email"])!='-'){
	$email='25';
}
if(trim($row_ins["id_line"])!=''  && trim($row_ins["id_line"])!='-'){
	$id_line='25';
}

if(trim($row_ins["vocation"])!=''  && trim($row_ins["vocation"])!='-'){
	$vocation='10';
}
if(trim($row_ins["SendAdd"])!=''  && trim($row_ins["SendAdd"])!='-'){
	$SendAdd='10';
}


$grand=$tel_mobile+$tel_mobile2+$tel_mobile3+$tel_home+$email+$id_line+$tel_office+$vocation+$SendAdd;

// ข้อมูลประกันภัย

$commition = floatval(preg_replace("/[^-0-9\.]/","",$row_ins["commition"]));
$other = floatval(preg_replace("/[^-0-9\.]/","",$row_ins["other"]));
$total_commition = floatval(preg_replace("/[^-0-9\.]/","",$row_ins["total_commition"]));



$Discount=number_format((($commition+$other)/$total_commition)*100);


//------- ส่วนลด ------------//
if($Discount<=1){
	$txt_Discount='<div style="float: left;">5</div>';
}else if($Discount>1 && $Discount<=5) {
	$txt_Discount='<div style="float: left;">4</div>';
}else if($Discount>5 && $Discount<=10) {
	$txt_Discount='<div style="float: left;">3</div>';
}else if($Discount>10 && $Discount<=15) {
	$txt_Discount='<div style="float: left;">2</div>';
}else if($Discount>15) {
	$txt_Discount='<div style="float: left;">1</div>';
}

// ------------- ระดับ เบี้ยชำระ -------------//
//$row_cerf["certificate_datestamp"]='2015-09-31';

	$date7=date ("Y-m-d", strtotime("+7 day", strtotime($row_cerf["certificate_datestamp"]))); //$row_ins["start_date"]
	$date15=date ("Y-m-d", strtotime("+15 day", strtotime($row_cerf["certificate_datestamp"])));
	$date30=date ("Y-m-d", strtotime("+10 day", strtotime($row_cerf["certificate_datestamp"])));





if($row_cerf["certificate_datestamp"]<=$row_ins["start_date"]){
	$Payment_Pre='<div style="float: left;">A</div>';
}else if($row_cerf["certificate_datestamp"]>$row_ins["start_date"] && $row_cerf["certificate_datestamp"]<=$date7) {
	$Payment_Pre='<div style="float: left;">B</div>';
}else if($row_cerf["certificate_datestamp"]>$date7 && $row_cerf["certificate_datestamp"]<=$date15) {
	$Payment_Pre='<div style="float: left;">C</div>';
}else if($row_cerf["certificate_datestamp"]>$date15 && $row_cerf["certificate_datestamp"]<=$date30) {
	$Payment_Pre='<div style="float: left;">D</div>';
}else if($row_cerf["certificate_datestamp"]>$date30) {
	$Payment_Pre='<div style="float: left;">E</div>';
}


// ------------- ระดับ เบี้ยชำระ -------------//

if($row_year["count_year"]==5){
	$Num_year='O';
}else if($row_year["count_year"]==4) {
	$Num_year='L';
}else if($row_year["count_year"]==3) {
	$Num_year='M';
}else if($row_year["count_year"]==2) {
	$Num_year='N';
}else if($row_year["count_year"]==1) {
	$Num_year='K';
}



// ------------- ระดับ เคลม -------------//
$cal_claim=0.00;
$total_pre=str_replace(",","",$row_ins["total_pre"]);
$cal_claim=number_format(($row_ins["claim_amount"]*100)/$total_pre);


if($cal_claim<1){
	$claim='<div style="margin-top: -1.5px;float: left; "><i class="icon-star icon-white " ></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i></div>';
}else if($cal_claim>=1 && $cal_claim<=20) {
	$claim='<div style="margin-top: -1.5px;float: left;"><i class="icon-star icon-white" ></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i></div>';
}else if($cal_claim>20 && $cal_claim<=40) {
	$claim='<div style="margin-top: -1.5px;float: left;"><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i></div>';
}else if($cal_claim>40 && $cal_claim<=60) {
	$claim='<div style="margin-top: -1.5px;float: left;"><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i></div>';
}else if($cal_claim>60) {
	$claim='<div style="margin-top: -1.5px;float: left;"><i class="icon-star icon-white"></i></div>';
}


// ------------- ระดับ จำนวนกรมธรรม์ -------------//

$policy_amount=$row_ins["policy_amount"];


$grand_statistic=$txt_Discount.''.$Payment_Pre.''.$claim.''.$Num_year.''.$policy_amount;

//******************* Condition Statistic ************************************//

// ข้อมูลประกันภัย

$commition = floatval(preg_replace("/[^-0-9\.]/","",$row_ins["commition"]));
$other = floatval(preg_replace("/[^-0-9\.]/","",$row_ins["other"]));
$total_commition = floatval(preg_replace("/[^-0-9\.]/","",$row_ins["total_commition"]));


$Discount=number_format((($commition+$other)/$total_commition)*100);


//------- ส่วนลด ------------//
if($Discount<=1){
	$txt_Discount='5';
}else if($Discount>1 && $Discount<=5) {
	$txt_Discount='4';
}else if($Discount>5 && $Discount<=10) {
	$txt_Discount='3';
}else if($Discount>10 && $Discount<=15) {
	$txt_Discount='2';
}else if($Discount>15) {
	$txt_Discount='1';
}

// ------------- ระดับ เบี้ยชำระ -------------//
//$row_cerf["certificate_datestamp"]='2015-09-31';

	$date7=date ("Y-m-d", strtotime("+7 day", strtotime($row_cerf["certificate_datestamp"]))); //$row_ins["start_date"]
	$date15=date ("Y-m-d", strtotime("+15 day", strtotime($row_cerf["certificate_datestamp"])));
	$date30=date ("Y-m-d", strtotime("+10 day", strtotime($row_cerf["certificate_datestamp"])));





if($row_cerf["certificate_datestamp"]<=$row_ins["start_date"]){
	$Payment_Pre='A';
}else if($row_cerf["certificate_datestamp"]>$row_ins["start_date"] && $row_cerf["certificate_datestamp"]<=$date7) {
	$Payment_Pre='B';
}else if($row_cerf["certificate_datestamp"]>$date7 && $row_cerf["certificate_datestamp"]<=$date15) {
	$Payment_Pre='C';
}else if($row_cerf["certificate_datestamp"]>$date15 && $row_cerf["certificate_datestamp"]<=$date30) {
	$Payment_Pre='D';
}else if($row_cerf["certificate_datestamp"]>$date30) {
	$Payment_Pre='E';
}


// ------------- ระดับ เบี้ยชำระ -------------//

if($row_year["count_year"]==5){
	$Num_year='O';
}else if($row_year["count_year"]==4) {
	$Num_year='L';
}else if($row_year["count_year"]==3) {
	$Num_year='M';
}else if($row_year["count_year"]==2) {
	$Num_year='N';
}else if($row_year["count_year"]==1) {
	$Num_year='K';
}



// ------------- ระดับ เคลม -------------//
$cal_claim=0.00;
$total_pre=str_replace(",","",$row_ins["total_pre"]);
$cal_claim=number_format(($row_ins["claim_amount"]*100)/$total_pre);


if($cal_claim<1){
	$claim='<i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i>';
}else if($cal_claim>=1 && $cal_claim<=20) {
	$claim='<i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i>';
}else if($cal_claim>20 && $cal_claim<=40) {
	$claim='<i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i>';
}else if($cal_claim>40 && $cal_claim<=60) {
	$claim='<i class="icon-star"></i><i class="icon-star"></i>';
}else if($cal_claim>60) {
	$claim='<i class="icon-star"></i>';
}


// ------------- ระดับ จำนวนกรมธรรม์ -------------//

$policy_amount=$row_ins["policy_amount"];





?>
<style type="text/css">

body
{
   font-family: sans-serif;
    
}
.container{
	width: 100%;

}

.pricing_table_wdg {  
	border:1px solid #c4cbcc;
	border-radius:4px;
	-moz-border-radius:4px;
	-webkit-border-radius:4px;
	float:left;
	margin-top: 0px;
}
.pricing_table_wdg ul { 
	list-style:none; 
	float:left; 
	width:100px; 
	margin:0; 
	border:1px solid #f2f3f3;
	padding:5px;
	text-align:center;
	background-color:#FFF;
}
.pricing_table_wdg ul:hover { 
	-webkit-transform: scale(1.1);
  	-moz-transform: scale(1.1);
  	-o-transform: scale(1.1);
  	-moz-box-shadow:3px 5px 7px rgba(0,0,0,.7);
  	-webkit-box-shadow: 3px 5px 7px rgba(0,0,0,.7);
  	box-shadow:3px 5px 7px rgba(0,0,0,.7);
	cursor:pointer;
	background:#d8e9f9;
}
.pricing_table_wdg ul li {  
	border-bottom:1px dashed #cfd2d2;
	padding:10px 0;
	font-weight:bold;
}
.pricing_table_wdg ul li:first-child { 
	color:#FFFFFF;
	font-size:14px;
	font-weight:bold;
	background:#2e818f;
}
.pricing_table_wdg ul li:nth-child(2) { 
	background:#fbfbfb;
}
.pricing_table_wdg ul li:nth-child(3) { 
	font-size:12px;
	font-weight:bold;
}
.pricing_table_wdg ul li:nth-child(n+4) { 
	font-size:14px;
}
.pricing_table_wdg ul li:last-child a { 
	color:#F0F0F0;
	text-decoration:none;
	font-weight:bold;
	display:block;
	border-radius:10px;
	-moz-border-radius:10px;
	-webkit-border-radius:10px;
	border:1px solid #c4cbcc;
	padding:10px;
	margin:5px 0;
	background: #0061bb; /* Old browsers */
	background: -moz-linear-gradient(top, #0061bb 0%, #164e82 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#0061bb), color-stop(100%,#164e82)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #0061bb 0%,#164e82 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #0061bb 0%,#164e82 100%); /* Opera11.10+ */
	background: -ms-linear-gradient(top, #0061bb 0%,#164e82 100%); /* IE10+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0061bb', endColorstr='#164e82',GradientType=0 ); /* IE6-9 */
	background: linear-gradient(top, #0061bb 0%,#164e82 100%); /* W3C */
}

.table th,td{
		text-align:center;
		font-size:14px;
}

</style>

คะแนน ข้อมูล ส่วนบุคคล
<section class="container">

<div class="pricing_table_wdg">
		<ul>
			<li>เบอร์มือถือ 1 <br>(10)</li>
			<li><?=number_format($tel_mobile);?></li>

		</ul>
		
		<ul>
			<li>เบอร์มือถือ 2  <br>(20)</li>
			<li><?=number_format($tel_mobile2);?></li>

		</ul>
		
		<ul>
			<li>เบอร์มือถือ 3  <br>(20)</li>
			<li><?=number_format($tel_mobile3);?></li>

		</ul>
		
		<ul>
			<li>เบอร์บ้าน  <br>(25)</li>
			<li><?=number_format($tel_home);?></li>

		</ul>
		
		<ul>
			<li>เบอร์ออฟฟิศ  <br>(25)</li>
			<li><?=number_format($tel_office);?></li>
			
		</ul>
		<ul>
			<li>Email  <br>(25)</li>
			<li><?=number_format($email);?></li>
			
		</ul>
		<ul>
			<li>ที่อยู่จัดส่ง  <br>(10)</li>
			<li><?=number_format($SendAdd);?></li>
			
		</ul>
		<ul>
			<li>อาชีพ  <br>(10)</li>
			<li><?=number_format($vocation);?></li>
			
		</ul>
		<ul>
			<li>Line ID  <br>(25)</li>
			<li><?=number_format($id_line);?></li>
			
		</ul>
		<ul >
			<li style="background: #DF7401; ">รวม<br>(170)</li>
			<li style="color: #DF7401; font-weight:bold "><?=number_format($grand)?></li>
			
		</ul>
</div>
  </section>


  <!-------------  การชำระ ------------>
  <hr>
  ระดับข้อมูลประกันภัย

  <section class="container">
<div class="pricing_table_wdg">
		<ul>
			<li>ส่่วนลด </li>
			<li><?=$txt_Discount;?></li>

		</ul>
		
		<ul>
			<li>ชำระเบี้ย  </li>
			<li><?=$Payment_Pre;?></li>

		</ul>
		
		<ul>
			<li>เคลม </li>
			<li><?=$claim;?></li>

		</ul>
		
		<ul>
			<li>จำนวนปี </li>
			<li><?=$Num_year;?></li>

		</ul>
		
		<ul>
			<li>กรมธรรม์  </li>
			<li><?=$policy_amount;?></li>
			
		</ul>
		
		<ul style="width:120px;">
			<li style="background: #DF7401; ">ระดับ</li>
			<li style="color: #DF7401; font-weight:bold "><?=$txt_Discount.''.$Payment_Pre.''.$claim.''.$Num_year.''.$policy_amount?></li>
			
		</ul>
</div>
  </section>
<hr>

<section class="container">
<table class="table  table-bordered ">
	<tr >
		<th style="background-color:#848484;" ></th>
		<th style="background-color:#848484;" colspan="2">ส่วนลด</th>
		<th style="background-color:#848484;" colspan="2">การชำระเบี้ย</th>
		<th style="background-color:#848484;" colspan="2">การเคลม</th>
		<th style="background-color:#848484;" colspan="2">จำนวนปี</th>

	</tr>
	<tr>
		<th style="background-color:#BDBDBD;">อธิบาย</th>
		<th style="background-color:#BDBDBD;">ตัวบ่งชี้</th><th style="background-color:#BDBDBD;">ระดับ</th>
		<th style="background-color:#BDBDBD;">ตัวบ่งชี้</th><th style="background-color:#BDBDBD;">ระดับ</th>
		<th style="background-color:#BDBDBD;">ตัวบ่งชี้</th><th style="background-color:#BDBDBD;">ระดับ</th>
		<th style="background-color:#BDBDBD;">ตัวบ่งชี้</th><th style="background-color:#BDBDBD;">ระดับ</th>

	</tr>
		<tbody>
			<tr>
				<td>ดีมาก</td>
				<td>ต่ำกว่า 1</td><td><strong>5</strong></td>
				<td>ก่อนวันชำระ</td><td><strong>A</strong></td>
				<td>ไม่เคลม</td><td><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></td>
				<td>5</td><td><strong>O</strong></td>

			</tr>
			<tr>
				<td>ดี</td>
				<td>1-5%</td><td><strong>4</strong></td>
				<td>1-7 วัน</td><td><strong>B</strong></td>
				<td>1-20 %</td><td><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></td>
				<td>4</td><td><strong>L</strong></td>

			</tr>

			<tr>
				<td>ปานกลาง</td>
				<td>6-10%</td><td><strong>3</strong></td>
				<td>8-15 วัน</td><td><strong>C</strong></td>
				<td>21-40 %</td><td><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i></td>
				<td>3</td><td><strong>M</strong></td>

			</tr>
			<tr>
				<td style="background-color:#FA5858;">พอใช้</td>
				<td style="background-color:#FA5858;">11-15%</td><td style="background-color:#FA5858;"><strong>2</strong></td>
				<td style="background-color:#FA5858;">16-30 วัน</td><td style="background-color:#FA5858;"><strong>D</strong></td>
				<td style="background-color:#FA5858;">41-60 %</td><td style="background-color:#FA5858;"><i class="icon-star"></i><i class="icon-star"></i></td>
				<td style="background-color:#FA5858;">2</td><td style="background-color:#FA5858;"><strong>N</strong></td>

			</tr>
			<tr>
				<td style="background-color:#FA5858;">ปรุับปรุง</td>
				<td style="background-color:#FA5858;">มากว่า 15%</td><td style="background-color:#FA5858;"><strong>1</strong></td>
				<td style="background-color:#FA5858;">มากกว่า 30 วัน</td><td style="background-color:#FA5858;"><strong>E</strong></td>
				<td style="background-color:#FA5858;">มากกว่า 60%</td><td style="background-color:#FA5858;"><i class="icon-star"></i></td>
				<td style="background-color:#FA5858;">1</td><td style="background-color:#FA5858;"><strong>K</strong></td>

			</tr>
			
		</tbody>	
</table>
  </section>