<script>
var start = '<?php echo $result['send_date']; ?>';
var _dataID = '<?php echo $_GET['id']; ?>';
var _startDate = new Date(start);
var _now = new Date();
var _elem = document.querySelectorAll('.hiddenByMount');
var _quotationSms = null;
var _typeDocuments = null;
var _telNumberArr = [];
var _detailID = null;
var _dataIDQ = $('#OQ').val();
var _dealerCode = '<?php echo $_resultDatas->userType; ?>';
//console.log('ค่าคอมใหม่',_NewAgentdis);
class TelCustomerAdd {
    Number;
    Status;
    Detail;
    Name;
    Relation;
    DataID;

    constructor(id) {
        this.DataID = id;
    }
}

var _cusAddModel = new TelCustomerAdd(_dataID); //สร้างmodelเก็บ tag เพิ่มเบอร์โทรศัพท์

async function postApiAsync(_url, _data) {
    return await $.ajax({
        type: "POST",
        url: _url,
        data: _data,
        dataType: "JSON",
        success: (response) => {
            return response;
        },
        error: (err) => {
            return err;
        }
    });
}

async function postApiAsyncHtml(_url, _data) {
    return await $.ajax({
        type: "POST",
        url: _url,
        data: _data,
        dataType: "HTML",
        success: (response) => {
            return response;
        },
        error: (err) => {
            return err;
        }
    });
}

handleDiffDate = (start, now) => {
    let difference = (now - start);

    let days = Math.floor(difference / (60 * 60 * 1000 * 24) * 1);
    let years = Math.floor(days / 365);
    if (years > 1) {
        days = days - (years * 365)
    }

    // console.log(`diff : ${days}`);

    days <= 90 ? _elem.forEach(x => {
        x.style.display = 'none'
    }) : _elem.forEach(x => {
        x.style.display = 'block'
    });
}

handleDiffDate(_startDate, _now);

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

async function checkTelMainCus(event) {
    try {
        let _elem = ``;
        const cThis = event.target;
        if (cThis.value == '5') {
            _elem = `
                <div style="text-align: left;">
                    <select id="statusFollow" name="statusFollow">
                        <option value="" selected disabled>--กรุณาเลือก--</option>
                        <option value="ระงับการใช้งาน">ระงับการใช้งาน</option>
                        <option value="เบอร์ดีลเลอร์">เบอร์ดีลเลอร์</option>
                        <option value="เบอร์เซลส์">เบอร์เซลส์</option>
                    </select>
                </div>
                <div>
                    <textarea id="Details" style="width: 100%; box-sizing: border-box;" name="Details" rows="2" cols="5"></textarea>
                </div>
            `;
        } else {
            _elem = `
                <div style="text-align: left;display: none;">
                    <select id="statusFollow" name="statusFollow">
                        <option value="" selected></option>
                    </select>
                </div>
                <div>
                    <textarea id="Details" style="width: 100%; box-sizing: border-box;display: none;" name="Details" rows="2" cols="5"></textarea>
                </div>
            `;
        }
        const resSwal = await Swal.fire({
            title: 'ต้องการบันทึกใช่ หรือไม่?',
            text: "บันทึกรายละเอียดเบอร์โทรศัพท์",
            type: 'warning',
                html: `${_elem}`,  
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
            showLoaderOnConfirm: true
        }).then(async (response) => {
            return response;
        });
        if (resSwal.value) {
            const url = './services/QuotationRenew/renew.controller.php';
            const cThis = event.target;
            const cThisClass = cThis.getAttribute('class').split(' ')[1];
            const chBoxBar = document.querySelectorAll(`.${cThisClass}`);

            chBoxBar.forEach(xbar => {
                xbar.checked = false;
            });
            cThis.checked = true;

            const telObj = _telNumberArr.find(t => {
                if (t.id == cThisClass) return t;
            });

            const param = {
                Controller: 'UpdateStatusTel',
                DataID: _dataID,
                Number: telObj.number,
                Pointer: cThis.value,
                StatusFollow: document.getElementById('statusFollow').value,
                Details: document.getElementById('Details').value
            };
            const result = await postApiAsync(url, param);

            if (result.Status == 200) {
                Swal.fire('', 'ตั้งค่าสำเร็จ', 'success');
            } else {
                Swal.fire('', 'ตั้งค่าไม่สำเร็จ', 'error');
            }
        } else {
            const cThis = event.target;
            cThis.checked = false;
        }
    } catch (err) {
        console.log(err);
    }
}

async function getRelationship() {
    const url = './services/QuotationRenew/renew.controller.php';
    const param = {
        Controller: 'GetRelationshipRenew',
    };
    const result = await this.postApiAsync(url, param);
    return result;
}

function blackList(event) {
    const ev = event.target.value;
    const divElem = document.querySelector('#d-b-l');
    if (ev == 'Blacklist') {
        const textElem = document.createElement('input');
        textElem.type = 'text';
        textElem.setAttribute('placeholder', 'กรุณาใส่เหตุผล');
        textElem.setAttribute('style', 'margin-top: 6.4em');
        divElem.appendChild(textElem);
        _cusAddModel.Detail = textElem;
    } else {
        divElem.innerHTML = '';
    }
}


async function saveTelCus() {
    const resSwal = await Swal.fire({
        title: 'ต้องการบันทึกใช่ หรือไม่?',
        text: "บันทึกเบอร์โทรศัพท์ ลูกค้า",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก',
        showLoaderOnConfirm: true
    }).then(async (response) => {
        return response;
    });

    if (resSwal.value) {
        const url = './services/QuotationRenew/renew.controller.php';
        const param = {
            Controller: 'SaveTelCustomerRenew',
            Name: _cusAddModel.Name.value,
            Detail: _cusAddModel.Detail == undefined ? '' : _cusAddModel.Detail.value,
            Number: _cusAddModel.Number,
            Status: _cusAddModel.Status.value,
            Relation: _cusAddModel.Relation.value,
            DataID: _cusAddModel.DataID
        };

        //console.log(param);

        const res = await this.postApiAsync(url, param);
        if (res.Status == 200) {
            Swal.fire('', 'บันทึก สำเร็จ', 'success');
            await $('.btn-cloes-modal-sms').trigger('click');
            await loadTelCustomer();
        } else {
            Swal.fire('', 'บันทึก ไม่สำเร็จ', 'error');
        }
    }
}

/********** LIB กรอกเบอร์โทรศัพท์ ทีละหมายเลข  **********************************************************/
function chkTelNumber(event) {
    const inputs = $('.number-tel');
    let key = event.keyCode || event.charCode;
    if (key != 32 && event.target.value != '') {
        if (_cusAddModel.Number.length < 10) {
            _cusAddModel.Number += inputs.eq(inputs.index(this)).val();
            //console.log(_cusAddModel.Number);
        }
        inputs.eq(inputs.index(this) + 1).focus();
    }

    if (key == 8 || key == 47) {
        let indexNum = inputs.index(this);
        _cusAddModel.Number = _cusAddModel.Number.substr(0, (_cusAddModel.Number.length) - 1);
        if (indexNum != 0) {
            inputs.eq(inputs.index(this) - 1).val('').focus();
        }
    }
}


async function detailAddPhoneNumber() {
    try {
        let opArr = ['SMS', 'Blacklist', 'WhiteList/ใช้งาน', 'ไม่แน่ใจ'];
        let mainDiv = document.querySelector('#add-p-c');
        let mainDivR = document.querySelector('#d-b-l');
        let labelTel = document.createElement('label');
        let labelStatus = document.createElement('label');
        let labelName = document.createElement('label');
        let inputName = document.createElement('input');
        let labelRelation = document.createElement('label');
        let spanBar = document.createElement('span');
        let selectStatus = document.createElement('select');
        let selectRelation = document.createElement('select');
        let inputArr = [];

        _cusAddModel.Number = '';
        _cusAddModel.Name = inputName;
        _cusAddModel.Relation = selectRelation;
        _cusAddModel.Status = selectStatus;
        // _cusAddModel.Number = inputNumber;

        spanBar.classList.add('number-s');
        mainDiv.innerHTML = '';
        mainDivR.innerHTML = '';

        inputName.type = 'text';

        labelTel.innerHTML = 'เบอร์โทรศัพท์/มือถือ';
        labelStatus.innerHTML = 'สถานะเบอร์นี้';
        labelName.innerHTML = 'ชื่อลูกค้า/ชื่อเล่น';
        labelRelation.innerHTML = 'ความสัมพันธ์';

        for (let i = 0; i < 10; i++) {
            const input = document.createElement('input');
            input.type = 'text';
            input.setAttribute('maxlength', '1');
            input.classList.add('number-tel');
            input.addEventListener('keyup', chkTelNumber);
            inputArr.push(input);
            if (i == 2 || i == 5) {
                let lbel = document.createElement('label');
                lbel.classList.add('l-number-f');
                lbel.innerHTML = '-';
                inputArr.push(lbel);
            }
        }

        opArr.forEach(x => {
            let option = document.createElement('option');
            option.value = x;
            option.innerHTML = x;
            selectStatus.appendChild(option);
        });

        let relation = await getRelationship();
        relation.Data.forEach(x => {
            let op = document.createElement('option');
            op.value = x.Name;
            op.innerHTML = x.Name;
            selectRelation.appendChild(op);
        });

        inputArr.forEach(inPu => {
            spanBar.appendChild(inPu);
        });

        mainDiv.appendChild(labelTel);
        mainDiv.appendChild(spanBar);
        mainDiv.appendChild(labelStatus);
        mainDiv.appendChild(selectStatus);
        mainDiv.appendChild(labelName);
        mainDiv.appendChild(inputName);
        mainDiv.appendChild(labelRelation);
        mainDiv.appendChild(selectRelation);

        selectStatus.addEventListener('change', blackList);
    } catch (err) {
        console.log(err);
        alert(err.message);
    }
}

