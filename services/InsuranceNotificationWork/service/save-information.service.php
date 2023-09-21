<?php

class SaveInformation
{
    protected $_context;

    public function __construct($context)
    {
        $this->_context = $context;
    }
    
    public function getTitleName($model){
        $sql = "SELECT prename FROM tb_titlename WHERE title_person_map_suzuki = $model->personType";
        $res = $this->_context->query($sql)->fetchAll(7);
        return $res;
    }

    public function SaveInformAfterQuotation($model){

    }
}
