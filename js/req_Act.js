


$('#req').keypress(function(e){
    if( e.which == 13 ){
var r=confirm("คุณต้องการบันทึกสลักหลังใช่หรือไม่");
if (r==true)
  {
  $("#Save_req").click(); return false;
  }
else
  {
  return false;
  } 
		
		}
});

//----------------------สลักหลังเปลี่ยนแปลงวันคุ้มครอง----------------------///
	$('#EditTime').click(function(){
		if($('#EditTime').is(':checked')) {
				$("#ShowEditTime").show('slow');
	$(function() {
			var myDate = new Date();
			var prettyDate = myDate.getDate() + '/' + (myDate.getMonth()+1) + '/' + myDate.getFullYear();
			$("#EditTimeStartDate").datepicker({ 
				dateFormat: "dd/mm/yy" ,
				showOn: "button",
				buttonImage: "images/calendar.gif",
				buttonImageOnly: true,
				minDate: prettyDate
			}).val();
	});
	} else {
				$("#ShowEditTime").hide('slow');
			}   	
	});

//----------------------สลักหลังข้อมูลรถยนต์----------------------///
	$('#EditCar').click(function(){
		if($('#EditCar').is(':checked')) {
				$("#ShowEditCar").show('slow');
			} else {
				$("#ShowEditCar").hide('slow');
			}   	
	});

//----------------------สลักหลังเลขที่ พ.ร.บ.---------------------///
	$('#EditAct').click(function(){
		if($('#EditAct').is(':checked')) {
				$("#ShowEditAct").show('slow');
			} else {
				$("#ShowEditAct").hide('slow');
			}   	
	});

//----------------------สลักหลังเลขที่ พ.ร.บ.---------------------///
	$('#EditActList').click(function(){
		if($('#EditActList').is(':checked')) {
				$("#ShowEditActList").show('slow');
			} else {
				$("#ShowEditActList").hide('slow');
			}   	
	});

//----------------------สลักหลังที่อยู่ในการจัดส่งเอกสาร---------------------///
	$('#EditSendAdd').click(function(){
		if($('#EditSendAdd').is(':checked')) {
				$("#ShowEditSendAdd").show('slow');
					$("#NewAdd1").click(function() 
						 { 
							 $("#ShowNewAdd").hide('slow');
						 });
					$("#NewAdd2").click(function() 
						 { 
							 $("#ShowNewAdd").show('slow');
						 });
			} else {
				$("#ShowEditSendAdd").hide('slow');
			}   	
	});



