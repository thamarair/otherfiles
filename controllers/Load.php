<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Load extends CI_Controller {

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
		if (isset($userid))
		{
			date_default_timezone_set($this->session->timezone);
		}
	}
	
	public function loadtest()
	{
		//Check Portal Type
		 	
// ----------------------------------------------------------------------------------------------//
// Login 
		/* $data['query'] = $this->Assessment_model->checkUsernew($this->input->post('email'),$this->input->post('pwd'), $this->input->post('ddlLanguage'));
			 
		if(isset($data['query'][0]->id))
		{ 
			 
			echo "</br></br>";
			echo "Login END";
		
		} */
		
		
		echo "</br></br>";
		echo "Login END";
		
		
		
		
		
		
		
	}
	
}
