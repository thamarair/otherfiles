<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_model extends CI_Model
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
		$this->load->database();
		/*$this->load->library('Multipledb');
		$this->load->library('School1819');
		$this->load->library('Asapo');*/
		$this->load->library('Counterdb');
	} 
	/*
		Counter value update query
	*/
	public function CounterValueUpdate()
	{
		$query = $this->counterdb->db->query('CALL counter_update()');
		//mysqli_next_result($this->Counterdb->db->conn_id);
		//echo $this->db->last_query(); exit;
		//return $query->result();
	}
}