//----------------------สลักหลังข้อมูลผู้เอาประกันภัย----------------------///
	$('#EditCustomer').click(function(){
		if($('#EditCustomer').is(':checked')) {
				$("#ShowEditCustomer").show('slow');

				if($("#perSo").val()==1){
					$("#EditPerson").attr('checked', true);
				}else if($("#perSo").val()==2)
			{
					$("#EditPersons").attr('checked', true);
			}
			else
			{
				$("#EditPersonss").attr('checked', true);
			}
		
				var options2 = {
						 type: "POST",
						 dataType: "json",
						 
						 url: "ajax/Ajax_EditPro.php",
						 data: {Cus_callajax:'START1'},
						 
						 success: function(msg) {
				
							 var returnedArray = msg;
							 cartype = $("#Cus_province");
							 cartype.append("<option value='0'>กรุณาเลือก</option>");
							if(returnedArray!=null){
								 for (i = 0; i < returnedArray.length; i++) {
								  cartype.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
							 	 }
							 $("#Cus_province").val($("#aa").val());
							}
							else{
								return false;
							}
						 }
					 };
					 $.ajax(options2);
					 
				$("#Cus_province").change(function(){
												   
						 $("#Cus_tumbon").empty();
						 $("#aa").val($("#Cus_province").val());
						 $("#Cus_tumbon").append("<option value='0'>กรุณาเลือก</option>");
						 $("#Cus_postal").empty();
						 $("#Cus_postal").append("<option value='0'>กรุณาเลือก</option>");
						 var _selected = $("#Cus_province").val();
						 var options = 
						 {
							 type: "POST",
							 dataType: "json",
							 
							 url: "ajax/Ajax_EditPro.php",
							 data: {
							 Cus_callajax:'AMPHUR',
							 Cus_province:_selected
							 },
							 success: function(msg) {
								$('#Cus_amphur').empty(); 
								 var returnedArray = msg;
								 state = $("#Cus_amphur");
								 state.append("<option value='0'>กรุณาเลือก</option>");
								 if(returnedArray!=null){
								 	for (var i = 0; i < returnedArray.length; ++i) {
									 	state.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
								 	}
								 }
								 else{
								 return false;
								 }
							 }
						 };
						 $.ajax(options);
				});
				
				$("#Cus_amphur").change(function() 
					 { 
						$("#Cus_postal").empty();
						 $("#Cus_postal").append("<option value='0'>กรุณาเลือก</option>");
						 var _selected = $("#Cus_amphur").val();
						 var options = 
						 {
							 type: "POST",
							 dataType: "json",
							 
							 url: "ajax/Ajax_EditPro.php",
							 data: {
							 Cus_callajax:'TUMBON',
							 Cus_amphur:_selected
							 },
							 success: function(msg) {
								$('#Cus_tumbon').empty(); 
								 var returnedArray = msg;
								 state = $("#Cus_tumbon");
								 state.append("<option value='0'>กรุณาเลือก</option>");
								 if(returnedArray!=null){
								 for (var i = 0; i < returnedArray.length; ++i) {
									 state.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
								 }
								 }
								 else{
								 return false;
								 }
							 }
						 };
						 $.ajax(options);
					 });
					 
				$("#Cus_tumbon").change(function(){ 
						 var _selected = $("#Cus_tumbon").val();
						 var options = 
						 {
							 type: "POST",
							 dataType: "json",
							 
							 url: "ajax/Ajax_EditPro.php",
							 data: {
							 Cus_callajax:'POST',
							 Cus_tumbon:_selected
							 },
							 success: function(msg) {
								$('#Cus_postal').empty(); 
								 var returnedArray = msg;
								 state = $("#Cus_postal");
								 if(returnedArray!=null){
									 for (var i = 0; i < returnedArray.length; ++i) {
										 state.append("<option value='" + returnedArray[i].Name + "'>" + returnedArray[i].Name + "</option>");
								 	}
								 }
								 else{
								 return false;
								 }
							 }
						 };
						 $.ajax(options);
					 });
				
			}
			else {
				$("#ShowEditCustomer").hide('slow');
			}   
});

//----------------------สลักหลังผู้รับผลประโยชน์----------------------///
	$('#EditHr').click(function(){
		if($('#EditHr').is(':checked')) {
				$("#ShowEditHr").show('slow');
			} else {
				$("#ShowEditHr").hide('slow');
			}   	
	});

//----------------------สลักหลังการออกใบเสร็จ---------------------///
	$('#EditReceipt').click(function(){
		if($('#EditReceipt').is(':checked')) {
				$("#ShowEditReceipt").show('slow');
			} else {
				$("#ShowEditReceipt").hide('slow');
			}   	
	});


