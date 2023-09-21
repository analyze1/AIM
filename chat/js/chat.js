var windowFocus = true;
var username;
var chatHeartbeatCount = 0;
var minChatHeartbeat = 1000;
var maxChatHeartbeat = 8000;
var chatHeartbeatTime = minChatHeartbeat;
var originalTitle;
var blinkOrder = 0;

var chatboxFocus = new Array();
var newMessages = new Array();
var newMessagesWin = new Array();
var chatBoxes = new Array();

$(document).ready(function(){
	originalTitle = document.title;
	startChatSession();	

	$([window, document]).blur(function(){
		windowFocus = false;
	}).focus(function(){
		windowFocus = true;
		document.title = originalTitle;
	});
});


function restructureChatBoxes() {
	align = 0;
	for (x in chatBoxes) {
		chatboxtitle = chatBoxes[x];

		if ($("#chatbox_"+chatboxtitle).css('display') != 'none') {
			if (align == 0) {
				$("#chatbox_"+chatboxtitle).css('right', '1155px');
//				$("#chatbox_"+chatboxtitle).css('right', '225px');
			} else {
				width = (align)*(225+7)+1155;
//				width = (align)*(225+7)+20;
				$("#chatbox_"+chatboxtitle).css('right', width+'px');
			}
			align++;
		}
	}
}

function chatWith(chatuser,chatto) {
	createChatBox(chatuser,chatto);
        $('#chatbox_'+chatuser+' form#MyUploadForm').attr('action', 'processupload.php?ufrom=&uto=');
	$("#chatbox_"+chatuser+" .chatboxtextarea").focus();
        
}

function createChatBox(chatboxtitle,chatto,minimizeChatBox) {
        
        //var hisShow = 0;
        var chatname = chatboxtitle;
        //var cutBox =   chatboxtitle.substring(1, 6);
        if(chatboxtitle=='admin'){
            chatname = chatto;
        }
	if ($("#chatbox_"+chatboxtitle).length > 0) {
		if ($("#chatbox_"+chatboxtitle).css('display') == 'none') {
			$("#chatbox_"+chatboxtitle).css('display','block');
			restructureChatBoxes();
		}
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		return;
	}
        
        
	$(" <div />" ).attr("id","chatbox_"+chatboxtitle)
	.addClass("chatbox")
//	.html('<div class="chatboxhead"><div class="chatboxtitle">'+chatboxtitle+'</div><div class="chatboxoptions"><a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')">-</a> <a href="javascript:void(0)" id="c'+chatboxtitle+'" onclick="javascript:closeChatBox(\''+chatboxtitle+'\')">X</a></div><br clear="all"/></div><div class="chatboxcontent"></div><div class="chatboxinput"><input type="hidden" name="chatname" id="chatname" value="'+chatname+'"><textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+chatboxtitle+'\');"></textarea></div>')	.appendTo($( "body" ));
	.html('<div class="chatboxhead" onclick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')"><div class="chatboxtitle">'+chatboxtitle+'</div><div class="chatboxoptions"><a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')">-</a> <a href="javascript:void(0)" id="c'+chatboxtitle+'" onclick="javascript:closeChatBox(\''+chatboxtitle+'\')">X</a></div><br clear="all"/></div><div class="chatboxcontent  dialogs"></div><div class="chatboxinput"><input type="hidden" name="chatname" id="chatname" value="'+chatname+'"><textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+chatboxtitle+'\');"></textarea><form  method="post" enctype="multipart/form-data" id="MyUploadForm"><div class="fileUpload"><div class="iconAttach"><i class="icon-paper-clip"></i></div><input class="fileCss" name="FileInput" id="FileInput" type="file" /><input style="display:none"  class="btnCss" type="submit"   value="Upload submit" /><img src="chat/attach/images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/></div></form><div style="display:none;" id="progressbox"><div style="display:none;" id="progressbar"></div ><div  style="display:none;" id="statustxt">0%</div></div><div id="output"></div></div>')	.appendTo($( "body" ));
	$("#chatbox_"+chatboxtitle).css('bottom', '0px');
	
	chatBoxeslength = 0;

	for (x in chatBoxes) {
		if ($("#chatbox_"+chatBoxes[x]).css('display') != 'none') {
			chatBoxeslength++;
		}
	}

	if (chatBoxeslength == 0) {
		$("#chatbox_"+chatboxtitle).css('right', '45%');
		$("#chatbox_"+chatboxtitle).css('top', '45%');
//		$("#chatbox_"+chatboxtitle).css('right', '1155px');
//		$("#chatbox_"+chatboxtitle).css('right', '225px');
	} else {
		//width = (chatBoxeslength)*(225+7)+20;
		width = (chatBoxeslength)*(225+7)+1155;
//		$("#chatbox_"+chatboxtitle).css('right', width+'px');
		$("#chatbox_"+chatboxtitle).css('right', '45%');
		$("#chatbox_"+chatboxtitle).css('top', '45%');
	}
	
	chatBoxes.push(chatboxtitle);
        
        // พับกล่องข้อความ
