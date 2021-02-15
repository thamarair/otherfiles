<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends CI_Controller {

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
				$this->load->model('Superadmin_model');
				$this->load->library('session');
				//$config=array('orientation'=>'P','size'=>'A4');
				//$this->load->library('mypdf',$config);
    }
 
	public function index()
	{			
		$this->load->view('superadmin/login');
		
	}
	public function login()
	{			
		
		$this->load->view('superadmin/login');
		
	}
	public function logincheck()
	{	
	
	if($_POST['username']=='admin@skillangels.com' && $_POST['password']=='super@dmin')
	{
		$this->session->set_userdata(array(
				'username'      => $_POST['username'],
				'role'			=>'1'
				));
				//echo $this->session->username; exit;
		redirect('index.php/superadmin/dashboard');
	}
/*	else if($_POST['username']=='skillangels' && $_POST['password']=='skillangels')
	{
		$this->session->set_userdata(array(
				'username'      => $_POST['username'],
				'role'			=>'1'
				));
		
		redirect('index.php/superadmin/schedule');
	} */
	else{
		
		$data['error'] = "Invalid credentials";
		$this->load->view('superadmin/login', $data);		
	}
	}
	
	public function logout()
	{
		if($this->session->username=="" || !isset($this->session->username)){redirect('index.php/superadmin/');}
		$user_data = $this->session->all_userdata();
        foreach ($user_data as $key => $value) {
            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
                $this->session->unset_userdata($key);
            }
        }
		$this->session->sess_destroy();
		redirect('index.php/superadmin/');
	}
	 public function gameanalysis()
	{
		$data['LowestPlaygames'] = $this->Superadmin_model->LowestPlaygames();
		$data['HighestPlaygames'] = $this->Superadmin_model->HighestPlaygames();
		$data['LowestScoreGames'] = $this->Superadmin_model->LowestScoreGames();
		$data['HighestScoreGames'] = $this->Superadmin_model->HighestScoreGames();
		
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/gameanalysis',$data);
		$this->load->view('superadmin/footer');
	} 
	
	public function gameanalysisv1()
	{
		
		$academicyear=$this->Superadmin_model->getacademicdates();
		$data['academicmonths'] = $this->Superadmin_model->getacademicmonths($academicyear[0]['startdate'],$academicyear[0]['enddate']);
		if($_POST['reporttype']==1)
		{
			if($_POST['hdnMonthID']=='')
			{
				$months = '06,07,08,09,10,11,12,01,02,03,04,05';
			}
			else{
			$months=str_replace("multiselect-all,",'',$_POST['hdnMonthID']);
			}
			//$months =  $_POST['hdnMonthID']; 
			$data['LowestPlaygames'] = $this->Superadmin_model->LowestPlaygames_M($months);
		}
		
		else if($_POST['reporttype']==2)
		{
			if($_POST['hdnMonthID']=='')
			{
				$months = '06,07,08,09,10,11,12,01,02,03,04,05';
			}
			else{
			$months=str_replace("multiselect-all,",'',$_POST['hdnMonthID']);
			}
		$data['HighestPlaygames'] = $this->Superadmin_model->HighestPlaygames_M($months);
		}
		else if($_POST['reporttype']==3)
		{
			if($_POST['hdnMonthID']=='')
			{
				$months = '06,07,08,09,10,11,12,01,02,03,04,05';
			}
			else{
			$months=str_replace("multiselect-all,",'',$_POST['hdnMonthID']);
			}
		$data['LowestScoreGames'] = $this->Superadmin_model->LowestScoreGames_M($months);
		}
		else if($_POST['reporttype']==4)
		{
			if($_POST['hdnMonthID']=='')
			{
				$months = '06,07,08,09,10,11,12,01,02,03,04,05';
			}
			else{
			$months=str_replace("multiselect-all,",'',$_POST['hdnMonthID']);
			}
		$data['HighestScoreGames'] = $this->Superadmin_model->HighestScoreGames_M($months);
		}
		
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/gameanalysisv1',$data);
		$this->load->view('superadmin/footer');
	}
	public function dashboard()
	{
		if($this->session->username=="" || !isset($this->session->username)){redirect('index.php/superadmin/');}

	$data['schoolCounts'] = $this->Superadmin_model->SchoolStudentCount();
	$data['GradeStudentCount'] = $this->Superadmin_model->GradeStudentCount();
	/* $data['LowestPlaygames'] = $this->Superadmin_model->LowestPlaygames();
	$data['HighestPlaygames'] = $this->Superadmin_model->HighestPlaygames();
	$data['LowestScoreGames'] = $this->Superadmin_model->LowestScoreGames();
	$data['HighestScoreGames'] = $this->Superadmin_model->HighestScoreGames();
	$data['CurrentDaySchedule'] = $this->Superadmin_model->CurrentDaySchedule(); */
	 foreach($data['schoolCounts'] as $row)
	{
		//$TotalUserCount=$this->Superadmin_model->GetTotalUserCount($row['start_date']);
		$AttendedUserCount=$this->Superadmin_model->GetAttendedUserCount($row['id']);
		$CompletedUserCount=$this->Superadmin_model->GetCompletedUserCount($row['id']);	
		//echo "<pre>";print_r($CompletedUserCount);exit;
		$result[$row['id'].'-R']=$AttendedUserCount[0]['totaluser'];
		$result[$row['id'].'-A']=$AttendedUserCount[0]['attenusers'];
		$result[$row['id'].'-C']=$CompletedUserCount[0]['completeduser'];
	}	//echo "<pre>";print_r($result);exit;
		$data['result']=$result;
		
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/dashboard',$data);
		$this->load->view('superadmin/footer');
	}
	
	public function bspi_analysis()
	{
		if($this->session->username=="" || !isset($this->session->username)){redirect('index.php/superadmin/');}
		
		$data['bspi_report1'] = $this->Superadmin_model->bspi_report_lessthan_forty();
		$data['totalusers1'] = count($data['bspi_report1']);
		$data['bspi_report2'] = $this->Superadmin_model->bspi_report_forty_to_sixty();
		$data['totalusers2'] = count($data['bspi_report2']);
		$data['bspi_report3'] = $this->Superadmin_model->bspi_report_sixty_to_eighty();
		$data['totalusers3'] = count($data['bspi_report3']);
		$data['bspi_report4'] = $this->Superadmin_model->bspi_report_more_than_eighty();
		$data['totalusers4'] = count($data['bspi_report4']);
		
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/bspi_analysis',$data);
		$this->load->view('superadmin/footer');
		
	}
	
	public function skillscore_analysis()
	{
		if($this->session->username=="" || !isset($this->session->username)){redirect('index.php/superadmin/');}
		
		$data['getskills'] = $this->Superadmin_model->getskills();
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/skill_score_analysis', $data);
		$this->load->view('superadmin/footer');
		
		
	}
	
	public function skillscore_analysis_ajax()
	{
		$skillid = $_POST['skillid'];
		//echo $skillid ; exit;
		$data['skillscore_report1'] = $this->Superadmin_model->skillscore_lessthan_forty($skillid);
		$data['totalusers1'] = count($data['skillscore_report1']);
		$data['skillscore_report2'] = $this->Superadmin_model->skillscore_forty_to_sixty($skillid);
		$data['totalusers2'] = count($data['skillscore_report2']);
		$data['skillscore_report3'] = $this->Superadmin_model->skillscore_sixty_to_eighty($skillid);
		$data['totalusers3'] = count($data['skillscore_report3']);
		$data['skillscore_report4'] = $this->Superadmin_model->skillscore_more_than_eighty($skillid);
		$data['totalusers4'] = count($data['skillscore_report4']); 
		
		$this->load->view('superadmin/skill_score_analysis_ajax', $data);
	} 
	
	public function today()
	{	
	
	if($this->session->username=="" || !isset($this->session->username)){redirect('index.php/superadmin/');}
		
		$data['schools'] = $this->Superadmin_model->schoolsession();
		$data['completeusers'] = $this->Superadmin_model->training_completedusers();
		
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/today',$data);
		$this->load->view('superadmin/footer');
	
	}
	
	public function schedule()
	{
		$data['timetable'] = $this->Superadmin_model->timetable();
		$data['schoolcodes'] = $this->Superadmin_model->schoolcodes();
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/schools_schedule', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function schools_schedule()
	{
		$schoolid = $_POST['schoolid'];
		$gradeid = $_POST['gradeid'];
		$section = $_POST['section'];
		
		$data['schools_schedule_r'] = $this->Superadmin_model->schools_schedule_regusers($schoolid,$gradeid,$section);
		$data['schools_schedule_t'] = $this->Superadmin_model->schools_schedule_takenusers($schoolid,$gradeid,$section);
		$data['schools_schedule_c'] = $this->Superadmin_model->schools_schedule_completeusers($schoolid,$gradeid,$section);
		
		$this->load->view('superadmin/dashboard_ajax', $data);
		//echo json_encode(array("registerusers"=>$regusers,"trainingtaken"=>$takenusers,"trainingcompleted"=>$completeusers)); exit;	
	}
	
	public function dashboard_counts()
	{			
	
	 $data['schoolscount'] = $this->Superadmin_model->schools();
	 $data['schoolscount'][0]['schoolscount']; 
	
	
	$data['studentscount'] = $this->Superadmin_model->students();
	$data['studentscount'][0]['studentscount'];

	  
	
	$schools[] = $data['schoolscount'][0]['schoolscount']; 
	$students[] = $data['studentscount'][0]['studentscount'];
	 
	
	echo json_encode(array("schools"=>$schools,"students"=>$students)); exit;

	}
	
	public function schoolwisebspi()
	{
		$data['overallbspi']=$_REQUEST['trainingoverallbspi'][0];
		$data['bspi'] = $this->Superadmin_model->schoolwisebspi();
		//print_r($data['bspi']); exit;
		$this->load->view('superadmin/schoolwise_bspiajax', $data);
	}
	
	public function skillwisetopper()
	{
		$skillid = $_POST['val'];
		$data['skilltopper'] = $this->Superadmin_model->skillwisetopper_memory($skillid);
		//print_r($data['memory']);
		//echo $data['memory'][0]['finalscore'];
		
		$this->load->view('superadmin/skilltopper_ajax', $data);
	}
	
	public function bspi_report()
	{	
		$data['schools'] = $this->Superadmin_model->getschools();
		$data['grades'] = $this->Superadmin_model->getgrades();
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/bspi_report', $data);
		$this->load->view('superadmin/footer');
	
	}
	public function eom()
	{	
		if($this->session->username=="" || !isset($this->session->username)){redirect('index.php/superadmin/');}
		
		$data['schools'] = $this->Superadmin_model->getschools();
		$data['grades'] = $this->Superadmin_model->getgrades();
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/eom_report', $data);
		$this->load->view('superadmin/footer');
	}	
	
	public function eom_summary()
	{	
		if($this->session->username=="" || !isset($this->session->username)){redirect('index.php/superadmin/');}
		
		$data['schools'] = $this->Superadmin_model->getschools();
		$data['grades'] = $this->Superadmin_model->getgrades();
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/eom_report_summary', $data);
		$this->load->view('superadmin/footer');
	}	
	public function getacademicmonth()
	{
		$sid = $_POST['sid'];
		$academicyear=$this->Superadmin_model->getacademicyearbyschoolid($sid);
		$data['academicmonths'] = $this->Superadmin_model->getacademicmonths($academicyear[0]['startdate'],$academicyear[0]['enddate']);
		$this->load->view('superadmin/academicmonth', $data);
	}
	public function tracking()
	{	
	
		if($this->session->username=="" || !isset($this->session->username)){redirect('index.php/superadmin/');}
		
		$data['schools'] = $this->Superadmin_model->getschools();
		$data['grades'] = $this->Superadmin_model->getgrades();
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/tracking_report', $data);
		$this->load->view('superadmin/footer');
	
	}
	
	public function tracking_report1()
	{	
	
	 $schoolid = $_POST['schoolid'];
	 $startdate = $_POST['startdate']; 
	 $enddate = $_POST['enddate']; 
	 $grade = $_POST['grade']; 
	 $section = $_POST['section']; 
	
		
		$data['tracking_report1'] = $this->Superadmin_model->tracking_report1($startdate,$enddate,$schoolid,$grade,$section);
			
		$data['tracking_report1_cusers'] = $this->Superadmin_model->tracking_report1_cusers($startdate,$enddate,$schoolid,$grade,$section);
		
		 
		
		$this->load->view('superadmin/tracking_report1_ajax', $data);
	}
	public function eom_utilizationreport()
	{
		$schoolid = $_POST['schoolid'];
		$month = explode("/",$_POST['month']);
		$exestartdate=explode("-",$month[0]);$exeenddate=explode("-",$month[1]);
		
		$startdate=$exestartdate[2];$enddate=$exeenddate[2];//echo "<pre>";print_r($exeenddate);exit;
		$qrypart1='';$qrypart2=''; $j=1;
		
		$data['eom_part1'] = $this->Superadmin_model->eom_utilizationreport($schoolid,$month[0],$month[1]);
		$data['eom_part2'] = $this->Superadmin_model->eom_utilizationreportbygrade($schoolid,$month[0],$month[1]);	
		
		$data['eom_part_cuser1'] = $this->Superadmin_model->eom_utilizationreport_cusers($schoolid,$month[0],$month[1]);
		$data['eom_part_cuser2'] = $this->Superadmin_model->eom_utilizationreportbygrade_cusers($schoolid,$month[0],$month[1]);	
		$data['weekofday']=$this->Superadmin_model->weekofday($schoolid,$month[0],$month[1]);
$data['eom_part_attenduser1'] = $this->Superadmin_model->eom_ureport_ausers($schoolid,$month[0],$month[1]);
$data['eom_part_attenduser2'] = $this->Superadmin_model->eom_ureportbygrade_ausers($schoolid,$month[0],$month[1]);
//echo "<pre>";print_r($data['eom_part_attenduser2']);exit;
		//$data['eom_part2'] = $this->Superadmin_model->eom_utilizationreport_cusers($schoolid,$month[0],$month[1]);
		$data['regattenduser']=$this->Superadmin_model->regattenduser($schoolid,$month[0],$month[1]);
		$data['completeduser']=$this->Superadmin_model->completeduser($schoolid,$month[0],$month[1]);
		/* $data['eom_part_timetaken'] = $this->Superadmin_model->eom_ureport_timetaken($schoolid,$month[0],$month[1]); */
		
		$this->load->view('superadmin/eom_utilizationreport_ajax', $data);
		//echo "<pre>";print_r($data['eom_part1']);
		//echo "<pre>";print_r($data['eom_part2']);exit;
	}

public function eom_utilizationreport_nonschedule()
	{
		$schoolid = $_POST['schoolid'];
		$month = explode("/",$_POST['month']);
		$exestartdate=explode("-",$month[0]);$exeenddate=explode("-",$month[1]);
		
		$startdate=$exestartdate[2];$enddate=$exeenddate[2];//echo "<pre>";print_r($exeenddate);exit;
		$qrypart1='';$qrypart2=''; $j=1;
		
		$data['eom_part2'] = $this->Superadmin_model->eom_utilizationreportbygrade_nonschedule($schoolid,$month[0],$month[1]);	
		
	
		$data['eom_part_cuser2'] = $this->Superadmin_model->eom_utilizationreportbygrade_cusers_nonschedule($schoolid,$month[0],$month[1]);	
		$data['weekofday']=$this->Superadmin_model->weekofday_nonschedule($schoolid,$month[0],$month[1]);

$data['eom_part_attenduser2'] = $this->Superadmin_model->eom_ureportbygrade_ausers_nonschedule($schoolid,$month[0],$month[1]);

		$data['regattenduser']=$this->Superadmin_model->regattenduser_nonschedule($schoolid,$month[0],$month[1]);
		$data['completeduser']=$this->Superadmin_model->completeduser_nonschedule($schoolid,$month[0],$month[1]);
		
		$this->load->view('superadmin/eom_utilizationreport_nonschedule_ajax', $data);
		
	}
	
	public function ajaxgetsection()
	{
		//echo 'hai'; exit;
	 	$gradeid = $_POST['ddlgrade']; 
		$schoolid = $_POST['schoolid'];
		$data['section'] = $this->Superadmin_model->getsectionajax($schoolid,$gradeid);
		$this->load->view('superadmin/section_grade_ajax', $data);
		
	}
	public function tracking_report2()
	{	
		$schoolid = $_POST['schoolid'];
		$startdate = $_POST['startdate']; 
		$enddate = $_POST['enddate']; 
		$data['tracking_report2'] = $this->Superadmin_model->tracking_report2($schoolid,$startdate,$enddate);	
		$this->load->view('superadmin/tracking_report2_ajax', $data);
	}
	
	public function tracking_report3()
	{		
		 $schoolid = $_POST['schoolid'];
		 $startdate = $_POST['startdate']; 
		 $enddate = $_POST['enddate']; 
		 $grade = $_POST['grade']; 
		 $section = $_POST['section']; 
		 $data['section']=$section;
		 $data['gamereport'] = $this->Superadmin_model->tracking_gamereport($startdate,$enddate,$schoolid,$grade,$section);
		$this->load->view('superadmin/tracking_report3_ajax',$data);
	}
	
	public function getschoolgrade()
	{
		
		$schoolid = $_POST['sid'];
		$data['schoolgrades'] = $this->Superadmin_model->schoolgrades($schoolid);
		$this->load->view('superadmin/school_grade_ajax', $data);
	}
	
	public function bspi_reports()
	{
		//echo 'hello'; exit;
	$schoolid = $_POST['schoolid'];
	$gradeid = $_POST['gradeid'];
	$sectionid = $_POST['sectionid'];
		
		$data['getplan'] = $this->Superadmin_model->getplanid($schoolid,$gradeid);
		$planid = $data['getplan'][0]['plan_id'];
		
		$data['usersbspireport'] = $this->Superadmin_model->usersbspireport($schoolid,$gradeid,$sectionid);
		$data['report1'] = $this->Superadmin_model->bspi_reports($schoolid,$gradeid,$sectionid);
		
		$this->load->view('superadmin/bspi_ajax', $data);
	}
	
	public function bspi_report_excel()
	{
		
	$schoolid = $_POST['schoolid'];
	$gradeid = $_POST['gradeid'];
	$sectionid = $_POST['sectionid'];
	//$skillid = $_POST['skillid'];
		$data['getplan'] = $this->Superadmin_model->getplanid($schoolid,$gradeid);
		$planid = $data['getplan'][0]['plan_id'];
		//$data['gradesetid'] = $this->Superadmin_model->getgradeidsets($planid,$gradeid);
		$data['report1'] = $this->Superadmin_model->bspi_reports($schoolid,$gradeid,$sectionid);
		
			
$this->load->library('excel');
//activate worksheet number 1
$this->excel->setActiveSheetIndex(0);
//name the worksheet
$this->excel->getActiveSheet()->setTitle('BSPI Report');
$objPHPExcel=$this->excel;
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(65);


$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');

$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);


$objPHPExcel->getActiveSheet()->SetCellValue('A2',"BSPI Report - ".$data['report1'][0]['schoolname']."");
$objPHPExcel->getActiveSheet()->SetCellValue('A3',$data['report1'][0]['gradename']);

$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '00b0f0')
        ),'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    )
);
$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'ffedb0')
        ),'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    )
);
$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'ffedb0')
        ),'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    )
);


	$objPHPExcel->getActiveSheet()->SetCellValue('A4','S.No.');
	$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Username');
	$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Section');
	$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'BSPI');
	
	 
	
	
