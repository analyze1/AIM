<script>
function testSaveModal() {
    Swal.fire({
        type: 'success',
        title: 'กำลังบันทึกข้อมูล',
        showConfirmButton: false,
        timer: 3000
    })

    //Swal.fire(`<span>ระบบ กำลังบันทึก และออก พ.ร.บ กรุณารอสักครู่...</span>`);

}

$("#mo_car").change(function() {
    $('#mo_car_sub').css('display', '');
    $('#mo_dev').css('display', '');
    var _mocar = $('#mo_car').val();
    var _cartype = $("#cartype").val();
    var CallCom = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_Cost.php",
        data: {
            callajax: 'START',
            status_sub: '1',
            mo_car: _mocar,
            cartype: _cartype
        },

        success: function(msg) {

            var returnedArray = msg;
            $("#costCost").empty();
            $("#costCost").append("<option value='0'>-------------------</option>");
            $("#mo_car_sub").html(returnedArray.mo_sub_show);
            com_data = $("#com_data");
            com_data.empty();
            com_data.append("<option value='0'>--กรุณาเลือกบริษัท--</option>");
            if (returnedArray != null) {

                for (i = 0; i < returnedArray.length; i++) {
                    com_data.append("<option value='" + returnedArray[i].sort + "'>" + returnedArray[i]
                        .name + "</option>");

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
    $.ajax(CallCom);

    $("#costPre").val('0.00');
    $("#costStamp").val('0.00');
    $("#costTax").val('0.00');
    $("#costNet").val('0.00');
    $("#com_data").val(0);
});

async function handleCarBodyAndModel(id) {
    let _mo = document.getElementById('cartype').value;
    let _car = document.getElementById('car_id').value;

    console.log(`${_mo}${_car}`)

    let _res = await $.ajax({
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_More.php",
        data: {
            callajax: 'BodyModel',
            carCode: `${_mo}${_car}`,
            carSub: id
        },

        success: function(res) {
            return res;
        }
    });

    return _res;
}

$("#mo_car_sub").change(async function() {

    var _selected = $("#mo_car_sub").val();
    var _input = $("#new_carbody");
    var _input1 = $("#new_motor");
    var car_seat = $("#car_seat");
    var gear = $("#gear");
    var car_cc = $("#car_cc");
    var _body = "";
    var _model = "";

    let _Car = await handleCarBodyAndModel(this.value);

    _Car.carBodyFormat == undefined || _Car.carBodyFormat == "" ? _input.attr("placeholder", "ไม่พบเลขตัวถัง") : _input.val(`${_Car.carBodyFormat}`);
    _Car.carModelFormat == undefined || _Car.carModelFormat == "" ? _input1.attr("placeholder", "ไม่พบเลขตัวถัง") : _input1.val(`${_Car.carModelFormat}`);

    var new_mo = _selected;
    <?php
        $mo_sql = "SELECT * FROM tb_mo_car WHERE status = 'T'";
        $mo_query = $_contextMitSu->query($mo_sql)->fetchAll(2);
        $rows = 0;

        foreach ($mo_query as $mo_array) {
            $mo_check_sql = "SELECT * FROM tb_mo_car_sub WHERE mo_car = '" . $mo_array['id'] . "'";
            $mo_check_query = $_contextMitSu->query($mo_check_sql)->fetchAll(2);
            foreach ($mo_check_query as $mo_check_array) {
                $rows++;
                $exp_array = explode("|", $mo_check_array['body']);
                $expnn_array = explode("/", $mo_check_array['desc']);
                if ($rows == 1) {     ?>
    if (_selected == "<?php echo  $mo_check_array['id']; ?>") {
        // _input.val(`${_Car.carBodyFormat}`);
        // _input1.val(`${_Car.carModelFormat}`);
        gear.empty();
        gear.append("<option value='A'>อัตโนมัติ</option>");
        car_seat.empty();
        car_seat.append(
            "<option value='<?php echo  $expnn_array[0]; ?>'>ไม่เกิน <?php echo  $expnn_array[0]; ?> ที่นั่ง</option>"
        );
        car_cc.empty();
        car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
    }
    <?php } else { ?>
    else if (_selected == "<?php echo  $mo_check_array['id']; ?>") {
        // _input.val(`${_Car.carBodyFormat}`);
        // _input1.val(`${_Car.carModelFormat}`);
        gear.empty();
        gear.append("<option value='A'>อัตโนมัติ</option>");
        car_seat.empty();
        car_seat.append(
            "<option value='<?php echo  $expnn_array[0]; ?>'>ไม่เกิน <?php echo  $expnn_array[0]; ?> ที่นั่ง</option>"
        );
        car_cc.empty();
        car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
    }
    <?php }
            }
        } ?>

});

async function mo_sub_start() {
    let _subCar = [980,979,978,977,976,975,974,973,972,971,970,968,966,964,981,2089];

    var mo_ajax = {
        url: "ajax/ajax_mo_car_sub.php",
        dataType: "json",
        type: "post",
        data: {
            mo_sub: $("#mo_car_sub").val()
        },
        success: function(data) {
            $("#cost_array").html(`
                <div class="cost" style="font-size: 1.5rem !important;font-weight: 700;">
                    ทุน&nbsp;<font color="#FF0000" id="showCost"> ${data.cost_text}</font>&nbsp;บาท
                </div>
            `);

            $("#com_data").html(data.com_data);
            $("#costCost").html(data.cost_array);
            $("#costPre").val(data.costpre);
            $("#costStamp").val(data.coststamp);
            $("#costTax").val(data.costtax);
            $("#costNet").val(data.costnet);
            $("#gear").html(data.cost_gear);

            $('#finance_add_tun').val('0');
            $('#finance_add_tun_price').val('0.00');
            $('#finance_custom_tun').val('0');

            let id = document.getElementById('mo_car_sub').value;
            let dats;
            const greaterThanTen = _subCar.find(e=>{
                if(e==id) {
                    dats = true;
                }
            });
            if(dats) {
                document.getElementById('car_color').value = 'ขาวมุก';
            } else {
                document.getElementById('car_color').value = 'ไม่ระบุ';
            }
            return data;
        }
    };
    let res = await $.ajax(mo_ajax);
    console.log('mo_sub_start',res);

    await genOptionInsuranceCapital();
    await $("#costCost").val(res.cost_first_id)
}
// $('#com_data').click(function() {
//     var mocar_sub = $('#mo_car_sub').val();
//     if (mocar_sub == '0') {
//         alert('กรูณาเลือกรุ่นรถย่อย');
//         $('#mo_car_sub').focus();
//     }
// });

function addon_start(ch) {
    var array_addon;
    var total_addon = 0;
    var ch_addon = 0;
    var n;
    <?php
        $select_add_sql = "SELECT * FROM tb_addon WHERE star_date <= '" . date('Y-m-d') . "' AND end_date >= '" . date('Y-m-d') . "'";
        $select_add_query = $_contextMitSu->query($select_add_sql)->fetchAll(2);
        foreach ($select_add_query as $select_add_array) { ?>
    for (n = 0; n < document.getElementsByName("addon_buy[]").length; n++) {
        if (array_addon = document.getElementsByName("addon_buy[]")[n].checked == true) {
            array_addon = document.getElementsByName("addon_buy[]")[n].value.split(",");
            if (array_addon[2] == '<?php echo $select_add_array['code_addon']; ?>') {
                ch_addon++;
            }
        }
    }
    if (ch_addon > 1) {
        alert('<?php echo $select_add_array['name_addon']; ?> คุณเลือกซื้อได้อย่างใดอย่างหนึ่งเท่านั้นครับ');
        array_addon = document.getElementsByName("addon_buy[]")[ch].checked = false;
        return false;
    }
    ch_addon = 0;
    <?php } ?>

    for (n = 0; n < document.getElementsByName("addon_buy[]").length; n++) {
        if (document.getElementsByName("addon_buy[]")[n].checked == true) {
            array_addon = document.getElementsByName("addon_buy[]")[n].value.split(",");
            total_addon += parseFloat(array_addon[1]);
        }
    }
    $("#costIns").val(total_addon);
}

function js_showsendadd() {
    if ($("#send_add_Y:checked").val() == 'Y') {
        $("#show_addsend").slideDown();
    } else if ($("#send_add_N:checked").val() == 'N') {
        $("#show_addsend").slideUp();
    }
}

function js_proshow(level, datapost, go, come) {
    var retu = "";
    if (datapost == 'province') {
        $("#send_amphur").html('<option value="">--กรุณาเลือก--</option>');
        $("#send_tumbon").html('<option value="">--กรุณาเลือก--</option>');
        $("#send_post").html('<option value="">--กรุณาเลือก--</option>');
        retu = {

            url: "ajax/Ajax_Pro.php",
            type: "POST",
            dataType: "JSON",
            data: {
                province: $("#" + go).val(),
                callajax: level
            },
            success: function(data) {
                var datahtml = '<option value="">--กรุณาเลือก--</option>';
                for (var n = 0; n < data.length; n++) {
                    datahtml += '<option value="' + data[n].Id + '">' + data[n].Name + '</option>';
                }
                $("#" + come).html(datahtml);
            }
        };
    } else if (datapost == 'amphur') {
        $("#send_tumbon").html('<option value="">--กรุณาเลือก--</option>');
        $("#send_post").html('<option value="">--กรุณาเลือก--</option>');
        retu = {

            url: "ajax/Ajax_Pro.php",
            type: "POST",
            dataType: "JSON",
            data: {
                amphur: $("#" + go).val(),
                callajax: level
            },
            success: function(data) {
                var datahtml = '<option value="">--กรุณาเลือก--</option>';
                for (var n = 0; n < data.length; n++) {
                    datahtml += '<option value="' + data[n].Id + '">' + data[n].Name + '</option>';
                }
                $("#" + come).html(datahtml);
            }
        };
    } else if (datapost == 'tumbon') {
        $("#send_post").html('<option value="">--กรุณาเลือก--</option>');
        retu = {

            url: "ajax/Ajax_Pro.php",
            type: "POST",
            dataType: "JSON",
            data: {
                tumbon: $("#" + go).val(),
                callajax: level
            },
            success: function(data) {
                var datahtml = '<option value="">--กรุณาเลือก--</option>';
                for (var n = 0; n < data.length; n++) {
                    datahtml += '<option value="' + data[n].Id + '"  selected >' + data[n].Name + '</option>';
                }
                $("#" + come).html(datahtml);
            }
        };
    }
    $.ajax(retu);
}

$("#checkAddonN").trigger("click");

function savenaja() {  
    $("#Savenaja").attr('disabled', true);
    var _actNo = $("#p_act3").val();
    var check_act = {
        url: "ajax/ajax_check_act.php",
        dataType: "JSON",
        type: "POST",
        data: {

        },
        success: function(data) {

            if (data.status == 'Y') {
                alert(data.alert_act);
                $("#p_act3").val(data.act_no_ja);
                $("#p_act3").focus();
                $("#Savenaja").attr('disabled', false);
            } else {

                $("#SaveInsurance").trigger("click");
                $("#Savenaja").attr('disabled', false);
            }
        },
        error: function() {
            alert('บันทึกข้อมูลล้มเหลว รบกวนเข้าสู่ระบบใหม่ด้วยครับ');
            $("#Savenaja").attr('disabled', false);
        }
    };

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
                // document.getElementById('modalNoti').style = 'display:block';
                $("#Savenaja").attr('disabled', true);
                $.ajax(check_act);
            }
        });
    } else {
        // document.getElementById('modalNoti').style = 'display:block';
        $("#Savenaja").attr('disabled', true);
        $.ajax(check_act);
    }
}


