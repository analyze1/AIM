$('#SelectCodeApi').change(() => {
    const _value = $('#SelectCodeApi').val();
    $.ajax({
        type: "POST",
        url: "./services/VehicleType.controller.php",
        data: {
            Controller: 'ActPriceController',
            ActTypeId: _value
        },
        dataType: "JSON",
        success: function(response) {

            const res = response;
            const _pre = $('#id_prp');
            const _stamp = $('#txtstamp1');
            const _vat = $('#txttax1');
            const _price = $('#txtnet1');
            ////console.log(res);

            if (res.Pre == null) {
                localStorage.setItem('ApiTypeCode', 0);
                _pre.empty();
                _pre.append(`<option value='0'>--</option>`);
                _stamp.val('');
                _vat.val('');
                _price.val('');
                return false;
            }
            _pre.empty();
            _pre.append(`<option value='${res.Pre}'>${res.Pre}</option>`);
            localStorage.setItem('ApiTypeCode', res.ApiTypeCode);
            $('#ApiTypeCode').val(`${res.ApiTypeCode}`);
            _stamp.val(res.Stamp);
            _vat.val(res.Vat);
            _price.val(res.Net);

        }
    });

});
async function selectCcWeightSeat() {
    //console.log('work');
    const _type = await $('#cartype').val();
    const _cc = await $('#car_cc');
    const _seat = await $('#car_seat');
    const _wg = await $('#car_wgt');
    if (_type == 1) {
        // _cc.html(`<option value="0" >กรุณาเลือก</option>`);
        _cc.html(`<option value="1000" >1000 CC</option>`);
        _cc.append(`<option value="1200" >1200 CC</option>`);
        _cc.append(`<option value="1400" >1400 CC</option>`);
        _cc.append(`<option value="1500" >1500 CC</option>`);
        _cc.append(`<option value="1600" >1600 CC</option>`);
        _cc.append(`<option value="1800" >1800 CC</option>`);
        _cc.append(`<option value="2000" >มากกว่า 2000 CC</option>`);

        _seat.html(`<option value="7" >ไม่เกิน 7 ที่นั่ง</option>`);
        _wg.html(`<option value="0" >ไม่เกิน 3 ตัน</option>`);

    } else if (_type == 3) {
        // _cc.html(`<option value="0" >กรุณาเลือก</option>`);
        _cc.html(`<option value="2000" >2000 CC</option>`);
        _cc.append(`<option value="2500" >2500 CC</option>`);
        _cc.append(`<option value="3000" >3000 CC</option>`);
        _cc.append(`<option value="3500" >3500 CC</option>`);
        _cc.append(`<option value="4500" >มากกว่า 4000 CC</option>`);

        _wg.html(`<option value="0" >ไม่เกิน 3 ตัน</option>`);
        _wg.append(`<option value="3" >ไม่เกิน 6 ตัน</option>`);
        _wg.append(`<option value="6" >ไม่เกิน 12 ตัน</option>`);
        _wg.append(`<option value="12" >เกิน 12 ตัน</option>`);

        _seat.html(`<option value="7" >ไม่เกิน 7 ที่นั่ง</option>`);
        _seat.append(`<option value="15" >ไม่เกิน 15 ที่นั่ง</option>`);

    } else {
        _cc.html(`<option value="0" >กรุณาเลือก</option>`);
        _seat.html(`<option value="0" >กรุณาเลือก</option>`);
        _wg.html(`<option value="0" >กรุณาเลือก</option>`);
    }
}

//ดึงประเภท
var CallCartype = {
    type: "POST",
    dataType: "json",
    url: "ajax/Ajax_Car.php",
    data: {
        callajax: 'START1'
    },

    success: function(msg) {

        const response = msg;
        const cartype = $("#cartype");
        if (response != null) {
            for (const i of response) {
                cartype.append(`<option value=${i.Id}> ${i.Name} </option>`);
            }
        } else {
            return false;
        }
    }
};
$.ajax(CallCartype);

//ดึงจังหวัดรถ
var CallProv = {
    type: "POST",
    dataType: "json",
    url: "ajax/Ajax_Pro.php",
    data: {
        callajax: 'START1'
    },

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
                //alert('รหัสประชาชนไม่ถูกต้อง');
                vala = $('#icard').val();
                Swal.fire({
                    type: 'error',
                    text: 'รหัสประชาชนไม่ถูกต้อง ' + vala,
                    timer: 3000
                });
            }
        }
    }
});

