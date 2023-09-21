<?php

//use static controllers
class ResponseJsonApi
{
    public static function statusOk($res)
    {
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(array('Status' => 200, 'Data' => $res));
        exit();
    }

    public static function statusBad($res)
    {
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(array('Status' => 400, 'Data' => $res));
        exit();
    }

    public static function statusCreated($res)
    {
        header('Content-Type: application/json');
        http_response_code(201);
        echo json_encode(array('Status' => 201, 'Data' => $res));
        exit();
    }
    public static function statusNoContent($res)
    {
        header('Content-Type: application/json');
        http_response_code(204);
        echo json_encode(array('Status' => 204, 'Data' => $res));
        exit();
    }

    public static function statusFail($res)
    {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(array('Status' => 500, 'Data' => $res));
        exit();
    }

    public static function statusBadParams($res)
    {
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode(array('Status' => 400, 'Data' => $res));
        exit();
    }
}