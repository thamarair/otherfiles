<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Padmin_api extends CI_Controller {
var $info;
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
		$this->load->model('Parent_model');
		$this->load->library('session');	
    }
	
	
	public function checklogin()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		 /* $username = 'C0001.jv';
		$password = 'skillangels'; */
		
		/* $username = '01.slvm';
		$password = 'kinderangels'; */
		
		if(($username!='') && ($password!=''))
		{			 
			$data['query'] = $this->Parent_model->checkUser($username,$password);
			$data['k_query'] = $this->Parent_model->checkUser_kinder($username,$password);
				
		if(isset($data['query'][0]->id))
		{
			$uniqueId = $data['query'][0]->id."".date("YmdHis")."".round(microtime(true) * 10);
						
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
		{
			 $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
		{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		} 
		else 
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
						 
			$this->Parent_model->insert_login_log($data['query'][0]->id,$uniqueId,$ip,$this->input->post('txcountry'),$this->input->post('txregion'),$this->input->post('txcity'),$this->input->post('txisp'),$_SERVER['HTTP_USER_AGENT'],1);
						
			$this->Parent_model->update_parent_sessionid($data['query'][0]->id,$uniqueId);
						
						
			$resparr=array("status"=>"success","code"=>"AD000","id"=>$data['query'][0]->id,"name"=>$data['query'][0]->name,"role"=>'PA',"msg"=>"Login successfull");
			echo json_encode($resparr);exit;
		}
		else if(isset($data['k_query'][0]->id))
		{
			
			$uniqueId = $data['k_query'][0]->id."".date("YmdHis")."".round(microtime(true) * 10);
						
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
		{
			 $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
		{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		} 
		else 
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
						 
			$this->Parent_model->k_insert_login_log($data['k_query'][0]->id,$uniqueId,$ip,$this->input->post('txcountry'),$this->input->post('txregion'),$this->input->post('txcity'),$this->input->post('txisp'),$_SERVER['HTTP_USER_AGENT'],1);
						
			$this->Parent_model->k_update_parent_sessionid($data['k_query'][0]->id,$uniqueId);
						
						
			$resparr=array("status"=>"success","code"=>"AD000","id"=>$data['k_query'][0]->id,"name"=>$data['k_query'][0]->name,"role"=>'KP',"msg"=>"Login successfull");
			echo json_encode($resparr);exit;
		
		}
		
		else 
		{
			$resparr=array("status"=>"Failed","code"=>"AD001","id"=>'-',"name"=>'-',"role"=>'-',"msg"=>"Enter Valid Login Credentials");
			echo json_encode($resparr);
		}
		}
		else
		{
			$resparr=array("status"=>"Failed","code"=>"AD002","id"=>'-',"name"=>'-',"role"=>'-',"msg"=>"Please provide required field values");
			echo json_encode($resparr);
		}
	}
	
	public function dashboard()
	{
		$userid = $this->input->post('userid');
		 //$userid = 39338;
		
		if(($userid!=''))
		{			 
			$arrofuser=$this->Parent_model->UseridIsexist($userid);
		if(isset($arrofuser[0]['id']))
		{
			$data['puzzledata'] = $this->Parent_model->user_puzzledatas($userid);
			$data['scoredata'] = $this->Parent_model->user_scoredata($userid);
				
			$resparr=array("status"=>"success","code"=>"AD000","user_puzzle_data"=>$data['puzzledata'],"user_score_data"=>$data['scoredata'],"role"=>'PA',"msg"=>"success");
			echo json_encode($resparr);exit;
			
		}
		else 
		{
			$resparr=array("status"=>"Failed","code"=>"AD001","user_puzzle_data"=>"-","user_score_data"=>"-","role"=>'-',"msg"=>"Invalid userid");
			echo json_encode($resparr);
		}
		}
		else
		{
			$resparr=array("status"=>"Failed","code"=>"AD002","user_puzzle_data"=>'-',"user_score_data"=>'-',"role"=>'-',"msg"=>"Please provide required field values");
			echo json_encode($resparr);
		}
		
	}
	
	public function overall_avg_skillscore()
	{
		$userid = $this->input->post('userid');
		 //$userid = 39338;
		if(($userid!=''))
		{			 
			$arrofuser=$this->Parent_model->UseridIsexist($userid);
		if(isset($arrofuser[0]['id']))
		{
			$startdate = $this->Parent_model->get_school_startdate($userid);
			$skill_data = $this->Parent_model->user_avg_skillscore($userid,$startdate[0]['start_date']);
				
			//	echo '<pre>'; print_r($skill_data); exit;
			$resparr=array("status"=>"success","code"=>"AD000","skillscore"=>$skill_data,"role"=>'PA',"msg"=>"success");
			echo json_encode($resparr);exit;
		}
		else 
		{
			$resparr=array("status"=>"Failed","code"=>"AD001","skillscore"=>"-","role"=>'-',"msg"=>"Invalid userid");
			echo json_encode($resparr);
		}
		}
		else
		{
			$resparr=array("status"=>"Failed","code"=>"AD002","skillscore"=>'-',"role"=>'-',"msg"=>"Please provide required field values");
			echo json_encode($resparr);
		}
		
	}
	
	public function overall_avg_bspi()
	{
		$userid = $this->input->post('userid');
		//$userid = 39338;
		if(($userid!=''))
		{			 
			$arrofuser=$this->Parent_model->UseridIsexist($userid);
		if(isset($arrofuser[0]['id']))
		{
			$bspi = $this->Parent_model->user_scoredata($userid);				
			//echo '<pre>'; print_r($bspi); exit;
			$resparr=array("status"=>"success","code"=>"AD000","bspi"=>$bspi,"role"=>'PA',"msg"=>"success");
			echo json_encode($resparr);exit;
			
		}
		else 
		{
			$resparr=array("status"=>"Failed","code"=>"AD001","bspi"=>"-","role"=>'-',"msg"=>"Invalid userid");
			echo json_encode($resparr);
		}
		}
		else
		{
			$resparr=array("status"=>"Failed","code"=>"AD002","bspi"=>'-',"role"=>'-',"msg"=>"Please provide required field values");
			echo json_encode($resparr);
		}
		
	}
	
	public function puzzle_played_count()
	{
		$userid = $this->input->post('userid'); 
		 //$userid = 39338;
		if(($userid!=''))
		{			 
			$arrofuser=$this->Parent_model->UseridIsexist($userid);
		if(isset($arrofuser[0]['id']))
		{
			$skillwise_play_count = $this->Parent_model->puzzle_play_count($userid);				
			//echo '<pre>'; print_r($skillwise_play_count); exit;
			$resparr=array("status"=>"success","code"=>"AD000","puzzle_play_count"=>$skillwise_play_count,"role"=>'-',"msg"=>"success");
			echo json_encode($resparr);exit;
				
		}
		else 
		{
			$resparr=array("status"=>"Failed","code"=>"AD001","puzzle_play_count"=>"-","role"=>'-',"msg"=>"Invalid userid");
			echo json_encode($resparr);
		}
		}
		else
		{
			$resparr=array("status"=>"Failed","code"=>"AD002","puzzle_play_count"=>'-',"role"=>'-',"msg"=>"Please provide required field values");
			echo json_encode($resparr);
		}
		
	}
	
	public function monthwise_skillscore()
	{
		$userid = $this->input->post('userid');
		$month = $this->input->post('month');
		$year = $this->input->post('year'); 
		
		/*  $userid = 39338;
		 $month = '04';
		 $year=2019;  */
		 
		if(($userid!='') && ($month!='') && ($year!=''))
		{			 
			$arrofuser=$this->Parent_model->UseridIsexist($userid);
		if(isset($arrofuser[0]['id']))
		{
			$monthwise_skillscore = $this->Parent_model->monthwise_skillscore($userid,$month,$year);				
			//echo '<pre>'; print_r($monthwise_skillscore); exit;
			$resparr=array("status"=>"success","code"=>"AD000","monthly_skillscore"=>$monthwise_skillscore,"role"=>'PA',"msg"=>"success");
			echo json_encode($resparr);exit;
			
		}
		else 
		{
			$resparr=array("status"=>"Failed","code"=>"AD001","monthly_skillscore"=>"-","role"=>'-',"msg"=>"Invalid userid");
			echo json_encode($resparr);
		}
		}
		else
		{
			$resparr=array("status"=>"Failed","code"=>"AD002","monthly_skillscore"=>'-',"role"=>'-',"msg"=>"Please provide required field values");
			echo json_encode($resparr);
		}
		
	}
	
	public function monthwise_bspi()
	{
		/* $userid = $this->input->post('userid');
		$year = $this->input->post('year'); */
		
		$userid = $this->input->post('username');
		$year = $this->input->post('academic_id');
		
		//$userid = 39338;
		//$year=2018;
		 
		if(($userid!=''))
		{			 
			$arrofuser=$this->Parent_model->UsernameIsexist($userid);
		if(isset($arrofuser[0]['id']))
		{
			$startdate = $this->Parent_model->get_school_startdate($userid);
			$academicMonths= $this->Parent_model->academymonths($arrofuser[0]['creation_date']);
			$monthwise_bspi = $this->Parent_model->monthwise_bspi($userid,$arrofuser[0]['creation_date']);	
				
		foreach($monthwise_bspi as $get_res)
		{
			$monthbspiscore[$get_res['monthNumber']]=$get_res['bspi'];
		}
		$categories=array();$data=array();$asap=array();
		foreach($academicMonths as $am)
		{
			$categories[]=$am['monthName'].'-'.$am['yearNumber'];
		if(isset($monthbspiscore[$am['monthNumber']]) && $year=='20')
		{
			$data[]=round($monthbspiscore[$am['monthNumber']],2);
				
		}
		else
		{
			$data[]=0;
		//	$categories[]=0;
				
		}
		}
		$res=array(
			'Months'=>$categories,'Score'=>$data);
			//	echo '<pre>'; print_r($res); exit;
			$resparr=array("status"=>"success","code"=>"AD000","monthly_bspiscore"=>$res,"role"=>'PA',"msg"=>"success");
			echo json_encode($resparr);exit;
			
		}
		else 
		{
			$resparr=array("status"=>"Failed","code"=>"AD001","monthly_bspiscore"=>"-","role"=>'-',"msg"=>"Invalid userid");
			echo json_encode($resparr);
		}
		}
		else
		{
			$resparr=array("status"=>"Failed","code"=>"AD002","monthly_bspiscore"=>'-',"role"=>'-',"msg"=>"Please provide required field values");
			echo json_encode($resparr);
		}
		
	}
	
	public function userprofile()
	{
		
		$userid = $this->input->post('userid');
		// $userid = 39338;
		 
		if(($userid!=''))
		{			 
			$arrofuser=$this->Parent_model->UseridIsexist($userid);
		if(isset($arrofuser[0]['id']))
		{
			$profile = $this->Parent_model->get_profile($userid);				
				//echo '<pre>'; print_r($monthwise_skillscore); exit;
			$resparr=array("status"=>"success","code"=>"AD000","user_profile"=>$profile,"role"=>'PA',"msg"=>"success");
			echo json_encode($resparr);exit;
			
		}
		else 
		{
			$resparr=array("status"=>"Failed","code"=>"AD001","user_profile"=>"-","role"=>'-',"msg"=>"Invalid userid");
			echo json_encode($resparr);
		}
		}
		else
		{
			$resparr=array("status"=>"Failed","code"=>"AD002","user_profile"=>'-',"role"=>'-',"msg"=>"Please provide required field values");
			echo json_encode($resparr);
		}
		
	
	}
	
	public function edit_profile()
	{
		
		$userid = $this->input->post('userid');
		$email = $this->input->post('email');
		$mobile = $this->input->post('mobile');
		 /* $userid = 39338;
		 $email = 'hari150891@gmail.com';
		 $mobile = 9884584861; */
		 
		if(($userid!='') && ($email!='') || ($mobile!=''))
		{			 
			$arrofuser=$this->Parent_model->UseridIsexist($userid);
		if(isset($arrofuser[0]['id']))
		{
			$edit_profile = $this->Parent_model->edit_profile($userid,$email,$mobile);				
			//echo '<pre>'; print_r($monthwise_skillscore); exit;
			$resparr=array("status"=>"success","code"=>"AD000","role"=>'PA',"msg"=>"Profile Update Successfully");
			echo json_encode($resparr);exit;
			
		}
		else 
		{
			$resparr=array("status"=>"Failed","code"=>"AD001","role"=>'-',"msg"=>"Invalid userid");
			echo json_encode($resparr);
		}
		}
		else
		{
			$resparr=array("status"=>"Failed","code"=>"AD002","role"=>'-',"msg"=>"Please provide required field values");
			echo json_encode($resparr);
		}
		
	}
	
	public function getyear_months()
	{
		
		//$userid = $this->input->post('userid');
		$year = $this->Parent_model->academic_year();
		$months = $this->Parent_model->get_months($year[0]['startdate'],$year[0]['enddate']);
		
		$res=array('Academic_year'=>$year,'Academic_months'=>$months);
		//echo '<pre>'; print_r($res); exit;
		$resparr=array("status"=>"success","code"=>"AD000","year_months"=>$res,"role"=>'PA',"msg"=>"success");
		echo json_encode($resparr);exit;
	}
	
	public function logout()
	{
		
		//$userid = 39338;
		$userid = $this->input->post('userid');
		
		if(($userid!=''))
		{			
			$arrofuser=$this->Parent_model->UseridIsexist($userid);	
		if(isset($arrofuser[0]['id']))
		{
			$data['get_session_id'] = $this->Parent_model->get_session_id($userid);
			//echo $data['get_session_id'][0]['session_id']; exit;
			$data['update_log'] = $this->Parent_model->update_logout($userid,$data['get_session_id'][0]['parent_session_id']);
				
			$resparr=array("status"=>"success","code"=>"AD000","role"=>'PA',"msg"=>"Loggedout successfully");
			echo json_encode($resparr);exit;
		}
		else 
		{
			$resparr=array("status"=>"Failed","code"=>"AD001","role"=>'-',"msg"=>"Invalid User ID");
			echo json_encode($resparr);
		}
		}
		else
		{
			$resparr=array("status"=>"Failed","code"=>"AD002","role"=>'-',"msg"=>"Please provide required field values");
			echo json_encode($resparr);
		}
	}
	
	public function usermonth_number()
	{
		
		//$userid = 39338;
		$userid = $this->input->post('userid');
		
		if(($userid!=''))
		{			
			$arrofuser=$this->Parent_model->UseridIsexist($userid);	
		if(isset($arrofuser[0]['id']))
		{
			$date1 = $arrofuser[0]['creation_date'];
			$date2 = date("Y-m-d");

			$ts1 = strtotime($date1);
			$ts2 = strtotime($date2);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$diff = (($year2 - $year1) * 12) + ($month2 - $month1);

			$totalmonth =  $diff+1;
			
			$resparr=array("status"=>"success","code"=>"AD000","month_count"=>$totalmonth,"role"=>'PA',"msg"=>"Success");
			echo json_encode($resparr);exit;
		}
		else 
		{
			$resparr=array("status"=>"Failed","month_count"=>'-',"code"=>"AD001","role"=>'-',"msg"=>"Invalid User ID");
			echo json_encode($resparr);
		}
		}
		else
		{
			$resparr=array("status"=>"Failed","month_count"=>'-',"code"=>"AD002","role"=>'-',"msg"=>"Please provide required field values");
			echo json_encode($resparr);
		}
	}
	
	
	
	
}