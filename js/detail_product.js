$(document).ready(function() { 
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



function calMore(){
	var cost = 0;
	var string = $("#id_price").val();
	
	show = string.split("|");
	cost = parseFloat(show[0]);
	cost2 = parseFloat(show[1]);
	
	for (s = 1; s < 15; s++){
		var string = $("#id_price"+s).val();
	show = string.split("|");
	cost = parseFloat(show[0])+parseFloat(cost)
	cost2 = parseFloat(show[1])+parseFloat(cost2)
	}
	$("#price_acc_tun").val(addCommas(cost2));
	$("#price_acc_cost").val(addCommas(cost));
}



//----------------------อุปกรณ์ตกแต่ง----------------------///

	$('#id_price').change(function(){
		if($('#id_price').val()!=0) {
			var cost = $('#id_price').val();
			costshow = cost.split("|");
				$("#price_acc").show('fast');
				$("#price_acc").val(addCommas(costshow[0]));
				
			} else {
				$("#price_acc").val('0');
				$("#price_acc").hide('fast');
			}   	
			calMore();
	});
	

	$('#id_price1').change(function(){
		if($('#id_price1').val()!=0) {
			var cost = $('#id_price1').val();
			costshow = cost.split("|");
				$("#price_acc1").show('fast');
				$("#price_acc1").val(addCommas(costshow[0]));
				
			} else {
				$("#price_acc1").val('0');
				$("#price_acc1").hide('fast');
			}   	
			calMore();
	});
	
	$('#id_price2').change(function(){
		if($('#id_price2').val()!=0) {
			var cost = $('#id_price2').val();
			costshow = cost.split("|");
				$("#price_acc2").show('fast');
				$("#price_acc2").val(addCommas(costshow[0]));
				
			} else {
				$("#price_acc2").val('0');
				$("#price_acc2").hide('fast');
			}   
			calMore();
	});
	
	$('#id_price3').change(function(){
		if($('#id_price3').val()!=0) {
			var cost = $('#id_price3').val();
			costshow = cost.split("|");
				$("#price_acc3").show('fast');
				$("#price_acc3").val(addCommas(costshow[0]));
				
			} else {
				$("#price_acc3").val('0');
				$("#price_acc3").hide('fast');
			}   	
			calMore();
	});
	
	$('#id_price4').change(function(){
		if($('#id_price4').val()!=0) {
			var cost = $('#id_price4').val();
			costshow = cost.split("|");
				$("#price_acc4").show('fast');
				$("#price_acc4").val(addCommas(costshow[0]));
				
			} else {
				$("#price_acc4").val('0');
				$("#price_acc4").hide('fast');
			}   	
			calMore();
	});
	
	$('#id_price5').change(function(){
		if($('#id_price5').val()!=0) {
			var cost = $('#id_price5').val();
			costshow = cost.split("|");
				$("#price_acc5").show('fast');
				$("#price_acc5").val(addCommas(costshow[0]));
				
			} else {
				$("#price_acc5").val('0');
				$("#price_acc5").hide('fast');
			}   	
			calMore();
	});
	
	$('#id_price6').change(function(){
		if($('#id_price6').val()!=0) {
			var cost = $('#id_price6').val();
			costshow = cost.split("|");
				$("#price_acc6").show('fast');
				$("#price_acc6").val(addCommas(costshow[0]));
			} else {
				$("#price_acc6").val('0');
				$("#price_acc6").hide('fast');
			}   	
			calMore();
	});
	
	$('#id_price7').change(function(){
		if($('#id_price7').val()!=0) {
			var cost = $('#id_price7').val();
			costshow = cost.split("|");
				$("#price_acc7").show('fast');
				$("#price_acc7").val(addCommas(costshow[0]));
			} else {
				$("#price_acc7").val('0');
				$("#price_acc7").hide('fast');
			}   	
			calMore();
	});
	
	$('#id_price8').change(function(){
		if($('#id_price8').val()!=0) {
			var cost = $('#id_price8').val();
			costshow = cost.split("|");
				$("#price_acc8").show('fast');
				$("#price_acc8").val(addCommas(costshow[0]));
			} else {
				$("#price_acc8").val(0);
				$("#price_acc8").hide('fast');
			}   	
			calMore();
	});
	
	$('#id_price9').change(function(){
		if($('#id_price9').val()!=0) {
			var cost = $('#id_price9').val();
			costshow = cost.split("|");
				$("#price_acc9").show('fast');
				$("#price_acc9").val(addCommas(costshow[0]));
			} else {
				$("#price_acc9").val(0);
				$("#price_acc9").hide('fast');
			}   	
			calMore();
	});
	
	$('#id_price10').change(function(){
		if($('#id_price10').val()!=0) {
			var cost = $('#id_price10').val();
			costshow = cost.split("|");
				$("#price_acc10").show('fast');
				$("#price_acc10").val(addCommas(costshow[0]));
			} else {
				$("#price_acc10").val(0);
				$("#price_acc10").hide('fast');
			}   	
			calMore();
	});
	$('#id_price11').change(function(){
		if($('#id_price11').val()!=0) {
			var cost = $('#id_price11').val();
			costshow = cost.split("|");
				$("#price_acc11").show('fast');
				$("#price_acc11").val(addCommas(costshow[0]));
			} else {
				$("#price_acc11").val(0);
				$("#price_acc11").hide('fast');
			}   	
			calMore();
	});
	
	$('#id_price12').change(function(){
		if($('#id_price12').val()!=0) {
			var cost = $('#id_price12').val();
			costshow = cost.split("|");
			$("#price_acc12").val(addCommas(costshow[0]));
				$("#price_acc12").show('fast');
			} else {
				$("#price_acc12").val('');
				$("#price_acc12").hide('fast');
			}   	
			calMore();
	});
	
	$('#id_price13').change(function(){
		if($('#id_price13').val()!=0) {
			var cost = $('#id_price13').val();
			costshow = cost.split("|");
				$("#price_acc13").show('fast');
				$("#price_acc13").val(addCommas(costshow[0]));
			} else {
				$("#price_acc13").val(0);
				$("#price_acc13").hide('fast');
			}   	
			calMore();
	});
	
	$('#id_price14').change(function(){
		if($('#id_price14').val()!=0) {
			var cost = $('#id_price14').val();
			costshow = cost.split("|");
				$("#price_acc14").show('fast');
				$("#price_acc14").val(addCommas(costshow[0]));
			} else {
				$("#price_acc14").val(0);
				$("#price_acc14").hide('fast');
			}   	
			calMore();
	});
	
	
	
		$('#acc_detail').click(function(){
		if($('#acc_detail').is(':checked')) {
				$("#Show_acc_detail").show('fast');
			} else {
				$("#Show_acc_detail").hide('fast');
				$("#id_price").val(0);
				$("#price_acc").val('0');
				$("#price_acc").hide('fast');
				calMore();
			}   	
	});
	
	$('#acc_detail1').click(function(){
		if($('#acc_detail1').is(':checked')) {
				$("#Show_acc_detail1").show('fast');
			} else {
				$("#Show_acc_detail1").hide('fast');
				$("#id_price1").val(0);
				$("#price_acc1").val('0');
				$("#price_acc1").hide('fast');
				calMore();
			}   	
	});
	$('#acc_detail2').click(function(){
		if($('#acc_detail2').is(':checked')) {
				$("#Show_acc_detail2").show('fast');
			} else {
				$("#Show_acc_detail2").hide('fast');
				$("#id_price2").val(0);
				$("#price_acc2").val('0');
				$("#price_acc2").hide('fast');
				calMore();
			}   	
	});
	$('#acc_detail3').click(function(){
		if($('#acc_detail3').is(':checked')) {
				$("#Show_acc_detail3").show('fast');
			} else {
				$("#Show_acc_detail3").hide('fast');
				$("#id_price3").val(0);
				$("#price_acc3").val('0');
				$("#price_acc3").hide('fast');
				calMore();
			}   	
	});
	$('#acc_detail4').click(function(){
		if($('#acc_detail4').is(':checked')) {
				$("#Show_acc_detail4").show('fast');
			} else {
				$("#Show_acc_detail4").hide('fast');
				$("#id_price4").val(0);
				$("#price_acc4").val('0');
				$("#price_acc4").hide('fast');
				calMore();
			}   	
	});
	$('#acc_detail5').click(function(){
		if($('#acc_detail5').is(':checked')) {
				$("#Show_acc_detail5").show('fast');
			} else {
				$("#Show_acc_detail5").hide('fast');
				$("#id_price5").val(0);
				$("#price_acc5").val('0');
				$("#price_acc5").hide('fast');
				calMore();
			}   	
	});
	$('#acc_detail6').click(function(){
		if($('#acc_detail6').is(':checked')) {
				$("#Show_acc_detail6").show('fast');
			} else {
				$("#Show_acc_detail6").hide('fast');
				$("#id_price6").val(0);
				$("#price_acc6").val('0');
				$("#price_acc6").hide('fast');
				calMore();
			}   	
	});
	$('#acc_detail7').click(function(){
		if($('#acc_detail7').is(':checked')) {
				$("#Show_acc_detail7").show('fast');
			} else {
				$("#Show_acc_detail7").hide('fast');
				$("#id_price7").val(0);
				$("#price_acc7").val('0');
				$("#price_acc7").hide('fast');
				calMore();
			}   	
	});
	$('#acc_detail8').click(function(){
		if($('#acc_detail8').is(':checked')) {
				$("#Show_acc_detail8").show('fast');
			} else {
				$("#Show_acc_detail8").hide('fast');
				$("#id_price8").val(0);
				$("#price_acc8").val('0');
				$("#price_acc8").hide('fast');
				calMore();
			}   	
	});
	$('#acc_detail9').click(function(){
		if($('#acc_detail9').is(':checked')) {
				$("#Show_acc_detail9").show('fast');
			} else {
				$("#Show_acc_detail9").hide('fast');
				$("#id_price9").val(0);
				$("#price_acc9").val('0');
				$("#price_acc9").hide('fast');
				calMore();
			}   	
	});
	$('#acc_detail10').click(function(){
		if($('#acc_detail10').is(':checked')) {
				$("#Show_acc_detail10").show('fast');
			} else {
				$("#Show_acc_detail10").hide('fast');
				$("#id_price10").val(0);
				$("#price_acc10").val('0');
				$("#price_acc10").hide('fast');
				calMore();
			}   	
	});
	$('#acc_detail11').click(function(){
		if($('#acc_detail11').is(':checked')) {
				$("#Show_acc_detail11").show('fast');
			} else {
				$("#Show_acc_detail11").hide('fast');
				$("#id_price11").val(0);
				$("#price_acc11").val('0');
				$("#price_acc11").hide('fast');
				calMore();
			}   	
	});
	$('#acc_detail12').click(function(){
		if($('#acc_detail12').is(':checked')) {
				$("#Show_acc_detail12").show('fast');
			} else {
				$("#Show_acc_detail12").hide('fast');
				$("#id_price12").val(0);
				$("#price_acc12").val('0');
				$("#price_acc12").hide('fast');
				calMore();
			}   	
	});
	$('#acc_detail13').click(function(){
		if($('#acc_detail13').is(':checked')) {
				$("#Show_acc_detail13").show('fast');
			} else {
				$("#Show_acc_detail13").hide('fast');
				$("#id_price13").val(0);
				$("#price_acc13").val('0');
				$("#price_acc13").hide('fast');
				calMore();
			}   	
	});
	$('#acc_detail14').click(function(){
		if($('#acc_detail14').is(':checked')) {
				$("#Show_acc_detail14").show('fast');
			} else {
				$("#Show_acc_detail14").hide('fast');
				$("#id_price14").val(0);
				$("#price_acc14").val('0');
				$("#price_acc14").hide('fast');
				calMore();
			}   	
	});
	
	
});