<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
if($_SESSION['claim']=='ADMIN' || $_SESSION["strUser"]=='admin')
{
	$dealer_name=ทุกดิลเลอร์;
	$sql="WHERE tb_stock_car.car_status != 'Y' ";
	$sql_num="";
}
else
{
	$dealer_name="ดิลเลอร์ ".$_SESSION["strUser"];
	$sql=" WHERE tb_stock_car.login = '".$_SESSION["strUser"]."' AND tb_stock_car.car_status != 'Y' ";
	$sql_num=" AND login = '".$_SESSION["strUser"]."'";
}
?>
<style>

.highcharts-container 
{
	margin-top:-25px;
	padding:0px;
}
</style>
<div id="container_stock" ></div>
<script type='text/javascript'>
Highcharts.getOptions().plotOptions.pie.colors = (function () {
    var colors = [],
        base = Highcharts.getOptions().colors[0],
        i;

    for (i = 0; i < 10; i += 1) {
        // Start out with a darkened base color (negative brighten), and end
        // up with a much brighter color
        colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
    }
    return colors;
}());

// Build the chart
Highcharts.chart('container_stock', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y:1f}</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y:1f}',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'จำนวน',
        data: [
		<?php
		$n=0;
		$select_mo_sql="SELECT tb_stock_car.id_mo_car,tb_mo_car.name FROM tb_stock_car
		INNER JOIN tb_mo_car ON (tb_stock_car.id_mo_car = tb_mo_car.id)
		".$sql." GROUP BY tb_stock_car.id_mo_car";
		$select_mo_query=mysql_query($select_mo_sql,$cndb1);
		while($select_mo_array=mysql_fetch_array($select_mo_query))
		{ 
			$select_num_sql="SELECT tb_stock_car.id_stock FROM tb_stock_car ".$sql." AND id_mo_car = '".$select_mo_array['id_mo_car']."'";
			$select_num_query=mysql_query($select_num_sql,$cndb1);
			$select_num=mysql_num_rows($select_num_query);
			if($n<=0)
			{ ?>
			{ name: '<?php echo $select_mo_array['name']; ?>', y: <?php echo $select_num; ?> }
			<?php } else {?>
			,{ name: '<?php echo $select_mo_array['name']; ?>', y: <?php echo $select_num; ?> }
			<?php } ?>
		<?php $n++; } ?>
        ]
    }]
});

$(".highcharts-background").hide();
$(".highcharts-button-symbol").hide();
$(".highcharts-button-box").hide();
$(".highcharts-credits").hide();
</script>