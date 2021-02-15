<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {

        
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
				 $this->load->database();
        }
		public function checklogin($username)
        {
			//echo 'select id FROM doctormaster WHERE username="'.$username.'" AND password="'.md5($password).'" AND status=1'; exit;
			$query = $this->db->query('select *,(SELECT language_key FROM language_master WHERE ID=1) as languagekey FROM users a WHERE username="'.$username.'" AND status=1 AND (SELECT school_id FROM school_admin WHERE school_id=a.sid AND active=1)');
			
			//echo $this->db->last_query(); exit;
			return $query->result();
        }
		
	
}