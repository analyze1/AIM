// JavaScript Document
function toFixed(num, pre){
    num *= Math.pow(10, pre);
    num = (Math.round(num, pre) + (((num - Math.round(num, pre))>=0.5)?1:0)) / Math.pow(10, pre);
    return num.toFixed(pre);
}




function calcfunc_inform() 
{
	
	var valpre1 = $('#pre_inform').val().replace(/,/g,'');  //เบี้ยสุทธิ
	var floatVv1 = parseFloat(valpre1.replace(/,/g,''));
	//var age_driver = document.getElementById( 'driver' ).value;  //ส่วนลดผู้ขับขี่1
	var ncb = document.getElementById( 'good_inform' ).value.replace(/,/g,'');  //ส่วนลด ncb
	var ncb2 = document.getElementById( 'goodb_inform' ).value.replace(/,/g,'');  //ส่วนลด ncb
	var driver = document.getElementById( 'driver_inform' ).value.replace(/,/g,'');  //ส่วนลด ผู้ขับขี่
	var one = document.getElementById( 'disone_inform' ).value.replace(/,/g,'');  //ส่วนลดความเสียหายส่วนแรก
	var commition1 = document.getElementById( 'commition_inform' ).value.replace(/,/g,'');  //ส่วนลด com
	var commition = parseFloat(commition1.replace(/,/g,''));
	var sum_prb = document.getElementById( 'select_prb_inform' ).value.replace(/,/g,'');  //ส่วนลด com
	var d_agent = document.getElementById( 'currentValue_inform' ).value.replace(/,/g,''); 
	var add_dis = document.getElementById( 'dis_vip_inform' ).value.replace(/,/g,'');
	var group3 = document.getElementById( 'group3_inform' ).value.replace(/,/g,'');
	var pro_dis = document.getElementById( 'pro_dis_inform' ).value.replace(/,/g,'');
	var pro_dis2 = document.getElementById( 'pro_dis2_inform' ).value.replace(/,/g,'');
	var vat1 = document.getElementById( 'vat1_inform' ).value.replace(/,/g,'');
	var vat_2 = 0;
	var vehicle_tax = document.getElementById( 'vehicle_tax_inform' ).value.replace(/,/g,'');  
	var service_charge = document.getElementById( 'service_charge_inform' ).value.replace(/,/g,''); 	

	/////// ส่วนลดผู้ขับขี่------------------------------------------------------
	var dis1 = (parseFloat(driver) + parseFloat(one));
	var total_age_driver = (floatVv1- dis1).toFixed(2); // ผลของส่วนลดผู้ขับขี่ 1
	var dis_group3 = Math.round(total_age_driver *  group3 / 100);
	var total_age_driver3 = (total_age_driver - dis_group3).toFixed(2); // ผลของส่วนลดผู้ขับขี่ 1
	var dis2 = Math.round(total_age_driver3 *  ncb / 100); // ผลของส่วนลด NCB	
	var total_age_driver_ncb = ((total_age_driver3 - dis2) ).toFixed(2); 
	var sum_pro1pro2 = (total_age_driver_ncb *  pro_dis / 100).toFixed(2);
	var sum_prodis2 = (parseFloat(pro_dis2)).toFixed(2); 
	let _other = document.getElementById('other_inform').value.replace(/,/g, '');
    _other = parseFloat(_other) - parseFloat(commition1);
	// alert(_other);
	// alert(commition1);

	if(d_agent == "8+13")
	{
		if(total_age_driver_ncb >= 5000.00)
		{				
			var num5000 = 5000*8/100;
			var num5000_8 = total_age_driver_ncb - 5000;
			var dis_total_num5000 = num5000_8*13/100;
			var total_disnum5000 = (parseFloat(num5000 + dis_total_num5000)).toFixed(2);
			var total_sum_dis = (total_age_driver_ncb - total_disnum5000).toFixed(2); // ผลของส่วนลดผู้ขับขี่ 1
			var  sum_pre = (parseFloat(total_age_driver_ncb)).toFixed(2); // เบี้ยสุทธิ หักส่วนลด
			var result_stamp =  Math.ceil(sum_pre * 0.4 /100); //.toFixed(2)  อากร = เบี้ยสุทธิ * 0.4/100		
			var  vat_1 = 0;
			var sum_stamp = (parseFloat(sum_pre) + parseFloat(result_stamp)).toFixed(2); // ผลรวม = อากร+เบี้ยลด
			var new_vat = parseFloat(sum_stamp * 7 /100);
			var result_vat = toFixed(new_vat,2); //ผลรวม vat = ผลรวมอากร *7 /100
			var result_sum = (parseFloat(sum_stamp) + parseFloat(result_vat)).toFixed(2); // ยอดชำระ = ผลรวม + vat
		
			if(vat1 != '0')
			{
				var  vat_1 = ((parseFloat(sum_pre) + parseFloat(result_stamp))/100).toFixed(2);
				var vat_2 = parseFloat(sum_prb/1.07/100).toFixed(2);
				var total_vat1 = (parseFloat(result_sum) - parseFloat( vat_1) - parseFloat( vat_2)).toFixed(2); 
				var result_prb = (((parseFloat(total_vat1) - parseFloat(sum_pro1pro2)) - parseFloat(sum_prodis2)) + parseFloat(sum_prb)).toFixed(2); // รวม พ.ร.บ.
				var dis_prb = (parseFloat(result_prb) * parseFloat(add_dis)/ 100).toFixed(2);// ส่วนลด เบี้ยรวม
				var to_dis3 = (parseFloat(total_disnum5000)  + parseFloat(dis_prb)).toFixed(2); // รวม คอมมิชั่น
				var result_commition = (parseFloat(result_prb) - parseFloat(to_dis3) - parseFloat(_other) + parseFloat(vehicle_tax) + parseFloat(service_charge)).toFixed(2);
			}
			else
			{
				var result_prb = (((parseFloat(result_sum) - parseFloat(sum_pro1pro2))-parseFloat(sum_prodis2)) + parseFloat(sum_prb)).toFixed(2); // รวม พ.ร.บ.
				var dis_prb = (parseFloat(result_prb) * parseFloat(add_dis)/ 100).toFixed(2);// ส่วนลด เบี้ยรวม
				var to_dis3 = (parseFloat(total_disnum5000)  + parseFloat(dis_prb)).toFixed(2); // รวม คอมมิชั่น
				var result_commition = (parseFloat(result_prb) - parseFloat(to_dis3) - parseFloat(_other) + parseFloat(vehicle_tax) + parseFloat(service_charge)).toFixed(2);
			}
		}
		
		else if(total_age_driver_ncb < 5000.00)
		{
			var total_disnum5000 = (parseFloat(total_age_driver_ncb*8/100)).toFixed(2);
			//	var total_sum_dis = total_ncb - total_disnum5000;
			var total_sum_dis = (total_age_driver_ncb - total_disnum5000).toFixed(2); // ผลของส่วนลดผู้ขับขี่ 1
			var  sum_pre = (parseFloat(total_age_driver_ncb)).toFixed(2); // เบี้ยสุทธิ หักส่วนลด
			var result_stamp =  Math.ceil(sum_pre * 0.4 /100); //.toFixed(2)  อากร = เบี้ยสุทธิ * 0.4/100		
			var vat_1 = 0;
			var sum_stamp = (parseFloat(sum_pre) + parseFloat(result_stamp)).toFixed(2); // ผลรวม = อากร+เบี้ยลด
			var new_vat = parseFloat(sum_stamp * 7 /100);
			var result_vat = toFixed(new_vat,2); //ผลรวม vat = ผลรวมอากร *7 /100
			var result_sum = (parseFloat(sum_stamp) + parseFloat(result_vat)).toFixed(2); // ยอดชำระ = ผลรวม + vat
			
			if(vat1 != '0')
			{
				var vat_2 = parseFloat(sum_prb/1.07/100).toFixed(2);
				var  vat_1 = ((parseFloat(sum_pre) + parseFloat(result_stamp))/100).toFixed(2);
				var total_vat1 = (parseFloat(result_sum) - parseFloat( vat_1) - parseFloat( vat_2)).toFixed(2); 
				var result_prb = (((parseFloat(total_vat1) - parseFloat(sum_pro1pro2)) - parseFloat(sum_prodis2)) + parseFloat(sum_prb)).toFixed(2); // รวม พ.ร.บ.
				var dis_prb = (parseFloat(result_prb) * parseFloat(add_dis)/ 100).toFixed(2);// ส่วนลด เบี้ยรวม
				var to_dis3 = (parseFloat(total_disnum5000)  + parseFloat(dis_prb)).toFixed(2); // รวม คอมมิชั่น
				var result_commition = (parseFloat(result_prb) - parseFloat(to_dis3) - parseFloat(_other) + parseFloat(vehicle_tax) + parseFloat(service_charge)).toFixed(2);
			}
			else
			{
				var result_prb = (((parseFloat(result_sum) - parseFloat(sum_pro1pro2)) - parseFloat(sum_prodis2)) + parseFloat(sum_prb)).toFixed(2); // รวม พ.ร.บ.
				var dis_prb = (parseFloat(result_prb) * parseFloat(add_dis)/ 100).toFixed(2);// ส่วนลด เบี้ยรวม
				var to_dis3 = (parseFloat(total_disnum5000)  + parseFloat(dis_prb)).toFixed(2); // รวม คอมมิชั่น
				var result_commition = (parseFloat(result_prb) - parseFloat(to_dis3)- parseFloat(_other) + parseFloat(vehicle_tax) + parseFloat(service_charge)).toFixed(2);
			}
		}
		
	}
	else
	{
		var total_disnum5000 = (parseFloat(total_age_driver_ncb * d_agent/100)).toFixed(2);
		var total_sum_dis = (total_age_driver_ncb - total_disnum5000).toFixed(2); // ผลของส่วนลดผู้ขับขี่ 1
		var sum_pre = (parseFloat(total_age_driver_ncb)).toFixed(2); // เบี้ยสุทธิ หักส่วนลด
		var result_stamp =  Math.ceil(sum_pre * 0.4 /100); //.toFixed(2)  อากร = เบี้ยสุทธิ * 0.4/100	
		var  vat_1 = 0;
		var sum_stamp = (parseFloat(sum_pre) + parseFloat(result_stamp)).toFixed(2); // ผลรวม = อากร+เบี้ยลด
		var new_vat = parseFloat(sum_stamp * 7 /100);
		var result_vat = toFixed(new_vat,2); //ผลรวม vat = ผลรวมอากร *7 /100

		var result_sum = (parseFloat(sum_stamp) + parseFloat(result_vat)).toFixed(2); // ยอดชำระ = ผลรวม + vat
	
		if(vat1 != '0')
		{
			var vat_2 = parseFloat(sum_prb/1.07/100).toFixed(2);
			var vat_1 = ((parseFloat(sum_pre) + parseFloat(result_stamp))/100).toFixed(2);
			var total_vat1 = (parseFloat(result_sum) - parseFloat( vat_1) - parseFloat( vat_2)).toFixed(2); 
			var result_prb = (((parseFloat(total_vat1) - parseFloat(sum_pro1pro2)) - parseFloat(sum_prodis2)) + parseFloat(sum_prb)).toFixed(2); // รวม พ.ร.บ.
			var dis_prb = (parseFloat(result_prb) * parseFloat(add_dis)/ 100).toFixed(2);// ส่วนลด เบี้ยรวม
			var to_dis3 = (parseFloat(total_disnum5000)  + parseFloat(dis_prb)).toFixed(2); // รวม คอมมิชั่น
			var result_commition = (parseFloat(result_prb) - parseFloat(to_dis3)- parseFloat(_other) - parseFloat(commition1) + parseFloat(vehicle_tax) + parseFloat(service_charge)).toFixed(2);
		}
		else
		{
			var result_prb = (((parseFloat(result_sum) - parseFloat(sum_pro1pro2)) - parseFloat(sum_prodis2)) + parseFloat(sum_prb)).toFixed(2); // รวม พ.ร.บ.
			var dis_prb = (parseFloat(result_prb) * parseFloat(add_dis)/ 100).toFixed(2);// ส่วนลด เบี้ยรวม
			var to_dis3 = (parseFloat(total_disnum5000)  + parseFloat(dis_prb)).toFixed(2); // รวม คอมมิชั่น
			var result_commition = (parseFloat(result_prb) - parseFloat(to_dis3) - parseFloat(_other) - parseFloat(commition1) + parseFloat(vehicle_tax) + parseFloat(service_charge)).toFixed(2);
		}		
	}
	
	// ซื้อ พรบ only
	var prb_net = document.getElementById( 'prb_net_inform' ).value.replace(/,/g,'');  //ส่วนลด ncb
	var dis_other = (parseFloat(prb_net * d_agent/100)).toFixed(2); // ส่วนลด other new
	var result_commition_new = (parseFloat(result_commition) - parseFloat(_other)).toFixed(2); 
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	var total_dis4 = (parseFloat(dis1) + parseFloat(dis2) + parseFloat(dis_group3)).toFixed(2);
//  console.log(to_dis3);
	webForm_inform.vehicle_tax_inform.value = addCommas(vehicle_tax);
	webForm_inform.service_charge_value_inform.value = addCommas(service_charge);
	webForm_inform.total_dis2_inform.value = addCommas(dis2);
	webForm_inform.dis_group3_inform.value = addCommas(dis_group3);
	webForm_inform.goodb_inform.value = addCommas(dis2);
	webForm_inform.total_dis3_inform.value = addCommas(total_disnum5000);
	webForm_inform.total_vip_inform.value = addCommas(dis_prb);
	webForm_inform.total_dis4_inform.value = addCommas(total_dis4);
	webForm_inform.other_inform.value = addCommas(_other);
	webForm_inform.vat_1_inform.value = addCommas(vat_1);
	webForm_inform.vat_2_inform.value = addCommas(vat_2);
	webForm_inform.total_pre_inform.value = addCommas(total_age_driver_ncb);
	webForm_inform.total_prb_inform.value = addCommas(result_prb);
	webForm_inform.total_stamp_inform.value = addCommas(result_stamp);
	webForm_inform.total_vat_inform.value= addCommas(result_vat);                                                                                                                                                                                                                                             
	webForm_inform.total_sum_inform.value= addCommas(result_sum);
	webForm_inform.total_pro_dis_inform.value= addCommas(sum_pro1pro2);
	webForm_inform.total_commition_inform.value = addCommas(result_commition);
	
	
	// ซื้อ พรบ only
	webForm_inform.other_new_inform.value = addCommas(dis_other);
	webForm_inform.total_commition_new_inform.value = addCommas(result_commition_new);
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}

