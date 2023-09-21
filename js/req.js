$('#add_pre_at').iMask({ type: 'number' });

$('#req').keypress(function(e) {
    if (e.which == 13) {
        var r = confirm("คุณต้องการบันทึกสลักหลังใช่หรือไม่");
        if (r == true) {
            $("#Save_req").click();
            return false;
        } else {
            return false;
        }

    }
});

$("#finance_add_tun").change(function() {
    if ($("#finance_add_tun").val() == "N" || $("#finance_add_tun").val() == "0") {
        $("#finance_add_tun_price").val('0.00');
    }

    var mo_car = $("#Editmo").val();
    var car_type = $("#Edittype").val();
    var finance_add_tun = $("#finance_add_tun").val();

    $.ajax(options3);
    var options3 = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_More.php",
        data: {
            callajax: 'FI_MORE',
            Fi_mo_car: mo_car,
            Fi_car_type: car_type,
            Fi_add_tun: finance_add_tun,
            mo_car_sub: $("#mo_car_sub").val()
        },
        success: function(msg) {
            var returnedArray = msg;
            if (returnedArray != null) {
                $("#finance_add_tun_price").val(addCommas(returnedArray.Fi_price));
            } else {
                return false;
            }
        }
    };
    $.ajax(options3);
});

$(document).ready(function() {
    if ($("#MORETUN").val() != '') {
        var MORETUN = $("#MORETUN").val();
        var new_moretun = MORETUN.split(',');
        var new_moretun_2 = new_moretun[1];

        $.ajax(options4);
        var options4 = {
            type: "POST",
            dataType: "json",
            url: "ajax/Ajax_More.php",
            data: {
                callajax: 'MORE_TUN',
                new_moretun: new_moretun_2,
                mo_car_sub: $("#mo_car_sub").val()
            },
            success: function(msg) {
                var returnedArray = msg;
                finance_add_tun = $("#finance_add_tun");
                if (returnedArray != null) {
                    finance_add_tun.val(parseInt(returnedArray.namecost)).change();
                    $("#finance_add_tun_price").val(addCommas(returnedArray.price_cost));
                } else {
                    return false;
                }
            }
        };
        $.ajax(options4);
    }
});

if ($("#MOREAJAX").val() != '') {
    var CALLMORE = {
        type: "POST",
        dataType: "json",

        url: "ajax/Ajax_More.php",
        data: {
            callajax: 'MOREMORE',
            cartype: $("#Edittype").val(),
            mo_car: $("#Editmo").val(),
            mo_car_sub: $("#mo_car_sub").val()
        },

        success: function(msg) {
            var status_free = '';
            var sTatus = $("#MOREAJAX").val();
            var sTatusSplit = sTatus.split('|');
            var returnedArray = msg;
            for (reflex = 0; reflex < sTatusSplit.length; reflex++) {
                $('#COUNTMORE').val(Number($('#COUNTMORE').val()) + 1);
                $('#MORE_ADD').append('<tr id="tr' + reflex + '" bgcolor=""><td width="10%"></td><td width="25%"><select onchange="callcost(' + reflex + ',this.value);" name="id_acc' + reflex + '" id="id_acc' + reflex + '" ><option value="0" selected="selected">--กรุณาเลือกอุปกรณ์--</option></select></td><td width="25%" align="center"><select  onchange="splitcost(' + reflex + ',this.value);" name="id_price' + reflex + '" id="id_price' + reflex + '" ><option value="0" selected="selected">--กรุณาเลือกราคาอุปกรณ์--</option></select></td><td width="20%" align="center"></td></tr>');
                status_free = '';
                var Sure = sTatusSplit[reflex].split(',');
                var Idmore = $('#id_acc' + reflex);
                var Price = $('#id_price' + reflex);
                if (returnedArray != null) {

                    for (i = 0; i < returnedArray.length; i++) {
                        if (returnedArray[i].id != undefined) {
                            Idmore.append("<option value='" + returnedArray[i].id + "'>" + returnedArray[i].name + "</option>");
                        }
                        if (returnedArray[i].idcost != undefined) {
                            if (returnedArray[i].namecost == 'ต่ำกว่า 10,000' && reflex == 0 && returnedArray[i].idcost == Sure[1]) {
                                Price.append("<option value='" + returnedArray[i].idcost + "'>ฟรี</option>");
                                status_free = 'Y';
                            } else {
                                if (returnedArray[i].namecost != 'ต่ำกว่า 10,000' && status_free != 'Y') {
                                    Price.append("<option value='" + returnedArray[i].idcost + "'>" + addCommas(returnedArray[i].namecost) + "</option>");
                                }
                            }
                        }
                    }
                    if (Sure[0] == '180' || Sure[0] == '182') {
                        Price.empty();
                        Price.append("<option value='1538'>0</option>");

                    }


                    Idmore.val(Sure[0]);
                    Price.val(Sure[1]);
                    splitcost(reflex, Sure[1])
                    TotalCOSTplus();

                } else {
                    return false;
                }
            }
        }
    };
    $.ajax(CALLMORE);
    $('#COUNTMORE').val(Number($('#COUNTMORE').val()) + 1);
}


