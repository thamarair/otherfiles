<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	  public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
				//$this->lang->load("menu_lang","english");
				$this->load->model('Assessment_model');
				$this->load->library('session');			
				//$this->lang->load("menu_lang","french");		
        }
		
	public function index()
	{			
		$this->load->view('header');
		$this->load->view('index');
		$this->load->view('footer');
		
	}
	public function testview()
	{
		echo date('Y-m-d H:i:s');exit;
	}
	public function termscheck()
	{
		//print_r($_POST); 
		
		if (!empty($_POST))
		{
			$data['query'] = $this->Assessment_model->checkUser($this->input->post('email'),$this->input->post('pwd'), $this->input->post('ddlLanguage'));
			
			echo $data['query'][0]->agreetermsandservice; exit;
			
		}
	}
	
	public function userlogin()
	{ 
		//print_r($_POST); 
		
		if (!empty($_POST))
		{ 
			 
			$data['query'] = $this->Assessment_model->checkUser($this->input->post('email'),$this->input->post('pwd'), $this->input->post('ddlLanguage'));
			 
			
			 
			if(isset($data['query'][0]->id)){
// update prelogin and login date
// get login count
// update login count by 1
// based on login count set welcome message

/* Creating unique login ID */
$uniqueId = $data['query'][0]->id."".date("YmdHis")."".round(microtime(true) * 1000);
$this->Assessment_model->update_loginDetails($data['query'][0]->id,$uniqueId);

$login_count=$data['query'][0]->login_count;
$prelogin_date=$data['query'][0]->pre_logindate;
$fname=$data['query'][0]->fname;
$todaydate=date('Y-m-d');
$login_date=$data['query'][0]->login_date;
$start_ts = strtotime($login_date);
$end_ts = strtotime($todaydate);
$diff = $end_ts - $start_ts;
$datediff = round($diff / 86400);

$usergrade = $data['query'][0]->grade_id;
 
if((isset($login_count) && $login_count<=1) || $prelogin_date == "0000-00-00" || $usergrade==3 || $usergrade==4 || $usergrade==5 || $usergrade==6)
{
$greetings_content = 'Thanks for subscribing to SkillAngels. I am sure you will enjoy the learning process.\n Good Luck';
}
elseif((isset($login_count) && $login_count>1) && $datediff <3 )
{
$greetings_content ='You last played on '.date("d-m-Y", strtotime($prelogin_date)).'\n Nice to see you pay so much \n attention';
}
elseif((isset($login_count) && $login_count>1) && ($datediff >= 3 && $datediff < 7 ))
{
$greetings_content =' You last played on '.date("d-m-Y", strtotime($prelogin_date)).'.\n
You were missing for the last '.$datediff.'\n
You missed '.$datediff.' training \n
Everything Okay?';
}
elseif((isset($login_count) && $login_count>1) && ($datediff >= 7 && $datediff <= 30 ))
{
$greetings_content ='You last played on '.date("d-m-Y", strtotime($prelogin_date)).'.\n You were missing for the last '.$datediff.' 
\n Please make it a habit to use SkillAngels regularly';
}
elseif((isset($login_count) && $login_count>1) && ($datediff > 30))
{
$greetings_content ='You last played on '.date("d-m-Y", strtotime($prelogin_date)).'.\n You were missing for the last '.$datediff.'\n That seems to be a long break. Please resume your training\n Good Luck';
}
$academicyear=$this->Assessment_model->getacademicyearbyschoolid($data['query'][0]->sid);

$this->session->set_userdata(array(
				'userlang'       =>3,
				'gp_id'       => $data['query'][0]->gp_id,
				'id'       => $data['query'][0]->id,
				'user_id'       => $data['query'][0]->id,
				'fname'      => $data['query'][0]->fname,
				'username'      => $data['query'][0]->username,
				'login_count'      => $data['query'][0]->login_count,
				'ltime'      => time(),
				'fullname'      => $data['query'][0]->fname.' '.$data['query'][0]->lname,
				'game_plan_id'      => $data['query'][0]->gp_id,
				'game_grade'      => $data['query'][0]->grade_id,
				'school_id'      => $data['query'][0]->sid,
				'section'      => $data['query'][0]->section,
				'greetings_content'      => $greetings_content,
				'avatarimage'=>$data['query'][0]->avatarimage,
				'login_session_id'=>$uniqueId, 
				'astartdate'=>$academicyear[0]['startdate'],
				'aenddate'=>$academicyear[0]['enddate'],
));

$r=$array = json_decode(json_encode($data['query'][0]), True);

$isavailable=$this->Assessment_model->CheckSkillkitexist($this->session->user_id);
$exeofnodaysplayed=$this->Assessment_model->getUserPlayedDayscount($this->session->user_id);
$confignoofdaysplay=$this->Assessment_model->getConfigNoofDaysPlay();
 
if($isavailable[0]['isavailable']==0)
{
if(($exeofnodaysplayed[0]['playedDate']!=0) && ($exeofnodaysplayed[0]['playedDate']%$confignoofdaysplay[0]['value'])==0)
{
	$SKBSPI = $this->Assessment_model->getSKBspi($r);
	$MemoryRang=$this->Assessment_model->getMemoryRange();
	$VisualProcessingRange=$this->Assessment_model->getVisualProcessingRange();
	$FocusAttentionRange=$this->Assessment_model->getFocusAttentionRange();
	$ProblemSolvingRange=$this->Assessment_model->getProblemSolvingRange();
	$LinguisticsRange=$this->Assessment_model->getLinguisticsRange();
	
	$arr=array('59'=>$MemoryRang[0]['rangeval'],'60'=>$VisualProcessingRange[0]['rangeval'],'61'=>$FocusAttentionRange[0]['rangeval'],'62'=>$ProblemSolvingRange[0]['rangeval'],'63'=>$LinguisticsRange[0]['rangeval']);
	//echo "<pre>";print_r($arr);exit;
	$month_array_skill=array();
	$arrgs_id=array();
	$arrlevel=array();
	$inini=0;$ininj=1;$inink=0;
$configrange=5;
foreach($SKBSPI as $get_res)
{
	$rangeval=explode('-',$arr[$get_res['gs_id']]);
	//echo "<pre>";print_r($rangeval);echo $get_res['gamescore'];exit;
	//echo $rangeval[0].">=".$get_res['gamescore'];exit;
	if($rangeval[0]>=$get_res['gamescore'])
	{
		if(($rangeval[0]>=$get_res['gamescore']) && (($rangeval[0]-$configrange)<=$get_res['gamescore']))
		{
			$arrgs_id[]=$get_res['gs_id'];
			$arrlevel[]='1';
		}
		else if((($rangeval[0]-$configrange)>=$get_res['gamescore']))
		{
			$arrgs_id[]=$get_res['gs_id'];
			$arrlevel[]='2';
		}
	}
	else
	{
		//echo "<br>ELSE</BR>";
	}
}
		$maxsession=$exeofnodaysplayed[0]['playedDate']/$confignoofdaysplay[0]['value'];
		$this->Assessment_model->updateSKGameList($r);
		$this->Assessment_model->insertSKGameList($r,$maxsession,$arrgs_id,$arrlevel);
		$skillkit_content='Personalized skill kit puzzles are enabled for you.';
		$this->session->set_userdata('skillkit_content', $skillkit_content);
} 
} 
		/* $uniqueId = uniqid($this->CI->input->ip_address(), TRUE);
		$this->session->set_userdata("my_session_id", md5($uniqueId)); */
		$language = $data['query'][0]->languagekey;
		$language = ($language != "") ? $language : "english";
        $this->session->set_userdata('site_lang', $language);
		
		$arrofinput=array("inSID"=>$this->session->school_id,"inGID"=>$this->session->game_grade,'inUID'=>$this->session->user_id,'inScenarioCode'=>'LOGIN','inTotal_Ques'=>'','inAttempt_Ques'=>'','inAnswer'=>'','inGame_Score'=>'',"inPlanid"=>$this->session->game_plan_id,'inGameid'=>'');	
		/*--- Sparkies ----*/
		$sparkies_output=$this->Assessment_model->insertsparkies($arrofinput);
		$finalpoints=$sparkies_output[0]['OUTPOINTS'];
		if($finalpoints!=''){$isexist=1;}else{$isexist=0;}
		$this->session->set_userdata('issparkies',$isexist);	
		$this->session->set_userdata('sparkiespoints',$finalpoints);
		
		//$data['academicyear'] = $this->Assessment_model->getacademicyear(); 
		$startdate=$this->session->astartdate;
		$enddate=$this->session->aenddate;
		
		//$this->Assessment_model->GetBadgeData($this->session->school_id,$this->session->game_grade,$startdate,$enddate);
		//$this->Assessment_model->insertnewsfeeddata($arrofinput);
	    //$this->Assessment_model->termsandcondition(1,$this->input->post('email'));
		
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
 $ip=$_SERVER['HTTP_CLIENT_IP'];}
 elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
 $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];} else {
 $ip=$_SERVER['REMOTE_ADDR'];}		
$this->Assessment_model->insert_login_log($data['query'][0]->id,$uniqueId,$ip,$this->input->post('txcountry'),$this->input->post('txregion'),$this->input->post('txcity'),$this->input->post('txisp'),$_SERVER['HTTP_USER_AGENT'],1);			
		
		
		echo $result=1; exit;
		//redirect('index.php/home/dashboard');
			
		}
	} 
}

	public function dashboard()
	{	 
		if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}
		
	//echo "hello"; exit;	
		$userid = $this->session->user_id;
		$check_date_time = date('Y-m-d');
		$catid=1;
		$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
		$data['skillkitenable']=$this->Assessment_model->IsSkillkitExist($this->session->user_id,$this->session->game_plan_id);
		$data['randomGames']=$this->Assessment_model->getRandomGames($check_date_time,$this->session->game_plan_id,$this->session->game_grade,$this->session->school_id);
		
		$data['assignGames']=$this->Assessment_model->getAssignGames($this->session->game_plan_id,$this->session->game_grade,$userid,$catid);
	
		
		$cur_day_skills = count($data['randomGames']);
		$assign_count = count($data['assignGames']);
		if($cur_day_skills <= 0 || $assign_count > $cur_day_skills ) {
				$this->fn_Rand_games($userid, $check_date_time, $cur_day_skills, $assign_count,$catid);
			}
		$data['randomGames']=$this->Assessment_model->getRandomGames($check_date_time,$this->session->game_plan_id,$this->session->game_grade,$this->session->school_id);
		$where = "";
		foreach($data['randomGames'] as $brainData )
		{
			$brainIds[] = $brainData['gid'];
			$active_game_ids = @implode(',',$brainIds);
			$where = " and g.gid in ($active_game_ids)";
		}
			 
		$data['actualGames'] = $this->Assessment_model->getActualGames($this->session->game_plan_id,$this->session->game_grade,$userid,$catid,$where);
		$data['actualGameCategory']=array('59'=>'Memory','60'=>'Visual Processing','61'=>'Focus & Attention','62'=>'Problem Solving','63'=>'Linguistics');
		$get_bspi_rows =$this->Assessment_model->getBSPI($userid);

		 