/****************************************** เพิ่มอุปกรณ์ ********************************************************************* */
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
        //alert('คุณไม่สามารถเพิ่มอุปกรณ์ได้อีก');
        Swal.fire({
            type: 'error',
            text: 'คุณไม่สามารถเพิ่มอุปกรณ์ได้อีก',
            timer: 3000
        });
    }
});

/****************************** ลบอุปกรณ์ ****************************************************************************************************** */
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
    const _selected = $("#cartype").val();
    const _selected2 = $("#car_id").val();

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
    //$.ajax(CallAct);
});

/**************** Async function lib **********************************************************************************************************************************/
async function postApi(_url, _data) {
    return await $.ajax({
        type: "POST",
        url: _url,
        data: _data,
        dataType: "JSON",
        success: (res) => {
            return res;
        },
        error: (err) => {
            return err;
        }
    });
}

/**************** Async function lib **********************************************************************************************************************************/

/********************** เลือก ประเภทรถ ******************************************************************************************************************************** */
$("#cartype").change(async function() {
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
    const _carTypeSelect = $("#cartype").val();

    const _send = {
        callajax: 'ID_CAR',
        id_pass_car: $("#cartype").val()
    };
    const carIDType = await postApi('ajax/Ajax_Car.php', _send);

    const _carId = $("#car_id");
    _carId.empty();
    if (carIDType != null) {
        _carId.append("<option value='0'>กรุณาเลือก</option>");

        for (let i = 0; i < carIDType.length; i++) {
            if (i == 0) {
                _carId.append(`<option value="${carIDType[i].Id}" selected> ${carIDType[i].Name} </option>`);
            } else {
                _carId.append(`<option value="${carIDType[i].Id}"> ${carIDType[i].Name} </option>`);
            }

        }
    } else {
        _carId.append("<option value='0'>กรุณาเลือก</option>");
    }

    if (_carTypeSelect != 0) {
        const _sendCatCar = {
            callajax: 'START2',
            id_pass_car: _carTypeSelect
        };
        const _catCarRes = await postApi('ajax/Ajax_Car.php', _sendCatCar);

        $('#cat_car').empty();
        const _CallCatCar = $("#cat_car");

        if (_catCarRes != null) {
            for (i = 0; i < _catCarRes.length; i++) {
                _CallCatCar.append(`<option value='${_catCarRes[i].Id}'>${_catCarRes[i].Name}</option>`);
            }
        } else {
            _CallCatCar.empty();
            _CallCatCar.append("<option value='0'>กรุณาเลือก</option>");
            return false;
        }

    } else {
        $('#cat_car').empty();
        $('#cat_car').append("<option value='0'>กรุณาเลือก</option>");
    }

    const _sendBrCar = {
        callajax: 'BRAND2_FOUR',
        cat_car: `0${$("#cartype").val()}`,
    };
    const _brCarRes = await postApi('ajax/Ajax_Car.php', _sendBrCar);


    $('#br_car').empty();
    const returnedArray = _brCarRes;

    if (returnedArray != null) {
        for (let i = 0; i < returnedArray.length; ++i) {
            $("#br_car").append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
        }

        if ($('#cartype').val() == 0) {
            $('#br_car').empty();
            $('#br_car').append("<option value='0'>กรุณาเลือก</option>");
        }
    } else {
        return false;
    }

    const _sendAct = {
        Controller: 'LoadActNameKey',
        CarType: $('#cartype').val()
    };
    const _actRes = await postApi('./services/VehicleType.controller.php', _sendAct);
    const _selectapibtn = $('#SelectCodeApi');
    if (_actRes != null) {
        _selectapibtn.empty();
        for (let r = 0; r < _actRes.length; r++) {
            if (r == 0) {
                _selectapibtn.append(`<option value='${_actRes[r].Id}' selected> ${_actRes[r].IdAct} ${_actRes[r].Name}</option>`);
            } else {
                _selectapibtn.append(`<option value='${_actRes[r].Id}'>${_actRes[r].IdAct} ${_actRes[r].Name}</option>`);
            }
        }
    }
    //await loadDefaultAct();
    // await $('#p_act3').val('SmartOn');
    await selectCcWeightSeat();
    // await loadPriceActZero();
});

async function loadPriceActZero() {
    await $('#id_prp').html(`<option value="0">--</option>`);
    await $('#txtprp1').val(0.00);
    await $('#txtstamp1').val(0.00);
    await $('#txttax1').val(0.00);
    await $('#txtnet1').val(0.00);


}
// $('#SelectCodeApi').change(async function(){
// 	await loadDefaultAct();
// });

