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
				$this->load->model('Dashboard_model');
				$this->load->library('session');
				$this->load->library('My_PHPMailer');
				$this->load->library('Ajax_pagination');
				$this->perPage = 12;
        }
		
	public function index()
	{			
		//$this->load->view('header');
		$this->load->view('index');
		//$this->load->view('footer');
		
	}
	
	public function logincheck()
	{	

	
			$data['query'] = $this->Dashboard_model->checklogin($this->input->post('username'),md5($this->input->post('password')));
		//	echo $data['query'][0]['school_id']; exit;
			if(isset($data['query'][0]['id'])){ 
			
			$uniqueId = $data['query'][0]['id']."".date("YmdHis")."".round(microtime(true) * 1000);
			
			$this->session->set_userdata(array(
			
			'centername'       => $data['query'][0]['centername'],
			'centerid'       => $data['query'][0]['id'],
			'centercode'       => $data['query'][0]['code'],
			'login_session_id'=>$uniqueId, 
			'school_id'       => 2,
			'game_grade'  => 11,
			
			));
			
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip=$_SERVER['HTTP_CLIENT_IP'];}
			elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];} else {
			$ip=$_SERVER['REMOTE_ADDR'];}		
			$this->Dashboard_model->insert_login_log($data['query'][0]['id'],$uniqueId,$ip,$this->input->post('txcountry'),$this->input->post('txregion'),$this->input->post('txcity'),$this->input->post('txisp'),$_SERVER['HTTP_USER_AGENT'],1);
			
			redirect('index.php/home/userperformance');
			}
			else {
				$data['error'] = 'Invalid Crendentials';
				$this->load->view('index', $data);
			}
	}
	
	public function checkuserisactive()
	{
		if($this->session->centerid=="" || !isset($this->session->centerid)){redirect('index.php');}
		
			$this->Dashboard_model->update_login_log($this->session->centerid,$this->session->login_session_id);
	}
	
	public function dashboard()
	{
		if($this->session->centerid=="" || !isset($this->session->centerid)){redirect('index.php');}
		
		$centerid = $this->session->centerid;
		$data['userscount'] = $this->Dashboard_model->userscount($centerid);
		//$data['couponcount'] = $this->Dashboard_model->couponcodecount($doctorid);
		//$data['doctorinfo'] = $this->Dashboard_model->doctorinfo($doctorid);
		$this->load->view('header', $data);
		$this->load->view('home', $data);
		$this->load->view('footer');
	}
	
	public function couponcounts()
	{
		if($this->session->doctorid=="" || !isset($this->session->doctorid)){redirect('index.php');}
		
		$doctorid = $this->session->doctorid;
		
		
		$data['scanstatus'] = $this->Dashboard_model->scanstatus($doctorid); 
	    $data['scanstatus'][0]['scancount'];
		
		echo $data['scanstatus'][0]['scancount']; exit;
	 	
	}
	
	public function userslist()
	{
		if($this->session->centerid=="" || !isset($this->session->centerid)){redirect('index.php');} 
		
		$data['totalrecord'] = $this->Dashboard_model->totalrec_userlist();
        $totalRec = $data['totalrecord'][0]['totalrecord'];  
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'index.php/home/userlist_PaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['userslist'] = $this->Dashboard_model->userslist('',$this->perPage);
		
		//$data['userslist'] = $this->Dashboard_model->userslist();
		$this->load->view('header');
		$this->load->view('users_list', $data);
		$this->load->view('footer');
	}
	
	public function userlist_PaginationData()
	{
		$conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }        
        //total rows count		
		$data['totalrecord'] = $this->Dashboard_model->totalrec_userlist();
        $totalRec = $data['totalrecord'][0]['totalrecord']; 
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'index.php/home/userlist_PaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset-$this->perPage;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['userslist'] = $this->Dashboard_model->userslist($offset,$this->perPage);
        
        //load the view
        $this->load->view('users_list_ajax.php', $data, false);
	}
	
	public function doctoredit()
	{
		if($this->session->doctorid=="" || !isset($this->session->doctorid)){redirect('index.php');}
		//$editid = $this->uri->segment(3);
		$doctorid = $this->session->doctorid;
		$data['getstate'] = $this->Dashboard_model->getstate();
	//	$data['gethospital'] = $this->Dashboard_model->gethospital();
		$data['editdoctor'] = $this->Dashboard_model->editdoctor($doctorid);
		 
		$this->load->view('header');
		$this->load->view('doctor_edit', $data);
		$this->load->view('footer');
		
	} 
	
	
	public function doctorupdate()
	{
		if($this->session->doctorid=="" || !isset($this->session->doctorid)){redirect('index.php');}
		
		//echo '<pre>'; print_r($_FILES);
		if(isset($_FILES["file"]["type"]))
{
	//echo 'yes'; exit;
$validextensions = array("jpeg", "jpg", "png");
$temporary = explode(".", $_FILES["file"]["name"]);
$file_extension = end($temporary);
 $size = getimagesize($files);
$maxWidth = 150;
$maxHeight = 150;
if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
) && in_array($file_extension, $validextensions)) {

$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
$targetPath = "assets/images/doctor/".$_FILES['file']['name']; // Target path where file is to be stored
//$output_dir = frontendurl()."assets/images/doctor/".$_FILES['file']['name'];
move_uploaded_file($sourcePath,$targetPath) ; 

}
}

