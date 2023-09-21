<?php
// include "../inc/checksession.inc.php";
include '../inc/connectdbs.pdo.php';
// error_reporting(0);
// mysql_select_db($db2,$cndb2);

$type_informm =$_POST['type_inform'];
$cartypeee    =$_POST['cartypee'];
$br_carr      =$_POST['br_car1'];
$yearcar      =$_POST['year'];
$yearP      =$_POST['yearcar'];
$mocarr       =$_POST['mo_car1'];
$mo_carprice = $_POST['mo_carprice1'];


   $dateY = date("Y-m-d");  //วันที่ปัจจุบัน
   $sqlRes1 = "SELECT *";  
   $sqlRes1 .= "FROM tb_mocar_group g inner join tb_mocar_group_cost gc ON (g.mggroup = gc.mggroup) ";
   $sqlRes1 .= "WHERE  g.brcar = $br_carr AND gc.carold = $yearcar AND g.mocar IN ('".$mocarr."','ALL') AND (g.mgstatus = 'Y')";
    $sqlRes1 .= " AND (gc.dateentry <=  '".$dateY."' AND gc.dateexpire >= '".$dateY."') "; //เบี้ยจากวันปปัจจุบันที่เสนอราคา
    $resSql1 = PDO_CONNECTION::fourinsure_insured()->query($sqlRes1);
    
       // echo $sqlRes1;
    $arrRes2 = $resSql1->fetch(2);
             //=======================
         
         $Cost_fixcost = $arrRes2['fixcost'];
         $Cost_fixcostend = $arrRes2['fixcostend'];
         $Cost_brcar = $arrRes2['brcar'];
         $Cost_carold = $arrRes2['carold'];
         $Cost_mocar = $arrRes2['mocar'];
         $Cost_mggroup = $arrRes2['mggroup'];
         $Cost_mgstatus = $arrRes2['mgstatus']; 
         $Cost_dateentry = $arrRes2['dateentry']; 
         $Cost_dateexpire = $arrRes2['dateexpire'];   





//เช็คว่า %A %B อะไรมาก่อน
         if ($Cost_fixcost == $Cost_fixcostend){
               @$priceMo1 = ceil(($mo_carprice*$Cost_fixcost)/100);
                @$priceMo2 = ceil(($mo_carprice*$Cost_fixcostend)/100);  
                $priceMo_1 =$Cost_fixcost;
                $priceMo_2 = $Cost_fixcostend;          
            }elseif ($Cost_fixcost > $Cost_fixcostend) {
                $priceMo1 = ceil(($mo_carprice*$Cost_fixcostend)/100);
                $priceMo2 = ceil(($mo_carprice*$Cost_fixcost)/100);
                $priceMo_1 = $Cost_fixcostend;
                $priceMo_2 = $Cost_fixcost;               
            }elseif ($Cost_fixcost < $Cost_fixcostend) {
                $priceMo1 = ceil(($mo_carprice*$Cost_fixcost)/100);
                $priceMo2 = ceil(($mo_carprice*$Cost_fixcostend)/100); 
                $priceMo_1 = $Cost_fixcost;
                $priceMo_2 = $Cost_fixcostend;   
            }else{
                $priceMo1 = ceil(($mo_carprice*$Cost_fixcost)/100);
                $priceMo2 = ceil(($mo_carprice*$Cost_fixcostend)/100);
                $priceMo_1 = $Cost_fixcost;
                $priceMo_2 = $Cost_fixcostend;
            }
         
        //echo "<BR> $priceMo1 --- $priceMo2 <BR> $priceMo_1 ---  $priceMo_2";
         $stsearchcost = round($priceMo1, -4) ;
         $edsearchcost = round($priceMo2, -4) ;
         // echo "<BR/>".$Cost_fixcost." ".$Cost_brcar." ".$Cost_carold." ".$Cost_mocar." ".$Cost_mggroup." ".$Cost_mgstatus." ".$Cost_dateentry." ".$Cost_dateexpire; 

         //echo 'ทุนประกัน '.$stsearchcost.' ถึง '.$edsearchcost;
        
    
         

if ($cartypeee == '1') {
      $cartyppee = '110';
 }else{
      $cartyppee = '320';
 }