$ini=4;
			

			foreach($data['report1'] as $result){ $ini++;
			
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$ini, $ini-4);
	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$ini, $result['fname']);
	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$ini, $result['section']);
	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$ini, round($result['avgbspiset1'], 2));
	
			}

$objPHPExcel->getActiveSheet()->getStyle("A1:D".$ini)->applyFromArray(
    array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            )
        )
    )
);

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$logo =APPPATH."../assets/superadmin/images/excellogo.png"; // Provide path to your logo file
$objDrawing->setPath($logo);
$objDrawing->setOffsetX(8);    // setOffsetX works properly
$objDrawing->setOffsetY(300);  //setOffsetY has no effect
$objDrawing->setCoordinates('A1');
$objDrawing->setHeight(75); // logo height
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); 
echo $filename='Reports/BSPI_Report'.date('Ymdhmis').'.xls'; //save our workbook as this file name

            
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
//force user to download the Excel file without writing it to server's HD
$objWriter->save($filename);
		
		
	}
	
	public function skillscore_report()
	{	
		$data['schools'] = $this->Superadmin_model->getschools();
		$data['grades'] = $this->Superadmin_model->getgrades();
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/skillscore_report', $data);
		$this->load->view('superadmin/footer');
	
	}
	
	public function skillscore_reports()
	{
	$schoolid = $_POST['schoolid'];
	$gradeid = $_POST['gradeid'];
	$skillid = $_POST['skillid']; 
	$sectionid = $_POST['sectionid'];
	$data['getplan'] = $this->Superadmin_model->getplanid($schoolid,$gradeid);
	$planid = $data['getplan'][0]['plan_id'];
	$data['overallsklscore'] = $this->Superadmin_model->skillscore_skl_grade_sect_wise($schoolid,$gradeid,$skillid,$sectionid);
		$data['report2'] = $this->Superadmin_model->skillscore_reports($schoolid,$gradeid,$skillid,$sectionid);
		$this->load->view('superadmin/skillscore_report_ajax', $data);
	}
	
	
	public function skillscore_report_excel()
	{
	$schoolid = $_POST['schoolid'];
	$gradeid = $_POST['gradeid'];
	$skillid = $_POST['skillid']; 
	$sectionid = $_POST['sectionid'];
	$data['getplan'] = $this->Superadmin_model->getplanid($schoolid,$gradeid);
	$planid = $data['getplan'][0]['plan_id'];
	
		$data['report2'] = $this->Superadmin_model->skillscore_reports($schoolid,$gradeid,$skillid,$sectionid);
		
		
	$this->load->library('excel');
//activate worksheet number 1
$this->excel->setActiveSheetIndex(0);
//name the worksheet
$this->excel->getActiveSheet()->setTitle('Skill Score Report');
$objPHPExcel=$this->excel;
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(65);


$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
$objPHPExcel->getActiveSheet()->mergeCells('A3:E3');


$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(26);



$objPHPExcel->getActiveSheet()->SetCellValue('A2',"Skill Score Report - ".$data['report2'][0]['schoolname']."");
$objPHPExcel->getActiveSheet()->SetCellValue('A3',$data['report2'][0]['gradename'].' - '.$data['report2'][0]['skill']);

$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '00b0f0')
        ),'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    )
);
$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'ffedb0')
        ),'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    )
);
$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'ffedb0')
        ),'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    )
);


	$objPHPExcel->getActiveSheet()->SetCellValue('A4','S.No');
	$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Username');
	$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Section');
	$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Skillscore');
	$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Avg.Response Time');
	
	 
	
	