async function loadTelCustomer() {
    try {
        const url = './services/QuotationRenew/renew.controller.php';
        const param = {
            Controller: 'GetTelNumberCus',
            DataID: _dataID
        };
        const result = await this.postApiAsync(url, param);
        if (result.Status == 200) {
            let telBar = document.querySelector('.telCusInfoID');
            telBar.innerHTML = '';
            let pointer = 1;
            let arrcheckBoxID = [];
            let _roundData = result.Data.length;
            result.Data.forEach(val => {

                if (val.Number != '') {
                    let div = document.createElement('div');
                    let span1 = document.createElement('span');
                    let span2 = document.createElement('span');
                    let span3 = document.createElement('span');
                    let spanSMS = document.createElement('span');
                    let spanSMSCall = document.createElement('span');
                    let spanUse = document.createElement('span');
                    let spanBackList = document.createElement('span');
                    let spanNotConnect = document.createElement('span');
                    let spanFail = document.createElement('span');
                    let spanBtnAddNumebr = document.createElement('span');
                    let input1 = document.createElement('input');
                    let input2 = document.createElement('input');
                    let chBoxSms = document.createElement("input");
                    let chBoxUse = document.createElement("input");
                    let chBoxBackList = document.createElement("input");
                    let chBoxNotConnect = document.createElement("input");
                    let chBoxFail = document.createElement("input");
                    let labelTelSms = document.createElement('label');
                    let labelTelUse = document.createElement('label');
                    let labelTelBackList = document.createElement('label');
                    let labelTelNotConnect = document.createElement('label');
                    let labelTelFail = document.createElement('label');
                    let buttonAdd = document.createElement('button');
                    let labelTelSmsCall = document.createElement('label');
                    let buttonWorimgSms = document.createElement('button');

                    labelTelSms.classList.add('detail-c-b');
                    labelTelSms.innerText = 'SMS';
                    labelTelUse.classList.add('detail-c-b');
                    labelTelUse.innerText = 'ใช้งาน';
                    labelTelBackList.classList.add('detail-c-b');
                    labelTelBackList.innerText = 'ระงับการใช้งาน';
                    labelTelNotConnect.classList.add('detail-c-b');
                    labelTelNotConnect.innerText = 'ติดต่อไม่ได้';
                    labelTelFail.classList.add('detail-c-b');
                    labelTelFail.innerText = 'เบอร์ผิด';

                    /*************** ที่กดโทรศัพท์จะเด้ง modal บันทึกและ มีการเก็บ memmo การโทร *******************************/
                    labelTelSmsCall.innerHTML =
                        `<a class="btn btn-success btn-small" style="width: 30px !important;" href="tel:${val.Number}" 
                        onclick="slide_open();telSaveLog('${val.Number}')" >
                        <img src="./assets/img/Call_Icon.png" style="width: 0.8rem;"/></a>`;
                    /*************** ที่กดโทรศัพท์จะเด้ง modal บันทึกและ มีการเก็บ memmo การโทร *******************************/

                    chBoxSms.setAttribute("type", "checkbox");
                    chBoxSms.classList.add('c-box-t-m');
                    chBoxUse.setAttribute("type", "checkbox");
                    chBoxUse.classList.add('c-box-t-m');
                    chBoxBackList.setAttribute("type", "checkbox");
                    chBoxBackList.classList.add('c-box-t-m');
                    chBoxNotConnect.setAttribute("type", "checkbox");
                    chBoxNotConnect.classList.add('c-box-t-m');
                    chBoxFail.setAttribute("type", "checkbox");
                    chBoxFail.classList.add('c-box-t-m');


                    let pointerID = 'telMainID' + pointer;
                    chBoxSms.classList.add(pointerID);
                    chBoxUse.classList.add(pointerID);
                    chBoxBackList.classList.add(pointerID);
                    chBoxNotConnect.classList.add(pointerID);
                    chBoxFail.classList.add(pointerID);
                    arrcheckBoxID.push(`.${pointerID}`);

                    _telNumberArr.push({
                        id: pointerID,
                        number: val.Number
                    });

                    spanSMS.classList.add('detail-c-s');
                    spanSMSCall.classList.add('detail-c-s');
                    spanUse.classList.add('detail-c-s');
                    spanBackList.classList.add('detail-c-s');
                    spanNotConnect.classList.add('detail-c-s');
                    spanFail.classList.add('detail-c-s');
                    spanBtnAddNumebr.classList.add('detail-c-s');

                    div.classList.add('mrpd10');
                    span1.classList.add('dttext');
                    input1.type = 'text';
                    input2.type = 'text';
                    input1.readOnly = true;
                    input2.readOnly = true;
                    input1.classList.add('tel-t-1');
                    input1.classList.add('m-0');
                    input2.classList.add('tel-t-2');
                    input2.classList.add('m-0');
                    input2.classList.add('telID');

                    chBoxSms.checked = val.StatusMain == 1 ? true : false;
                    chBoxUse.checked = val.StatusMain == 2 ? true : false;
                    chBoxBackList.checked = val.StatusMain == 3 ? true : false;
                    chBoxNotConnect.checked = val.StatusMain == 4 ? true : false;
                    chBoxFail.checked = val.StatusMain == 5 ? true : false;

                    chBoxSms.value = 1; //SMS
                    chBoxUse.value = 2; //ใช้งาน
                    chBoxBackList.value = 3; //BackList
                    chBoxNotConnect.value = 4; //ติดต่อไม่ได้
                    chBoxFail.value = 5; //เบอร์ผิด

                    input1.value = val.Detail;
                    input2.value = val.HidenNumber;

                    chBoxSms.classList.add('m-0');
                    chBoxUse.classList.add('m-0');
                    chBoxBackList.classList.add('m-0');
                    chBoxNotConnect.classList.add('m-0');
                    chBoxFail.classList.add('m-0');
                    labelTelSmsCall.classList.add('m-0');

                    span2.appendChild(input1);
                    span3.appendChild(input2);
                    spanSMS.appendChild(chBoxSms);
                    spanSMS.appendChild(labelTelSms);

                    spanUse.appendChild(chBoxUse);
                    spanUse.appendChild(labelTelUse);
                    spanBackList.appendChild(chBoxBackList);
                    spanBackList.appendChild(labelTelBackList);
                    spanNotConnect.appendChild(chBoxNotConnect);
                    spanNotConnect.appendChild(labelTelNotConnect);
                    spanFail.appendChild(chBoxFail);
                    spanFail.appendChild(labelTelFail);
                    spanSMSCall.appendChild(labelTelSmsCall);


                    span1.appendChild(span2);
                    span1.appendChild(span3);
                    span1.appendChild(spanSMS);
                    span1.appendChild(spanUse);
                    span1.appendChild(spanBackList);
                    span1.appendChild(spanNotConnect);
                    span1.appendChild(spanFail);
                    span1.appendChild(spanSMSCall);
                    if (_roundData == pointer) {

                        if(pointer < 3)
                        {
                            buttonAdd.setAttribute('type', 'button');
                            buttonAdd.setAttribute('data-toggle', 'modal');
                            buttonAdd.setAttribute('data-target', '#addPhoneNumber');
                            buttonAdd.classList.add('btn-add-number');
                            buttonAdd.innerHTML = `<i class="icon-plus"></i>&nbsp;เพิ่มเบอร์`;
                            buttonAdd.addEventListener('click', detailAddPhoneNumber);
                            spanBtnAddNumebr.appendChild(buttonAdd);
                            span1.appendChild(spanBtnAddNumebr);
                        }

                        buttonWorimgSms.setAttribute('type', 'button');
                        buttonWorimgSms.setAttribute('data-toggle', 'modal');
                        buttonWorimgSms.setAttribute('data-target', '#sendSmsQuotation');
                        buttonWorimgSms.style = 'margin-left:10px';
                        buttonWorimgSms.classList.add('btn-warning-number');
                        buttonWorimgSms.innerHTML = `<i class="icon-plus"></i>&nbsp;ส่ง SMS แจ้งเตือนมิจฉาชีพ`;
                        buttonWorimgSms.addEventListener('click', ()=>
                        {
                            sendSMSQuotationDealer(_dataID,'','W');
                        });
                        spanBtnAddNumebr.appendChild(buttonWorimgSms);
                        span1.appendChild(spanBtnAddNumebr);



                    }

                    div.appendChild(span1);

                    telBar.appendChild(div);
                    pointer++;
                }
            });

            arrcheckBoxID.forEach(box => {

                document.querySelectorAll(box).forEach(c => {

                    c.addEventListener('click', checkTelMainCus);
                });
            });

        }
    } catch (error) {
        console.log(error);
        alert(error);
        alert(error.responseText);
    }
}

function sendRenewFrist() {
    try {
        alert('sms first');
    } catch (err) {
        console.log(err);
    }
}

async function telSaveLog(telNumber) {
    let url = './services/OutboundLog/outbound.controller.php';
    let params = {
        Controller: 'SaveInboundLog',
        Number: telNumber,
        DataID: _dataID,
        DealerCode: _dealerCode
    };

    let res = await postApiAsync(url, params);
}
async function sendQuotationByDealer(type = false) {

    try {
        const resSwal = await Swal.fire({
            title: 'ต้องการส่งSMS ใช่ หรือไม่?',
            text: "ส่ง SMS เสนอราคาลูกค้า",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
            showLoaderOnConfirm: true
        }).then(async (response) => {
            return response;
        });

        if (resSwal.value) {
            const url = './services/QuotationRenew/renew.controller.php';
            const t = _quotationSms;
            let total = [];

            let numberChkList = document.querySelectorAll('#renew-d-i input');
            for (const i of numberChkList) {
                if (i.checked == true) {
                    total.push(i.value);
                }
            }

            let params = null;
            if(type)
            {
                params = {
                Controller: 'SendSmsWarning',
                DataID: _dataID,
                DetailID: _detailID,
                NumberList: total,
                TypeDoc: _typeDocuments
                };
            }
            else
            {
                params = {
                Controller: 'SendSmsQuotationRenew',
                DataID: _dataID,
                DetailID: _detailID,
                NumberList: total,
                TypeDoc: _typeDocuments
                };
            }


            const response = await postApiAsync(url, params);
            if (response.Status == 200) {
                Swal.fire('', 'ส่ง SMS สำเร็จ', 'success');
                $('.btn-cloes-modal-sms').trigger('click');
            } else {
                Swal.fire('', 'ส่ง SMS ไม่สำเร็จ', 'error');
            }
            // console.log(response);
        }
    } catch (err) {
        console.log(err);
        alert(err.message);
        alert(err.responseText);
    }
}

async function viewCostSet(type) {
    try {
        $('#P1').empty();
        $('#P2').empty();
        $('#P3').empty();
        $('#P4').empty();
        $('#P5').empty();
        const url = 'ajax/ajax_view_suzuki_renew.php';
        const params = {
            regis_date: $('#costfix').val(),
            mo_car: $('#mocarid').val(),
            end_date: $('#end_date').val(),
            cost_new: $('#cost_new').val(),
            carid: $('#car_id').val(),
            txt_loss: $('#txt_loss').val(),
            txt_policy: $('#txt_policy').val(),
            car_regis_pro: $('#car_regis_pro').val(),
            claimall: $('#claimall').val(),
            costdataOld: $('#costdataOld').val(),
            insured_type: type
        };
        const result = await postApiAsyncHtml(url, params);
        if (result != '') {
            $('#P' + type).html(result);
        } else {
            $('#P' + type).html(
                "<br><br><center><font color='RED' size='4'>ไม่มี package!</font></center><br><br>");
        }
    } catch (err) {
        console.log(err);
        alert(err.responseText);
    }
}

jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    "date-th2-pre": function(a) {
        var x;
        if ($.trim(a) !== '') {
            // a คือข้อความวันที่ใน column ของแต่ละแถว
            // ส่วนนี้จะเป็นส่วนแยก เอาค่าต่างๆ ไปใช้สร้างวันที่
            var dateData = $.trim(a);
            var d_date = dateData.split("/");
            var yearVal = d_date[2] - 543;
            // จบการแยกค่าต่างๆ ออกจากข้อความ
            var myDate = new Date(yearVal, d_date[1] - 1, d_date[0], 0, 0, 00, 000);
            // เราจะเก็บวันที่ที่ถูกแปลงเป็นตัวเลขด้วย myDate.getTime() ไว้ในตัวแปร x
            // ไว้สำหรับเทียบค่ามากกว่า น้อยกว่า
            x = (myDate.getTime()) * 1;

        } else {
            // ภ้าช่องนั้นมีค่าเป็นว่าง กำหนดเป็น x เป็น Infinity
            x = Infinity;
        }
        // คืนค่ารูปแบบวันที่ที่ถูกแปลงเป็นตัวเลข เพื่อนำไปจัดเรียง
        return x;
    },
    "date-th2-asc": function(a, b) { // กรณีให้เรียงจากน้อยไปมาก
        return a - b;
    },
    "date-th2-desc": function(a, b) { // กรณีให้เรียงจากมากไปน้อย
        return b - a;
    }
});

