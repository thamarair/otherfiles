

<!--to get the table data-------->


 <div class="container1">  
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;color:#FF5722;font-weight: bold;letter-spacing: 2px;border-bottom: 2px dotted #ccc;padding: 0 0 10px 0;">
				<h4 style="margin:0px;">Job Profile</h4> 
				<h2 style="margin:0px;font-weight: bold;"><?php echo $EbilityProfileData[0]['occupation']; ?></h2> 
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;font-weight: bold;letter-spacing: 2px;color: #009688;border-bottom: 2px dotted #ccc;padding: 10px 0;"> 
					<h4 style="margin:0px;">Sector</h4> 
				<h3 style="margin:0px;font-weight: bold;"><?php echo $EbilityProfileData[0]['subsector']; ?></h3>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:200px;">
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;color:#FF5722;font-weight: bold;letter-spacing: 2px;">
					<h2>Abilities</h2> 
				</div>
				<table id="AB" class="table table-striped table-bordered"	>
					<thead>
						<tr>
							<th>S.No.</th>
							<th>Name</th>
							<th>Percentage(%)</th>
							<th>Description</th>
						   
						</tr>
					</thead>
					<tbody>
						<?php $i=1;
						foreach($EbilityProfileData as $row)
						{
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $row['subability']; ?></td>
								<td><?php echo $row['abilityvalue']; ?></td>
								<td><?php echo $row['description']; ?></td>
								</td>	
							</tr>
						<?php
						$i++; }
						?>	 
					</tbody>
				</table>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;color:#FF5722;font-weight: bold;letter-spacing: 2px;">
					<h2>Skills</h2> 
				</div>
				<table id="SK" class="table table-striped table-bordered"	>
					<thead>
						<tr>
							<th>S.No.</th>
							<th>Name</th>
							<th>Percentage(%)</th>
							<th>Description</th>
						</tr>
					</thead>
					
					<tbody>
					<?php $j=1;
					foreach ($SkillProfileData as $row)
					{
						?>
						<tr>
							<td><?php echo $j; ?></td>
							<td><?php echo $row['subskill']; ?></td>
							<td><?php echo $row['skillvalue']; ?></td>
							<td><?php echo $row['description']; ?></td>
							</td>	
						</tr>
					<?php
					$j++; }
					?>	 
				<?php
					$row++;
				?>
					</tbody>
				</table>
			 </div>
		</div>
	</div>
</div>
 <script>
$(document).ready(function() {
    $('#AB').DataTable( {
  "pageLength": 5,searching: false, "bLengthChange" : false
} );
    $('#SK').DataTable( {
  "pageLength": 5,searching: false, "bLengthChange" : false
} );
});
</script>

<!----concat by seperating with comma ex:name(80),---------->
<?php 
	/* $ability = ""; 
	foreach($EbilityProfileData as $row)
	{ 
		$ability.=$row['subability']." (".$row['abilityvalue']."%), ";
		 
	}
	$skillocc = ""; 
	foreach($SkillProfileData as $row1)
	{ 
		$skillocc.=$row1['subskill']." (".$row1['skillvalue']."%), ";
		 
	} */			//	echo trim($ability); to remove last comma
?>	

<div class="container1">  
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;color:#FF5722;font-weight: bold;letter-spacing: 2px;border-bottom: 2px dotted #ccc;padding: 0 0 10px 0;">
				<h4 style="margin:0px;">Job Profile</h4> 
				<h2 style="margin:0px;font-weight: bold;"><?php echo $EbilityProfileData[0]['occupation']; ?></h2> 
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;font-weight: bold;letter-spacing: 2px;color: #009688;border-bottom: 2px dotted #ccc;padding: 10px 0;"> 
					<h4 style="margin:0px;">Sector</h4> 
				<h3 style="margin:0px;font-weight: bold;"><?php echo $EbilityProfileData[0]['subsector']; ?></h3>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:50px;">
			
				<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;color:#FF5722;font-weight: bold;letter-spacing: 2px;">
				<h2>	Abilities </h2>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:left;color:#000;letter-spacing: 2px;"> 
					<div class="abview">
						<?php 
						foreach($EbilityProfileData as $row)
						{ 
						?>
							<div class="col-md-2 col-sm-2 col-xs-2">
								<div class="abbox">
									<?php echo $row['subability']." (".$row['abilityvalue']."%)"; ?>
								</div>
							</div>
						<?php
						} 
						?>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:100px;border-bottom: 2px dotted #ccc;">
				<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;color:#FF5722;font-weight: bold;letter-spacing: 2px;">
					<h2>Skills</h2> 
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12" style="text-align: left;color:#000;letter-spacing: 2px;"> 
					<div class="skview">
						<?php 
						foreach($SkillProfileData as $row1)
						{ 
						?>
							<div class="col-md-2 col-sm-2 col-xs-2">
								<div class="skbox">
									<?php echo $row1['subskill']." (".$row1['skillvalue']."%)"; ?>
								</div>
							</div>
						<?php
						} 
						?>
					</div>
				</div>
			 </div>
		
	</div>
