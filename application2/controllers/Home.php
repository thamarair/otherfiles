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
				$this->load->library('My_PHPMailer'); 
				if (isset($this->session->user_id))
				{
					date_default_timezone_set($this->session->timezone);
				}
        }
		
	public function index()
	{			
		$this->load->view('header');
		$this->load->view('index');
		$this->load->view('footer');
		
	}
	public function testview()
	{//echo "jjjtg";exit;
	
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
		//echo "jjjkk";exit;
		
		//$data['getip'] = $this->Assessment_model->getipaddress($userid);
		
		if (!empty($_POST))
		{ 
			 
			$data['query'] = $this->Assessment_model->checkUser($this->input->post('email'),$this->input->post('pwd'), $this->input->post('ddlLanguage'));
			 
			
			 
			if(isset($data['query'][0]->id)){
					
				date_default_timezone_set($data['query'][0]->time_zone);
				
				
				//$data['isuser_tfeedback']=$this->Assessment_model->isuser_tfeedback($data['query'][0]->id);
				//$isusertfdbk = $data['isuser_tfeedback'][0]['total'];
				
				/*Brain test comment*/
				/*$data['braintest']=$this->Assessment_model->braintest($data['query'][0]->sid,$data['query'][0]->grade_id);
				$data['isuserplayed_BT']=$this->Assessment_model->isuserplayed_BT($data['query'][0]->id);		
				$btcount = $data['isuserplayed_BT'][0]['total'];
				$bstartdate  = $data['braintest'][0]['startdate'];
				$enddate  = $data['braintest'][0]['enddate'];
				$curdate = date('Y-m-d');
				
				if($bstartdate<=$curdate && $curdate <= $enddate)
				{
					$isbraintest=1; //Enabled
					$this->session->set_userdata('isbraintest',$isbraintest);
				}
				else if($btcount>0)

				{ 
					$isbraintest=0;
					$this->session->set_userdata('isbraintest',$isbraintest); 
				}*/
				$btcount=0;
				$isbraintest=0;
				$this->session->set_userdata('isbraintest',$isbraintest);
				/*Brain test commen*/
				//192.168.10.153
				
				$ipa = $data['query'][0]->ipa;
				/* echo"<pre>";
				print_r($ipa); */
				$ipadress=explode(",",$ipa);
				 /* echo"<pre>";
				 print_r($ipadress); */
				 $ip=$_SERVER['REMOTE_ADDR'];
			//	$sip = "192.168.10.150";
				 if(in_array($ip,$ipadress)){
					
				}
				else{
					echo "IVIP";exit;
				}  
				
				
					 
				/* if($Tstartdate<=$curdate && $curdate <= $Tenddate && $isusertfdbk==0)
		{
			$isteachers_popup=1; //Enabled
			$this->session->set_userdata('isteachers_popup',$isteachers_popup);
			//echo $result = 'BT';
		}
		else {
			
			$isteachers_popup=0; //Disabled
			$this->session->set_userdata('isteachers_popup',$isteachers_popup);
		} */
// update prelogin and login date
// get login count
// update login count by 1
// based on login count set welcome message

/* Creating unique login ID */
$uniqueId = $data['query'][0]->id."".date("YmdHis")."".round(microtime(true) * 10);
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
$gradename=$data['query'][0]->gradename;
$usergrade = $data['query'][0]->grade_id;

$data['chkprevioussession'] = $this->Assessment_model->chkprevioussession($data['query'][0]->id,$usergrade,$data['query'][0]->section,$data['query'][0]->sid);
$previou_sessiondate = $data['chkprevioussession'][0]['lastsessiondate'];

if($isbraintest==1)
{
$Sclass = 'commonmsg';
$greetings_content ='<div style="padding:7%;"><h3 style="color:#ff6600;">Hey '.$fname.'..</h3><p style="font-size: 23px; color:#000;">Welcome to the HOTS Olympiad !!</p></div>';
} 
else if((isset($login_count) && $login_count<=1) || $prelogin_date == "0000-00-00")
{
	$Fclass = 'firstlogincls';
	$greetings_content = '<ul><li>Here you go …! 😊</li><li>Each session will have 5 skills to be completed.</li><li>You can play maximum of 5 times in a day provided a time period of 40 minutes. </li><li>Skill Kit will show the skills you need to concentrate and to learn more.</li><li>e-Certificates will be awarded if you are a topper …</li><li>You will get Crownies for each day you play …</li><li>Your trophies will be increased based on your performance…</li><li>Get set and here you go!  START!</li></ul>'; 

}
elseif((isset($previou_sessiondate) && $previou_sessiondate==0))
{
	$Sclass = 'commonmsg';
$greetings_content ='<div style="padding:7%;"><h3 style="color:#ff6600;">Hey '.$fname.'..</h3><p style="font-size: 23px; color:#000;">Welcome back to the Happy Planet. Missed you!!</p></div>';
}


elseif((isset($login_count) && $login_count>1))
{
	$Sclass = 'commonmsg';
$greetings_content ='<div style="padding:8%;"><p style="font-size: 23px; color:#000;">Hello!! Welcome to happy planet!</p><p style="font-size: 23px; color:#000;">Lets have fun everyday with SkillAngels!</p></div>';
}

$academicyear=$this->Assessment_model->getacademicyearbyschoolid($data['query'][0]->sid);

/* if($data['query'][0]->grade_id==10)
{ 
	$gamepath = 'grade8'; 
}
else if($data['query'][0]->grade_id==9)
{
	$gamepath = 'grade7'; 
}
else if($data['query'][0]->grade_id==8)
{
	$gamepath = 'grade6'; 
}
else
{
	$gamepath = 3; 
} */


/* if($data['query'][0]->grade_id==3)
{
	$gamepath = 'g11'; 
}
else if($data['query'][0]->grade_id==4)
{
	$gamepath = 'grade2'; 
}
else if($data['query'][0]->grade_id==5)
{
	$gamepath = 'grade3'; 
}
else if($data['query'][0]->grade_id==6)
{
	$gamepath = 'grade4'; 
}
else if($data['query'][0]->grade_id==7)
{
	$gamepath = 'grade5'; 
}
else if($data['query'][0]->grade_id==8 || $data['query'][0]->grade_id==12)
{
	$gamepath = 'grade6'; 
}
else if($data['query'][0]->grade_id==9 || $data['query'][0]->grade_id==13)
{
	$gamepath = 'grade7'; 
}
else if($data['query'][0]->grade_id==10 || $data['query'][0]->grade_id==14 || $data['query'][0]->grade_id==15)
{
	$gamepath = 'grade8'; 
} */

$gamepath ='clp';

if($data['query'][0]->sid==100 || $data['query'][0]->sid==101 ||  $data['query'][0]->sid==125)
{
	$Play_Times=1;
}
else
{
	$Play_Times=5;
}




$this->session->set_userdata(array(
				'userlang'       =>$gamepath,
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
				'firstlogincls' => $Fclass,
				'commonmsg' => $Sclass,
				'avatarimage'=>$data['query'][0]->avatarimage,
				'login_session_id'=>$uniqueId, 
				'astartdate'=>$academicyear[0]['startdate'],
				'aenddate'=>$academicyear[0]['enddate'],
				'btestlevel'=>$data['braintest'][0]['level'],
				'bstartdate'=>$data['braintest'][0]['startdate'],
				'benddate'=>$data['braintest'][0]['enddate'],
				'braingamepath'=>'braintest',
				'PlayTimes'=>$Play_Times,
				'timezone'=>$data['query'][0]->time_zone,
				'timezone_offset'=>date('P'),
				'lang_id' => $data['query'][0]->lang_id
));

$r=$array = json_decode(json_encode($data['query'][0]), True);


	
	

$SessionLevel=$this->Assessment_model->getCurrentSessionLevel($this->session->user_id);
$DefaultCycle=$this->Assessment_model->getcyclevalue();

					if($SessionLevel[0]['session_id']!='')
						{ 
							foreach($DefaultCycle as $cycle)
							{
								$next_session_level_id=$SessionLevel[0]['session_id']+1;
								$range=explode('-',$cycle['value']);
								//echo "<pre>";print_r($range);
								if($range[0]<=$SessionLevel[0]['session_id'] && $range[1]>=$SessionLevel[0]['session_id'])
								{
									$Session_StartRange=$range[0];
									$Session_EndRange=$range[1];
								}
								if($range[0]<=$next_session_level_id && $range[1]>=$next_session_level_id)
								{
									$Next_Session_StartRange=$range[0];
									$Next_Session_EndRange=$range[1];
								}
							}
							$this->session->set_userdata('Session_StartRange', $Session_StartRange);
							$this->session->set_userdata('Session_EndRange', $Session_EndRange);
							$this->session->set_userdata('Next_Session_StartRange', $Next_Session_StartRange);
							$this->session->set_userdata('Next_Session_EndRange', $Next_Session_EndRange);
							$this->session->set_userdata('Session_Curid', $SessionLevel[0]['session_id']);
							$this->session->set_userdata('Next_Session_id', $SessionLevel[0]['session_id']+1);
						}
					else
						{
							$SessionVar=$DefaultCycle[0]['value'];
							$range=explode("-",$SessionVar);
							
							$Session_StartRange=$range[0];
							$Session_EndRange=$range[1];
							
							$Next_Session_StartRange=$range[0];
							$Next_Session_EndRange=$range[1];
							
							$this->session->set_userdata('Session_StartRange', $Session_StartRange);
							$this->session->set_userdata('Session_EndRange', $Session_EndRange);
							$this->session->set_userdata('Next_Session_StartRange', $Next_Session_StartRange);
							$this->session->set_userdata('Next_Session_EndRange', $Next_Session_EndRange);
							$this->session->set_userdata('Session_Curid', 1);
							$this->session->set_userdata('Next_Session_id', 1);
						}
		$confignoofdaysplay=$this->Assessment_model->getConfigNoofDaysPlay();
		$level_calc=($data['query'][0]->current_session%$confignoofdaysplay[0]['value']);
		if($level_calc==0)
		{
			$this->session->set_userdata('user_current_session',$confignoofdaysplay[0]['value']);
		}
		else
		{
			$this->session->set_userdata('user_current_session',$level_calc);
		}
		
		$isavailable=$this->Assessment_model->CheckSkillkitexist($this->session->user_id);
		$exeofnodaysplayed=$this->Assessment_model->getUserPlayedDayscount($this->session->user_id);
		
		/* echo "<pre>";print_r($isavailable); 
		echo "<pre>";print_r($exeofnodaysplayed); 
		echo "<pre>";print_r($confignoofdaysplay);exit;   */
		if($isavailable[0]['isavailable']==0)
		{
			if(($exeofnodaysplayed[0]['playedDate']!=0) && ($exeofnodaysplayed[0]['playedDate']%$confignoofdaysplay[0]['value'])==0)
			{
				$SKBSPI = $this->Assessment_model->getSKBspi($r,$this->session->Session_StartRange,$this->session->Session_EndRange);
				$MedianValue=$this->Assessment_model->getMedianValue($this->session->game_grade);
			
			$arr=array('59'=>$MedianValue[0]['median_value'],'60'=>$MedianValue[1]['median_value'],'61'=>$MedianValue[2]['median_value'],'62'=>$MedianValue[3]['median_value'],'63'=>$MedianValue[4]['median_value']);
			
			//echo "<pre>";print_r($arr);exit;
			$month_array_skill=array();
			$arrgs_id=array();
			$arrlevel=array();
			$inini=0;$ininj=1;$inink=0;
			$configrange=5;
			foreach($SKBSPI as $get_res)
			{
				$rangeval=explode('-',$arr[$get_res['gs_id']]);
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
			if(count($arrgs_id)>0)
			{
				$this->Assessment_model->insertSKGameList($r,$maxsession,$arrgs_id,$arrlevel,$this->session->Next_Session_StartRange,$this->session->Next_Session_EndRange);
				$skillkit_content='Personalized skill kit puzzles are enabled for you.';
				$this->session->set_userdata('skillkit_content', $skillkit_content);
			}
			else
			{
				$this->Assessment_model->updateSKGameList($r);
			}
			
			} 
		}
		
		$language = $data['query'][0]->languagekey;
		$language = ($language != "") ? $language : "english";
        $this->session->set_userdata('site_lang', $language);
		
		$arrofinput=array("inSID"=>$this->session->school_id,"inGID"=>$this->session->game_grade,'inUID'=>$this->session->user_id,'inScenarioCode'=>'LOGIN','inTotal_Ques'=>'','inAttempt_Ques'=>'','inAnswer'=>'','inGame_Score'=>'',"inPlanid"=>$this->session->game_plan_id,'inGameid'=>'');	
		/*--- Sparkies ----*/
		$sparkies_output=$this->Assessment_model->insertsparkies($arrofinput);
		$finalpoints=$sparkies_output[0]['OUTPOINTS'];
		 /* echo "<pre>";
		print_r($finalpoints);exit;  */
	//	$finalpoints!=0 if it is not given means then it will insert the data into table.so it is required to insert the data only one time(first time login) in the table
		if($finalpoints!='' && $finalpoints!=0)
		{ 
			$isexist=1;
			$userid = $this->session->user_id;
			$data['jobprofile_popupchk'] = $this->Assessment_model->insert_jobprofile_popup($userid);
		//	echo $data['jobprofile_popupchk'];exit;
			
		}		
		else{$isexist=0;}
		
		$this->session->set_userdata('issparkies',$isexist);	
		$this->session->set_userdata('sparkiespoints',$finalpoints);
		
		/* $userid = $this->session->user_id;
	$data['popupchk'] = $this->Assessment_model->popupche	ck($userid); */
	//echo $data['popupchk'];exit;
		
		//$data['academicyear'] = $this->Assessment_model->getacademicyear(); 
		$startdate=$this->session->astartdate;
		$enddate=$this->session->aenddate;
		
		
		$data['skillkitenable']=$this->Assessment_model->IsSkillkitExist($this->session->user_id,$this->session->game_plan_id);
		$this->session->set_userdata('skillkitactive',$data['skillkitenable'][0]['isenable']);
		
		if(isset($data['skillkitenable'][0]['isenable']) && $data['skillkitenable'][0]['isenable']>=1)
		{
			$this->session->set_userdata('TimerRunningStatus','N'); // Don't run the Timer Now.
		}
		else
		{
			$this->session->set_userdata('TimerRunningStatus','Y'); //Run the Timer Now.
		}
		
		
		//$this->Assessment_model->GetBadgeData($this->session->school_id,$this->session->game_grade,$startdate,$enddate);
		//$this->Assessment_model->insertnewsfeeddata($arrofinput);
	    //$this->Assessment_model->termsandcondition(1,$this->input->post('email'));
		
		/*---------------------------- Quarterly Toppers Start --------------------------------*/
		/* $isbspi=$this->Assessment_model->IsBspiTopper($this->session->user_id);
		$iscrowny=$this->Assessment_model->IsCrowniesTopper($this->session->user_id);
		$isarrofskill=$this->Assessment_model->IsSkillTopper($this->session->user_id);
		
		
		
		if($isbspi[0]['topper']>0){$this->session->set_userdata('IsBspiTopper',1);}else{$this->session->set_userdata('IsBspiTopper',0);}
		if($iscrowny[0]['topper']>0){$this->session->set_userdata('IsCrowniesTopper',1);}else{$this->session->set_userdata('IsCrowniesTopper',0);}
		$topskills = count($isarrofskill);
		if($topskills>0){$this->session->set_userdata('Topskillscount',$topskills);}else{$this->session->set_userdata('Topskillscount',0);}
		if(count($isarrofskill)>0)
		{
			foreach($isarrofskill as $skill)
			{
				$this->session->set_userdata("B".$skill['gs_id'],1);
			}
		} */
		
		/*---------------------------- Quarterly Toppers End --------------------------------*/		


		
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
 $ip=$_SERVER['HTTP_CLIENT_IP'];}
 elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
 $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];} else {
 $ip=$_SERVER['REMOTE_ADDR'];}		
$this->Assessment_model->insert_login_log($data['query'][0]->id,$uniqueId,$ip,$this->input->post('txcountry'),$this->input->post('txregion'),$this->input->post('txcity'),$this->input->post('txisp'),$_SERVER['HTTP_USER_AGENT'],1);	


		

		$startdate= strtotime($this->session->aenddate);
		$now= strtotime(date('Y-m-d'));
		$datediff = $startdate - $now;
		$RemainingDay=round($datediff / (60 * 60 * 24));
	
		
		
/*------------- Auto Email Trigger ------------------*/
		if($this->session->user_id=='51866' || $this->session->user_id=='52537')
		{
				$ipaddress = '';
				if (getenv('HTTP_CLIENT_IP'))
					$ipaddress = getenv('HTTP_CLIENT_IP');
				else if(getenv('HTTP_X_FORWARDED_FOR'))
					$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
				else if(getenv('HTTP_X_FORWARDED'))
					$ipaddress = getenv('HTTP_X_FORWARDED');
				else if(getenv('HTTP_FORWARDED_FOR'))
					$ipaddress = getenv('HTTP_FORWARDED_FOR');
				else if(getenv('HTTP_FORWARDED'))
				   $ipaddress = getenv('HTTP_FORWARDED');
				else if(getenv('REMOTE_ADDR'))
					$ipaddress = getenv('REMOTE_ADDR');
				else
					$ipaddress = 'UNKNOWN';
				$ip= $ipaddress;

			$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
			if($query && $query['status'] == 'success') 
			{
				$subject = 'User Login Notification - '.$this->session->fname;
				$message = '<table align="center" width="800px" border="1" cellspacing="0" cellpadding="0" style="font-size:medium;margin-right:auto;margin-left:auto;border:1px solid rgb(197,197,197);font-family:Arial,Helvetica,sans-serif;background-image:initial;background-repeat:initial;box-shadow: 10px 10px 5px #35395e;"><tbody><tr style="display:block;overflow:hidden;background: #1e88e5;"><td style="float:left;border:0px;text-align: center;padding: 10px 0px;width:33%;color: #fff;"></td><td style="float:left;border:0px;text-align: center;padding: 5px 0px;width: 33%;color: #fff;">'.$this->session->fname.' Logged In Details</td><td style="float:left;border:0px;text-align: center;padding: 10px 0px;width: 33%;color: #fff;"></td></tr><tr style="padding:0px;margin:10px 42px 20px;display:block;font-size:13px;font-family:Verdana,Geneva,sans-serif;line-height:18px;text-align:justify"><td colspan="2" style="border:0px">Dear Team,<br/><br/>Please find the login details.<br/><br/>Logged in user name <strong> :'.$this->session->fname.' </strong><br/>Logged in date time<strong> : '.date("d/m/Y h:i a", strtotime(date("Y-m-d h:i a"))).'</strong><br/>Logged in IP<strong> : '.$ip.'</strong><br/>Logged in location<strong> : '.$query['country'].' - '.$query['regionName'].' - '.$query['city'].'</strong><strong></strong><br/></td></tr><tr style="display:block;overflow:hidden"><td style="float:left;border:0px;"></td></tr></tbody></table>';
				//echo $message;exit;
				$emailstatus=$this->email_login_log($subject,$message); 
				
				$this->Assessment_model->InsertAccessLog($this->session->user_id,$query['query'],$query['country'],$query['regionName'],$query['city'],$query['zip'],$emailstatus);

			}
			if($RemainingDay<=7)
			{
				$AEsubject = 'User Account Expiry Details';
				$AEmessage = '<table align="center" width="800px" border="1" cellspacing="0" cellpadding="0" style="font-size:medium;margin-right:auto;margin-left:auto;border:1px solid rgb(197,197,197);font-family:Arial,Helvetica,sans-serif;background-image:initial;background-repeat:initial;box-shadow: 10px 10px 5px #35395e;"><tbody><tr style="display:block;overflow:hidden;background: #1e88e5;"><td style="float:left;border:0px;text-align: center;padding: 10px 0px;width:33%;color: #fff;"></td><td style="float:left;border:0px;text-align: center;padding: 5px 0px;width: 33%;color: #fff;">'.$this->session->fname.' Account Expiry Details</td><td style="float:left;border:0px;text-align: center;padding: 10px 0px;width: 33%;color: #fff;"></td></tr><tr style="padding:0px;margin:10px 42px 20px;display:block;font-size:13px;font-family:Verdana,Geneva,sans-serif;line-height:18px;text-align:justify"><td colspan="2" style="border:0px">Dear Team,<br/><br/>Please find the Account Expiry Details of  '.$this->session->fname.'.<br/><br/>Logged in user name <strong> :'.$this->session->fname.' </strong><br/>Account expiry date<strong> : '.date("d/m/Y", strtotime($this->session->aenddate)).'</strong><br/></td></tr><tr style="display:block;overflow:hidden"><td style="float:left;border:0px;"></td></tr></tbody></table>';
				
				$emailstatus=$this->email_login_log($AEsubject,$AEmessage); 
			}
		}
/*--------------------Auto Email Trigger -------------------*/
	
		 
		 
			/* $data['braintest']=$this->Assessment_model->braintest($this->session->school_id,$this->session->game_grade);
			$bstartdate  = $data['braintest'][0]['startdate'];
			$enddate  =    $data['braintest'][0]['enddate'];
			$curdate =     date('Y-m-d');

			if($this->session->isbraintest==1 && $btcount==0)
			{
				echo $result = 'BT';
			}
			else  
			{
				
				echo $result=1; exit;
			
			}*/
			
			if($data['skillkitenable'][0]['isenable']>=1)
						{
							echo $result=0; exit;
							//redirect('index.php/home/skillkit');
						}
						else
						{
							echo $result=1; exit;
							//redirect('index.php/home/dashboard');
						}
			
		}
	} 
}

	public function dashboard()
	{	 
	
		if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}
		
		/* $data['isIAS']=$this->isiasenabled('FN');		
		if($data['isIAS']==1){redirect('index.php/home/iaschallenge');} */
		
	
		$userid = $this->session->user_id;//echo $userid; exit;
		$sid = $this->session->school_id;//echo $sid; exit;
		$check_date_time = date('Y-m-d');
		$lang_id = $this->session->lang_id;
		//echo $lang_id; exit;
		$catid=1;
		//$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
		$data['userthemefile'] = '';
		
		$data['getfdbksubject'] = $this->Assessment_model->getfdbksubject();
		
		$data['feedbackenable'] = $this->Assessment_model->feedbackenable($userid);
		
		$data['getjobprofile'] = $this->Assessment_model->get_jobprofile($lang_id);
		/* echo "<pre>";
		print_r($data['getjobprofile']);
		exit; */
		
		//$data['getnewjobprofile'] = $this->Assessment_model->newjobprofile();
		
		 $premnthnumber = date('m', strtotime('last month'));
		//$ugradeid = $this->session->game_grade;
		$data['maxvaluesbbadge'] = $this->Assessment_model->maxvaluesbbadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
		$a7['sbbadge'] = $this->Assessment_model->sbbadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade,$data['maxvaluesbbadge'][0]['sbtopvalue']);
		
		$data['maxvaluesabadge'] = $this->Assessment_model->maxvaluesabadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
		$a7['sabadge'] = $this->Assessment_model->sabadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade,$data['maxvaluesabadge'][0]['satopvalue']);
		
		$data['maxvaluesgbadge'] = $this->Assessment_model->maxvaluesgbadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
		$a7['sgbadge'] = $this->Assessment_model->sgbadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade,$data['maxvaluesgbadge'][0]['sgtopvalue']);
		
		/*........... ECertificateList .......*/
			$arrofec=$this->ECertificateList();
			$data['sbbadge']=$arrofec['sbbadge'];
			$data['sabadge']=$arrofec['sabadge'];
			$data['sgbadge']=$arrofec['sgbadge'];
		/*........... ECertificateList .......*/
		
		
		$data['skills'] = $this->Assessment_model->getskills();	
		
		$data['randomGames']=$this->Assessment_model->getRandomGames($check_date_time,$this->session->game_plan_id,$this->session->game_grade,$this->session->school_id);
		
		$data['assignGames']=$this->Assessment_model->getAssignGames($this->session->game_plan_id,$this->session->game_grade,$userid,$catid);
		
		$cur_day_skills = count($data['randomGames']);
		$assign_count = count($data['assignGames']);
		if($cur_day_skills <= 0 || $assign_count > $cur_day_skills)
		{
			 $this->fn_Rand_games($userid, $check_date_time, $cur_day_skills, $assign_count,$catid,$this->session->user_current_session);
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
	 
	 $restrainCalendar= $this->Assessment_model->getTrainCalendar($userid,date('Y-m-01'),date('Y-m-d'),$catid);
	 $data['arrtrainCalendar']=explode(',',$restrainCalendar[0]['updateDates']);
	 
	 $data['trophies']=array();
	 $data['trophies']= $this->Assessment_model->getMyCurrentTrophies_opt($userid,$this->session->Session_StartRange,$this->session->Session_EndRange);
	 $data['PlayedSkillCount']=$this->Assessment_model->getPlayedSkillCount($userid);
	 
	 // Check Skillkit Game Played OR NOT
		$data['skillkitenable']=$this->Assessment_model->IsSkillkitExist($this->session->user_id,$this->session->game_plan_id);
		if($data['skillkitenable'][0]['isenable']>0)
		{
			$data['skillkitplay']=$this->checkSkillkitGamePlayed();
		}
		else
		{
			$data['skillkitplay']='Y';
		}
		
		
		/* Expire time Validation */
		if($this->session->TimerRunningStatus=='Y')
		{
			$maxtimofplay=$this->Assessment_model->getMaxTimeofPlay();
			$sumoftottimeused=$this->Assessment_model->getSumofUserUsedTime($userid,date('Y-m-d'));
			$data['maxtimeofplay']=$maxtimofplay[0]['value'];
			$data['sumoftottimeused']=$sumoftottimeused[0]['LoggedIntime'];
			$data['Remainingtime']=$maxtimofplay[0]['value']-$sumoftottimeused[0]['LoggedIntime'];
			if($sumoftottimeused[0]['LoggedIntime']>=$maxtimofplay[0]['value'])
			{
				$this->TodayTimerInsert();
			}
		}
		/* Expire time Validation */

if($this->session->game_grade==100)
{
/*--------------- Math Puzzles Start ---------------*/
		$arrMathAssigned=$this->Assessment_model->checkMathAssignedToday($this->session->user_id,$this->session->game_grade);
		$arrAssignedPuzzles=$this->Assessment_model->checkTotalAssignedPuzzles($this->session->user_id,$this->session->game_grade);
		if($arrMathAssigned[0]['assigned']>0)
		{ // Already Assigne Game for a Today.
			$data['arrofmath']=$this->Assessment_model->getTodayPuzzles($this->session->user_id,$this->session->game_grade);
		}
		else
		{ // Assign New Game For today
			if($arrAssignedPuzzles[0]['assigned']>=10)
			{ // Delete Previous data and Insert
				$this->Assessment_model->DeletePrevMathCycle($this->session->user_id,$this->session->game_grade);
				$AssignedGameID=$this->Assessment_model->AssignTodayMathPuzzles($this->session->user_id,$this->session->game_grade);
				if($AssignedGameID[0]['mid'])
				{
					$this->Assessment_model->InertTodayMathPuzzles($AssignedGameID[0]['mid'],$this->session->user_id,$this->session->game_grade);
				}
			}
			else
			{// Insert new data
				$AssignedGameID=$this->Assessment_model->AssignTodayMathPuzzles($this->session->user_id,$this->session->game_grade);
				if($AssignedGameID[0]['mid'])
				{
					$this->Assessment_model->InertTodayMathPuzzles($AssignedGameID[0]['mid'],$this->session->user_id,$this->session->game_grade);
				}
			}
			$data['arrofmath']=$this->Assessment_model->getTodayPuzzles($this->session->user_id,$this->session->game_grade);
		}
		 
/* Total Score */
			$data['arrofmathscore']=$this->Assessment_model->getTotalScoreofMath($this->session->user_id);
			
			$startdate = $this->session->astartdate;
			$enddate = $this->session->aenddate;
			$data['academicmonths'] = $this->Assessment_model->getacademicmonths($startdate,$enddate);
			$data['isEligibleToday']=$this->TodayMathPuzzleEligible('FN');
/* Total Score */ 
/*--------------- Math Puzzles End ---------------*/
}	
	$data['asap_bspi']=$this->getAsapBspi();
	$data['DailyPuzzlePlayed_Status']=$this->CheckDailyPuzzlePlayed();
	$data['sparkies']=$this->MySparkies();
	
	
		//echo "<pre>";print_r($data['actualGames']);  exit;
		$this->load->view('headerinner', $data);//echo "hiittff";exit;
        $this->load->view('home/dashboard', $data);
		$this->load->view('footerinner');
	
	//redirect('index.php/home/dashboard');
	
	}
	
