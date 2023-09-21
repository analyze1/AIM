$(document).ready(function() {

    var CallCartype = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_CarF.php",
        data: { callajax: 'START1' },

        success: function(msg) {

            var returnedArray = msg;
            cartype = $("#cartype");
            if (returnedArray != null) {
                for (i = 0; i < returnedArray.length; i++) {
                    cartype.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                }
            } else {
                return false;
            }
        }
    };
    $.ajax(CallCartype);

    var CallProv = {
        type: "POST", //คือการรับค่า
        dataType: "json",
        url: "ajax/Ajax_Pro.php",
        data: { callajax: 'START1' },

        success: function(msg) {

            var returnedArray = msg;
            Carprov = $("#province");
            car_regis_pro = $("#car_regis_pro");
            Carprov.append("<option value='0'>กรุณาเลือก</option>");
            car_regis_pro.append("<option value='0'>กรุณาเลือก</option>");
            if (returnedArray != null) {
                for (i = 0; i < returnedArray.length; i++) {
                    Carprov.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                    car_regis_pro.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                }
            } else {
                return false;
            }
        }
    };
    $.ajax(CallProv);


    $('#pageSearch').hide('fast');
    $('form').attr('autocomplete', 'off');



    $('#Insurance').keypress(function(e) {
        if (e.which == 13) { SaveI(); return false; }
    });
    $('#person').click(function() {
        if ($('#person').is(':checked')) {
            $("#icardTEXT").html(' * (กรุณากรอกเฉพาะตัวเลขบัตรประชาชน 13 หลัก)');
            $('#icard').val('');
        }
    });
    $('#persons').click(function() {
        if ($('#persons').is(':checked')) {
            $("#icardTEXT").html(' * (กรุณากรอกเฉพาะตัวเลขทะเบียนนิติบุคคล 13 หลัก)');
            $('#icard').val('');
        }
    });

    function checkID(id) {
        if (id.length != 13) return false;
        for (i = 0, sum = 0; i < 12; i++)
            sum += parseFloat(id.charAt(i)) * (13 - i);
        if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12)))
            return false;
        return true;
    }

    $('#icard').blur(function() {
        if ($('#icard').val() != '') {
            if ($('#person').is(':checked')) {
                if (!checkID($('#icard').val())) {
                    alert('รหัสประชาชนไม่ถูกต้อง');
                    $('#icard').val('');
                }
            }
        }
    });

    /* $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    เพิ่มอุปกรณ์
    */
    $('#ADDTABLE').click(function() {
        var COL = '#CCCCCC';
        var NUMBER = $('#COUNTMORE').val();
        if (NUMBER < 14) {
            $('#MORE_ADD').append('<tr id="tr' + NUMBER + '" bgcolor="' + COL + '"><td width="10%"></td><td width="25%"><select onchange="callcost(' + NUMBER + ',this.value);" name="id_acc' + NUMBER + '" id="id_acc' + NUMBER + '" ><option value="0" selected="selected">--กรุณาเลือกอุปกรณ์--</option></select></td><td width="25%" align="center"><select  onchange="splitcost(' + NUMBER + ',this.value);" name="id_price' + NUMBER + '" id="id_price' + NUMBER + '" ><option value="0" selected="selected">--กรุณาเลือกราคาอุปกรณ์--</option></select></td><td width="20%" align="center"></td></tr>');

            var CALLMORE = {
                type: "POST",
                dataType: "json",
                url: "ajax/Ajax_More.php",
                data: {
                    callajax: 'MORE',
                    cartype: $("#cartype").val(),
                    mo_car: $("#mo_car").val()
                },

                success: function(msg) {
                    var returnedArray = msg;
                    var TRADD = $('#id_acc' + NUMBER);
                    if (returnedArray != null) {
                        for (i = 0; i < returnedArray.length; i++) {
                            TRADD.append("<option value='" + returnedArray[i].id + "'>" + returnedArray[i].name + "</option>");
                        }
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
    /* $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    ลบอุปกรณ์
    */
    $('#moreclose').click(function() {
        var num = Number($('#COUNTMORE').val()) - 1

        CHOSE = "#tr" + num.toString();
        $(CHOSE).remove();
        $('#COUNTMORE').val(num);

        TotalCOSTplus();
        TotalTEXTplus();
    });

    $('BcloseIn').click(function() {
        $('#Insurance').reset();
    });

    $("#car_id").change(function() {
        var _selected = $("#cartype").val();
        var _selected2 = $("#car_id").val();
        var CallAct = {
            type: "POST",
            dataType: "json",
            url: "ajax/Ajax_Prp.php",
            data: {
                idprp: _selected,
                id_car: _selected2
            },
            success: function(msg) {
                $('#id_prp').empty();
                $('#txtstamp1').val('0.00');
                $('#txttax1').val('0.00');
                $('#txtnet1').val('0.00');
                var returnedArray = msg;
                id_prp = $("#id_prp");
                if (returnedArray != null) {
                    for (i = 0; i < returnedArray.length; i++) {
                        id_prp.append("<option value='" + returnedArray[i].id + "'>" + returnedArray[i].prp + "</option>");
                    }

                    $("#txtstamp1").val('0.00');
                    $("#txttax1").val('0.00');
                    $("#txtnet1").val('0.00');


                    var CallCostAct = {
                        type: "POST",
                        dataType: "json",
                        url: "ajax/Ajax_Prp.php",
                        data: {
                            idprp: _selected,
                            id_car: _selected2
                        },
                        success: function(msg) {
                            var returnedArray = msg;
                            txtstamp1 = $("#txtstamp1");
                            txttax1 = $("#txttax1");
                            txtnet1 = $("#txtnet1");
                            if (returnedArray != null) {
                                for (i = 0; i < returnedArray.length; i++) {
                                    txtstamp1.val(returnedArray[i].stamp);
                                    txttax1.val(returnedArray[i].tax);
                                    txtnet1.val(returnedArray[i].net);
                                }
                            } else {
                                return false;
                            }
                        }
                    };
                    $.ajax(CallCostAct);

                } else {
                    return false;
                }
            }
        };
        $.ajax(CallAct);
    });
    /* $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    เลือกประเภท
    */
    //start new
    $('#searchAct').click(function() {
        var cartype = $('#cartype');
        var YearCar = $('#YearCar');
        var br_car = $('#br_car');
        var mo_car = $('#mo_car');

        if (YearCar.val() == '0') {
            alert('กรุณาเลือกปีรุ่น');
            YearCar.focus();
            return false;
        }
        if (cartype.val() == '0') {
            alert('กรุณาเลือกประเภทการใช้งาน');
            cartype.focus();
            return false;
        }
        if (br_car.val() == '0') {
            alert('กรุณาเลือกยี่ห้อรถ');
            br_car.focus();
            return false;
        }
        if (mo_car.val() == '0') {
            alert('กรุณาเลือกรุ่น');
            mo_car.focus();
            return false;
        }
        var CallAct = {
            type: "POST",
            //dataType: "json",
            url: "ajax/ajax_chkSearch.php",
            data: {
                YearCar: YearCar.val(),
                cartype: cartype.val(),
                br_car: br_car.val(),
                mo_car: mo_car.val()
            },
            success: function(msg) {
                $('#showSearch').html(msg);
            }
        };
        $.ajax(CallAct);

    });

    $("#YearCar").change(function() {
        $("#txtstamp1").val('0.00');
        $("#txttax1").val('0.00');
        $("#txtnet1").val('0.00');
        $("#id_prp").empty();
        $("#id_prp").append("<option value='0'>กรุณาเลือกเบี้ย</option>");
        $("#MORE_ADD").html('');
        $("#acc").val('');
        $("#price_acc_tun").val(0);
        $("#price_acc_cost").val(0);
        $("#COUNTMORE").val(0);
        $("#car_seat").val(0);
        $("#car_cc").val(0);
        $("#new_carbody").val('');
        $('#br_car').empty();
        $("#More").hide('slow');
        $("#More2").hide('slow');
        $("#costPre").val('0.00');
        $("#costStamp").val('0.00');
        $("#costTax").val('0.00');
        $("#costNet").val('0.00');
        $("#com_data").empty();
        $("#new_motor").val('');
        $("#eq_non").attr('checked', true);
        $("#com_data").append("<option value='0'>กรุณาเลือก</option>");
        $("#costCost").empty();
        $("#costCost").append("<option value='0'>-------------------</option>");
        var _selected = $("#cartype").val();
        var CallCarID = {
            type: "POST",
            dataType: "json",
            url: "ajax/Ajax_CarF.php",
            data: {
                callajax: 'ID_CAR',
                id_pass_car: _selected
            },
            success: function(msg) {
                $('#car_id').empty();
                var returnedArray = msg;
                car_id = $("#car_id");
                if (returnedArray != null) {
                    car_id.append("<option value='0'>กรุณาเลือก</option>");
                    for (var i = 0; i < returnedArray.length; ++i) {
                        car_id.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                    }
                    if (i == 1) {
                        car_id.val(returnedArray[0].Id);
                        var _selected = $("#cartype").val();
                        var _selected2 = $("#car_id").val();
                        var CallAct = {
                            type: "POST",
                            dataType: "json",
                            url: "ajax/Ajax_Prp.php",
                            data: {
                                idprp: _selected,
                                id_car: _selected2
                            },
                            success: function(msg) {
                                $('#id_prp').empty();
                                $('#txtstamp1').val('0.00');
                                $('#txttax1').val('0.00');
                                $('#txtnet1').val('0.00');
                                var returnedArray = msg;
                                id_prp = $("#id_prp");
                                if (returnedArray != null) {
                                    for (i = 0; i < returnedArray.length; i++) {
                                        id_prp.append("<option value='" + returnedArray[i].id + "'>" + returnedArray[i].prp + "</option>");
                                    }

                                    $("#txtstamp1").val('0.00');
                                    $("#txttax1").val('0.00');
                                    $("#txtnet1").val('0.00');


                                    var CallCostAct = {
                                        type: "POST",
                                        dataType: "json",
                                        url: "ajax/Ajax_Prp.php",
                                        data: {
                                            idprp: _selected,
                                            id_car: _selected2
                                        },
                                        success: function(msg) {
                                            var returnedArray = msg;
                                            txtstamp1 = $("#txtstamp1");
                                            txttax1 = $("#txttax1");
                                            txtnet1 = $("#txtnet1");
                                            if (returnedArray != null) {
                                                for (i = 0; i < returnedArray.length; i++) {
                                                    txtstamp1.val(returnedArray[i].stamp);
                                                    txttax1.val(returnedArray[i].tax);
                                                    txtnet1.val(returnedArray[i].net);
                                                }
                                            } else {
                                                return false;
                                            }
                                        }
                                    };
                                    $.ajax(CallCostAct);

                                } else {
                                    return false;
                                }
                            }
                        };
                        $.ajax(CallAct);
                    }
                } else {
                    car_id.append("<option value='0'>กรุณาเลือก</option>");
                    return false;
                }
            }
        };
        $.ajax(CallCarID);


        if (_selected != 0) {
            var CallCatCar = {
                type: "POST",
                dataType: "json",
                url: "ajax/Ajax_CarF.php",
                data: {
                    callajax: 'START2',
                    id_pass_car: _selected
                },
                success: function(msg) {
                    $('#cat_car').empty();
                    var returnedArray = msg;
                    CallCatCar = $("#cat_car");
                    if (returnedArray != null) {
                        for (i = 0; i < returnedArray.length; i++) {
                            CallCatCar.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                        }
                    } else {
                        CallCatCar.empty();
                        CallCatCar.append("<option value='0'>กรุณาเลือก</option>");
                        return false;
                    }
                }
            };
            $.ajax(CallCatCar);



        } else {
            $('#cat_car').empty();
            $('#cat_car').append("<option value='0'>กรุณาเลือก</option>");
        }



        // var _selected = $("#cartype").val();
        // var CallBrand = {
        //     type: "POST",
        //     dataType: "json",
        //     url: "ajax/Ajax_CarF.php",
        //     data: {
        //         callajax: 'BRAND2',
        //         cat_car: '0' + _selected,
        //     },
        //     success: function(msg) {
        //         console.log('ประเภท', msg);
        //         if (!msg) {
        //             alert("ไม่พบข้อมูล กรุณาเลือกใหม่ครับ");
        //             return false;
        //         }
        //         br_car = $("#br_car");
        //         br_car.empty();
        //         br_car.append(`<option value='${msg.Id}'>${msg.Name}</option>`);
        //         if ($('#cartype').val() == 0) {
        //             $('#br_car').empty();
        //             $('#br_car').append("<option value='0'>กรุณาเลือก</option>");
        //         }
        //     }
        // };
        // $.ajax(CallBrand);





        var moreoption = {
            type: "POST",
            dataType: "json",
            url: "ajax/Ajax_More.php",
            data: {
                callajax: 'START1',
                cartype: $("#cartype").val()
            },
            success: function(msg) {

                var returnedArray = msg;
                id_price = $("#id_price");
                idprice = "#id_price";
                id_price.empty();
                id_price.append("<option value='0|0'>--กรุณาเลือกราคาอุปกรณ์--</option>");
                if (returnedArray != null) {
                    for (i = 0; i < returnedArray.length; i++) {
                        id_price.append("<option value='" + returnedArray[i].price + "'>" + returnedArray[i].name + "</option>");
                        for (s = 1; s < 15; s++) {
                            if (s == 13 && $("#cartype").val() == 1) { $(idprice + s).append("<option value='" + returnedArray[i].price2 + "'>" + returnedArray[i].name + "</option>"); } else {
                                $(idprice + s).append("<option value='" + returnedArray[i].price + "'>" + returnedArray[i].name + "</option>");
                            }
                        }
                    }
                } else {
                    return false;
                }
            }
        };
        $.ajax(moreoption);

    });
    //end new


    $("#cartype").change(function() {
        $("#txtstamp1").val('0.00');
        $("#txttax1").val('0.00');
        $("#txtnet1").val('0.00');
        $("#id_prp").empty();
        $("#id_prp").append("<option value='0'>กรุณาเลือกเบี้ย</option>");
        $("#MORE_ADD").html('');
        $("#acc").val('');
        $("#price_acc_tun").val(0);
        $("#price_acc_cost").val(0);
        $("#COUNTMORE").val(0);
        $("#car_seat").val(0);
        $("#car_cc").val(0);
        $("#new_carbody").val('');
        $('#br_car').empty();
        $("#More").hide('slow');
        $("#More2").hide('slow');
        $("#costPre").val('0.00');
        $("#costStamp").val('0.00');
        $("#costTax").val('0.00');
        $("#costNet").val('0.00');
        $("#com_data").empty();
        $("#new_motor").val('');
        $("#eq_non").attr('checked', true);
        $("#com_data").append("<option value='0'>กรุณาเลือก</option>");
        $("#costCost").empty();
        $("#costCost").append("<option value='0'>-------------------</option>");
        var _selected = $("#cartype").val();
        var CallCarID = {
            type: "POST",
            dataType: "json",
            url: "ajax/Ajax_CarF.php",
            data: {
                callajax: 'ID_CAR',
                id_pass_car: _selected
            },
            success: function(msg) {
                $('#car_id').empty();
                var returnedArray = msg;
                car_id = $("#car_id");
                if (returnedArray != null) {
                    car_id.append("<option value='0'>กรุณาเลือก</option>");
                    for (var i = 0; i < returnedArray.length; ++i) {
                        car_id.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                    }

                } else {
                    car_id.append("<option value='0'>กรุณาเลือก</option>");
                    return false;
                }
            }
        };
        $.ajax(CallCarID);


        //			if(_selected!=0){
        //				var CallCatCar = {
        //					type: "POST",
        //					dataType: "json",
        //					url: "ajax/Ajax_CarF.php",
        //					data: {callajax:'START2',
        //					id_pass_car:_selected
        //				},
        //				success: function(msg) {
        //					$('#cat_car').empty(); 
        //					var returnedArray = msg;
        //					CallCatCar = $("#cat_car");
        //					if(returnedArray!=null){
        //						for (i = 0; i < returnedArray.length; i++) {
        //							CallCatCar.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
        //						}
        //					}
        //					else{
        //						CallCatCar.empty();
        //						CallCatCar.append("<option value='0'>กรุณาเลือก</option>");
        //						return false;
        //					}
        //				}
        //			};
        //			$.ajax(CallCatCar);
        //
        //
        //
        //		}
        //		else{
        //			$('#cat_car').empty(); 
        //			$('#cat_car').append("<option value='0'>กรุณาเลือก</option>");
        //		}



        var _selected = $("#cartype").val();
        var CallBrand = {
            type: "POST",
            dataType: "json",
            url: "ajax/Ajax_CarF.php",
            data: {
                callajax: 'BRAND2',
                cat_car: '0' + _selected,
            },
            success: function(msg) {
                console.log('ประเภท', msg);
                if (!msg) {
                    alert("ไม่พบข้อมูล กรุณาเลือกใหม่ครับ");
                    return false;
                }
                br_car = $("#br_car");
                br_car.empty();
                br_car.append(`<option value='${msg.Id}'>${msg.Name}</option>`);
                getModelCar();
                if ($('#cartype').val() == 0) {
                    $('#br_car').empty();
                    $('#br_car').append("<option value='0'>กรุณาเลือก</option>");
                }
            }
        };
        $.ajax(CallBrand);





        //		var moreoption = {
        //			type: "POST",
        //			dataType: "json",
        //			url: "ajax/Ajax_More.php",
        //			data: {callajax:'START1',
        //			cartype: $("#cartype").val()
        //		},
        //		success: function(msg) {
        //
        //			var returnedArray = msg;
        //			id_price = $("#id_price");
        //			idprice="#id_price";
        //			id_price.empty();
        //			id_price.append("<option value='0|0'>--กรุณาเลือกราคาอุปกรณ์--</option>");
        //			if(returnedArray!=null){
        //				for (i = 0; i < returnedArray.length; i++) {
        //					id_price.append("<option value='" + returnedArray[i].price + "'>" + returnedArray[i].name + "</option>");
        //					for (s = 1; s < 15; s++) {
        //						if(s==13 && $("#cartype").val()==1){$(idprice+s).append("<option value='" + returnedArray[i].price2 + "'>" + returnedArray[i].name + "</option>");}
        //						else{
        //							$(idprice+s).append("<option value='" + returnedArray[i].price + "'>" + returnedArray[i].name + "</option>");
        //						}
        //					}
        //				}
        //			}
        //			else{
        //				return false;
        //			}
        //		}
        //	};
        //	$.ajax(moreoption);

    });

    $("#br_car").change(function() {
        var _brcar = $('#br_car').val();
        var CallType = {
            type: "POST",
            dataType: "json",
            url: "ajax/Ajax_CarF.php",
            data: {
                callajax: 'TYPE2',
                br_car: _brcar,
            },
            success: function(msg) {
                $('#mo_car').empty();
                var returnedArray = msg;

                mo_car = $("#mo_car");
                mo_car.append("<option value='0'>กรุณาเลือก</option>");
                if (returnedArray != null) {
                    for (var i = 0; i < returnedArray.length; ++i) {
                        mo_car.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                    }
                    if ($('#cartype').val() == 0) {
                        $('#mo_car').empty();
                        $('#mo_car').append("<option value='0'>กรุณาเลือก</option>");
                    }
                } else {
                    return false;
                }

            }
        };
        $.ajax(CallType);
    });
    /* $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
    ดึงราคามาโชว์
    */
    $("#mo_car").change(function() {
        var _mo_car = $('#mo_car').val();
        var CallType = {
            type: "POST",
            dataType: "json",
            url: "ajax/Ajax_CarF.php",
            data: {
                callajax: 'getPieceCar',
                mo_car_id: _mo_car,
            },
            success: function(msg) {
                let value = Number(msg);
                if (value) {
                    $("#mo_carprice").val(value);
                } else {
                    $("#mo_carprice").val(0.00);
                }

            }
        };
        $.ajax(CallType);
    });

    function getModelCar() {
        let _brcar = $('#br_car').val();
        let CallType = {
            type: "POST",
            dataType: "json",
            url: "ajax/Ajax_CarF.php",
            data: {
                callajax: 'TYPE2',
                br_car: _brcar,
            },
            success: function(msg) {
                $('#mo_car').empty();
                var returnedArray = msg;

                mo_car = $("#mo_car");
                mo_car.append("<option value='0'>กรุณาเลือก</option>");
                if (returnedArray != null) {
                    for (var i = 0; i < returnedArray.length; ++i) {
                        mo_car.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                    }
                    if ($('#cartype').val() == 0) {
                        $('#mo_car').empty();
                        $('#mo_car').append("<option value='0'>กรุณาเลือก</option>");
                    }
                } else {
                    return false;
                }

            }
        };
        $.ajax(CallType);
    }
});