$res_tot_memory=$res_tot_vp=$res_tot_fa= $res_tot_ps=$res_tot_lang=0;
$res_tot_memory_i=$res_tot_vp_i=$res_tot_fa_i= $res_tot_ps_i=$res_tot_lang_i=0;
 
	foreach($get_bspi_rows as $get_res){
		
		if(($get_res['gs_id']=='59')){$res_tot_memory_i++; $res_tot_memory += $get_res['score'];}
		else{$res_tot_memory += 0.00;}
		if(($get_res['gs_id']=='60')){$res_tot_vp_i++;$res_tot_vp += $get_res['score'];}
		else{$res_tot_vp += 0.00;}
		if(($get_res['gs_id']=='61')){$res_tot_fa_i++;$res_tot_fa += $get_res['score'];}
		else{$res_tot_fa += 0.00;}
		if(($get_res['gs_id']=='62')){$res_tot_ps_i++;$res_tot_ps += $get_res['score'];}
		else{$res_tot_ps += 0.00;}
		if(($get_res['gs_id']=='63')){$res_tot_lang_i++;$res_tot_lang += $get_res['score'];}
		else{$res_tot_lang += 0.00;}
		 
	}
	if($res_tot_memory_i==0){$res_tot_memory_i=1;}
	if($res_tot_vp_i==0){$res_tot_vp_i=1;}
	if($res_tot_fa_i==0){$res_tot_fa_i=1;}
	if($res_tot_ps_i==0){$res_tot_ps_i=1;}
	if($res_tot_lang_i==0){$res_tot_lang_i=1;}
	$tot = (($res_tot_memory/$res_tot_memory_i)+($res_tot_vp/$res_tot_vp_i)+($res_tot_fa/$res_tot_fa_i)+($res_tot_ps/$res_tot_ps_i)+($res_tot_lang/$res_tot_lang_i))/5;
	$data['PlayedSkillCount']=$this->Assessment_model->getPlayedSkillCount($userid);
	
	$data['bspi'] = $tot;
 
	 $restrainCalendar= $this->Assessment_model->getTrainCalendar($userid,date('Y-m-01'),date('Y-m-d'),$catid);
	 $data['arrtrainCalendar']=explode(',',$restrainCalendar[0]['updateDates']);
	 $data['trophies']=array();
	 $data['trophies']= $this->Assessment_model->getMyCurrentTrophies($userid);
/* Expire time Validation */
$maxtimofplay=$this->Assessment_model->getMaxTimeofPlay();
$sumoftottimeused=$this->Assessment_model->getSumofUserUsedTime($userid,date('Y-m-d'));
$data['maxtimeofplay']=$maxtimofplay[0]['value'];
$data['sumoftottimeused']=$sumoftottimeused[0]['LoggedIntime'];
$data['Remainingtime']=$maxtimofplay[0]['value']-$sumoftottimeused[0]['LoggedIntime'];
if($sumoftottimeused[0]['LoggedIntime']>=$maxtimofplay[0]['value'])
{
	$this->TodayTimerInsert();
}
/* Expire time Validation */
	
	$data['sparkies']=$this->MySparkies();
	
	
	//print_r($data['sparkies']);  exit;
		$this->load->view('headerinner', $data);
        $this->load->view('home/dashboard', $data);
		$this->load->view('footerinner');
	
	//redirect('index.php/home/dashboard');
	
	}
	
public function fn_Rand_games($uid, $check_date_time, $cur_day_skills, $assign_count,$catid) {
$arrSkills=$this->Assessment_model->getSkillsRandom($catid);

	  foreach($arrSkills as $gs_data)
	  {
		  $rand_sel = $this->Assessment_model->assignRandomGame($catid,$this->session->game_plan_id,$this->session->game_grade,$uid,$gs_data['skill_id'],$this->session->school_id);
		  
		 $rand_count = count($rand_sel);//echo $rand_count."<=0";exit;
		  if($rand_count <=0) {
					$del_where = "";
					if($assign_count <> $cur_day_skills && $cur_day_skills > 0)
					{
					 $del_where = " and created_date = '$check_date_time'";
					 $this->Assessment_model->deleteRandomGames($catid,$this->session->game_plan_id,$this->session->game_grade,$uid,$gs_data['skill_id'],$this->session->school_id,$del_where);
					}
				} 
				if($rand_count > 0) {
					$rand_data = $this->Assessment_model->insertRandomGames($catid,$this->session->game_plan_id,$this->session->game_grade,$gs_data['skill_id'],$this->session->school_id,$this->session->section,$rand_sel[0]['gid'],$check_date_time);
					 
				}
	  }
	  $data['randomGames']=$this->Assessment_model->getRandomGames($check_date_time,$this->session->game_plan_id,$this->session->game_grade,$this->session->school_id);
		$cur_day_skills = count($data['randomGames']);
		
		
		if($cur_day_skills == 0)
		{				  
				$this->fn_Rand_games($uid, $check_date_time, $cur_day_skills, $assign_count);
		}
		else if($cur_day_skills<count($arrSkills))
			{
				$this->Assessment_model->deleteSPLRandomGames($check_date_time,$this->session->game_plan_id,$this->session->game_grade,$this->session->school_id);
				$this->fn_Rand_games($uid, $check_date_time, $cur_day_skills, $assign_count,$catid);
			}
}
	
	public function language()
	{
	
	 $email = $this->input->post('Lemail'); 
		
		$data['query'] = $this->Assessment_model->languagechange($email);
		
		//print_r($data['query']);
		$str_language='';
		foreach($data['query'] as $data)
		{
			
			$str_language.='<option value="'.$data->ID.'">'.$data->name.'</option>';
	
		}	

	
	 if($str_language==''){$str_language='<option value="1">English</option>';}
		echo $str_language;exit;

	}
	public function logout()
	{
		$this->load->view('headerinner');
		$this->load->view('logout/logout');
		$this->load->view('footerinner'); 
	}
	public function mainlogout()
	{
		if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}
		$this->Assessment_model->update_logout_log($this->session->user_id,$this->session->login_session_id);
		$exeout = $this->Assessment_model->updateuserloginstatus($this->session->user_id,$this->session->login_session_id);
		$user_data = $this->session->all_userdata();
        foreach ($user_data as $key => $value) {
            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
                $this->session->unset_userdata($key);
            }
        }
		$this->session->sess_destroy();
		redirect(base_url());
	}
	public function gamesajax()
	{
		$gameurl =  $_POST['gameurl']; 
		$gname = substr($gameurl, strrpos($gameurl, '/') + 1);
		$gamename = str_replace('.html','', $gname); 
		
		
		if($_POST['skillkit']!='Y')
		{	$data['gameid'] = $this->Assessment_model->getgameid($gamename);
			$gameid = $data['gameid'][0]['gid']; 
			$data['checkgame'] = $this->Assessment_model->checkgame($gameid);
			
			$gid = $data['checkgame'][0]['gameid']; 
			
			if($gid==1)
			{
				
			$this->session->set_userdata(array( 'currentgameid'=> $gameid ));
			$this->session->set_userdata(array( 'isskillkit'=> $_POST['skillkit'] ));
			echo $this->session->currentgameid;exit;
			}
			else{
				
				echo 'IA'; exit;
			}
		}
		else
		{	
			$data['gameid'] = $this->Assessment_model->getgameid_SK($gamename);
			$gameid = $data['gameid'][0]['gid'];
			$this->session->set_userdata(array( 'currentgameid'=> $gameid ));
			$this->session->set_userdata(array( 'isskillkit'=> $_POST['skillkit'] ));
			echo $this->session->currentgameid;exit;
		}

	}
	public function result()
	{
			if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php'); exit;}
	if(!isset($_POST)){redirect('index.php'); exit;}
	if(empty($_POST)){redirect('index.php'); exit;}
$total_ques=$_POST["tqcnt1"];
if($_POST["aqcnt1"]>10){
	$attempt_ques=10;
}
else{
	$attempt_ques=$_POST["aqcnt1"];
}

$answer=$_POST["cqcnt1"];
$score=$_POST["gscore1"];
$a6=$_POST["gtime1"];
$a7=$_POST["rtime1"];
$a8=$_POST["crtime1"];
$a9=$_POST["wrtime1"];	
$gameid=$this->session->currentgameid;
$isskillkit=$this->session->isskillkit;
if($isskillkit=="Y"){$skillkit=1;}
else{$skillkit=0;}
/*
echo "<pre>";
print_r($_SESSION);
exit;

		/*echo 'hai'; exit;*/
		
		$userlang = $this->session->userlang;
		$userid = $this->session->user_id; 
		$lastup_date = date("Y-m-d");
		$cid = 1;
				$data['gameDetails'] = $this->Assessment_model->getresultGameDetails($userid,$gameid);

		$skillid =$data['gameDetails'][0]['gameskillid'] ; 
		  
		//$createddate = NOW();
		
		$data['chkschedule'] = $this->Assessment_model->checkscheduledays($this->session->game_grade,$this->session->section,$this->session->school_id);
		$schedule_val = $data['chkschedule'][0]['scheduleday'];
		 
		$pid =  $this->session->gp_id; 
		if($skillkit==0){
		$data['insert1'] = $this->Assessment_model->insertone($userid,$cid,$skillid,$pid,$gameid,$total_ques,$attempt_ques,$answer,$score,$a6,$a7,$a8,$a9,$lastup_date,$schedule_val);
		}
		else if($skillkit==1){
		$data['insert1'] = $this->Assessment_model->insertone_SK($userid,$cid,$skillid,$pid,$gameid,$total_ques,$attempt_ques,$answer,$score,$a6,$a7,$a8,$a9,$lastup_date);
		}
		$data['insert2'] = $this->Assessment_model->insertlang($gameid,$userid,$userlang,$skillkit);
 		$currentacademicid=$this->Assessment_model->getacademicyearbyschoolid($this->session->school_id);
		$acid =$currentacademicid[0]['id'];
		$st = 1;
		$data['insert3'] = $this->Assessment_model->insertthree($userid,$gameid,$acid,$lastup_date,$st);
		
		$arrofinput=array("inSID"=>$this->session->school_id,"inGID"=>$this->session->game_grade,'inUID'=>$userid,'inScenarioCode'=>'GAME_END','inTotal_Ques'=>$total_ques,'inAttempt_Ques'=>$attempt_ques,'inAnswer'=>$answer,'inGame_Score'=>$score,"inPlanid"=>$pid,'inGameid'=>$gameid);
		
		/*--- Sparkies ----*/
		$sparkies_output=$this->Assessment_model->insertsparkies($arrofinput);
		$_REQUEST['gameoutput']=$sparkies_output[0]['OUTPOINTS'];
		//$this->session->set_flashdata('newsparky', $sparkies_output[0]['OUTPOINTS']);
		/*--- News Feed ----*/
		$newsfeed_output=$this->Assessment_model->insertnewsfeeddata($arrofinput);		
		echo $sparkies_output[0]['OUTPOINTS'];exit;
		//$this->load->view('gameresult/Result');
		
	}
	
	public function profile()
	{
		 
		if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}
				
				if(isset($_FILES["file"]["type"]))
{
	
$validextensions = array("jpeg", "jpg", "png");
$temporary = explode(".", $_FILES["file"]["name"]);
$file_extension = end($temporary);
 $size = getimagesize($files);
$maxWidth = 150;
$maxHeight = 150;
if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
) && in_array($file_extension, $validextensions)) {

$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
$targetPath = "assets/images/avatarimages/".$_FILES['file']['name']; // Target path where file is to be stored
//$targetPath = "upload/".$_FILES['file']['name'];

move_uploaded_file($sourcePath,$targetPath) ; 

}
}
/*
		$data['updatemsG']="";
		if($_REQUEST)
		{
		$sfname =  $this->input->post('sfname');
	$gender = $this->input->post('gender');
	$dob = $this->input->post('dob');
	$fathername = $this->input->post('fathername');
	$mothename = $this->input->post('mname');
	$address = $this->input->post('saddress');
	$emailid = $_POST['emailid'];
	$sphoneno = $this->input->post('sphoneno');
	$id = $this->input->post('id');
	$newpass = $this->input->post('newpass');
	$confirmpass = $this->input->post('cpass');
		
		
		$userid = $this->session->user_id;
		$data['updateprofile'] = $this->Assessment_model->updateprofile($sfname,$gender,$dob,$fathername,$mothename,$address,$sphoneno,$id,$newpass,$confirmpass,$targetPath);
		$data['updatemsG']="Updated Successfully !!!";
		}
		*/
		
		$userid = $this->session->user_id;
		$get_bspi_rows =$this->Assessment_model->getBSPI($userid);

		 
