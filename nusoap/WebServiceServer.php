<?
		require_once("lib/nusoap.php");
		 
		//Create a new soap server
		$server = new soap_server();
		 
		//Define our namespace
		$namespace = "http://192.168.1.250/newFour/policy/nusoap/WebServiceClient.php";
		$server->wsdl->schemaTargetNamespace = $namespace;
		 
		//Configure our WSDL
		$server->configureWSDL("SendPolicyCTPRealTime"); //HelloWorld
		 
		// Register our method and argument parameters
        $varname = array(
                   'AgentCode' => "xsd:string",
				   'ApplicationNo' => "xsd:string",
				   'SaleName' => "xsd:string",
				   'AppSignDate' => "xsd:string",
				   'EffectiveDate' => "xsd:string",
				   'ExpiredDate' => "xsd:string",
				   'PolicyNo' => "xsd:string",
				   'Barcode' => "xsd:string",
				   'CardType' => "xsd:string",
				   'CardNo' => "xsd:string",
				   'InsuredType' => "xsd:string",
				   'InsuredBranchCode' => "xsd:string",
				   'InsuredTitleName' => "xsd:string",
				   'InsuredName' => "xsd:string",
				   'InsuredLastName' => "xsd:string",
				   'Gender' => "xsd:string",
				   'BirthDate' => "xsd:string",
				   'Telephone' => "xsd:string",
				   'MobileNo' => "xsd:string",
				   'HomeNo' => "xsd:string",
				   'Building' => "xsd:string",
				   'Moo' => "xsd:string",
				   'Moobarn' => "xsd:string",
				   'RoomNo' => "xsd:string",
				   'Trok' => "xsd:string",
				   'Soi' => "xsd:string",
				   'Road' => "xsd:string",
				   'Tambol' => "xsd:string",
				   'Amphur' => "xsd:string",
				   'Postcode' => "xsd:string",
				   'Province' => "xsd:string",
				   'LicenseNo' => "xsd:string",
				   'LicenseProvince' => "xsd:string",
				   'Chassis' => "xsd:string",
				   'Engine' => "xsd:string",
				   'VehicleType' => "xsd:string",
				   'VehicleMake' => "xsd:string",
				   'VehicleModel' => "xsd:string",
				   'VehicleRegYear' => "xsd:string",
				   'Seat' => "xsd:string",
				   'CC' => "xsd:string",
				   'VehicleWeight' => "xsd:string",
				   'VehicleUseCode' => "xsd:string",
				   'NetPremium' => "xsd:string",
				   'Vat' => "xsd:string",
				   'Stamp' => "xsd:string",
				   'GrossPremium' => "xsd:string",
				   'OnlinePayment_amt' => "xsd:string",
				   'OnlinePayment_no' => "xsd:string",
				   'isOnline' => "xsd:string",
				   'email_customer' => "xsd:string",
				   'email_agent' => "xsd:string",
				   'onlinemerchant_id' => "xsd:string"
        );
        
		$server->register('SendPolicyCTPRealTime',$varname, array('return' => 'xsd:string')); //HelloWorld
		 
		function SendPolicyCTPRealTime($strName,$strEmail) //HelloWorld
		{
			
			return "Hello, World! Khun ($strName , Your email : $strEmail)";
		}
		 
		// Get our posted data if the service is being consumed
		// otherwise leave this data blank.
		$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
		 
		// pass our posted data (or nothing) to the soap service
		$server->service($POST_DATA);
		exit(); 
?>