<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ka_reports extends CI_Controller {

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
				$this->load->model('kinderangels_model');//echo "hi";exit;
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
	 
	
	
	public function userview()
	{		//error_reporting(E_ALL); 
		//echo "ka";exit;		
		$userid = $this->uri->segment(3);
	//	$data['getusername'] = $this->kinderangels_model->getusername($userid);
		$data['gettotalscore'] = $this->kinderangels_model->gettotalscore($userid); 
		$data['gettotalcrownies'] = $this->kinderangels_model->gettotalcrownies($userid); 
		$data['getmonthlyscore'] = $this->kinderangels_model->getchartdetails($userid); 
		$data['getasapinfo'] = $this->kinderangels_model->getasapinfo($userid);
	
		
		$this->load->view('header');
		$this->load->view('kinderangels/user_viewdetails',$data);
		$this->load->view('footer');
	}
	
	 
}