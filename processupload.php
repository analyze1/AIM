<?php
include "pages/check-ses.php"; 
include "../inc/connectdbs.pdo.php";

if(isset($_FILES["FileInput"]) && $_FILES["FileInput"]["error"]== UPLOAD_ERR_OK)
{
  $from =   $_GET['ufrom'];
  $to =   $_GET['uto'];
  if($to=='admin'){
        $chatname = 'admin_'.$from;
  }else{
      $chatname = 'admin_'.$to;
  }
	############ Edit settings ##############
	$UploadDirectory	= 'uploads/'; //specify upload directory ends with / (slash)
	##########################################
	
	//check if this is an ajax request
	if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		die();
	}
	
	//Is file size is less than allowed size.
	if ($_FILES["FileInput"]["size"] > 5242880) {
		die("File size is too big!");
	}
	
	//allowed file type Server side check
	switch(strtolower($_FILES['FileInput']['type']))
		{
			//allowed file types
                        case 'image/png': 
			case 'image/gif': 
			case 'image/jpeg': 
			case 'image/pjpeg':
			case 'text/plain':
			case 'text/html': //html file
			case 'application/x-zip-compressed':
			case 'application/pdf':
			case 'application/msword':
			case 'application/vnd.ms-excel':
//			case 'video/mp4':
			break;
			default:
				die('Unsupported File!'); //output error
	}
	
	$File_Name          = strtolower($_FILES['FileInput']['name']);
	$File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
	$Random_Number      = rand(0, 9999999999); //Random number to be added to name.
	$NewFileName 		= $Random_Number.$File_Ext; //new file name
	
	if(move_uploaded_file($_FILES['FileInput']['tmp_name'], $UploadDirectory.$NewFileName ))
	   {
                $message = '<a href="uploads/'.$NewFileName.'" target="_blank"><img src="images/unknown.png"></a>';
                
                $sql = "insert into chat (msgfrom,msgto,message,sent,area,chatname) values ('$from', '$to','$message','".date('Y-m-d H:i:s')."','".$_SESSION['strArea']."','$chatname')";
              
                $query = mysql_query($sql);
               //die('Success! File Uploaded.');
            }else{
               die('error uploading File!');
           }
	
}
else
{
	die('Something wrong with upload! Is "upload_max_filesize" set correctly?');
}