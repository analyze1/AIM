$(document).ready(function() { 
$('#search-text1').mask("99999/รย/999999");
$( '#search-text2' ).datepicker({dateFormat : 'dd/mm/yy',
 changeMonth: true,
changeYear: true
});
$( '#search-text2-2' ).datepicker({dateFormat : 'dd/mm/yy',
changeMonth: true,
changeYear: true
});
$( '#search-text4' ).datepicker({dateFormat : 'dd/mm/yy',
 changeMonth: true,
changeYear: true
});
$( '#search-text4-2' ).datepicker({dateFormat : 'dd/mm/yy',
changeMonth: true,
changeYear: true
});

$("#search_btn").click(function()
     { 
	 var LINK = $("#Link").val();
	 loadPage(LINK,1);
	 }
	 );

	$("#SOPTION").change(function() 
     { 
	 if($("#SOPTION").val()==2){
        $('#search-text1').hide('fast');
		$( '#search-text2' ).show('fast');
		$( '#search-text2-2' ).show('fast');
		$( '#search-text3' ).hide('fast');
		$( '#search-text4' ).hide('fast');
		$( '#search-text4-2' ).hide('fast');
	 }
	 else  if($("#SOPTION").val()==1){
		$('#search-text1').show('fast');
		$( '#search-text2' ).hide('fast');
		$( '#search-text2-2' ).hide('fast');
		$( '#search-text3' ).hide('fast');
		$( '#search-text4' ).hide('fast');
		$( '#search-text4-2' ).hide('fast');
	 }
	 else  if($("#SOPTION").val()==3){
		$('#search-text1').hide('fast');
		$( '#search-text2' ).hide('fast');
		$( '#search-text2-2' ).hide('fast');
		$( '#search-text3' ).show('fast');
		$( '#search-text4' ).hide('fast');
		$( '#search-text4-2' ).hide('fast');
	 }
	 else if($("#SOPTION").val()==4){
        $('#search-text1').hide('fast');
		$( '#search-text4' ).show('fast');
		$( '#search-text4-2' ).show('fast');
		$( '#search-text2' ).hide('fast');
		$( '#search-text2-2' ).hide('fast');
		$( '#search-text3' ).hide('fast');
	 }


     });
	 
});