/*                    ///แปลงปีกับเป็นคศ. 
                    $y = date('Y');
                    for ($i = 1; $i <= 29; $i++) {
                        $th = $y + 543;
                    }
                    $caryear = $y-$yearcar+1;
                    //ปิด*/
/*    echo  "<BR/>ประเภท =".$type_informm;
    echo  "  ปีรุ่น Year =".$yearcar;
    echo  "  ปีรถ =".$yearP;
    echo  "  ประเภทการใช้ Cartypee =".$cartyppee;
    echo  "  ยี่ห้อรถยนต์ Br_car =".$br_carr;
    echo  "  รุ่น Mo_CAR =".$mocarr;
    echo  " ราคา Mocar_price =".$mo_carprice;*/


 
 function doComparison($a, $operator, $b)
{
    switch ($operator) {
        case '<':  return ($a <  $b); break;
        case '<=': return ($a <= $b); break;
        case '=':  return ($a == $b); break; // SQL way
        case '==': return ($a == $b); break;
        case '!=': return ($a != $b); break;
        case '>=': return ($a >= $b); break;
        case '>':  return ($a >  $b); break;
    }

}
?>
<?php 
        $claimall00 = $_POST['claimall'];
        $regis_date = $_POST['regis_date'];
        $mo_car= $_POST['mo_car1'];
        $end_date= $_POST['end_date'];
        $Cost_NEW= $_POST['cost_new'];
        $insured_type= $_POST['insured_type'];
        $carid= $_POST['carid'];
        $useLoss= $_POST['txt_loss'];  //%claim
        $claim_po= $_POST['txt_policy'];  //จำนวนเคลม
        $tprovince= $_POST['car_regis_pro'];  //จำนวนเคลม
        $dateN = date("Y-m-d");  //วันที่ปัจจุบัน
        $nowYear = date('Y'); //ปีปัจจุบัน
        $yearOld = number_format($nowYear-$yearcar)+1;
        // mysql_select_db($db2,$cndb2);       
        // mysql_query("SET NAMES 'utf8'");
        //echo "<BR/>".$nowYear.$yearOld; 