var tables = $('#TableViewLog').DataTable({
    "ajax": 'ajax/ajax_renewdetail_data.php?iddata=' + _dataIDQ,
    "bFilter": false,
    "bInfo": false,
    "destroy": true,
    "aLengthMenu": [7],
    "iDisplayLength": 7,
    "order": [[ 13, "desc" ]],
    "columnDefs": [{
            "type": 'date-th',
            "targets": 0,
            "data": 'timecall',
            'bSortable': false,
            "bSearchable": false
        },
        {
            "targets": 1,
            "name": 'dtr.renew_comp',
            "data": 'renew_comp',
            "defaultContent": ""
        },
        {
            "targets": 2,
            "name": 'dtr.detail_doc_type',
            "data": 'detail_doc_type',
            "defaultContent": ""
        },
        {
            "targets": 3,
            "name": 'dtr.pretotal',
            "data": 'pretotal',
            "defaultContent": ""
        },
        {
            "targets": 4,
            "name": 'dtr.prd',
            "data": 'prb',
            "defaultContent": ""
        },
        {
            "targets": 5,
            "name": 'dtr.sum_pretotal',
            "data": 'sum_pretotal',
            "defaultContent": ""
        },
        {
            "targets": 6,
            "name": 'dtr.status_renew',
            "data": 'status',
            "defaultContent": ""
        },
        {
            "targets": 7,
            "name": 'dtr.detailtext',
            "data": 'detailtext',
            "defaultContent": ""
        },
        {
            "type": "date-th2",
            "targets": 8,
            "data": 'date_alert',
            "bSortable": false,
            "bSearchable": false,
            "defaultContent": ""
        },
        {
            "targets": 9,
            "data": 'userdetail',
            "bSortable": false,
            "bSearchable": false,
            "defaultContent": ""
        },
        {
            "targets": 10,
            "data": 'print',
            "bSortable": false,
            "bSearchable": false,
            "defaultContent": ""
        },
        {
            "targets": 11,
            "data": 'sms',
            "bSortable": false,
            "bSearchable": false,
            "defaultContent": ""
        },
        {
            "targets": 12,
            "data": 'inform',
            "bSortable": false,
            "bSearchable": false,
            "defaultContent": ""
        },
        {
            "targets": 13,
            "data": 'dateSort',
            "bSortable": true,
            "bSearchable": false,
            "defaultContent": "",
            "visible": false
        }
    ]
});

function cancel_payinstallment(prmIdData, prmIdDetail) {
    $.ajax({
        type: 'post',
        url: 'ajax/ajax_check_paymentinstallment.php',
        async: false,
        data: {
            'id_data': prmIdData,
            'int_ref': prmIdDetail,
            'update': true
        },
        dataType: 'json',
        success: function(res) {
            _res = res.status;
            tables.ajax.reload();
        }
    });
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


$('a[data-toggle="tab"]').on('shown', function(e) {
    e.target // activated tab
    e.relatedTarget // previous tab
})

$('#disdriver').iMask({
    type: 'number'
});

$('#extra').iMask({
    type: 'number'
});

$('#old_price').iMask({
    type: 'number'
});

function getPre() {
    var discounts = 0;
    var all = $('#pre-set').val();
    discounts = $('#disdriver').val();
    discounts = parseFloat(discounts.replace(",", ""));
    all = parseFloat(all - discounts);
    var group = parseFloat($('#dgroup').val());
    var good = parseFloat($('#dgood').val());
    $('#showgroup').val(addCommas(Math.round(parseFloat(all * group / 100))));
    $('#showgood').val(addCommas(Math.round(parseFloat((all - (parseFloat(all * group / 100))) * good / 100))));
    var showgroup = Math.round(parseFloat(all * group / 100));
    var showgood = Math.round(parseFloat((all - (all * group / 100)) * good / 100));
    var pre = parseFloat(all - showgroup - showgood); //รอคำนวนใหม่
    return pre;
}

//TODO function คำนวนเบี้ย

function calcfunc() {
    var discounts = 0;
    var all = $('#pre-set').val();
    discounts = $('#disdriver').val();
    discounts = parseFloat(discounts.replace(",", ""));
    all = parseFloat(all - discounts);
    //alert("all"+all);

    //var group = $('#dgroup').val();
    //var pgood = $('#dgood').val();
    var group = parseFloat($('#dgroup').val());
    var good = parseFloat($('#dgood').val());
    var act = parseFloat($('#act').val());
    //alert("group"+group);

    if (act == '645.21') {
        var preact = 600;
    } else if (act == '967.28') {
        var preact = 900;
    } else {
        var preact = 0;
        act = parseFloat(0);
    }

    $('#showgroup').val(addCommas(Math.round(parseFloat(all * group / 100))));
    $('#showgood').val(addCommas(Math.round(parseFloat((all - (parseFloat(all * group / 100))) * good / 100))));
    var showgroup = Math.round(parseFloat(all * group / 100));
    var showgood = Math.round(parseFloat((all - (all * group / 100)) * good / 100));
    //alert("showgroup"+showgroup);

    //	$('#pre').val( parseFloat( all-showgroup-showgood ).toFixed(2) );
    var pre = parseFloat(all - showgroup - showgood); //รอคำนวนใหม่

    //	$('#stamp').val( Math.ceil(pre * 0.4 /100) );
    var stamp = parseFloat(pre + parseFloat(Math.ceil(pre * 0.4 / 100))); //รอคำนวนใหม่
    //alert(stamp);

    // $('#vat').val(parseFloat(( stamp * 7 /100)).toFixed(2));
    var vat = parseFloat((stamp * 7 / 100)); //รอคำนวนใหม่
    //alert("vat"+vat);

    $('#net').val(addCommas(parseFloat(stamp + vat).toFixed(2)));
    $('#nets').val(addCommas(parseFloat(stamp + vat).toFixed(2)));
    //alert("net"+ parseFloat(stamp+vat).toFixed(2));

    var net = parseFloat(stamp + vat);
    var disextra = $('#extra').val();
    disextra = parseFloat(disextra.replace(",", ""));
    $('#totaldis').val(addCommas(parseFloat(discounts + showgroup + showgood + disextra).toFixed(2)));
    //alert("disextra"+parseFloat(discounts+showgroup+showgood+disextra).toFixed(2));

    if (act == 'N') {
        $('#netact').val(addCommas(parseFloat(net).toFixed(2)));
        $('#snet').val(addCommas(parseFloat((net) - (disextra)).toFixed(2)));
        $('#temp_snet').val(addCommas(parseFloat((net) - (disextra)).toFixed(2)));
        $('#costshowread').html(addCommas(parseFloat((net) - (disextra)).toFixed(2)));

    } else {
        $('#netact').val(addCommas(parseFloat(parseFloat(net) + parseFloat(act)).toFixed(2)));
        $('#snet').val(addCommas(parseFloat((net + act) - (disextra)).toFixed(2)));
        $('#temp_snet').val(addCommas(parseFloat((net + act) - (disextra)).toFixed(2)));
        $('#costshowread').html(addCommas(parseFloat((net + act) - (disextra)).toFixed(2)));
    }
    
    // คำนวณเรื่อง 1 เปอร์เซ็น

    let selectOnePercent = $('#onepercent').val();
    let onePercen = parseFloat($('#showOnepercent').val());

    if(selectOnePercent==1){
        $('#snet').val(addCommas(parseFloat((net + act) - onePercen - (disextra)).toFixed(2)));
        $('#temp_snet').val(addCommas(parseFloat((net + act) - onePercen - (disextra)).toFixed(2)));
    }else{
        $('#snet').val(addCommas(parseFloat((net + act) + onePercen - (disextra)).toFixed(2)));
        $('#temp_snet').val(addCommas(parseFloat((net + act) + onePercen - (disextra)).toFixed(2)));
    }

}
/********* END calcfunc ***********************/

//TODO select extra

function extraChange() {
    let pre = getPre();
    let extraperElm = $('#extra-per');
    let disExtraPer = extraperElm.val();
    extraperElm.empty();
    loadextraPer();
    extraperElm.val(disExtraPer);
    //console.log('เบี้ยสุทธิ', pre);
    //console.log('ส่วนลดได้', (((pre * disExtraPer) / 100)).toFixed(2));
    let extraSelect = ((pre * disExtraPer) / 100).toFixed(2);
    $('#extra').val(extraSelect);
    calcfunc();
}

//TODO input handle extra

function extrainput() {

    let preMain = getPre();
    let disextra = $('#extra').val(); //ส่วนลดทางดีลเลอร์คีย์/มีการนำเสนอผ่านระบบ suzuki
    disextra = parseFloat(disextra.replace(",", ""));
    let totalLead = (preMain * _NewAgentdis) / 100;

    //console.log('กรอกเข้ามา', disextra);
    //console.log('ลดได้สูงสุด', totalLead);

    if (disextra <= totalLead) {
        //console.log('สูตร', `(${disextra}X100)/${preMain}`);
        let perinput = (disextra * 100) / preMain;
        let perinoutFix = perinput.toFixed(2);
        //console.log('คำนวนเปอเซ็น', perinput.toFixed(2));

        $('#extra-per').empty();
        let y = false;
        for (let i = 0; i <= _NewAgentdis; i++) {
            if (i < perinoutFix && y == false) {
                $('#extra-per').append(`<option value='${i}'>${i}%</option>`);
            } else if (i > perinoutFix && y == false) {
                $('#extra-per').append(`<option value='${perinoutFix}'>${perinoutFix}%</option>`);
                $('#extra-per').append(`<option value='${i}'>${i}%</option>`);
                y = true;
            } else {
                $('#extra-per').append(`<option value='${i}'>${i}%</option>`);
            }
        }
        $('#extra-per').val(perinoutFix);
        calcfunc();
    } else {

        $('#extra').val();
        $('#extra').val(totalLead.toFixed(2));
        $('#extra-per').val(_NewAgentdis);
        calcfunc();
    }
}

function Stun() {
    var _selectedcomp = $("#compid").val();
    var _selectedmoc = $("#mocarid").val();
    var _selected = $("#tun").val();
    var _selected2 = $("#type_pro").val();
    var _selected3 = $("#service").val();
    var _selected4 = $("#mo_car_re").val();
    if (_selected != '') {
        $('#proshowread').html(addCommas(_selected));
    }
    var options = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_CostRe.php",
        data: {
            compid: _selectedcomp,
            type: _selected2,
            service: _selected3,
            mo_car_re: _selected4,
            mocar: _selectedmoc,
            cost: _selected
        },
        success: function(msg) {
            var returnedArray = msg;
            perSet = $("#pre-set");
            perSet2 = $("#pre-set2");
            perNet = $("#pre-all");
            if (returnedArray != null) {
                perSet.val(returnedArray.Cost);
                perSet2.val(addCommas(returnedArray.Cost));
                perNet.val(addCommas(returnedArray.Cost_net));
                calcfunc();
            } else {
                return false;
            }
        }
    };
    $.ajax(options);
}