function checkID_test(id) {
    if (id.length != 13) return false;
    for (i = 0, sum = 0; i < 12; i++)
        sum += parseFloat(id.charAt(i)) * (13 - i);
    if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12)))
        return false;
    return true;
}

function onkeyicard(id, id1, event) {
    if (event.which == 37 || event.which == 38 || event.which == 39 || event.which == 40) {
        return false;
    }
    if ($('#person').is(':checked')) {
        if ($("#" + id1).val().search(/^[0-9]{0,9}$/)) {
            $("#" + id1).val('');
            $("#" + id1).focus();
        }
    }
    if (event.keyCode == 8) {
        $("#icard13").val('');
        $("#icard12").val('');
        $("#icard11").val('');
        $("#icard10").val('');
        $("#icard9").val('');
        $("#icard8").val('');
        $("#icard7").val('');
        $("#icard6").val('');
        $("#icard5").val('');
        $("#icard4").val('');
        $("#icard3").val('');
        $("#icard2").val('');
        $("#icard1").val('');
        $("#icard1").focus();
        $("#icard").val('');
    }
    if ($("#" + id1).val() == '') {
        return false;
    }
    if (id != '') {
        $("#" + id).val('');
        $("#" + id).focus();

    }
    var icard_val = $("#icard1").val() + '' + $("#icard2").val() + '' + $("#icard3").val() + '' + $("#icard4").val() +
        '' + $("#icard5").val() + '' + $("#icard6").val() + '' + $("#icard7").val() + '' + $("#icard8").val() + '' + $(
            "#icard9").val() + '' + $("#icard10").val() + '' + $("#icard11").val() + '' + $("#icard12").val() + '' + $(
            "#icard13").val();
    $("#icard").val(icard_val);
    if ($('#person').is(':checked') && icard_val != '' && icard_val.length == 13) {
        if (!checkID_test($('#icard').val())) {
            alert('รหัสประชาชนไม่ถูกต้อง');
            $('#icard').val('');
            $('#icard1').focus();
            onkeyicard_clear(1);
        }
    }


}

