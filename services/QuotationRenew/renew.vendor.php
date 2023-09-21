<?php

require('../../inc/connectdbs.pdo.php');
require('../ApiBase.controller.php');
require('../Link-Bitly.service.php');
require('./models/renew-request.model.php');
require('./models/renew-response.model.php');
require('./services/renew.service.php');
require('./services/renew-tel.service.php');
require('./services/renew-tel-main.service.php');
require('./services/renew-sms.service.php');
require('../PaymentViriyah/services/renew.control.php');//call service วิริยะ


?>