$("#act").empty();
$("#act").append("<option value='645.21'>645.21</option>");
$("#act").append("<option value='967.28'>967.28</option>");
$("#act").append("<option value='N'>ไม่เอา พ.ร.บ.</option>");
$("#act").val($("#Bact<?php echo $fixNumber ?>").val());

var str = $("#costfix").val();
var str2 = $("#costselect").val();
var COSTFIX = parseInt(str.replace(",", ""));
var COSTFIX3 = str.replace(",", "");
var COSTFIX2 = str2.replace(",", "");
var PRICE = $("#old_price").val();
var oldCost = <?php echo $CalculaCost ?>;
var fixCost = <?php echo intval(($CalculaCost - $Cost_NEW) / 10000) ?>;
var COST = $("#cost").val();
for (ss = 3; ss > 0; ss--) {
    $("#tun").append("<option value='" + parseInt(COSTFIX + (10000 * ss)) + "'>" + addCommas(parseInt(COSTFIX + (10000 *
        ss))) + "</option>");
}
for (i = fixCost; parseInt(((i * 10000) / oldCost) * 100) < 20; i++) {
    $("#tun").append("<option value='" + parseInt(oldCost - (10000 * i)) + "'>" + addCommas(parseInt(oldCost - (10000 *
        i))) + "</option>");
}

if (COSTFIX2 != '') {
    $("#tun").val(COSTFIX2);
} else {
    $("#tun").val(COSTFIX3);
}

$("#disdriver").val(<?php echo $costselect[3] ?>);
$("#dgood").val(<?php echo $costselect[4] ?>);
$("#dgroup").val(<?php echo $costselect[11] ?>);
$("#extra").val(<?php echo $costselect[6] ?>);

Stun();

$("#province").change(function() {
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
        success: function(msg) {
            $('#amphur').empty();
            var returnedArray = msg;
            state = $("#amphur");
            state.append("<option value='0'>กรุณาเลือก</option>");
            if (returnedArray != null) {
                for (var i = 0; i < returnedArray.length; ++i) {
                    state.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i]
                        .Name + "</option>");
                }
            } else {
                return false;
            }
        }
    };
    $.ajax(options);
});

$("#amphur").change(function() {
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
        success: function(msg) {
            $('#tumbon').empty();
            var returnedArray = msg;
            state = $("#tumbon");
            state.append("<option value='0'>กรุณาเลือก</option>");
            if (returnedArray != null) {
                for (var i = 0; i < returnedArray.length; ++i) {
                    state.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i]
                        .Name + "</option>");
                }
            } else {
                return false;
            }
        }
    };
    $.ajax(options);
});
$("#tumbon").change(function() {
    var _selected = $("#tumbon").val();
    var options = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_Pro.php",
        data: {
            callajax: 'POST',
            tumbon: _selected
        },
        success: function(msg) {
            $('#postal').empty();
            var returnedArray = msg;
            state = $("#postal");
            if (returnedArray != null) {
                for (var i = 0; i < returnedArray.length; ++i) {
                    state.val(returnedArray[i].Name);
                }
            } else {
                return false;
            }
        }
    };
    $.ajax(options);
});

/************************************ START บันทึกการติดตาม ต่ออายุ *************************************/
$('#saveaction').click(function(event) {
    if ($("#detail_follow").val() == '0') 
    {
            alert("กรุณาเลือกรายการด้วยครับ");
            $("#detail_follow").focus();
            return false;
        }
    if ($('#textdetail').val().length < 5) {
        alert('กรุณากรอกรายละเอียดมากกว่า 5 ตัวอักษร');
        $('#textdetail').focus();
        return false;
    }

    if ($("#main").val() == 'N') {
        if ($("#detail_follow").val() == '') {
            alert("กรุณาเลือกเหตุผลไม่สนใจด้วยครับ");
            $("#detail_follow").focus();
            return false;
        }
        if ($("#detail_follow").val() == '<?php echo $focus_follow ?>') {
            if ($("#other_detail_follow").val() == '') {
                $("#other_detail_follow").focus();
                alert("กรุณาคีย์ข้อมูลเหตุผลไม่สนใจด้วยครับ");
                return false;
            }
        }
    }

    $("#printDeal").removeAttr('disabled');

    const datauser = ($('#savefol').serialize());

    $('#saveaction').attr('disabled', 'disabled');

    const options = {
        type: "POST",
        dataType: "JSON",
        url: "ajax/Ajax_SaveRenewNaja.php",
        data: datauser,
        success: function(res) {
            if(res.Status == 200)
            {
                $('#main').val('');
                alert(res.MessageDesc);
                tables.ajax.reload();
                return false;
            }
            else
            {
                alert(res.MessageDesc);
                $("#saveaction").removeAttr('disabled');
                return false;
            }
        },
        error: function() {
            alert("การบันทึกผิดพลาด!\nId Button : saveaction\nEvent : Click");
            $("#saveaction").removeAttr('disabled');
            return false;
        }
    };
    $.ajax(options);
});

/************************************ END บันทึกการติดตาม ต่ออายุ *************************************/

$('#saveadd').click(function(event) {
    //alert('ADD');
    for (var n = 0; n < document.getElementsByName("estimate[]").length; n++) {
        if (document.getElementsByName("claim_status[]")[n].value == "") {
            alert("กรูณาเลือกสถานะเคลมด้วยครับ");
            document.getElementsByName("claim_status[]")[n].focus();
            return false;
        }
        if (document.getElementsByName("claim_no[]")[n].value == "") {
            alert("กรูณาป้อนเลขเคลมด้วยครับ");
            document.getElementsByName("claim_no[]")[n].focus();
            return false;
        }
        if (document.getElementsByName("claim_location[]")[n].value == "") {
            alert("กรูณาป้อนสถานที่เกิดเหตุด้วยครับ");
            document.getElementsByName("claim_location[]")[n].focus();
            return false;
        }
        if (document.getElementsByName("estimate[]")[n].value == "" || document.getElementsByName("estimate[]")[
                n].value == 0) {
            alert("กรูณาป้อนจำนวนเงินด้วยครับ");
            document.getElementsByName("estimate[]")[n].focus();
            return false;
        }
    }
    var datauser = ($('#saveother').serialize());

    var options = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_Saveother.php",
        data: datauser,
        success: function(msg) {
            //alert("บันทึกข้อมูลเคลมเรียบร้อยแล้วครับ");

            $("#story_claim").load(`ajax/ajax_story_claim.php?id_data=${_dataID}`);
            tables.ajax.reload();
            viewCostSet('1');


        },
        error: function(msg) {
            alert('การบันทึกผิดพลาด');
        }
    };
    $.ajax(options);
});

$("#telopen").click(function(event) {
    $("#telO").show();
    $("#telopen").hide();
});

$("#printDeal").click(function(event) {

    var _selected = $("#OQ").val();
    // window.open("print/print_renewal_note_vib.php?id=" + _selected + "&st=F", "", "width=1000, height=900");
    window.open("print/print_renewal_note_vib.php?id=" + _selected + "&st=F", "_blank");

});

// $(".dataTables_length").hide();
</script>

<script type="text/javascript">
// $("#de_follow").hide();
$("#datefolf2").hide();

/********************************** START MAIN Change ***********************************/
async function mainChange() {

    // $("#de_follow").hide();
    $('#show-data-pay').hide();
    $("#datefolf2").hide();

    if ($(this).val() == 'S') {
        $("#send_quotation").show();
    } else {
        $(".detail_renew").hide();
    }

    if ($("#main").val() == "R") {
        $("#list-follow").html('รายการ:');
        getdatafollows('R');
        $(".row1").hide();
        $(".row2").hide();
        // $(".row3").hide();
        $(".row4").hide();
    }

    if ($("#main").val() == "S") {
        $("#list-follow").html('คนตัดสินใจ:');
        getdatafollows('S');
        $(".row1").show();
        $(".row2").show();
        // $(".row3").hide();
        $(".row4").hide();
    }

    if ($("#main").val() == "N") {
        $("#list-follow").html('รายการ:');
        getdatafollows('N');
        $(".row1").hide();
        $(".row2").hide();
        // $(".row3").show();
        $(".row4").hide();
       
    }


    if ($(this).val() == 'E') {
        $("#datefolf").hide();
        $("#send_confirmrenew").show();
        $("#datefolf").attr('disabled', 'disabled');
        $("#datefolf2").show();
        var url = "";
        var _tr = $('#TableViewLog').find('tbody tr');
        $.each(_tr, function(x, y) {
            var _url = $(y).find('td:eq(8)').find('#btnpay').attr('href');
            var _cancel = $(y).find('td:eq(9)').html();
            if (_url != undefined && _cancel != undefined && _url != "" && _cancel != '-') {
                $.ajax({
                    type: 'get',
                    url: _url,
                    success: function(res) {
                        $('#show-data-pay').html(res);
                        $('#show-data-pay').show();
                    }
                });
                return false;
            }
        });

    } else if ($(this).val() == 'O') {
        $("#datefolf").hide();
        $("#datefolf").attr('disabled', 'disabled');
    } else if ($(this).val() == 'N') {
        $("#datefolf").hide();
        $("#datefolf").attr('disabled', 'disabled');
        $("#datefolf2").show();
        $("#de_follow").show();
    } else {
        $("#datefolf").show();
        $("#datefolf").removeAttr('disabled')
    }

    if ($(this).val() == '') {
        $("#textdetail").attr('disabled', 'disabled');
        $("#saveaction").attr('disabled', 'disabled');
    } else {
        $("#textdetail").removeAttr('disabled');
        $("#saveaction").removeAttr('disabled');
    }

    $('#send_confirmrenew').hide();
    $("#detail_follow option[value='']").attr("selected", "true");
    $("#show_detail_follow").hide();
    $("#other_detail_follow").val("");
}
/********************************** END MAIN Change *************************************/

// $("#main").trigger('change');

$('#datefol').datepicker({
    language: "th",
    autoclose: true,
    format: 'dd/mm/yyyy',
    startDate: 'toda'
});

$('#checkcar_date').datepicker({
    language: "th",
    autoclose: true,
    format: 'dd/mm/yyyy'
});

$('#date_SP').datepicker({
    language: "th",
    autoclose: true,
    format: 'dd/mm/yyyy'
});

$('#payment_date').datepicker({
    language: "th",
    autoclose: true,
    format: 'dd/mm/yyyy'
});

$('#payment_in').datepicker({
    language: "th",
    autoclose: true,
    format: 'dd/mm/yyyy'
});

$('#payment_in').datepicker({
    language: "th",
    autoclose: true,
    format: 'dd/mm/yyyy'
});
$(document).ready(function() {
    $('.snet1').show();
    $('.snet3').hide();
    $('.snet4').hide();
    $('.snet2').hide();
});

