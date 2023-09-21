<?php

	
  class DB
  {
    /** Put this variable to true if you want ALL queries to be debugged by default:
      */
    var $defaultDebug = false;

    /** INTERNAL: The start time, in miliseconds.
      */
    var $mtStart;
    /** INTERNAL: The number of executed queries.
      */
    var $nbQueries;
    /** INTERNAL: The last result ressource of a query().
      */
    var $lastResult;
	
	var $last;	
	var $st;
	var $minid;
	var $maxid;
	
	var $params1 = array();
	var $cursor1 = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
	
	protected $conn = null;

    /** Connect to a MySQL database to be able to use the methods below.
      */
	 
	public function Formaterrors( $errors )
	{
    /* Display errors. */
    echo "Error information : <br/>";
    foreach ( $errors as $error )
    {
        echo "SQLSTATE: ".$error['SQLSTATE']."<br/>";
        echo "Code: ".$error['code']."<br/>";
        echo "Message: ".$error['message']."<br/>";
    }
	}
	
    public function DB($serverName, $connectionInfo)
    { 
	  if ( $this->conn) {
            return;
	  }
      $this->nbQueries  = 0;
      $this->lastResult = NULL;
	  $this->conn =  sqlsrv_connect( $serverName, $connectionInfo) or die( print_r( sqlsrv_errors() ) ); 
	  
	  return $this->conn;
	}

    /** Query the database.  */
    public function queryselect ($query,$param,$cursor)
    {
      $this->lastResult = sqlsrv_query($this->conn,$query,$param,$cursor) or die( print_r(sqlsrv_errors()) );
      return $this->lastResult ; 
    } 
	
	public function queryloop ($query)
    {
      $this->lastResult = sqlsrv_query($this->conn,$query,$this->param1,$this->cursor1) or die( print_r(sqlsrv_errors()) );
      return $this->lastResult ; 
    } 	
	
	 public function query($query)
    {
      $this->lastResult = sqlsrv_query($this->conn,$query) or die( print_r(sqlsrv_errors()) );
      return $this->lastResult ; 
    }    
     
    /** Get the number of rows of a query. */
	
    public function numRows()
    {
        return sqlsrv_num_rows($this->lastResult) or die( print_r( sqlsrv_errors() ) );
    }
	
     /** fetch next object. */  
	public function fetchnextobject($stmt)
    {
        return  sqlsrv_fetch_object($stmt) or die( print_r( sqlsrv_errors() ) );
    } 
 	
	public function lastId($queryID) {
     sqlsrv_next_result($queryID);
     sqlsrv_fetch($queryID);
     return sqlsrv_get_field($queryID, 0);
	}
	
	//column, view or table
	//$db->lastRecordId("LastId","LatestTransaction");
	public function lastRecordId($column,$table) {
	 $this->st = sqlsrv_query($this->conn,"SELECT {$column} FROM {$table}",$this->param1,$this->cursor1); 
	 if(sqlsrv_num_rows($this->st) > 0)	{
		while($data = sqlsrv_fetch_Object($this->st))	{ 
		  $this->last = $data->LastId;
		}					
	}	 
     return $this->last;
	}
	
	//max id | func (column,table)
	public function maxid($column,$table) {
	 $this->st = sqlsrv_query($this->conn,"SELECT MAX({$column}) AS maxid FROM {$table}",$this->param1,$this->cursor1); 
	 if(sqlsrv_num_rows($this->st) > 0)	{
	while($data = sqlsrv_fetch_Object($this->st))	{ 
		  $this->maxid = $data->maxid;
		}					
	}	 
     return $this->maxid;
	}
	
	//min id | func (column,table)
	public function minid($column,$table) {
	 $this->st = sqlsrv_query($this->conn,"SELECT MAX({$column}) AS minid FROM {$table}",$this->param1,$this->cursor1); 
	 if(sqlsrv_num_rows($this->st) > 0)	{
	while($data = sqlsrv_fetch_Object($this->st))	{ 
		  $this->minid = $data->minid;
		}					
	}	 
     return $this->minid;
	}
	
    /** Close the connexion with the database server.\n      */
    public function close()
    {	
	  //sqlsrv_free_stmt($this->lastResult);
      sqlsrv_close($this->conn);
    }


  } // class DB
?>
