<?php 
include '../../inc/connectdbs.pdo.php';
include './models/modal-response.model.php';
include './models/paymentfull-request.model.php';
include './services/modal.service.php';
include '../Link-Bitly.service.php';

$_service = new InfomationModalControl(PDO_CONNECTION::fourinsure_insured());
try
{
    switch($_POST['Controller'])
    {
        case 'OpenModal':
        {
            $res = $_service->getInformationModal($_POST['DataID']);//:ModalModelResponse
        
            if(gettype($_service)=='object')
            {
                echo json_encode(array('Status'=>200,'Data'=>$res));
            }
            else
            {
                echo json_encode(array('Status'=>400,'Text'=>'มีปัญหา Database'));
            }
        break;
        }
    
        case 'FullPayment':
        {
            $res = $_service->paymentFullManager($_POST);
            if($res==200)
            {
                echo json_encode(array('Status'=>200,'Text'=>'ดำเนินการเสร็จสิ้น'));
                break;
            }
            else if($res==400)
            {
                echo json_encode(array('Status'=>400,'Text'=>'มีการเปลี่ยนแปลงยอดชำระ'));
                break;
            }
            else if($res==401)
            {
                echo json_encode(array('Status'=>401,'Text'=>'ยังไม่ตั้งค่าเบอร์หลัก/ไม่มีหมายเลขโทรศัพท์'));
                break;
            }
            else if($res==403)
            {
                echo json_encode(array('Status'=>403,'Text'=>'ไม่สามารถสร้างลิงก์ bitly ได้'));
                break;
            }
            else if($res==405)
            {
                echo json_encode(array('Status'=>405,'Text'=>'ไม่สามารถบันทึกได้'));
                break;
            }
    
            echo json_encode(array('Status'=>500,'Text'=>'ระบบผิดพลาด'));
    
            break;
        }

        case 'InstallmentPayment':
        {
            $res = $_service->installmentPayment($_POST);
            if($res==200)
            {
                echo json_encode(array('Status'=>200,'Text'=>'ดำเนินการเสร็จสิ้น'));
                break;
            }
            else if($res==400)
            {
                echo json_encode(array('Status'=>400,'Text'=>'มีการเปลี่ยนแปลงยอดชำระ'));
                break;
            }
            else if($res==401)
            {
                echo json_encode(array('Status'=>401,'Text'=>'ยังไม่ตั้งค่าเบอร์หลัก/ไม่มีหมายเลขโทรศัพท์'));
                break;
            }
            else if($res==403)
            {
                echo json_encode(array('Status'=>403,'Text'=>'ไม่สามารถสร้างลิงก์ bitly ได้'));
                break;
            }
            else if($res==405)
            {
                echo json_encode(array('Status'=>405,'Text'=>'ไม่สามารถบันทึกได้'));
                break;
            }
    
            echo json_encode(array('Status'=>500,'Text'=>'ระบบผิดพลาด'));
    
            break;
        }
    }
}
catch(Exception $e)
{
    echo json_encode(array('Status'=>500,'Text'=>'ระบบผิดพลาด','Err'=>$e));
}


?>