async function loadDefaultAct() {
    const _sendDefault = {
        Controller: 'ActPriceController',
        ActTypeId: $('#SelectCodeApi').val()
    };

    const _resActDefault = await postApi('./services/VehicleType.controller.php', _sendDefault);
    if (_resActDefault != null) {
        $('#id_prp').empty();
        $('#id_prp').append(`<option value='${_resActDefault.Pre}'>${_resActDefault.Pre}</option>`);
        $('#txtstamp1').val(_resActDefault.Stamp);
        $('#txttax1').val(_resActDefault.Vat);
        $('#txtnet1').val(_resActDefault.Net);
        $('#ApiTypeCode').val(_resActDefault.ApiTypeCode);
    }

}


/********************************************************************** เลือกยี่ห้อรถแล้ว ******************************************************************************* */
$("#br_car").change(async function() {
    const _brcar = $('#br_car').val();

    const _sendMoCar = {
        callajax: 'TYPE2_FOUR',
        br_car: _brcar,
    };
    const _mocarRes = await postApi('ajax/Ajax_Car.php', _sendMoCar);
    const _mocarObj = $('#mo_car');
    _mocarObj.empty();
    const returnedArray = _mocarRes;

    _mocarObj.append("<option value='0'>กรุณาเลือก</option>");

    if (returnedArray != null) {
        for (var i = 0; i < returnedArray.length; ++i) {
            _mocarObj.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
        }
        if ($('#cartype').val() == 0) {
            _mocarObj.empty();
            _mocarObj.append("<option value='0'>กรุณาเลือก</option>");
        }
    } else {
        return false;
    }
});


$("#mo_car").change(function() {
    var _mocar = $('#mo_car').val();
    var _cartype = $("#cartype").val();
    var CallCom = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_Cost.php",
        data: {
            callajax: 'START',
            mo_car: _mocar,
            cartype: _cartype
        },

        success: function(msg) {

            var returnedArray = msg;
            $("#costCost").empty();
            $("#costCost").append("<option value='0'>-------------------</option>");
            com_data = $("#com_data");
            com_data.empty();
            com_data.append("<option value='0'>--กรุณาเลือกบริษัท--</option>");
            if (returnedArray != null) {

                for (i = 0; i < returnedArray.length; i++) {
                    com_data.append("<option value='" + returnedArray[i].sort + "'>" + returnedArray[i].name + "</option>");

                    if ($('#cartype').val() == 0) {
                        $("#com_data").empty();
                        $("#com_data").append("<option value='0'>กรุณาเลือก</option>");
                    }
                }
            } else {
                return false;
            }
        }
    };

    // $.ajax(CallCom);
    // $("#costPre").val('0.00');
    // $("#costStamp").val('0.00');
    // $("#costTax").val('0.00');
    // $("#costNet").val('0.00');
    // $("#com_data").val(0);
    // var _selected = $("#mo_car").val();
    // var _input = $("#new_carbody");
    // var _input1 = $("#new_motor");
    // var car_seat = $("#car_seat");
    // var gear = $("#gear");
    // var car_cc = $("#car_cc");


    // var new_mo = _selected;

});


$("#province").change(async function() {
    $("#tumbon").html("<option value='0'>กรุณาเลือก</option>");
    $("#id_post").html("<option value='0'>กรุณาเลือก</option>");

    const _sendaumphar = {
        callajax: 'AMPHUR',
        province: $("#province").val()
    };
    const _aumPhurRes = await postApi('ajax/Ajax_Pro.php', _sendaumphar);

    $('#amphur').empty();
    const returnedArray = _aumPhurRes;
    const _state = $("#amphur");
    _state.append("<option value='0'>กรุณาเลือก</option>");
    if (returnedArray != null) {
        for (let i = 0; i < returnedArray.length; i++) {
            _state.append(`<option value='${returnedArray[i].Id}'> ${returnedArray[i].Name} </option>`);
        }
    } else {
        return false;
    }
});

$("#amphur").change(async function() {
    $("#id_post").html("<option value='0'>กรุณาเลือก</option>");
    const _sendTumbon = {
        callajax: 'TUMBON',
        amphur: $("#amphur").val()
    };

    const _tumbonRes = await postApi('ajax/Ajax_Pro.php', _sendTumbon);

    $('#tumbon').empty();
    const returnedArray = _tumbonRes;
    const state = $("#tumbon");
    state.append("<option value='0'>กรุณาเลือก</option>");
    if (returnedArray != null) {
        for (let i = 0; i < returnedArray.length; i++) {
            state.append(`<option value='${returnedArray[i].Id}'> ${returnedArray[i].Name} </option>`);
        }
    } else {
        return false;
    }

});

