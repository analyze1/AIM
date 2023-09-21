<?php

class RenewCreditFormViriyah
{
    private $_context4;
    private $_serBitly;
    private $_contextMitsu;
    private $_staff;

    public function __construct($conn, $suzuki = null, $staff = null, $bitlyService)
    {
        $this->_context4 = $conn;
        $this->_serBitly = $bitlyService;
        $this->_contextMitsu = $suzuki;
        $this->_staff = $staff;
    }

    #region hide not work
    // public function getLinkForReneVIB($id)
    // {
    //     $str = "SELECT com_data AS com FROM `data` WHERE id_data = '$id'";
    //     $info = $this->_context4->query($str)->fetch(5);
    //     if ($info->com != 'VIB_S' || $info->com == null) return false;

    //     // $text = "ผ่อนสบาย0%ได้6งวดชำระ ".$this->linkfull($id);
    //     $text = " ผ่อนสบาย0%25 \r\nได้6งวดชำระ " . $this->linkInstallment($id, 'RenewInstallment') . " ง่ายๆคุ้มครองทันที ";

    //     $text .= "ต้องการซื้อพ.ร.บ.ด่วน \r\nเพื่อให้ต่อภาษี " . $this->actFullLink($id, 'ActRenew');

    //     return $text;
    // }

    // private function linkfull($id)
    // {
    //     $dataIDBase64 = base64_encode($id);
    //     $long = _LinkPaymentViriyahCredit . "/full-payment.php?Customer=$dataIDBase64";

    //     $bitly = _PointerDev == true ? $long : $this->_serBitly->shorten_url($long);
    //     $this->saveLinkSms($id, $bitly, 'Renew4Full');
    //     return $bitly;
    // }

    // private function actFullLink($id, $type = 'Full')
    // {
    //     $base64ID = base64_encode($id);
    //     $base64Type = base64_encode($type);
    //     $long = _LinkPaymentViriyahCredit . "/full-payment.php?Customer=$base64ID&Type=$base64Type";

    //     $bitly = _PointerDev == true ? $long : $this->_serBitly->shorten_url($long);
    //     $this->saveLinkSms($id, $bitly, $type);
    //     return $bitly;
    // }

    #endregion

    private function linkInstallment($id, $type, $idRenew = null)
    {
        $dataIDBase64 = base64_encode($id);
        $typeBase64 = base64_encode($type);
        $idRenewBase64 = $idRenew != null ? '&RenewID=' . base64_encode($idRenew) : '';

        $long  = _LinkPaymentViriyahCredit . "/new-payment.php?Customer=$dataIDBase64&Type=$typeBase64" . "$idRenewBase64";

        $longBase = base64_encode($long);
        $_link = _LinkViriyahCreditOnly."?Link=".$longBase;
        $bitly = _PointerDev == true ? $_link : $this->_serBitly->shorten_url($_link);

        $this->saveLinkSms($id, $bitly, $type);
        return $bitly;
    }

    private function checkCommandRenewSuzuki($id, $renewID, $type)
    {
        if ($type == 'F') //F คือ FIRST อัพเดทเบี้ย ุทน ต่ออายุ suzuki ปี 2 ก่อนที่จะเสนอราคารอบต่อไป
        {
            return "SELECT `renew_comp` AS com,id_detail AS detailID FROM `detail_renew` 
            WHERE `id_data` = '$id' AND `status` = 'F' LIMIT 1";
        } else {
            return "SELECT `renew_comp` AS com,id_detail AS detailID FROM `detail_renew` 
            WHERE `id_data` = '$id' AND id_detail = '$renewID' LIMIT 1";
        }
    }

    public function getLinkForRenewSuzukiVIB($dataID, $renewID, $docType)
    {
        $sql = $this->checkCommandRenewSuzuki($dataID, $renewID, $docType);

        $info = $this->_contextMitsu->query($sql)->fetch(5);

        if ($info->com != 'VIB_S' || $info->com == null) return false;

        $link = $this->linkInstallment($dataID, 'RenewMitsubishi', $info->detailID);

        $textArr = [];
        $textArr['textApi'] = "\r\nผ่อนสบาย0%25 ได้6งวดชำระ " . $link;
        $textArr['textString'] = "\r\nผ่อนสบาย0% ได้6งวดชำระ " . $link;

        return $textArr;
    }

    private function saveLinkSms($id, $link, $type)
    {
        $str = "INSERT INTO LogMitsubishiRenewViriyahSms (id_data,Staff,`DateTimeStamp`,`Type`,Bitly,PayStatus) 
        VALUES(:id_data,:Staff,:DateTimeStamp,:Type,:Bitly,:PayStatus)";

        $params = array(
            'id_data' => $id,
            'Staff' => $this->_staff,
            'DateTimeStamp' => date('Y-m-d H:i:s'),
            'Type' => $type,
            'Bitly' => $link,
            'PayStatus' => 'N'
        );
        $res = $this->_context4->prepare($str)->execute($params);
        return $res;
    }
}