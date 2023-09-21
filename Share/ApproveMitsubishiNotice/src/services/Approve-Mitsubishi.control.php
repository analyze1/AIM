<?php
class ApproveMitsubishirenew
{
    private $_contextMitsu;
    private $_contextFour;
    public function __construct($conmit,$confour)
    {
        $this->_contextMitsu = $conmit;
        $this->_contextFour = $confour;
    }

    function ApproveMitsubishi($model)
    {
        $disOnPartner = new stdClass();

        //เช็คการติดตามในโครงการ
        if ($model->Follow == 'F') {
            $disOnPartner->disPre = 10;
            $disOnPartner->disAct = 12;
        } else {
            $disOnPartner->disPre = 18;
            $disOnPartner->disAct = 12;
        }

        //ปรับสถานะ approve ที่ upload_admin_telephone
        $app_update = "UPDATE upload_admin_telephone SET 
        Approve = '$model->Confirm', 
        Follow = '$model->Follow', 
        DateApprove = NOW(), 
        become = '$model->Become' ,
        DealerCode = '$model->DealerCode',
        AgentDis = '$disOnPartner->disPre',
        Receipt = '$model->Receipt'
        WHERE keyran = '$model->Key'";
        $app_query = $this->_contextMitsu->prepare($app_update)->execute();

        $sql = "UPDATE tb_customer SET emp_namerenew = '$model->NameFull', 
        emp_telrenew = '$model->Phone' WHERE `user` = '$model->DealerCode'";
        $this->_contextMitsu->prepare($sql)->execute();

        $this->loadPartnerCenter($model, $disOnPartner);//เช็ค partner

        $textContentLineNoti = 'อัพโหลดเอกสารเปลี่ยนผู้ดูแลติดตามต่ออายุ Mitsubishi' . "\r\n";
        $textContentLineNoti .= 'ดีลเลอร์ : ' . $model->DealerCode . "\r\n";
        $textContentLineNoti .= 'อนุมัติเรียบร้อย' . "\r\n";
        $_tokenDevelop = 'i2rADrAk83bWBcO9YawX1bW7JReAbi5dEdSyxc7lU60'; // devnoti 
        LineNotificationControl::linenotify($_tokenDevelop, $textContentLineNoti);
        return $app_query;
    }

    private function loadPartnerCenter($models, $disOnPartner)
    {
        $dealerCode = $models->DealerCode;
        $sql = "SELECT * FROM partner_code_center WHERE DealerID = '$dealerCode'";
        $infoCenter = $this->_contextFour->query($sql)->fetch(5);
        if (empty($infoCenter)) {//ถ้าข้อมูลเก่าไม่มี เพิ่มใหม่
            return $this->addPartnerCenter($models, $disOnPartner);
        } else {//ถ้ามีข้อมูลเก่า ใหม่ปรับวันหมดอายุ แล้วเพิ่มใหม่
            $dateNow = date('Y-m-d');
            $sqlPartnerCenterUpdate = "UPDATE partner_code_center 
            SET EndDate = '$dateNow' WHERE DealerID = '$dealerCode'";
            
            $this->_contextFour->prepare($sqlPartnerCenterUpdate)->execute();
    
            $sqlIn = "INSERT INTO partner_code_center(`Name`,DealerCode,AgentCode,AgentDis,
            AgentActDis,Follow,`Type`,Confirm,StartDate,EndDate,DealerID,Receipt) 
            VALUES(:Name,:DealerCode,:AgentCode,:AgentDis,:AgentActDis,
            :Follow,:Type,:Confirm,:StartDate,:EndDate,:DealerID,:Receipt)";

            $params = array(
                'Name' => "$infoCenter->Name",
                'DealerCode' => "$infoCenter->DealerCode",
                'AgentCode' => "$infoCenter->AgentCode",
                'AgentDis' => $disOnPartner->disPre,
                'AgentActDis' => $disOnPartner->disAct,
                'Follow' => "$models->Follow",
                'Type' => "Mitsubishi",
                'Confirm' => "Y",
                'StartDate' => date('Y-m-d', strtotime( $dateNow . " +1 days")),
                'EndDate' => "9999-12-31",
                'DealerID' => "$dealerCode",
                'Receipt' => "$models->Receipt"
            );

            return $this->_contextFour->prepare($sqlIn)->execute($params);
        }
    }

    private function addPartnerCenter($models, $disOnPartner)
    //เพิ่ม partner ใหม่เอาข้อมูลจาก suzuki ตามดิลเลอร์นั้นๆ
    {
        $sql = "SELECT * FROM tb_customer WHERE `user` = '$models->DealerCode'";
        $i = $this->_contextMitsu->query($sql)->fetch(5);

        $sqlIn = "INSERT INTO partner_code_center(`Name`,DealerCode,AgentCode,AgentDis,
            AgentActDis,Follow,`Type`,Confirm,StartDate,EndDate,DealerID,Receipt) 
            VALUES(:Name,:DealerCode,:AgentCode,:AgentDis,:AgentActDis,
            :Follow,:Type,:Confirm,:StartDate,:EndDate,:DealerID,:Receipt)";

        $dcode = $i->user;
        $acode = 'M' . substr($i->user, 1, 5);
        $params = array(
            'Name' => "$i->title_sub $i->sub",
            'DealerCode' =>"$dcode" ,
            'AgentCode' => "$acode",
            'AgentDis' => $disOnPartner->disPre,
            'AgentActDis' => $disOnPartner->disAct,
            'Follow' => "$models->Follow",
            'Type' => "Mitsubishi",
            'Confirm' => "Y",
            'StartDate' => date('Y-m-d'),
            'EndDate' => "9999-12-31",
            'DealerID' => "$models->DealerCode",
            'Receipt' => "$models->Receipt"
        );

        return $this->_contextFour->prepare($sqlIn)->execute($params);
    }
}