function getDataMobileNo(id, id1, event) {
    if (event.which == 37 || event.which == 38 || event.which == 39 || event.which == 40) {
        return false;
    }
    if ($('#person').is(':checked')) {
        if ($("#" + id1).val().search(/^[0-9]{0,9}$/)) {
            $("#" + id1).val('');
            $("#" + id1).focus();
        }
    }
    if (event.keyCode == 8) {
        $("#TelNo10").val('');
        $("#TelNo9").val('');
        $("#TelNo8").val('');
        $("#TelNo7").val('');
        $("#TelNo6").val('');
        $("#TelNo5").val('');
        $("#TelNo4").val('');
        $("#TelNo3").val('');
        $("#TelNo2").val('');
        $("#TelNo1").val('');
        $("#TelNo1").focus();
        $("#tel_mobi").val('');
    }
    if ($("#" + id1).val() == '') {
        return false;
    }
    if (id != '') {
        $("#" + id).val('');
        $("#" + id).focus();

    }
    var telMobileNo = $("#TelNo1").val() + '' + $("#TelNo2").val() + '' + $("#TelNo3").val() + '' + $("#TelNo4").val() +
        '' + $("#TelNo5").val() + '' + $("#TelNo6").val() + '' + $("#TelNo7").val() + '' + $("#TelNo8").val() + '' + $(
            "#TelNo9").val() + '' + $("#TelNo10").val();
    $("#tel_mobi").val(telMobileNo);
}



