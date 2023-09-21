<?php

date_default_timezone_set("Asia/Bangkok");
/****************** pointer dev&production ***************************************************/
define('_PointerDev', false);

/***************** Account ACT Webservice *****************************************************/

define('_ActLink', 'http://ws.viriyah.co.th/TcsPolicy/CmiService.asmx?wsdl');
define('_ActUser', 'WS08829');
define('_ActPass', '9y;cmovib113');

// define('_ActPass', 'df3R(AEr85');


/***************** ระบบ member production ***************************************************/
define('_Main4inFourinsuredWeb', 'https://www.4insurance.co.th');

/****************** Link iamge signature form viriyah payment*****************************************************/
define('_PatchSignature', 'https://www.4insurance.co.th/composer/shared/signature-img/');

/****************** Link iamge verrify form viriyah payment*******************************************************/
define('_PatchVerify', 'https://www.4insurance.co.th/composer/shared/citizen-verify/');

/****************** LinkViriyahPaymentcredit *********************************************************************/
define('_LinkPaymentViriyahCredit', 'https://www.4insurance.co.th/composer/shared/viriyah-payment');

define('_LinkViriyahCreditOnly', 'https://viriyah.net/payment/viriyah-payment.php');

/****************** LinkViriyahPaymentcredit Local*************************************************/
define('_LinkPaymentViriyahCreditLocal', 'http://localhost:8080/4insurance/composer/shared/viriyah-payment/full-payment.php');

/****************** LinkViriyahPaymentcredit Prod*************************************************/
define('_LinkPaymentViriyahCreditProd', 'https://www.4insurance.co.th/composer/shared/viriyah-payment/full-payment.php');

/****************** LinkQuotationSmsView *************************************************************************/
define('_LinkQuotationSmsView', 'https://www.fourinsured.com/pm/quotation');

/************************************ SMS Account *********************************************/
define('_UserSMS', 'postmvi@fourinsura');
define('_PassSMS', 'B544BD194EFB029A66344EA3135C9571230B006F0E566C52B6371AF2CDB7BCC09047D02264DE22E0');

//patch main url
define('_MainViriyahNet', 'http://viriyah.net');

//root connect
// define('_HOST_CONNECT', '192.168.1.104');
define('_HOST_CONNECT', '203.146.170.105');


//pase Fourinsurance
define('_USER_NEW_FOUR', 'fourinsure_insured');
define('_PASS_NEW_FOUR', 'itf@ur1972');

//pase Account Base
define('_FourinsureAcountUser', 'fourinsure_mitsu');
define('_FourinsureAcountPass', 'itf@ur1972');

//pase My4ib
define('_SuzukiRenewUser', 'my4ib_Renew');
define('_SuzukiRenewPass', 'itf@ur1972');

define('_USER_NEW_MY4IB', 'my4ib_new');
define('_PASS_NEW_MY4IB', 'itf@ur1972');
//pase mitsu
define('_USER_NEW_MITSU', 'fourinsure_mitsu');
define('_PASS_NEW_MITSU', 'itf@ur1972');

//pase NameBase
define('_DB_MY4IB_NEW', 'my4ib_new');
define('_DB_FOUR_INSURED', 'fourinsure_insured');
define('_DB_FOUR_ACCOUNT', 'fourinsure_account');
define('_DB_MitSu_ACCOUNT', 'fourinsure_mitsu');

// define('_DB_MY4IB_SUBARU','my4ib_subaru');
// define('_DB_MY4IB_ASSETS','my4ib_assets');
// define('_DB_MY4IB_BIGBIKE','my4ib_bigbike');
// define('_DB_MY4IB_FOOD','food');
// define('_DB_MY4IB_TPB','my4ib_tpb');
// define('_DB_MY4IB_MHK','my4ib_mhk');
// define('_DB_MY4IB_TRIUMPH','my4ib_triumph');
// define('_DB_MY4IB_FOTON','my4ib_foton');
// define('_DB_MY4IB_VOLVO','my4ib_volvo');
// define('_DB_MY4IB_CHEVROLET','my4ib_chevrolet');
// define('_DB_MY4IB_MG','my4ib_mg');
// define('_DB_MY4IB_ECL','my4ib_ecl');
// define('_DB_FOUR_MBLT','fourinsure_mblt');
// define('_DB_FOUR_HR','fourinsure_hr');
// define('_DB_FOUR_PAYMENTONLINE','fourinsure_paymentonline');

//NEW Mail SET

define('_MAIL_MY4IB', 'localhost'); //mail.my4ib.com

define('_SMTP_MY4IB_TLS', 'smtp.gmail.com'); // localhost
define('_SMTP_MY4IB_POST', '25'); //POST ตรงส่วนนี้เปลี่ยนตามนี้  587

define('_SMTP_MY4IB_USERNAME_INFO', 'info_support@my4ib.com');
define('_SMTP_MY4IB_PASSWORD_INFO', 'iNfo@2532');
define('_SMTP_MY4IB_USERNAME_ADMIN', 'admin@viriyah.net');
define('_SMTP_MY4IB_PASSWORD_ADMIN', 'Ch9yqX=Bb');
define('_SMTP_MY4IB_USERNAME_ADMIN2', 'admin2@my4ib.com'); //ADMIN 2  ใช้กับ Suzuki
define('_SMTP_MY4IB_PASSWORD_ADMIN2', 'aBEJ&2dW');
define('_SMTP_MY4IB_USERNAME_RENEW', 'renew@my4ib.com');
define('_SMTP_MY4IB_PASSWORD_RENEW', '??rN10@A2018');
define('_SMTP_MY4IB_USERNAME_POLICY', 'policy@my4ib.com');
define('_SMTP_MY4IB_PASSWORD_POLICY', '?pO10@sS2018'); 



// define('_USER_CHEVROLET','my4ib_chevrolet');
// define('_PASS_CHEVROLET','itf@ur1972');
// define('_USER_TRIUMPH','my4ib_triumph');
// define('_PASS_TRIUMPH','itf@ur1972');
// if(!defined('_USER_MG')) define('_USER_MG','my4ib_mg');
// if(!defined('_PASS_MG')) define('_PASS_MG','itf@ur1972');
// if(!defined('_USER_MHK')) define('_USER_MHK','my4ib_mhk');
// if(!defined('_PASS_MHK')) define('_PASS_MHK','itf@ur1972');
// if(!defined('_USER_NEW_MY4IB')) define('_USER_NEW_MY4IB','my4ib_new');
// if(!defined('_PASS_NEW_MY4IB')) define('_PASS_NEW_MY4IB','itf@ur1972');
// if(!defined('_USER_FOTON')) define('_USER_FOTON','my4ib_foton');
// if(!defined('_PASS_FOTON')) define('_PASS_FOTON','itf@ur1972');
// if(!defined('_USER_SUBARU')) define('_USER_SUBARU','my4ib_subaru');
// if(!defined('_PASS_SUBARU')) define('_PASS_SUBARU','itf@ur1972');
// if(!defined('_USER_ECL')) define('_USER_ECL','my4ib_ecl');
// if(!defined('_PASS_ECL')) define('_PASS_ECL','itf@ur1972');
// if(!defined('_USER_VOLVO')) define('_USER_VOLVO','my4ib_volvo');
// if(!defined('_PASS_VOLVO')) define('_PASS_VOLVO','itf@ur1972');
// if(!defined('_USER_BIGBIKE')) define('_USER_BIGBIKE','my4ib_bigbike');
// if(!defined('_PASS_BIGBIKE')) define('_PASS_BIGBIKE','itf@ur1972');