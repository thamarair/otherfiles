<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
				$this->load->model('Admin_model');
				$this->load->library('session');						
    }
	
	public function index()
	{			
		$this->load->view('admin/login');
		
	}
		
	public function login()
	{			
		
		$this->load->view('admin/login');
		
	}
	
		
	
	public function logincheck()
	{	
	
	if($_POST['username']=='admin@skillangels.com' && $_POST['password']==123456)
	{
		$this->session->set_userdata(array(
				'username'      => $_POST['username'],
				'role'			=>'1'
				));
		redirect('index.php/admin/dashboard');
	}
	else if($_POST['username']=='skillangels' && $_POST['password']=='skillangels')
	{
		$this->session->set_userdata(array(
				'username'      => $_POST['username'],
				'role'			=>'1'
				));
		
		redirect('index.php/admin/schedule');
	}
	else{
		
		$data['error'] = "Invalid credentials";
		$this->load->view('admin/login', $data);		
	}
	}
	
	public function logout()
	{
		if($this->session->username=="" || !isset($this->session->username)){redirect('index.php/admin/');}
		$user_data = $this->session->all_userdata();
        foreach ($user_data as $key => $value) {
            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
                $this->session->unset_userdata($key);
            }
        }
		$this->session->sess_destroy();
		redirect('index.php/admin/');
	}
	
	public function dashboard()
	{
		if($this->session->username=="" || !isset($this->session->username)){redirect('index.php/admin/');}

		$this->load->view('admin/admin_header');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/footer');
	}
	
	public function schedule()
	{
		if($this->session->username=="" || !isset($this->session->username)){redirect('index.php/admin/');}
		$data['timetable'] = $this->Admin_model->timetable();
		$data['schoolcodes'] = $this->Admin_model->schoolcodes();
		$this->load->view('admin/admin_header');
		$this->load->view('admin/schools_schedule', $data);
		$this->load->view('admin/footer');
	}
	
	public function schools_schedule()
	{
		$schoolid = $_POST['schoolid'];
		$gradeid = $_POST['gradeid'];
		$section = $_POST['section'];
		
		$data['schools_schedule_r'] = $this->Admin_model->schools_schedule_regusers($schoolid,$gradeid,$section);
		$data['schools_schedule_t'] = $this->Admin_model->schools_schedule_takenusers($schoolid,$gradeid,$section);
		$data['schools_schedule_c'] = $this->Admin_model->schools_schedule_completeusers($schoolid,$gradeid,$section);
		
		$this->load->view('admin/dashboard_ajax', $data);
		//echo json_encode(array("registerusers"=>$regusers,"trainingtaken"=>$takenusers,"trainingcompleted"=>$completeusers)); exit;	
	}
	
	public function dashboard_counts()
	{			
	
	 $data['academic'] = $this->Admin_model->academicyears();
	 $startdate = $data['academic'][0]['startdate'];
	 $enddate = $data['academic'][0]['enddate'];
	 $data['schoolscount'] = $this->Admin_model->schools($startdate,$enddate);
	 $data['schoolscount'][0]['schoolscount']; 
	
	
	$data['studentscount'] = $this->Admin_model->students($startdate,$enddate);
	$data['studentscount'][0]['studentscount'];

	 $data['trainningbspi'] = $this->Admin_model->trainingbspi($startdate,$enddate);
	 $data['trainningbspi'][0]['overallbspi'];
	
	$schools[] = $data['schoolscount'][0]['schoolscount']; 
	$students[] = $data['studentscount'][0]['studentscount'];
	$studentname[] = $data['username'][0]['fname'];
	$trainingbspi[] = round($data['trainningbspi'][0]['overallbspi'], 2 );
	
	echo json_encode(array("schools"=>$schools,"students"=>$students,"name"=>$studentname, "trainingbspi"=>$trainingbspi)); exit;

	}
	
	public function schoolwisebspi()
	{
		$data['academic'] = $this->Admin_model->academicyears();
		$startdate = $data['academic'][0]['startdate'];
		$enddate = $data['academic'][0]['enddate'];
		$data['overallbspi']=$_REQUEST['trainingoverallbspi'][0];
		$data['bspi'] = $this->Admin_model->schoolwisebspi($startdate,$enddate);
		//print_r($data['bspi']); exit;
		$this->load->view('admin/schoolwise_bspiajax', $data);
	}
	
	public function skillwisetopper()
	{
		$data['academic'] = $this->Admin_model->academicyears();
		$startdate = $data['academic'][0]['startdate'];
		$enddate = $data['academic'][0]['enddate'];
		$skillid = $_POST['val'];
		$data['skilltopper'] = $this->Admin_model->skillwisetopper_memory($skillid,$startdate,$enddate);
		//print_r($data['memory']);
		//echo $data['memory'][0]['finalscore'];
		
		$this->load->view('admin/skilltopper_ajax', $data);
	}
	
	public function bspi_report()
	{	
	if($this->session->username=="" || !isset($this->session->username)){redirect('index.php/admin/');}
		$data['academic'] = $this->Admin_model->academicyears();
		$startdate = $data['academic'][0]['startdate'];
		$enddate = $data['academic'][0]['enddate'];
		$data['getschools_m'] = $this->Admin_model->getschools_chk($startdate,$enddate);
		$data['grades'] = $this->Admin_model->getgrades();
		$this->load->view('admin/admin_header');
		$this->load->view('admin/bspi_report', $data);
		$this->load->view('admin/footer');
	
	}
	
	public function bspi_reports()
	{
		$data['academic'] = $this->Admin_model->academicyears();
		$startdate = $data['academic'][0]['startdate'];
		$enddate = $data['academic'][0]['enddate'];
	$schoolid = $_POST['schoolid'];
	$gradeid = $_POST['gradeid'];
	$sectionid = $_POST['sectionid'];
		
		$data['getplan'] = $this->Admin_model->getplanid($schoolid,$gradeid);
		$planid = $data['getplan'][0]['plan_id'];
		
		$data['usersbspireport'] = $this->Admin_model->usersbspireport($schoolid,$gradeid,$sectionid,$startdate,$enddate);
		$data['report1'] = $this->Admin_model->bspi_reports($schoolid,$gradeid,$sectionid);
		
		$this->load->view('admin/bspi_ajax', $data);
	}
	
	public function bspi_report_excel()
	{
		
	$schoolid = $_POST['schoolid'];
	$gradeid = $_POST['gradeid'];
	$sectionid = $_POST['sectionid'];
	//$skillid = $_POST['skillid'];
		$data['getplan'] = $this->Admin_model->getplanid($schoolid,$gradeid);
		$planid = $data['getplan'][0]['plan_id'];
		//$data['gradesetid'] = $this->Admin_model->getgradeidsets($planid,$gradeid);
		$data['report1'] = $this->Admin_model->bspi_reports($schoolid,$gradeid,$sectionid);
		
			
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
$logo =APPPATH."../assets/admin/images/excellogo.png"; // Provide path to your logo file
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
	if($this->session->username=="" || !isset($this->session->username)){redirect('index.php/admin/');}
		$data['academic'] = $this->Admin_model->academicyears();
		$startdate = $data['academic'][0]['startdate'];
		$enddate = $data['academic'][0]['enddate'];
		$data['getschools_m'] = $this->Admin_model->getschools_chk($startdate,$enddate);
		$data['grades'] = $this->Admin_model->getgrades();
		$this->load->view('admin/admin_header');
		$this->load->view('admin/skillscore_report', $data);
		$this->load->view('admin/footer');
	
	}
	
	public function skillscore_reports()
	{
		
	$schoolid = $_POST['schoolid'];
	$gradeid = $_POST['gradeid'];
	$skillid = $_POST['skillid']; 
	$sectionid = $_POST['sectionid'];
	$data['getplan'] = $this->Admin_model->getplanid($schoolid,$gradeid);
	$planid = $data['getplan'][0]['plan_id'];
	$data['overallsklscore'] = $this->Admin_model->skillscore_skl_grade_sect_wise($startdate,$enddate,$schoolid,$gradeid,$skillid,$sectionid);
		$data['report2'] = $this->Admin_model->skillscore_reports($schoolid,$gradeid,$skillid,$sectionid);
		$this->load->view('admin/skillscore_report_ajax', $data);
	}
	
	
	public function skillscore_report_excel()
	{
		$data['academic'] = $this->Admin_model->academicyears();
		$startdate = $data['academic'][0]['startdate'];
		$enddate = $data['academic'][0]['enddate'];
		
	$schoolid = $_POST['schoolid'];
	$gradeid = $_POST['gradeid'];
	$skillid = $_POST['skillid']; 
	$sectionid = $_POST['sectionid'];
	$data['getplan'] = $this->Admin_model->getplanid($schoolid,$gradeid);
	$planid = $data['getplan'][0]['plan_id'];
	
		$data['report2'] = $this->Admin_model->skillscore_reports($schoolid,$gradeid,$skillid,$sectionid);
		
		
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
$logo =APPPATH."../assets/admin/images/excellogo.png"; // Provide path to your logo file
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
		$data['academic'] = $this->Admin_model->academicyears();
		$startdate = $data['academic'][0]['startdate'];
		$enddate = $data['academic'][0]['enddate'];
		$data['getschools_m'] = $this->Admin_model->getschools_chk($startdate,$enddate);
		$data['grades'] = $this->Admin_model->getgrades();
		$data['academic'] = $this->Admin_model->academicyears();
		$startdate = $data['academic'][0]['startdate'];
		$enddate = $data['academic'][0]['enddate'];
		$this->load->view('admin/admin_header');
			
			if(isset($_POST['schoolid']) || isset($_POST['gradeid']) || isset($_POST['sectionid']) ||  isset($_POST['rangefrom']) || isset($_POST['rangeto']) )
			{
		$schoolid = $_POST['schoolid'];
		$gradeid = $_POST['gradeid'];
		$sectionid = $_POST['sectionid'];
		$rangefrom = $_POST['rangefrom'];
		$rangeto = $_POST['rangeto'];
		
		$data['GradewiseScore_data1'] = $this->Admin_model->getClassPerformace_data($schoolid,$gradeid,$sectionid,'game_reports',$rangefrom,$rangeto,$startdate,$enddate);
		
		$data['getplan'] = $this->Admin_model->getplanid($schoolid,$gradeid);
		$planid = $data['getplan'][0]['plan_id'];
		
		$data['data'] = $sectionid;
		$data['bspirange'] = $bspirange;
		//print_r($data['GradewiseScore_data1']);
			}

		$this->load->view('admin/performance_report', $data);
		$this->load->view('admin/footer');
	
	}
	
	public function getsection()
	{
		$schoolid = $_REQUEST['schoolid'];
		$gradeid = $_REQUEST['gradeid'];
		
		$data['section'] = $this->Admin_model->getsection($schoolid,$gradeid);
		$this->load->view('admin/section_ajax', $data);
		
	}
	
	public function sgb_report()
	{
		if($this->session->username=="" || !isset($this->session->username)){redirect('index.php/admin/');}
		$data['academic'] = $this->Admin_model->academicyears();
		$startdate = $data['academic'][0]['startdate'];
		$enddate = $data['academic'][0]['enddate'];
		$data['getschools_m'] = $this->Admin_model->getschools_chk($startdate,$enddate);
		$data['getgrades_m'] = $this->Admin_model->getgrades_chk($startdate,$enddate);
		//print_r($data['getgrades_m']); 
		$this->load->view('admin/admin_header');
		$this->load->view('admin/school_gradewise_bspi', $data);
		$this->load->view('admin/footer');
	}
	
	
	public function schoolwise_gradewise_bspi_avg()
	{			
		$data['academic'] = $this->Admin_model->academicyears();
		$startdate = $data['academic'][0]['startdate'];
		$enddate = $data['academic'][0]['enddate'];
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
	$data['sgb'] = $this->Admin_model->schoolwise_gradewise_bspi_avg($gradeids,$schoolids,$startdate,$enddate);
	$data['bspi'] = $this->Admin_model->schoolwisebspi($startdate,$enddate);
	$this->load->view('admin/school_gradewise_bspi_ajax', $data);
		
	}
	
	public function gradewise_report()
	{
		if($this->session->username=="" || !isset($this->session->username)){redirect('index.php/admin/');}
		$data['academic'] = $this->Admin_model->academicyears();
		$startdate = $data['academic'][0]['startdate'];
		$enddate = $data['academic'][0]['enddate'];
		$data['getschools_m'] = $this->Admin_model->getschools_chk($startdate,$enddate);
		$this->load->view('admin/admin_header');
		$this->load->view('admin/gradewise_bspi', $data);
		$this->load->view('admin/footer');
	}
	
	public function tsu()
	{
		$this->load->view('admin/admin_header');
		$this->load->view('admin/top_schools_by_users');
		$this->load->view('admin/footer');
	}
	
	public function schools_usage()
	{
		$this->load->view('admin/admin_header');
		$this->load->view('admin/top_schools_by_usage');
		$this->load->view('admin/footer');
	}
	
	public function schools_sparkie()
	{
		$this->load->view('admin/admin_header');
		$this->load->view('admin/top_schools_by_sparkie');
		$this->load->view('admin/footer');
	}
	
	public function bspi_users()
	{
		$this->load->view('admin/admin_header');
		$this->load->view('admin/top_users_bspi');
		$this->load->view('admin/footer');
	}
	
	public function skillscore_users()
	{
		$this->load->view('admin/admin_header');
		$this->load->view('admin/users_skillscore_report');
		$this->load->view('admin/footer');
	}
	
	public function top_attempted_users()
	{
		$this->load->view('admin/admin_header');
		$this->load->view('admin/top_users_attempted');
		$this->load->view('admin/footer');
	}
	
	public function sparkie_users()
	{
		$this->load->view('admin/admin_header');
		$this->load->view('admin/top_users_sparkie');
		$this->load->view('admin/footer');
	}
	
	public function gradewise_bspi_avg()
	{			
		$data['academic'] = $this->Admin_model->academicyears();
		$startdate = $data['academic'][0]['startdate'];
		$enddate = $data['academic'][0]['enddate'];
		$schoolid = $_POST['schoolid'];
		$data['bspi'] = $this->Admin_model->schoolwisebspi();
	$data['gradewisebspi'] = $this->Admin_model->gradewise_bspi_avg($schoolid,$startdate,$enddate);
	
	$this->load->view('admin/gradewise_bspi_ajax', $data);
		
	}
	
	public function sg_skillscore()
	{
		if($this->session->username=="" || !isset($this->session->username)){redirect('index.php/admin/');}
		$this->load->view('admin/admin_header');
		$this->load->view('admin/school_gradewise_skillscore');
		$this->load->view('admin/footer');
	}
	
		public function skl_gradewise_skillscore()
	{
		$data['academic'] = $this->Admin_model->academicyears();
		$startdate = $data['academic'][0]['startdate'];
		$enddate = $data['academic'][0]['enddate'];
		$skillid = $_POST['val'];
		$data['skilltopper'] = $this->Admin_model->skillwisetopper_memory($skillid,$startdate,$enddate);
		$data['sklgrade_skillscore'] = $this->Admin_model->skl_gradewise_skillscore($skillid,$startdate,$enddate);
		$this->load->view('admin/school_gradewise_skillscore_ajax', $data);
	}
	
	public function gradewise_skillscore()
	{
		if($this->session->username=="" || !isset($this->session->username)){redirect('index.php/admin/');}
		$data['academic'] = $this->Admin_model->academicyears();
		$startdate = $data['academic'][0]['startdate'];
		$enddate = $data['academic'][0]['enddate'];
		$data['getschools_m'] = $this->Admin_model->getschools_chk($startdate,$enddate);
		$this->load->view('admin/admin_header');
		$this->load->view('admin/gradewise_skillscore', $data);
		$this->load->view('admin/footer');
	}
	
	public function gradewise_skill()
	{
		$data['academic'] = $this->Admin_model->academicyears();
		$startdate = $data['academic'][0]['startdate'];
		$enddate = $data['academic'][0]['enddate'];
		$skillid = $_POST['val'];
		$schoolid = $_POST['schoolid'];
		$data['skilltopper'] = $this->Admin_model->skillwisetopper_memory($skillid,$startdate,$enddate);
		$data['gradewise_skillscore'] = $this->Admin_model->gradewise_skillscore($skillid,$schoolid,$startdate,$enddate);
		$this->load->view('admin/gradewise_skillscore_ajax', $data);
	}
	
	public function userupload()
	{	
		$data['schools'] = $this->Admin_model->getschools();
		$data['grades'] = $this->Admin_model->getgrades();
		$this->load->view('admin/admin_header');
		$this->load->view('admin/user_upload', $data);
		$this->load->view('admin/footer');
	
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
		
		
	$data['query1'] = $this->Admin_model->getusercount($data[0]);
	$userexist = $data['query1'][0]['userCount']; 
	
	$password = 'skillangels';
				$hashpass = $this->salt_my_pass($password);
				 
				$shpassword = $hashpass['Hash']; 
				$salt1 = $hashpass['Salt1']; 
				$salt2 = $hashpass['Salt2'];
		
		if($userexist==0)
		{
			$data['import'] = $this->Admin_model->userimport($shpassword,$salt1,$salt2,$data[0],$data[1],$data[2],$data[3],$data[4],$schoolid,$ddlGradeType,$ceationkey);
		}
		else
		{
			$data['import'] = $this->Admin_model->userimport1($shpassword,$salt1,$salt2,$data[0],$data[1],$data[2],$data[3],$data[4],$schoolid,$ddlGradeType,$ceationkey,$userexist);
		}

    }
	
	
	$data['download'] = $this->Admin_model->userdownload($ceationkey);

 foreach($data['download'] as $downloaddata)
 {
	 fputcsv($file,array($downloaddata['fname'],$downloaddata['lname'],$downloaddata['gender'],$downloaddata['dob'],$downloaddata['gradename'],$downloaddata['username'],'skillangels' ));
 }
 
 

    fclose($handle);
	