$("#tumbon").change(async function() {
    const _sendPost = {
        callajax: 'POST',
        tumbon: $("#tumbon").val()
    };

    const _postE = await postApi('ajax/Ajax_Pro.php', _sendPost);
    const returnedArray = _postE;
    if (returnedArray != null) {
        for (let i = 0; i < returnedArray.length; i++) {
            $("#id_post").html(`<option value='${returnedArray[i].Id}'> ${returnedArray[i].Name} </option>`);
        }
    } else {
        return false;
    }
});

$("#rdodriverN").click(function() {
    $("#Divdriver1").hide('slow');
    $("#Divdriver2").hide('slow');
});

$("#rdodriver1").click(function() {
    $("#Divdriver1").show('slow');
    $("#Divdriver2").hide('slow');
});

$("#rdodriver2").click(function() {
    $("#Divdriver1").show('slow');
    $("#Divdriver2").show('slow');
});

$("#eq").click(function() {
    var brandchose = $('#cartype').val();
    if (brandchose == 0) {
        //alert("กรุณาเลือกประเภทการใช้งาน");
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกประเภทการใช้งาน',
            timer: 3000
        });
        $('#cartype').focus();
        $("#eq_non").attr('checked', 'checked');
        return false;
    }

    $('#ADDTABLE').click();
    $("#More").show('slow');
});

$("#eq_non").click(function() {
    $('#moreclose').click();
    $("#More").hide('slow');
});


function Chose_PRICE(val, type) {
    var _more = val
    var options2 = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_More.php",
        data: {
            callmore: 'PRICE',
            type: type
        },
        success: function(msg) {
            var returnedArray = msg;
            more = $("#costprice-" + _more);
            if (returnedArray != null) {
                more.val(returnedArray[0].name);
            } else {
                return false;
            }
        }
    };
    $.ajax(options2);
}

$("#gear").change(function() {
    if ($("#gear").val() == "A") {
        mo_car_sub = $("#mo_car_sub");
        $("#mo_car_sub").empty();
        mo_car_sub.append("<option value='0'>--กรุณาเลือก model--</option>");
        mo_car_sub.append("<option value='5'>ZF1C9C00AA14 [GA OLD]</option>");
        mo_car_sub.append("<option value='6'>ZF1C9E00AA14 [GA NEW]</option>");
        mo_car_sub.append("<option value='7'>ZF1C9H00AA14 [GL OLD]</option>");
        mo_car_sub.append("<option value='8'>ZF1C9K00AA14 [GL NEW]</option>");
        mo_car_sub.append("<option value='9'>GLX</option>");
    }
    if ($("#gear").val() == "M") {
        mo_car_sub = $("#mo_car_sub");
        $("#mo_car_sub").empty();
        mo_car_sub.append("<option value='0'>--กรุณาเลือก model--</option>");
        mo_car_sub.append("<option value='1'>ZF1C2C00AA14 [GA OLD]</option>");
        mo_car_sub.append("<option value='2'>ZF1C2E00AA14 [GA NEW]</option>");
        mo_car_sub.append("<option value='3'>ZF1C2H00AA14 [GL OLD]</option>");
        mo_car_sub.append("<option value='4'>ZF1C2K00AA14 [GL NEW]</option>");
    }
});


$("#com_data").change(function() {
    var _selected = $("#com_data").val();
    var _selected2 = $("#com_data").val();
    var gear = $("#gear").val();
    var car_cc = $("#car_cc").val();
    var cat_car = $("#cartype").val();
    var mo_car = $("#mo_car").val();
    var mo_car_sub = $("#mo_car_sub").val();
    $("#costPre").val('0.00');
    $("#costStamp").val('0.00');
    $("#costTax").val('0.00');
    $("#costNet").val('0.00');
    var alert_msg = '';
    if (gear == 0) {
        //alert("กรุณาเลือกเกียร์");
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกเกียร์',
            timer: 3000
        });
        $('#gear').focus();
        $("#com_data").val(0);
        return false;
    } else if (car_cc == 0) {
        //alert("กรุณาเลือกซีซี");
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกซีซี',
            timer: 3000
        });
        $('#car_cc').focus();
        $("#com_data").val(0);
        return false;
    } else if (cat_car == 0) {
        //alert("กรุณาเลือกประเภทรถ");
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกประเภทรถ',
            timer: 3000
        });
        $('#cat_car').focus();
        $("#com_data").val(0);
        return false;
    } else if (mo_car == 0) {
        //alert("กรุณาเลือกรุ่นรถ");
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกรุ่นรถ',
            timer: 3000
        });
        $('#mo_car').focus();
        $("#com_data").val(0);
        return false;
    } else if (mo_car == 1951) {
        if (mo_car_sub == 0) {
            //alert("กรุณาเลือก model");
            Swal.fire({
                type: 'error',
                text: 'กรุณาเลือก model',
                timer: 3000
            });
            $('#mo_car_sub').focus();
            $("#com_data").val(0);
            return false;
        }
    }
    $.ajax(options3);

    var _selected1 = $("#cartype").val();
    var car_id = $("#car_id").val();

    var options3 = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_Cost.php",
        data: {
            callajax: 'COST',
            comdata: _selected,
            gear: gear,
            car_cc: car_cc,
            cat_car: cat_car,
            mo_car: mo_car,
            mo_car_sub: mo_car_sub,
            idcar: car_id
        },
        success: function(msg) {
            var returnedArray = msg;
            $("#costCost").empty();
            costCost = $("#costCost");
            costCost.append("<option value='0'>--กรุณาเลือกทุนประกันภัย--</option>");
            if (returnedArray != null) {
                for (i = 0; i < returnedArray.length; i++) {
                    costCost.append("<option value='" + returnedArray[i].id + "'>" + returnedArray[i].cost + "</option>");
                }
            } else {
                return false;
            }


        }
    };
    $.ajax(options3);
});


