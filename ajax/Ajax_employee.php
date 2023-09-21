<?php
        include "../check-ses.php"; 
	//include "../inc/checksession.inc.php";
	include "../inc/connectdbs.inc.php"; 

	$call = $_POST['callajax'];
	$Dx_emp = $_POST['emp'];

	mysql_select_db($db_hr,$cndb_hr);

	if($call=="EMP")
	{
		$sql = "SELECT DEP_ID,DepartmentName_TH FROM department WHERE DepartmentName_TH='$Dx_emp'";
		$result = mysql_query( $sql,$cndb_hr );
		$fetcharr = mysql_fetch_array( $result );
		
		$query_EMP ="SELECT ID_EMP,Title,Name,Surname,Department  FROM employee WHERE Department = '".$fetcharr['DEP_ID']."' AND Status != 'N' ORDER BY ID_EMP ASC";
		$objQuery_EMP = mysql_query($query_EMP,$cndb_hr);
		$i=0;
		while( $row_EMP = mysql_fetch_array( $objQuery_EMP ) )
		{ 
			$returnedArray[$i]['ID_EMP'] = $row_EMP[ID_EMP];
			$returnedArray[$i]['emp_name'] = $row_EMP[Title].' '.$row_EMP[Name].' '.$row_EMP[Surname];
			$i++;
		};
	
		echo json_encode($returnedArray);
	}	

mysql_close();
?>