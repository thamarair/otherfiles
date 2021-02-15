<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

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
		
	public function reportslist()
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

	$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
	$data['bspi'] = $tot;
		$this->load->view('headerinner',$data);
		$this->load->view('reports/reports',$data);
		$this->load->view('footerinner');
		
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
	
	public function reportslist1()
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

	$data['bspi'] = $tot;
	$data['mspi'] = $this->MyCurrentMspi('FN');
	$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
	
	/*Puzzle Performance Brain Skills*/
	$gameid = $this->input->post('game');
	$pid = $this->input->post('planid');
	
	$data['query'] = $this->Assessment_model->getgameplanid($userid);
	$pid =$data['query'][0]['gp_id'];
	//$data['query1'] = $this->Assessment_model->getgamenames($userid,$pid);
	
	
	/*Puzzle Performance Brain Skills*/
	
	
	/*SKILL PERFORMANCE REPORT*/
	//$data['academicyear'] = $this->Assessment_model->getacademicyear(); 
	$startdate = $this->session->astartdate;
	$enddate = $this->session->aenddate;
	$data['academicmonths'] = $this->Assessment_model->getacademicmonths($startdate,$enddate);
	$data['skills'] = $this->Assessment_model->getskills();	
	
	$yearMonthQry=$_REQUEST['yearMonth'];
	$bspicalendarskillScore= $this->Assessment_model->mybspicalendarSkillChart("",$userid,$yearMonthQry);
	$mybspiCalendarSkillScore=array("SID59"=>0,"SID60"=>0,"SID61"=>0,"SID62"=>0,"SID63"=>0);
	 foreach($bspicalendarskillScore as $score)
	{
		$mybspiCalendarSkillScore["SID".$score['gs_id']]=round($score['gamescore'],2);
	}
	 $data['bspicalendarskillScore']=$mybspiCalendarSkillScore;
	 $data['yearMonthQry']=$yearMonthQry;
	 /*SKILL PERFORMANCE REPORT*/
	 
	 
	 /*SKILL PERFORMANCE CLP*/
$data['clp_skillwiseaverage'] = $this->Assessment_model->getSkillWiseAvgScore_opt($userid);
$data['MonthWiseSkillScore'] = $this->Assessment_model->getMonthWiseSkillScore($userid,$startdate,$enddate);
$data['CLP_M'] = ($data['clp_skillwiseaverage'][0]['skillscorem']);

$data['CLP_V'] = ($data['clp_skillwiseaverage'][0]['skillscorev']);

$data['CLP_F'] = ($data['clp_skillwiseaverage'][0]['skillscoref']);

$data['CLP_P'] = ($data['clp_skillwiseaverage'][0]['skillscorep']);

$data['CLP_L'] = ($data['clp_skillwiseaverage'][0]['skillscorel']);
		/*SKILL PERFORMANCE CLP*/
	 
	 
	 
	 /*........... ECertificateList .......*/
			$arrofec=$this->ECertificateList();
			$data['sbbadge']=$arrofec['sbbadge'];
			$data['sabadge']=$arrofec['sabadge'];
			$data['sgbadge']=$arrofec['sgbadge'];
		/*........... ECertificateList .......*/
	 
	 
	 
	 
	 /*INDIVIDUAL SKILL REPORT*/
	 $data['skills'] = $this->Assessment_model->getskills();
	/*INDIVIDUAL SKILL REPORT*/
	
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
	
		$this->load->view('headerinner',$data);
		$this->load->view('reports/reports1',$data);
		$this->load->view('footerinner');
		
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
	
	$Yearmonth=explode("-", $yearMonthQry);