//------------------สลักหลังอัตราเบี้ย---------------------///
$('#EditCost').click(function(){
		if($('#EditCost').is(':checked')) {
				$("#ShowEditCost").show('slow');
				/*var optionsCost1 = {
					
						 type: "POST",
						 dataType: "json",
						 url: "ajax/Ajax_EditCost.php",
						 data: {Editcallajax:'COST',
						 id_mo_car:$("#id_mo_car").val(),
						 id_gear:$("#id_gear").val(),
						 com_data:$("#comp_cost").val()
						 },
						 
						 success: function(msg) {
				
							 var returnedArray = msg;
							 EditcostCost = $("#EditcostCost");
							// EditcostCost.append("<option value='0'>กรุณาเลือก</option>");
							if(returnedArray!=null){
								 for (i = 0; i < returnedArray.length; i++) {
								  EditcostCost.append("<option value='" + returnedArray[i].id + "'>" + returnedArray[i].cost + "</option>");
							 	 }
							 EditcostCost.val($("#id_costCost").val());
							 var _selected = $("#EditcostCost").val();
								 var optionscost = {
									 type: "POST",
									 dataType: "json",
									 url: "ajax/Ajax_EditCost.php",
									 data: {callajax:'PRICE',
									 idcost:_selected,
									 },
									 success: function(msg) {
										 var returnedArray = msg;
										if(returnedArray!=null){
											  $("#EditcostPre").val(returnedArray.pre);
											  $("#EditcostStamp").val(returnedArray.stamp);
											  $("#EditcostTax").val(returnedArray.tax);
											  $("#EditcostNet").val(returnedArray.net);
										 }
										 else{
											 return false;
										 }
									 }
								 };
								 $.ajax(optionscost);
							}
							else{
								return false;
							}
						 }
					 };
					 $.ajax(optionsCost1);
					 
					 
				$("#EditcostCost").change(function(){
						var _selected = $("#EditcostCost").val();						   
						$("#EditcostPre").val('0.00');
						$("#EditcostStamp").val('0.00');
						$("#EditcostTax").val('0.00');
						$("#EditcostNet").val('0.00');
						 
						 var optionsCostChose = 
						 {
							 type: "POST",
							 dataType: "json",
							 url: "ajax/Ajax_EditCost.php",
							 data: {
							 Editcallajax:'PRICE',
							 EditcostCost:_selected
							 },
							 success: function(msg) {
								 var returnedArray = msg;
								 if(returnedArray!=null){
									  $("#EditcostPre").val(returnedArray.pre);
									  $("#EditcostStamp").val(returnedArray.stamp);
									  $("#EditcostTax").val(returnedArray.tax);
									  $("#EditcostNet").val(returnedArray.net);
								 }
								 else{
								 return false;
								 }
							 }
						 };
						 $.ajax(optionsCostChose);
				});*/
				} else {
				$("#ShowEditCost").hide('slow');
			}   	
	});
//--------------------Save สลักหลัง-----------------------///
$("#Save_req").click(function() 
     { 
	 $('#Save_reqCLOSE').css("display", "");
	 	if($("#Cancel_Detail").val()==''){
			 $("#Cancel_Detail").focus();
			 alert('กรุณากรอกรายละเอียดการยกเลิกกรมธรรม์');
			 return false;
	 	}
		if(document.getElementById('EditPerson').checked){
		 var valPerson = 1;
			}
			else if(document.getElementById('EditPersons').checked){
		 var valPerson = 2;
			}
			else
			{
				var valPerson = 3;
			}
	 var DATA = $('#req').serialize();
	 var SAVEREQ = {
         type: "POST",
         dataType: "json",
		 
         url: "ajax/Ajax_req_Act.php?valPerson="+valPerson,
         data: DATA,
         success: function(msg) {
			 var returnedArray = msg;
			 if(returnedArray.msg == 'Y')
			 {
				 $("#closed").click();
				alert('ยกเลิกกรมธรรม์เรียบร้อยแล้ว');				
				$(".modal").hide();
				$(".modal-backdrop").hide();		
				$(".modal").removeData('modal');
				$('#page-content').load("pages/load_CheckCancel.php");
				//location.href = '#load_CheckCancel|1|send_CheckCancel?'+returnedArray.id;
				//return false;
			 }
			 else
			 {
				 if(returnedArray.Re_req == '1')
				 {
					 $("#closed").click();
					alert('บันทึกข้อมูลการสลักหลังเรียบร้อย');		
					$(".modal").hide();
					$(".modal-backdrop").hide();		
					$(".modal").removeData('modal');
					$('#page-content').load("pages/load_Attached_Act.php");
					//location.href = '#load_Attached|1|send_Check?'+returnedArray.id;
					//return false;
			 	 }
				 else
				 {
					 $("#closed").click();
					alert('บันทึกข้อมูลการสลักหลังเรียบร้อย');				
					$(".modal").hide();
					$(".modal-backdrop").hide();		
					$(".modal").removeData('modal');
					$('#page-content').load("pages/load_Attached_Act.php");
					//location.href = '#load_CheckAttached|1|send_Check?'+returnedArray.id;
					//return false;
				 }
			 }
			 $('#Save_req').css("display", "");
	 		$('#Save_reqCLOSE').css("display", "none");
			 return false;
         },
		 error:function(msg) {
			 var returnedArray = msg;
             alert('การบันทึกสลักหลังผิดพลาด');
			 $('#Save_req').css("display", "");
	 		$('#Save_reqCLOSE').css("display", "none");
         }
     };
     $.ajax(SAVEREQ);
});


