<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kinderangels_model extends CI_Model {

        
     public function __construct()
     {
         // Call the CI_Model constructor
          parent::__construct();
		  $this->load->database();
	      $this->load->library('Multipledb');
     }
  
		
	public function gettotalscore($userid)
    {
		$query = $this->multipledb->kinderangels->query("select sum(game_score) as gamescore,sum(star) as stars from gamedata where gu_id='".$userid."'");
	//	echo $this->multipledb->kinderangels->last_query(); exit;
		return $query->result_array();
    }
	
	public function gettotalcrownies($userid)
    {
		$query = $this->multipledb->kinderangels->query("SELECT sum(Points) as crownies FROM `user_sparkies_history` WHERE   U_ID='".$userid."'");
	//	echo $this->multipledb->kinderangels->last_query(); exit;
		return $query->result_array();
    } 
	
	
	
	public function getasapinfo($userid)
    {
		$query = $this->multipledb->kinderangels->query("SELECT id,fname,lname,gender,email,mobile,dob,avatarimage,startdate,enddate, creation_date,(select classname from class where id=u.grade_id) as grade FROM users u where id=".$this->multipledb->kinderangels->escape($userid)." and u.status=1");		
	  //  echo $this->multipledb->saclp->last_query(); exit;
		return $query->result_array();
    } 
	 		
	public function getchartdetails($userid)
	{
		$query = $this->multipledb->kinderangels->query("SELECT sum(game_score) as gamescore,sum(star) as star, date_format(lastupdate,'%m') as monthnumber,date_format(lastupdate,'%b') as monthname FROM gamedata WHERE gu_id='".$userid."' group by month(lastupdate)");
		return $query->result_array();
	} 
	    
}

 