function stype_change() {
    var _stype = parseInt($('select[name="stype"]').val());
    var _snet = parseFloat($('#temp_snet').val().replace(/,/g, ''));
    var _checked = $('#chkcall')[0].checked;
    switch (_stype) {
        case 1:
            $('#snet').val(addCommas((_snet / _stype).toFixed(2)));
            $('.snet1').show();
            $('.snet2').hide();
            $('.snet3').hide();
            $('.snet4').hide();
            break;
        case 2:
            if (_checked) {
                $('#snet21').val(addCommas(3000.00));
                $('#snet22').val(addCommas(((_snet - 3000)).toFixed(2)));
            } else {
                $('#snet21,#snet22').val(addCommas(((_snet / 2)).toFixed(2)));
            }


            $('.snet1').hide();
            $('.snet4').hide();
            $('.snet2').show();
            $('.snet3').hide();
            break;
        case 3:
            if (_checked) {
                $('#snet31').val(addCommas(3000.00));
                $('#snet32,#snet33').val(addCommas(((_snet - 3000) / 2).toFixed(2)));
            } else {
                $('#snet32,#snet33,#snet31').val(addCommas(((_snet) / 3).toFixed(2)));
            }

            $('.snet1').hide();
            $('.snet4').hide();
            $('.snet3').show();
            $('.snet2').hide();
            break;
        case 4:
            if (_checked) {
                $('#snet41').val(addCommas(3000.00));
                $('#snet42,#snet43,#snet44').val(addCommas(((_snet - 3000) / 3).toFixed(2)));
            } else {
                $('#snet41,#snet42,#snet43,#snet44').val(addCommas(((_snet) / 4).toFixed(2)));
            }
            $('.snet1').hide();
            $('.snet3').hide();
            $('.snet4').show();
            $('.snet2').hide();
            break;
        default:
            break;
    }
}

var _iddata = '';

function send_sms(send, prmIddata) {
    if (send) {
        if ($('#barcode').val() == "") {
            alert('กรุณาระบุ รหัสการชำระเบี้ย');
            $('#barcode').focus();
            return;
        } else {
            var data = $('#frm_send_sms').serialize();
            $.ajax({
                type: 'POST',
                url: 'ajax/Ajax_Sms.php',
                data: data,
                success: function(res) {
                    alert(res);
                    $('#modal_send_sms').modal('hide');
                }
            });
        }
    } else {
        _iddata = prmIddata;
        $('#modal_send_sms').modal('show');
    }
}

function binding_message() {
    var _bc = "";
    if ($('#barcode').val() == "") {
        _bc = "*** กรุณาระบุ รหัสการชำระเบี้ย ***";
    } else {
        _bc = $('#barcode').val();
    }

    var txt_form = "<?php echo $txt_form; ?>";
    var txt_form_arr = txt_form.split('|');
    var int_amount = '';
    $.ajax({
        type: 'post',
        url: 'ajax/ajax_check_paymentinstallment.php',
        async: false,
        data: {
            'id_data': txt_form_arr[0],
            'int_ref': _iddata,
            'msg': true
        },
        dataType: 'json',
        success: function(res) {
            int_amount = res.int_amount;
        }
    });
    var _msg = 'รหัสการชำระเบี้ย: ' + _bc + ' ยอดชำระ: ' + addCommas(int_amount) + ' บาท ติดต่อเรา: 02-196-8234';
    $('textarea[name="message"]')[0].innerHTML = _msg;
}

$('#modal_send_sms').on('shown', function() {
    binding_message();
    $('#barcode').val('');
    $('#barcode').focus();
});

$('#txt_claim').iMask({
    type: 'number'
});
$('#txt_claimpre').iMask({
    type: 'number'
});

function chkDis(a) { //blist1
    if ($('#blist' + a).attr('checked')) {
        $('#blist_remark' + a).css('display', 'block');
    } else {
        $('#blist_remark' + a).css('display', 'none');
    }
}

function group_fleed() {

    $("#show_fleed").hide();

    var text_fleed = "";

    if ($("#check_fleed:checked").val() == 1) {
        text_fleed += "<span>";
        text_fleed += "<select name='type_group' id='type_group' class='spanSMS' onchange='select_type()'>";
        text_fleed += "<option value='id_group' selected>ค้นหากลุ่ม</option>";
        text_fleed += "<option value='id_data'>ค้นหาเลขที่รับแจ้ง</option>";
        text_fleed += "<option value='name'>ค้นหาชื่อลูกค้า</option>";
        text_fleed += "</select>";
        text_fleed += "</span>";
        text_fleed += "<span id='show_search'>";
        text_fleed += "<select name='group_id' id='group_id'  class='spanSMS'>";
        text_fleed += "<option value=''>--กรุณาเลือกกลุ่ม--</option>";
        <?php

            $group_sql = "SELECT * FROM group_fleed GROUP BY id_group ORDER BY id_group ASC";
            $group_query = PDO_CONNECTION::fourinsure_insured()->query($group_sql);
            foreach ($group_query->fetchAll() as $group_array) {
            ?>
        text_fleed +=
            "<option value='<?php echo $group_array['id_group']; ?>'><?php echo $group_array['id_group']; ?></option>";
        <?php } ?>
        text_fleed += "</select></span>";
        text_fleed +=
            "&nbsp;<input class='btn btn-small btn-success' type='button' value='ค้นหา' onclick='group_member()'>";
        text_fleed += "<label id='show_member'></label>";

    } else if ($("#check_fleed:checked").val() == 2) {
        $("#show_fleed").hide();
        text_fleed +=
            "<input type='radio' name='select_group' id='select_group' value='1' onchange='selected_group()'>&nbsp;เพิ่มลงในกลุ่มเดิม &nbsp;&nbsp;&nbsp;";

        text_fleed +=
            "<input type='radio' name='select_group' id='select_group' value='2' onchange='selected_group()'>&nbsp;เพิ่มลงในกลุ่มใหม่ <br>";
        text_fleed +=
            "<div style='display:none;' id='show_selected'><span id='show_group' style='display:none;'><br>เลือกกลุ่ม :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name='id_group' id='id_group' class='spanSMS'>";
        text_fleed += "<option value=''>--กรุณาเลือกกลุ่ม--</option>";
        <?php
            $group_sql = "SELECT * FROM group_fleed GROUP BY id_group ORDER BY id_group ASC";
            $group_query = PDO_CONNECTION::fourinsure_insured()->query($group_sql);
            foreach ($group_query as $group_array) {
            ?>
        text_fleed +=
            "<option value='<?php echo $group_array['id_group']; ?>'><?php echo $group_array['id_group']; ?></option>";
        <?php } ?>
        text_fleed += "</select></span>";
        text_fleed += "<br>";
        text_fleed +=
            `เลขที่รับแจ้ง :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='id_data_fleed' id='id_data_fleed' class='spanSMS' value='${_dataID}' `;
        text_fleed += _dataID != '' ? 'readonly' : '';
        text_fleed += '><br>';
        text_fleed +=
            "คำนำหน้า :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name='title' id='title' class='spanSMS'>";
        <?php if (!empty($row['title'])) { ?>
        text_fleed += "<option value='<?php echo $row['title']; ?>'><?php echo $row['title']; ?></option>";
        <?php } else { ?>
        text_fleed += "<option value=''>-กรุณาเลือกคำนำหน้า-</option>";
        <?php } ?>
        <?php
            $title_sql = "SELECT * FROM tb_titlename";

            $title_query = PDO_CONNECTION::fourinsure_insured()->query($title_sql);

            foreach ($title_query as $title_array) {
                $prename = str_replace(" ", "", $title_array['prename']);
            ?>

        text_fleed += "<option value='<?php echo $prename; ?>'><?php echo $prename; ?></option>";
        <?php } ?>

        text_fleed += "</select><br>";
        text_fleed +=
            `ชื่อผู้เอาประกันภัย :<input type='text' name='name' id='name' class='spanSMS' value='<?php echo $row['name']; ?>' <?php
                                                                                                                                    if (!empty($row['name'])) {
                                                                                                                                        echo "readonly";
                                                                                                                                    }
                                                                                                                                    ?>/>`;
        text_fleed +=
            `&nbsp;<input type='text' name='last' id='last' class='spanSMS'   value='<?php echo $row['last']; ?>' <?php
                                                                                                                        if (!empty($row['last'])) {
                                                                                                                            echo "readonly";
                                                                                                                        }
                                                                                                                        ?>><br>`;

        text_fleed +=
            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        text_fleed += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        text_fleed += "<input class='btn btn-small btn-success' type='button' value='บันทึก' onclick='group_member()'>";
        text_fleed += "<label id='show_member'></label></div>";
    }

    $("#show_fleed").html(text_fleed);
    $("#show_fleed").slideDown();
}

function group_member() {
    if ($("#check_fleed:checked").val() == 1) {
        if ($("#group_id").val() == '') {
            alert("กรุณาคีย์หรือเลือกข้อมูลที่จะค้นหา");
            $("#group_id").focus();
            return false;
        }
        var ajax_fleed = {
            url: "ajax/ajax_group_fleed.php",
            type: "POST",
            dataType: "JSON",
            data: {
                group_id: $("#group_id").val(),
                id_data: $("#txt_iddata").val(),
                type_group: $("#type_group").val()
            },
            success: function(data) {
                $("#show_member").hide();
                $("#show_member").html(data.name);
                $("#show_member").slideDown();
            }
        };
        $.ajax(ajax_fleed);
    } else if ($("#check_fleed:checked").val() == 2) {
        if (!js_check_group(document.getElementsByName('select_group'))) {
            alert("กรุณาเลือกการเพิ่มข้อมูลกลุ่ม");
            return false;
        }
        if ($("#select_group:checked").val() == 1) {
            if ($("#id_group").val() == "") {
                alert("กรุณาเลือกกลุ่ม");
                $("#id_group").focus();
                return false;
            }
        }
        if ($("#id_data_fleed").val() == "") {
            alert("กรุณาป้อนข้อมูลตรงเลขที่รับแจ้ง");
            $("#id_data_fleed").focus();
            return false;
        }
        if ($("#title").val() == "") {
            alert("กรุณาเลือกคำนำหน้า");
            $("#title").focus();
            return false;
        }
        if ($("#name").val() == "") {
            alert("กรุณาป้อนข้อมูลตรงช่องชื่อจริง");
            $("#name").focus();
            return false;
        }
        if ($("#last").val() == "") {
            alert("กรุณาป้อนข้อมูลตรงช่องนามสกุล");
            $("#last").focus();
            return false;
        }
        var save_fleed = {
            url: "ajax/ajax_save_fleed",
            type: "POST",
            dataType: "JSON",
            data: {
                type_save: $("#select_group:checked").val(),
                id_data_fleed: $("#id_data_fleed").val(),
                id_data: $("#txt_iddata").val(),
                id_group: $("#id_group").val(),
                title: $("#title").val(),
                name: $("#name").val(),
                last: $("#last").val()
            },
            success: function(data) {
                alert(data.name);
                showView('pages/view4.php?t=1&IDDATA=' + $("#txt_iddata").val());
            }
        };
        $.ajax(save_fleed);
    }
}

function selected_group() {
    $("#show_selected").hide();
    $("#show_selected").slideDown();
    if ($("#select_group:checked").val() == 1) {
        $("#show_group").show();
    } else if ($("#select_group:checked").val() == 2) {
        $("#show_group").hide();
    }
}

function js_check_group(elements) {
    for (var n = 0; n < elements.length; n++) {
        if (elements[n].checked)
            return true;
    }
    return false;
}

