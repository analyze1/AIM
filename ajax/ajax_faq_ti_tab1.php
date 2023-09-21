<?php
// include "../inc/checksession.inc.php";
include "../inc/connectdbs.pdo.php"; 

// mysql_select_db($db2,$cndb2);
?>
<style>
.sm_tab_color {
  background: #f2f2f2;
  background-image: -webkit-linear-gradient(top, #f2f2f2, #e6e6e6);
  background-image: -moz-linear-gradient(top, #f2f2f2, #e6e6e6);
  background-image: -ms-linear-gradient(top, #f2f2f2, #e6e6e6);
  background-image: -o-linear-gradient(top, #f2f2f2, #e6e6e6);
  background-image: linear-gradient(to bottom, #f2f2f2, #e6e6e6);
  -webkit-border-radius: 10;
  -moz-border-radius: 10;
  border-radius: 10px;
  font-family: Arial;
  color: #000000;
  font-size: 16px;
  padding: 10px 20px 10px 20px;
  /* border: solid #c5c6c7 1px; */
  text-decoration: none;
  cursor: pointer;
}

.sm_tab_color:hover {
  background: #f7f7f7;
  background-image: -webkit-linear-gradient(top, #f7f7f7, #f0f0f0);
  background-image: -moz-linear-gradient(top, #f7f7f7, #f0f0f0);
  background-image: -ms-linear-gradient(top, #f7f7f7, #f0f0f0);
  background-image: -o-linear-gradient(top, #f7f7f7, #f0f0f0);
  background-image: linear-gradient(to bottom, #f7f7f7, #f0f0f0);
  text-decoration: none;
}
.border_tab
{
-webkit-border-radius: 10;
-moz-border-radius: 10;
border-radius: 10;
border-radius: 7px;
border: solid #c5c6c7 1px;
}
.move-icon
{
	-webkit-transition-duration:1s;
	-moz-transition-duration:1s;
	transition-duration:1s;
}
.rotate-icon-90
{
	-webkit-transform: rotate(90deg);
	-moz-transform: rotate(90deg);
	transform: rotate(90deg);
}
.shadow-box
{
padding:0px 0px 10px 0px; border-radius:0px 0px 10px 10px;
-webkit-box-shadow: 0px 0px 5px 1px rgba(181,181,181,1);
-moz-box-shadow: 0px 0px 5px 1px rgba(181,181,181,1);
box-shadow: 0px 0px 5px 1px rgba(181,181,181,1);
}
.linear-color
{
	background: linear-gradient(-45deg,#595959 45%,#FFFFFF 45.5%,#333333 0%); /* Standard syntax (must be last) */
}
.bage{
  display: inline-block;
    padding: .25em .4em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    color: #fff;
    background-color: #28a745;
    display:inline-block; 
    float:right;
     text-align:center;
}
.bage-Warning {
    display: inline-block;
    padding: .25em .4em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    color: #212529;
    font-size:15px;
    background-color: #ffc107;
}
</style>

<div class='span12'  style='margin:0;background: #fdfdfd;padding: 10px;'>
<?php 

$select_icon_sql="SELECT * FROM faq_new";
$select_icon_query= PDO_CONNECTION::fourinsure_mitsu()->query($select_icon_sql);
$select_like_num= $select_icon_query->rowCount(); 

?>

<font class="bage-Warning"  color='red'> <?php echo $select_like_num .' '.'คำถามที่พบบ่อย'?></font><br><br>
<?php
$n=0;
$faq_sql="SELECT * FROM faq_new WHERE `type` ='Mitsubishi' ";

$faq_query=PDO_CONNECTION::fourinsure_mitsu()->query($faq_sql);


$faq_nums= $faq_query->rowCount();

if($faq_nums<=0)
{ ?>
<br>
<br>
<center><font color='#595959' size='8'>NO DATA!!</font></center>
<br>
<br>
<?php }
foreach ($faq_query->fetchAll(2) as  $faq_array)
{
  $order = $faq_array['question'];
  ?>
<div class='span12 sm_tab_color ' style='margin:0;' id='hot_tab<?php echo $n?>' onclick='open_hot_faq("<?php echo $n?>","<?php echo $order ?>");'>
<?php 
echo "<div class='move-icon' id='icon".$n."' style='display:inline-block;  width:20px; height:20px; text-align:center;'>►</div> ".$order." <div class='bage'>".$faq_array['creationdate']."</div>"; 

?>
</div>
<div class='span12 border_tab' style='margin:0;display:none' id='show_hot_tab<?php echo $n?>' >
<table width='100%' id='data_table_hot<?php echo $n?>'>
<thead style='display:none;'>
<tr>
<th></th>
</tr>
</thead>
<tbody>
<?php
$detail_sql="SELECT * FROM faq_new WHERE id = '".$faq_array['id']."'";
// echo $detail_sql;exit;
$detail_query=PDO_CONNECTION::fourinsure_mitsu()->query($detail_sql);
foreach($detail_query->fetchAll(2) as $detail_array)
{ ?>
<tr>
<td>
<div class='span12 ' style='margin:0; font-size:16px;'>

<div class='span12' style='padding:10px; margin:0;'>
<span style='color:red'>คำอธิบาย : <?php echo str_replace("\n"," ",$detail_array['reply'])?></span>
</div>
<div class='span12' style='padding:10px; margin:0;'>

<div style='margin-top:8px; position:absolute; margin-left:-15px;'>

</div>
</div>
</div>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
<script>
$("#data_table_hot<?php echo $n?>").DataTable({"order": []});
$("#data_table_hot<?php echo $n?>_length").hide();
$("#data_table_hot<?php echo $n?>_filter").hide();
$("#data_table_hot<?php echo $n?>_info").hide();
$("#data_table_hot<?php echo $n?>_paginate").hide();

</script>
<?php 
$n++;
} 
?>
</div>
<script>
function open_hot_faq(id,title)
{
	$("#show_hot_tab"+id).slideToggle();
	if($("#icon"+id).hasClass("rotate-icon-90"))
	{
	$("#icon"+id).removeClass("rotate-icon-90");
	}
	else
	{
	$("#icon"+id).addClass("rotate-icon-90");
	}
}
</script>
