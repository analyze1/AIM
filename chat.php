<?php

include "pages/check-ses.php"; 
include "../inc/connectdbs.pdo.php";


$Chatter = new Chat();
//require_once("new_con.php");


if ($_GET['action'] == "chatheartbeat") { $Chatter->chatHeartbeat(); } 
if ($_GET['action'] == "sendchat") { $Chatter->sendChat(); } 
if ($_GET['action'] == "closechat") { $Chatter->closeChat(); } 
if ($_GET['action'] == "startchatsession") {$Chatter->startChatSession(); } 

if ($_GET['action'] == "chatheartbeatHis") { $Chatter->chatHeartbeatHis($_GET['b']); } 

if (!isset($_SESSION['chatHistory'])) {
	$_SESSION['chatHistory'] = array();	
}

if (!isset($_SESSION['openChatBoxes'])) {
	$_SESSION['openChatBoxes'] = array();	
}

class Chat
  {	  
	public $usr = null; 
// 	public $database = null;
// 	public $uid = "root";
// 	public $pwd = "root";
// 	public $dbnm = "test";
// 	public $connectionInfo = null;
	public $query = null;
//  	public $serverName = ".\SQL";
//	public $params1 = array();
//	public $cursor1 = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
 
   	public function Chat()
    {	
//            $objConnect = mysql_connect("localhost","root","root");
//            mysql_select_db('test',$objConnect);
//		$this->connectionInfo = array("UID"=>$this->uid,"PWD"=>$this->pwd,"Database"=>$this->dbnm, "ReturnDatesAsStrings"=> true, "CharacterSet" => 'utf-8');
//		$this->database = new DB ($this->serverName,$this->connectionInfo);
	}
	
public function chatHeartbeat() {
//    if($_SESSION['strUser']=='admin'){
//        $usr = $_SESSION['strArea'].$_SESSION['strUser'];
//    }else{
//        $usr = $_SESSION['strUser'];
//    }
	$usr = $_SESSION['strUser'];	
	$sql = "select * from chat where msgto = '{$usr}' AND recd = '0' order by id ASC";
	$query = mysql_query($sql);	
	$items = '';
	$chatBoxes = array();
	while ($chatt = mysql_fetch_array($query)) {
           $rmsgfrom =  $chatt['msgfrom'];
           $rmessage =  $chatt['message'];
           $rsent =  $chatt['sent'];
           $chatname =  $chatt['chatname'];
		if (!isset($_SESSION['openChatBoxes'][$rmsgfrom]) && isset($_SESSION['chatHistory'][$rmsgfrom])) {
			//$items = $_SESSION['chatHistory'][$rmsgfrom];
			$items = $_SESSION['chatHistory'][$rmsgfrom];
                        
		}
		$rmessage =  addslashes($rmessage);
//		$rmessage = $this->sanitize($rmessage);
		$items .= <<<EOD
					   {
			"s": "0",
			"f": "{$rmsgfrom}",
			"m": "{$rmessage}",
			"n": "{$chatname}"
	   },
EOD;

	if (!isset($_SESSION['chatHistory'][$rmsgfrom])) {
		$_SESSION['chatHistory'][$rmsgfrom] = '';
	}
	$_SESSION['chatHistory'][$rmsgfrom] .= <<<EOD
						   {
			"s": "0",
			"f": "{$rmsgfrom}",
			"m": "{$rmessage}",
                        "n": "{$chatname}"
	   },
EOD;
		
		unset($_SESSION['tsChatBoxes'][$rmsgfrom]);
		$_SESSION['openChatBoxes'][$rmsgfrom] = date("Y-m-d h:i:s",strtotime($rsent)); //2014-07-08 09:24:01
	}
	if (!empty($_SESSION['openChatBoxes'])) {
	foreach ($_SESSION['openChatBoxes'] as $chatbox => $time) {
		if (!isset($_SESSION['tsChatBoxes'][$chatbox])) {
			$now = time()-strtotime($time);
			$time = date('g:iA M dS', strtotime($time));

			$message = "Sent at $time";
			if ($now > 180) {
				$items .= <<<EOD
{
"s": "2",
"f": "$chatbox",
"m": "{$message}",
"n": "{$chatname}"
},
EOD;

	if (!isset($_SESSION['chatHistory'][$chatbox])) {
		$_SESSION['chatHistory'][$chatbox] = '';
	}
	$_SESSION['chatHistory'][$chatbox] .= <<<EOD
		{
"s": "2",
"f": "$chatbox",
"m": "{$message}",
"n": "{$chatname}"
},
EOD;
			$_SESSION['tsChatBoxes'][$chatbox] = 1;
		}
		}
	}
}

	$sql = "update chat set recd = '1' where msgto = '{$usr}' and recd = '0'";
	$query = mysql_query($sql);
	if ($items != '') {
		$items = substr($items, 0, -1);
	}
	
header('Content-type: application/json');
?>
{
		"items": [
			<?php echo $items;?>
        ]
}

<?php			
	exit(0);
}

public function chatHeartbeatHis($b) {
        if($_SESSION['strUser']=='admin'){
            $chBox = 'admin'.'_'.$b;
        }else{
            $chBox = 'admin'.'_'.$_SESSION['strUser'];
        }
        
	$sql = "select * from chat where chatname='".$chBox."' order by id ASC";
	$query = mysql_query($sql);	
	$items = '';
	$chatBoxes = array();
	while ($chatt = mysql_fetch_array($query)) {
           $rmsgfrom =  $chatt['msgfrom'];
           $rmessage =  $chatt['message'];
           $rsent =  $chatt['sent'];
           $chatname =  $chatt['chatname'];

		$rmessage = addslashes($rmessage);
//		$rmessage = $this->sanitize($rmessage);
		$items .= <<<EOD
		{
			"s": "0",
			"f": "{$rmsgfrom}",
			"m": "{$rmessage}",
			"n": "{$sql}"
                },
EOD;

	}
        $usr = $_SESSION['strUser'];
	$sql = "update chat set recd = '1' where msgto = '{$usr}' and recd = '0'";
	$query = mysql_query($sql);
        
	if ($items != '') {
            $items = substr($items, 0, -1);
	}
	
header('Content-type: application/json');
?>
{
		"items": [ <?php echo $items;?> ]
}

<?php			
	exit(0);
}

public function chatBoxSession($chatbox) {	
	$items = '';	
	if (isset($_SESSION['chatHistory'][$chatbox])) {
		$items = $_SESSION['chatHistory'][$chatbox];
	}
	return $items;
}

public function startChatSession() {
	$items = '';
	if (!empty($_SESSION['openChatBoxes'])) {
		foreach ($_SESSION['openChatBoxes'] as $chatbox => $void) {
			$items .= $this->chatBoxSession($chatbox);
		}
	}
	if ($items != '') {
		$items = substr($items, 0, -1);
	}

header('Content-type: application/json');
?>
{
                "username": "<?php echo $_SESSION['strUser']; ?>",
		"items": [
			<?php echo $items;?>
        ]
}

<?php
	exit(0);
}


public function sendChat() {
        //check user หากเป็น admin จะกำหนด area ไว้ด้านหน้า
//        if($_SESSION['strUser']!='admin'){
//            $from = $_SESSION['strUser'];
//        }else{
//            $from = $_SESSION['strArea'].$_SESSION['strUser'];
//        }
        $from = $_SESSION['strUser'];
	$to = $_POST['to'];
        
	$chatname = 'admin'.'_'.$_POST['chatname'];
	$message = $_POST['message'];
	$_SESSION['openChatBoxes'][$_POST['to']] = date('Y-m-d H:i:s', time());	
	$messagesan = $this->sanitize($message);
	if (!isset($_SESSION['chatHistory'][$_POST['to']])) {
		$_SESSION['chatHistory'][$_POST['to']] = '';
	}
	$_SESSION['chatHistory'][$_POST['to']] .= <<<EOD
					   {
			"s": "1",
			"f": "{$to}",
			"m": "{$messagesan}"
	   },
EOD;
	unset($_SESSION['tsChatBoxes'][$_POST['to']]);
	$sql = "insert into chat (msgfrom,msgto,message,sent,area,chatname) values ('$from', '$to','$message','".date('Y-m-d H:i:s')."','".$_SESSION['strArea']."','$chatname')";
	$query = mysql_query($sql);
	echo "1";	
	exit(0);
}

public function closeChat() {
	unset($_SESSION['openChatBoxes'][$_POST['chatbox']]);	
	echo "1";
	exit(0);
}

public function sanitize($text) {
        $text = htmlspecialchars($text, ENT_QUOTES);
	$text = str_replace("\n\r","\n",$text);
	$text = str_replace("\r\n","\n",$text);
	$text = str_replace("\n","<br>",$text);
	return $text;
}
  }