function select_type() {
    var text_html = "";
    if ($("#type_group").val() == "id_group") {
        text_html += "<select name='group_id' id='group_id'  class='spanSMS'>";
        text_html += "<option value=''>--กรุณาเลือกกลุ่ม--</option>";

        <?php
            $group_sql = "SELECT * FROM group_fleed  GROUP BY id_group ORDER BY id_group ASC";
            $group_query = PDO_CONNECTION::fourinsure_insured()->query($group_sql);
            foreach ($group_query as $group_array) {
            ?>

        text_html +=
            "<option value='<?php echo $group_array['id_group']; ?>'><?php echo $group_array['id_group']; ?></option>";
        <?php } ?>

        text_html += "</select>";
    } else {
        text_html += "<input type='text' name='group_id' id='group_id'  class='spanSMS'>";
    }

    $("#show_search").html(text_html);
}

$("#save_remark").click(function() {

    var DATA = $('#saveother').serialize();
    var options = {
        type: "POST",
        dataType: "json",
        url: "ajax/Save_Checklist4_Document.php?remark=1&dr=S",
        data: DATA,
        success: function(msg) {
            var returnedArray = msg;
            if (returnedArray.status == true) {
                //$("#form_remark")[0].reset();
                alert(returnedArray.msg);
                // $('#showRemark').html('<p></p>').load('ajax/remark_special.php?t=1&IDDATA='+ $('#txt_iddata').val());	
                //$('#showRemark').html('<p>DDDDD</p>');
                var drmk = returnedArray.remark;
                var rmk = drmk.split("|");
                var crmk = rmk.count;
                var rmkdata = '';
                for (var i = 0; i < crmk; i++) {
                    rmkdata = rmkdata + '<br>' + rmk[i];

                }
                $('#showRemark').html(rmkdata);
                $('#showRemark').slideToggle('slow', function() {});
            } else {
                alert(returnedArray.msg);

            }
        }
    };
    $.ajax(options);

});

function cross_follow() {
    $("#show_follow").hide();
    $("#editspan").removeClass('span8');
    $("#editspan").addClass('span12');
    $("#editspan").removeClass('d-none');
    $("#iheretoo").removeClass('d-none');
}

function cross_sdl() {
    $("#show_follow").hide();
    $("#editspan").removeClass('span8');
    $("#editspan").addClass('span12');
    $("#iheretoo").addClass('span12');
    $("#editspan").removeClass('d-none');
    $("#iheretoo").removeClass('d-none');
}

async function getdetailProtect(a, b) {
    return await $.ajax({
        type: "POST",
        dataType: "html",
        url: "ajax/ajax_view_suzuki_protect.php",
        data: {
            tprotect_type: a,
            tscost: b
        },
        success: function(res) {
            return res;

        },
        error: function(err) {
            return err;
        }
    });
}
function openQuotationHandle(e) {
        $('#html_inform_quotation').html(`<iframe style="width: 100%; height: 200vh;" src="http://localhost:8080/Fourinsure_Dev/policy7/ajax/ajax_quote_mitsubishi_renew.php?Controller=Mitsubishi_Web&id_data=64401/MMT/004489&cost=690000&idcost=7394" frameborder="0"></iframe>`);
    }
function slide_open(sld) {

    const opMainVal = [{
        id: 'R',
        name: 'ติดตาม'
    }, {
        id: 'S',
        name: 'เสนอราคา'
    }, {
        id: 'N',
        name: 'ไม่สนใจ'
    }];

    if ($("#editspan").hasClass('span12')) {
        $("#show_follow").show();
        $("#editspan").removeClass('span12');
        $("#editspan").addClass('d-none');
        $("#iheretoo").addClass('d-none');
    }

    $(".row1").hide();

    $('#main option').remove();
    let mainEv = document.querySelector('#main');

    opMainVal.forEach(x => {
        const op = document.createElement('option');
        op.value = x.id;
        op.text = x.name;
        mainEv.appendChild(op);
    });
   
    $('#main').val('R');
    $("#main option[value=S]").hide();
    $('#main').attr('readOnly', false);
    mainEv.addEventListener('change', mainChange);
    $("#list-follow").html('รายการ:');
    getdatafollows('R');



}

