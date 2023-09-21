<?php
include "check-ses.php";
//include "../inc/checksession.inc.php";
include "../inc/connectdbs.pdo.php";
include "../inc/session_car.php";
?>

<link type="text/css" rel="stylesheet" href="assets/css/modal.css">
<link rel="stylesheet" type="text/css" href="data_table/css/jquery.dataTables.min.css">
<script type="text/javascript" src="data_table/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>





<style type="text/css">
	body.modal-open .datepicker {
		z-index: 100000 !important;
	}
	body.modal-open {
		overflow: hidden;
	}
	/*.quote.modal {
		position: fixed;
		top: 0px !important;
		left: 0px !important;
		right: 0px !important;
		bottom: 0px !important;
		width: 80% !important;
		height: 100% !important;
		margin: 0px !important;
		padding: 0px !important;
		display: none;
		border-radius: 0px !important;
		border:none;
		overflow: hidden;
	}*/
	
	.quote.modal {
		position: absolute;
		left: auto !important;
		right: auto !important;
		width: 80% !important;
		height: 80% !important;
		margin: 0px auto !important;
		padding: 0px !important;
		display: none;
		border-radius: 0px !important;
		border:none;
		overflow: hidden;
	}

	.quote .modal-dialog {
		position: relative;
		width: 100% !important;
		height: 100% !important;
		margin: 0px auto !important;
		padding: 0px !important;
		border-radius: 0px !important;
	}

	.quote .modal-content {
		position: relative !important;
		margin: 0px auto !important;
		width: 100% !important;
		height: 100% !important;
		max-width: none;
		max-height: none;
		top: 0px !important;
		left: 0px !important;
		right: 0px !important;
		bottom: 0px !important;
	}
	
	.quote .modal-header {

	}

	.quote .modal-title {

	}
	
	.quote .modal-body {
		max-height: 85% !important;
		
	}

	.quote .modal-footer {
		position: absolute !important;
		margin: 0px !important;
		left: 0px !important;
		right: 0px !important;
		bottom: 0px !important;
	left: 0;
	}
	.quote .btn-disable {
		display: none;
	}
	.quote.modal table {
		font-size: 100%;
		font-weight:bold;
		box-shadow:1px 1px 1px 1px #D8D8D8;
	}

	.quote.modal th {
		font-size: 100%;
		background-color:#5098c9; 
		color: #FFFFFF;
	}

	.quote.modal input[value='0.00'] {
		float:right;

	}
	.quote.modal table tr th, .quote.modal table tr td {
		padding: 4px 6px;
		vertical-align: middle;
	}
	.quote .modal tr.info th {
		color: #fff;
		text-shadow: 0 -1px 0 rgba(0,0,0,0.25) !important;
		background-color: #006dcc !important;
		background-image: -moz-linear-gradient(top,#08c,#04c) !important;
		background-image: -webkit-gradient(linear,0 0,0 100%,from(#08c),to(#04c)) !important;
		background-image: -webkit-linear-gradient(top,#08c,#04c) !important;
		background-image: -o-linear-gradient(top,#08c,#04c) !important;
		background-image: linear-gradient(to bottom,#08c,#04c) !important;
		background-repeat: repeat-x !important;
		border-color: #04c #04c #002a80 !important;
		border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25) !important;
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff0088cc',endColorstr='#ff0044cc',GradientType=0) !important;
		filter: progid:DXImageTransform.Microsoft.gradient(enabled=false) !important;
	}
	.quote.modal table tr td input[type="text"], .quote.modal table tr th input[type="text"] {
		display: inline-block;
		height: 20px;
		padding: 4px 6px;
		margin-bottom: 0px;
		font-size: 90%;
		line-height: 20px;
		color: #555;
		vertical-align: middle;
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
		border-radius: 0px;
	}
	.quote.modal table tr td select {
		display: inline-block;
		height: 30px;
		padding: 4px 6px;
		margin-bottom: 0px;
		font-size: 90%;
		line-height: 20px;
		color: #555;
		vertical-align: middle;
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
		border-radius: 0px;
	}
	.quote.modal table tr th input[type="checkbox"] {
		display: inline-block;
		width: 14px;
		height: 14px;
		margin: 0px;
		margin-top: -4px;
		font-size: 90%;
		line-height: 20px;
		color: #555;
		vertical-align: middle;
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
		border-radius: 0px;
	}
	.span2 {
		width: 120px;
	}
	*[data-align="right"] {
		text-align: right !important;
	}
	*[data-align="left"] {
		text-align: left !important;
	}
	*[data-align="center"] {
		text-align: center !important;
	}
	.search.modal table {
		font-size: 90%;
	}
	.search.modal table tr th, .search.modal table tr td {
		padding: 4px 6px;
		vertical-align: middle;
	}
	.search.modal {
		width: 60% !important;
		margin-left: -30% !important;
	}

	.search .modal-dialog {
		width: 70% !important;
	}

	.search .modal-content {
		width: auto;
	}
	.search .modal tr.info th {
		color: #fff;
		text-shadow: 0 -1px 0 rgba(0,0,0,0.25) !important;
		background-color: #006dcc !important;
		background-image: -moz-linear-gradient(top,#08c,#04c) !important;
		background-image: -webkit-gradient(linear,0 0,0 100%,from(#08c),to(#04c)) !important;
		background-image: -webkit-linear-gradient(top,#08c,#04c) !important;
		background-image: -o-linear-gradient(top,#08c,#04c) !important;
		background-image: linear-gradient(to bottom,#08c,#04c) !important;
		background-repeat: repeat-x !important;
		border-color: #04c #04c #002a80 !important;
		border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25) !important;
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff0088cc',endColorstr='#ff0044cc',GradientType=0) !important;
		filter: progid:DXImageTransform.Microsoft.gradient(enabled=false) !important;
	}
	.search.modal table tr td input[type="text"], .search.modal table tr th input[type="text"] {
		display: inline-block;
		height: 20px;
		padding: 4px 6px;
		margin-bottom: 0px;
		font-size: 90%;
		line-height: 20px;
		color: #555;
		vertical-align: middle;
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
		border-radius: 0px;
	}
	.search.modal table tr td select {
		display: inline-block;
		height: 30px;
		padding: 4px 6px;
		margin-bottom: 0px;
		font-size: 90%;
		line-height: 20px;
		color: #555;
		vertical-align: middle;
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
		border-radius: 0px;
	}
	.search.modal table tr th input[type="checkbox"] {
		display: inline-block;
		width: 14px;
		height: 14px;
		margin: 0px;
		margin-top: -4px;
		font-size: 90%;
		line-height: 20px;
		color: #555;
		vertical-align: middle;
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
		border-radius: 0px;
	}
</style>

<div class="container-fluid outer">
	<div class="row-fluid">
		<div class="span12 inner">
			<div class="row-fluid">
				<div class="span12">
					<div class="box">
						<header>
							<!--<div class="icons"><i class="icon-move"></i></div>
							<h5>เสนอราคา FOUR</h5>-->
						</header>
						<div class="body">
                        	<div id="search">
                        	<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" id="quote_four">
								<thead>
									<tr>
										<th class="span3" style="text-align:center;">พิมพ์ใบเสนอราคา</th>
										<th class="span1" style="text-align:center;">Qutation</th>
										<th class="span2" style="text-align:center;">ทะเบียน</th>
										<th class="span3" style="text-align:center;">ชื่อ - นามสกุล</th>
										<th class="span2" style="text-align:center;">ยี่ห้อ/รุ่นรถ</th>
										<th class="span2" style="text-align:center;">ผู้เสนอ</th>
										<!--<th class="span3" style="text-align:center;">หมายเหตุ</th>-->
										
									</tr>
								</thead>
							</table>
                            </div>
						</div>
						<hr>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- /.modal -->
<div class="quote modal fade" id="modal_quote_four" tabindex="-1" role="dialog" aria-labelledby="modal_quote_four_label" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="modal_quote_four_label">ออกใบเสนอราคา FOUR</h4>
			</div>
			<div class="modal-body">			
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
				<button type="button" class="btn btn-primary" onclick="SaveI();">บันทึก</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /.modal -->
<div class="modal fade" id="modal_quote_four_customer" tabindex="-1" role="dialog" aria-labelledby="modal_quote_four_customer_label" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="modal_quote_four_customer_label">ค้นหาลูกค้าเก่า</h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" id="close-search-customer">ปิด</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
var tables = $('#quote_four').DataTable( {
			"processing": false,
			"serverSide": false,
			"ajax": 'ajax/ajax_quote_four.php',
			"columnDefs": [ {
            "targets": 0,
			"data": 'button',
			'bSortable' : false,
			"bSearchable": false,
            "defaultContent": ""
        },
		{
            "targets": 1,
            "data": 'q_auto',
			'bSortable' : false,
			"bSearchable": true,
            "defaultContent": ""
        },	 
		{
            "targets": 2,
            "data": 'car_regis',
			"bSortable" : false,
			"bSearchable": true,
            "defaultContent": ""
        },
		{
            "targets": 3,
            "data": 'name_customer',
			"bSortable" : false,
			"bSearchable": true,
			"defaultContent": ""
        },
		{
            "targets": 4,
            "data": 'brand',
			"bSortable" : false,
			"bSearchable": true,
            "defaultContent": ""
        },
		 {
            "targets": 5,
            "data": 'login',
			"bSortable" : false,
			"bSearchable": false,
            "defaultContent": ""
        }/*,
		 {
            "targets": 6,
            "data": 'remark',
			"bSortable" : false,
			"bSearchable": false,
            "defaultContent": ""
        }*/
		],
        "order": [[0, '']]
    });

function load_modal()
{
	$.ajax(
	{
		type: 'get',
		url: 'ajax/ajax_quote_four_modal.php',
		success:function(res)
		{
			$('#modal_quote_four').find('.modal-body').html(res);
		}
	});
}
function load_modal_copy(prmQauto){
		$.ajax({
			type: 'get',
			url: 'ajax/ajax_quote_four_modal_copy.php?q_auto='+prmQauto,
			success:function(res){
				$('#modal_quote_four').find('.modal-body').html(res);
			}
		});
	}

	var enforceModalFocusFn = $.fn.modal.Constructor.prototype.enforceFocus;
	$.fn.modal.Constructor.prototype.enforceFocus = function() {};

$("#modal_quote_four_customer").draggable({
		cursor: "move",
		handle: ".modal-header"
	});

	$(document).on('show.bs.modal', '#modal_quote_four_customer', function (event) {
		var zIndex = 1040 + (10 * 2);
		$(this).css('z-index', zIndex);
		var bd = $('.modal-backdrop');
		$(bd[bd.length - 1]).css('z-index', zIndex - 1);
		$.ajax({
			type: 'get',
			url: 'ajax/ajax_quote_four_customer.php',
			success:function(res){
				$('#modal_quote_four_customer').find('.modal-body').html(res);
			}
		});
		
	}).on('hidden.bs.modal', '.modal', function (event) {
		var zIndex = 1040 + (10 * 1);
		$('#modal_quote_four').css('z-index', zIndex);
		var bd = $('.modal-backdrop');
		$(bd[bd.length - 1]).css('z-index', zIndex - 1);
	});
	$(document).ready(function(){
		$("#modal_quote_four").on("show", function () {
			$("body").addClass("modal-open");
		}).on("hidden", function () {
			$("body").removeClass("modal-open")
		});
		$('.btn-disable').show();
	});

</script>