//----------------------สลักหลังเปลี่ยนแปลงวันคุ้มครอง----------------------///
$('#EditTime').click(function() {
    if ($('#EditTime').is(':checked')) {
        $("#ShowEditTime").show('slow');
        $(function() {
            var myDate = new Date();
            var prettyDate = myDate.getDate() + '/' + (myDate.getMonth() + 1) + '/' + myDate.getFullYear();
            $("#EditTimeStartDate").datepicker({
                format: "dd/mm/yyyy",
                startDate: "today",
                language: "th",
                autoclose: true
            }).val();
        });
    } else {
        $("#ShowEditTime").hide('slow');
    }
});

//----------------------สลักหลังข้อมูลรถยนต์----------------------///
$('#EditCar').click(function() {
    if ($('#EditCar').is(':checked')) {
        $("#ShowEditCar").show('slow');
    } else {
        $("#ShowEditCar").hide('slow');
    }
});

//----------------------สลักหลังเพิ่มทุน---------------------///
$('#Edit_addTun').click(function() {
    if ($('#Edit_addTun').is(':checked')) {
        $("#ShowEdit_addTun").show('slow');
    } else {
        $("#ShowEdit_addTun").hide('slow');
    }
});

//----------------------สลักหลัง อท. 220/230---------------------///
$('#Edit_addAT').click(function() {
    if ($('#Edit_addAT').is(':checked')) {
        $("#ShowEdit_addAT").show('slow');
    } else {
        $("#ShowEdit_addAT").hide('slow');
    }
});

//----------------------สลักหลังเลขที่ พ.ร.บ.---------------------///
$('#EditAct').click(function() {
    if ($('#EditAct').is(':checked')) {
        $("#ShowEditAct").show('slow');
    } else {
        $("#ShowEditAct").hide('slow');
    }
});

//----------------------สลักหลังที่อยู่ในการจัดส่งเอกสาร---------------------///
$('#EditSendAdd').click(function() {
    if ($('#EditSendAdd').is(':checked')) {
        $("#ShowEditSendAdd").show('slow');
        $("#NewAdd1").click(function() {
            $("#ShowNewAdd").hide('slow');
        });
        $("#NewAdd2").click(function() {
            $("#ShowNewAdd").show('slow');
        });
    } else {
        $("#ShowEditSendAdd").hide('slow');
    }
});