/********************************** START Quotation Renew  ***********************************************/
async function funcQuatation(sel) {
    
    //removeEventListener
    $('#costFixd').hide();
        _qHandPoint = false;

    if ($("#editspan").hasClass('span12')) {
        $("#show_follow").show();
        $("#editspan").removeClass('span12');
        $("#editspan").addClass('d-none');
        $("#iheretoo").addClass('d-none');
    }

    $(".row1").show();
    $(".row2").hide();

    const opElemArr = document.querySelectorAll('#main option');
    opElemArr.forEach(x => {
        x.remove();
    });
    const opCr = document.createElement('option');
    opCr.value = 'S';
    opCr.text = 'เสนอราคา';
    const mainElem = document.querySelector('#main');
    mainElem.appendChild(opCr);
    mainElem.setAttribute('readOnly', true);

    var focusselect = $('#datause' + sel).val();

    //console.log('datause' + sel, focusselect);

    var myArray = focusselect.split('|');
    var scomp = myArray[0];
    var scompname = myArray[11];
    var sctype = myArray[1];
    var scost = myArray[2];
    var scoststart = parseInt(myArray[3]);
    var scostend = parseInt(myArray[4]);
    var srange = parseInt(myArray[5]);

    var sservice = myArray[6];
    var spre = myArray[7];
    var snet = myArray[8];
    var sprod_name = myArray[9]; // กลุ่มผลิตภัณฑ์
    var sprod_remark = myArray[10]; //หมายเหตุ
    var protect_type = myArray[12]; // protect_type
    var sidcost = myArray[13];
    //console.log('modal', protect_type, scost);
    const detailRes = await getdetailProtect(protect_type, scost);

    $("#testdiv").html(detailRes);

    $('#qidcost').val(sidcost);
    $("#textdetail").removeAttr('disabled');
    $("#saveaction").removeAttr('disabled');
    $('#send_quotation').css('display', '');

    $('#tun').change(function() {
        var str = $("#tun option:selected").text();
        $('#sttun').html(str);
        $('#sttun3').html(str);
        $('#sttun2').css('display', 'none');
        $('#sttun4').css('display', 'none');
    });

    var selectstun = $('#tun');
    selectstun.empty();
    for (var sc = scostend; sc >= scoststart; sc = sc - srange) {
        selectstun.append("<option value='" + sc + "'>" + addCommas(sc) + "</option>");
        // scoststart=scoststart +srange;
    }
    selectstun.val(scost);

    var tservice = $('#service');
    tservice.empty();
    if (sservice == '1') {
        tservice.append("<option value='1'>ซ่อมห้าง</option>");
    } else if (sservice == '2') {
        tservice.append("<option value='2'>ซ่อมอู่</option>");
    }

    var tserviceb = $('#service');
    if (sservice == '1') {
        // tserviceb.append("ซ่อมห้าง");
        $('#psom').html('<div>ซ่อมห้าง</div>');
    } else if (sservice == '2') {
        // tserviceb.append("ซ่อมอู่");
        $('#psom').html('<div>ซ่อมอู่</div>');
    }

    // $('#service').val(sservice);
    $('#dgroup').val('0');
    $('#dgood').val('0');
    /* สุทธิ */
    $('#pre-set').val(spre);
    $('#pre-set2').val(addCommas(spre));
    /* เบี้ยรวม */
    $('#pre-all').val(addCommas(snet));
    /* เลือกประเภท */
    // $('select[id="compid"]').val(scomp);

    var compid = $('#compid');
    compid.empty();
    compid.append("<option value='" + scomp + "'>" + scompname + "</option>");

    var doctype = $('#doctype');
    doctype.empty();
    doctype.append("<option value='" + sctype + "'>" + sctype + "</option>");

    /* เลือกประเภท */
    var sprodgroup = $('#sprodgroup');
    sprodgroup.empty();
    sprodgroup.append("<option value='" + sprod_name + "'>" + sprod_name + ":" + sprod_remark + "</option>");
    $('#protect_type').val(protect_type);

    /* detail เสนอราคา */
    $('#imgcomp').html('<img class="q-image" src="images/logo_insured/' + scomp + '.png">');
    $('#namecomp').html('<div  class="divTitle">' + scompname + '</div>');

    $('#ptype').html('<div>' + sctype + '</div>');
    $('#ptclame').html('<div>' + snet + '</div>');
    $('#bsuti').html('<div>' + addCommas(spre) + '</div>');
    $('#bsum').html('<div>' + addCommas(snet) + '</div>');

    calcfunc();
    $('#textdetail').focus();
    // $("#de_follow").hide();
    $("#show_detail_follow").hide();
    $("#detail_follow option[value='']").attr("selected", "true");
    $("#other_detail_follow").val("");
    $("#list-follow").html('คนตัดสินใจ:');
    getdatafollows('S');
}
/********************************** END Quotation Renew  ***********************************************/


    /********************************** START Quotation Handle  ***********************************************/

    var _costIDList = null;
    var _costSNList = null;
    var _carOldFix = null;
    var _qHandPoint = false;
    var _fixTun = 0;

    async function funcQuatationHandle(sel, _data, yearCarOld,mocarID,mocarDetailID) {

        const focusselect = $('#datause' + sel).val();
        if(focusselect==undefined)
        {
            alert('ไม่มีช่วงทุนที่ใช้ได้ กรุณาติดต่อเจ้าหน้าที่');
            return false;
        }

        _carOldFix = yearCarOld;
        $('#costFixd').show();
        _qHandPoint = true;
        // const selTun = document.getElementById('tun');
        // selTun.addEventListener('change',handlereneweiei);

        $('#txt-title-ch').text(` เสนอราคา`);
        if ($("#editspan").hasClass('span12')) {
            $("#show_follow").show();
            $("#editspan").removeClass('span12');
            $("#editspan").addClass('d-none');
            $("#iheretoo").addClass('d-none');
        }

        $(".row1").show();
        $(".row2").hide();

        const opElemArr = document.querySelectorAll('#main option');
        opElemArr.forEach(x => {
            x.remove();
        });
        const opCr = document.createElement('option');
        opCr.value = 'S';
        opCr.text = 'เสนอราคา';
        const mainElem = document.querySelector('#main');
        mainElem.appendChild(opCr);
        mainElem.setAttribute('readOnly', true);

        
        let myArray = focusselect.split('|');
        let scomp = myArray[0];
        let scompname = myArray[11];
        let sctype = myArray[1];
        let scost = myArray[2];
        let scoststart = parseInt(myArray[3]);
        let scostend = parseInt(myArray[4]);
        let srange = parseInt(myArray[5]);
        let sservice = myArray[6];
        let spre = myArray[7];
        let snet = myArray[8];
        let sprod_name = myArray[9]; // กลุ่มผลิตภัณฑ์
        let sprod_remark = myArray[10]; //หมายเหตุ
        let protect_type = myArray[12]; // protect_type
        let sidcost = myArray[13];
        _fixTun = scost;
        //console.log('modal', protect_type, scost);


        //handdle
        const url = './services/get-cost-renew.controller.php';

        let costID = await this.postApiAsync(url, {
            Controller: 'GetCostID',
            DataID: _data
        }); //renew_id_cost

        _costIDList = costID;


        //let costfirst = costID.Data.detailcost.split('|');

        let listCostFixs = await this.postApiAsync(url, {
            Controller: 'GetCostFixVVT',
            Caroldfix: yearCarOld,
            Mocargroup: costID.Data.mocargroup,
            DataID: _data
        });

        let costSN = await this.postApiAsync(url, {
            Controller: 'GetCostFixEndCost',
            Caroldfix: yearCarOld,
            Mocargroup: costID.Data.mocargroup,
            DataID: _data
        });

        _costSNList = costSN;

        let newCostList = await findPremiumRenewMitsu(mocarID,mocarDetailID);

    

        if(newCostList!=false)
        {
            findPriceAndTunExtract(newCostList,costSN.Data.EndCost,_fixTun);
            
            // costfixsel.append(`<option value='0'selected disabled>กรุณาเลือก</option>`);
            // for (let c of listCostFixs.Data) {
            //     costfixsel.append(`<option mocarGroup='${c.mocargroup}' protectType='${c.protect_type}' value='${c.cost}-${costSN.Data.EndCost}'>${c.cost}-${costSN.Data.EndCost} เบี้ย >>${c.total} กลุ่มเบี้ย >> ${c.mocargroup} </option>`);
            // }
        }
        else
        {
            //costfixsel.append(`<option value='0'selected disabled>ไม่มีช่วงทุน</option>`);
            _qHandPoint = false;
        }

        const detailRes = await getdetailProtect(protect_type, scost);

        $("#testdiv").html(detailRes);

        $('#qidcost').val(sidcost);
        $("#textdetail").removeAttr('disabled');
        $("#saveaction").removeAttr('disabled');
        $('#send_quotation').css('display', '');

        $('#tun').change(function() {
            var str = $("#tun option:selected").text();
            $('#sttun').html(str);
            $('#sttun3').html(str);
            $('#sttun2').css('display', 'none');
            $('#sttun4').css('display', 'none');
        });

        /*var selectstun = $('#tun');
        selectstun.empty();
        for (var sc = scostend; sc >= scoststart; sc = sc - srange) {
            selectstun.append("<option value='" + sc + "'>" + addCommas(sc) + "</option>");
            // scoststart=scoststart +srange;
        }
        selectstun.val(scost);*/

        var tservice = $('#service');
        tservice.empty();
        if (sservice == '1') {
            tservice.append("<option value='1'>ซ่อมห้าง</option>");
        } else if (sservice == '2') {
            tservice.append("<option value='2'>ซ่อมอู่</option>");
        }

        var tserviceb = $('#service');
        if (sservice == '1') {
            // tserviceb.append("ซ่อมห้าง");
            $('#psom').html('<div>ซ่อมห้าง</div>');
        } else if (sservice == '2') {
            // tserviceb.append("ซ่อมอู่");
            $('#psom').html('<div>ซ่อมอู่</div>');
        }

        // $('#service').val(sservice);
        $('#dgroup').val('0');
        $('#dgood').val('0');
        /* สุทธิ */
        $('#pre-set').val(spre);
        $('#pre-set2').val(addCommas(spre));
        /* เบี้ยรวม */
        $('#pre-all').val(addCommas(snet));
        /* เลือกประเภท */
        // $('select[id="compid"]').val(scomp);

        var compid = $('#compid');
        compid.empty();
        compid.append("<option value='" + scomp + "'>" + scompname + "</option>");

        var doctype = $('#doctype');
        doctype.empty();
        doctype.append("<option value='" + sctype + "'>" + sctype + "</option>");

        /* เลือกประเภท */
        var sprodgroup = $('#sprodgroup');
        sprodgroup.empty();
        sprodgroup.append("<option value='" + sprod_name + "'>" + sprod_name + ":" + sprod_remark + "</option>");
        $('#protect_type').val(protect_type);

        /* detail เสนอราคา */
        $('#imgcomp').html('<img class="q-image" src="images/logo_insured/' + scomp + '.png">');
        $('#namecomp').html('<div  class="divTitle">' + scompname + '</div>');

        $('#ptype').html('<div>' + sctype + '</div>');
        $('#ptclame').html('<div>' + snet + '</div>');
        $('#bsuti').html('<div>' + addCommas(spre) + '</div>');
        $('#bsum').html('<div>' + addCommas(snet) + '</div>');

        calcfunc();
        $('#textdetail').focus();
        // $("#de_follow").hide();
        $("#show_detail_follow").hide();
        $("#detail_follow option[value='']").attr("selected", "true");
        $("#other_detail_follow").val("");
        $("#list-follow").html('คนตัดสินใจ:');
        getdatafollows('S');
    }
    /********************************** END Quotation Handle  ***********************************************/

    function checkGroupCost(result,tun)
    {
        for(let x2 of result)
        {
            if(tun>=x2.cost && tun<=x2.cost_end)
            {
                return x2;
            }
        }
    }

    var _costLegGroup = [];
    var _costStart = 0;
    var _costEndQuery = 0;

    async function findPriceAndTunExtract(valueList,costEnd,fixTun)
    {
        try 
        {
            let costArr = [];
            let costleg = [];
            let costGroup = [];
            for(const xcost of valueList)
            {
                costArr.push(xcost.cost);
            }
            costArr.sort();
            costleg['start'] = Number(costArr[0]);
            costleg['end'] = Number(costEnd);
            //เอา min max ไปลอย
            _costStart = costleg['start'];
            _costEndQuery = costleg['end'];

            console.log('start',costleg['start']);
            console.log('end',costleg['end']);

            for(let x = costleg['end']; x >= costleg['start']; x = x - 10000)
            {
                _costLegGroup[x] = checkGroupCost(valueList,x);
            }
            
            let selectcost = $('#tun');
            selectcost.empty();
            selectcost.append("<option value='0' selected disabled >กรุณาเลือก</option>");

            for (let x = costleg['end']; x >= costleg['start']; x = x - 10000) 
            {
                if(_costLegGroup[x]!=null)
                {
                    selectcost.append(`<option value='${x}'>${addCommas(x)} เบี้ย ${addCommas(_costLegGroup[x].total)} บาท</option>`);
                }
                
            }
            selectcost.val(fixTun);
            await selectcost.val(fixTun);
            await handlereneweiei();
        } catch (err) {
            console.log(err);
            alert('เกิดข้อผิดพลาดไม่สามารถทำรายการได้');
        }
    }

    async function handlereneweiei() {

        if(_qHandPoint==false)
        {
            return false;
        }
        let year = _carOldFix;
        let __tund = $('#tun').val();
        let ___sprodName = _costIDList.Data.prod_name;
        let ___mocarGroup = _costLegGroup[__tund].mocargroup;//$('#costFix').find(':selected').attr('mocargroup');
        let ___protectType = _costLegGroup[__tund].protect_type;//$('#costFix').find(':selected').attr('protecttype');
        let res = await getPremiumrenewmit(___mocarGroup, ___protectType, ___sprodName, __tund, year);
        calcfunc();
    }


    async function changeCarModelID(mocar,e)
    {
        let x2 = await findPremiumRenewMitsu(mocar,e.value);
        await findPriceAndTunExtract(x2,_costSNList.Data.EndCost,_fixTun);
    }

    async function findPremiumRenewMitsu(mocar,e)
    {
        console.log('findPremiumRenewMitsu',mocar,e);
        console.log('_costStart',_costSNList.Data.StartCost);
        console.log('_constEndQuery',_costSNList.Data.EndCost);
		let data = {
			Controller: 'findPremiumrenewMitsu',
			carYear : _carOldFix,
			costMin : `${_costSNList.Data.StartCost}`,
			costMax : `${_costSNList.Data.EndCost}`,
			modelCarID : mocar,
			carID : e, 
			repair : 1,
			insuredType : 1
		};

		let newCost = {
			type: "POST",
			dataType: "json",
			cache:false,
			url: "https://www.fourinsured.com/policy/controller/RenewMitsuQutation.controller.php",
			data: data,
			success: function(msg) {
				return msg;
			},error: function(e){
				console.log(e);
				return false;
			}
		};    
		let  resNewCosts = await $.ajax(newCost);
        return resNewCosts;
	}

	async function getPremiumrenewmit(mocarGroup,protectType,prodName,cost,year){
		try
        {
            let data = {
			Controller: 'getPremiumrenewMitsu',
			mocarGroup : mocarGroup,
			protectType : protectType,
			prodName : prodName,
			cost : cost,
			year : year
		};
		
		let newCost = {
			type: "POST",
			dataType: "json",
			cache:false,
			url: "https://www.fourinsured.com/policy/controller/RenewMitsuQutation.controller.php",
			data: data,
			success: function(msg) {
				return msg;
			},error: function(e){
				console.log(e);
				return false;
			}
		};    

		let  resNewCosts = await $.ajax(newCost);
		if(resNewCosts==false)
		{
			console.log('getPremiumrenewMitsu ไม่พบข้อมูล');
			return false;
		}
        $('#pre-set').val(resNewCosts.pre);
    }
    catch(err)
        {
            console.log(err);
            alert('เกิดข้อผิดพลาดกรุณาติดต่อเจ้าหน้าที่/ลองใหม่อีกครั้ง');
        }
}


    async function handlefixcost() 
    {
        try 
        {
            let selectcost = $('#tun');
            selectcost.empty();
            $('#pre').val(0);
            calcfunc();

            let __cut = $('#costFix').val().split("-");
            

            if (__cut.length == '1') 
            {
                $('#cost').val(<?php echo $cost ?>);

                let __minc = costss - 100000;
                let __max = costss + 100000;
                selectcost.append("<option value='0' selected disable >กรุณาเลือก</option>");
                for (let x = __max; x >= __minc; x = x - 10000) {
                    selectcost.append("<option value='" + x + "'>" + addCommas(x) + "</option>");
                }
                calcfunc();
            }
            else
            {
                let __costminrenew = __cut[0];
                let __costmaxrenew = __cut[1];
                selectcost.append("<option value='0' selected disable >กรุณาเลือก</option>");
                for (let x = __costmaxrenew; x >= __costminrenew; x = x - 10000) 
                {
                    selectcost.append(`<option value='${x}'>${addCommas(x)}</option>`);
                }
                $('#cost').trigger('change');
            }
        } catch (err) {
            console.log(err);
        }
    }

$('#updclaim').click(function() {
    $('#saveadd').trigger('click');
    alert("บันทึกข้อมูลเคลมเรียบร้อยแล้วครับ");
});

function fncClaim() {
    var newClaim = parseFloat($('#txt_claim').val().replace(/,/g, ""));
    var newchkpre = parseFloat($('#txt_claimpre').val().replace(/,/g, ""));
    var newLoss = (newClaim * 100) / newchkpre;
    if (newchkpre > 0) {
        $('#txt_loss').val(newLoss.toFixed(2));
    }
}


$(document).ready(function() {
    $('#viewRemark').click(function() {
        $('#showRemark').slideToggle('slow', function() {});
    });
});