$res_tot_memory=$res_tot_vp=$res_tot_fa= $res_tot_ps=$res_tot_lang=0;
$res_tot_memory_i=$res_tot_vp_i=$res_tot_fa_i= $res_tot_ps_i=$res_tot_lang_i=0;
 
	foreach($get_bspi_rows as $get_res){
		
		if(($get_res['gs_id']=='59')){$res_tot_memory_i++; $res_tot_memory += $get_res['score'];}
		else{$res_tot_memory += 0.00;}
		if(($get_res['gs_id']=='60')){$res_tot_vp_i++;$res_tot_vp += $get_res['score'];}
		else{$res_tot_vp += 0.00;}
		if(($get_res['gs_id']=='61')){$res_tot_fa_i++;$res_tot_fa += $get_res['score'];}
		else{$res_tot_fa += 0.00;}
		if(($get_res['gs_id']=='62')){$res_tot_ps_i++;$res_tot_ps += $get_res['score'];}
		else{$res_tot_ps += 0.00;}
		if(($get_res['gs_id']=='63')){$res_tot_lang_i++;$res_tot_lang += $get_res['score'];}
		else{$res_tot_lang += 0.00;}
		 
	}
	if($res_tot_memory_i==0){$res_tot_memory_i=1;}
	if($res_tot_vp_i==0){$res_tot_vp_i=1;}
	if($res_tot_fa_i==0){$res_tot_fa_i=1;}
	if($res_tot_ps_i==0){$res_tot_ps_i=1;}
	if($res_tot_lang_i==0){$res_tot_lang_i=1;}
	$tot = (($res_tot_memory/$res_tot_memory_i)+($res_tot_vp/$res_tot_vp_i)+($res_tot_fa/$res_tot_fa_i)+($res_tot_ps/$res_tot_ps_i)+($res_tot_lang/$res_tot_lang_i))/5;

	
	$data['bspi'] = $tot;
		$userid = $this->session->user_id;
		//$data['query'] = $this->Assessment_model->getleftbardata($userid);
		//$data['mytrophy'] = $this->Assessment_model->gettrophy($userid);
		$data['myprofile'] = $this->Assessment_model->getmyprofile($userid);
		$planid = $data['myprofile'][0]['gp_id'];
		$schoolid = $data['myprofile'][0]['sid'];
		$gradeid = $data['myprofile'][0]['grade_id']; 
		$data['getplandetails'] = $this->Assessment_model->getplandetais($planid);
		$data['getgrade'] = $this->Assessment_model->getgradedetais($gradeid);
		$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
		$data['skillkitenable']=$this->Assessment_model->IsSkillkitExist($this->session->user_id,$this->session->game_plan_id);
		
	/*	MY BADGES - function */
	
		//$data['academicyear'] = $this->Assessment_model->getacademicyear(); 
		$startdate = $this->session->astartdate;
		$enddate = $this->session->aenddate;
		$gradeid = $this->session->game_grade;
		$schoolid = $this->session->school_id;
	
		/* $data['superbrainb'] = $this->Assessment_model->getbadgeone($startdate,$enddate,$gradeid,$userid,$schoolid);
		$data['supergoerb'] = $this->Assessment_model->getbadgetwo($startdate,$enddate,$gradeid,$userid,$schoolid);
		$data['superangelb'] = $this->Assessment_model->getbadgethree($startdate,$enddate,$gradeid,$userid,$schoolid); */ 
		$data['UserBadgeCount']=$this->Assessment_model->getUserBadgeCount($schoolid,$gradeid,$userid);
		/*Class performance report*/
	$data['GradewiseScore_data1'] = $this->Assessment_model->getClassPerformace_data($this->session->school_id,$this->session->game_grade,$this->session->section,'game_reports');
	
	 $su1=array_unique(array_column($data['GradewiseScore_data1'],'bspi'));
	 $gu1=array_search($this->session->user_id,array_column($data['GradewiseScore_data1'],'id'));
	 
	 $data['GradeWiseReport1']=$data['GradewiseScore_data1'];
	 
	 $su1_r=array_reverse(array_merge($su1));
	 $cus1=$data['GradewiseScore_data1'][$gu1];
	 
	  $data['gu1']=$gu1;
	  $data['su1']=$su1;
	  
	  $data['su1_r']=$su1_r;
	  $data['cus1']=$cus1;
	
	 $su1_r=array_reverse(array_merge($su1)); 

	/*Class performance report*/
	
	$data['sparkies']=$this->MySparkies();
		
		$this->load->view('headerinner', $data);
        $this->load->view('myprofile/newmyprofile', $data);
		$this->load->view('footerinner');
		
	}
	
public function salt_my_pass($password)
{
// Generate two salts (both are numerical)
$salt1 = mt_rand(1000,9999999999);
$salt2 = mt_rand(100,999999999);

// Append our salts to the password
$salted_pass = $salt1 . $password . $salt2;

// Generate a salted hash
$pwdhash = sha1($salted_pass);

// Place into an array
$hash['Salt1'] = $salt1;
$hash['Salt2'] = $salt2;
$hash['Hash'] = $pwdhash;

// Return the hash and salts to whatever called our function
return $hash;

}
	
	/* public function myprofile()
	{
				if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}
				
if(isset($_FILES["file"]["type"]))
{
	
$validextensions = array("jpeg", "jpg", "png");
$temporary = explode(".", $_FILES["file"]["name"]);
$file_extension = end($temporary);
 $size = getimagesize($files);
$maxWidth = 150;
$maxHeight = 150;
if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
) && in_array($file_extension, $validextensions)) {

$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
$targetPath = "assets/images/avatarimages/".$_FILES['file']['name']; // Target path where file is to be stored
//$targetPath = "upload/".$_FILES['file']['name'];
$this->session->set_userdata('avatarimage', $targetPath);
move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
//echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
//echo "<br/><b>File Name:</b> " . $_FILES["file"]["name"] . "<br>";
//echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
//echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
//echo "<b>Temp file:</b> " . $_FILES["file"]["tmp_name"] . "<br>";

}
}

		$data['updatemsG']="";
		if($_REQUEST)
		{
				$sfname =  $this->input->post('sfname');
				$gender = $this->input->post('gender');
				$dob = $this->input->post('dob');
				$fathername = $this->input->post('fathername');
				$mothename = $this->input->post('mname');
				$address = $this->input->post('saddress');
				$emailid = $this->input->post('email');
				$sphoneno = $this->input->post('sphoneno');
				$id = $this->input->post('id');
				$newpass = $this->input->post('newpass');
				$confirmpass = $this->input->post('cpass');
			
				//$password = $_POST['txtOPassword'];
				 $hashpass = $this->salt_my_pass($newpass);
				 
				$shpassword = $hashpass['Hash']; 
				$salt1 = $hashpass['Salt1']; 
				$salt2 = $hashpass['Salt2']; 
				
				$saltedpass = $salt1 . $shpassword . $salt2;
				
				$ip=$this->getRealIpAddr();
				$userid = $this->session->user_id;
				$data['updateprofile'] = $this->Assessment_model->updateprofile($sfname,$gender,$emailid,$dob,$fathername,$mothename,$address,$sphoneno,$id,$shpassword,$salt1,$salt2,$confirmpass,$targetPath,$ip);
				$data['updatemsG']="Updated Successfully !!!";
				$this->session->set_flashdata('flag', '1');
				redirect("index.php/home/profile");
		}
		
		
		$userid = $this->session->user_id;
		$get_bspi_rows =$this->Assessment_model->getBSPI($userid);

		 
$res_tot_memory=$res_tot_vp=$res_tot_fa= $res_tot_ps=$res_tot_lang=0;
$res_tot_memory_i=$res_tot_vp_i=$res_tot_fa_i= $res_tot_ps_i=$res_tot_lang_i=0;
 
	foreach($get_bspi_rows as $get_res){
		
		if(($get_res['gs_id']=='59')){$res_tot_memory_i++; $res_tot_memory += $get_res['score'];}
		else{$res_tot_memory += 0.00;}
		if(($get_res['gs_id']=='60')){$res_tot_vp_i++;$res_tot_vp += $get_res['score'];}
		else{$res_tot_vp += 0.00;}
		if(($get_res['gs_id']=='61')){$res_tot_fa_i++;$res_tot_fa += $get_res['score'];}
		else{$res_tot_fa += 0.00;}
		if(($get_res['gs_id']=='62')){$res_tot_ps_i++;$res_tot_ps += $get_res['score'];}
		else{$res_tot_ps += 0.00;}
		if(($get_res['gs_id']=='63')){$res_tot_lang_i++;$res_tot_lang += $get_res['score'];}
		else{$res_tot_lang += 0.00;}
		 
	}
	if($res_tot_memory_i==0){$res_tot_memory_i=1;}
	if($res_tot_vp_i==0){$res_tot_vp_i=1;}
	if($res_tot_fa_i==0){$res_tot_fa_i=1;}
	if($res_tot_ps_i==0){$res_tot_ps_i=1;}
	if($res_tot_lang_i==0){$res_tot_lang_i=1;}
	$tot = (($res_tot_memory/$res_tot_memory_i)+($res_tot_vp/$res_tot_vp_i)+($res_tot_fa/$res_tot_fa_i)+($res_tot_ps/$res_tot_ps_i)+($res_tot_lang/$res_tot_lang_i))/5;

	
	$data['bspi'] = $tot;
		$userid = $this->session->user_id;
		//$data['query'] = $this->Assessment_model->getleftbardata($userid);
		//$data['mytrophy'] = $this->Assessment_model->gettrophy($userid);
		$data['myprofile'] = $this->Assessment_model->getmyprofile($userid);
		$planid = $data['myprofile'][0]['gp_id'];
		$schoolid = $data['myprofile'][0]['sid'];
		$gradeid = $data['myprofile'][0]['grade_id']; 
		$data['getplandetails'] = $this->Assessment_model->getplandetais($planid);
		$data['getgrade'] = $this->Assessment_model->getgradedetais($gradeid);
		$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
		$data['skillkitenable']=$this->Assessment_model->IsSkillkitExist($this->session->user_id,$this->session->game_plan_id);
		
		$data['sparkies']=$this->MySparkies();
		
		$this->load->view('headerinner', $data);
        $this->load->view('myprofile/myprofile', $data);
		$this->load->view('footerinner');
	
	} */
	public function mybrainprofile()
	{
				if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}

		$userid = $this->session->user_id;
		$get_bspi_rows =$this->Assessment_model->getBSPI($userid);

		 
