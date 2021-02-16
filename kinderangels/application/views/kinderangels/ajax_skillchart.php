<?php 
//error_reporting(E_ALL);
?>
<?php if(isset($bspi) && $bspi!=''){
if($type=="BASIC")
{?><div class="col-md-12 col-sm-12 col-xs-12 text-center">
	<div class="col-md-12 col-sm-12 col-xs-12 text-center">
		<div class="chartbd">
			<div class="panel panel-default minhe3" style="background: #fff;">
				<div class="panel-body">
				<h2 class="Mh2">Skill Score</h2>
					<div class="reportChartContainer1">
						<div id="SkillChart"></div>
						 
					 </div> 
				</div>
			</div>
		</div>
	</div>
	<!--<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="chartbd">
			<div class="panel panel-default minhe3" style="background: #fff;">
				<div class="panel-body">
					<h2 class="Mh2"><?php echo $CurrentBSPIName['0']['name']; ?></h2>
						<div id="score" class="block"  style="text-align:center; font-size: 25px;font-weight: bold;"><?php echo round($bspi,2); ?></div>
					<div class="" style="background: #fff;">
						<div id="chart-container5"  style=""></div>
					</div>
				</div>
			</div>
		</div>
	</div>-->
</div>
<?php 
}
else
{
?>
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
	<div class="col-md-6 col-sm-6 col-xs-12 text-center">
		<div class="chartbd"> 
			<div class="panel panel-default minhe3" style="background: #fff;">
				<div class="panel-body">
				<h2 class="Mh2">Skill Score</h2>
					<div class="reportChartContainer1">
						<div id="AdvanceSkillChart"></div>
					 
					 </div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="chartbd">
			<div class="panel panel-default minhe3" style="background: #fff;">
				<div class="panel-body">
					<h2 class="Mh2"><?php echo $CurrentBSPIName['0']['name']; ?></h2>
					<div id="score1" class="block"  style="text-align:center; font-size: 25px;font-weight: bold;"><?php echo round($bspi,2); ?></div>
					<div class="" style="background: #fff;">
						<div id="chart-container4"  style=""></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
}}else{
?>
	<div class="col-md-12 col-sm-12 col-xs-12 text-center">	
		<div class="col-md-12 col-sm-12 col-xs-12 text-center">	
			<div class="chartbd">  			
				<div class="panel panel-default" style="background: #fff;">		
					<div class="panel-body">	
						<div class="reportChartContainer1">	
							<div style="background:#d05858;color:#fff;">No data found</div>
						</div>		
					</div>		
				</div>	
			</div>	
		</div>
	</div>
<?php }?>