public function fn_Rand_games($uid, $check_date_time, $cur_day_skills, $assign_count,$catid,$user_current_session) {
$arrSkills=$this->Assessment_model->getSkillsRandom($catid);

		foreach($arrSkills as $gs_data)
		{
			$rand_sel = $this->Assessment_model->assignRandomGame($catid,$this->session->game_plan_id,$this->session->game_grade,$uid,$gs_data['skill_id'],$this->session->school_id,$user_current_session);

			$rand_count = count($rand_sel);//echo $rand_count."<=0";exit;
			if($rand_count <=0) 
			{
				$del_where = "";
				/* if($assign_count <> $cur_day_skills && $cur_day_skills > 0)
				{ */

				$del_where = " and 1=1";
				// $del_where = " and created_date = '$check_date_time'";
				$this->Assessment_model->deleteRandomGames($catid,$this->session->game_plan_id,$this->session->game_grade,$uid,$gs_data['skill_id'],$this->session->school_id,$del_where);
			 
				$rand_sel = $this->Assessment_model->assignRandomGame($catid,$this->session->game_plan_id,$this->session->game_grade,$uid,$gs_data['skill_id'],$this->session->school_id,$user_current_session);
				$rand_count = count($rand_sel);
				/* } */
			} 
			if($rand_count > 0)
			{
				$rand_data = $this->Assessment_model->insertRandomGames($catid,$this->session->game_plan_id,$this->session->game_grade,$gs_data['skill_id'],$this->session->school_id,$this->session->section,$rand_sel[0]['gid'],$check_date_time,$user_current_session);
			 
			}
		}
	  $data['randomGames']=$this->Assessment_model->getRandomGames($check_date_time,$this->session->game_plan_id,$this->session->game_grade,$this->session->school_id);
		$cur_day_skills = count($data['randomGames']);
		
		
		if($cur_day_skills == 0)
		{				  
				$this->fn_Rand_games($uid, $check_date_time, $cur_day_skills, $assign_count,$catid);
		}
		else if($cur_day_skills<count($arrSkills))
			{
				$this->Assessment_model->deleteSPLRandomGames($check_date_time,$this->session->game_plan_id,$this->session->game_grade,$this->session->school_id,$this->session->user_id);
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
		unset($_SESSION);
		session_destroy();
		$this->session->sess_destroy();
		redirect(base_url());
	}
	public function gamesajax()
	{
		$gameurl =  $_POST['gameurl']; 
		$gname = substr($gameurl, strrpos($gameurl, '/') + 1);
		$gamename = str_replace('.html','', $gname); 
		
		if($_POST['skillkit']=='N')
		{	
			//echo 'CLP'; exit;
			$data['gameid'] = $this->Assessment_model->getgameid($gamename);
			$gameid = $data['gameid'][0]['gid']; 
			$data['checkgame'] = $this->Assessment_model->checkgame($gameid);
			
			$gid = $data['checkgame'][0]['gameid']; 
			
			if($gid==1)
			{
				
			$this->session->set_userdata(array( 'currentgameid'=> $gameid ));
			//if($this->session->game_grade==10) {
			$this->session->set_userdata(array( 'newgname'=> $gamename )); //}
			$this->session->set_userdata(array( 'isskillkit'=> $_POST['skillkit'] ));
			echo $this->session->currentgameid;exit;
			}
			else{
				
				echo 'IA'; exit;
			}
		}
		else if($_POST['skillkit']=='BT')
		{	 
			$data['gameid'] = $this->Assessment_model->getgameid_BT($gamename);
			$gameid = $data['gameid'][0]['gid'];
			$this->session->set_userdata(array( 'currentgameid'=> $gameid ));
		//	$this->session->set_userdata(array( 'currentlanguage'=> '101' ));
			$this->session->set_userdata(array( 'isskillkit'=> $_POST['skillkit'] ));
			echo $this->session->currentgameid;exit;
		}
		else
		{	
			$data['gameid'] = $this->Assessment_model->getgameid_SK($gamename);
			$gameid = $data['gameid'][0]['gid'];
			$this->session->set_userdata(array( 'currentgameid'=> $gameid ));
			$this->session->set_userdata(array( 'isskillkit'=> $_POST['skillkit'] ));
			echo $this->session->currentgameid;exit;
		}
		
		/* if($_POST['skillkit']!='Y')
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
		} */

	}
	
	
	public function result()
	{
		if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php'); exit;}
		if(!isset($_POST)){redirect('index.php'); exit;}
		if(empty($_POST)){redirect('index.php'); exit;}

		$total_ques=$_POST["tqcnt1"];

		if($_POST["aqcnt1"]>10){$attempt_ques=10;}else{$attempt_ques=$_POST["aqcnt1"];}

		$answer=$_POST["cqcnt1"];
		$score=$_POST["gscore1"];
		$a6=$_POST["gtime1"];
		$a7=$_POST["rtime1"];
		$a8=$_POST["crtime1"];
		$a9=$_POST["wrtime1"];	
		$gameid=$this->session->currentgameid;
		$skillkit='';
		$btscore = '';
		$isskillkit=$this->session->isskillkit;
		$braintest_level = $this->session->btestlevel;
		if($isskillkit=="Y"){$skillkit=1;}

		elseif($isskillkit=="BT") {
		$skillkit=2;
		$btscore=$score;
		$this->session->set_userdata(array( 'btscore'=> $btscore ));
		$attempt_ques=$_POST["aqcnt1"];

		}
		else{ $skillkit=0; }
		/*
		echo "<pre>";
		print_r($_SESSION);
		exit;

		/*echo 'hai'; exit;*/
		
		if($gameid==0)
		{
			echo '-2';exit;
		}

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
		$game_limt=$this->config->item('game_limit');
		if($skillkit==0)
		{			
			if($game_limt>$data['gameDetails'][0]['playedgamescount'])
			{				
				//$data['insert1'] = $this->Assessment_model->insertone($userid,$cid,$skillid,$pid,$gameid,$total_ques,$attempt_ques,$answer,$score,$a6,$a7,$a8,$a9,$lastup_date,$schedule_val);
			}
			else
			{
				echo '-1';exit;
			}
		}
		else if($skillkit==1)
		{
			$data['gameDetails'] = $this->Assessment_model->getSkGameDetails($userid,$gameid);
			if($game_limt>$data['gameDetails'][0]['playedgamescount'])
			{
				$data['insert1'] = $this->Assessment_model->insertone_SK($userid,$cid,$skillid,$pid,$gameid,$total_ques,$attempt_ques,$answer,$score,$a6,$a7,$a8,$a9,$lastup_date);
			}
			else
			{
				echo '-1';exit;
			}
		}
		else if($skillkit==2){
		$data['insert1'] = $this->Assessment_model->insertone_BT($userid,$cid,$skillid,$pid,$gameid,$total_ques,$attempt_ques,$answer,$score,$a6,$a7,$a8,$a9,$lastup_date);
		}
		//$data['insert2'] = $this->Assessment_model->insertlang($gameid,$userid,$userlang,$skillkit);
		//$currentacademicid=$this->Assessment_model->getacademicyearbyschoolid($this->session->school_id);
		//$acid =$currentacademicid[0]['id'];
		//$st = 1;
		//$data['insert3'] = $this->Assessment_model->insertthree($userid,$gameid,$acid,$lastup_date,$st);

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
		
		$data['isIAS']=$this->isiasenabled('FN');
				
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
		$userid = $this->session->user_id;

		$data['bspi'] = $this->getBspi();
		$data['mspi'] = $this->MyCurrentMspi('FN');
		$data['asapbspi'] = $this->getAsapBspi();
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
	
	/*........... ECertificateList .......*/
			$arrofec=$this->ECertificateList();
			$data['sbbadge']=$arrofec['sbbadge'];
			$data['sabadge']=$arrofec['sabadge'];
			$data['sgbadge']=$arrofec['sgbadge'];
		/*........... ECertificateList .......*/
		
/*---------------------------- Quarterly Toppers Start --------------------------------*/
		 $isbspi=$this->Assessment_model->IsBspiTopper($this->session->user_id);
		$iscrowny=$this->Assessment_model->IsCrowniesTopper($this->session->user_id);
		$isarrofskill=$this->Assessment_model->IsSkillTopper($this->session->user_id);
		
		
		
		if($isbspi[0]['topper']>0){$this->session->set_userdata('IsBspiTopper',1);}else{$this->session->set_userdata('IsBspiTopper',0);}
		if($iscrowny[0]['topper']>0){$this->session->set_userdata('IsCrowniesTopper',1);}else{$this->session->set_userdata('IsCrowniesTopper',0);}
		$topskills = count($isarrofskill);
		if($topskills>0){$this->session->set_userdata('Topskillscount',$topskills);}else{$this->session->set_userdata('Topskillscount',0);}
		if(count($isarrofskill)>0)
		{
			foreach($isarrofskill as $skill)
			{
				$this->session->set_userdata("B".$skill['gs_id'],1);
			}
		} 
		
		/*---------------------------- Quarterly Toppers End --------------------------------*/	
	$data['asap_bspi']=$this->getAsapBspi();
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
		
		$premnthnumber = date('m', strtotime('last month'));
		//$ugradeid = $this->session->game_grade;
		$data['maxvaluesbbadge'] = $this->Assessment_model->maxvaluesbbadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
		$data['sbbadge'] = $this->Assessment_model->sbbadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade);
		
		$data['maxvaluesabadge'] = $this->Assessment_model->maxvaluesabadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
		$data['sabadge'] = $this->Assessment_model->sabadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade,'');
		
		$data['maxvaluesgbadge'] = $this->Assessment_model->maxvaluesgbadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
		$data['sgbadge'] = $this->Assessment_model->sgbadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade);
		
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
	$data['mspi'] = $this->MyCurrentMspi('FN');
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
	$bspicalendardays= $this->Assessment_model->mybspicalendar($this->session->school_id,$userid,$yearMonthQry,$startdate,$enddate);$skillscores= $this->Assessment_model->myskillscores($this->session->school_id,$userid,$yearMonthQry,$startdate,$enddate);
	$mybspiCalendar=array();
	$myskillscores=array();	
	
	
	foreach($bspicalendardays as $days)
	{
		$mybspiCalendar[$days['playedDate']]=$days['game_score'];
	}
	 $data['mybspiCalendar']=$mybspiCalendar;
	 
	foreach($skillscores as $days)
	{
		$myskillscores[$days['playedDate']][$days['gs_id']]=$days['game_score'];
	}
	 $data['myskillscores']=$myskillscores;
	 