$("#costCost").change(function() {
    var _selected = $("#costCost").val();
    $.ajax(options3);
    var options3 = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_Cost.php",
        data: {
            callajax: 'PRICE',
            idcost: _selected,
        },
        success: function(msg) {
            var returnedArray = msg;
            if (returnedArray != null) {
                $("#costPre").val(addCommas(returnedArray.pre));
                $("#costStamp").val(addCommas(returnedArray.stamp));
                $("#costTax").val(addCommas(returnedArray.tax));
                $("#costNet").val(addCommas(returnedArray.net));
            } else {
                return false;
            }
        }
    };
    $.ajax(options3);
});

$("#Dxuser").change(function() {
    var _selected = $("#Dxuser").val();
    var options4 = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_saka.php",
        data: {
            callajax: 'SAKA',
            saka: _selected,
        },
        success: function(msg) {
            var returnedArray = msg;
            if (returnedArray != null) {
                $("#p_act2").val(returnedArray.saka);
                //$("#p_act3").val(returnedArray.act_no);
            } else {
                return false;
            }
        }
    };
    $.ajax(options4);

    var options4 = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_saka.php",
        data: {
            callajax: 'ACTNO',
            saka: _selected,
        },
        success: function(msg) {
            var returnedArray = msg;
            $('#p_act3').empty();
            p_act3 = $("#p_act3");
            p_act3.append("<option value='0'>---กรุณาเลือก---</option>");
            if (returnedArray != null) {
                for (i = 0; i < returnedArray.length; i++) {
                    p_act3.append("<option value='" + returnedArray[i].act_no + "'>" + returnedArray[i].act_no + "</option>");
                }
            } else {
                return false;
            }
        }
    };
    $.ajax(options4);
});

