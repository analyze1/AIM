<?php
require("../../inc/connectdbs.pdo.php");

$sql = "SELECT * FROM dealer_mitsu ";
$res = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetchAll(2);

foreach ($res as $array) {
 
    $customer = "INSERT INTO tb_login (
        code_dealer,
        user,
        pass,
        uname,
        ulname,
        mac_address,
        mn_prb,
        mn_red,
        mn_year,
        mn_new,
        mn_stock,
        logo_images,
        icon_logo,
        st_active,
        log_type
    ) VALUES (
        '$array[dealercode]',
        '$array[dealercode]',
        '',
        '$array[namecompany]',
        '',
        '',
        'Y',
        'Y',
        'Y',
        'N',
        'N',
        '',
        '',
        'Y',
        ''
    )";

    PDO_CONNECTION::fourinsure_mitsu()->prepare($customer)->execute();
}

?>