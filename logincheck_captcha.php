   <?php
   if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['do'] == 'contact') {

        $captcha = @$_POST['ct_captcha']; // the user's entry for the captcha code
         // $name    = substr($name, 0, 64);  // limit name to 64 characters

        $errors = array();  // initialize empty error array

        if (isset($GLOBALS['DEBUG_MODE']) && $GLOBALS['DEBUG_MODE'] == false) {

            if (strlen($captcha) == 0) {
                $errors['name_error'] = 'คีย์ตัวอักษรตามรูปภาพ ด้วยครับ!'; //'Your name is required';
            }

        }

        // Only try to validate the captcha if the form has no errors
        // This is especially important for ajax calls
        if (sizeof($errors) == 0) {
           require_once dirname(__FILE__) .'/captcha/securimage.php';

            $securimage = new Securimage();

            if ($securimage->check($captcha) == false) {
               $errors['captcha_error'] = 'ท่านคีย์ตัวอักษรไม่ถูกต้อง กรุณาคีย์ใหม่ครับ!!';
            }

        }

        if (sizeof($errors) == 0) {
        
             $return = array('error' => 0, 'message' => 'OK');
            echo  json_encode($return);

        } else {

            $errmsg = '';
            foreach($errors as $key => $error) {
                // set up error messages to display with each field
                $errmsg .= "  {$error}\n";
            }

            $return = array('error' => 1, 'message' => $errmsg);
            die(json_encode($return));
        }
    } // POST
    ?>