//	 echo '<pre>'; 
//print_r($bspicalendardays);
		//	print_r($data['mybspiCalendar']);
	  
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
		
		$data['isIAS']=$this->isiasenabled('FN');
		$topval='';
		$premnthnumber = date('m', strtotime('last month'));
		//$ugradeid = $this->session->game_grade;
		$data['maxvaluesbbadge'] = $this->Assessment_model->maxvaluesbbadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
		$data['sbbadge'] = $this->Assessment_model->sbbadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade,$topval);
		
		$data['maxvaluesabadge'] = $this->Assessment_model->maxvaluesabadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
		$data['sabadge'] = $this->Assessment_model->sabadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade,$topval);
		
		$data['maxvaluesgbadge'] = $this->Assessment_model->maxvaluesgbadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
		$data['sgbadge'] = $this->Assessment_model->sgbadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade,$topval);
		
		/* $get_bspi_rows =$this->Assessment_model->getBSPI($userid);

		 
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
	$tot = (($res_tot_memory/$res_tot_memory_i)+($res_tot_vp/$res_tot_vp_i)+($res_tot_fa/$res_tot_fa_i)+($res_tot_ps/$res_tot_ps_i)+($res_tot_lang/$res_tot_lang_i))/5; */

	
	//$data['bspi'] = $tot;
	$data['asap_bspi']=$this->getAsapBspi();
	//$data['academicyear'] = $this->Assessment_model->getacademicyear(); 
	$startdate = $this->session->astartdate;
	$enddate = $this->session->aenddate;
	$data['academicmonths'] = $this->Assessment_model->getacademicmonths($startdate,$enddate);
	
	$mytrophies= $this->Assessment_model->myTrophiesAll_opt($userid,$startdate,$enddate,$this->session->Session_StartRange,$this->session->Session_EndRange);
		
	$meTrophies=array();$vpTrophies=array();$faTrophies=array();$psTrophies=array();$liTrophies=array();
	foreach($mytrophies as $trophies)
	{
		$arrmyTrophies[str_pad($trophies['session_id'], 1, '', STR_PAD_LEFT)][$trophies['category']]=$trophies['totstar'];
	}
	$data['arrmyTrophies'] =$arrmyTrophies;
	 //$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
	 $data['skillkitenable']=$this->Assessment_model->IsSkillkitExist($this->session->user_id,$this->session->game_plan_id);
	 
	 $data['default_cycle']=$this->Assessment_model->getDefaultCycleData($this->session->Session_StartRange,$this->session->Session_EndRange,$this->session->Session_Curid);
	 
	 /*........... ECertificateList .......*/
			$arrofec=$this->ECertificateList();
			$data['sbbadge']=$arrofec['sbbadge'];
			$data['sabadge']=$arrofec['sabadge'];
			$data['sgbadge']=$arrofec['sgbadge'];
		/*........... ECertificateList .......*/
		
		$data['sparkies']=$this->MySparkies();	 
		$this->load->view('headerinner', $data);
        $this->load->view('mytrophies/newtrophies', $data);
		$this->load->view('footerinner');
		
	}
	
	public function skillkitpopup()
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
		$data['actualGameCategory']=array('59'=>'Memory','60'=>'Visual Processing','61'=>'Focus & Attention','62'=>'Problem Solving','63'=>'Linguistics');
		
		foreach($data['actualGames'] as $games)
{ echo $data['actualGameCategory'][$games['skill_id']].','; }
	
      //  $this->load->view('home/skillkitpopup', $data);
	
	//redirect('index.php/home/dashboard');
	
	}
	
	public function skillkit()
	{
		if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}
		
		$data['isIAS']=$this->isiasenabled('FN');
		
	//echo "hello"; exit;	
		$userid = $this->session->user_id;
		$sid = $this->session->school_id;
		$topval='';
		$premnthnumber = date('m', strtotime('last month'));
		//$ugradeid = $this->session->game_grade;
		
		$data['maxvaluesbbadge'] = $this->Assessment_model->maxvaluesbbadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
		$data['sbbadge'] = $this->Assessment_model->sbbadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade,$topval);
		
		$data['maxvaluesabadge'] = $this->Assessment_model->maxvaluesabadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
		$data['sabadge'] = $this->Assessment_model->sabadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade,$topval);
		
		$data['maxvaluesgbadge'] = $this->Assessment_model->maxvaluesgbadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
		$data['sgbadge'] = $this->Assessment_model->sgbadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade,$topval);
		
		
		$check_date_time = date('Y-m-d');
		$catid=1;
		$this->fn_SK_Rand_games($userid, $check_date_time, '',100,$catid);
		$brain_rs = $this->Assessment_model->getAssignSK_RandomGame($check_date_time,$this->session->game_plan_id,$this->session->game_grade,$userid,$this->session->school_id);
		$where = "";
		$brainIds=array();
		$planids=array();
		$data['actualGames']=array();
			foreach( $brain_rs as $brainData)
			{
					$brainIds[] = $brainData['gid'];
					$planids[] = $brainData['gp_id'];
			}
			if($brainIds)
			{			
					$active_game_ids = @implode(',',$brainIds);
					$assigned_plan_id = @implode(',',$planids);
					$where = " and g.ID in ($active_game_ids)";
					$planwhere = " and plan_id in ($assigned_plan_id)";
			}
			if($brainIds)
			{				
				$data['actualGames'] = $this->Assessment_model->getSK_ActualGames($this->session->game_plan_id,$this->session->game_grade,$userid,$catid,$where,$planwhere);
			} 
		$data['actualGameCategory']=array('59'=>'Memory','60'=>'Visual Processing','61'=>'Focus & Attention','62'=>'Problem Solving','63'=>'Linguistics');
		
		$data['skillkitenable']=$this->Assessment_model->IsSkillkitExist($this->session->user_id,$this->session->game_plan_id);
		
		$this->UpdateSkillkitSession();
		
	$data['asap_bspi']=$this->getAsapBspi();
	$data['mspi'] = $this->MyCurrentMspi('FN');
	$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
	$data['DailyPuzzlePlayed_Status']=$this->CheckDailyPuzzlePlayed();
	$data['skillkitplay']=$this->checkSkillkitGamePlayed();
	$data['sparkies']=$this->MySparkies();
	
	if($data['skillkitplay']=='Y')
		{
			$CurrentDatetime=date('Y-m-d H:i:s');
			$this->Assessment_model->Update_Timer_StartTime($this->session->user_id,$this->session->login_session_id,$CurrentDatetime);
			$this->session->set_userdata('TimerRunningStatus','Y'); //Run the Timer Now.
		} 
	
	/* Expire time Validation */
	if($this->session->TimerRunningStatus=='Y')
	{
		$maxtimofplay=$this->Assessment_model->getMaxTimeofPlay();
		$sumoftottimeused=$this->Assessment_model->getSumofUserUsedTime($userid,date('Y-m-d'));
		$data['maxtimeofplay']=$maxtimofplay[0]['value'];
		$data['sumoftottimeused']=$sumoftottimeused[0]['LoggedIntime'];
		$data['Remainingtime']=$maxtimofplay[0]['value']-$sumoftottimeused[0]['LoggedIntime'];
		if($sumoftottimeused[0]['LoggedIntime']>=$maxtimofplay[0]['value'])
		{
			$this->TodayTimerInsert();
		}
	}