$res_tot_memory=$res_tot_vp=$res_tot_fa= $res_tot_ps=$res_tot_lang=0;
$res_tot_memory_i=$res_tot_vp_i=$res_tot_fa_i= $res_tot_ps_i=$res_tot_lang_i=0;
 
	foreach($get_bspi_rows as $get_res){
		
		if(($get_res['gs_id']=='59')){$res_tot_memory_i++; $res_tot_memory += $get_res['score'];}
		else{$res_tot_memory += 0.00;}
		if(($get_res['gs_id']=='60')){$res_tot_vp_i++;$res_tot_vp += $get_res['score'];}
		else{$res_tot_vp += 0.00;}
		if(($get_res['gs_id']=='61')){$res_tot_fa_i++;$res_tot_fa += $get_res['score'];}
		else{$res_tot_fa += 0.00;}
		if(($get_res['gs_id']=='62')){$res_tot_ps_i++;$res_tot_ps += $get_res['score'];}
		else{$res_tot_ps += 0.00;}
		if(($get_res['gs_id']=='63')){$res_tot_lang_i++;$res_tot_lang += $get_res['score'];}
		else{$res_tot_lang += 0.00;}
		 
	}
	if($res_tot_memory_i==0){$res_tot_memory_i=1;}
	if($res_tot_vp_i==0){$res_tot_vp_i=1;}
	if($res_tot_fa_i==0){$res_tot_fa_i=1;}
	if($res_tot_ps_i==0){$res_tot_ps_i=1;}
	if($res_tot_lang_i==0){$res_tot_lang_i=1;}
	$tot = (($res_tot_memory/$res_tot_memory_i)+($res_tot_vp/$res_tot_vp_i)+($res_tot_fa/$res_tot_fa_i)+($res_tot_ps/$res_tot_ps_i)+($res_tot_lang/$res_tot_lang_i))/5;

	
	$data['bspi'] = $tot;
	
	//$data['academicyear'] = $this->Assessment_model->getacademicyear(); 
	$startdate = $this->session->astartdate;
	$enddate = $this->session->aenddate;
	$data['academicmonths'] = $this->Assessment_model->getacademicmonths($startdate,$enddate);
	$data['skills'] = $this->Assessment_model->getskills();	
	$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
	$data['skillkitenable']=$this->Assessment_model->IsSkillkitExist($this->session->user_id,$this->session->game_plan_id);
	$data['sparkies']=$this->MySparkies();
		$this->load->view('headerinner', $data);
        $this->load->view('mybrainprofile/mybrainprofile', $data);
		$this->load->view('footerinner');
		
	}
	public function ajaxcalendar()
	{
				 

		$yearMonthQry=$_REQUEST['yearMonth'];
		$userid = $this->session->user_id;
		
	
	//$data['academicyear'] = $this->Assessment_model->getacademicyear(); 
	$startdate = $this->session->astartdate;
	$enddate = $this->session->aenddate;
	$data['academicmonths'] = $this->Assessment_model->getacademicmonths($startdate,$enddate);
	$data['skills'] = $this->Assessment_model->getskills();	
	$bspicalendardays= $this->Assessment_model->mybspicalendar($this->session->school_id,$userid,$yearMonthQry,$startdate,$enddate);
	$mybspiCalendar=array();	
	foreach($bspicalendardays as $days)
	{
		$mybspiCalendar[$days['playedDate']]=$days['game_score'];
	}
	 $data['mybspiCalendar']=$mybspiCalendar;
	  
	$data['yearMonthQry']=$yearMonthQry;
	
		 
        $this->load->view('mybrainprofile/ajaxcalendar', $data);
 
		
	}
	public function ajaxcalendarSkillChart()
	{
				 

		$yearMonthQry=$_REQUEST['yearMonth'];
		$userid = $this->session->user_id;
		
 
	$bspicalendarskillScore= $this->Assessment_model->mybspicalendarSkillChart("",$userid,$yearMonthQry);
  
	 $mybspiCalendarSkillScore=array("SID59"=>0,"SID60"=>0,"SID61"=>0,"SID62"=>0,"SID63"=>0);
	 foreach($bspicalendarskillScore as $score)
	{
		$mybspiCalendarSkillScore["SID".$score['gs_id']]=round($score['gamescore'],2);
	}
	 $data['bspicalendarskillScore']=$mybspiCalendarSkillScore;
	  
	$data['yearMonthQry']=$yearMonthQry;
	
		 
        $this->load->view('mybrainprofile/ajaxcalendarSkillChart', $data);
 
		
	}
	public function mytrophies()
	{
				if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}

		$userid = $this->session->user_id;
		$get_bspi_rows =$this->Assessment_model->getBSPI($userid);

		 
$res_tot_memory=$res_tot_vp=$res_tot_fa= $res_tot_ps=$res_tot_lang=0;
$res_tot_memory_i=$res_tot_vp_i=$res_tot_fa_i= $res_tot_ps_i=$res_tot_lang_i=0;
 
	foreach($get_bspi_rows as $get_res){
		
		if(($get_res['gs_id']=='59')){$res_tot_memory_i++; $res_tot_memory += $get_res['score'];}
		else{$res_tot_memory += 0.00;}
		if(($get_res['gs_id']=='60')){$res_tot_vp_i++;$res_tot_vp += $get_res['score'];}
		else{$res_tot_vp += 0.00;}
		if(($get_res['gs_id']=='61')){$res_tot_fa_i++;$res_tot_fa += $get_res['score'];}
		else{$res_tot_fa += 0.00;}
		if(($get_res['gs_id']=='62')){$res_tot_ps_i++;$res_tot_ps += $get_res['score'];}
		else{$res_tot_ps += 0.00;}
		if(($get_res['gs_id']=='63')){$res_tot_lang_i++;$res_tot_lang += $get_res['score'];}
		else{$res_tot_lang += 0.00;}
		 
	}
	if($res_tot_memory_i==0){$res_tot_memory_i=1;}
	if($res_tot_vp_i==0){$res_tot_vp_i=1;}
	if($res_tot_fa_i==0){$res_tot_fa_i=1;}
	if($res_tot_ps_i==0){$res_tot_ps_i=1;}
	if($res_tot_lang_i==0){$res_tot_lang_i=1;}
	$tot = (($res_tot_memory/$res_tot_memory_i)+($res_tot_vp/$res_tot_vp_i)+($res_tot_fa/$res_tot_fa_i)+($res_tot_ps/$res_tot_ps_i)+($res_tot_lang/$res_tot_lang_i))/5;

	
	$data['bspi'] = $tot;
	//$data['academicyear'] = $this->Assessment_model->getacademicyear(); 
	$startdate = $this->session->astartdate;
	$enddate = $this->session->aenddate;
	$data['academicmonths'] = $this->Assessment_model->getacademicmonths($startdate,$enddate);
	$mytrophies= $this->Assessment_model->myTrophiesAll($userid,$startdate,$enddate);
	$arrmyTrophies=array();
	 foreach($mytrophies as $trophies)
	 {
		 $arrmyTrophies[str_pad($trophies['month'], 2, '0', STR_PAD_LEFT)][$trophies['category']]=$trophies['totstar'];
	 }
	 $data['arrmyTrophies'] =$arrmyTrophies;
	 $data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
	 $data['skillkitenable']=$this->Assessment_model->IsSkillkitExist($this->session->user_id,$this->session->game_plan_id);
	 
$data['sparkies']=$this->MySparkies();	 
		$this->load->view('headerinner', $data);
        $this->load->view('mytrophies/mytrophies', $data);
		$this->load->view('footerinner');
		
	}
	
	public function skillkit()
	{
		if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}
		
	//echo "hello"; exit;	
		$userid = $this->session->user_id;
		$check_date_time = date('Y-m-d');
		$catid=1;
		 $this->fn_SK_Rand_games($userid, $check_date_time, '',100,$catid);
		$brain_rs = $this->Assessment_model->getAssignSK_RandomGame($check_date_time,$this->session->game_plan_id,$this->session->game_grade,$userid,$this->session->school_id);
		$where = "";
		$brainIds='';
		$data['actualGames']='';
			foreach( $brain_rs as $brainData)
			{
					$brainIds[] = $brainData['gid'];
			}
			if($brainIds)
			{			
					$active_game_ids = @implode(',',$brainIds);
					$where = " and g.ID in ($active_game_ids)";

			}
	if($brainIds)
			{				
			$data['actualGames'] = $this->Assessment_model->getSK_ActualGames($this->session->game_plan_id,$this->session->game_grade,$userid,$catid,$where);
			}
		$data['actualGameCategory']=array('59'=>'Memory','60'=>'Visual Processing','61'=>'Focus and Attention','62'=>'Problem Solving','63'=>'Linguistics');
		$get_bspi_rows =$this->Assessment_model->getBSPI($userid);

		 