</div>
 <style>
 .abbox{border: 1px solid #ccc;
    min-height: 60px;
    margin: 5px 0;
    text-align: center;}
.skbox{border: 1px solid #ccc;
    min-height: 60px;
    margin: 5px 0;
    text-align: center;}
 </style>


<?php 
	/* $ability = ""; 
	foreach($EbilityProfileData as $row)
	{ 
		$ability.=$row['subability']." (".$row['abilityvalue']."%), ";
		 
	}
	$skillocc = ""; 
	foreach($SkillProfileData as $row1)
	{ 
		$skillocc.=$row1['subskill']." (".$row1['skillvalue']."%), ";
		 
	} */
?>	

<div class="container1">  
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;color:#FF5722;font-weight: bold;letter-spacing: 2px;border-bottom: 2px dotted #ccc;padding: 0 0 10px 0;">
				<h4 style="margin:0px;">Job Profile</h4> 
				<h2 style="margin:0px;font-weight: bold;"><?php echo $EbilityProfileData[0]['occupation']; ?></h2> 
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;font-weight: bold;letter-spacing: 2px;color: #009688;border-bottom: 2px dotted #ccc;padding: 10px 0;"> 
					<h4 style="margin:0px;">Sector</h4> 
				<h3 style="margin:0px;font-weight: bold;"><?php echo $EbilityProfileData[0]['subsector']; ?></h3>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:50px;border-bottom: 2px dotted #ccc;">
			
				<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;color:#FF5722;font-weight: bold;letter-spacing: 2px;">
				<h2>	Abilities </h2>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:left;color:#000;letter-spacing: 2px;"> 
					<div class="abview">
						<?php $i=1;
						foreach($EbilityProfileData as $row)
						{ 
						?>
							<div class="col-md-2 col-sm-2 col-xs-2">
								<div class="abbox">
									<?php echo $row['subability']." (".$row['abilityvalue']."%)"; ?>
								</div>
							</div>
						<?php
						$i++;
						} 
						?>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:100px;border-bottom: 2px dotted #ccc;">
				<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;color:#FF5722;font-weight: bold;letter-spacing: 2px;">
					<h2>Skills</h2> 
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12" style="text-align: left;color:#000;letter-spacing: 2px;"> 
					<div class="skview">
						<?php 
						foreach($SkillProfileData as $row1)
						{ 
						?>
							<div class="col-md-2 col-sm-2 col-xs-2">
								<div class="skbox">
									<?php echo $row1['subskill']." (".$row1['skillvalue']."%)"; ?>
								</div>
							</div>
						<?php
						} 
						?>
					</div>
				</div>
			 </div>
		
	</div>
</div>
 <style>
 .abbox{border: 1px solid #ccc;
    min-height: 60px;
    margin: 5px 0;
    text-align: center;}
.skbox{border: 1px solid #ccc;
    min-height: 60px;
    margin: 5px 0;
    text-align: center;}
 </style>


<!---------new current --------------->
<?php 
	/* $ability = ""; 
	foreach($EbilityProfileData as $row)
	{ 
		$ability.=$row['subability']." (".$row['abilityvalue']."%), ";
		 
	}
	$skillocc = ""; 
	foreach($SkillProfileData as $row1)
	{ 
		$skillocc.=$row1['subskill']." (".$row1['skillvalue']."%), ";
		 
	} */
$color=array("0"=>"#da0404","1"=>"#ffc000","2"=>"#00b0f0","3"=>"#da0404","4"=>"#ffc000","5"=>"#00b0f0");
$color1=array("0"=>"#ff6600","1"=>"#00b0f0","2"=>"#9c27b0","3"=>"#ff6600","4"=>"#00b0f0","5"=>"#9c27b0");
?>	

