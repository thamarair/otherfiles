<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	class Counterdb 
	{
	  var $db = NULL;
	  function __construct()
	  {
		$CI = &get_instance();
		$this->db = $CI->load->database('db6', TRUE);  
	  }
	}
?>