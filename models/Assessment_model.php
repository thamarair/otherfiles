<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assessment_model extends CI_Model {

        
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
				 $this->load->database();
				 //$this->load->library('Multipledb');
				 //$this->load->library('School1819');
				 //$this->load->library('Asapo');
				 if (isset($this->session->user_id))
				{
					date_default_timezone_set($this->session->timezone);
				}
        }
		public function getacademicyearbyschoolid($sid)
		 {
			 
			$query = $this->db->query("select startdate,enddate,id from academic_year where id=(select academic_id from schools where id=".$this->db->escape($sid).")order by id desc limit 1");
			return $query->result_array();
		 }

        public function checkUser($username,$password,$langid="")
        {
			$query = $this->db->query('select a.*, "english" as languagekey, (select classname from class WHERE ID=a.grade_id) as gradename FROM users a join school_admin sa on sa.school_id=a.sid WHERE a.username='.$this->db->escape($username).' AND a.password=SHA1(CONCAT(a.salt1,'.$this->db->escape($password).',a.salt2)) AND a.status=1 AND sa.active=1 and sa.flag=1');
			
			//echo $this->db->last_query(); exit;
			return $query->result();
        }
		
		public function chkprevioussession($userid,$gradeid,$section,$schoolid)
        {
			$query = $this->db->query('select count(lastupdate) as lastsessiondate from gamedata where gu_id = '.$this->db->escape($userid).' and lastupdate = (select max(period_date) from schools_period_schedule_days where grade_id="'.$gradeid.'" and section='.$this->db->escape($section).' and sid='.$this->db->escape($schoolid).')');
			
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		
		
			public function islogin($username,$password,$idealtime)
        {	//echo 'select count(id) as islogin FROM users a WHERE username='.$username.' AND password=md5('.$password.') AND status=1 AND (SELECT school_id FROM school_admin WHERE school_id=a.sid AND active=1) AND  TIMESTAMPDIFF(MINUTE,last_active_datetime,NOW())<='.$idealtime.'';
		$innow=date("Y-m-d H:i:s");
			$query = $this->db->query('CALL IsLogin('.$this->db->escape($username).','.$this->db->escape($password).','.$this->db->escape($idealtime).',"","'.$innow.'")');
			mysqli_next_result($this->db->conn_id);
			//echo $this->db->last_query(); exit;
			return $query->result();
        }
		public function checkuserisactive($userid,$login_session_id)
        { 
			$innow=date("Y-m-d H:i:s");
			$query = $this->db->query('CALL checkuserisactive('.$this->db->escape($userid).','.$this->db->escape($login_session_id).',"'.$innow.'")');
			mysqli_next_result($this->db->conn_id);
			//echo $this->db->last_query(); exit;
			return $query->result();
        }
		public function updateuserloginstatus($userid,$login_session_id)
        {	//echo 'CALL updateuserloginstatus('.$this->db->escape($userid).','.$this->db->escape($login_session_id).')';exit;
			$query = $this->db->query('CALL updateuserloginstatus('.$this->db->escape($userid).','.$this->db->escape($login_session_id).')');
			mysqli_next_result($this->db->conn_id);
			
        }	
		
		/* public function getdates($userid)
		 {
			 
		$query = $this->db->query("select AY.startdate,AY.enddate from users UG,academic_year AY where AY.id=UG.academicyear and UG.id=".$this->db->escape($userid)." limit 0,1");
		//echo $this->db->last_query(); 
			return $query->result_array();
		 }	 */
		 
		  public function getbspireport($userid)
		 {
			 
		$query = $this->db->query("SELECT (AVG(`game_score`)) as gamescore ,gs_id , lastupdate,DATE_FORMAT(`lastupdate`,'%m') as playedMonth  FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id=".$this->db->escape($userid)." and  lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."'    group by gs_id , lastupdate");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }	
		 
		 
		 
		 public function languagechange($email)
		 {
		$query = $this->db->query("select * from language_master where status='Y' and ID in (select languageID from schools_language where schoolID=(select sid from users where username=".$this->db->escape($email)." and status=1) and status='Y')");
		//echo $this->db->last_query(); exit;
			return $query->result();
		 }
		 public function update_loginDetails($userid,$session_id)
		 { 
		$query = $this->db->query("update users set pre_logindate = login_date,login_date = '".date("Y-m-d")."',login_count=login_count+1,session_id=".$this->db->escape($session_id).",islogin=1,last_active_datetime='".date("Y-m-d H:i:s")."' WHERE id =".$this->db->escape($userid)."");
		//echo $this->db->last_query(); exit;
		 }	

		public function getRandomGames($check_date_time,$game_plan_id,$game_grade,$school_id)
		 {
			 
			$query = $this->db->query("SELECT gid FROM rand_selection WHERE DATE(created_date) = ".$this->db->escape($check_date_time)." AND gp_id = ".$this->db->escape($game_plan_id)." AND grade_id = ".$this->db->escape($game_grade)." AND school_id = ".$this->db->escape($school_id)." and user_id='".$this->session->user_id."' GROUP BY school_id, gs_id ORDER BY gs_id ASC");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }
		 public function deleteSPLRandomGames($check_date_time,$game_plan_id,$game_grade,$school_id,$userid)
		 {
			$query = $this->db->query("delete FROM rand_selection WHERE gp_id = ".$this->db->escape($game_plan_id)." AND grade_id = ".$this->db->escape($game_grade)." AND school_id = ".$this->db->escape($school_id)." and user_id=".$this->db->escape($userid)."");
		 }
		 public function getAssignGames($game_plan_id,$game_grade,$uid,$catid)
		 {
			 
		$query = $this->db->query("SELECT a.id, a.grade_id, d.skill_id FROM users AS a JOIN g_plans AS b ON a.gp_id = b.id AND b.id = ".$this->db->escape($game_plan_id)." JOIN class_plan_game AS c ON b.id = c.plan_id AND b.grade_id = c.class_id JOIN class_skill_game AS d ON c.class_id = d.class_id AND c.game_id = d.game_id AND d.class_id = ".$this->db->escape($game_grade)." JOIN category_skills AS e ON e.id = d.skill_id WHERE a.id = ".$this->db->escape($uid)." AND e.category_id = ".$this->db->escape($catid)." GROUP BY d.skill_id");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }
		 public function getSkillsRandom($catid)
		 {
			 
		$query = $this->db->query("SELECT a.id AS category_id, b.id AS skill_id FROM g_category AS a JOIN category_skills AS b ON a.id = b.category_id WHERE a.id = ".$this->db->escape($catid)."");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }
		 public function getSK_SkillsRandom($uid,$weakSkills)
		 {
		
		$query = $this->db->query("select id as skill_id from category_skills where id in(".$weakSkills.") order by field(id,".$weakSkills.")");
		
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }
		 public function assignRandomGame($catid,$game_plan_id,$game_grade,$uid,$skill_id,$school_id,$user_current_session)
		 { 
			$query = $this->db->query("SELECT j.id, g.gs_id as skill_id, j.name AS skill_name, g.gid, g.gname FROM users AS a
		 
				JOIN class_plan_game AS d ON d.class_id=".$this->db->escape($game_grade)." AND d.plan_id = ".$this->db->escape($game_plan_id)."
				
				JOIN games AS g ON d.game_id = g.gid 
				
				JOIN category_skills AS j ON g.gs_id = j.id   
				
				WHERE a.id = ".$this->db->escape($uid)." AND g.gc_id = ".$this->db->escape($catid)." and j.id = ".$this->db->escape($skill_id)." 
				
				and g.gid not in (SELECT gid FROM rand_selection WHERE gp_id = ".$this->db->escape($game_plan_id)." AND grade_id = ".$this->db->escape($game_grade)." AND school_id = ".$this->db->escape($school_id)." and user_id='".$this->session->user_id."' and gs_id = ".$this->db->escape($skill_id).") and complexity_level=".$this->db->escape($user_current_session)." GROUP BY g.gid ORDER BY RAND() LIMIT 1");
				//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }
		 public function assignSK_RandomGame($check_date_time,$game_plan_id,$game_grade,$uid,$skill_id,$school_id)
		 {
			$query = $this->db->query("SELECT gid FROM sk_rand_selection WHERE DATE(created_date) = ".$this->db->escape($check_date_time)."  AND userID = ".$this->db->escape($uid)." AND grade_id = ".$this->db->escape($game_grade)." AND school_id = ".$this->db->escape($school_id)." AND gs_id=".$this->db->escape($skill_id)." GROUP BY school_id, gs_id,gid order by gs_id");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }
		 public function getAssignSK_RandomGame($check_date_time,$game_plan_id,$game_grade,$uid,$school_id)
		 {
			 
		$query = $this->db->query("SELECT gid,gp_id FROM sk_rand_selection WHERE DATE(created_date) = ".$this->db->escape($check_date_time)." AND userID = ".$this->db->escape($uid)." AND grade_id = ".$this->db->escape($game_grade)." AND school_id = ".$this->db->escape($school_id)." GROUP BY school_id, gs_id,gid order by gs_id");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }
		 public function assignSK_assignGameCount($game_plan_id,$skill_id,$school_id,$levelid)
		 {
			 
		$query = $this->db->query("select * from sk_personalized_game where sk_planSkillCountID in (select ID from sk_plan_skillcount where school_ID=".$this->db->escape($school_id)." and plan_ID=".$this->db->escape($game_plan_id).") and skillID = ".$this->db->escape($skill_id)." and level=".$this->db->escape($levelid)." ");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }
		 public function getSK_randomGames($game_plan_id,$game_grade,$uid,$skill_id,$school_id,$assign_count,$cur_day_skills,$levelid)
		 {
			 
		$query = $this->db->query("SELECT g.skill_ID as skill_id,(select name from category_skills where id=g.skill_ID) as skill_name,g.name as gname,g.ID as gid,gp.plan_ID FROM sk_games g join sk_games_plan gp on g.ID=gp.sk_game_ID  join sk_personalized_game pg on gp.plan_ID=from_GradeID and level=".$this->db->escape($levelid)." WHERE g.skill_ID=".$this->db->escape($skill_id)." and gp.school_ID=".$this->db->escape($school_id)." and  pg.skillID=g.skill_ID and pg.sk_planSkillCountID in (select ID from sk_plan_skillcount where school_ID=".$this->db->escape($school_id)." and plan_ID=".$this->db->escape($game_plan_id)." ) and g.ID not in (SELECT gid FROM sk_rand_selection  WHERE userID = ".$this->db->escape($uid)." AND grade_id = ".$this->db->escape($game_grade)."  AND school_id = ".$this->db->escape($school_id)." and gs_id = ".$this->db->escape($skill_id).") and g.game_masterID not in(243,283,23,65,100,146,140,179,186,226,266,307,233) order by rand() limit ".($assign_count-$cur_day_skills)." ;");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 } 
		 public function getSK_mindatePlay($game_plan_id,$game_grade,$uid,$skill_id,$school_id,$catid)
		 {
			 
		$query = $this->db->query("select min(created_date) as mindate from sk_rand_selection where gc_id = ".$this->db->escape($catid)." AND userID = ".$this->db->escape($uid)."  and gs_id = ".$this->db->escape($skill_id)." and grade_id = ".$this->db->escape($game_grade)."  and school_id = ".$this->db->escape($school_id)."");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }
		 public function deleteSK_OldGames($catid,$game_plan_id,$game_grade,$uid,$skill_id,$school_id,$mindate)
		 {
			 
		$query = $this->db->query("delete from sk_rand_selection where gc_id = ".$this->db->escape($catid)." AND userID = ".$this->db->escape($uid)."  and gs_id = ".$this->db->escape($skill_id)." and  grade_id = ".$this->db->escape($game_grade)."  and school_id = ".$this->db->escape($school_id)."  and created_date=".$this->db->escape($mindate)."");
		//echo $this->db->last_query(); exit;
			 
		 }
		 public function deleteRandomGames($catid,$game_plan_id,$game_grade,$uid,$skill_id,$school_id,$del_where)
		 {
			 
		$query = $this->db->query("delete from rand_selection where gc_id = ".$this->db->escape($catid)." and gs_id = ".$this->db->escape($skill_id)." and gp_id = ".$this->db->escape($game_plan_id)." and grade_id = ".$this->db->escape($game_grade)."  and school_id = ".$this->db->escape($school_id)." and user_id='".$this->session->user_id."' ".$del_where);
		//echo $this->db->last_query(); exit;
			 
		 }
		 public function deleteSK_RandomGames($catid,$game_plan_id,$game_grade,$uid,$skill_id,$school_id,$del_where)
		 {
			 
		$query = $this->db->query("delete from sk_rand_selection where gc_id = ".$this->db->escape($catid)." AND userID = ".$this->db->escape($uid)."  and gs_id = ".$this->db->escape($skill_id)." and  grade_id = ".$this->db->escape($game_grade)."  and school_id = ".$this->db->escape($school_id)." ".$del_where);
		//echo $this->db->last_query(); exit;
			 
		 }
		 public function insertRandomGames($catid,$game_plan_id,$game_grade,$skill_id,$school_id,$section,$gameid,$check_date_time,$user_current_session)
		 { 
			$query = $this->db->query("INSERT INTO rand_selection SET gc_id = ".$this->db->escape($catid).", gs_id = ".$this->db->escape($skill_id).", gid = ".$this->db->escape($gameid).", gp_id = ".$this->db->escape($game_plan_id).", grade_id = ".$this->db->escape($game_grade).", section = ".$this->db->escape($section).", school_id = ".$this->db->escape($school_id).",user_id='".$this->session->user_id."',created_date = ".$this->db->escape($check_date_time).",complexity_level = '".$this->db->escape($user_current_session)."' "); 
		 } 
		 public function insertSK_RandomGames($catid,$game_plan_id,$game_grade,$uid,$skill_id,$school_id,$section,$gameid,$check_date_time)
		 {

		$query = $this->db->query("INSERT INTO sk_rand_selection SET userID=".$this->db->escape($uid).", gc_id = ".$this->db->escape($catid).", gs_id = ".$this->db->escape($skill_id).", gid = ".$gameid.", gp_id = ".$this->db->escape($game_plan_id).", grade_id = ".$this->db->escape($game_grade).", section = ".$this->db->escape($section).", school_id = ".$this->db->escape($school_id).", created_date = '".date('Y-m-d h:i:s')."'");
		
			 
		 }
		public function getActualGames($game_plan_id,$game_grade,$uid,$catid,$where)
		{
			$query = $this->db->query("SELECT j.id,(select count(*) as tot_game_played from game_reports where gu_id = ".$this->db->escape($uid)."  AND gc_id = ".$this->db->escape($catid)." AND gs_id = e.skill_id AND gp_id = ".$this->db->escape($game_plan_id)." AND lastupdate = '".date('Y-m-d')."') as tot_game_played ,
			(select ".$this->config->item('starslogic')."(game_score)  from game_reports where gu_id =  ".$this->db->escape($uid)."  AND gc_id = ".$this->db->escape($catid)." AND gs_id = e.skill_id AND gp_id = ".$this->db->escape($game_plan_id)." AND lastupdate = '".date('Y-m-d')."') as tot_game_score ,
			(select DISTINCT puzzle_cycle from gamescore where g_id=g.gid and gu_id=".$this->db->escape($uid)." and lastupdate='".date('Y-m-d')."' order by puzzle_cycle DESC limit 1) current_puzzle_cycle,
			(SELECT  CASE  when count(gs_id)>=10 THEN count(id) WHEN FIND_IN_SET('U',group_concat(answer_status))>=1 THEN 'TO' when count(gs_id)<10 THEN count(id) ELSE 0 END CompletedSkill FROM gamescore as gs   where gs.gs_id=e.skill_id and gu_id=".$this->db->escape($uid)." and lastupdate='".date('Y-m-d')."' and puzzle_cycle=current_puzzle_cycle) as tot_ques_attend, 
			e.skill_id, j.name AS skill_name, g.gid, g.gname, g.img_path,g.game_html, j.icon 
			FROM users AS a
			JOIN class_plan_game AS d ON d.class_id=".$this->db->escape($game_grade)." AND d.plan_id = ".$this->db->escape($game_plan_id)."
			JOIN class_skill_game AS e ON e.class_id = ".$this->db->escape($game_grade)." AND  d.game_id = e.game_id
			JOIN category_skills AS j ON e.skill_id = j.id 
			JOIN games AS g ON d.game_id = g.gid	WHERE a.id = ".$this->db->escape($uid)." AND g.gc_id = ".$this->db->escape($catid)." $where GROUP BY skill_id,g.gid"); 
			return $query->result_array();
		}
		
		
		public function getSK_ActualGames($game_plan_id,$game_grade,$uid,$catid)
		{
			$query = $this->db->query("select g.skill_ID as skill_id,game_html,".$this->config->item('SK_MinPlayCount')." as SK_MinPlayCount,g.ID as gid, g.name as gname, g.image_path as img_path,cs.name,cs.colorcode,

			(select times_count from sk_games_plan where school_ID='".$this->session->school_id."' and sk_game_ID=g.ID and plan_id=rd.gp_id) as playcount,

			(select count(*) as tot_game_played from sk_game_reports where gu_id = ".$this->db->escape($uid)."  AND gc_id = ".$this->db->escape($catid)." AND g_id = g.ID AND gp_id = ".$this->db->escape($game_plan_id)." AND lastupdate = '".date('Y-m-d')."') as tot_game_played,

			(select DISTINCT puzzle_cycle from sk_gamescore where g_id=g.ID and gu_id=".$this->db->escape($uid)." and lastupdate='".date('Y-m-d')."' order by puzzle_cycle DESC limit 1) current_puzzle_cycle,

			(SELECT  CASE  when count(gs_id)>=10 THEN count(id) WHEN FIND_IN_SET('U',group_concat(answer_status))>=1 THEN 'TO' when count(gs_id)<10 THEN count(id) ELSE 0 END CompletedSkill FROM sk_gamescore as gs where gs.gs_id=g.skill_ID and gs.g_id=g.ID and gu_id=".$this->db->escape($uid)." and lastupdate='".date('Y-m-d')."' and puzzle_cycle=current_puzzle_cycle) as tot_ques_attend

			from sk_rand_selection as rd 
			 
			join sk_games AS g on g.ID=rd.gid 
			join category_skills AS cs on cs.id=g.skill_ID
			  
			where userID=".$this->db->escape($uid)." and date(rd.created_date)='".date('Y-m-d')."' order by cs.id asc ");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		
		 public function getTrainCalendar($userid,$startdate,$enddate,$catid)
		 {
		$query = $this->db->query("select group_concat(distinct(lastupdate)) as updateDates  from game_reports WHERE gu_id = ".$this->db->escape($userid)." and (lastupdate between ".$this->db->escape($startdate)." and ".$this->db->escape($enddate).")  and gc_id = ".$this->db->escape($catid)."");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }
		 public function getBSPI($userid,$Session_StartRange='',$Session_EndRange='')
		 {
			 
		$query = $this->db->query("SELECT (".$this->config->item('skilllogic')."(`game_score`)) as score ,gs_id , lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id=".$this->db->escape($userid)." and (lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."') and (session_id between ".$this->db->escape($Session_StartRange)." and ".$this->db->escape($Session_EndRange).") and session_id!=0   group by gs_id ,session_id");
	//	echo $this->db->last_query();  exit;
			return $query->result_array();
		 }
		
		 public function getleftbardata($userid)
		 {
			 
		$todaydate=date('Y-m-d');
		$query = $this->db->query("select avatarimage,fname,DATEDIFF('".date("Y-m-d")."', login_date) as noofdays,pre_logindate from users where status=1 and id=".$this->db->escape($userid)."");
		//echo $this->db->last_query(); exit;
			return $query->result();
		 }			 
		 
		 public function getMyCurrentTrophies($userid)
		 {
			$query = $this->db->query("select cs.id as catid,cs.name as name ,(select sum(diamond) from popuptrophys pt where gu_id=".$this->db->escape($userid)." and pt.catid=cs.id) as diamond ,(select sum(gold) from popuptrophys pt where gu_id=".$this->db->escape($userid)." and pt.catid=cs.id) as gold ,(select sum(silver) from popuptrophys pt where gu_id=".$this->db->escape($userid)." and pt.catid=cs.id) as silver from category_skills cs where category_id=1 ");
			
			return $query->result_array();
		 }		

		public function getmyprofile($userid)
		 {
			 
		$query = $this->db->query("SELECT *,(SELECT school_name FROM schools WHERE id=us.sid) as schoolname  FROM users us where id=".$this->db->escape($userid)."");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }			

		public function getplandetais($planid)
		 {
			 
		$query = $this->db->query("select * FROM g_plans where id=".$this->db->escape($planid)."");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }	

		public function getgradedetais($gradeid)
		 {
			 
		$query = $this->db->query("select distinct(classname),id from class where id=".$this->db->escape($gradeid)."");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }	

		public function updateprofile($sfname,$gender,$emailid,$dob,$fathername,$mothename,$address,$sphoneno,$id,$shpassword,$salt1,$salt2,$confirmpass,$targetPath,$ip)
		
		 {
			  if($targetPath==""){$avatarimage="avatarimage";}
			 else{$avatarimage="'".$targetPath."'";}
			 
			 if($shpassword !='' && $confirmpass!='')
{
	 //$newpassword=md5($newpass); 		 
			 $qry=$this->db->query("INSERT INTO password_history(userid, changed_on, newpwd, ip) VALUES(".$this->db->escape($id).",'".date("Y-m-d H:i:s")."',".$this->db->escape($confirmpass).",".$this->db->escape($ip).") ");			 
		
		$query = $this->db->query("update users set fname = ".$this->db->escape($sfname).",password=".$this->db->escape($shpassword).",salt1=".$this->db->escape($salt1).",salt2=".$this->db->escape($salt2).",father=".$this->db->escape($fathername).",mother=".$this->db->escape($mothename).",gender=".$this->db->escape($gender).",email=".$this->db->escape($emailid).",dob=".$this->db->escape($dob).",mobile=".$this->db->escape($sphoneno).",address=".$this->db->escape($address).", avatarimage=".$this->db->escape($avatarimage)." where id = ".$this->db->escape($id)."");
}
else{
	
	$query = $this->db->query("update users set fname = ".$this->db->escape($sfname).",father=".$this->db->escape($fathername).",mother=".$this->db->escape($mothename).",gender=".$this->db->escape($gender).",email=".$this->db->escape($emailid).",dob=".$this->db->escape($dob).",mobile=".$this->db->escape($sphoneno).",address=".$this->db->escape($address).", avatarimage=".$this->db->escape($avatarimage)." where id = ".$this->db->escape($id)."");
	
}
		//echo $this->db->last_query(); exit;
			//return $query->result_array();
		 }


	   public function getgameplanid($userid)
		 {
			 
		$query = $this->db->query("select gp_id from users where id = ".$this->db->escape($userid)."");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }

		public function getgamenames($userid,$pid)
		 {
			 
		$query = $this->db->query("SELECT a.gid,a.gname FROM  games a, game_reports b where a.gid=b.g_id and b.gu_id=".$this->db->escape($userid)." and b.gp_id = ".$this->db->escape($pid)."  and a.gc_id = 1 and (lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."') group by a.gid");
		//echo $this->db->last_query(); exit;
			return $query->result();
		 }

		public function getgamedetails($userid,$gameid,$pid)
		 {
			 
		$query = $this->db->query("select g_id, avg(game_score) as game_score,lastupdate from game_reports where gp_id = ".$this->db->escape($pid)." and gu_id=".$this->db->escape($userid)." and g_id=".$this->db->escape($gameid)." AND (lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."') group by lastupdate  ORDER BY lastupdate DESC LIMIT 10");
		//echo $this->db->last_query(); 
			return $query->result_array();
		 }		 
		 public function insertone($userid,$cid,$sid,$pid,$gameid,$total_ques,$attempt_ques,$answer,$score,$a6,$a7,$a8,$a9,$lastup_date,$schedule_val)
		 {
			 //echo 'hello'; exit;
		$query = $this->db->query("insert into gamedata (gu_id,gc_id,gs_id,gp_id,g_id,total_question,attempt_question,answer,game_score,gtime,rtime,crtime,wrtime,lastupdate,created_date_time,Is_schedule) values(".$this->db->escape($userid).",".$this->db->escape($cid).",".$this->db->escape($sid).",".$this->db->escape($pid).",".$this->db->escape($gameid).",".$this->db->escape($total_ques).",".$this->db->escape($attempt_ques).",".$this->db->escape($answer).",".$this->db->escape($score).",".$this->db->escape($a6).",".$this->db->escape($a7).",".$this->db->escape($a8).",".$this->db->escape($a9).",".$this->db->escape($lastup_date).",'".date("Y-m-d H:i:s")."',".$this->db->escape($schedule_val).")");
		//echo $this->db->last_query(); exit;
			 
		 }	 
		 public function insertone_SK($userid,$cid,$sid,$pid,$gameid,$total_ques,$attempt_ques,$answer,$score,$a6,$a7,$a8,$a9,$lastup_date)
		 {
			 //echo 'hello'; exit;
		$query = $this->db->query("insert into sk_gamedata (gu_id,gc_id,gs_id,gp_id,g_id,total_question,attempt_question,answer,game_score,gtime,rtime,crtime,wrtime,lastupdate) values(".$this->db->escape($userid).",".$this->db->escape($cid).",".$this->db->escape($sid).",".$this->db->escape($pid).",".$this->db->escape($gameid).",".$this->db->escape($total_ques).",".$this->db->escape($attempt_ques).",".$this->db->escape($answer).",".$this->db->escape($score).",".$this->db->escape($a6).",".$this->db->escape($a7).",".$this->db->escape($a8).",".$this->db->escape($a9).",".$this->db->escape($lastup_date).")");
		//echo $this->db->last_query(); exit;
			 
		 }	
		 
		 public function insertlang($gameid,$userid,$userlang,$skillkit)
		 {
			 //echo 'hello'; exit;
		$query = $this->db->query("INSERT INTO game_language_track( gameID, userID, languageID, skillkit, createddatetime) VALUES (".$this->db->escape($gameid).",".$this->db->escape($userid).",".$this->db->escape($userlang).",".$this->db->escape($skillkit).",'".date("Y-m-d H:i:s")."')");
		//echo $this->db->last_query(); exit;
			 
		 }	
		 
		  public function getresultGameDetails($userid,$gameid)
		 {
			 
			$query = $this->db->query("select (select gs_id from games where gid=".$this->db->escape($gameid).") as gameskillid,(select count(gu_id) from game_reports where gu_id=".$this->db->escape($userid)." and g_id=".$this->db->escape($gameid)." and lastupdate='".date("Y-m-d")."' and gs_id IN(59,60,61,62,63)) as playedgamescount");
			return $query->result_array();
		 }	
		 
		  public function insertthree($userid,$gameid,$acid,$lastup_date,$st)
		 {
			 //echo 'hello'; exit;
		$query = $this->db->query("insert into user_games (gu_id,played_game,last_update,date,status,academicyear) values(".$this->db->escape($userid).",".$this->db->escape($gameid).",".$this->db->escape($lastup_date).",".$this->db->escape($lastup_date).",".$this->db->escape($st).",".$this->db->escape($acid).")");
		 
		 }	
		 
		public function getacademicmonths($startdate,$enddate)
		 { //echo ;exit;
			 
		$query = $this->db->query("select DATE_FORMAT(m1, '%m') as monthNumber,DATE_FORMAT(m1, '%Y') as yearNumber,DATE_FORMAT(m1, '%b') as monthName from (select (".$this->db->escape($startdate)." - INTERVAL DAYOFMONTH(".$this->db->escape($startdate).")-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from(select 1 union select 2 union select 3 union select 4) t1,(select 1 union select 2 union select 3 union select 4) t2,(select 1 union select 2 union select 3 union select 4) t3,(select 1 union select 2 union select 3 union select 4) t4,(select @rownum:=-1) t0) d1) d2 where m1<=".$this->db->escape($enddate)." order by m1");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }
		 
		
		 public function getskills()
		 {		 
		$query = $this->db->query("select name,id,colorcode from category_skills where category_id = 1 order by id");
		//echo $this->db->last_query(); 
			return $query->result_array();
		 }
		 
		 public function getWeakSkills($skillid)
	{	
		if($skillid!=''){$gs_id="id in(".$skillid.")";}else{$gs_id="1=1";} 
	
		$query = $this->db->query("select * from category_skills where category_id = 1 and  ".$gs_id." order by id");
		return $query->result_array();
	}
	
		 public function getcalendar($uid,$start_date,$last_date)
		 {
	
		$query = $this->db->query("SELECT id, date_format(lastupdate, '%d/%m/%Y') as created_date FROM game_reports WHERE gu_id = ".$this->db->escape($uid)." and lastupdate between ".$this->db->escape($start_date)." and ".$this->db->escape($last_date)."  and gc_id = 1");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }	
		 
		 public function getskpreport($userid,$skillsid,$month)
		 {
	
		$query = $this->db->query("SELECT (AVG(`game_score`)) as gamescore ,gs_id , lastupdate,DATE_FORMAT(`lastupdate`,'%m') as playedMonth FROM `game_reports` WHERE gs_id in (".$this->db->escape($skillsid).") and gu_id=".$this->db->escape($userid)." and  lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."' and DATE_FORMAT(lastupdate, '%Y-%m')=\"".$month."\"   group by gs_id , lastupdate");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }
		 public function mybspicalendar($school_id,$uid,$dateQry,$startdate,$enddate)
		 {
			 $query = $this->db->query('select (sum(a.game_score)/5) as game_score, lastupdate,playedDate from
								(
									SELECT '.$this->config->item('skilllogic').'(gr.game_score) as game_score,count(*) as cnt, lastupdate,DATE_FORMAT(`lastupdate`,"%d") as playedDate FROM game_reports gr join category_skills sk join users u WHERE gr.gu_id = u.id and u.sid = '.$this->db->escape($school_id).' and gr.gu_id='.$this->db->escape($uid).' and sk.id = gr.gs_id and gr.gs_id in (SELECT id FROM category_skills where category_id=1) and  lastupdate between '.$this->db->escape($startdate).' and '.$this->db->escape($enddate).' AND DATE_FORMAT(lastupdate, "%Y-%m")=\''.$dateQry.'\' group by lastupdate, gr.gs_id, gr.gu_id order by gr.gs_id
								) a group by lastupdate');
								//echo $this->db->last_query(); exit;
								return $query->result_array();
								
		 }
		 
		 public function myskillscores($school_id,$uid,$dateQry,$startdate,$enddate)
		 {
			 $query = $this->db->query('SELECT ROUND(AVG(gr.game_score),2) as game_score,gs_id, lastupdate,DATE_FORMAT(`lastupdate`,"%d") as playedDate FROM game_reports gr join category_skills sk join users u WHERE gr.gu_id = u.id and u.sid = '.$this->db->escape($school_id).' and gr.gu_id='.$this->db->escape($uid).' and sk.id = gr.gs_id and gr.gs_id in (SELECT id FROM category_skills where category_id=1) and  lastupdate between '.$this->db->escape($startdate).' and '.$this->db->escape($enddate).' AND DATE_FORMAT(lastupdate, "%Y-%m")=\''.$dateQry.'\' group by lastupdate, gr.gs_id, gr.gu_id order by gr.gs_id');
		echo $this->db->last_query(); exit;
			return $query->result_array();
								
		 }

		 public function mybspicalendarSkillChart($skillsid,$uid,$dateQry)
		 {
			  $query = $this->db->query("select AVG(gamescore) as gamescore,gs_id,playedMonth from (SELECT (AVG(game_score)) as gamescore ,gs_id , lastupdate,DATE_FORMAT(lastupdate,'%m') as playedMonth  FROM game_reports WHERE gs_id in (59,60,61,62,63) and gu_id=".$this->db->escape($uid)." and  lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."' and DATE_FORMAT(lastupdate, '%Y-%m')=\"".$dateQry."\"   group by gs_id,lastupdate) a1 group by gs_id");
								//echo $this->db->last_query(); exit;
								return $query->result_array();
								
		 }
		   public function myTrophiesAll($userid,$startdate,$enddate)
		 {
			 $query = $this->db->query("select trophystar.gu_id AS gu_id,extract(month from trophystar.lastupdate) AS month,sum(trophystar.ct) as totstar,trophystar.id as category from trophystar where (trophystar.lastupdate>=".$this->db->escape($startdate)." and trophystar.lastupdate<=".$this->db->escape($enddate).") and  trophystar.gu_id=".$this->db->escape($userid)." group by month,trophystar.id ");
								//echo $this->db->last_query(); exit;
								return $query->result_array();
								
		 }
		  
		 function getPlaysCountPrior($r)
		 {	
			 $query = $this->db->query("select playedGamesCount as max_playedGamesCount from (SELECT  (select count(distinct(lastupdate)) from game_reports gr where gr.gs_id=g.gs_id and gr.gu_id=".$this->db->escape($r['id'])." and gr.g_id=cpg.game_id and lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."') as playedGamesCount FROM class_plan_game cpg join games g on g.gid=cpg.game_id WHERE cpg.class_id=".$this->db->escape($r['grade_id'])." and cpg.plan_id=".$this->db->escape($r['gp_id'])." and g.gs_id in (59,60,61,62,63) and cpg.game_id not in(243,283,23,65,100,146,140,179,186,226,266,307,233)) as a1 order by playedGamesCount ASC limit 1");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }		 
		 	function getPlayCounts($r,$max_playedGamesCount)
		 {
			 $query = $this->db->query("select (select IFNULL(max(SessionID),0) from sk_user_game_list where userID=".$this->db->escape($r['id'])." and planID=".$this->db->escape($r['gp_id']).") as maxSession, (select skill_count from sk_plan_skillcount where school_ID='".$r['sid']."' and plan_ID=".$this->db->escape($r['gp_id']).") as skillCount, (select count(*) FROM class_plan_game cpg join games g on g.gid=cpg.game_id WHERE cpg.class_id='".$r['grade_id']."' and cpg.plan_id=".$this->db->escape($r['gp_id'])." and g.gs_id in (59,60,61,62,63) and g.gid not in(243,283,23,65,100,146,140,179,186,226,266,307,233) ) as acualGamesCount,count(*) as playedGamesCount  from (SELECT game_id,gs_id,(select count(distinct(lastupdate)) from game_reports gr where gr.gs_id=g.gs_id and gr.gu_id='".$r['id']."' and gr.g_id=cpg.game_id and lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."' ) as playedGamesCount FROM class_plan_game cpg join games g on g.gid=cpg.game_id WHERE cpg.class_id='".$r['grade_id']."' and cpg.plan_id=".$this->db->escape($r['gp_id'])." and g.gs_id in (59,60,61,62,63) and cpg.game_id not in(243,283,23,65,100,146,140,179,186,226,266,307,233)) as a1 where a1.playedGamesCount!=0 and a1.playedGamesCount>=".$this->db->escape($max_playedGamesCount)."");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }		 
		 	function getSKBspi($r,$session_start_range,$session_end_range)
		 {
			
			 $query = $this->db->query("select ROUND(avg(gamescore),2) as gamescore,gs_id from (select avg(gamescore) as gamescore ,playedMonth,gs_id from (SELECT (AVG(game_score)) as gamescore ,gs_id , lastupdate,DATE_FORMAT(`lastupdate`,'%m') as playedMonth,session_id  FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id=".$this->db->escape($r['id'])." and  (lastupdate between '".$this->session->astartdate."'and '".$this->session->aenddate."') and (session_id between ".$this->db->escape($session_start_range)." and ".$this->db->escape($session_end_range).") and session_id!=0 group by gs_id , session_id) as a1 group by gs_id,session_id) as a2 group by gs_id order by gamescore asc");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }	
		  public function updateSKGameList($r)
		 {
			 //echo 'hello'; exit;
		$query = $this->db->query("update sk_user_game_list set status=1 where userID=".$this->db->escape($r['id'])." and planID=".$this->db->escape($r['gp_id'])."");
		//echo $this->db->last_query(); exit;
			 
		 }	
		  public function insertSKGameList($r,$maxsession,$month_array_skill,$levelid,$Session_StartRange,$Session_EndRange)
		 {
		
		$query = $this->db->query("insert into sk_user_game_list(userID,planID,SessionID,weakSkills,levelid,status,created_date,session_start_range,session_end_range) values ('".$r['id']."',".$this->db->escape($r['gp_id']).",".$this->db->escape($maxsession).",'".implode (",", $month_array_skill)."','".implode (",", $levelid)."',0,'".date("Y-m-d")."',".$this->db->escape($Session_StartRange).",".$this->db->escape($Session_EndRange).")");
		//echo $this->db->last_query(); exit;
			 
		 }	
		 	 
		 
		 public function getbspireport1($userid,$mnths)
		 {
	
		$query = $this->db->query("SELECT (".$this->config->item('skilllogic')."(`game_score`)) as gamescore,gs_id , lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id=".$this->db->escape($userid)." and DATE_FORMAT(lastupdate,'%b-%Y') in (".$this->db->escape($mnths).") and  date(lastupdate) between '".$this->session->astartdate."' and '".$this->session->aenddate."' group by gs_id , lastupdate");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }
	  
		public function getstudentplay($userid,$txtFDate,$txtTDate)
		 {
	
		$query = $this->db->query("SELECT count(*) as PalyCount,lastupdate,gs_id ,
		(select concat(fname,' ',lname) from users u where u.id=".$this->db->escape($userid).") as Name,
		(select username from users u where u.id=".$this->db->escape($userid).") as Username,
		(select concat((select classname from class c where c.id=u.grade_id),' - ',section) from users u where u.id=".$this->db->escape($userid).") as Class from game_reports where gu_id=".$this->db->escape($userid)." and  date(lastupdate) between '".$this->session->astartdate."' and '".$this->session->aenddate."' and  date(lastupdate) between ".$this->db->escape($txtFDate)." and ".$this->db->escape($txtTDate)." group by date(lastupdate),gs_id order by date(lastupdate)");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		 }

	public function insertsparkies($arrofinput)	 
	{  //echo "<pre>";print_r($arrofinput);exit;
		/* $stored_procedure = "CALL insertsparkies(?,?,?,?,?,?,?,?,?) ";
		$result = $this->db->query($sp,$arrofinput); 	 */
		$inDatetime=date("Y-m-d H:i:s");
		$inDate=date("Y-m-d");
		$inTime=date('H:i:s');
	
		$query = $this->db->query("CALL insertsparkiesnew(".$this->db->escape($arrofinput['inSID']).",".$this->db->escape($arrofinput['inGID']).",".$this->db->escape($arrofinput['inUID']).",".$this->db->escape($arrofinput['inScenarioCode']).",".$this->db->escape($arrofinput['inTotal_Ques']).",".$this->db->escape($arrofinput['inAttempt_Ques']).",".$this->db->escape($arrofinput['inAnswer']).",".$this->db->escape($arrofinput['inGame_Score']).",".$this->db->escape($arrofinput['inPlanid']).",".$this->db->escape($arrofinput['inGameid']).",".$this->db->escape($inDatetime).",".$this->db->escape($inDate).",'".$inTime."')");
		mysqli_next_result($this->db->conn_id);
		return $query->result_array();
	}
	public function insertnewsfeeddata($arrofinput)	 
	{
		$inDatetime=date("Y-m-d H:i:s");
		$inDate=date("Y-m-d");
		
		$query = $this->db->query("CALL insertnewsfeeddata(".$this->db->escape($arrofinput['inSID']).",".$this->db->escape($arrofinput['inGID']).",'".$arrofinput['inUID']."',".$this->db->escape($arrofinput['inScenarioCode']).",".$this->db->escape($arrofinput['inTotal_Ques']).",".$this->db->escape($arrofinput['inAttempt_Ques']).",".$this->db->escape($arrofinput['inAnswer']).",".$this->db->escape($arrofinput['inGame_Score']).",".$this->db->escape($arrofinput['inPlanid']).",".$this->db->escape($arrofinput['inGameid']).",".$this->db->escape($inDatetime).",".$this->db->escape($inDate).")");
		
		//return $query->result_array();
	}
	
	public function getMyCurrentSparkies($school_id,$grade_id,$userid,$startdate,$enddate)
    {
		
		$query = $this->db->query("CALL getMyCurrentSparkies(".$this->db->escape($school_id).",".$this->db->escape($grade_id).",".$this->db->escape($userid).",".$this->db->escape($startdate).",".$this->db->escape($enddate).")");
		mysqli_next_result($this->db->conn_id);
		return $query->result_array();

	}	
	public function getNewsFeed($school_id,$grade_id,$userid,$type,$page,$startdate,$enddate)
	{	//echo "CALL getNewsFeed(".$this->db->escape($school_id).",".$this->db->escape($grade_id).",".$this->db->escape($userid).",".$this->db->escape($type).")";exit;
		$query = $this->db->query("CALL getNewsFeed(".$this->db->escape($school_id).",".$this->db->escape($grade_id).",".$this->db->escape($userid).",".$this->db->escape($type).",".$this->db->escape($startdate).",".$this->db->escape($enddate).")");
		mysqli_next_result($this->db->conn_id);
		return $query->result_array();
	}
	public function getNewsFeedCount($school_id,$grade_id,$userid,$type,$page,$startdate,$enddate)
	{		//echo "CALL getNewsFeedCount(".$this->db->escape($school_id).",".$this->db->escape($grade_id).",".$this->db->escape($userid).",".$this->db->escape($type).")";exit;
		$inDate=date("Y-m-d");
			$query = $this->db->query("CALL getNewsFeedCount(".$this->db->escape($school_id).",".$this->db->escape($grade_id).",".$this->db->escape($userid).",".$this->db->escape($type).",".$this->db->escape($startdate).",".$this->db->escape($enddate).",".$this->db->escape($inDate).")");
			mysqli_next_result($this->db->conn_id);
			return $query->result_array();
	}	
	
	public function getTopSparkiesValue($startdate,$enddate,$school_ID,$grad_ID)
	{ 	
		
		$query = $this->db->query("select U_ID,points,monthName,monthNumber,S_ID,G_ID,group_concat(studentname) as username from (select U_ID,points,monthName,monthNumber,S_ID,G_ID,(select username from `users` where id = U_ID) as username,(select CONCAT(fname,' ',lname) from `users` where id = U_ID) as studentname from (select `a2`.`U_ID` AS `U_ID`,sum(`a2`.`Points`) AS `points`,date_format(`a2`.`Datetime`,'%b') AS `monthName`,date_format(`a2`.`Datetime`,'%m') AS `monthNumber`,a2.S_ID,a2.G_ID from user_sparkies_history `a2` where (date_format(`a2`.`Datetime`,'%Y-%m-%d') between ".$this->db->escape($startdate)." and ".$this->db->escape($enddate).")   group by date_format(`a2`.`Datetime`,'%m'),`a2`.`U_ID`) a1 where a1.U_ID in (select id from users where status=1 and visible=1) and a1.G_ID=".$this->db->escape($grad_ID)." and a1.S_ID=".$this->db->escape($school_id)." and  a1.points=(select points from vv2 where vv2.monthNumber =a1.monthNumber  and vv2.monthNumber!=".date('m')." and vv2.G_ID=".$this->db->escape($grad_ID)." and vv2.S_ID=".$this->db->escape($school_id)." ) ) as a5 group by monthNumber");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function getTopPlayedGames($startdate,$enddate,$school_ID,$grad_ID)
	{
		
		$query = $this->db->query("select countofplayed,gu_id,monthName,monthNumber,grad_ID,gs_ID,group_concat(studentname) as username  from (select countofplayed,gu_id,monthName,monthNumber,grad_ID,gs_ID,(select username from `users` where id = gu_id) as username,(select CONCAT(fname,' ',lname) from `users` where id = gu_id) as studentname from (select count(`gu_id`) AS `countofplayed`,`gu_id` AS `gu_id`,date_format(`lastupdate`,'%b') AS `monthName`,date_format(`lastupdate`,'%m') AS `monthNumber`,(select `sid` from `users` where (`id` = `gu_id`)) AS `gs_ID`,(select `grade_id` from `users` where (`id` = `gu_id`)) AS `grad_ID` from `game_reports` where (convert(date_format(`lastupdate`,'%Y-%m-%d') using latin1) between '".$this->session->astartdate."' and '".$this->session->aenddate."' ) group by date_format(`lastupdate`,'%m'),`gu_id`) a1 where a1.gu_id in (select id from users where status=1 and visible=1) and a1.grad_ID=".$this->db->escape($grad_ID)." and a1.gs_ID=".$this->db->escape($school_id)." and a1.countofplayed in (select countofval from vi_gameplayed v where v.monthNumber=a1.monthNumber and v.monthNumber!=".date('m')." and  v.school_id=".$this->db->escape($school_id)." and v.grad_id=".$this->db->escape($grad_ID).") ) as a5 group by monthNumber");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function getTopBSPIScore($startdate,$enddate,$school_ID,$grad_ID)
	{ 	
		$query = $this->db->query("select bspi,monthName,monthNumber,sid,gu_id,grade_id,(select GROUP_CONCAT(CONCAT(fname,' ',lname)) from users where id = gu_id) as username,classname,school_name from(select bspi,monthName,monthNumber,sid,gu_id,grade_id,(select CONCAT(fname,' ',lname) from users where id = gu_id) as username,(select classname from class where id = grade_id)as classname,(select school_name from schools where id = sid)as school_name from(select finalscore as bspi,gu_id,monthNumber,monthName,sid,grade_id from vii_avguserbspiscorebymon ) as a1 where a1.gu_id in (select id from users where status=1 and visible=1) and a1.grade_id=".$this->db->escape($grad_ID)." and a1.sid=".$this->db->escape($school_id)."  and ROUND(a1.bspi,2) in (select bspi from vii_topbspiscore as vv3 where vv3.monthNumber =a1.monthNumber and  vv3.monthNumber!=".date('m')." and vv3.grade_id=".$this->db->escape($grad_ID)." and vv3.sid=".$this->db->escape($school_id).")) as a5 group by monthNumber");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function getSuperAngels($startdate,$enddate,$school_ID,$grad_ID)
	{
		$query = $this->db->query("select ans,gu_id,monthName,monthNumber,grad_ID,gs_ID,group_concat(studentname) as username from (select ans,gu_id,monthName,monthNumber,grad_ID,gs_ID,(select username from `users` where id = gu_id) as username,(select CONCAT(fname,' ',lname) from `users` where id = gu_id) as studentname from (select sum(answer) as ans,`game_reports`.`gu_id` AS `gu_id`,date_format(`game_reports`.`lastupdate`,'%b') AS `monthName`,date_format(`game_reports`.`lastupdate`,'%m') AS `monthNumber`,(select `users`.`sid` from `users` where (`users`.`id` = `game_reports`.`gu_id`)) AS `gs_ID`,(select `users`.`grade_id` from `users` where (`users`.`id` = `game_reports`.`gu_id`)) AS `grad_ID` from `game_reports` where (convert(date_format(`game_reports`.`lastupdate`,'%Y-%m-%d') using latin1) between '".$this->session->astartdate."' and '".$this->session->aenddate."' ) group by date_format(`game_reports`.`lastupdate`,'%m'),`game_reports`.`gu_id`) a1 where a1.gu_id in (select id from users where status=1 and visible=1) and a1.grad_ID=".$this->db->escape($grad_ID)." and a1.gs_ID=".$this->db->escape($school_id)." and a1.ans in (select ans from vii_topsuperangels v where v.monthNumber=a1.monthNumber and  v.monthNumber!=".date('m')." and v.gs_ID=".$this->db->escape($school_id)." and v.grad_ID=".$this->db->escape($grad_ID).")) as a5 group by monthNumber");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	
	/* Hari */
	
	public function getbadgeone($startdate,$enddate,$grad_ID,$userid,$school_ID)	 
	{
		$currentmonth = date('F');
		
		$query = $this->db->query("select bspi,monthName,monthNumber,sid,count(gu_id) as total,grade_id from(select finalscore as bspi,gu_id,monthNumber,monthName,sid,grade_id from vii_avguserbspiscorebymon) as a1 where a1.grade_id=".$this->db->escape($grad_ID)." and a1.sid=".$this->db->escape($school_id)."  and a1.gu_id in(".$this->db->escape($userid).") and ROUND(a1.bspi,2)=(select bspi from vii_topbspiscore  as vv3 where vv3.monthNumber =a1.monthNumber and  vv3.monthNumber!=".date('m')." and vv3.grade_id=".$this->db->escape($grad_ID)." and vv3.sid=".$this->db->escape($school_id).")");
		
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getbadgetwo($startdate,$enddate,$grad_ID,$userid,$school_ID)	 
	{
		$currentmonth = date('F');
		
		$query = $this->db->query("select countofplayed,count(gu_id) as total,monthName,monthNumber,grad_ID,gs_ID from (select count(`gu_id`) AS `countofplayed`,`gu_id` AS `gu_id`,date_format(`lastupdate`,'%b') AS `monthName`,date_format(`lastupdate`,'%m') AS `monthNumber`,(select `sid` from `users` where (`id` = `gu_id`)) AS `gs_ID`,(select `grade_id` from `users` where (`id` = `gu_id`)) AS `grad_ID` from `game_reports` where (convert(date_format(`lastupdate`,'%Y-%m-%d') using latin1) between '".$this->session->astartdate."' and '".$this->session->aenddate."' ) group by date_format(`lastupdate`,'%m'),`gu_id`) a1 where a1.grad_ID=".$this->db->escape($grad_ID)." and a1.gs_ID=".$this->db->escape($school_id)." and a1.gu_id in(".$this->db->escape($userid).") and a1.countofplayed in (select countofval from vi_gameplayed v where v.monthNumber=a1.monthNumber and v.monthNumber!=".date('m')." and  v.school_id=".$this->db->escape($school_id)." and v.grad_id=".$this->db->escape($grad_ID).")");
		
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getbadgethree($startdate,$enddate,$gradeid,$userid,$schoolid)	 
	{
		$currentmonth = date('F');
		
		$query = $this->db->query("select ans,count(gu_id) as total,monthName,monthNumber,grad_ID,gs_ID from (select sum(answer) as ans,`game_reports`.`gu_id` AS `gu_id`,date_format(`game_reports`.`lastupdate`,'%b') AS `monthName`,date_format(`game_reports`.`lastupdate`,'%m') AS `monthNumber`,(select `users`.`sid` from `users` where (`users`.`id` = `game_reports`.`gu_id`)) AS `gs_ID`,(select `users`.`grade_id` from `users` where (`users`.`id` = `game_reports`.`gu_id`)) AS `grad_ID` from `game_reports` where (convert(date_format(`game_reports`.`lastupdate`,'%Y-%m-%d') using latin1) between '".$this->session->astartdate."' and '".$this->session->aenddate."' ) group by date_format(`game_reports`.`lastupdate`,'%m'),`game_reports`.`gu_id`) a1 where a1.grad_ID=".$this->db->escape($gradeid)." and a1.gs_ID=".$this->db->escape($schoolid)." and a1.gu_id in(".$this->db->escape($userid).") and a1.ans in (select ans from vii_topsuperangels v where v.monthNumber=a1.monthNumber and  v.monthNumber!=".date('m')." and v.gs_ID=".$this->db->escape($schoolid)." and v.grad_ID=".$this->db->escape($gradeid).")");
		
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	
	public function getthemefile()
    {
		$query = $this->db->query("select * from thememaster where status = 1 ");
		return $query->result_array();
	}
	
	public function get_user_themefile($userid)
    {
		$query = $this->db->query("select usertheme from users where id = ".$this->db->escape($userid)." ");
		return $query->result_array();
		 
	}
	
	public function updatethemefile($filename,$userid)
    {
	$query = $this->db->query("UPDATE users SET usertheme=".$this->db->escape($filename)." where id = ".$this->db->escape($userid)." ");
 
	}
	public function getOverallSparkyTopper($startdate,$enddate,$school_ID,$grad_ID)
	{ 	
		$query = $this->db->query("select U_ID,points,S_ID,G_ID,(select GROUP_CONCAT(studentname) from users where id = U_ID) as username,classname,GROUP_CONCAT(school_name) as school_name from 

(select U_ID,points,monthName,monthNumber,S_ID,G_ID,(select username from users where id = U_ID) as username,(select CONCAT(fname,' ',lname) from users where id = U_ID) as studentname,(select classname from class where id = G_ID)as classname,(select school_name from schools where id = S_ID)as school_name from 

(select a2.U_ID AS U_ID,sum(a2.Points) AS points,date_format(a2.Datetime,'%b') AS monthName,date_format(a2.Datetime,'%m') AS monthNumber,a2.S_ID,a2.G_ID from user_sparkies_history a2 where a2.S_ID in (select schools.id from schools where visible = 1) and a2.U_ID in (select id from users where status=1 and visible=1) group by a2.U_ID) a1 

where a1.points in (select points from vi_overallcrownytoppers as vv3 where a1.G_ID=vv3.G_ID )) as a5 group by classname");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function getOverallBspiTopper($startdate,$enddate,$school_ID,$grad_ID)
	{ 	
		$query = $this->db->query("select bspi,sid,gu_id,grade_id,(select GROUP_CONCAT(studentname) from users where id = gu_id) as username,classname,GROUP_CONCAT(school_name) as school_name from

(select bspi,sid,gu_id,grade_id,(select username from users where id = gu_id) as username,(select CONCAT(fname,' ',lname) from users where id = gu_id) as studentname,(select classname from class where id = grade_id)as classname,(select school_name from schools where id = sid)as school_name from

(select finalscore as bspi,v1.gu_id,v1.sid,v1.grade_id from vii_avguserbspiscore as v1
join users u on u.id = v1.gu_id where u.sid in (select id from schools where visible = 1) and u.status=1 and visible=1) as a1

 where a1.bspi in (select bspi from vii_overallbspitoppers as vv3 where a1.grade_id=vv3.grade_id )) as a5 group by classname");
	
		return $query->result_array();
	}
	 public function getClassPerformace_data($schoolid,$gradeid,$section,$tablename)
	{
 
		$query = $this->db->query("select rowNumber,id, name,lname,avatarimage,bspi from (select  (@cnt := @cnt + 1) AS rowNumber,id, fname as name,lname,avatarimage, IF(avgbspiset1 IS NULL,0,avgbspiset1) as bspi from (select id as id, fname,lname,avatarimage, grade_id,(select classname from class where id=grade_id) as gradename,a3.finalscore as avgbspiset1 from users mu  left join 
 (SELECT SUM(score)/5 as finalscore, gu_id, (SELECT sid from users where id=gu_id) as schoolid from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (".$this->config->item('skilllogic')."(`game_score`)) as score , gs_id , gu_id, lastupdate FROM ".$this->db->escape($tablename)." join users as u on u.id=gu_id  WHERE gs_id in (59,60,61,62,63) and lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."' and sid=".$this->db->escape($schoolid)." and grade_id=".$this->db->escape($gradeid)." and section=".$this->db->escape($section)." and status=1 and visible=1 group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id) a3   on a3.gu_id=mu.id where sid=".$this->db->escape($schoolid)." and grade_id=".$this->db->escape($gradeid)." and section=".$this->db->escape($section)." and status=1 and visible=1  ORDER BY avgbspiset1 DESC ) as a5 CROSS JOIN (SELECT @cnt := 0) AS dummy) as b1 order by bspi asc");
		//echo $this->db->last_query(); 
		//exit;
			return $query->result_array();
	}
	public function GetBadgeData($school_id,$grade_id,$startdate,$enddate)
	{
		$query = $this->db->query("CALL GetBadgeData(".$this->db->escape($school_id).",".$this->db->escape($grade_id).",".$this->db->escape($startdate).",".$this->db->escape($enddate).",'".date("Y-m-d H:i:s")."','".date("Y-m-d")."')");
		//return $query->result_array();
	}
	
	public function termsandcondition($terms,$username)
	{
		$query = $this->db->query("UPDATE users SET agreetermsandservice = ".$this->db->escape($terms)." WHERE username=".$this->db->escape($username)." ");
	}
	
	public function getMemoryRange()
	{
		$query = $this->db->query("select max(totalCount) as memory,CONCAT(startRange,'-',endRange) as rangeval from (select r.startRange,r.endRange,count(a5.gamescore) totalCount
from(select gamescore,gs_id,lastupdate,playedMonth,gu_id from (SELECT (AVG(game_score)) as gamescore,gs_id,lastupdate,DATE_FORMAT(lastupdate,'%m') as playedMonth,gu_id  FROM game_reports join users as u on u.id=gu_id WHERE gs_id in(59) and  lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."' and sid='".$this->session->school_id."' and grade_id='".$this->session->game_grade."' group by gu_id,gs_id,lastupdate) as a1 where gamescore!=0 group by  gs_id,lastupdate order by gamescore ASC)a5 inner join range_values r on a5.gamescore >startrange  and a5.gamescore <=endrange group by r.startRange, r.endRange order by startRange asc )a2 group by totalCount order by totalCount desc limit 1");
		return $query->result_array();
	}
	public function getVisualProcessingRange()
	{
		$query = $this->db->query("select max(totalCount) as memory,CONCAT(startRange,'-',endRange) as rangeval from (select r.startRange,r.endRange,count(a5.gamescore) totalCount
from(select gamescore,gs_id,lastupdate,playedMonth,gu_id from (SELECT (AVG(game_score)) as gamescore,gs_id,lastupdate,DATE_FORMAT(lastupdate,'%m') as playedMonth,gu_id  FROM game_reports  join users as u on u.id=gu_id WHERE gs_id in(60) and  lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."' and sid='".$this->session->school_id."' and grade_id='".$this->session->game_grade."' group by gu_id,gs_id,lastupdate) as a1 where gamescore!=0 group by  gs_id,lastupdate order by gamescore ASC)a5 inner join range_values r on a5.gamescore >startrange  and a5.gamescore <=endrange group by r.startRange, r.endRange order by startRange asc )a2 group by totalCount order by totalCount desc limit 1");
		return $query->result_array();
	}
	public function getFocusAttentionRange()
	{
		$query = $this->db->query("select max(totalCount) as memory,CONCAT(startRange,'-',endRange) as rangeval from (select r.startRange,r.endRange,count(a5.gamescore) totalCount
from(select gamescore,gs_id,lastupdate,playedMonth,gu_id from (SELECT (AVG(game_score)) as gamescore,gs_id,lastupdate,DATE_FORMAT(lastupdate,'%m') as playedMonth,gu_id  FROM game_reports  join users as u on u.id=gu_id WHERE gs_id in(61) and  lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."' and sid='".$this->session->school_id."' and grade_id='".$this->session->game_grade."' group by gu_id,gs_id,lastupdate) as a1 where gamescore!=0 group by  gs_id,lastupdate order by gamescore ASC)a5 inner join range_values r on a5.gamescore >startrange  and a5.gamescore <=endrange group by r.startRange, r.endRange order by startRange asc )a2 group by totalCount order by totalCount desc limit 1");
		return $query->result_array();
	}
	public function getProblemSolvingRange()
	{
		$query = $this->db->query("select max(totalCount) as memory,CONCAT(startRange,'-',endRange) as rangeval from (select r.startRange,r.endRange,count(a5.gamescore) totalCount
from(select gamescore,gs_id,lastupdate,playedMonth,gu_id from (SELECT (AVG(game_score)) as gamescore,gs_id,lastupdate,DATE_FORMAT(lastupdate,'%m') as playedMonth,gu_id  FROM game_reports  join users as u on u.id=gu_id WHERE gs_id in(62) and  lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."' and sid='".$this->session->school_id."' and grade_id='".$this->session->game_grade."' group by gu_id,gs_id,lastupdate) as a1 where gamescore!=0 group by  gs_id,lastupdate order by gamescore ASC)a5 inner join range_values r on a5.gamescore >startrange  and a5.gamescore <=endrange group by r.startRange, r.endRange order by startRange asc )a2 group by totalCount order by totalCount desc limit 1");
		return $query->result_array();
	}
	public function getLinguisticsRange()
	{
		$query = $this->db->query("select max(totalCount) as memory,CONCAT(startRange,'-',endRange) as rangeval from (select r.startRange,r.endRange,count(a5.gamescore) totalCount
from(select gamescore,gs_id,lastupdate,playedMonth,gu_id from (SELECT (AVG(game_score)) as gamescore,gs_id,lastupdate,DATE_FORMAT(lastupdate,'%m') as playedMonth,gu_id  FROM game_reports join users as u on u.id=gu_id WHERE gs_id in(63) and  lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."' and sid='".$this->session->school_id."' and grade_id='".$this->session->game_grade."' group by gu_id,gs_id,lastupdate) as a1 where gamescore!=0 group by  gs_id,lastupdate order by gamescore ASC)a5 inner join range_values r on a5.gamescore >startrange  and a5.gamescore <=endrange group by r.startRange, r.endRange order by startRange asc )a2 group by totalCount order by totalCount desc limit 1");
		return $query->result_array();
	}
	public function checkbandwidthisexist($schoolID)
	{
		$query = $this->db->query("CALL checkbandwidthisexist(".$this->db->escape($schoolid).",'".date("Y-m-d H:i:s")."')");
		mysqli_next_result($this->db->conn_id);
		return $query->result_array();
	}
	public function insertbandwidth($schoolID,$user_id,$Bps,$Kbps,$Mbps)
	{
		$query = $this->db->query("CALL insertbandwidth(".$this->db->escape($schoolID).",".$this->db->escape($user_id).",".$this->db->escape($Bps).",".$this->db->escape($Kbps).",".$this->db->escape($Mbps).",'".date("Y-m-d H:i:s")."')");
		//echo $this->db->last_query(); exit;
		mysqli_next_result($this->db->conn_id);
	}
	public function getPlayedSkillCount($user_id)
	{
		$query = $this->db->query("SELECT COUNT(id),gs_id FROM `gamedata` WHERE gu_id =".$this->db->escape($user_id)." and lastupdate='".date("Y-m-d")."' group by gs_id ");
		return $query->result_array();
	}
	public function IsSkillkitExist($userid,$plan_id)
	{
		$query = $this->db->query("select count(ID) as isenable from sk_user_game_list where userID=".$this->db->escape($userid)." and planID=".$this->db->escape($plan_id)." and status=0  and (".$this->session->Next_Session_id."  between session_start_range and session_end_range) ");
		return $query->result_array();
	}
	public function checkscheduledays($gradeid,$section,$schoolid)
	{
	$curdate=date('Y-m-d');
	$curday = date('l', strtotime($curdate)); 
	$gradecolumn = strtolower($curday).'_'."grade";
	$sectioncolumn = strtolower($curday).'_'."section";

	$query = $this->db->query("select case when count(*)>0 THEN 1 else 0 END as scheduleday from schools_period_schedule where academic_id=20 and school_id='".$this->db->escape($schoolid)."' and ".$gradecolumn." = (select REPLACE(classname,'Grade ','') from class where id =".$this->db->escape($gradeid).") and ".$sectioncolumn." = ".$this->db->escape($section)." and status = 'Y' and school_id not in(select school_id from schools_leave_list where leave_date=".$this->db->escape($curdate)." and school_id='".$this->db->escape($schoolid)."' )");
	//	 echo $this->db->last_query(); exit;
	return $query->result_array();
	} 

	 public function getgameid($gamename)
	{
		$query = $this->db->query("select gid from games where game_html='".$gamename."' ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function checkgame($gameid)
	{
		$curdate=date('Y-m-d');
		$schoolid = $this->session->school_id;
		$gradeid = $this->session->game_grade;
		$section = $this->session->section;
		
		$query = $this->db->query("select count(distinct gid) as gameid from rand_selection where gid=".$this->db->escape($gameid)." and created_date=".$this->db->escape($curdate)." and grade_id=".$this->db->escape($gradeid)."  and school_id=".$this->db->escape($schoolid)."  ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
		
	public function insert_login_log($userid,$sessionid,$ip,$country,$region,$city,$isp,$browser,$status)
	{
		$query = $this->db->query('INSERT INTO user_login_log(userid,sessionid,first_login_datetime,created_date,lastupdate,logout_date,ip,country,region,city,browser,isp,status)VALUES('.$this->db->escape($userid).','.$this->db->escape($sessionid).',"'.date("Y-m-d H:i:s").'","'.date("Y-m-d H:i:s").'","'.date("Y-m-d H:i:s").'","'.date("Y-m-d H:i:s").'", '.$this->db->escape($ip).','.$this->db->escape($country).','.$this->db->escape($region).','.$this->db->escape($city).','.$this->db->escape($browser).','.$this->db->escape($isp).','.$this->db->escape($status).')');
		return $query;
	}
 public function update_login_log($userid,$sessionid,$now)
		{
			$query = $this->db->query('update user_login_log set lastupdate='.$this->db->escape($now).' where userid='.$this->db->escape($userid).' and sessionid='.$this->db->escape($sessionid).'');
			return $query;
			
		}
		public function update_logout_log($userid,$sessionid)
		{
			$query = $this->db->query('update user_login_log set lastupdate="'.date("Y-m-d H:i:s").'",logout_date="'.date("Y-m-d H:i:s").'" where userid='.$this->db->escape($userid).' and sessionid='.$this->db->escape($sessionid).'');
			return $query;
			
		}
		public function CheckSkillkitexist($userid)
		{
			$query = $this->db->query("select count(ID) as isavailable from sk_user_game_list where userID=".$this->db->escape($userid)." and DATE(created_date)='".date("Y-m-d")."'");
			return $query->result_array();
		}
		public function getUserPlayedDayscount($userid)
		{
			$query = $this->db->query("select count(distinct(lastupdate)) as playedDate from game_reports gr where gr.gu_id=".$this->db->escape($userid)." and lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."' and session_id!=0 and lastupdate!='".date("Y-m-d")."' ");
			return $query->result_array();
		}
	public function getConfigNoofDaysPlay()
	{
		$query = $this->db->query("select value from config_master where code='SKILLKIT_NODAYSPLAY' and status='Y'");
		return $query->result_array();
	}
	
	/*  PopUp Code Start */
	public function CheckisUser($username,$password)
	{
		$query = $this->db->query("select count(id) as isUser,id,sid,grade_id,(select classname from class where id=grade_id) as gradename,section,username,login_count,fname,lname FROM users a WHERE username=".$this->db->escape($username)." AND password=SHA1(CONCAT(salt1,".$this->db->escape($password).",salt2)) AND status=1 and visible=1 AND (SELECT school_id FROM school_admin WHERE school_id=a.sid AND active=1 and flag=1)");
		return $query->result_array();
	}	
	public function CheckUserStatus($userid)
	{
		$query = $this->db->query("select count(id) as userstatus FROM isuser_log  WHERE User_id=".$this->db->escape($userid)." and Confirmation_type='1' order by id DESC");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function CheckisScheduleday($gradename,$section,$sid)
	{	$curtime=date('H:i:s');
		$currentdaygrade=strtolower(date ('l')."_grade");$currentdaysection=strtolower(date ('l')."_section");
		$query = $this->db->query("SELECT count(schedule_id) as isschedule FROM schools_period_schedule WHERE ".$currentdaygrade."='".ltrim($gradename,'Grade ')."' and ".$currentdaysection."=".$this->db->escape($section)." and school_id=".$this->db->escape($sid)." and academic_id=20 and '".$curtime."' between start_time and end_time");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function insertuserlog($userid,$Login_type,$Confirmation_type)
	{	$curdateandtime=date('Y-m-d h:i:s');
		$this->db->query("INSERT into isuser_log(User_id,Login_type,Confirmation_type,Logged_datetime,Org_userid)values(".$this->db->escape($userid).",".$this->db->escape($Login_type).",".$this->db->escape($Confirmation_type).",'".$curdateandtime."','')");
		return $this->db->insert_id();
		//echo $this->db->last_query(); exit;
	}
	public function fetchrelateduser($userid,$username,$grade_id,$section,$sid)
	{	
		$query =$this->db->query("SELECT username,id FROM users WHERE username like '%".$username."%' and grade_id=".$this->db->escape($grade_id)." and section=".$this->db->escape($section)." and sid=".$this->db->escape($sid)." ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	/*  PopUp Code end */
	public function getgameid_SK($gamename)
	{
		$query = $this->db->query("select ID as gid from sk_games where game_html='".$gamename."' ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	/* -------------------------------------------------------------------------------
		New Overall Topper Concept 
	*/
	public function InsertOverallSparkyToppernew()
	{
		$query = $this->db->query("INSERT into overalltoppers(userid,gradeid,sid,value,type,duedate,created_on)
		select U_ID,G_ID,S_ID,points,'CT','".date("Y-m-d")."','".date("Y-m-d H:i:s")."' from (select U_ID,points,monthName,monthNumber,S_ID,G_ID from 
(select a2.U_ID AS U_ID,sum(a2.Points) AS points,date_format(a2.Datetime,'%b') AS monthName,date_format(a2.Datetime,'%m') AS monthNumber,a2.S_ID,a2.G_ID from user_sparkies_history a2 where a2.S_ID in (select schools.id from schools where visible = 1) and a2.U_ID in (select id from users where status=1 and visible=1) group by a2.U_ID) a1
where a1.points in (select points from vi_overallcrownytoppers as vv3 where a1.G_ID=vv3.G_ID )) as a5 group by G_ID");
		//echo $this->db->last_query(); exit;
		
	}
	public function InsertOverallBspiToppernew()
	{
		$query = $this->db->query("INSERT into overalltoppers(userid,gradeid,sid,value,type,duedate,created_on) 
		select gu_id,grade_id,sid,bspi,'BT','".date("Y-m-d")."','".date("Y-m-d H:i:s")."' from (select bspi,sid,gu_id,grade_id from
(select finalscore as bspi,v1.gu_id,v1.sid,v1.grade_id from vii_avguserbspiscore as v1
join users u on u.id = v1.gu_id where u.sid in (select id from schools where visible = 1) and u.status=1 and visible=1) as a1
 where a1.bspi in (select bspi from vii_overallbspitoppers as vv3 where a1.grade_id=vv3.grade_id )) as a5 group by grade_id");
	
		
	}
	public function CheckTodaydataExist()
	{
		$query = $this->db->query("select count(id) as isexist from overalltoppers where duedate='".date("Y-m-d")."'");
		return $query->result_array();
	}
	public function ClearToppersData()
	{
		$query = $this->db->query("TRUNCATE TABLE overalltoppers");
		//return $query->result_array();
	}
	public function getOverallSparkyToppernew($startdate,$enddate,$school_ID,$grad_ID)
	{
		$query = $this->db->query("select GROUP_CONCAT(username) as username,GROUP_CONCAT(studentname) as studentname,classname,GROUP_CONCAT(school_name) as school_name,points from(Select gradeid,(select username from users where id=userid) as username,(select CONCAT(fname,' ',lname) from users where id=userid) as studentname,(select classname from class where id =gradeid)as classname,(select school_name from schools where id = sid)as school_name,value as points from overalltoppers where type='CT')c1 group by gradeid");
		return $query->result_array();
	}
	public function getOverallBspiToppernew($startdate,$enddate,$school_ID,$grad_ID)
	{
		$query = $this->db->query("select GROUP_CONCAT(username) as username,GROUP_CONCAT(studentname) as studentname,classname,GROUP_CONCAT(school_name) as school_name,bspi from(Select gradeid,(select username from users where id=userid) as username,(select CONCAT(fname,' ',lname) from users where id=userid) as studentname,(select classname from class where id =gradeid)as classname,(select school_name from schools where id = sid)as school_name,value as bspi from overalltoppers where type='BT')b1 group by gradeid");
		return $query->result_array();
	}
	public function Schools_Wise_Period_Insert($startdate,$enddate)
	{
		$query = $this->db->query("CALL Schools_Wise_Period_Insert(".$this->db->escape($startdate).",".$this->db->escape($enddate).")");
		mysqli_next_result($this->db->conn_id);
	}
/* ---------------------- Leader Board API Insert Start -----------------------*/
	public function CheckTodayLeaderboardDataExist($sid,$gid,$monthno)
	{
		$query = $this->db->query("select count(id) as isexist from leaderboard where year=YEAR('".date("Y-m-d")."') and monthnumber in(".$monthno.") and sid=".$this->db->escape($sid)." and gradeid=".$this->db->escape($gid)." ");
		return $query->result_array();
	}
	public function GetSchoolDetails()
	{
		$query = $this->db->query("select id,school_name,(select group_concat(class_id) from skl_class_plan where school_id=s.id) as grade from schools as s where status=1 and active=1 and visible=1");
		return $query->result_array();
	}
	public function InsertTopSparkiesValue($startdate,$enddate,$school_ID,$grad_ID)
	{
		$query = $this->db->query("INSERT into leaderboard(sid,gradeid,year,monthname,monthnumber,userid,value,type,Created_on)select S_ID,G_ID,Year,monthName,monthNumber,U_ID,points,'CB','".date("Y-m-d H:i:s")."' from (select U_ID,points,monthName,monthNumber,Year,S_ID,G_ID,(select username from users where id = U_ID) as username,(select CONCAT(fname,' ',lname) from users where id = U_ID) as studentname from (select a2.U_ID AS U_ID,sum(a2.Points) AS points,date_format(a2.Datetime,'%b') AS monthName,date_format(Datetime,'%Y') AS Year,date_format(a2.Datetime,'%m') AS monthNumber,a2.S_ID,a2.G_ID from user_sparkies_history a2 where (date_format(a2.Datetime,'%Y-%m-%d') between ".$this->db->escape($startdate)." and ".$this->db->escape($enddate).")   group by date_format(a2.Datetime,'%m'),a2.U_ID) a1 where a1.U_ID in (select id from users where status=1 and visible=1) and a1.G_ID=".$this->db->escape($grad_ID)." and a1.S_ID=".$this->db->escape($school_id)." and  a1.points=(select points from vv2 where vv2.monthNumber =a1.monthNumber  and vv2.monthNumber!=".date('m')." and vv2.G_ID=".$this->db->escape($grad_ID)." and vv2.S_ID=".$this->db->escape($school_id)." ) ) as a5 group by monthNumber");
		//echo $this->db->last_query(); exit;
		
	}
	public function InsertTopPlayedGames($startdate,$enddate,$school_ID,$grad_ID)
	{
		$query = $this->db->query("INSERT into leaderboard(sid,gradeid,year,monthname,monthnumber,userid,value,type,Created_on)select gs_ID,grad_ID,Year,monthName,monthNumber,group_concat(gu_id),countofplayed,'SGB','".date("Y-m-d H:i:s")."'  from (select countofplayed,gu_id,monthName,monthNumber,Year,grad_ID,gs_ID,(select username from users where id = gu_id) as username,(select CONCAT(fname,' ',lname) from users where id = gu_id) as studentname from (select count(gu_id) AS countofplayed,gu_id AS gu_id,date_format(lastupdate,'%b') AS monthName,date_format(lastupdate,'%m') AS monthNumber,date_format(lastupdate,'%Y') AS Year,(select sid from users where (id = gu_id)) AS gs_ID,(select grade_id from users where (id = gu_id)) AS grad_ID from game_reports where (convert(date_format(lastupdate,'%Y-%m-%d') using latin1) between ".$this->db->escape($startdate)." and ".$this->db->escape($enddate)." ) group by date_format(lastupdate,'%m'),gu_id) a1 where a1.gu_id in (select id from users where status=1 and visible=1) and a1.grad_ID=".$this->db->escape($grad_ID)." and a1.gs_ID=".$this->db->escape($school_id)." and a1.countofplayed in (select countofval from vi_gameplayed v where v.monthNumber=a1.monthNumber and v.monthNumber!=".date('m')." and  v.school_id=".$this->db->escape($school_id)." and v.grad_id=".$this->db->escape($grad_ID).") ) as a5 group by monthNumber");
		//echo $this->db->last_query(); exit;
	}
	public function InsertTopBSPIScore($startdate,$enddate,$school_ID,$grad_ID)
	{ 	
		$query = $this->db->query("INSERT into leaderboard(sid,gradeid,year,monthname,monthnumber,userid,value,type,Created_on)select sid,grade_id,date_format(".$this->db->escape($startdate).",'%Y') AS Year,DATE_FORMAT(STR_TO_DATE(monthnumber, '%m'), '%b') as monthName,monthNumber,GROUP_CONCAT(gu_id),bspi,'SBB','".date("Y-m-d H:i:s")."' from
(select bspi,monthName,monthNumber,sid,gu_id,grade_id,(select CONCAT(fname,' ',lname) from users where id = gu_id) as username,(select classname from class where id = grade_id)as classname,(select school_name from schools where id = sid)as school_name from(select finalscore as bspi,gu_id,monthNumber,monthName,sid,grade_id from vii_avguserbspiscorebymon where monthNumber=DATE_FORMAT(".$this->db->escape($startdate).", '%m')) as a1 where a1.gu_id in (select id from users where status=1 and visible=1) and a1.grade_id=".$this->db->escape($grad_ID)." and a1.sid=".$this->db->escape($school_id)."  and ROUND(a1.bspi,2) in (select bspi from vii_topbspiscore as vv3 where vv3.monthNumber =a1.monthNumber and  vv3.monthNumber!=".date('m')." and vv3.grade_id=".$this->db->escape($grad_ID)." and vv3.sid=".$this->db->escape($school_id).")) as a5 group by monthNumber");
		//echo $this->db->last_query(); exit;
	}
	public function InsertSuperAngels($startdate,$enddate,$school_ID,$grad_ID)
	{
		$query = $this->db->query("INSERT into leaderboard(sid,gradeid,year,monthname,monthnumber,userid,value,type,Created_on)select gs_ID,grad_ID,Year,monthName,monthNumber,group_concat(gu_id),ans,'SAB','".date("Y-m-d H:i:s")."' as username from (select ans,gu_id,monthName,monthNumber,Year,grad_ID,gs_ID,(select username from users where id = gu_id) as username,(select CONCAT(fname,' ',lname) from users where id = gu_id) as studentname from 
(select sum(answer) as ans,game_reports.gu_id AS gu_id,date_format(game_reports.lastupdate,'%b') AS monthName,date_format(game_reports.lastupdate,'%m') AS monthNumber,date_format(game_reports.lastupdate,'%Y') AS Year,(select users.sid from users where (users.id = game_reports.gu_id)) AS gs_ID,(select users.grade_id from users where (users.id = game_reports.gu_id)) AS grad_ID from game_reports where (convert(date_format(game_reports.lastupdate,'%Y-%m-%d') using latin1) between ".$this->db->escape($startdate)." and ".$this->db->escape($enddate)." ) group by date_format(game_reports.lastupdate,'%m'),game_reports.gu_id) a1 where a1.gu_id in (select id from users where status=1 and visible=1) and a1.grad_ID=".$this->db->escape($grad_ID)." and a1.gs_ID=".$this->db->escape($school_id)." and a1.ans in (select ans from vii_topsuperangels v where v.monthNumber=a1.monthNumber and  v.monthNumber!=".date('m')." and v.gs_ID=".$this->db->escape($school_id)." and v.grad_ID=".$this->db->escape($grad_ID).")) as a5 group by monthNumber");
		//echo $this->db->last_query(); exit;
	}
/*------------------- New Leader Board Concept Qry -------------------------*/
public function getTopBadge($schoolid,$gradid,$type)
{
	$query = $this->db->query("SELECT monthnumber,gradeid,group_concat(concat(fname,'',lname)) as username,type FROM leaderboard as l join users as u on find_in_set(u.id,userid) where l.sid='".$this->db->escape($schoolid)."' and l.gradeid=".$this->db->escape($gradid)." and type=".$this->db->escape($type)." group by l.id ");
	return $query->result_array();
}

public function getUserBadgeCount($sid,$gradeid,$userid)
{
	$query = $this->db->query("SELECT SUM(CASE WHEN type='SAB' THEN 1 else 0 END ) as sabbadge, SUM(CASE WHEN type='SBB' THEN 1 else 0 END ) as sbbbadge, SUM(CASE WHEN type='SGB' THEN 1 else 0 END ) as sgbbadge from leaderboard where gradeid=".$this->db->escape($gradeid)." and sid=".$this->db->escape($sid)." and userid=".$this->db->escape($userid)." ");
	return $query->result_array();
}
/*-------------------30 mins Time over concept-------------------------*/

	public function getSumofUserUsedTime($userid,$Todaydate)
	{
		$query =$this->db->query("SELECT SUM(TimeLoggedIn) as LoggedIntime from(SELECT TIMESTAMPDIFF(SECOND,created_date,lastupdate) AS TimeLoggedIn FROM user_login_log WHERE userid=".$this->db->escape($userid)." and date(created_date)=".$this->db->escape($todaydate).") as a2 ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	/* public function getMaxTimeofPlay()
	{
		$query = $this->db->query("select value from config_master where code='MAXTIMEOFPLAY' and status='Y'");
		return $query->result_array();
	} */
	public function getMaxTimeofPlay()
	{
		$query = $this->db->query("select value from config_master where code='MAXTIMEOFPLAY' and status='Y'");
		return $query->result_array();
	}
	public function TodayTimerInsert($userid)
	{
		$query = $this->db->query("Insert into userplaytime(userid,expiredon,expireddatetime)values(".$this->db->escape($userid).",'".date("Y-m-d")."','".date('Y-m-d H:i:s')."')");
	}
	public function IsTotayTimerExist($userid)
	{
		$query = $this->db->query("Select count(id) as isexist from userplaytime where userid=".$this->db->escape($userid)." and expiredon='".date("Y-m-d")."' ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
/*-------------------30 mins Time over concept End------------------------*/

	public function getplayeddates($userid)
	{
		$query = $this->db->query("Select lastupdate as `date`,1 as badge from gamedata where gu_id=".$this->db->escape($userid)." group by lastupdate");
	//	echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function curdayplaystatus($userid,$curday)
	{
		$query = $this->db->query("SELECT COUNT(DISTINCT gs_id) as total FROM `gamedata` WHERE `gu_id`=".$this->db->escape($userid)." and `lastupdate`=".$this->db->escape($curday)." and gs_id IN (59,60,61,62,63)");
	//	echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getfdbksubject()
	{
		$query = $this->db->query("SELECT `id`,`subject` FROM `feedback_subject_master` WHERE status='Y'");
	//	echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function userfdbk($userid,$qone,$qtwo,$qthree,$skillname,$usercmnt)
	{
		//$query = $this->db->query("INSERT INTO `users_feedback`(`userid`, `subjectid`, `comment`, `created_date`, `status`) VALUES (".$this->db->escape($userid).",'".$subject."','".$comment."',NOW(),1)");
		
		$query = $this->db->query("INSERT INTO `users_feedback`(`userid`, `qone`, `qtwo`, `qthree`, `skillid`, `comment`, `created_date`, `status`) VALUES (".$this->db->escape($userid).",".$this->db->escape($qone).",".$this->db->escape($qtwo).",".$this->db->escape($qthree).",".$this->db->escape($skillname).",".$this->db->escape($usercmnt).",'".date("Y-m-d H:i:s")."',1)");
	//	echo $this->db->last_query(); exit;
		//return $query->result_array();
	}
	
	public function feedbackenable($userid)
	{
		$curmonth = date('m');
		
		$query = $this->db->query("SELECT count(userid) as uid, (select DATE_FORMAT(`creation_date`,'%m') from users where id=".$this->db->escape($userid).") as regdate FROM `users_feedback` WHERE DATE_FORMAT(`created_date`,'%m')='".$curmonth."' and userid=".$this->db->escape($userid)."");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
public function maxvaluesbbadge($premnthnumber,$schoolid,$gradeid)
{
	$query = $this->db->query("SELECT MAX(value) as sbtopvalue FROM `leaderboard` WHERE `sid`='".$this->db->escape($schoolid)."' and `monthnumber`=".$this->db->escape($premnthnumber)." and gradeid=".$this->db->escape($gradeid)." and `type`='SBB'");
	//echo $this->db->last_query(); exit;
	return $query->result_array();
}

public function sbbadge($userid,$premnthnumber,$schoolid,$gradeid,$topvalue)
{
	$query = $this->db->query("SELECT count(id) as isSB, value as usersbtopvalue FROM `leaderboard` WHERE `sid`='".$this->db->escape($schoolid)."' and `monthnumber`=".$this->db->escape($premnthnumber)." and gradeid=".$this->db->escape($gradeid)." and FIND_IN_SET(".$this->db->escape($userid).",userid) and `type`='SBB' and value=".$this->db->escape($topvalue)."  ");
	return $query->result_array();
}

public function maxvaluesabadge($premnthnumber,$schoolid,$gradeid)
{
	$query = $this->db->query("SELECT MAX(value) as satopvalue FROM `leaderboard` WHERE `sid`='".$this->db->escape($schoolid)."' and `monthnumber`=".$this->db->escape($premnthnumber)." and gradeid=".$this->db->escape($gradeid)." and `type`='SAB'");
	//echo $this->db->last_query(); exit;
	return $query->result_array();
}

public function sabadge($userid,$premnthnumber,$schoolid,$gradeid,$topvalue)
{
	$query = $this->db->query("SELECT count(id) as isSA, value as usersbtopvalue FROM `leaderboard` WHERE `sid`='".$this->db->escape($schoolid)."' and `monthnumber`=".$this->db->escape($premnthnumber)." and gradeid=".$this->db->escape($gradeid)." and FIND_IN_SET(".$this->db->escape($userid).",userid) and `type`='SAB' and value=".$this->db->escape($topvalue)." ");
	return $query->result_array();
}

public function maxvaluesgbadge($premnthnumber,$schoolid,$gradeid)
{
	$query = $this->db->query("SELECT MAX(value) as sgtopvalue FROM `leaderboard` WHERE `sid`='".$this->db->escape($schoolid)."' and `monthnumber`=".$this->db->escape($premnthnumber)." and gradeid=".$this->db->escape($gradeid)." and `type`='SGB'");
	//echo $this->db->last_query(); exit;
	return $query->result_array();
}

public function sgbadge($userid,$premnthnumber,$schoolid,$gradeid,$topvalue)
{
	$query = $this->db->query("SELECT count(id) as isSG,value as usersbtopvalue FROM `leaderboard` WHERE `sid`='".$this->db->escape($schoolid)."' and `monthnumber`=".$this->db->escape($premnthnumber)." and gradeid=".$this->db->escape($gradeid)." and FIND_IN_SET(".$this->db->escape($userid).",userid) and `type`='SGB' and value=".$this->db->escape($topvalue)." ");
	//echo $this->db->last_query(); exit;
	return $query->result_array();
}
public function userinfo($userid)
{
	$query = $this->db->query("select id, (select school_name from schools where id=u.sid) as sname, (select classname from class where id=u.grade_id) as classname,section from users u where id=".$this->db->escape($userid)."");
	return $query->result_array();
}

	public function getTrainingCalendarData($userid,$curdate)
	{
		$query = $this->db->query("SELECT ROUND((SUM(gtime)/60),0) as MinutesTrained  , SUM(answer) as PuzzlesSolved, SUM(attempt_question) as PuzzlesAttempted,(select SUM(Points) from user_sparkies_history where U_ID=".$this->db->escape($userid)." and date(Datetime)=".$this->db->escape($curdate).") as Crownies FROM game_reports gr join users u on gr.gu_id=u.id	WHERE gtime IS NOT NULL AND answer IS NOT NULL and u.id=".$this->db->escape($userid)." and lastupdate=".$this->db->escape($curdate)." ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getonedaybspi($userid,$curdate)
	{
		$query = $this->db->query("SELECT SUM(avgskillscore)/5 as BSPI from (select MAX(game_score) as avgskillscore, gs_id FROM game_reports  where gu_id=".$this->db->escape($userid)." and lastupdate=".$this->db->escape($curdate)." group by gs_id) a1");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getonedayskillscore($userid,$curdate)
	{
		$query = $this->db->query("SELECT id, s1.mem as memory,s2.vp as visual, s3.fa as focus, s4.ps as problem,s5.lin as ling from users mu left join 

		(select AVG(game_score) as mem, gu_id FROM game_reports  where gu_id=".$this->db->escape($userid)." and lastupdate=".$this->db->escape($curdate)." and gs_id=59)s1 ON s1.gu_id=mu.id

		left join (select AVG(game_score) as vp, gu_id FROM game_reports  where gu_id=".$this->db->escape($userid)." and lastupdate=".$this->db->escape($curdate)." and gs_id=60)s2 ON s2.gu_id=mu.id

		left join (select AVG(game_score) as fa, gu_id FROM game_reports  where gu_id=".$this->db->escape($userid)." and lastupdate=".$this->db->escape($curdate)." and gs_id=61)s3 ON s3.gu_id=mu.id

		left join (select AVG(game_score) as ps, gu_id FROM game_reports  where gu_id=".$this->db->escape($userid)." and lastupdate=".$this->db->escape($curdate)." and gs_id=62)s4 ON s4.gu_id=mu.id

		left join (select AVG(game_score) as lin, gu_id FROM game_reports  where gu_id=".$this->db->escape($userid)." and lastupdate=".$this->db->escape($curdate)." and gs_id=63)s5 ON s5.gu_id=mu.id where mu.id=".$this->db->escape($userid)." ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function overallskillscore($userid,$curdate)
	 {
		$query = $this->db->query("select AVG(gamescore) as skillscore,gs_id from (SELECT (AVG(game_score)) as gamescore ,gs_id , lastupdate  FROM game_reports WHERE gs_id in (59,60,61,62,63) and gu_id=".$this->db->escape($userid)." and  lastupdate = ".$this->db->escape($curdate)." group by gs_id,lastupdate) a1 group by gs_id");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
							
	 }
	
	public function getnxtsession($sid,$grade,$section,$curday,$nextdate)
	{
		$query = $this->db->query("select starttime,endtime,dayname1,selected_date,nameofday,grade,section,pd from (select * from 
( select monday_grade as grade,monday_section as section,start_time as starttime,end_time as endtime,period as pd,'Monday' as dayname1 from schools_period_schedule where school_id=".$this->db->escape($sid)." and academic_id=20 and monday_grade!='' union select tuesday_grade,tuesday_section as section,start_time as starttime,end_time as endtime,period as pd,'Tuesday' as dayname1 from schools_period_schedule where school_id=".$this->db->escape($sid)." and academic_id=20 and tuesday_grade!='' 
union select wednesday_grade,wednesday_section as section,start_time as starttime,end_time as endtime,period as pd,'Wednesday' as dayname1 from schools_period_schedule where school_id=".$this->db->escape($sid)." and academic_id=20 and wednesday_grade!='' 
union select thursday_grade,thursday_section as section,start_time as starttime,end_time as endtime,period as pd,'Thursday' as dayname1 from schools_period_schedule where school_id=".$this->db->escape($sid)." and academic_id=20 and thursday_grade!='' 
union select friday_grade,friday_section as section,start_time as starttime,end_time as endtime,period as pd,'Friday' as dayname1 from schools_period_schedule where school_id=".$this->db->escape($sid)." and academic_id=20 and friday_grade!='' 
union select saturday_grade,saturday_section as section,start_time as starttime,end_time as endtime,period as pd,'Saturday' as dayname1 from schools_period_schedule where school_id=".$this->db->escape($sid)." and academic_id=20 and saturday_grade!='' 
union select sunday_grade,sunday_section as section,start_time as starttime,end_time as endtime,period as pd,'Sunday' as dayname1  from schools_period_schedule where school_id=".$this->db->escape($sid)." and academic_id=20 and sunday_grade!='')j1  cross join 
(select selected_date,dayname(selected_date) as nameofday from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where selected_date between ".$this->db->escape($curday)." and ".$this->db->escape($nextdate)."  and selected_date >= (select start_date from schools where id=".$this->db->escape($sid)." and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = ".$this->db->escape($sid)." and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1 where concat(selected_date,'',starttime)>=date_format('".date("Y-m-d H:i:s")."', '%Y-%m-%d%H:%i') and grade=".$this->db->escape($grade)." and section=".$this->db->escape($section)."  group by pd order by selected_date ASC");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function get_clp_skillwise_avg($userid)		 
		{
			$query = $this->db->query("select id, fname, s1.skillscore_M as skillscorem, skillscore_V as skillscorev,skillscore_F as skillscoref,skillscore_P as skillscorep,skillscore_L as skillscorel, a3.finalscore as avgbspiset1 from users mu 
left join (SELECT SUM(score)/5 as finalscore, gu_id, (SELECT sid from users where id=gu_id) as schoolid from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id) a3 on a3.gu_id=mu.id 

left join (select (AVG(score)) as skillscore_M, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =59 and gu_id=".$this->db->escape($userid)." group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s1 on s1.gu_id=mu.id 
left join (select (AVG(score)) as skillscore_V, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =60 and gu_id=".$this->db->escape($userid)." group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s2 on s2.gu_id=mu.id 
left join (select (AVG(score)) as skillscore_F, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =61 and gu_id=".$this->db->escape($userid)." group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s3 on s3.gu_id=mu.id 
left join (select (AVG(score)) as skillscore_P, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =62 and gu_id=".$this->db->escape($userid)." group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s4 on s4.gu_id=mu.id 
left join (select (AVG(score)) as skillscore_L, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =63 and gu_id=".$this->db->escape($userid)." group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s5 on s5.gu_id=mu.id 

 where id=".$this->db->escape($userid)." ORDER BY avgbspiset1 DESC");
 
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function getMonthWiseSkillScore($uid,$startdate,$enddate)
	{
		$query = $query = $this->db->query("select gs_id,(CASE WHEN gs_id=59 THEN 'MEMORY'
WHEN gs_id=60 THEN 'VP'
WHEN gs_id=61 THEN 'FA'
WHEN gs_id=62 THEN 'PS'
WHEN gs_id=63 THEN 'LI' else 0
END) as skillname,playedMonth,monthName,AVG(gamescore) as gamescore from (SELECT (AVG(game_score)) as gamescore ,gs_id , lastupdate,gu_id,DATE_FORMAT(lastupdate,'%m') as playedMonth,DATE_FORMAT(lastupdate, '%b') as monthName FROM game_reports WHERE gs_id in (59,60,61,62,63)and gu_id=".$this->db->escape($uid)." and lastupdate between ".$this->db->escape($startdate)." and ".$this->db->escape($enddate)." group by gs_id,lastupdate) a1 group by gs_id,playedMonth order by gs_id, lastupdate");
//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function getAsapBspi($username)
	{
		
		if($this->session->school_id==130 || $this->session->school_id==131 || $this->session->school_id==132 || $this->session->school_id==133 || $this->session->school_id==136 || $this->session->school_id==138 || $this->session->school_id==139 || $this->session->school_id==2)
		{
			//$this->load->library('Asapo');
			//asap_db_1920
			$query = $this->db->query("SELECT  sum(game_score)/5 as bspi FROM asap_db_1920.game_reports join asap_db_1920.users as u on u.id=gu_id where u.username=".$this->db->escape($username)." and u.status=1");
			//echo $this->multipledb->db->last_query(); exit;
		}
		else
		{
			//$this->load->library('Multipledb');
			$query = $this->db->query("SELECT  sum(game_score)/5 as bspi FROM asap_db_1920.game_reports join asap_db_1920.users as u on u.id=gu_id where u.username=".$this->db->escape($username)." and u.status=1");
		}
		return $query->result_array();
	}
	public function getCLPScore($userid)		 
	{
		$query = $this->db->query("select id, fname, s1.skillscore_M as ME, skillscore_V as VP,skillscore_F as FA,skillscore_P as PS,skillscore_L as LI from users mu 
		
		left join (select (AVG(score)) as skillscore_M, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =59 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s1 on s1.gu_id=mu.id 
		left join (select (AVG(score)) as skillscore_V, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =60 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s2 on s2.gu_id=mu.id 
		left join (select (AVG(score)) as skillscore_F, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =61 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s3 on s3.gu_id=mu.id 
		left join (select (AVG(score)) as skillscore_P, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =62 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s4 on s4.gu_id=mu.id 
		left join (select (AVG(score)) as skillscore_L, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =63 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s5 on s5.gu_id=mu.id 

		where id=".$this->db->escape($userid)." ");

		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getTotalTrainingData($userid)
	{
		$query = $this->db->query("SELECT ROUND((SUM(gtime)/60),0) as MinutesTrained  , SUM(answer) as PuzzlesSolved, SUM(attempt_question) as PuzzlesAttempted,(select SUM(Points) from user_sparkies_history where U_ID=".$this->db->escape($userid)." and date(Datetime) between '".$this->session->astartdate."' and '".$this->session->aenddate."') as Crownies FROM game_reports gr join users u on gr.gu_id=u.id	WHERE gtime IS NOT NULL AND answer IS NOT NULL and u.id=".$this->db->escape($userid)." and lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."' ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getAsapcore($username)
	{
		 
		if($this->session->school_id==130 || $this->session->school_id==131 || $this->session->school_id==132 || $this->session->school_id==133 || $this->session->school_id==136 || $this->session->school_id==138 || $this->session->school_id==139 || $this->session->school_id==2)
		{
			//$this->load->library('Asapo');
			$query = $this->db->query("select 
			(select game_score from  asap_db_1920.game_reports where gs_id=59  and gu_id=a1.id ) as ME,
			(select game_score from  asap_db_1920.game_reports where gs_id=60  and gu_id=a1.id ) as VP,
			(select game_score from  asap_db_1920.game_reports where gs_id=61  and gu_id=a1.id ) as FA,
			(select game_score from  asap_db_1920.game_reports where gs_id=62  and gu_id=a1.id ) as PS,			
			(select game_score from  asap_db_1920.game_reports where gs_id=63  and gu_id=a1.id ) as LI			
			from (select id from asap_db_1920.users where username=".$this->db->escape($username)." and status=1) a1 ");
			//echo $this->db->last_query(); exit;
		}
		else
		{
			//$this->load->library('Multipledb');
			$query = $this->db->query("select 
			(select game_score from  asap_db_1920.game_reports where gs_id=59  and gu_id=a1.id ) as ME,
			(select game_score from  asap_db_1920.game_reports where gs_id=60  and gu_id=a1.id ) as VP,
			(select game_score from  asap_db_1920.game_reports where gs_id=61  and gu_id=a1.id ) as FA,
			(select game_score from  asap_db_1920.game_reports where gs_id=62  and gu_id=a1.id ) as PS,			
			(select game_score from  asap_db_1920.game_reports where gs_id=63  and gu_id=a1.id ) as LI			
			from (select id from asap_db_1920.users where username=".$this->db->escape($username)." and status=1) a1 ");
		}
			return $query->result_array();
	}
	
	public function chkportaltype($username,$password)
	{
		//$this->load->library('Multipledb');
		$query = $this->db->query("select id,portal_type,sid,IS_ASAP,gp_id from asap_db_1920.users where username=".$this->db->escape($username)." and password=SHA1(CONCAT(salt1,".$this->db->escape($password).",salt2)) and status=1");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function chk_asapouser($username,$password)
	{
		 //$this->load->library('Asapo');
		$query = $this->db->query("select id,portal_type,sid,IS_ASAP,gp_id from asap_db_1920.users where username=".$this->db->escape($username)." and password=SHA1(CONCAT(salt1,".$this->db->escape($password).",salt2)) and status=1");
		 
		return $query->result_array();
	}
	
	public function tuserfdbk($userid,$tqone,$tusercmnt)
	{
		//$query = $this->db->query("INSERT INTO `users_feedback`(`userid`, `subjectid`, `comment`, `created_date`, `status`) VALUES (".$this->db->escape($userid).",'".$subject."','".$comment."',NOW(),1)");
		
		$query = $this->db->query("INSERT INTO `teachersday_feedback`(`userid`, `sid`,`qone`,`comment`, `created_date`, `status`) VALUES (".$this->db->escape($userid).",'".$_SESSION['school_id']."',".$this->db->escape($tqone).",".$this->db->escape($tusercmnt).",'".date("Y-m-d H:i:s")."',1)");
	//	echo $this->db->last_query(); exit;
		//return $query->result_array();
	}
	
	public function isuser_tfeedback($id)
	{
		$query = $this->db->query("select count(userid) as total from teachersday_feedback where userid=".$this->db->escape($id)."");
		//echo $this->multipledb->db->last_query(); exit;
		return $query->result_array();
	}
	
	/*---------------------------- IAS Challenge Start ------------------*/
	
	/* public function braintest($sid,$gradeid)
	{
		$query = $this->db->query("select startdate,enddate,level from braintest_mapping where sid=".$this->db->escape($sid)." and gradeid=".$this->db->escape($gradeid)." and level=1 and status=1");
		//echo $this->multipledb->db->last_query(); exit;
		return $query->result_array();
	} */
	
	public function isuserplayed_BT($id)
	{
		$query = $this->db->query("select count(gu_id) as total,game_score as score from bt_gamedata where gu_id=".$this->db->escape($id)." and BT_LEVEL=1");
		//echo $this->multipledb->db->last_query(); exit;
		return $query->result_array();
	}
	
	/* public function get_btscore($userid)
	{
		$query = $this->db->query("select total_question,attempt_question,answer,gtime,rtime,crtime,game_score from bt_gamedata where gu_id=".$this->db->escape($userid)." and BT_LEVEL=1");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	} 
	public function getBrainTestLanguage()
	{
		$query = $this->db->query("select id,name from bt_languages where status='Y' order by id asc");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	} */
	
	public function get_BTGames($sid,$game_grade)
	{
		$query = $this->db->query("SELECT  gid,game_html,img_path from braintest_games where gid=(select gameid from braintest_mapping where gradeid=".$this->db->escape($game_grade)." and sid=".$this->db->escape($sid)." and level=1)");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function insertone_BT($userid,$cid,$sid,$pid,$gameid,$total_ques,$attempt_ques,$answer,$score,$a6,$a7,$a8,$a9,$lastup_date)
	 {
	
	$query = $this->db->query("insert into bt_gamedata (gu_id,gc_id,gs_id,gp_id,g_id,total_question,attempt_question,answer,game_score,gtime,rtime,crtime,wrtime,lastupdate,BT_LEVEL,languageID) values(".$this->db->escape($userid).",".$this->db->escape($cid).",".$this->db->escape($sid).",".$this->db->escape($pid).",".$this->db->escape($gameid).",".$this->db->escape($total_ques).",".$this->db->escape($attempt_ques).",".$this->db->escape($answer).",".$this->db->escape($score).",".$this->db->escape($a6).",".$this->db->escape($a7).",".$this->db->escape($a8).",".$this->db->escape($a9).",".$this->db->escape($lastup_date).",'".$this->session->btestlevel."','".$this->session->currentlanguage."')");
	//echo $this->db->last_query(); exit;
		 
	 }
	 public function getgameid_BT($gamename)
	{
		$query = $this->db->query("select gid from braintest_games where game_html=".$gamename." ");
	//	echo $this->db->last_query(); exit;
		return $query->result_array();
	}
		 
	/*---------------------------- IAS Challenge End ------------------*/
	
	public function IsBspiTopper($id)
	{
		$query = $this->db->query("select count(userid) as topper,topbspi as value from q1_bspitopper where FIND_IN_SET(".$this->db->escape($id).", userid)");
		//echo $this->multipledb->db->last_query(); exit;
		return $query->result_array();
	}
	public function IsCrowniesTopper($id)
	{
		$query = $this->db->query("select count(userid) as topper,topbspi as value from q1_crowniestopper where FIND_IN_SET(".$this->db->escape($id).", userid) ");
		//echo $this->multipledb->db->last_query(); exit;
		return $query->result_array();
	}
	public function IsSkillTopper($id)
	{
		$query = $this->db->query("select * from q1_skilltopper where FIND_IN_SET(".$this->db->escape($id).", userid) ");
		//echo $this->multipledb->db->last_query(); exit;
		return $query->result_array();
	}
	
	
	public function InsertAccessLog($userid,$ip,$country,$region,$city,$zip,$emailstatus)
	{
		$query = $this->db->query('INSERT INTO user_access_log(userid, ip, login_datetime, country, regionname, city, zip, created_on, mailsend)VALUES('.$this->db->escape($userid).', '.$this->db->escape($ip).',"'.date("Y-m-d H:i:s").'",'.$this->db->escape($country).','.$this->db->escape($region).','.$this->db->escape($city).','.$this->db->escape($zip).',"'.date("Y-m-d H:i:s").'",'.$this->db->escape($emailstatus).')');
	}
	
	public function getSkillWiseAvgScore_opt($userid)		 
	{
		$query = $this->db->query("select id,fname,
 (select (AVG(score))  from (SELECT (AVG(game_score)) as score FROM game_reports WHERE gs_id =59 and gu_id=".$this->db->escape($userid)." group by lastupdate) a1) as skillscorem,
 (select (AVG(score))  from (SELECT (AVG(game_score)) as score FROM game_reports WHERE gs_id =60 and gu_id=".$this->db->escape($userid)." group by lastupdate) a1) as skillscorev,
 (select (AVG(score))  from (SELECT (AVG(game_score)) as score FROM game_reports WHERE gs_id =61 and gu_id=".$this->db->escape($userid)." group by lastupdate) a1) as skillscoref,
 (select (AVG(score))  from (SELECT (AVG(game_score)) as score FROM game_reports WHERE gs_id =62 and gu_id=".$this->db->escape($userid)." group by lastupdate) a1) as skillscorep,
 (select (AVG(score))  from (SELECT (AVG(game_score)) as score FROM game_reports WHERE gs_id =63 and gu_id=".$this->db->escape($userid)." group by lastupdate) a1) as skillscorel

 from users where  id=".$this->db->escape($userid)." ");
		//echo $this->multipledb->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function myTrophiesAll_opt($userid,$startdate,$enddate,$Session_StartRange,$Session_EndRange)
	{
		$query = $this->db->query("select gu_id AS gu_id,extract(month from lastupdate) AS month,sum(ct) as totstar,id as category,session_id from
		(select gr.gu_id AS gu_id,gs_id AS id,session_id,

		(case 
		when (round(max(gr.game_score),0) < 20) then 0 
		when ((round(max(gr.game_score),0) >= 20) and (round(max(gr.game_score),0) <= 40)) then 1 
		when ((round(max(gr.game_score),0) >= 41) and (round(max(gr.game_score),0) <= 60)) then 2 
		when ((round(max(gr.game_score),0) >= 61) and (round(max(gr.game_score),0) <= 80)) then 3 
		when ((round(max(gr.game_score),0) >= 81) and (round(max(gr.game_score),0) <= 90)) then 4 
		when ((round(max(gr.game_score),0) >= 91) and (round(max(gr.game_score),0) <= 100)) then 5 end) AS ct,

		gr.lastupdate AS lastupdate from game_reports gr where gs_id IN(59,60,61,62,63) and gu_id=".$this->db->escape($userid)." and (session_id <=".$this->db->escape($Session_EndRange).") and session_id!=0 group by session_id,gs_id,gr.gu_id) as a1 group by session_id,id");
		//echo $this->db->last_query(); exit;
		return $query->result_array();

	}
	
	public function getSkillWiseAvgCLPScore_opt($userid)		 
	{
		$query = $this->db->query("select id,fname,
 (select (AVG(score))  from (SELECT (AVG(game_score)) as score FROM game_reports WHERE gs_id =59 and gu_id=".$this->db->escape($userid)." group by lastupdate) a1) as ME,
 (select (AVG(score))  from (SELECT (AVG(game_score)) as score FROM game_reports WHERE gs_id =60 and gu_id=".$this->db->escape($userid)." group by lastupdate) a1) as VP,
 (select (AVG(score))  from (SELECT (AVG(game_score)) as score FROM game_reports WHERE gs_id =61 and gu_id=".$this->db->escape($userid)." group by lastupdate) a1) as FA,
 (select (AVG(score))  from (SELECT (AVG(game_score)) as score FROM game_reports WHERE gs_id =62 and gu_id=".$this->db->escape($userid)." group by lastupdate) a1) as PS,
 (select (AVG(score))  from (SELECT (AVG(game_score)) as score FROM game_reports WHERE gs_id =63 and gu_id=".$this->db->escape($userid)." group by lastupdate) a1) as LI

 from users where  id=".$this->db->escape($userid)." ");
		//echo $this->multipledb->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getMyCurrentTrophies_opt($userid,$start_range,$end_range)
	{
		$query = $this->db->query("select c.id as catid,c.name,sum(diamond) as diamond,sum(gold) as gold,sum(silver) as silver from 
			(select gu_id AS gu_id,id AS catid,(select name from category_skills as cs where cs.id=a1.id) as name,
			extract(month from lastupdate) AS month,
			floor((sum(ct) / 30)) AS diamond,
			floor(((sum(ct) % 30) / 20)) AS gold,
			floor((((sum(ct) % 30) % 20) / 10)) AS silver 

			from
			(select gr.gu_id AS gu_id,gs_id AS id,

			(case 
			when (round(max(gr.game_score),0) < 20) then 0 
			when ((round(max(gr.game_score),0) >= 20) and (round(max(gr.game_score),0) <= 40)) then 1 
			when ((round(max(gr.game_score),0) >= 41) and (round(max(gr.game_score),0) <= 60)) then 2 
			when ((round(max(gr.game_score),0) >= 61) and (round(max(gr.game_score),0) <= 80)) then 3 
			when ((round(max(gr.game_score),0) >= 81) and (round(max(gr.game_score),0) <= 90)) then 4 
			when ((round(max(gr.game_score),0) >= 91) and (round(max(gr.game_score),0) <= 100)) then 5 end) AS ct,

			gr.lastupdate AS lastupdate,session_id from game_reports 
			gr join category_skills cs 
			
			where gs_id IN(59,60,61,62,63) and (session_id between ".$this->db->escape($start_range)." and ".$this->db->escape($end_range).") and session_id!=0 and  gu_id=".$this->db->escape($userid)."  group by gr.session_id,gs_id) as a1 group by id) a2 right join category_skills as c on c.id=catid  where category_id=1 group by c.id ");
	
//	echo $this->db->last_query(); exit;

		return $query->result_array();
	}
	
		/* ------------------------ Staff FeedBack ------------------------ */
	public function checkValidUser($userid)
	{
		$query = $this->db->query('select * from stafffeedback_list where md5(id)='.$this->db->escape($userid).' and status=1');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function getStaffFeedback($userid)
	{
		$query = $this->db->query('select * from stafffeedback where md5(staffid)='.$this->db->escape($userid).' and status=1');
		return $query->result_array();
	}
	public function StaffFeedbackInsert($staffid,$qus1,$qus2,$qus3,$qus4,$qus5)
	{
		$query = $this->db->query('INSERT INTO stafffeedback( staffid, qus1, qus2, qus3, qus4, qus5, status, created_on) VALUES ('.$this->db->escape($staffid).','.$this->db->escape($qus1).','.$this->db->escape($qus2).','.$this->db->escape($qus3).','.$this->db->escape($qus4).','.$this->db->escape($qus5).',1,"'.date("Y-m-d H:i:s").'")');
		return $lastid=$this->db->insert_id();
	}
	/* ------------------------ Staff FeedBack ------------------------ */
	
	public function getSkGameDetails($userid,$gameid)
	{
		$query = $this->db->query("select (select count(gs_id) from sk_gamedata where gu_id=".$this->db->escape($userid)." and g_id=".$this->db->escape($gameid)." and lastupdate='".date("Y-m-d")."' and gs_id IN(59,60,61,62,63)) as playedgamescount");
		return $query->result_array();
	}
	public function UpdateUserZone($userid,$TimeZone)
	{
		$query = $this->db->query("Update users SET time_zone=".$this->db->escape($TimeZone)." where id=".$this->db->escape($userid)." "); 
	}
	
	/*----------------- Math Puzzles --------------------------*/

	public function checkMathAssignedToday($userid,$grade_id)
	{
		$query = $this->db->query("SELECT count(id) as assigned from mathrand_selection where user_id=".$this->db->escape($userid)." and grade_id=".$this->db->escape($grade_id)." and date(created_date)='".date('Y-m-d')."' ");
	
		return $query->result_array();
	}
	public function checkTotalAssignedPuzzles($userid,$grade_id)
	{
		$query = $this->db->query("SELECT count(id) as assigned from mathrand_selection where user_id=".$this->db->escape($userid)." and grade_id=".$this->db->escape($grade_id)." ");
		return $query->result_array();
	}	
	public function AssignTodayMathPuzzles($userid,$grade_id)
	{
		$query = $this->db->query("SELECT mid FROM math_gamemaster as mg where grade_id = ".$this->db->escape($grade_id)." and mid not in(select mid from mathrand_selection where user_id=".$this->db->escape($userid)." ) order by mid ASC Limit 1 ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function InertTodayMathPuzzles($gid,$userid,$grade_id)
	{	
		$query = $this->db->query("Insert INTO mathrand_selection(mid,grade_id,user_id,created_date)values(".$this->db->escape($gid).",".$this->db->escape($grade_id).",".$this->db->escape($userid).",'".date('Y-m-d H:i:s')."') ");
	}
	public function getTodayPuzzles($userid,$grade_id)
	{
		$query = $this->db->query("SELECT m.mid,mg.gamename,mg.game_html,mg.img_path,(select count(*) as tot_game_played from math_reports where gu_id = ".$this->db->escape($userid)." AND lastupdate = '".date('Y-m-d')."') as tot_game_played,(select coalesce(".$this->config->item('starslogic')."(game_score),0)from math_reports where gu_id =  ".$this->db->escape($userid)." and lastupdate = '".date('Y-m-d')."') as tot_game_score from mathrand_selection as m join math_gamemaster as mg on mg.mid=m.mid where m.user_id=".$this->db->escape($userid)." and mg.grade_id=".$this->db->escape($grade_id)." and date(m.created_date)='".date('Y-m-d')."'  ");

		//echo $this->db->last_query(); exit;
		return $query->result_array();

	}
	public function DeletePrevMathCycle($userid,$grade_id)
	{
		$query = $this->db->query("DELETE FROM mathrand_selection where user_id=".$this->db->escape($userid)." and grade_id=".$this->db->escape($grade_id)." ");
	}

	public function InsertMathData($userid,$cid,$sid,$pid,$gameid,$total_ques,$attempt_ques,$answer,$score,$a6,$a7,$a8,$a9,$lastup_date,$schedule_val)
	{
		$query = $this->db->query("insert into math_reports (gu_id,gc_id,gs_id,gp_id,g_id,total_question,attempt_question,answer,game_score,gtime,rtime,crtime,wrtime,lastupdate,created_date_time,Is_schedule) values(".$this->db->escape($userid).",".$this->db->escape($cid).",".$this->db->escape($sid).",".$this->db->escape($pid).",".$this->db->escape($gameid).",".$this->db->escape($total_ques).",".$this->db->escape($attempt_ques).",".$this->db->escape($answer).",".$this->db->escape($score).",".$this->db->escape($a6).",".$this->db->escape($a7).",".$this->db->escape($a8).",".$this->db->escape($a9).",".$this->db->escape($lastup_date).",'".date("Y-m-d H:i:s")."',".$this->db->escape($schedule_val).")");
		 
	}	 
	public function getMathGameId($gamename)
	{
		$query = $this->db->query("select mid from math_gamemaster where game_html='".$gamename."'");
		//	echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getTotalScoreofMath($userid)
	{
		$query = $this->db->query("select coalesce(Sum(game_score),0) as TotalScore from math_reports where gu_id =".$this->db->escape($userid)." ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function getMathScoreByMonth($userid,$Month,$Year)
	{
		$query = $this->db->query("select lastupdate,Sum(game_score) as DayScore from math_reports where gu_id =".$this->db->escape($userid)." and month(lastupdate)='".$Month."' and year(lastupdate)='".$Year."' group by lastupdate ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function TodayMathPuzzleEligible($userid)
	{
		$query = $this->db->query("select count(DISTINCT gs_id) as tot_games_played from gamedata where gu_id = ".$this->db->escape($userid)." AND lastupdate = '".date('Y-m-d')."' ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function MathPuzzleEligible($userid)
	{
		$query = $this->db->query("select count(gs_id) as tot_games_played from gamedata where gu_id = ".$this->db->escape($userid)." AND lastupdate = '".date('Y-m-d')."' ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	/*----------- Math Puzzles ---------------------------*/
	
	
	public function school_1819($username,$pwd)
	{
		$this->load->library('School1819');
			$query = $this->school1819->db->query('select id,sid FROM users a WHERE username='.$this->db->escape($username).' AND password=SHA1(CONCAT(salt1,'.$this->db->escape($pwd).',salt2)) AND status=1');
			
			//echo $this->db->last_query(); exit;
			return $query->result_array();
       
	}
	
	
	/*NEW FEATURES*/
	
	public function getCurrentSessionLevel($userid)
	{
	$query = $this->db->query("select session_id from gamedata where gu_id=".$this->db->escape($userid)." and session_id!=0 order by id DESC limit 1");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getcyclevalue()
	{
		$query = $this->db->query("SELECT value FROM cycle_master WHERE status=1");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getMedianValue($grade_id)
	{
		$query = $this->db->query("select skill_id,median_value from skillkit_master where grade_id=".$this->db->escape($grade_id)." order by skill_id ASC");
		return $query->result_array();
	}
	public function getDefaultCycleData($Session_StartRange,$Session_EndRange,$session_curid)
	{
		$query = $this->db->query("select * from cycle_master where status=1 and range_start <=".$this->db->escape($session_curid)." ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function UpdateTodaySession($userid,$todaydate)
	{
		$query = $this->db->query('CALL UpdateTodaySessionnew('.$this->db->escape($userid).','.$this->db->escape($todaydate).')');
		mysqli_next_result($this->db->conn_id);
		return $query->result_array();
	}
	
	public function getCurrentBSPIName($Session_StartRange,$Session_EndRange,$session_curid)
	{
		//$query = $this->db->query("select * from cycle_master where status=1 and range_start =".$Session_StartRange." and range_end =".$Session_EndRange."");
		$query = $this->db->query("select * from cycle_master where status=1 and ".$this->db->escape($session_curid)." between range_start and range_end ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function checkSkillkitGamePlayed($userid,$todaydate)
	{
		$query = $this->db->query('select (select count(*) from sk_gamedata where gu_id='.$this->db->escape($userid).' and lastupdate='.$this->db->escape($todaydate).') as playedcount,(select count(*) from sk_rand_selection where userID='.$this->db->escape($userid).' and date(created_date)='.$this->db->escape($todaydate).') as assignedcount');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getAdvancedSkillChart($userid,$Session_StartRange,$Session_EndRange,$session_curid)
	{
		$query = $this->db->query("select AVG(gamescore) as gamescore,gs_id,session_id from (SELECT (AVG(game_score)) as gamescore,gs_id,session_id  FROM game_reports WHERE gs_id in (59,60,61,62,63) and gu_id=".$this->db->escape($userid)." and  (lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."') and (session_id between ".$this->db->escape($Session_StartRange)." and ".$this->db->escape($Session_EndRange).") and session_id!=0  group by gs_id,session_id) a1 group by gs_id");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getDirectBSPI($userid,$Session_StartRange,$Session_EndRange)
	{
		$query = $this->db->query('SELECT SUM(score)/5 as tsi, gu_id from (select (AVG(score)) as score, gu_id, gs_id from (SELECT ('.$this->config->item('skilllogic').'(Convert(game_score,SIGNED))) as score , gs_id , gu_id, lastupdate FROM game_reports WHERE gs_id in (59,60,61,62,63) and gu_id ='.$this->db->escape($userid).' and (session_id between '.$this->db->escape($Session_StartRange).' and '.$this->db->escape($Session_EndRange).') and session_id!=0 group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getBasicSkillChart($userid,$Session_StartRange,$Session_EndRange,$session_curid)
	{
		$query = $this->db->query("select AVG(gamescore) as gamescore,gs_id,playedMonth from (SELECT (AVG(game_score)) as gamescore ,gs_id , lastupdate,DATE_FORMAT(lastupdate,'%m') as playedMonth  FROM sk_gamedata WHERE gs_id in (59,60,61,62,63) and gu_id=".$this->db->escape($userid)." and  (lastupdate between '".$this->session->astartdate."' and '".$this->session->aenddate."') and (session_id between ".$this->db->escape($Session_StartRange)." and ".$this->db->escape($Session_EndRange).") and session_id!=0  group by gs_id,session_id) a1 group by gs_id");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getSkillKitBSPI($userid,$Session_StartRange,$Session_EndRange)
	{
		$query = $this->db->query('SELECT AVG(score) as tsi, gu_id from (select (AVG(score)) as score, gu_id, gs_id from (SELECT ('.$this->config->item('skilllogic').'(Convert(game_score,SIGNED))) as score , gs_id , gu_id, lastupdate FROM sk_gamedata WHERE gs_id in (59,60,61,62,63) and gu_id ='.$this->db->escape($userid).' and (session_id between '.$this->db->escape($Session_StartRange).' and '.$this->db->escape($Session_EndRange).') and session_id!=0 group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getAssignSkills($userid)
	{
		$query = $this->db->query('select * from category_skills where FIND_IN_SET(id,(select weakSkills from sk_user_game_list where  userID='.$this->db->escape($userid).' and status=0))');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function UpdateSkillkitSession($userid,$todaydate,$start_range,$end_range)
	{
		$query = $this->db->query('CALL UpdateSkillkitSession('.$this->db->escape($userid).','.$this->db->escape($todaydate).','.$this->db->escape($start_range).','.$this->db->escape($end_range).')');
		mysqli_next_result($this->db->conn_id);
		return $query->result_array();
	}
	
	public function CheckTodayPuzzlePlayedCount($userid,$todaydate)
	{
		$query = $this->db->query("select count(DISTINCT gs_id) as playedskillcount from gamedata where gu_id=".$this->db->escape($userid)." and lastupdate=".$this->db->escape($todaydate)." ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function Update_Timer_StartTime($userid,$sessionid,$now)
	{
		$query = $this->db->query('update user_login_log set created_date='.$this->db->escape($now).',lastupdate='.$this->db->escape($now).',logout_date='.$this->db->escape($now).' where userid='.$this->db->escape($userid).' and sessionid='.$this->db->escape($sessionid).'');
		return $query;
	}
	/*NEW FEATURES*/
	
	/*-------------- CLP Single Entry -----------*/
	public function getGameValues($gamename)
	{
		//$gamename="lll";
		$query=$this->db->query("select gid,gs_id  FROM  games  WHERE game_html=".$gamename."");
		//$query=$this->db->query("select gid,gs_id  FROM  games  WHERE game_html='".$this->db->escape_like_str($gamename)."'");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function getPuzzle_cycle($gid,$uid)
	{
		$query=$this->db->query("select coalesce(sum(CompletedSkill),0) as play_cycle from 
		(
		SELECT CASE when count(gs_id)>=10 THEN 1
		WHEN FIND_IN_SET('U',group_concat(answer_status))>=1 THEN 1 ELSE 0 END CompletedSkill FROM gamescore as gs 
		join users as u on u.id=gu_id where g_id=".$this->db->escape($gid)." and u.id=".$this->db->escape($uid)." and lastupdate='".date("Y-m-d")."' and status=1 group by puzzle_cycle

		) as a1");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function getGamePlayedDetails($gid,$uid,$puzzlecycle,$curdate)
	{
		$query = $this->db->query(" SELECT count(*) as qcnts,sum(game_score) as scores,MIN(balancetime) as timerval,GROUP_CONCAT(que_id) as qvalues,sum(responsetime) as rsptime,max(answer) as crtcnt,GROUP_CONCAT(game_score) as questionscore,GROUP_CONCAT(useranswer) as useranswer FROM gamescore  WHERE g_id=".$this->db->escape($gid)." and gu_id=".$this->db->escape($uid)." and puzzle_cycle=".$this->db->escape($puzzlecycle)." and lastupdate='".date("Y-m-d")."' ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function InsertSingleGameScore($uid,$SID,$GID,$ResponseTime,$BalaceTime,$CorrectAnswer,$UserAnswer,$AnswerStaus,$QNO,$SCORE,$TimeOverStatus,$puzzle_cycle,$curdate,$curdatetime)
	{
		 
		$query = $this->db->query("INSERT INTO gamescore(gu_id, gs_id, g_id, que_id, answer, useranswer, game_score, answer_status, timeoverstatus, responsetime, balancetime, lastupdate, creation_date, modified_date, puzzle_cycle)VALUES(".$this->db->escape($uid).",".$this->db->escape($SID).",".$this->db->escape($GID).",".$this->db->escape($QNO).",".$this->db->escape($CorrectAnswer).",".$this->db->escape($UserAnswer).",".$this->db->escape($SCORE).",".$this->db->escape($AnswerStaus).",".$this->db->escape($TimeOverStatus).",".$this->db->escape($ResponseTime).",".$this->db->escape($BalaceTime).",".$this->db->escape($curdate).",".$this->db->escape($curdatetime).",".$this->db->escape($curdatetime).",".$this->db->escape($puzzle_cycle).") "); 
	}
	
	public function getPlayedPuzzleCount($userid,$todaydate,$gid,$current_Cycle)
	{
		$query = $this->db->query('select count(gu_id) as playedcount from gamescore where gu_id = '.$this->db->escape($userid).' and lastupdate ='.$this->db->escape($todaydate).' and g_id='.$this->db->escape($gid).' and puzzle_cycle='.$this->db->escape($current_Cycle).' ');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function InsertGameData($uid,$SID,$GID,$ResponseTime,$BalaceTime,$CorrectAnswer,$UserAnswer,$AnswerStaus,$QNO,$SCORE,$TimeOverStatus,$puzzle_cycle,$curdate,$curdatetime,$gametime,$gp_id)
	{ 
		$query = $this->db->query('CALL GameDataInsert('.$this->db->escape($uid).','.$this->db->escape($SID).','.$this->db->escape($GID).','.$this->db->escape($ResponseTime).','.$this->db->escape($BalaceTime).','.$this->db->escape($CorrectAnswer).','.$this->db->escape($UserAnswer).','.$this->db->escape($AnswerStaus).','.$this->db->escape($QNO).','.$this->db->escape($SCORE).','.$this->db->escape($TimeOverStatus).','.$this->db->escape($puzzle_cycle).','.$this->db->escape($curdate).','.$this->db->escape($curdatetime).','.$this->db->escape($gametime).','.$this->db->escape($gp_id).')'); 
		
		mysqli_next_result($this->db->conn_id);
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function getLastPlayedGameData($userid,$todaydate,$gid,$current_Cycle)
	{
		$query = $this->db->query('select * from gamedata where gu_id='.$this->db->escape($userid).' and lastupdate='.$this->db->escape($todaydate).' and g_id='.$this->db->escape($gid).' and puzzle_cycle='.$this->db->escape($current_Cycle).' ');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	// -------- Skillkit Single entry
	public function getSKPuzzle_cycle($gid,$uid)
	{
		$query=$this->db->query("select coalesce(sum(CompletedSkill),0) as play_cycle from 
		(
		SELECT CASE when count(gs_id)>=10 THEN 1
		WHEN FIND_IN_SET('U',group_concat(answer_status))>=1 THEN 1 ELSE 0 END CompletedSkill FROM sk_gamescore as gs 
		join users as u on u.id=gu_id where g_id=".$this->db->escape($gid)." and u.id=".$this->db->escape($uid)." and lastupdate='".date("Y-m-d")."' and status=1 group by puzzle_cycle

		) as a1");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function getSKGamePlayedDetails($gid,$uid,$puzzlecycle,$curdate)
	{
		$query = $this->db->query(" SELECT count(*) as qcnts,sum(game_score) as scores,MIN(balancetime) as timerval,GROUP_CONCAT(que_id) as qvalues,sum(responsetime) as rsptime,max(answer) as crtcnt,GROUP_CONCAT(game_score) as questionscore,GROUP_CONCAT(useranswer) as useranswer FROM sk_gamescore  WHERE g_id=".$this->db->escape($gid)." and gu_id=".$this->db->escape($uid)." and puzzle_cycle=".$this->db->escape($puzzlecycle)." and lastupdate='".date("Y-m-d")."' ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function getSKPlayedPuzzleCount($userid,$todaydate,$gid,$current_Cycle)
	{
		$query = $this->db->query('select count(gu_id) as playedcount from sk_gamescore where gu_id = '.$this->db->escape($userid).' and lastupdate ='.$this->db->escape($todaydate).' and g_id='.$this->db->escape($gid).' and puzzle_cycle='.$this->db->escape($current_Cycle).' ');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function InsertSKGameData($uid,$SID,$GID,$ResponseTime,$BalaceTime,$CorrectAnswer,$UserAnswer,$AnswerStaus,$QNO,$SCORE,$TimeOverStatus,$puzzle_cycle,$curdate,$curdatetime,$gametime,$gp_id)
	{	
		$query = $this->db->query('CALL SK_GameDataInsert('.$this->db->escape($uid).','.$this->db->escape($SID).','.$this->db->escape($GID).','.$this->db->escape($ResponseTime).','.$this->db->escape($BalaceTime).','.$this->db->escape($CorrectAnswer).','.$this->db->escape($UserAnswer).','.$this->db->escape($AnswerStaus).','.$this->db->escape($QNO).','.$this->db->escape($SCORE).','.$this->db->escape($TimeOverStatus).','.$this->db->escape($puzzle_cycle).','.$this->db->escape($curdate).','.$this->db->escape($curdatetime).','.$this->db->escape($gametime).','.$this->db->escape($gp_id).')'); 
		
		mysqli_next_result($this->db->conn_id);
		//echo $this->db->last_query(); exit;
		return $query->result();
	}
	
	/*-------------- CLP Single Entry -----------*/
	
	public function getPreviouslyAssignedPuzzles($userid)
	{
		$query = $this->db->query('select created_date,group_concat(gid) as gid from(select date(created_date) as created_date,gid as gid from rand_selection where user_id='.$this->db->escape($userid).' order by date(created_date) DESC limit 5) as a1');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function checkPuzzlesAllPlayed($userid,$assigneddate,$gid)
	{
		$query = $this->db->query('select count(DISTINCT gs_id) as playedcount from gamedata where gu_id='.$this->db->escape($userid).' and lastupdate='.$this->db->escape($assigneddate).'  and g_id IN('.$this->db->escape($gid).') ');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function InsertPreviousPuzzles($catid,$game_plan_id,$game_grade,$school_id,$section,$check_date_time,$gid,$userid)
	{ 
		
		$query = $this->db->query("INSERT INTO rand_selection(gc_id, gs_id, gid, gp_id, grade_id, section, school_id, user_id, created_date) select ".$this->db->escape($catid)." as gc_id,gs_id,gid,".$this->db->escape($game_plan_id)." as gp_id,".$this->db->escape($game_grade)." as grade_id,".$this->db->escape($section)." as section,".$this->db->escape($school_id)." as school_id,".$this->db->escape($userid).",".$this->db->escape($check_date_time)." from games where gid in(".$this->db->escape($gid).") "); 
	}
	public function UpdateUserCurrentSessionLevel($userid,$SESSIONLEVEL)
	{
		$query = $this->db->query('Update users set current_session='.$this->db->escape($SESSIONLEVEL).' where id='.$this->db->escape($userid).' '); 
	}
	public function getSK_AssignedSkills($uid)
	{
		$query = $this->db->query('select weakSkills,levelid  from sk_user_game_list where userID='.$this->db->escape($uid).' and status=0'); 
		return $query->result_array();
	}
	
	public function getActualGamesFromSP($userid,$gp_id,$grade_id,$sid,$curdate,$user_current_session,$section)
	{
	/*	$query = $this->db->query('CALL GameAssignLogic('.$this->db->escape($userid).','.$this->db->escape($gp_id).','.$this->db->escape($grade_id).','.$this->db->escape($sid).','.$this->db->escape($curdate).',"'.$user_current_session.'",'.$this->db->escape($section).')');*/
		
	$query = $this->db->query('CALL GameAssignLogic("'.$userid.'","'.$gp_id.'","'.$grade_id.'","'.$sid.'","'.$curdate.'","'.$user_current_session.'","'.$section.'")');
	
		mysqli_next_result($this->db->conn_id);
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getUserDataFromSP($userid,$uniqueId,$grade_id,$sid,$section,$ip,$txcountry,$txregion,$txcity,$txisp,$browser,$status,$todaydate,$now)
	{
		$query = $this->db->query('CALL sp_userlogin('.$this->db->escape($userid).','.$this->db->escape($uniqueId).','.$this->db->escape($grade_id).','.$this->db->escape($sid).','.$this->db->escape($section).','.$this->db->escape($ip).',"","","","",'.$this->db->escape($browser).','.$this->db->escape($status).','.$this->db->escape($todaydate).','.$this->db->escape($now).')');
		mysqli_next_result($this->db->conn_id);
	//	echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function SkillkitGameAssignFromSP($user_id,$game_grade,$confignoofdaysplay,$Session_StartRange,$Session_EndRange,$plan_id,$Next_Session_StartRange,$Next_Session_EndRange,$CurDate,$astartdate,$aenddate,$CurDateTime,$IntervalRange)
	{
	//	echo $CurDateTime; exit;
		$query = $this->db->query('CALL SkillkitGameAssign('.$this->db->escape($user_id).','.$this->db->escape($game_grade).','.$this->db->escape($confignoofdaysplay).','.$this->db->escape($Session_StartRange).','.$this->db->escape($Session_EndRange).','.$this->db->escape($plan_id).','.$this->db->escape($Next_Session_StartRange).','.$this->db->escape($Next_Session_EndRange).',"'.$CurDate.'",'.$this->db->escape($astartdate).','.$this->db->escape($aenddate).',"'.$CurDateTime.'",'.$this->db->escape($IntervalRange).')');
		mysqli_next_result($this->db->conn_id);
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	public function getTodayTimerInsertSP($user_id,$curdate,$curdatetime)
	{	 
		$query = $this->db->query('CALL TodayTimerInsert('.$this->db->escape($user_id).','.$this->db->escape($curdate).','.$this->db->escape($curdatetime).')');
		mysqli_next_result($this->db->conn_id);
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	
	
	
	
	/* ----------------- Hots Integration ------------------------*/
	
	public function braintest($sid,$gradeid)
	{
		$query = $this->db->query("select startdate,enddate,level from braintest_mapping where sid=".$this->db->escape($sid)." and gradeid=".$this->db->escape($gradeid)." and level=1 and status=1");
		//echo $this->multipledb->db->last_query(); exit;
		return $query->result_array();
	}	
	public function GamePlayedDataA($id,$gid)
	{
		$query = $this->db->query("select count(gu_id) as total,game_score as score,(select count(*) from bt_gamescore where gu_id=".$this->db->escape($id)."  and g_id=".$this->db->escape($gid).") as btgscore_count from bt_gamedata where gu_id=".$this->db->escape($id)." and BT_LEVEL=1  and g_id=".$this->db->escape($gid)." ");
		//echo $this->multipledb->db->last_query(); exit;
		return $query->result_array();
	}
	public function GamePlayedDataB($id,$gid)
	{
		$query = $this->db->query("select count(gu_id) as total,game_score as score,(select count(*) from bt_gamescore where gu_id=".$this->db->escape($id)." and g_id=".$this->db->escape($gid).") as btgscore_count from bt_gamedata where gu_id=".$this->db->escape($id)." and BT_LEVEL=1  and g_id=".$this->db->escape($gid)." ");
		//echo $this->multipledb->db->last_query(); exit;
		return $query->result_array();
	}	
	public function get_btscore($userid)
	{
		$query = $this->db->query("select g_id,total_question,attempt_question,answer,gtime,rtime,crtime,game_score from bt_gamedata where gu_id=".$this->db->escape($userid)." and BT_LEVEL=1 group by g_id");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function getBrainTestLanguage()
	{
		$query = $this->db->query("select id,name from bt_languages where status='Y' order by id asc");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	} 
	/* Hots Single Insert */ 
	public function getGamePlayedDetails_hots($gid,$uid,$puzzlecycle,$curdate)
	{
		$query = $this->db->query(" SELECT count(*) as qcnts,sum(game_score) as scores,MIN(balancetime) as timerval,GROUP_CONCAT(que_id) as qvalues,sum(responsetime) as rsptime,max(answer) as crtcnt,GROUP_CONCAT(game_score) as questionscore,GROUP_CONCAT(useranswer) as useranswer FROM bt_gamescore  WHERE g_id=".$this->db->escape($gid)." and gu_id=".$this->db->escape($uid)." and puzzle_cycle=".$this->db->escape($puzzlecycle)." and lastupdate='".date("Y-m-d")."' ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function getPlayedPuzzleCount_hots($userid,$todaydate,$gid)
	{
		$query = $this->db->query('select count(gu_id) as playedcount from bt_gamescore where gu_id= '.$this->db->escape($userid).' and g_id='.$this->db->escape($gid).' ');
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function InsertGameData_hots($uid,$SID,$GID,$ResponseTime,$BalaceTime,$CorrectAnswer,$UserAnswer,$AnswerStaus,$QNO,$SCORE,$TimeOverStatus,$puzzle_cycle,$curdate,$curdatetime,$gametime,$gp_id,$currentquestion,$btlevel,$currentlangid)
	{ 
		$query = $this->db->query('CALL GameDataInsert_hots('.$this->db->escape($uid).','.$this->db->escape($SID).','.$this->db->escape($GID).','.$this->db->escape($ResponseTime).','.$this->db->escape($BalaceTime).','.$this->db->escape($CorrectAnswer).','.$this->db->escape($UserAnswer).','.$this->db->escape($AnswerStaus).','.$this->db->escape($QNO).','.$this->db->escape($SCORE).','.$this->db->escape($TimeOverStatus).','.$this->db->escape($puzzle_cycle).','.$this->db->escape($curdate).','.$this->db->escape($curdatetime).','.$this->db->escape($gametime).','.$this->db->escape($gp_id).','.$this->db->escape($currentquestion).','.$this->db->escape($btlevel).','.$this->db->escape($currentlangid).')');  
		
		mysqli_next_result($this->db->conn_id);
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function checkandUpgradeUserStatus_hots($userid,$username)
	{
		$query = $this->db->query('CALL checkandUpgradeUserStatus_hots('.$this->db->escape($userid).','.$this->db->escape($username).')');
		mysqli_next_result($this->db->conn_id);
		return $query->result_array();
	}
	
	/* ------------------ Music Sound ---------------*/
	public function get_gamesound()
	{
		$query = $this->db->query('select id,game_sound,sound_name,path from user_game_sound where status=1');
		return $query->result_array();		
	}	
	public function updategamesound($gamesound,$userid)
	{
		$query = $this->db->query('update users set user_game_sound='.$this->db->escape($gamesound).' where id='.$this->db->escape($userid).' ');
	}
	
	/*................... Dubai School Changes ............*/
	public function scl_holidays($sid)
	{
		$curdate=date('Y-m-d');		
		$query = $this->db->query("select count(leave_date) as todayleave from schools_leave_list where leave_date=".$this->db->escape($curdate)." and school_id=".$this->db->escape($sid)." ");	 
		return $query->result_array();
	}
	public function new_features($sid)
	{	
		$query = $this->db->query("select new_features from schools where id=".$this->db->escape($sid)." "); 
		return $query->result();
	}
	
	
		/*--------------ddl for language section---------------*/
	public function get_language()
	{
		$query = $this->db->query("select ID,name as language from language_master where status='Y'");
	//	echo $this->db->last_query(); exit;
		return $query->result_array();
	}	
	
		
	public function updatelanguage($language,$userid)
	{
		$query = $this->db->query("update users set language='".$language."' where id='".$userid."' ");
		//echo $this->db->last_query(); exit;
	}	
		
		
		/*--------------ddl for language section---------------*/
}