//----------------------สลักหลังข้อมูลผู้เอาประกันภัย----------------------///
$('#EditCustomer').click(function() {
    if ($('#EditCustomer').is(':checked')) {
        $("#ShowEditCustomer").show('slow');

        if ($("#perSo").val() == 1) {
            $("#EditPerson").attr('checked', true);
        } else if ($("#perSo").val() == 2) {
            $("#EditPersons").attr('checked', true);
        } else {
            $("#EditPersonss").attr('checked', true);
        }

        var options2 = {
            type: "POST",
            dataType: "json",

            url: "ajax/Ajax_EditPro.php",
            data: { Cus_callajax: 'START1' },

            success: function(msg) {

                var returnedArray = msg;
                cartype = $("#Cus_province");
                cartype.append("<option value='0'>กรุณาเลือก</option>");
                if (returnedArray != null) {
                    for (i = 0; i < returnedArray.length; i++) {
                        cartype.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                    }
                    $("#Cus_province").val($("#aa").val());
                } else {
                    return false;
                }
            }
        };
        $.ajax(options2);

        $("#Cus_province").change(function() {

            $("#Cus_tumbon").empty();
            $("#aa").val($("#Cus_province").val());
            $("#Cus_tumbon").append("<option value='0'>กรุณาเลือก</option>");
            $("#Cus_postal").empty();
            $("#Cus_postal").append("<option value='0'>กรุณาเลือก</option>");
            var _selected = $("#Cus_province").val();
            var options = {
                type: "POST",
                dataType: "json",

                url: "ajax/Ajax_EditPro.php",
                data: {
                    Cus_callajax: 'AMPHUR',
                    Cus_province: _selected
                },
                success: function(msg) {
                    $('#Cus_amphur').empty();
                    var returnedArray = msg;
                    state = $("#Cus_amphur");
                    state.append("<option value='0'>กรุณาเลือก</option>");
                    if (returnedArray != null) {
                        for (var i = 0; i < returnedArray.length; ++i) {
                            state.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                        }
                    } else {
                        return false;
                    }
                }
            };
            $.ajax(options);
        });

        $("#Cus_amphur").change(function() {
            $("#Cus_postal").empty();
            $("#Cus_postal").append("<option value='0'>กรุณาเลือก</option>");
            var _selected = $("#Cus_amphur").val();
            var options = {
                type: "POST",
                dataType: "json",

                url: "ajax/Ajax_EditPro.php",
                data: {
                    Cus_callajax: 'TUMBON',
                    Cus_amphur: _selected
                },
                success: function(msg) {
                    $('#Cus_tumbon').empty();
                    var returnedArray = msg;
                    state = $("#Cus_tumbon");
                    state.append("<option value='0'>กรุณาเลือก</option>");
                    if (returnedArray != null) {
                        for (var i = 0; i < returnedArray.length; ++i) {
                            state.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                        }
                    } else {
                        return false;
                    }
                }
            };
            $.ajax(options);
        });

        $("#Cus_tumbon").change(function() {
            var _selected = $("#Cus_tumbon").val();
            var options = {
                type: "POST",
                dataType: "json",

                url: "ajax/Ajax_EditPro.php",
                data: {
                    Cus_callajax: 'POST',
                    Cus_tumbon: _selected
                },
                success: function(msg) {
                    $('#Cus_postal').empty();
                    var returnedArray = msg;
                    state = $("#Cus_postal");
                    if (returnedArray != null) {
                        for (var i = 0; i < returnedArray.length; ++i) {
                            state.append("<option value='" + returnedArray[i].Name + "'>" + returnedArray[i].Name + "</option>");
                        }
                    } else {
                        return false;
                    }
                }
            };
            $.ajax(options);
        });

    } else {
        $("#ShowEditCustomer").hide('slow');
    }
});

//----------------------สลักหลัง ADDON----------------------///
$('#EditAddon').click(function() {
    if ($('#EditAddon').is(':checked')) {
        $("#ShowEditAddon").show('slow');
    } else {
        $("#ShowEditAddon").hide('slow');
    }
});

//----------------------สลักหลังผู้รับผลประโยชน์----------------------///
$('#EditHr').click(function() {
    if ($('#EditHr').is(':checked')) {
        $("#ShowEditHr").show('slow');
    } else {
        $("#ShowEditHr").hide('slow');
    }
});

//----------------------สลักหลังการออกใบเสร็จ---------------------///
$('#EditReceipt').click(function() {
    if ($('#EditReceipt').is(':checked')) {
        $("#ShowEditReceipt").show('slow');
    } else {
        $("#ShowEditReceipt").hide('slow');
    }
});


