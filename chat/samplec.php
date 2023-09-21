<?php
session_start();
$_SESSION['username'] = "babydoe"; // Must be already set
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/loose.dtd" >

<html>
<head>
<title>Sample Chat Application</title>
<style>
body {
	background-color: #eeeeee;
	padding:0;
	margin:0 auto;
	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	font-size:11px;
}
</style>

<link type="text/css" rel="stylesheet" media="all" href="css/chat.css" />
<link type="text/css" rel="stylesheet" media="all" href="css/screen.css" />

<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" media="all" href="css/screen_ie.css" />
<![endif]-->

</head>
<body>
<div id="main_container">
you are : - <?php echo $_SESSION['username']; ?> <br>
<a href="javascript:void(0)" onclick="javascript:chatWith('janedoe')">Chat With Jane Doe</a>
<a href="javascript:void(0)" onclick="javascript:chatWith('johndoe')">Chat With John Doe</a>
<!-- YOUR BODY HERE -->

</div>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/chat.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
           setTimeout("chatHeartbeat();",800); 
        });
    	function play_sound() {
        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', 'notice.mp3');
        audioElement.setAttribute('autoplay', 'autoplay');
		audioElement.setAttribute('id','audio-notification');
        audioElement.load();
        audioElement.play();
    	}
		function remove_sound() {
       // document.getElementById("audio-notification").remove();
    	}
        
</script>
</body>
</html>