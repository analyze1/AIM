<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.inc.php"; 
//header('Content-Type: text/html; charset=UTF-8');
//include "../inc/checksession.inc.php";
mysql_select_db($db1,$cndb1);
$USER = $_SESSION["strUser"];
?>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!--<link type="text/css" rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap-responsive.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/Font-awesome/css/font-awesome.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/css/style.css"/>
    <link id="active-theme" type="text/css" rel="stylesheet" href="assets/css/default.min.css"/>-->
    <style type="text/css">
    .style1 {font-size: 12px; color:#333;}

    .icon_bank{
      width:30px;
      vertical-align: bottom;

    }.button_text{
border:0px solid #7d99ca; -webkit-border-radius: 0px; -moz-border-radius: 0px;border-radius: 0px;font-size:14px;font-family:arial, helvetica, sans-serif; padding: 13px 13px 13px 13px; text-decoration:none; display:inline-block;text-shadow: -1px -1px 0 rgba(0,0,0,0.3);font-weight:bold; color: #FFFFFF;
 background-color: #a5b8da; background-image: -webkit-gradient(linear, left top, left bottom, from(#a5b8da), to(#7089b3));
 background-image: -webkit-linear-gradient(top, #a5b8da, #7089b3);
 background-image: -moz-linear-gradient(top, #a5b8da, #7089b3);
 background-image: -ms-linear-gradient(top, #a5b8da, #7089b3);
 background-image: -o-linear-gradient(top, #a5b8da, #7089b3);
 background-image: linear-gradient(to bottom, #a5b8da, #7089b3);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#a5b8da, endColorstr=#7089b3);
}

.button_text:hover{
 border:px solid #5d7fbc;
 background-color: #819bcb; background-image: -webkit-gradient(linear, left top, left bottom, from(#819bcb), to(#536f9d));
 background-image: -webkit-linear-gradient(top, #819bcb, #536f9d);
 background-image: -moz-linear-gradient(top, #819bcb, #536f9d);
 background-image: -ms-linear-gradient(top, #819bcb, #536f9d);
 background-image: -o-linear-gradient(top, #819bcb, #536f9d);
 background-image: linear-gradient(to bottom, #819bcb, #536f9d);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#819bcb, endColorstr=#536f9d);
}
    </style>
    <!--<script type="text/javascript" src="assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script type="text/javascript" src="js/jquery.imask.js"></script>
    <script type="text/javascript" src="js/jquery.maskedinput-1.2.2.js"></script>-->

<div class="container-fluid outer">
    <div class="row-fluid">
                       <!-- .inner -->
        <div class="span12 inner">
                            <!--Begin Datatables-->
            <div class="row-fluid">
                <div class="span12">
                    <div class="box">
                            <header>
                                                    <!--<div class="icons"><i class="icon-move"></i></div>-->
                                                    <h5>ส่งข้อความมือถือ (SMS) <a onclick='load_page("pages/renew_suzuki_select.php?id=<?php echo $_GET['id_data'];?>","แจ้งงาน");' class='btn-small btn btn-warning'>กลับไปหน้าต่ออายุ</a></h5>
                            </header> 
                 
                                       
                        <div id="collapse4" class="body">
                        
                        <?
                        	
							$query = "SELECT ";
							$query .= "insuree.title, "; 
							$query .= "insuree.name,  "; 
							$query .= "insuree.last, "; 
							$query .= "insuree.tel_mobi,";
							$query .= "data.end_date, "; 
							$query .= "tb_br_car.name as car_brand, "; 
							$query .= "tb_mo_car.name as mo_car_name, "; 
							$query .= "detail.id_data, ";
							$query .= "data.n_insure, ";
							$query .= "tb_comp.name_print "; // บริษัทประกันภัย
							
							$query .= "FROM data ";
							$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
							$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";	
							$query .= "INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
							$query .= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
							$query .= "INNER JOIN tb_comp ON (data.com_data = tb_comp.sort) ";
							$query .= "WHERE data.id_data='".$_GET['id_data']."' ";
							$objQuery = mysql_query($query,$cndb1) or die ("Error query [".$query."]");
							$row = mysql_fetch_array($objQuery);
							$tel_edit=str_replace("-","",$row['tel_mobi']);
							
							if($row['id_data_company'] != ''){$id_data_company = $row['id_data_company'];}else{$id_data_company = '-';}
							
						?>
                        
                                    <form id="smsSend">

                                                    <div class="span3">
                                                    	<h5><!--<img src="icon/i_phone.png" class="icon_bank" >--> เบอร์โทรศัพท์ : </h5><!--<input name="u4" id="u4" type="hidden" value="<?=$USER?>" />-->
                                                        <input size="10" type="text" id="tel" style="color:red;" name="tel" value="<?=$tel_edit; ?>" /><br />
                                                    	<h5><!--<img src="icon/i_sms.jpg" class="icon_bank" >--> ข้อความ : </h5><textarea id="message" name="message" class="form-control" rows="5" style="width:100%" ></textarea><br />
                                                    </div>

                                                    <div class="span3" >
                                                        <fieldset>    <legend><h5>ข้อมูลประกันภัย</h5></legend>               
                                                        	<? if($row['name_print'] !=''){?>
                                                            	<button style="width:100%; text-align:left;"  class="button_text" id="_bank"> <?=$row['name_print'];?></button>
                                                            <? } ?>                                    
                                                              <button style="width:100%; text-align:left; " class="button_text" id="_bank"> เรียน <?=$row['title'].''.$row['name'].' '.$row['last'];?></button>
                                                              <button style="width:100%; text-align:left;" class="button_text" id="_bank"> ยี่ห้อ <?=$row['car_brand'];?></button>
                                                              <button style="width:100%; text-align:left;" class="button_text" id="_bank"> รุ่น <?=$row['mo_car_name'];?></button>
                                                              <button style="width:100%; text-align:left;" class="button_text" id="_bank"><?php if($row['n_insure']==""){echo "  เลขรับแจ้ง  ".$row['id_data'];}else{echo " เลขกรมธรรม์  ".$row['n_insure'];}?></button>
															  <button style="width:100%; text-align:left;" class="button_text" id="_bank"> เบี้ยประกัน <?=$row['net_renew'];?></button>

                                                        </fieldset>

                                                    </div>

                                                    <div class="span3" >
                                                        <fieldset>    <legend><h5>บัญชีีธนาคาร</h5></legend>                                                   
                                                              <button style="width:100%; text-align:left;"  class="button_text" id="_bank"> ธ.ไทยพาณิชย์ เลขที่ 352-2-33464-0</button>
                                                              <button style="width:100%; text-align:left;" class="button_text" id="_bank"> ธ.กรุงเทพ เลขที่ 174-0-91796-6</button>
                                                              <button style="width:100%; text-align:left;" class="button_text" id="_bank"> ธ.กรุงศรีอยุธยา เลขที่ 618-1-00154-9</button>
                                                              <button style="width:100%; text-align:left;" class="button_text" id="_bank"> ธ.กรุงไทย เลขที่ 121-0-22131-4</button>
                                                              <button style="width:100%; text-align:left;" class="button_text" id="_bank"> ธ.กสิกรไทย เลขที่ 655-2-00119-0</button>

                                                        </fieldset>

                                                    </div>

                                                    <div class="span3" >
                                                        <fieldset>    <legend><h5>Keyword</h5></legend>                                                   
                                                              <button style="width:100%; text-align:left;"  class="button_text" id="_bank"> บจ.โฟร์ อินชัวร์โบรกเกอร์</button>
                                                              <button style="width:100%; text-align:left;" class="button_text" id="_bank"> ประกันรถยนต์หมดอายุ วันที่ <?=date('d/m/Y', strtotime($row['end_date']));?></button>
                                                              <button style="width:100%; text-align:left;" class="button_text" id="_bank"> Tel.02-1968234</button>
                                                              <button style="width:100%; text-align:left;" class="button_text" id="_bank"> Fax.02-1968235</button>
                                                              <button style="width:100%; text-align:left;" class="button_text" id="_bank"> Hotlne.085-9215454</button>
                                                              <button style="width:100%; text-align:left;" class="button_text" id="_bank"> Hotlne.085-9213636</button>

                                                        </fieldset>

                                                    </div>
                                        <div class="span12">
                                            <input type="hidden" name="tdataid" id="tdataid" value="<?php echo $_GET['id_data'] ; ?>">
                                            <input type="button" id="submit" name="submit" value="ส่งข้อความ" class="btn btn-primary" /><input type="reset" id="reset" name="reset" value="เคลียร์" class="btn" />
                                    
										</div>   
                                </form>
                         </div>

                </div>
             </div>
        </div>
                            <!--End Datatables-->
                            <hr>
                            <!-- /.row-fluid -->
    </div>
                        <!-- /.inner -->
</div>
                    <!-- /.row-fluid -->
 


<script type="text/javascript">

var text = $( this ).text();

    $( "button" ).click(function() {

      var text = $( this ).text();
      //console.log(text);
        $('#message').val(function(_, val){return val + text; }); 
        return false;
    });

</script>

<script>

$('#submit').click(function(){
var DATA = $('#smsSend').serialize();
 var options2 = {
         type: "POST",
         dataType: "html",
         url: "ajax/ajax_save_sms.php",
         data: DATA,
         success: function(msg) {
             var returnedArray = msg;
             $('#tel').val('');
             $('#message').val('');
            alert(returnedArray);
			load_page("pages/renew_suzuki_select.php?id=<?php echo $_GET['id_data'];?>","แจ้งงาน");
         }
     };
     $.ajax(options2);
     });

$('#tel').mask("9999999999");
</script>

