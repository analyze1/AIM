<?php
	if($_REQUEST['onload']==''){
		
	header("Content-type: text/html; charset=utf-8");
	echo "<meta charset='utf-8'>" ;
	//mysql_query( "SET NAMES UTF8" );
	
	}
function getIP(){
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
//echo("<br /><br /> IP :".getIP()."<br />");
$logip = getIP();
//Tiem
	function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate));
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("d",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","01","02","03","04","05","06","07","08","09","10","11","12");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strYear-$strMonthThai-$strDay $strHour:$strMinute:$strSeconds";
	}
	$strDate = date('Y-m-d H:i:s');
	$logdate = DateThai($strDate);
?>
<?php
//OS
$user_agent     =   $_SERVER['HTTP_USER_AGENT'];

function getOS() { 

    global $user_agent;

    $os_platform    =   "Unknown OS Platform";

    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows10',
                            '/windows nt 6.3/i'     =>  'Windows8.1',
                            '/windows nt 6.2/i'     =>  'Windows8',
                            '/windows nt 6.1/i'     =>  'Windows7',
                            '/windows nt 6.0/i'     =>  'WindowsVista',
                            '/windows nt 5.2/i'     =>  'WindowsServer 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'WindowsXP',
                            '/windows xp/i'         =>  'WindowsXP',
                            '/windows nt 5.0/i'     =>  'Windows2000',
                            '/windows me/i'         =>  'WindowsME',
                            '/win98/i'              =>  'Windows98',
                            '/win95/i'              =>  'Windows95',
                            '/win16/i'              =>  'Windows3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }   

    return $os_platform;

}

function getBrowser() {

    global $user_agent;

    $browser        =   "Unknown Browser";

    $browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/edge/i'       =>  'Edge',
							'/spartan/i'    =>  'Project Spartan', 
							'/opr/i'        =>  'Opera',
                            '/opera/i'      =>  'Opera',
							'/bd/i'         =>  'Baidu Browser',
							'/bs/i'         =>  'Baidu Browser',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Mobile Browser'  
                        );

    foreach ($browser_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }

    }

    return $browser;

}


$user_os        =   getOS();
$user_browser   =   getBrowser();

// $device_details =   "<strong>Browser: </strong>".$user_browser."<br /><strong>Operating System: </strong>".$user_os."";

?>
