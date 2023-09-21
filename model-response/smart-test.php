<?
require('../inc/connectdbs.pdo.php');




$sql = "SELECT tb_customer.Dealer_code, tb_customer.saka, data.id,data.doc_type,data.login, data.send_date, data.name_inform, data.id_data, data.o_insure, data.ty_inform, data.start_date, data.end_date, data.name_gain, insuree.person , insuree.title, insuree.name, insuree.last, insuree.career, insuree.add, insuree.icard, insuree.SendAdd, insuree.group, insuree.town, insuree.lane, insuree.road, insuree.tumbon, insuree.amphur, insuree.province, insuree.postal, insuree.tel_home, insuree.email, tb_tumbon.name as tumbon_name, tb_amphur.name as amphur_name, tb_province.name as province_name, tb_province.province_code_oic, tb_br_car.name as car_brand, tb_cat_car.name as cat_car_name, tb_mo_car.name as mo_car_name, detail.car_id, detail.car_color, detail.cc, detail.car_regis, detail.car_regis_pro, detail.car_body, detail.regis_date, detail.car_seat, detail.n_motor, tb_car_prb.pre,tb_car_prb.duty,tb_car_prb.vat,tb_car_prb.net,tb_car_prb.vehicle_type, protect.*, tb_mo_car_sub.desc as full_mocar, driver.title_num1, driver.name_num1, driver.last_num1, driver.birth_num1, driver.title_num2, driver.name_num2, driver.last_num2, driver.birth_num2, act.p_id, act.act_sort, act.tmp_act_id, act.barcode_id, tb_type_inform.name as type_inform_name,  tb_titlename.id_prename as idtitlename 
FROM data INNER JOIN detail ON (data.id_data = detail.id_data) INNER JOIN driver ON (driver.id_data = data.id_data) 
INNER JOIN tb_car_prb ON (detail.car_id = tb_car_prb.pre_id) INNER JOIN protect ON (data.id_data = protect.id_data) 
INNER JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car) 
INNER JOIN act ON (act.id_data = data.id_data) INNER JOIN insuree ON (data.id_data = insuree.id_data) 
INNER JOIN tb_titlename ON(tb_titlename.prename = insuree.title) 
INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) 
INNER JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) INNER JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) 
INNER JOIN tb_province ON (tb_province.id = insuree.province) INNER JOIN tb_mo_car_sub ON (detail.mo_sub = tb_mo_car_sub.id) 
LEFT JOIN tb_customer ON (data.login = tb_customer.user)
WHERE data.id_data= '63113/รย/031856'";




?>