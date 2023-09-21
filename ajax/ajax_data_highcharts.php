<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
if(!empty($_POST['id_dealer']) || !empty($_POST['date_year']))
{
	$id_dealer=$_POST['id_dealer'];
	$date_year=$_POST['date_year'];
	$sql="";
	$title_text="";
	if(!empty($id_dealer))
	{
		$sql.=" AND data.login = '".$id_dealer."' ";
		$title_text.=" ของดิลเลอร์ ".$id_dealer;
	}
	if(!empty($date_year))
	{
		$sql.=" AND YEAR(data.send_date) = '".$date_year."' ";
		$title_text.=" ประจำปี ".$date_year;
	}
}
$select_data_sql="SELECT detail.br_car,tb_br_car.name,detail.car_id
			FROM data 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			INNER JOIN insuree ON (data.id_data  = insuree.id_data) 
			INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car) 
			INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) 
			INNER JOIN tb_cost ON (data.costCost  = tb_cost.id) 
			INNER JOIN act ON (data.id_data  = act.id_data) 
			INNER JOIN req ON (data.id_data  = req.id_data)
WHERE data.id_data != '' AND req.EditCancel = '' AND detail.car_id!='' AND detail.car_id!='0' AND detail.br_car !='' AND detail.br_car !='0' ".$sql." GROUP BY detail.br_car ORDER BY data.send_date ASC";
$select_data_query=mysql_query($select_data_sql,$cndb1);
$select_data_num=(mysql_num_rows($select_data_query)-1);
$i=0;
$sql_br_name="";
$total=0;
?>
<div id="container"></div>
<script>
var colors = Highcharts.getOptions().colors,
    
    data = [
	<?php while($select_data_array=mysql_fetch_array($select_data_query)) {
		$select_detail_sql="SELECT detail.mo_car
		FROM data 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			INNER JOIN insuree ON (data.id_data  = insuree.id_data) 
			INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car) 
			INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) 
			INNER JOIN tb_cost ON (data.costCost  = tb_cost.id) 
			INNER JOIN act ON (data.id_data  = act.id_data) 
			INNER JOIN req ON (data.id_data  = req.id_data)
		WHERE data.id_data != '' AND req.EditCancel = '' AND detail.car_id!='' AND detail.car_id!='0' AND detail.br_car = '".$select_data_array['br_car']."' AND detail.mo_car !='' AND detail.mo_car !='0' ".$sql."ORDER BY data.send_date ASC";
		$select_detail_query=mysql_query($select_detail_sql,$cndb1);
		$select_detail_num=mysql_num_rows($select_detail_query);
		$total+=$select_detail_num;
	?>
	
	{
        y: <?php echo $select_detail_num; ?>,
        color: colors[<?php echo $i; ?>],
        drilldown: {
            name: '<?php echo $select_data_array['name']." ".$select_data_array['car_id']; ?>',
			<?php
			$select_mo_car_sql="SELECT detail.mo_car,tb_mo_car.name
			FROM data 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			INNER JOIN insuree ON (data.id_data  = insuree.id_data) 
			INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car) 
			INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) 
			INNER JOIN tb_cost ON (data.costCost  = tb_cost.id) 
			INNER JOIN act ON (data.id_data  = act.id_data) 
			INNER JOIN req ON (data.id_data  = req.id_data)
			WHERE data.id_data != '' AND req.EditCancel = '' AND detail.car_id!='' AND detail.car_id!='0' AND  detail.car_id = '".$select_data_array['car_id']."' AND detail.br_car = '".$select_data_array['br_car']."' AND detail.mo_car !='' AND detail.mo_car !='0' ".$sql."GROUP BY detail.mo_car ORDER BY data.send_date ASC";
			$select_mo_car_query=mysql_query($select_mo_car_sql,$cndb1);
			$select_mo_car_num=mysql_num_rows($select_mo_car_query)-1;
			$text_mo_car="";
			$num_mo_car="";
			$n=0;
			while($select_mo_car_array=mysql_fetch_array($select_mo_car_query))
			{
				$select_number_sql="SELECT detail.mo_car
				FROM data 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			INNER JOIN insuree ON (data.id_data  = insuree.id_data) 
			INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car) 
			INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) 
			INNER JOIN tb_cost ON (data.costCost  = tb_cost.id) 
			INNER JOIN act ON (data.id_data  = act.id_data) 
			INNER JOIN req ON (data.id_data  = req.id_data)
				WHERE data.id_data != '' AND req.EditCancel = '' AND detail.car_id!='' AND detail.car_id!='0' AND  detail.car_id = '".$select_data_array['car_id']."' AND detail.mo_car = '".$select_mo_car_array['mo_car']."' AND detail.mo_car !='' AND detail.mo_car !='0' ".$sql." ORDER BY data.send_date ASC";
				$select_number_query=mysql_query($select_number_sql,$cndb1);
				$select_number_num=mysql_num_rows($select_number_query);
				if($n<$select_mo_car_num){$commas_mo=",";}else{$commas_mo="";}	
				$text_mo_car.="'".$select_mo_car_array['name']."'".$commas_mo;
				$num_mo_car.=$select_number_num." ".$commas_mo;
				
			}
			?>
            categories: [<?php echo $text_mo_car; ?>],
            data: [<?php echo $num_mo_car; ?>],
            color: colors[<?php echo $i; ?>]
        }
    }<?php if($i<$select_data_num){echo $commas=","; }else{echo $commas=""; }
			
	$sql_br_name.="'".$select_data_array['name']." ".$select_data_array['car_id']."'".$commas;
	
	 $i++; } ?>
	],
	categories = [<?php echo $sql_br_name; ?>],
    browserData = [],
    versionsData = [],
    i,
    j,
    dataLen = data.length,
    drillDataLen,
    brightness;