function SaveI() {
    /*$('#SaveInsurance').css("display", "none");
    $('#BlockSAVE').css("display", "");*/

    if ($("#xuser").val() == 'admin') {
        if ($("#Dxuser").val() == 0) {
            $("#Dxuser").focus();
            //alert('กรุณาเลือกรหัสผู้แจ้ง');
            Swal.fire({
                type: 'error',
                text: 'กรุณาเลือกรหัสผู้แจ้ง',
                timer: 3000
            });
            $('#SaveInsurance').css("display", "");
            /*
            			$('#BlockSAVE').css("display", "none");*/
            return false;
        }
    }

    if ($("#start_date").val() == '') {
        $("#start_date").focus();
        Swal.fire({
            type: 'error',
            text: 'กรุณาคลิกเลือกวันที่คุ้มครอง',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    }

    if ($("#cartype").val() == 0) {
        $("#cartype").focus();
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกประเภทการใช้งาน',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#car_id").val() == 0) {
        $("#car_id").focus();
        //alert('กรุณาเลือกลักษณะใช้งาน');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกลักษณะใช้งาน',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#cat_car").val() == 0) {
        $("#cat_car").focus();
        //alert('กรุณาเลือกประเภทรถ');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกประเภทรถ',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#br_car").val() == 0) {
        $("#br_car").focus();
        //alert('กรุณาเลือกยี่ห้อรถ');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกยี่ห้อรถ',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#mo_car").val() == 0) {
        $("#mo_car").focus();
        //alert('กรุณาเลือกรุ่นรถ');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกรุ่นรถ',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#car_cc").val() == 0) {
        $("#car_cc").focus();
        //alert('กรุณาเลือกจำนวน ซี.ซี.');
        Swal.fire({
            type: 'error',
            text: 'กรุณากรอก จำนวน ซี.ซี.',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#car_wgt").val() == '') {
        $("#car_wgt").focus();
        //alert('กรุณาเลือกน้ำหนัก');
        Swal.fire({
            type: 'error',
            text: 'กรุณากรอก น้ำหนัก',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#car_seat").val() == 0) {
        $("#car_seat").focus();
        //alert('กรุณาเลือกจำนวนที่นั่ง');
        Swal.fire({
            type: 'error',
            text: 'กรุณากรอก จำนวนที่นั่ง',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#gear").val() == 0) {
        $("#gear").focus();
        //alert('กรุณาเลือกเกียร์');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกเกียร์',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#new_carbody").val() == 0) {
        $("#mo_car").focus();
        //alert('กรุณาเลือกรุ่นรถ');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกรุ่นรถ',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#car_body").val() == 0) {
        $("#car_body").focus();
        //alert('กรุณากรอกเลขตัวถัง');
        Swal.fire({
            type: 'error',
            text: 'กรุณากรอกเลขตัวถัง',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#new_motor").val() == 0) {
        $("#mo_car").focus();
        //alert('กรุณาเลือกรุ่นรถ');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกรุ่นรถ',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#n_motor").val() == 0) {
        $("#n_motor").focus();
        //alert('กรุณากรอกเลขเครื่อง');
        Swal.fire({
            type: 'error',
            text: 'กรุณากรอกเลขเครื่อง',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#car_regis_pro").val() == 0) {
        $("#car_regis_pro").focus();
        //alert('กรุณาเลือกจังหวัดทะเบียนรถ');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกจังหวัดทะเบียนรถ',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#car_color").val() == 0) {
        $("#car_color").focus();
        //alert('กรุณาเลือกสีรถ');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกสีรถ',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#name_gain").val() == 0) {
        $("#name_gain").focus();
        //alert('กรุณาเลือกผู้รับผลปะโยชน์');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกผู้รับผลปะโยชน์',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#p_act3").val() == 0) {
        $("#p_act3").focus();
        //alert('กรุณากรอกเลข พ.ร.บ. หรือกรณีไม่ซื้อ พ.ร.บ. กรอก "9999999"');
        Swal.fire({
            type: 'error',
            text: 'กรุณากรอกเลข พ.ร.บ. หรือกรณีไม่ซื้อ พ.ร.บ. กรอก "9999999"',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#id_acc0").val() == 0 || $("#id_price0").val() == 0) {
        CheckT();
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#icard").val() == 0) {
        $("#icard").focus();
        //alert('กรุณากรอกเลขบัตรประชาชน หรือ เลขหมายทะเบียนการค้า 13 หลัก');
        Swal.fire({
            type: 'error',
            text: 'กรุณากรอกเลขบัตรประชาชน หรือ เลขหมายทะเบียนการค้า 13 หลัก',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#title").val() == 0) {
        $("#title").focus();
        //alert('กรุณาเลือกคำนำหน้าชื่อ');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกคำนำหน้าชื่อ',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#name_name").val() == 0) {
        $("#name_name").focus();
        //alert('กรุณากรอกชื่อ');
        Swal.fire({
            type: 'error',
            text: 'กรุณากรอกชื่อ',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#last").val() == 0) {
        $("#last").focus();
        //alert('กรุณากรอกนามสกุล');
        Swal.fire({
            type: 'error',
            text: 'กรุณากรอกนามสกุล',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#add").val() == 0) {
        $("#add").focus();
        //alert('กรุณากรอกบ้านเลขที่');
        Swal.fire({
            type: 'error',
            text: 'กรุณากรอกบ้านเลขที่',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#province").val() == 0) {
        $("#province").focus();
        //alert('กรุณาเลือกจังหวัด');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกจังหวัด',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#amphur").val() == 0) {
        $("#amphur").focus();
        //alert('กรุณาเลือกอำเภอ');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกอำเภอ',
            timer: 3000
        });
        /*	$('#SaveInsurance').css("display", "");
        	$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#tumbon").val() == 0) {
        $("#tumbon").focus();
        //alert('กรุณาเลือกตำบล');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกตำบล',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#email").val() == 0) {
        $("#email").focus();
        //alert('กรุณากรอกอีเมล์');
        Swal.fire({
            type: 'error',
            text: 'กรุณากรอกอีเมล์',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#com_data").val() == 0) {
        $("#com_data").focus();
        //alert('กรุณาเลือกบริษัทประกันภัย');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกบริษัทประกันภัย',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#costCost").val() == 0) {
        $("#costCost").focus();
        //alert('กรุณาเลือกทุนประกันภัย');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกทุนประกันภัย',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#tel_mobi").val() == 0) {
        $("#tel_mobi").focus();
        //alert('กรุณาเลือกประเภทการใช้งาน');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกประเภทการใช้งาน',
            timer: 3000
        });
        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#regis_date").val() == 'N') {
        $("#regis_date").focus();
        //alert('กรุณาเลือกปีรถ');
        Swal.fire({
            type: 'error',
            text: 'กรุณาเลือกปีรถ',
            timer: 3000
        });
        /*	$('#SaveInsurance').css("display", "");
        	$('#BlockSAVE').css("display", "none");*/
        return false;
    } else if ($("#car_regis").val() == '') {
        $("#car_regis").focus();
        //alert('กรุณากรอกทะเบียนรถ');
        Swal.fire({
            type: 'error',
            text: 'กรุณากรอกทะเบียนรถ',
            timer: 3000
        });

        $('#SaveInsurance').css("display", "");
        /*
        		$('#BlockSAVE').css("display", "none");*/

        return false;
    } else {
        Swal.fire({
            title: 'บันทึกข้อมูล?',
            text: "คุณต้องการบันทึกข้อมูล ใช่หรือไม่",
            type: 'warning',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            showCancelButton: true,
            confirmButtonText: 'บันทึก!',
            cancelButtonText: 'ยกเลิก',
            reverseButtons: true,
        }).then((result) => {
            if (result.value) {
                const noti = document.getElementById('modalNoti');
                noti.style.display = 'flex';
                noti.classList.add("dsp-flx");

                const DATA = $('#Insurance').serialize();
                const SAVE = {
                    type: "POST",
                    async: false,
                    dataType: "json",
                    url: "ajax/Ajax_InsuranceSave_Act.php",
                    data: DATA,
                    success: function(res) {
                        if (res.status == 200) {
                            // $.ajax({
                            // 	type: "POST",
                            // 	url: "./services/MainController.php",
                            // 	data: {
                            // 		Controller:'ActBlackApi',
                            // 		DATAID: res.DataID
                            // 	},
                            // 	dataType: "JSON",
                            // 	success: function (response) 
                            // 	{
                            // 		const noti = document.getElementById('modalNoti');
                            // 		noti.style.display = 'none';

                            // 		const _response = response;
                            // 		Swal.fire(
                            // 			'',
                            // 			_response.msg,
                            // 			'success'
                            // 		  ).then(()=>{
                            // 			load_page('pages/load_ACTCh.php','พ.ร.บ. (ออนไลน์)');
                            // 		  });
                            // 	},
                            // 	error:()=>
                            // 	{
                            // 		Swal.fire(
                            // 			res,
                            // 			'เกิดข้อผิดพลาดกรุณาติดต่อเจ้าหน้าที่',
                            // 			'error'
                            // 		  );
                            // 	}
                            // });
                            alert('post api');
                        } else if (res.status == 400) {
                            const noti = document.getElementById('modalNoti');
                            noti.style.display = 'none';
                            // noti.classList.add("dsp-flx");
                            // alert(_response.ms);

                            Swal.fire(
                                '',
                                res.msg,
                                'success'
                            ).then(() => {
                                load_page('pages/load_ACTCh.php', 'พ.ร.บ. (ออนไลน์)');
                            });
                        } else {
                            Swal.fire(
                                '',
                                res.msg,
                                'error'
                            );
                        }
                    },
                    error: function(msg) {
                        Swal.fire(
                            msg,
                            'เกิดข้อผิดพลาดกรุณาติดต่อเจ้าหน้าที่',
                            'error'
                        );
                    }
                };
                $.ajax(SAVE);
            } else {
                Swal.fire({
                    type: 'error',
                    title: 'ยกเลิกบันทึกข้อมูลเรียบร้อย',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });

    }
}

$("#SaveInsurance").click(function() {
    if (localStorage.getItem('SakaDear') != 113 && SmartOnlineStatus == 1) {
        Swal.fire({
            title: 'คุณมี Blank Form แล้วหรือยัง?',
            text: "คุณได้เลือกออก smart พ.ร.บ.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'มีแล้ว',
            cancelButtonText: 'ไม่มี',
        }).then((result) => {
            if (result.value != true || result.value == null) {
                $('#SmartPRBN').trigger('click');

                return false;
            } else if (result.value == true) {

                $('#SaveInsurance').attr('disabled', true);

                //$("#Savenaja").attr('disabled',true);
                SaveI();
            }
        });
    } else {
        // const noti = document.getElementById('modalNoti');
        // noti.style.display = 'flex';
        // noti.classList.add("dsp-flx");
        $('#SaveInsurance').attr('disabled', true);
        SaveI();

        //("#Savenaja").attr('disabled',true);

    }


});

function closeModal() {
    const modalClose = document.getElementById('modalNoti');

    modalClose.style.display = "none";
}

function callcost(data, costval) {
    if (costval != 0) {
        var _select = costval.split('|');
        var CALLCOSTS = {
            type: "POST",
            dataType: "json",
            url: "ajax/Ajax_More.php",
            data: {
                callajax: 'COST',
                cartype: $("#cartype").val(),
                mo_car: $("#mo_car").val(),
                type: _select[1]
            },
            success: function(msg) {

                var returnedArray = msg;
                var PRICE = $('#id_price' + data);
                PRICE.empty();
                PRICE.append('<option value="0" selected="selected">--กรุณาเลือกราคาอุปกรณ์--</option>');
                if (returnedArray != null) {
                    for (i = 0; i < returnedArray.length; i++) {
                        PRICE.append("<option value='" + returnedArray[i].id + "'>" + returnedArray[i].name + "</option>");
                    }

                } else {
                    return false;
                }
            }
        };
        $.ajax(CALLCOSTS);
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

function TotalCOSTplus(id) {
    var TotalCOST = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_More.php",
        data: {
            callajax: 'TOTAL',
            cartype: $("#cartype").val(),
            mo_car: $("#mo_car").val()
        },
        success: function(msg) {

            var returnedArray = msg;
            if (returnedArray != null) {
                var textTun = 0;
                var textTunCap = 0;
                var textCostCap = 0;
                var CostNormal = 0;
                for (i = 0; i < 14; i++) {
                    if ($('#id_acc' + i).val() != undefined) {
                        if ($('#id_price' + i).val() != 0) {
                            FixCost = $('#id_price' + i).val();
                            //if($('#id_acc'+i).val()!=14){
                            textTun = Number(textTun) + Number(returnedArray[FixCost].name);

                            // }
                            //	 else
                            //	 {
                            //		 textCostCap = Number(textCostCap)+Number(returnedArray[FixCost].price1);
                            //		 textTunCap = Number(textTunCap)+Number(returnedArray[FixCost].name);
                            //	 }
                        }
                    }

                }
                var countauto = 1;
                var Costauto = 0;
                if ($("#cartype").val() == 1) {
                    var Limit = 150000;
                } else if ($("#cartype").val() == 3) {
                    var Limit = 140000;
                } else if ($("#cartype").val() == 2) {
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
                $("#price_acc_cost").val(addCommas(Number(CostNormal) + Number(textCostCap)));
                $("#price_acc_tun").val(addCommas(Number(textTun) + Number(textTunCap)));

                var CheckCOST = $("#price_acc_tun").val();
                var ScheckCOST = CheckCOST.split(',');
                if (ScheckCOST[0] + ScheckCOST[1] > Limit) {
                    $("#id_price" + id).val(0);
                    //alert('คุณไม่สามารถเพิ่มทุนได้มากกว่า '+ addCommas(Limit) +' บาท');
                    Swal.fire({
                        type: 'error',
                        text: 'คุณไม่สามารถเพิ่มทุนได้มากกว่า ' + addCommas(Limit) + ' บาท',
                        timer: 3000
                    });
                    TotalCOSTplus(id);
                }
            } else {
                return false;
            }
        }
    };
    $.ajax(TotalCOST);
}

function CheckT() {
    come = $('#COUNTMORE').val();
    come = Number(come) - 1;
    var str = come.toString();
    for (i = 0; i <= come; i++) {
        if (
            $('#id_acc' + i).val() == 0) {
            //alert('กรุณาเลือกอุปกรณ์ตกแต่ง');
            Swal.fire({
                type: 'error',
                text: 'กรุณาเลือกอุปกรณ์ตกแต่ง',
                timer: 3000
            });
            $('#ADD_MORE').focus();
            return false;
        }
        if ($('#id_price' + i).val() == 0) {
            //alert('กรุณาเลือกราคาอุปกรณ์ตกแต่ง');
            Swal.fire({
                type: 'error',
                text: 'กรุณาเลือกราคาอุปกรณ์ตกแต่ง',
                timer: 3000
            });
            $('#ADD_MORE').focus();
            return false;
        }
    }
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