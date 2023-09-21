<?php
class InsuranceRenewalService
{
    private $_contextMitsu;
    private $_contextFour;

    public function __construct($conMitsu,$conFour)
    {
        $this->_contextMitsu = $conMitsu;
        $this->_contextMitsu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->_contextFour = $conFour;
        $this->_contextFour->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    //ดึงข้อมูลรายละเอียดใบเตือนที่เป็นตัวล่าสุด
    private function fetchFollowUpRenewalDetailWarningStatusLatest($valDataId)
    {
        try
        {
            $sqlStr = "SELECT detailcost,
            detail_doc_type,
            vat_pointer,
            vat_total,
            detailpaytype,
            detailpayamount,
            doc_type,
            renew_comp,
            renew_ptype,
            renew_product,
            renew_id_cost 
            FROM detail_renew 
            WHERE id_data = '$valDataId' AND 
            `status` = 'F' ORDER BY id_detail DESC LIMIT 0,1";

            $fetch = $this->_contextMitsu->query($sqlStr)->fetch(2);

            return $fetch;
        }
        catch(Exception $e)
        {
            return 'error';
        }
    }

    //ดึงข้อมูลรายละเอียดใบเสนอราคาที่เป็นของล่าสุดเช็คผู้ที่ทำเสนอราคา
    private function fetchFollowUpRenewalDetailQuotationStatusLatest($valDataId,$valUser)
    {
        try
        {
            $sqlStrUser = $valUser != 'admin' ? " userdetail = 'DEALER' AND " : "";
            $sqlStr = "SELECT detailcost,
            detail_doc_type,
            vat_pointer,
            vat_total,
            detailpaytype,
            detailpayamount,
            doc_type,
            renew_comp,
            renew_ptype,
            renew_product,
            renew_id_cost 
            FROM detail_renew 
            WHERE id_data = '$valDataId' AND 
            $sqlStrUser `status` = 'S' ORDER BY id_detail DESC LIMIT 0,1";

            $fetch = $this->_contextMitsu->query($sqlStr)->fetch(2);
            // print_r($fetch);
            return $fetch;
        }
        catch(Exception $e)
        {
            return 'error';
        }
    }

    //ดึงแพ็คเกจเบี้ยของโฟร์ tb_cost
    private function fetchPremiumPackageFour($idPackage)
    {
        try
        {
            $sqlStr = "SELECT pre,stamp,tax,net,prb,total 
            FROM tb_cost WHERE id = '$idPackage'";

            $fetch = $this->_contextFour->query($sqlStr)->fetch(2);

            return $fetch;
        }
        catch(Exception $e)
        {
            return 'error';
        }
    }

    public function getFollowUpPrevious($valDataId,$valUser)
    {
        $datas = array();
        $res = new FollowUpPreviousResponseModel();

        $infoQuo = $this->fetchFollowUpRenewalDetailQuotationStatusLatest($valDataId,$valUser);

        if($infoQuo == 'error')
        {
            $res->MessageDesc = 'การเรียกข้อมูลใบเสนอราคาล้มเหลว';
            $res->Status = 500;
            return $res;
        }

        //ข้อมูลใบเสนอราคาไม่มี ไปเช็ค ใบเตือน ถ้าใบเตือนไม่มีอีก ไปแจ้ง Error
        if(!empty($infoQuo))
        {
            $datas = $infoQuo;
        }
        else
        {
            $infoWarn = $this->fetchFollowUpRenewalDetailWarningStatusLatest($valDataId);
            if($infoWarn == 'error')
            {
                $res->MessageDesc = 'การเรียกข้อมูลใบเตือนล้มเหลว';
                $res->Status = 500;
                return $res;
            }
            $datas = $infoWarn;
        }

        if(empty($datas))
        {
            $res->MessageDesc = "ไม่มีการทำใบเตือนไม่สามารถทำการติดตามงานได้ครับ\n";
            $res->MessageDesc .= "การแก้ไขให้ทำการเสนอราคามาก่อนแล้วทำการติดตามงานครับ\n";
            $res->MessageDesc .= "ไม่สามารถติดตามงานต่ออายุได้กรุณาติดต่อเจ้าหน้าที่ครับ";
            $res->Status = 406;
            return $res;
        }

        if($datas['renew_id_cost'] == 0)
        {
            $res->MessageDesc = "รหัส Package เบี้ย ไม่สมบูรณ์ ระบบไม่สามารถ บันทึกข้อมูลได้\n";
            $res->MessageDesc .= "การแก้ไขให้ทำการเสนอราคามาก่อนแล้วทำการติดตามงานครับ\n";
            $res->MessageDesc .= "ไม่สามารถติดตามงานต่ออายุได้กรุณาติดต่อเจ้าหน้าที่ครับ";
            $res->Status = 406;
            return $res;
        }

        //เรียกข้อมูล Package เบี้ย จากโฟร์ ใช้ แผนที่ 2
        $prePackDatas = $this->fetchPremiumPackageFour($datas['renew_id_cost']);

        if($prePackDatas == 'error')
        {
            $res->MessageDesc = 'การเรียกข้อมูล Package เบั้ย ล้มเหลว';
            $res->Status = 500;
            return $res;
        }

        if(empty($prePackDatas))
        {
            $res->MessageDesc = 'ไม่มีข้อมูล package เบี้ย';
            $res->Status = 406;
            return $res;
        }

        //$res->ProductDetail = $datas['detailcost'];              //รายละเอียดเบี้ยที่เก็บเป็น | ต่อกันไป แผนที่ 1
        $res->IdProduct = $datas['renew_id_cost'];                 //รหัสPackage
        $res->IdProductType = $datas['renew_ptype'];               //รหัสประเภทกลุ่มผลิตภัณ
        $res->InsuranceComp = $datas['renew_comp'];                //ตัวย่อบริษัทประกัน
        $res->ProductGroup = $datas['renew_product'];              //กลุ่มผลิตภัณท์
        $res->InsuranceType = $datas['detail_doc_type'];           //ประเภทประกันภัย เช่น 1 2 2+ 3
        $res->VatPointer = $datas['vat_pointer'];                  //เป็นตัวเอาไปชี้ว่าใช่หัก ณ ที่จ่าย
        $res->VatTotal = $datas['vat_total'];                      //ยอดรวม หัก ณ ที่จ่าย
        $res->PaymentType = $datas['detailpaytype'];               //ประเภทชำระเงิน
        $res->NumInstallments = $datas['detailpayamount'];         //จำนวนงวดที่ชำระเงิน

        //รายละเอียดเบี้ยที่เก็บเป็น | ต่อกันไป แผนที่ 2
        $costDatas = explode('|',$datas['detailcost']);

        $res->ProductDetail = $costDatas[0].'|';
        $res->ProductDetail .= $costDatas[1].'|';
        $res->ProductDetail .= $costDatas[2].'|';
        $res->ProductDetail .= $costDatas[3].'|';
        $res->ProductDetail .= $costDatas[4].'|';
        $res->ProductDetail .= $costDatas[5].'|';
        $res->ProductDetail .= $costDatas[6].'|';
        $res->ProductDetail .= $costDatas[7].'|';
        // $res->ProductDetail .= $prePackDatas['total'].'|'; //arr key 8 อาจจะมีการเปลียนสูตร เป็น เบี้ยรวม กรมธรรม์รวมพรบ
        $res->ProductDetail .= ($prePackDatas['net'] + $costDatas[9]).'|';
        // $res->ProductDetail .= $prePackDatas['prb'].'|'; //arr key 9 อาจจะมีการเปลียนสูตร เป็น พ.ร.บ เบี้ยรวม
        $res->ProductDetail .= $costDatas[9].'|';
        $res->ProductDetail .= $prePackDatas['pre'].'|';
        $res->ProductDetail .= $costDatas[11].'|';
        $res->ProductDetail .= $costDatas[12].'|';
        $res->ProductDetail .= $prePackDatas['net'];
        $res->MessageDesc = 'Success';
        $res->Status = 200;

        return $res;
    }
}
?>