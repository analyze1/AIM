$(document).ready(function(){
show3();
$('#pageSearch').load('pages/tools_Search.php');
$('form').attr('autocomplete', 'off');

// $(function() {
//$( "#alert" ).dialog({
//	modal: true, 
//height: 'auto',
//width: 'auto'});
//});

$('#previewContent').css("top", "30px");
$('#previewContent').css("left", ($(window).width() - $('#previewContent').width()) / 2 + $(window).scrollLeft() + "px");


$(window).resize(function() {

if($(window).width()>1200){
$('body').css("width", $(window).width()+ "px");
}
});

	checkURL();

	
	$('ul li a').click(function (e){
		var linkURL = document.URL;
		var CheckLink =	linkURL.split("#");
		if(('#'+CheckLink[1])!= this.hash){
		$('#search-text1').val('');
		$('#search-text2').val('');
		$('#search-text2-2').val('');
		$('#search-text3').val('');
		$('#search-text4').val('');
		$('#search-text4-2').val('');
		}
			checkURL(this.hash);
	});
	
	//filling in the default content
	
	setInterval("checkURL()", 250);
	
});

var lasturl="";

function checkURL(hash)
{
	if(window.location.hash==""){
		
      window.location.href = "#load_AdminSuzuki"
		}
		
	if(!hash){
		hash=window.location.hash;
	}
	
	
	if(hash != lasturl)
	{
		
		lasturl=hash;
		
		// FIX - if we've used the history buttons to return to the homepage,
		// fill the pageContent with the default_content
		
		if(hash==""){
		
        alert( 'Error กรุณาออกจากระบบ และทำการ Login อีกครั้ง' );
		history.back(1);
		}
		else{
		loadPage(hash);
		}
	}
	$('#Link').val(hash);
}


