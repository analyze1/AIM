<?php

class ForgetModelReq
{
    public $user;
    public $numberphone;
    public function __construct($x,$y=null)
    {
        $this->user = $x;
        $this->numberphone = $y;
    }
}

class ForgetModelRes
{
    public $numberX;
    public $numberFull;
    public $userCode;
}
