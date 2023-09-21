// JavaScript Document
//AJAX
function Inint_AJAX()
{
	try
	{
		return new ActiveXObject( "Msxml2.XMLHTTP" );
	}
	catch ( e )
	{
	};

	try
	{
		return new ActiveXObject( "Microsoft.XMLHTTP" );
	}
	catch ( e )
	{
	};

	try
	{
		return new XMLHttpRequest();
	}
	catch ( e )
	{
	};

	alert( "XMLHttpRequest not supported" );
	return null;
};

function dotype( obj )
{
	var req = Inint_AJAX();
	var cartype = document.getElementById( 'cartype' ).value;
	if ( obj && obj.name == 'cartype' )
	{
		var car_id = "";
	}
	else //???????????????
	{
		var car_id = document.getElementById( 'car_id' ).value;
	};
	var data = "cartype=" + cartype + "&car_id=" + car_id;
	
	req.onreadystatechange = function()
	{
		if ( req.readyState == 4 )
		{
			if ( req.status == 200 )
			{
				var datas = eval( '(' + req.responseText + ')' ); // JSON
				document.getElementById( 'cartypeDiv' ).innerHTML = datas[0].cartype;
				document.getElementById( 'car_idDiv' ).innerHTML = datas[0].car_id;
			};
		};
	};
	req.open( "post" , "cartype.php" , true ); //???? connection
	req.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded" ); // set Header
	req.send( data ); //?????
};