$data['filename'] = $csvfilename; 
$this->load->view('admin/admin_header');
$this->load->view('admin/user_upload', $data);
$this->load->view('admin/footer');

}
	}
	
	public function toppers()
	{
		$data['school']=$this->Admin_model->GetSchool();
		$data['grade']=$this->Admin_model->GetGrade();
		$data['toppers']=$this->Admin_model->GetClassSparkiesToppers();
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
						$arrresultbspi=$this->Admin_model->GetSchoolWiseToppersBSPI($schoolqry,$gradeqry,$typeids,$monthqry);
						$arrresultsparkies=$this->Admin_model->GetSchoolWiseToppersSparkies($schoolqry1,$gradeqry1,$typeids,$monthqry1);
					}
					else if($hdntype=='BSPI')
					{	$arrresultbspi=$this->Admin_model->GetSchoolWiseToppersBSPI($schoolqry,$gradeqry,$typeids,$monthqry);
					}
					else if($hdntype=='SPARKIES')
					{	$arrresultsparkies=$this->Admin_model->GetSchoolWiseToppersSparkies($schoolqry1,$gradeqry1,$typeids,$monthqry1);
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
					$data['bspi']=$this->Admin_model->GetSchoolWiseToppersBSPI($schoolqry,$gradeqry,$typeids,$monthqry);
					$data['sparkies']=$this->Admin_model->GetSchoolWiseToppersSparkies($schoolqry1,$gradeqry1,$typeids,$monthqry1);
				}
				else if($hdntype=='BSPI')
				{	$data['bspi']=$this->Admin_model->GetSchoolWiseToppersBSPI($schoolqry,$gradeqry,$typeids,$monthqry);
				}
				else if($hdntype=='SPARKIES')
				{	$data['sparkies']=$this->Admin_model->GetSchoolWiseToppersSparkies($schoolqry1,$gradeqry1,$typeids,$monthqry1);
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
		$this->load->view('admin/toppers', $data);
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
}