$year=$Yearmonth[0];
$month= $Yearmonth[1];
echo json_encode($data['bspicalendarskillScore']);exit;
	
		 
        //$this->load->view('mybrainprofile/ajaxcalendarSkillChart', $data);
 
		
	}
	
	public function brainskill_report()
	{			
	
	//print_r($_POST); 
	//echo $this->input->post('game'),

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
		$data['query'] = $this->Assessment_model->getgameplanid($userid);
		$pid =$data['query'][0]['gp_id'];
		
		$data['query1'] = $this->Assessment_model->getgamenames($userid,$pid);
		//echo '<pre>';
		//print_r($data['query1']); exit;
		//foreach($data['query1'] as $gamedetails)
		//{ 
		//$gameid = $this->input->post('game');
		//$data['gamedetails'] = $this->Assessment_model->getgamedetails($userid,$gameid,$pid );
		//}
		$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
		
		$this->load->view('headerinner', $data);
		$this->load->view('reports/pp_brainskillreport', $data);
		$this->load->view('footerinner');
		
	}
	
	public function brainskill_report_ajax()
	{
		 $userid = $this->session->user_id;
		 $gameid = $this->input->post('game');
		 $pid = $this->input->post('planid');
		
		
		$data['gamedetails'] = $this->Assessment_model->getgamedetails($userid,$gameid,$pid ); 
		//print_r($data['gamedetails']);
		echo $data['json'] = json_encode($data['gamedetails']);	exit;

	}
	
	
	public function skill_performance_report()
	{			
	
	//print_r($_POST); 
	//echo $this->input->post('game'),

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
	
		$this->load->view('headerinner', $data);
		$this->load->view('reports/skill_performance_report', $data);
		$this->load->view('footerinner');
		
	}
	
	
	public function individual_skill_report()
	{			
	
	//print_r($_POST); 
	//echo $this->input->post('game'),

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
		$data['skills'] = $this->Assessment_model->getskills();
		$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
		
		$this->load->view('headerinner', $data);
		$this->load->view('reports/individual_skill_report', $data);
		$this->load->view('footerinner');
		
	}
	public function individualskill_report_ajax()
	{
		$skillname= $_REQUEST["months"];
		$userid = $this->session->user_id;
		//$data['timelimit'] = $this->Assessment_model->getdates($userid); 
		//print_r($data['timelimit']); 
		$trophystartdate = $this->session->astartdate;
		
		$monthdisparray = array("1"=>"JAN","2"=>"FEB","3"=>"MAR","4"=>"APR","5"=>"MAY","6"=>"JUN","7"=>"JUL","8"=>"AUG","9"=>"SEP","10"=>"OCT","11"=>"NOV","12"=>"DEC");
		
		$startdatesplit = explode("-",$trophystartdate);
		
		$startmonthdisp = $startdatesplit[1];
					
					$displaycatval = array();
					$displaydataval = array();
					$indskillarr = array();
					
		$data['getbspi'] = $this->Assessment_model->getbspireport($userid); 
		
		$res_tot_memory=$res_tot_vp=$res_tot_fa= $res_tot_ps=$res_tot_lang=0;
		$res_tot_memory_i=$res_tot_vp_i=$res_tot_fa_i= $res_tot_ps_i=$res_tot_lang_i=0;
		$month_array=$month_array_chart=array();
		 
		error_reporting(0);
		foreach($data['getbspi'] as $get_res)
		{
			 
			if(!isset($month_array[$get_res['playedMonth']][$get_res['gs_id']]['score'])){$month_array[$get_res['playedMonth']][$get_res['gs_id']]['score']=0;}
			if(!isset($month_array[$get_res['playedMonth']][$get_res['gs_id']]['count'])){$month_array[$get_res['playedMonth']][$get_res['gs_id']]['count']=0;}
			//if(!isset($month_array[$get_res[3]][$get_res[1]]['score'])){$month_array[$get_res[3]][$get_res[1]]['score']=0;}

				$month_array[$get_res['playedMonth']][$get_res['gs_id']]['score']+=$get_res['gamescore'];
			
			$month_array[$get_res['playedMonth']][$get_res['gs_id']]['score']+=$get_res[0];
	$month_array[$get_res['playedMonth']][$get_res['gs_id']]['count']+=1;
	$month_array_chart[$get_res['playedMonth']][$get_res['gs_id']]=$month_array[$get_res['playedMonth']][$get_res['gs_id']]['score']/$month_array[$get_res['playedMonth']][$get_res['gs_id']]['count'];
	
	 
		
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
			
		}
		 
		$tot = (($res_tot_memory/$res_tot_memory_i)+($res_tot_vp/$res_tot_vp_i)+($res_tot_fa/$res_tot_fa_i)+($res_tot_ps/$res_tot_ps_i)+($res_tot_lang/$res_tot_lang_i))/5;
		$skillQuotient_value = round($tot,2);
	
					 
					 for($i=0;$i<=11;$i++){
					 	$passmonth = date("M", mktime(0, 0, 0, $startdatesplit[1]+$i, $startdatesplit[2], $startdatesplit[0]));
						$passmonthnum = date("m", mktime(0, 0, 0, $startdatesplit[1]+$i, $startdatesplit[2], $startdatesplit[0]));
						$passyear = date("Y", mktime(0, 0, 0, $startdatesplit[1]+$i, $startdatesplit[2], $startdatesplit[0]));
						 
						
						$currmonthdayx= cal_days_in_month(0, $passmonthnum, $passyear) ; 
						
						$displaycatval[]= $passmonth."-".$passyear;
						$displaydataval[]= round($month_array[$passmonthnum][$skillname]["score"]/$month_array[$passmonthnum][$skillname]["count"],2);					
						//array_push($indskillarr,$skillkitdata["sc"]);	
					 }
					 
					
				 echo json_encode(array("data"=>$displaycatval,"values"=>$displaydataval)); exit;
				//echo $displaydataval."@@".$displaycatval; exit;
				
			

	}
	public function skillperformance_report_ajax()
	{			
	
			
$date = time(); 
$day = date('d', $date) ; 
$month = date('m', $date) ; 
$year = date('Y', $date);
$mth = date('M', $date) ; 

//$date1 = getdate();
//$dayCurrent= $date1['day']; 


$dateMonthYearArr = array();

$event_array[][] = "";
$uid = $this->session->user_id;
$user_id = $uid; 
$startyear = $this->session->start_year;
$startmonth = $this->session->start_month;

$start_date = date(''.$startyear.'-m-01'); 
$last_date = date(''.$startyear.'-m-t'); 

$maxDays=date('t');

$event_array = $this->range_date_curstudent($start_date, date('d-m-Y'), $uid);

$data['sql'] = $this->Assessment_model->getcalendar($uid,$start_date,$last_date);	

foreach($data['sql'] as $rsData)
{
	$played_date = $rsData['created_date'];	
	$event_array[$played_date][$uid] = "2";
}
	
$first_day = mktime(0,0,0,$startmonth, 1, $startyear) ;

//This gets us the month name
$title = date('F', $first_day) ;

//Here we find out what day of the week the first day of the month falls on 
$day_of_week = date('D', $first_day) ; 


 //Once we know what day of the week it falls on, we know how many blank days occure before it. If the first day of the week is a Sunday then it would be zero

 switch($day_of_week){ 

 case "Sun": $blank = 0; break; 

 case "Mon": $blank = 1; break; 

 case "Tue": $blank = 2; break; 

 case "Wed": $blank = 3; break; 

 case "Thu": $blank = 4; break; 

 case "Fri": $blank = 5; break; 

 case "Sat": $blank = 6; break; 

 }
	
 $days_in_month = cal_days_in_month(0, $startmonth, $year) ; 
	
echo "<TABLE class='myBrainTable'> ";

 echo "<tr><TD class='CalenderHeader' COLSPAN='7' ALIGN=center><h4>BSPI Calender</h4></TD> </tr>";

 echo "<tr><td width=42 style='color:#497096;'><b>SUN</td></b><td width=42 style='color:#497096;'><b>MON</b></td><td 
		style='color:#497096;' width=42><b>TUE</b></td><td width=42 style='color:#497096;'><b>WED</b></td><td width=42 style='color:#497096;'><b>THU</b></td><td 
		width=42 style='color:#497096;'><b>FRI</b></td><td width=42 style='color:#497096;'><b>SAT</b></td></tr>";



//This counts the days in the week, up to 7

 $day_count = 1;



 echo "<tr>";

//first we take care of those blank days

 while ( $blank > 0 ) 
 { 
	 echo "<td></td>"; 
	 $blank = $blank-1; 
	 $day_count++;
 } 
 
  //sets the first day of the month to 1 

 $day_num = 1;

$curr_day = '';



 //count up the days, untill we've done all of them in the month

 while ( $day_num <= $days_in_month ) 
 { 
    $curr_day = '';
	$val_day = '';
	
    /*if($day == $day_num) { $curr_day = "style='background-color:#FFFF00';"; 
	} */
	
	if(strlen($day_num) <= 1)
	{
	  $day_num = "0".$day_num;
	}
	
	$val_day =  $day_num."/".$month."/".$year;
	
	/*echo $val_day;
	echo "-----";
	echo $day_num."/".$month."/".$year;
	echo "<br/>";*/
	
	if(($day_num == $day)&&($month == $_SESSION['start_month']))
	{
	   $curr_day = "style='background:url(images/line.png) no-repeat right; background-size: 16px 16px;'";
	}
	
	$day_num_str=$day_num;

	if(isset($dayArrPlayedScore[$day_num_str]))
	{
		 $day_num_str = '<font>'.$day_num_str.'</font> / <b><font color="green">'.$dayArrPlayedScore[$day_num].'</font></b>';
		 $curr_day = "style='background:url(img/img/smiley2.png) no-repeat right; background-size: 26px 26px;'";
	}
	elseif((int)$dayCurrent >(int)$day_num)
	{
		//dayArrNotPlayed
		$curr_day = "style='background:url(img/img/cross.png) no-repeat right; background-size: 16px 16px;'";
		$day_num_str = '<font>'.$day_num_str.'</font>';
	}
	else
	{
		$day_num_str = '<font>'.$day_num_str.'</font>';
	}
	
	
	echo "<td ".$curr_day."> $day_num_str </td>"; 
	$day_num++; 
	$day_count++;
	
	//Make sure we start a new row every week
	if ($day_count > 7)
	{
		echo "</tr><tr>";
		$day_count = 1;
	}
  } 
  
  echo "</table>";
  
  echo "<table class='BSPIStatus'>
  <tr class='alert alert-success'><TD COLSPAN='7'><strong><i><img src='img/img/smiley2.png'style='width:26px;height:26;'></i></strong> Brain Trained </TD></tr></table>
  <h5 style='color:#1E991E;'><center><strong></strong></center></h5>"; 
	

	
	//print_r($_POST);  
	 $skillsid = str_replace("multiselect-all,",'',$_POST['hdnskillsid']); 
	// $skillsid = ($_POST['skill'][0].','.$_POST['skill'][1].','.$_POST['skill'][2].','.$_POST['skill'][3].','.$_POST['skill'][4]);exit;
	$userid = $this->session->user_id;
	$month = $_POST['months'];
	
	$data['skpreport'] = $this->Assessment_model->getskpreport($userid,$skillsid,$month); 
	//print_r($data['skpreport']); exit;
		echo $data['json'] = json_encode($data['skpreport']);	exit;
	}
	
	public function mybspi_report()
	{	
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
	//print_r($data['academicyear']);
	$startdate = $this->session->astartdate;
	$enddate = $this->session->aenddate;
		$data['academicmonths'] = $this->Assessment_model->getacademicmonths($startdate,$enddate);
		$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
		
		$this->load->view('headerinner', $data);
	$this->load->view('reports/mybspi_report', $data);
	$this->load->view('footerinner');
	}
	
