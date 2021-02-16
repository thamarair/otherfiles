<?php //echo "<pre>";print_r($getmonthlyscore);exit; ?>
<div id="loadingimage" style="display:none;"></div>
<style>
@media (min-width:1025px) {.counter {width: 16%;}}
@media (min-width:1281px) {.counter {width: 16%;}}
.counter {background:#1b7590; padding: 9px; margin: 2px; color:white;  }
.counterinnertxt { font-size: 15px; font-weight: bold; color: cornsilk;}


.tabnation{margin:20px;}
 
.tabactive a
{	
    box-shadow: 2px 5px 5px #3a0d11;
	background: #d24d57;
	color:#fff !important;
}
.tabinner{
	padding: 10px;
    border-top: 10px solid #33244e;
    border-left: 7px solid #ccc;
    border-right: 7px solid #ccc;
    border-bottom: 0px solid #33244e;
	font-size: 22px;
}
.tab a:hover,a:focus{text-decoration: none;color:#fff;}


/* BSPI METER STYLE */

@media only screen and (max-width: 999px) and (min-width: 768px) {
    .he100 {
        height: 86px !important;
    }
}
.he100{height:70px;}
.nopdmr{margin: 5px 0px !important;padding: 0 !important;}
.redcoll{padding: 5px;background: #c61f26;color: #fff;text-align: center;margin-bottom:0px !important;}
.redcold{padding: 5px;background: #b12025;color: #fff;text-align: center;}

.orgcoll{padding: 5px;background: #f47822;color: #fff;text-align: center;margin-bottom:0px !important;}
.orgcold{padding: 5px;background: #f04d22;color: #fff;text-align: center;}

.yelcoll{padding: 5px;background: #ffc80b;color: #fff;text-align: center;margin-bottom:0px !important;}
.yelcold{padding: 5px;background: #fbb019;color: #fff;text-align: center;}

.grecoll{padding: 5px;background: #a6cf59;color: #fff;text-align: center;margin-bottom:0px !important;}
.grecold{padding: 5px;background: #73c04c;color: #fff;text-align: center;}

.dgrecoll{padding: 5px;background: #42b54d;color: #fff;text-align: center;margin-bottom:0px !important;}
.dgrecold{padding: 5px;background: #00ab4f;color: #fff;text-align: center;}

.userinfo {
    font-size: 18px;
    background: darkred;
    color: #FFF;
    border-radius: 10px;
    padding: 5px;
}

.nice-select span.current{font-size: 20px}
.nice-select .option {font-size: 10px}
.nice-select ul{height:200px;overflow-y:scroll !important}



/* Global Button Styles */ 
a.animated-button:link, a.animated-button:visited {
	position: relative;
	display: block;
	margin: 0px auto 0;
	padding: 11px 8px;
	color: #000;
	font-size:18px;
	font-weight: bold;
	text-align: center;
	text-decoration: none;
	text-transform: uppercase;
	overflow: hidden;
	letter-spacing: .09em;
	border-radius: 0;
	text-shadow: 0 0 1px rgba(0, 0, 0, 0.2), 0 1px 0 rgba(0, 0, 0, 0.2);
	-webkit-transition: all 1s ease;
	-moz-transition: all 1s ease;
	-o-transition: all 1s ease;
	transition: all 1s ease;
}
a.animated-button:link:after, a.animated-button:visited:after {
	content: "";
	position: absolute;
	height: 0%;
	left: 50%;
	top: 50%;
	width: 150%;
	z-index: -1;
	-webkit-transition: all 0.75s ease 0s;
	-moz-transition: all 0.75s ease 0s;
	-o-transition: all 0.75s ease 0s;
	transition: all 0.75s ease 0s;
}
a.animated-button:link:hover, a.animated-button:visited:hover {
	color: #FFF;
	text-shadow: none;
}
a.animated-button:link:hover:after, a.animated-button:visited:hover:after {
	height: 450%;
}
a.animated-button:link, a.animated-button:visited {
	position: relative;
	display: block;
	margin: 0px auto 0;
	padding: 11px 8px;
	color: #000;
	font-size:18px;
	border-radius: 0;
	font-weight: bold;
	text-align: center;
	text-decoration: none;
	text-transform: uppercase;
	overflow: hidden;
	letter-spacing: .09em;
	text-shadow: 0 0 1px rgba(0, 0, 0, 0.2), 0 1px 0 rgba(0, 0, 0, 0.2);
	-webkit-transition: all 1s ease;
	-moz-transition: all 1s ease;
	-o-transition: all 1s ease;
	transition: all 1s ease;
}

/* Victoria Buttons */

a.animated-button.victoria-one {
	border: 2px solid #D24D57;
}
a.animated-button.victoria-one:after {
	background: #D24D57;
	-moz-transform: translateX(-50%) translateY(-50%) rotate(-25deg);
	-ms-transform: translateX(-50%) translateY(-50%) rotate(-25deg);
	-webkit-transform: translateX(-50%) translateY(-50%) rotate(-25deg);
	transform: translateX(-50%) translateY(-50%) rotate(-25deg);
}
a.animated-button.victoria-two {
	border: 2px solid #D24D57;
}
a.animated-button.victoria-two:after {
	background: #D24D57;
	-moz-transform: translateX(-50%) translateY(-50%) rotate(25deg);
	-ms-transform: translateX(-50%) translateY(-50%) rotate(25deg);
	-webkit-transform: translateX(-50%) translateY(-50%) rotate(25deg);
	transform: translateX(-50%) translateY(-50%) rotate(25deg);
}
a.animated-button.victoria-three {
	border: 2px solid #D24D57;
}
a.animated-button.victoria-three:after {
	background: #D24D57;
	opacity: .5;
	-moz-transform: translateX(-50%) translateY(-50%);
	-ms-transform: translateX(-50%) translateY(-50%);
	-webkit-transform: translateX(-50%) translateY(-50%);
	transform: translateX(-50%) translateY(-50%);
}
a.animated-button.victoria-three:hover:after {
	height: 140%;
	opacity: 1;
}
a.animated-button.victoria-four {
	border: 2px solid #D24D57;
}
a.animated-button.victoria-four:after {
	background: #D24D57;
	opacity: .5;
	-moz-transform: translateY(-50%) translateX(-50%) rotate(90deg);
	-ms-transform: translateY(-50%) translateX(-50%) rotate(90deg);
	-webkit-transform: translateY(-50%) translateX(-50%) rotate(90deg);
	transform: translateY(-50%) translateX(-50%) rotate(90deg);
}
a.animated-button.victoria-four:hover:after {
	opacity: 1;
	height: 600% !important;
}  
.minhe1{min-height:467px;}
.minhe2{min-height:510px;}

</style>
<!--<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.nice-select.js"></script>
<link href="<?php echo base_url();?>assets/css/nice-select.css" rel="stylesheet">-->
<div class="right_col" role="main">
          <div class="">
           
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>User Report</h2>
                  <a href="<?php echo  base_url(); ?>index.php/home/userslist" class="btn btn-success" id="downloadcsv" style="float: right;margin-bottom: 10px;" ><i class="fa fa-chevron-left"></i> Back</a>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content userinfo">
				  <div class="col-md-4 col-sm-4 col-xs-4"><i class="fa fa-user"></i> <?php echo $getasapinfo[0]['fname']; ?></div>
				  
				<!--  <div class="col-md-3 col-sm-3 col-xs-3"><i class="fa fa-university"></i> <?php echo $getasapinfo[0]['centername']; ?></div>-->
				  
				  <div class="col-md-4 col-sm-4 col-xs-4"><i class="fa fa-graduation-cap"></i> Grade <?php echo str_replace("Grade","", $getasapinfo[0]['grade']); ?></div>
				  
				  <div class="col-md-4 col-sm-4 col-xs-4"><i class="fa fa-calendar-o"></i> Registered Date : <?php echo date('d-m-Y', strtotime($getasapinfo[0]['creation_date'])); ?></div>
				  </div></div>
				  
<div class="row"> 

<?php if($gettotalscore[0]['gamescore']==0 && $gettotalcrownies[0]['crownies']==0 && $gettotalscore[0]['stars']==0)
 {?>
	<center><h3>User not yet played</h3></center>
	 
 <?php } else{ ?> 
<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 padtop">
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
	<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist" style="margin:0">
		<li role="presentation" class="col-md-4 col-sm-4 col-xs-12"><h3><center>Total Score - <?php echo $gettotalscore[0]['gamescore']; ?></center></h3>
		</li>
		<li role="presentation" class="col-md-4 col-sm-4 col-xs-12"><h3><center>Crownies - <?php echo $gettotalcrownies[0]['crownies']; ?></center> </h3>
		</li>

		<li role="presentation" class="col-md-4 col-sm-4 col-xs-12"><h3><center>Total Stars - <?php echo $gettotalscore[0]['stars']; ?></center></h3>
		</li>

	<!--	<li role="presentation" class="col-md-4 col-sm-4 col-xs-12"><a href="#tab_content3" role="tab" id="clp_asap_tab" data-toggle="tab" aria-expanded="false">Initial vs Post Assessment</a>
		</li>-->
	</ul>
<div id="myTabContent" class="tab-content">
<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
 


<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="chartbd">
			<div class="panel panel-default" style="background: #fff;">
				<div class="panel-body minhe1">				
					<h3 class="Mh2">Monthwise Chart</h3>
					<div id="container3" style="background-color: #fff;"></div>
				<!--	<h3><//?php echo $getchartdetails[0]['gamescore']; ?></h3>
				 	<h3><//?php echo $getchartdetails[0]['month_no']; ?></h3>  -->					
				</div>
			</div>
		</div>
	</div> 
</div> 


</div>   
		</div>
	</div>
	
</div>
<?php } ?>
</div>
           </div>
        </div>
    </div>
 </div>
               
		<?php 
		
/* $categories=''; 
foreach($academicmonths as $months){ 
	   $categories.="'".$months['monthName']."-".$months['yearNumber']."',";
 } */
 
 $memory = round($set1avg_M, 2);
$visual = round($set1avg_V, 2);
$focus = round($set1avg_F, 2);
$problem = round($set1avg_P, 2);
$linguistics = round($set1avg_L, 2);

$memory_clp = round($CLP_M, 2);
$visual_clp = round($CLP_V, 2);
$focus_clp = round($CLP_F, 2);
$problem_clp = round($CLP_P, 2);
$linguistics_clp = round($CLP_L, 2); 


$test = array("Memory"=>$memory, "Visual Processing"=>$visual, "Focus and Attention"=>$focus, "Problem Solving"=>$problem, "Linguistics"=>$linguistics);
$IntialASAP = array("Memory"=>$memory, "Visual Processing"=>$visual, "Focus and Attention"=>$focus, "Problem Solving"=>$problem, "Linguistics"=>$linguistics);
//arsort($test);

$clp_skills = array("Memory"=>$memory_clp, "Visual Processing"=>$visual_clp, "Focus and Attention"=>$focus_clp, "Problem Solving"=>$problem_clp, "Linguistics"=>$linguistics_clp);
$clp_skills1 = array("Memory"=>$memory_clp, "Visual Processing"=>$visual_clp, "Focus and Attention"=>$focus_clp, "Problem Solving"=>$problem_clp, "Linguistics"=>$linguistics_clp);
arsort($clp_skills); 
		?>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js" type="text/javascript"></script>
<!--<script src="<?php echo base_url(); ?>assets/js/highchartsnew.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/drilldown.js"></script>-->

		
<script>

<?php 
if($clpbspi[0]['playcount']>8)
{?> 
cyclychange();
<?php
}
?>
 

	$("#tsi").click(function(){
		//alert('hai');
		//$("#advancetab").click();
	});
  
		
	$(document).ready(function(){ 
		skillwisechart(); 
	});
		
		
	 $('#patienttype').change(function(){
			var typeid = $(this).val();
			var userid = '<?php echo $this->uri->segment(3); ?>';
		$.ajax({
			type:"POST",
			url:"<?php echo base_url('index.php/ka_reports/update_patienttype') ?>",
			data:{typeid:typeid,userid:userid},
			success:function(result)
			{
			//alert(result);
			if(result==1)
				{
					$("#successmsg").html("Updated Successfully");
				}
			}
		});
	}); 
		
		
	bspimeter($("#frmbspi")); 

	$('#bspireport').change(function(){
		var form=$("#frmbspi");	
		bspimeter(form);
	});
  
	function skillwisechart()
	{

		var chart3 = Highcharts.chart('container3', {

		chart: {
			type: 'column'	 
		},

		title: {
			text: ''
		},

		subtitle: {
			text: ''
		},
		tooltip: {enabled: false},exporting:false,credits: {
			enabled: false
		},

		xAxis: {
			categories: [<?php foreach($getmonthlyscore as $monname){ 
				echo "'".$monname['monthname']."',";
			}?> ]
		 
 /* labels: {
            style: {
                fontSize: '25px',
				color: '#FF6600',
				fontFamily: 'Phenomena-Regular'
            }
        } */
       
    },
  
    yAxis: {
        allowDecimals: false,
        title: {
            text: 'Score'
			/* style: {fontSize: '25px',color: '#000',fontFamily: 'Phenomena-Regular'} */
        },
		  
		gridLineWidth: 1,
		minorGridLineWidth: 1,
 /* labels: {
            style: {
                fontSize: '20px',
				color: '#000',
				fontFamily: 'Phenomena-Regular'
            }
        } */		
    },
	
	
	plotOptions: {
	  
		column: {
                depth: 50,
		dataLabels:
					{
					enabled: true
					}
				}
			},	

   
    series: [{
		//showInLegend: false,
        name:"Score",
		color:'#0b62bd', 
        data: [<?php $i=0;foreach($getmonthlyscore as $monname)
			{ 
		
			if($i!=0){echo ",";}
				echo $monname['gamescore'];
				$i++;
			}
	?>]},
		{
			name: 'Stars',
			color:'#00bcd4',
			data: [<?php $i=0;foreach($getmonthlyscore as $monname)
					{ 		
						if($i!=0){echo ",";}
						echo $monname['star'];
						$i++;
					}
		?>]}
		] 
	});
	$('#loadingimage1').css("display", "none");
}
  
</script>
	
 
<style>
.Mh2{text-align:center;}

.tab-content > .tab-pane,
.pill-content > .pill-pane {
    display: block;     
    height: 0;          
    overflow-y: hidden; 
}

.tab-content > .active,
.pill-content > .active {
    height: auto;       
} 
.padtop {padding-top:10px;}
#loadingimage
{
	position: fixed;
    left: 0px;
    top: 0px;
    bottom: 0;
    right: 0;
    width: 100%;
    height: 100%;
    z-index: 99999;
    background:#151928 url(<?php echo base_url(); ?>assets/images/ajax-page-loader.gif) 50% 70% no-repeat;
    opacity: 0.8;
	background-size: 60px;
}
.pd10{padding:10px 0;}
</style>
<script src="<?php echo base_url(); ?>assets/js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/js/highcharts-3d.js"></script>
<script src="<?php echo base_url(); ?>assets/js/cylinder.js"></script> 
<script src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.js"></script>
<script src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.theme.fint.js"></script>
<script src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.widgets.js"></script>
<link href="<?php echo base_url();?>assets/css/bspiCalendar.css" rel="stylesheet">	