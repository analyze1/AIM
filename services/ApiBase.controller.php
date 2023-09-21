<?php

class BaseResponse
{
    public function __construct($model)
    {
        if($model==false)
        {
            return array('Status'=>400,'Data'=>null);
        }
        else
        {
            return array('Status'=>200,'Data'=>$model);
        }
    }
}



?>