$res_tot_memory=$res_tot_vp=$res_tot_fa= $res_tot_ps=$res_tot_lang=0;
$res_tot_memory_i=$res_tot_vp_i=$res_tot_fa_i= $res_tot_ps_i=$res_tot_lang_i=0;
 
	foreach($get_bspi_rows as $get_res){
		
		if(($get_res['gs_id']=='59')){$res_tot_memory_i++; $res_tot_memory += $get_res['score'];}
		else{$res_tot_memory += 0.00;}
		if(($get_res['gs_id']=='60')){$res_tot_vp_i++;$res_tot_vp += $get_res['score'];}
		else{$res_tot_vp += 0.00;}
		if(($get_res['gs_id']=='61')){$res_tot_fa_i++;$res_tot_fa += $get_res['score'];}
		else{$res_tot_fa += 0.00;}
		if(($get_res['gs_id']=='62')){$res_tot_ps_i++;$res_tot_ps += $get_res['score'];}
		else{$res_tot_ps += 0.00;}
		if(($get_res['gs_id']=='63')){$res_tot_lang_i++;$res_tot_lang += $get_res['score'];}
		else{$res_tot_lang += 0.00;}
		 
	}
	if($res_tot_memory_i==0){$res_tot_memory_i=1;}
	if($res_tot_vp_i==0){$res_tot_vp_i=1;}
	if($res_tot_fa_i==0){$res_tot_fa_i=1;}
	if($res_tot_ps_i==0){$res_tot_ps_i=1;}
	if($res_tot_lang_i==0){$res_tot_lang_i=1;}
	$tot = (($res_tot_memory/$res_tot_memory_i)+($res_tot_vp/$res_tot_vp_i)+($res_tot_fa/$res_tot_fa_i)+($res_tot_ps/$res_tot_ps_i)+($res_tot_lang/$res_tot_lang_i))/5;

	
	$data['bspi'] = $tot;
	$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
	$data['skillkitenable']=$this->Assessment_model->IsSkillkitExist($this->session->user_id,$this->session->game_plan_id);
	
/* Expire time Validation */
	$maxtimofplay=$this->Assessment_model->getMaxTimeofPlay();
	$sumoftottimeused=$this->Assessment_model->getSumofUserUsedTime($userid,date('Y-m-d'));
	$data['maxtimeofplay']=$maxtimofplay[0]['value'];
	$data['sumoftottimeused']=$sumoftottimeused[0]['LoggedIntime'];
	$data['Remainingtime']=$maxtimofplay[0]['value']-$sumoftottimeused[0]['LoggedIntime'];
	if($sumoftottimeused[0]['LoggedIntime']>=$maxtimofplay[0]['value'])
	{
		$this->TodayTimerInsert();
	}
/* Expire time Validation */
	
	$data['sparkies']=$this->MySparkies();
		$this->load->view('headerinner', $data);
        $this->load->view('home/skillkit', $data);
		$this->load->view('footerinner');
	
	//redirect('index.php/home/dashboard');
	
	}
	public function fn_SK_Rand_games($uid, $check_date_time, $cur_day_skills, $assign_count,$catid) {
//echo "fn_Rand_games";

$arrSkills=$this->Assessment_model->getSK_SkillsRandom($uid);
$arrlevelid=explode(',',$arrSkills[0]['levelid']); //echo "<pre>";print_r($arrSkills);exit;
$vv=0;
	  foreach($arrSkills as $gs_data)
	  { 	
			$rand_sel = $this->Assessment_model->assignSK_RandomGame($check_date_time,$this->session->game_plan_id,$this->session->game_grade,$uid,$gs_data['skill_id'],$this->session->school_id);
		  
			$cur_day_skills = count($rand_sel);
			
			$rand_sel_limit = $this->Assessment_model->assignSK_assignGameCount($this->session->game_plan_id,$gs_data['skill_id'],$this->session->school_id,$arrlevelid[$vv]);
			$assign_count = $rand_sel_limit[0]['gameCount']; 

//echo "<pre>";print_r($assign_count);exit;
if($cur_day_skills<$assign_count){
	$rand_sel_rs=$this->Assessment_model->getSK_randomGames($this->session->game_plan_id,$this->session->game_grade,$uid,$gs_data['skill_id'],$this->session->school_id,$assign_count,$cur_day_skills,$arrlevelid[$vv]);
 
 

$rand_count = count($rand_sel_rs);	

if($rand_count <=0) {
					$del_where = "";
					if($assign_count <> $cur_day_skills && $cur_day_skills > 0)
						$del_where = " and created_date = '$check_date_time'";
					 $this->Assessment_model->deleteSK_RandomGames($catid,$this->session->game_plan_id,$this->session->game_grade,$uid,$gs_data['skill_id'],$this->session->school_id,$del_where);
} 
				 
				if($rand_count > 0) {
					foreach($rand_sel_rs as $rand_data1) { 
					$rand_data = $this->Assessment_model->insertSK_RandomGames($catid,$rand_data1['plan_ID'],$this->session->game_grade,$uid,$gs_data['skill_id'],$this->session->school_id,$this->session->section,$rand_data1['gid'],$check_date_time);
					}
					 
				}
	  }
			$rand_sel = $this->Assessment_model->assignSK_RandomGame($check_date_time,$this->session->game_plan_id,$this->session->game_grade,$uid,$gs_data['skill_id'],$this->session->school_id);
			$cur_day_skills = count($rand_sel);	
			if($cur_day_skills == 0)
			{				  
					$this->fn_Rand_games($uid, $check_date_time, $cur_day_skills, $assign_count);
			}
			else if($cur_day_skills <$assign_count)
			{	  
			   $min_date_arr = $this->Assessment_model->getSK_mindatePlay($this->session->game_plan_id,$this->session->game_grade,$uid,$gs_data['skill_id'],$this->session->school_id ,$catid);
				$this->Assessment_model->deleteSK_OldGames($catid,$this->session->game_plan_id,$this->session->game_grade,$uid,$gs_data['skill_id'],$this->session->school_id,$min_date_arr[0]['mindate']);
				
				$this->fn_SK_Rand_games($uid, $check_date_time, $cur_day_skills, $assign_count,1);	
			}	  
	  $vv++;
}
	
	 
}

public function fetchnewsfeed()
{   
	$pageno=$this->input->post('page');
	$type=$this->input->post('type');
	//echo $pageno."==".$type;exit;
	if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}
	
	$data['newsfeed']=$this->Assessment_model->getNewsFeed($this->session->school_id,$this->session->game_grade,$this->session->user_id,$type,$pageno,$this->session->astartdate,$this->session->aenddate);
	$count_of_tot_record=count($data['newsfeed']);
	$htmldata='';
	if($type=='ALL'){
	$htmldata.='<input type="hidden" value="'.$count_of_tot_record.'" id="hdnnewsfeedall" />';
	}else{
	$htmldata.='<input type="hidden" value="'.$count_of_tot_record.'" id="hdnnewsfeedmine" />';
	}
	if(count($data['newsfeed'])>0){
	foreach($data['newsfeed'] as $row)
	{ if($row['avatarimage']!=''){$src=base_url()."".$row['avatarimage'];}else{$src=base_url()."assets/images/".'avatar.png';}
	  /* if (!file_get_contents(base_url().$row['avatarimage'], 0, NULL, 0, 1)) {
             $src=base_url()."assets/images/".'avatar.png';
	} */
		//echo "<pre>";print_r($row);exit;
		$htmldata.='<li style="" class="news-item">
		<table cellpadding="4">
		<tbody><tr>
		<td><img src="'.$src.'" width="40" height="40" class="img-circle"></td>
		<td>'.$row["scenario"].'</td>
		</tr>
		</tbody></table>
		</li>';
	}
	}
	else
	{	if($this->session->avatarimage!=''){$src=base_url()."".$this->session->avatarimage;}else{$src=base_url()."assets/images/".'avatar.png';}
		$htmldata.='<li style="" class="news-item">
		<table cellpadding="4">
		<tbody><tr> 
		<td><img src="'.$src.'" width="40" height="40" class="img-circle"></td>
		<td>Welcome '.$this->session->fname.', Have a great day ! Keep playing puzzles and improve your skills !!</td>
		</tr>
		</tbody></table>
		</li>';
	}
	echo $htmldata;exit;
	
}
public function fetchnewsfeedcount()
{
	$type=$this->input->post('type');
	//echo $pageno."==".$type;exit;
	if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}
	$newsfeedcount=$this->Assessment_model->getNewsFeedCount($this->session->school_id,$this->session->game_grade,$this->session->user_id,$type);
	echo json_encode($newsfeedcount[0]);exit;
}
public function bee_smart()
{
	if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}	
	$inUID = $this->session->user_id;
	$inDateTime = date('Y-m-d');	
	$data['randomGames']=$this->Assessment_model->bee_smart($this->session->school_id,$this->session->game_grade,$inUID,$inPoints,$inType,$inScenarioID,$inDateTime);	
	
}

public function dashboard_ajax()
	{
		if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}
		
	//echo "hello"; exit;	
		$userid = $this->session->user_id;
		$check_date_time = date('Y-m-d');
		$catid=1;
		$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
		$data['skillkitenable']=$this->Assessment_model->IsSkillkitExist($this->session->user_id,$this->session->game_plan_id);
		$data['randomGames']=$this->Assessment_model->getRandomGames($check_date_time,$this->session->game_plan_id,$this->session->game_grade,$this->session->school_id);
		
		$data['assignGames']=$this->Assessment_model->getAssignGames($this->session->game_plan_id,$this->session->game_grade,$userid,$catid);
	
		
		$cur_day_skills = count($data['randomGames']);
		$assign_count = count($data['assignGames']);
		if($cur_day_skills <= 0 || $assign_count > $cur_day_skills ) {
				$this->fn_Rand_games($userid, $check_date_time, $cur_day_skills, $assign_count,$catid);
			}
		$data['randomGames']=$this->Assessment_model->getRandomGames($check_date_time,$this->session->game_plan_id,$this->session->game_grade,$this->session->school_id);
		$where = "";
		foreach($data['randomGames'] as $brainData )
		{
			$brainIds[] = $brainData['gid'];
			$active_game_ids = @implode(',',$brainIds);
			$where = " and g.gid in ($active_game_ids)";
		}
			 
		$data['actualGames'] = $this->Assessment_model->getActualGames($this->session->game_plan_id,$this->session->game_grade,$userid,$catid,$where);
		$data['actualGameCategory']=array('59'=>'Memory','60'=>'Visual Processing','61'=>'Focus and Attention','62'=>'Problem Solving','63'=>'Linguistics');
		$get_bspi_rows =$this->Assessment_model->getBSPI($userid);

		 