?>
<div id="myTabContent" class="tab-content" style="border:none !important;padding:10px !important">
    <div class="tab-pane fade active in" id="full-width">
        <div class="content-wrap">
            <div class="car_listings">
                <?php
               //$insured_type = "1";  

        $sqlRes ='';
        $sqlRes = " SELECT cp.name ,cm.comp_sort,cm.namegroup,cm.ins_type,cm.cmocar,cm.cmocar_sz, c.*"; 
        $sqlRes .= "FROM tb_cost c inner join tb_cost_mocar cm ON (c.mocargroup = cm.namegroup) ";
        $sqlRes .= "inner join tb_comp cp  ON (c.comp = cp.sort) ";
        //$sqlRes .= "inner join tb_mocar_cost mo  ON (cm.cmocar = mo.mocar) ";
        $sqlRes .= "WHERE  car_old <= ".$yearcar." AND car_old_end >= ".$yearcar." AND cm.cmocar IN ('".$mo_car."','ALL')  AND (cm.cstatus_sz = 'Y')";
        $sqlRes .= " AND (c.create_date <=  '".$dateN."' AND c.date_expired >= '".$dateN."') "; //เบี้ยจากวันปปัจจุบันที่เสนอราคา
        
        // if($_SESSION["4User"]!='TAA'){
        //     if ($type_informm== 1) {
        //         $sqlRes .= " AND (c.cost <= '".$Cost_fixcost."' AND c.cost_end >='".$Cost_fixcost."')";
        //     }
        // }

        $sqlRes .= " AND c.car_id = '".$cartyppee."'";
        $sqlRes .= " AND c.mocargroup != '' ";
        $sqlRes .= " AND c.insured_type = '".$type_informm."'";    
       // $sqlRes .= " AND SELECT * FROM tb_mocar_cost where mo_car = $mocarr ORDER BY cost";     
        $sqlRes .= " AND c.prod_name NOT IN ('SA1','SA2','SA5','SA6','SA7','SA8') ";     
        $sqlRes .= " group by c.prod_name  ,pre , cm.cmocar_sz ORDER BY `repair` ASC ,c.`comp`  ASC ";
        $resSql = PDO_CONNECTION::fourinsure_insured()->query($sqlRes);
        $numsql = $resSql->rowCount();
        //echo $sqlRes;
        
        $runc =1;
        $firstrepair = 0; 
        ?>

                <!-- <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script> -->
                <script type="text/javascript">
                $(function() {
                    $("#btnSearch").click(function() {
                        $.ajax({
                            url: "search.php",
                            type: "post",
                            data: {
                                itemname: $("#itemname").val()
                            },
                            beforeSend: function() {
                                $(".loading").show();
                            },
                            complete: function() {
                                $(".loading").hide();
                            },
                            success: function(data) {
                                $("#list-data").html(data);
                            }
                        });
                    });
                    $("#searchform").on("keyup keypress", function(e) {
                        var code = e.keycode || e.which;
                        if (code == 13) {
                            $("#btnSearch").click();
                            return false;
                        }
                    });
                });
                </script>


                <table class="" id="example1" name="viewdata" width="100%" border="0" aria-describedby="messenger_info">
                    <thead>
                        <tr>
                            <td class="span3 e-span3 design-ti_3 color_font_ti" scope="col">บริษัทประกันภัย</td>
                            <td class="span1 e-span1 design-ti_3 color_font_ti" scope="col">ประเภท</td>
                            <td class="span1 e-span1 design-ti_3 color_font_ti" scope="col">ทุนประกัน <BR />
                                <?php echo  $stsearchcost.' ถึง '.$edsearchcost; ?>
                            </td>
                            <td class="span1 e-span1 design-ti_3 color_font_ti" scope="col">ซ่อม</td>
                            <td class="span2 e-span2 design-ti_3 color_font_ti" scope="col">กลุ่มผลิตภัณฑ์</td>
                            <td class="span1 e-span1 design-ti_3 color_font_ti" scope="col">เบี้ย</td>
                            <td class="span3 e-span3 design-ti_3 color_font_ti_stop" scope="col">-</td>
                        </tr>
                        <!--  <?php if($numsql<=0){ ?>
            <tr>
            <td colspan='7' class='color_font_form'><center><font color='red' size='4'>ไม่มี Package!</font></center></td>
            </tr>
        <?php } ?> -->

                        <?php

         // $arrData  = array();
         // $arrDatachk  = array();
         $arrDatachkTMP = array();
       
         $nn = 0;
        foreach($resSql->fetchAll(2) as $arrDatares){
            ///////START NEW BETWEEN///////// 
			$dtst1=''; $dtst2=''; $stuseid1=''; $stuseid2='';$blcolor='';$dstartcost='';$dendcost='';

            if($stsearchcost>=$arrDatares['cost'] && $stsearchcost<=$arrDatares['cost_end']){
                $dtst1 =  "ST : ".$arrDatares['mocargroup'];
                $stuseid1 = $arrDatares['id'];
                $dstartcost = $stsearchcost;
            }
            if($edsearchcost>=$arrDatares['cost'] && $edsearchcost<=$arrDatares['cost_end']){
                $dtst2 =  "ED : ".$arrDatares['mocargroup'];
                $stuseid2 = $arrDatares['id'];
                $dendcost = $edsearchcost;
            }
            if($stuseid1==$stuseid2 && $stuseid2=''){
            $blchk =  $nn.' ST COST:'.$stsearchcost.' ID :'.$dtst1.':'.$stuseid1.' ED COST : '.$edsearchcost.':'.$dtst2.' ID :'.$stuseid2." SAME ID    =>".$arrDatares['cost'].'-'.$arrDatares['cost_end'].'<br><br><br>';
            		$blcolor =  " style='background:#ccc;' ";
            }else{
            	if($stuseid1!=''){
            		$blcolor =  " style='background:#ccc;' ";
            		$dstartcost = $stsearchcost;
            	}
            	if($stuseid2!=''){
            		$blcolor =  " style='background:#e5e5e5;' ";
            		$dendcost =  $arrDatares['cost'];
            	}
            	if($stuseid1=='' && $stuseid2==''){
            		$blcolor =  " style='background:#fff;' ";
            	}
             $blchk = $nn.' ST COST:'.$stsearchcost.' ID :'.$dtst1.':'.$stuseid1.' ED COST : '.$edsearchcost.':'.$dtst2.' ID :'.$stuseid2." DIFF ID    USE:".$dstartcost.'-'.$dendcost.'<br><br>';
            	
            }
             if($stuseid1!='' || $arrDatares['ins_type']!='1'){
            $arrDatachkTMPC[$nn]=  array(
                                'comp_sort'=> "{$arrDatares['comp_sort']}",
                                'mocargroup'=> "{$arrDatares['mocargroup']}",
                                'name'=> "{$arrDatares['name']}",
                                'ins_type' => "{$arrDatares['ins_type']}",
                                'cost' => "{$arrDatares['cost']}",
                                'cost_end' => "{$arrDatares['cost_end']}",
                                'cost_range' => "{$arrDatares['cost_range']}",
                                'pre' => "{$arrDatares['pre']}",
                                'net' => "{$arrDatares['net']}",
                                'prod_name' => "{$arrDatares['prod_name']}",
                                'prod_remark' => "{$arrDatares['prod_remark']}",
                                'repair' => "{$arrDatares['repair']}",
                                'protect_type' => "{$arrDatares['protect_type']}",
                                'id' => "{$arrDatares['id']}",
                                'prod_condition' => "{$arrDatares['prod_condition']}",
                                'diffstatus'=>"{$blchk}",
                                'diffcolor'=>"{$blcolor}"
                            );
          }
        
                   $arrDatachk = $arrDatachkTMP;
                  
                 //END area develop

            $nn++;

           

        }


  $typep1 = is_countable($arrDatachkTMPC);

  $arrDatachkTMPC = $arrDatachkTMPC==null?array():$arrDatachkTMPC;

  if (($typep1<=0 && $type_informm==1 )|| $numsql<=0) { //เช็คว่ามีข้อมูล หรือ ไม่มีข้อมูล
      ?> <tr>
                            <td colspan='7' class='color_font_form'>
                                <center>
                                    <font color='red' size='4'>ไม่มี Package!</font>
                                </center>
                            </td>
                        </tr>
                        <?php
  }

     
            foreach( $arrDatachkTMPC as $arrRes)
            {
            $comp_sort= $arrRes['comp_sort'];
            $ins_comp= $arrRes['name'];
            $ins_type = $arrRes['ins_type'];
            $ins_cost = $arrRes['cost'];
            $ins_cost_end = $arrRes['cost_end'];
            $ins_cost_range = $arrRes['cost_range'];
            $ins_pre = $arrRes['pre'];
            $ins_net = $arrRes['net'];
            $ins_prod_name = $arrRes['prod_name'];
            $ins_prod_remark = $arrRes['prod_remark'];
            $trepair = $arrRes['repair'];
            $ins_protect_type = $arrRes['protect_type'];
            $inscost_id = $arrRes['id'];
            $diffstatus = $arrRes['diffstatus'];
            $diffcolor = $arrRes['diffcolor'];


            if($trepair=='1'){
                $tservice =  'ซ่อมห้าง';
            }else if($trepair=='2'){
                $tservice =  'ซ่อมอู่';
                $firstrepair=$firstrepair+1;
            }
             $Cost_newuse='';
            if($ins_cost<=$Cost_fixcost && $Cost_fixcost <= $ins_cost_end){
                $Cost_newuse = $Cost_fixcost;

            }else{
                $Cost_newuse = $ins_cost_end;
            }
        $ins_focus = $comp_sort.'|'.$ins_type.'|'.$Cost_newuse.'|'.$ins_cost.'|'.$ins_cost_end.'|'.$ins_cost_range.'|'.$trepair.'|'.$ins_pre.'|'.$ins_net.'|'.$ins_prod_name.'|'.$ins_prod_remark.'|'.$ins_comp.'|'.$ins_protect_type.'|'.$inscost_id.'|'.$yearcar.'|'.$cartypeee.'|'.$br_carr.'|'.$mocarr.'|'.$yearP;


        $prod_condition = $arrRes['prod_condition'];
        $excond = '';
        $chkC = 0;
        $chkL = 0;
        $chkLALL = 0;
        $chkA = 0;
        $chkALLA =0;
        $chkALLN =0;
        $chkALLF =0;
        if(!empty($prod_condition)){
            $excond = explode('|',$prod_condition);
            for($ic=0;$ic<count($excond);$ic++){
                $firstcheck =   substr($excond[$ic],0,1);  
                // เช็คจำนวน PO เคลมก่อน
                if($firstcheck=='C'){
                    $chkdataC = explode(",",$excond[$ic]);
                    if(doComparison($claim_po,$chkdataC[1],$chkdataC[2])){
                        $chkC+=1;
                    }
                }
                if($firstcheck=='L'){
                    $chkLALL += 1;
                    $chkdataL = explode(",",$excond[$ic]);
                    if(doComparison($useLoss,$chkdataL[1],$chkdataL[2])){
                        $chkL += 1 ;
                    }
                }
                if($firstcheck=='A'){
                    $chkALLA +=1;
                    $chkdataA = explode(",",$excond[$ic]);
                    if(doComparison($tprovince,$chkdataA[1],$chkdataA[2])){
                        $chkA+=1;
                    }
                }
                if($firstcheck=='N'){
                    $chkALLN +=1;
                }
                if($firstcheck=='F'){
                    $chkALLF +=1;
                }

            }
        
            $CvalData='';
            $CvalSet='';
            if($chkLALL!=0 && $chkLALL == $chkL){
                if($chkC>=0){
                    $CvalData .= "C condition :USE";

                }else{
                    $CvalData .=  "L ตรงเงื่อนไข";
                }

                ?>
                        <tr <?php echo $diffcolor;?>>
                            <td class='color_font_form' data-label="บริษัทประกันภัย"><span><img
                                        src="images/logo_insured/<?php echo $comp_sort;?>.png"
                                        style="height:50px;"></span>
                                <span style="font-size:12px;padding-left:5px;"><?php echo $ins_comp;?></span>
                            </td>
                            <td class='color_font_form' data-label="ประเภท" align="center"><?php echo $ins_type;?></td>
                            <td class='color_font_form' data-label="ทุนประกัน" align="center">
                                <?php echo ' ('.$ins_cost.' - '.$ins_cost_end.')';?></td>
                            <!-- number_format($Cost_newuse,2). -->
                            <td class='color_font_form' data-label="ซ่อม" align="center"><?php echo $tservice;?></td>
                            <td class='color_font_form' data-label="กลุ่มผลิตภัณฑ์"><?php echo $ins_prod_name;?></td>
                            <td class='color_font_form' data-label="เบี้ย" align="center">
                                <B><?php echo number_format($ins_net,2);?> </B>
                            </td>
                            <td class='color_font_form' data-label="เสนอราคา" align='center'><a
                                    onclick="funcQuatation('<?php echo $ins_protect_type;?>','<?php echo $ins_comp;?>','<?php echo $ins_type;?>','<?php echo $tservice;?>','<?php echo $ins_net;?>','<?php echo $Cost_newuse;?>','<?php echo $comp_sort;?>','<?php echo $yearcar;?>');"
                                    class="span5 btn btn-info" data-toggle="modal" data-target="#story_send"><i
                                        class="icon-search  icon-white"></i>ความคุ้มครอง</a>
                                <input type="hidden" name="datause<?php echo $runc;?>" id="datause<?php echo $runc;?>"
                                    value="<?php echo $ins_focus;?>">
                                <div onclick="funcQtext('<?php echo $runc;?>');" class="span4 btn btn-inverse"
                                    data-toggle="modal" data-target="#myquotation">เสนอราคา</div>
                            </td>
                        </tr>

                        <?php
            }else if($chkALLA>0 && $chkA>0){
        ?>
                        <tr <?php echo $diffcolor;?>>
                            <td class='color_font_form' data-label="บริษัทประกันภัย"><span><img
                                        src="images/logo_insured/<?php echo $comp_sort;?>.png"
                                        style="height:50px;"></span>
                                <span style="font-size:12px;padding-left:5px;"><?php echo $ins_comp;?></span>
                            </td> <!-- <?php echo '<br>'.$diffstatus;?> -->
                            <td class='color_font_form' data-label="ประเภท" align="center"><?php echo $ins_type;?></td>
                            <td class='color_font_form' data-label="ทุนประกัน" align="center">
                                <?php echo ' ('.$ins_cost.' - '.$ins_cost_end.')';?></td>
                            <!-- number_format($Cost_newuse,2). -->
                            <td class='color_font_form' data-label="ซ่อม" align="center"><?php echo $tservice;?></td>
                            <td class='color_font_form' data-label="กลุ่มผลิตภัณฑ์"><?php echo $ins_prod_name;?></td>
                            <td class='color_font_form' data-label="เบี้ย" align="center">
                                <B><?php echo number_format($ins_net,2);?> </B>
                            </td>
                            <td class='color_font_form' data-label="เสนอราคา" align='center'> <a
                                    onclick="funcQuatation('<?php echo $ins_protect_type;?>','<?php echo $ins_comp;?>','<?php echo $ins_type;?>','<?php echo $tservice;?>','<?php echo $ins_net;?>','<?php echo $Cost_newuse;?>','<?php echo $comp_sort;?>','<?php echo $yearcar;?>');"
                                    class="span5 btn btn-info btn-lg" data-toggle="modal" data-target="#story_send"><i
                                        class="icon-search  icon-white"></i>ความคุ้มครอง</a>
                                <input type="hidden" name="datause<?php echo $runc;?>" id="datause<?php echo $runc;?>"
                                    value="<?php echo $ins_focus;?>">
                                <div onclick="funcQtext('<?php echo $runc;?>');" class="span4 btn btn-inverse"
                                    data-toggle="modal" data-target="#myquotation">เสนอราคา</div>
                            </td>
                        </tr>
                        <?php
            }else if($chkALLN>0){
        ?>

                        <tr <?php echo $diffcolor;?>>
                            <td class='color_font_form' data-label="บริษัทประกันภัย"><span><img
                                        src="images/logo_insured/<?php echo $comp_sort;?>.png"
                                        style="height:50px;"></span>
                                <span style="font-size:12px;padding-left:5px;"><?php echo $ins_comp;?></span>
                            </td> <!-- <?php echo '<br>'.$diffstatus;?> -->
                            <td class='color_font_form' data-label="ประเภท" align="center"><?php echo $ins_type;?></td>
                            <td class='color_font_form' data-label="ทุนประกัน" align="center">
                                <?php echo ' ('.$ins_cost.' - '.$ins_cost_end.')';?></td>
                            <!-- number_format($Cost_newuse,2). -->
                            <td class='color_font_form' data-label="ซ่อม" align="center"><?php echo $tservice;?></td>
                            <td class='color_font_form' data-label="กลุ่มผลิตภัณฑ์"><?php echo $ins_prod_name;?></td>
                            <td class='color_font_form' data-label="เบี้ย" align="center">
                                <B><?php echo number_format($ins_net,2);?> </B>
                            </td>
                            <td class='color_font_form' data-label="เสนอราคา" align='center'> <a
                                    onclick="funcQuatation('<?php echo $ins_protect_type;?>','<?php echo $ins_comp;?>','<?php echo $ins_type;?>','<?php echo $tservice;?>','<?php echo $ins_net;?>','<?php echo $Cost_newuse;?>','<?php echo $comp_sort;?>','<?php echo $yearcar;?>');"
                                    class="span5 btn btn-info btn-lg" data-toggle="modal" data-target="#story_send"><i
                                        class="icon-search  icon-white"></i>ความคุ้มครอง</a>
                                <input type="hidden" name="datause<?php echo $runc;?>" id="datause<?php echo $runc;?>"
                                    value="<?php echo $ins_focus;?>">
                                <div onclick="funcQtext('<?php echo $runc;?>');" class="span4 btn btn-inverse"
                                    data-toggle="modal" data-target="#myquotation">เสนอราคา</div>
                            </td>
                        </tr>

                        <?php  
        }
        }else{  // ไม่มีเงื่อนไขพิเศษ ?>
                        <tr <?php echo $diffcolor;?>>
                            <td class='color_font_form' data-label="บริษัทประกันภัย"><span><img
                                        src="images/logo_insured/<?php echo $comp_sort;?>.png"
                                        style="height:50px;"></span>
                                <span style="font-size:12px;padding-left:5px;"><?php echo $ins_comp;?></span>
                            </td> <!-- <?php echo '<br>'.$diffstatus;?> -->
                            <td class='color_font_form' data-label="ประเภท" align="center"><?php echo $ins_type;?></td>
                            <td class='color_font_form' data-label="ทุนประกัน" align="center">
                                <?php echo ' ('.$ins_cost.' - '.$ins_cost_end.')';?></td>
                            <!-- number_format($Cost_newuse,2). -->
                            <td class='color_font_form' data-label="ซ่อม" align="center"><?php echo $tservice;?></td>
                            <td class='color_font_form' data-label="กลุ่มผลิตภัณฑ์"><?php echo $ins_prod_name;?></td>
                            <td class='color_font_form' data-label="เบี้ย" align="center">
                                <B><?php echo number_format($ins_net,2);?> </B>
                            </td>
                            <td class='color_font_form' data-label="ความคุ้มครอง" align='center'>
                                <a onclick="funcQuatation('<?php echo $ins_protect_type;?>','<?php echo $ins_comp;?>','<?php echo $ins_type;?>','<?php echo $tservice;?>','<?php echo $ins_net;?>','<?php echo $Cost_newuse;?>','<?php echo $comp_sort;?>','<?php echo $yearcar;?>');"
                                    class="span5 btn btn-info btn-lg" data-toggle="modal" data-target="#story_send"><i
                                        class="icon-search  icon-white"></i>ความคุ้มครอง</a>
                                <input type="hidden" name="datause<?php echo $runc;?>" id="datause<?php echo $runc;?>"
                                    value="<?php echo $ins_focus;?>">
                                <div onclick="funcQtext('<?php echo $runc;?>','<?php echo $tservice;?>');"
                                    class="span4 btn btn-inverse" data-toggle="modal" data-target="#myquotation">
                                    เสนอราคา</div>
                            </td>


                        </tr>
                        <?php } ?>


                        <?php 
            if($runc%3==0){ echo "<div style='clear:both'></div>";}
            $runc++;  
    }