/* Expire time Validation */
	

		/*........... ECertificateList .......*/
			$arrofec=$this->ECertificateList();
			$data['sbbadge']=$arrofec['sbbadge'];
			$data['sabadge']=$arrofec['sabadge'];
			$data['sgbadge']=$arrofec['sgbadge'];
		/*........... ECertificateList .......*/
		
		//echo "<pre>";print_r($data);exit;
		$this->load->view('headerinner', $data);
        $this->load->view('home/skillkit', $data);
		$this->load->view('footerinner');
	
	//redirect('index.php/home/dashboard');
	}
	
	public function CheckDailyPuzzlePlayed()
	{
		$TodayDate=date('Y-m-d');
		$isplayedtoday=$this->Assessment_model->CheckTodayPuzzlePlayedCount($this->session->user_id,$TodayDate);
		if($isplayedtoday[0]['playedskillcount']==$this->config->item('MaxPlayedCount'))
		{
			return "P";exit;
		}
		else
		{
			return "NP";exit;
		}
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
					$this->fn_Rand_games($uid, $check_date_time, $cur_day_skills, $assign_count,$catid);
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
	$data['mspi'] = $this->MyCurrentMspi('FN');
 
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
	//$data['trophies']= $this->Assessment_model->getMyCurrentTrophies($userid);
	$data['trophies']= $this->Assessment_model->getMyCurrentTrophies_opt($userid,$this->session->Session_StartRange,$this->session->Session_EndRange);

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
		$sid = $this->session->school_id;
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
		$data['actualGameCategory']=array('59'=>'Memory','60'=>'Visual Processing','61'=>'Focus & Attention','62'=>'Problem Solving','63'=>'Linguistics');
		
		/* Expire time Validation */
		if($this->session->TimerRunningStatus=='Y')
	{
		$maxtimofplay=$this->Assessment_model->getMaxTimeofPlay();
		$sumoftottimeused=$this->Assessment_model->getSumofUserUsedTime($userid,date('Y-m-d'));
		$data['maxtimeofplay']=$maxtimofplay[0]['value'];
		$data['sumoftottimeused']=$sumoftottimeused[0]['LoggedIntime'];
		$data['Remainingtime']=$maxtimofplay[0]['value']-$sumoftottimeused[0]['LoggedIntime'];
		if($sumoftottimeused[0]['LoggedIntime']>=$maxtimofplay[0]['value'])
		{
			$this->TodayTimerInsert();
		}
	}
		/* Expire time Validation */

//if($this->session->game_grade!=12 && $this->session->game_grade!=13 && $this->session->game_grade!=14 && $this->session->game_grade!=15)
if($this->session->game_grade==100)
{
/*--------------- Math Puzzles Start ---------------*/
		$arrMathAssigned=$this->Assessment_model->checkMathAssignedToday($this->session->user_id,$this->session->game_grade);
		$arrAssignedPuzzles=$this->Assessment_model->checkTotalAssignedPuzzles($this->session->user_id,$this->session->game_grade);
		if($arrMathAssigned[0]['assigned']>0)
		{ // Already Assigne Game for a Today.
			$data['arrofmath']=$this->Assessment_model->getTodayPuzzles($this->session->user_id,$this->session->game_grade);
		}
		else
		{ // Assign New Game For today
			if($arrAssignedPuzzles[0]['assigned']>=10)
			{ // Delete Previous data and Insert
				$this->Assessment_model->DeletePrevMathCycle($this->session->user_id,$this->session->game_grade);
				$AssignedGameID=$this->Assessment_model->AssignTodayMathPuzzles($this->session->user_id,$this->session->game_grade);
				if($AssignedGameID[0]['mid'])
				{
					$this->Assessment_model->InertTodayMathPuzzles($AssignedGameID[0]['mid'],$this->session->user_id,$this->session->game_grade);
				}
			}
			else
			{// Insert new data
				$AssignedGameID=$this->Assessment_model->AssignTodayMathPuzzles($this->session->user_id,$this->session->game_grade);
				if($AssignedGameID[0]['mid'])
				{
					$this->Assessment_model->InertTodayMathPuzzles($AssignedGameID[0]['mid'],$this->session->user_id,$this->session->game_grade);
				}
			}
			$data['arrofmath']=$this->Assessment_model->getTodayPuzzles($this->session->user_id,$this->session->game_grade);
		}
		 
/* Total Score */
			$data['arrofmathscore']=$this->Assessment_model->getTotalScoreofMath($this->session->user_id);
			
			$startdate = $this->session->astartdate;
			$enddate = $this->session->aenddate;
			$data['academicmonths'] = $this->Assessment_model->getacademicmonths($startdate,$enddate);
			$data['isEligibleToday']=$this->TodayMathPuzzleEligible('FN');
/* Total Score */ 
/*--------------- Math Puzzles End ---------------*/
}

	/* $this->load->view('headerinner', $data); */
	$this->load->view('home/dashboard_ajaxnew', $data);
	/* $this->load->view('footerinner'); */
}
public function leaderboard()
{
		if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}
		$userid = $this->session->user_id;
		
		$data['isIAS']=$this->isiasenabled('FN');
		
		$premnthnumber = date('m', strtotime('last month'));
		//$ugradeid = $this->session->game_grade;
		$data['maxvaluesbbadge'] = $this->Assessment_model->maxvaluesbbadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
		
		$topval='';
		
		$data['sbbadge'] = $this->Assessment_model->sbbadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade,$topval);
		
		$data['maxvaluesabadge'] = $this->Assessment_model->maxvaluesabadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
		$data['sabadge'] = $this->Assessment_model->sabadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade,$topval);
		
		$data['maxvaluesgbadge'] = $this->Assessment_model->maxvaluesgbadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
		$data['sgbadge'] = $this->Assessment_model->sgbadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade,$topval);
		
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
		//$data['bspi'] = $tot;
		$data['asap_bspi']=$this->getAsapBspi();
		$data['mspi'] = $this->MyCurrentMspi('FN');
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
	
	/*........... ECertificateList .......*/
			$arrofec=$this->ECertificateList();
			$data['sbbadge']=$arrofec['sbbadge'];
			$data['sabadge']=$arrofec['sabadge'];
			$data['sgbadge']=$arrofec['sgbadge'];
		/*........... ECertificateList .......*/
	
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
	$data['mspi'] = $this->MyCurrentMspi('FN');
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
		$data['mspi'] = $this->MyCurrentMspi('FN');
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
		if ($this->session->user_id && isset($this->session->issparkies))
		{ 
			if($this->session->sparkiespoints!=0)
			{
				$sparkiestotpoints=$sparkies_total_points[0]['mysparkies']-$this->session->sparkiespoints;
			}	
			else
			{ 
				$sparkiestotpoints=$sparkies_total_points[0]['mysparkies'];
			}		
		}
		else
		{ 
				$sparkiestotpoints=$sparkies_total_points[0]['mysparkies'];
		}

		return $sparkiestotpoints;		
	}
	
	public function islogin()
	{ 
		if (!empty($_POST))
		{			 
			$exeislogin = $this->Assessment_model->islogin($this->input->post('email'),$this->input->post('pwd'),$this->config->item('ideal_time'));
		//	echo $exeislogin[0]->islogin;exit;
		}
	}
	public function checkuserisactive()
	{
		if($this->session->TimerRunningStatus=='Y')
		{
			$now=date('Y-m-d H:i:s');
			$this->Assessment_model->update_login_log($this->session->user_id,$this->session->login_session_id,$now);
		}
		$exeislogin = $this->Assessment_model->checkuserisactive($this->session->user_id,$this->session->login_session_id);
		//echo $exeislogin[0]->isalive;exit;
		if($exeislogin[0]->isalive!=1)
		{ 	
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
				'fname'=>$arrisUser[0]['fname'],
				'gradename'=>$arrisUser[0]['gradename'],
				'grade_id'=>$arrisUser[0]['grade_id'],
				'id'=>$arrisUser[0]['id'],
				'sid'=>$arrisUser[0]['sid'],
				'section'=>$arrisUser[0]['section'],
				'isschedule'=>$arrisschedule[0]['isschedule'],
				'popup'=>$popup,
				'logincount'=>$arrisUser[0]['login_count']
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
		$date=Date("2019-".$monthno."-d");
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

public function curdayplaystatus()
{
	$userid = $this->session->user_id;
	$curday = date('Y-m-d');
	$sid = $this->session->school_id;
	
	$data['curdayplaystatus']=$this->Assessment_model->curdayplaystatus($userid,$curday);
	
	$data['maxtimofplay']=$this->Assessment_model->getMaxTimeofPlay($sid);
	$data['$sumoftottimeused=']=$this->Assessment_model->getSumofUserUsedTime($userid,$curday);
	
		$response=array(
		'maxtimofplay'=>$data['maxtimofplay'][0]['value'],
		'sumoftottimeused'=>$data['$sumoftottimeused='][0]['LoggedIntime'],
		'curdayplaystatus'=>$data['curdayplaystatus'][0]['total']
		
	);
	
	echo json_encode($response);exit;
	
	//echo $data['curdayplaystatus'][0]['total']; exit;
	//echo json_encode(array("date"=>$data['playeddates'])); exit;
	
}

public function userfdbk()
{
	//echo ''; exit;
	$userid = $this->session->user_id;
	//$subject = $this->input->post('subject');
	$qone = $this->input->post('qone');
	$qtwo = $this->input->post('qtwo');
	$qthree = $this->input->post('qthree');
	$chkbox = $this->input->post('chkbox');
	$usercmnt = $this->input->post('usercmnt');
	
	$skillname=implode(",", $chkbox);
	
	$data['fdbkinser']=$this->Assessment_model->userfdbk($userid,$qone,$qtwo,$qthree,$skillname,$usercmnt);
	echo 1; exit;
	//echo json_encode(array("date"=>$data['playeddates'])); exit;
	
}

public function ecertificate()
{
	$score = $this->input->post('score');
	$username = $this->session->fullname;
	$userid = $this->session->user_id;
	$type = $this->input->post('type');
	
	$data['userinfo'] = $this->Assessment_model->userinfo($userid);
	
	$sname = $data['userinfo'][0]['sname'];
	$class = str_replace('Grade', '', $data['userinfo'][0]['classname']).' '.$data['userinfo'][0]['section'];
	$MonofYear = date('F', strtotime('last month'))."_".date('Y');
	
	if($type=='sa') 
	{
		 //$BackgroundImage= base_url().'assets/images/SuperAngel-Certificate.jpg';
		$BackgroundImage= '/mnt/nschools/assets/images/SuperAngel-Certificate.jpg';
	
		$img = $this->LoadJpeg($BackgroundImage,$username,$class,$sname,$score);	
		// imagejpeg($img);
		// imagedestroy($img);
		$foldername="Ecertificates/superangels/".trim($userid)."/";
			if (!file_exists($foldername)) {
				mkdir($foldername, 0777, true);
			}
		$username=str_replace(' ', '', $username);
		imagejpeg($img,$foldername.''.$userid.'_'.$username.'_'.$MonofYear.".jpg");
		imagedestroy($img);
		
		
		$file_name=$userid.'_'.$username.'_'.$MonofYear.".jpg";
		$file_url=base_url()."".$foldername.''.$userid.'_'.$username.'_'.$MonofYear.".jpg";
		
		$arresult=array("file_name"=>$file_name,"file_url"=>$file_url);
		$res=json_encode($arresult);
		echo $res;exit;
	}
	
	if($type=='sb') 
	{
		
		//$BackgroundImage= base_url().'assets/images/SuperBrain-Certificate.jpg';
		$BackgroundImage= '/mnt/nschools/assets/images/SuperBrain-Certificate.jpg';
	
		$img = $this->LoadJpegsb($BackgroundImage,$username,$class,$sname,$score);	
		// imagejpeg($img);
		// imagedestroy($img);
		$foldername="Ecertificates/superbrain/".trim($userid)."/";
			if (!file_exists($foldername)) {
				mkdir($foldername, 0777, true);
			}
		$username=str_replace(' ', '', $username);
		imagejpeg($img,$foldername.''.$userid.'_'.$username.'_'.$MonofYear.".jpg");
		imagedestroy($img);
		$file_name=$userid.'_'.$username.'_'.$MonofYear.".jpg";
		$file_url=base_url()."".$foldername.''.$userid.'_'.$username.'_'.$MonofYear.".jpg";
		$arresult=array("file_name"=>$file_name,"file_url"=>$file_url);
		$res=json_encode($arresult);
		echo $res;exit;
	}
	
	if($type=='sg') 
	{
		
		//$BackgroundImage= base_url().'assets/images/SuperGoer-Certificate.jpg';
		$BackgroundImage= '/mnt/nschools/assets/images/SuperGoer-Certificate.jpg';

		$img = $this->LoadJpegsg($BackgroundImage,$username,$class,$sname,$score);	
		// imagejpeg($img);
		// imagedestroy($img);
		$foldername="Ecertificates/supergoer/".trim($userid)."/";
			if (!file_exists($foldername)) {
				mkdir($foldername, 0777, true);
			}
		$username=str_replace(' ', '', $username);
		imagejpeg($img,$foldername.''.$userid.'_'.$username.'_'.$MonofYear.".jpg");
		imagedestroy($img);
		$file_name=$userid.'_'.$username.'_'.$MonofYear.".jpg";
		$file_url=base_url()."".$foldername.''.$userid.'_'.$username.'_'.$MonofYear.".jpg";
		$arresult=array("file_name"=>$file_name,"file_url"=>$file_url);
		$res=json_encode($arresult);
		echo $res;exit;
	}
}

public function LoadJpeg($fBackgroundImage,$username,$class,$sname,$score)
{
    /* Attempt to open */
    $im = @imagecreatefromjpeg($fBackgroundImage);
    /* See if it failed */
    if(!$im)
    {
      echo "Loading bg has issue ".fBackgroundImage;
    }
// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
// The text to draw
// Replace path by your own font path
//$font = "fonts/OpenSansBold.ttf";
$font = APPPATH."../assets/fonts/OpenSansBold.ttf";
// Add some shadow to the text
	$lastmonthname = date('F', strtotime('last month'));
	$currentyear = date('Y');

	$text_color = imagecolorallocate($im, 213, 91, 0);
	imagettftext ($im, 20, 0, 425, 450, $text_color, $font, $username);
	imagettftext ($im, 20, 0, 287, 504, $text_color, $font, $class);
	imagettftext ($im, 18, 0, 485, 500, $text_color, $font, $sname);
	imagettftext ($im, 18, 0, 350, 620, $text_color, $font, $lastmonthname."-".$currentyear);
	/* imagestring($im, 5, 200, 92, str_pad($fCity,50," ",STR_PAD_BOTH), $text_color);
	imagestring($im, 5, 200, 107, str_pad($fState,50," ",STR_PAD_BOTH), $text_color); */
	/* BSPIScore */ 
	$text_color = imagecolorallocate($im, 255, 255, 255);

	
    return $im;
}

public function LoadJpegsb($fBackgroundImage,$username,$class,$sname,$score)
{
    /* Attempt to open */
    $im = @imagecreatefromjpeg($fBackgroundImage);
    /* See if it failed */
    if(!$im)
    {
      echo "Loading bg has issue ".fBackgroundImage;
    }
// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
// The text to draw
// Replace path by your own font path
//$font = "fonts/OpenSansBold.ttf";
$font = APPPATH."../assets/fonts/OpenSansBold.ttf";
// Add some shadow to the text
	$lastmonthname = date('F', strtotime('last month'));
	$currentyear = date('Y');

	$text_color = imagecolorallocate($im, 213, 91, 0);
	imagettftext ($im, 20, 0, 425, 450, $text_color, $font, $username);
	imagettftext ($im, 20, 0, 287, 504, $text_color, $font, $class);
	imagettftext ($im, 18, 0, 485, 500, $text_color, $font, $sname);
	imagettftext ($im, 18, 0, 350, 620, $text_color, $font, $lastmonthname."-".$currentyear);
	/* imagestring($im, 5, 200, 92, str_pad($fCity,50," ",STR_PAD_BOTH), $text_color);
	imagestring($im, 5, 200, 107, str_pad($fState,50," ",STR_PAD_BOTH), $text_color); */
	/* BSPIScore */ 
	$text_color = imagecolorallocate($im, 255, 255, 255);

	
    return $im;
}

public function LoadJpegsg($fBackgroundImage,$username,$class,$sname,$score)
{
    /* Attempt to open */
    $im = @imagecreatefromjpeg($fBackgroundImage);
    /* See if it failed */
    if(!$im)
    {
      echo "Loading bg has issue ".fBackgroundImage;
    }
// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
// The text to draw
// Replace path by your own font path
//$font = "fonts/OpenSansBold.ttf";
$font = APPPATH."../assets/fonts/OpenSansBold.ttf";
// Add some shadow to the text
	$lastmonthname = date('F', strtotime('last month'));
	$currentyear = date('Y');

	$text_color = imagecolorallocate($im, 213, 91, 0);
	imagettftext ($im, 20, 0, 425, 450, $text_color, $font, $username);
	imagettftext ($im, 20, 0, 287, 504, $text_color, $font, $class);
	imagettftext ($im, 18, 0, 485, 500, $text_color, $font, $sname);
	imagettftext ($im, 18, 0, 350, 620, $text_color, $font, $lastmonthname."-".$currentyear);
	/* imagestring($im, 5, 200, 92, str_pad($fCity,50," ",STR_PAD_BOTH), $text_color);
	imagestring($im, 5, 200, 107, str_pad($fState,50," ",STR_PAD_BOTH), $text_color); */
	/* BSPIScore */ 
	$text_color = imagecolorallocate($im, 255, 255, 255);

	
    return $im;
}

public function getTrainingCalendarData($type=null)
{
	$userid = $this->session->user_id;
	$curdate = $this->input->post('curdate');
	$arrval=$this->Assessment_model->getTrainingCalendarData($userid,$curdate);
	$arrvalbspi=$this->Assessment_model->getonedaybspi($userid,$curdate);
	$arrvalskillscore=$this->Assessment_model->getonedayskillscore($userid,$curdate);
	
	$response=array(
		'MinutesTrained'=>$arrval[0]['MinutesTrained'],
		'PuzzlesSolved'=>$arrval[0]['PuzzlesSolved'],
		'PuzzlesAttempted'=>$arrval[0]['PuzzlesAttempted'],
		'Crownies'=>$arrval[0]['Crownies'],
		'BSPI'=>round($arrvalbspi[0]['BSPI'], 2),
		'MEMORY'=>round($arrvalskillscore[0]['memory'], 2),
		'VISUAL'=>round($arrvalskillscore[0]['visual'], 2),
		'FOCUS'=>round($arrvalskillscore[0]['focus'], 2),
		'PROBLEM'=>round($arrvalskillscore[0]['problem'], 2),
		'LING'=>round($arrvalskillscore[0]['ling'], 2),
		'Curday'=>date("d-m-Y", strtotime($curdate))
	);
	if($type=='FN')
	{
		return json_encode($response);
	}
	else
	{
		echo json_encode($response);exit;
	}
}

public function overallskillscore()
{
	$userid = $this->session->user_id;
	$curdate = date('Y-m-d');
	
	$skillscore = $this->Assessment_model->overallskillscore($userid,$curdate);
	
	$skillset=array("SID59"=>0,"SID60"=>0,"SID61"=>0,"SID62"=>0,"SID63"=>0);
	 foreach($skillscore as $score)
	{
		$skillset["SID".$score['gs_id']]=round($score['skillscore'],2);
	}
	$data['skillscore']=$skillset;
	echo json_encode($data['skillscore']);exit;
	
}

public function getnextsession()
{
	$userid = $this->session->user_id;
	$curday = date('Y-m-d');
	$date = strtotime("+7 day");
	$nextdate = date('Y-m-d', $date);
	$data['userinfo'] = $this->Assessment_model->userinfo($userid);
	$grade = str_replace('Grade ', '', $data['userinfo'][0]['classname']);
	$section = $data['userinfo'][0]['section'];
	$sid = $this->session->school_id;
	
	$data['getnxtsession'] = $this->Assessment_model->getnxtsession($sid,$grade,$section,$curday,$nextdate);
	
	if($data['getnxtsession'][0]['selected_date']!='') {
	$response=array(
		//'dateday'=>'Date & Day : '.''.date("d-m-Y", strtotime($data['getnxtsession'][0]['selected_date'])).', '.$data['getnxtsession'][0]['nameofday'],
		
		'dateday'=>'Your next challenge awaits you on '.''.date("d-m-Y", strtotime($data['getnxtsession'][0]['selected_date'])).' at '.date("g:i A", strtotime($data['getnxtsession'][0]['starttime'])),
		//'time'=>'Start Time : '.''.date("g:i A", strtotime($data['getnxtsession'][0]['starttime'])),
		
		//'time'=>'Start Time : '.''.date("g:i A", strtotime($data['getnxtsession'][0]['starttime'])),
		
	);
	echo json_encode($response);exit;
	}
}

	public function getBspi()
	{
		$userid = $this->session->user_id;
		$get_bspi_rows =$this->Assessment_model->getBSPI($userid,$this->session->Session_StartRange,$this->session->Session_EndRange);		 
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
		return $tot;
	}
	
	public function getAsapBspi()
{
	$username = $this->session->username;
	$arrbspi=$this->Assessment_model->getAsapBspi($username);
	$CurrentBSPIName=$this->Assessment_model->getCurrentBSPIName($this->session->Session_StartRange,$this->session->Session_EndRange,$this->session->Next_Session_id);

	$response=array(
		"bspi"=>$arrbspi[0]['bspi'],
		"current_status"=>$CurrentBSPIName[0]['name']
	);
	return $response;
}
public function checkSkillkitGamePlayed()
{
	$userid = $this->session->user_id;
	$isplayedtoday=$this->Assessment_model->checkSkillkitGamePlayed($userid,date('Y-m-d'));
	if(($isplayedtoday[0]['playedcount']/$isplayedtoday[0]['assignedcount']) >= $this->config->item('SK_MinPlayCount'))
	{
		return "Y"; // Skillkit Game played. So Enable daily puzzles part
	}
	else
	{
		return "N";  // Skillkit Game not played. So Disable daily puzzles part
	}
}
	
public function UpdateTodaySession()
{
	$TodayDate=date('Y-m-d');
	$SessionLevel=$this->Assessment_model->UpdateTodaySession($this->session->user_id,$TodayDate);
	$cyclevalue=$this->Assessment_model->getcyclevalue();
	
	if($SessionLevel[0]['OUTPLAYCOUNT']==5)
	{	
		if($SessionLevel[0]['OUTSESSIONLEVEL']!='')
		{
			foreach($cyclevalue as $cycle)
			{
				$range=explode('-',$cycle['value']);
				//echo "<pre>";print_r($range);
				if($range[0]<=$SessionLevel[0]['OUTSESSIONLEVEL'] && $range[1]>=$SessionLevel[0]['OUTSESSIONLEVEL'])
				{
					$Session_StartRange=$range[0];
					$Session_EndRange=$range[1];
				}
			} 
			$this->session->set_userdata('Session_StartRange', $Session_StartRange);
			$this->session->set_userdata('Session_EndRange', $Session_EndRange);
			$this->session->set_userdata('Session_Curid', $SessionLevel[0]['OUTSESSIONLEVEL']);
			$this->Assessment_model->UpdateUserCurrentSessionLevel($this->session->user_id,$SessionLevel[0]['OUTSESSIONLEVEL']+1);
			//$this->session->set_userdata('user_current_session', $SessionLevel[0]['OUTSESSIONLEVEL']);
			echo 1;exit;
		}
	}
	else
	{
		echo 0;exit;
	} 
}

public function reports()
{
	/*Class performance report*/
	
	$data['default_cycle']=$this->Assessment_model->getDefaultCycleData($this->session->Session_StartRange,$this->session->Session_EndRange,$this->session->Session_Curid);
	
	$data['asap_bspi']=$this->getAsapBspi(); 
	$data['sparkies']=$this->MySparkies();
	//$data['bspi'] = $this->getBspi();
	
	$this->load->view('headerinner',$data);
	$this->load->view('reports/newreport');
	$this->load->view('footerinner');
}

public function getSkillChart()
{
	$cycleid = $this->input->post('cycle');
	$range_value = $this->input->post('range');
	$type = $this->input->post('type');
	$userid = $this->session->user_id;
	
	$range=explode("-",$range_value);
	
	if($type=='ADVANCE')
	{
		$arrSkillChart=$this->Assessment_model->getAdvancedSkillChart($userid,$range[0],$range[1],$this->session->Session_Curid);
		$mybspiCalendarSkillScore=array("SID59"=>0,"SID60"=>0,"SID61"=>0,"SID62"=>0,"SID63"=>0);
		foreach($arrSkillChart as $score)
		{
			$mybspiCalendarSkillScore["SID".$score['gs_id']]=round($score['gamescore'],2);
		}
		$data['SkillChart']=$mybspiCalendarSkillScore;
		$tsivalue=$this->Assessment_model->getDirectBSPI($userid,$range[0],$range[1]);
		$data['bspi']=$tsivalue[0]['tsi'];
		$data['skills'] = $this->Assessment_model->getskills();
	}
	else
	{
		$arrSkillChart=$this->Assessment_model->getBasicSkillChart($userid,$range[0],$range[1],$this->session->Session_Curid);
		//$mybspiCalendarSkillScore=array("SID59"=>0,"SID60"=>0,"SID61"=>0,"SID62"=>0,"SID63"=>0);
		foreach($arrSkillChart as $score)
		{
			$mybspiCalendarSkillScore[$score['gs_id']]=round($score['gamescore'],2);
		}
		$data['SkillChart']=$mybspiCalendarSkillScore;
		$tsivalue=$this->Assessment_model->getSkillKitBSPI($userid,$range[0],$range[1]);
		$data['bspi']=$tsivalue[0]['tsi'];
		$data['skills'] = $this->Assessment_model->getskills();	
	}
	
	$data['CurrentBSPIName']=$this->Assessment_model->getCurrentBSPIName($range[0],$range[1],$this->session->Session_Curid);
	
	$data['type']=$type;
	
	//echo "<pre>";print_r($data);exit;
	$this->load->view('reports/ajax_skillchart', $data);	
}

	
public function UpdateSkillkitSession()
{
	
	//echo $this->session->Session_StartRange.",".$this->session->Session_EndRange;
	$TodayDate=date('Y-m-d');
	$SessionLevel=$this->Assessment_model->UpdateSkillkitSession($this->session->user_id,$TodayDate,$this->session->Session_StartRange,$this->session->Session_EndRange);
	$cyclevalue=$this->Assessment_model->getcyclevalue();
	//echo $SessionLevel[0]['OUTPLAYCOUNT']."==".$SessionLevel[0]['OUTPLAYEDCOUNT'];exit;
	if(($SessionLevel[0]['OUTPLAYCOUNT']==$SessionLevel[0]['OUTPLAYEDCOUNT']) && $SessionLevel[0]['OUTPLAYEDCOUNT']!=0)
	{	
		if($SessionLevel[0]['OUTSESSIONLEVEL']!='')
		{
			foreach($cyclevalue as $cycle)
			{
				$range=explode('-',$cycle['value']);
				//echo "<pre>";print_r($range);
				if($range[0]<=$SessionLevel[0]['OUTSESSIONLEVEL'] && $range[1]>=$SessionLevel[0]['OUTSESSIONLEVEL'])
				{
					$Session_StartRange=$range[0];
					$Session_EndRange=$range[1];
				}
			} 
			$this->session->set_userdata('Session_StartRange', $Session_StartRange);
			$this->session->set_userdata('Session_EndRange', $Session_EndRange);
			$this->session->set_userdata('Session_Curid', $SessionLevel[0]['OUTSESSIONLEVEL']);
		}
	}
}	

	public function getCLPScoreData($type=null)
	{
		$userid = $this->session->user_id;
		$arrval=$this->Assessment_model->getTotalTrainingData($userid);
		$arrvalbspi=$this->getBSPI();
		$arrvalskillscore=$this->Assessment_model->getSkillWiseAvgCLPScore_opt($userid);
		
		
		$response=array(
			'MinutesTrained'=>$arrval[0]['MinutesTrained'],
			'PuzzlesSolved'=>$arrval[0]['PuzzlesSolved'],
			'PuzzlesAttempted'=>$arrval[0]['PuzzlesAttempted'],
			'Crownies'=>$arrval[0]['Crownies'],
			'BSPI'=>round($arrvalbspi, 2),
			'MEMORY'=>round($arrvalskillscore[0]['ME'], 2),
			'VISUAL'=>round($arrvalskillscore[0]['VP'], 2),
			'FOCUS'=>round($arrvalskillscore[0]['FA'], 2),
			'PROBLEM'=>round($arrvalskillscore[0]['PS'], 2),
			'LING'=>round($arrvalskillscore[0]['LI'], 2),
			'Curday'=>''
		);
		if($type=='FN')
		{
			return json_encode($response);
		}
		else
		{
			echo json_encode($response);exit;
		}
	}
	
public function getASAPScoreData($type=null)
{
	$username = $this->session->username;
	
	$arrvalbspi=$this->getAsapBspi();
	$arrvalskillscore=$this->Assessment_model->getAsapcore($username);
	
	
	$response=array(
		'MinutesTrained'=>'',
		'PuzzlesSolved'=>'',
		'PuzzlesAttempted'=>'',
		'Crownies'=>'',
		'BSPI'=>round($arrvalbspi['bspi'], 2),
		'MEMORY'=>round($arrvalskillscore[0]['ME'], 2),
		'VISUAL'=>round($arrvalskillscore[0]['VP'], 2),
		'FOCUS'=>round($arrvalskillscore[0]['FA'], 2),
		'PROBLEM'=>round($arrvalskillscore[0]['PS'], 2),
		'LING'=>round($arrvalskillscore[0]['LI'], 2),
		'Curday'=>''
	);
	if($type=='FN')
	{
		return json_encode($response);
	}
	else
	{
		echo json_encode($response);exit;
	}
}

public function ECertificateList()
{	
	$premnthnumber = date('m', strtotime('last month'));
	$userid = $this->session->user_id;
	$data['maxvaluesbbadge'] = $this->Assessment_model->maxvaluesbbadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
	$sbbadge= $this->Assessment_model->sbbadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade,$data['maxvaluesbbadge'][0]['sbtopvalue']);
	
	$data['maxvaluesabadge'] = $this->Assessment_model->maxvaluesabadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
	$sabadge= $this->Assessment_model->sabadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade,$data['maxvaluesabadge'][0]['satopvalue']);
	
	$data['maxvaluesgbadge'] = $this->Assessment_model->maxvaluesgbadge($premnthnumber,$this->session->school_id,$this->session->game_grade);
	$sgbadge = $this->Assessment_model->sgbadge($userid,$premnthnumber,$this->session->school_id,$this->session->game_grade,$data['maxvaluesgbadge'][0]['sgtopvalue']);
	
	$response=array(
		"sbbadge"=>$sbbadge,
		"sabadge"=>$sabadge,
		"sgbadge"=>$sgbadge	
	);
	return $response;
}

