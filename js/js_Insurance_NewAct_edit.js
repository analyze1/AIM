$(document).ready(function()
{ 

	var CallCartype = {
		type: "POST",
		dataType: "json",
		url: "ajax/Ajax_Car.php",
		data: {callajax:'START1'},

		success: function(msg) {

			var returnedArray = msg;
			cartype = $("#cartype");
			if(returnedArray!=null){
				for (i = 0; i < returnedArray.length; i++) {
					cartype.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
				}
			}
			else{
				return false;
			}
		}
	};
	$.ajax(CallCartype);
	var CallProv = {
		type: "POST",
		dataType: "json",
		url: "ajax/Ajax_Pro.php",
		data: {callajax:'START1'},

		success: function(msg) {

			var returnedArray = msg;
			Carprov = $("#province");
			car_regis_pro = $("#car_regis_pro");
			//Carprov.append("<option value='0'>กรุณาเลือก</option>");
			//car_regis_pro.append("<option value='0'>กรุณาเลือก</option>");
			if(returnedArray!=null){
				for (i = 0; i < returnedArray.length; i++) {
					//Carprov.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
					//car_regis_pro.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
				}
			}
			else{
				return false;
			}
		}
	};
	$.ajax(CallProv);


	$('#pageSearch').hide('fast');
	$('form').attr('autocomplete', 'off');



$('#Insurance').keypress(function(e){
	if ( e.which == 13 ){SaveI(); return false;}
});
$('#person').click(function(){
	if($('#person').is(':checked')) {
		$("#icardTEXT").html(' * (กรุณากรอกเฉพาะตัวเลขบัตรประชาชน 13 หลัก)');
		$('#icard').val('');
	} 
});
$('#persons').click(function(){
	if($('#persons').is(':checked')) {
		$("#icardTEXT").html(' * (กรุณากรอกเฉพาะตัวเลขทะเบียนนิติบุคคล 13 หลัก)');
		$('#icard').val('');
	} 
});

function checkID(id)
{
	if(id.length != 13) return false;
	for(i=0, sum=0; i < 12; i++)
		sum += parseFloat(id.charAt(i))*(13-i); if((11-sum%11)%10!=parseFloat(id.charAt(12)))
	return false; return true;}

	$('#icard').blur(function(){
		if($('#icard').val()!=''){
			if($('#person').is(':checked')) { 
				if(!checkID($('#icard').val())){
					alert('รหัสประชาชนไม่ถูกต้อง');$('#icard').val('');
				}
			}
		}
	});
	
/* $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
เพิ่มอุปกรณ์
*/
$('#ADDTABLE').click(function(){
	var COL = '#CCCCCC';
	var NUMBER = $('#COUNTMORE').val();
	if (NUMBER < 14){
		$('#MORE_ADD').append('<tr id="tr'+NUMBER+'" bgcolor="'+COL+'"><td width="10%"></td><td width="25%"><select onchange="callcost('+NUMBER+',this.value);" name="id_acc'+NUMBER+'" id="id_acc'+NUMBER+'" ><option value="0" selected="selected">--กรุณาเลือกอุปกรณ์--</option></select></td><td width="25%" align="center"><select  onchange="splitcost('+NUMBER+',this.value);" name="id_price'+NUMBER+'" id="id_price'+NUMBER+'" ><option value="0" selected="selected">--กรุณาเลือกราคาอุปกรณ์--</option></select></td><td width="20%" align="center"></td></tr>');
		
		var CALLMORE = {
			type: "POST",
			dataType: "json",
			url: "ajax/Ajax_More.php",
			data: {callajax:'MORE',
			cartype:$("#cartype").val(),
			mo_car:$("#mo_car").val()
		},

		success: function(msg) {
			var returnedArray = msg;
			var TRADD = $('#id_acc'+NUMBER);
			if(returnedArray!=null){
				for (i = 0; i < returnedArray.length; i++) {
					TRADD.append("<option value='" + returnedArray[i].id + "'>" + returnedArray[i].name + "</option>");
				}
			}
			else{
				return false;
			}
		}
	};
	$.ajax(CALLMORE);
	$('#COUNTMORE').val(Number(NUMBER)+1);
}
else{
	alert('คุณไม่สามารถเพิ่มอุปกรณ์ได้อีก');
}
});
/* $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
ลบอุปกรณ์
*/
$('#moreclose').click(function(){
	var num = Number($('#COUNTMORE').val())-1

	CHOSE = "#tr"+num.toString();
	$(CHOSE).remove();
	$('#COUNTMORE').val(num);

	TotalCOSTplus();
	TotalTEXTplus();
});

$('BcloseIn').click(function(){
	$('#Insurance').reset();
});

$("#car_id").change(function()
{ 
	var _selected = $("#cartype").val();
	var _selected2 = $("#car_id").val();
	var CallAct = {
		type: "POST",
		dataType: "json",
		url: "ajax/Ajax_Prp.php",
		data: {idprp:_selected,
			id_car:_selected2},
			success: function(msg) {
				$('#id_prp').empty(); 
				$('#txtstamp1').val('0.00');
				$('#txttax1').val('0.00'); 
				$('#txtnet1').val('0.00'); 
				var returnedArray = msg;
				id_prp = $("#id_prp");
				if(returnedArray!=null){
					for (i = 0; i < returnedArray.length; i++) {
						id_prp.append("<option value='" + returnedArray[i].id + "'>" + returnedArray[i].prp + "</option>");
					}

					$("#txtstamp1").val('0.00');
					$("#txttax1").val('0.00');
					$("#txtnet1").val('0.00');


					var CallCostAct = {
						type: "POST",
						dataType: "json",
						url: "ajax/Ajax_Prp.php",
						data: {idprp:_selected,
							id_car:_selected2},
							success: function(msg) {
								var returnedArray = msg;
								txtstamp1 = $("#txtstamp1");
								txttax1 = $("#txttax1");
								txtnet1 = $("#txtnet1");
								if(returnedArray!=null){
									for (i = 0; i < returnedArray.length; i++) {
										txtstamp1.val(returnedArray[i].stamp);
										txttax1.val(returnedArray[i].tax);
										txtnet1.val(returnedArray[i].net);
									}
								}
								else{
									return false;
								}
							}
						};
						$.ajax(CallCostAct);

					}
					else{
						return false;
					}
				}
			};
			$.ajax(CallAct);
		});
/* $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
เลือกประเภท
*/
$("#cartype").change(function()
{ 
	$("#txtstamp1").val('0.00');
	$("#txttax1").val('0.00');
	$("#txtnet1").val('0.00');
	$("#id_prp").empty();
	$("#id_prp").append("<option value='0'>กรุณาเลือกเบี้ย</option>");
	$("#MORE_ADD").html('');
	$("#acc").val('');
	$("#price_acc_tun").val(0);
	$("#price_acc_cost").val(0);
	$("#COUNTMORE").val(0);
	$("#car_seat").val(0);
	$("#car_cc").val(0);
	$("#new_carbody").val('');
	$('#br_car').empty(); 
	$("#More").hide('slow');
	$("#More2").hide('slow');
	$("#costPre").val('0.00');
	$("#costStamp").val('0.00');
	$("#costTax").val('0.00');
	$("#costNet").val('0.00');
	$("#com_data").empty();
	$("#new_motor").val('');
	$("#eq_non").attr('checked', true);
	$("#com_data").append("<option value='0'>กรุณาเลือก</option>");
	$("#costCost").empty();
	$("#costCost").append("<option value='0'>-------------------</option>");
	var _selected = $("#cartype").val();
	var CallCarID = 
	{
		type: "POST",
		dataType: "json",
		url: "ajax/Ajax_Car.php",
		data: {
			callajax:'ID_CAR',
			id_pass_car:_selected
		},
		success: function(msg) {
			$('#car_id').empty(); 
			var returnedArray = msg;
			car_id = $("#car_id");
			if(returnedArray!=null){
				car_id.append("<option value='0'>กรุณาเลือก</option>");
				for (var i = 0; i < returnedArray.length; ++i) {
					car_id.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
				}
				if(i==1){
					car_id.val(returnedArray[0].Id);
					var _selected = $("#cartype").val();
					var _selected2 = $("#car_id").val();
					var CallAct = {
						type: "POST",
						dataType: "json",
						url: "ajax/Ajax_Prp.php",
						data: {idprp:_selected,
							id_car:_selected2},
							success: function(msg) {
								$('#id_prp').empty(); 
								$('#txtstamp1').val('0.00');
								$('#txttax1').val('0.00'); 
								$('#txtnet1').val('0.00'); 
								var returnedArray = msg;
								id_prp = $("#id_prp");
								if(returnedArray!=null){
									for (i = 0; i < returnedArray.length; i++) {
										id_prp.append("<option value='" + returnedArray[i].id + "'>" + returnedArray[i].prp + "</option>");
									}

									$("#txtstamp1").val('0.00');
									$("#txttax1").val('0.00');
									$("#txtnet1").val('0.00');


									var CallCostAct = {
										type: "POST",
										dataType: "json",
										url: "ajax/Ajax_Prp.php",
										data: {idprp:_selected,
											id_car:_selected2},
											success: function(msg) {
												var returnedArray = msg;
												txtstamp1 = $("#txtstamp1");
												txttax1 = $("#txttax1");
												txtnet1 = $("#txtnet1");
												if(returnedArray!=null){
													for (i = 0; i < returnedArray.length; i++) {
														txtstamp1.val(returnedArray[i].stamp);
														txttax1.val(returnedArray[i].tax);
														txtnet1.val(returnedArray[i].net);
													}
												}
												else{
													return false;
												}
											}
										};
										$.ajax(CallCostAct);

									}
									else{
										return false;
									}
								}
							};
							$.ajax(CallAct);
						}
					}
					else{
						car_id.append("<option value='0'>กรุณาเลือก</option>");
						return false;
					}
				}
			};		 
			$.ajax(CallCarID);


			if(_selected!=0){
				var CallCatCar = {
					type: "POST",
					dataType: "json",
					url: "ajax/Ajax_Car.php",
					data: {callajax:'START2',
					id_pass_car:_selected
				},
				success: function(msg) {
					$('#cat_car').empty(); 
					var returnedArray = msg;
					CallCatCar = $("#cat_car");
					if(returnedArray!=null){
						for (i = 0; i < returnedArray.length; i++) {
					
							CallCatCar.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
						}
					}
					else{
						CallCatCar.empty();
						CallCatCar.append("<option value='0'>กรุณาเลือก</option>");
						return false;
					}
				}
			};
			$.ajax(CallCatCar);



		}
		else{
			$('#cat_car').empty(); 
			$('#cat_car').append("<option value='0'>กรุณาเลือก</option>");
		}



		var _selected = $("#cartype").val();
		var CallBrand = 
		{
			type: "POST",
			dataType: "json",
			url: "ajax/Ajax_Car.php",
			data: {
				callajax:'BRAND2',
				cat_car:'0'+_selected,
			},
			success: function(msg) {
				$('#br_car').empty(); 
				var returnedArray = msg;
				br_car = $("#br_car");
				if(returnedArray!=null){
					for (var i = 0; i < returnedArray.length; ++i) {
						if(i==0){br_car.append("<option value='0'>กรุณาเลือก</option>");}
						br_car.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
					}
					if($('#cartype').val()==0){
						$('#br_car').empty(); 
						$('#br_car').append("<option value='0'>กรุณาเลือก</option>");
					}
				}
				else{
					return false;
				}
			}
		};
		$.ajax(CallBrand);
		




		var moreoption = {
			type: "POST",
			dataType: "json",
			url: "ajax/Ajax_More.php",
			data: {callajax:'START1',
			cartype: $("#cartype").val()
		},
		success: function(msg) {

			var returnedArray = msg;
			id_price = $("#id_price");
			idprice="#id_price";
			id_price.empty();
			id_price.append("<option value='0|0'>--กรุณาเลือกราคาอุปกรณ์--</option>");
			if(returnedArray!=null){
				for (i = 0; i < returnedArray.length; i++) {
					id_price.append("<option value='" + returnedArray[i].price + "'>" + returnedArray[i].name + "</option>");
					for (s = 1; s < 15; s++) {
						if(s==13 && $("#cartype").val()==1){$(idprice+s).append("<option value='" + returnedArray[i].price2 + "'>" + returnedArray[i].name + "</option>");}
						else{
							$(idprice+s).append("<option value='" + returnedArray[i].price + "'>" + returnedArray[i].name + "</option>");
						}
					}
				}
			}
			else{
				return false;
			}
		}
	};
	$.ajax(moreoption);

});

$("#br_car").change(function() 
{ 
	var _brcar =  $('#br_car').val();
		var CallType = 
		{
			type: "POST",
			dataType: "json",
			url: "ajax/Ajax_Car.php",
			data: {
				callajax:'TYPE2',
				br_car:_brcar,
			},
			success: function(msg) {
				$('#mo_car').empty(); 
				var returnedArray = msg;

				mo_car = $("#mo_car");
				mo_car.append("<option value='0'>กรุณาเลือก</option>");
				if(returnedArray!=null){
					for (var i = 0; i < returnedArray.length; ++i) {
						mo_car.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
					}
					
					if($('#cartype').val()==0 || $('#br_car').val()==0){
						$('#mo_car').empty(); 
						$('#mo_car').append("<option value='0'>กรุณาเลือก</option>");
					}
				}
				else{
					return false;
				}

			}
		};
		$.ajax(CallType);
});


$("#mo_car").change(function() 
{ 
	var _mocar =  $('#mo_car').val();
	var _cartype = $("#cartype").val();
	var CallCom = {
		type: "POST",
		dataType: "json",
		url: "ajax/Ajax_Cost.php",
		data: {callajax:'START',
		mo_car:_mocar,
		cartype:_cartype},

		success: function(msg) {

			var returnedArray = msg;
			$("#costCost").empty();
			$("#costCost").append("<option value='0'>-------------------</option>");
			com_data = $("#com_data");
			com_data.empty(); 
			com_data.append("<option value='0'>--กรุณาเลือกบริษัท--</option>");
			if(returnedArray!=null){

				for (i = 0; i < returnedArray.length; i++) {
					com_data.append("<option value='" + returnedArray[i].sort + "'>" + returnedArray[i].name + "</option>");

					if($('#cartype').val()==0){
						$("#com_data").empty(); 
						$("#com_data").append("<option value='0'>กรุณาเลือก</option>");
					}
				}
			}
			else{
				return false;
			}
		}
	};
	$.ajax(CallCom);

	$("#costPre").val('0.00');
	$("#costStamp").val('0.00');
	$("#costTax").val('0.00');
	$("#costNet").val('0.00');
	$("#com_data").val(0);
	var _selected = $("#mo_car").val();
	var _input = $("#new_carbody");
	var _input1 = $("#new_motor");
	var car_seat = $("#car_seat");
	var gear = $("#gear");
	var car_cc = $("#car_cc");


	var new_mo = _selected;

});


$("#province").change(function() 
{ 
	$("#tumbon").empty();
	$("#tumbon").append("<option value='0'>กรุณาเลือก</option>");
	$("#id_post").empty();
	$("#id_post").append("<option value='0'>กรุณาเลือก</option>");
	var _selected = $("#province").val();
	var options = 
	{
		type: "POST",
		dataType: "json",
		url: "ajax/Ajax_Pro.php",
		data: {
			callajax:'AMPHUR',
			province:_selected
		},
		success: function(msg) {
			$('#amphur').empty(); 
			var returnedArray = msg;
			state = $("#amphur");
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

$("#amphur").change(function() 
{ 
	$("#id_post").empty();
	$("#id_post").append("<option value='0'>กรุณาเลือก</option>");
	var _selected = $("#amphur").val();
	var options = 
	{
		type: "POST",
		dataType: "json",
		url: "ajax/Ajax_Pro.php",
		data: {
			callajax:'TUMBON',
			amphur:_selected
		},
		success: function(msg) {
			$('#tumbon').empty(); 
			var returnedArray = msg;
			state = $("#tumbon");
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

$("#tumbon").change(function() 
{ 
	var _selected = $("#tumbon").val();
	var options = 
	{
		type: "POST",
		dataType: "json",
		url: "ajax/Ajax_Pro.php",
		data: {
			callajax:'POST',
			tumbon:_selected
		},
		success: function(msg) {
			$('#id_post').empty(); 
			var returnedArray = msg;
			state = $("#id_post");
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





$("#rdodriverN").click(function() 
{ 
	$("#Divdriver1").hide('slow');
	$("#Divdriver2").hide('slow');
});

$("#rdodriver1").click(function() 
{ 
	$("#Divdriver1").show('slow');
	$("#Divdriver2").hide('slow');
});

$("#rdodriver2").click(function() 
{ 
	$("#Divdriver1").show('slow');
	$("#Divdriver2").show('slow');
});

$("#eq").click(function() 
{ 
	var brandchose = $('#cartype').val();
	if(brandchose==0){
		alert("กรุณาเลือกประเภทการใช้งาน");
		$('#cartype').focus();
		$("#eq_non").attr('checked', 'checked');
		return false;
	}

	$('#ADDTABLE').click();
	$("#More").show('slow');
});

$("#eq_non").click(function() 
{ 
	$('#moreclose').click();
	$("#More").hide('slow');
});


function Chose_PRICE(val,type) 
{
	var _more = val
	var options2 = {
		type: "POST",
		dataType: "json",
		url: "ajax/Ajax_More.php",
		data: {callmore:'PRICE',
		type: type},
		success: function(msg) {
			var returnedArray = msg;
			more = $("#costprice-"+_more);
			if(returnedArray!=null){
				more.val(returnedArray[0].name);
			}
			else{
				return false;
			}
		}
	};
	$.ajax(options2);
}

$("#gear").change(function() 
{
	if($("#gear").val()=="A")
	{ 
		mo_car_sub = $("#mo_car_sub");
		$("#mo_car_sub").empty();
		mo_car_sub.append("<option value='0'>--กรุณาเลือก model--</option>");
		mo_car_sub.append("<option value='5'>ZF1C9C00AA14 [GA OLD]</option>");
		mo_car_sub.append("<option value='6'>ZF1C9E00AA14 [GA NEW]</option>");
		mo_car_sub.append("<option value='7'>ZF1C9H00AA14 [GL OLD]</option>");
		mo_car_sub.append("<option value='8'>ZF1C9K00AA14 [GL NEW]</option>");
		mo_car_sub.append("<option value='9'>GLX</option>");		
	}
	if($("#gear").val()=="M")
	{ 
		mo_car_sub = $("#mo_car_sub");
		$("#mo_car_sub").empty();
		mo_car_sub.append("<option value='0'>--กรุณาเลือก model--</option>");
		mo_car_sub.append("<option value='1'>ZF1C2C00AA14 [GA OLD]</option>");
		mo_car_sub.append("<option value='2'>ZF1C2E00AA14 [GA NEW]</option>");
		mo_car_sub.append("<option value='3'>ZF1C2H00AA14 [GL OLD]</option>");
		mo_car_sub.append("<option value='4'>ZF1C2K00AA14 [GL NEW]</option>");	
	}
});


$("#com_data").change(function() 
{
	var _selected = $("#com_data").val();
	var _selected2 = $("#com_data").val();
	var gear = $("#gear").val();
	var car_cc = $("#car_cc").val();
	var cat_car = $("#cartype").val();
	var mo_car = $("#mo_car").val();
	var mo_car_sub = $("#mo_car_sub").val();
	$("#costPre").val('0.00');
	$("#costStamp").val('0.00');
	$("#costTax").val('0.00');
	$("#costNet").val('0.00');
	var alert_msg = '';
	if(gear==0){
		alert("กรุณาเลือกเกียร์");
		$('#gear').focus();
		$("#com_data").val(0);
		return false;
	}
	else if(car_cc==0){
		alert("กรุณาเลือกซีซี");
		$('#car_cc').focus();
		$("#com_data").val(0);
		return false;
	}
	else if(cat_car==0){
		alert("กรุณาเลือกประเภทรถ");
		$('#cat_car').focus();
		$("#com_data").val(0);
		return false;
	}
	else if(mo_car==0){
		alert("กรุณาเลือกรุ่นรถ");
		$('#mo_car').focus();
		$("#com_data").val(0);
		return false;
	}
	else if(mo_car==1951){
		if(mo_car_sub==0){
			alert("กรุณาเลือก model");
			$('#mo_car_sub').focus();
			$("#com_data").val(0);
			return false;
		}
	}
	$.ajax(options3);

	var _selected1 = $("#cartype").val();
	var car_id = $("#car_id").val();

	var options3 = {
		type: "POST",
		dataType: "json",
		url: "ajax/Ajax_Cost.php",
		data: {callajax:'COST',
		comdata:_selected,
		gear:gear,
		car_cc:car_cc,
		cat_car:cat_car,
		mo_car:mo_car,
		mo_car_sub:mo_car_sub,
		idcar:car_id},
		success: function(msg) {
			var returnedArray = msg;
			$("#costCost").empty();
			costCost = $("#costCost");
			costCost.append("<option value='0'>--กรุณาเลือกทุนประกันภัย--</option>");
			if(returnedArray!=null){
				for (i = 0; i < returnedArray.length; i++) {
					costCost.append("<option value='" + returnedArray[i].id + "'>" + returnedArray[i].cost + "</option>");
				}
			}
			else{
				return false;
			}
			
			
		}
	};
	$.ajax(options3);
});


$("#costCost").change(function() 
{
	var _selected = $("#costCost").val();
	$.ajax(options3);
	var options3 = {
		type: "POST",
		dataType: "json",
		url: "ajax/Ajax_Cost.php",
		data: {callajax:'PRICE',
		idcost:_selected,
	},
	success: function(msg) {
		var returnedArray = msg;
		if(returnedArray!=null){
			$("#costPre").val(addCommas(returnedArray.pre));
			$("#costStamp").val(addCommas(returnedArray.stamp));
			$("#costTax").val(addCommas(returnedArray.tax));
			$("#costNet").val(addCommas(returnedArray.net));
		}
		else{
			return false;
		}
	}
};
$.ajax(options3);
});

$("#Dxuser").change(function() 
{
	var _selected = $("#Dxuser").val();
	var options4 = {
		type: "POST",
		dataType: "json",
		url: "ajax/Ajax_saka.php",
		data: {callajax:'SAKA',
		saka:_selected,
	},
	success: function(msg)
	{
		var returnedArray = msg;
		if(returnedArray!=null)
		{
			$("#p_act2").val(returnedArray.saka);
			//$("#p_act3").val(returnedArray.act_no);
		}
		else
		{
			return false;				 
		}
	}
};
$.ajax(options4);

	var options4 = {
		type: "POST",
		dataType: "json",
		url: "ajax/Ajax_saka.php",
		data: {callajax:'ACTNO',
		saka:_selected,
	},
	success: function(msg)
	{
		var returnedArray = msg;
		$('#p_act3').empty(); 
		p_act3 = $("#p_act3");
		p_act3.append("<option value='0'>---กรุณาเลือก---</option>");
		if(returnedArray!=null)
		{
			for (i = 0; i < returnedArray.length; i++)
			{
				p_act3.append("<option value='" + returnedArray[i].act_no + "'>" + returnedArray[i].act_no + "</option>");
			}
		}
		else
		{
			return false;
		}
	}
	};
	$.ajax(options4);
});

function SaveI() 
{ 
	$('#SaveInsurance').css("display", "none");
	$('#BlockSAVE').css("display", "");
if($("#q_auto").val()=="")
{
alert('กรุณาป้อนที่ใบเสนอราคา');
$("#q_auto").focus();
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
return false;
}
if($("#q_auto").val().length<8 || $("#q_auto").val().length>8)
{
alert('กรุณาป้อนเลขที่ใบเสนอราคา ให้ครบ 8 ตัวอักษร');
$("#q_auto").focus();
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
return false;
}
if($("#js_q_auto").val()=="")
{
alert('เลขที่ใบเสนอราคา '+$("#q_auto").val()+' ไม่มีข้อมูล');
$("#q_auto").focus();
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
return false;
}
	if($("#xuser").val()=='admin'){
		if($("#Dxuser").val()==0){
			$("#Dxuser").focus();
			alert('กรุณาเลือกรหัสผู้แจ้ง');
			$('#SaveInsurance').css("display", "");
			$('#BlockSAVE').css("display", "none");
			return false;
		}
	}
	/*if($('#start_date').val()<$('#end_date').val());
	{
		$('#start_date').focus();
	alert('คุณเลือกวันคุ้มครองย้อนหลัง');
			$('#SaveInsurance').css("display", "");
			$('#BlockSAVE').css("display", "none");
			return false;
	}*/
	
		if($('#start_date').val()=="")
	{
		$('#start_date').focus();
		alert('กรุณาเลือกวันคุ้มครอง');
			$('#SaveInsurance').css("display", "");
			$('#BlockSAVE').css("display", "none");
			return false;
	}
	


	if($("#cartype").val()==0){
		$("#cartype").focus();
		alert('กรุณาเลือกประเภทการใช้งาน');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#car_id").val()==0){
		$("#car_id").focus();
		alert('กรุณาเลือกลักษณะใช้งาน');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#cat_car").val()==0){
		$("#cat_car").focus();
		alert('กรุณาเลือกประเภทรถ');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#br_car").val()==0){
		$("#br_car").focus();
		alert('กรุณาเลือกยี่ห้อรถ');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#mo_car").val()==0){
		$("#mo_car").focus();
		alert('กรุณาเลือกรุ่นรถ');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#car_cc").val()=="0"){
		$("#car_cc").focus();
		alert('กรุณาเลือกจำนวน ซี.ซี.');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	/*if($("#car_wgt1").val()==""){
		$("#car_wgt1").focus();
		alert('กรุณาป้อนในช่อง น้ำหนัก');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}*/
		if($("#car_wgt").val()=="0"){
		$("#car_wgt").focus();
		alert('กรุณาเลือกน้ำหนัก');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#car_seat1").val()==""){
		$("#car_seat1").focus();
		alert('กรุณาป้อนในช่อง จำนวนที่นั่ง');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#car_seat").val()==0){
		$("#car_seat").focus();
		alert('กรุณาเลือกจำนวนที่นั่ง');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#gear").val()==0){
		$("#gear").focus();
		alert('กรุณาเลือกเกียร์');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#new_carbody").val()==0){
		$("#mo_car").focus();
		alert('กรุณาเลือกรุ่นรถ');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	else if($("#car_body").val()==0){
		$("#car_body").focus();
		alert('กรุณากรอกเลขตัวถัง');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#new_motor").val()==0){
		$("#mo_car").focus();
		alert('กรุณาเลือกรุ่นรถ');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#n_motor").val()==0){
		$("#n_motor").focus();
		alert('กรุณากรอกเลขเครื่อง');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#car_regis_pro").val()==0){
		$("#car_regis_pro").focus();
		alert('กรุณาเลือกจังหวัดทะเบียนรถ');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	else if($("#car_color").val()==0){
		$("#car_color").focus();
		alert('กรุณาเลือกสีรถ');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#name_gain").val()==0){
		$("#name_gain").focus();
		alert('กรุณาเลือกผู้รับผลปะโยชน์');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#p_act3").val()==0){
		$("#p_act3").focus();
		alert('กรุณากรอกเลข พ.ร.บ. หรือกรณีไม่ซื้อ พ.ร.บ. กรอก "9999999"');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#id_acc0").val()==0 || $("#id_price0").val()==0){
		CheckT();
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#icard").val()==0){
		$("#icard").focus();
		alert('กรุณากรอกเลขบัตรประชาชน หรือ เลขหมายทะเบียนการค้า 13 หลัก');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#title").val()==0){
		$("#title").focus();
		alert('กรุณาเลือกคำนำหน้าชื่อ');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#name_name").val()==0){
		$("#name_name").focus();
		alert('กรุณากรอกชื่อ');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#last").val()==0){
		$("#last").focus();
		alert('กรุณากรอกนามสกุล');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#add").val()==0){
		$("#add").focus();
		alert('กรุณากรอกบ้านเลขที่');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#province").val()==0){
		$("#province").focus();
		alert('กรุณาเลือกจังหวัด');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#amphur").val()==0){
		$("#amphur").focus();
		alert('กรุณาเลือกอำเภอ');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#tumbon").val()==0){
		$("#tumbon").focus();
		alert('กรุณาเลือกตำบล');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#email").val()==0){
		$("#email").focus();
		alert('กรุณากรอกอีเมล์');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#com_data").val()==0){
		$("#com_data").focus();
		alert('กรุณาเลือกบริษัทประกันภัย');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#costCost").val()==0){
		$("#costCost").focus();
		alert('กรุณาเลือกทุนประกันภัย');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#tel_mobi").val()==0){
		$("#tel_mobi").focus();
		alert('คุณลืมกรอกเบอร์มือถือ');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#regis_date").val()=='N'){
		$("#regis_date").focus();
		alert('กรุณาเลือกปีรถ');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#car_regis").val()==''){
		$("#car_regis").focus();
		alert('กรุณากรอกทะเบียนรถ');
		$('#SaveInsurance').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	
	
		var DATA = $('#Insurance').serialize();
		var SAVE = {
			type:"POST",
			dataType:"json",
			url:"ajax/Ajax_InsuranceSave_NewAct.php",
			data:DATA,
			success:function(msg) {
				var returnedArray = msg;
				alert(returnedArray.msg);
				if(returnedArray.check=="T")
				{
				$('#SaveInsurance').css('display', 'none');
				$('#BlockSAVE').css('display', '');
				load_page('pages/load_viewACT.php','ตรวจสอบข้อมูล');
				}
				else
				{
				$('#SaveInsurance').css('display', '');
				$('#BlockSAVE').css('display', 'none');
				}
			},
			error:function(msg){
				var returnedArray = msg;
				$('#SaveInsurance').css('display', '');
				$('#BlockSAVE').css('display', 'none');
				alert('การบันทึกผิดพลาด');
			}
		};

			$.ajax(SAVE);


}




$("#SaveInsurance").click(function() 
{
	SaveI();
});


});

function callcost(data,costval)
{
	if(costval!=0){
		var _select = costval.split('|');
		var CALLCOSTS = {
			type: "POST",
			dataType: "json",
			url: "ajax/Ajax_More.php",
			data: {callajax:'COST',
			cartype:$("#cartype").val(),
			mo_car:$("#mo_car").val(),
			type:_select[1]
		},
		success: function(msg) {

			var returnedArray = msg;
			var PRICE = $('#id_price'+data);
			PRICE.empty();
			PRICE.append('<option value="0" selected="selected">--กรุณาเลือกราคาอุปกรณ์--</option>');
			if(returnedArray!=null){
				for (i = 0; i < returnedArray.length; i++) {
					PRICE.append("<option value='" + returnedArray[i].id + "'>" + returnedArray[i].name + "</option>");
				}

			}
			else{
				return false;
			}
		}
	};
	$.ajax(CALLCOSTS);
	TotalCOSTplus();
	TotalTEXTplus();
}
else{
	$('#id_price'+data).empty();
	$('#id_price'+data).append('<option value="0" selected="selected">--กรุณาเลือกราคาอุปกรณ์--</option>');
	$('#price_acc'+data).val(0);
	TotalCOSTplus();
	TotalTEXTplus();
}
}



function splitcost(data,costval)
{
	TotalCOSTplus(data);
	var textchose = $("#price_acc_cost").val();
	var textsplit = textchose.split(',')
	var costChose = 0.00;
	for(i=1;i<textchose.length;i++){
		var costChose = costChose+textsplit[i]
	}
	TotalTEXTplus();
}

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

function TotalCOSTplus(id)
{
	var TotalCOST = {
		type: "POST",
		dataType: "json",
		url: "ajax/Ajax_More.php",
		data: {callajax:'TOTAL',
		cartype:$("#cartype").val(),
		mo_car:$("#mo_car").val()
	},
	success: function(msg) {

		var returnedArray = msg;
		if(returnedArray!=null){
			var textTun = 0;
			var textTunCap = 0;
			var textCostCap = 0;
			var CostNormal = 0;
			for(i=0;i<14;i++){
				if($('#id_acc'+i).val()!=undefined){
					if($('#id_price'+i).val()!=0){
						FixCost = $('#id_price'+i).val();
										 //if($('#id_acc'+i).val()!=14){
										 	textTun = Number(textTun)+Number(returnedArray[FixCost].name);

										// }
										//	 else
										//	 {
										//		 textCostCap = Number(textCostCap)+Number(returnedArray[FixCost].price1);
										//		 textTunCap = Number(textTunCap)+Number(returnedArray[FixCost].name);
										//	 }
									}
								}

							}
							var countauto = 1;
							var Costauto = 0;
							if($("#cartype").val()==1){
								var Limit = 150000;
							}
							else if($("#cartype").val()==3){
								var Limit = 140000;
							}
							else if($("#cartype").val()==2){
								var Limit = 140000;
							}
							while(Costauto != 1 && textTun!=0 &&textTun<=Limit){
								if(returnedArray[countauto]!=undefined){
									if(textTun+'.00'==returnedArray[countauto].name){
										CostNormal=returnedArray[countauto].price;
										Costauto++;
									}
								}
								countauto++;
							}
							$("#price_acc_cost").val(addCommas(Number(CostNormal)+Number(textCostCap)));
							$("#price_acc_tun").val(addCommas(Number(textTun)+Number(textTunCap)));

							var CheckCOST = $("#price_acc_tun").val();
							var ScheckCOST = CheckCOST.split(',');
							if(ScheckCOST[0]+ScheckCOST[1]>Limit){
								$("#id_price"+id).val(0);
								alert('คุณไม่สามารถเพิ่มทุนได้มากกว่า '+ addCommas(Limit) +' บาท');
								TotalCOSTplus(id);
							}
						}
						else{
							return false;
						}
					}
				};
				$.ajax(TotalCOST);
			}

			function CheckT(){
				come = $('#COUNTMORE').val();
				come = Number(come)-1;
				var str = come.toString();
				for(i=0;i <=come;i++){
					if(
						$('#id_acc'+i).val()==0){
						alert('กรุณาเลือกอุปกรณ์ตกแต่ง');
					$('#ADD_MORE').focus();
					return false;
				}
				if($('#id_price'+i).val()==0){
					alert('กรุณาเลือกราคาอุปกรณ์ตกแต่ง');
					$('#ADD_MORE').focus();
					return false;
				}
			}
		}

		function addCommas(nStr){
			nStr += '';
			x = nStr.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
			}
			return x1 + x2;
		}