//echo $targetPath; exit;

		
		$doctorid = $this->session->doctorid;
		
		 $data['addhospital'] = $this->Dashboard_model->updatedoctor($this->input->post('txtFName'),$this->input->post('txtLName'),$this->input->post('rdGender'),$this->input->post('txtDOB'),$this->input->post('txtEmail'),$this->input->post('txtSEmail'),$this->input->post('txtMobile'),$this->input->post('txtSMobile'),$this->input->post('ddlState'),$this->input->post('txtCity'),$this->input->post('txtAddress'),$doctorid,$targetPath,$this->input->post('txthospitalname'));
		 
		 redirect('index.php/home/dashboard');
		
	}
	
	public function couponlist()
	{
		if($this->session->doctorid=="" || !isset($this->session->doctorid)){redirect('index.php');} 
		$doctorid = $this->session->doctorid;
		$data['couponlist'] = $this->Dashboard_model->couponlist($doctorid);
		$this->load->view('header');
		$this->load->view('couponlist', $data);
		$this->load->view('footer');
	}
	
	public function playeddates()
{

	$userid = $this->input->post('userid');
	$data['playeddates']=$this->Dashboard_model->getplayeddates($userid);
	$resJSON = json_encode($data['playeddates']);
	/* $res = str_replace('lastupdate','date', $resJSON);
	echo  str_replace('gc_id','badge', $res);exit; */
	echo $resJSON;exit;
	//echo json_encode(array("date"=>$data['playeddates'])); exit;
	
}