public function comma_separated_to_array($string, $separator = ',')
{
  //Explode on comma
  $vals = explode($separator, $string);
 
  //Trim whitespace
  foreach($vals as $key => $val) {
    $vals[$key] = trim($val);
  }
  
  return array_diff($vals, array(""));
}
	
	public function mybspi_report_ajax()
	{	
	
	$yeramonths = $this->comma_separated_to_array($_POST['hdnMonthID']);
	//print_r($yeramonths); exit;
	
	 $test = "'" . implode("','", $yeramonths) . "'";
	
	$userid = $this->session->user_id;

	
		//echo $mnths; exit;
		
		 
$data['bspireport'] = $this->Assessment_model->getbspireport1($userid,$test); 
		
//print_r($data['bspireport']);  exit;
//print_r($data['bspireport'][0]['gs_id']);

//echo $data['json'] = json_encode($data['bspireport'][0]);	exit;

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
	
	public function myutilization()
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

	$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
	$data['bspi'] = $tot;
		$this->load->view('headerinner',$data);
		$this->load->view('reports/myutilization',$data);
		$this->load->view('footerinner');
			
	}
	
	public function myutilization_ajax()
	{
		 date_default_timezone_set('Asia/Kolkata');
		//print_r($_POST); exit;
		$userid = $this->session->user_id;
		$txtFDate=date("Y-m-d", strtotime(str_replace('/', '-',$_REQUEST['txtFDate'])));	
		$txtTDate=date("Y-m-d", strtotime(str_replace('/', '-',$_REQUEST['txtTDate'])));
		$begin = new DateTime($txtFDate);
		$end = new DateTime($txtTDate);
		$end = $end->modify( '+1 day' ); 

		$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
		
		$data['myutilization'] = $this->Assessment_model->getstudentplay($userid,$txtFDate,$txtTDate); 
		
		//print_r($data['myutilization']); exit;
		$this->load->view('reports/myutilization_ajax', $data); 
	}
	
	public function performance_report()
	{	
	$this->load->view('header');
	//$data['academicyear'] = $this->Assessment_model->getacademicyear(); 
	//print_r($data['academicyear']);
	$startdate = $this->session->astartdate;
	$enddate = $this->session->aenddate;
		$data['userthemefile'] = $this->Assessment_model->get_user_themefile($userid);
		$data['academicmonths'] = $this->Assessment_model->getacademicmonths($startdate,$enddate);
	$this->load->view('reports/performance_report', $data);
	$this->load->view('footer');
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
	
	public function fetchnewsfeed()
	{   
		$pageno=$this->input->post('page');
		$type=$this->input->post('type');
		//echo $pageno."==".$type;exit;
		if($this->session->user_id=="" || !isset($this->session->user_id)){redirect('index.php');}
		
		$data['newsfeed']=$this->Assessment_model->getNewsFeed($this->session->school_id,$this->session->game_grade,$this->session->user_id,$type,$pageno);
		$htmldata='';
		foreach($data['newsfeed'] as $row)
		{ if($row['avatarimage']!=''){$src=base_url()."".$row['avatarimage'];}else{$src=base_url()."assets/images/".'avatar.png';}
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
		echo $htmldata;exit;
		
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
	
	
}


