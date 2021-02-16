 <div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel tile">
<div class="x_title">
<h2><span style="background:aqua; padding:5px; border-radius:45px; color:#000;">Product - CLP</span></h2>
<h2 style="float: right;margin-bottom: 10px;" >License in Hand : <?php echo $distributedlicence[0]['totalcount'] - $userscount[0]['total']; ?></h2>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>

<div class="row">

<div class="animated flipInY col-lg-12 col-md-12 col-sm-12 col-xs-12">


<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">	
		<div class="tile-stats">
			<!--<a href="<?php echo base_url(); ?>index.php/home/userslist">-->
			<div class="toppart" style="background-color: #ffa500;color:#fff">
			<div class="icon"><i class="fa fa-credit-card"></i></div>
				<div class="count"><?php  if($distributedlicence[0]['totalcount']=='') { echo 0; } else { echo $distributedlicence[0]['totalcount']; } ?></div>
				<h4>Total Licenses</h4>
			</div>
			
			<div class="footerpart">
				<p class="pull-left"></p><span style="visibility:hidden;" class="pull-right"><i class="fa fa-arrow-circle-down"></i></span>
			</div>
		</div>
		</div>



	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	<a href="javascript:;" id = "buttonLogin" onclick = "displayLoginBox()">
	
		<div class="tile-stats">
			<!--<a href="<?php echo base_url(); ?>index.php/home/userslist">-->
			<div class="toppart" style="background-color: #ffa500;color:#fff">
			<div class="icon"><i class="fa fa-credit-card"></i></div>
				<div class="count"><?php echo $userscount[0]['total']; ?></div>
				<h4>Licenses Used</h4>
			</div>
			
			<div class="footerpart">
				<p class="pull-left"></p><span class="pull-right"><i class="fa fa-arrow-circle-down"></i></span>
			</div>
		</div></a>
		</div>
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display:none;" id="login_Box_Div">
<!--<div id="Gradewiseusers" style="background:#fff;padding-top:20px;border: 1px solid #ccc;" ></div>-->

<table id="assementTable1" class="table table-striped table-bordered table-hover table-condensed">
    <thead>
      <tr>
        <th>S.No.</th>
        <th>Grade</th>
		<th>Users Count</th>
       
      </tr>
    </thead>
    <tbody>
	<?php 
	$ini=0; 
	foreach($gradewiseusers as $res){
	$ini++;
	?>	
      <tr>
        <td><?php echo $ini; ?></td>
		<td><?php echo $res['grade']; ?></td>
		<td><?php echo $res['usercount']; ?></td>
		</tr>
		<?php } ?>
		  </tbody>
  </table>
</div>
		
		
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="x_panel tile">
<div class="x_title">
<div>
<h2 class="reporttitle">User Performance</h2>
<!--<a href="<?php echo base_url(); ?><?php echo $filename; ?>" class="btn btn-success" style="float: right;margin-bottom: 10px;" >Download</a>-->
<a href="javascript:;" class="btn btn-success" id="downloadcsv" style="float: right;margin-bottom: 10px;" ><i class="fa fa-download"></i> Download</a>
</div>
<div style="clear:both">Note : Click on specific student name to view their details</div>

<div class="clearfix"></div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<?php 

		foreach($asap_reports as $key1=>$val1) {
			
			$query1[$asap_reports[$key1]['username']] =  $val1;
	
		}		
		foreach($clp_reports as $key2=>$val2) {
			
			$query2[$clp_reports[$key2]['username']] =  $val2;

		}
		
