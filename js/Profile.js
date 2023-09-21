$(document).ready(function() { 
$("#upStart").click(function() 
     { 
	 $("#UpLoad1").submit();
	 $('#previewContent').css("position", "");
 location.href = '#load_AdminSuzuki';
	 });
	 

$("#upClose").click(function() 
     { 
	 $('#previewContent').css("position", "");
	 location.href = '#load_AdminSuzuki';
	 });

$("#SaveProfile").click(function() 
     { 
var DATA = $('#Insurance').serialize();
	 var SAVE = {
         type: "POST",
         dataType: "json",
         url: "ajax/Ajax_AdminSuzukiSave.php",
         data: DATA,
         success: function(msg) {
			 var returnedArray = msg;
             alert(returnedArray.msg);
			 $('#pageContent').load('pages/load_AdminSuzuki.php');
			 return false;
         },
		 error:function(msg) {
			 var returnedArray = msg;
             alert('การบันทึกผิดพลาด');
         }
     };
     $.ajax(SAVE);
     });
	 
$('#pageSearch').hide('Slow');


		
$('#pictures').click(function() {
	$('#previewContent').css("position", "fixed");
location.href = '#load_AdminSuzuki|0|send_UploadPic?userUp='+$('#IdDealer').val()+'&statusUp=company';
});


$('#pictures1').click(function() {
	$('#previewContent').css("position", "fixed");
location.href = '#load_AdminSuzuki|0|send_UploadPic?userUp='+$('#IdDealer').val()+'&statusUp=ceo';
});

$('#pictures2').click(function() {
	$('#previewContent').css("position", "fixed");
location.href = '#load_AdminSuzuki|0|send_UploadPic?userUp='+$('#IdDealer').val()+'&statusUp=admin1';
});

$('#pictures3').click(function() {
	$('#previewContent').css("position", "fixed");
location.href = '#load_AdminSuzuki|0|send_UploadPic?userUp='+$('#IdDealer').val()+'&statusUp=admin2';
});


$('#pictures4').click(function() {
	$('#previewContent').css("position", "fixed");
location.href = '#load_AdminSuzuki|0|send_UploadPic?userUp='+$('#IdDealer').val()+'&statusUp=finance1';
});

$('#pictures5').click(function() {
	$('#previewContent').css("position", "fixed");
location.href = '#load_AdminSuzuki|0|send_UploadPic?userUp='+$('#IdDealer').val()+'&statusUp=finance2';
});

});