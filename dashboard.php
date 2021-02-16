<div class="modal fade" data-easein="bounceIn" id="GotoSkillkitPuzzles" role="dialog">
    <div class="modal-dialog"> 
      <!-- Modal content-->
     <div class="">
        <div class="modal-body skillkitmodal"  style="" >
			<div style="padding-top:80px">
					<h2 class="modal-title" style="text-align:center;padding-bottom:0"></h2>
					<div style="text-align:center;position: relative;padding: 5%;">
					<h3 style="color:#ff6600"> Hi <?php echo $this->session->fname; ?>,</h3>
				  <div class="fdbkcontent" style="font-size: 20px; width:70%; margin:0 auto;">
				  Great job now by solving the puzzles again to get a higher score !</div>
				</div>
			</div><br/><br/> 
			 <div style="text-align:center;">
			 <a href="<?php echo base_url(); ?>index.php/home/skillkit" class="btn btn-success" id="" >Ok</a> 
			<!-- <button type="button" class="btn btn-danger" id="skillkitclose">ok</button>--> 
			 </div>
        </div>
      </div>
    </div>
</div>
<?php   
//if($this->session->game_grade!=12 && $this->session->game_grade!=13 && $this->session->game_grade!=14 && $this->session->game_grade!=15)
if($this->session->game_grade==100)
{
	if($isEligibleToday==1)
	{ 
		$class="UnlockMP";
		$Icon="fa fa-unlock lockbounce";
		$msg="<div class=''><span style='font-size:12px;'>Now you can play math puzzle.</span></div>";
	}
	else
	{
		$class="LockMP";
		$Icon="fa fa-lock";
		$msg="<div class=''><span style='font-size:12px;'>Get your daily Math Puzzle! <br/>Complete all 5 skills, The math puzzle will enable for you..!</span></div>";
	}
	$mathcolsize="col-md-2 col-sm-2 col-xs-12";
}
else
{
	$mathcolsize="col-md-3 col-sm-3 col-xs-12";
}
?>
<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.fancybox-media.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.fancybox.css" media="screen">-->

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/fancy/jquery.fancybox.css" media="screen">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/fancy/fullscreen.css" media="screen">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/css/fancy/jquery.fancybox.js"></script>

 
<style>
#techskip {
	
	/* background: #370000; */
    text-decoration: underline;
	color : grey;
    font-size: 25px;
    display: block;
    margin: 13px;
   /*  border: 4px solid #e38908;
    border-radius: 30px; */
}

.pricesaving {
    width: 27%;
    height: 17%;
    padding-top: 10px;
    color: #fff;
    font-weight: 700;
    font-size: 16px;
     background: url('<?php echo base_url(); ?>assets/images/home/lifesymbol.png');
    position: absolute;
    right: -17px;
    top: -27px;
    border-radius: 16px;
    background-size: cover;
    background-repeat: no-repeat;
}
.timelabel{margin:45px 0px 0px 0px;font-size:20px;font-weight:bold;}
.clock{margin:40px 0px 20px 0px;}
.warninglabel {
    margin: 25px 0px 0px 0px;
    font-size: 20px;
    color: #2b6121;
    text-align: left;
}
.warninglabel .fa {
    padding-right: 10px;
    color: #06345f;
}
.warninglabel strong {
    color: #f60;
}