$res_tot_memory=$res_tot_vp=$res_tot_fa= $res_tot_ps=$res_tot_lang=0;
$res_tot_memory_i=$res_tot_vp_i=$res_tot_fa_i= $res_tot_ps_i=$res_tot_lang_i=0;
 
	foreach($get_bspi_rows as $get_res){
		
		if(($get_res['gs_id']=='59')){$res_tot_memory_i++; $res_tot_memory += $get_res['score'];}
		else{$res_tot_memory += 0.00;}
		if(($get_res['gs_id']=='60')){$res_tot_vp_i++;$res_tot_vp += $get_res['score'];}
		else{$res_tot_vp += 0.00;}
		if(($get_res['gs_id']=='61')){$res_tot_fa_i++;$res_tot_fa += $get_res['score'];}
		else{$res_tot_fa += 0.00;}
		if(($get_res['gs_id']=='62')){$res_tot_ps_i++;$res_tot_ps += $get_res['score'];}
		else{$res_tot_ps += 0.00;}
		if(($get_res['gs_id']=='63')){$res_tot_lang_i++;$res_tot_lang += $get_res['score'];}
		else{$res_tot_lang += 0.00;}
		 
	}
	if($res_tot_memory_i==0){$res_tot_memory_i=1;}
	if($res_tot_vp_i==0){$res_tot_vp_i=1;}
	if($res_tot_fa_i==0){$res_tot_fa_i=1;}
	if($res_tot_ps_i==0){$res_tot_ps_i=1;}
	if($res_tot_lang_i==0){$res_tot_lang_i=1;}
	$tot = (($res_tot_memory/$res_tot_memory_i)+($res_tot_vp/$res_tot_vp_i)+($res_tot_fa/$res_tot_fa_i)+($res_tot_ps/$res_tot_ps_i)+($res_tot_lang/$res_tot_lang_i))/5;
	$data['PlayedSkillCount']=$this->Assessment_model->getPlayedSkillCount($userid);
	
	$data['bspi'] = $tot;
 
	$restrainCalendar= $this->Assessment_model->getTrainCalendar($userid,date('Y-m-01'),date('Y-m-d'),$catid);
	$data['arrtrainCalendar']=explode(',',$restrainCalendar[0]['updateDates']);
	$data['trophies']=array();
	$data['trophies']= $this->Assessment_model->getMyCurrentTrophies($userid);

	/* $this->load->view('headerinner', $data); */
	$this->load->view('home/dashboard_ajax', $data);
	/* $this->load->view('footerinner'); */

	
	}
public function MyCurrenttrophies()
{
	$userid = $this->session->user_id;
	$data['trophies']=array();
	$data['trophies']= $this->Assessment_model->getMyCurrentTrophies($userid);

	$this->load->view('home/dashboard_mytrophies', $data);
}
public function MySkillPie()
{	$userid = $this->session->user_id;
	$data['PlayedSkillCount']=$this->Assessment_model->getPlayedSkillCount($userid);
	$this->load->view('home/dashboard_myskillpie', $data);
}
public function dashboard_ajaxnew()
{
	if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}
		$userid = $this->session->user_id;
		$check_date_time = date('Y-m-d');
		$catid=1;
		$data['PlayedSkillCount']=$this->Assessment_model->getPlayedSkillCount($userid);
		$data['randomGames']=$this->Assessment_model->getRandomGames($check_date_time,$this->session->game_plan_id,$this->session->game_grade,$this->session->school_id);
		$data['assignGames']=$this->Assessment_model->getAssignGames($this->session->game_plan_id,$this->session->game_grade,$userid,$catid);
		$cur_day_skills = count($data['randomGames']);
		$assign_count = count($data['assignGames']);
		if($cur_day_skills <= 0 || $assign_count > $cur_day_skills ) {
				$this->fn_Rand_games($userid, $check_date_time, $cur_day_skills, $assign_count,$catid);
			}
		$data['randomGames']=$this->Assessment_model->getRandomGames($check_date_time,$this->session->game_plan_id,$this->session->game_grade,$this->session->school_id);
		$where = "";
		foreach($data['randomGames'] as $brainData )
		{
			$brainIds[] = $brainData['gid'];
			$active_game_ids = @implode(',',$brainIds);
			$where = " and g.gid in ($active_game_ids)";
		}
			 
		$data['actualGames'] = $this->Assessment_model->getActualGames($this->session->game_plan_id,$this->session->game_grade,$userid,$catid,$where);
		$data['actualGameCategory']=array('59'=>'Memory','60'=>'Visual Processing','61'=>'Focus and Attention','62'=>'Problem Solving','63'=>'Linguistics');
		
/* Expire time Validation */
$maxtimofplay=$this->Assessment_model->getMaxTimeofPlay();
$sumoftottimeused=$this->Assessment_model->getSumofUserUsedTime($userid,date('Y-m-d'));
$data['maxtimeofplay']=$maxtimofplay[0]['value'];
$data['sumoftottimeused']=$sumoftottimeused[0]['LoggedIntime'];
$data['Remainingtime']=$maxtimofplay[0]['value']-$sumoftottimeused[0]['LoggedIntime'];
if($sumoftottimeused[0]['LoggedIntime']>=$maxtimofplay[0]['value'])
{
	$this->TodayTimerInsert();
}
/* Expire time Validation */

	/* $this->load->view('headerinner', $data); */
	$this->load->view('home/dashboard_ajaxnew', $data);
	/* $this->load->view('footerinner'); */
}
public function leaderboard()
{
		if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}
		$userid = $this->session->user_id;
		$get_bspi_rows =$this->Assessment_model->getBSPI($userid);

		 
		$res_tot_memory=$res_tot_vp=$res_tot_fa= $res_tot_ps=$res_tot_lang=0;
		$res_tot_memory_i=$res_tot_vp_i=$res_tot_fa_i= $res_tot_ps_i=$res_tot_lang_i=0;

	foreach($get_bspi_rows as $get_res){
		
		if(($get_res['gs_id']=='59')){$res_tot_memory_i++; $res_tot_memory += $get_res['score'];}
		else{$res_tot_memory += 0.00;}
		if(($get_res['gs_id']=='60')){$res_tot_vp_i++;$res_tot_vp += $get_res['score'];}
		else{$res_tot_vp += 0.00;}
		if(($get_res['gs_id']=='61')){$res_tot_fa_i++;$res_tot_fa += $get_res['score'];}
		else{$res_tot_fa += 0.00;}
		if(($get_res['gs_id']=='62')){$res_tot_ps_i++;$res_tot_ps += $get_res['score'];}
		else{$res_tot_ps += 0.00;}
		if(($get_res['gs_id']=='63')){$res_tot_lang_i++;$res_tot_lang += $get_res['score'];}
		else{$res_tot_lang += 0.00;}
		 
	}
		if($res_tot_memory_i==0){$res_tot_memory_i=1;}
		if($res_tot_vp_i==0){$res_tot_vp_i=1;}
		if($res_tot_fa_i==0){$res_tot_fa_i=1;}
		if($res_tot_ps_i==0){$res_tot_ps_i=1;}
		if($res_tot_lang_i==0){$res_tot_lang_i=1;}
		$tot = (($res_tot_memory/$res_tot_memory_i)+($res_tot_vp/$res_tot_vp_i)+($res_tot_fa/$res_tot_fa_i)+($res_tot_ps/$res_tot_ps_i)+($res_tot_lang/$res_tot_lang_i))/5;
		$data['bspi'] = $tot;
		
		//$data['academicyear'] = $this->Assessment_model->getacademicyear(); 
		$startdate = $this->session->astartdate;
		$enddate = $this->session->aenddate;
		$data['academicmonths'] = $this->Assessment_model->getacademicmonths($startdate,$enddate); 

		/* $getTopSparkiesValue=$this->Assessment_model->getTopSparkiesValue($startdate,$enddate,$this->session->school_id,$this->session->game_grade);
		 //if(34696==$userid){echo "lll"; exit;}
		$getTopPlayedGames=$this->Assessment_model->getTopPlayedGames($startdate,$enddate,$this->session->school_id,$this->session->game_grade);
		
		$getTopBSPIScore=$this->Assessment_model->getTopBSPIScore($startdate,$enddate,$this->session->school_id,$this->session->game_grade);
 
		$getSuperAngels=$this->Assessment_model->getSuperAngels($startdate,$enddate,$this->session->school_id,$this->session->game_grade);
		//echo "<pre>";print_r($data['getSuperAngels']);exit;
		
		$superbrain=array();
		foreach($getTopBSPIScore as $row)
		{
			$superbrain[$row['monthNumber']]=$row['username'];
		}
		$data['superbrain']=$superbrain;
		//echo "<pre>";print_r($superbrain);exit;
		$Sparkies=array();
		foreach($getTopSparkiesValue as $row)
		{
			$Sparkies[$row['monthNumber']]=$row['username'];
		}
		$data['Sparkies']=$Sparkies;
		
		$supergoer=array();
		foreach($getTopPlayedGames as $row)
		{
			$supergoer[$row['monthNumber']]=$row['username'];
		}
		$data['SuperGoer']=$supergoer;
		
		
		$superagels=array();
		foreach($getSuperAngels as $row)
		{
			$superagels[$row['monthNumber']]=$row['username'];
		}
		$data['getSuperAngels']=$superagels; */

/*-------------------- New Leader Board Code Modification --------------------*/
$arrCrownyBadge=$this->Assessment_model->getTopBadge($this->session->school_id,$this->session->game_grade,'CB');//Crownies-Badge
$arrSuperAngelBadge=$this->Assessment_model->getTopBadge($this->session->school_id,$this->session->game_grade,'SAB');//Super Angel-Badge
$arrSuperBrainBadge=$this->Assessment_model->getTopBadge
($this->session->school_id,$this->session->game_grade,'SBB');//Super Brain-Badge
$arrSuperGoerBadge=$this->Assessment_model->getTopBadge
($this->session->school_id,$this->session->game_grade,'SGB');//Super Goer-Badge