<div class="container1">  
	<div class="row"> 
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;color:#FF5722;font-weight: bold;letter-spacing: 2px;border-bottom: 2px dotted #ccc;padding: 0 0 10px 0;">
				<h4 style="margin:0px;">Job Profile</h4> 
				<h2 style="margin:0px;font-weight: bold;"><?php echo $EbilityProfileData[0]['occupation']; ?></h2> 
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;font-weight: bold;letter-spacing: 2px;color: #009688;border-bottom: 2px dotted #ccc;padding: 10px 0;"> 
					<h4 style="margin:0px;">Sector</h4> 
				<h3 style="margin:0px;font-weight: bold;"><?php echo $EbilityProfileData[0]['subsector']; ?></h3>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:200px;border-bottom: 2px dotted #ccc;">
			<div class="col-md-6 col-sm-6 col-xs-6" style="border-right: 2px dotted #ccc;">
				<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;color:#FF5722;font-weight: bold;letter-spacing: 2px;">
					<h2>Abilities </h2>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:left;color:#000;letter-spacing: 2px;"> 
					<div class="abview">
						<?php $i=1; $k=0;
						foreach($EbilityProfileData as $row)
						{ 
							if($i%3==1)
							{
								echo '<div class="row">';
							}
							if($row['abilityvalue']<=7){$abwidth='10';}else{$abwidth=$row['abilityvalue'];}
						?>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="abbox">
									<?php echo $row['subability']; ?>
									<div class="meter mt10">
										<span class="redColor" id="memscore" style="background-color:<?php echo $color[$k%6];?>;width:<?php echo $abwidth."%"; ?>"><?php echo $row['abilityvalue']; ?></span>
									</div>
								</div>
							</div>
						<?php
							if($i%3==0)
							{
								echo '</div>';
							}
						$i++;$k++;
						} 
						?>
					</div>
				</div>
			</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6" style="padding-bottom:50px;">
				<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;color:#FF5722;font-weight: bold;letter-spacing: 2px;">
					<h2>Skills</h2> 
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12" style="text-align: left;color:#000;letter-spacing: 2px;"> 
					<div class="skview">
						<?php 
						$j=1; $m=0;
						foreach($SkillProfileData as $row1)
						{ 
							if($j%3==1 || $j==1)
							{
								echo '<div class="row">';
							}
							if($row1['skillvalue']<=7){$skwidth='10';}else{$skwidth=$row1['skillvalue'];}
						?>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<div class="skbox">
									<?php echo $row1['subskill']; ?>
									<div class="meter mt10">
										<span class="redColor" id="memscore" style="background-color:<?php echo $color[$m%6];?>;width:<?php echo $skwidth."%"; ?>"><?php echo $row1['skillvalue']; ?></span>
									</div>
								</div>
							</div>
						<?php
							if($j%3==0)
							{
								echo '</div>';
							}
							$j++;$m++;
						} 
						?>
					</div>
				</div>
			 </div>
		</div>
	</div>
</div>
 <style>
 .abbox{border: 1px solid #ccc;
    min-height: 95px;
    margin: 5px 0;
    text-align: center;
	color: #795548;
    font-weight: bold;
	}
.skbox{border: 1px solid #ccc;
    min-height: 95px;
    margin: 5px 0;
    text-align: center;
	color: #000;
    font-weight: bold;
	}
	
