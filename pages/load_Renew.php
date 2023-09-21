<?php
	include "check-ses.php"; 
	include "../../inc/connectdbs.pdo.php"; 
	header('Content-Type: text/html; charset=utf-8');
	
	$costOb = $_SESSION["Cost"];
	$costObname = $_SESSION["CostName"];
	$Cost_PRE = $_SESSION["CostPre"];
	$MoC = $_SESSION["MoC"];
?>
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/DT_bootstrap.js"></script>
<script type="text/javascript" src="js/js_Renew.js"></script>
<script type='text/javascript'>

	$("#saverenew").click(function() {

		var DATA = $('#formInsertrenew').serialize();
		var options = 
		{
			type: "POST",
			dataType: "json",
			async: false,
			url: "ajax/Ajax_SaveRenewCUS.php?",
			data: DATA,
			success: function(msg) 
			{
				var returnedArray = msg;
				if(returnedArray.status==true)
				{
					alert(returnedArray.msg);
					$('#page-content').load("pages/load_Renew.php");
				}
				else
				{
					alert(returnedArray.msg);
				}
			}
		};
		$.ajax(options);
		return false;
		
	});
</script>

<style>
	.modal-body
	{
        position: relative;
		background-color: #fff;
		max-height: 500px;
    }
    .modal-content
	{
        position: relative;
        background-color: #fff;
        border: 1px solid #999;
        width: 1200px; /* SET THE WIDTH OF THE MODAL */
        margin: -30px 0 0 -300px;
		max-height: 500px;
    }
</style>