html{background:#2F3238; }

.feedback-button {height:40px; border:solid 3px #CCCCCC; background:#333; width:100px; line-height:32px; -webkit-transform:rotate(-90deg); font-weight:600; color:white; transform:rotate(-90deg);  -ms-transform:rotate(-90deg);  -moz-transform:rotate(-90deg); text-align:center; font-size:17px; position:fixed; right:-40px; top:45%; font-family: "Roboto", helvetica, arial, sans-serif; z-index:999; }





@media only screen and (max-width: 580px) {
	#feedback-div{
		left: 3%;
		margin-right: 3%;
		width: 88%;
		margin-left: 0;
		padding-left: 3%;
		padding-right: 3%;
	}
}

.error { color:red; }
.mandatory{color:red;}


.ViewBadges{text-align:center;}
/* #badge{
    -webkit-animation: highlight1 2000ms infinite;
    -moz-animation: highlight1 2000ms infinite;
    -o-animation: highlight1 2000ms infinite;
    animation: highlight1 2000ms infinite;
	background: #92278f;
    padding: 15px;
    overflow: hidden;
    display: inline-block;
    border-radius: 20px;
    font-size: 25px;
    box-shadow: 5px 5px 5px #ccc;
} */
 

@-webkit-keyframes highlight1
{
0%{background-color:#92278f;-webkit-box-shadow:0 0 3px #92278f;}
50%{background-color:#92278f;-webkit-box-shadow:0 0 40px #92278f;}
100%{background-color:#ff6600;-webkit-box-shadow:0 0 3px #ff6600;}
}
@-moz-keyframes highlight1
{
0%{background-color:#92278f;-webkit-box-shadow:0 0 3px #92278f;}
50%{background-color:#92278f;-webkit-box-shadow:0 0 40px #92278f;}
100%{background-color:#ff6600;-webkit-box-shadow:0 0 3px #ff6600;}
}
@-o-keyframes highlight1
{
0%{background-color:#92278f;-webkit-box-shadow:0 0 3px #92278f;}
50%{background-color:#92278f;-webkit-box-shadow:0 0 40px #92278f;}
100%{background-color:#ff6600;-webkit-box-shadow:0 0 3px #ff6600;}
}
@keyframes highlight1
{
0%{background-color:#92278f;-webkit-box-shadow:0 0 3px #92278f;}
50%{background-color:#92278f;-webkit-box-shadow:0 0 40px #92278f;}
100%{background-color:#ff6600;-webkit-box-shadow:0 0 3px #ff6600;}
}
</style>
 <div id="slider1" class="slider" style="display: none;" >
 <input type="hidden" id="latestallcount" value="" />
 <input type="hidden" id="latestminecount" value="" />
<!-- <input type="hidden" id="latestjobprofile" value="" />	-->
<div class="loading-info" style="display: none;"><img src="<?php echo base_url(); ?>assets/images/ajax-loader.gif" /></div>
	 <div id="trigger1" class="minecls"><div class="newsfeedoverlay"><span class="glyphicon glyphicon-chevron-left fltleft"><span class="toppercontent">Mine</span></span><div id="new_newsfeed_minecount" class="newmsgcame"></div></div></div>
	 <div class="Mineoverlay">
		<ul class="scrollbar" id="resultsmine" style="display:none;"></ul>
	 </div>
</div>
<div id="slider2" class="slider" style="display: none;" >
<div class="loading-info" style="display: none;"><img src="<?php echo base_url(); ?>assets/images/ajax-loader.gif" /></div>
	 <div id="trigger2" class="minecls"><div class="newsfeedoverlay"><span class="glyphicon glyphicon-chevron-left fltleft"><span class="toppercontent">All</span></span><div id="new_newsfeed_allcount" class="newmsgcame"></div></div></div>
	 <div class="AllOverlay">
		<ul class="scrollbar" id="resultsall" style="display:none;"></ul>
	 </div>
</div>

<!--
<div class="parallax-window">
<a href="javascript:;" class="vprofile" id="vprofile" onclick="openNav()">View Jobprofile</a>

<div id="jobProfile" class="sidenav">
	<div class="">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="fa fa-window-close" aria-hidden="true"></i></a>
</div>
	
	<div class="">
		<div class="col-md-12 col-sm-12 col-xs-12 starclsnew" style="background: #fafafa;">		
			<h3 style="background: #faa400;padding: 10px;color: #fff;font-size: 30px;">Job Profile</h3>
			<div class="clear_both"></div>	
			<div class="sectionb" id="report">
				<div class="container">
					<div class="row">	
						<div id="JobProfile"></div>
					</div>
				</div>
			</div>	
		</div>	
	</div>	</div>
</div>	

<script>
/* function openNav() {
		$(".btmbar").css("z-index","99");
		$("#myBtn").css("z-index","99");
		
		document.getElementById("jobProfile").style.width = "100%";
	}

	function closeNav() {
		document.getElementById("jobProfile").style.width = "0";
		$(".btmbar").css("z-index","9999");
		$("#myBtn").css("z-index","99999");
	} */

/* $(function () {
   $('[data-toggle="tooltip"]').tooltip();
	
}); */


</script>
<!--<div id="slider3" class="slider" style="display: none;">
<div class="loading-info" style="display: none;"><img src="<?php echo base_url(); ?>assets/images/ajax-loader.gif" /></div>
	 <div id="trigger3" class="minecls"><div class="newsfeedoverlay"><span class="glyphicon glyphicon-chevron-left fltleft"><span class="toppercontent">Job Profile</span></span><div id="new_jobprofile" class="newmsgcame"></div></div></div>
	  <div class="Jobprofileoverlay">
		<ul class="scrollbar" id="resultsjob" style="display:none;"></ul>
	 </div>
</div>	-->


<?php if($feedbackenable[0]['uid']==0 && $feedbackenable[0]['regdate']!=date('m')) { ?>
<button id="popup" class="feedback-button" data-toggle="modal" data-target="#modalContactForm" >Feedback </button>
<?php } ?>

<div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
		<!--<div class="modal-header text-center">
                <h3 class="modal-title w-100 font-weight-bold">Feedback Corner</h3>
				
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
         </div>-->
        <div class="modal-content">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
				<div id="successmsg" style="color: green;font-size: 25px; text-align:center;"></div>
			<form role="form" id="fdbkform" style="" enctype="multipart/form-data" accept-charset="utf-8" name="fdbkform" class="col-md-12">
			
	<div class="feedbackhd">
		<h3 >Hello <?php echo $this->session->fname; ?></h3>
		<label class="radio-inline">We Would love to hear from you. Please fill out the questionaire.</label>
	</div>
                
 <div class="form-group">
    <label for="nameoftheorganisation">1. Where you been able to understand the puzzles <span class="mandatory">*</span> ?</label>
	<br/>
    <label class="radio-inline optioncolor">
      <input type="radio" name="qone"  value="1">Yes
    </label>
	<label class="radio-inline optioncolor">
      <input type="radio" name="qone" value="0">No
    </label>
  </div>
  
   <div class="form-group">
    <label for="nameoftheorganisation">2. Was it easy to play <span class="mandatory">*</span> ? </label>
	<br/>
    <label class="radio-inline optioncolor">
      <input type="radio" name="qtwo" value="1" >Yes
    </label>
	<label class="radio-inline optioncolor">
      <input type="radio" name="qtwo" value="0" >No
    </label>
  </div>
  
   <div class="form-group">
    <label for="nameoftheorganisation">3. Do you like the icons <span class="mandatory">*</span> ?</label>
	<br/>
    <label class="radio-inline optioncolor">
      <input type="radio" name="qthree" value="1" >Yes
    </label>
	<label class="radio-inline optioncolor">
      <input type="radio" name="qthree" value="0" >No
    </label>
  </div>
  
  <div class="form-group">
    <label for="nameoftheorganisation">4. Do you find any skill to be difficult ?</label>
	<br/>
	<?php foreach($skills as $res) { ?>
    <label class="radio-inline optioncolor nopad">
      <input type="checkbox" name="chkbox[]" class="skillname" id="" value="<?php echo $res['id']; ?>"> <?php echo $res['name']; ?>
    </label>
	<?php } ?>
  </div>
  
  
  <div class="form-group">
    <label for="exampleInputPassword1">5. Kindly send us what you feel ! Please write here</label>
    <textarea type="text" class="md-textarea form-control" id="usercmnt" name="usercmnt"  rows="4" placeholder=""></textarea>
  </div>
  <div class="form-group text-center" >
	<button type="button" id="fdbksubmit" class="btn btn-success">Submit</button>
  </div>
</form>
        </div>
    </div>
</div>



<div class="modal fade" id="teachersmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
	<div>
<div class="modal-body">
        <div class="modal-content">
           <div id="tsuccessmsg" style="color: green;font-size: 25px; text-align:center; display:none; margin:45px;">Thanks for your feedback
				<button type="button" class="close" style="top: 10px;right: 10px;font-size: 35px;position: absolute;opacity : 1;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:#000;">&times;</span>
                </button>
				
				</div>
				
				<img src="<?php echo base_url(); ?>/assets/images/popup/Teachers-01web.png" class="tfdimg" style="width: 100%;" />
			<form role="form" id="tfdbkform" style="" enctype="multipart/form-data" accept-charset="utf-8" name="tfdbkform" class="col-md-12">
			
	  

  
  
  <div class="form-group">
    <textarea type="text" class="md-textarea form-control" id="tusercmnt" name="tusercmnt"  rows="4" placeholder="Write your message here ..."></textarea>
  </div>
  
  <div class="col-md-6 col-sm-6 col-xs-6">
  <!--<p class="thanksmsg">- Thank You... Dear Teacher.</p>--->
  <img src="<?php echo base_url(); ?>/assets/images/popup/Teachers-02aweb.png" style="width: 100%;" />
  </div>
  
  <div class="col-md-3 col-sm-3 col-xs-3  sbmtimg">
  <button type="button" id="tfdbksubmit" class="btn tfdbksubmit"></button>
  </div>
  
  <div class="col-md-3 col-sm-3 col-xs-3 pull-right">
	<a href="javascript:;" class="btn tfdbksubmit" id="techskip" class="btn">Skip</a>
  </div>
  

</form>
        </div>
		</div> </div>
    </div>
</div>

                

<div class="clear_both"></div>
<div class="section_four" style="padding: 0px 0px 0px 60px;">
<div class="container">
<div id="TodayTimer">
 <?php if($sumoftottimeused<=$maxtimeofplay){ //Checking 30mins play time get over for the DAY ?>
 <div class="col-md-12 col-sm-12 col-xs-12">
	 <div class="col-md-7 col-sm-7 col-xs-12">
		<div class="row"><h2>Today's Puzzles<a style="top:-5px;position:relative;" href="javascript:;" data-toggle="tooltip" data-placement="bottom" data-html="true" title='<div class=""><span style="font-size:12px;">Get your daily dose! <br/>Practice regularly to improve your skills!</span></div>'><i  style="color:black; font-size:16px;" class="fa fa-info-circle"></i></a></h2></div><br/>
	 </div>
	 <?php
	if($this->session->TimerRunningStatus=='Y')
	{
	?>
	<div class="col-md-5 col-sm-5 col-xs-12">
		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-12 timelabel">Time Left <a style="top:-5px;position:relative;" href="javascript:;" data-toggle="tooltip" data-placement="right" data-html="true" title='<div class=""><span style="font-size:12px;">Hurry! This shows how much time you have left today.</span></div>'><i  style="color:black; font-size:16px;" class="fa fa-info-circle"></i></a></div>
			<div class="col-md-6 col-sm-6 col-xs-12 timevalue">
				<div class="clock" style=""></div>
			</div>
		 </div>
	 </div>
	 <?php
	}
	?>
 </div>
 <?php } else{ ?>
 <div class="col-md-12 col-sm-12 col-xs-12 panel">
	<div class="col-md-4 col-sm-4 col-xs-12">
		<div class="row"><h2>Today's Puzzles <a style="top:-5px;position:relative;" href="javascript:;" data-toggle="tooltip" data-placement="bottom" data-html="true" title='<div class=""><span style="font-size:12px;">Get your daily dose! <br/>Practice regularly to improve your skills!</span></div>'><i  style="color:black; font-size:16px;" class="fa fa-info-circle"></i></a></h2></div>
	</div>
	<div class="col-md-8 col-sm-8 col-xs-12 warninglabel">
		<div class="row"><i class="fa fa-hourglass-end faa-flash animated"></i>Hope you enjoyed learning the fun way.<strong> See you in the next session . . . </strong><i class="fa fa-thumbs-o-up faa-bounce animated"></i></div>
	</div>
 </div> 
 <?php } ?>
</div> 
<div class="clear_both"></div>
</div><!-- container -->
</div><!-- section_four -->

<div id="dashboard_ajax"><!-------------------- Dashboard Ajax Start ------------------------->
 <div class="clear_both"></div>
 <div class="section_four">
 <div class="container">
<div class="panel panel-default">
<div class="panel-body">
<!--<ul class="nav nav-tabs responsive">
<li class="active"><a href="#BrainSkillsOn" class="tab_bg_one">Brain Skills</a></li>
<li><a href="#Curriculum" class="tab_bg_two">Curriculum</a></li>
<li><a href="#LifeSkills" class="tab_bg_three">Life Skills</a></li>
</ul>-->

<div class="tab-content responsive">
<div class="tab-pane active" id="BrainSkillsOn">
<div class="tab_sec_c1">
 <h3> </h3>
<div class="row">
<?php
 $myskillpie=array("59"=>"#cdcdcd","60"=>"#cdcdcd","61"=>"#cdcdcd","62"=>"#cdcdcd","63"=>"#cdcdcd");
 //$myskillpie=array("59"=>"#ff6600","60"=>"#067d00","61"=>"#ffbe00","62"=>"#be0000","63"=>"#1e9ddf");
 $myskillpie_orginal=array("59"=>"#da0404","60"=>"#ffc000","61"=>"#92d050","62"=>"#ff6600","63"=>"#00b0f0");
?>
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="row">
<?php 
if($skillkitplay=='Y')
{
?>
<?php foreach($actualGames as $games)
{
	$skillhint='';
	 	 
	if($games['skill_id']=='59'){$skillhint='This skill reflects how fast your brain encodes, stores and retrieves information.';}
	else if($games['skill_id']=='60'){$skillhint="This skill reflects how you organise and interpret information you see and give it meaning.";}
	else if($games['skill_id']=='61'){$skillhint='This skill reflects the three components of attention: alertness, orientating and executive functions.';}
	else if($games['skill_id']=='62'){$skillhint='This skill reflects the act of analytical and creative thinking to identify problems and evaluate alternatives.';}
	else if($games['skill_id']=='63'){$skillhint='This skill reflects phonic and sight word recognition with images.';}
	
	?>

	
<div class="<?php echo $mathcolsize; ?> bounce">
<div class="box_c1 bounceIn animated" style="background-color:<?php echo $myskillpie_orginal[$games['skill_id']]; ?>;margin:0px;">
<div class="pricesaving"><?php echo $this->session->PlayTimes-$games['tot_game_played']; ?></div>
<h3 style="font-size: 25px;"><?php echo $actualGameCategory[$games['skill_id']]; ?> <a style="top:-5px;position:relative;" href="javascript:;" data-toggle="tooltip" data-placement="bottom" data-html="true" title='<div class=""><span style="font-size:12px;"><?php echo $skillhint; ?></span></div>'><i  style="color:black; font-size:16px;" class="fa fa-info-circle"></i></a></h3>
<?php
if($games['tot_game_score']==""){$games['tot_game_score']=0;}
if($games['tot_game_played']=="" || $games['tot_game_played']==0 ){$tot_game_played=1;}else{$myskillpie[$games['skill_id']]=$myskillpie_orginal[$games['skill_id']];$tot_game_played=$games['tot_game_played'];}
 
$avg_game_score=$games['tot_game_score'];
	if($avg_game_score < 20) $filled_stars = 0;
	if($avg_game_score >= 20 && $avg_game_score <= 40)	$filled_stars = 1;
	if($avg_game_score >= 41 && $avg_game_score <= 60)	$filled_stars = 2;
	if($avg_game_score >= 61 && $avg_game_score <= 80)	$filled_stars = 3;
	if($avg_game_score >= 81 && $avg_game_score <= 90)	$filled_stars = 4;
	if($avg_game_score >= 91 && $avg_game_score <= 100)	$filled_stars = 5;
	
$gameurl='';
/* if($this->session->game_grade==10 || $this->session->game_grade==9 || $this->session->game_grade==8)
{
	$gameurl = base_url()."assets/swf/".$this->session->userlang."/games.php?newgame=".$games['game_html']; 
}
else
{ 
	$gameurl = base_url()."assets/swf/".$this->session->userlang."/".$games['game_html'].".html"; 
} */	

$gameurl = base_url()."assets/swf/".$this->session->userlang."/games.php?newgame=".$games['game_html'];

?>
<?php 
if($sumoftottimeused<=$maxtimeofplay)
{ //Checking 30mins play time get over for the DAY
	if($games['tot_game_played']<$this->session->PlayTimes)
	{
		if($games['tot_game_played']==0)
		{	?>	
			<a class="fancybox fancybox.iframe imgactive"  id="<?php echo $games['gid']; ?>" href="<?php echo $gameurl; ?>" data-href="<?php echo base_url()."assets/swf/".$this->session->userlang."/".$games['game_html'].".html"; ?>"><img width="70%" src="<?php echo base_url(); ?>assets/<?php echo $games['img_path']; ?>"/></a>
		<?php
		}
		else
		{
			if($this->session->PlayTimes<=COUNT($PlayedSkillCount))
			{ ?>
					<a class="fancybox fancybox.iframe imgactive"  id="<?php echo $games['gid']; ?>" href="<?php echo $gameurl; ?>" data-href="<?php echo base_url()."assets/swf/".$this->session->userlang."/".$games['game_html'].".html"; ?>"><img width="70%" src="<?php echo base_url(); ?>assets/<?php echo $games['img_path']; ?>"/></a>
				
			<?php 
			}
			else
			{
			?>
				<a  href="javascript:;"><img width="70%" src="<?php echo base_url(); ?>assets/<?php echo $games['img_path']; ?>"/></a> 
			<?php 
			}
		}
	} 
	else
	{
	?>        
		<a  href="javascript:;"><img width="70%" src="<?php echo base_url(); ?>assets/<?php echo $games['img_path']; ?>"/></a> 
<?php 	
	}
}
else
{
?>
	<a  href="javascript:;"><img width="70%" src="<?php echo base_url(); ?>assets/<?php echo $games['img_path']; ?>"/></a>  
<?php 
} 
?>

<!--<p><?php //echo $games['gname']; ?></p>-->
<p style="background-color: #fff;box-shadow: 2px 0px 8px 2px rgb(183, 180, 180);">
 
<?php 
 for($i=0;$i<$filled_stars;$i++){ ?>
	 <img class="staractive" width="80%" src="<?php echo base_url(); ?>assets/images/icon_StarActive.gif">
 <?php } ?>
  <?php for($i=0;$i<5-$filled_stars;$i++){  ?>
	 <img class="starinactive" width="80%" src="<?php echo base_url(); ?>assets/images/icon_StarInActive.png">
 <?php } ?>
</p>

<?php 
if($sumoftottimeused<=$maxtimeofplay)
{ //Checking 30mins play time get over for the DAY
	if($games['tot_game_played']<$this->session->PlayTimes)
	{
		if($games['tot_game_played']==0)
		{
			if($games['tot_ques_attend']<=0)
			{
		?>
				<a class="btn btn-default in_btn fancybox fancybox.iframe btnactive" id="<?php echo $games['gid']; ?>" href="<?php echo $gameurl; ?>"  data-href="<?php echo base_url()."assets/swf/".$this->session->userlang."/".$games['game_html'].".html"; ?>"><span>Play</span></a>  
		<?php 
			}
			else
			{
			?> 
				<a class="btn btn-default in_btn fancybox fancybox.iframe btnactive" id="<?php echo $games['gid']; ?>" href="<?php echo $gameurl; ?>"  data-href="<?php echo base_url()."assets/swf/".$this->session->userlang."/".$games['game_html'].".html"; ?>"><span>Continue</span></a>  
			<?php
			}
		}
		else
		{ 
			if($this->session->PlayTimes<=COUNT($PlayedSkillCount))
			{
				if($games['tot_ques_attend']==0 || $games['tot_ques_attend']%10==0)
				{	
			?>
					<a class="btn btn-default in_btn fancybox fancybox.iframe btnactive" id="<?php echo $games['gid']; ?>" href="<?php echo $gameurl; ?>"  data-href="<?php echo base_url()."assets/swf/".$this->session->userlang."/".$games['game_html'].".html"; ?>"><span>Re-Play</span></a>  
			<?php
				}
				else
				{
				?>
					<a class="btn btn-default in_btn fancybox fancybox.iframe btnactive" id="<?php echo $games['gid']; ?>" href="<?php echo $gameurl; ?>"  data-href="<?php echo base_url()."assets/swf/".$this->session->userlang."/".$games['game_html'].".html"; ?>"><span>Continue</span></a>  
			<?php
				}
			}
			else
			{
			?> 
				<a class="btn btn-default in_btn gameBtnInactive btninactive" href="javascript:;">Locked</a>  

			<?php 
			}
		}
	}
	else 
	{
	?>        
		<a class="btn btn-default in_btn gameBtnInactive btninactive" href="javascript:;">Limit Expired</a>  
	<?php 
	}
}
else
{  ?>
	<a class="btn btn-default in_btn gameBtnInactive btninactive" href="javascript:;">Time Expired</a> 
<?php 
}
?>

</div>
</div>
<?php } ?>

<?php 
//if($this->session->game_grade!=12 && $this->session->game_grade!=13 && $this->session->game_grade!=14 && $this->session->game_grade!=15)
if($this->session->game_grade==100)
{?> 
<div class="<?php echo $mathcolsize; ?> MBody1"> 
<?php 
	foreach($arrofmath as $games)
	{	
		if($isEligibleToday==1)
		{ 
			$color="#673AB7"; 
			$Icon="fa fa-unlock";
			$lockid="UnLockGame";
		}
		else
		{
			$color="#673AB7";
			$Icon="fa fa-lock";
			$lockid="LockGame";
		}
	?> 

		<div id="" class="box_c1 bounceIn animated" style="background-color:<?php echo $color; ?>;margin:0px;">
		<div id="<?php echo $lockid; ?>" data-toggle="tooltip" data-placement="bottom" data-html="true" title="" data-original-title="<div class=''><span style='font-size:12px;'>Get your daily Math Puzzle! <br/>Complete all 5 skills, The math puzzle will enable for you..!</span></div>">
			<div id="text" ><i id="MPIcon" class="<?php echo $Icon; ?>" aria-hidden="true"></i></div>
		</div>
		<div class="pricesaving"><?php echo 5-$games['tot_game_played']; ?></div>
		<h3 style="font-size: 25px;">Math<a style="top:-5px;position:relative;" href="javascript:;" data-toggle="tooltip" data-placement="bottom" data-html="true" title='<div class=""><span style="font-size:12px;"><?php echo $skillhint; ?></span></div>'><i  style="color:black; font-size:16px;" class="fa fa-info-circle"></i></a></h3> 
			<?php
			 
			$avg_game_score=$games['tot_game_score'];
				if($avg_game_score < 20) $filled_stars = 0;
				if($avg_game_score >= 20 && $avg_game_score <= 40)	$filled_stars = 1;
				if($avg_game_score >= 41 && $avg_game_score <= 60)	$filled_stars = 2;
				if($avg_game_score >= 61 && $avg_game_score <= 80)	$filled_stars = 3;
				if($avg_game_score >= 81 && $avg_game_score <= 90)	$filled_stars = 4;
				if($avg_game_score >= 91 && $avg_game_score <= 100)	$filled_stars = 5;
				
			$gameurl='';
			$gameurl = base_url()."assets/swf/mathps/games.php?gamename=".$games['game_html']; 
			
			?>
			<?php 
			if($isEligibleToday==1)
			{
				if($sumoftottimeused<=$maxtimeofplay)
				{ //Checking 30mins play time get over for the DAY
					if($games['tot_game_played']<5)
					{?>	
						<a class="fancybox fancybox.iframe"  id="mathgame" href="<?php echo $gameurl; ?>" data-href="<?php echo base_url()."assets/swf/mathps/".$games['game_html'].".html"; ?>"><img width="70%" src="<?php echo base_url(); ?>assets/<?php echo $games['img_path']; ?>"/></a>
					<?php 
					} 
					else 
					{
					?>        
						<a  href="javascript:;"><img width="70%" src="<?php echo base_url(); ?>assets/<?php echo $games['img_path']; ?>"/></a>  
			<?php	}
				}
				else
				{ ?>
						<a  href="javascript:;"><img width="70%" src="<?php echo base_url(); ?>assets/<?php echo $games['img_path']; ?>"/></a>  
		<?php 	}
			}
			else
			{?>
				<a  href="javascript:;"><img width="70%" src="<?php echo base_url(); ?>assets/<?php echo $games['img_path']; ?>"/></a>  
	<?php	} 
			?>
			<!--<h3 style="" class="CanPlay"><?php echo $games['gamename']; ?></h3>-->
			<p style="background-color: #fff;box-shadow: 2px 0px 8px 2px rgb(183, 180, 180);">
				<?php
				 for($i=0;$i<$filled_stars;$i++){ ?>
					 <img class="staractive" width="80%" src="<?php echo base_url(); ?>assets/images/icon_StarActive.gif">
				 <?php } ?>
				  <?php for($i=0;$i<5-$filled_stars;$i++){  ?>
					 <img class="starinactive" width="80%" src="<?php echo base_url(); ?>assets/images/icon_StarInActive.png">
				 <?php } ?>
			</p>
			<?php 
			if($isEligibleToday==1)
			{
				if($sumoftottimeused<=$maxtimeofplay)
				{ //Checking 30mins play time get over for the DAY
					if($games['tot_game_played']==0)
					{?>
						<a class="btn btn-default in_btn fancybox  fancybox.iframe btnactive" id="mathgame" href="<?php echo $gameurl; ?>"  data-href="<?php echo base_url()."assets/swf/mathps/".$games['game_html'].".html"; ?>"><span>Play</span></a>  
					<?php 
					} 
					else if($games['tot_game_played']<5)
					{ ?>
						<a class="btn btn-default in_btn fancybox  fancybox.iframe btnactive" id="mathgame" href="<?php echo $gameurl; ?>"  data-href="<?php echo base_url()."assets/swf/mathps/".$games['game_html'].".html"; ?>"><span>Re-Play</span></a> 
					<?php }
					else 
					{?>        
						<a class="btn btn-default in_btn gameBtnInactive btninactive" href="javascript:;">Limit Expired</a>  
					<?php 
					} 
				} 
				else
				{  ?>
					<a class="btn btn-default in_btn gameBtnInactive btninactive" href="javascript:;">Time Expired</a> 
				<?php 
				} 
			}
			else
			{  ?>
					<a class="btn btn-default in_btn gameBtnInactive btninactive" href="javascript:;">Locked</a>
		<?php 
			} ?>
		</div>


<?php } ?>
</div>
<?php }
}
else
{ ?>
<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 text-center nodailypuzzles">
			<h3 class="">Play skillkit puzzles at least once. <br/> The regular puzzles will be  enabled only after completing the skillkit.</h3>
			<a href="<?php echo base_url("index.php/home/skillkit#View") ?>" title="SkillKit" > Go to SkillKit Puzzles</a>
		</div>
	</div>
<?php } ?>

</div>
</div> <!--Game part OVER -->
</div><!--/row -->
</div><!--/tab_sec_c1 -->
</div><!--/tab-pane -->
</div><!-- tab-content -->
</div><!-- panel-body -->
</div><!-- panel-default -->
 </div><!-- container -->
 </div><!-- section_four -->
 <div class="clear_both"></div>
</div><!----------------------------Dashboard Ajax End--------------------------------------->


<?php 
if($this->session->IsBspiTopper==1 || $this->session->IsCrowniesTopper==1 || (isset($this->session->B59) || isset($this->session->B60) || isset($this->session->B61) || isset($this->session->B62) || isset($this->session->B63)))
{
?>
	<!--<div class="row">
		<div class="ViewBadges">
			<a href="<?php echo base_url("index.php/home/profile"); ?>" class="badge" id="badge" />Semester - 1 Rewards</a>
		</div>
	</div>-->
<?php 
}
?>


<div class="clear_both"></div>
<div class="section_five">
<div class="container">
<div class="row">

<div class="col-md-6 col-sm-12 col-xs-12">
<div class="calc_L">
<div class="calendarheading">
<h3>My Daily Planner</h3>
</div>
<div id="my-calendar"></div>
<ul>
<li>Note : Click on marked dates to view their current day score details</li>
<li><div style="background-color: #1e88e5;border-radius: 50%;border: 1px solid #1e88e5;width: 15px;height: 15px;display: inline-block;"></div> <p>Brain trained</p></li>

</ul>
<!---<div class="calendar">

</div>-->
</div>
</div>
<div class="col-md-6 col-sm-12 col-xs-12"  id="MySkillPie">
<div class="circle_sec">
<h3 style="text-align: center; font-size:20px;">My Skill Pie for the Day</h3>
<!--<ul>
<li><img src="<?php echo base_url(); ?>assets/images/bullet_Memory.png"/> <p>Memory</p></li>
<li class="pad_v2"><img src="<?php echo base_url(); ?>assets/images/bullet_VisualProcessing.png"/> <p>Visual Processing</p></li>
<li><img src="<?php echo base_url(); ?>assets/images/bullet_FocusandAttention.png"/> <p>Focus & Attention</p></li>
<li><img src="<?php echo base_url(); ?>assets/images/bullet_ProblemSolving.png"/> <p>Problem Solving</p></li>
<li><img src="<?php echo base_url(); ?>assets/images/bullet_Linguistics.png"/> <p>Linguistics</p></li>
</ul>-->
<div class="panel panel-default" >
                        <div class="panel-body">
					<div class="reportChartContainer1">
                            <div class="cb">
                            	<p class="PskillName pt0">Memory</p>
                                	
                            	<div class="meter mt10">
                                	<span class="redColor" id="memscore"></span>
								</div>
                            </div>
                            <div class="cb">
                            	<p class="PskillName">Visual Processing</p>
                            	<div class="meter mt10">
  									<span class="yellowColor" id="vpscore"></span>
								</div>
                            </div>
                            <div class="cb">
                            	<p class="PskillName">Focus & Attention</p>
                            	<div class="meter mt10">
  									<span class="greenColor" id="focusscore"></span>
								</div>
                            </div>
                            <div class="cb">
                            	<p class="PskillName">Problem Solving</p>
                            	<div class="meter mt10">
  									<span class="orangeColor" id="problemscore"></span>
								</div>
                            </div>
                            <div class="cb">
                            	<p class="PskillName">Linguistics</p>
                            		<div class="meter mt10">
  										<span class="blueColor" id="lingscore"></span>
									</div>
                            </div>
                     </div>
				
				</div>
				</div>
				
</div>
<div class="circle_sec_C1">
<div class="col-md-8 col-sm-8 col-xs-8">
<?php 
/* $month= date("n");
$year=date("Y");
$day=date("d");
$endDate=date("t",mktime(0,0,0,$month,$day,$year)); */

//date_default_timezone_set("Australia/Hobart");

$date = DateTime::createFromFormat("Y-m-d", $this->session->astartdate);
$date1 = $this->session->astartdate;
$date2 = $this->session->aenddate;
$ts1 = strtotime($date1);
$ts2 = strtotime($date2);
$year1 = date('Y',$ts1);
$year2 = date('Y',$ts2);
$month1 = date('m',$ts1);
$month2 = date('m',$ts2);
$aaa = (($year2 - $year1) * 12) + ($month2 - date('m'));
//echo $year1;
if($month1==date('m'))
{
	$currmonth=$date->format("m");
	$curryear=$date->format("Y");
	$monval=0;
}
else if($month2>=date('m') && $aaa==1)
{
	$currmonth=date('m');
	$curryear=date('Y');
	$monval=$month2-$currmonth;
}
else if($aaa<0)
{
	$currmonth=$date->format("m");
	$curryear=$date->format("Y");
	$monval=0;
}
else
{
	$currmonth=date('m');
	$curryear=date('Y');
	$monval=$month2-$month1;
}

$datetime1 = date_create($date1);
$datetime2 = date_create(date('Y-m-d'));
$Pinterval = date_diff($datetime1, $datetime2);
 

$edatetime1 = date_create(date('Y-m-d'));
$edatetime2 = date_create($date2);
$Einterval = date_diff($edatetime1, $edatetime2);

			
?>

<!--<div id="container" style="height: 400px"></div>-->
<script src="<?php echo base_url(); ?>assets/js/zabuto_calendar.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/zabuto_calendar.min.css">
<script>

function cal(arug)
{ 
	$.ajax({
	type: "POST",
	url: "<?php echo base_url()."index.php/home/playeddates"; ?>",
	dataType:"json",
	success: function(result){ //alert('<?php echo $aaa; ?>');
		/* alert(result); */
		$(arug).html('');
		$(arug).zabuto_calendar({
	
			 cell_border: true,
			 data: result,
			cell_border: true,
			today: true,
			show_days: true,
			year: <?php echo $curryear; ?>,
			month: <?php echo $currmonth; ?>,
			show_previous: <?php echo $Pinterval->format('%m'); ?>,
			show_next: <?php echo $Einterval->format('%m'); ?>,
			 action: function () { //alert(this.id);
					 return myDateFunction(this.id, false);
             },
		 
		 
	});
	}
	});
}

function myDateFunction(id, fromModal) {
	
        $("#date-popover").hide();
        if (fromModal) {
            $("#" + id + "_modal").modal("hide");
        }
        var date = $("#" + id).data("date");
		var hasEvent = $("#" + id).data("hasEvent");
		if (hasEvent) 
		{
			$('#loadingimage').show();
			$.ajax({
			type: "POST",
			url: "<?php echo base_url()."index.php/home/getTrainingCalendarData"; ?>",
			data: {curdate:date},
			dataType: "json",
			success: function(result){
			//	alert(result);
					$("#curday").html('Daily Score : '+result.Curday);
					$("#mem").html(result.MEMORY);					
					$("#vp").html(result.VISUAL);				
					$("#focus").html(result.FOCUS);
					$("#problem").html(result.PROBLEM);
					$("#ling").html(result.LING);
					
					if(result.MEMORY<=8){var memwid='10';}else{var memwid=result.MEMORY;}
					if(result.VISUAL<=8){var vpwid='10';}else{var vpwid=result.VISUAL;}
					if(result.FOCUS<=8){var fawid='10';}else{var fawid=result.FOCUS;}
					if(result.PROBLEM<=8){var pbwid='10';}else{var pbwid=result.PROBLEM;}
					if(result.LING<=8){var liwid='10';}else{var liwid=result.LING;}
					
					$("#mem").css("width", memwid+'%');
					$("#vp").css("width", vpwid+'%');					
					$("#focus").css("width", fawid+'%');					
					$("#problem").css("width", pbwid+'%');
					$("#ling").css("width", liwid+'%');
					
					
					$("#CURScore").html(result.BSPI);
					
					guagechart(result.BSPI);
					var sco =parseFloat(result.BSPI).toFixed(2); 
					$('#score').html(sco);
					
					$("#CURCrownies").html(result.Crownies);
					$("#CURPuzzlesAttempted").html(result.PuzzlesAttempted);
					$("#CURPuzzlesSolved").html(result.PuzzlesSolved);
					$("#CURMinutesTrained").html(result.MinutesTrained);
					$('#todayModal').modal('show'); 
				//	$('#jobprofile').modal('show'); 
					$('#loadingimage').hide();
			}
			});	
		}
		
}

function guagechart(score)
			{
			
	FusionCharts.ready(function () {
    var csatGauge = new FusionCharts({
        "type": "angulargauge",
        "renderAt": "chart-container","background":"transparent",
        "width": "100%",
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
                "value": score,
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



// $(function () {});
</script>
<!-- <img src="<?php echo base_url(); ?>assets/images/circle.png"/>-->
</div>
</div>
</div>
</div><!-- row -->
</div> <!-- container -->	
</div>	<!-- section_five -->	
 
 <div class="clear_both"></div>	
 <div class="section_six">
 <div class="container">
<div class="row">

<div class="col-md-7 col-sm-7 col-xs-9">
<div class="trophies_L">
<h2>How can I get stars and trophies?</h2>
<p>Stars are awarded to the users based on the scores of each games played.</p>
<p>Stars Awarded on a given day. <b>Based on score obtained in the game or based on average score in the game. Every day the stars are refreshed.</b></p>
<p>Trophies are awarded based on the no of stars earned in each skill for the current month.</p>
</div>
</div>
<!--<div class="col-md-3 col-sm-3 col-xs-12">
<div class="trophies_R">
<img src="<?php echo base_url(); ?>assets/images/howCanIgetStars.png"/>
</div>
</div>-->

</div><!-- row -->
</div> <!-- container -->	
 </div><!-- section_six -->
 
 
<div class="clear_both"></div>	
 <div class="section_seven" id="Mytrophies">
 <h2>My trophies <a style="top:-5px;position:relative;" href="javascript:;" data-toggle="tooltip" data-placement="bottom" data-html="true" title='<div class=""><span style="font-size:12px;">These trophies are based on the number of stars you receive after each game. Get more stars daily and upgrade your trophy</span></div>'><i  style="color:black; font-size:16px;" class="fa fa-info-circle"></i></a></h2>
 <div class="container">
<div class="row">

<div class="col-md-2 col-sm-2 col-xs-12">
<img src="<?php echo base_url(); ?>assets/images/home/awardsboy.png"/>
</div>
<?php
foreach($trophies as $tro)
				{ 
					//print_r($tro);
					$mainclass='';
					$innerclass='';
					
					 
			?>
<div class="col-md-2 col-sm-12 col-xs-12">
<div class="award_sec <?php echo "cls".$tro['catid']; ?>" >
<?php if($tro['diamond'] > 0)
{ echo '<div class="platinum"></div>'; }
else{ echo '<div class="platinum-inactive"></div>';}
if($tro['gold'] > 0)
{ echo '<div class="gold"></div>';}
else{ echo '<div class="gold-inactive"></div>';}
if($tro['silver'] > 0)
{ echo '<div class="silver"></div>'; }
else{ echo '<div class="silver-inactive"></div>';}

 ?>
</div>
<p class=""><?php  echo $tro['name'];?></p>
</div>
<?php } ?>
</div><!-- row -->
</div> <!-- container -->	
 </div><!-- section_seven -->	

<div class="clear_both"></div>	
<div class="loader" style=" display: none; "></div>
<div id="loadingimage" style="display:none;" class="loading"></div>

<script src="<?php echo base_url(); ?>assets/js/highcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/js/highcharts-3d.js"></script>
<script src="<?php echo base_url(); ?>assets/js/exporting.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	fancyCall();
	cal("#my-calendar");
	MySkillPie();
	//MyJobProfile();
});
$(".btnactive").click(function(){
	/* $(this).hide(); */
	$(this).addClass('inactiveLink');
});
$(".imgactive").click(function(){
	/* $(this).hide(); */
	$(this).addClass('inactiveLink');
});

function fancyCall()
{//alert("hi");
$("a.fancybox").each(function() {
var tthis = this;
$(this).fancybox({
'transitionIn'    :    'elastic',
'transitionOut'    :    'elastic',
'speedIn'     :    600,
'speedOut'     :    200,
'overlayShow'    :    false,
/* 'width'  : 750,           // set the width
'height' : 500, */           // set the height
'type'   : 'iframe',       // tell the script to create an iframe
'scrolling'   : 'no',
'idleTime': false,
/* 'href'          : $(this).attr('data-href'), */
helpers     : { 
	overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
},
keys : {
	// prevents closing when press ESC button
	close  : null
},
'afterClose': function () { //alert($("#hdnsparkiespoints").val());
//$('#loadingimage').show();

//$('a.fancybox').show();
$('a.fancybox').removeClass('inactiveLink');

if($("#hdnsparkiespoints").val()!='' || $("#hdnsparkiespoints").val()!=0)
{ 	$("#visiblepoints").text('wow! You have gained ' + $("#hdnsparkiespoints").val() + ' Crownies today!');
	$('#loadingimage').show();
	$.ajax({
			type: "POST",
			url: "<?php echo base_url()."index.php/home/dashboard_ajaxnew"; ?>",
			data: {gameid:tthis.id},
			success: function(result){
				 $('#dashboard_ajax').html(result);
				 //
				 MySkillPie();
				 $('#loadingimage').hide();
				if($("#hdnsparkiespoints").val()!='' && $("#hdnsparkiespoints").val()!=0 && $("#hdnsparkiespoints").val()!='SI')
				{
				  //if(typeof  sparkies !== 'undefined'){sparkies();}
				  <!-- Sparkies Start -->
					$(".loader").show();
					var cart = $('.points-cart-img');
					var imgtodrag = $("#sparkiesimg").eq(0); //console.log(imgtodrag);
					var points=$("#sparkiespoints").text();
					//var imgtodrag = $(this).parent('.bounceIn').find("img").eq(0);
					console.log("Crowny working"+$("#sparkiespoints").text());
					if (imgtodrag) {
						var imgclone = imgtodrag.clone()
							.offset({
							top: "350",
							left: "550"
						})
							.css({
							'opacity': '0.9',
								'position': 'absolute',
								'height': '150px',
								'width': '150px',
								'z-index': '99999',
								/*'background':'#fafafa',
								 'width':'100%',
								'height':'100%', 
								 'left': '0px',
								 'top': '0px',
								'bottom': '0',
								'right': '0'*/
								

						})
							.appendTo($('body'))
							.animate({
								'top': cart.offset().top + 10,
								'left': cart.offset().left + 10,
								'width': 200,
								'height': 200
						}, 2000, 'easeInOutExpo');
						
						setTimeout(function () {
							cart.effect("shake", {
								times: 2
							}, 200);
							
						}, 1500);

						imgclone.animate({
							'width': 0,
								'height': 0
						}, function () {
							$(this).detach();
							$(".loader").hide();
							if($("#hdnsparkiespoints").val()!='' && $("#hdnsparkiespoints").val()!='0')
							{   var total_skyangels=$('#skyangelspoints').text();
								var current_skyangels=$("#hdnsparkiespoints").val();
								//alert(parseInt(total_skyangels)+parseInt(current_skyangels));
								$('#skyangelspoints').text(parseInt(total_skyangels)+parseInt(current_skyangels));
								$("#hdnsparkiespoints").val('');
								$("#visiblepoints").val('');
								
								HappyBirthday();
								cal('.zabuto_calendar');
								//Celebration();
							}
							
						});
						
						
					}
					<!-- Sparkies End -->				 
				}
				  MyCurrentBsbi();
				  //MyCurrentMsbi();
				  //TodayMathPuzzleEligible();
				  UpdateTodaySession();
				  MyCurrenttrophies();
			//	  MyJobProfile();
				fancyCall();
			}
	});	
}
},
beforeShow : function(){
/* Check User Login */
		LoginAjaxCall();
/* Check User Login */	
$(".fancybox-inner").addClass("fancyGameClass");

if(tthis.id=='mathgame')
	{
		$.ajax({
				type: "POST",
				url: "<?php echo base_url()."index.php/home/mathgamesajax"; ?>",
				data: {gameid:tthis.id,skillkit:'N',gameurl:$(tthis).attr('data-href')},
				success: function(result)
				{
					if($.trim(result)=='IA')
					{
						$.fancybox.close();
					}
				}
			});
	}
	else
	{
$.ajax({
type: "POST",
url: "<?php echo base_url()."index.php/home/gamesajax"; ?>",
data: {gameid:tthis.id,skillkit:'N',gameurl:$(tthis).attr('data-href')},

success: function(result){
	//console.log("this is IA"+result);
 if($.trim(result)=='IA')
{
	$.fancybox.close();
}
}
});

	}
}
});
});
} // FancyBox Close Event
function MyCurrentMsbi()
{ /* alert("MyCurrentBsbi"); */
	$.ajax({
	type: "POST",
	url: "<?php echo base_url()."index.php/home/MyCurrentMspi"; ?>",
	data: {},
	success: function(result){
			$("#currentMSPI").text(result);
	}
	});	
}
function UpdateTodaySession()
{ /* alert("UpdateTodaySession"); */
	$.ajax({
	type: "POST",
	url: "<?php echo base_url()."index.php/home/UpdateTodaySession"; ?>",
	data: {},
	success: function(result)
	{
		if(result==1)
		{
			<?php if($skillkitenable[0]['isenable']>0)
			{
			?>
				$('#GotoSkillkitPuzzles').modal({backdrop: 'static', keyboard: false}) ;
			<?php
			}
			?>
		}
	}
	});	
}
function MyCurrentBsbi()
{ /* alert("MyCurrentBsbi"); */
$.ajax({
type: "POST",
url: "<?php echo base_url()."index.php/home/mycurrentbspi"; ?>",
data: {},
success: function(result){
		$("#currentBSPI").text(result);
}
});	
}
function MyCurrenttrophies()
{
$.ajax({
type: "POST",
url: "<?php echo base_url()."index.php/home/MyCurrenttrophies"; ?>",
data: {},
success: function(result){
		$("#Mytrophies").html(result);
}
});	
}
function MySkillPie()
{ 
//var date = <?php echo date('Y-m-d'); ?>;
$.ajax({
type: "POST",
url: "<?php echo base_url()."index.php/home/overallskillscore"; ?>",
data: {},
dataType: "json",
success: function(result){
	//alert(result);
	//console.log("Testing");
		//$("#MySkillPie").html(result);
		
		//$("#curday_D").html('Daily Score : '+result.Curday);
		$("#memscore").html(result.SID59);
			if(result.SID59<=0)
			{
				$("#memscore").css("width",'7%');
			}
			else
			{
				$("#memscore").css("width", result.SID59+'%');
			}
			$("#vpscore").html(result.SID60);
			if(result.SID60<=0)
			{
				$("#vpscore").css("width",'7%');
			}
			else
			{
				$("#vpscore").css("width", result.SID60+'%');
			}
			$("#focusscore").html(result.SID61);
			if(result.SID61<=0)
			{
				$("#focusscore").css("width",'7%');
			}
			else
			{
				$("#focusscore").css("width", result.SID61+'%');
			}
			$("#problemscore").html(result.SID62);
			if(result.SID62<=0)
			{
				$("#problemscore").css("width",'7%');
			}
			else
			{
				$("#problemscore").css("width", result.SID62+'%');
			}
			$("#lingscore").html(result.SID63);
			if(result.SID63<=0)
			{
				$("#lingscore").css("width",'7%');
			}
			else
			{
				$("#lingscore").css("width", result.SID63+'%');
			}
					/* $("#memscore").html(result.SID59);
					$("#memscore").css("width", result.SID59+'%');
					$("#vpscore").html(result.SID60);
					$("#vpscore").css("width", result.SID60+'%');
					$("#focusscore").html(result.SID61);
					$("#focusscore").css("width", result.SID61+'%');
					$("#problemscore").html(result.SID62);
					$("#problemscore").css("width", result.SID62+'%');
					$("#lingscore").html(result.SID63);
					$("#lingscore").css("width", result.SID63+'%'); */
}
});	
}

</script>
<script>

</script>


<style>
.panel-footer { display:none;}	
.inactiveLink {
   pointer-events: none;
   cursor: default;
}
</style>
<!-- Full Image Fade OUT --><script src="<?php echo base_url(); ?>assets/js/imagefade/parallax.min.js"></script>
<script type="text/javascript">
$(function(){
 slider = $("#slider1").slideReveal({
          // width: "100px",
          push: false,
          position: "right",
          speed: 600,
          trigger: $("#trigger1"),
          // autoEscape: false,
          overlay: true,
          top: 100,
          overlayColor: 'rgba(19, 17, 17, 0.498039)',
		  shown: function(slider, trigger){
			//alert("After opened!");
		  },
		  hidden: function(slider, trigger){
			$("#trigger2").show();
			$("#trigger1 .glyphicon").removeClass('glyphicon-chevron-right');
			$("#trigger1 .glyphicon").addClass('glyphicon-chevron-left');
		  }, 
		  show: function(slider, trigger){
			$("#trigger2").hide();
			$("#trigger1 .glyphicon").removeClass('glyphicon-chevron-left');
			$("#trigger1 .glyphicon").addClass('glyphicon-chevron-right');
		  },
		  /*  hidden: function(slider, trigger){
		 	$("#trigger3").show();
			$("#trigger1 .glyphicon").removeClass('glyphicon-chevron-right');
			$("#trigger1 .glyphicon").addClass('glyphicon-chevron-left');
		  }, 
		  show: function(slider, trigger){
			$("#trigger3").hide();
			$("#trigger1 .glyphicon").removeClass('glyphicon-chevron-left');
			$("#trigger1 .glyphicon").addClass('glyphicon-chevron-right');
		  }, */ 
		  hide: function(slider, trigger){
			
		  }
        });
slider2 = $("#slider2").slideReveal({
          // width: "100px",
          push: false,
          position: "right",
          speed: 600,
          trigger: $("#trigger2"),
          // autoEscape: false,
          overlay: true,
          top: 100,
          overlayColor: 'rgba(19, 17, 17, 0.498039)',
		  shown: function(slider2, trigger){
			//alert("After opened!");
		  },
		  hidden: function(slider2, trigger){
			$("#trigger1").show();
			$("#trigger2 .glyphicon").removeClass('glyphicon-chevron-right');
			$("#trigger2 .glyphicon").addClass('glyphicon-chevron-left');
		  }, 
		  show: function(slider2, trigger){
			$("#trigger1").hide();
			$("#trigger2 .glyphicon").removeClass('glyphicon-chevron-left');
			$("#trigger2 .glyphicon").addClass('glyphicon-chevron-right');
		  },
		 /*   hidden: function(slider2, trigger){
			$("#trigger3").show();
			$("#trigger2 .glyphicon").removeClass('glyphicon-chevron-right');
			$("#trigger2 .glyphicon").addClass('glyphicon-chevron-left');
		  },
		  
		 
		   show: function(slider2, trigger){
			$("#trigger3").hide();
			$("#trigger2 .glyphicon").removeClass('glyphicon-chevron-left');
			$("#trigger2 .glyphicon").addClass('glyphicon-chevron-right');
		  }, */
		   hide: function(slider2, trigger){
			
		  },
        });
		
		/* slider3 = $("#slider3").slideReveal({
          // width: "100px",
          push: false,
          position: "right",
          speed: 600,
          trigger: $("#trigger2"),
          // autoEscape: false,
          overlay: true,
          top: 100,
          overlayColor: 'rgba(19, 17, 17, 0.498039)',
		  shown: function(slider3, trigger){
			//alert("After opened!");
		  },
		  hidden: function(slider3, trigger){
			$("#trigger3").show();
			$("#trigger2 .glyphicon").removeClass('glyphicon-chevron-right');
			$("#trigger2 .glyphicon").addClass('glyphicon-chevron-left');
		  }, 
		  show: function(slider3, trigger){
			$("#trigger3").hide();
			$("#trigger2 .glyphicon").removeClass('glyphicon-chevron-left');
			$("#trigger2 .glyphicon").addClass('glyphicon-chevron-right');
		  },
		  hide: function(slider3, trigger){
			
		  }
        });  */
});
</script>

<script src="<?php echo base_url(); ?>assets/js/hover/jquery.slidereveal.min.js"></script>
<script type="text/javascript">
var track_page = 1; //track user scroll as page number, right now page number is 1
var loading  = false; //prevents multiple loads
load_mine(track_page,'MINE'); //initial content load
load_all(track_page,'ALL'); //initial content load
$("#newsfeed").scroll(function() {
	//alert($("#newsfeed").scrollTop()+"=="+$("#newsfeed").height()+"=="+$("#newsfeed").height());
    if($("#newsfeed").scrollTop()+40 >= $("#newsfeed").height()) { 	
        track_page++; //page number increment
        load_contents(track_page,$("#feedtypeval").val()); //load content   
    }
}); 
$("#trigger1").click(function(){ //alert("MINE");
	$("#hdnnewsfeedall").val($("latestminecount").val());
	$("#new_newsfeed_minecount").text('');
	load_mine(track_page,'MINE');
}); 
$("#trigger2").click(function(){ //alert("All");
	$("#hdnnewsfeedmine").val($("latestallcount").val());
	$("#new_newsfeed_allcount").text('');
	load_all(track_page,'ALL');
}); 
 /* $("#trigger3").click(function(){ //alert("Job profile");
	$("#hdnjobprofile").val($("latestjobprofile").val());
	$("#new_jobprofile").text('');
	load_all(track_page,'ALL');
}); */       

//Ajax load function
function load_mine(track_page,type){  $("#resultsmine").show();  //alert(type);
    if(loading == false){
        //loading = true;  //set loading flag on
        $('.loading-info').show(); //show loading animation 
        $.post('fetchnewsfeed',{'page': track_page,'type':type}, function(data){
            loading = false; //set loading flag off once the content is loaded
            if(data.trim().length == 0){
                //notify user if nothing to load
                $('.loading-info').html("No more records!");
                return;
            }
            $('.loading-info').hide(); //hide loading animation once data is received
            $("#resultsmine").html(data); //append data into #results element 
        
        }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
            $('.loading-info').html("error!");//alert with HTTP error
        })
    }
}
//Ajax load function
function load_all(track_page,type){ $("#resultsall").show();  //alert(type);
    if(loading == false){
        loading = true;  //set loading flag on
        $('.loading-info').show(); //show loading animation 
        $.post('fetchnewsfeed',{'page': track_page,'type':type}, function(data){
            loading = false; //set loading flag off once the content is loaded
            if(data.trim().length == 0){ alert(data);
                //notify user if nothing to load
                $('.loading-info').html("No more records!");
                return;
            }
            $('.loading-info').hide(); //hide loading animation once data is received
            $("#resultsall").html(data); //append data into #results element
        
        }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
            $('.loading-info').html("error!");//alert with HTTP error
        })
    }
}

 
/* function load_all(track_page,type){ $("#resultsjob").show();  //alert(type);
    if(loading == false){
        loading = true;  //set loading flag on
        $('.loading-info').show(); //show loading animation 
        $.post('fetchnewsfeed',{'page': track_page,'type':type}, function(data){
            loading = false; //set loading flag off once the content is loaded
            if(data.trim().length == 0){ alert(data);
                //notify user if nothing to load
                $('.loading-info').html("No more records!");
                return;
            }
            $('.loading-info').hide(); //hide loading animation once data is received
            $("#resultsjob").html(data); //append data into #results element
        
        }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
            $('.loading-info').html("error!");//alert with HTTP error
        })
    }
} */
 



$(document).ready(function(){	  	 
	//getNewsfeedcountAjax();	
	$(".slider").show();
	//setInterval(function(){getNewsfeedcountAjax();}, 1000*60);  // 1000 = 1 second, 3000 = 3 seconds	
});	

function getNewsfeedcountAjax()
{
	 $.ajax({
		url: "fetchnewsfeedcount",
		dataType:"json",
		success: function(data) {
			$("latestminecount").val(data.OUTALLCOUNT);
			$("latestallcount").val(data.OUTMINECOUNT);
	//		$("latestjobprofile").val(data.OUTJOBPROFILE);
			var latestallnewsfeedcount=parseInt(data.OUTALLCOUNT)-parseInt($("#hdnnewsfeedall").val());
			var latestminenewsfeedcount=parseInt(data.OUTMINECOUNT)-parseInt($("#hdnnewsfeedmine").val());
		//	var latestminenewsfeedcount=parseInt(data.OUTMINECOUNT)-parseInt($("#hdnnewsfeedmine").val());
			//alert(latestallnewsfeedcount+"=="+latestminenewsfeedcount);
			if(latestallnewsfeedcount>0){
				$("#new_newsfeed_allcount").text('('+latestallnewsfeedcount+')');
			}
			if(latestminenewsfeedcount>0){
				$("#new_newsfeed_minecount").text('('+latestminenewsfeedcount+')');
			}			
		}
	});
}
</script>
<?php
if($this->session->TimerRunningStatus=='Y')
{
?>
<script type="text/javascript">
		var clock;		
		$(document).ready(function() {
			var clock;
			clock = $('.clock').FlipClock({
		        clockFace: 'MinuteCounter',
		        autoStart: false,
		        callbacks: {
		        	stop: function() { //alert("JJ");
					logincheck_ajxcall();
		        		$.ajax({
							type:"POST",
							url:"<?php echo base_url('index.php/home/TodayTimerInsert') ?>",
							success:function(result)
							{	//alert(result);
								
									$.ajax({
									type: "POST",
									url: "<?php echo base_url()."index.php/home/dashboard_ajaxnew"; ?>",
									data: {},
									success: function(result){
										 $('#dashboard_ajax').html(result);
$("#TodayTimer").html('<div class="col-md-12 col-sm-12 col-xs-12 panel"><div class="col-md-4 col-sm-4 col-xs-12"><div class="row"><h2>Todays Puzzles </h2></div></div><div class="col-md-8 col-sm-8 col-xs-12 warninglabel"><div class="row"><i class="fa fa-hourglass-end faa-flash animated" aria-hidden="true"></i> Hope you enjoyed learning the fun way.<strong> See you in the next session. . . </strong><i class="fa fa-thumbs-o-up faa-bounce animated"></i></div></div></div>');
									}
									});
							}
						});
		        	}
		        }
			
		    });
				 
		    //clock.setTime(1800);
			clock.setTime(<?php echo $Remainingtime;?>);
		    clock.setCountdown(true);
		    clock.start();
			//alert("AAA"+a);
		}); 
		
		$("#fdbkform").validate({
		
		rules : {
               // fdbksubject : {required:true},
				qone : {required:true},
				qtwo : {required:true},
				qthree : {required:true}
				//skillname : {required:true}
            },
			
		messages: {
            "qone": {required: "Please select any one"},
			"qtwo": {required: "Please select any one"},
			"qthree": {required: "Please select any one"}
			//"skillname": {required: "Please select any one"}
           
        },
		
		
		errorPlacement: function(error, element) {
    if (element.attr("type") === "radio") {
        error.insertAfter(element.parent().parent());
    } 
	else if (element.attr("type") === "checkbox") {
        error.insertAfter(element.parent().parent());
    } 
	else {
        error.insertAfter(element);
    }
	
},
		highlight: function(input) {
           // $(input).addClass('error');
        } 
    });
		
		$('#fdbksubmit').click(function(){
			
			
			//alert(val);
			if($("#fdbkform").valid()==true)
		{
			
			var qone = $('input[name=qone]:checked').val();
			var qtwo = $('input[name=qtwo]:checked').val();
			var qthree = $('input[name=qthree]:checked').val();
			//var skillname = $('.skillname').val();
			var usercmnt = $('#usercmnt').val();
			
			var form = $('#fdbkform')[0];
			var formData = new FormData(form);
			// var skillname = [];
        // $(':checkbox:checked').each(function(i){
          // skillname[i] = $(this).val();
        // });
			// alert(skillname);
$.ajax({
type:"POST",
					data:formData,
					contentType: false,       
					cache: false,             
					processData:false, 
url: "<?php echo base_url()."index.php/home/userfdbk"; ?>",
//data: {qone:qone,qtwo:qtwo,qthree:qthree,skillname:skillname,usercmnt:usercmnt},

success: function(result){
	//console.log("this is IA"+result);
 if(result==1)
{
	$("#successmsg").html('Thanks for your feedback');
	//$("#fdbkform")[0].reset();
	$("#fdbkform").hide();
	window.location.href="<?php echo base_url(); ?>index.php/home/dashboard";
}
}
});
		}
		});
		
		
		/*******Teachers Feedback FORM*******/
		
		$("#tfdbkform").validate({
		
		rules : {
               // fdbksubject : {required:true},
				tqone : {required:true}
				//tusercmnt : {required:true}
				//skillname : {required:true}
            },
			
		messages: {
            "tqone": {required: "Please select any one"}
			//"tusercmnt": {required: "Please add your comments"}
           
        },
		
		
		errorPlacement: function(error, element) {
    if (element.attr("type") === "radio") {
        error.insertAfter(element.parent().parent());
    } 
	else if (element.attr("type") === "checkbox") {
        error.insertAfter(element.parent().parent());
    } 
	else {
        error.insertAfter(element);
    }
	
},
		highlight: function(input) {
           // $(input).addClass('error');
        } 
    });
		
$('.tfdbksubmit').click(function(){


//alert(val);
if($("#tfdbkform").valid()==true)
{

var tqone = $('input[name=qone]:checked').val();
//var skillname = $('.skillname').val();
var tusercmnt = $('#usercmnt').val();

var form = $('#tfdbkform')[0];
var formData = new FormData(form);

$.ajax({
type:"POST",
data:formData,
contentType: false,       
cache: false,             
processData:false, 
url: "<?php echo base_url()."index.php/home/tuserfdbk"; ?>",
//data: {qone:qone,qtwo:qtwo,qthree:qthree,skillname:skillname,usercmnt:usercmnt},

success: function(result){
//console.log("this is IA"+result);
if(result==1)
{

$("#tfdbkform").hide();
$(".tfdimg").hide();
$("#tsuccessmsg").show();
}
else { $("#teachersmodal").hide(); 
	   $('#teachersmodal').modal('hide'); 
	   }
}
});
}
});
//$('#skyangelspoints').sparkleHover(); 
</script>
<?php 
}
?>
<script src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.js"></script>
<script src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.theme.fint.js"></script>
<script src="<?php echo base_url(); ?>assets/fusioncharts/js/fusioncharts.widgets.js"></script>

<div class="modal fade" data-easein="bounceIn" id="Mathmodal" role="dialog">
    <div class="modal-dialog mathpopup">    
      <!-- Modal content-->
      <div class="modal-content1 math-content">
        <div class="modal-header bodernone" >
			<!--<button type="button" class="close" data-dismiss="modal" style="opacity: 1;font-size: 29px;">&times;</button>-->
			<h3 class="modal-title math-title">Math Puzzles</h3>
		</div>
        <div class="modal-body ">	
			<h3 class="modal-title" style="text-align:center;padding-bottom:0">Math puzzles unlocked for you.</h3>
					
        </div>
      </div>
	  <a href="javascript:;" class="btn btn-success"   id="MathPopup" >Go to math puzzle</a>		
    </div>
</div>
<script>
//TodayMathPuzzleEligible();
function TodayMathPuzzleEligible()
{ /* Open Math Puzzle Menu*/
var MathGameCount='<?php echo $arrofmath[0]['tot_game_played']; ?>'; 
 
	$.ajax({
	type: "POST",
	url: "<?php echo base_url()."index.php/home/MathPuzzleEligible"; ?>",
	data: {},
	success: function(result){ 
		if(result==5 && MathGameCount==0)
		{
			//$('#Mathmodal').modal('show');
			$("#MP").removeClass('LockMP');
			$("#MP").addClass('UnlockMP');
			
			$("#MPIcon").removeClass('fa fa-lock');
			$("#MPIcon").addClass('fa fa-unlock lockbounce');
			
			$("#MP").attr('data-original-title',"<div class=''><span style='font-size:12px;'>Now you can play math puzzle.</span></div>");
		}
	}
	});	
}
</script>
<div id="mySidenav" class="sidenav">
	<div class="<?php echo $clsname; ?>">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="fa fa-window-close" aria-hidden="true"></i></a>
	</div>
	<div class="container">
		<div class="col-md-12 col-sm-12 col-xs-12 starclsnew" style="">
			 <div id="MathPuzzles"></div>
			 <div id="IssetFirstTime"></div>
		</div>	
	</div>	
</div> 
<script> 
	$(document).on("click","#MathPopup",function()
	{
		$(".close").click();
		/* openNav(); */
	});
	/* 
	$(document).on("click",".UnlockMP",function()
	{
		openNav();
	});
	function openNav() 
	{		
		$("#MP").css("z-index","99");
		OpenMathPuzzles();
		document.getElementById("mySidenav").style.width = "100%";
		$('body').css('overflow','hidden'); // Webkit browsers

	}
	function closeNav() 
	{
		$("#MP").css("z-index","999999");
		document.getElementById("mySidenav").style.width = "0"; 
		$('body').css('overflow','auto'); // Webkit browsers
	} 
	*/
</script>
<script>
function OpenMathPuzzles(Month)
{
	$('#loadingimage').show();
	$.ajax({
		type: "POST",
		url: "<?php echo base_url()."index.php/home/MathPuzzles"; ?>",
		data: {Month:Month},
		success: function(result)
		{
			 $("#MathPuzzles").html(result);
			 $('[data-toggle="tooltip"]').tooltip();
			 $('#loadingimage').hide();
		}
	});
}
</script>
<!--
<div class="parallax-window">
<a href="javascript:;" class="vprofile" id="vprofile" onclick="openNav()">View Jobprofileeeee</a>
</div>	-->
<script>
 $(document).ready(function(){	//alert("hello");
	MyJobProfile();
});
function MyJobProfile()
{ //alert("hello");
	//var cid=ChildId;
	$.ajax({
		type:"POST",
	//	url:"<?php echo base_url('index.php/home/DailyStatus') ?>",
	//	data:{cid:cid}, 
		dataType: 'json', 
		success:function(result)
		{
			$("#jprofile").html(result);
		}
	});
} 
</script>