function open_inform(id_de, id_da) {


    chuser = '<?php echo $_SESSION['strUser']; ?>';
    if (chuser == 'admin') {
        $("#title_inform").html("<font color='BLACK'>ตรวจสอบข้อมูลแจ้งงาน สำหรับ(Admin)</font>");
        $.post("ajax/ajax_inform_four_modal.php", {
            id_detail: id_de,
            id_data: id_da,
            user: '<?php echo $_SESSION['strUser']; ?>',
            claim: '<?php echo $_SESSION['claim']; ?>'
        }, function(data) {
            $("#html_inform").html(data);
        });
    } else {
        $("#title_inform").html("<font color='BLACK'>ตรวจสอบข้อมูลแจ้งงาน สำหรับ(dealer)</font>");
        $.post("ajax/ajax_inform_four_modal_dealer.php", {
            id_detail: id_de,
            id_data: id_da,
            user: '<?php echo $_SESSION['strUser']; ?>',
            claim: '<?php echo $_SESSION['claim']; ?>'
        }, function(data) {
            $("#html_inform").html(data);
        });
    }


}

function show_claim() {
    if ($("#show_box").hasClass("show_story_claim")) {
        $("#show_box").slideUp();
        $("#show_box").removeClass("show_story_claim");
    } else {

        $.get("ajax/ajax_story_claim.php", {
            id_data: _dataID
        }, function(data) {
            $("#story_claim").html(data);
            $("#show_box").slideDown();
        });
        $("#show_box").addClass("show_story_claim");
    }
}

/****** หลังจากเลือกเหตุผล ที่ลูกค้าไม่สนใจเข้า func ******************************/
function open_detail_follow() {
    if ($("#detail_follow").val() == '<?php echo $focus_follow ?>') {
        $("#other_detail_follow").val("");
        $("#show_detail_follow").slideDown();
    } else {
        $("#show_detail_follow").slideUp();
        $("#other_detail_follow").val("");
    }
}

$("#pload").css('display', 'none');
$('#closepop').css('display', 'block');
$('#closepop').click(function() {
    $('#collapse4').css('display', 'block');
    $('#content_pop').empty();
    $('#closepop').css('display', 'none');
});

var listcount_long = 0;

$("#add-tel").click(function(event) {
    var listcount = $('#countlist').val();
    $('#countlist').val(++listcount);
    var htmltel = `
        <div class=" span12" style="margin:0;" id="listadd${listcount_long}">
            <span>
                <a type="button" style="border-radius:5px;" class="btn btn-danger btn-mini" onclick="$('#list_tel${listcount_long}').remove();$('#teladd${listcount_long}').remove();$('#listadd${listcount_long}').remove(); $('#countlist').val($('#countlist').val()-1); $('#add-tel').show();delete_tel();">
                    <i class="icon-remove"></i></a>
            </span>
            <span>
                <select name="list_tel[]" id="list_tel${listcount_long}" class="span2">
                    <option value="N">กรุณาเลือก</option>
                    <option value="เบอร์บ้าน">เบอร์บ้าน</option>
                    <option value="เบอร์มือถือ">เบอร์มือถือ</option>
                    <option value="เบอร์ที่ทำงาน">เบอร์ที่ทำงาน</option>
                </select>
            </span>
            <span>
                <input class="span2" name="teladd[]" id="teladd${listcount_long}" type="text" value="" maxlength="12" placeholder="หมายเลขเบอร์โทร">
            </span>
        </div>
    `;

    $('#selectlist1').append(htmltel);

    $("#show_detail_tel_button").show();
    if ($('#countlist').val() > 2) {
        $('#add-tel').hide();
    }
    listcount_long++;
});

function delete_tel() {
    var listcount = $('#countlist').val();
    $('#countlist').val(listcount--);
    if ($('#countlist').val() == 0) {
        $('#show_detail_tel_button').hide();
    }
}

function save_detail_tel() {
    for (var n = 0; n < document.getElementsByName("list_tel[]").length; n++) {
        if (document.getElementsByName("list_tel[]")[n].value == 'N') {
            alert('กรุณาเลือกเบอร์โทรศัพท์');
            document.getElementsByName("list_tel[]")[n].focus();
            return false;
        }
        if (document.getElementsByName("teladd[]")[n].value == '') {
            alert('กรุณาคีย์เบอร์โทรศัพท์');
            document.getElementsByName("teladd[]")[n].focus();
            return false;
        }
    }
    var list_tel = [];
    for (n = 0; n < document.getElementsByName("list_tel[]").length; n++) {
        list_tel[n] = document.getElementsByName("list_tel[]")[n].value;
    }
    var teladd = [];
    for (n = 0; n < document.getElementsByName("teladd[]").length; n++) {
        teladd[n] = document.getElementsByName("teladd[]")[n].value;
    }

    var save = {
        url: "ajax/ajax_save_detail_tel.php",
        dataType: "JSON",
        type: "POST",
        data: {
            id_data: _dataID,
            list_tel: list_tel,
            teladd: teladd
        },
        success: function(data) {
            if (data.status == 'Y') {
                alert(data.alert);
                $("#content_pop").load(`pages/renew_suzuki_select.php?id=${_dataID}`);
            } else {
                alert(data.alert);
            }
        },
        error: function() {
            alert('บันทึกผิดพลาด เนื่องจาก session หมดอายุ ล็อกอินเข้าระบบใหม่ครับ');
        }

    };
    $.ajax(save);
}

async function sendSMSQuotationDealer(id, detailID, typeDoc = 'S') {
    try {
        
        
        _detailID = detailID;
        _typeDocuments = typeDoc;

        let result = await this.postApiAsync('./services/QuotationRenew/renew.controller.php', {
            Controller: 'CheckSmsRenew',
            DataID: id,
            DetailRenewID: detailID
        })

        if (result.Status == 200) {
            //console.log(result.Data);
            _quotationSms = result.Data;
            let renewElem = document.querySelector('#renew-d-i');
            renewElem.innerHTML = '';
            let ro = 0;
            let divTx = document.createElement('div');
            divTx.innerHTML = 'เลือก ส่งSMS หรือกลับไปตรวจสอบด้านหน้า';
            divTx.style = 'margin-bottom:1rem';
            renewElem.appendChild(divTx);
            result.Data.forEach(i => {
                if (i.StatusMain == 1) {
                    let div1 = document.createElement('div');
                    div1.style = 'display: flex;align-items: center;';
                    let div2 = document.createElement('div');
                    let div = document.createElement('div');
                    // let div3 = document.createElement('div');

                    // let label = document.createElement('label');
                    // label.innerHTML = 'ส่งSMS';
                    // label.classList.add('label-chk-l');
                    div.innerHTML =
                        `เบอร์โทรที่ ${++ro} : ${i.Number.substr(0,3)}XXXX${i.Number.substr(7,3)}`;
                    let box = document.createElement('input');
                    box.type = 'checkbox';
                    box.value = i.Number;
                    box.setAttribute('checked', true);
                    box.classList.add('chk-send-s-c');

                    div1.appendChild(div);
                    div2.appendChild(box);
                    // div3.appendChild(label);
                    div1.appendChild(div2);
                    // div1.appendChild(div3);
                    renewElem.appendChild(div1);

                } else {

                    let div1 = document.createElement('div');
                    div1.style = 'display: flex;align-items: center;';
                    let div2 = document.createElement('div');
                    let div = document.createElement('div');
                    // let div3 = document.createElement('div');

                    // let label = document.createElement('label');
                    // label.innerHTML = 'ไม่ส่งSMS';
                    // label.classList.add('label-chk-l');
                    div.innerHTML =
                        `เบอร์โทรที่ ${++ro} : ${i.Number.substr(0,3)}XXXX${i.Number.substr(7,3)}`;

                    let box = document.createElement('input');
                    box.type = 'checkbox';
                    box.value = i.Number;
                    box.classList.add('chk-send-s-c');
                    // box.setAttribute('checked', true);
                    div1.appendChild(div);
                    div2.appendChild(box);
                    // div3.appendChild(label);
                    div1.appendChild(div2);
                    // div1.appendChild(div3);
                    renewElem.appendChild(div1);
                }
            });

            if(typeDoc=='W')//Warning sms
            {
                let divfElem = document.createElement('div');
                let buttonSend = document.createElement('button');
                buttonSend.type = 'button';
                buttonSend.classList.add('btn-s-q');
                buttonSend.innerHTML = 'ส่ง SMS แจ้งเตือนมิจฉาชีพ';
                buttonSend.addEventListener('click',()=>{
                    sendQuotationByDealer(true);
                });
                divfElem.appendChild(buttonSend);

                renewElem.appendChild(divfElem);
            }
            else
            {
                let divfElem = document.createElement('div');
                let buttonSend = document.createElement('button');
                buttonSend.type = 'button';
                buttonSend.classList.add('btn-s-q');
                buttonSend.innerHTML = 'ส่ง SMS เสนอราคา';
                buttonSend.addEventListener('click', ()=>{
                    sendQuotationByDealer(false);
                });
                divfElem.appendChild(buttonSend);

                renewElem.appendChild(divfElem);
            }

        }
    } catch (err) {
        console.log(err);
    }
}

/********************************************** START LIB  ****************************************************/
viewCostSet('1'); //เรียก lib แสดงเบี้ยประเภท 1 
loadTelCustomer(); //เรียก lib ดึงเบอร์โทรศัพท์

// $(`#story_claim`).load(`ajax/ajax_story_claim.php?id_data=${_dataID}`);

/********************************************** END LIB  ****************************************************/
// let btnRenewElem = document.querySelector('#warming-renew');
// b
//RenewElem.addEventListener('click', sendSMSQuotationDealer);
async function getdatafollows(type)
{
    
    const detailFlElem = document.querySelector('#detail_follow');
        const optionDetailF = document.querySelectorAll('#detail_follow option');
        optionDetailF.forEach(x => {
            x.remove();
        });

        const url = './services/InsuranceNotificationWork/insurance-notification-work.controller.php';
        const controller = {
            Controller: 'DetailFollowKey',
            type:type,
        };
        const result = await postApiAsync(url, controller);
        if (result.Status == 200) {
            $('#textdetail').val(''); 
            $('#detail_follow').empty(); 
            const opf = document.createElement('option');
                opf.value = 0;
                opf.text = 'กรุณาเลือก';
                detailFlElem.appendChild(opf);

            result.Data.forEach(x => {
                const op = document.createElement('option');
                op.value = x.Id;
                op.text = x.Name;
                detailFlElem.appendChild(op);
            });
        }

}

function loadextraPer() {
    const exper = $('#extra-per');
    for (let i = 0; i <= _NewAgentdis; i++) {
        exper.append(`<option value='${i}'>${i}%</option>`);
    }
}

//TODO select one percent

function onePercentChange() {
    let onePercent = $('#onepercent').val();
    if(onePercent == 0){
        $('#showOnepercent').val(0);
        calcfunc();
        return false;
    }
    let act = $('#act').val();
    let _actPre = 0;
    if (act == '645.21') {
        _actPre = 600;
    } else if (act == '967.28') {
        _actPre = 900;
    }
    let pre = getPre();
    let preAct = pre + _actPre;
    let akon = Math.ceil((preAct)*0.004);
    let extraSelect = (((preAct+akon) * 1) / 100).toFixed(2);
    $('#showOnepercent').val(extraSelect);
    calcfunc(); 
}

loadextraPer();
</script>