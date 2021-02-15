 <div class="loading" style="display:none;" ><img src="<?php echo base_url(); ?>assets/images/ajax-page-loader.gif" style="width:80px;" /></div>


<div class="row hdndiv">
	

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="x_panel tile">
<div class="x_title">
<div>
<h2 style="background:aqua; padding:5px; border-radius:45px; color:#000;">User Performance</h2>
<!--<a href="<?php echo base_url(); ?><?php echo $filename; ?>" class="btn btn-success" style="float: right;margin-bottom: 10px;" >Download</a>-->
</div>
<div style="clear:both">Note : Click on specific student name to view their details</div>
<!--<div style="clear:both">Note : Click on specific academy name to view their details</div>-->


<div class="clearfix"></div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<div id="clptable">

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
		<th>M</th>
		<th>VP</th>
		<th>FA</th>
		<th>PS</th>
		<th>L</th>
		<th>Detailed Assessment</th>
		<th>Program Status</th>
		<th>Scheduled Session</th>
		<th>Attended Session</th>
		<th>Completed Session</th>
		<!--<th>Registered Date</th>-->
		<th>Action</th>
       
      </tr>
    </thead>
    <tbody>
	<?php 
	$ini=0; 
	 
	{

	}
	foreach($query2 as $key3=>$val3){
	$ini++;
		$m=$v=$f=$p=$l=0;
	$ME = explode(',',$val3['skillscorem']);
	$VP = explode(',',$val3['skillscorev']);
	$FA = explode(',',$val3['skillscoref']);
	$PS = explode(',',$val3['skillscorep']);
	$LI = explode(',',$val3['skillscorel']);
	 
	?>	
      <tr>
        <td><?php echo $ini; ?></td> 
		<td class="fname"><a href="<?php echo base_url(); ?>index.php/home/userview/<?php echo $val3['username'];  ?>" style="text-decoration: underline;" ><?php echo $val3['fname'].' '.$val3['lname'];  ?></a></td>
		
		<td><?php echo $val3['username'];  ?></td>
		<td><?php echo str_replace("Grade","", $val3['grade']);  ?></td>
		<td><?php if($query1[$key3]['avgbspiset1']=='') {  echo '-'; } else { echo round($query1[$key3]['avgbspiset1'], 2); } ?>
		<a class="asap" style="float:right" href="javascript:;" data-target="#pwdModal" data-toggle="modal" data-info="<table><tr><td>Memory &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($query1[$key3]['skillscorem']=='') {  echo '-'; } else { echo round($query1[$key3]['skillscorem'], 2); } ?></td></tr><tr><td>Visual Processing &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($query1[$key3]['skillscorev']=='') {  echo '-'; } else { echo round($query1[$key3]['skillscorev'], 2); } ?></td></tr><tr><td>Focus and Attention &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($query1[$key3]['skillscoref']=='') {  echo '-'; } else { echo round($query1[$key3]['skillscoref'], 2); }  ?></td></tr><tr><td>Problem Solving &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($query1[$key3]['skillscorep']=='') {  echo '-'; } else { echo round($query1[$key3]['skillscorep'], 2); } ?></td></tr><tr><td>Linguistics &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($query1[$key3]['skillscorel']=='') {  echo '-'; } else { echo round($query1[$key3]['skillscorel'], 2); }?></td></tr></table>"><i class="fa fa-info"></i></a>
		</td>
		
		<td><?php if($query1[$key3]['skillscorem']=='') {  echo '-'; } else { echo round($query1[$key3]['skillscorem'], 2); }  ?></td>
		<td><?php if($query1[$key3]['skillscorev']=='') {  echo '-'; } else { echo round($query1[$key3]['skillscorev'], 2); }  ?></td>
		<td><?php if($query1[$key3]['skillscoref']=='') {  echo '-'; } else { echo round($query1[$key3]['skillscoref'], 2); }  ?></td>
		<td><?php if($query1[$key3]['skillscorep']=='') {  echo '-'; } else { echo round($query1[$key3]['skillscorep'], 2); }  ?></td>
		<td><?php if($query1[$key3]['skillscorel']=='') {  echo '-'; } else { echo round($query1[$key3]['skillscorel'], 2); }  ?></td>
		
		<td><?php if((($ME[1]+$VP[1]+$FA[1]+$PS[1]+$LI[1])/5)=='') {  echo '-'; } else { echo  round(($ME[1]+$VP[1]+$FA[1]+$PS[1]+$LI[1])/5,2);  } ?> 
		<a class="clp" style="float:right" href="javascript:;" data-target="#pwdModal" data-toggle="modal" data-info="<table><tr><td>Memory &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($ME[0]=='') {  echo '-'; } else { echo round($ME[0], 2);  }  ?></td></tr><tr><td>Visual Processing &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($VP[0]=='') {  echo '-'; } else { echo round($VP[0], 2);  } ?></td></tr><tr><td>Focus and Attention &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($FA[0]=='') {  echo '-'; } else { echo round($FA[0], 2);  } ?></td></tr><tr><td>Problem Solving &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($PS[0]=='') {  echo '-'; } else { echo round($PS[0], 2);  } ?></td></tr><tr><td>Linguistics &nbsp;&nbsp;</td><td>&nbsp;&nbsp;<?php if($LI[0]=='') {  echo '-'; } else { echo round($LI[0], 2);  } ?></td></tr></table>"><i class="fa fa-info"></i></a>
		</td>
		
		<td>		
		<?php 		
		if($query1[$key3]['playcount']==0)		{  	echo 'Initial Assessment Yet to Start'; 	}		
		else if($query1[$key3]['playcount']<5)	{ 	echo 'Initial Assessment In progress'; 		} 		
		else if($val3['playcount']==0)			{	echo 'Detailed Assessment Yet to start';	}		
		else if($val3['playcount']<8)			{ 	echo 'Detailed Assessment'; 				}
		else if($val3['playcount']==8)			{ 	echo 'Personalized Training Yet to start';  }		
		else if($val3['playcount']>8)			{	echo $val3['cyclename']; 					} 
		?>		
		</td>
		
		<!--<td><?php echo date('d-m-Y',strtotime($val3['creation_date'])); ?></td>-->
		
		<td><?php if($val3['scheduled_session']=='') { echo 0; } else { echo $val3['scheduled_session']; } ?></td>
		<td><?php if($val3['AttendedSession']=='') { echo 0; } else { echo $val3['AttendedSession'];     } ?></td>
		<td><?php if($val3['CompletedSession']=='') { echo 0; } else { echo $val3['CompletedSession'];   } ?></td>
		
		<td><a href="<?php echo base_url(); ?>index.php/home/userview/<?php echo $val3['username'];  ?>" class="btn btn-success"><i class="fa fa-eye"></i> View</a></td>
      </tr>
	<?php } ?>
      
	  
    </tbody>
  </table> 
 </div>	