function loadPage(url,Searchpages)
{
	var TEXTOsearch=$("#SOPTION").val();
	var TEXTsearch = $('#search-text'+TEXTOsearch).val();
	var TEXTsearch2 = $('#search-text'+TEXTOsearch+'-2').val();
	var url=url.replace('#','');
	var n=url.split("?");
	$('#loading').css('visibility','visible');
	$('#bg-off').css("display", "block");
	var t=url.split("_");
	var b=t[1].split("?");
	if(t[0]=='load'){
	var pGo =	n[0].split('|')
	if(Searchpages==1){
		var status = 1;
		window.location.href = "#"+pGo[0]
	}
	else{
	var status = pGo[1];
	}
	$.ajax({
		type: "POST",
		url:"pages/"+pGo[0]+".php",
		data: {
			start:status,
			searchTxT:TEXTsearch,
			searchTxT2:TEXTsearch2,
			otp:TEXTOsearch
		},
		dataType: "html",
		error: function() {
        alert( 'Error กรุณาออกจากระบบ และทำการ Login อีกครั้ง' );
		history.back(1);
    },
		success: function(msg){
			if(parseInt(msg)!=0)
			{
				$('#previewContent').hide("fast");
				$('#pageContent').html(msg);
				$('#loading').css('visibility','hidden');
				$('#bg-off').css("display", "none");
				$(document).attr('title', 'แบบฟอร์มประกันภัยออนไลน์ MY4IB.COM');
			}
			if(pGo[2]!=null){
		$('#previewContent').show("fast");	
		$('#bg-off').css("display", "block");
		$.ajax({
		type: "POST",
		url:"pages/"+pGo[2]+".php",
		data:{ 
		IDDATA : n[1]
		},
		dataType: "html",
		error: function() {
        alert( 'Error กรุณาออกจากระบบ และทำการ Login อีกครั้ง' );
		history.back(1);
    },
		success: function(msg){
			if(parseInt(msg)!=0)
			{
				$('#previewContent').html(msg);
				$('#previewContent').css('visibility','visible');
				$('#loading').css('visibility','hidden');
				$('#bg-off').css("display", "block");
					$('input#Bclose').click(function() {
					$('#previewContent').hide("fast");
					$('#bg-off').css("display", "none");
				window.location.href = "#"+pGo[0]+"|"+status;
	});
			}
		}
	
	});
	}
		}
	
	});
	}


}

  var dn;
  c1 = new Image(); c1.src = "images/digital-clock/c1.gif";
  c2 = new Image(); c2.src = "images/digital-clock/c2.gif";
  c3 = new Image(); c3.src = "images/digital-clock/c3.gif";
  c4 = new Image(); c4.src = "images/digital-clock/c4.gif";
  c5 = new Image(); c5.src = "images/digital-clock/c5.gif";
  c6 = new Image(); c6.src = "images/digital-clock/c6.gif";
  c7 = new Image(); c7.src = "images/digital-clock/c7.gif";
  c8 = new Image(); c8.src = "images/digital-clock/c8.gif";
  c9 = new Image(); c9.src = "images/digital-clock/c9.gif";
  c0 = new Image(); c0.src = "images/digital-clock/c0.gif";
  cb = new Image(); cb.src = "images/digital-clock/cb.gif";
  cam = new Image(); cam.src = "images/digital-clock/cam.gif";
  cpm = new Image(); cpm.src = "images/digital-clock/cpm.gif";
  
  function extract(d,mm,y,h,m,s,type) {
  if (!document.images) return;
  if (d <= 9) {
  document.images.k.src = c0.src;
  document.images.l.src = eval("c"+d+".src");
  }
  else {
  document.images.k.src = eval("c"+Math.floor(d/10)+".src");
  document.images.l.src = eval("c"+(d%10)+".src");
  }
    if (mm <= 9) {
  document.images.m.src = c0.src;
  document.images.n.src = eval("c"+mm+".src");
  }
  else {
  document.images.m.src = eval("c"+Math.floor(mm/10)+".src");
  document.images.n.src = eval("c"+(mm%10)+".src");
  }
	var yshow=y.toString().split('');
  document.images.o.src = eval("c"+yshow[0]+".src");
  document.images.p.src = eval("c"+yshow[1]+".src");
  document.images.q.src = eval("c"+yshow[2]+".src");
  document.images.r.src = eval("c"+yshow[3]+".src");

  if (h <= 9) {
  document.images.a.src = c0.src;
  document.images.b.src = eval("c"+h+".src");
  }
  else {
  document.images.a.src = eval("c"+Math.floor(h/10)+".src");
  document.images.b.src = eval("c"+(h%10)+".src");
  }
  if (m <= 9) {
  document.images.d.src = c0.src;
  document.images.e.src = eval("c"+m+".src");
  }
  else {
  document.images.d.src = eval("c"+Math.floor(m/10)+".src");
  document.images.e.src = eval("c"+(m%10)+".src");
  }
  if (s <= 9) {
  document.g.src = c0.src;
  document.images.h.src = eval("c"+s+".src");
  }
  else {
  document.images.g.src = eval("c"+Math.floor(s/10)+".src");
  document.images.h.src = eval("c"+(s%10)+".src");
  }
  if (dn == "AM") document.j.src = cam.src;
  else document.images.j.src = cpm.src;
  }
  function show3() {
  if (!document.images)
  return;
  var Digital = new Date();
  var days = Digital.getDate();
  var months = Digital.getMonth()+1;
  var years = Digital.getFullYear();
  var hours = Digital.getHours();
  var minutes = Digital.getMinutes();
  var seconds = Digital.getSeconds();
  dn = "AM";
  if ((hours >= 12) && (minutes >= 1) || (hours >= 13)) {
  dn = "PM";
  hours = hours-12;
  }
  if (hours == 0)
  hours = 12;
  extract(days,months,years,hours, minutes, seconds, dn);
  setTimeout("show3()", 1000);
  }
  //  End -->