public function getTrainingCalendarData($type=null)
{
	$userid = $this->input->post('userid');
	$curdate = $this->input->post('curdate');
	$arrval=$this->Dashboard_model->getTrainingCalendarData($userid,$curdate);
	$arrvalbspi=$this->Dashboard_model->getonedaybspi($userid,$curdate);
	$arrvalskillscore=$this->Dashboard_model->getonedayskillscore($userid,$curdate);
	
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

public function datewisebspi()
{
	$userid = $this->input->post('userid');
	$startdate = $this->input->post('startdate');
	$enddate = $this->input->post('enddate');
	$data['datewisebspi']=$this->Dashboard_model->datewisebspi_sc($userid,$startdate,$enddate);
	echo $data['json'] = json_encode($data['datewisebspi']);	exit;
}

public function overallskillscore()
{
	$userid = $this->input->post('userid');
	$startdate = $this->input->post('startdate');
	$enddate = $this->input->post('enddate');
	
	$skillscore = $this->Dashboard_model->overallskillscore_sc($userid,$startdate,$enddate);
	
	$skillset=array("SID59"=>0,"SID60"=>0,"SID61"=>0,"SID62"=>0,"SID63"=>0);
	 foreach($skillscore as $score)
	{
		$skillset["SID".$score['gs_id']]=round($score['skillscore'],2);
	}
	$data['skillscore']=$skillset;
	echo json_encode($data['skillscore']);exit;
	
}
	
	public function userview_sc()
	{
		if($this->session->centerid=="" || !isset($this->session->centerid)){redirect('index.php');}
		
		$userid = $this->uri->segment(3);
		$data['getusername'] = $this->Dashboard_model->getusername($userid);
		$uname = $data['getusername'][0]['username'];
		
		/* New Report  */
		$pid =$data['query'][0]['gp_id'];
		$data['Playedgames'] = $this->Dashboard_model->getgamenames($userid,$data['getusername'][0]['gp_id'],$data['getusername'][0]['startdate'],$data['getusername'][0]['enddate']);
		$data['academicmonths'] = $this->Dashboard_model->getacademicmonths($data['getusername'][0]['startdate'],$data['getusername'][0]['enddate']);
		
		$data['IsAsapEnable'] = $this->Dashboard_model->IsAsapEnable($uname);
		$data['IsCLPEnable'] = $this->Dashboard_model->IsCLPEnable($userid);
		
		
		
		$data['getuserinfo_sc'] = $this->Dashboard_model->getuserinfo_sc($userid);		
		$centerid = $this->session->centerid;
		$data['getcounters_sc'] = $this->Dashboard_model->getcounters_sc($userid);
		$data['getcrowny_sc'] = $this->Dashboard_model->getcrowny_sc($userid);
		//$data['my_percentilerank'] = $this->Dashboard_model->my_percentilerank($userid,$centerid);
		//$data['rank']=json_decode($data['my_percentilerank'],true );
		$data['getbspi_sc'] = $this->Dashboard_model->getbspi_sc($userid);
		
		$data['IsCLPEnable_sc'] = $this->Dashboard_model->IsCLPEnable_sc($userid);
		

		/* Efficiency Graph */

$arrofEfficiency=$this->Dashboard_model->getUserEfficiencyGraph($userid,$startdate,$enddate);
foreach($arrofEfficiency as $month)
{
	$userscore[$month['monthNumber'].$month['yearNumber'].'-S']=$month['score'];
	$userresponsetime[$month['monthNumber'].$month['yearNumber'].'-T']=$month['rtime'];
}
$data['Uscore']=$userscore;
$data['Utime']=$userresponsetime;

/* Efficiency Graph */
		
		
		$this->load->view('header');
		$this->load->view('user_view_sc', $data);
		if($data['IsCLPEnable_sc'][0]['playedstatus']>=1) {
		$this->load->view('footer');
		}
	}
	
	public function userview()
	{
		if($this->session->centerid=="" || !isset($this->session->centerid)){redirect('index.php');}
		
		$userid = $this->uri->segment(3);
		$data['getusername'] = $this->Dashboard_model->getusername($userid);
		$uname = $data['getusername'][0]['username'];
		
		/* New Report  */
		$pid =$data['query'][0]['gp_id'];
		$data['Playedgames'] = $this->Dashboard_model->getgamenames($userid,$data['getusername'][0]['gp_id'],$data['getusername'][0]['startdate'],$data['getusername'][0]['enddate']);
		$data['academicmonths'] = $this->Dashboard_model->getacademicmonths($data['getusername'][0]['startdate'],$data['getusername'][0]['enddate']);
		
		$data['IsAsapEnable'] = $this->Dashboard_model->IsAsapEnable($uname);
		$data['IsCLPEnable'] = $this->Dashboard_model->IsCLPEnable($userid);
		
		
		
		$data['getasapinfo'] = $this->Dashboard_model->getasapinfo($userid);
		$data['getuserid'] = $this->Dashboard_model->getuserid($uname);
		//$data['patienttype'] = $this->Dashboard_model->getpatienttype();
		$startdate = $data['getasapinfo'][0]['startdate'];
		$enddate = $data['getasapinfo'][0]['enddate'];
		$data['academicmonths'] = $this->Dashboard_model->getacademicmonths($startdate,$enddate);
		
		 $asapuserid = $data['getuserid'][0]['id']; 
		 
		 /*Current cycle*/
		$SessionLevel=$this->Dashboard_model->getCurrentSessionLevel($userid);
		
		
		
		if($SessionLevel[0]['session_id']!='')
		{ 
	
			foreach($this->config->item('CYCLE') as $cycle)
			{
				$range=explode('-',$cycle);
				//echo "<pre>";print_r($range);
				if($range[0]<=$SessionLevel[0]['session_id'] && $range[1]>=$SessionLevel[0]['session_id'])
				{
					$Session_StartRange=$range[0];
					$Session_EndRange=$range[1];
				}
				
			}
			$Session_Start_Range=$Session_StartRange;
			$Session_End_Range=$Session_EndRange;
			$Session_Curid=$SessionLevel[0]['session_id'];
			/* $this->session->set_userdata('Session_StartRange', $Session_StartRange);
			$this->session->set_userdata('Session_EndRange', $Session_EndRange);
			$this->session->set_userdata('Session_Curid', $SessionLevel[0]['session_id']); */
		}
		else
		{
			//echo 'hai'; exit;
			$SessionVar=$this->config->item('CYCLE');
			$range=explode("-",$SessionVar[0]);
			//echo $range[1]; exit;
			$Session_StartRange=$range[0];
			$Session_EndRange=$range[1];
			
			$Session_Start_Range=$Session_StartRange;
			$Session_End_Range=$Session_EndRange;
			$Session_Curid=0;
			
			/* $this->session->set_userdata('Session_StartRange', $Session_StartRange);
			$this->session->set_userdata('Session_EndRange', $Session_EndRange);
			$this->session->set_userdata('Session_Curid', 0); */
		}
		$data['Session_Start_Range']=$Session_Start_Range;
		$data['Session_End_Range']=$Session_End_Range; 
		 
		$data['default_cycle']=$this->Dashboard_model->getDefaultCycleData($Session_Start_Range,$Session_End_Range,$Session_Curid);
		
		 $data['asapbspi'] = $this->Dashboard_model->getbspicomparison($asapuserid);
		 $data['clpbspi'] = $this->Dashboard_model->clpbspi($userid);		 
			/*SKILL PERFORMANCE*/
	
$data['skillwiseaverage'] = $this->Dashboard_model->getskillwise_avg($uname);

$data['set1avg_M'] = ($data['skillwiseaverage'][0]['skillscorem']);

$data['set1avg_V'] = ($data['skillwiseaverage'][0]['skillscorev']);

$data['set1avg_F'] = ($data['skillwiseaverage'][0]['skillscoref']);

$data['set1avg_P'] = ($data['skillwiseaverage'][0]['skillscorep']);

$data['set1avg_L'] = ($data['skillwiseaverage'][0]['skillscorel']);
		/*SKILL PERFORMANCE*/
		
		$data['getcounters'] = $this->Dashboard_model->getcounters($userid);
		$data['getcrowny'] = $this->Dashboard_model->getcrowny($userid);
		$data['getattemptsession'] = $this->Dashboard_model->getattemptsession($userid);
		$data['getcompsession'] = $this->Dashboard_model->getcompsession($userid);
		
		/*SKILL PERFORMANCE CLP*/
$data['clp_skillwiseaverage'] = $this->Dashboard_model->get_clp_skillwise_avg($userid);
$data['MonthWiseSkillScore'] = $this->Dashboard_model->getMonthWiseSkillScore($userid,$startdate,$enddate);
$data['CLP_M'] = ($data['clp_skillwiseaverage'][0]['skillscorem']);

$data['CLP_V'] = ($data['clp_skillwiseaverage'][0]['skillscorev']);

$data['CLP_F'] = ($data['clp_skillwiseaverage'][0]['skillscoref']);

$data['CLP_P'] = ($data['clp_skillwiseaverage'][0]['skillscorep']);

$data['CLP_L'] = ($data['clp_skillwiseaverage'][0]['skillscorel']);
		/*SKILL PERFORMANCE CLP*/
		
		/* Efficiency Graph */

$arrofEfficiency=$this->Dashboard_model->getUserEfficiencyGraph($userid,$startdate,$enddate);
foreach($arrofEfficiency as $month)
{
	$userscore[$month['monthNumber'].$month['yearNumber'].'-S']=$month['score'];
	$userresponsetime[$month['monthNumber'].$month['yearNumber'].'-T']=$month['rtime'];
}
$data['Uscore']=$userscore;
$data['Utime']=$userresponsetime;

/* Efficiency Graph */
	
//echo "<pre>";print_r($data);exit;	
		
		$this->load->view('header');
		$this->load->view('user_view', $data);
		$this->load->view('footer');
	}
	
	
	public function getSkillChart()
{
	$cycleid = $this->input->post('cycle');
	$range_value = $this->input->post('range');
	$type = $this->input->post('type');
	$userid = $this->input->post('userid');
	
	$range=explode("-",$range_value);
//	$data['bspi']=$this->getBSPI($userid);

	$data['bspirange']=$this->Dashboard_model->getBSPI_range($userid,$range[0],$range[1]);
	$data['bspi']=$data['bspirange'][0]['avgbspiset1'];
	
	$academicyear=$this->Dashboard_model->getacademicyearbyschoolid($userid);
	
	if($type=='ADVANCE')
	{
		
		$arrSkillChart=$this->Dashboard_model->getAdvancedSkillChart($userid,$range[0],$range[1],$this->session->Session_Curid,$academicyear[0]['startdate'],$academicyear[0]['enddate']);
		$mybspiCalendarSkillScore=array("SID59"=>0,"SID60"=>0,"SID61"=>0,"SID62"=>0,"SID63"=>0);
		foreach($arrSkillChart as $score)
		{
			$mybspiCalendarSkillScore["SID".$score['gs_id']]=round($score['gamescore'],2);
		}
		 $data['SkillChart']=$mybspiCalendarSkillScore;
		 $data['skills'] = $this->Dashboard_model->getskills();
	}
	else
	{
		$arrSkillChart=$this->Dashboard_model->getBasicSkillChart($userid,$range[0],$range[1],$this->session->Session_Curid,$academicyear[0]['startdate'],$academicyear[0]['enddate']);
		$mybspiCalendarSkillScore=array("SID59"=>0,"SID60"=>0,"SID61"=>0,"SID62"=>0,"SID63"=>0);
		foreach($arrSkillChart as $score)
		{
			$mybspiCalendarSkillScore[$score['gs_id']]=round($score['gamescore'],2);
		}
		$data['SkillChart']=$mybspiCalendarSkillScore;
		$tsivalue=$this->Dashboard_model->getSkillKitBSPI($userid,$range[0],$range[1]);
		$data['bspi']=$tsivalue[0]['tsi'];
		$data['skills'] = $this->Dashboard_model->getAssignSkills($userid);
	}
	
	$data['CurrentBSPIName']=$this->Dashboard_model->getCurrentBSPIName($range[0],$range[1],$this->session->Session_Curid);
	
	$data['type']=$type;
		
	//echo "<pre>";print_r($data);exit;
	$this->load->view('reports/ajax_skillchart', $data);
}
	
	
	
	public function mybspi_report_ajax()
{
	/*$yeramonths = $this->comma_separated_to_array($_POST['hdnMonthID']);
	//print_r($yeramonths); exit;
	$test = "'" . implode("','", $yeramonths) . "'"; */
	$userid = $_POST['userid'];
	$mnthval = $_POST['bspireport'];
	$data['bspireport'] = $this->Dashboard_model->getbspireport1($userid,$mnthval); 
	$res_tot_memory=$res_tot_vp=$res_tot_fa= $res_tot_ps=$res_tot_lang=0;
$res_tot_memory_i=$res_tot_vp_i=$res_tot_fa_i= $res_tot_ps_i=$res_tot_lang_i=0;

foreach($data['bspireport'] as $get_res)
{
	//echo $get_res['gs_id'];
	//echo $get_res['gamescore'];
	if(($get_res['gs_id']=='59')){
			$res_tot_memory_i++;
			  $res_tot_memory += $get_res['gamescore'];	
		}else{
		 	$res_tot_memory += 0.00;
			}
if(($get_res['gs_id']=='60')){
				$res_tot_vp_i++;

			 	$res_tot_vp += $get_res['gamescore'];
		}else{
			 $res_tot_vp += 0.00;
			}
if(($get_res['gs_id']=='61')){
				$res_tot_fa_i++;

				 $res_tot_fa += $get_res['gamescore'];	
		}else{
			 $res_tot_fa += 0.00;
			}
if(($get_res['gs_id']=='62')){
				$res_tot_ps_i++;

			 $res_tot_ps += $get_res['gamescore'];	
		}else{
			 $res_tot_ps += 0.00;
			}
if(($get_res['gs_id']=='63')){
				$res_tot_lang_i++;

			 $res_tot_lang += $get_res['gamescore'];
		}else{
		 	$res_tot_lang += 0.00;
			}
		//$month_cnt =  count($_POST['option']);
}
if($res_tot_memory_i==0){$res_tot_memory_i=1;}
	if($res_tot_vp_i==0){$res_tot_vp_i=1;}
	if($res_tot_fa_i==0){$res_tot_fa_i=1;}
	if($res_tot_ps_i==0){$res_tot_ps_i=1;}
	if($res_tot_lang_i==0){$res_tot_lang_i=1;}
$tot = (($res_tot_memory/$res_tot_memory_i)+($res_tot_vp/$res_tot_vp_i)+($res_tot_fa/$res_tot_fa_i)+($res_tot_ps/$res_tot_ps_i)+($res_tot_lang/$res_tot_lang_i))/5;

echo $bspi = $tot;

}
	
public function ajaxcalendar()
{
$yearMonthQry=$this->input->post('yearMonth');
$userid =$userid = $this->input->post('userid');
$startdate = $this->input->post('startdate');
$enddate = $this->input->post('enddate');

//$data['academicmonths'] = $this->Dashboard_model->getacademicmonths($startdate,$enddate);
//$data['skills'] = $this->Dashboard_model->getskills();
$bspicalendardays= $this->Dashboard_model->mybspicalendar('',$userid,$yearMonthQry,$startdate,$enddate);
$mySkillCalendar= $this->Dashboard_model->mySkillCalendar('',$userid,$yearMonthQry,$startdate,$enddate);
$mybspiCalendar=array();
foreach($bspicalendardays as $days)
{
	$mybspiCalendar[$days['playedDate']]=$days['game_score'];
}
$data['mybspiCalendar']=$mybspiCalendar;
$myskillval=array();
foreach($mySkillCalendar as $days)
{
	$myskillval[$days['playedDate']."-".$days['gs_id']]=$days['game_score'];
}
$data['myskillval']=$myskillval;

	$data['yearMonthQry']=$yearMonthQry;
	$this->load->view('mybrainprofile/ajaxcalendar', $data);
}

public function brainskill_report_ajax()
{
	 $userid = $this->input->post('userid');
	 $gameid = $this->input->post('game');
	 $pid = $this->input->post('planid');
	 $startdate = $this->input->post('startdate');
	 $enddate = $this->input->post('enddate');
	$data['gamedetails'] = $this->Dashboard_model->getgamedetails($userid,$gameid,$pid ,$startdate,$enddate); 
	echo $data['json'] = json_encode($data['gamedetails']);	exit;
}
	
	public function update_patienttype()
	{
		$data['updatepatienttype'] = $this->Dashboard_model->updatepatienttype($_POST['userid'],$_POST['typeid']);
		echo 1; exit;
	}
	
	public function userperformance()
	{
		if($this->session->centerid=="" || !isset($this->session->centerid)){redirect('index.php');}
		
		$centerid = $this->session->centerid;
		/* $data['asap_reports'] = $this->Dashboard_model->asap_reports($centerid);
		$data['clp_reports'] = $this->Dashboard_model->clp_reports($centerid);
		$data['userscount'] = $this->Dashboard_model->userscount($centerid);
		$data['gradewiseusers'] = $this->Dashboard_model->gradewiseusers($centerid); */
		$data['getproduct'] = $this->Dashboard_model->getproductlist();
		$this->load->view('header');
		$this->load->view('patient_performance', $data);
		$this->load->view('footer');
	}
	
	public function gradewiseusers()
	{
		$centerid = $this->session->centerid;
		$data['gradewiseusers'] = $this->Dashboard_model->gradewiseusers($centerid);
		echo $data['json'] = json_encode($data['gradewiseusers']);	exit;
		
	}
	
	public function datewiseusers()
	{
		$centerid = $this->session->centerid;
		$data['datewiseusers'] = $this->Dashboard_model->datewiseusers($centerid);
		echo $data['json'] = json_encode($data['datewiseusers']);	exit;
		
	}
	
	public function patientperformance_downloadcsv()
	{
		
		$centerid = $this->session->centerid;
		$data['asap_reports'] = $this->Dashboard_model->asap_reports($centerid);
		$data['clp_reports'] = $this->Dashboard_model->clp_reports($centerid);
		
		$ceationkey = date('YmdHis')."_".$centerid;
		$csvfilename = "uploads/CLP_Userlist_".$centerid.".csv";
		$file = fopen($csvfilename,"w");
		fputcsv($file,array('S.No.','Firstname','Username','Grade','Initial Assessment - Memory','Initial Assessment - Visual Processing','Initial Assessment - Focus and attention','Initial Assessment - Problem Solving','Initial Assessment - Linguistics','Initial Assessment - BSPI','Detailed Assessment - Memory','Detailed Assessment - Visual Processing','Detailed Assessment - Focus and attention','Detailed Assessment - Problem Solving','Detailed Assessment - Linguistics','Detailed Assessment - BSPI','Intermediate  Assessment - Memory','Intermediate  Assessment - Visual Processing','Intermediate Assessment - Focus and attention','Intermediate Assessment - Problem Solving','Intermediate Assessment - Linguistics','Intermediate Assessment - BSPI','Post Assessment - Memory','Post Assessment - Visual Processing','Post Assessment - Focus and attention','Post Assessment - Problem Solving','Post Assessment - Linguistics','Post Assessment - BSPI','Program Status','Created Date'));
		
		foreach($data['asap_reports'] as $key1=>$val1) {
			
			$query1[$data['asap_reports'][$key1]['username']] =  $val1;
	
		}		
		foreach($data['clp_reports'] as $key2=>$val2) {
			
			$query2[$data['clp_reports'][$key2]['username']] =  $val2;

		}
		
		$ini=0; 
	foreach($query2 as $key3=>$val3){
	$ini++;
	
	$ME = explode(',',$val3['skillscorem']);
	$VP = explode(',',$val3['skillscorev']);
	$FA = explode(',',$val3['skillscoref']);
	$PS = explode(',',$val3['skillscorep']);
	$LI = explode(',',$val3['skillscorel']);
	
	
	
	if($query1[$key3]['skillscorem']=="") { $asap_mscore= "-"; } else {   $asap_mscore= round($query1[$key3]['skillscorem'], 2);  }
	if($query1[$key3]['skillscorev']=="") { $asap_vscore= "-"; } else {   $asap_vscore= round($query1[$key3]['skillscorev'], 2);  }
	if($query1[$key3]['skillscoref']=="") { $asap_fscore= "-"; } else {   $asap_fscore= round($query1[$key3]['skillscoref'], 2);  }
	if($query1[$key3]['skillscorep']=="") { $asap_pscore= "-"; } else {   $asap_pscore= round($query1[$key3]['skillscorep'], 2);  }
	if($query1[$key3]['skillscorel']=="") { $asap_lscore= "-"; } else {   $asap_lscore= round($query1[$key3]['skillscorel'], 2);  }
	if($query1[$key3]['avgbspiset1']=="") { $asap_bspi= "-";   } else {     $asap_bspi= round($query1[$key3]['avgbspiset1'], 2);  }
	
	 if($ME[0]=='') {   $clp_mscore = '-'; } else {  $clp_mscore = round($ME[0], 2);  }
	 if($VP[0]=='') {   $clp_vscore= '-'; } else {  $clp_vscore= round($VP[0], 2);  }
	 if($FA[0]=='') {   $clp_fscore= '-'; } else {  $clp_fscore= round($FA[0], 2);  }
	 if($PS[0]=='') {   $clp_pscore= '-'; } else {  $clp_pscore= round($PS[0], 2);  }
	 if($LI[0]=='') {   $clp_lscore= '-'; } else {  $clp_lscore= round($LI[0], 2);  }
	 
	if($val3['me24']!=''){$me24=$val3['me24'];$me24ss=$val3['me24'];}else{$me24=0;$me24ss='-';}
	if($val3['vp24']!=''){$vp24=$val3['vp24'];$vp24ss=$val3['vp24'];}else{$vp24=0;$vp24ss='-';}
	if($val3['fa24']!=''){$fa24=$val3['fa24'];$fa24ss=$val3['fa24'];}else{$fa24=0;$fa24ss='-';}
	if($val3['ps24']!=''){$ps24=$val3['ps24'];$ps24ss=$val3['ps24'];}else{$ps24=0;$ps24ss='-';}
	if($val3['li24']!=''){$li24=$val3['li24'];$li24ss=$val3['li24'];}else{$li24=0;$li24ss='-';}
	
	if((($me24+$vp24+$fa24+$ps24+$li24)/5)=='') {  $ia_bspi='-'; }else{ $ia_bspi=round(($me24+$vp24+$fa24+$ps24+$li24)/5,2);  }
	
	if($val3['me48']!=''){$me48=$val3['me48'];$me48ss=$val3['me48'];}else{$me48=0;$me48ss='-';}
	if($val3['vp48']!=''){$vp48=$val3['vp48'];$vp48ss=$val3['vp48'];}else{$vp48=0;$vp48ss='-';}
	if($val3['fa48']!=''){$fa48=$val3['fa48'];$fa48ss=$val3['fa48'];}else{$fa48=0;$fa48ss='-';}
	if($val3['ps48']!=''){$ps48=$val3['ps48'];$ps48ss=$val3['ps48'];}else{$ps48=0;$ps48ss='-';}
	if($val3['li48']!=''){$li48=$val3['li48'];$li48ss=$val3['li48'];}else{$li48=0;$li48ss='-';}
	
	if((($me48+$vp48+$fa48+$ps48+$li48)/5)=='') {  $pa_bspi='-'; }else{ $pa_bspi=round(($me48+$vp48+$fa48+$ps48+$li48)/5,2);  }
		 
	
	if((($ME[1]+$VP[1]+$FA[1]+$PS[1]+$LI[1])/5)=='') {   $clp_bspi='-'; } else { $clp_bspi=round(($ME[1]+$VP[1]+$FA[1]+$PS[1]+$LI[1])/5,2);  }
	
	if($query1[$key3]['playcount']==0)
	{  
		$status = 'Initial Assessment Yet to Start'; 
	}
	else if($query1[$key3]['playcount']<5)
	{ 
		$status = 'Initial Assessment In progress'; 
	} 
	else if($val3['playcount']==0)
	{
		$status = 'Detailed Assessment Skill Index Yet to start';
	}
	else if($val3['playcount']<=8)
	{ 
		$status = 'Detailed Assessment Skill Index'; 
	}
	else if($val3['playcount']>8)
	{
		$status = $val3['cyclename']; 
	} 
	
	if($val3['playcount']==0)
	{
		$asession='-';
		$csession='-';
	}
	else
	{
		$asession=$val3['AttendedSession'];
		$csession=$val3['CompletedSession']; 
	}
	
	 fputcsv($file,array($ini,$val3['fname'],$val3['username'],str_replace("Grade","", $val3['grade']),$asap_mscore,$asap_vscore,$asap_fscore,$asap_pscore,$asap_lscore,$asap_bspi,$clp_mscore,$clp_vscore,$clp_fscore,$clp_pscore,$clp_lscore,$clp_bspi,$me24ss,$vp24ss,$fa24ss,$ps24ss,$li24ss,$ia_bspi,$me48ss,$vp48ss,$fa48ss,$ps48ss,$li48ss,$pa_bspi,$status,date('d-m-Y',strtotime($val3['creation_date']))));
 }
 
 

    fclose($handle);
	
echo $data['filename'] = $csvfilename; exit; 
		
	}
	
	
	public function logout(){
        // Unset User Data
		if($this->session->centerid=="" || !isset($this->session->centerid)){redirect('index.php');}
		
		$this->Dashboard_model->update_logout_log($this->session->centerid,$this->session->login_session_id);
		
        $this->session->sess_destroy();
        redirect(base_url());
    }
public function couponscanned()
{
	if($this->session->doctorid=="" || !isset($this->session->doctorid)){redirect('index.php');}
     $data['query'] = $this->Dashboard_model->getScannedCoupon($this->session->doctorid);
	 $this->load->view('header', $data);
		$this->load->view('couponscanned', $data);
		$this->load->view('footer'); 
}

	public function changepwd()
		{
			if($this->session->centerid=="" || !isset($this->session->centerid)){redirect('index.php');}
		
			$this->load->view('header');
			$this->load->view('changepassword', $data);
			$this->load->view('footer');
		}
		
		public function resetpwd()
		{
			if($this->session->centerid=="" || !isset($this->session->centerid)){redirect('index.php');}
			
			$centerid = $this->session->centerid;
			$pwd=$this->input->post('pwd');
			//$userid= $this->Dashboard_model->checkdoctormailidexist($username);
			
			$data['updatepwd'] = $this->Dashboard_model->updatepwd($centerid,$pwd);
			//$this->session->set_flashdata('error_message', 'No Sufficient Coupons Available');
			
			$randid=rand(1000000, 9999999);
			$qryinsertLog=$this->Dashboard_model->adminresetpwdlog($randid,$pwd,$centerid);
		
		echo 1; exit;
			// redirect('index.php/home/userperformance');
			
		}
		
		public function registration()
		{
			if($this->session->centerid=="" || !isset($this->session->centerid)){redirect('index.php');}
			
			$data['grades'] = $this->Dashboard_model->getgrades();
			$data['validity'] = $this->Dashboard_model->getvalidity();
			$data['chklicense'] = $this->Dashboard_model->chklicense($this->session->centerid);
			
		
			$this->load->view('header');
			$this->load->view('sc_registration', $data);
			$this->load->view('footer');
		}
		
		public function ajaxdashboard()
		{
			if($this->session->centerid=="" || !isset($this->session->centerid)){redirect('index.php');}
			$productid = $this->input->post('proid');
			$centerid = $this->session->centerid;
			if($productid==1)
			{
			
			$data['asap_reports'] = $this->Dashboard_model->asap_reports($centerid);
			$data['clp_reports'] = $this->Dashboard_model->clp_reports($centerid);
			$data['userscount'] = $this->Dashboard_model->userscount($centerid);
			$data['gradewiseusers'] = $this->Dashboard_model->gradewiseusers($centerid);
			$data['distributedlicence'] = $this->Dashboard_model->distributedlicence($centerid);
			}
			if($productid==2)
			{
				
				$data['userscount_sc'] = $this->Dashboard_model->userscount_sc($centerid);
				
				$data['gradewiseusers_sc'] = $this->Dashboard_model->gradewiseusers_sc($centerid);
				
				$data['userdetails_sc'] = $this->Dashboard_model->userdetails_sc($centerid);
				
				$data['distributedlicence_sc'] = $this->Dashboard_model->distributedlicence_sc($centerid);
				//echo 'hassssssic'; exit;
			}
			//$this->load->view('header');
			if($productid==1)
			{
			$this->load->view('ajax_dashboard_clp', $data);
			}
			if($productid==2)
			{
			$this->load->view('ajax_dashboard_summercamp', $data);
			}
			//$this->load->view('footer');
		}
		
		public function sc_userlist_csv()
		{
			$centerid = $this->session->centerid;
			$data['userdetails_sc'] = $this->Dashboard_model->userdetails_sc($centerid);
			
		$ceationkey = date('YmdHis')."_".$centerid;
		$csvfilename = "uploads/Summercamp_Userlist_".$centerid.".csv";
		$file = fopen($csvfilename,"w");
		fputcsv($file,array('S.No.','Studentname','Username','Grade','Registered Date','Start Date','No. of Days Played','Memory','Visual Processing','Focus & Attention','Problem Solving','Linguistics','BSPI'));
			
		$ini=0; 
	foreach($data['userdetails_sc'] as $res){
	$ini++;
	
	if($res['avgbspiset1']=='') {  $bspi = '-'; } else {  $bspi = $res['avgbspiset1'];  }
	
	if($res['skillscorem']=='') {  $memory = '-'; } else { $memory = $res['skillscorem'];  }
	if($res['skillscorev']=='') {  $vp = '-'; } else { $vp = $res['skillscorev'];  }
	if($res['skillscoref']=='') {  $focus = '-'; } else { $focus = $res['skillscoref'];  }
	if($res['skillscorep']=='') {  $problem = '-'; } else { $problem = $res['skillscorep'];  }
	if($res['skillscorel']=='') {  $ling = '-'; } else { $ling = $res['skillscorel'];  }
	
	
	
	 fputcsv($file,array($ini,$res['fname'],$res['username'],$res['grade'],date('d-m-Y',strtotime($res['creation_date'])),date('d-m-Y',strtotime($res['startdate'])),$res['totaldays'],$memory,$vp,$focus,$problem,$ling,$bspi));
 }
 
    fclose($handle);
	
echo $data['filename'] = $csvfilename; exit; 
			
					}
		
		public function addsummercampuser()
		{
			if($this->session->centerid=="" || !isset($this->session->centerid)){redirect('index.php');}
			
			$centerid = $this->session->centerid;
			$name = $this->input->post('name');
			$grade = $this->input->post('grade');
			$gender = $this->input->post('gender');
			$username = $this->input->post('username').'.'.$this->session->centercode;
			$mobile = $this->input->post('mobile');
			$emailid = $this->input->post('emailid');
			//$startdate = $this->input->post('startdate');
			$startdate =  date("Y-m-d", strtotime($this->input->post('startdate')));
			
			$data['getenddate'] = $this->Dashboard_model->getenddate($startdate);
			$data['getplanid'] = $this->Dashboard_model->getplanid($grade);
			$enddate =  $data['getenddate'][0]["enddate"];
			$planid =  $data['getplanid'][0]["id"];
			//$data['validity'] = $data['getplanid'][0]["validity"];
			$salt1 = 3041850768;
			$salt2 = 685064127;
			$password = '6bba2825556dd0f6b4a9ccc944de90f825c4e0ab';
			
			$data['chklicense'] = $this->Dashboard_model->chklicense($this->session->centerid);
			if($data['chklicense'][0]['givenlicense']<=$data['chklicense'][0]['totalusers']) {
				
				echo 0; exit;
			}
			else {
				
			$data['adduser'] = $this->Dashboard_model->adduser($centerid,$name,$grade,$gender,$username,$mobile,$emailid,$startdate,$enddate,$salt1,$salt2,$password,$planid);
			
			$userlastid = $data['adduser'];
			$data['adduser_mapping'] = $this->Dashboard_model->adduser_mapping($userlastid,$grade,$planid);
			//echo $data['adduser']; exit;
			echo 1; exit;
			
			}
			
		}
		
		
		
		public function usernamecheck()
		{
			if($this->session->centerid=="" || !isset($this->session->centerid)){redirect('index.php');}
			
			$username = $this->input->post('username').'.'.$this->session->centercode;
			
			$data['usernamecheck'] = $this->Dashboard_model->usernamecheck($username);
			
			echo $data['usernamecheck'][0]['usercount']; exit;
			
		}
}
