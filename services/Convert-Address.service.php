<?php

class ConvertAddress
{
    private $_con;
    private $_addressInfo;

    public function __construct($con)
    {
        $this->_con = $con;
        $this->_addressInfo = array();
        $this->loadAddress();
    }

    private function loadAddress()
    {
        $send_province_sql = "SELECT * FROM tb_province";
        $send_province_query = $this->_con->query($send_province_sql)->fetchAll();
        foreach ($send_province_query as $send_province_array) {
            $this->_addressInfo['province'][$send_province_array['id']] = $send_province_array['name'];
        }

        $send_amphur_sql = "SELECT * FROM tb_amphur";
        $send_amphur_query = $this->_con->query($send_amphur_sql)->fetchAll();
        foreach ($send_amphur_query as $send_amphur_array) {
            $this->_addressInfo['amphur'][$send_amphur_array['id']] = $send_amphur_array['name'];
        }

        $send_tumbon_sql = "SELECT * FROM tb_tumbon";
        $send_tumbon_query = $this->_con->query($send_tumbon_sql)->fetchAll();
        foreach ($send_tumbon_query as $send_tumbon_array) {
            $this->_addressInfo['tumbon'][$send_tumbon_array['id']] = $send_tumbon_array['name'];
        }

        $this->_con = null;
    }

    public function getAddress()
    {
        return $this->_addressInfo;
    }

    public function mapperAddress($row)
    {
        $address_pdf = "";

        if ($row['add'] != "-" && $row['add'] != "") {
            $address_pdf .= $row['add'];
        }
        if ($row['group'] != "-" && $row['group'] != "") {
            $address_pdf .= " หมู่ " . $row['group'];
        }
        if ($row['town'] != "-" && $row['town'] != "") {
            $address_pdf .= " หมู่บ้าน/อาคาร " . $row['town'];
        }
        if ($row['lane'] != "-" && $row['lane'] != "") {
            $address_pdf .= " ซอย " . $row['lane'] . " ";
        }
        if ($row['road'] != "-" && $row['road'] != "") {
            $address_pdf .= " ถนน " . $row['road'];
        }

        if ($row['province'] != "102") {
            $address_pdf .= ' ตำบล' . $this->_addressInfo['tumbon'][$row['tumbon']] . ' อำเภอ' . $this->_addressInfo['amphur'][$row['amphur']];
            $address_pdf .= ' จังหวัด' . $this->_addressInfo['province'][$row['province']] . ' ' . $row['postal'];
        } else {
            $address_pdf .= ' แขวง' . $this->_addressInfo['tumbon'][$row['tumbon']] . ' ' . $this->_addressInfo['amphur'][$row['amphur']];
            $address_pdf .= ' ' . $this->_addressInfo['province'][$row['province']] . ' ' . $row['postal'];
        }
        return $address_pdf;
    }

    //ที่อยู่ในการจัดส่งเอกสาร
    public function ExpMapperAddress($data)
    {
        $address_pdf = "";
        //$this->_addressInfo;
        $textaddarray = explode('|', $data);
        if ($textaddarray[0] != "-" && $textaddarray[0] != "") {
            $address_pdf .= $textaddarray[0];
        }
        if ($textaddarray[1] != "-" && $textaddarray[1] != "") {
            $address_pdf .= " หมู่ " . $textaddarray[1];
        }
        if ($textaddarray[2] != "-" && $textaddarray[2] != "") {
            $address_pdf .= " หมู่บ้าน/อาคาร " . $textaddarray[2];
        }
        if ($textaddarray[3] != "-" && $textaddarray[3] != "") {
            $address_pdf .= " ซอย " . $textaddarray[3] . " ";
        }
        if ($textaddarray[4] != "-" && $textaddarray[4] != "") {
            $address_pdf .= " ถนน " . $textaddarray[4];
        }
        if ($textaddarray[5] != "102") {
            $address_pdf .= ' ต.' . $this->_addressInfo["tumbon"][$textaddarray[7]] . ' อ.' . $this->_addressInfo["amphur"][$textaddarray[6]];
            $address_pdf .= ' จ.' . $this->_addressInfo["province"][$textaddarray[5]] . ' ' . $textaddarray[8];
        } else {
            $address_pdf .= ' แขวง' . $this->_addressInfo["tumbon"][$textaddarray[7]] . ' เขต' . $this->_addressInfo["amphur"][$textaddarray[6]];
            $address_pdf .= ' ' . $this->_addressInfo["province"][$textaddarray[5]] . ' ' . $textaddarray[8];
        }
        return $address_pdf;
    }

    public function mapperPDFViriyah($row)
    {
        $address_pdf = "";

        if ($row['add'] != "-" && $row['add'] != "") {
            $address_pdf .= $row['add'];
        }
        if ($row['group'] != "-" && $row['group'] != "") {
            $address_pdf .= " หมู่ " . $row['group'];
        }
        if ($row['town'] != "-" && $row['town'] != "") {
            $address_pdf .= " หมู่บ้าน/อาคาร " . $row['town'];
        }
        if ($row['lane'] != "-" && $row['lane'] != "") {
            $address_pdf .= " ซอย " . $row['lane'] . " ";
        }
        if ($row['road'] != "-" && $row['road'] != "") {
            $address_pdf .= " ถนน " . $row['road'];
        }

        if ($row['province'] != "102") {
            $address_pdf .= ' ตำบล' . $this->_addressInfo['tumbon'][$row['tumbon']];
            $address_pdf2 = ' อำเภอ' . $this->_addressInfo['amphur'][$row['amphur']] . ' จังหวัด' . $this->_addressInfo['province'][$row['province']] . ' ' . $row['postal'];
        } else {
            $address_pdf .= ' แขวง' . $this->_addressInfo['tumbon'][$row['tumbon']];
            $address_pdf2 = $this->_addressInfo['amphur'][$row['amphur']] . ' ' . $this->_addressInfo['province'][$row['province']] . ' ' . $row['postal'];
        }
        return array('pdf1' => $address_pdf, 'pdf2' => $address_pdf2);
    }

    public function mapperPDFViriyahInstallment($row)
    {
        $address_pdf = "";

        if ($row['add'] != "-" && $row['add'] != "") {
            $address_pdf .= $row['add'];
        }
        if ($row['group'] != "-" && $row['group'] != "") {
            $address_pdf .= " หมู่ " . $row['group'];
        }
        if ($row['town'] != "-" && $row['town'] != "") {
            $address_pdf .= " หมู่บ้าน/อาคาร " . $row['town'];
        }
        if ($row['lane'] != "-" && $row['lane'] != "") {
            $address_pdf .= " ซอย " . $row['lane'] . " ";
        }
        if ($row['road'] != "-" && $row['road'] != "") {
            $address_pdf .= " ถนน " . $row['road'];
        }

        if ($row['province'] != "102") {
            $address_pdf .= ' ตำบล' . $this->_addressInfo['tumbon'][$row['tumbon']] . ' อำเภอ' . $this->_addressInfo['amphur'][$row['amphur']];
            $address_pdf .= ' จังหวัด' . $this->_addressInfo['province'][$row['province']];
        } else {
            $address_pdf .= ' แขวง' . $this->_addressInfo['tumbon'][$row['tumbon']] . ' ' . $this->_addressInfo['amphur'][$row['amphur']];
            $address_pdf .= ' ' . $this->_addressInfo['province'][$row['province']];
        }
        return $address_pdf;
    }
}