$("#Save_reqCancel").click(function() 
     { 
	  $('#Save_req').css("display", "none");
	 $('#Save_reqCLOSE').css("display", "");
	 	if($("#Cancel_Detail").val()==''){
			 $("#Cancel_Detail").focus();
			 alert('กรุณากรอกรายละเอียดการยกเลิกกรมธรรม์');
			 return false;
	 	}
		//if(document.getElementById('EditPerson').checked){
		 var valPerson = 1;
		//	}
		//	else if(document.getElementById('EditPersons').checked){
		 //var valPerson = 2;
			//}
			//else
			//{
			//var valPerson = 3;	
	// }
	 var DATA = $('#req').serialize();
	 var SAVEREQ = {
         type: "POST",
         dataType: "json",
		 
         url: "ajax/Ajax_req.php?valPerson="+valPerson,
         data: DATA,
         success: function(msg)
		 {
			 var returnedArray = msg;
			 if(returnedArray.msg == 'Y')
			 {
				 $("#closed").click();
				alert('ยกเลิกกรมธรรม์เรียบร้อยแล้ว');				
				$(".modal").hide();
				$(".modal-backdrop").hide();		
				$(".modal").removeData('modal');
	
				//location.href = '#load_CheckCancel|1|send_CheckCancel?'+returnedArray.id;
				//return false;
			 }
			 else
			 {
				 if(returnedArray.Re_req == '1')
				 {
					 $("#closed").click();
					alert('บันทึกข้อมูลการสลักหลังเรียบร้อย');		
					$(".modal").hide();
					$(".modal-backdrop").hide();		
					$(".modal").removeData('modal');

					//location.href = '#load_Attached|1|send_Check?'+returnedArray.id;
					//return false;
			 	 }
				 else
				 {
					 $("#closed").click();
					alert('บันทึกข้อมูลการสลักหลังเรียบร้อย');				
					$(".modal").hide();
					$(".modal-backdrop").hide();		
					$(".modal").removeData('modal');
					
					//location.href = '#load_CheckAttached|1|send_Check?'+returnedArray.id;
					//return false;
				 }
			 }
			 $('#Save_req').css("display", "");
	 		$('#Save_reqCLOSE').css("display", "none");
			 return false;
         },
		 error:function(msg) {
			 var returnedArray = msg;
             alert('การบันทึกสลักหลังผิดพลาด');
			 $('#Save_req').css("display", "");
	 		$('#Save_reqCLOSE').css("display", "none");
         }
     };
	 var id_can = $('#EditId_data').val();
	
	var now = new Date();

	 if(confirm('เลขรับแจ้ง '+id_can+' จะถูกยกเลิกความคุ้มครองในทันที คุณแน่ใจหรือไม่ '))
	 {
		 $.ajax(SAVEREQ);
	 }
	 else
	 {
		 return false;
	 }
});							
		 
function TotalTEXTplus()
 {
var textsave = '';
	 for(i=0;i<14;i++){
		 if($('#id_acc'+i).val()!=undefined){
			 if(i==0){
	 			 textsave = textsave+$('#id_acc'+i).val()+','+$('#id_price'+i).val();
			 }
			 else{
				 textsave = textsave+'|'+$('#id_acc'+i).val()+','+$('#id_price'+i).val();
			 }
		 }
	 }
	 $("#acc").val(textsave);
 }		
				