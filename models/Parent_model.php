<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parent_model extends CI_Model {

        
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
				 $this->load->database();
				 $this->load->library('Multipledb');
				 $this->load->library('Kinderdb');
        }
		
		public function checkUser($username,$password)
        {
			$query = $this->db->query('select a.id,CONCAT(fname," ",lname) as name,(select classname from class WHERE ID=a.grade_id) as gradename FROM users a WHERE username="'.$username.'" AND password=SHA1(CONCAT(salt1,"'.$password.'",salt2)) AND status=1');
		//	echo $this->db->last_query(); exit;
			return $query->result();
        }
		
		public function checkUser_kinder($username,$password)
        {
			$query = $this->kinderdb->db->query('select a.id,CONCAT(fname," ",lname) as name,(select classname from class WHERE ID=a.grade_id) as gradename FROM users a WHERE username="'.$username.'" AND password=SHA1(CONCAT(salt1,"'.$password.'",salt2)) AND status=1');
		//	echo $this->db->last_query(); exit;
			return $query->result();
        }
		
		 public function insert_login_log($userid,$sessionid,$ip,$country,$region,$city,$isp,$browser,$status)
		{
			$query = $this->db->query('INSERT INTO parent_login_log(userid,sessionid,created_date,lastupdate,logout_date,ip,country,region,city,browser,isp,status)VALUES("'.$userid.'","'.$sessionid.'",now(),now(),now(), "'.$ip.'","'.$country.'","'.$region.'","'.$city.'","'.$browser.'","'.$isp.'","'.$status.'")');
			return $query;
		}
		
		public function update_parent_sessionid($userid,$sessionid)
		{
			$query = $this->db->query('UPDATE users SET parent_session_id="'.$sessionid.'" WHERE id="'.$userid.'"');
			//return $query;
		} 
		
		public function k_insert_login_log($userid,$sessionid,$ip,$country,$region,$city,$isp,$browser,$status)
		{
			$query = $this->kinderdb->db->query('INSERT INTO parent_login_log(userid,sessionid,created_date,lastupdate,logout_date,ip,country,region,city,browser,isp,status)VALUES("'.$userid.'","'.$sessionid.'",now(),now(),now(), "'.$ip.'","'.$country.'","'.$region.'","'.$city.'","'.$browser.'","'.$isp.'","'.$status.'")');
			return $query;
		}
		
		public function k_update_parent_sessionid($userid,$sessionid)
		{
			$query = $this->kinderdb->db->query('UPDATE users SET parent_session_id="'.$sessionid.'" WHERE id="'.$userid.'"');
			//return $query;
		}
		
		public function UseridIsexist($userid)
        {
			$query = $this->db->query("SELECT id,creation_date FROM users WHERE id='".$userid."' and status=1 and visible=1");
			return $query->result_array();
		}
		public function UsernameIsexist($userid)
        {
			$query = $this->db->query("SELECT id,creation_date FROM users WHERE username='".$userid."' and status=1 and visible=1");
			return $query->result_array();
		}
		
		public function user_puzzledatas($userid)
        {
			$query = $this->db->query("SELECT SUM(attempt_question) as puzzles_attempted,SUM(answer) as puzzles_solved,Round(SUM(gtime)/60) as minutes_trained  FROM game_reports gr join users u on gr.gu_id=u.id WHERE gtime IS NOT NULL AND answer IS NOT NULL and u.id=".$userid." and u.status=1 and u.visible=1");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function user_scoredata($userid)
        {
			$query = $this->db->query("select id,name,gradename,section,ROUND(sum(mem + vp + fa + ps + lin )/5, 2) as bspi,crowny from (select id,name,gradename,section,
				
			(select avg(game_score)  from (select MAX(game_score)as game_score,AVG(game_score)as game_score1,lastupdate,gu_id from game_reports gr join users u on u.id=gr.gu_id  where u.id='".$userid."' and status=1 and visible=1 and academicyear=20 and gs_id=59  group by lastupdate,gu_id ) s1  where gu_id=a1.id) as mem,
		
			(select avg(game_score1)  from (select MAX(game_score)as game_score,AVG(game_score)as game_score1,lastupdate,gu_id from game_reports gr join users u on u.id=gr.gu_id  where u.id='".$userid."' and status=1 and visible=1 and academicyear=20 and gs_id=59  group by lastupdate,gu_id ) s1  where gu_id=a1.id) as mem1,
		
		
			(select avg(game_score)  from (select MAX(game_score)as game_score,AVG(game_score)as game_score1,lastupdate,gu_id from game_reports gr join users u on u.id=gr.gu_id  where u.id='".$userid."' and status=1 and visible=1 and academicyear=20 and gs_id=60  group by lastupdate,gu_id ) s1  where gu_id=a1.id) as vp,
		
			(select avg(game_score1)  from (select MAX(game_score)as game_score,AVG(game_score)as game_score1,lastupdate,gu_id from game_reports gr join users u on u.id=gr.gu_id  where u.id='".$userid."' and status=1 and visible=1 and academicyear=20 and gs_id=60  group by lastupdate,gu_id ) s1  where gu_id=a1.id) as vp1,
			
			(select avg(game_score)  from (select MAX(game_score)as game_score,AVG(game_score)as game_score1,lastupdate,gu_id from game_reports gr join users u on u.id=gr.gu_id  where u.id='".$userid."' and status=1 and visible=1 and academicyear=20 and gs_id=61  group by lastupdate,gu_id ) s1  where gu_id=a1.id) as fa,
		
			(select avg(game_score1)  from (select MAX(game_score)as game_score,AVG(game_score)as game_score1,lastupdate,gu_id from game_reports gr join users u on u.id=gr.gu_id  where u.id='".$userid."' and status=1 and visible=1 and academicyear=20 and gs_id=61  group by lastupdate,gu_id ) s1  where gu_id=a1.id) as fa1,
			
			
			(select avg(game_score)  from (select MAX(game_score)as game_score,AVG(game_score)as game_score1,lastupdate,gu_id from game_reports gr join users u on u.id=gr.gu_id  where u.id='".$userid."' and status=1 and visible=1 and academicyear=20 and gs_id=62  group by lastupdate,gu_id ) s1  where gu_id=a1.id) as ps,
		
			(select avg(game_score1)  from (select MAX(game_score)as game_score,AVG(game_score)as game_score1,lastupdate,gu_id from game_reports gr join users u on u.id=gr.gu_id  where u.id='".$userid."' and status=1 and visible=1 and academicyear=20 and gs_id=62  group by lastupdate,gu_id ) s1  where gu_id=a1.id) as ps1,
			
			(select avg(game_score)  from (select MAX(game_score)as game_score,AVG(game_score)as game_score1,lastupdate,gu_id from game_reports gr join users u on u.id=gr.gu_id  where u.id='".$userid."' and status=1 and visible=1 and academicyear=20 and gs_id=63  group by lastupdate,gu_id ) s1  where gu_id=a1.id) as lin,
		
			(select avg(game_score1)  from (select MAX(game_score)as game_score,AVG(game_score)as game_score1,lastupdate,gu_id from game_reports gr join users u on u.id=gr.gu_id  where u.id='".$userid."' and status=1 and visible=1 and academicyear=20 and gs_id=63  group by lastupdate,gu_id ) s1  where gu_id=a1.id) as lin1,
		
			(select sum(Points) from user_sparkies_history where U_ID=a1.id) as crowny
			
			from (select id,CONCAT(fname,' ',lname) as name,section,grade_id,(select classname from class where id=grade_id) as gradename from users where id='".$userid."' and status=1 and visible=1 and academicyear=20) a1 order by name asc) z1 group by id");
		//	echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function get_school_startdate($userid)
        {
			$query = $this->db->query("select id, start_date from schools where id=(select sid from users where username='".$userid."' and status=1 and visible=1)");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function user_avg_skillscore($userid,$startdate)
        {
			$enddate = date("Y-m-d");
			$query = $this->db->query("select round(AVG(score), 2) as score, s.name, gs_id from
			(select avg(score) AS score,gu_id AS gu_id,gs_id AS gs_id,sid AS sid,grade_id AS grade_id,section AS section,lastupdate AS lastupdate from
			(select AVG(gr.game_score) AS score,gr.gs_id AS gs_id,gr.gu_id AS gu_id,u.sid AS sid,u.grade_id AS grade_id,u.section AS section,gr.lastupdate AS lastupdate from game_reports gr 
			join users u on u.id = gr.gu_id

			where u.status = 1 and u.visible = 1 and gu_id='".$userid."' and gr.gs_id in (59,60,61,62,63) and 
			gr.lastupdate between '".$startdate."' and '".$enddate."' group by gr.gs_id,gr.gu_id,gr.lastupdate)a1
			 group by gs_id,gu_id) a2 join category_skills s ON s.id=a2.gs_id where gu_id='".$userid."' group by gs_id");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function puzzle_play_count($userid)
        {
			$query = $this->db->query("select count(g_id) as playedcount,(select name from category_skills where id=gs_id) as skillname,gs_id from game_reports where gu_id='".$userid."' and g_id!=0 GROUP by gs_id");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function monthwise_skillscore($userid,$month,$year)
        {
			$date = $year.'-'.$month;
			$query = $this->db->query("select round(AVG(score), 2) as skillscore, s.name,gs_id from
			(select avg(score) AS score,gu_id AS gu_id,gs_id AS gs_id,sid AS sid,grade_id AS grade_id,section AS section,lastupdate AS lastupdate from
			(select AVG(gr.game_score) AS score,gr.gs_id AS gs_id,gr.gu_id AS gu_id,u.sid AS sid,u.grade_id AS grade_id,u.section AS section,gr.lastupdate AS lastupdate from game_reports gr 
			join users u on u.id = gr.gu_id

			where u.status = 1 and u.visible = 1 and gu_id='".$userid."' and gr.gs_id in (59,60,61,62,63) and 
			date_format(gr.lastupdate,'%Y-%m') = '".$date."' group by gr.gs_id,gr.gu_id,gr.lastupdate)a1
			 group by gs_id,gu_id) a2 join category_skills s ON s.id=a2.gs_id where gu_id='".$userid."' group by gs_id");
		//	echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function academymonths($startdate)
        {
			date_default_timezone_set('Asia/Kolkata');
			$currentdate = date('Y-m-d', strtotime('last day of previous month'));
			$query = $this->db->query("select m1 as startdate,LAST_DAY(m1) as enddate,DATE_FORMAT(m1, '%m') as monthNumber,DATE_FORMAT(m1, '%Y') as yearNumber,DATE_FORMAT(m1, '%b') as monthName from (select ('".$startdate."' - INTERVAL DAYOFMONTH('".$startdate."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from(select 1 union select 2 union select 3 union select 4) t1,(select 1 union select 2 union select 3 union select 4) t2,(select 1 union select 2 union select 3 union select 4) t3,(select 1 union select 2 union select 3 union select 4) t4,(select @rownum:=-1) t0) d1) d2 where m1<=LAST_DAY('".$currentdate."') order by m1");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function monthwise_bspi($userid,$startdate)
        {
			date_default_timezone_set('Asia/Kolkata');
			$currentdate = date('Y-m-d', strtotime('last day of previous month'));
			$query = $this->db->query("SELECT ROUND(avg(`finalscore`), 2) as bspi, monthNumber FROM  
 
			(select round((sum(vii2.score) / 5),2) AS finalscore,vii2.gu_id AS gu_id,vii2.sid AS sid,vii2.grade_id AS grade_id,vii2.section AS section,(select users.username from users where (users.id = vii2.gu_id)) AS username,vii2.monthNumber AS monthNumber,monthname(str_to_date(vii2.monthNumber,'%m')) AS monthName,vii2.yearName AS yearName from

			(select round(avg(score),2) AS score,gu_id AS gu_id,gs_id AS gs_id,sid AS sid,grade_id AS grade_id,section AS section,date_format(lastupdate,'%m') AS monthNumber,date_format(lastupdate,'%Y') AS yearName from

			(select max(gr.game_score) AS score,gr.gs_id AS gs_id,gr.gu_id AS gu_id,u.sid AS sid,u.grade_id AS grade_id,u.section AS section,gr.lastupdate AS lastupdate from game_reports gr 
			join users u on u.id = gr.gu_id 

			where u.status = 1 and u.visible = 1 and u.username='".$userid."' and gr.gs_id in (59,60,61,62,63) and 
			gr.lastupdate between '".$startdate."' and '".$currentdate."'
			group by gr.gs_id,gr.gu_id,gr.lastupdate) as a1
			group by gs_id,gu_id,month(lastupdate))vii2 group by vii2.gu_id,vii2.monthNumber) as a3
			group by monthNumber");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function get_profile($userid)
        {
			$query = $this->db->query("select id,CONCAT(fname,' ',lname) as name,REPLACE((select classname name from class where id=grade_id), 'Grade', '') as gradename,section,email,mobile from users where id='".$userid."' and status=1 and visible=1");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function edit_profile($userid,$email,$mobile)
        {
			$query = $this->db->query("UPDATE users set email='".$email."',mobile='".$mobile."' where id='".$userid."'");
			//echo $this->db->last_query(); exit;
			//return $query->result_array();
		}
		
		public function get_session_id($userid)
        {
			$query = $this->db->query("SELECT `parent_session_id` FROM `users` WHERE `id`='".$userid."' and status=1 and visible=1");
			return $query->result_array();
		}
		
		public function update_logout($userid,$sessionid)
        {
			$query = $this->db->query("UPDATE `parent_login_log` SET `lastupdate`=NOW(),`logout_date`=NOW()  WHERE sessionid='".$sessionid."' and userid='".$userid."' ");
			//return $query->result_array();
		}
		
		public function academic_year()
        {
			$query = $this->db->query("select id,startdate,enddate,CONCAT(EXTRACT(YEAR FROM startdate),'-',EXTRACT(YEAR FROM enddate)) as yearname from academic_year where id=20");
			return $query->result_array();
		}
		
		public function get_months($startdate,$enddate)
        {
			$query = $this->db->query("select DATE_FORMAT(m1, '%m') as monthNumber,DATE_FORMAT(m1, '%Y') as yearNumber,DATE_FORMAT(m1, '%b') as monthName from (select ('".$startdate."' - INTERVAL DAYOFMONTH('".$startdate."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from(select 1 union select 2 union select 3 union select 4) t1,(select 1 union select 2 union select 3 union select 4) t2,(select 1 union select 2 union select 3 union select 4) t3,(select 1 union select 2 union select 3 union select 4) t4,(select @rownum:=-1) t0) d1) d2 where m1<=LAST_DAY('".$enddate."') order by m1");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		
}