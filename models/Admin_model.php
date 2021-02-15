<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

        
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
				 $this->load->database();
        }
		
		public function academicyears()
		{
			$query = $this->db->query('select * from academic_year where id = 20');
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function schools($startdate,$enddate)
        {
	
		$query = $this->db->query ('select count(DISTINCT(sid))  as schoolscount from users u join game_reports gr on u.id=gr.gu_id join schools s on s.id=u.sid where lastupdate BETWEEN "'.$startdate.'" and "'.$enddate.'" and s.active=1 and u.status=1 and u.visible = 1 and s.status =1 and s.visible =1');	

			return $query->result_array();
        }
		
		public function students($startdate,$enddate)
        {

		$query = $this->db->query('select count(distinct u.id) as studentscount from users u join schools s on s.id=u.sid inner join game_reports gr on gr.gu_id=u.id where s.active=1 AND s.status=1 and s.visible=1 and u.status=1 and u.visible=1 and lastupdate between "'.$startdate.'" and "'.$enddate.'"');

			return $query->result_array();
        }
		
		public function trainingbspi($startdate,$enddate)
		{
			$query = $this->db->query('select AVG(bspiscore) as overallbspi from (select avg(score) as bspiscore,id,count(uid) as totstudent,school_name from (select (sum(score1)/5) as score,gu_id,s.id,u.id as uid,s.school_name  from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id in (59,60,61,62,63) and lastupdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id  join schools s on s.id=u.sid and s.active=1 and s.status=1 and s.visible=1 and u.status =1 and u.visible=1 group by gu_id) a3 group by id ORDER BY bspiscore DESC) x1 ');
			//echo $this->db->last_query();
			return $query->result_array();
		}
		
		public function schoolwisebspi($startdate,$enddate)
		{
			$query = $this->db->query('select avg(score) as bspiscore,id,count(uid) as totstudent,school_name from (select (sum(score1)/5) as score,gu_id,s.id,u.id as uid,s.school_name  from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id in (59,60,61,62,63) and lastupdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id and status=1 and visible=1 join schools s on s.id=u.sid and s.active=1 and s.status=1 and s.visible=1 group by gu_id) a3 group by id ORDER BY bspiscore DESC');
			
		
			return $query->result_array();
		}
		
		public function skillwisetopper_memory($skillid,$startdate,$enddate)
		{
			$query = $this->db->query('select avg(score) as finalscore,id,count(uid) as totstu,school_name from (select AVG(score1) as score,gu_id,s.id,u.id as uid,s.school_name  from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id = "'.$skillid.'" and lastupdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id and status=1 and visible=1 join schools s on s.id=u.sid and s.active=1 and s.status=1 and s.visible=1 group by gu_id) a3 group by id ORDER BY finalscore DESC');
			
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		 public function getschools()
        {
			$query = $this->db->query('select * from schools where status=1 and active=1 and visible=1');
			
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		
		 public function getgrades()
        {
			$query = $this->db->query('select * from class');
			
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		
		 public function getschools_chk($startdate,$enddate)
        {
						
			$query = $this->db->query ('select DISTINCT(sid)  as schoolid, (select school_name from schools where id=schoolid and status=1 and visible=1) as schoolname from users u join game_reports gr on u.id=gr.gu_id join schools s on s.id=u.sid where lastupdate BETWEEN "'.$startdate.'" and "'.$enddate.'" and s.active=1 and s.visible=1 and s.status=1 and u.status=1 and u.visible=1 order by schoolid');
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		
		 public function getgrades_chk($startdate,$enddate)
        {
						
			$query = $this->db->query ('(SELECT (AVG(game_score)) as score , gs_id , gu_id, (SELECT grade_id from users where id=gr.gu_id and status=1 and visible=1) as gradeid, (SELECT classname from class where id=gradeid) as gradename, lastupdate FROM game_reports gr WHERE gs_id in (59,60,61,62,63) and lastupdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" and gu_id in (select users.id FROM users JOIN schools as s ON users.sid=s.id WHERE users.status=1 and users.visible=1 and s.active=1 and s.status=1 and s.visible=1) group by gradeid)');	
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		
		public function getplanid($schoolid,$gradeid)
        {
			$query = $this->db->query('SELECT plan_id from skl_class_plan where school_id="'.$schoolid.'" AND class_id="'.$gradeid.'"');
			return $query->result_array();
		}
		
		
		public function usersbspireport($schoolid,$gradeid,$sectionid,$startdate,$enddate)
        {
			/*$where = "";
			if($gradeids=='' && $schoolids=='') 
			{	 $where = ""; } else {  $where="where s.id IN (".$schoolids.") and u.grade_id IN (".$gradeids.")";} */
		
			$query = $this->db->query('select avg(score) as bspiscore,id,count(uid) as totstudent,gradeid,(SELECT classname from class where id=gradeid) as gradename,school_name from (select (sum(score1)/5) as score,gu_id,s.id,u.id as uid,s.school_name,(SELECT grade_id from users where id=gu_id and users.status=1 and users.visible=1) as gradeid  from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id in (59,60,61,62,63) and lastupdate BETWEEN "'.$startdate.'" and "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id and status=1 and visible=1 join schools s on s.id=u.sid and s.active=1 and s.status=1 and s.visible=1 where s.id = "'.$schoolid.'" and u.grade_id = "'.$gradeid.'" and section="'.$sectionid.'" group by gu_id) a3 group by gradeid,id');
			
		//echo $this->db->last_query(); exit;
		return $query->result_array();
		}
		
		
		
		
		public function bspi_reports($schoolid,$gradeid,$sectionid)
        {
				$query = $this->db->query('select id, sid, (select school_name from schools where id = "'.$schoolid.'") as schoolname, fname, section, grade_id,(select classname from class where id=grade_id) as gradename, s1.skillscore_M as skillscorem, skillscore_V as skillscorev,skillscore_F as skillscoref,skillscore_P as skillscorep,skillscore_L as skillscorel,a3.finalscore as avgbspiset1 from users mu

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
(select (AVG(score)) as skillscore_L, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =63 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s5 on s5.gu_id=mu.id where sid="'.$schoolid.'" and grade_id="'.$gradeid.'" and section="'.$sectionid.'" and status=1 and visible=1 ORDER BY avgbspiset1 DESC');
//echo $this->db->last_query(); exit;
		return $query->result_array();
		 
}

public function skillscore_reports($schoolid,$gradeid,$skillid,$sectionid)
        {
				$query = $this->db->query('select id, fname, sid,(select school_name from schools where id = "'.$schoolid.'" and active=1 and status=1 and visible=1) as schoolname, (select name from category_skills where id ="'.$skillid.'") as skill, section, grade_id,(select classname from class where id=grade_id) as gradename,a2.score,a2.rstime from users mu left join (select (AVG(score)) as score, (AVG(restime)) as rstime, gu_id, gs_id, (select name from category_skills where id ="'.$skillid.'") as skillname, (SELECT sid from users where id=gu_id) as schoolid from (SELECT (AVG(`game_score`)) as score , (AVG(rtime)) as restime, gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id ="'.$skillid.'" and gu_id in (select id from users where status=1 and visible=1) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) a2 on a2.gu_id=mu.id where sid="'.$schoolid.'" and grade_id="'.$gradeid.'" and section="'.$sectionid.'" and status=1 and visible=1 ORDER BY a2.score DESC' );			
			
			//echo $this->db->last_query(); exit;
			return $query->result_array();
			
		}
		
		public function skillscore_skl_grade_sect_wise($startdate,$enddate,$schoolid,$gradeid,$skillid,$sectionid)
        {
				$query = $this->db->query('select avg(score) as finalscore,id,count(uid) as totstu,gradeid,(select name from category_skills where id ="'.$skillid.'" ) as skillname,(SELECT classname from class where id=gradeid) as gradename,school_name from (select AVG(score1) as score,gu_id,s.id,u.id as uid,s.school_name,(SELECT grade_id from users where id=gu_id and users.status=1 and users.visible=1) as gradeid from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id = "'.$skillid.'" and lastupdate BETWEEN "'.$startdate.'" and "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id and u.grade_id="'.$gradeid.'" and u.section="'.$sectionid.'" and  status=1 and visible=1 join schools s on s.id="'.$schoolid.'" and s.active=1 and s.status=1 and s.visible=1 group by gu_id) a3 group by gradeid,id');			
			
			//echo $this->db->last_query(); exit;
			return $query->result_array();
			
		}
		
		public function getClassPerformace_data($schoolid,$gradeid,$sectionid,$tablename,$rangefrom,$rangeto,$startdate,$enddate)
        {
			$query = $this->db->query('select  (@cnt := @cnt + 1) AS rowNumber,id, fname as name,lname,avatarimage, IF(avgbspiset1 IS NULL,0,avgbspiset1) as bspi from (select id as id, fname,lname,avatarimage, grade_id,(select classname from class where id=grade_id) as gradename,a3.finalscore as avgbspiset1 from users mu  left join 
 (SELECT SUM(score)/5 as finalscore, gu_id, (SELECT sid from users where id=gu_id and status=1 and visible=1) as schoolid from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM '.$tablename.' WHERE gs_id in (59,60,61,62,63) and lastupdate between "'.$startdate.'" and "'.$enddate.'" and gu_id in (select id from users where status=1 and visible=1) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id) a3   on a3.gu_id=mu.id where sid="'.$schoolid.'" and grade_id="'.$gradeid.'" and status=1 and visible=1 and section="'.$sectionid.'" and a3.finalscore BETWEEN '.$rangefrom.' AND  '.$rangeto.' ORDER BY avgbspiset1 ASC ) as a5 CROSS JOIN (SELECT @cnt := 0) AS dummy');
 
			//echo $this->db->last_query(); 
			return $query->result_array();
		}
		
		 public function getsection($schoolid,$gradeid)
        {
			$query = $this->db->query('select id,section from skl_class_section where class_id="'.$gradeid.'" and school_id="'.$schoolid.'"');
		//	echo $this->db->last_query(); exit;
			return $query->result_array();
			
		}
		
		public function schoolwise_gradewise_bspi_avg($gradeids,$schoolids,$startdate,$enddate)
		{
			//echo $gradeids; 
			//echo $schoolids; exit;
			$where = "";
			if($gradeids=='' && $schoolids=='') 
			{	 $where = ""; } else {  $where="where s.id IN (".$schoolids.") and u.grade_id IN (".$gradeids.")";}
		
			$query = $this->db->query('select avg(score) as bspiscore,id,count(uid) as totstudent,gradeid,(SELECT classname from class where id=gradeid) as gradename,school_name from (select (sum(score1)/5) as score,gu_id,s.id,u.id as uid,s.school_name,(SELECT grade_id from users where id=gu_id and users.status=1 and users.visible=1) as gradeid  from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id in (59,60,61,62,63) and lastupdate BETWEEN "'.$startdate.'" and "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id and status=1 and visible=1 join schools s on s.id=u.sid and s.active=1 and s.visible=1 and s.status=1 '.$where.' group by gu_id) a3 group by gradeid,id');
		
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function gradewise_bspi_avg($schoolid,$startdate,$enddate)
		{
			$where = "";
			if($schoolid=='') 
			{	 $where = ""; } else {  $where="where id=".$schoolid."";}
		
			$query = $this->db->query('select avg(bspiscore) as overallbspi,id,gradeid,(SELECT classname from class where id=gradeid) as gradename from (select avg(score) as bspiscore,id,gradeid,(SELECT classname from class where id=gradeid) as gradename,school_name from (select (sum(score1)/5) as score,gu_id,s.id,u.id as uid,s.school_name,(SELECT grade_id from users where id=gu_id and users.status=1 and users.visible=1) as gradeid  from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id in (59,60,61,62,63) and lastupdate BETWEEN "'.$startdate.'" and "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id and status=1 and visible=1 join schools s on s.id=u.sid and s.active=1 and s.status=1 and s.visible=1 group by gu_id) a3 group by gradeid,id) a4 '.$where.' group by gradeid');
			
			
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function skl_gradewise_skillscore($skillid,$startdate,$enddate)
		{
			$query = $this->db->query('select avg(score) as finalscore,id,count(uid) as totstu,gradeid,(select name from category_skills where id ="'.$skillid.'" ) as skillname,(SELECT classname from class where id=gradeid) as gradename,school_name from (select AVG(score1) as score,gu_id,s.id,u.id as uid,s.school_name,(SELECT grade_id from users where id=gu_id and users.status=1 and users.visible=1) as gradeid from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id = "'.$skillid.'" and lastupdate BETWEEN "'.$startdate.'" and "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id and status=1 and visible=1 join schools s on s.id=u.sid and s.active=1 and s.status=1 and s.visible=1 group by gu_id) a3 group by gradeid,id');
			
			//(select (AVG(score)) as finalscore, skillname,(select school_name from schools where id=schoolid) as schoolname, gradeid, (SELECT classname from class where id=gradeid) as gradename, schoolid from (select (AVG(score)) as score, gu_id, gs_id, (select name from category_skills where id =gs_id ) as skillname, (SELECT sid from users where id=gu_id) as schoolid,(SELECT grade_id from users where id=gu_id and users.status=1) as gradeid from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id ="'.$skillid.'" and lastupdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" and gu_id in (select users.id FROM users JOIN schools as s ON users.sid=s.id WHERE users.status=1 and s.active=1 and s.status=1) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id )a2 group by schoolid,gradeid,gs_id) ORDER BY gradeid
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function gradewise_skillscore($skillid,$schoolid,$startdate,$enddate)
		{
			$where = "";
			if($schoolid=='') 
			{	 $where = ""; } else {  $where="where id=".$schoolid."";}
			
			$query = $this->db->query('SELECT avg(finalscore) as overallskillscore,id,gradeid,(select name from category_skills where id ="'.$skillid.'" ) as skillname,(SELECT classname from class where id=gradeid) as gradename from (select avg(score) as finalscore,id,count(uid) as totstu,gradeid,(SELECT classname from class where id=gradeid) as gradename,school_name from (select AVG(score1) as score,gu_id,s.id,u.id as uid,s.school_name,(SELECT grade_id from users where id=gu_id and users.status=1 and users.visible=1) as gradeid from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id = "'.$skillid.'" and lastupdate BETWEEN "'.$startdate.'" and "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id and status=1 and visible=1 join schools s on s.id=u.sid and s.active=1 and s.status=1 and s.visible=1 group by gu_id) a3 group by gradeid,id) a4 '.$where.'  group by gradeid');
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function getusercount($data0)
        {
			$query = $this->db->query("select count(*) as userCount from users where username LIKE (select concat('$data0_%')) and status=1 and visible=1");
			return $query->result_array();
		}
		
		public function userimport($shpassword,$salt1,$salt2,$data0,$data1,$data2,$data3,$data4,$schoolid,$ddlGradeType,$ceationkey)
        {
			$creationdate = date("Y-m-d H:i:s");
			$query = $this->db->query("INSERT INTO users(password,salt1,salt2,creation_date, fname, lname, gender, dob, status, gp_id, grade_id, username,  sid, section, academicyear, creationkey) VALUES ('$shpassword','$salt1','$salt2','$creationdate','$data0','$data1','$data2','$data3','1',(select id from g_plans where grade_id=$ddlGradeType limit 1),'$ddlGradeType',(select concat('$data0','.',(select school_code from schools limit 1))),'$schoolid','$data4',(select id from academic_year where id=20), '".$ceationkey."' )");
			
			//return $query->result_array();
		}
		
		public function userimport1($shpassword,$salt1,$salt2,$data0,$data1,$data2,$data3,$data4,$schoolid,$ddlGradeType,$ceationkey,$userexist)
        {
			$creationdate = date("Y-m-d H:i:s");
			$query = $this->db->query("INSERT INTO users(password,salt1,salt2,creation_date, fname, lname, gender, dob, status, gp_id, grade_id, username,  sid, section, academicyear,creationkey) VALUES ('$shpassword','$salt1','$salt2','$creationdate','$data0','$data1','$data2','$data3','1',(select id from g_plans where grade_id=$ddlGradeType limit 1),'$ddlGradeType',(select concat('$data0','_',($userexist+1),'.',(select school_code from schools limit 1))),'$schoolid','$data4',(select id from academic_year where id = 20), '".$ceationkey."')");
		}
		
		public function userdownload($ceationkey)
        {
			$query = $this->db->query("SELECT *, (SELECT classname FROM class WHERE id=user.grade_id) as gradename FROM users user WHERE creationkey = '".$ceationkey."'");
			return $query->result_array();
		}
		
		public function GetClassSparkiesToppers()
		{
			$query = $this->db->query("select vv1.U_ID,vv1.S_ID,vv1.G_ID,vv1.points,vv1.monthName,vv1.monthNumber FROM vv1 join vv2 on vv2.points=vv1.points where vv1.S_ID=vv2.S_ID and vv1.G_ID=vv2.G_ID and vv1.monthName=vv2.monthName");
			return $query->result_array();
		}
		public function GetGrade()
		{			 
			$query = $this->db->query("select id,classname from class");
			return $query->result_array();
		}
		public function GetSchool()
		{			 
			$query = $this->db->query("select id,school_name from schools where status=1 and visible=1 and active=1");
			return $query->result_array();
		}
		public function GetSchoolWiseToppersBSPI($schoolqry,$gradeqry,$typeids,$monthqry)
		{ 	
			$query = $this->db->query("select bspi1.gu_id,bspi1.sid,bspi1.grade_id,bspi1.bspi,bspi1.monthNumber,bspi1.monthName,(select username from users where id = bspi1.gu_id and status=1 and visible=1) as username,(select section from users where id = bspi1.gu_id and status=1 and visible=1) as sectionname,(select classname from class where id = bspi1.grade_id)as classname,(select school_name from schools where id = bspi1.sid and active=1 and status=1 and visible=1)as school_name  from vi_avguserbspiscore bspi1 join vi_monthwisebspi bspi2 on bspi1.bspi=bspi2.bspi where bspi1.sid=bspi2.sid and bspi1.grade_id=bspi2.grade_id and bspi1.monthNumber=bspi2.monthNumber ".$schoolqry." ".$gradeqry."  ".$monthqry." ");
			
			return $query->result_array();
		}
		public function GetSchoolWiseToppersSparkies($schoolqry,$gradeqry,$typeids,$monthqry)
		{		
			$query = $this->db->query("select vv1.U_ID,vv1.S_ID,vv1.G_ID,vv1.points,vv1.monthName,vv1.monthNumber,(select username from users where id = vv1.U_ID) as username,(select classname from class where id = vv1.G_ID)as classname,(select school_name from schools where id = vv1.S_ID)as school_name,(select section from users where id = vv1.U_ID) as sectionname FROM vv1 join vv2 on vv2.points=vv1.points where vv1.S_ID=vv2.S_ID and vv1.G_ID=vv2.G_ID and vv1.monthName=vv2.monthName ".$schoolqry." ".$gradeqry."  ".$monthqry."  ");
			return $query->result_array();
		}
		
		public function timetable()
		{		
			$query = $this->db->query("select period,group_concat(school_id) as school_id,group_concat(monday_grade,'-',code) as monday, group_concat(tuesday_grade,'-',code) as tuesday, group_concat(wednesday_grade,'-',code) as wednesday, group_concat(thursday_grade,'-',code) as thursday, group_concat(friday_grade,'-',code) as friday, group_concat(saturday_grade,'-',code) as saturday, group_concat(sunday_grade,'-',code) as sunday, 
			
group_concat(mon_grade,'/',school_id) as mon_id, group_concat(tue_grade,'/',school_id) as tue_id, group_concat(wed_grade,'/',school_id) as wed_id, group_concat(thu_grade,'/',school_id) as thu_id, group_concat(fri_grade,'/',school_id) as fri_id, group_concat(sat_grade,'/',school_id) as sat_id, group_concat(sun_grade,'/',school_id) as sun_id,

group_concat(mon_count) as mon_val, group_concat(tue_count) as tue_val, group_concat(wed_count) as wed_val, group_concat(thu_count) as thu_val, group_concat(fri_count) as fri_val, group_concat(sat_count) as sat_val


 

from (select school_id,period,

CASE WHEN monday_grade!='' THEN CONCAT(monday_grade,'-', monday_section) END as monday_grade, 
CASE WHEN tuesday_grade!='' THEN CONCAT(tuesday_grade,'-', tuesday_section) END as tuesday_grade, 
CASE WHEN wednesday_grade!='' THEN CONCAT(wednesday_grade,'-', wednesday_section) END as wednesday_grade, 
CASE WHEN thursday_grade!='' THEN CONCAT(thursday_grade,'-', thursday_section) END as thursday_grade, 
CASE WHEN friday_grade!='' THEN CONCAT(friday_grade,'-', friday_section) END as friday_grade,
CASE WHEN saturday_grade!='' THEN CONCAT(saturday_grade,'-', saturday_section) END as saturday_grade,
CASE WHEN sunday_grade!='' THEN CONCAT(sunday_grade,'-', sunday_section) END as sunday_grade,

CONCAT((select id from class where REPLACE(classname,'Grade ','')  = monday_grade),'/', monday_section) as mon_grade, CONCAT((select id from class where REPLACE(classname,'Grade ','')  = tuesday_grade),'/', tuesday_section) as tue_grade, CONCAT((select id from class where REPLACE(classname,'Grade ','')  = wednesday_grade),'/', wednesday_section) as wed_grade, CONCAT((select id from class where REPLACE(classname,'Grade ','')  = thursday_grade),'/', thursday_section) as thu_grade, CONCAT((select id from class where REPLACE(classname,'Grade ','')  = friday_grade),'/', friday_section) as fri_grade, CONCAT((select id from class where REPLACE(classname,'Grade ','')  = saturday_grade),'/', saturday_section) as sat_grade, CONCAT((select id from class where REPLACE(classname,'Grade ','')  = sunday_grade),'/', sunday_section) as sun_grade,

CASE WHEN monday_grade!='' THEN (SELECT count(gu_id) from game_reports as gd 
join users as u on u.id=gd.gu_id where u.sid=school_id and u.section=monday_section and u.grade_id=((select id from class where REPLACE(classname,'Grade ','')  = monday_grade)) and date(lastupdate) =CURDATE()) END as mon_count,

CASE WHEN tuesday_grade!='' THEN (SELECT count(gu_id) from game_reports as gd 
join users as u on u.id=gd.gu_id where u.sid=school_id and u.section=tuesday_section and u.grade_id=((select id from class where REPLACE(classname,'Grade ','')  = tuesday_grade)) and date(lastupdate) =CURDATE()) END as tue_count,


CASE WHEN wednesday_grade!='' THEN (SELECT count(gu_id) from game_reports as gd 
join users as u on u.id=gd.gu_id where u.sid=school_id and u.section=wednesday_section and u.grade_id=((select id from class where REPLACE(classname,'Grade ','')  = wednesday_grade)) and date(lastupdate) =CURDATE()) END as wed_count,


CASE WHEN thursday_grade!='' THEN (SELECT count(gu_id) from game_reports as gd 
join users as u on u.id=gd.gu_id where u.sid=school_id and u.section=thursday_section and u.grade_id=((select id from class where REPLACE(classname,'Grade ','')  = thursday_grade)) and date(lastupdate) =CURDATE()) END as thu_count,


CASE WHEN friday_grade!='' THEN (SELECT count(gu_id) from game_reports as gd 
join users as u on u.id=gd.gu_id where u.sid=school_id and u.section=friday_section and u.grade_id=((select id from class where REPLACE(classname,'Grade ','')  = friday_grade)) and date(lastupdate) =CURDATE()) END as fri_count,


CASE WHEN saturday_grade!='' THEN (SELECT count(gu_id) from game_reports as gd 
join users as u on u.id=gd.gu_id where u.sid=school_id and u.section=saturday_section and u.grade_id=((select id from class where REPLACE(classname,'Grade ','')  = saturday_grade)) and date(lastupdate) =CURDATE()) END as sat_count,


 (select school_code from schools where id=sp.school_id) as code
from schools_period_schedule sp where academic_id='20' and school_id IN((select id from schools where status=1 and active=1 and id!=2 )) group by period,school_id) as a1 group by period");
			//echo $this->db->last_query(); exit; 
			return $query->result_array();
		}
		
		public function schools_schedule_regusers($schoolid,$gradeid,$section)
		{
			$query = $this->db->query("select count(distinct(u.id)) as regusers,  section, (select school_name from schools where id=u.sid) as schoolname, (select classname from class where id='".$gradeid."') as gradename from users u  where u.grade_id='".$gradeid."' and u.section='".$section."' and u.sid='".$schoolid."' and u.status = 1 and u.visible=1");
			return $query->result_array();
		
		}
		
		public function schools_schedule_takenusers($schoolid,$gradeid,$section)
		{
			
			$query = $this->db->query("select count(distinct(gu_id)) as TrainingTaken from(select gu_id from (SELECT gu_id from game_reports as gd 
join users as u on u.id=gd.gu_id where u.sid=".$schoolid." and u.section='".$section."' and u.grade_id=('".$gradeid."') and date(lastupdate) =CURDATE()) as a1 where gu_id!=0)as a2");
//echo $this->db->last_query(); exit; 
			return $query->result_array();
		
		}
		
		public function schools_schedule_completeusers($schoolid,$gradeid,$section)
		{
		/*	echo "select count(Distinct(gu_id)) as TrainingFullyTaken from(
select gu_id from(SELECT gu_id,set1 from(
SELECT gu_id,count(gr.id) as set1 FROM game_reports as gr 
join users as u on u.id=gr.gu_id where u.sid=".$schoolid." and u.section='".$section."' and u.grade_id='".$gradeid."' and date(lastupdate) =CURDATE() and gu_id!=0  group by gu_id)a1 where set1>=5)b1) c1"; */

			$query = $this->db->query("select count(set1) as TrainingFullyTaken from (select count(gu_id) as set1 from (SELECT gu_id,gs_id FROM game_reports as gr 
join users as u on u.id=gr.gu_id 
where u.sid=".$schoolid." and u.section='".$section."' and u.grade_id='".$gradeid."' and gr.gu_id!=0 and u.status=1 and date(lastupdate) =CURDATE()  group by gu_id,gs_id) a1 where gs_id in(59,60,61,62,63)  group by gu_id)a3 where set1>=5");



			
			//echo $this->db->last_query(); exit; 
			return $query->result_array();
		
		}
		
		public function schoolcodes()
		{
			$query = $this->db->query("SELECT `id`, `school_name`, `school_code`   FROM `schools` WHERE `active` = 1 and `status` = 1 and id!=2 ");
			//echo $this->db->last_query(); exit; 
			return $query->result_array();
		
		}
		
}