public function chkportaltype()
{
	if (!empty($_POST))
	{
		
		if($this->input->post('email')=='bhavnahpamnani@gmail.com' || $this->input->post('email')=='rachanabhayani@yahoo.in' || $this->input->post('email')=='deepikajain1874@gmail.com')
		{
			echo "1819"; exit;
		}
		
		$arrportaltype = $this->Assessment_model->chkportaltype($this->input->post('email'),$this->input->post('pwd'));
		
		if(($arrportaltype[0]['portal_type']=='ASAP') && ($arrportaltype[0]['sid']==2 || $arrportaltype[0]['sid']==130 || $arrportaltype[0]['sid']==131 ||  $arrportaltype[0]['sid']==132 || $arrportaltype[0]['sid']==133 || $arrportaltype[0]['sid']==136 || $arrportaltype[0]['sid']==139 || $arrportaltype[0]['sid']==138))
		{
			echo "asapo"; exit;
		}
		
		else if($arrportaltype[0]['portal_type']=='ASAP')
		{
			if($arrportaltype[0]['gp_id']==1 || $arrportaltype[0]['gp_id']==2 || $arrportaltype[0]['gp_id']==3 || $arrportaltype[0]['gp_id']==4 || $arrportaltype[0]['gp_id']==5 || $arrportaltype[0]['gp_id']==6 || $arrportaltype[0]['gp_id']==7 || $arrportaltype[0]['gp_id']==8 || $arrportaltype[0]['gp_id']==92 || $arrportaltype[0]['gp_id']==93 || $arrportaltype[0]['gp_id']==94 || $arrportaltype[0]['gp_id']==95) 
			{
				echo "asapnew"; exit; // Grade I to VIII, will redirect to new portal
			}
			else 
			{
				echo "asapnew"; exit;  // other grades, will redirect to new portal
			}
		}
		else if($arrportaltype[0]['portal_type']=='PASAP')
		{
			echo "PASAP"; exit; 
		}
		else if($arrportaltype[0]['portal_type']=='CLP')
		{
			echo $arrportaltype[0]['portal_type']; exit;  // other grades, will redirect to new portal
		}
		else
			{
			$arrportaltype = $this->Assessment_model->school_1819($this->input->post('email'),$this->input->post('pwd'));
			
			if($arrportaltype[0]['sid']==78 || $arrportaltype[0]['sid']==131 || $arrportaltype[0]['sid']==88 || $arrportaltype[0]['sid']==130 || $arrportaltype[0]['sid']==129 || $arrportaltype[0]['sid']==98) { echo "1819"; exit; }
		} 
		//echo $arrportaltype[0]['portal_type']; exit;
	}
}