//	if (minimizeChatBox == 1) {
//		minimizedChatBoxes = new Array();
//
//		if ($.cookie('chatbox_minimized')) {
//			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
//		}
//		minimize = 0;
//		for (j=0;j<minimizedChatBoxes.length;j++) {
//			if (minimizedChatBoxes[j] == chatboxtitle) {
//				minimize = 1;
//			}
//		}
//
//		if (minimize == 1) {
//			$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
//			$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
//		}
//	}
        
	chatboxFocus[chatboxtitle] = false;

	$("#chatbox_"+chatboxtitle+" .chatboxtextarea").blur(function(){
		chatboxFocus[chatboxtitle] = false;
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").removeClass('chatboxtextareaselected');
	}).focus(function(){
		chatboxFocus[chatboxtitle] = true;
		newMessages[chatboxtitle] = false;
		$('#chatbox_'+chatboxtitle+' .chatboxhead').removeClass('chatboxblink');
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").addClass('chatboxtextareaselected');
	});

	$("#chatbox_"+chatboxtitle).click(function() {
		if ($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') != 'none') {
			$("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		}
	});

        
        
	$("#chatbox_"+chatboxtitle).show();
        if(chatboxtitle!='admin'){
        $("#chatbox_"+chatboxtitle).draggable().css('bottom','auto');
//        $("#chatbox_"+chatboxtitle).css('bottom','auto');
        }
       chatHeartbeatHis(chatname,chatboxtitle);
       getSAttach(chatboxtitle,chatto);
        
}

function chatHeartbeatHis(chatname,chatme){
  // alert('chatHeartbeatHis'+chatname+'|'+chatme);

    var itemsfound = 0;
	
	if (windowFocus == false) {
           
 
		var blinkNumber = 0;
		var titleChanged = 0;
		for (x in newMessagesWin) {
			if (newMessagesWin[x] == true) {
				++blinkNumber;
				if (blinkNumber >= blinkOrder) {
					document.title = x+' says...';
					play_sound();
					titleChanged = 1;
					break;	
				}
			}
		}
		
		if (titleChanged == 0) {
			document.title = originalTitle;
			blinkOrder = 0;
			remove_sound()
		} else {
			++blinkOrder;
		}

	} else {
           
		for (x in newMessagesWin) {
			newMessagesWin[x] = false;
		}
	}

	for (x in newMessages) {
             
		if (newMessages[x] == true) {
			if (chatboxFocus[x] == false) {
				$('#chatbox_'+x+' .chatboxhead').toggleClass('chatboxblink');
			}
		}
	}
        //alert(chatname);
        $.ajax({
	  url: "chat.php?action=chatheartbeatHis&b="+chatname,
	  cache: false,
	  dataType: "json",
	  success: function(data) {
                $("#chatbox_"+chatme+" .chatboxcontent").html('');
		$.each(data.items, function(i,item){
                    //alert(item.f+'|'+item.n);
			if (item){ 
                               
//				$("#chatbox_"+chatme+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+item.f+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
			if(item.f==chatme){	
                            //other
                            $("#chatbox_"+chatme+" .chatboxcontent").append('<div class="chatboxmessage itemdiv dialogdiv "><div class="body"><div class="chatboxmessagefrom name"><a href="#">'+item.f+'&nbsp;&nbsp;</a></div><div class="chatboxmessagecontent text">'+item.m+'</div></div></div>');
			}else{
                            //ME
                            $("#chatbox_"+chatme+" .chatboxcontent").append('<div class="chatboxmessage itemdiv dialogdiv "><div class="bodyR"><div class="chatboxmessagefrom name "><a href="#">'+item.f+'&nbsp;&nbsp;</a></div><div class="chatboxmessagecontent text">'+item.m+'</div></div></div>');
                        }
                        }
		});
	}});
}
function chatHeartbeat(){

	var itemsfound = 0;
	
	if (windowFocus == false) {
           
 
		var blinkNumber = 0;
		var titleChanged = 0;
		for (x in newMessagesWin) {
			if (newMessagesWin[x] == true) {
				++blinkNumber;
				if (blinkNumber >= blinkOrder) {
					document.title = x+' says...';
					play_sound();
					titleChanged = 1;
					break;	
				}
			}
		}
		
		if (titleChanged == 0) {
			document.title = originalTitle;
			blinkOrder = 0;
			remove_sound()
		} else {
			++blinkOrder;
		}

	} else {
           
		for (x in newMessagesWin) {
			newMessagesWin[x] = false;
		}
	}

	for (x in newMessages) {
             
		if (newMessages[x] == true) {
			if (chatboxFocus[x] == false) {
				//FIXME: add toggle all or none policy, otherwise it looks funny
				$('#chatbox_'+x+' .chatboxhead').toggleClass('chatboxblink');
			}
		}
	}
	
	$.ajax({
	  url: "chat.php?action=chatheartbeat",
	  cache: false,
	  dataType: "json",
	  success: function(data) {
               // alert(data.items);
		$.each(data.items, function(i,item){
			if (item)	{ // fix strange ie bug
                                //alert('s='+item.s+'|f='+item.f+'| m='+item.m+'| box='+item.n);
				chatboxtitle = item.f;

				if ($("#chatbox_"+chatboxtitle).length <= 0) {
					createChatBox(chatboxtitle);
				}
				if ($("#chatbox_"+chatboxtitle).css('display') == 'none') {
					$("#chatbox_"+chatboxtitle).css('display','block');
					restructureChatBoxes();
				}
                                
				if (item.s == 1) {
					item.f = username;
				}

				if (item.s == 2) {
					$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
				} else {
					newMessages[chatboxtitle] = true;
					newMessagesWin[chatboxtitle] = true;
                                        if(item.f==chatboxtitle){	
                                            //other
                                            $("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage itemdiv dialogdiv "><div class="body"><div class="chatboxmessagefrom name"><a href="#">'+item.f+'&nbsp;&nbsp;</a></div><div class="chatboxmessagecontent text">'+item.m+'</div></div></div>');
                                        }else{
                                            //ME
                                            $("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage itemdiv dialogdiv "><div class="bodyR"><div class="chatboxmessagefrom name "><a href="#">'+item.f+'&nbsp;&nbsp;</a></div><div class="chatboxmessagecontent text">'+item.m+'</div></div></div>');
                                        }
					//$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+item.f+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
				}

				$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
				itemsfound += 1;
			}
		});

		chatHeartbeatCount++;

		if (itemsfound > 0) {
			chatHeartbeatTime = minChatHeartbeat;
			chatHeartbeatCount = 1;
		} else if (chatHeartbeatCount >= 10) {
			chatHeartbeatTime *= 2;
			chatHeartbeatCount = 1;
			if (chatHeartbeatTime > maxChatHeartbeat) {
				chatHeartbeatTime = maxChatHeartbeat;
			}
		}
		
		setTimeout('chatHeartbeat();',chatHeartbeatTime);
	}});
}

function closeChatBox(chatboxtitle) {
	$('#chatbox_'+chatboxtitle).css('display','none');
	restructureChatBoxes();

	$.post("chat.php?action=closechat", { chatbox: chatboxtitle} , function(data){	
	});

}

function toggleChatBoxGrowth(chatboxtitle) {
	if ($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') == 'none') {  
		
		var minimizedChatBoxes = new Array();
		
//		if ($.cookie('chatbox_minimized')) {
//			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
//		}

		var newCookie = '';

		for (i=0;i<minimizedChatBoxes.length;i++) {
			if (minimizedChatBoxes[i] != chatboxtitle) {
				newCookie += chatboxtitle+'|';
			}
		}

		newCookie = newCookie.slice(0, -1)


//		$.cookie('chatbox_minimized', newCookie);
		$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','block');
		$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','block');
		$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
	} else {
		
		var newCookie = chatboxtitle;

//		if ($.cookie('chatbox_minimized')) {
//			newCookie += '|'+$.cookie('chatbox_minimized');
//		}


//		$.cookie('chatbox_minimized',newCookie);
		$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
		$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
	}
	
}

function checkChatBoxInputKey(event,chatboxtextarea,chatboxtitle) {
	 
	if(event.keyCode == 13 && event.shiftKey == 0)  {
		chatname = $('#chatbox_'+chatboxtitle+'  #chatname').val();
                
		message = $(chatboxtextarea).val();
		message = message.replace(/^\s+|\s+$/g,"");

		$(chatboxtextarea).val('');
		$(chatboxtextarea).focus();
		$(chatboxtextarea).css('height','44px');
		if (message != '') {
			$.post("chat.php?action=sendchat", 
                        {to: chatboxtitle, message: message, chatname: chatname} , 
                        function(data){
                                
				message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");
				//$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+username+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+message+'</span></div>');
				if(username==chatboxtitle){	
                                            //other
                                            $("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage itemdiv dialogdiv "><div class="body"><div class="chatboxmessagefrom name"><a href="#">'+username+'&nbsp;&nbsp;</a></div><div class="chatboxmessagecontent text">'+message+'</div></div></div>');
                                        }else{
                                            //ME
                                            $("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage itemdiv dialogdiv "><div class="bodyR"><div class="chatboxmessagefrom name "><a href="#">'+username+'&nbsp;&nbsp;</a></div><div class="chatboxmessagecontent text">'+message+'</div></div></div>');
                                        }
                            $("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
			});
		}
		chatHeartbeatTime = minChatHeartbeat;
		chatHeartbeatCount = 1;

		return false;
	}

	var adjustedHeight = chatboxtextarea.clientHeight;
	var maxHeight = 94;

	if (maxHeight > adjustedHeight) {
		adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
		if (maxHeight)
			adjustedHeight = Math.min(maxHeight, adjustedHeight);
		if (adjustedHeight > chatboxtextarea.clientHeight)
			$(chatboxtextarea).css('height',adjustedHeight+8 +'px');
	} else {
		$(chatboxtextarea).css('overflow','auto');
	}
	 
}

function startChatSession(){  
	$.ajax({
	  url: "chat.php?action=startchatsession",
	  cache: false,
	  dataType: "json",
	  success: function(data) {
 
		username = data.username;
                ;
		$.each(data.items, function(i,item){
                    
			if (item)	{ // fix strange ie bug

				chatboxtitle = item.f;

				if ($("#chatbox_"+chatboxtitle).length <= 0) {
					createChatBox(chatboxtitle,1);
				}
				
				if (item.s == 1) {
					item.f = username;
				}

				if (item.s == 2) {
					$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
				} else {
                                    if(item.f==chatboxtitle){	
                                            //other
                                            $("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage itemdiv dialogdiv "><div class="body"><div class="chatboxmessagefrom name"><a href="#">'+item.f+'&nbsp;&nbsp;</a></div><div class="chatboxmessagecontent text">'+item.m+'</div></div></div>');
                                        }else{
                                            //ME
                                            $("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage itemdiv dialogdiv "><div class="bodyR"><div class="chatboxmessagefrom name "><a href="#">'+item.f+'&nbsp;&nbsp;</a></div><div class="chatboxmessagecontent text">'+item.m+'</div></div></div>');
                                        }
                                        
					//$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+item.f+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
				}
			}
		});
		
		for (i=0;i<chatBoxes.length;i++) {
			chatboxtitle = chatBoxes[i];
			$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
			setTimeout('$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);', 100); // yet another strange ie bug
		}
	
	setTimeout(function(){
            chatHeartbeat();
        },chatHeartbeatTime);
		
	}});
}

/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

jQuery.cookie = function(name, value, options) {
   
//    if (typeof value != 'undefined') { // name and value given, set cookie
//        options = options || {};
//        if (value === null) {
//            value = '';
//            options.expires = -1;
//        }
//        var expires = '';
//        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
//            var date;
//            if (typeof options.expires == 'number') {
//                date = new Date();
//                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
//            } else {
//                date = options.expires;
//            }
//            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
//        }
//        // CAUTION: Needed to parenthesize options.path and options.domain
//        // in the following expressions, otherwise they evaluate to undefined
//        // in the packed version for some reason...
//        var path = options.path ? '; path=' + (options.path) : '';
//        var domain = options.domain ? '; domain=' + (options.domain) : '';
//        var secure = options.secure ? '; secure' : '';
//        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
//    } else { // only name given, get cookie
//        var cookieValue = null;
//        if (document.cookie && document.cookie != '') {
//            var cookies = document.cookie.split(';');
//            for (var i = 0; i < cookies.length; i++) {
//                var cookie = jQuery.trim(cookies[i]);
//                // Does this cookie string begin with the name we want?
//                if (cookie.substring(0, name.length + 1) == (name + '=')) {
//                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
//                    break;
//                }
//            }
//        }
//        return cookieValue;
//    }
};

function getSAttach(chatboxtitle,namebox){
    var chatname = chatboxtitle;
    var chatFrom;
        if(chatboxtitle=='admin'){
            chatname = namebox;
            chatFrom = namebox;
        }else{
            chatFrom = 'admin';
        }
        
   // alert(chatboxtitle+'|'+chatname+'|'+chatto);
    $.getScript('chat/attach/js/jquery.form.js', function()
//    $.getScript('http://192.168.1.250/suzuki/suzukinew/chat/attach/js/jquery.form.js', function()
    {
     
      $('#chatbox_'+chatboxtitle+' #MyUploadForm').attr('action','processupload.php?ufrom='+chatFrom+'&uto='+chatboxtitle);

	var options = { 
			target: '#chatbox_'+chatboxtitle+' #output',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmit,  // pre-submit callback 
			success:       afterSuccess,  // post-submit callback 
			uploadProgress: OnProgress, //upload progress callback  
			chatbox: '#chatbox_'+chatboxtitle+' ', 
                        
			resetForm: true        // reset the form after successful submit 
		}; 
                
                    $('#chatbox_'+chatboxtitle+' #FileInput').on('change', function() 
                    {
                        $('#chkChatbox').val('chatbox_'+chatboxtitle+' ');
                         $('#chatbox_'+chatboxtitle+' #MyUploadForm').ajaxSubmit(options); 
                         chatHeartbeatHis(chatboxtitle,chatname);
                         return false;
                   });	
//	 $('#chatbox_'+chatboxtitle+' #MyUploadForm').submit(function() {                     
//			$('#chatbox_'+chatboxtitle+' #MyUploadForm').ajaxSubmit(options); 
//                        chatHeartbeatHis(chatboxtitle,chatname);
//                        return false;
//		}); 
    }); 
 }

//function after succesful file upload (when server response)
function afterSuccess()
{
	$('#submit-btn').show(); //hide submit button
//	$('#loading-img').hide(); //hide submit button
	$('#progressbox').delay( 1000 ).fadeOut(); //hide progress bar
        
}

//function to check file size before uploading.
function beforeSubmit(){
    var chatbox= $('#chkChatbox').val();
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( !$('#'+chatbox +' #FileInput').val()) //check empty input filed
		{
			$('#'+chatbox +" #output").html("Are you kidding me?");
			return false
		}
		
		var fsize = $('#'+chatbox +' #FileInput')[0].files[0].size; //get file size
		var ftype = $('#'+chatbox +' #FileInput')[0].files[0].type; // get file type
		

		//allow file types 
		switch(ftype)
        {
            case 'image/png': 
			case 'image/gif': 
			case 'image/jpeg': 
			case 'image/pjpeg':
			case 'text/plain':
			case 'text/html':
			case 'application/x-zip-compressed':
			case 'application/pdf':
			case 'application/msword':
			case 'application/vnd.ms-excel':
//			case 'video/mp4':
                break;
            default:
                $('#'+chatbox +" #output").html("<b>"+ftype+"</b> Unsupported file type!");
				return false
        }
		
		//Allowed file size is less than 2 MB (1048576)
		if(fsize>2097152) 
		{
			$('#'+chatbox + "#output").html("<b>"+bytesToSize(fsize) +"</b> Too big file! <br />File is too big, it should be less than 2 MB.");
			return false
		}
				
		$('#'+chatbox +' #submit-btn').hide(); //hide submit button
//		$('#'+chatbox +' #loading-img').show(); //hide submit button
		$('#'+chatbox +" #output").html("");  
	}
	else
	{
		//Output error to older unsupported browsers that doesn't support HTML5 File API
		$('#'+chatbox +" #output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

//progress bar function
function OnProgress(event, position, total, percentComplete)
{
    //Progress bar
	$('#progressbox').show();
    $('#progressbar').width(percentComplete + '%') //update progressbar percent complete
    $('#statustxt').html(percentComplete + '%'); //update status text
    if(percentComplete>50)
        {
            $('#statustxt').css('color','#000'); //change status text to white after 50%
        }
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}



 

 