?>
                </table>




                <div id='showdata' class="loading-img"></div>


                <script>
                function funcQtext(id) {
                    var ajaxdata = $("#datause" + id).val();
                    var id_data = '<?php echo $_POST["IDDATA"];?>';
                    var title_text = '';
                    var footer_text = '';
                    title_text += 'ทำใบเสนอราคา&nbsp;&nbsp;&nbsp;';
                    title_text +=
                        '<a type="button" name="button" id="SelectCus" class="btn btn-inverse"  >ลูกค้าเก่า</a>&nbsp;';
                    title_text +=
                        '<a type="button" name="button"  class="btn btn-inverse" id="SelectCusOrder2" >ค้นหาใบเสนอราคา</a>';
                    footer_text += '<button type="button" class="btn btn-inverse" onclick="SaveI();">บันทึก</button>';
                    footer_text += '<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>';
                    $("#title_text_renew").html(title_text);
                    $("#footer_text_renew").html(footer_text);
                    $.post("ajax/ajax_test_quote_four.php", {
                        id_data: id_data,
                        detail_data: ajaxdata
                    }, function(data) {
                        $("#data_quote_renew").html(data);
                    });
                }
                </script>


                <script type="text/javascript" src="js/jquery-1.8.3.js"></script>
                <script type="text/javascript">
                function funcQuatation(data1, data2, data3, data4, data5, data6, data7, data8) {
                    var so = {
                        url: "ajax/ajaxtest_suzuki.php",
                        type: 'POST',
                        data: {
                            ins_protect_type: data1,
                            ins_comp: data2,
                            tservice: data3,
                            ins_type: data4,
                            ins_net: data5,
                            ins_cost_end: data6,
                            comp_sort: data7,
                            yearcar: data8
                        },
                        success: function(mes) {
                            $('#send_body').html(mes);
                        }
                    };
                    $.ajax(so);
                }
                </script> <!-- $ins_comp,$ins_type,$tservice,$ins_net ,'<?php echo $comp_sort;?>' -->