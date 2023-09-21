<?php
include "../pages/check-ses.php";
//include "../inc/checksession.inc.php";
include "../inc/connectdbs.inc.php"; 
//include "../inc/session_car.php"; 
//include "../inc/session_renew.php"; 

                        
$cost = $_POST['cost'];
	//$type = $_POST['type_pro'];
	$type1 = $_POST['type1'];
	$service = $_POST['service'];
	$doc_type = $_POST['doc_type'];
	$mo_car_re = $_POST['mo_car_re'];
	//$type2 = $_POST['type2'];
	
	 //if($_SESSION["MoC"]['name'][$row['mo_car']] =='CARRY' ) 
	 if($mo_car_re =='CARRY' ){ 
                    if($doc_type=='2+')
                    {
                    $type2='AS2_2';
                    }
                    else  if($doc_type=='3+')
                    {
                    $type2='AS2_3';
                    }
                    else
                    {
                    $type2='AS2';
                    }
	}else{ 
		  if($doc_type=='2+')
		  {
		  $type2='S30_2';
		  }
		   else  if($doc_type=='3+')
		  {
		  $type2='S30_3';
		  }
		  else
		  {
                    $type2='S30';
                  }
	} 
	
	
	//$mo_car_re = $_POST['mo_car_re'];
	if($mo_car_re == 'ERTIGA'){
		$mo_car_re = '1960' ;
	}else if($mo_car_re == 'CARRY'){
		$mo_car_re = '1098';
	}else{
                $mo_car_re = '';
        }
	
	mysql_select_db($db1,$cndb1);
	mysql_query("SET NAMES 'utf8'");

	if($doc_type == "1")
	{
            // กรณี เป็น ป.1  และเช็ค mocar เป็น carry   
            if($mo_car_re == '1098'){
                $sqlcost = "SELECT * FROM UCostRenew WHERE  doc_type= '$doc_type'  AND mo_car='$mo_car_re'  ORDER BY cost DESC"; 
            }else{
                $sqlcost = '';
            }
            
            $sql = "SELECT pre,net FROM UCostRenew WHERE cost='$cost' AND service = '$service' AND  type='$type1' ";
	}
	else
	{
            $sqlcost = "SELECT * FROM UCostRenew WHERE service = '2' AND doc_type= '$doc_type' AND type='$type2'  ORDER BY cost DESC";    
            $sql = "SELECT pre,net FROM UCostRenew WHERE cost='$cost' AND service = '2' AND doc_type= '$doc_type'  AND type='$type2' ";
	}

	
		
if(!empty($sqlcost)){
	$resultcost = mysql_query($sqlcost,$cndb1);	
	while($sqlarray=mysql_fetch_array($resultcost))
	{
		$x++;
		if($x==1)
		{
		if($cost==$sqlarray['cost'])
		{	
			$costoption.="<option value='".$sqlarray['cost']."'  selected  >".number_format($sqlarray['cost'])."</option>";
		}
		else
		{
			$costoption.="<option value='".$sqlarray['cost']."'>".number_format($sqlarray['cost'])."</option>";
		}
		}
		else
		{
		if($cost==$sqlarray['cost'])
		{
			$costoption.="<option value='".$sqlarray['cost']."' selected >".number_format($sqlarray['cost'])."</option>";
		}
		else
		{
			$costoption.="<option value='".$sqlarray['cost']."'>".number_format($sqlarray['cost'])."</option>";	
		}
		}
	}
		$returnedArray['costoption'] = $costoption;
}	
	
		
		
		$result = mysql_query( $sql,$cndb1 );
		$fetcharr = mysql_fetch_array( $result );
		$returnedArray['Cost'] = $fetcharr['pre'];
		$returnedArray['Cost_net'] = $fetcharr['net'];
		

	
	
	
echo json_encode($returnedArray);
	


mysql_close();
?>