.PskillName {
    float: left;
    width: 34.5%;
    display: inline-block;
    padding: 10px 0 11px 0;
    border-right: 1px solid #000;
    margin-bottom: 0;    color: #000;
	font-size:18px !important;
	line-height:25px; !important;
}
div.meter {
    float: left;
    width: 100%;
    height: 25px;
    border: 1px solid #b0b0b0;
    -webkit-box-shadow: inset 0 3px 5px 0 #d3d0d0;
    -moz-box-shadow: inset 0 3px 5px 0 #d3d0d0;
    box-shadow: inset 0 3px 5px 0 #d3d0d0;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    -ms-border-radius: 3px;
    -o-border-radius: 3px;
    border-radius: 3px;
}
.mt10 {
    margin-top: 9px;
}
div.meter span {
    color: #fff;
    top: 0;
    line-height: 0px;
    padding-left: 7px;
    font-weight: bold;
    text-align: right;
    padding-right: 5px;
    display: block;
    height: 100%;
    animation: grower 1s linear;
    -moz-animation: grower 1s linear;
    -webkit-animation: grower 1s linear;
    -o-animation: grower 1s linear;
    position: relative;
    left: -1px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    -ms-border-radius: 3px;
    -o-border-radius: 3px;
    border-radius: 3px;
    -webkit-box-shadow: inset 0px 3px 5px 0px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: inset 0px 3px 5px 0px rgba(0, 0, 0, 0.2);
    box-shadow: inset 0px 3px 5px 0px rgba(0, 0, 0, 0.2);
    background-image: -webkit-gradient(linear, 0 0, 100% 100%, color-stop(0.25, rgba(255, 255, 255, 0.2)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.2)), color-stop(0.75, rgba(255, 255, 255, 0.2)), color-stop(0.75, transparent), to(transparent));
    background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent);
    background-image: -moz-linear-gradient(45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent);
    background-image: -ms-linear-gradient(45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent);
    background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent);
    -webkit-background-size: 45px 45px;
    -moz-background-size: 45px 45px;
    -o-background-size: 45px 45px;
    background-size: 45px 45px;
}
.redColor {
    background: #e81919;
}
.yellowColor {
    background: #ffa300;
    margin-bottom: 10px;
}
.greenColor {
    background: #8bcc46;
    margin-bottom: 10px;
}
.orangeColor {
    background: #f16202;
    margin-bottom: 10px;
}
.blueColor {
    background: #0ab7f6;
    margin-bottom: 10px;
}
div.meter span:before {
    content: '';
    display: block;
    width: 100%;
    height: 50%;
    position: relative;
    top: 50%;
    background: rgba(0, 0, 0, 0.03);
}
/* 
#JP{
	background: rgba(255,255,255,1);
background: -moz-radial-gradient(center, ellipse cover, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, rgba(255,255,255,1)), color-stop(47%, rgba(246,246,246,1)), color-stop(100%, rgba(237,237,237,1)));
background: -webkit-radial-gradient(center, ellipse cover, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
background: -o-radial-gradient(center, ellipse cover, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
background: -ms-radial-gradient(center, ellipse cover, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
background: radial-gradient(ellipse at center, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed', GradientType=1 );
} */
 </style>
 
 
 					<!-- popup side nav    headerinner.php-->
<div id="jobProfilenav" class="sidenav">

	<div class="">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="fa fa-window-close" aria-hidden="true"></i></a>
</div>
	
	<div class="">
		<div class="col-md-12 col-sm-12 col-xs-12 starclsnew" style="background: #fafafa;">		
			
			<div class="clear_both"></div>	
			<div class="sectiona" id="report">
				<div class="container">
					<div class="row">	
					
					<div class="modal-body"  style="padding:0px;">
	  <div style="padding-top:20px"> 
			<div style="text-align:center">
			<div class="fdbkcontent welcontent" style="padding-left: 150px;padding-right: 150px;line-height: 45px;font-weight: 550;font-size: 30px;color:#da0404 ">Abilities</div>
			
			<?php $i=1;
						foreach($getjobprofile as $row)
						{ 
						?>
			
			
			
				<div class="fdbkcontent welcontent" style="padding-left: 150px;padding-right: 150px;line-height: 45px;font-weight: 500;font-size: 25px; color:#92d050"><?php echo $row['subability']; ?>(<?php echo $row['abilityvalue']; ?>%)</div>
				<div class="fdbkcontent welcontent" style="padding-left: 150px;padding-right: 150px;font-weight: 450;line-height: 40px;font-size: 25px;"><?php echo $row['description']; ?></div>
				<?php
						$i++;
						} 
						?>
				<div class="fdbkcontent welcontent" style="padding-left: 150px;padding-right: 150px;font-weight: 550;line-height: 50px;font-size: 30px;color:#ffc000">Skill</div>
				<?php $j=1;
						foreach($getskilldata as $row1)
						{ 
						?>
				<div class="fdbkcontent welcontent" style="padding-left: 150px;padding-right: 150px;font-weight: 500;line-height: 45px;font-size: 25px;color:#ff6600"><?php echo $row1['subskill']; ?>(<?php echo $row1['skillvalue']; ?>%)</div>
				<div class="fdbkcontent welcontent" style="padding-left: 150px;padding-right: 150px;font-weight: 450;line-height: 40px;font-size: 25px;"><?php echo $row1['description']; ?></div>
				<?php
						$j++;
						} 
						?>
			</div>