//------------------สลักหลังอัตราเบี้ย---------------------///
$('#EditCost').click(function() {
    if ($('#EditCost').is(':checked')) {
        $("#ShowEditCost").show('slow');
        /*var optionsCost1 = {
        	
        		 type: "POST",
        		 dataType: "json",
        		 url: "ajax/Ajax_EditCost.php",
        		 data: {Editcallajax:'COST',
        		 id_mo_car:$("#id_mo_car").val(),
        		 id_gear:$("#id_gear").val(),
        		 com_data:$("#comp_cost").val()
        		 },
        		 
        		 success: function(msg) {
				
        			 var returnedArray = msg;
        			 EditcostCost = $("#EditcostCost");
        			// EditcostCost.append("<option value='0'>กรุณาเลือก</option>");
        			if(returnedArray!=null){
        				 for (i = 0; i < returnedArray.length; i++) {
        				  EditcostCost.append("<option value='" + returnedArray[i].id + "'>" + returnedArray[i].cost + "</option>");
        			 	 }
        			 EditcostCost.val($("#id_costCost").val());
        			 var _selected = $("#EditcostCost").val();
        				 var optionscost = {
        					 type: "POST",
        					 dataType: "json",
        					 url: "ajax/Ajax_EditCost.php",
        					 data: {callajax:'PRICE',
        					 idcost:_selected,
        					 },
        					 success: function(msg) {
        						 var returnedArray = msg;
        						if(returnedArray!=null){
        							  $("#EditcostPre").val(returnedArray.pre);
        							  $("#EditcostStamp").val(returnedArray.stamp);
        							  $("#EditcostTax").val(returnedArray.tax);
        							  $("#EditcostNet").val(returnedArray.net);
        						 }
        						 else{
        							 return false;
        						 }
        					 }
        				 };
        				 $.ajax(optionscost);
        			}
        			else{
        				return false;
        			}
        		 }
        	 };
        	 $.ajax(optionsCost1);
        	 
        	 
        $("#EditcostCost").change(function(){
        		var _selected = $("#EditcostCost").val();						   
        		$("#EditcostPre").val('0.00');
        		$("#EditcostStamp").val('0.00');
        		$("#EditcostTax").val('0.00');
        		$("#EditcostNet").val('0.00');
        		 
        		 var optionsCostChose = 
        		 {
        			 type: "POST",
        			 dataType: "json",
        			 url: "ajax/Ajax_EditCost.php",
        			 data: {
        			 Editcallajax:'PRICE',
        			 EditcostCost:_selected
        			 },
        			 success: function(msg) {
        				 var returnedArray = msg;
        				 if(returnedArray!=null){
        					  $("#EditcostPre").val(returnedArray.pre);
        					  $("#EditcostStamp").val(returnedArray.stamp);
        					  $("#EditcostTax").val(returnedArray.tax);
        					  $("#EditcostNet").val(returnedArray.net);
        				 }
        				 else{
        				 return false;
        				 }
        			 }
        		 };
        		 $.ajax(optionsCostChose);
        });*/
    } else {
        $("#ShowEditCost").hide('slow');
    }
});
//--------------------Save สลักหลัง-----------------------///
$("#Save_req").click(function() {
    $('#Save_req').css("display", "none");
    $('#Save_reqCLOSE').css("display", "");
    if (document.getElementById('EditPerson').checked) {
        var valPerson = 1;
    } else if (document.getElementById('EditPersons').checked) {
        var valPerson = 2;
    } else {
        var valPerson = 3;
    }

    var DATA = $('#req').serialize();
    var SAVEREQ = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_req.php?valPerson=" + valPerson,
        data: DATA,
        success: function(msg) {
            var returnedArray = msg;
            if (returnedArray.msg == 'Y') {
                $("#closed").click();
                alert('ยกเลิกกรมธรรม์เรียบร้อยแล้ว');
                $(".modal").hide();
                $(".modal-backdrop").hide();
                $(".modal").removeData('modal');
                //location.href = '#load_CheckCancel|1|send_CheckCancel?'+returnedArray.id;
                //return false;
            } else {
                if (returnedArray.Re_req == '1') {
                    $("#closed").click();
                    alert('บันทึกข้อมูลการสลักหลังเรียบร้อย');
                    $(".modal").hide();
                    $(".modal-backdrop").hide();
                    $(".modal").removeData('modal');
                    //location.href = '#load_Attached|1|send_Check?'+returnedArray.id;
                    //return false;
                } else {
                    $("#closed").click();
                    alert('บันทึกข้อมูลการสลักหลังเรียบร้อย');
                    $(".modal").hide();
                    $(".modal-backdrop").hide();
                    $(".modal").removeData('modal');
                    //location.href = '#load_CheckAttached|1|send_Check?'+returnedArray.id;
                    //return false;
                }
            }
            $('#Save_req').css("display", "");
            $('#Save_reqCLOSE').css("display", "none");
            return false;
        },
        error: function(msg) {
            var returnedArray = msg;
            alert('การบันทึกสลักหลังผิดพลาด');
            $('#Save_req').css("display", "");
            $('#Save_reqCLOSE').css("display", "none");
        }
    };
    $.ajax(SAVEREQ);
});


