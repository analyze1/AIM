$(document).ready(function() { 
$("#btnSendMail").click(function() 
     { 
	 $('#loading').css('visibility','visible');
	$('#bg-off').css("display", "block");
	$('#bg-off').css("z-index", "9003");
var DATA = $('#Insurance').serialize();
	 var SAVE = {
         type: "POST",
         dataType: "json",
         url: "ajax/Ajax_Mail.php",
         data: {
			 IDDATA : $("#txtID").val()
		 },
         success: function(msg) {
			 var returnedArray = msg;
             alert(returnedArray.msg);
			 $('#loading').css('visibility','hidden');
			$('#bg-off').css("z-index", "9001");
			if(returnedArray.person == 1){
				location.href = '#load_Individuals';
				return false;
			}
			else{
				 location.href = '#load_Corporation';
				 return false;
			}
         },
		 error:function(msg) {
			 var returnedArray = msg;
             alert('การส่งอีเมลผิดพลาด');
         }
     };
     $.ajax(SAVE);
     });
});