<script src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.js"></script>
<script src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.theme.fint.js"></script>
<script src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.widgets.js"></script>
<script>
<?php 
if(isset($bspi) && $bspi!='')
{ 
	if($type=="BASIC")
	{
?>
	Highcharts.chart('SkillChart', {
		colors: [<?php $c=0;
			foreach($skills as $skillid)
			{
				$c++;
				if($c>1){echo ",";}
				echo "'".$skillid['colorcode']."'";
			} ?>],
		chart: {
			type: 'column',
			/* backgroundColor: {
				linearGradient: [0, 0, 500, 500],
				stops: [
					[0, 'rgb(255, 255, 255)'],
					[1, 'rgb(240, 240, 255)']
				]
			}, */

			/* options3d: {
				enabled: true, 
				viewDistance: 25
			} */
		},
		title: {
			text: ''
		},
		credits: {
            enabled: false
        },
		xAxis: 
		{
			categories:[
			<?php $i=0;
			foreach($skills as $skillid)
			{
				$i++;
				if($i>1){echo ",";}
				echo "'".$skillid['name']."'";
			}
			?>
			],
			gridLineWidth: 0,
  minorGridLineWidth: 0,
			/* labels: {
				skew3d: true,
				style: {
					fontSize: '16px'
				}
			} */
		},
		yAxis: {
            min: 0,
            max: 100,
            tickInterval: 25
		},
		plotOptions: {
			series: {
				depth: 25,
				colorByPoint: true,
				dataLabels: {
					enabled: true,
					format: '{point.y:.f}'
				}
			}
		},
		series: [{
			data: [
			<?php $i=0;
			foreach($skills as $skillid)
			{
				$i++;
				if($i>1){echo ",";}
				if(isset($SkillChart[$skillid['id']]) && $SkillChart[$skillid['id']]!='')
				{
					$Score=round($SkillChart[$skillid['id']],2);
				}
				else
				{
					$Score=0;
				}
				echo $Score;
			}
			?>
			],
			name: 'Score',
			showInLegend: false
		}]
	}); 
	
	/* FusionCharts.ready(function () {
    var csatGauge = new FusionCharts({
        "type": "angulargauge",
        "renderAt": "chart-container5","background":"transparent",
        "width": "100%",
        "height": "250",
        "dataFormat": "json",
            "dataSource": 
			{
				"chart": 
				{
					"caption": "",
					"lowerlimit": "0",
					"upperlimit": "100",
					"bgAlpha":'0',
					"gaugeFillRatio": "15",
					"theme": "fint" 
				},
				"colorrange": 
				{
					"color": 
					[
						{
							"minvalue": "0",
							"maxvalue": "20",
							"code": "c01f25"
						},
						{
							"minvalue": "20",
							"maxvalue": "40",
							"code": "f36621"
						},
						{
							"minvalue": "40",
							"maxvalue": "60",
							"code": "fdc010"
						},
						{
							"minvalue": "60",
							"maxvalue": "80",
							"code": "94c953"
						},
						{
							"minvalue": "80",
							"maxvalue": "100",
							"code": "00b04e"
						}
					]
				},
				"dials": {
					"dial": [
						{
							"value": <?php echo round($bspi,2); ?>,
							"rearextension": "15",
							"radius": "100",
							"bgcolor": "333333",
							"bordercolor": "333333",
							"basewidth": "8"
						}
					]
				}
		}
      });

csatGauge.render();
}); */
<?php 
}
else
{
?>
Highcharts.chart('AdvanceSkillChart', {
		colors: ['#da0404', '#ffc000', '#92d050', '#ff6600', '#00b0f0'],
		chart: {
			type: 'cylinder',
				/* backgroundColor: {
				linearGradient: [0, 0, 500, 500],
				stops: [
					[0, 'rgb(255, 255, 255)'],
					[1, 'rgb(240, 240, 255)']
				]
			}, */
			/* options3d: {
				enabled: true,
				 
				viewDistance: 25
			} */
		},
		title: {
			text: ''
		},
		credits: {
            enabled: false
        },
		xAxis: 
		{
			categories:[<?php $i=0;
			foreach($skills as $skillid)
			{
				$i++;
				if($i>1){echo ",";}
				echo "'".$skillid['name']."'";
			}
			?>],
			/* labels: {
				skew3d: true,
				style: {
					fontSize: '16px'
				}
			} */
		},
		yAxis: {
            min: 0,
            max: 100,
            tickInterval: 25
		},
		plotOptions: {
			series: {
				depth: 25,
				colorByPoint: true,
				dataLabels: {
					enabled: true,
					format: '{point.y:.f}'
				}
			}
		},
		series: [{
			data: [
			<?php $j=0;
			foreach($skills as $skillid)
			{
				$j++;
				if($j>1){echo ",";}
				if(isset($SkillChart["SID".$skillid['id']]) && $SkillChart["SID".$skillid['id']]!='')
				{
					$Score=round($SkillChart["SID".$skillid['id']],2);
				}
				else
				{
					$Score=0;
				}
				echo $Score;
			}
			?>		
			],
			name: 'Score',
			showInLegend: false
		}]
	});
	
FusionCharts.ready(function () {
    var csatGauge = new FusionCharts({
        "type": "angulargauge",
        "renderAt": "chart-container4","background":"transparent",
        "width": "100%",
        "height": "250",
        "dataFormat": "json",
            "dataSource": 
			{
				"chart": 
				{
					"caption": "",
					"lowerlimit": "0",
					"upperlimit": "100",
					"bgAlpha":'0',
					"gaugeFillRatio": "15",
					"theme": "fint" 
				},
				"colorrange": 
				{
					"color": 
					[
						{
							"minvalue": "0",
							"maxvalue": "20",
							"code": "c01f25"
						},
						{
							"minvalue": "20",
							"maxvalue": "40",
							"code": "f36621"
						},
						{
							"minvalue": "40",
							"maxvalue": "60",
							"code": "fdc010"
						},
						{
							"minvalue": "60",
							"maxvalue": "80",
							"code": "94c953"
						},
						{
							"minvalue": "80",
							"maxvalue": "100",
							"code": "00b04e"
						}
					]
				},
				"dials": {
					"dial": [
						{
							"value": <?php echo round($bspi,2); ?>,
							"rearextension": "15",
							"radius": "100",
							"bgcolor": "333333",
							"bordercolor": "333333",
							"basewidth": "8"
						}
					]
				}
		}
      });

csatGauge.render();
});
<?php 
}
}
?>

 
</script>
<style>
.minhe3{min-height:469px;}
</style>