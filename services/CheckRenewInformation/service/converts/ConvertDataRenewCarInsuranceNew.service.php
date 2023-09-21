<?php
class ConvertDataRenewCarInsuranceNewService
{
    private $_contextFour;
    private $arrDataInsuranceNew; //เก็บข้อมูลประกันภัยต่ออายุใหม่โดยจับกับเลขรับแจ้งใหม่

    public function __construct($conFour)
    {
        $this->_contextFour = $conFour;
    }

    public function createDataCarInsuranceNew($params)
    {
        try {
            $this->arrDataInsuranceNew = array();
            $createIdDataFourSearch = null;

            foreach ($params as $obj) {
                $createIdDataFourSearch .= $createIdDataFourSearch  != '' ? ",'$obj->IdDataFour'" : "'$obj->IdDataFour'";
            }

            $fetchInsured = $this->_contextFour
                ->query("SELECT detail.id_data,
            detail.car_body,
            detail.car_regis,
            detail.id_data_company,
            insuree.status_company,
            insuree.title,
            insuree.name,
            insuree.last,
            protect.cost,
            tb_province.name_mini AS CarRegistProMini,
            tb_mo_car.name AS CarModelName
            FROM detail
            INNER JOIN insuree ON (detail.id_data = insuree.id_data)
            INNER JOIN `data` ON (detail.id_data = `data`.id_data)
            INNER JOIN protect ON (detail.id_data = protect.id_data)
            INNER JOIN tb_mo_car ON (detail.mo_car = tb_mo_car.id)
            INNER JOIN tb_province ON (detail.car_regis_pro = tb_province.id)
            WHERE detail.id_data IN ($createIdDataFourSearch) ORDER BY `data`.send_date ASC ")
                ->fetchAll(2);

            foreach ($fetchInsured as $datas) {
                $this->arrDataInsuranceNew[$datas['id_data']]['Approval'] = $datas['status_company'];               //อนุมัติ
                $this->arrDataInsuranceNew[$datas['id_data']]['CarRegistNo'] = $datas['car_regis'];                 //เลขทะเบียน
                $this->arrDataInsuranceNew[$datas['id_data']]['CarRegistProvince'] = $datas['CarRegistProMini'];    //ทะเบียนจังหวัด
                $this->arrDataInsuranceNew[$datas['id_data']]['Title'] = $datas['title'];                           //คำนำหน้า
                $this->arrDataInsuranceNew[$datas['id_data']]['Name'] = $datas['name'];                             //ชื่อจริง
                $this->arrDataInsuranceNew[$datas['id_data']]['Last'] = $datas['last'];                             //ชื่อนามสกุล
                $this->arrDataInsuranceNew[$datas['id_data']]['CarModelName'] = $datas['CarModelName'];             //ชื่อรุ่นรถยนตร์
                $this->arrDataInsuranceNew[$datas['id_data']]['Fund'] = $datas['cost'];                             //ทุนประกันใหม่
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function approvalButton($obj)
    {
        $getIdDataNew = $obj->IdDataFour;

        // if(array_key_exists($getIdDataNew,$this->arrDataInsuranceNew) == false)
        // {
        //     return "<div class='btn-danger btn-small' style='width:100px;float:left;heigth:32px;padding:5px 10px;' title='ยืนยันรับประกัน' rel='tooltip' id='prints' ><b>Warning</b><br>เลขรับแจ้งใหม่ : $getIdDataNew<br>ไม่มีข้อมูลอยู่ในต่ออายุประกันใหม่ หรือ เลขรับแจ้งต่อประกันใหม่ไม่ตรงกัน</div>";
        // }

        if ($this->arrDataInsuranceNew[$getIdDataNew]['Approval'] == 'Y') {
            return "<div class='btn-success btn-small' style='width:105px;float:left;heigth:32px;padding:5px 10px;white-space: nowrap;' title='ยืนยันรับประกัน' rel='tooltip' id='prints' ><i class='icon-white icon-check'></i>ยืนยันรับประกัน</div>";
        } else if($this->arrDataInsuranceNew[$getIdDataNew]['Approval'] == 'C') {
            return "<div class='btn-danger btn-small' style='width:100px;float:left;heigth:32px;padding:5px 10px;' title='ยกเลิก' rel='tooltip' id='prints' ><i class='icon-white icon-trash'></i>ยกเลิก</div>";
        } else {
            return "<div class='btn-warning btn-small' style='width:100px;float:left;heigth:32px;padding:5px 10px;' title='รออนุมัติ' rel='tooltip' id='prints' ><i class='icon-white icon-time'></i>รออนุมัติ...</div>";
        }
    }

    public function viewDocumentButton($obj)
    {
        $getApproveStatus = null;
        $getIdDataNew = $obj->IdDataFour;

        if (isset($this->arrDataInsuranceNew[$getIdDataNew])) {
            $getApproveStatus = $this->arrDataInsuranceNew[$getIdDataNew]['Approval'];
        } else {
            $getApproveStatus = null;
        }

        if ($getApproveStatus == 'Y') {
            return "<a title='ใบรับประกัน' style='width:100px;float:left;heigth:32px;' class='btn btn-success btn-small' href='javascript:void(0)' onclick=\"window.open('print/Reprint_Order.php?IDDATA=$getIdDataNew','welcome','menubar=no,status=no,scrollbars=yes')\"><i class='icon-white icon-print'></i> ใบรับประกัน</a>";
        } else {
            return "<a title='ใบคำขอ' style='width:100px;float:left;heigth:32px;' class='btn btn-inverse btn-small' href='javascript:void(0)' onclick=\"window.open('print/print_waitConfirm.php?IDDATA=$getIdDataNew','welcome','menubar=no,status=no,scrollbars=yes')\"><i class=\"icon-white icon-print\"></i> ใบคำขอ</a>";
        }
    }

    public function viewInformationButton($obj)
    {
        return "<a class='btn btn-success btn-small' title='' rel='tooltip' style='white-space: nowrap;' onclick='funcrenew(\"$obj->IdData\")' data-original-title='ดูข้อมูล'><i class='icon-white icon-list'></i> ดูข้อมูล</a>";
    }

    public function customerFullName($obj)
    {
        $getIdDataNew = $obj->IdDataFour;
        $getTitle = null;
        $getName = null;
        $getLast = null;
        if (isset($this->arrDataInsuranceNew[$getIdDataNew])) {
            $getTitle = $this->arrDataInsuranceNew[$getIdDataNew]['Title'] != '-' ? $this->arrDataInsuranceNew[$getIdDataNew]['Title'] : '';
            $getName = $this->arrDataInsuranceNew[$getIdDataNew]['Name'] != '-' ? $this->arrDataInsuranceNew[$getIdDataNew]['Name'] : '';
            $getLast = $this->arrDataInsuranceNew[$getIdDataNew]['Last'] != '-' ? $this->arrDataInsuranceNew[$getIdDataNew]['Last'] : '';
            return $getTitle . $getName . ' ' . $getLast;
        } else {
            $getTitle = $obj->Title != '-' ? $obj->Title : '';
            $getName = $obj->Name != '-' ? $obj->Name : '';
            $getLast = $obj->Last != '-' ? $obj->Last : '';
            return $getTitle . $getName . ' ' . $getLast;
        }
    }

    public function carFullName($obj)
    {
        $getIdDataNew = $obj->IdDataFour;
        if (isset($this->arrDataInsuranceNew[$getIdDataNew])) {
            return $this->arrDataInsuranceNew[$getIdDataNew]['CarModelName'];
        } else {
            return $obj->CarModelName;
        }
    }

    public function renewFund($obj, $valDecimal = 0)
    {
        $getIdDataNew = $obj->IdDataFour;
        $numberOnly = 0;
        if (isset($this->arrDataInsuranceNew[$getIdDataNew])) {
            $numberOnly = preg_replace('/[^0-9\.]/', '', $this->arrDataInsuranceNew[$getIdDataNew]['Fund']);
        } else {
            $numberOnly = preg_replace('/[^0-9\.]/', '', $obj->Fund);
        }
        return $numberOnly != '' ? number_format($numberOnly, $valDecimal, '.', ',') : '0.00';
    }

    public function carRegistFullName($obj)
    {
        $getIdDataNew = $obj->IdDataFour;
        if (isset($this->arrDataInsuranceNew[$getIdDataNew])) {
            return $this->arrDataInsuranceNew[$getIdDataNew]['CarRegistNo'] . ' ' . $this->arrDataInsuranceNew[$getIdDataNew]['CarRegistProvince'];
        } else {
            return $obj->CarRegistNo . ' ' . $obj->CarRegistProvince;
        }
    }
}