<?php
	$querycontact = "SELECT emp_namerenew,emp_telrenew,emp_faxrenew,emp_emailrenew FROM tb_customer WHERE user = '".$_SESSION["strUser"]."'";
	$objQuerycontact = mysql_query($querycontact) or die ("Error Query [".$querycontact."]");
	$rowcontact = mysql_fetch_array($objQuerycontact);
	
	if($rowcontact['emp_namerenew']!='' && $rowcontact['emp_telrenew']!='' && $rowcontact['emp_faxrenew']!='' && $rowcontact['emp_emailrenew']!='')
	{	
		if($_SESSION["strUser"] == 'admin')
		{
			$query = "SELECT * FROM data ";
			$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
			$query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
			$query .= "INNER JOIN insuree ON (data.id_data = insuree.id_data) ";
			$query .= "INNER JOIN req ON (data.id_data = req.id_data) ";
			$query .= " WHERE DATE(data.end_date) BETWEEN '".date('Y-m-d')."' AND '".date('Y-m-d',strtotime("+120 day"))."' AND req.EditCancel = ''";
			$query .= "ORDER BY data.end_date ASC ";
	
			$objQuery = mysql_query($query) or die ("Error Query [".$query."]");
		}
		else
		{
			$query = "SELECT * FROM data ";
			$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
			$query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
			$query .= "INNER JOIN insuree ON (data.id_data = insuree.id_data) ";
			$query .= "INNER JOIN req ON (data.id_data = req.id_data) ";
			$query .= " WHERE DATE(data.end_date) BETWEEN '".date('Y-m-d')."' AND '".date('Y-m-d',strtotime("+120 day"))."' AND data.login = '".$_SESSION["strUser"]."' AND req.EditCancel = ''";
			$query .= "ORDER BY data.end_date ASC ";
	
			$objQuery = mysql_query($query) or die ("Error Query [".$query."]");
		}
?>
<script src="assets/js/bootstrap-tooltip.js"></script>
<script type="text/javascript">
 $(document).ready(function() {
        $("a[rel='tooltip']").tooltip({'placement': 'top', 'z-index': '3000'});
    });
    </script>
                    <div class="row-fluid">
                        <!-- .inner -->
                        <div class="span12 inner">
                            <!--Begin Datatables-->
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="widget-box">                                        
                                       
                                        <div id="collapse4" class="body">

	<table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table table-striped table-bordered" id="example">
  <thead>
  	<th width="100">ติดตาม</th>
    <th width="70">วันหมดอายุ</th>
	 <th width="250">ชื่อผู้เอาประกัน</th>
    <th width="70">รุ่นรถ</th>
    <th width="80">เลขตัวถัง/ตัวเครื่อง</th>
    <th width="50">เบี้ยประกันภัย</th>
  </thead>
    <tbody> 

   <?php 
  $color = "";
  $fixNumber = 0;
  while($row = mysql_fetch_array($objQuery)) 
  { 
  	if($color=="#DDE0FF")
  	{
		$color="#F4F5FF";
	}
	else
	{
		$color = "#DDE0FF";
	}
	
	$query_detailRenew = "SELECT * FROM detail_renew WHERE detail_renew.id_data ='".$row['id_data']."' order by id_detail desc limit 1 ";
	$objQuery_detailRenew = mysql_query($query_detailRenew) or die ("Error Query [".$query_detailRenew."]");
	$row_detailRenew = mysql_fetch_array($objQuery_detailRenew);			
  	if($row_detailRenew['status'] != 'E')
	{
		$query_URenew = "SELECT * FROM URenew WHERE URenew.renew_id ='".$row['id_data']."' ";
		$objQuery_URenew = mysql_query($query_URenew) or die ("Error Query [".$query_URenew."]");
		$row_URenew = mysql_fetch_array($objQuery_URenew);
        ?>
	  <tr id="tr" bgcolor="<?=$color?>"  align="center">
      	<td align="center"><div align="center">
       	<a class="btn btn-info" data-toggle="modal" title="ดูข้อมูล" href="pages/Renew_info.php?IDDATA=<?=$row['id_data']; ?>" aria-hidden="true"   data-target="#modal"><i class="icon-white icon-list"></i> ดูข้อมูล</a> 
        <? if($row_URenew['renew_cost'] != '0' && $row_URenew['renew_id'] != ''){?><a title="พิมพ์ใบเตือน" href="javascript:void(0)" onclick="window.open('print/print_Alert.php?IDDATA=<?=$row['id_data']; ?>','welcome','menubar=no,status=no,scrollbars=yes')" class="btn btn-success" ><i class="icon-white icon-print"></i>พิมพ์ใบเสนอราคา</a><? } ?>
        </div></td>
	<td><div align="center">
		<?php
            if(date($row['end_date'])<date('Y-m-d'))
            {
                $coloralert="#EEEEEE";
                $color = "#000000";
            }
            else if(date($row['end_date'])>date('Y-m-d',strtotime("+30 day")))
            {
                $coloralert="#088A29";
            }
            else if(date($row['end_date'])>date('Y-m-d',strtotime("+15 day")))
            {
                $coloralert="#FF9900";
            }
            else if(date($row['end_date'])>=date('Y-m-d'))
            {
                $coloralert="#CC0000";
            }
            echo "<span style='color:$coloralert;'>".date("d/m/Y",strtotime($row['end_date']))."</span>";
		?>
		</div></td> 	
		
       <td align="left"><?=$row['title']." ".$row['name']." ".$row['last']?>
       <?php
	   		if(!empty($_POST['searchTxT']) && $row['Cus_name'] !='')
			{
				echo "( ".$row['Cus_title'].$row['Cus_name']." ".$row['Cus_last']." )";
			}
	   ?> 
       </td>	
        <td><div align="center"><?=$MoC[$row['mo_car']]?></div></td>
        <td><div align="center"><?=$row['car_body']."<BR>".$row['n_motor']?></div></td>
        <td><div align="center">0.00</div></td>

	  </tr>
      <?php } ?>
      <?php $fixNumber++;   } ?>
        </tbody> 
</table>
                            <hr>

                            <!-- /.row-fluid -->
                        </div>
                           
                          
                            <!-- /.inner -->
                    </div>
                    <!-- /.row-fluid -->
                </div>
                <!-- /.outer -->
            </div>  
 <link type="text/css" rel="stylesheet" href="assets/css/modal.css">
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static"  data-keyboard="false">
	<div class="modal-dialog" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="rpg();">&times;</button>
				<h4 class="modal-title">รายละเอียดลูกค้า ต่ออายุ</h4>
			</div>
			<div class="modal-body">Load Data...</div>
			<div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" onclick="rpg();">Close</a></div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<!-- Modal -->


<div class="search modal fade" id="modal_PayOnline" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">แบบฟอร์มชำระเงิน Online</h4>
            </div>
            <div class="modal-body" style="overflow-y:scroll; max-height: 600px;">

            </div>
            <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" >Close</a></div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!--<script src="bootstrap/js/bootstrap.min.js"></script>-->
<?
}
else
{ 
?>
<span class="warn"> * กรุณากรอก   " ข้อมูลพนักงาน "   ข้อมูลจะถูกพิมพ์ลงบนใบเตือนเพื่อความสะดวกในการติดต่อเพื่อขอต่อประกันภัย</span>
<form id="formInsertrenew">
<table>
	<tr>
        <td width="80px">ชื่อ - นามสกุล  </td>
        <td>: <input type="text" value="<?=$rowcontact['emp_namerenew'];?>" name="nameRenew" id="nameRenew"  /></td>
	</tr>
	<tr>
		<td>เบอร์โทร  </td>
		<td>: <input type="text" value="<?=$rowcontact['emp_telrenew'];?>" name="telRenew" id="telRenew"  /></td>
	</tr>
	<tr>
		<td>เบอร์แฟกซ์  </td>
		<td>: <input type="text" value="<?=$rowcontact['emp_faxrenew'];?>" name="faxRenew" id="faxRenew"  /></td>
	</tr>
	<tr>
		<td>อีเมล์  </td>
		<td>: <input type="text" value="<?=$rowcontact['emp_emailrenew'];?>" name="emailRenew" id="emailRenew"  /></td>
	</tr>
</table>
<input class="btn btn-primary" id="saverenew" type="button" value="บันทึก">
</form>

<?
}
mysql_close();
?>
</div>
<!-- <script src="bootstrap/js/bootstrap.min.js"></script> -->
<script type="text/javascript">
	$('a[data-toggle="modal"]').click(function(e) {
		var mb = $('#modal .modal-body');
		mb.html('Load Data...');
		mb.load(e.target.href);
	});
	function rpg(){
		load_page('pages/load_Renew.php','แจ้งประกันภัยต่ออายุ');
	}
</script>

<script type='text/javascript'>//<![CDATA[ 
$(document).on('click','a[data-toggle=modal]', function() {
       // event.preventDefault();
       var $modal=$($(this).data('target'));
       $('.modal-body',$modal).empty();
       $modal.show();
       $('.modal-body',$modal).load($(this).attr('href'));
});
</script>