function docar( obj )
{
	var req = Inint_AJAX();
	var cat_car = document.getElementById( 'cat_car' ).value;
	var mo_car = document.getElementById( 'mo_car' ).value;
	if ( obj && obj.name == 'cat_car' )
	{
		var br_car = "";
	}
	else //???????????????
	{
		var br_car = document.getElementById( 'br_car' ).value;
	};
	var data = "cat_car=" + cat_car + "&br_car=" + br_car + "&mo_car=" + mo_car;
	req.onreadystatechange = function()
	{
		if ( req.readyState == 4 )
		{
			if ( req.status == 200 )
			{
				var datas = eval( '(' + req.responseText + ')' ); // JSON
				document.getElementById( 'cat_carDiv' ).innerHTML = datas[0].cat_car;
				document.getElementById( 'br_carDiv' ).innerHTML = datas[0].br_car;
				document.getElementById( 'mo_carDiv' ).innerHTML = datas[0].mo_car;
			};
		};
	};
	req.open( "post" , "car.php" , true ); //???? connection
	req.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded" ); // set Header
	req.send( data ); //?????
};
    function showCarAge()
    {
		var currentTime = new Date();
		//var month = currentTime.getMonth() + 1;
		//var day = currentTime.getDate();
		var year = currentTime.getFullYear();
		var iYear = year - document.getElementById("regis_date").value + 1 + "ปี";
        if (document.getElementById("regis_date").value == "")
            document.getElementById("year_old").value = "";        
        else
            document.getElementById("year_old").value = iYear;        
    }
	//-------------------------------------------------------
	function showcarbody()
    {
		var new_mo = document.getElementById("mo_car").value;
        if (document.getElementById("mo_car").value == "760")
            document.getElementById("new_carbody").value = "MHYEZC21S00"; 
		else if (document.getElementById("mo_car").value == "759")
            document.getElementById("new_carbody").value = "MHYHYA21S00";       
		else if (document.getElementById("mo_car").value == "754")
            document.getElementById("new_carbody").value = "MHYJTE54V00";      
		else if (document.getElementById("mo_car").value == "1098")
            document.getElementById("new_carbody").value = "MHYGDN71T00"; 
		else if (document.getElementById("mo_car").value == "747")
            document.getElementById("new_carbody").value = "MHYGDN71V00"; 
		else if (document.getElementById("mo_car").value == "1951")
            document.getElementById("new_carbody").value = "MMSHZC72S00"; 
		else if (document.getElementById("tel_mobi").value == "")
            document.getElementById("tel_mobi2").value = "-"; 
        else
            document.getElementById("new_carbody").value = "";    
		
		var new_carbody2 = document.getElementById("mo_car").value;
        if (document.getElementById("mo_car").value == "760")
            document.getElementById("new_motor").value = "M15AIA";
		else if (document.getElementById("mo_car").value == "759")
      		document.getElementById("new_motor").value = "M16AIA";
		else if (document.getElementById("mo_car").value == "754")
      		document.getElementById("new_motor").value = "J20AID";
		else if (document.getElementById("mo_car").value == "1098")
         	document.getElementById("new_motor").value = "G16AID";
		else if (document.getElementById("mo_car").value == "747")
         	document.getElementById("new_motor").value = "G16AID";
		else if (document.getElementById("mo_car").value == "1951")
         	document.getElementById("new_motor").value = "K12BS1";
        else
            document.getElementById("new_motor").value = ""; 
    }
	function showdriver(){
        if (document.getElementsByName("rdodriver")[1].checked == true)
        {
            document.getElementById("Divdriver1").style.display = "block";
            document.getElementById("Divdriver2").style.display = "none";
        }
        else if (document.getElementsByName("rdodriver")[2].checked == true)
        {
            document.getElementById("Divdriver1").style.display = "block";
            document.getElementById("Divdriver2").style.display = "block";
        }    
        else
        {            
            document.getElementById("Divdriver1").style.display = "none";
            document.getElementById("Divdriver2").style.display = "none";
        }
    } 
	//----------------------------------------------------
		function showcard(){
        if (document.getElementsByName("id_card")[1].checked == true)
        {
            document.getElementById("Divcard2").style.display = "block";
            document.getElementById("Divcard1").style.display = "none";
        }
        else
        {
            document.getElementById("Divcard1").style.display = "block";
            document.getElementById("Divcard2").style.display = "none";
        }    

    }
	//-----------------------------------------------------
	function showans()
	{
        if (document.getElementsByName("601")[1].checked == true)
        {
            document.getElementById("Div601Y").style.display = "block";
			var ans601 = document.webForm.detail601.value;
			if ( ans601.length=="")
				   {
				   alert("โปรดระบุรายละเอียด");
				   document.webForm.detail601.focus();           
				   return false;
				   }
        }    
		else
		{
		    document.getElementById("Div601Y").style.display = "none";	
		}
	}
	function showans2()
	{
		if (document.getElementsByName("602")[1].checked == true)
        {
            document.getElementById("Div602Y").style.display = "block";
			var ans602 = document.webForm.detail602.value;
			if ( ans602.length=="")
				   {
				   alert("โปรดระบุรายละเอียด");
				   document.webForm.detail602.focus();           
				   return false;
				   }
        }    
		else
		{
		    document.getElementById("Div602Y").style.display = "none";	
		}
	}
	function showans3()
	{
		if (document.getElementsByName("603")[1].checked == true)
        {
            document.getElementById("Div603Y").style.display = "block";
			var ans603 = document.webForm.detail603.value;
			if ( ans603.length=="")
				   {
				   alert("โปรดระบุรายละเอียด");
				   document.webForm.detail603.focus();           
				   return false;
				   }
        }    
		else
		{
		    document.getElementById("Div603Y").style.display = "none";	
		}
	}
	function showans4()
	{
		if (document.getElementsByName("604")[1].checked == true)
        {
            document.getElementById("Div604Y").style.display = "block";
			var ans604 = document.webForm.detail601.value;
			if ( ans604.length=="")
				   {
				   alert("โปรดระบุรายละเอียด");
				   document.webForm.detail604.focus();           
				   return false;
				   }
        }    
		else
		{
		    document.getElementById("Div604Y").style.display = "none";	
		}
	}
	function showans5()
	{
		if (document.getElementsByName("605")[1].checked == true)
        {
            document.getElementById("Div605Y").style.display = "block";
			var ans605 = document.webForm.detail605.value;
			if ( ans605.length=="")
				   {
				   alert("โปรดระบุรายละเอียด");
				   document.webForm.detail605.focus();           
				   return false;
				   }
        }    
		else
		{
		    document.getElementById("Div605Y").style.display = "none";	
		}
    }
	//-----------------------------------------------------
    function showgain(){
        if (document.getElementsByName("rdogain")[1].checked == true)
        {
            document.getElementById("Divgain").style.display = "block";
        }
        else
        {            
            document.getElementById("Divgain").style.display = "none";
        }
    } 
	function  equi() {
        if (document.getElementsByName("equit")[1].checked == true)	
		{
			document.getElementById("divEquit").style.display = "block";
		}
		else 
		{
			document.getElementById("divEquit").style.display = "none";
		}
	}
	function  equi_br_car() {
        if (document.getElementsByName("equit_car")[1].checked == true)	
		{
			document.getElementById("divAns_carry").style.display = "block";
			document.getElementById("divEquit_swift").style.display = "none";
		}
		else 
		{
			document.getElementById("divAns_carry").style.display = "none";
			document.getElementById("divEquit_swift").style.display = "block";
		}
	}
	function  equi_ans_car() 
	{
        if (document.getElementsByName("idcarry")[1].checked == true)	
		{
			document.getElementById("divEquit_carry").style.display = "block";
			document.getElementById("divEquit_carry220").style.display = "none";
		}
		else 
		{
			document.getElementById("divEquit_carry").style.display = "none";
			document.getElementById("divEquit_carry220").style.display = "block";
		}
	}
	function  chk_first_cost() {
        if (document.getElementsByName("chk_first")[1].checked == true)	
		{
			document.getElementById("first_costSpn").style.display = "block";
		}
		else 
		{
			document.getElementById("first_costSpn").style.display = "none";
		}		
	}
	function  chk_car_cost() {
        if (document.getElementsByName("chk_carcost")[1].checked == true)	
		{
			document.getElementById("car_costSpn").style.display = "block";
		}
		else 
		{
			document.getElementById("car_costSpn").style.display = "none";
		}		
	}	
    function showsms(){
        if (document.getElementsByName("sendtxt")[1].checked == true)	
		{
			document.getElementById("Divsms").style.display = "block";
			document.getElementById("Divemail").style.display = "none";
		}
		else 
		{
			document.getElementById("Divsms").style.display = "none";
			document.getElementById("Divemail").style.display = "block";
		}
	} 
	