?>
	<table id="assementTable" class="table table-striped table-bordered table-hover table-condensed">
    <thead>
      <tr>
        <th>S.No.</th>
        <th>Student Name</th>
		<th>Username</th>
		<th>Grade</th>  		
		<th>Initial Assessment - BSPI</th>
		<th>Detailed Assessment</th>		
		<th>Intermediate Assessment</th>
		<th>Post Assessment</th>
		<th>Program Status</th>
	<!--<th>Created Date</th>-->
		<th>Action</th>
       
      </tr>
    </thead>
    <tbody>
	<?php 
	$ini=0; 
	
	foreach($query2 as $key3=>$val3){
	$ini++;
	
	$m=$v=$f=$p=$l=0;
	$ME = explode(',',$val3['skillscorem']);
	$VP = explode(',',$val3['skillscorev']);
	$FA = explode(',',$val3['skillscoref']);
	$PS = explode(',',$val3['skillscorep']);
	$LI = explode(',',$val3['skillscorel']);
	
	if($val3['me24']!=''){$me24=$val3['me24'];}else{$me24=0;}
	if($val3['vp24']!=''){$vp24=$val3['vp24'];}else{$vp24=0;}
	if($val3['fa24']!=''){$fa24=$val3['fa24'];}else{$fa24=0;}
	if($val3['ps24']!=''){$ps24=$val3['ps24'];}else{$ps24=0;}
	if($val3['li24']!=''){$li24=$val3['li24'];}else{$li24=0;}
	
	if($val3['me48']!=''){$me48=$val3['me48'];}else{$me48=0;}
	if($val3['vp48']!=''){$vp48=$val3['vp48'];}else{$vp48=0;}
	if($val3['fa48']!=''){$fa48=$val3['fa48'];}else{$fa48=0;}
	if($val3['ps48']!=''){$ps48=$val3['ps48'];}else{$ps48=0;}
	if($val3['li48']!=''){$li48=$val3['li48'];}else{$li48=0;}
	?>	
      <tr>
        <td><?php echo $ini; ?></td>
		<td class="fname"><a href="<?php echo base_url(); ?>index.php/home/userview/<?php echo $val3['id'];  ?>" style="text-decoration: underline;" ><?php echo $val3['fname'].' '.$val3['lname'];  ?></a></td>
		
		<td><?php echo $val3['username'];  ?></td>
		<td><?php echo str_replace("Grade","", $val3['grade']);  ?></td>		
		
		<td><?php if($query1[$key3]['avgbspiset1']=='') {  echo '-'; } else { echo round($query1[$key3]['avgbspiset1'], 2); } ?>
		<a class="asap" style="float:right" href="javascript:;" data-target="#pwdModal" data-toggle="modal" data-info="<table><tr><td>Memory &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($query1[$key3]['skillscorem']=='') {  echo '-'; } else { echo round($query1[$key3]['skillscorem'], 2); } ?></td></tr><tr><td>Visual Processing &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($query1[$key3]['skillscorev']=='') {  echo '-'; } else { echo round($query1[$key3]['skillscorev'], 2); } ?></td></tr><tr><td>Focus and Attention &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($query1[$key3]['skillscoref']=='') {  echo '-'; } else { echo round($query1[$key3]['skillscoref'], 2); }  ?></td></tr><tr><td>Problem Solving &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($query1[$key3]['skillscorep']=='') {  echo '-'; } else { echo round($query1[$key3]['skillscorep'], 2); } ?></td></tr><tr><td>Linguistics &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($query1[$key3]['skillscorel']=='') {  echo '-'; } else { echo round($query1[$key3]['skillscorel'], 2); }?></td></tr></table>"><i class="fa fa-info"></i></a>
		</td>
		
		<td><?php if((($ME[1]+$VP[1]+$FA[1]+$PS[1]+$LI[1])/5)=='') {  echo '-'; } else { echo  round(($ME[1]+$VP[1]+$FA[1]+$PS[1]+$LI[1])/5,2);  } ?> 
		<a class="clp" style="float:right" href="javascript:;" data-target="#pwdModal" data-toggle="modal" data-info="<table><tr><td>Memory &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($ME[0]=='') {  echo '-'; } else { echo round($ME[0], 2);  }  ?></td></tr><tr><td>Visual Processing &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($VP[0]=='') {  echo '-'; } else { echo round($VP[0], 2);  } ?></td></tr><tr><td>Focus and Attention &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($FA[0]=='') {  echo '-'; } else { echo round($FA[0], 2);  } ?></td></tr><tr><td>Problem Solving &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($PS[0]=='') {  echo '-'; } else { echo round($PS[0], 2);  } ?></td></tr><tr><td>Linguistics &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($LI[0]=='') {  echo '-'; } else { echo round($LI[0], 2);  } ?></td></tr></table>"><i class="fa fa-info"></i></a>
		</td>
		
		<td><?php if((($me24+$vp24+$fa24+$ps24+$li24)/5)=='') {  echo '-'; }else{ echo  round(($me24+$vp24+$fa24+$ps24+$li24)/5,2);  } ?> 
		<a class="inasap" style="float:right" href="javascript:;" data-target="#pwdModal" data-toggle="modal" data-info="<table><tr><td>Memory &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($me24=='') {  echo '-'; } else { echo $me24;  }  ?></td></tr><tr><td>Visual Processing &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($vp24=='') {  echo '-'; } else { echo $vp24;  } ?></td></tr><tr><td>Focus and Attention &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($fa24=='') {  echo '-'; } else { echo $fa24;  } ?></td></tr><tr><td>Problem Solving &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($ps24==''){  echo '-'; }else{ echo $ps24;  } ?></td></tr><tr><td>Linguistics &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($li24=='') {  echo '-'; } else { echo $li24;  } ?></td></tr></table>"><i class="fa fa-info"></i></a>
		</td>
		
		
		<td><?php if((($me48+$vp48+$fa48+$ps48+$li48)/5)=='') {  echo '-'; }else{ echo  round(($me48+$vp48+$fa48+$ps48+$li48)/5,2);  } ?> 
		<a class="pasap" style="float:right" href="javascript:;" data-target="#pwdModal" data-toggle="modal" data-info="<table><tr><td>Memory &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($me48=='') {  echo '-'; } else { echo $me48;  }  ?></td></tr><tr><td>Visual Processing &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($vp48=='') {  echo '-'; } else { echo $vp48;  } ?></td></tr><tr><td>Focus and Attention &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($fa48=='') {  echo '-'; } else { echo $fa48;  } ?></td></tr><tr><td>Problem Solving &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($ps48==''){  echo '-'; }else{ echo $ps48;  } ?></td></tr><tr><td>Linguistics &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($li48=='') {  echo '-'; } else { echo $li48;  } ?></td></tr></table>"><i class="fa fa-info"></i></a>
		</td>
		
		<td>
		<?php if($query1[$key3]['playcount']==0)
		{  
			echo 'Initial Assessment Yet to Start'; 
		}
		else if($query1[$key3]['playcount']<5)
		{ 
			echo 'Initial Assessment In progress'; 
		} 
		else if($val3['playcount']==0)
		{
			echo 'Detailed Assessment Yet to start';
		}
		else if($val3['playcount']<8)
		{ 
			echo 'Detailed Assessment'; 
		}
		
		else if($val3['playcount']>8)
		{
			echo $val3['cyclename']; 
		} 
		?></td>
		 
		
	<!--	<td><?php echo date('d-m-Y',strtotime($val3['creation_date'])); ?></td>-->
		<td><a href="<?php echo base_url(); ?>index.php/home/userview/<?php echo $val3['id'];  ?>" class="btn btn-success"><i class="fa fa-eye"></i> View</a></td>
      </tr>
	<?php } ?>
      
	  
    </tbody>
  </table>
	
