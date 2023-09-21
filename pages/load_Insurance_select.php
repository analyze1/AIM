<?php
include "check-ses.php"; 
include "../../inc/connectdbs.pdo.php"; 
header('Content-Type: text/html; charset=utf-8');
?>

<script src="js/js_Insurance.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/cupertino/jquery-ui-1.9.2.custom.min.css" />
<link rel="stylesheet" type="text/css" href="assets/css/datepicker.css" />

<div style="margin-left:auto;margin-right:auto;" class="row-fluid">
<form name="Insurance" id="Insurance">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-header widget-header-flat"> <h3>กรุณาเลือก ประเภทประกันภัย</h3></div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row-fluid">
                            <div class="span12">
                                <table class="table"><center>
                                	<a class="btn btn-large btn-success" onclick="load_page('pages/load_Insurance.php?insureYear=1','แจ้งประกันภัยป้ายแดง 1 ปี');" style="width:200px;"><h4>ประกันภัย 1 ปี</h4></a> <a class="btn btn-large btn-info" onclick="load_page('pages/load_Insurance.php?insureYear=2','แจ้งประกันภัยป้ายแดงระยะยาว 2 ปี');" style="width:200px;"><h4>ประกันภัยระยะยาว 2 ปี</h4></a> <a class="btn btn-large btn-warning" onclick="load_page('pages/load_Insurance.php?insureYear=3','แจ้งประกันภัยป้ายแดงระยะยาว 3 ปี');" style="width:200px;"><h4>ประกันภัยระยะยาว 3 ปี</h4></a>
                                <center></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>

<script type="text/javascript">

if(window.location.hash=="")
{
}
function load_page(link,nlink)
{
	if(link=="")
	{
		link="index.php?nid=หน้าแรก";
	}
	$('#page-content').html('<p><br><br><center><img src="img4/loadingIcon.gif"  /> <img src="img4/loadingIcon.gif"  /> <img src="img4/loadingIcon.gif"  /></center></p>').load(link);
	$('#txt_nlink').html(nlink);
}
</script>

<? mysql_close(); ?>