// Build the data arrays
for (i = 0; i < dataLen; i += 1) {

    // add browser data
    browserData.push({
        name: categories[i],
        y: data[i].y,
        color: data[i].color
    });

    // add version data
    drillDataLen = data[i].drilldown.data.length;
    for (j = 0; j < drillDataLen; j += 1) {
        brightness = 0.2 - (j / drillDataLen) / 5;
        versionsData.push({
            name: data[i].drilldown.categories[j],
            y: data[i].drilldown.data[j],
            color: Highcharts.Color(data[i].color).brighten(brightness).get()
        });
    }
}

// Create the chart
Highcharts.chart('container', {
    chart: {
        type: 'pie'
    },
    title: {
	text: 'รายงานยอดขาย [Suzuki]<?php echo $title_text;?>'
    },
    subtitle: {
        text: 'จำนวนรายการขาย ทั้งหมด <?php echo $total; ?> รายการ'
    },
    yAxis: {
        title: {
            text: 'Total percent market share'
        }
    },
    plotOptions: {
        pie: {
            shadow: false,
            center: ['50%', '50%']
        }
    },
    tooltip: {
        valueSuffix: ''
    },
    series: [{
        name: 'จำนวนขาย',
        data: browserData,
        size: '60%',
        dataLabels: {
            formatter: function () {
                return this.y > 5 ? this.point.name : null;
            },
            color: '#ffffff',
            distance: -30
        }
    }, {
        name: 'จำนวนขาย',
        data: versionsData,
        size: '80%',
        innerSize: '60%',
        dataLabels: {
            formatter: function () {
                // display only if larger than 1
                return this.y > 1 ? '<b>' + this.point.name + ':</b> ' +
                    this.y + ' รายการ' : null;
            }
        },
        id: 'versions'
    }],
    responsive: {
        rules: [{
            condition: {
                maxWidth: 400
            },
            chartOptions: {
                series: [{
                    id: 'versions',
                    dataLabels: {
                        enabled: false
                    }
                }]
            }
        }]
    }
});
<?php if($select_data_num<0){ ?>
alert("ไม่มีข้อมูลขาย<?php echo $title_text;?>");
<?php } ?>
$(".highcharts-credits").hide();
$(".highcharts-button").hide();
</script>