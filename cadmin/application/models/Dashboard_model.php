<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

        
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
				 $this->load->database();
				 $this->load->library('Multipledb');
        }

		public function checklogin($username,$password)
        {
					 
			$query = $this->db->query("SELECT *  FROM academic_center_master WHERE (username='".$username."' AND password='".$password."') and status=1");		
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }	
		
		public function doctorinfo($doctorid)
        {
					 
			$query = $this->db->query("SELECT * FROM academic_center_master WHERE id='".$doctorid."' and status=1");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		
		public function totalrec_userlist()
        {
			$query = $this->db->query("SELECT count(*) as totalrecord FROM users u where academic_center_id='".$this->session->centerid."'");		
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}

		public function userslist($start,$limit)
        {
			$qry=' ';
			if($limit=='')
			{
				$qry=" ";
			}
			else if($start=='' && $limit!=''){
				$qry=" limit ".$limit;
			}
			else if($start!='' && $limit!=''){
				$qry=" limit ".$start.','.$limit;
			}
					 
			$query = $this->db->query("SELECT id,fname,username,email,mobile,address,dob,avatarimage,creation_date,status,father,mother,(select classname from class where id=u.grade_id) as grade  FROM users u where academic_center_id='".$this->session->centerid."' order by creation_date desc ".$qry."");		
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		
		public function getusername($userid)
        {
					 
			$query = $this->db->query("SELECT id,username,gp_id,grade_id,startdate,enddate  FROM users where id='".$userid."'");		
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		
		public function getasapinfo($userid)
        {
					 
			$query = $this->db->query("SELECT id,fname,lname,gender,email,mobile,dob,address,avatarimage,startdate,enddate,father,(select classname from class where id=u.grade_id) as grade FROM users u where id='".$userid."'");		
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		
		public function getuserid($uname)
        {
					 
			$query = $this->multipledb->db->query("SELECT id  FROM users where username='".$uname."'");		
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }

		
		
		public function userscount($centerid)
        {
			$query = $this->db->query("SELECT count(*) as total FROM users  WHERE  academic_center_id='".$centerid."' and status=1 and isdemo=0 and isapp='Y'");		
		//	echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		
		public function userscount_sc($centerid)
        {
			$query = $this->multipledb->summercampdb->query("SELECT count(*) as total FROM users  WHERE  academic_center_id='".$centerid."' and status=1");		
		//	echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		

		
		public function datewiseusers($centerid)
        {
			
			$query = $this->db->query("SELECT count(*) as users, DATE_FORMAT(creation_date, '%d-%m-%Y') as creation_date FROM users WHERE academic_center_id='".$centerid."' and status=1 group by creation_date");		
		//	echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function gradewiseusers($centerid)
        {
			
			$query = $this->db->query("SELECT count(*) as usercount, REPLACE (classname, 'Grade', '') as grade,sorting_order  FROM users u JOIN class c ON u.grade_id=c.id  WHERE  academic_center_id='".$centerid."' and u.status=1 and u.visible=1 and u.isdemo=0 and u.isapp='Y' group by `grade_id` order by sorting_order");
		//	echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function gradewiseusers_sc($centerid)
        {
			
			$query = $this->multipledb->summercampdb->query("SELECT count(*) as usercount, REPLACE (classname, 'Grade', '') as grade,sorting_order  FROM users u JOIN class c ON u.grade_id=c.id  WHERE  academic_center_id='".$centerid."' and u.status=1 and u.visible=1 group by `grade_id` order by sorting_order");
		//	echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function userdetails_sc($centerid)
        {
			
			//$query = $this->multipledb->summercampdb->query("SELECT u.id,u.fname,username,u.creation_date,startdate, REPLACE (classname, 'Grade', '') as grade,sorting_order  FROM users u JOIN class c ON u.grade_id=c.id  WHERE  academic_center_id='".$centerid."' and u.status=1 and u.visible=1 order by creation_date DESC");
			
			$query = $this->multipledb->summercampdb->query("SELECT u.id,u.fname,username,u.creation_date,startdate, REPLACE (classname, 'Grade', '') as grade,sorting_order, (select count(DISTINCT lastupdate) from game_reports where gu_id=u.id and lastupdate between u.startdate and u.enddate) as totaldays,  ROUND(s1.skillscore_M, 2) as skillscorem, ROUND(skillscore_V, 2) as skillscorev,ROUND(skillscore_F, 2) as skillscoref,ROUND(skillscore_P, 2) as skillscorep,ROUND(skillscore_L, 2) as skillscorel, ROUND(a3.finalscore, 2) as avgbspiset1  FROM users u JOIN class c ON u.grade_id=c.id  
			
			left join (SELECT SUM(score)/5 as finalscore,count(gu_id) as playedcount, gu_id, (SELECT sid from users where id=gu_id) as schoolid from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id) a3 on a3.gu_id=u.id 
			left join (select (AVG(score)) as skillscore_M, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =59 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s1 on s1.gu_id=u.id 
			left join (select (AVG(score)) as skillscore_V, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =60 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s2 on s2.gu_id=u.id 
			left join (select (AVG(score)) as skillscore_F, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =61 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s3 on s3.gu_id=u.id 
			left join (select (AVG(score)) as skillscore_P, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =62 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s4 on s4.gu_id=u.id 
			left join (select (AVG(score)) as skillscore_L, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =63 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s5 on s5.gu_id=u.id
			
			WHERE  academic_center_id='".$centerid."' and u.status=1 and u.visible=1 order by creation_date DESC");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function IsCLPEnable_sc($userid)
	{
		$query = $query = $this->multipledb->summercampdb->query('select count(id) as playedstatus from game_reports where gu_id="'.$userid.'" and gs_id in(59,60,61,62,63)');
		return $query->result_array();
	}
		
		public function scanstatus($doctorid)
        {
					 
			$query = $this->db->query("SELECT COUNT(qrcode) as scancount from couponmaster where doctorid='".$doctorid."' and status=1");		
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		
	
		public function couponcodecount($doctorid)
        {
			$query = $this->db->query("SELECT count(*) as totalcoupon FROM couponmaster  WHERE doctorid='".$doctorid."' and usedstatus='N'");		
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		
		public function couponlist($doctorid)
        {
			$query = $this->db->query("SELECT *  FROM couponmaster  WHERE doctorid='".$doctorid."' ");		
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		

		public function getstate()
        {
			$query = $this->db->query("SELECT id, state_name FROM state  WHERE countryid=113");		
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }	
		
		public function gethospital()
        {
			$query = $this->db->query("SELECT id, hospitalname FROM hospitalmaster  WHERE status=1");		
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }	
		
		public function editdoctor($doctorid)
        {
			$query = $this->db->query("SELECT *,(select state_name from state where id=d.state) as statename,(select hospitalname from hospitalmaster where id=d.hospitalid) as hospitalname1 FROM doctormaster d WHERE d.id='".$doctorid."'");		
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }	
		
		public function updatedoctor($doctorname,$lname,$gender,$dob,$emailid,$secondaryemailid,$mobile,$secondarymobile,$state,$city,$address,$doctorid,$imgpath,$hospitalname)
        {
			if($imgpath!='')
			{
				$query = $this->db->query("UPDATE `doctormaster` SET `doctorname`='".$doctorname."',`lastname`='".$lname."',`gender`='".$gender."',`dateofbirth`='".$dob."',`email`='".$emailid."',`secondaryemail`='".$secondaryemailid."',`state`='".$state."',`city`='".$city."',`mobilenumber`='".$mobile."',`secondarymobilenumber`='".$secondarymobile."',`address`='".$address."',`profileimage`='".$imgpath."',`modifed_on`=NOW(),hospitalname='".$hospitalname."' WHERE id='".$doctorid."'");
			}
			else
			{
				$query = $this->db->query("UPDATE `doctormaster` SET `doctorname`='".$doctorname."',`lastname`='".$lname."',`gender`='".$gender."',`dateofbirth`='".$dob."',`email`='".$emailid."',`secondaryemail`='".$secondaryemailid."',`state`='".$state."',`city`='".$city."',`mobilenumber`='".$mobile."',`secondarymobilenumber`='".$secondarymobile."',`address`='".$address."',`modifed_on`=NOW(),hospitalname='".$hospitalname."' WHERE id='".$doctorid."'");
			}
		//	echo $this->db->last_query(); exit;
			
        }

		 public function getskillwise_avg($uname) 
		{
			
			$query = $this->multipledb->db->query('select id, fname,s1.skillscore_M as skillscorem, skillscore_V as skillscorev,skillscore_F as skillscoref,skillscore_P as skillscorep,skillscore_L as skillscorel, a3.finalscore as avgbspiset1 from users mu

left join 
 (SELECT SUM(score)/5 as finalscore, gu_id, (SELECT sid from users where id=gu_id) as schoolid from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id) a3   on a3.gu_id=mu.id 
 
 left join
(select (AVG(score)) as skillscore_M, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =59 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s1 on s1.gu_id=mu.id 

left join
(select (AVG(score)) as skillscore_V, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =60 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s2 on s2.gu_id=mu.id 

left join
(select (AVG(score)) as skillscore_F, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =61 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s3 on s3.gu_id=mu.id 

left join
(select (AVG(score)) as skillscore_P, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =62 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s4 on s4.gu_id=mu.id 

left join
(select (AVG(score)) as skillscore_L, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =63 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s5 on s5.gu_id=mu.id 
 
 

 where username="'.$uname.'" ORDER BY avgbspiset1 DESC');
			//echo $this->multipledb->db->last_query(); exit;
			return $query->result_array();
			
		}
		
		public function asap_reports($centerid) 
		{
			
			$query = $this->multipledb->db->query('select id, fname,lname,username,mobile,father,mother,  s1.skillscore_M as skillscorem, skillscore_V as skillscorev,skillscore_F as skillscoref,skillscore_P as skillscorep,skillscore_L as skillscorel, a3.finalscore as avgbspiset1,COALESCE(a3.playedcount,0) as playcount from users mu

left join 
 (SELECT SUM(score)/5 as finalscore, count(gu_id) as playedcount, gu_id, (SELECT sid from users where id=gu_id) as schoolid from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id) a3   on a3.gu_id=mu.id 
 
 left join
(select (AVG(score)) as skillscore_M, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =59 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s1 on s1.gu_id=mu.id 

left join
(select (AVG(score)) as skillscore_V, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =60 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s2 on s2.gu_id=mu.id 

left join
(select (AVG(score)) as skillscore_F, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =61 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s3 on s3.gu_id=mu.id 

left join
(select (AVG(score)) as skillscore_P, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =62 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s4 on s4.gu_id=mu.id 

left join
(select (AVG(score)) as skillscore_L, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =63 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s5 on s5.gu_id=mu.id 
 
 

 where academic_center_id="'.$centerid.'" and mu.status=1');
			//echo $this->multipledb->db->last_query(); exit;
			return $query->result_array();
			
		}
		
		public function getbspireport1($userid,$mnths)
		 {
	
		$query = $this->db->query("SELECT (".$this->config->item('skilllogic')."(`game_score`)) as gamescore,gs_id , lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id='".$userid."' and DATE_FORMAT(lastupdate,'%b-%Y') in ('".$mnths."') and  lastupdate between (select startdate from users where id='".$userid."') and (select enddate from users where id='".$userid."') group by gs_id , lastupdate");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }
		
		public function clp_reports($centerid)		 
		{
			$query = $this->db->query("select id,fname,lname,username,gp_id,section,grade_id,creation_date,(select classname from class where id=grade_id order by id asc) as grade,academic_center_id,(select centername from academic_center_master where id=academic_center_id) as centername,(select MAX(session_id) as play from game_reports where gu_id=a1.id) as playcount,(select name from cycle_master where (playcount between range_start and range_end) and status=1) as cyclename,
			
	(select game_score from asap_game_reports where gs_id=59 and asap_id=24 and gu_id=a1.id) as me24,
	(select game_score from asap_game_reports where gs_id=60 and asap_id=24 and gu_id=a1.id) as vp24,
	(select game_score from asap_game_reports where gs_id=61 and asap_id=24 and gu_id=a1.id) as fa24,
	(select game_score from asap_game_reports where gs_id=62 and asap_id=24 and gu_id=a1.id) as ps24,
	(select game_score from asap_game_reports where gs_id=63 and asap_id=24 and gu_id=a1.id) as li24,
	
	(select game_score from asap_game_reports where gs_id=59 and asap_id=48 and gu_id=a1.id) as me48,
	(select game_score from asap_game_reports where gs_id=60 and asap_id=48 and gu_id=a1.id) as vp48,
	(select game_score from asap_game_reports where gs_id=61 and asap_id=48 and gu_id=a1.id) as fa48,
	(select game_score from asap_game_reports where gs_id=62 and asap_id=48 and gu_id=a1.id) as ps48,
	(select game_score from asap_game_reports where gs_id=63 and asap_id=48 and gu_id=a1.id) as li48,
	
	(select CONVERT(CONCAT(avg(game_score),',',avg(game_score1)),CHAR(100)) from (select AVG(game_score)as game_score,MAX(game_score)as game_score1,lastupdate,gu_id from game_reports where gs_id=59 and session_id BETWEEN 1 and 8  group by lastupdate,gu_id ) s1  where gu_id=a1.id) as skillscorem,
	
	(select CONVERT(CONCAT(avg(game_score),',',avg(game_score1)),CHAR(100)) from (select AVG(game_score)as game_score,MAX(game_score)as game_score1,lastupdate,gu_id from game_reports where gs_id=60 and session_id BETWEEN 1 and 8 group by lastupdate,gu_id )s2  where gu_id=a1.id) as skillscorev,
	
	(select CONVERT(CONCAT(avg(game_score),',',avg(game_score1)),CHAR(100)) from (select AVG(game_score)as game_score,MAX(game_score)as game_score1,lastupdate,gu_id from game_reports where gs_id=61 and session_id BETWEEN 1 and 8 group by lastupdate,gu_id )s3  where gu_id=a1.id) as skillscoref,
	
	(select CONVERT(CONCAT(avg(game_score),',',avg(game_score1)),CHAR(100)) from (select AVG(game_score)as game_score,MAX(game_score)as game_score1,lastupdate,gu_id from game_reports where gs_id=62 and session_id BETWEEN 1 and 8 group by lastupdate,gu_id )s4  where gu_id=a1.id) as skillscorep,
	
	(select CONVERT(CONCAT(avg(game_score),',',avg(game_score1)),CHAR(100)) from (select AVG(game_score)as game_score,MAX(game_score)as game_score1,lastupdate,gu_id from  game_reports where gs_id=63 and session_id BETWEEN 1 and 8 group by lastupdate,gu_id )s5  where gu_id=a1.id) as skillscorel,
	
	(select count(lastupdate) from (select lastupdate,gu_id from  game_reports group by lastupdate,gu_id) s1 where lastupdate between a1.startdate and a1.enddate and gu_id=a1.id) as AttendedSession,
	
	(select SUM(CASE WHEN game>=5 THEN 1 ELSE 0 END) as completedsession from (select sum(gamesplayed) as game,gu_id,lastupdate from (select lastupdate,count(DISTINCT gs_id) as gamesplayed,gu_id from  game_reports  group by gu_id,gs_id,lastupdate) a3 group by gu_id,lastupdate) s1 where lastupdate between a1.startdate and a1.enddate and  gu_id=a1.id) as CompletedSession	
	
	
	from (select id,fname,lname,username,gp_id,section,grade_id,creation_date,academic_center_id,startdate,enddate from users where academic_center_id='".$centerid."' and status=1 and visible=1 and isdemo=0 and isapp='Y' ) a1");
 
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		 public function getbspicomparison($userid)		 
		{
			$query = $this->multipledb->db->query('select id, fname, a3.finalscore as avgbspiset1 from users mu

left join 
 (SELECT SUM(score)/5 as finalscore, gu_id, (SELECT sid from users where id=gu_id) as schoolid from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id =  "'.$userid.'" group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id) a3   on a3.gu_id=mu.id 
 where id = "'.$userid.'" ORDER BY avgbspiset1 DESC');
 
			//echo $this->multipledb->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function getMonthWiseSkillScore($uid,$startdate,$enddate)
	{
		$query = $query = $this->db->query("select gs_id,(CASE WHEN gs_id=59 THEN 'MEMORY'
WHEN gs_id=60 THEN 'VP'
WHEN gs_id=61 THEN 'FA'
WHEN gs_id=62 THEN 'PS'
WHEN gs_id=63 THEN 'LI' else 0
END) as skillname,playedMonth,monthName,AVG(gamescore) as gamescore from (SELECT (AVG(game_score)) as gamescore ,gs_id , lastupdate,gu_id,DATE_FORMAT(lastupdate,'%m') as playedMonth,DATE_FORMAT(lastupdate, '%b') as monthName FROM game_reports WHERE gs_id in (59,60,61,62,63)and gu_id=".$uid." and lastupdate between '".$startdate."' and '".$enddate."' group by gs_id,lastupdate) a1 group by gs_id,playedMonth");
//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
		
		public function clpbspi($userid)		 
		{
			$query = $this->db->query('select id, fname, a3.finalscore as avgbspiset1,(select MAX(session_id) as play from game_reports where gu_id=mu.id) as playcount,(select name from cycle_master where (playcount between range_start and range_end) and status=1) as cyclename from users mu

left join 
 (SELECT SUM(score)/5 as finalscore, gu_id, (SELECT sid from users where id=gu_id) as schoolid from (select (AVG(score)) as score, gu_id, gs_id from (SELECT ('.$this->config->item('skilllogic').'(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id =  "'.$userid.'" and session_id BETWEEN 1 and 8 group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id) a3   on a3.gu_id=mu.id 
 where id = "'.$userid.'" ORDER BY avgbspiset1 DESC');
 
			//echo $this->multipledb->db->last_query(); exit;
			return $query->result_array();
		}
		
		
		public function getcounters($userid)		 
		{
			$query = $this->db->query("SELECT ROUND((SUM(gtime)/60),0) as gtime_school_count , SUM(answer) as answer_school_count, SUM(attempt_question) as attempted_question_count FROM game_reports gr join users u on gr.gu_id=u.id
		WHERE gtime IS NOT NULL AND answer IS NOT NULL and u.id='".$userid."' and u.status=1  and lastupdate between (select startdate from users where id='".$userid."') and (select enddate from users where id='".$userid."')");
 
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function getcounters_sc($userid)		 
		{
			$query = $this->multipledb->summercampdb->query("SELECT ROUND((SUM(gtime)/60),0) as MinutesTrained , SUM(answer) as PuzzlesSolved, SUM(attempt_question) as PuzzlesAttempted,count(g_id) as UniqueGames  FROM game_reports gr join users u on gr.gu_id=u.id	WHERE gtime IS NOT NULL AND answer IS NOT NULL and u.id='".$userid."' and u.status=1 and lastupdate between (select startdate from users where id='".$userid."') and (select enddate from users where id='".$userid."')");
 
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function getcrowny($userid)		 
		{
			$query = $this->db->query("select points from vi_sumofcrownypoints where U_ID='".$userid."' ");
 
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function getcrowny_sc($userid)		 
		{
			$query = $this->multipledb->summercampdb->query("select points from vi_sumofcrownypoints where U_ID='".$userid."' ");
 
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function getbspi_sc($userid)		 
		{
			$query = $this->multipledb->summercampdb->query("select finalscore as bspi from vii_avguserbspiscore where gu_id='".$userid."' ");
 
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function getuserinfo_sc($userid)
        {
					 
			$query = $this->multipledb->summercampdb->query("SELECT id,fname,username,gender,email,mobile,startdate,enddate,creation_date,(select classname from class where id=u.grade_id) as grade FROM users u where id='".$userid."' and status=1");		
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		
		public function getplayeddates($userid)
	{
		$query = $this->multipledb->summercampdb->query("Select lastupdate as `date`,1 as badge from gamedata where gu_id='".$userid."' group by lastupdate");
	//	echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getTrainingCalendarData($userid,$curdate)
	{
		$query = $this->multipledb->summercampdb->query("SELECT ROUND((SUM(gtime)/60),0) as MinutesTrained  , SUM(answer) as PuzzlesSolved, SUM(attempt_question) as PuzzlesAttempted,(select SUM(Points) from user_sparkies_history where U_ID='".$userid."' and date(Datetime)='".$curdate."') as Crownies FROM game_reports gr join users u on gr.gu_id=u.id	WHERE gtime IS NOT NULL AND answer IS NOT NULL and u.id='".$userid."' and lastupdate between (select startdate from users where id='".$userid."') and (select enddate from users where id='".$userid."') and lastupdate='".$curdate."' ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getonedaybspi($userid,$curdate)
	{
		$query = $this->multipledb->summercampdb->query("SELECT ROUND(SUM(avgskillscore)/5, 2) as BSPI from (select AVG(game_score) as avgskillscore, gs_id FROM game_reports  where gu_id='".$userid."' and lastupdate='".$curdate."' group by gs_id) a1");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function datewisebspi_sc($userid,$startdate,$enddate)
	{
		$query = $this->multipledb->summercampdb->query("SELECT ROUND(SUM(avgskillscore)/5, 2) as BSPI, DATE_FORMAT(lastupdate, '%d-%m-%Y') as Playeddate from (select AVG(game_score) as avgskillscore, lastupdate, gs_id FROM game_reports  where gu_id='".$userid."' and lastupdate BETWEEN '".$startdate."' and '".$enddate."' group by gs_id, lastupdate) a1 group by lastupdate");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	 public function overallskillscore_sc($userid,$startdate,$enddate)
		 {
			$query = $this->multipledb->summercampdb->query("select AVG(gamescore) as skillscore,gs_id from (SELECT (AVG(game_score)) as gamescore ,gs_id , lastupdate  FROM game_reports WHERE gs_id in (59,60,61,62,63) and gu_id='".$userid."' and  lastupdate between '".$startdate."' and '".$enddate."' group by gs_id,lastupdate) a1 group by gs_id");
			//echo $this->multipledb->summercampdb->last_query(); exit;
			return $query->result_array();
								
		 }
	
	
	
	public function getonedayskillscore($userid,$curdate)
	{
		$query = $this->multipledb->summercampdb->query("SELECT id, s1.mem as memory,s2.vp as visual, s3.fa as focus, s4.ps as problem,s5.lin as ling from users mu left join 

		(select AVG(game_score) as mem, gu_id FROM game_reports  where gu_id='".$userid."' and lastupdate='".$curdate."' and gs_id=59)s1 ON s1.gu_id=mu.id

		left join (select AVG(game_score) as vp, gu_id FROM game_reports  where gu_id='".$userid."' and lastupdate='".$curdate."' and gs_id=60)s2 ON s2.gu_id=mu.id

		left join (select AVG(game_score) as fa, gu_id FROM game_reports  where gu_id='".$userid."' and lastupdate='".$curdate."' and gs_id=61)s3 ON s3.gu_id=mu.id

		left join (select AVG(game_score) as ps, gu_id FROM game_reports  where gu_id='".$userid."' and lastupdate='".$curdate."' and gs_id=62)s4 ON s4.gu_id=mu.id

		left join (select AVG(game_score) as lin, gu_id FROM game_reports  where gu_id='".$userid."' and lastupdate='".$curdate."' and gs_id=63)s5 ON s5.gu_id=mu.id where mu.id='".$userid."' and mu.status=1 ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
		
		/* public function my_percentilerank($userid,$centerid)		 
		{
			if($centerid!=''){$gwhere="org_id=".$centerid;}else{$gwhere="1=1";}
		
		$query = $this->multipledb->summercampdb->query("select 
		(select count(gu_id) from  vii_avguserbspiscore where grade_id=(select grade_id from users where id='".$userid."') and ".$gwhere.") as totusercount,
		(select finalscore from  vii_avguserbspiscore where gu_id=".$userid." and grade_id=(select grade_id from users where id='".$userid."') and ".$gwhere." ) as Mytotscore,
		(select count(gu_id) from  vii_avguserbspiscore where finalscore < Mytotscore and gu_id!=".$userid." and grade_id=(select grade_id from users where id='".$userid."') and ".$gwhere.") as belowusercount,
		(select count(gu_id) from  vii_avguserbspiscore where finalscore=Mytotscore and grade_id=(select grade_id from users where id='".$userid."') and ".$gwhere.") as samescoreusercount");
 
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		} */
		
		public function getattemptsession($userid)		 
		{
			$query = $this->db->query("select gu_id,count(Completed) as attempt from (select gu_id,gs_id,count(gs_id) Completed from (SELECT count(gr.id) as PalyCount,DATE_FORMAT(`lastupdate`,'%m') as monthlist ,lastupdate,gs_id,gu_id from game_reports gr join users u on u.id = gr.gu_id join user_academic_mapping um on u.id=um.id where gu_id='".$userid."' and date(lastupdate) between (select startdate from users where id='".$userid."') and (select enddate from users where id='".$userid."') group by date(lastupdate),DATE_FORMAT(`lastupdate`,'%m'),gu_id,gs_id order by date(lastupdate))a2 group by gu_id,lastupdate)a2 ");
 
		//	echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function getcompsession($userid)		 
		{
			$query = $this->db->query("select gu_id,count(Completed) as comp from (select gu_id,gs_id,count(gs_id) Completed from (SELECT count(gr.id) as PalyCount,DATE_FORMAT(`lastupdate`,'%m') as monthlist ,lastupdate,gs_id,gu_id from game_reports gr join users u on u.id = gr.gu_id join user_academic_mapping um on u.id=um.id where gu_id='".$userid."' and date(lastupdate) between (select startdate from users where id='".$userid."') and (select enddate from users where id='".$userid."') group by date(lastupdate),DATE_FORMAT(`lastupdate`,'%m'),gu_id,gs_id order by date(lastupdate))a2 group by gu_id,lastupdate)a2 where Completed>=5");
 
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function get_clp_skillwise_avg($userid)		 
		{
			$query = $this->db->query("select id, fname, s1.skillscore_M as skillscorem, skillscore_V as skillscorev,skillscore_F as skillscoref,skillscore_P as skillscorep,skillscore_L as skillscorel, a3.finalscore as avgbspiset1 from users mu 
left join (SELECT SUM(score)/5 as finalscore, gu_id, (SELECT sid from users where id=gu_id) as schoolid from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id='".$userid."' and session_id BETWEEN 1 and 8 group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id) a3 on a3.gu_id=mu.id 
left join (select (AVG(score)) as skillscore_M, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =59 and gu_id='".$userid."' and session_id BETWEEN 1 and 8 group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s1 on s1.gu_id=mu.id 
left join (select (AVG(score)) as skillscore_V, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =60 and gu_id='".$userid."' and session_id BETWEEN 1 and 8 group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s2 on s2.gu_id=mu.id 
left join (select (AVG(score)) as skillscore_F, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =61 and gu_id='".$userid."' and session_id BETWEEN 1 and 8 group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s3 on s3.gu_id=mu.id 
left join (select (AVG(score)) as skillscore_P, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =62 and gu_id='".$userid."' and session_id BETWEEN 1 and 8 group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s4 on s4.gu_id=mu.id 
left join (select (AVG(score)) as skillscore_L, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =63 and gu_id='".$userid."' and session_id BETWEEN 1 and 8 group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s5 on s5.gu_id=mu.id 

 where id='".$userid."' ORDER BY avgbspiset1 DESC");
 
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		
	
		public function getpatienttype()		 
		{
			$query = $this->db->query("SELECT id,type from  patient_type_master where status=1");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function updatepatienttype($userid,$typeid)		 
		{
			$query = $this->db->query("UPDATE users SET patient_type='".$typeid."' where id='".$userid."' ");
			//echo $this->db->last_query(); exit;
			//return $query->result_array();
		}
		
		public function getacademicmonths($startdate,$enddate)
		 { //echo ;exit;
			 
		$query = $this->db->query("select DATE_FORMAT(m1, '%m') as monthNumber,DATE_FORMAT(m1, '%Y') as yearNumber,DATE_FORMAT(m1, '%b') as monthName from (select ('".$startdate."' - INTERVAL DAYOFMONTH('".$startdate."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from(select 1 union select 2 union select 3 union select 4) t1,(select 1 union select 2 union select 3 union select 4) t2,(select 1 union select 2 union select 3 union select 4) t3,(select 1 union select 2 union select 3 union select 4) t4,(select @rownum:=-1) t0) d1) d2 where m1<='".$enddate."' order by m1");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }
		 
		 public function IsAsapEnable($username)
	{
		$query = $query = $this->multipledb->db->query('select count(id) as playedstatus from game_reports where gu_id=(select id from users where username="'.$username.'" and status=1) and gs_id in(59,60,61,62,63)');
		//echo $this->multipledb->db->last_query(); exit;
		return $query->result_array();
	}
		public function IsCLPEnable($uid)
	{
		$query = $query = $this->db->query('select count(id) as playedstatus from game_reports where gu_id="'.$uid.'" and gs_id in(59,60,61,62,63)');
		return $query->result_array();
	}
	
		 
public function getUserEfficiencyGraph($userid,$startdate,$enddate)
{
	$query = $this->db->query("
	select round((sum(score)/5),2) as score,playeddate as rtime,monthNumber,yearNumber from (select avg(score) as score,sum(playeddate) as playeddate,DATE_FORMAT(lastupdate, '%m') as monthNumber,DATE_FORMAT(lastupdate, '%Y') as yearNumber from ( SELECT (".$this->config->item('skilllogic')."(`game_score`)) as score,count(distinct lastupdate) as playeddate,gs_id,lastupdate,gu_id FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id='".$userid."' and (lastupdate between '".$startdate."' and '".$enddate."') group by gs_id,lastupdate) a1 group by gs_id,month(lastupdate))a2 group by monthNumber");
	//echo $this->db->last_query(); exit;
	return $query->result_array();
}


	public function mybspicalendar($school_id,$uid,$dateQry,$startdate,$enddate)
	{
	 $query = $this->db->query('select (sum(a.game_score)/5) as game_score, lastupdate,playedDate from(SELECT '.$this->config->item('skilllogic').'(gr.game_score) as game_score,count(*) as cnt, lastupdate,DATE_FORMAT(`lastupdate`,"%d") as playedDate FROM game_reports gr join category_skills sk join users u WHERE gr.gu_id = u.id and u.sid =2 and gr.gu_id='.$uid.' and sk.id = gr.gs_id and gr.gs_id in (SELECT id FROM category_skills where category_id=1) and  lastupdate between "'.$startdate.'" and "'.$enddate.'" AND DATE_FORMAT(lastupdate, "%Y-%m")=\''.$dateQry.'\' group by lastupdate, gr.gs_id, gr.gu_id order by gr.gs_id) a group by lastupdate');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
						
	}
	public function mySkillCalendar($school_id,$uid,$dateQry,$startdate,$enddate)
	{
	 $query = $this->db->query('SELECT gs_id,avg(gr.game_score) as game_score,count(*) as cnt, lastupdate,DATE_FORMAT(`lastupdate`,"%d") as playedDate FROM game_reports gr join category_skills sk join users u WHERE gr.gu_id = u.id and u.sid =2 and gr.gu_id='.$uid.' and sk.id = gr.gs_id and gr.gs_id in (SELECT id FROM category_skills where category_id=1) and  lastupdate between "'.$startdate.'" and "'.$enddate.'" AND DATE_FORMAT(lastupdate, "%Y-%m")=\''.$dateQry.'\' group by lastupdate, gr.gs_id, gr.gu_id order by lastupdate asc');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getgamedetails($userid,$gameid,$pid,$startdate,$enddate)
	{
		$query = $this->db->query("select g_id, avg(game_score) as game_score,DATE_FORMAT(lastupdate, '%d-%m-%Y') as lastupdate from game_reports where gp_id = '".$pid."' and gu_id='".$userid."' and g_id='".$gameid."' AND (lastupdate between '".$startdate."' and '".$enddate."') group by lastupdate  ORDER BY lastupdate DESC LIMIT 10");
		//echo $this->db->last_query(); 
		return $query->result_array();
	}
		   
		public function getScannedCoupon($doctorid)
	{  
		$query = $this->db->query("SELECT qrcode,date(qr_scanned_date_time) as scandate,status as ldata,usedstatus FROM couponmaster WHERE doctorid=".$doctorid." ORDER BY qr_scanned_date_time DESC");
			return $query->result_array();
	}
	
	public function getgamenames($userid,$pid,$startdate,$enddate)
	{
	 
	$query=$this->db->query("SELECT a.gid,a.gname FROM  games a, game_reports b where a.gid=b.g_id and b.gu_id='".$userid."' and b.gp_id = '".$pid."'  and a.gc_id = 1 and (lastupdate between '".$startdate."' and '".$enddate."') group by a.gid");
	//echo $this->db->last_query(); exit;
	return $query->result();
	}
	
	
	public function checkdoctormailidexist($emailid)
	{
				 
		$query = $this->db->query('select id,count(email) as emailcount,doctorname,lastname,email,username,mobilenumber from doctormaster where email ="'.$emailid.'" and status=1');		
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function resetpwdlog($userid,$randid)
	{	
		$qry=$this->db->query("insert into doctor_password_history(doctorid,randid,requestdatetime,status)values('".$userid."','".$randid."',NOW(),0)");
	}
	function CheckValidActivationlink($userid,$randid)
	{
		$query=$this->db->query("select doctorid as userid,randid,requestdatetime from doctor_password_history where status=0 and md5(doctorid)='".$userid."' and md5(randid)='".$randid."'");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function getResetpwdDoctorDetails($userid)
	{	
		$query = $this->db->query('select id,doctorname,lastname,email,username,mobilenumber from doctormaster where id="'.$userid.'" and status=1');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	function UpdateNewPwd($pwd,$userid,$salt1,$salt2,$orgpwd)
	{
		$qry=$this->db->query("update doctormaster set password='".$pwd."',orgpwd='".$orgpwd."' where md5(id)='".$userid."'");
	}
	function UpdateNewPwd_log($userid,$randid,$orgpwd,$ip)
	{
		$qry=$this->db->query("update doctor_password_history set processdatetime=now(),status=1,update_password='".$orgpwd."',ip='".$ip."' where md5(doctorid)='".$userid."' and md5(randid)='".$randid."'");
	}
	
	public function insert_login_log($centerid,$sessionid,$ip,$country,$region,$city,$isp,$browser,$status)
		{
			$query = $this->db->query('INSERT INTO 	center_login_log(	centerid,sessionid,created_date,lastupdate,logout_date,ip,country,region,city,browser,isp,status)VALUES("'.$centerid.'","'.$sessionid.'",now(),now(),now(), "'.$ip.'","'.$country.'","'.$region.'","'.$city.'","'.$browser.'","'.$isp.'","'.$status.'")');
			//echo $this->db->last_query(); exit;
			return $query;
			
		}
		
		public function update_login_log($centerid,$sessionid)
		{
			$query = $this->db->query('update center_login_log set lastupdate=now() where centerid="'.$centerid.'" and sessionid="'.$sessionid.'"');
			return $query;
			
		}
		
		public function update_logout_log($centerid,$sessionid)
		{
			$query = $this->db->query('update center_login_log set lastupdate=now(),logout_date=now() where centerid="'.$centerid.'" and sessionid="'.$sessionid.'"');
			return $query;
			
		}
		
		public function updatepwd($centerid,$pwd)
		{
			$query = $this->db->query('update academic_center_master set password="'.md5($pwd).'",orgpwd="'.$pwd.'",modifed_on=now() where id="'.$centerid.'"');
			return $query;
		}
		
		public function adminresetpwdlog($randid,$pwd,$centerid)
	{	
		$qry=$this->db->query("insert into  academy_admin_password_history(centerid,randid,requestdatetime,update_password,ip,status)values('".$centerid."','".$randid."',NOW(),'".$pwd."','".$this->input->ip_address()."',0)");
	}
	
	public function getproductlist()
		{
			$query = $this->db->query('SELECT `id`, `product_name`, `product_code`, `status` FROM `product_master` WHERE status=1 and isdemo=0');
			return $query->result_array();
			
		}
	
	public function getgrades()
	{	
		$query = $this->multipledb->summercampdb->query('SELECT `id`, `classname`, `sorting_order` FROM `class` WHERE status=0 ORDER BY sorting_order');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getenddate($enddate)
	{	
		$query = $this->multipledb->summercampdb->query('SELECT DATE_ADD("'.$enddate.'", INTERVAL (select value from config_master where code="VALIDDAYS" and status="Y") DAY) as enddate');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getplanid($grade)
	{	
		$query = $this->multipledb->summercampdb->query('SELECT id,(select value from config_master where code="VALIDDAYS" and status="Y") as validity from g_plans where grade_id="'.$grade.'"');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getvalidity()
	{	
		$query = $this->multipledb->summercampdb->query('select value from config_master where code="VALIDDAYS" and status="Y"');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function adduser($centerid,$name,$grade,$gender,$username,$mobile,$emailid,$startdate,$enddate,$salt1,$salt2,$password,$planid)
	{	
	
		$qry=$this->multipledb->summercampdb->query("INSERT INTO `users`( `deviceid`, `rollno`, `email`, `salt1`, `password`, `salt2`, `fname`, `lname`, `gender`, `mobile`, `dob`, `status`, `visible`, `gp_id`, `glevel`, `grade_id`, `sname`, `father`, `mother`, `address`, `username`, `initial`, `sid`, `section`, `academicyear`, `createdby`, `login_count`, `login_date`, `pre_logindate`, `creation_date`, `modifiedby`, `modified_date`, `avatarimage`, `agreetermsandservice`, `creationkey`, `usertheme`, `session_id`, `islogin`, `last_active_datetime`, `school_name`, `referedby`, `startdate`, `enddate`, `org_pwd`, `academic_center_id`, `isdemo`) VALUES ('','','".$emailid."','".$salt1."','".$password."','".$salt2."','".$name."','','".$gender."','".$mobile."','',1,1,'".$planid."','','".$grade."','','','','','".$username."','',2,'A',20,'',0,'0000-00-00','0000-00-00',NOW(),'',NOW(),'',1,'','','',0,'','','','".$startdate."','".$enddate."','gensmart','".$centerid."',0)");
		
		return $last_insert_id = $this->multipledb->summercampdb->insert_id();
		//echo $this->db->last_query(); exit;
	}
	
	public function adduser_mapping($userlastid,$grade,$planid)
	{	
	
		$qry=$this->multipledb->summercampdb->query("INSERT INTO `user_academic_mapping`( `id`, `grade_id`, `gp_id`, `sid`, `section`, `academicid`, `status`, `visible`) VALUES ('".$userlastid."','".$grade."','".$planid."',2,'A',20,1,1)");
		//echo $this->db->last_query(); exit;
	}
	
	public function usernamecheck($username)
	{
		$query = $this->multipledb->summercampdb->query('SELECT count(id) as usercount from users where username="'.$username.'" and status=1');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
		
	}
	
	public function chklicense($centerid)
	{
		$query = $this->db->query("SELECT SUM(`licensecount`) as givenlicense, (select count(*) from gtec_scamp.users where status=1 and isdemo=0 and status=1 and academic_center_id='".$centerid."') as totalusers FROM `license_count` WHERE status=1 and `centerid`='".$centerid."' and `product_id`=2");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
		
	}
	
	public function distributedlicence($centerid)
	{
		$query = $this->db->query("SELECT SUM(licensecount) as totalcount FROM license_count  WHERE status=1 and centerid='".$centerid."' and product_id=1");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
		
	}
	
	public function distributedlicence_sc($centerid)
	{
		$query = $this->db->query("SELECT SUM(licensecount) as totalcount FROM license_count  WHERE status=1 and centerid='".$centerid."' and product_id=2");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
		
	}
	
	/*New code*/
		
		public function getCurrentSessionLevel($userid)
	{
		$query = $this->db->query("select session_id from gamedata where gu_id=".$userid." and session_id!=0 order by id DESC limit 1");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getDefaultCycleData($Session_StartRange,$Session_EndRange,$session_curid)
	{
		$query = $this->db->query("select * from cycle_master where status=1 and range_start <=".$session_curid." and range_start!=1 ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getCurrentBSPIName($Session_StartRange,$Session_EndRange,$session_curid)
	{
		$query = $this->db->query("select * from cycle_master where status=1 and range_start =".$Session_StartRange." and range_end =".$Session_EndRange." ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getacademicyearbyschoolid($userid)
		 {
			 
			$query = $this->db->query("select startdate,enddate,id from academic_year where id=(select academic_id from schools where id=(select sid from users where id='".$userid."'))order by id desc limit 1");
			return $query->result_array();
		 }
	 
	public function getAdvancedSkillChart($userid,$Session_StartRange,$Session_EndRange,$session_curid,$startdate,$enddate)
	{
		$query = $this->db->query("select AVG(gamescore) as gamescore,gs_id,session_id from (SELECT (AVG(game_score)) as gamescore,gs_id,session_id  FROM game_reports WHERE gs_id in (59,60,61,62,63) and gu_id='".$userid."' and  (lastupdate between '".$startdate."' and '".$enddate."') and (session_id between '".$Session_StartRange."' and '".$Session_EndRange."') and session_id!=0  group by gs_id,session_id) a1 group by gs_id");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function getBSPI_range($userid,$startrange,$endrange)		 
		{
			$query = $this->db->query('select id, fname, a3.finalscore as avgbspiset1 from users mu left join (SELECT SUM(score)/5 as finalscore, gu_id, (SELECT sid from users where id=gu_id) as schoolid from (select (AVG(score)) as score, gu_id, gs_id from (SELECT ('.$this->config->item('skilllogic').'(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id =  "'.$userid.'" and (session_id between "'.$startrange.'" and "'.$endrange.'") and session_id!=0 group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id) a3   on a3.gu_id=mu.id where id = "'.$userid.'" ORDER BY avgbspiset1 DESC');
 
			//echo $this->multipledb->db->last_query(); exit;
			return $query->result_array();
		}
	public function getBasicSkillChart($userid,$Session_StartRange,$Session_EndRange,$session_curid,$startdate,$enddate)
	{
		$query = $this->db->query("select AVG(gamescore) as gamescore,gs_id,playedMonth from (SELECT (AVG(game_score)) as gamescore ,gs_id , lastupdate,DATE_FORMAT(lastupdate,'%m') as playedMonth  FROM sk_gamedata WHERE gs_id in (59,60,61,62,63) and gu_id='".$userid."' and  (lastupdate between '".$startdate."' and '".$enddate."') and (session_id between '".$Session_StartRange."' and '".$Session_EndRange."') and session_id!=0  group by gs_id,session_id) a1 group by gs_id");
	//	echo $this->db->last_query(); exit;
		
		return $query->result_array();
	}
	
	public function getSkillKitBSPI($userid,$Session_StartRange,$Session_EndRange)
	{
		$query = $this->db->query('SELECT AVG(score) as tsi, gu_id from (select (AVG(score)) as score, gu_id, gs_id from (SELECT ('.$this->config->item('skilllogic').'(Convert(game_score,SIGNED))) as score , gs_id , gu_id, lastupdate FROM sk_gamedata WHERE gs_id in (59,60,61,62,63) and gu_id ="'.$userid.'" and (session_id between "'.$Session_StartRange.'" and "'.$Session_EndRange.'") and session_id!=0 group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id');
	
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function getAssignSkills($userid)
	{
		$query = $this->db->query('select * from category_skills where FIND_IN_SET(id,(select weakSkills from sk_user_game_list where  userID='.$userid.' and status=0))');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	 public function getskills()
		 {
		$query = $this->db->query("select name,id from category_skills where category_id = 1 order by id");
		//echo $this->db->last_query(); 
			return $query->result_array();
		 }
}
