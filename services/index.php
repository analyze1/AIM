<?php
/************************************************************************ Controller of Service SUZUKI Work **************************************************************** */
require('../inc/connectdbs.pdo.php');
require('../rest_api_lib/httpful.phar');
require('./ActApiBack.service.php');


switch($_POST['Controller'])
{
    case 'ActBlackApi':
    {
        $_res = loadInformationControl::postApiControl($_POST['DATAID']);
        echo json_encode($_res);
        break;
    }
    default:
    {
        http_response_code(405);
    }
}
















?>