$CrownyBadge=array();
foreach($arrCrownyBadge as $row)
{
	$CrownyBadge[$row['monthnumber']]=$row['username'];
}
$data['CrownyBadge']=$CrownyBadge;
$SuperAngelBadge=array();
foreach($arrSuperAngelBadge as $row)
{
	$SuperAngelBadge[$row['monthnumber']]=$row['username'];
}
$data['SuperAngelBadge']=$SuperAngelBadge;
$SuperBrainBadge=array();
foreach($arrSuperBrainBadge as $row)
{
	$SuperBrainBadge[$row['monthnumber']]=$row['username'];
}
$data['SuperBrainBadge']=$SuperBrainBadge;
$SuperGoerBadge=array();
foreach($arrSuperGoerBadge as $row)
{
	$SuperGoerBadge[$row['monthnumber']]=$row['username'];
}
$data['SuperGoerBadge']=$SuperGoerBadge;
/*-------------------- New Leader Board Code Modification --------------------*/

	$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
	$data['skillkitenable']=$this->Assessment_model->IsSkillkitExist($this->session->user_id,$this->session->game_plan_id);
	$data['sparkies']=$this->MySparkies();	
	$this->load->view('headerinner', $data);
	$this->load->view('leaderboard/leaderboard', $data);
	$this->load->view('footerinner');

}
	/* Hari */
	 public function mybadges()
	{
				if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}

		$userid = $this->session->user_id;
		$get_bspi_rows =$this->Assessment_model->getBSPI($userid);

		 
$res_tot_memory=$res_tot_vp=$res_tot_fa= $res_tot_ps=$res_tot_lang=0;
$res_tot_memory_i=$res_tot_vp_i=$res_tot_fa_i= $res_tot_ps_i=$res_tot_lang_i=0;
 
	foreach($get_bspi_rows as $get_res){
		
		if(($get_res['gs_id']=='59')){$res_tot_memory_i++; $res_tot_memory += $get_res['score'];}
		else{$res_tot_memory += 0.00;}
		if(($get_res['gs_id']=='60')){$res_tot_vp_i++;$res_tot_vp += $get_res['score'];}
		else{$res_tot_vp += 0.00;}
		if(($get_res['gs_id']=='61')){$res_tot_fa_i++;$res_tot_fa += $get_res['score'];}
		else{$res_tot_fa += 0.00;}
		if(($get_res['gs_id']=='62')){$res_tot_ps_i++;$res_tot_ps += $get_res['score'];}
		else{$res_tot_ps += 0.00;}
		if(($get_res['gs_id']=='63')){$res_tot_lang_i++;$res_tot_lang += $get_res['score'];}
		else{$res_tot_lang += 0.00;}
		 
	}
	if($res_tot_memory_i==0){$res_tot_memory_i=1;}
	if($res_tot_vp_i==0){$res_tot_vp_i=1;}
	if($res_tot_fa_i==0){$res_tot_fa_i=1;}
	if($res_tot_ps_i==0){$res_tot_ps_i=1;}
	if($res_tot_lang_i==0){$res_tot_lang_i=1;}
	$tot = (($res_tot_memory/$res_tot_memory_i)+($res_tot_vp/$res_tot_vp_i)+($res_tot_fa/$res_tot_fa_i)+($res_tot_ps/$res_tot_ps_i)+($res_tot_lang/$res_tot_lang_i))/5;

	
	$data['bspi'] = $tot;
	
	//$data['academicyear'] = $this->Assessment_model->getacademicyear(); 
	$startdate = $this->session->astartdate;
	$enddate = $this->session->aenddate;
	$gradeid = $this->session->game_grade;
	$schoolid = $this->session->school_id;
	
	$data['superbrainb'] = $this->Assessment_model->getbadgeone($startdate,$enddate,$gradeid,$userid,$schoolid);
	$data['supergoerb'] = $this->Assessment_model->getbadgetwo($startdate,$enddate,$gradeid,$userid,$schoolid);
	$data['superangelb'] = $this->Assessment_model->getbadgethree($startdate,$enddate,$gradeid,$userid,$schoolid);
	 
	 $data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
	 $data['skillkitenable']=$this->Assessment_model->IsSkillkitExist($this->session->user_id,$this->session->game_plan_id);
	$data['sparkies']=$this->MySparkies();	 
		$this->load->view('headerinner', $data);
        $this->load->view('mybadges/mybadges', $data);
		$this->load->view('footerinner');
		
	}
	
	 public function mythemes()
	{
	
		if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}

		$userid = $this->session->user_id;
		$get_bspi_rows =$this->Assessment_model->getBSPI($userid);

		 
		$res_tot_memory=$res_tot_vp=$res_tot_fa= $res_tot_ps=$res_tot_lang=0;
		$res_tot_memory_i=$res_tot_vp_i=$res_tot_fa_i= $res_tot_ps_i=$res_tot_lang_i=0;
 
	foreach($get_bspi_rows as $get_res){
		
		if(($get_res['gs_id']=='59')){$res_tot_memory_i++; $res_tot_memory += $get_res['score'];}
		else{$res_tot_memory += 0.00;}
		if(($get_res['gs_id']=='60')){$res_tot_vp_i++;$res_tot_vp += $get_res['score'];}
		else{$res_tot_vp += 0.00;}
		if(($get_res['gs_id']=='61')){$res_tot_fa_i++;$res_tot_fa += $get_res['score'];}
		else{$res_tot_fa += 0.00;}
		if(($get_res['gs_id']=='62')){$res_tot_ps_i++;$res_tot_ps += $get_res['score'];}
		else{$res_tot_ps += 0.00;}
		if(($get_res['gs_id']=='63')){$res_tot_lang_i++;$res_tot_lang += $get_res['score'];}
		else{$res_tot_lang += 0.00;}
		 
	}
		if($res_tot_memory_i==0){$res_tot_memory_i=1;}
		if($res_tot_vp_i==0){$res_tot_vp_i=1;}
		if($res_tot_fa_i==0){$res_tot_fa_i=1;}
		if($res_tot_ps_i==0){$res_tot_ps_i=1;}
		if($res_tot_lang_i==0){$res_tot_lang_i=1;}
		$tot = (($res_tot_memory/$res_tot_memory_i)+($res_tot_vp/$res_tot_vp_i)+($res_tot_fa/$res_tot_fa_i)+($res_tot_ps/$res_tot_ps_i)+($res_tot_lang/$res_tot_lang_i))/5;

	
		$data['bspi'] = $tot;
		//$data['academicyear'] = $this->Assessment_model->getacademicyear(); 
		$startdate = $this->session->astartdate;
		$enddate = $this->session->aenddate;
		$gradeid = $this->session->game_grade;

	
		$data['themeslist'] = 	$this->Assessment_model->getthemefile();
	
		$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
		$data['skillkitenable']=$this->Assessment_model->IsSkillkitExist($this->session->user_id,$this->session->game_plan_id);
		$data['sparkies']=$this->MySparkies();	
		$this->load->view('headerinner', $data);
        $this->load->view('mythemes/mythemes', $data);
		$this->load->view('footerinner');
		
	}	
	public function updatethemefile()
	{
		$filename = $_POST['filename'];
		$userid = $this->session->user_id;
		
		$changetheme=$this->Assessment_model->updatethemefile($filename,$userid);	
	} 
	public function getOverAllTopperList()
	{
		$type=$this->input->post('type');
		//$data['academicyear'] = $this->Assessment_model->getacademicyear(); 
		$startdate = $this->session->astartdate;
		$enddate = $this->session->aenddate;
		//$data['academicmonths'] = $this->Assessment_model->getacademicmonths($startdate,$enddate);
		
		//echo "<pre>";print_r($getTopSparkiesValue);exit;
		if($type=='BSPI')
		{	
			$getTopBSPIScore=$this->Assessment_model->getOverallBspiToppernew($startdate,$enddate,$this->session->school_id,$this->session->game_grade);
			if(COUNT($getTopBSPIScore)>0)
			{
				foreach($getTopBSPIScore as $row1)
				{			
					$arrsch=explode(',',$row1['school_name']);
					$arruser=explode(',',$row1['studentname']);
					//echo "<pre>";print_r($arrsch);echo "<br/>";
					if(count($arrsch)>1)
					{
						for($i=0;$i<count($arrsch);$i++)
						{
							$data1.="<li class='news-item'><div class='main'>".$row1['classname']." - <span style='color:green'>".ROUND($row1['bspi'],2)."</span></div><div class='sub'>".$arruser[$i]."</div></li>";
						}
					}
					else
					{
							$data1.="<li class='news-item'><div class='main'>".$row1['classname']." - <span style='color:green'>".ROUND($row1['bspi'],2)."</span></div><div class='sub'>".str_replace(',',', ',$row1['studentname'])."</div></li>";
					}
				}
			}
			else
			{	$data1.="<li class='news-item'><div class='norecord'>No record found</div></li>";
			}
			
		}
		else
		{
			$getTopSparkiesValue=$this->Assessment_model->getOverallSparkyToppernew($startdate,$enddate,$this->session->school_id,$this->session->game_grade);
			if(COUNT($getTopSparkiesValue)>0)
			{
				foreach($getTopSparkiesValue as $row)
				{				
					$arrsch=explode(',',$row['school_name']);
					$arruser=explode(',',$row['studentname']);
					//echo "<pre>";print_r($arrsch);echo "<br/>";
					if(count($arrsch)>1)
					{
						for($i=0;$i<count($arrsch);$i++)
						{ //echo $arrsch[$i];
							$data1.="<li class='news-item'><div class='main'>".$row['classname']." - <span style='color:green'>".ROUND($row['points'],0)."</span></div><div class='sub'>".$arruser[$i]."</div></li>";
						}
					}
					else
					{
						$data1.="<li class='news-item'><div class='main'>".$row['classname']." - <span style='color:green'>".ROUND($row['points'],0)."</span></div><div class='sub'>".str_replace(',',', ',$row['studentname'])."</div></li>";
					}
				}
			}
			else
			{	$data1.="<li class='news-item'><div class='norecord'>No record found</div></li>";
			}
			
		}
		
		
		echo $data1;exit;
	}
	public function MySparkies()
	{
		$sparkies_total_points=$this->Assessment_model->getMyCurrentSparkies($this->session->school_id,$this->session->game_grade,$this->session->user_id,$this->session->astartdate,$this->session->aenddate); 	
		if ($this->session->user_id && isset($this->session->issparkies)){ 
			if($this->session->sparkiespoints!=0){
				$sparkiestotpoints=$sparkies_total_points[0]['mysparkies']-$this->session->sparkiespoints;
			}	
			else{ 
				$sparkiestotpoints=$sparkies_total_points[0]['mysparkies'];
			}		
		}
		else{ 
				$sparkiestotpoints=$sparkies_total_points[0]['mysparkies'];
		}

		return $sparkiestotpoints;		
	}
	
	public function islogin()
	{ 
		if (!empty($_POST))
		{			 
			$exeislogin = $this->Assessment_model->islogin($this->input->post('email'),$this->input->post('pwd'),$this->config->item('ideal_time'));
			echo $exeislogin[0]->islogin;exit;
		}
	}
	public function checkuserisactive()
	{
			$this->Assessment_model->update_login_log($this->session->user_id,$this->session->login_session_id);
		$exeislogin = $this->Assessment_model->checkuserisactive($this->session->user_id,$this->session->login_session_id);
		//echo $exeislogin[0]->isalive;exit;
		if($exeislogin[0]->isalive!=1)
		{ 	
	//$exeislogin = $this->Assessment_model->updateuserloginstatus($this->session->user_id,$this->session->login_session_id);
			$this->session->unset_userdata();
			$this->session->sess_destroy();
			echo 1;exit;
		}
		else
		{
			echo 0;exit;
		}
	}
	public function checkbandwidthisexist()
	{
		$exeislogin = $this->Assessment_model->checkbandwidthisexist($this->session->school_id);
		echo $exeislogin[0]['isexist'];exit;
	}
	public function insertbandwidth()
	{	$Bps=$_POST['Bps'];
		$Kbps=$_POST['Kbps'];
		$Mbps=$_POST['Mbps'];
		$exeislogin = $this->Assessment_model->insertbandwidth($this->session->school_id,$this->session->user_id,$Bps,$Kbps,$Mbps);
	}	
	public function termsofservice()
	{
  $this->load->view('header');
  $this->load->view('footerpages/termsofservice');
  $this->load->view('footer');
	}
	
	public function privacypolicy()
	{
  $this->load->view('header');
  $this->load->view('footerpages/privacypolicy');
  $this->load->view('footer');
	}
	
	public function faq()
	{
  $this->load->view('header');
  $this->load->view('footerpages/faq');
  $this->load->view('footer');
	}
