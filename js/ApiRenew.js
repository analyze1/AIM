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
async function loadApiDataRenew() {
    const url = 'services/InsuranceNotificationWork/insurance-notification-work.controller.php';
    const ctrlData = {
        Controller: 'DataRenewArray',
        iddata: _iddata

    };
    const res = await this.postApiAsync(ctrlData, url);
    return res;

}

async function handleApiDataRenew() {
    const DataTypeRenew = await loadApiDataRenew();
    console.log(DataTypeRenew);
    if (DataTypeRenew.Status == 200) {
        alert('ok');

    } else {
        alert('no');
    }
}
handleApiDataRenew();