$("#Save_reqCancel").click(function() {
    $('#Save_req').css("display", "none");
    $('#Save_reqCLOSE').css("display", "");
    if ($("#Cancel_Detail").val() == '') {
        $("#Cancel_Detail").focus();
        alert('กรุณากรอกรายละเอียดการยกเลิกกรมธรรม์');
        return false;
    }
    //if(document.getElementById('EditPerson').checked){
    var valPerson = 1;
    //}
    //else if(document.getElementById('EditPersons').checked){
    //var valPerson = 2;
    //}
    //else
    //{
    //	 var valPerson = 3;
    //}
    var DATA = $('#req').serialize();
    var SAVEREQ = {
        type: "POST",
        dataType: "json",

        url: "ajax/Ajax_req.php?valPerson=" + valPerson,
        data: DATA,
        success: function(msg) {
            var returnedArray = msg;
            if (returnedArray.msg == 'Y') {
                $("#closed").click();
                alert('ยกเลิกกรมธรรม์เรียบร้อยแล้ว');
                $(".modal").hide();
                $(".modal-backdrop").hide();
                $(".modal").removeData('modal');
                $('#page-content').load("pages/load_CheckCancel.php");
                //location.href = '#load_CheckCancel|1|send_CheckCancel?'+returnedArray.id;
                //return false;
            } else {
                if (returnedArray.Re_req == '1') {
                    $("#closed").click();
                    alert('บันทึกข้อมูลการสลักหลังเรียบร้อย');
                    $(".modal").hide();
                    $(".modal-backdrop").hide();
                    $(".modal").removeData('modal');
                    $('#page-content').load("pages/load_Attached.php");
                    //location.href = '#load_Attached|1|send_Check?'+returnedArray.id;
                    //return false;
                } else {
                    $("#closed").click();
                    alert('บันทึกข้อมูลการสลักหลังเรียบร้อย');
                    $(".modal").hide();
                    $(".modal-backdrop").hide();
                    $(".modal").removeData('modal');
                    $('#page-content').load("pages/load_Attached.php");
                    //location.href = '#load_CheckAttached|1|send_Check?'+returnedArray.id;
                    //return false;
                }
            }
            $('#Save_req').css("display", "");
            $('#Save_reqCLOSE').css("display", "none");
            return false;
        },
        error: function(msg) {
            var returnedArray = msg;
            alert('การบันทึกสลักหลังผิดพลาด');
            $('#Save_req').css("display", "");
            $('#Save_reqCLOSE').css("display", "none");
        }
    };
    var id_can = $('#EditId_data').val();

    var now = new Date();

    if (confirm('เลขรับแจ้ง ' + id_can + ' จะถูกยกเลิกความคุ้มครองในทันที คุณแน่ใจหรือไม่ ')) {
        $.ajax(SAVEREQ);
    } else {
        return false;
    }
});


//----------------------สลักหลังอุปกรณ์ตกแต่ง----------------------///
$('#EditProduct').click(function() {
    if ($('#EditProduct').is(':checked')) {
        $("#ShowEditProduct").show('slow');
    } else {
        $("#ShowEditProduct").hide('slow');
    }
});

