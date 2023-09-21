<?php
include "check-ses.php";
include "../inc/connectdbs.inc.php";
if($_SESSION['claim']=='ADMIN' || $_SESSION["strUser"]=='admin')
{
	$dealer_name=ทุกดิลเลอร์;
}
else
{
	$dealer_name="ดิลเลอร์ ".$_SESSION["strUser"];
}
?>
<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
<script src="js/jquery.imask.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/DT_bootstrap.js"></script>

<script src="assets/js/bootstrap-tooltip.js"></script>
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="assets/css/datepicker.css" />
    <div class="inner">

        <div class="row-fluid">
                <div class="box">
                    <header>
                        <h5>ข้อมูลลูกค้าจองรถยนต์</h5>
                    </header>


                    <div id="collapse4" class="body">


                       <!-- <form name="ajaxform" id="ajaxform" method="POST">
                            <div class="control-group">
                                <div style="width:526px;float:left;">
                                <select name="select_data" id="select_data" onchange='js_mask()'>
                                    <option value=''>--เลือกข้อมูลค้นหา--</option>
		  <option value='tb_my_car.name'>ชื่อจริง</option>
		  <option value='tb_my_car.last'>นามสกุล</option>
		  <option value='tb_my_car.id_card'>บัครประชาชน</option>
		  <option value='tb_my_car.tel_mobile1'>เบอร์โทรศัพท์1</option>
		  <option value='tb_my_car.tel_mobile2'>เบอร์โทรศัพท์2</option>
		  <option value='tb_my_car.tel_mobile3'>เบอร์โทรศัพท์3</option>
		  <option value='tb_my_car.tel_home'>เบอร์บ้าน</option>
		  <option value='tb_my_car.tel_office'>เบอร์ที่ทำงาน</option>
		  <option value='tb_my_car.id_line'>ID Line</option>
		  <option value='tb_my_car.facebook'>facebook</option>

                                </select>
                                <span id='input_mask'><input name='select_key' id='select_key' type='text' placeholder='คำค้นหา'></span>

                                <a type='button' class="btn btn-primary btn-small" id="search_post" onclick='search_data();'>Search</a
                                </div>
                                <div class="span5" id="pos_Blsit" style="padding-left:20px;color:red;"></div>
                            </div>
                            <div style="clear:both;"></div>
                        </form> -->


                        <div id="content_search">
                        </div>
                        
                    </div>
                    <hr>
                </div>
        </div>
    </div>
<script type='text/javascript'>
function search_data()
{
	/*if($("#select_data").val()=='')
	{
		alert("กรุณาเลือกข้อมูลค้นหาด้วยครับ");
		$("#select_data").focus();
		return false;
	}
	if($("#select_key").val()=='')
	{
		alert("กรุณาป้อนข้อมูลคำค้นหาด้วยครับ");
		$("#select_key").focus();
		return false;
	}*/
	$.post("ajax/ajax_search_data_customer_car.php",{search_data:$("#select_data").val(),search_key:$("#select_key").val()},function(data){$("#content_search").html(data)});
}
search_data();
function js_mask()
{
	if($("#select_data").val()=="tb_my_car.tel_mobile1" || $("#select_data").val()=="tb_my_car.tel_mobile2" || $("#select_data").val()=="tb_my_car.tel_mobile3")
	{
		$('#input_mask').html("<input name='select_key' id='select_key' type='text' placeholder='คำค้นหา' >");
		$("#select_key").mask("999-9999999");
	}
	else if($("#select_data").val()=="tb_my_car.tel_home")
	{
		$('#input_mask').html("<input name='select_key' id='select_key' type='text' placeholder='คำค้นหา' >");
		$("#select_key").mask("99-9999999");
	}
	else if($("#select_data").val()=="tb_my_car.id_card")
	{
		$('#input_mask').html("<input name='select_key' id='select_key' type='text' placeholder='คำค้นหา' >");
		$("#select_key").mask("9999999999999");
	}
	else
	{
		$('#input_mask').html("<input name='select_key' id='select_key' type='text' placeholder='คำค้นหา' >");
	}
}
</script>