public function tuserfdbk()
{
	//echo ''; exit;
	$userid = $this->session->user_id;
	//$subject = $this->input->post('subject');
	$qone = mysql_real_escape_string($this->input->post('tqone'));
	$usercmnt = mysql_real_escape_string($this->input->post('tusercmnt'));
	
	//$skillname=implode(",", $chkbox);
	
	$data['fdbkinser']=$this->Assessment_model->tuserfdbk($userid,$qone,$usercmnt);
	$this->session->unset_userdata('isteachers_popup',0);
	if($usercmnt=='') { echo 0; exit; }
	else { echo 1; exit; }
	//echo json_encode(array("date"=>$data['playeddates'])); exit;
	
}
	
	
/*-------- IAS Challenge Question ----------------*/
public function iaschallenge()
{
	if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}
	$userid = $this->session->user_id;
	$sid = $this->session->school_id;
	
	$data['isIAS']=$this->isiasenabled('FN');
	$currdate=date('Y-m-d');
	if($this->session->bstartdate <= $currdate){}
	else{redirect('index.php/home/dashboard');}
	
	$get_bspi_rows =$this->Assessment_model->getBSPI($userid);
	$data['isuserplayed_BT']=$this->Assessment_model->isuserplayed_BT($userid);
	$data['get_btscore']=$this->Assessment_model->get_btscore($userid);
	//$btcount = $data['isuserplayed_BT'][0]['total'];

	 
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
		$data['mspi'] = $this->MyCurrentMspi('FN');
		$data['actualGames'] = $this->Assessment_model->get_BTGames($sid,$this->session->game_grade);
			
			/* Expire time Validation */
			if($this->session->TimerRunningStatus=='Y')
			{
				$maxtimofplay=$this->Assessment_model->getMaxTimeofPlay();
				$sumoftottimeused=$this->Assessment_model->getSumofUserUsedTime($userid,date('Y-m-d'));
				$data['maxtimeofplay']=$maxtimofplay[0]['value'];
				$data['sumoftottimeused']=$sumoftottimeused[0]['LoggedIntime'];
				$data['Remainingtime']=$maxtimofplay[0]['value']-$sumoftottimeused[0]['LoggedIntime'];
				if($sumoftottimeused[0]['LoggedIntime']>=$maxtimofplay[0]['value'])
				{
					$this->TodayTimerInsert();
				}
			}
			/* Expire time Validation */
		
		/*........... ECertificateList .......*/
			$arrofec=$this->ECertificateList();
			$data['sbbadge']=$arrofec['sbbadge'];
			$data['sabadge']=$arrofec['sabadge'];
			$data['sgbadge']=$arrofec['sgbadge'];
		/*........... ECertificateList .......*/
		
		/*......... Brain Test Language .............*/
			$data['lang']=$this->Assessment_model->getBrainTestLanguage();
			if(!isset($this->session->currentlanguage))
			{
				$this->session->set_userdata(array('currentlanguage'=>'101'));
			}
			if($this->session->game_grade==8){$quecount="6";}
			else if($this->session->game_grade==9){$quecount="7";}
			else if($this->session->game_grade==10){$quecount="8";}
			else if($this->session->game_grade==12){$quecount="9";}
			else if($this->session->game_grade==13){$quecount="10";}
			else if($this->session->game_grade==14){$quecount="11";}
			else if($this->session->game_grade==15){$quecount="12";}
			
			$this->session->set_userdata(array( 'currentquestion'=>$quecount));
		/*......... Brain Test Language .............*/

		$data['sparkies']=$this->MySparkies();
	
		$this->load->view('headerinner', $data);
		$this->load->view('home/braintest', $data);
		$this->load->view('footerinner');
	
}
public function isiasenabled($type=null)
{	
	$isuserplayed_BT=$this->Assessment_model->isuserplayed_BT($this->session->user_id);
	$currdate = date('Y-m-d');

	if(($this->session->bstartdate <= $currdate && $currdate <= $this->session->benddate) && $isuserplayed_BT[0]['total']==0)
	{	
		$response=1;
	}
	else
	{
		$response=0;
	}
	if($type=='FN')
	{
		return $response;
	}
	else
	{
		echo $response;
	}
}
public function setBTLanguage()
{
	if(!empty($_POST))
	{	
		$langid=$this->input->post('languageid');
		$this->session->set_userdata(array('currentlanguage'=>$langid));
		echo 1;
	}
	else
	{
		echo 0;
	}
}

/*-----------------------------------------------------------------*/	


