<!-- <script src="js/jquery-1.10.1.min.js"></script>-->
<script src="js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/DT_bootstrap.js"></script>
<script type="text/javascript" src="js/js_Renew.js"></script>

<style>
.modal-body {
    position: relative;
    background-color: #fff;
    max-height: 500px;
}

.modal-content {
    position: relative;
    background-color: #fff;
    border: 1px solid #999;
    max-height: 500px;
}

.center {
    display: flex;
    justify-content: center;
}

#checkActOnline tr>td {
    padding: 5px !important;
}

#checkActOnline tr:nth-child(even) {
    background: #f9f9f9 !important;
}

#checkActOnline tr:nth-child(odd) {
    background: #233f85 !important;
}
</style>

<div class="row-fluid">
    <!-- .inner -->
    <div class="span12 inner">
        <!--Begin Datatables-->
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <table style="border:0" width="100%" cellpadding="0" cellspacing="0"
                        class="table table-striped table-bordered" id="checkActOnline">
                        <thead>
                            <tr class="info" style="text-align: center;">
                                <td>
                                    <div style="text-align: center;color: #fff !important;">เลขที่รับแจ้ง</div>
                                </td>
                                <td>
                                    <div style="text-align: center;color: #fff !important;">API</div>
                                </td>
                                <td>
                                    <div style="text-align: center;color: #fff !important;">ชื่อผู้เอาประกัน</div>
                                </td>
                                <td>
                                    <div style="text-align: center;color: #fff !important;">วันที่แจ้ง</div>
                                </td>
                                <td>
                                    <div style="text-align: center;color: #fff !important;">วันที่คุ้มครอง</div>
                                </td>
                                <td>
                                    <div style="text-align: center;color: #fff !important;">พิมพ์ พ.ร.บ.</div>
                                </td>
                                <td>
                                    <div style="text-align: center;color: #fff !important;">รุ่นรถ</div>
                                </td>
                                <td>
                                    <div style="text-align: center;color: #fff !important;">เลขตัวถัง</div>
                                </td>
                                <td>
                                    <div style="text-align: center;color: #fff !important;">เบี้ย</div>
                                </td>
                                <td>
                                    <div style="text-align: center;color: #fff !important;">ชำระเงิน</div>
                                </td>
                                <td>
                                    <div style="text-align: center;color: #fff !important;">ฟอร์มชำระเงิน</div>
                                </td>
                                <td>
                                    <div style="text-align: center;color: #fff !important;">บัตรเรดิต</div>
                                </td>
                                <td>
                                    <div style="text-align: center;color: #fff !important;">ธนาคาร/บัตรเรดิต</div>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="paymentModal" class="modal fade" role="dialog">
    <div class="modal-dialog dialog_renew">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <a type="button" class="close" id="closePayment" data-dismiss="modal">&times;</a>
                <h4 class="modal-title" style="color: #000 !important;">ส่ง SMS ชำระเบี้ย พ.ร.บ. ออนไลน์</h4>
            </div>
            <div class="modal-body">
                <div id='paymentBody'></div>
            </div>
        </div>
    </div>
</div>

<script>
var table = $('#checkActOnline').DataTable({
    "processing": true,
    "serverSide": true,
    "deferRender": true,
    //"ordering":false,
    "order": [
        [3, "desc"]
    ],
    "ajax": {
        "url": "ajax/Ajax_ACTCh.php",
        "type": "POST"
    },
    "columns": [{
            "data": "id_data"
        },
        {
            "data": "API"
        },
        {
            "data": "name"
        },
        {
            "data": "send_date"
        },
        {
            "data": "start_date"
        },
        {
            "data": "print_act"
        },
        {
            "data": "mo_car"
        },
        {
            "data": "car_body"
        },
        {
            "data": "pre"
        },
        {
            "data": "PaymentDetail",
            "className": "center",
        },
        {
            "data": "pdf"
        },
        {
            "data": "LinkCopy"
        },
        {
            "data": "LinkPayment"
        }
    ]

});

$(document).on('click', 'a[data-toggle=modal]', function() {
    var $modal = $($(this).data('target'));
    $('.modal-body', $modal).empty();
    $modal.show();
    $('.modal-body', $modal).load($(this).attr('href'));
});

function resolveApi(dataID) {
    Swal.fire({
        title: 'ต้องการออก Smart พ.ร.บ. หรือไม่',
        text: `เลขที่รับแจ้ง : ${dataID}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {

        if (result.value) {

            $.ajax({
                type: "POST",
                url: "./services/MainController.php",
                data: {
                    DATAID: dataID,
                    Controller: 'ActBlackApi'
                },
                dataType: "JSON",
                success: function(response) {
                    const _res = response;
                    Swal.fire(
                        '',
                        _res.msg,
                        'success'
                    );
                    table.ajax.reload();
                },
                error: (err) => {
                    alert(err);
                }
            });
        }
    });
}

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

async function handlePaymentSMS(IdData, Link) {
    try {
        const resSwal = await Swal.fire({
            title: 'ต้องการส่ง SMS ตัดบัตรให้ลูกค้าใช่ หรือไม่?',
            type: 'info',
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

            let total = [];
            let numberChkList = document.getElementsByName('telSMS');

            for (const i of numberChkList) {
                if (i.checked == true) {
                    total.push(i.value);
                }
            }

            let params = null;
            params = {
                Controller: 'SendSmsPaymentViriyah',
                DataID: IdData,
                Link: Link,
                Telophone: total
            };

            const response = await postApiAsync(url, params);
            if (response.Status == 200) {
                Swal.fire('', 'ส่ง SMS สำเร็จ', 'success');
                $('#closePayment').trigger('click');
            } else {
                Swal.fire('', 'ส่ง SMS ไม่สำเร็จ', 'error');
                $('#closePayment').trigger('click');
            }
        }
    } catch (err) {
        console.log(err);
        alert(err.message);
        alert(err.responseText);
    }
}

function handleCopyLink(link) {
    navigator.clipboard.writeText(link);
    Swal.fire({
        type: 'success',
        title: 'คัดลอกเรียบร้อย',
        showConfirmButton: false,
        timer: 1000
    })
}

async function handleCheckTelephone(_dataID, _link) {
    const url = './services/QuotationRenew/renew.controller.php';
    const param = {
        Controller: 'GetTelNumberCusPayment',
        DataID: _dataID
    };
    const result = await this.postApiAsync(url, param);

    if (result.Status == 200) {
        let pointer = 1;
        let _roundData = result.Data.length;
        $('#paymentBody').empty();
        result.Data.forEach(val => {
            $('#paymentBody').append(`
                <div style="margin-bottom: 0.5rem;display: flex;">
                    <div style="width: 250px;"><span>${val.Detail} : ${val.HidenNumber}</span></div>
                    <input type="checkbox" id="telSMS${pointer}" name="telSMS" value="${val.Number}" style="margin: 0;">
                </div>
            `);

            pointer++;
        });
        $('#paymentBody').append(`
            <button type="button" class="btn btn-primary" style="float: right;" onclick="handlePaymentSMS('${_dataID}', '${_link}')">ส่ง sms</button>
        `);
    }
}
</script>