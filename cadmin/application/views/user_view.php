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
</style>
<!--<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.nice-select.js"></script>-->
<link href="<?php echo base_url();?>assets/css/nice-select.css" rel="stylesheet">
<div class="right_col" role="main">
          <div class="">
           
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>User Report</h2>
                  <a href="<?php echo  base_url(); ?>index.php/home/userperformance" class="btn btn-success" id="downloadcsv" style="float: right;margin-bottom: 10px;" ><i class="fa fa-chevron-left"></i> Back</a>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content userinfo">
				  <div class="col-md-10 col-sm-10 col-xs-10"><i class="fa fa-user"></i> <?php echo $getasapinfo[0]['fname']; ?></div>
				  
				  
				  <div class="col-md-2 col-sm-2 col-xs-2"><i class="fa fa-graduation-cap"></i> Grade <?php echo str_replace("Grade","", $getasapinfo[0]['grade']); ?></div>
				  
				  
				  </div></div>
				  
				  <div class="row">
                    <!--<div class="col-md-12 col-sm-12 col-xs-12 col-lg-3  profile_left">
                     <div class="row profile_content" style="">
                      <h3><?php echo $getasapinfo[0]['fname']; ?></h3>

                      <ul class="list-unstyled user_data">
					  <li><i class="fa fa-university"></i> <?php echo $getasapinfo[0]['centername']; ?></li>
					  <li>
					  <?php if($getasapinfo[0]['gender']=='M') {  ?>
					  <i class="fa fa-male"></i> Male
					<?php   } ?>
					<?php if($getasapinfo[0]['gender']=='F') {  ?>
					  <i class="fa fa-female"></i> Female
					<?php   } ?>
					  </li>
					  <?php 
					  $dateOfBirth = $getasapinfo[0]['dob'];
					  $today = date("Y-m-d");
					  $diff = date_diff(date_create($dateOfBirth), date_create($today));
					  ?>
							  
						  <?php if($getasapinfo[0]['father']!='') { ?>
						 <li class="m-top-xs">
                          <i class="fa fa-user"></i>
                          <?php echo $getasapinfo[0]['father']; ?>
						  </li><?php } ?>
						 <?php if($getasapinfo[0]['dob']!='') { ?>
							  <li><i class="fa fa-birthday-cake"></i> <?php echo date('d-m-Y',strtotime($getasapinfo[0]['dob'])); ?></li><?php } ?>
						 <li><i class="fa fa-graduation-cap"></i> Grade <?php echo str_replace("Grade","", $getasapinfo[0]['grade']); ?></li>
						 <li class="m-top-xs">
                          <i class="fa fa-calendar-o"></i> Registered Date : <?php echo date('d-m-Y', strtotime($getasapinfo[0]['creation_date'])); ?>
                        </li>
						
						
						<li id="successmsg" style="color: green; font-weight: 700;"></li>
						
                      </ul>

                      <br />

					</div>
                    </div>-->
					<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 padtop">
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist" style="margin:0">
                          <li role="presentation" class="active col-md-3 col-sm-3 col-xs-12"><a href="#tab_content1" id="asap-tab" role="tab" data-toggle="tab" aria-expanded="true">Initial Assessment</a>
                          </li>
                          <li role="presentation" class="col-md-2 col-sm-2 col-xs-12"><a href="#tab_content2" role="tab" id="training-tab" data-toggle="tab" aria-expanded="false">Detailed Assessment</a>
                          </li>
						  
						<li role="presentation" class="col-md-3 col-sm-3 col-xs-12"><a href="#tab_content4" role="tab" id="tsi" data-toggle="tab" aria-expanded="false">Personalized Training</a>
                          </li>
						  
                          <li role="presentation" class="col-md-4 col-sm-4 col-xs-12"><a href="#tab_content3" role="tab" id="clp_asap_tab" data-toggle="tab" aria-expanded="false">Initial vs Intermediate vs Post Assessment</a>
                          </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                          <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
						  <?php if($IsAsapEnable[0]['playedstatus']>0) { ?> 
                            <div class="">
								<div class="col-md-2">
								<!--<h2 style="font-weight:700 !important; color:#4765ff;">BSPI : <?php echo round($asapbspi[0]['avgbspiset1'], 2); ?> </h2>-->
								</div>
								<div class="col-md-10">
								  
								</div>
							  </div><br/>
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="col-md-6 col-sm-6 col-xs-6">
		<div class="chartbd">
			<div class="panel panel-default" style="background: #fff;">
				<div class="panel-body minhe1">
					<h3 class="Mh2">Skill Score</h3>
					<div id="container3" style="background-color: #fff;"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6 col-sm-6 col-xs-6">
	<div class="chartbd">
			<div class="panel panel-default" style="background: #fff;">
				<div class="panel-body minhe1">
					<h3 class="Mh2">Brain Skill Power Index</h3>
					<div class="block"  style="text-align:center; font-size: 25px;font-weight: bold;"><?php echo round($asapbspi[0]['avgbspiset1'], 2); ?></div>
					<div id="chart-container"  style="background:#fff;padding-top:20px; text-align:center;min-height: 356px;"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="col-3 col-md-3 col-sm-3 col-xs-12 nopdmr">
		<span class="col-12 col-md-12 col-sm-12 col-xs-12 redcoll"><=20</span>
		<span class="col-12 col-md-12 col-sm-12 col-xs-12 redcold he100">Rigorous & Immediate Intervention Needed</span>
		</div>
		<div class="col-2 col-md-2 col-sm-2 col-xs-12 nopdmr">
		<span class="col-12 col-md-12 col-sm-12 col-xs-12 orgcoll">21-40</span>
		<span class="col-12 col-md-12 col-sm-12 col-xs-12 orgcold he100">Need Immediate Intervention</span>
		</div>
		<div class="col-3 col-md-3 col-sm-3 col-xs-12 nopdmr">
		<span class="col-12 col-md-12 col-sm-12 col-xs-12 yelcoll">41-60</span>
		<span class="col-12 col-md-12 col-sm-12 col-xs-12 yelcold he100">Intervention Will Enhance Curriculum Performance</span>
		</div>
		<div class="col-2 col-md-2 col-sm-2 col-xs-12 nopdmr">
		<span class="col-12 col-md-12 col-sm-12 col-xs-12 grecoll">61-80</span>
		<span class="col-12 col-md-12 col-sm-12 col-xs-12 grecold he100">Can Be Groomed To Be Highly Successful</span>
		</div>
		<div class="col-2 col-md-2 col-sm-2 col-xs-12 nopdmr">
		<span class="col-12 col-md-12 col-sm-12 col-xs-12 dgrecoll">>80</span>
		<span class="col-12 col-md-12 col-sm-12 col-xs-12 dgrecold he100">Prodigy</span>
		</div>
	</div>
</div>
							
							  <!-- end of user-activity-graph -->
						  <?php } else { ?>
						  <h2 style="text-align:center;"> Initial Assessment not yet started </h2>
						  <?php } ?>
                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
						  
						  <?php if($clpbspi[0]['playcount']<=0) { ?> 
						  <h2 style="text-align:center;"> Detailed Assessment not yet started </h2>
						  <?php }  else { ?>
 						
							  <!-- start of user-activity-graph -->
							<div class="">
								<div class="col-md-2">
								<!--<h2 style="font-weight:700 !important; color:#4765ff; margin-left: 13px;">DASI : <?php echo round($clpbspi[0]['avgbspiset1'], 2); ?> </h2>-->
								</div>
								<div class="col-md-10">
								</div>
							  </div><br/>
							  <!---inner-->
							
							   
						
<div id="myTabContent1" class="tab-content">
	

	<div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="home-tab">
	
	<div class="col-md-6 col-sm-6 col-xs-6">
		<div class="chartbd">
			<div class="panel panel-default" style="background: #fff;">
				<div class="panel-body minhe2">
					<h3 class="Mh2">Skill Score</h3>
					<div id="clpchart" style="background:#fff;padding-top:10px;"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-6 col-sm-6 col-xs-6">
		<div class="chartbd">
			<div class="panel panel-default" style="background: #fff;">
				<div class="panel-body minhe2">
					<h3 class="Mh2">Detailed Assessment Skill Index</h3>
					<div class="block"  style="background:#fff;padding-top:20px; text-align:center; font-size: 16px;font-weight: bold;"><?php echo round($clpbspi[0]['avgbspiset1'], 2); ?></div> 
					<div id="chart-container1"  style="background:#fff;padding-top:20px; text-align:center;"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="col-3 col-md-3 col-sm-3 col-xs-12 nopdmr">
				<span class="col-12 col-md-12 col-sm-12 col-xs-12 redcoll"><=20</span>
				<span class="col-12 col-md-12 col-sm-12 col-xs-12 redcold he100">Rigorous & Immediate Intervention Needed</span>
		</div>
		<div class="col-2 col-md-2 col-sm-2 col-xs-12 nopdmr">
				<span class="col-12 col-md-12 col-sm-12 col-xs-12 orgcoll">21-40</span>
				<span class="col-12 col-md-12 col-sm-12 col-xs-12 orgcold he100">Need Immediate Intervention</span>
		</div>
		<div class="col-3 col-md-3 col-sm-3 col-xs-12 nopdmr">
				<span class="col-12 col-md-12 col-sm-12 col-xs-12 yelcoll">41-60</span>
				<span class="col-12 col-md-12 col-sm-12 col-xs-12 yelcold he100">Intervention Will Enhance Curriculum Performance</span>
		</div>
		<div class="col-2 col-md-2 col-sm-2 col-xs-12 nopdmr">
				<span class="col-12 col-md-12 col-sm-12 col-xs-12 grecoll">61-80</span>
				<span class="col-12 col-md-12 col-sm-12 col-xs-12 grecold he100">Can Be Groomed To Be Highly Successful</span>
		</div>
		<div class="col-2 col-md-2 col-sm-2 col-xs-12 nopdmr">
				<span class="col-12 col-md-12 col-sm-12 col-xs-12 dgrecoll">>80</span>
				<span class="col-12 col-md-12 col-sm-12 col-xs-12 dgrecold he100">Prodigy</span>
		</div>
	</div>
	
	
	</div>
	
	
	
	
	
	
	
	
	
	
</div>
							  <!--inner-->
                            <!-- end user projects -->
						 
						  
						  <?php } ?>
                          </div> 
						  <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
						<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
	
	<div id="myTabContent1" class="tab-content"> 
		<div role="tabpanel" class="tab-pane fade active in" id="tab_content31" aria-labelledby="home-tab">
			<?php 
			if($IsAsapEnable[0]['playedstatus']>0)
			{
			?>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="chartbd">
					<div class="panel panel-default" style="background: #fff;">
						<div class="panel-body minhe2">
							<h3 class="Mh2">Skill Score Comparison</h3>
							<div id="ComparsionChart" style="background:#fff;padding-top:10px;"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="chartbd">
					<div class="panel panel-default" style="background: #fff;">
						<div class="panel-body minhe2">
							<h3 class="Mh2">BSPI Comparison</h3>
							<div class="block"  style="background:#fff;padding-top:20px; text-align:center; font-size: 16px;font-weight: bold;"></div> 
							<div id="chart-ComparsionChart"  style="background:#fff;padding-top:20px; text-align:center;"></div>
						</div>
					</div>
				</div>
			</div>
			<?php 
			}
			else
			{
			?>
				<h2 style="text-align:center;"> Initial Assessment not yet started </h2>
			<?php
			}
			?>
		</div>
	</div>