$('#ADDTABLE').click(function() {
    var COUNTMORE = $("#COUNTMORE").val() - 1;

    if ($("#id_acc" + COUNTMORE).val() == '0') {
        alert("กรุณาเลือกอุปกรณ์ตกแต่งก่อนเพิ่มอุปกรณ์ตกแต่งด้วยครับ");
        $("#id_acc" + COUNTMORE).focus();
        return false;
    }
    if ($("#id_price" + COUNTMORE).val() == '0') {
        alert("กรุณาเลือกราคาทุนอุปกรณ์ก่อนเพิ่มอุปกรณ์ตกแต่งด้วยครับ");
        $("#id_price" + COUNTMORE).focus();
        return false;
    }
    var COL = '#CCCCCC';
    var NUMBER = $('#COUNTMORE').val();
    if (NUMBER < 14) {
        $('#MORE_ADD').append('<tr id="tr' + NUMBER + '" bgcolor="' + COL + '"><td width="10%"></td><td width="25%"><select onchange="callcost(' + NUMBER + ',this.value);" name="id_acc' + NUMBER + '" id="id_acc' + NUMBER + '" ></select></td><td width="25%" align="center"><select  onchange="splitcost(' + NUMBER + ',this.value);" name="id_price' + NUMBER + '" id="id_price' + NUMBER + '" ><option value="0" selected="selected">--กรุณาเลือกราคาอุปกรณ์--</option></select></td><td width="20%" align="center"></td></tr>');
        //อันเก่าจ้า :(				
        /*var CALLMORE = {
        	 type: "POST",
        	 dataType: "json",				 
        	 url: "ajax/Ajax_More.php",
        	 data: {
        		 callajax:'MORE_NEW',
        	 	cartype:$("#Edittype").val(),
        		mo_car:$("#Editmo").val(),
        		countmore:$('#COUNTMORE').val(),
        		mo_car_sub:$("#mo_car_sub").val()
        	 },
        	success: function(msg)
        	{
        		var returnedArray = msg;
        		var TRADD = $('#id_acc'+NUMBER);
		

        	TRADD.append('<option value="0" selected="selected">--กรุณาเลือกอุปกรณ์--</option>');

        		if(returnedArray!=null)
        		{
        			for (i = 0; i < returnedArray.length; i++) 
        			{
        				TRADD.append("<option value='" + returnedArray[i].id + "'>" + returnedArray[i].name + "</option>");
        			}
        		}
        		else
        		{
        			return false;
        		}
        		
        	}
        };*/
        //อันใหม่จ้า :)
        var CALLMORE = {
            type: "POST",
            dataType: "json",
            url: "ajax/Ajax_More.php",
            data: {
                callajax: 'MORE_NEW',
                cartype: $("#Edittype").val(),
                mo_car: $("#Editmo").val(),
                countmore: $('#COUNTMORE').val(),
                mo_car_sub: $("#mo_car_sub").val()
            },

            success: function(msg) {
                var returnedArray = msg;
                var TRADD = $('#id_acc' + NUMBER);
                if (returnedArray != null) {
                    TRADD.html(returnedArray.html_acc);
                    $('#id_acc' + NUMBER).attr('style', 'width:500px;');
                    $('#id_acc' + NUMBER).select2();

                    $('.select2-choice').attr('style', 'width:500px;');
                } else {
                    return false;
                }
            }
        };
        $.ajax(CALLMORE);
        $('#COUNTMORE').val(Number(NUMBER) + 1);
    } else {
        alert('คุณไม่สามารถเพิ่มอุปกรณ์ได้อีก');
    }
});

$('#moreclose').click(function() {
    var num = Number($('#COUNTMORE').val()) - 1
    CHOSE = "#tr" + num.toString();
    $(CHOSE).remove();
    $('#COUNTMORE').val(num);

    TotalCOSTplus();
    TotalTEXTplus();
    if ($('#COUNTMORE').val() == '0') {
        $("#ADDTABLE").trigger('click');
    }
});

function callcost(data, costval) {
    if (costval != 0) {
        $('#price_acc' + data).val(0);
        var _select = costval.split('|');
        var CALLCOST = {
            type: "POST",
            dataType: "json",

            url: "ajax/Ajax_More.php",
            data: {
                callajax: 'COST_NEW',
                cartype: $("#Edittype").val(),
                countmore: $('#COUNTMORE').val(),
                type: _select[1],
                id_acc: costval,
                mo_car: $("#Editmo").val(),
                mo_car_sub: $("#mo_car_sub").val()
            },
            success: function(msg) {

                var returnedArray = msg;
                var PRICE = $('#id_price' + data);
                var AD = $('#id_acc' + data + ' option:selected');
                PRICE.empty();
                if (returnedArray[0].status_free != 'Y') {
                    PRICE.append('<option value="0" selected="selected">--กรุณาเลือกราคาอุปกรณ์--</option>');
                }
                if (returnedArray != null) {
                    if (AD.text() == 'Upgrade Mitsubishi V premium') {
                        PRICE.append("<option value='1538'>0</option>");
                        PRICE.val('1538');
                    } else {
                        for (i = 0; i < returnedArray.length; i++) {
                            PRICE.append("<option value='" + returnedArray[i].id + "'>" + returnedArray[i].name + "</option>");
                        }
                    }

                } else {
                    return false;
                }
            }
        };
        $.ajax(CALLCOST);
        TotalCOSTplus();
        TotalTEXTplus();
    } else {
        $('#id_price' + data).empty();
        $('#id_price' + data).append('<option value="0" selected="selected">--กรุณาเลือกราคาอุปกรณ์--</option>');
        $('#price_acc' + data).val(0);
        TotalCOSTplus();
        TotalTEXTplus();
    }
}