function dochange( obj )
{
	var req = Inint_AJAX();
	var province = document.getElementById( 'province' ).value;
	var tumbon = document.getElementById( 'tumbon' ).value;
	var id_post = document.getElementById( 'id_post' ).value;
	if ( obj && obj.name == 'province' ) //????????????????????????? ??????????????????
	{
		var amphur = "";
	}
	else //???????????????
	{
		var amphur = document.getElementById( 'amphur' ).value;
	};
	var data = "province=" + province + "&amphur=" + amphur + "&tumbon=" + tumbon+ "&id_post=" + id_post;
	req.onreadystatechange = function()
	{
		if ( req.readyState == 4 )
		{
			if ( req.status == 200 )
			{
				var datas = eval( '(' + req.responseText + ')' ); // JSON
				document.getElementById( 'provinceDiv' ).innerHTML = datas[0].province;
				document.getElementById( 'amphurDiv' ).innerHTML = datas[0].amphur;
				document.getElementById( 'tumbonDiv' ).innerHTML = datas[0].tumbon;
				document.getElementById( 'id_postDiv' ).innerHTML = datas[0].id_post;
			};
		};
	};
	req.open( "post" , "province.php" , true ); //???? connection
	req.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded" ); // set Header
	req.send( data ); //?????
};

function Cus_dochange( obj )
{
	var req = Inint_AJAX();
	var Cus_province = document.getElementById( 'Cus_province' ).value;
	var Cus_tumbon = document.getElementById( 'Cus_tumbon' ).value;
	if ( obj && obj.name == 'Cus_province' ) //????????????????????????? ??????????????????
	{
		var Cus_amphur = "";
	}
	else //???????????????
	{
		var Cus_amphur = document.getElementById( 'Cus_amphur' ).value;
	};
	var data = "Cus_province=" + Cus_province + "&Cus_amphur=" + Cus_amphur + "&Cus_tumbon=" + Cus_tumbon;
	req.onreadystatechange = function()
	{
		if ( req.readyState == 4 )
		{
			if ( req.status == 200 )
			{
				var datas = eval( '(' + req.responseText + ')' ); // JSON
				document.getElementById( 'Cus_provinceDiv' ).innerHTML = datas[0].Cus_province;
				document.getElementById( 'Cus_amphurDiv' ).innerHTML = datas[0].Cus_amphur;
				document.getElementById( 'Cus_tumbonDiv' ).innerHTML = datas[0].Cus_tumbon;
			};
		};
	};
	req.open( "post" , "req_province.php" , true ); //???? connection
	req.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded" ); // set Header
	req.send( data ); //?????
};