function calcfunc2_inform() 
{
	var total_sum = document.getElementById( 'total_sum_inform' ).value.replace(/,/g,'');  //ส่วนลด ncb
	var currentValue_prb = document.getElementById( 'currentValue_prb_inform' ).value.replace(/,/g,'');  //ส่วนลด ncb
	var vat_1 = document.getElementById( 'vat_1_inform' ).value.replace(/,/g,'');  //ส่วนลด ncb
	var vat_2 = document.getElementById( 'vat_2_inform' ).value.replace(/,/g,'');  //ส่วนลด ncb
	var total_commition = document.getElementById( 'total_commition_inform' ).value.replace(/,/g,'');  
	var commition = document.getElementById( 'commition_inform' ).value.replace(/,/g,'');  
	var other = document.getElementById( 'other_inform' ).value.replace(/,/g,'');  
	if(commition==''){
		commition=0;
	}
	if (vat_2 == 0);
	{			
		var total_vat1 = (parseFloat(total_sum) + parseFloat(currentValue_prb) - parseFloat( vat_1) - parseFloat( vat_2)).toFixed(2); 
		var result_commition2 = (parseFloat(total_vat1) - parseFloat( commition)- parseFloat( other)).toFixed(2); 						
		webForm_inform.total_prb_inform.value = addCommas(total_vat1);
		webForm_inform.total_commition_inform.value = addCommas(result_commition2);
	}
}
function com_action() 
{
	var total_pre = $("#total_pre_inform").val().replace(/,/g,"");
	var commition_percent = $("#commition_percent_inform").val().replace(/,/g,"");
	var commition_c = (parseFloat(total_pre) * parseFloat(commition_percent/100)).toFixed(2);
	$("#commition_inform").val(addCommas(commition_c));
	
	//////////////////////////////////////////////////////////////////////////////////////////
	var total_sum = document.getElementById( 'total_sum_inform' ).value.replace(/,/g,'');  //ส่วนลด ncb
	var currentValue_prb = document.getElementById( 'currentValue_prb_inform' ).value.replace(/,/g,'');  //ส่วนลด ncb
	var vat_1 = document.getElementById( 'vat_1_inform' ).value.replace(/,/g,'');  //ส่วนลด ncb
	var vat_2 = document.getElementById( 'vat_2_inform' ).value.replace(/,/g,'');  //ส่วนลด ncb
	var total_commition = document.getElementById( 'total_commition_inform' ).value.replace(/,/g,'');  
	var commition = document.getElementById( 'commition_inform' ).value.replace(/,/g,'');  
	var other = document.getElementById( 'other_inform' ).value.replace(/,/g,'');  
	if(commition==''){
		commition=0;
	}
	if (vat_2 == 0);
	{			
		var total_vat1 = (parseFloat(total_sum) + parseFloat(currentValue_prb) - parseFloat( vat_1) - parseFloat( vat_2)).toFixed(2); 
		var result_commition2 =  (parseFloat(total_vat1) - parseFloat(other) - parseFloat(commition)).toFixed(2);						
		webForm_inform.total_prb_inform.value = addCommas(total_vat1);
		webForm_inform.total_commition_inform.value = addCommas(result_commition2);
	}
}