function number_length(name, name_text, maxlength) {
    var value_edit = $("#" + name).val();
    var valie_subedit = '';
    var num_length = '';
    if ($("#" + name).val().length > maxlength) {
        $('#' + name_text).attr('style', 'color:RED !important;');
        valie_subedit = value_edit.substring(0, ($("#" + name).val().length - 1));
        //alert(valie_subedit);
        $("#" + name).val(valie_subedit);
        return false;
    } else if ($("#" + name).val().length == maxlength) {
        $('#' + name_text).attr('style', 'color:RED !important;');
    } else {
        $('#' + name_text).attr('style', 'color:#FFFFFF !important;');
    }
    num_length = $("#" + name).val().length;
    $('#' + name_text).html(num_length + '/' + maxlength);
}

var inset = 0;

setInterval(function() {
    if (inset == 0) {
        $('#color_infinity').addClass('font_inform_new');
        $('#color_hotline').addClass('font_inform_new');
        inset++;
    } else {
        $('#color_infinity').removeClass('font_inform_new');
        $('#color_hotline').removeClass('font_inform_new');
        inset--;
    }

}, 500);

function getFactoryEquipment() {
    let getArrFactoryAcc = JSON.parse(_accesForce);
    let idMocarSub = $("#mo_car_sub").val();
    let NameMocarSub = $("#mo_car_sub :selected").html();
    for (var datas of getArrFactoryAcc) {
        if (datas.mo_sub == idMocarSub) {
            $("#getDataAccesForceShow").show();
            $("#getDataAccesForceShow").html(datas.name);
            return false;
        }
    }
    $("#getDataAccesForceShow").html('');
    $("#getDataAccesForceShow").hide();
    console.log('arrCar', getArrFactoryAcc);
}

async function genOptionInsuranceCapital(){
    let moCar = $('#mo_car_sub').val();
    let _res = await $.ajax({
        type: "POST",
        dataType: "json",
        url: "services/InsuranceNotificationWork/insurance-notification-work.controller.php",
        data: {
            Controller: 'genOption-InsuranceCapital',
            carSub: moCar
        },
        success: function(res) {
            return res;
        },        
        error: function(e){
            return false;
        }
    });
    let selectCapital = $('#costCost');
    selectCapital.empty();
    if(_res.status != 200){
        _res.Data.forEach(element => {
            selectCapital.append(`<option value="${element.id}">${element.cost}</option>`);                 
        });           
    }
    console.log('genOptionInsuranceCapital',_res);
}


$('#costCost').change(function (){

    let x = document.getElementById('costCost');
    console.log('option',x);
    let showCost = x.options[x.selectedIndex].text;
    console.log(showCost);
    $('#showCost').text(showCost);

});
</script>