</div>
</div>
</div>

<!--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
<div id="Usercountdatewise" style="background:#fff;padding-top:20px;border: 1px solid #ccc;" ></div>
</div>-->		

<link href="<?php echo base_url(); ?>assets/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/fixedcolumns/3.3.0/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/css/dataTables.tableTools.css" rel="stylesheet" type="text/css">

<script src="<?php echo base_url(); ?>assets/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.js" type="text/javascript"></script>
<script src="https://datatables.net/extensions/fixedcolumns/examples/initialisation/two_columns.html" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/dataTables.tableTools.js" type="text/javascript"></script>


<script src="<?php echo base_url(); ?>assets/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/jszip.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/pdfmake.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/vfs_fonts.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/buttons.print.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/pdfmake.min.js" type="text/javascript"></script>



<script>
$(document).ready(function(){
	
});

$('#btnsrch').click(function(){
	
	var ddacademyname = $('#ddacademyname').val();
	var txtstudentname = $('#txtstudentname').val();
	var ddgradename = $('#ddgradename').val();
			$('.loading').show();
		$.ajax({
type:"POST",
url:"<?php echo base_url('index.php/home/clp_users_search') ?>",
data:{ddacademyname:ddacademyname,txtstudentname:txtstudentname,ddgradename:ddgradename},
success:function(result)
{
	$('.loading').hide();
$('#clptable').html(result);
}
});
		
});

$('#buttonLogin').on('click', function(e){

    $("#login_Box_Div").toggle();
});


$('#btnReset').click(function() {
   // location.reload(true);
	location.href="userperformance";
});

$('#assementTable').DataTable( {
	"lengthMenu": [[10,  -1], [10,  "All"]],
	dom: 'Blfrtip',
    buttons: ['copy', 'csv', 'excel', 'print','pdf'],
	//paging: false,
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   {leftColumns: 1,rightColumns: 1},
		
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
		
		
	},
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
		$(".modalheading").html($(this).parent().siblings('td.fname').html()+" - Initial Assessment");	
		$(".modaldata").html($(this).attr("data-info"));
	});
	$('.clp').click(function(){
		$(".modaldata").html("");$(".modalheading").html("");
		$(".modalheading").html($(this).parent().siblings('td.fname').html()+" - Detailed Assessment");
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

.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.3);
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}
</style>