$ini=4;
			

			foreach($data['report2'] as $result){ $ini++;
			
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$ini, $ini-4);
	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$ini, $result['fname']);
	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$ini, $result['section']);
	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$ini, round($result['score'], 2));
	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$ini, round($result['rstime'], 2));
	
			}

$objPHPExcel->getActiveSheet()->getStyle("A1:E".$ini)->applyFromArray(
    array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            )
        )
    )
);

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$logo =APPPATH."../assets/superadmin/images/excellogo.png"; // Provide path to your logo file
$objDrawing->setPath($logo);
$objDrawing->setOffsetX(8);    // setOffsetX works properly
$objDrawing->setOffsetY(300);  //setOffsetY has no effect
$objDrawing->setCoordinates('A1');
$objDrawing->setHeight(75); // logo height
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); 
echo $filename='Reports/Skillscore_Report'.date('Ymdhmis').'.xls'; //save our workbook as this file name

            
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
//force user to download the Excel file without writing it to server's HD
$objWriter->save($filename);		
	}
	
	public function performance_report()
	{	
		$data['schools'] = $this->Superadmin_model->getschools();
		$data['grades'] = $this->Superadmin_model->getgrades();
		$data['academic'] = $this->Superadmin_model->academicyears();
		$this->load->view('superadmin/admin_header');
			
			if(isset($_POST['schoolid']) || isset($_POST['gradeid']) || isset($_POST['sectionid']) ||  isset($_POST['rangefrom']) || isset($_POST['rangeto']) )
			{
		$schoolid = $_POST['schoolid'];
		$gradeid = $_POST['gradeid'];
		$sectionid = $_POST['sectionid'];
		$rangefrom = $_POST['rangefrom'];
		$rangeto = $_POST['rangeto'];
		
		$data['GradewiseScore_data1'] = $this->Superadmin_model->getClassPerformace_data($schoolid,$gradeid,$sectionid,'game_reports',$rangefrom,$rangeto);
		
		$data['getplan'] = $this->Superadmin_model->getplanid($schoolid,$gradeid);
		$planid = $data['getplan'][0]['plan_id'];
		
		$data['data'] = $sectionid;
		$data['bspirange'] = $bspirange;
		//print_r($data['GradewiseScore_data1']);
			}

		$this->load->view('superadmin/performance_report', $data);
		$this->load->view('superadmin/footer');
	
	}
	
	public function getsection()
	{
		$schoolid = $_REQUEST['schoolid'];
		$gradeid = $_REQUEST['gradeid'];
		
		$data['section'] = $this->Superadmin_model->getsection($schoolid,$gradeid);
		$this->load->view('superadmin/section_ajax', $data);
		
	}
	
	public function sgb_report()
	{
		$data['getschools_m'] = $this->Superadmin_model->getschools_chk();
		$data['getgrades_m'] = $this->Superadmin_model->getgrades_chk();
		//print_r($data['getgrades_m']); 
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/school_gradewise_bspi', $data);
		$this->load->view('superadmin/footer');
	}
	
	
	public function schoolwise_gradewise_bspi_avg()
	{			
		$data['academic'] = $this->Superadmin_model->academicyears();
		$schoolid = $_POST['schoolid'];
		$gradeid = $_POST['gradeid'];
		
		//echo $gradeid; exit;
		$gradeidsplit = $this->comma_separated_to_array($gradeid);
		$schoolidsplit = $this->comma_separated_to_array($schoolid);
	if($schoolid=='' && $gradeid=='')
	{
		$gradeids='';
		$schoolids='';
	}
	else{
	 $gradeids = "'" . implode("','", $gradeidsplit) . "'";
	 $schoolids = "'" . implode("','", $schoolidsplit) . "'";
	}
	$data['sgb'] = $this->Superadmin_model->schoolwise_gradewise_bspi_avg($gradeids,$schoolids);
	$data['bspi'] = $this->Superadmin_model->schoolwisebspi();
	$this->load->view('superadmin/school_gradewise_bspi_ajax', $data);
		
	}
	
	public function gradewise_report()
	{
		$data['schools'] = $this->Superadmin_model->getschools();
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/gradewise_bspi', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function tsu()
	{
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/top_schools_by_users');
		$this->load->view('superadmin/footer');
	}
	
	public function schools_usage()
	{
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/top_schools_by_usage');
		$this->load->view('superadmin/footer');
	}
	
	public function schools_sparkie()
	{
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/top_schools_by_sparkie');
		$this->load->view('superadmin/footer');
	}
	
	public function bspi_users()
	{
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/top_users_bspi');
		$this->load->view('superadmin/footer');
	}
	
	public function skillscore_users()
	{
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/users_skillscore_report');
		$this->load->view('superadmin/footer');
	}
	
	public function top_attempted_users()
	{
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/top_users_attempted');
		$this->load->view('superadmin/footer');
	}
	
	public function sparkie_users()
	{
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/top_users_sparkie');
		$this->load->view('superadmin/footer');
	}
	
	public function gradewise_bspi_avg()
	{			
		$schoolid = $_POST['schoolid'];
		$data['bspi'] = $this->Superadmin_model->schoolwisebspi();
	$data['gradewisebspi'] = $this->Superadmin_model->gradewise_bspi_avg($schoolid);
	
	$this->load->view('superadmin/gradewise_bspi_ajax', $data);
		
	}
	
	public function sg_skillscore()
	{
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/school_gradewise_skillscore');
		$this->load->view('superadmin/footer');
	}
	
		public function skl_gradewise_skillscore()
	{
		$skillid = $_POST['val'];
		$data['skilltopper'] = $this->Superadmin_model->skillwisetopper_memory($skillid);
		$data['sklgrade_skillscore'] = $this->Superadmin_model->skl_gradewise_skillscore($skillid);
		$this->load->view('superadmin/school_gradewise_skillscore_ajax', $data);
	}
	
	public function gradewise_skillscore()
	{
		$data['schools'] = $this->Superadmin_model->getschools();
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/gradewise_skillscore', $data);
		$this->load->view('superadmin/footer');
	}
	
	public function gradewise_skill()
	{
		$skillid = $_POST['val'];
		$schoolid = $_POST['schoolid'];
		$data['skilltopper'] = $this->Superadmin_model->skillwisetopper_memory($skillid);
		$data['gradewise_skillscore'] = $this->Superadmin_model->gradewise_skillscore($skillid,$schoolid);
		$this->load->view('superadmin/gradewise_skillscore_ajax', $data);
	}
	
	public function userupload()
	{	
		$data['schools'] = $this->Superadmin_model->getschools();
		$data['grades'] = $this->Superadmin_model->getgrades();
		$this->load->view('superadmin/admin_header');
		$this->load->view('superadmin/user_upload', $data);
		$this->load->view('superadmin/footer');
	
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
	
	public function userupload_list()
	{
		
		if(isset($_POST['sbmtbtn'])) 
{
	 
	$ceationkey = date('YmdHis');
	$schoolid=$_REQUEST['schoolid'];
	$ddlGradeType=$_REQUEST['ddlGradeType'];

	
	$handle = fopen($_FILES['txtUpload']['tmp_name'], "r");
	
	
$csvfilename = "uploads/contacts_".$ceationkey.".csv";

 $file = fopen($csvfilename,"w");
 
 fputcsv($file,array('Firstname','Lastname','Gender','DOB','Grade','Username','Password'));
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		
		
	$data['query1'] = $this->Superadmin_model->getusercount($data[0]);
	$userexist = $data['query1'][0]['userCount']; 
	
	$password = 'skillangels';
				$hashpass = $this->salt_my_pass($password);
				 
				$shpassword = $hashpass['Hash']; 
				$salt1 = $hashpass['Salt1']; 
				$salt2 = $hashpass['Salt2'];
		
		if($userexist==0)
		{
			$data['import'] = $this->Superadmin_model->userimport($shpassword,$salt1,$salt2,$data[0],$data[1],$data[2],$data[3],$data[4],$schoolid,$ddlGradeType,$ceationkey);
		}
		else
		{
			$data['import'] = $this->Superadmin_model->userimport1($shpassword,$salt1,$salt2,$data[0],$data[1],$data[2],$data[3],$data[4],$schoolid,$ddlGradeType,$ceationkey,$userexist);
		}

    }
	
	
	$data['download'] = $this->Superadmin_model->userdownload($ceationkey);

 foreach($data['download'] as $downloaddata)
 {
	 fputcsv($file,array($downloaddata['fname'],$downloaddata['lname'],$downloaddata['gender'],$downloaddata['dob'],$downloaddata['gradename'],$downloaddata['username'],'skillangels' ));
 }
 
 

    fclose($handle);
	
$data['filename'] = $csvfilename; 
$this->load->view('superadmin/admin_header');
$this->load->view('superadmin/user_upload', $data);
$this->load->view('superadmin/footer');

}
	}
	
	public function toppers()
	{
		$data['school']=$this->Superadmin_model->GetSchool();
		$data['grade']=$this->Superadmin_model->GetGrade();
		$data['toppers']=$this->Superadmin_model->GetClassSparkiesToppers();
	if(isset($_POST['btndownload'])) 
	{ 
		
			if($this->input->post('hdnschool')!='' || $this->input->post('hdngrade')!='' || $this->input->post('hdntype')!='' || $this->input->post('hdnmonth')!='')
			{ 	  
				if($this->input->post('hdntype')!='')
				{ 
					$hdnschool=$this->input->post('hdnschool');
					$hdngrade=$this->input->post('hdngrade');
					$hdntype=$this->input->post('hdntype');
					$hdnmonth=$this->input->post('hdnmonth');
					
					$hdnschool=str_replace("multiselect-all,",'',$hdnschool);
					$tests = $this->comma_separated_to_array($hdnschool);
					$schoolids = "'" . implode("','", $tests) . "'";
					
					$hdngrade=str_replace("multiselect-all,",'',$hdngrade);
					$testg = $this->comma_separated_to_array($hdngrade);
					$gradeids = "'" . implode("','", $testg) . "'";
					
					$hdntype=str_replace("multiselect-all,",'',$hdntype);
					$testt = $this->comma_separated_to_array($hdntype);
					$typeids = "'" . implode("','", $testt) . "'";
					
					$hdnmonth=str_replace("multiselect-all,",'',$hdnmonth);
					$testm = $this->comma_separated_to_array($hdnmonth);
					$monthids = "'" . implode("','", $testm) . "'"; 
					
					 if(isset($hdnschool) && $hdnschool!='')
					{	$schoolqry=" and bspi1.sid in(".$schoolids.")";
						$schoolqry1=" and vv1.S_ID in(".$schoolids.")";
					}
					else
					{	$schoolqry=" and 1=1"; $schoolqry1=" and 1=1";
					}
					
					if(isset($hdngrade) && $hdngrade!='' )
					{	$gradeqry=" and bspi1.grade_id in(".$gradeids.")";
						$gradeqry1=" and vv1.G_ID in(".$gradeids.") ";
					}
					else
					{	$gradeqry=" and 1=1";$gradeqry1=" and 1=1";
					}
					
					if(isset($hdnmonth) && $hdnmonth!='')
					{	$monthqry=" and bspi1.monthNumber in (".$monthids.")";
						$monthqry1=" and vv1.monthNumber in (".$monthids.")";
					}
					else
					{	$monthqry=" and 1=1";
						$monthqry1=" and 1=1";
					}  
					
					if($hdntype=='BSPI,SPARKIES')
					{
						$arrresultbspi=$this->Superadmin_model->GetSchoolWiseToppersBSPI($schoolqry,$gradeqry,$typeids,$monthqry);
						$arrresultsparkies=$this->Superadmin_model->GetSchoolWiseToppersSparkies($schoolqry1,$gradeqry1,$typeids,$monthqry1);
					}
					else if($hdntype=='BSPI')
					{	$arrresultbspi=$this->Superadmin_model->GetSchoolWiseToppersBSPI($schoolqry,$gradeqry,$typeids,$monthqry);
					}
					else if($hdntype=='SPARKIES')
					{	$arrresultsparkies=$this->Superadmin_model->GetSchoolWiseToppersSparkies($schoolqry1,$gradeqry1,$typeids,$monthqry1);
					}
					$ClasswisePerformanceReport=array();
					$data['ClasswisePerformanceReport']=$ClasswisePerformanceReport;
					//echo "<pre>";print_r($arrresultbspi);echo "<br/>";
					//echo "<pre>";print_r($arrresultsparkies);
					$i=0;
					foreach($arrresultbspi as $row)
					{
						$ClasswisePerformanceReport[$i]['Username']=$row['username'];
						$ClasswisePerformanceReport[$i]['school_name']=$row['school_name'];
						$ClasswisePerformanceReport[$i]['classname']=$row['classname']." - ". $row['sectionname'];
						$ClasswisePerformanceReport[$i]['monthNumber']=$row['monthName'];
						$ClasswisePerformanceReport[$i]['score']=$row['bspi'];
						$ClasswisePerformanceReport[$i]['type']='BSPI';
						$i++;
					}
					foreach($arrresultsparkies as $row1)
					{
						$ClasswisePerformanceReport[$i]['Username']=$row1['username'];
						$ClasswisePerformanceReport[$i]['school_name']=$row1['school_name'];
						$ClasswisePerformanceReport[$i]['classname']=$row1['classname']." - ". $row1['sectionname'];
						$ClasswisePerformanceReport[$i]['monthNumber']=$row1['monthName'];
						$ClasswisePerformanceReport[$i]['score']=$row1['points'];
						$ClasswisePerformanceReport[$i]['type']='SPARKIES';
						$i++;
					}
					//echo "<br/><br/>		<pre>";print_r($ClasswisePerformanceReport);
					foreach($ClasswisePerformanceReport as $result)
					{
						
					if (file_exists(APPPATH."../report_image/".$result['school_name']."/".$result['type']."/".$result['classname'])) {
					foreach (glob(APPPATH."../report_image/".$result['school_name']."/".$result['type']."/".$result['classname']."/*.*") as $filename) {
						if (is_file($filename)) {
							unlink($filename);
						}
					}
					rmdir(APPPATH."../report_image/".$result['school_name']."/".$result['type']."/".$result['classname']);
					}
					if (!file_exists(APPPATH."../report_image/".$result['school_name']."/".$result['type']."/".$result['classname'])) {
					mkdir(APPPATH."../report_image/".$result['school_name']."/".$result['type']."/".$result['classname'], 0777, true);
					}
						
						$BackgroundImage= APPPATH."../assets/images/sparkies/Report.png";
						$img=$this->LoadPNG($BackgroundImage,$result['Username'],$result['school_name'],str_replace("Grade",'',$result['classname']),$result['monthNumber'],$result['score']);
						
						imagepng($img,APPPATH."../report_image/".$result['school_name']."/".$result['type']."/".$result['classname']."/".trim($result['Username']).".png");

						imagedestroy($img);
					}
				}
				else
				{
					$data['error']="Please select any one type.";
				}
			}
			else
			{
				$data['error']="Please fillout all the fields.";
			}	
	}
		if(isset($_POST['btnSearch'])) 
		{ 
			if($this->input->post('hdnschool')!='' || $this->input->post('hdngrade')!='' || $this->input->post('hdntype')!='' || $this->input->post('hdnmonth')!=''){ 	  
			if($this->input->post('hdntype')!=''){ 
			$hdnschool=$this->input->post('hdnschool');
			$hdngrade=$this->input->post('hdngrade');
			$hdntype=$this->input->post('hdntype');
			$hdnmonth=$this->input->post('hdnmonth');
			
			$hdnschool=str_replace("multiselect-all,",'',$hdnschool);
			$tests = $this->comma_separated_to_array($hdnschool);
			$schoolids = "'" . implode("','", $tests) . "'";
			
			$hdngrade=str_replace("multiselect-all,",'',$hdngrade);
			$testg = $this->comma_separated_to_array($hdngrade);
			$gradeids = "'" . implode("','", $testg) . "'";
			
			$hdntype=str_replace("multiselect-all,",'',$hdntype);
			$testt = $this->comma_separated_to_array($hdntype);
			$typeids = "'" . implode("','", $testt) . "'";
			
			$hdnmonth=str_replace("multiselect-all,",'',$hdnmonth);
			$testm = $this->comma_separated_to_array($hdnmonth);
			$monthids = "'" . implode("','", $testm) . "'"; 
			
			 if(isset($hdnschool) && $hdnschool!='')
			{	$schoolqry=" and bspi1.sid in(".$schoolids.")";
				$schoolqry1=" and vv1.S_ID in(".$schoolids.")";
			}
			else
			{	$schoolqry=" and 1=1"; $schoolqry1=" and 1=1";
			}
			
			if(isset($hdngrade) && $hdngrade!='' )
			{	$gradeqry=" and bspi1.grade_id in(".$gradeids.")";
				$gradeqry1=" and vv1.G_ID in(".$gradeids.") ";
			}
			else
			{	$gradeqry=" and 1=1";$gradeqry1=" and 1=1";
			}
			
			if(isset($hdnmonth) && $hdnmonth!='')
			{	$monthqry=" and bspi1.monthNumber in (".$monthids.")";
				$monthqry1=" and vv1.monthNumber in (".$monthids.")";
			}
			else
			{	$monthqry=" and 1=1";
				$monthqry1=" and 1=1";
			}  
			//echo $hdntype;
			
				if($hdntype=='BSPI,SPARKIES')
				{
					$data['bspi']=$this->Superadmin_model->GetSchoolWiseToppersBSPI($schoolqry,$gradeqry,$typeids,$monthqry);
					$data['sparkies']=$this->Superadmin_model->GetSchoolWiseToppersSparkies($schoolqry1,$gradeqry1,$typeids,$monthqry1);
				}
				else if($hdntype=='BSPI')
				{	$data['bspi']=$this->Superadmin_model->GetSchoolWiseToppersBSPI($schoolqry,$gradeqry,$typeids,$monthqry);
				}
				else if($hdntype=='SPARKIES')
				{	$data['sparkies']=$this->Superadmin_model->GetSchoolWiseToppersSparkies($schoolqry1,$gradeqry1,$typeids,$monthqry1);
				}
			}
			else
			{
				$data['error']="Please select any one type.";
			}
			}
			else
			{
				$data['error']="Please fillout all the fields.";
			}
		}
		//echo "<pre>";print_r($data);exit;
			
		$this->load->view('headerinner');
		$this->load->view('superadmin/toppers', $data);
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
	  //Return empty array if no items found
	  //http://php.net/manual/en/function.explode.php#114273
	  return array_diff($vals, array(""));
	}

	
public function LoadPNG($fBackgroundImage,$fUserName,$fGrade,$fSchool,$fMonth,$fScore)
{ //echo $fBackgroundImage;exit;
    /* Attempt to open */
    $im = @imagecreatefrompng($fBackgroundImage);
//echo "<pre>";print_r($im);exit;
    /* See if it failed */
    if(!$im)
    {
      echo "Loading bg has issue ";
    }
 //echo $fBackgroundImage.",".$fUserName.",".$fGrade.",".$fSchool.",".$fMonth.",".$fScore;exit;
// Add some shadow to the text
$text_color = imagecolorallocate($im, 0, 0, 0);
$font = APPPATH."../assets/fonts/OpenSansBold.ttf";

	/* imagestring($im, 3, 400, 300, $fUserName, $text_color);
	imagestring($im, 3, 400, 400, $fSchool, $text_color);
	imagestring($im, 3, 400, 500, $fGrade, $text_color);
	imagestring($im, 3, 400, 600, $fMonth, $text_color);
	imagestring($im, 3, 400, 700, $fScore, $text_color); */
	imagettftext($im, 30, 0, 400, 323, $text_color, $font, $fUserName);
	imagettftext($im, 30, 0, 400, 425, $text_color, $font, $fSchool);
	imagettftext($im, 30, 0, 400, 527, $text_color, $font, str_replace("Grade",' ',$fGrade));
	imagettftext($im, 30, 0, 400, 630, $text_color, $font, $fMonth);
	imagettftext($im, 30, 0, 400, 732, $text_color, $font, $fScore);
	//echo "<pre>";print_r($im);exit;
	/* header("Content-type: image/png");
	imagepng($im);
imagedestroy($im);exit; */
    return $im;
}
public function eom_monthwisebspireport()
{
	$schoolid = $_POST['schoolid'];
	$month = explode("/",$_POST['month']);
	$exestartdate=explode("-",$month[0]);$exeenddate=explode("-",$month[1]);		
	$monthNumber=$exestartdate[1];
	$data['training']=$this->Superadmin_model->trainingmonthwisebspi($schoolid,$monthNumber);
	$data['assessments']=$this->Superadmin_model->assessmentmonthwisebspi($schoolid,$monthNumber);
	$this->load->view('superadmin/eom_bspireport_ajax', $data);
	/* echo "<pre>";print_r($data['training']);
	echo "<pre>";print_r($data['assessments']);exit; */
	
}
public function eom_topperslist()
{
	$schoolid = $_POST['schoolid'];
	$month = explode("/",$_POST['month']);
	$exestartdate=explode("-",$month[0]);$exeenddate=explode("-",$month[1]);		
	$monthNumber=$exestartdate[1];
	$data['bspigradetoppers']=$this->Superadmin_model->bspigradetoppers($schoolid,$monthNumber);
	$data['overallbspitoppers']=$this->Superadmin_model->overallbspitoppers($schoolid,$monthNumber);
	$this->load->view('superadmin/eom_overalltoppersbspireport_ajax', $data);
}
public function eom_intervention()
{
	$schoolid = $_POST['schoolid'];
	$month = explode("/",$_POST['month']);
	$exestartdate=explode("-",$month[0]);$exeenddate=explode("-",$month[1]);		
	$monthNumber=$exestartdate[1];
	$data['bspiranges']=$this->Superadmin_model->bspiranges($schoolid,$monthNumber);
	$data['notattendeduser']=$this->Superadmin_model->notattendeduser($schoolid,$monthNumber);
	$data['notattendeduserlist']=$this->Superadmin_model->notattendeduserlist($schoolid,$monthNumber);
	//echo "<pre>";print_r($data['notattendeduser']);exit;
	$data['bspilessthan_twentity']=$this->Superadmin_model->bspilessthan_twentity($schoolid,$monthNumber);
	$data['bspilessthan_twentytoforty']=$this->Superadmin_model->bspilessthan_twentytoforty($schoolid,$monthNumber);
	$data['bspilessthan_fortytosixty']=$this->Superadmin_model->bspilessthan_fortytosixty($schoolid,$monthNumber);
	$data['bspilessthan_sixtytoeighty']=$this->Superadmin_model->bspilessthan_sixtytoeighty($schoolid,$monthNumber);
	$data['bspilessthan_aboveeighty']=$this->Superadmin_model->bspilessthan_aboveeighty($schoolid,$monthNumber);
	
	$this->load->view('superadmin/eom_interventionreport_ajax', $data);
}
public function DownloadPDF()
{
	$schoolid = 18;
	$month = explode("/",$_POST['month']);
	$exestartdate=explode("-",$month[0]);$exeenddate=explode("-",$month[1]);		
	$monthNumber='06';
	$data['bspigradetoppers']=$this->Superadmin_model->bspigradetoppers($schoolid,$monthNumber);
	$arrofresult='';
	$header = array('S.No.', 'Grade', 'Section', 'Name', 'BSPI Score');
	$i=0;
	/* foreach($data['bspigradetoppers'] as $row) {
		//echo  "<pre>";print_r($row['classname']);exit;
		$arrofresult.="array('".$i."','".$row['classname']."','".$row['section']."','".$row['username']."','".$row['bspi']."'),";
		$i++;
	}
	//echo "<pre>";print_r($arrofresult);exit;
	$data   = array(array('0','Grade I','A','SARVESH VARUN A ','53.64'),array('1','Grade I','B','SIVA DHARSHINI V K ','54.50'),array('2','Grade II','A','POOJA VARSHNI M ','48.57'),array('3','Grade II','B','KARTHI RAJ K G ','53.60'),array('4','Grade III','A','DAKSHESH SABARI S ','46.75'),array('5','Grade III','B','KEYANSH S SHAH ','54.17'),array('6','Grade IV','A','AKSHA D ','58.50'),array('7','Grade IV','B','VAISHNAVI R ','51.16'),array('8','Grade V','A','KRISHNAN S ','59.62'),array('9','Grade V','B','RAKSHA M ','58.97'),array('10','Grade VI','A','SANJANA N ','78.76'),array('11','Grade VI','B','THRESHMA SRI G S ','79.35'),array('12','Grade VII','A','PREMNIVAS B M ','55.60'),array('13','Grade VII','B','ASWINI M S ','60.02'),array('14','Grade VIII','A','MRIDHULA P ','49.50'),array('15','Grade VIII','B','MYTHREYAN PRASATH M R S ','51.36')); */
	$this->mypdf->SetFont('Arial','',12);
	$this->mypdf->AddPage();
	$this->mypdf->SetY(40); 			
	//$this->mypdf->improvedTable($header,$data);
		
		
		// Colors, line width and bold font
	    $this->mypdf->SetFillColor(255,0,0);
	    $this->mypdf->SetTextColor(255);
	    $this->mypdf->SetDrawColor(128,0,0);
	    $this->mypdf->SetLineWidth(.3);
	    $this->mypdf->SetFont('','B');
	    // Header
	    $w = array(15,25,18,100,30);
	    for($i=0;$i<count($header);$i++)
	        $this->mypdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
	    $this->mypdf->Ln();
	    // Color and font restoration
	    $this->mypdf->SetFillColor(224,235,255);
	    $this->mypdf->SetTextColor(0);
	    $this->mypdf->SetFont('');
	    // Data
	    $fill = false;$j=1;
	    foreach($data['bspigradetoppers'] as $row)
	    {	//echo "<pre>";print_r($row);exit;
			//echo $this->mypdf->GetY();exit;
				/* if(($j%12)==0){
						for($i=0;$i<count($header);$i++)
							$this->mypdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
						$this->mypdf->Ln();
				} */
				$this->mypdf->Cell($w[0],8,$j,'LR',0,'L',$fill);
				$this->mypdf->Cell($w[1],8,$row['classname'],'LR',0,'L',$fill);
				$this->mypdf->Cell($w[2],8,$row['section'],'LR',0,'L',$fill);
				$this->mypdf->Cell($w[3],8,$row['username'],'LR',0,'L',$fill);
				$this->mypdf->Cell($w[4],8,$row['bspi'],'LR',0,'L',$fill);
				$this->mypdf->Ln();
				$fill = !$fill;
			
				$j++;
	    }
	    // Closing line
	    $this->mypdf->Cell(array_sum($w),0,'','T');
		//$this->mypdf->Output();
	echo $this->mypdf->Output('hello_world.pdf','D');
	
}
public function fancyTable()
{
	 $header = array('S.No.', 'Grade', 'Section', 'Name', 'BSPIScore');
	$data   = array(array('Austria','Vienna','83859','8075','jj'));
	$this->mypdf->SetFont('Arial','',12);
	$this->mypdf->AddPage();
	$this->mypdf->SetY(40); 			
	$this->mypdf->FancyTable($header,$data);
	$this->mypdf->Output();
	
}
	public function eom_userattendedcount()
	{
		$schoolid = $_POST['schoolid'];
		$month = explode("/",$_POST['month']);
		$exestartdate=explode("-",$month[0]);$exeenddate=explode("-",$month[1]);		
		$monthNumber=$exestartdate[1];
		$data['userattendedcount']=$this->Superadmin_model->userattendedcount($schoolid,$monthNumber);
		$this->load->view('superadmin/eom_userattendedcount_ajax', $data);
		/* echo "<pre>";print_r($data['training']);
		echo "<pre>";print_r($data['assessments']);exit; */
		
	}
	public function eom_reportupdate()
	{
		$schoolid = $_POST['schoolid'];
		$rCode = $_POST['code'];
		$message = $_POST['message'];
		$month = explode("/",$_POST['month']);
		$exestartdate=explode("-",$month[0]);$exeenddate=explode("-",$month[1]);		
		$monthNumber=$exestartdate[1];
		//echo $schoolid.",".$monthNumber.",".$rCode.",".$message.",".$isexist[0]['countval'];exit;
		$isexist=$this->Superadmin_model->Reportisexist($schoolid,$monthNumber);		
		$this->Superadmin_model->UpdateReport($schoolid,$monthNumber,$rCode,$message,$isexist[0]['countval']);
		
	}
	public function eom_getreportmessage()
	{
		$schoolid = $_POST['schoolid'];
		$rCode = $_POST['code'];
		$month = explode("/",$_POST['month']);
		$exestartdate=explode("-",$month[0]);$exeenddate=explode("-",$month[1]);		
		$monthNumber=$exestartdate[1];
		$GetData=$this->Superadmin_model->GetReportMessage($schoolid,$monthNumber,$rCode);
		echo $GetData[0]['Message'];exit;
	}
}
