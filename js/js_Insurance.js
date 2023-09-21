async function postApiAsync(_data, _url) //postapi
{
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

function showAddONlist(add_code) {
    var COL = '#CCCCCC';
    var NUMBER = $('#aoCounter').val();

    var _id = $('#addonM' + add_code + ' option:selected').val();
    var chk = 0;
    for (i = 1; i <= NUMBER; i++) {
        if ($('#check_addon' + i).val() == _id) {
            alert('คุณไม่สามารถเลือกกรมธรรม์ประกันภัยอุบัติเหตุประเภทนี้ได้อีก กรุณาเลือกรายการใหม่');
            chk = '1';
        }
    }

    if (chk != '1') {
        var options = {
            type: "POST",
            dataType: "json",
            async: false,
            url: "ajax/ajax_addon.php?",
            data: {
                data_id: _id
            },
            success: function (msg) {
                var returnedArray = msg;
                if (returnedArray != null) {

                    $('#More_addon_select' + add_code).show();
                    $('#More_addon_select' + add_code).html('<select class="showAddon" onchange="showAddOn(\'' + add_code + '\')" style="width:100%;" id="showAddon' + add_code + '"><option value="0">กรุณาเลือกประกันภัย Add On</option></select>');
                    for (i = 0; i < returnedArray.length; i++) {
                        $('#showAddon' + add_code).append('<option value="' + returnedArray[i].id + '">' + returnedArray[i].name_addon + ' ' + returnedArray[i].id_add + '</option>');
                    }
                } else {
                    $('#More_addon_select' + add_code).hide();
                }
            }
        };
        $.ajax(options);
    }
}

function sumValAddon() {

    var NUMBER = Number($('#aoCounter').val());
    var sumTotal = 0;
    var i;
    for (i = 1; i <= NUMBER; i++) {
        sumTotal = sumTotal + Number($('#val_addon' + i).val());
    }
    $('#costIns').val(sumTotal);
}

function showAddOn(rid) {
    var NUMBER = rid;
    $('#check_addon_detail' + NUMBER).val('');
    $('#addon_select_text' + NUMBER).html('');

    $('#More_addon' + NUMBER).empty();
    var _idAddON = $('#addonM' + NUMBER + ' option:selected').val();
    var _id = $('#showAddon' + NUMBER + ' option:selected').val();
    var options = {
        type: "POST",
        dataType: "json",
        async: false,
        url: "ajax/ajax_addon.php?",
        data: {
            data_id: _idAddON,
            data_select: _id
        },
        success: function (msg) {
            var returnedArray = msg;
            if (returnedArray != null) {
                $('#More_addon' + NUMBER).show();
                for (i = 0; i < returnedArray.length; i++) {
                    $('#More_addon' + NUMBER).append('<button onclick="$(\'#check_addon_detail' + NUMBER + '\').val(' + returnedArray[i].id + ');$(\'#check_addonY\').val(' + NUMBER + ');$(\'#check_addon' + NUMBER + '\').val(\'' + returnedArray[i].code_addon + '\');$(\'#val_addon' + NUMBER + '\').val(\'' + returnedArray[i].cost_insuran + '\');mnBtnBox(\'' + NUMBER + '\');$(\'#More_addon' + NUMBER + '\').hide(\'slow\'); $(\'#addon_select_text' + NUMBER + '\').html(\'*** ท่านได้ซื้อ ' + returnedArray[i].name_addon + ' ' + returnedArray[i].id_add + ' เพิ่มเบี้ย ' + returnedArray[i].cost_insuran + ' บาท ***\');" class="btn btn-info addon_detail" type="button" id="' + returnedArray[i].code_addon + '' + returnedArray[i].id + '" name="' + returnedArray[i].code_addon + '' + returnedArray[i].id + '"><b>' + returnedArray[i].name_addon + ' ' + returnedArray[i].id_add + '</b><br><table class="addontable" width="400" border="0" cellpadding="0" cellspacing="0"><tr><td>ข้อตกลงคุ้มครอง</td><td><div align="right">จำนวนเงินเอาประกัน</div></td></tr><tr><td>' + returnedArray[i].detail_insuran_inbody_text + '</td><td width="150"><div align="right">' + returnedArray[i].detail_insuran_inbody + '</div></td></tr><tr><td>' + returnedArray[i].detail_insuran_incar_text + '</td><td><div align="right">' + returnedArray[i].detail_insuran_incar + '</div></td></tr><tr style="background-color:#d15b47 !important;"><td>เบี้ยประกันภัยรวมภาษี</td><td><div align="right">' + returnedArray[i].cost_insuran + ' บาท </div></td></tr><tr><td colspan="2"><div align="center"><label class="alert alert-block alert-info"><div id="btnCL' + NUMBER + '" size="+2">คลิ๊ก!!! เลือก</div></label></div></td></tr></table></button> ');
                }
            } else {
                $('#More_addon' + NUMBER).hide();
            }
        }
    };
    $.ajax(options);
}

function showMoreText(num) {
    $('#More_addon' + num).show();
    $('#addon_select_text' + num).hide();
    $('#More_addon' + num).show();
}

function mnBtnBox(num) {
    sumValAddon();
    $('#addon_select_text' + num).css({ "background-color": "#d15b47", "padding": "5px", "cursor": "pointer", "color": "#fff" });
    $('#btnCL' + num).html('ซื้อ Add On นี้แล้ว');
    $('#addon_select_text' + num).show();

}

$('#Insurance').keypress(function (e) {
    if (e.which == 13) { SaveI(); return false; }
});

// addon  bullet radio 
$(".addon_N").click(function () {
    $('#addONHideBtn').hide();
    $('#boxAddOn').hide('slow');
    $('#MORE_ADDON_SELECT').empty();
    $('#aoCounter').val('0');
    $('#costIns').val('0');
    $('#More_addon_select').html('');
    $('#check_addonY').val('N');
});

$(".addon_Y").click(function () {
    $('#addONHideBtn').show();
    $('#boxAddOn').show('slow');
    $('#check_addonY').val('Y');
});

$('#ADDONTABLE').click(function () {
    var COL = '#f5e8e8';

    var NUMBER = Number($('#aoCounter').val()) + 1;
    $('#aoCounter').val(NUMBER);
    var selectAddON = $('#addonM' + NUMBER + ' option:selected').val();
    $('#MORE_ADDON_SELECT').append(`
        <div class="row" id="trAO${NUMBER}">
            <div class="col-2">
                <select class="w-100" onchange="showAddONlist('${NUMBER}')" name="addonM${NUMBER}"
                    id="addonM${NUMBER}">
                    <option value="0" selected="selected">--กรุณาเลือกกรรมธรรม์--</option>
                </select>
            </div>
            <div class="col-2">
                <p id="More_addon_select${NUMBER}"></p>
            </div>
            <div class="col-2">
                <span id="More_addon${NUMBER}"></span>
                <input type="hidden" name="check_addon_detail[]" id="check_addon_detail${NUMBER}" value="">
                <input type="hidden" name="check_addon[]" id="check_addon${NUMBER}" value="">
                <input type="hidden" name="val_addon${NUMBER}" id="val_addon${NUMBER}" value="">
                <input type="hidden" name="r_addon${NUMBER}" id="r_addon${NUMBER}" value="${NUMBER}">
                <p onclick="showMoreText('${NUMBER}')" id="addon_select_text${NUMBER}"></p>
            </div>
        </div>
    `);

    var CALLMORE = {
        type: "POST",
        dataType: "json",
        url: "ajax/ajax_addon_select.php",
        data: {
            data_id: selectAddON
        },

        success: function (msg) {
            var returnedArray = msg;
            var TRADD = $('#addonM' + NUMBER);
            if (returnedArray != null) {
                for (i = 0; i < returnedArray.length; i++) {
                    TRADD.append("<option value='" + returnedArray[i].code_addon + "'>" + returnedArray[i].name_addon + "</option>");
                }
            } else {
                return false;
            }
        }
    };
    $.ajax(CALLMORE);
});

$('#addonclose').click(function () {
    var num = Number($('#aoCounter').val())
    var valN = num - 1;
    CHOSE = "#trAO" + num.toString();
    $(CHOSE).remove();
    $('#aoCounter').val(valN);
    if (valN > 0) {
        $('#check_addonY').val(valN);
    } else {
        $('#check_addonY').val('Y');
    }

    sumValAddon();
});

$(".addon_select").click(function () {
    $('#check_addon_detail').val('');
    $('#addon_select_text').html('');
    $('#More_addon').empty();
    var _id = $(this).attr("data-id");
    $('#check_addon').val(_id);

    var options = {
        type: "POST",
        dataType: "json",
        async: false,
        url: "ajax/ajax_addon.php?",
        data: {
            data_id: _id
        },
        success: function (msg) {
            var returnedArray = msg;
            if (returnedArray != null) {
                $('#More_addon').show();

                for (i = 0; i < returnedArray.length; i++) {
                    $('#More_addon').append('<button onclick="$(\'#check_addon_detail\').val(' + returnedArray[i].id + '); $(\'#addon_select_text\').html(\'*** ท่านได้ซื้อ ' + returnedArray[i].name_addon + ' ' + returnedArray[i].id_add + ' เพิ่มเบี้ย ' + returnedArray[i].cost_insuran + ' ***\');" class="btn btn-info addon_detail" type="button" id="' + returnedArray[i].code_addon + '' + returnedArray[i].id + '" name="' + returnedArray[i].code_addon + '' + returnedArray[i].id + '"><b>' + returnedArray[i].name_addon + ' ' + returnedArray[i].id_add + '</b><br><table width="400" border="0" cellpadding="0" cellspacing="0"><tr><td>ข้อตกลงคุ้มครอง</td><td><div align="right">จำนวนเงินเอาประกัน</div></td></tr><tr><td>' + returnedArray[i].detail_insuran_inbody_text + '</td><td width="150"><div align="right">' + returnedArray[i].detail_insuran_inbody + '</div></td></tr><tr><td>' + returnedArray[i].detail_insuran_incar_text + '</td><td><div align="right">' + returnedArray[i].detail_insuran_incar + '</div></td></tr><tr><td>เบี้ยประกันภัยรวมภาษี</td><td><div align="right">' + returnedArray[i].cost_insuran + '</div></td></tr><tr><td colspan="2"><div align="center"><label class="alert alert-block alert-danger"><font size="+2">คลิ๊ก!!! เลือก</font></label></div></td></tr></table></button> ');
                }
            } else {
                $('#More_addon').hide();
            }
        }
    };
    $.ajax(options);
});

$('#person').click(function () {
    if ($('#person').is(':checked')) {
        $("#icardTEXT").html(' * (กรุณากรอกเฉพาะตัวเลขบัตรประชาชน 13 หลัก)');
        $('#icard').val('');
        $('#icard').unmask();
        $('#icard').mask("9999999999999");
    }
});

$('#persons').click(function () {
    if ($('#persons').is(':checked')) {
        $("#icardTEXT").html(' * (กรุณากรอกเฉพาะตัวเลขทะเบียนนิติบุคคล 13 หลัก)');
        $('#icard').val('');
        $('#icard').unmask();
        $('#icard').mask("9999999999999");
    }
});

$('#person_foreign').click(function () {
    if ($('#person_foreign').is(':checked')) {

        $("#icardTEXT").html(' * (กรุณากรอกหมายเลขพาสปอร์ต)');
        $('#icard').val('');
        $('#icard').removeAttr("maxlength");
        $('#icard').unmask();

    }
});


// $('#car_body').blur(function() {
//     Check_CARBODY();
// });

$('#icard').blur(function () {
    if ($('#icard').val() != '') {
        if ($('#person').is(':checked')) {
            if (!checkID($('#icard').val())) {
                alert('รหัสประชาชนไม่ถูกต้อง');
                $('#icard').val('');
            }
        }
    }
});

/************* เพิ่มอุปกรณ์ตกแต่ง *********************/
$('#ADDTABLE').click(function () {
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
        $('#MORE_ADD').append(`
            <div class="row g-2" id="tr${NUMBER}">
                <div class="col-6">
                    <label for="id_price${NUMBER}" class="text-white">.</label>
                    <select onchange="callcost('${NUMBER}',this.value);" name="id_acc${NUMBER}" id="id_acc${NUMBER}" class="w-100">
                        <option value="0" selected="selected">เลือกราคาอุปกรณ์</option>
                    </select>
                </div>
                <div class="col-3">
                    <label for="id_price${NUMBER}" class="text-white">.</label>
                    <select onchange="splitcost('${NUMBER}');" name="id_price" id="id_price${NUMBER}" class="w-100">
                        <option value="0" selected="selected">เลือกราคาอุปกรณ์</option>
                    </select>
                </div>
                <div class="col-2" id="forFree${NUMBER}" style="display: none;">
                    <label for="add_price${NUMBER}" class="text-white">.</label>
                    <select name="add_price" id="add_price${NUMBER}" class="w-100" onchange="splitcost('${NUMBER}');">
                        <option value="0" selected>เลือกราคา</option>
                    </select>
                </div>
            </div>
        `);

        var CALLMORE = {
            type: "POST",
            dataType: "json",
            url: "ajax/Ajax_More.php",
            data: {
                callajax: 'MORE_NEW',
                cartype: $("#cartype").val(),
                mo_car: $("#mo_car").val(),
                mo_car_sub: $("#mo_car_sub").val()
            },

            success: function (msg) {
                var returnedArray = msg;
                var TRADD = $('#id_acc' + NUMBER);
                if (returnedArray != null) {
                    TRADD.html(returnedArray.html_acc);
                    $('#id_acc' + NUMBER).attr('style', 'width:500px;');
                    TRADD.chosen();

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

/************* ลบอุปกรณ์ตกแต่ง *********************/
$('#moreclose').click(function () {
    var num = Number($('#COUNTMORE').val()) - 1;

    CHOSE = "#tr" + num.toString();
    $(CHOSE).remove();
    $('#COUNTMORE').val(num);

    TotalCOSTplus();
    TotalTEXTplus();
    if ($('#COUNTMORE').val() == '0') {
        $("#ADDTABLE").trigger('click');
    }
});

$('BcloseIn').click(function () {
    $('#Insurance').reset();
});

$("#car_id").change(function () {
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
        success: function (msg) {
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
                    success: function (msg) {
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

function checkID(id) {
    if (id.length != 13) return false;
    for (i = 0, sum = 0; i < 12; i++)
        sum += parseFloat(id.charAt(i)) * (13 - i);
    if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12)))
        return false;
    return true;
}

function loadActStart() {
    const _value = $('#SelectCodeApi').val();
    $.ajax({
        type: "POST",
        url: "./services/VehicleType.controller.php",
        data: {
            Controller: 'ActPriceController',
            ActTypeId: _value
        },
        dataType: "JSON",
        success: function (response) {

            const res = response;
            const _pre = $('#id_prp');
            const _stamp = $('#txtstamp1');
            const _vat = $('#txttax1');
            const _price = $('#txtnet1');
            //console.log(res);

            if (res.Pre == null) {
                _pre.empty();
                _pre.append(`<option value='0'>--</option>`);
                _stamp.val('');
                _vat.val('');
                _price.val('');
                return false;
            }
            _pre.empty();
            _pre.append(`<option value='${res.Pre}'>${res.Pre}</option>`);
            _stamp.val(res.Stamp);
            _vat.val(res.Vat);
            _price.val(res.Net);

        }
    });
}

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
        success: function (response) {

            const res = response;
            const _pre = $('#id_prp');
            const _stamp = $('#txtstamp1');
            const _vat = $('#txttax1');
            const _price = $('#txtnet1');
            //console.log(res);

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

/*********************************** เลือกประเภทการใช้งาน **************************************************************************************************************** */

function changeCarType() {
    openForChangeTypeCarEquitment();
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
        url: "ajax/Ajax_Car.php",
        data: {
            callajax: 'ID_CAR',
            id_pass_car: _selected
        },
        success: function (msg) {
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
                    car_id.css('background-color', '#ddd');
                    var _selected = $("#cartype").val();
                    var _selected2 = $("#car_id").val();
                }
            } else {
                car_id.css('background-color', '#fff');
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
            url: "ajax/Ajax_Car.php",
            data: {
                callajax: 'START2',
                id_pass_car: _selected
            },
            success: function (msg) {
                $('#cat_car').empty();
                var returnedArray = msg;
                CallCatCar = $("#cat_car");
                if (returnedArray != null) {
                    CallCatCar.css('background-color', '#ddd');
                    for (i = 0; i < returnedArray.length; i++) {
                        CallCatCar.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                    }
                } else {
                    CallCatCar.empty();
                    CallCatCar.css('background-color', '#fff');
                    CallCatCar.append("<option value='0'>กรุณาเลือก</option>");
                    return false;
                }
            }
        };
        $.ajax(CallCatCar);

    } else {
        CallCatCar = $("#cat_car");
        CallCatCar.css('background-color', '#fff');
        $('#cat_car').empty();
        $('#cat_car').append("<option value='0'>กรุณาเลือก</option>");
    }

    var _selected = $("#cartype").val();

    var CallBrand = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_Car.php",
        data: {
            callajax: 'BRAND',
            cat_car: '0' + _selected,
        },
        success: function (msg) {
            $('#br_car').empty();
            var returnedArray = msg;
            br_car = $("#br_car");
            if (returnedArray != null) {
                br_car.css('background-color', '#ddd');
                for (var i = 0; i < returnedArray.length; ++i) {
                    br_car.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                }
                if ($('#cartype').val() == 0) {
                    br_car.css('background-color', '#fff');
                    $('#br_car').empty();
                    $('#br_car').append("<option value='0'>กรุณาเลือก</option>");
                }
            } else {
                return false;
            }
        }
    };
    $.ajax(CallBrand);

    var CallType = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_Car.php",
        data: {
            callajax: 'TYPE',
            br_car: '0' + _selected
        },
        success: function (msg) {
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

    var moreoption = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_More.php",
        data: {
            callajax: 'START1',
            cartype: $("#cartype").val()
        },
        success: function (msg) {

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

    $('#SelectCodeApi').html('<option value="0">--กรุณาเลือก--</option>');
}

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
        },
    });
}

$("#cartype").change(async function () {
    console.log('changeCartype');
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

    const resPassCarType = await getPassCarType(Number(_selected));
    const resPassCatCar = await getCatCar(Number(_selected));


    // console.log('resPassCarType', resPassCarType);
    console.log('resPassCatCar', resPassCatCar);

    if ((resPassCatCar.Status != 200) || (resPassCarType.Status != 200)) {
        return false;
    }

    if (resPassCatCar.Data) {
        const catCarElem = document.querySelector('#cat_car');
        catCarElem.innerHTML = '';
        resPassCatCar.Data.forEach(x => {
            const op = document.createElement('option');
            op.value = x.Id;
            op.text = x.Name;
            catCarElem.appendChild(op);
        });
    }
    let _selectedCatCar = $("#cat_car").val();
    const resBrandCar = await getBrandCarAct(Number(_selected), _selectedCatCar);
    if (resBrandCar.Status == 200) {
        handleBrandCar(resBrandCar.Data)
    }

    let _selectedBrand = $("#br_car").val();
    const resModelCar = await getModelCar(_selectedBrand, Number(_selected));
    if (resModelCar.Status == 200) {
        handleModelCar(resModelCar.Data)
    }

    if (resPassCarType.Data.TypeCar) {
        const carIdElem = document.querySelector('#car_id');
        carIdElem.innerHTML = '';
        resPassCarType.Data.TypeCar.forEach(x => {
            const op = document.createElement('option');
            op.value = x.Id;
            op.text = `[${x.Id}] ${x.Name}`;
            carIdElem.appendChild(op);
        });
    }

    if (resPassCarType.Data.CC) {
        const carCCElem = document.querySelector('#car_cc');
        carCCElem.innerHTML = '';
        resPassCarType.Data.CC.forEach(x => {
            const op = document.createElement('option');
            op.value = x;
            op.text = `ไม่เกิน ${x}`;
            if (x == '1200') carCCElem.appendChild(op);
        });
    }

    if (resPassCarType.Data.Seat) {
        const carSeatElem = document.querySelector('#car_seat');
        carSeatElem.innerHTML = '';
        console.log(resPassCarType.Data.Seat);
        resPassCarType.Data.Seat.forEach(x => {
            const op = document.createElement('option');
            op.value = x;
            op.text = `ไม่เกิน ${x} ที่นั่ง`;
            if (x == 7) carSeatElem.appendChild(op);
        });
        if ($('#cat_car').val() == '01') {
            $("#car_seat select").val("7");
        }
    }

    if (resPassCarType.Data.Weight) {
        const carWeightElem = document.querySelector('#car_wgt');
        carWeightElem.innerHTML = '';
        resPassCarType.Data.Weight.forEach(x => {
            const op = document.createElement('option');
            op.value = x;
            op.text = `ไม่เกิน ${Number(x) + 3} ตัน`;
            if (x == '0') carWeightElem.appendChild(op);
        });
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

    _selectapibtn.trigger('change');
});


/*********************************** END เลือกประเภทการใช้งาน *****************************************************************/

$("#province").change(function () {
    $("#tumbon").empty();
    $("#tumbon").append("<option value='0'>กรุณาเลือก</option>");
    $("#id_post").empty();
    $("#id_post").append("<option value='0'>กรุณาเลือก</option>");
    var _selected = $("#province").val();
    var options = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_Pro.php",
        data: {
            callajax: 'AMPHUR',
            province: _selected
        },
        success: function (msg) {
            $('#amphur').empty();
            var returnedArray = msg;
            state = $("#amphur");
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

$("#amphur").change(function () {
    $("#id_post").empty();
    $("#id_post").append("<option value='0'>กรุณาเลือก</option>");
    var _selected = $("#amphur").val();
    var options = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_Pro.php",
        data: {
            callajax: 'TUMBON',
            amphur: _selected
        },
        success: function (msg) {
            $('#tumbon').empty();
            var returnedArray = msg;
            state = $("#tumbon");
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

$("#tumbon").change(function () {
    var _selected = $("#tumbon").val();
    var options = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_Pro.php",
        data: {
            callajax: 'POST',
            tumbon: _selected
        },
        success: function (msg) {
            $('#id_post').empty();
            var returnedArray = msg;
            state = $("#id_post");
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

$("#address_chk1").click(function () {
    $("#user_ScomC").hide('slow');
});
$("#address_chk2").click(function () {
    $("#user_ScomC").show('slow');
});

$("#rdodriverN").click(function () {
    $("#Divdriver1").hide('slow');
    $("#Divdriver2").hide('slow');
});

$("#rdodriver1").click(function () {
    $("#Divdriver1").show('slow');
    $("#Divdriver2").hide('slow');
});

$("#rdodriver2").click(function () {
    $("#Divdriver1").show('slow');
    $("#Divdriver2").show('slow');
});

$("#eq").click(function () {
    var brandchose = $('#cartype').val();
    if (brandchose == 0) {
        alert("กรุณาเลือกประเภทการใช้งาน");
        $('#cartype').focus();
        $("#eq_non").attr('checked', 'checked');
        return false;
    }
    if ($("#mo_car").val() == '0' || $("#mo_car").val() == 'N' || $("#mo_car").val() == '') {
        alert("กรุณาเลือกรุ่นรถยนต์");
        $('#mo_car').focus();
        $("#eq_non").attr('checked', 'checked');
        return false;
    }
    if ($("#mo_car_sub").val() == '0' || $("#mo_car_sub").val() == 'N' || $("#mo_car_sub").val() == '') {
        alert("กรุณาเลือกรุ่นย่อยรถยนต์");
        $('#mo_car_sub').focus();
        $("#eq_non").attr('checked', 'checked');
        return false;
    }
    if ($("#car_body").val() == '') {
        alert("กรุณาคีย์เลขตัวถังด้วยครับ");
        $('#car_body').focus();
        $("#eq_non").attr('checked', 'checked');
        return false;
    }
    if ($("#n_motor").val() == '') {
        alert("กรุณาคีย์เลขตัวเครื่องด้วยครับ");
        $('#n_motor').focus();
        $("#eq_non").attr('checked', 'checked');
        return false;
    }

    $('#ADDTABLE').click();
    $("#More").show('slow');

    warningChangeTypeCarEquitment();
});

$("#eq_non").click(function () {
    $('#moreclose').click();
    $("#More").hide('slow');
    openForChangeTypeCarEquitment();
});

$("#insureYear1").click(function () {
    $('#insureYear').val('1');
});
$("#insureYear2").click(function () {
    $('#insureYear').val('2');
});
$("#insureYear3").click(function () {
    $('#insureYear').val('3');
});

function handleAddTun() {
    if ($("#finance_add_tun").val() == "N" || $("#finance_add_tun").val() == "0") {
        $("#finance_add_tun_price").val('0.00');
    }

    var mo_car = $("#mo_car").val();
    var car_type = $("#cartype").val();
    var finance_add_tun = $("#finance_add_tun").val();
    var finance_custom_tun = $("#finance_custom_tun").val();
    var _tun = '';

    if (finance_add_tun == 'add') {
        document.getElementById('customTun').style.display = "block";
        _tun = finance_custom_tun;
    } else {
        document.getElementById('customTun').style.display = "none";
        _tun = finance_add_tun;
    }

    $.ajax(options3);
    var options3 = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_More.php",
        data: {
            callajax: 'FI_MORE',
            Fi_mo_car: mo_car,
            Fi_car_type: car_type,
            Fi_add_tun: _tun,
            mo_car_sub: $("#mo_car_sub").val()
        },
        success: function (msg) {
            var returnedArray = msg;
            if (returnedArray != null) {
                $("#finance_add_tun_price").val(addCommas(returnedArray.Fi_price));
            } else {
                $("#finance_add_tun_price").val('0.00');
            }
        }
    };
    $.ajax(options3);
}

// async function handleAddTunEqiup(val, id) {
//     var mo_car = $("#mo_car").val();
//     var car_type = $("#cartype").val();
//     var finance_add_tun = $(`#id_price${id}`).val();
//     var finance_custom_tun = $(`#add_price${id}`).val();
//     var _tun = '';

//     if ($(`#id_price${id} option:selected`).text() == 'เพิ่มทุน') {
//         _tun = finance_custom_tun;
//     } else {
//         _tun = finance_add_tun;
//     }

//     let _res = await $.ajax({
//         type: "POST",
//         dataType: "json",
//         url: "ajax/Ajax_More.php",
//         data: {
//             callajax: 'FI_MORE',
//             Fi_mo_car: mo_car,
//             Fi_car_type: car_type,
//             Fi_add_tun: _tun,
//             mo_car_sub: $("#mo_car_sub").val()
//         },
//         success: function (msg) {
//             return msg;
//         }
//     })

//     if (_res != null) {
//         document.getElementById('price_acc_tun').value = val;
//         document.getElementById('price_acc_cost').value = _res.Fi_price;
//     } else {
//         $("#price_acc_cost").val('0.00');
//     }
// }

$("#com_data").change(function () {
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

    if (_selected == 'VIB_S') {
        Check_LISTCAR();
    }

    if (gear == 0) {
        alert("กรุณาเลือกเกียร์");
        $('#gear').focus();
        $("#com_data").val(0);
        return false;
    } else if (car_cc == 0) {
        alert("กรุณาเลือกซีซี");
        $('#car_cc').focus();
        $("#com_data").val(0);
        return false;
    } else if (cat_car == 0) {
        alert("กรุณาเลือกประเภทรถ");
        $('#cat_car').focus();
        $("#com_data").val(0);
        return false;
    } else if (mo_car == 0) {
        alert("กรุณาเลือกรุ่นรถ");
        $('#mo_car').focus();
        $("#com_data").val(0);
        return false;
    } else if (mo_car == 1951) {
        if (mo_car_sub == 0) {
            alert("กรุณาเลือก model");
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
            countmore: $('#COUNTMORE').val(),
            idcar: car_id
        },
        success: function (msg) {
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


$("#costCost").change(function () {
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
        success: function (msg) {
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

$("#Dxuser").change(function () {
    var _selected = $("#Dxuser").val();
    var options4 = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_saka.php",
        data: {
            callajax: 'SAKA',
            saka: _selected,
        },
        success: function (msg) {
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
        success: function (msg) {
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

//เมื่อเช็คเลข พรบ เสร็จ fun savenaja จะคลิก btn id #SaveInsurance หลังจากนั้นจะมาที่นี่
$("#SaveInsurance").click(function () {
    $('#SaveInsurance').css("display", "none");
    $('#BlockSAVE').css("display", "");
    //ปิดปุ่มกันลั่นแล้วไปต่อ fnc
    SaveI();
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
        success: function (msg) {
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

function Check_CARBODY() {
    var CHECK = $('#new_carbody').val() + $('#car_body').val();
    var CHECKSQL = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_CheckCarbody.php",
        data: {
            CHECKCARBODY: CHECK
        },
        success: function (msg) {
            var returnedArray = msg;
            if (returnedArray != null) {
                if (returnedArray['STATUS'] > 0) {
                    alert(returnedArray['TEXT']);
                    $("#car_body").val('');
                    return false;
                } else {
                    return true;
                }
            } else {
                alert('ระบบผิดพลาดกรุณา บันทึกใหม่อีกครั้งภายหลัง')
                return false;
            }
        }
    };
    $.ajax(CHECKSQL);
    $('#SaveInsurance').css("display", "");
    $('#BlockSAVE').css("display", "none");
}

function Check_LISTCAR() {
    var CHECK = $('#new_carbody').val() + $('#car_body').val();
    var CHECKSQL = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_listcar.php",
        data: {
            CHECKCARBODY: CHECK
        },
        success: function (msg) {
            var returnedArray = msg;
            if (returnedArray != null) {
                if (returnedArray['STATUS'] > 0) {
                    alert('เลขตัวถัง ' + CHECK + " เป็นรถ celebrity กรุณาติดต่อเจ้าหน้าที่");
                    $("#car_body").val('');
                    $('#mo_car').focus();
                    $("#com_data").val(0);
                    return false;
                    return false;
                } else {
                    return true;
                }
            } else {
                alert('ระบบผิดพลาดกรุณา บันทึกใหม่อีกครั้งภายหลัง')
                return false;
            }
        }
    };
    $.ajax(CHECKSQL);
    $('#SaveInsurance').css("display", "");
    $('#BlockSAVE').css("display", "none");
}

function SaveI() {
    $('#SaveInsurance').css("display", "none");
    $('#BlockSAVE').css("display", "");

    Array.prototype.contains = function (obj) {
        var i = this.length;
        while (i--) {
            if (this[i] === obj) {
                return true;
            }
        }
        return false;
    }

    if ($("#xuser").val() == 'admin') {
        if (document.getElementsByName('Dxuser')[0].value == '') {
            $("#Dxuser").focus();
            alert('กรุณาเลือกสาขาแจ้งงาน');
            $('#SaveInsurance').css("display", "");
            $('#BlockSAVE').css("display", "none");
            return false;
        }
    }

    if ($('#checkAddonN').checked == false) {
        // addon
        if ($("#check_addonY").val() == '') {

            $("#checkAddonN").focus();
            alert('กรุณาเลือกประกันภัย Add On');
            $('#SaveInsurance').css("display", "");
            $('#BlockSAVE').css("display", "none");
            return false;
        } else if ($("#check_addonY").val() == 'Y') { // มีประกันภัย Addon แต่ยังไม่ได้คลิกเลือก

            var c = 0;
            for (var n = 0; n < document.getElementsByName("addon_buy[]").length; n++) {
                if (document.getElementsByName("addon_buy[]")[n].checked == false) {
                    c++;
                }
            }
            if (document.getElementsByName("addon_buy[]").length == c) {
                alert('กรุณาเลือกประกันภัย Add On');
                $("#checkAddonN").focus();
                $('#SaveInsurance').css("display", "");
                $('#BlockSAVE').css("display", "none");
                return false;
            }
        }
    }
    /************************************************************* */
    if ($('#SelectCodeApi').val() == 0 && SmartOnlineStatus == 1) {
        alert('กด YES หรือ NO แล้ว เลือกประเภท พ.ร.บ.');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }

    if ($("#cartype").val() == 0) {
        $("#cartype").focus();
        alert('กรุณาเลือกประเภทการใช้งาน');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#car_id").val() == 0) {
        $("#car_id").focus();
        alert('กรุณาเลือกลักษณะใช้งาน');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#cat_car").val() == 0) {
        $("#cat_car").focus();
        alert('กรุณาเลือกประเภทรถ');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#br_car").val() == 0) {
        $("#br_car").focus();
        alert('กรุณาเลือกยี่ห้อรถ');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#mo_car").val() == 0) {
        $("#mo_car").focus();
        alert('กรุณาเลือกรุ่นรถ');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    // if ($("#mo_car_sub").val() == 0) {
    //     $("#mo_car_sub").focus();
    //     alert('กรุณาเลือกรุ่นรถย่อย');
    //     $('#SaveInsurance').css("display", "");
    //     $('#BlockSAVE').css("display", "none");
    //     return false;
    // }
    if ($("#car_cc").val() == 0) {
        $("#car_cc").focus();
        alert('กรุณาเลือกจำนวน ซี.ซี.');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#car_wgt").val() == '') {
        $("#car_wgt").focus();
        alert('กรุณาเลือกน้ำหนัก');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#car_seat").val() == 0) {
        $("#car_seat").focus();
        alert('กรุณาเลือกจำนวนที่นั่ง');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#gear").val() == 0) {
        $("#gear").focus();
        alert('กรุณาเลือกเกียร์');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    // if ($("#new_carbody").val() == 0) {
    //     $("#mo_car").focus();
    //     alert('กรุณาเลือกรุ่นรถ');
    //     $('#SaveInsurance').css("display", "");
    //     $('#BlockSAVE').css("display", "none");
    //     return false;
    // }
    if ($("#car_body").val() == 0) {
        $("#car_body").focus();
        alert('กรุณากรอกเลขตัวถัง 8 ตัวหลัง');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    // if ($("#new_motor").val() == 0) {
    //     $("#mo_car").focus();
    //     alert('กรุณาเลือกรุ่นรถ');
    //     $('#SaveInsurance').css("display", "");
    //     $('#BlockSAVE').css("display", "none");
    //     return false;
    // }
    if ($("#n_motor").val() == 0) {
        $("#n_motor").focus();
        alert('กรุณากรอกเลขเครื่อง 6 ตัวหลัง');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#car_regis_pro").val() == 0) {
        $("#car_regis_pro").focus();
        alert('กรุณาเลือกจังหวัดทะเบียนรถ');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#car_color").val() == 0) {
        $("#car_color").focus();
        alert('กรุณาเลือกสีรถ');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#name_gain").val() == '0') {
        $("#name_gain").focus();
        alert('กรุณาเลือกผู้รับผลปะโยชน์');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }

    if ($("#p_act3").val() == '' || $("#p_act3").val().length < 7 || $("#p_act3").val().length > 7) {
        $("#p_act3").focus();
        alert('กรุณากรอกเลข พ.ร.บ. หรือกรณีไม่ซื้อ พ.ร.บ. กรอก "9999999"');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }

    if ($("#id_acc0").val() == 0 || $("#id_price0").val() == 0) {
        CheckT();
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#icard").val() == 0) {
        $("#icard").focus();
        alert('กรุณากรอกเลขบัตรประชาชน หรือ เลขหมายทะเบียนการค้า 13 หลัก');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($('#person').is(':checked')) {
        if ($("#icard").val().length < 13) {
            $("#icard").focus();
            alert('กรุณากรอกเลขบัตรประชาชน หรือ เลขหมายทะเบียนการค้า 13 หลัก');
            $('#SaveInsurance').css("display", "");
            $('#BlockSAVE').css("display", "none");
            return false;
        }
    }
    if ($("#title").val() == 0) {
        $("#title").focus();
        alert('กรุณาเลือกคำนำหน้าชื่อ');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#name_name").val() == 0) {
        $("#name_name").focus();
        alert('กรุณากรอกชื่อ');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#persons:checked").val() != 2) {
        if ($("#last").val() == 0) {
            $("#last").focus();
            alert('กรุณากรอกนามสกุล');
            $('#SaveInsurance').css("display", "");
            $('#BlockSAVE').css("display", "none");
            return false;
        }
    }
    if ($("#add").val() == 0) {
        $("#add").focus();
        alert('กรุณากรอกบ้านเลขที่');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#road").val() == '') {
        $("#road").focus();
        alert('กรุณากรอกถนน ไม่มีใส่เครื่องหมาย - ');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#province").val() == 0) {
        $("#province").focus();
        alert('กรุณาเลือกจังหวัด');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#amphur").val() == 0) {
        $("#amphur").focus();
        alert('กรุณาเลือกอำเภอ');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#tumbon").val() == 0) {
        $("#tumbon").focus();
        alert('กรุณาเลือกตำบล');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#email").val() == 0) {
        $("#email").focus();
        alert('กรุณากรอกอีเมล์');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    // if ($("#com_data").val() == 0) {
    //     $("#com_data").focus();
    //     alert('กรุณาเลือกบริษัทประกันภัย');
    //     $('#SaveInsurance').css("display", "");
    //     $('#BlockSAVE').css("display", "none");
    //     return false;
    // }
    if ($("#costCost").val() == 0) {
        $("#costCost").focus();
        alert('กรุณาเลือกทุนประกันภัย');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }

    if ($("#finance_add_tun").val() == 0) {
        $("#finance_add_tun").focus();
        alert('กรุณาเลือกไฟแนนซ์เพิ่มทุน');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#vocation").val() == '') {
        $("#vocation").focus();
        alert('กรุณากรอกอาชีพผู้เอาประกัน');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#send_add_Y:checked").val() == 'Y') {
        if ($("#send_add").val() == '') {
            $("#send_add").focus();
            alert('กรุณากรอกบ้านเลขที่');
            $('#SaveInsurance').css("display", "");
            $('#BlockSAVE').css("display", "none");
            return false;
        }
        if ($("#send_group").val() == '') {
            $("#send_group").focus();
            alert('กรุณากรอกหมู่');
            $('#SaveInsurance').css("display", "");
            $('#BlockSAVE').css("display", "none");
            return false;
        }
        if ($("#send_town").val() == '') {
            $("#send_town").focus();
            alert('กรุณากรอกอาคาร/หมู่บ้าน');
            $('#SaveInsurance').css("display", "");
            $('#BlockSAVE').css("display", "none");
            return false;
        }
        if ($("#send_lane").val() == '') {
            $("#send_lane").focus();
            alert('กรุณากรอกซอย');
            $('#SaveInsurance').css("display", "");
            $('#BlockSAVE').css("display", "none");
            return false;
        }
        if ($("#send_road").val() == '') {
            $("#send_road").focus();
            alert('กรุณากรอกถนน');
            $('#SaveInsurance').css("display", "");
            $('#BlockSAVE').css("display", "none");
            return false;
        }
        if ($("#send_province").val() == '') {
            $("#send_province").focus();
            alert('กรุณาเลือกจังหวัด');
            $('#SaveInsurance').css("display", "");
            $('#BlockSAVE').css("display", "none");
            return false;
        }
        if ($("#send_amphur").val() == '') {
            $("#send_amphur").focus();
            alert('กรุณาเลือกอำเภอ');
            $('#SaveInsurance').css("display", "");
            $('#BlockSAVE').css("display", "none");
            return false;
        }
        if ($("#send_tumbon").val() == '') {
            $("#send_tumbon").focus();
            alert('กรุณาเลือกตำบล');
            $('#SaveInsurance').css("display", "");
            $('#BlockSAVE').css("display", "none");
            return false;
        }
        if ($("#send_post").val() == '') {
            $("#send_post").focus();
            alert('กรุณาเลือกไปรษณีย์');
            $('#SaveInsurance').css("display", "");
            $('#BlockSAVE').css("display", "none");
            return false;
        }
    }

    document.getElementById('modalPolicy').style.display = 'flex';
}

function closeModalPolicy() {
    document.getElementById('modalPolicy').style.display = 'none';
}

function handleSaveService() {
    String.prototype.isPhoneNumber = function () {
        var invalidPhoneNumber = ["999-999-9999", "888-888-8888", "777-777-7777", "666-666-6666", "555-555-5555", "444-444-4444", "333-333-3333", "222-222-2222", "111-111-1111", "000-000-0000"];
        if (invalidPhoneNumber.contains(this.toString())) {
            return false;
        }
        return true;
    }

    // วิธีใช้
    var phone = $('#tel_mobi').val();
    if (phone.isPhoneNumber()) { } else {
        $("#tel_mobi").focus();
        alert('กรุณากรอกเบอร์มือถือใหม่');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }
    if ($("#tel_mobi").val() == 0 || $("#tel_mobi").val().length < 10) {
        $("#tel_mobi").focus();
        alert('คุณลืมกรอกเบอร์มือถือ หรือ เบอร์มือถือไม่ถึง 10 หลัก');
        $('#SaveInsurance').css("display", "");
        $('#BlockSAVE').css("display", "none");
        return false;
    }

    let _check = document.getElementById('checkPolicy').checked;

    if (_check == false) {
        alert('กรุณายอมรับข้อกำหนดและเงื่อนไขการใช้บริการของบริษัท');
        return false;
    }
    closeModalPolicy();
    var DATA = $('#Insurance').serialize();
    var AccesForce = $('#getDataAccesForceShow').text();
    var ByCustomer = $('#ByCustomer').val();

    var SAVE = {
        type: "POST",
        async: false,
        dataType: "json",
        url: "ajax/Ajax_InsuranceSave.php",
        data: `${DATA}&accesForce=${AccesForce}&ByCustomer=${ByCustomer}`,
        success: function (msg) {
            var returnedArray = msg;
            $('#close-modal').trigger('click');

            $('#test-modal').trigger('click');

            var _postApi = {
                url: 'services/MainController.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    DATAID: returnedArray.DataApiId,
                    PerSonID: returnedArray.idperson,
                    Controller: 'ActBlackApiRed'
                },
                success: function (res) {
                    let response = res;
                    document.getElementById('modalNoti').style = 'display:none';
                    Swal.fire(
                        '',
                        response.msg,
                        'success'
                    ).then(() => {
                        if (response.Status == 200) {
                            if (response.PerSonID == '1') {
                                $(`a[onclick="load_page('pages/load_Individuals.php','บุคคลธรรมดา');"]`).trigger('click');
                            } else if (response.PerSonID == '2') {
                                $(`a[onclick="load_page('pages/load_Corporation.php','นิติบุคคล');"]`).trigger('click');
                            } else {
                                $(`a[onclick="load_page('pages/load_Foreigner.php','ชาวต่างชาติ');"]`).trigger('click');
                            }
                        } else {
                            return false;
                        }
                    });


                },
                error: function (res) {
                    alert(res);
                }
            };

            if (SmartOnlineStatus == 1) {
                $.ajax(_postApi);
            } else {

                $('#close-modal').trigger('click');
                document.getElementById('modalNoti').style = 'display:none';

                Swal.fire(
                    '',
                    returnedArray.msg,
                    'success'
                ).then(() => {
                    if (returnedArray.idperson == '1') {
                        $(`a[onclick="load_page('pages/load_Individuals.php','บุคคลธรรมดา');"]`).trigger('click');
                    } else if (returnedArray.idperson == '2') {
                        $(`a[onclick="load_page('pages/load_Corporation.php','นิติบุคคล');"]`).trigger('click');
                    } else {
                        $(`a[onclick="load_page('pages/load_Foreigner.php','ชาวต่างชาติ');"]`).trigger('click');
                    }
                });
            }
        },
        error: function (msg) {
            console.log(msg);
            alert(msg);
        }
    };

    document.getElementById('modalNoti').style = 'display:flex';
    $.ajax(SAVE);
}

createChangeTypeCarEquitment();

async function callcost(data, costval) {
    if (costval != 0) {
        var _select = costval.split('|');
        var _cost = await $.ajax({
            type: "POST",
            dataType: "json",
            url: "ajax/Ajax_More.php",
            data: {
                callajax: 'COST_NEW',
                countmore: $('#COUNTMORE').val(),
                cartype: $("#cartype").val(),
                mo_car: $("#mo_car").val(),
                body_car: $("#new_carbody").val() + '' + $("#car_body").val(),
                n_motor: $("#new_motor").val() + '' + $("#n_motor").val(),
                type: _select[1],
                id_acc: costval,
                mo_car_sub: $("#mo_car_sub").val()
            },
            success: function (msg) {
                return msg;
            }
        });

        if (_cost == null) return false;

        console.log('callcost', _cost);
        var PRICE = $('#id_price' + data);
        var free = $('#add_price' + data);
        var AD = $('#id_acc' + data + ' option:selected');

        PRICE.empty();
        PRICE.append('<option value="0" selected>--กรุณาเลือกราคาอุปกรณ์--</option>');

        for (i = 0; i < _cost.length; i++) PRICE.append(`<option value='${_cost[i].id}'>${_cost[i].name}</option>`);

        if (_cost[0].status_free == 'Y') {
            let kbeer = await genTotalCOSTplusOption();
            console.log('genTotalCOSTplusOption', Object.entries(kbeer));
            let arr = Object.entries(kbeer);
            PRICE.append(`<option value="${_cost[0].id}">เพิ่มทุน</option>`);
            let cal = 30000;
            free.empty();
            free.append(`<option value="0" selected>เลือกราคาอุปกรณ์</option>`)
            /*for (i = 0; i < 8; i++) {
                free.append(`<option value='${cal}'>${cal}</option>`);
                // cal += 10000;
            }*/
            arr.forEach(val => {
                if (val[1].name != '0.00' && Number(val[1].name) > 20000) {
                    free.append(`<option value='${val[0]}'>${Number(val[1].name)}</option>`);
                }
            });
        }

        TotalCOSTplus(data);
        TotalTEXTplus();
    } else {
        $('#id_price' + data).empty();
        $('#id_price' + data).append('<option value="0" selected="selected">--กรุณาเลือกราคาอุปกรณ์--</option>');
        $('#price_acc' + data).val(0);
        TotalCOSTplus(data);
        TotalTEXTplus();
    }
    warningChangeTypeCarEquitment();
}



async function splitcost(data) {

    TotalCOSTplus(data);

    if ($(`#id_price${data} option:selected`).text() == 'เพิ่มทุน') {
        document.getElementById(`forFree${data}`).style.display = "block";
        $("#price_acc_tun").val('');
        $("#price_acc_cost").val('');

    } else {
        document.getElementById(`forFree${data}`).style.display = "none";
        document.getElementById(`add_price${data}`).value = "0";
    }
    TotalTEXTplus();
}

function TotalTEXTplus() {
    let textsave = '';
    for (i = 0; i < 10; i++) {
        if ($('#id_acc' + i).val() != undefined) {
            if (i == 0) {
                console.log('first', $('#add_price' + i).val());
                if ($(`#id_price${i} option:selected`).text() == 'เพิ่มทุน') {
                    textsave = textsave + $('#id_acc' + i).val() + ',' + $('#add_price' + i).val();
                } else {
                    textsave = textsave + $('#id_acc' + i).val() + ',' + $('#id_price' + i).val();
                }
            } else {
                console.log('second', $('#add_price' + i).val());
                if ($(`#id_price${i} option:selected`).text() == 'เพิ่มทุน') {
                    textsave = textsave + '|' + $('#id_acc' + i).val() + ',' + $('#add_price' + i).val();
                } else {
                    textsave = textsave + '|' + $('#id_acc' + i).val() + ',' + $('#id_price' + i).val();
                }
            }
        }
    }
    $("#acc").val(textsave);
}

async function TotalCOSTplus(id) {
    let _res = await $.ajax({
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_More.php",
        data: {
            callajax: 'TOTAL',
            cartype: $("#cartype").val(),
            mo_car: $("#mo_car").val(),
            mo_car_sub: $("#mo_car_sub").val(),
            id_price: $(`#id_price${id}`).val()
        },
        success: function (x) {
            return x;
        }, error: function (x) {
            return null;
        }
    });

    if (_res == null) return false;

    let tot = 0;
    let totPrice = 0;
    let arr = document.getElementsByName('id_price');
    let arrPrice = document.getElementsByName('add_price');
    let _sumTotalPrice = 0;
    let _sumTotal = 0;
    let _sumTotalPremium = 0;
    let _allTotal = 0;

    const last = $("#COUNTMORE").val() - 1;

    for (let index = last; index > -1; index--) {
        const element = arr[index].options[arr[index].selectedIndex].text;
        const _elem = arrPrice[index].options[arrPrice[index].selectedIndex].text;

        if (arr[index].value != 0) {
            _sumTotal += Number(element.replace(',', '')) || 0;
            _sumTotalPremium += (_res[arr[index].value]) ? Number(_res[arr[index].value].price) : 0;
        }

        if (arrPrice[index].value != 0 && element == 'เพิ่มทุน' && _elem != 'เลือกราคา') {
            _sumTotalPrice += Number(_elem.replace(',', '')) || 0;
            _sumTotalPremium += (_res[arrPrice[index].value]) ? Number(_res[arrPrice[index].value].price) : 0;
        }
    }
    _allTotal = Number(_sumTotal + _sumTotalPrice)
    if (_allTotal > 100000) {
        alert("เพิ่มทุนได้ไม่เกิน 100,000 บาท");
        document.getElementById('price_acc_tun').value = "0";
        document.getElementById('price_acc_cost').value = "0";
        for (let index = last; index > -1; index--) {
            arr[index].value = 0;
            arrPrice[index].value = 0;
        }
        return false;
    }
    document.getElementById('price_acc_tun').value = _allTotal;
    document.getElementById('price_acc_cost').value = _sumTotalPremium;
}

function CheckT() {
    come = $('#COUNTMORE').val();
    come = Number(come) - 1;
    var str = come.toString();
    for (i = 0; i <= come; i++) {
        if (
            $('#id_acc' + i).val() == 0) {
            alert('กรุณาเลือกอุปกรณ์ตกแต่ง');
            $('#ADD_MORE').focus();
            return false;
        }
        if ($('#id_price' + i).val() == 0) {
            alert('กรุณาเลือกราคาอุปกรณ์ตกแต่ง');
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

async function customerLastName() {
    try {
        const widthTextBox = parseInt($("#title option:selected").val().length) * parseInt(15);
        if ($("#title option:selected").val() != '' && $("#title option:selected").val() != '0') {
            if ($('#title').val() == ' บริษัท ' || $('#title').val() == ' ห้างหุ้นส่วนจำกัด' || $('#title').val() == ' ห้างหุ้นส่วนสามัญ') {
                $("#TitleCustomer").show().val(`${$("#title option:selected").val()}/จำกัด`);
            } else {
                $("#TitleCustomer").show().val(`${$("#title option:selected").val()}`);
            }
        } else {
            $("#TitleCustomer").hide().val('');
        }
        $("#TitleCustomer").css('width', `${widthTextBox}px`); // ${widthTextBox}px
        if ($('#persons:checked').val() != 2) {
            return false;
        }

        const valTitle = $("#title option:selected").text();
        let params = {
            "Control": 'LastComp',
            "DataTitle": valTitle
        };

        const res = await postApiAsync(params, 'services/CustomerName/CustomerName.controller.php');
        if ($("#persons").is(":checked") == true) {
            if (res.LastCompany != '' || res.ByCustomer != '') {
                // $("#show_last_title").hide();
                $("#show_last_text").show();
                $("#show_last_text").attr('colspan', '2');
                $("#show_name_text").attr('colspan', '1');
                $("#last_text").text('');
                $("#name_name").attr('style', 'width:200px');
                res.ByCustomer != '' ? $("#ByCustomer").show().val(res.ByCustomer) : $("#ByCustomer").hide().val('');
                res.ByCustomer != '' ? $("#last").val('').attr("readonly", false) : $("#last").val(res.LastCompany).attr("readonly", true);
                $("#last").attr('maxlength', parseInt(40) - parseInt($("#ByCustomer").val().length));
            } else {
                $("#last").val('').attr("readonly", true);
                $("#show_last_text").hide();
                $("#show_last_text").attr('colspan', '1');
                $("#show_name_text").attr('colspan', '3');
                $("#last_text").text('');
                $("#name_name").attr('style', 'width:500px;');
                $("#ByCustomer").hide().val('');
                $("#last").attr('maxlength', parseInt(40) - parseInt($("#ByCustomer").val().length));
            }

            if ($('#title').val() == ' ') $("#TitleCustomer").hide();
        }
        return false;
    } catch (err) {
        console.log(err);
    }
}

//สร้างข้อมูลอุปกรณ์ตกแต่งที่เป็นของเปลียนแปลงประเภทรถมารอ เพื่อรอหยิบมาใช้งาน
var _dataEquip = null; //ตัวแปรเก็บข้อมูลมารอ
async function createChangeTypeCarEquitment() {
    try {
        let params = { "Controller": 'CheckChangeTypeEquipment' };
        _dataEquip = await postApiAsync(params, 'services/DecorationEquipmentCar/DecorationEquipmentCar.controller.php');
    } catch (err) {
        alert(err);
        return false;
    }
}

//เรียกข้อมูล ว่า อุปกรณ์ตกแต่งที่เป็นของเปลียนแปลงประเภทรถใช่หรือไม่
async function warningChangeTypeCarEquitment() {
    try {
        // if (_dataEquip == null) {
        //     _dataEquip = await createChangeTypeCarEquitment();
        // }
        const numberIndex = $('#COUNTMORE').val();
        var staChange = 0;
        var textEqu = null;


        for (var i = 0; i < numberIndex; i++) {
            staChange = _dataEquip.ChangeTypeStatus[$(`#id_acc${i}`).val()];

            if (staChange == 1) {
                textEqu = $(`#id_acc${i} option:selected`).text();
                await openForChangeTypeCarEquitment(staChange, textEqu);
                return false;
            }
        }

        await openForChangeTypeCarEquitment(0);
        //console.log('StatusEquipment',dataEquip);

    } catch (err) {
        alert(err);
        return false;
    }
}

//ตัวเปิดและซ่อน Html ที่ไม่ให้ไปต่อ
async function openForChangeTypeCarEquitment(valStatus = 0, valText = null) {
    try {
        let textEqu = `
        ${valText}</br>
        เป็นอุปกรณ์ตกแต่งสำหรับรถโดยสาร กรุณาติดต่อเจ้าหน้าที่ 
        เพื่อเปลี่ยนแปลงประเภทรถยนต์ให้ถูกต้อง
        `;
        if (valStatus == 1) {
            $("#moreDetails").hide();
            $("#warningForEquipmentChangeTypeCar").html(textEqu).show();
            $("#Savenaja").hide();
        } else {
            $("#moreDetails").show();
            $("#warningForEquipmentChangeTypeCar").hide();
            $("#Savenaja").show();
        }
    } catch (err) {
        alert(err);
        return false;
    }
}

async function onkeyicard_clear(selectID) {
    try {
        $("#icard1").val('');
        $("#icard2").val('');
        $("#icard3").val('');
        $("#icard4").val('');
        $("#icard5").val('');
        $("#icard6").val('');
        $("#icard7").val('');
        $("#icard8").val('');
        $("#icard9").val('');
        $("#icard10").val('');
        $("#icard11").val('');
        $("#icard12").val('');
        $("#icard13").val('');
        if (selectID == 1) {
            $("#show_name_title").html('ชื่อ');
            $("#last").val('').attr('readonly', false);
            $("#show_last_title").html('นามสกุล');
            $("#show_last_text").show();
            $("#show_last_text").attr('colspan', '1');
            $("#show_name_text").attr('colspan', '1');
            $("#name_name").attr('style', 'width:200px');
            $("#GroupIdCardSingle").hide();
            $("#GroupIdCardMultiple").show();
            $("#ByCustomer").hide().val('');
            $("#last_text").text('');
            $("#TitleCustomer").hide().val('');
            $("#name_name").attr("placeholder", "");
            $("#last").attr("placeholder", "");
            $("#last").attr('maxlength', parseInt(40) - parseInt($("#ByCustomer").val().length));
        } else if (selectID == 2) {
            $("#show_name_title").html('ชื่อบริษัท');
            $("#last").val('').attr('readonly', true);
            $("#show_last_title").html('.');
            $("#show_last_text").hide();
            $("#show_last_text").attr('colspan', '1');
            $("#show_name_text").attr('colspan', '3');
            $("#name_name").attr('style', 'width:500px;');
            $("#GroupIdCardSingle").hide();
            $("#GroupIdCardMultiple").show();
            $("#ByCustomer").hide().val('');
            $("#last_text").text('');
            $("#TitleCustomer").hide().val('');
            $("#last").attr('maxlength', parseInt(40) - parseInt($("#ByCustomer").val().length));
            $("#name_name").attr("placeholder", "ใส่เฉพาะชื่อบริษัท");
            $("#last").attr("placeholder", "ชื่อกรรมการ 1 ท่าน");
        } else if (selectID == 3) {
            $("#show_name_title").html('ชื่อ');
            $("#last").attr('readonly', false);
            $("#show_last_title").html('นามสกุล');
            $("#show_last_text").show();
            $("#show_last_text").attr('colspan', '1');
            $("#show_name_text").attr('colspan', '1');
            $("#name_name").attr('style', 'width:200px;');
            $("#GroupIdCardMultiple").hide();
            $("#GroupIdCardSingle").show();
            $("#ByCustomer").hide().val('');
            $("#last_text").text('');
            $("#TitleCustomer").hide().val('');
            $("#name_name").attr("placeholder", "");
            $("#last").attr("placeholder", "");
            $("#last").attr('maxlength', parseInt(40) - parseInt($("#ByCustomer").val().length));
        }

        const titleElem = document.querySelector('#title');
        titleElem.innerHTML = '';
        const opFirst = document.createElement('option');
        opFirst.value = 0;
        opFirst.text = 'กรุณาเลือก';
        titleElem.appendChild(opFirst);
        const url = 'services/InsuranceNotificationWork/insurance-notification-work.controller.php';
        const titleRes = await this.postApiAsync({
            Controller: 'getTitleName',
            personType: selectID
        }, url);

        if (titleRes.Status == 200) {
            titleElem.innerHTML = titleRes.Data;
        }
    } catch (e) {
        console.log(e);
    }
}

var CallProv = {
    type: "POST",
    dataType: "json",
    url: "ajax/Ajax_Pro.php",
    data: {
        callajax: "START1",
    },

    success: function (msg) {
        var returnedArray = msg;
        Carprov = $("#province");
        car_regis_pro = $("#car_regis_pro");
        Carprov.append("<option value='0'>กรุณาเลือก</option>");
        car_regis_pro.append("<option value='0'>กรุณาเลือก</option>");
        if (returnedArray != null) {
            for (i = 0; i < returnedArray.length; i++) {
                Carprov.append(
                    "<option value='" +
                    returnedArray[i].Id +
                    "'>" +
                    returnedArray[i].Name +
                    "</option>"
                );
                car_regis_pro.append(
                    "<option value='" +
                    returnedArray[i].Id +
                    "'>" +
                    returnedArray[i].Name +
                    "</option>"
                );
            }
        } else {
            return false;
        }
    },
};
$.ajax(CallProv);

async function loadCarType() {
    const url = 'services/InsuranceNotificationWork/insurance-notification-work.controller.php';
    const ctrlName = { Controller: 'getTypeOfUse' };
    const res = await this.postApiAsync(ctrlName, url);
    return res;

}

async function run() {
    try {
        const carTypeList = await loadCarType();
        console.log(carTypeList);
        const carTypeElem = document.querySelector("#cartype");

        if (carTypeList.Status == 200) {
            carTypeList.Data.forEach((x) => {
                if (x.Id == 1) {
                    const op = document.createElement("option");
                    op.value = x.Id;
                    op.text = x.Name;
                    carTypeElem.appendChild(op);
                }
                // if (x.Id == 2) {
                //     const op = document.createElement("option");
                //     op.value = x.Id;
                //     op.text = x.Name;
                //     carTypeElem.appendChild(op);
                // }
                // if (x.Id == 3) {
                //     const op = document.createElement("option");
                //     op.value = x.Id;
                //     op.text = x.Name;
                //     carTypeElem.appendChild(op);
                // }
            });
        }
    } catch (e) {
        console.log(e);
    }
}

async function getPassCarType(passCarID = 1) {
    const url = 'services/InsuranceNotificationWork/insurance-notification-work.controller.php';
    const data = {
        Controller: 'getPassCarType',
        passCarID: passCarID
    };
    const res = await this.postApiAsync(data, url);
    return res;

}
async function getCatCar(passCarID = 1) {
    const url = 'services/InsuranceNotificationWork/insurance-notification-work.controller.php';
    const data = {
        Controller: 'getCatCar',
        passCarID: passCarID
    };
    const res = await this.postApiAsync(data, url);
    return res;

}
async function getBrandCarAct(passCarID = 1, catCarID = 1) {
    const url = 'services/InsuranceNotificationWork/insurance-notification-work.controller.php';
    const data = {
        Controller: 'getBrandCarAct',
        passCarID: passCarID,
        catCarID: catCarID
    };
    const res = await this.postApiAsync(data, url);
    return res;

}
async function handleBrandCar(data) {
    const brCarElem = document.querySelector('#br_car');
    brCarElem.innerHTML = '';
    const op = document.createElement('option');
    op.value = data.Id;
    op.text = data.Name;
    brCarElem.appendChild(op);
}

async function getModelCar(brandCarID = 1, passCarID = 1) {
    const url = 'services/InsuranceNotificationWork/insurance-notification-work.controller.php';
    const data = {
        Controller: 'getModelCar',
        brandCarID: brandCarID,
        passCarID: passCarID
    };
    const res = await this.postApiAsync(data, url);
    return res;

}
async function handleModelCar(data) {
    const moCarElem = document.querySelector('#mo_car'); // 1993 2089
    moCarElem.innerHTML = '';
    moCarElem.innerHTML = '<option value="0">กรุณาเลือก</option>';
    data.forEach(x => {
        const op = document.createElement('option');
        op.value = x.Id;
        op.text = x.Name;
        moCarElem.appendChild(op);
    });
}
async function loadCarColor() {
    const url = 'services/InsuranceNotificationWork/insurance-notification-work.controller.php';
    const ctrlName = {
        Controller: 'getCarColor',
        color: "mock"

    };
    const res = await this.postApiAsync(ctrlName, url);
    return res;

}
async function runCarcolor() {
    const carTypeList = await loadCarColor();

    const carTypeElem = document.querySelector('#car_color');
    if (carTypeList.Status == 200) {
        carTypeList.Data.forEach(x => {
            const op = document.createElement('option');
            op.value = x;
            op.text = x;
            carTypeElem.appendChild(op);
        });
    }
}
async function genTotalCOSTplusOption() {
    let _res = await $.ajax({
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_More.php",
        data: {
            callajax: 'TOTAL',
            cartype: $("#cartype").val(),
            mo_car: $("#mo_car").val(),
            mo_car_sub: $("#mo_car_sub").val()
        },
        success: function (x) {
            return x;
        }, error: function (x) {
            return false;
        }
    });
    return _res;
}
run();
runCarcolor();
