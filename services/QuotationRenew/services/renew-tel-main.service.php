<?php

class RenewUpdateTelMainControl
{
    private $_contextFour;
    private $_contextSuzuki;

    public function __construct($four, $suzuki)
    {
        $this->_contextFour = $four;
        $this->_contextSuzuki = $suzuki;
    }

    public function updateTelMainByNumberDataID($req)
    {
        try {
            $result = $this->sqlCommand($req->DataID, $req->Number);
            if ($result == null) {
                $r = $this->saveMainTel($req);
            } else {
                $r = $this->update($req);
            }
            return $r == true ? true : false;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    private function sqlCommand($id, $number)
    {
        $str = "SELECT Main,Telephone,DataID 
        FROM MainTelephoneCustomer WHERE DataID ='$id' AND Telephone='$number'";

        return $this->_contextSuzuki->query($str)->fetch(5);
    }

    private function saveMainTel($request)
    {
        $str = "INSERT INTO MainTelephoneCustomer (DataID,Telephone,Main,`TimeStamp`,StatusFollow,Detail,UserSave) VALUES (:DataID,:Telephone,:Main,:TimeStamp,:StatusFollow,:Detail,:UserSave)";
        return $this->_contextSuzuki
            ->prepare($str)
            ->execute(array(
                'DataID' => $request->DataID,
                'Telephone' => $request->Number,
                'Main' => $request->Pointer,
                'TimeStamp' => date('Y-m-d H:i:s'),
                'StatusFollow' => $request->StatusFollow,
                'Detail' => $request->Details,
                'UserSave' => $_SESSION['strUser']
            ));
    }

    private function update($request)
    {
        $str = "UPDATE MainTelephoneCustomer SET Main = :pointer, `TimeStamp` = :time,StatusFollow =:StatusFollow, Detail=:Detail, UserSave=:UserSave WHERE DataID = :id AND Telephone  = :tel";
        
        return $this->_contextSuzuki
            ->prepare($str)
            ->execute(array(
                'pointer' => $request->Pointer,
                'id' => $request->DataID,
                'tel' => $request->Number,
                'time' => date('Y-m-d H:i:s'),
                'StatusFollow' => $request->StatusFollow,
                'Detail' => $request->Details,
                'UserSave' => $_SESSION['strUser']
            ));
    }

    public function getRelationshipRenewSuzuki()
    {
        $r = array();
        $str = "SELECT `name` FROM tb_human_relations WHERE status_use = 'Y'";
        $Arr = $this->_contextFour->query($str)->fetchAll(5);
        foreach ($Arr as $s) {
            $x = new RelationshipModel();
            $x->Name = $s->name;
            $r[] = $x;
        }
        return $r;
    }

    function chkStatusMain($status) //ขอโทษจำเป็นต้องเช็คแบบนี้
    {
        switch ($status) {
            case 'SMS':
                return 1;
            case 'WhiteList/ใช้งาน':
                return 2;
            case 'Blacklist':
                return 3;
            case 'ไม่แน่ใจ':
                return 5;
            default:
                return 4;
        }
    }

    function chkTelComment($req)
    {
        $str = "SELECT * FROM tel_comment WHERE tel_mobi = '$req->Number'";
        $chkInfo = $this->_contextSuzuki->query($str)->fetch(5);
        if ($chkInfo == null) {
            $str = "INSERT INTO tel_comment (tel_mobi,tel_comment,status_use,tel_name,tel_job,tel_type_status) 
            VALUES (:tel_mobi,:tel_comment,:status_use,:tel_name,:tel_job,:tel_type_status)";
            $params = array(
                'tel_mobi' => $req->Number,
                'tel_comment' => $req->Relation,
                'status_use' => 'Y',
                'tel_name' => $req->Name,
                'tel_job' => '',
                'tel_type_status' => $req->Status
            );
            return $this->_contextSuzuki->prepare($str)->execute($params);
        } else {
            $str = "UPDATE tel_comment SET tel_mobi = :tel_mobi,tel_comment = :tel_comment,
            status_use = :status_use,tel_name = :tel_name,tel_job = :tel_job,tel_type_status = :tel_type_status 
            WHERE tel_mobi = :tel_mobi";
            $params = array(
                'tel_mobi' => $req->Number,
                'tel_comment' => $req->Relation,
                'status_use' => 'Y',
                'tel_name' => $req->Name,
                'tel_job' => '',
                'tel_type_status' => $req->Status,
            );
            return $this->_contextSuzuki->prepare($str)->execute($params);
        }
    }

    function chkTbBlacklist($req, $status) //status blacklist = 3
    {
        $info = $this->_contextSuzuki
            ->query("SELECT * FROM tb_blacklist WHERE bl_data = '$req->Number' ORDER BY bl_id DESC")->fetch(5);

        if ($info == null && $status == 3) {
            $str = "INSERT INTO tb_blacklist (bl_data,bl_remark,bl_type,bl_cusstatus,addby,bl_date,bl_status) 
            VALUES (:bl_data,:bl_remark,:bl_type,:bl_cusstatus,:addby,:bl_date,:bl_status)";
            $params = array(
                'bl_data' => $req->Number,
                'bl_remark' => $req->Detail,
                'bl_type' => 'Tel',
                'bl_cusstatus' => 'C',
                'addby' => 'Dealer',
                'bl_date' => date('Y-m-d H:i:s'),
                'bl_status' => 1
            );
            return $this->_contextSuzuki->prepare($str)->execute($params);
        } else if ($info != null && $status != 3) {
            $str = "DELETE FROM tb_blacklist WHERE bl_data = '$req->Number'";
            return $this->_contextSuzuki->prepare($str)->execute();
        } else if ($info != null && $status == 3) {
            $str = "UPDATE tb_blacklist SET bl_remark = '$req->Detail' WHERE bl_data = '$req->Number'";
            return $this->_contextSuzuki->prepare($str)->execute();
        } else {
            return true;
        }
    }

    function saveTelephoneRenew($req)
    {
        try {
            $chkStatusN = $this->chkStatusMain($req->Status);
            $chkTel = $this->sqlCommand($req->DataID, $req->Number);
            if ($chkTel == null) {
                $reqs = array();
                $reqs['Pointer'] = $chkStatusN;
                $reqs['DataID'] = $req->DataID;
                $reqs['Number'] = $req->Number;
                $this->saveMainTel((object)$reqs);
            } else {
                $reqs = array();
                $reqs['Pointer'] = $chkStatusN;
                $reqs['DataID'] = $req->DataID;
                $reqs['Number'] = $req->Number;
                $this->update((object)$reqs);
            }

            $this->chkTbBlacklist($req, $chkStatusN);
            $this->chkTelComment($req);

            $str = "SELECT tel_mobi_2 FROM insuree WHERE id_data = '$req->DataID'";
            $tel2 = $this->_contextSuzuki->query($str)->fetch(5)->tel_mobi_2;

            $newText = $tel2 . "เบอร์มือถือ/$req->Number|";
            $str = "UPDATE insuree SET tel_mobi_2 = '$newText' WHERE id_data = '$req->DataID'";
            $this->_contextSuzuki->prepare($str)->execute();

            return true;
        } catch (EXception $e) {
            echo $e->getMessage();
            exit();
        }
    }
}