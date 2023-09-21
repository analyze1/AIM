<?php
class DownloadDocService
{
    protected $_context;
    public $_url = null;
    public function __construct($context)
    {
        $this->_context = $context;
    }

    #region
    // public function loadInsureList()
    // {
    //     $sql = "SELECT * FROM DownLoadDocInsureLoGo WHERE Active = 1 ORDER BY DownLoadDocInsureLogoID ASC";
    //     $res = $this->_context->query($sql)->fetchAll(2);
    //     return $res;
    // }

    // public function loadPassCarList()
    // {
    //     $sql = "SELECT * FROM tb_pass_car ORDER BY id ASC";
    //     $res = $this->_context->query($sql)->fetchAll(2);
    //     return $res;
    // }

    // public function test()
    // {
    //     $model = new stdClass();
    //     $model->sort = 'TNI';
    //     $model->name = 'xxxx.pdf';
    //     return $model;
    // }
    #endregion

    public function handleSaveDocument($model,$typeDoc)
    {
        $res = $this->handleSaveFile($model->dealerCode, $model->file['name'], $model->file['tmp_name']);
        if ($res) {
            $query = $this->saveToDataBase($res->nameFile, $res->numRand, $model->dealerCode,$typeDoc);
        }
        if ($query) {
            $response = array('message' => 'บันทึกเสร็จสิ้น..', 'status' => 200);
        } else {
            $response = array('message' => "บันทึกล้มเหลว..", 'status' => 500);
        }
        return $response;
    }
    private function saveToDataBase($fileName, $rand, $code,$typeDoc)
    {
        $param = array(
            'TypeWork'=> $typeDoc,
            'PatchFile' => $fileName,
            'DealerCode' => $code,
            'Approve' => 'P',
            'DateUpload' => date("Y-m-d H:i:s"),
            'Type' => 'Mitsubishi',
            'keyran' => $rand
        );
        $sql = "INSERT INTO upload_admin_telephone (TypeWork,PatchFile, DealerCode, Approve, DateUpload, `Type`, keyran) 
        VALUES (:TypeWork,:PatchFile, :DealerCode, :Approve, :DateUpload, :Type, :keyran)";
        $res = $this->_context->prepare($sql)->execute($param);

        if ($res) {
            $sql = "SELECT CONCAT(title_sub,' ',sub) AS nameDe,saka FROM tb_customer WHERE user = '$code'";
            $info = $this->_context->query($sql)->fetch(5);
            $textContentLineNoti = 'อัพโหลดเอกสารเปลี่ยนผู้ดูแลติดตามต่ออายุ Mitsubishi' . "\r\n";
            $textContentLineNoti .= 'ดีลเลอร์ : ' . $info->nameDe . "\r\n";
            $textContentLineNoti .= 'สาขา : ' . $info->saka . "\r\n";
            $base = array();
            $base['id'] = $code;
            $base['key'] = $rand;
            $json = json_encode($base);
            $url = "https://viriyah.net/mitsubishi/Share/ApproveMitsubishiNotice/src/Approve-Mitsubishi.php?id=" . base64_encode($json);
            $textContentLineNoti .= 'เข้าอนุมัติ : ' . $url . "\r\n";
            $_tokenDevelop = 'i2rADrAk83bWBcO9YawX1bW7JReAbi5dEdSyxc7lU60'; // devnoti 
            LineNotificationControl::linenotify($_tokenDevelop, $textContentLineNoti);
        }
        return $res;
    }

    private function handleSaveFile($code, $name, $tmp)
    {
        $dir = "../../DocAdminTelephone/"; // directory setup

        $type = strrchr($name, "."); //เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
        $image_timye_onl = date("Y-m-d");
        $numRand = rand(0, 99999);

        $newName = $code . '-' . $image_timye_onl . "-" . $numRand . $type; //ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
        if (!is_dir($dir)) {
            if (!mkdir($dir)) return false; //create directory if not create return false now
        }

        $file = $dir . $newName;
        if (move_uploaded_file($tmp, $file)) {
            $res = new stdClass();
            $res->nameFile = $newName;
            $res->numRand = $numRand;
            return $res;
        } else {
            return false;
        }
    }

    #region
    /*public function handleLoadDatas()
    {
        $sql = "SELECT
                    DownLoadDocInsureFile.Sort,
                    DownLoadDocInsureFile.`Name` AS TypeName,
                    DownLoadDocInsureFile.TypeInsure,
                    DownLoadDocInsureFile.FileName,
                    DownLoadDocInsureLoGo.`Name` AS InsureName,
                    DownLoadDocInsureLoGo.FileName AS LogoName,
                    tb_pass_car.name AS UseType
                FROM
                    DownLoadDocInsureFile
                    INNER JOIN DownLoadDocInsureLoGo ON DownLoadDocInsureFile.Sort = DownLoadDocInsureLoGo.Sort 
                    INNER JOIN tb_pass_car ON tb_pass_car.id = DownLoadDocInsureFile.TypeOfUse 
                ORDER BY
                    DownLoadDocInsureFile.TypeInsure ASC";
        $query = $this->_context->query($sql)->fetchAll(5);

        // print_r($query); exit;
        $arr = array();
        $arrNew = array();
        
        foreach ($query as $data){
            $arr[$data->Sort]['TypeName'][] = $data->TypeName;
            $arr[$data->Sort]['TypeInsure'][] = $data->TypeInsure;
            $arr[$data->Sort]['FileName'][] = $data->FileName;
            $arr[$data->Sort]['InsureName'][] = $data->InsureName;
            $arr[$data->Sort]['LogoName'][] = $data->LogoName;
            $arr[$data->Sort]['UseType'][] = $data->UseType;
        }
        // print_r($arr); exit;

        foreach($arr as $key => $val){
            $arrNext = array();
            foreach($val as $k => $v){
                foreach($v as $vv){
                    $arrNext[$k][] = $vv;
                }
            }
            array_push($arrNew, array('sort'=>$key,'data'=>$arrNext));
        }
        
        return $arrNew;
    }

    public function LoadDataShow($req) {
        $sql = "SELECT * FROM DownLoadDocInsureFile WHERE Sort = '$req' ORDER BY DownLoadDocInsureFileID ASC";
        $res = $this->_context->query($sql)->fetchAll(2);
        return $res;
    }

    public function UpdateData($model){
        $param = array(
            'DownLoadDocInsureFileID' => $model->id,
            'Name' => $model->name,
            'TypeInsure' =>  $model->category,
            'TypeOfUse' => $model->passCar,
        );
        $sql = "UPDATE DownLoadDocInsureFile SET `Name`=:Name, `TypeInsure`=:TypeInsure, `TypeOfUse`=:TypeOfUse  WHERE DownLoadDocInsureFileID =:DownLoadDocInsureFileID";
        $res = $this->_context->prepare($sql)->execute($param);
        return $res;
    }

    public function DeleteData($model){
        $sql = "DELETE FROM DownLoadDocInsureFile WHERE DownLoadDocInsureFileID =  :DownLoadDocInsureFileID";
        $stmt = $this->_context->prepare($sql);
        $stmt->bindParam(':DownLoadDocInsureFileID', $model->id, PDO::PARAM_INT);           
        $res=  $stmt->execute();
        return $res;
    }*/

    #endregion
}