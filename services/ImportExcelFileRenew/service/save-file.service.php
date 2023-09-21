<?php

class SaveFile
{
    protected $_context;

    public function __construct($context)
    {
        $this->_context = $context;
    }

    public function save($folderPath, $model, $user, $position)
    {
        $is_path = is_dir($folderPath);
        $year =  date("Y") + 543;
        if (!$is_path) {
            mkdir($folderPath);
        }
        $pathYear = self::foderExists($folderPath, $year);
        //หากมีไฟล์เดิมให้ลบก่อน
        if (file_exists($pathYear . $model['name'])) {
            unlink($pathYear . $model['name']);
        }
        $TypeFile = strrchr($model['name'], ".");
        $NameFile = "Renew-" . date("YmdHis") . "-" . rand(0, 9999) . $TypeFile;
        //ย้ายไฟล์ไปบันทึกตามโฟลเดอร์และชื่อที่กำหนด
        $filleUploadResult = move_uploaded_file($model['tmp_name'], iconv("UTF-8", "TIS-620", $pathYear . $NameFile));
        $path = "file/{$year}/{$NameFile}";
        $this->saveLog($NameFile,$path,$user,$position,$filleUploadResult);
        return $path;
    }

    private function saveLog($nameFile,$pathFile,$user,$position,$satatus){
        $data = [
            'NameFile' => $nameFile,
            'PathFile' => $pathFile,
            'DateUpload' => date("Y-m-d H:i:s"),
            'User' => $user,
            'Position' => $position,
            'Satatus' => $satatus
        ];
        $sql = "INSERT INTO UploadExcelFileLog (NameFile, PathFile, DateUpload, User, Position, Satatus) VALUES (:NameFile, :PathFile, :DateUpload, :User, :Position, :Satatus)";
        $res= $this->_context->prepare($sql)->execute($data);
    }

    private static function foderExists($patch, $year)
    {
        try {
            $pathApi = is_dir($patch);
            if (!$pathApi) {
                mkdir($patch);
            }
            $subPathApi = is_dir("$patch/$year");
            if (!$subPathApi) {
                mkdir("$patch/$year");
            }
            return "$patch/$year/";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