public function semester_certificate()
{
	//echo 'hai'; exit;
	$score = $this->input->post('score');
	$username = $this->session->fullname;
	$userid = $this->session->user_id;
	$type = $this->input->post('type');
	
	$data['userinfo'] = $this->Assessment_model->userinfo($userid);
	
	$sname = $data['userinfo'][0]['sname'];
	$class = str_replace('Grade', '', $data['userinfo'][0]['classname']).' '.$data['userinfo'][0]['section'];
	$MonofYear = date('F', strtotime('last month'))."_".date('Y');
	if($type=='bspitopper') 
	{
		$imagename= "BSPI-Topper-Certificate.jpg";
		$foldername= "bspitopper";
		$skillname= "bspi";
	}
	else if($type=='m_topper') 
	{
		$imagename= "Memory-Certificate.jpg";
		$foldername= "skilltopper";
		$skillname= "mem";
	}
	else if($type=='vp_topper') 
	{
		$imagename= "VP-Certificate.jpg";
		$foldername= "skilltopper";
		$skillname= "vp";
	}
	else if($type=='fa_topper') 
	{
		$imagename= "FA-Certificate.jpg";
		$foldername= "skilltopper";
		$skillname= "fa";
	}
	else if($type=='ps_topper') 
	{
		$imagename= "PS-Certificate.jpg";
		$foldername= "skilltopper";
		$skillname= "ps";
	}
	else if($type=='li_topper') 
	{
		$imagename= "LI-Certificate.jpg";
		$foldername= "skilltopper";
		$skillname= "li";
	}
	else if($type=='crowny_topper') 
	{
		$imagename= "CrownyTopper-Certificate.jpg";
		$foldername= "crownytopper";
		$skillname= "crwny";
	}
	
		 //$BackgroundImage= base_url().'assets/images/SuperAngel-Certificate.jpg';
		$BackgroundImage= '/mnt/nschools/assets/images/semester_certificates/'.$imagename;
		
	//	$BackgroundImage= '/home/skillangels/public_html/html5devschools/assets/images/semester_certificates/'.$imagename;
	
		$img = $this->LoadJpeg_semester($BackgroundImage,$username,$class,$sname,$score);	
		// imagejpeg($img);
		// imagedestroy($img);
		$foldername="Ecertificates/semester1/".$foldername."/".trim($userid)."/";
			if (!file_exists($foldername)) {
				mkdir($foldername, 0777, true);
			}
		$username=str_replace(' ', '', $username);
		imagejpeg($img,$foldername.''.$skillname.'_'.$username.".jpg");
		imagedestroy($img);
		
		
		$file_name=$skillname.'_'.$username.".jpg";
		$file_url=base_url()."".$foldername.''.$skillname.'_'.$username.".jpg";
		
		$arresult=array("file_name"=>$file_name,"file_url"=>$file_url);
		$res=json_encode($arresult);
		echo $res;exit;
}

public function LoadJpeg_semester($fBackgroundImage,$username,$class,$sname,$score)
{
    /* Attempt to open */
    $im = @imagecreatefromjpeg($fBackgroundImage);
    /* See if it failed */
    if(!$im)
    {
      echo "Loading bg has issue ".$fBackgroundImage;
    }
// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
// The text to draw
// Replace path by your own font path
//$font = "fonts/OpenSansBold.ttf";
//$font = APPPATH."../assets/fonts/OpenSansBold.ttf";
$font = "/mnt/nschools/assets/fonts/OpenSansBold.ttf";
// Add some shadow to the text
	$lastmonthname = date('F', strtotime('last month'));
	$currentyear = date('Y');

	$text_color = imagecolorallocate($im, 213, 91, 0);
	imagettftext ($im, 20, 0, 425, 470, $text_color, $font, $username);
	imagettftext ($im, 20, 0, 287, 524, $text_color, $font, $class);
	imagettftext ($im, 18, 0, 485, 520, $text_color, $font, $sname);
	//imagettftext ($im, 18, 0, 350, 620, $text_color, $font, $lastmonthname."-".$currentyear);
	/* imagestring($im, 5, 200, 92, str_pad($fCity,50," ",STR_PAD_BOTH), $text_color);
	imagestring($im, 5, 200, 107, str_pad($fState,50," ",STR_PAD_BOTH), $text_color); */
	/* BSPIScore */ 
	$text_color = imagecolorallocate($im, 255, 255, 255);

	
    return $im;
}
	
	
public function icon()
{

if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}

$data['isIAS']=$this->isiasenabled('FN');

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

$data['bspi'] = $this->getBspi();
$data['asapbspi'] = $this->getAsapBspi();
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

/*........... ECertificateList .......*/
$arrofec=$this->ECertificateList();
$data['sbbadge']=$arrofec['sbbadge'];
$data['sabadge']=$arrofec['sabadge'];
$data['sgbadge']=$arrofec['sgbadge'];
/*........... ECertificateList .......*/

$data['sparkies']=$this->MySparkies();

$this->load->view('headerinner', $data);
$this->load->view('myprofile/icon', $data);
$this->load->view('footerinner');

}

public function email_login_log($subject,$message)
{
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->Host = "smtp.falconide.com";
	$mail->Port = 587;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "";
	$mail->Username = "skillsangelsfal";
	$mail->Password = "SkillAngels@123";
	$mail->setFrom('angel@skillangels.com', 'SkillAngels');
	$mail->addReplyTo('angel@skillangels.com', 'SkillAngels');
	$mail->addAddress('damu@skillangels.com', 'Damu'); //to mail id
	//$mail->addAddress('damu.skillangels@gmail.com', 'Damu'); //to mail id
	$mail->addAddress('ramya@skillangels.com', 'Ramya'); //to mail id
	$mail->addAddress('sarav@skillangels.com', 'Sarav'); //to mail id		
		
	$mail->Subject = $subject;
	$mail->msgHTML($message);
	if (!$mail->send()) {
	   //echo "Mailer Error: " . $mail->ErrorInfo;
	   return 0;
	} else {
	   //echo "Message sent!";
		return 1;
	}  
}

public function log1()
{
	if($this->session->user_id=='51866' || $this->session->user_id=='52537' || $this->session->user_id=='38336')
	{
				$ipaddress = '';
				if (getenv('HTTP_CLIENT_IP'))
					$ipaddress = getenv('HTTP_CLIENT_IP');
				else if(getenv('HTTP_X_FORWARDED_FOR'))
					$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
				else if(getenv('HTTP_X_FORWARDED'))
					$ipaddress = getenv('HTTP_X_FORWARDED');
				else if(getenv('HTTP_FORWARDED_FOR'))
					$ipaddress = getenv('HTTP_FORWARDED_FOR');
				else if(getenv('HTTP_FORWARDED'))
				   $ipaddress = getenv('HTTP_FORWARDED');
				else if(getenv('REMOTE_ADDR'))
					$ipaddress = getenv('REMOTE_ADDR');
				else
					$ipaddress = 'UNKNOWN';
				$ip= $ipaddress;

			$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
			if($query && $query['status'] == 'success') 
			{
				$subject = 'User Access Log';
				$message = '<table align="center" width="800px" border="1" cellspacing="0" cellpadding="0" style="font-size:medium;margin-right:auto;margin-left:auto;border:1px solid rgb(197,197,197);font-family:Arial,Helvetica,sans-serif;background-image:initial;background-repeat:initial;box-shadow: 10px 10px 5px #35395e;"><tbody><tr style="display:block;overflow:hidden;background: #1e88e5;"><td style="float:left;border:0px;text-align: center;padding: 10px 0px;width:33%;color: #fff;"></td><td style="float:left;border:0px;text-align: center;padding: 5px 0px;width: 33%;color: #fff;">'.$this->session->fname.' Logged In Details</td><td style="float:left;border:0px;text-align: center;padding: 10px 0px;width: 33%;color: #fff;"></td></tr><tr style="padding:0px;margin:10px 42px 20px;display:block;font-size:13px;font-family:Verdana,Geneva,sans-serif;line-height:18px;text-align:justify"><td colspan="2" style="border:0px">Dear Team,<br/><br/>Please find the login details.<br/><br/>Logged in user name <strong> :'.$this->session->fname.' </strong><br/>Logged in date time<strong> : '.date("d/m/Y h:i a", strtotime(date("Y-m-d h:i a"))).'</strong><br/>Logged in IP<strong> : '.$ip.'</strong><br/>Logged in location<strong> : '.$query['country'].' - '.$query['regionName'].' - '.$query['city'].' - '.$query['zip'].'</strong><strong></strong><br/></td></tr><tr style="display:block;overflow:hidden"><td style="float:left;border:0px;"></td></tr></tbody></table>';
				//echo $message;exit;
				$emailstatus=$this->email_login_log($subject,$message); 
				
				$this->Assessment_model->InsertAccessLog($this->session->user_id,$query['query'],$query['country'],$query['regionName'],$query['city'],$query['zip'],$emailstatus);

			}
			if($RemainingDay<=7)
			{
				$AEsubject = 'User Account Expiry Details';
				$AEmessage = '<table align="center" width="800px" border="1" cellspacing="0" cellpadding="0" style="font-size:medium;margin-right:auto;margin-left:auto;border:1px solid rgb(197,197,197);font-family:Arial,Helvetica,sans-serif;background-image:initial;background-repeat:initial;box-shadow: 10px 10px 5px #35395e;"><tbody><tr style="display:block;overflow:hidden;background: #1e88e5;"><td style="float:left;border:0px;text-align: center;padding: 10px 0px;width:33%;color: #fff;"></td><td style="float:left;border:0px;text-align: center;padding: 5px 0px;width: 33%;color: #fff;">'.$this->session->fname.' Account Expiry Details</td><td style="float:left;border:0px;text-align: center;padding: 10px 0px;width: 33%;color: #fff;"></td></tr><tr style="padding:0px;margin:10px 42px 20px;display:block;font-size:13px;font-family:Verdana,Geneva,sans-serif;line-height:18px;text-align:justify"><td colspan="2" style="border:0px">Dear Team,<br/><br/>Please find the Account Expiry Details of  '.$this->session->fname.'.<br/><br/>Logged in user name <strong> :'.$this->session->fname.' </strong><br/>Account expiry date<strong> : '.date("d/m/Y", strtotime($this->session->aenddate)).'</strong><br/></td></tr><tr style="display:block;overflow:hidden"><td style="float:left;border:0px;"></td></tr></tbody></table>';
				
				$emailstatus=$this->email_login_log($AEsubject,$AEmessage); 
			}
	}
	
}


/* ------------------------ Staff FeedBack ------------------------ */
public function feedback()
	{			
		$userid=$this->uri->segment('3');
		if($userid!='')
		{
			$isvalid=$this->Assessment_model->checkValidUser($userid);
			if($isvalid[0]['id']!='')
			{
				$data['isvaliduser']=1;
			}
			else
			{
				$data['isvaliduser']=0;
			}
			$arroffeedback=$this->Assessment_model->getStaffFeedback($userid);
			if($arroffeedback[0]['id']!='')
			{
				$data['feedbacksent']=1;
			}
			else
			{
				$data['feedbacksent']=0;
			}
			$data['staffid']=$isvalid[0]['id'];
			//echo "<pre>";print_r($data);exit;
			//$this->load->view('header');
			$this->load->view('feedback',$data);
			//$this->load->view('footer');
			
		}	
	}
	
	public function StaffFeedbackInsert()
	{
		$qus1=$this->input->post('qus1');
		$qus2=$this->input->post('qus2');
		$qus3=$this->input->post('qus3');
		$qus4=$this->input->post('qus4');
		$qus5=$this->input->post('qus5');
		$staffid=$this->input->post('staffid');
		
		if($qus1!='' && $qus2!='' && $qus3!='' && $qus4!='' && $qus5!='' && $staffid!='')
		{
			$lastid=$this->Assessment_model->StaffFeedbackInsert($staffid,$qus1,$qus2,$qus3,$qus4,$qus5);
			$arrResult=array("response"=>"1","msg"=>"Thank you for your valuable feedback");
			echo json_encode($arrResult);exit;
		}
		else
		{
			$arrResult=array("response"=>"0","msg"=>"Please provide required field values");
			echo json_encode($arrResult);exit;
		}
	}
/* ------------------------ Staff FeedBack ------------------------ */

/* ------------------------ Time zone ------------------------ */

public function TimeZoneUpdate()
	{
		if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}
		$TimeZone=$this->input->post('TimeZone'); 
		if(isset($TimeZone) && $TimeZone!='')
		{
			$this->session->set_userdata(array('timezone'=>$TimeZone));
			$this->Assessment_model->UpdateUserZone($this->session->user_id,$TimeZone);
			echo 1;exit;
		}
		else
		{
			echo 0;exit;
		}
	}