</div>
                          </div>
						  
						  <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
						  <?php 
						  if($clpbspi[0]['playcount']<=8)
						  {?> 
							<h2 style="text-align:center;"> Personalized Training not yet started </h2>
						  <?php 
						  }  
						  else
						  { 
							?>
						  <div class="" role="tabpanel" data-example-id="togglable-tabs">
						  <div class="col-sm-4 col-md-4 col-lg-4"></div>
						  <div class="col-sm-4 col-md-4 col-lg-4">
								<div class="text-center">
									<select name="ddlcycle" class="form-control" id="ddlcycle">
										<option value="">Please select phase level</option>	
										<?php 
										foreach($default_cycle as $cycle)
										{
											if($cycle['range_start']<=$Session_Start_Range && $cycle['range_end']>=$Session_End_Range)
											{
												$selection="selected='selected'";
											}
										?>
												<option <?php echo $selection; ?> value="<?php echo $cycle['value']; ?>" data-cycle="<?php echo $cycle['id']; ?>"><?php echo $cycle['name']; ?></option>
										<?php
										}
										?>
										</select>
								</div>
							</div>
			<div class="col-sm-4 col-md-4 col-lg-4"></div><br/>
			<div class=" tabnation" style="display:none;">
				<div class="col-md-12 col-sm-12 col-xs-12 text-center">
					<div class="col-md-12 col-sm-12 col-xs-12 text-center" style="margin-bottom:15px;">
						<div class="col-sm-3 col-md-3 col-lg-3"></div>
						<div class="col-sm-6 col-md-6 col-lg-6">
							<div class="col-sm-6 col-md-6 col-lg-6 tab tab1 ">
								<div class="">
									<a  href="javascript:;" class="btn btn-sm animated-button victoria-one" id="basictab">Skillkit Report</a>
								</div>
							</div>
							<div class="col-sm-6 col-md-6 col-lg-6 tab tab2">
								<div class="">
									<a href="javascript:;" class="btn btn-sm animated-button victoria-two" id="advancetab">Regular Report</a>
								</div>
							</div>
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3"></div>
					</div>
				</div>
			</div>
		
		
		<div class=" chartview1" style="display:none;">
			<div class="col-md-12 col-sm-12 col-xs-12 text-center">
				<div class="col-md-12 col-sm-12 col-xs-12 text-center"> 
						<div class="panel panel-default" style="background: #fff;">
							<div class="panel-body">
									<div class="reportChartContainer1">
											<div id="BasicChart"></div>
									 </div>
								</div>
						</div>
				</div>
			</div>
		</div>
		<div class=" chartview2" style="display:none;">
			<div class="col-md-12 col-sm-12 col-xs-12 text-center">
				<div class="col-md-12 col-sm-12 col-xs-12 text-center"> 
						<div class="panel panel-default" style="background: #fff;">
							<div class="panel-body">
									<div class="reportChartContainer1">
											<div id="AdvancedChart"></div>
									 </div>
								</div>
						</div>
				</div>
			</div>
		</div>
		<div id="emptycycle"></div>
		
						
						</div><?php } ?> 
						
						</div> 
	<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
	
	<div id="myTabContent1" class="tab-content"> 
		<div role="tabpanel" class="tab-pane fade active in" id="tab_content31" aria-labelledby="home-tab">
			<?php 
			if($IsAsapEnable[0]['playedstatus']>0)
			{
			?>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="chartbd">
					<div class="panel panel-default" style="background: #fff;">
						<div class="panel-body minhe2">
							<h3 class="Mh2">Skill Score Comparison</h3>
							<div id="ComparsionChart" style="background:#fff;padding-top:10px;"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="chartbd">
					<div class="panel panel-default" style="background: #fff;">
						<div class="panel-body minhe2">
							<h3 class="Mh2">BSPI Comparison</h3>
							<div class="block"  style="background:#fff;padding-top:20px; text-align:center; font-size: 16px;font-weight: bold;"></div> 
							<div id="chart-ComparsionChart"  style="background:#fff;padding-top:20px; text-align:center;"></div>
						</div>
					</div>
				</div>
			</div>
			<?php 
			}
			else
			{
			?>
				<h2 style="text-align:center;"> Initial Assessment not yet started </h2>
			<?php
			}
			?>
		</div>
	</div>
