<?php
include "check-ses.php";
include "../../inc/connectdbs.pdo.php"; 
?>
 <link type="text/css" rel="stylesheet" href="assets/css/modal.css">

  
                <div class="container-fluid outer">
<div class="row-fluid">
                        <!-- .inner -->
  <div class="span12 inner">
                            <!--Begin Datatables-->
                            <div class="row-fluid">
                                <div class="widget-box">
                                    <div class="box">
                                         <div class="widget-header widget-header-flat">
                                            <div class="icons"><i class="icon-search" style="color:#fff;"></i></div>
                                            <h5 style="text-align:left;padding-top:5px;">ข้อมูล ( Mitsubishi )</h5>
                                       </div> 
                                        
                                       
                                        <div id="collapse4" class="body" style="padding-left:10px;">
                          
                                          
<form name="ajaxform" id="ajaxform"  method="POST">   
<div class="control-group">
<div style="width:806px;float:left;">
     
                                <select onchange="chkfocusdata()" name="otp" id="otp">
                                    <option value="senddate">วันที่แจ้งงาน</option>
                                    <option value="iddata">เลขที่รับแจ้ง</option>
                                    <option value="policy">เลขที่กรมธรรม์</option>
                                    <option value="regis">ทะเบียน</option>
                                    <option value="namesearch">ชื่อผู้เอาประกัน</option>
                                    <option value="prb">พ.ร.บ</option>
                                    <option value="carbody">เลขตัวถัง/ตัวเครื่อง</option>
                                    <option value="phone">เบอร์โทรศัพท์</option>
                                </select>

                                <span id="notdate" style="display:none;"><input type="text" name="txtsearch" id="txtsearch" placeholder="คำค้นหา" required/></span>
                                <span id="possenddate">
                                  <input type="text"  id="txtstartdate" name="txtstartdate" class="datepick"  placeholder="เริ่มวันที่" value="">  ถึง   <input type="text"  class="datepick"  id="txtenddate" placeholder="วันที่" name="txtenddate" value="">
                                </span>
                                <button class="btn btn-primary btn-small" id="search_post">Search</button>

</div>
      <div class="span5" id="pos_Blsit" style="padding-left:20px;color:red;"></div>
    </div> 
    
</form> 
<div style="clear:both;"></div>

 <div id="content_search" style="display:none;"> 
 </div>
                            </div>
                            <!--End Datatables-->

                            <hr>

                            <!-- /.row-fluid -->
                        </div>
                        <!-- /.inner -->
                    </div>
                    <!-- /.row-fluid -->
                </div>
                <!-- /.outer -->
  </div>  
            
           
            
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
<div class="modal-dialog" >
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
&times;</button>
<h4 class="modal-title">ใบคำขอประกันภัยรถยนต์</h4>
</div>
<div class="modal-body">
  
Load Data...

</div>
<div class="modal-footer">
<a href="#" class="btn btn-default" data-dismiss="modal">Close</a>

</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>
  <!-- Modal -->
<script type='text/javascript'>//<![CDATA[ 
$(document).on('click','a[data-toggle=modal]', function() {
        event.preventDefault();
        var $modal=$($(this).data('target'));
        $('.modal-body',$modal).empty();
        $modal.show();
        $('.modal-body',$modal).load($(this).attr('href'));
});

</script>    



 </div>

<!-- <script src="assets/validation/1.7.2/jquery.min.js"></script> <!-- or use local jquery --> 
<script src="assets/validation/jqBootstrapValidation.js"></script>

        
<script type='text/javascript'>

