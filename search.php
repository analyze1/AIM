<?php
include "inc/connectdbs.inc.php";
mysql_select_db($db2,$cndb2);
$sql = "select * from tb_cost_mocar  where ins_type like '%{$_POST['itemname']}%'";
$query = mysql_query($sql);
?>
<div class="col-md-12">
    <table class="table table-bordered">
        <thead>
            <tr>
                 <th class="span2"><i class="icon-signal"></i> บริษัทประกันภัย</th>
                <th class="span1"><i class="icon-signal"></i> ประเภท</th>
                <th class="span1"><i class="icon-signal"></i> ทุนประกัน</th>
                <th class="span1"><i class="icon-signal"></i> ซ่อม</th>
                <th class="span1"><i class="icon-signal"></i> กลุ่มผลิตภัณฑ์</th>
                <th class="span1"><i class="icon-signal"></i> เบี้ย</th>
				<!--th class="span2">เสนอราคา</th -->
            </tr>
        </thead>
        <tbody>
            <?php $i=1; while ($result = mysql_fetch_assoc($query)) { ?>
            <tr>
               <td><?php echo $result['comp_sort'];?></td>
				<td><?php echo $result['namegroup'];?></td>               
				<td><?php echo $result['ins_type'];?></td>
				<td><?php echo $result['cmocar'];?></td>
                <td><?php echo $result['cstatus_sz'];?></td>
                <!--td>
				<input type="hidden" name="datause<?=$runc;?>" id="datause<?=$runc;?>" value="<?=$ins_focus;?>">
                    <div onclick="funcQuatation('<?=$runc;?>');" class="span11 btn btn-default">เสนอราคา</div>
				</td -->
              
            </tr>
            <?php $i++; } ?>
        </tbody>
    </table>
</div>