function costtype( obj )
{
	var req = Inint_AJAX();
	
	var com_data = document.getElementById("com_data").value;
	var car_cc  = document.getElementById("car_cc").value;
	var cat_car = document.getElementById("cat_car").value;
	var mo_car = document.getElementById("mo_car").value;
	var gear = document.getElementById("gear").value;
	
	var costCost = document.getElementById( 'costCost' ).value;
	var costPre = document.getElementById( 'costPre' ).value;
	var costStamp = document.getElementById( 'costStamp' ).value;
	var costTax = document.getElementById( 'costTax' ).value;
	var costNet = document.getElementById( 'costNet' ).value;
	
	var data = "costCost=" + costCost + "&costPre=" + costPre + "&costStamp=" + costStamp + "&costTax=" + costTax + "&costNet=" + costNet + "&com_data=" + com_data + "&gear=" + gear + "&car_cc=" + car_cc + "&cat_car=" + cat_car + "&mo_car=" + mo_car;
	req.onreadystatechange = function()
	{
		if ( req.readyState == 4 )
		{
			if ( req.status == 200 )
			{
				var datas = eval( '(' + req.responseText + ')' ); // JSON
				
				document.getElementById( 'costCostDiv' ).innerHTML = datas[0].costCost;
				document.getElementById( 'costPreDiv' ).innerHTML = datas[0].costPre;
				document.getElementById( 'costStampDiv' ).innerHTML = datas[0].costStamp;
				document.getElementById( 'costTaxDiv' ).innerHTML = datas[0].costTax;
				document.getElementById( 'costNetDiv' ).innerHTML = datas[0].costNet;
			};
		};
	};
	req.open( "post" , "cost.php" , true ); //???? connection
	req.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded" ); // set Header
	req.send( data ); //?????
};

    function ShowDetail(){
        if (document.getElementById("showkkk").style.display == "none")
        {
            document.getElementById("showkkk").style.display = "block";
        }
        else 
        {
            document.getElementById("showkkk").style.display = "none";
        }
        return false;
	}
	
		function checking()
		{
			  var v1 = document.webForm.com_data.value;	
			  var v2 = document.webForm.ty_inform.value;
			  var v3 = document.webForm.start_date.value;
			  var v4 = document.webForm.cartype.value;
			  var v5 = document.webForm.car_id.value;
			  var v6 = document.webForm.cat_car.value;
			  var v7 = document.webForm.br_car.value;
			  var v8 = document.webForm.mo_car.value;
			  var v9 = document.webForm.car_cc.value;
			  var v10 = document.webForm.car_wgt.value;
			  var v11 = document.webForm.car_seat.value;
			  var v12 = document.webForm.gear.value;
			  var v13 = document.webForm.car_body.value;
			  var v14 = document.webForm.n_motor.value;
			  var v15 = document.webForm.car_regis_pro.value;
			  var v16 = document.webForm.regis_date.value;
			  var title = document.webForm.title.value;
			  var name = document.webForm.name.value;
			  var last = document.webForm.last.value;
			  var add = document.webForm.add.value;
			  var group = document.webForm.group.value;
			  var town = document.webForm.town.value;
			  var rec_lane = document.webForm.rec_lane.value;
			  var road = document.webForm.road.value;
			  var tel_home = document.webForm.tel_home.value;
			  var tel_mobi = document.webForm.tel_mobi.value;
			  var province = document.webForm.province.value;
			  var amphur = document.webForm.amphur.value;
			  var tumbon = document.webForm.tumbon.value;
			  
			  
			  var xx = v3.split('/');
			  var a = parseInt(xx[0]);
		      var b = parseInt(xx[1]);
			  var c = parseInt(xx[2]);
			  
			  var right_now = new Date();
		      var yy = parseInt(right_now.getYear());   
			 // var mm = parseInt(right_now.getMonth()+1);
			  var mm = parseInt(right_now.getMonth());
			  var dd = parseInt(right_now.getDate()); 
		  	 
				if (c<yy)
				   {
				   alert("??????????????????????????????????????????");
				   document.webForm.start_date.focus();           
				   return false;
				/*   }
				else
				  { 
				   if (a<mm)
				 	 {
					   alert("?????????????????????????????????????????????");
					   document.webForm.start_date.focus();           
					   return false;
					 }
					else
					 {
					  if (b<dd)
						{
						   alert("???????????????????????????????????????????");
						   document.webForm.start_date.focus();           
						   return false;
						 }								 
					 }	*/
				 } 
						   
				if ( v1.length==0)
				   {
				   alert("????????????????");
				   document.webForm.com_data.focus();           
				   return false;
				   }
				else if ( v2.length==0)
				   {
				   alert("?????????????????????????");
				   document.webForm.ty_inform.focus();           
				   return false;
				   }
				else if ( v3.length==0)
				   {
				   alert("???????????????????????");
				   document.webForm.start_date.focus();           
				   return false;
				   }
				else if ( v4.length==0)
				   {
				   alert("??????????????????????");
				   document.webForm.cartype.focus();           
				   return false;
				   }
				else if ( v5.length==0)
				   {
				   alert("??????????????????????");
				   document.webForm.car_id.focus();           
				   return false;
				   }
				   else if ( v6.length==0)
				   {
				   alert("?????????????????");
				   document.webForm.cat_car.focus();           
				   return false;
				   }
				   else if ( v7.length==0)
				   {
				   alert("?????????????????");
				   document.webForm.br_car.focus();           
				   return false;
				   }
				   else if ( v8.length==0)
				   {
				   alert("???????????????");
				   document.webForm.mo_car.focus();           
				   return false;
				   }
				   else if ( v9.length==0)
				   {
				   alert("???????????????");
				   document.webForm.car_cc.focus();           
				   return false;
				   }	
				   else if ( v10.length==0)
				   {
				   alert("??????????????????");
				   document.webForm.car_wgt.focus();           
				   return false;
				   }
				   else if ( v11.length==0)
				   {
				   alert("?????????????????????");
				   document.webForm.car_seat.focus();           
				   return false;
				   }
				   else if ( v12.length==0)
				   {
				   alert("??????????????????????");
				   document.webForm.gear.focus();           
				   return false;
				   }
				   else if ( v13.length==0)
				   {
				   alert("????????????????");
				   document.webForm.car_body.focus();           
				   return false;
				   }
				   else if ( v14.length==0)
				   {
				   alert("??????????????????");
				   document.webForm.n_motor.focus();           
				   return false;
				   }
				   else if ( v15.length==0)
				   {
				   alert("????????????????????????");
				   document.webForm.car_regis_pro.focus();           
				   return false;
				   }
				   else if ( v16.length==0)
				   {
				   alert("?????????????????????");
				   document.webForm.regis_date.focus();           
				   return false;
				   }		
				   else if ( title.length==0)
				   {
				   alert("????????????????????????????????????");
				   document.webForm.title.focus();           
				   return false;
				   }	
				   else if ( name.length==0)
				   {
				   alert("?????????????????????????");
				   document.webForm.name.focus();           
				   return false;
				   }	
				   else if ( last.length==0)
				   {
				   alert("??????????????????????????????");
				   document.webForm.last.focus();           
				   return false;
				   }	
				   else if ( add.length==0)
				   {
				   alert("?????????????????????????????????");
				   document.webForm.add.focus();           
				   return false;
				   }
				   else if ( road.length==0)
				   {
				   alert("???????????");
				   document.webForm.road.focus();           
				   return false;
				   }
				   else if ( tel_mobi.length==0)
				   {
				   alert("?????????????????????????????????????????");
				   document.webForm.tel_mobi.focus();           
				   return false;
				   }
				   else if ( province.length==0)
				   {
				   alert("?????????????????????????????");
				   document.webForm.province.focus();           
				   return false;
				   }
				   else if ( amphur.length==0)
				   {
				   alert("????????????????????????????");
				   document.webForm.amphur.focus();           
				   return false;
				   }
				   else if ( tumbon.length==0)
				   {
				   alert("???????????????????????????");
				   document.webForm.tumbon.focus();           
				   return false;
				   }
			   else
			   {
				   return true;
				}
		}	
  function doCallAjax1(fID,fprp,fstamp,ftax,fnet) {
		  HttPRequest = false;
		  if (window.XMLHttpRequest) { // Mozilla, Safari,...
			 HttPRequest = new XMLHttpRequest();
			 if (HttPRequest.overrideMimeType) {
				HttPRequest.overrideMimeType('text/html');
			 }
		  } else if (window.ActiveXObject) { // IE
			 try {
				HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
			 } catch (e) {
				try {
				   HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {}
			 }
		  } 
		  
		  if (!HttPRequest) {
			 alert('Cannot create XMLHTTP instance');
			 return false;
		  }

		  var url = 'AjaxGetFill.php';
		  var pmeters = "tID=" + encodeURI( document.getElementById(fID).value);

			HttPRequest.open('POST',url,true);

			HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			HttPRequest.setRequestHeader("Content-length", pmeters.length);
			HttPRequest.setRequestHeader("Connection", "close");
			HttPRequest.send(pmeters);
			
			
			HttPRequest.onreadystatechange = function()
			{

				//if(HttPRequest.readyState == 3)  // Loading Request
				//{
					//document.getElementById(fProductName).innerHTML = "..";
				//}

				if(HttPRequest.readyState == 4) // Return Request
				{
					var myProduct = HttPRequest.responseText;
					if(myProduct != "")
					{
						var myArr = myProduct.split("|");
						document.getElementById(fprp).value = myArr[0];
						document.getElementById(fstamp).value = myArr[1];
						document.getElementById(ftax).value = myArr[2];
						document.getElementById(fnet).value = myArr[3];
					}
				}
				
			}

	   }