public function mycurrentbspi()
{
$get_bspi_rows =$this->Assessment_model->getBSPI($this->session->user_id);
$res_tot_memory=$res_tot_vp=$res_tot_fa= $res_tot_ps=$res_tot_lang=0;
$res_tot_memory_i=$res_tot_vp_i=$res_tot_fa_i= $res_tot_ps_i=$res_tot_lang_i=0;
 
foreach($get_bspi_rows as $get_res){
if(($get_res['gs_id']=='59')){$res_tot_memory_i++; $res_tot_memory += $get_res['score'];}
else{$res_tot_memory += 0.00;}
if(($get_res['gs_id']=='60')){$res_tot_vp_i++;$res_tot_vp += $get_res['score'];}
else{$res_tot_vp += 0.00;}
if(($get_res['gs_id']=='61')){$res_tot_fa_i++;$res_tot_fa += $get_res['score'];}
else{$res_tot_fa += 0.00;}
if(($get_res['gs_id']=='62')){$res_tot_ps_i++;$res_tot_ps += $get_res['score'];}
else{$res_tot_ps += 0.00;}
if(($get_res['gs_id']=='63')){$res_tot_lang_i++;$res_tot_lang += $get_res['score'];}
else{$res_tot_lang += 0.00;}
}
if($res_tot_memory_i==0){$res_tot_memory_i=1;}
if($res_tot_vp_i==0){$res_tot_vp_i=1;}
if($res_tot_fa_i==0){$res_tot_fa_i=1;}
if($res_tot_ps_i==0){$res_tot_ps_i=1;}
if($res_tot_lang_i==0){$res_tot_lang_i=1;}
$tot = (($res_tot_memory/$res_tot_memory_i)+($res_tot_vp/$res_tot_vp_i)+($res_tot_fa/$res_tot_fa_i)+($res_tot_ps/$res_tot_ps_i)+($res_tot_lang/$res_tot_lang_i))/5;

echo round($tot,2);exit;
	
}

public function isUser()
{
	/*
	isUser	   =0 Is not a valid user
	isUser	   =1 valid user	
	isschedule =0 Non Schedule day 
	isschedule =1 Schedule day 
	userstatus =0 User confirmation status=No
	userstatus >0 or = 1 User confirmation status=Yes
	popup      =1 Open Popup
	popup      =0 Don't Popup.Call userlogin() function
	*/
	
	if (!empty($_POST))
	{ 
	$arrisUser= $this->Assessment_model->CheckisUser($this->input->post('email'),$this->input->post('pwd'));
	//$arrisUser= $this->Assessment_model->CheckisUser('sundar','skillangels');
	$arrisschedule= $this->Assessment_model->CheckisScheduleday($arrisUser[0]['gradename'],$arrisUser[0]['section'],$arrisUser[0]['sid']);
	
	if($arrisschedule[0]['isschedule']!=0)
	{ // Schedule Day
		$arruserstatus= $this->Assessment_model->CheckUserStatus($arrisUser[0]['id']);
		if($arruserstatus[0]['userstatus']==0)
		{
			$popup=1;
		}
		else
		{
			$popup=0;
		}
	}
	else
	{  // Non Schedule Day
		$popup=1;
	}

			$response=array(
				'isUser'=>$arrisUser[0]['isUser'],
				'Username'=>$arrisUser[0]['username'],
				'gradename'=>$arrisUser[0]['gradename'],
				'grade_id'=>$arrisUser[0]['grade_id'],
				'id'=>$arrisUser[0]['id'],
				'sid'=>$arrisUser[0]['sid'],
				'section'=>$arrisUser[0]['section'],
				'isschedule'=>$arrisschedule[0]['isschedule'],
				'popup'=>$popup
			);
			//echo "<pre>";print_r($response);
			echo json_encode($response);exit;
			//echo "<pre>";print_r($arrisschedule);
		
	} 
}
public function insertuserlog()
{
	/*
	isschedule =0 Non Schedule day 
	isschedule =1 Schedule day 
	*/
	$userid=$_POST['userid'];
	$isschedule=$_POST['isschedule'];
	$type=$_POST['type'];
	if($isschedule==0)
	{	$Login_type='2';//NSTL
	}
	else
	{	$Login_type='1';//FTL
	}
	if($type=='Y')
	{	$Confirmation_type='1';//YES
	}
	else
	{	$Confirmation_type='0';//NO
	}

	$arruserstatus= $this->Assessment_model->insertuserlog($userid,$Login_type,$Confirmation_type);
	echo $arruserstatus;exit;
}
public function fetchrelateduser()
{
	$userid=$_POST['userid'];
	$username=$_POST['username'];
	$grade_id=$_POST['grade_id'];
	$section=$_POST['section'];
	$sid=$_POST['sid'];
	$isschedule=$_POST['isschedule'];
	$type=$_POST['type'];
	if($isschedule==0)
	{	$Login_type='2';//NSTL
	}
	else
	{	$Login_type='1';//FTL
	}
	if($type=='Y')
	{	$Confirmation_type='1';//YES
	}
	else
	{	$Confirmation_type='0';//NO
	}

	$last_insert_id= $this->Assessment_model->insertuserlog($userid,$Login_type,$Confirmation_type);
	
	$arrgetrelatedusers=$this->Assessment_model->fetchrelateduser($userid,$username,$grade_id,$section,$sid);
	/* $html='<ul>';
	foreach($arrgetrelatedusers as $arr)
	{
		$html.="<li><label>".$arr['']."</label>";
		$html.="<a href=''></a></li>";
	} */
}

public function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
public function toppers()
{	
	/* Check whether data insterted today or not. 
	*/
		//$arrtdyentry=$this->Assessment_model->CheckTodaydataExist();
		$this->Assessment_model->ClearToppersData();
		$getTopBSPIScore=$this->Assessment_model->InsertOverallBspiToppernew();
		$getTopSparkiesValue=$this->Assessment_model->InsertOverallSparkyToppernew();
		echo "Success";exit;
}
public function schoolswiseperiodinsert($startdate = null)
{
	if($startdate==''){$startdate=date('Y-m-d');$enddate=date('Y-m-d');}else{$startdate=$startdate;$enddate=$startdate;}
	//echo $startdate."==".$enddate;exit;
	$getSuperAngels=$this->Assessment_model->Schools_Wise_Period_Insert($startdate,$enddate);
}
/*------------- Leader Board API -------------------------*/
public function leaderboardnew($sid=null,$gradeid=null,$monthno=null)
{	if($sid!='' && $gradeid!='' && $monthno!='')
	{
		$date=Date("2018-".$monthno."-d");
		$startdate=date('Y-m-01',strtotime($date));
		$enddate=date('Y-m-t',strtotime($date));
		//echo $sid."==".$gradeid."==".$startdate ."==".$enddate;exit;
		$getTopSparkiesValue=$this->Assessment_model->InsertTopSparkiesValue($startdate,$enddate,$sid,$gradeid);

		$getTopSparkiesValue=$this->Assessment_model->InsertTopPlayedGames($startdate,$enddate,$sid,$gradeid);

		$getTopSparkiesValue=$this->Assessment_model->InsertTopBSPIScore($startdate,$enddate,$sid,$gradeid);

		$getTopSparkiesValue=$this->Assessment_model->InsertSuperAngels($startdate,$enddate,$sid,$gradeid);
			echo "Success";exit;
	}
	else
	{
		echo "Please pass valid arguments";exit;
	}
}
/*-------------------30 mins Time over concept-------------------------*/
public function TodayTimerInsert()
{
	$arrofisexist=$this->Assessment_model->IsTotayTimerExist($this->session->user_id);
	//echo "<pre>";print_r($arrofisexist);exit;
	if($arrofisexist[0]['isexist']==0){
		$this->Assessment_model->TodayTimerInsert($this->session->user_id);
	}
}
/*-------------------30 mins Time over concept END-----------------------*/


public function playeddates()
{

	$userid = $this->session->user_id;
	$data['playeddates']=$this->Assessment_model->getplayeddates($userid);
	$resJSON = json_encode($data['playeddates']);
	/* $res = str_replace('lastupdate','date', $resJSON);
	echo  str_replace('gc_id','badge', $res);exit; */
	echo $resJSON;exit;
	//echo json_encode(array("date"=>$data['playeddates'])); exit;
	
}

}
