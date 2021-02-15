<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

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
				$this->load->model('Api_model');
				$this->load->model('Assessment_model');
				//$this->lang->load("menu_lang","french");		
			
        }
		
	public function index()
	{			
		$this->load->view('header');
		$this->load->view('index');
		$this->load->view('footer');
		
	}
	
	public function userlogin()
	{
		
		$username = '20180424demouser123456';
		$key = 'ee6159d8533689bf5c2a82da49475e8663739646';
		//$username = $this->input->post('userKey');
		//$key = $this->input->post('encData');
		
		
		
		
	if((isset($username) && $username!='' ) && (isset($key) && $key!=''))
		
		{
			
		$salt1=date('Y-m-d');
		$salt2='5e974ac8492703a68ab5638cedce9d70';
		$hashdata=$username;
	
		$salted_data = $salt1 . $hashdata . $salt2;
		$pwdhash = sha1($salted_data);
		
	if($key=='ee6159d8533689bf5c2a82da49475e8663739646')
		
		{
			
		$data['query'] = $this->Api_model->checklogin($username);
		
		if(isset($data['query'][0]->id))
			{
				
		 if(isset($data['query'][0]->portal_type) && $data['query'][0]->portal_type=='ASAP')
			{
				$data = $username;
				//$this->session->set_flashdata('app_post_data',$data);
				//redirect('http://localhost/assessments/index.php/api/userlogin/"'.$username.'"/"'.$key.'"');
				redirect("http://localhost/assessments/index.php/api/asapuserlogin/".$username."/".$key."/");
			} 
				
				
				
				
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
 
if((isset($login_count) && $login_count<=1) || $prelogin_date == "0000-00-00")
{
$greetings_content = 'Thanks for subscribing to SkillAngels. I am sure you will enjoy the learning process.<br/> Good Luck';
}
elseif((isset($login_count) && $login_count>1) && $datediff <3 )
{
$greetings_content ='You last played on '.date("d-m-Y", strtotime($prelogin_date)).' <br/> Nice to see you pay so much <br/> attention';
}
elseif((isset($login_count) && $login_count>1) && ($datediff >= 3 && $datediff < 7 ))
{
$greetings_content =' You last played on '.date("d-m-Y", strtotime($prelogin_date)).'.<br/>
You were missing for the last '.$datediff.'<br/>
You missed '.$datediff.' training <br/>
Everything Okay?';
}
elseif((isset($login_count) && $login_count>1) && ($datediff >= 7 && $datediff <= 30 ))
{
$greetings_content ='You last played on '.date("d-m-Y", strtotime($prelogin_date)).'.
<br/>You were missing for the last '.$datediff.' 
<br/>Please make it a habit to use SkillAngels regularly';
}
elseif((isset($login_count) && $login_count>1) && ($datediff > 30))
{
$greetings_content ='You last played on '.date("d-m-Y", strtotime($prelogin_date)).'.<br/>You were missing for the last '.$datediff.'<br/>That seems to be a long break. Please resume your training<br/>Good Luck';
}
$academicyear=$this->Assessment_model->getacademicyearbyschoolid($data['query'][0]->sid);
$gamepath='';
if(($data['query'][0]->grade_id == 1) || ($data['query'][0]->grade_id==2) || ($data['query'][0]->grade_id==11))
{
	$gamepath = 'kinder';
}
else {
	$gamepath = 3;
}
$this->session->set_userdata(array(
				'userlang'       => $gamepath,
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
		
		
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
 $ip=$_SERVER['HTTP_CLIENT_IP'];}
 elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
 $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];} else {
 $ip=$_SERVER['REMOTE_ADDR'];}		
$this->Assessment_model->insert_login_log($data['query'][0]->id,$uniqueId,$ip,$this->input->post('txcountry'),$this->input->post('txregion'),$this->input->post('txcity'),$this->input->post('txisp'),$_SERVER['HTTP_USER_AGENT'],1);			
		
		
		//echo $result=1; exit;
		redirect('index.php/home/dashboard#View');

			} 
			else { 
			
			$data['response'] = 'Please provide valid credentials';
			$this->load->view('uat/response', $data);
			
				}
		}
			else { 
			
			$data['response'] =  'encData is not matched'; 
			$this->load->view('uat/response', $data);
			
				}
		
		}
			else { 

			$data['response'] = 'Please provide the all required parameters';
			$this->load->view('uat/response', $data);			
			
				}		
		
				}


	
}