</div>
</div>
</div>

<!--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
<div id="Usercountdatewise" style="background:#fff;padding-top:20px;border: 1px solid #ccc;" ></div>
</div>-->

</div>
</div>
 </div>
 
<div class="row">

</div>
		
		

<link href="<?php echo base_url(); ?>assets/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/dataTables.tableTools.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/dataTables.tableTools.js" type="text/javascript"></script>
<script>
$('#buttonLogin').on('click', function(e){

    $("#login_Box_Div").toggle();
  //  $(this).toggleClass('class1')
});

$('#assementTable').DataTable( {
	"lengthMenu": [[10,  -1], [10,  "All"]],
	"fnDrawCallback": function (oSettings) {
		$('.asap').click(function(){
			$(".modaldata").html("");$(".modalheading").html("");
			$(".modalheading").html($(this).parent().siblings('td.fname').html()+" - Initial Assessment");	
			$(".modaldata").html($(this).attr("data-info"));
		});
		$('.clp').click(function(){
			$(".modaldata").html("");$(".modalheading").html("");
			$(".modalheading").html($(this).parent().siblings('td.fname').html()+" - Detailed Assessment");
			$(".modaldata").html($(this).attr("data-info"));
		});
		$('.inasap').click(function(){
			$(".modaldata").html("");$(".modalheading").html("");
			$(".modalheading").html($(this).parent().siblings('td.fname').html()+" - Intermediate Assessment");	
			$(".modaldata").html($(this).attr("data-info"));
		});
		$('.pasap').click(function(){
			$(".modaldata").html("");$(".modalheading").html("");
			$(".modalheading").html($(this).parent().siblings('td.fname').html()+" - Post Assessment");	
			$(".modaldata").html($(this).attr("data-info"));
		});
	},
"scrollX": true
});

$('#downloadcsv').click(function(){
		$.ajax({
type:"POST",
url:"<?php echo base_url('index.php/home/patientperformance_downloadcsv') ?>",
data:{},
success:function(result)
{
//alert(result);
var s = result.replace(/\uploads/g, '');
var res = s.replace(/\//g, '');
$("#downloadcsv").attr("download", res);
window.location.href= "<?php echo base_url(); ?>"+ result +"";
}
});
		
	$('.asap').click(function(){
		//alert($(this).parent().siblings('td.fname').html());
		$(".modaldata").html("");$(".modalheading").html("");
		$(".modalheading").html($(this).parent().siblings('td.fname').html()+" - ASAP Skill Score");	
		$(".modaldata").html($(this).attr("data-info"));
	});
	$('.clp').click(function(){
		$(".modaldata").html("");$(".modalheading").html("");
		$(".modalheading").html($(this).parent().siblings('td.fname').html()+" - CLP Skill Score");
		$(".modaldata").html($(this).attr("data-info"));
	});
});

</script>
<style>
.reporttitle { color:#1abb9c; }
thead{ background-color: #1abb9c; color: #fff;}
body{ padding-right: 0px !important; }
body.modal-open { padding-right: 0px !important; }
.modal-content {width: 70%;margin: 0 auto;}
.modaldata table{margin: 0 auto;}
.modaldata td{text-align:justify;}
.modalheading{color: #0d77de;font-weight: bold;}
.panel-default{border-color: #5187bd;background: #3d6a96;color: #fff;}
</style>