function splitcost(data, costval) {
    TotalCOSTplus(data);
    var textchose = $("#price_acc_cost").val();
    var textsplit = textchose.split(',')
    var costChose = 0.00;
    for (i = 1; i < textchose.length; i++) {
        var costChose = costChose + textsplit[i]
    }
    TotalTEXTplus();
}


function TotalCOSTplus(id) {
    var TotalCOST = {
        type: "POST",
        dataType: "json",

        url: "ajax/Ajax_More.php",
        data: {
            callajax: 'TOTAL',
            cartype: $("#Edittype").val(),
            mo_car: $("#Editmo").val(),
            mo_car_sub: $("#mo_car_sub").val()
        },
        success: function(msg) {

            var returnedArray = msg;
            if (returnedArray != null) {
                var textTun = 0;
                var textTunCap = 0;
                var textCostCap = 0;
                var CostNormal = 0;
                var checkLowCost = 0;
                var upgrade = 0;
                for (i = 0; i < 14; i++) {

                    if ($('#id_acc' + i).val() != undefined) {
                        if ($('#id_price' + i).val() != 0 || $('#id_acc' + i + ' option:selected').text() == 'Upgrade Mitsubishi V premium') {
                            FixCost = $('#id_price' + i).val();
                            var sumCost = 0;
                            if ($('#id_acc' + i + ' option:selected').text() == 'Upgrade Mitsubishi V premium') {
                                upgrade = Number(upgrade) + Number(3000);
                                sumCost = 0;

                            } else {
                                sumCost = returnedArray[FixCost].name;
                            }
                            // if($('#id_acc'+i).val()!=14){
                            textTun = Number(textTun) + Number(sumCost);

                            //}
                            // else
                            //{
                            // textCostCap = Number(textCostCap)+Number(returnedArray[FixCost].price2);
                            //textTunCap = Number(textTunCap)+Number(returnedArray[FixCost].name);
                            //}
                        }
                        if ($('#id_price' + i + ' option:selected').text() == 'ต่ำกว่า 10,000') {
                            checkLowCost = Number(checkLowCost) + 1;
                        }
                    }

                }

                var countauto = 1;
                var Costauto = 0;
                //					if($("#Edittype").val()==1){
                //						var Limit = 120000;
                //					}
                //					else if($("#Edittype").val()==3){
                //						var Limit = 140000;
                //					}
                if ($("#Edittype").val() == 1) {
                    var Limit = 150000;
                } else if ($("#Edittype").val() == 3) {
                    var Limit = 150000;
                } else if ($("#Edittype").val() == 2) {
                    var Limit = 140000;
                }
                while (Costauto != 1 && textTun != 0 && textTun <= Limit) {
                    if (returnedArray[countauto] != undefined) {
                        if (textTun + '.00' == returnedArray[countauto].name) {
                            CostNormal = returnedArray[countauto].price;
                            Costauto++;
                        }
                    }
                    countauto++;
                }
                $("#price_acc_cost").val(addCommas(Number(CostNormal) + Number(textCostCap) + Number(upgrade)));
                $("#price_acc_tun").val(addCommas(Number(textTun) + Number(textTunCap)));

                var CheckCOST = $("#price_acc_tun").val();
                var ScheckCOST = CheckCOST.split(',');
                if (ScheckCOST[0] + ScheckCOST[1] > Limit) {
                    $("#id_price" + id).val(0);
                    alert('คุณไม่สามารถเพิ่มทุนได้มากกว่า ' + addCommas(Limit) + ' บาท');
                    TotalCOSTplus(id);
                }
                if (checkLowCost > 1) {
                    alert('ท่านเลือกทุน ต่ำกว่า 10,000 ได้เพียง 1 รายการ ');
                    $("#id_price" + id).val(0);

                }

            } else {
                return false;
            }
        }
    };
    $.ajax(TotalCOST);
}


function TotalTEXTplus() {
    var textsave = '';
    for (i = 0; i < 14; i++) {
        if ($('#id_acc' + i).val() != undefined) {
            if (i == 0) {
                textsave = textsave + $('#id_acc' + i).val() + ',' + $('#id_price' + i).val();
            } else {
                textsave = textsave + '|' + $('#id_acc' + i).val() + ',' + $('#id_price' + i).val();
            }
        }
    }
    $("#acc").val(textsave);
}

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}