</div>					
						
						
						
						
						
						
						
						
						
						
						
</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
		<?php 
		
$categories=''; 
foreach($academicmonths as $months){ 
	   $categories.="'".$months['monthName']."-".$months['yearNumber']."',";
 }
 
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
arsort($test);

$clp_skills = array("Memory"=>$memory_clp, "Visual Processing"=>$visual_clp, "Focus and Attention"=>$focus_clp, "Problem Solving"=>$problem_clp, "Linguistics"=>$linguistics_clp);
$clp_skills1 = array("Memory"=>$memory_clp, "Visual Processing"=>$visual_clp, "Focus and Attention"=>$focus_clp, "Problem Solving"=>$problem_clp, "Linguistics"=>$linguistics_clp);
arsort($clp_skills);
		?>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/js/highcharts-3d.js"></script>
<script src="<?php echo base_url(); ?>assets/js/cylinder.js"></script> 
<script src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.js"></script>
<script src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.theme.fint.js"></script>
<script src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.widgets.js"></script>
<link href="<?php echo base_url();?>assets/css/bspiCalendar.css" rel="stylesheet">	
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
//$("#advancetab").click();

$("#tsi").click(function(){
	//alert('hai');
	//$("#advancetab").click();
});
$("#ddlcycle").change(function(){
	cyclychange();
	
	
	if($("#ddlcycle").val() === "")
	{
		$(".tabnation").hide();
	}
	else 
	{
		$(".tabnation").show();
	}
	
});
function cyclychange()
{
	var cycle=$("#ddlcycle option:selected").attr('data-cycle');
	var range=$("#ddlcycle option:selected").val();
	if(range!='')
	{
		if(cycle==1)
		{
			$(".tabnation").hide();
			$(".chartview2").show();
			$(".chartview1").hide();		
			AdvancedChart(cycle,range);
			$("#emptycycle").hide();
		}
		else
		{
			$(".tabnation").show();
			$(".chartview1").hide();
			$(".chartview2").hide();
			AdvancedChart(cycle,range);
			$("#emptycycle").hide();
		}
	}
	else
	{
		$("#emptycycle").html("Play more puzzles to get your report");
	}
}
$("#basictab").click(function(){
	var cycle=$("#ddlcycle option:selected").attr('data-cycle');
	var range=$("#ddlcycle option:selected").val(); 
	if(cycle>1)
	{
		$(".chartview1").show();
		$(".chartview2").hide();
		//BasicChart();
		BasicChart(cycle,range);
		$(".tab").removeClass('tabactive');
		$(".tab1").addClass('tabactive');
	}		
});
$("#advancetab").click(function(){
	var cycle=$("#ddlcycle option:selected").attr('data-cycle');
	var range=$("#ddlcycle option:selected").val(); 
	if(cycle>1)
	{
		$(".chartview2").show();
		$(".chartview1").hide();
		AdvancedChart(cycle,range);
		$(".tab").removeClass('tabactive');
		$(".tab2").addClass('tabactive');
	}		
});
function BasicChart(cycle,range,type)
{
	var userid = '<?php echo $this->uri->segment(3); ?>';
	$("#loadingimage").show();
	$.ajax({
		url: "<?php echo base_url(); ?>index.php/home/getSkillChart",
		type:"POST",
		data:{cycle:cycle,range:range,type:'BASIC',userid:userid},
		success: function(result)
		{
			$("#loadingimage").hide();
			$("#BasicChart").html(result);
		}
	});
}
function AdvancedChart(cycle,range)
{
	var userid = '<?php echo $this->uri->segment(3); ?>';
	$("#loadingimage").show();
	//alert(range);
	 $.ajax({
	  url: "<?php echo base_url(); ?>index.php/home/getSkillChart",
	 type:"POST",
	  data:{cycle:cycle,range:range,type:'ADVANCE',userid:userid},
	  success: function(result){ 
			$(".chartview2").show();
			$(".chartview1").hide();
			$(".tab").removeClass('tabactive');
			$(".tab2").addClass('tabactive');
			$("#AdvancedChart").html(result);
			$("#loadingimage").hide();
		}
	});
	
}
		
		
		
		$(document).ready(function(){
			
			<?php if($IsAsapEnable[0]['playedstatus']>0) { ?>
			skillwisechart();
			bspimeter();
			<?php } ?>
		});
		
		
		$('#patienttype').change(function(){
			var typeid = $(this).val();
			var userid = '<?php echo $this->uri->segment(3); ?>';
		$.ajax({
type:"POST",
url:"<?php echo base_url('index.php/home/update_patienttype') ?>",
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
function bspimeter(form)
		{

var form=$("#frmbspi");
$.ajax({
type:"POST",
url:"<?php echo base_url('index.php/home/mybspi_report_ajax') ?>",
data:form.serialize(),
//dataType: 'json',
success:function(result)
{
 
//if(result!=0)
{
	//alert('heello');
	guagechart(result);
	var sco =parseFloat(result).toFixed(2); 
	$('#score').html(sco);
}

}
});

		}
		
		$('#asap-tab').click(function(){
			<?php if($IsAsapEnable[0]['playedstatus']>0) { ?>
				skillwisechart();
			<?php } ?>
		});
		
		$('#training-tab').click(function(){
			<?php if($IsCLPEnable[0]['playedstatus']>0) { ?>
					skillwisechart_clp();
					guagechart_dasi();
					EfficiencyGraphChart();
					//bspimeter();
			<?php } ?>
		});
		
		$('#clp_asap_tab').click(function(){
			<?php if($IsCLPEnable[0]['playedstatus']>0) { ?>
				ComparsionChart();
				BspiComparsionChart();
			<?php } ?>
		});
		
	function ComparsionChart()
{
Highcharts.setOptions({ colors: ['#3B97B2', '#67BC42', '#FF56DE', '#E6D605', '#BC36FE'] });
	Highcharts.chart('ComparsionChart', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [
            'Memory',
            'Visual Processing',
            'Focus and Attention',
            'Problem Solving',
            'Linguistics'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Score'
        }
    },
	
		plotOptions: {
			series: {
				borderWidth: 0,
				dataLabels: {
					enabled: true,
					format: '{point.y:.2f}'
				}
			}
		},
		exporting:false,
		credits: {
		  enabled: false
		},
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
	{
        name: 'Initial Assessment',
        data: [
				<?php
				foreach($test as $key=>$value)
				{
					echo "".$value.",";
				}
				?>
			  ]

    }
	<?php 
	if(count($InterAsapData)>0)
	{
	?>
		,{
			name: 'Intermediate Assessment',
			data:[	
					<?php 
						foreach($InterAsapData as $row1)
						{
							 echo "".$row1['game_score'].",";
						}
					?>  
				 ]
		}
	<?php
	}
	?>
	<?php 
	if(count($PostAsapData)>0)
	{
	?>
		,{
			name: 'Post Assessment',
			data:[	
					<?php 
						foreach($PostAsapData as $row1)
						{
							 echo "".$row1['game_score'].",";
						}
					?>  
				 ]
		}
	<?php
	}
	?> 
	]
});
}	
		
function BspiComparsionChart()
{
	Highcharts.setOptions({ colors: ['#3B97B2', '#67BC42', '#FF56DE', '#E6D605', '#BC36FE'] });
	Highcharts.chart('chart-ComparsionChart', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [
            'BSPI' 
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Score'
        }
    },
	
		plotOptions: {
			series: {
				borderWidth: 0,
				dataLabels: {
					enabled: true,
					format: '{point.y:.2f}'
				}
			}
		},
		exporting:false,
		credits: {
		  enabled: false
		},
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
	{
        name: 'Initial Assessment',
        data: [<?php echo round($asapbspi[0]['avgbspiset1'], 2); ?>]
    }
	<?php 
	if(count($InterAsapData)>0)
	{
		$imbspi=0;
		foreach($InterAsapData as $row1)
		{
			$imbspi=$imbspi+$row1['game_score'];
		}		
	?>
		,{
        name: 'Intermediate Assessment',
        data: [<?php echo round($imbspi/5, 2); ?>]

		}
	<?php
	}
	?>
	<?php 
	if(count($PostAsapData)>0)
	{	
		$postasap=0;
		foreach($PostAsapData as $row1)
		{
			$postasap=$postasap+$row1['game_score'];
		}
	?>
		,{
			name: 'Post Assessment',
			data: [<?php echo round($postasap/5, 2); ?>]
		}
	<?php
	}
	?>
	]
});
$('#loadingimage1').css("display", "none");
}		
		
		
		
		
		
		
		
		
		
		
		
		function guagechart(score)
			{
			
	FusionCharts.ready(function () {
    var csatGauge = new FusionCharts({
        "type": "angulargauge",
        "renderAt": "chart-container","background":"transparent",
        "width": "400",
        "height": "250",
        "dataFormat": "json",
            "dataSource": {
    "chart": {
		
        "caption": "",
        "lowerlimit": "0",
        "upperlimit": "100",
	 "bgAlpha":'0',
            
            "gaugeFillRatio": "15",
            "theme": "fint",
			
        
    },
    "colorrange": {
        "color": [
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
                "value": <?php echo round($asapbspi[0]['avgbspiset1'], 2); ?>,
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
			}
			
			function guagechart_dasi(score)
			{
			
	FusionCharts.ready(function () {
    var csatGauge = new FusionCharts({
        "type": "angulargauge",
        "renderAt": "chart-container1","background":"transparent",
        "width": "400",
        "height": "250",
        "dataFormat": "json",
            "dataSource": {
    "chart": {
		
        "caption": "",
        "lowerlimit": "0",
        "upperlimit": "100",
	 "bgAlpha":'0',
            
            "gaugeFillRatio": "15",
            "theme": "fint",
			
        
    },
    "colorrange": {
        "color": [
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
                "value": <?php echo round($clpbspi[0]['avgbspiset1'], 2); ?>,
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
			}
			
		
		 function skillwisechart_asap_clp()
 {
		Highcharts.chart('graph_bar', {
    chart: {
        type: 'column',
		backgroundColor:'transparent'
    },
	
	 title: {
            text: 'Skills Score'
        },
    
    xAxis: {
        categories: [
            'Memory',
            'Visual Processing',
            'Focus and Attention',
            'Problem Solving',
            'Linguistics'
           
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Score'
        },
		max: 100 ,
  gridLineWidth: 0,
  minorGridLineWidth: 0
    },
    tooltip: {enabled: false},exporting:false,credits: {
      enabled: false
  },
    plotOptions: {
     
            column: {
                depth: 50,
    dataLabels: {
            enabled: true
        }
            }
        },
    series: [{
        name: 'Initial Assessment',
		color:'#0b62bd',
        data: [<?php echo $memory; ?>, <?php echo $visual; ?>, <?php echo $focus; ?>, <?php echo $problem; ?>, <?php echo $linguistics; ?>]

    }, {
        name: 'Post Assessment',
		color:'#00bcd4',
        data: [<?php echo $memory_clp; ?>, <?php echo $visual_clp; ?>, <?php echo $focus_clp; ?>, <?php echo $problem_clp; ?>, <?php echo $linguistics_clp; ?>]

    }]
});

 }
 
 		 function bspibarchart()
 {
		Highcharts.chart('bspibarchart', {
    chart: {
        type: 'column',
		backgroundColor:'transparent'
    },
	
	 title: {
            text: 'BSPI Score'
        },
    
    xAxis: {
        categories: [
            'BSPI'
           
           
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Score'
        },
		max: 100 ,
  gridLineWidth: 0,
  minorGridLineWidth: 0
    },
    tooltip: {enabled: false},exporting:false,credits: {
      enabled: false
  },
    plotOptions: {
     
            column: {
                depth: 50,
    dataLabels: {
            enabled: true
        }
            }
        },
    series: [{
        name: 'Initial Assessment',
		color:'#bf2025',
        data: [<?php echo round($asapbspi[0]['avgbspiset1'], 2); ?>]

    }, {
        name: 'Post Assessment',
		color:'#f36621',
        data: [<?php echo round($clpbspi[0]['avgbspiset1'], 2); ?>]

    }]
});

 }
 
 function EfficiencyGraphChart()
{
    var chart = new Highcharts.Chart({
        chart: {
            renderTo: 'EfficiencyGraphChart',
            type: 'column',
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [<?php echo rtrim($categories,',');?>],
        crosshair: true
    },
    yAxis: {
		gridLineWidth: 0,
		minorGridLineWidth: 0,
        min: 0,
        title: {
            text: ''
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            dataLabels: {
                enabled: true,
                crop: false,
                overflow: 'none'
            }
        }
    },exporting:false,
	credits: {
      enabled: false
  },
    series: [
		{ 	showInLegend: true,
			name: 'BSPI',
			color: '#ff6600',
            data: [<?php $ini=0; foreach($academicmonths as $months){
				$ini++;
				if($ini>1){echo ",";}
				if(isset($Uscore[$months['monthNumber'].$months['yearNumber'].'-S'])){
				echo "".$Uscore[$months['monthNumber'].$months['yearNumber'].'-S']."";
				}
				else{echo "0";}
			} ?>]
        },
		{	showInLegend: true, 
			name: 'Played Days',
			color: '#77bdff',
            data: [<?php $ini=0; foreach($academicmonths as $months){
				$ini++;
				if($ini>1){echo ",";}
				if(isset($Utime[$months['monthNumber'].$months['yearNumber'].'-T'])){
				echo "".round($Utime[$months['monthNumber'].$months['yearNumber'].'-T'])."";
				}
				else{echo "0";}
			} ?>]
        }]
});
}
		

		 function skillwisechart()
 {

	 var chart3 = Highcharts.chart('container3', {

    chart: {
        type: 'column',
		backgroundColor:'transparent'
	
	 
    },

    title: {
        text: ''
    },

    subtitle: {
        text: ''
    },
	tooltip: {enabled: true},exporting:false,credits: {
      enabled: false
  },

    xAxis: {
        categories: [<?php foreach($test as $key=>$value){ 
	 echo "'".$key."',";
		}
	?> ],
		gridLineWidth: 0,
  minorGridLineWidth: 0,
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
		 max: 100 ,
  gridLineWidth: 0,
  minorGridLineWidth: 0,
 /* labels: {
            style: {
                fontSize: '20px',
				color: '#000',
				fontFamily: 'Phenomena-Regular'
            }
        } */
		
    },
	
 plotOptions: {
	  
    series: {
        dataLabels: {
            enabled: true,
			/* formatter: function() {
 
    var Greeting0='RIGOROUS & IMMEDIATE INTERVENTION NEEDED';
    var Greeting1='NEEDS IMMEDIATE INTERVENTION';
    var Greeting2='INTERVENTION WILL ENHANCE CURRICULUM PERFORMANCE';
    var Greeting3='CAN BE GROOMED TO BE HIGHLY SUCCESSFUL';
    var Greeting4='PRODIGY';

    if(this.y<=20){ return this.y +' - '+ Greeting0;}
    else if(this.y>=21 && this.y<=40){ return this.y +' - '+ Greeting1;}
    else if(this.y>=41 && this.y<=60){ return this.y +' - '+ Greeting2;}
    else if(this.y>=61 && this.y<=80){ return this.y +' - '+ Greeting3;}
    else if(this.y>80){ return this.y +' - '+ Greeting4;}
   }, */
                        inside: true,
			style: {color: '#000', textShadow: false}
             
        }
    }
},	

   
    series: [
	
	{
		showInLegend: false,
        name:"Skill Wise Average",
        data: [<?php foreach($test as $key=>$value){  if($key=='Memory'){ if($value<=20) { $color='#bf2025'; } else if($value>=21 && $value<=40) { $color='#f36621'; } else if($value>=41 && $value<=60) { $color='#fdc010'; }   else if($value>=61 && $value<=80) { $color='#94c953'; }  else if($value>80) { $color='#00b04e'; }  }
		else if($key=='Visual Processing'){ if($value<=20) { $color='#bf2025'; } else if($value>=21 && $value<=40) { $color='#f36621'; } else if($value>=41 && $value<=60) { $color='#fdc010'; }   else if($value>=61 && $value<=80) { $color='#94c953'; }  else if($value>80) { $color='#00b04e'; } }
		else if($key=='Focus and Attention'){ if($value<=20) { $color='#bf2025'; } else if($value>=21 && $value<=40) { $color='#f36621'; } else if($value>=41 && $value<=60) { $color='#fdc010'; }   else if($value>=61 && $value<=80) { $color='#94c953'; }  else if($value>80) { $color='#00b04e'; } }
		else if($key=='Problem Solving'){ if($value<=20) { $color='#bf2025'; } else if($value>=21 && $value<=40) { $color='#f36621'; } else if($value>=41 && $value<=60) { $color='#fdc010'; }   else if($value>=61 && $value<=80) { $color='#94c953'; }  else if($value>80) { $color='#00b04e'; } }
		else if($key=='Linguistics'){ if($value<=20) { $color='#bf2025'; } else if($value>=21 && $value<=40) { $color='#f36621'; } else if($value>=41 && $value<=60) { $color='#fdc010'; }   else if($value>=61 && $value<=80) { $color='#94c953'; }  else if($value>80) { $color='#00b04e'; } }
		echo'{y:'.$value.',color:"'.$color.'"},'; }?>]
	}
	 ] 

});
$('#loadingimage1').css("display", "none");
 }
 
function skillwisechart_clp()
{

Highcharts.chart('clpchart', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Score'
        },
		 max: 100 ,
  gridLineWidth: 0,
  minorGridLineWidth: 0

    },
	
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:.2f}'
            }
        }
    },
	exporting:false,
	credits: {
      enabled: false
	},
    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f} </b><br/>'
    },

    series: [{
        name: 'Avg. Score',
        colorByPoint: true,
        data: [<?php foreach($clp_skills1 as $key=>$value){  
	if($key=='Memory'){$color='#da0404';$gsid=59;}
	else if($key=='Visual Processing'){$color='#ffc000';$gsid=60;}
	else if($key=='Focus and Attention'){$color='#92d050';$gsid=61;}
	else if($key=='Problem Solving'){$color='#ff6600';$gsid=62;}
	else if($key=='Linguistics'){$color='#00b0f0';$gsid=63;} echo'{name:"'.$key.'",y:'.$value.',color:"'.$color.'"},'; }?>]
    }],
    //drilldown: { }
});
$('#loadingimage1').css("display", "none");
 }
/* -------------- Puzzle Skill Chart -------------- */

</script>
<script>

	 
getMonthName = function (v) {
    var n = ["","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    return n[v]
}

</script>
<script>
getMonthName = function (v) {
var n = ["","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
return n[v]
}
<?php if($IsCLPEnable[0]['playedstatus']>0) { ?>
bspiCalendar("<?php echo date('Y-m');?>");
<?php } ?>
$("#ddlbrianmonth").change(function(){
   bspiCalendar($(this).val()); 
});
function bspiCalendar(yearMonthData)
{
	/* userid=$("#userid").val();
	startdate=$("#startdate").val();
	enddate=$("#enddate").val();

	$.ajax({
	  url: "<?php echo base_url(); ?>index.php/home/ajaxcalendar",
	  type:"POST",
	  data:{yearMonth:yearMonthData,userid:userid,startdate:startdate,enddate:enddate},
	  success: function(result){
		$("#myBspiCalendar").html(result);
		$('[data-toggle="tooltip"]').tooltip();
		}
	}); */
}
</script>
<style>
.minhe1{min-height:467px;}
.minhe2{min-height:477px;}
.Mh2 {
    text-align: center;
}
a {
    color: #fff;
}
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
		</style>
