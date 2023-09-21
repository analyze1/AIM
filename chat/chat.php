<?php
session_start();
//header('Content-type: application/json');
/*

Copyright (c) 2009 Anant Garg (anantgarg.com | inscripts.com)

This script may be used for non-commercial purposes only. For any
commercial purposes, please contact the author at 
anant.garg@inscripts.com

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

*/

//require_once ("db.class.sqlsrv.php");
$Chatter = new Chat();
//require_once("new_con.php");

$objConnect = mysql_connect("localhost","root","root");
mysql_select_db('test');
if ($_GET['action'] == "chatheartbeat") { $Chatter->chatHeartbeat(); } 
if ($_GET['action'] == "sendchat") { $Chatter->sendChat(); } 
if ($_GET['action'] == "closechat") { $Chatter->closeChat(); } 
if ($_GET['action'] == "startchatsession") {$Chatter->startChatSession(); } 

if (!isset($_SESSION['chatHistory'])) {
	$_SESSION['chatHistory'] = array();	
}

if (!isset($_SESSION['openChatBoxes'])) {
	$_SESSION['openChatBoxes'] = array();	
}

	
	
/* class Session
{

    private $sessionName;
    
    public function __construct($sessionName=null, $regenerateId=false, $sessionId=null)
    {
        if (!is_null($sessionId)) {
            session_id($sessionId);
        }
        
        session_start();

        if ($regenerateId) {
            //session_regenerate_id(true);
        }

        if (!is_null($sessionName)) {
            $this->sessionName = session_name($sessionName);
        }
    }
    
    
    public function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }
    
    /*
        to set something like $_SESSION['key1']['key2']['key3']:
        $session->setMd(array('key1', 'key2', 'key3'), 'value')
    */
	/*
    public function setMd($keyArray, $val)
    {
        $arrStr = "['".implode("']['", $keyArray)."']";
        $_SESSION{$arrStr} = $val;
    }
    
    
    public function get($key)
    {
        return (isset($_SESSION[$key])) ? $_SESSION[$key] : false;
    }
    */
    /*
        to get something like $_SESSION['key1']['key2']['key3']:
        $session->getMd(array('key1', 'key2', 'key3'))
    
    public function getMd($keyArray)
    {
        $arrStr = "['".implode("']['", $keyArray)."']";
        return (isset($_SESSION{$arrStr})) ? $_SESSION{$arrStr} : false;
    }
    
    
    public function delete($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }
    
    
    public function deleteMd($keyArray)
    {
        $arrStr = "['".implode("']['", $keyArray)."']";
        if (isset($_SESSION{$arrStr})) {
            unset($_SESSION{$arrStr});
            return true;
        }
        return false;
    }
    
    
    public function regenerateId($destroyOldSession=false)
    {
        session_regenerate_id(false);
        
        if ($destroyOldSession) {
            //  hang on to the new session id and name
            $sid = session_id();
            //  close the old and new sessions
            session_write_close();
            //  re-open the new session
            session_id($sid);
            session_start();
        }
    }
    
    
    public function destroy()
    {
        return session_destroy();
    }
    
    
    public function getName()
    {
        return $this->sessionName;
    }

}*/

 class Chat
  {	  
	public $usr = null; 
 	public $database = null;
 	public $uid = "root";
 	public $pwd = "root";
 	public $dbnm = "test";
 	public $connectionInfo = null;
	public $query = null;
  	public $serverName = ".\SQL";
	public $params1 = array();
	public $cursor1 = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
 
   	public function Chat()
    {	
//            $objConnect = mysql_connect("localhost","root","root");
//            mysql_select_db('test',$objConnect);
//		$this->connectionInfo = array("UID"=>$this->uid,"PWD"=>$this->pwd,"Database"=>$this->dbnm, "ReturnDatesAsStrings"=> true, "CharacterSet" => 'utf-8');
//		$this->database = new DB ($this->serverName,$this->connectionInfo);
	}
	
 
public function chatHeartbeat() {	
	$usr = $_SESSION['username'];
	//$this->query = $this->database->queryselect("",$this->params1,$this->cursor1); 	
	$sql = "select * from chat where msgto = '{$usr}' AND recd = '0' order by id ASC";
	$query = mysql_query($sql);	
	$items = '';
	$chatBoxes = array();
	while ($chatt = mysql_fetch_array($query)) {
           $rmsgfrom =  $chatt['msgfrom'];
           $rmessage =  $chatt['message'];
           $rsent =  $chatt['sent'];
		if (!isset($_SESSION['openChatBoxes'][$rmsgfrom]) && isset($_SESSION['chatHistory'][$rmsgfrom])) {
			$items = $_SESSION['chatHistory'][$rmsgfrom];
		}
		$rmessage = $this->sanitize($rmessage);
		$items .= <<<EOD
					   {
			"s": "0",
			"f": "{$rmsgfrom}",
			"m": "'line189='.{$rmessage}"
	   },
EOD;

	if (!isset($_SESSION['chatHistory'][$rmsgfrom])) {
		$_SESSION['chatHistory'][$rmsgfrom] = '';
	}
	$_SESSION['chatHistory'][$rmsgfrom] .= <<<EOD
						   {
			"s": "0",
			"f": "{$rmsgfrom}",
			"m": "'line200='.{$rmessage}"
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

			$message = "Sent 211 at $time";
			if ($now > 180) {
				$items .= <<<EOD
{
"s": "2",
"f": "$chatbox",
"m": "'line219='.{$message}"
},
EOD;

	if (!isset($_SESSION['chatHistory'][$chatbox])) {
		$_SESSION['chatHistory'][$chatbox] = '';
	}
	$_SESSION['chatHistory'][$chatbox] .= <<<EOD
		{
"s": "2",
"f": "$chatbox",
"m": "'line230='.{$message}"
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
		"username": "<?php echo $_SESSION['username'];?>",
		"items": [
			<?php echo $items;?>
        ]
}

<?php
	exit(0);
}


public function sendChat() {
	$from = $_SESSION['username'];
	$to = $_POST['to'];
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
	$sql = "insert into chat (msgfrom,msgto,message,sent) values ('$from', '$to','$message','".date('Y-m-d H:i:s')."')";
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