/*------------ MAth Puzzles integration ------------ */
	Public function math()
	{		
		if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}
		$data['bspi'] = $this->getBspi();
		$data['mspi'] = $this->MyCurrentMspi('FN');
		/* Expire time Validation */
			if($this->session->TimerRunningStatus=='Y')
			{
				$maxtimofplay=$this->Assessment_model->getMaxTimeofPlay();
				$sumoftottimeused=$this->Assessment_model->getSumofUserUsedTime($userid,date('Y-m-d'));
				$data['maxtimeofplay']=$maxtimofplay[0]['value'];
				$data['sumoftottimeused']=$sumoftottimeused[0]['LoggedIntime'];
				$data['Remainingtime']=$maxtimofplay[0]['value']-$sumoftottimeused[0]['LoggedIntime'];
				if($sumoftottimeused[0]['LoggedIntime']>=$maxtimofplay[0]['value'])
				{
					$this->TodayTimerInsert();
				}
			}
		/* Expire time Validation */
		$data['sparkies']=$this->MySparkies();	 
		$this->load->view('headerinner', $data);
		$this->load->view('math/math', $data);
		$this->load->view('footerinner');
	}
	Public function MathPuzzles()
	{
		$data['bspi'] = $this->getBspi();
		$data['mspi'] = $this->MyCurrentMspi('FN');
		$arrMathAssigned=$this->Assessment_model->checkMathAssignedToday($this->session->user_id,$this->session->game_grade);
		$arrAssignedPuzzles=$this->Assessment_model->checkTotalAssignedPuzzles($this->session->user_id,$this->session->game_grade);
		if($arrMathAssigned[0]['assigned']>0)
		{ // Already Assigne Game for a Today.
			$data['arrofmath']=$this->Assessment_model->getTodayPuzzles($this->session->user_id,$this->session->game_grade);
		}
		else
		{ // Assign New Game For today
			if($arrAssignedPuzzles[0]['assigned']>=10)
			{ // Delete Previous data and Insert
				$this->Assessment_model->DeletePrevMathCycle($this->session->user_id,$this->session->game_grade);
				$AssignedGameID=$this->Assessment_model->AssignTodayMathPuzzles($this->session->user_id,$this->session->game_grade);
				if($AssignedGameID[0]['mid'])
				{
					$this->Assessment_model->InertTodayMathPuzzles($AssignedGameID[0]['mid'],$this->session->user_id,$this->session->game_grade);
				}
			}
			else
			{// Insert new data
				$AssignedGameID=$this->Assessment_model->AssignTodayMathPuzzles($this->session->user_id,$this->session->game_grade);
				if($AssignedGameID[0]['mid'])
				{
					$this->Assessment_model->InertTodayMathPuzzles($AssignedGameID[0]['mid'],$this->session->user_id,$this->session->game_grade);
				}
			}
			$data['arrofmath']=$this->Assessment_model->getTodayPuzzles($this->session->user_id,$this->session->game_grade);
		} 
		
		/* Expire time Validation */
			$maxtimofplay=$this->Assessment_model->getMaxTimeofPlay($this->session->school_id);
			$sumoftottimeused=$this->Assessment_model->getSumofUserUsedTime($this->session->user_id,date('Y-m-d'));
			$data['maxtimeofplay']=$maxtimofplay[0]['value'];
			$data['sumoftottimeused']=$sumoftottimeused[0]['LoggedIntime'];
			$data['Remainingtime']=$maxtimofplay[0]['value']-$sumoftottimeused[0]['LoggedIntime'];
			if($sumoftottimeused[0]['LoggedIntime']>=$maxtimofplay[0]['value'])
			{
				$this->TodayTimerInsert();
			}
		/* Expire time Validation */
		/*-------- Total Score -------*/
			$data['arrofmathscore']=$this->Assessment_model->getTotalScoreofMath($this->session->user_id);
			
			$startdate = $this->session->astartdate;
			$enddate = $this->session->aenddate;
			$data['academicmonths'] = $this->Assessment_model->getacademicmonths($startdate,$enddate);
			$data['isEligibleToday']=$this->TodayMathPuzzleEligible('FN');
		/*-------- Total Score -------*/
		//echo "<pre>";print_r($data);exit;
		$this->load->view('math/math_ajax', $data);
	}
	
	public function getMonthWiseMathScore()
	{
		$montharr=$this->input->post('Month');
		$arrofval=explode("-",$montharr);
		$Month=$arrofval[0];
		$Year=$arrofval[1];
		
		$data['arrofmathscore']=$this->Assessment_model->getMathScoreByMonth($this->session->user_id,$Month,$Year);
		
		$this->load->view('math/math_chart', $data);
	}
	public function TodayMathPuzzleEligible($type=null)
	{
		$tot_games_played=$this->Assessment_model->TodayMathPuzzleEligible($this->session->user_id,$Month,$Year);
		if($type=='FN')
		{
			if($tot_games_played['0']['tot_games_played']==5)
			{
				return 1;exit;
			}
			else
			{
				return 0;exit;
			}
		}
		else
		{
			if($tot_games_played['0']['tot_games_played']==5)
			{
				echo 1;exit;
			}
			else
			{
				echo 0;exit;
			}
		}
	}
	public function MathPuzzleEligible($type=null)
	{
		$tot_games_played=$this->Assessment_model->MathPuzzleEligible($this->session->user_id,$Month,$Year);
		if($type=='FN')
		{
			return $tot_games_played['0']['tot_games_played'];
		}
		else
		{
			echo $tot_games_played['0']['tot_games_played'];
		}
	}
	public function mathgamesajax()
	{
		$gameurl =  $_POST['gameurl']; 
		$gname = substr($gameurl, strrpos($gameurl, '/') + 1);
		$gamename = str_replace('.html','', $gname); 
		
		$data['gameid'] = $this->Assessment_model->getMathGameId($gamename);
		$gameid = $data['gameid'][0]['mid'];
		$this->session->set_userdata(array( 'MATHGID'=> $gameid ));  
		echo $this->session->MATHGID;exit;
	}

	public function resultmath()
	{
		if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php'); exit;}
		if(!isset($_POST)){redirect('index.php'); exit;}
		if(empty($_POST)){redirect('index.php'); exit;}
			
		$total_ques=$_POST["tqcnt1"];

		$attempt_ques=$_POST["aqcnt1"];

		$answer=$_POST["cqcnt1"];
		$score=$_POST["gscore1"];
		$a6=$_POST["gtime1"];
		$a7=$_POST["rtime1"];
		$a8=$_POST["crtime1"];
		$a9=$_POST["wrtime1"];	
		$gameid=$this->session->MATHGID;
		$skillkit='';
		$btscore = '';
		
		if($gameid=='')
		{
			echo "-1";exit;
		}
		
		$userid = $this->session->user_id; 
		$lastup_date = date("Y-m-d");
		$cid = 1;
		  
		
		$data['chkschedule'] = $this->Assessment_model->checkscheduledays($this->session->game_grade,$this->session->section,$this->session->school_id);
		$schedule_val = $data['chkschedule'][0]['scheduleday'];
		$skillid=69;
		$pid =  $this->session->gp_id; 
		
		$data['insert1'] = $this->Assessment_model->InsertMathData($userid,$cid,$skillid,$pid,$gameid,$total_ques,$attempt_ques,$answer,$score,$a6,$a7,$a8,$a9,$lastup_date,$schedule_val);
		
		  
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
	public function MyCurrentMspi($type=null)
	{
		$arrofmathscore=$this->Assessment_model->getTotalScoreofMath($this->session->user_id);
		if($type=='FN')
		{
			return $arrofmathscore['0']['TotalScore'];exit;
			
		}
		else
		{
			echo $arrofmathscore['0']['TotalScore'];exit;
		}
	}
	

		/*------------ MAth Puzzles integration ------------ */
/* ------------------------ Single entry ------------------------ */
	
	public function get_info()
	{
		$gname=$this->input->post('gname');
		$uid=$this->session->user_id; 
		//$uid=38332; 
		$curdate=date('Y-m-d'); 
		
		if($gname!='' && $uid!='')
		{
			$arrgame=$this->Assessment_model->getGameValues($gname); 
			if(isset($arrgame[0]['gid'])!='' && $arrgame[0]['gid']!='')
			{
				$skillkit=0;
				if($this->session->isskillkit=="Y"){$skillkit=1;}
				
				if($skillkit==0)
				{ // Daily Puzzles
					$arrofpuzzle=$this->Assessment_model->getPuzzle_cycle($arrgame[0]['gid'],$uid);
					$current_Cycle=$arrofpuzzle[0]['play_cycle']+1;
					
					$arrPlyedDetails=$this->Assessment_model->getGamePlayedDetails($arrgame[0]['gid'],$uid,$current_Cycle,$curdate);
				}
				else
				{// Skillkit Puzzles
					$arrofpuzzle=$this->Assessment_model->getSKPuzzle_cycle($arrgame[0]['gid'],$uid);
					$current_Cycle=$arrofpuzzle[0]['play_cycle']+1;
					
					$arrPlyedDetails=$this->Assessment_model->getSKGamePlayedDetails($arrgame[0]['gid'],$uid,$current_Cycle,$curdate);
				}
				//echo "<pre/>";print_r($arrPlyedDetails);exit;
				$arr=array(
					"gname"=>$gname,
					"gameid"=>$arrgame[0]['gid'],
					"skillid"=>$arrgame[0]['gs_id'],
					"qcnts"=>$arrPlyedDetails[0]['qcnts'],
					"scores"=>$arrPlyedDetails[0]['scores'],
					"timerval"=>$arrPlyedDetails[0]['timerval'],
					"qvalues"=>$arrPlyedDetails[0]['qvalues'],
					"rsptime"=>$arrPlyedDetails[0]['rsptime'],
					"questionscore"=>$arrPlyedDetails[0]['questionscore'],
					"useranswer"=>$arrPlyedDetails[0]['useranswer'],
					"crtcnt"=>$arrPlyedDetails[0]['crtcnt'],
					"puzzle_cycle"=>$current_Cycle,
					"status"=>1
				);
				
			}
			else
			{
				$arr=array(
					"gameid"=>'',
					"gname"=>'',
					"skillid"=>'',
					"qcnts"=>'',
					"scores"=>'',
					"timerval"=>'',
					"qvalues"=>'',
					"rsptime"=>'',
					"questionscore"=>'',
					"useranswer"=>'',
					"crtcnt"=>'',
					"puzzle_cycle"=>'',
					"status"=>0
				);
			}
			echo '{"gameinfo":'.json_encode($arr).'}';exit; 
		}
		else
		{
			$arr=array(
					"gameid"=>'',
					"gname"=>'',
					"skillid"=>'',
					"qcnts"=>'',
					"scores"=>'',
					"timerval"=>'',
					"qvalues"=>'',
					"rsptime"=>'',
					"questionscore"=>'',
					"useranswer"=>'',
					"crtcnt"=>'',
					"puzzle_cycle"=>'',
					"status"=>0
				);
			echo '{"gameinfo":'.json_encode($arr).'}';exit; 
		}
	}
	public function scoreupdate()
	{
		//echo "<pre>";print_r($_GET);exit;
		//if(isset($_POST["SID"]) && isset($_POST["GID"]) && isset($_POST["RT"]) && isset($_POST["TV"]) && isset($_POST["CA"]) && isset($_POST["UA"]) && isset($_SESSION['AS'])&& isset($_POST['QNO'])&& isset($_POST['SCORE'])&& isset($_POST['puzzle_cycle'])&& isset($_POST['TOS']))
		if(isset($_REQUEST["SID"]) && isset($_REQUEST["GID"]) && isset($_REQUEST["RT"]) && isset($_REQUEST["TV"]) && isset($_REQUEST["CA"]) && isset($_REQUEST["UA"]) && isset($_REQUEST['AS']) && isset($_REQUEST['QNO']) && isset($_REQUEST['SCORE']) && isset($_REQUEST['puzzle_cycle']) && isset($_REQUEST['TOS']))
		{
			 
			$uid=$this->session->user_id; 
			//$uid=38332; 
			$SID=$_REQUEST["SID"]; 
			$GID=$_REQUEST["GID"];
			$ResponseTime=$_REQUEST["RT"];
			$BalaceTime=$_REQUEST["TV"];
			$CorrectAnswer=$_REQUEST["CA"];
			$UserAnswer=$_REQUEST["UA"];
			$AnswerStaus=$_REQUEST["AS"];
			$QNO=$_REQUEST["QNO"];
			$SCORE=$_REQUEST["SCORE"];
			$puzzle_cycle=$_REQUEST["puzzle_cycle"];
			$TimeOverStatus=$_REQUEST["TOS"];
			$todaydaste = date('Y-m-d');
			
			$pid=$this->session->gp_id;
			
			$gametime=180; 
			//$gametime=$_REQUEST["G_T"];
			
			$skillkit=0;
			if($this->session->isskillkit=="Y"){$skillkit=1;}
			
			if($skillkit==0)
			{	 
				$arrofPlayedCount=$this->Assessment_model->getPlayedPuzzleCount($uid,$todaydaste,$GID,$puzzle_cycle);
			
				if($arrofPlayedCount[0]['playedcount']>9)
				{
					echo -2;exit;
				} 
				$curdate=date('Y-m-d'); 
				$curdatetime=date('Y-m-d H:i:s'); 
				
				$GameResult=$this->Assessment_model->InsertGameData($uid,$SID,$GID,$ResponseTime,$BalaceTime,$CorrectAnswer,$UserAnswer,$AnswerStaus,$QNO,$SCORE,$TimeOverStatus,$puzzle_cycle,$curdate,$curdatetime,$gametime,$pid);
				
				if($GameResult[0]['OUTPUT']=='GAMEINSERT')
				{
					$arrofGameData=$this->Assessment_model->getLastPlayedGameData($uid,$todaydaste,$GID,$puzzle_cycle);
					
					$arrofinput=array("inSID"=>$this->session->school_id,"inGID"=>$this->session->game_grade,'inUID'=>$uid,'inScenarioCode'=>'GAME_END','inTotal_Ques'=>$arrofGameData[0]['total_question'],'inAttempt_Ques'=>$arrofGameData[0]['attempt_question'],'inAnswer'=>$arrofGameData[0]['answer'],'inGame_Score'=>$arrofGameData[0]['game_score'],"inPlanid"=>$pid,'inGameid'=>$GID);

					/*--- Sparkies ----*/
					$sparkies_output=$this->Assessment_model->insertsparkies($arrofinput);
					$_REQUEST['gameoutput']=$sparkies_output[0]['OUTPOINTS'];
					//$this->session->set_flashdata('newsparky', $sparkies_output[0]['OUTPOINTS']);
					/*--- News Feed ----*/
					$newsfeed_output=$this->Assessment_model->insertnewsfeeddata($arrofinput);		
					echo $sparkies_output[0]['OUTPOINTS'];exit;
				}
				else
				{
					echo 'SI';exit;// Closing the popup, 
				}
			}
			else
			{// Skill game Data
		
				$arrofPlayedCount=$this->Assessment_model->getSKPlayedPuzzleCount($uid,$todaydaste,$GID,$puzzle_cycle);
				//echo "<pre>";print_r($arrofPlayedCount);exit;
				if($arrofPlayedCount[0]['playedcount']>9)
				{
					echo -2;exit;
				} 
				$curdate=date('Y-m-d'); 
				$curdatetime=date('Y-m-d H:i:s');  
				
				$arrofpuzzle=$this->Assessment_model->InsertSKGameData($uid,$SID,$GID,$ResponseTime,$BalaceTime,$CorrectAnswer,$UserAnswer,$AnswerStaus,$QNO,$SCORE,$TimeOverStatus,$puzzle_cycle,$curdate,$curdatetime,$gametime,$this->session->gp_id);
				echo 1;
			}
			/* $arrofpuzzle=$this->Assessment_model->InsertSingleGameScore($uid,$SID,$GID,$ResponseTime,$BalaceTime,$CorrectAnswer,$UserAnswer,$AnswerStaus,$QNO,$SCORE,$TimeOverStatus,$puzzle_cycle,$curdate,$curdatetime); */
			
		} 
		else
		{
			echo -1;
		}
	}
/* ------------------------ Single entry ------------------------ */
	
}