$("#search_post").click(function()
{
	 $('#txtsearch').attr('readonly',false);
   var otpB = $('#otp').val();
      $("#pos_Blsit").html("");
  // $("input,select,textarea").jqBootstrapValidation( );
   var chkpa=true;
  if(otpB=='senddate'){
                var txtstartdate = $('#txtstartdate').val();
                var txtenddate = $('#txtenddate').val();
                if(txtstartdate==''){
                    alert('กรุณาระบุวันที่ค้นหา');
                    $('#txtstartdate').focus();
                    chkpa='false';
                }else  if(txtenddate==''){
                    alert('กรุณาระบุวันที่ค้นหา');
                    $('#txtenddate').focus();
                    chkpa='false';
                }


       }else{
              var txtsearch = $('#txtsearch').val();
                if(txtsearch==''){
                    alert('กรุณาระบุข้อมูลที่ต้องการค้นหา');
                    $('#txtsearch').focus();
                    chkpa='false';
                }

           }

  if(chkpa == true){           
	$("#ajaxform").submit(function(e)
	{
		$("#content_search").html("<img src='img4/loadingIcon.gif'/>");
		var postData = $(this).serializeArray();
		var formURL = $(this).attr("action");
		$.ajax(
		{
			url: "pages/search_data_my4ib.php",
			type: "POST",
			data : postData,
			success:function(data, textStatus, jqXHR) 
			{
				$("#content_search").html(''+data+'');

			},
			error: function(jqXHR, textStatus, errorThrown) 
			{
				$("#content_search").html('<pre><code class="prettyprint">AJAX Request Failed<br/> textStatus='+textStatus+', errorThrown='+errorThrown+'</code></pre>');
			}
		});
    // Blacklist Search

	    e.preventDefault();	//STOP default action
	});
		
	$("#ajaxform").submit(); //SUBMIT FORM
	
}
	if(document.getElementById('content_search').style.display=='none') {
      document.getElementById('content_search').style.display='block';
    }
    
    	 
    
   
	
});


function chkBListSearch(){
  if($('#blistAdd').attr('checked')) {
      $('#blistdetail').css('display','inherit');
      $('#txtsearch').attr('readonly',true);
  } else {
    $('#blistdetail').css('display','none');
    $('#txtsearch').attr('readonly',false);
  }

}
function chkDTShow(){
  $('#blistShowDT').toggle();

}

function saveBList(){
  var votp = $('#otp').val();
  var vtxtsearch = $('#txtsearch').val();
  var voptUPD = $('#optUPD').val();
  var vblist_reason = $('#blist_reason').val();
  var votpcust = $('#otpcust').val();
  $(document).ready(function(){
    $.post("ajax/Ajax_SaveBlacklist.php",{
                         otp: votp,
                         txtsearch: vtxtsearch,
                         optUPD: voptUPD,
                         blist_reason: vblist_reason,
                         otpcust : votpcust
                     },
                     function(result){
                      $("#pos_Blsit").html(result);
                      $('#txtsearch').attr('readonly',false);
                     }
                 );
  });
}

</script>
<!-- <script language="JavaScript">
     function doCallAjax(Page) {
     // alert('show');
      var dtxtsearch  = $('#txtsearch').val();
      var txt_otp  = $('#otp').val();
      var txt_iddata = $('#txt_iddata').val();
     
    var options = 
    { 
      type:"POST",
      dataType: "html",
      url:"pages/search_data_my4ib.php",
      data:{
        myPage:Page,
        txtsearch:dtxtsearch,
        otp:txt_otp,
        Per_Page:'20'
      },
      success: function(msg) {
        $('#content_search').html(msg);
      }
    };
    $.ajax(options);

     }
  </script> -->

<script src="assets/js/bootstrap-datepicker.js"></script>
<script>
function chkfocusdata(){
   var votp = $('#otp').val();
   if(votp=='senddate'){
      $('#notdate').css('display','none');
      $('#possenddate').fadeIn('slow');
   }else{
     $('#notdate').fadeIn('slow');
     $('#possenddate').css('display','none');
   }
}
$('.datepick').datepicker(
            {
            language: "th",
            autoclose: true,
            format: 'dd/mm/yyyy'
            });
</script>