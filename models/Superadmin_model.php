<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin_model extends CI_Model {

        
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
				 $this->load->database();
				 $this->load->library('Multipledb');
        }
		
		public function academicyears()
		{
			$query = $this->db->query('select * from academic_year limit 1');
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function schools()
        {
	
		$query = $this->db->query ('select count(id)  as schoolscount from schools s where s.visible=1 and s.active=1 and s.status=1');	

			return $query->result_array();
        }
		
		public function getacademicdates()
		{
			$query = $this->db->query("select startdate,enddate,id from academic_year where id=20");
			return $query->result_array();
		}
		
		public function students()
        {

		$query = $this->db->query('select count(u.id) as studentscount from users u join schools s on s.id=u.sid  where s.visible=1 and s.active=1 and s.status=1 and u.status=1 and u.visible=1 and u.academicyear=s.academic_id ');

			return $query->result_array();
        }
		public function SchoolStudentCount()
        {

		$query = $this->db->query('select count(u.id) as studentscount,s.id,s.school_name, start_date,(select group_concat(classname) from class where FIND_IN_SET(id,group_concat(distinct grade_id))) as grade_id from users u join schools s on s.id=u.sid  where s.visible=1 and s.active=1 and s.status=1 and u.status=1 and u.visible=1 and u.academicyear=s.academic_id   group by s.id order by studentscount desc');

			return $query->result_array();
        }
		public function GradeStudentCount()
        {

		$query = $this->db->query('select count(u.id) as studentscount,u.grade_id,(select classname from class where id=u.grade_id) as grade  from users u join schools s on s.id=u.sid  where s.visible=1 and s.active=1 and s.status=1 and u.status=1 and u.visible=1 and u.academicyear=s.academic_id  group by u.grade_id order by grade asc');

			return $query->result_array();
        }
		
		public function LowestPlaygames()
        {
		
		$query = $this->db->query("select gcount,group_concat(gname,' (',skill,' - ',grade,')') as gamelist from ( SELECT count(*) as gcount,g_id,(select gname from games where gid=g_id) gname,u.grade_id,(select classname from class where id=u.grade_id) as grade,gr.gs_id,(select name from category_skills where id=gr.gs_id) as skill from game_reports gr join users u on u.id=gr.gu_id where u.status=1 and u.visible=1 and u.sid in (select id from schools where status=1 and visible=1) and gr.gs_id in (59,60,61,62,63) group by g_id) a1 where a1.gname is not NULL group by gcount order by gcount asc limit 10");

			return $query->result_array();
        }
		public function HighestPlaygames()
        {

		$query = $this->db->query("select gcount,group_concat(gname,' (',skill,' - ',grade,')') as gamelist from ( SELECT count(*) as gcount,g_id,(select gname from games where gid=g_id) gname,u.grade_id,(select classname from class where id=u.grade_id) as grade,gr.gs_id,(select name from category_skills where id=gr.gs_id) as skill from game_reports gr join users u on u.id=gr.gu_id where u.status=1 and u.visible=1 and u.sid in (select id from schools where status=1 and visible=1)  and gr.gs_id in (59,60,61,62,63) group by g_id) a1 where a1.gname is not NULL group by gcount order by gcount desc limit 10");

			return $query->result_array();
        }
		
		public function LowestScoreGames()
        {

		$query = $this->db->query("select gname,grade,skill,gscore ,(select count(*) from game_reports ggr join users u on u.id=ggr.gu_id where u.status=1 and u.visible=1 and ggr.gs_id in (59,60,61,62,63) and ggr.g_id=a1.g_id  ) as playedcount from( SELECT round(avg(game_score),2) as gscore,g_id,(select gname from games where gid=g_id) gname,u.grade_id,(select classname from class where id=u.grade_id) as grade,gr.gs_id,(select name from category_skills where id=gr.gs_id) as skill from game_reports gr join users u on u.id=gr.gu_id where u.status=1 and u.visible=1 and u.sid in (select id from schools where status=1 and visible=1)  and gr.gs_id in (59,60,61,62,63) group by g_id ) a1 where a1.gscore<25 and a1.gname is not NULL order by a1.gscore asc");

			return $query->result_array();
        }
		public function HighestScoreGames()
        {

		$query = $this->db->query("select gname,grade,skill,gscore,(select count(*) from game_reports ggr join users u on u.id=ggr.gu_id where u.status=1 and u.visible=1 and ggr.gs_id in (59,60,61,62,63) and ggr.g_id=a1.g_id  ) as playedcount   from( SELECT round(avg(game_score),2) as gscore,g_id,(select gname from games where gid=g_id) gname,u.grade_id,(select classname from class where id=u.grade_id) as grade,gr.gs_id,(select name from category_skills where id=gr.gs_id) as skill from game_reports gr join users u on u.id=gr.gu_id where u.status=1 and u.visible=1 and u.sid in (select id from schools where status=1 and visible=1)  and gr.gs_id in (59,60,61,62,63) group by g_id ) a1 where a1.gscore>75 and a1.gname is not NULL order by a1.gscore desc");

			return $query->result_array();
        }
		
		public function LowestPlaygames_M($months)
        {

		$query = $this->db->query("select gcount,group_concat(gname,' (',skill,' - ',grade,')') as gamelist from ( SELECT count(*) as gcount,g_id,(select gname from games where gid=g_id) gname,u.grade_id,(select classname from class where id=u.grade_id) as grade,gr.gs_id,(select name from category_skills where id=gr.gs_id) as skill from game_reports gr join users u on u.id=gr.gu_id where u.status=1 and u.visible=1 and u.academicyear=20 and u.sid in (select id from schools where status=1 and visible=1 and academic_id=20) and gr.gs_id in (59,60,61,62,63) and DATE_FORMAT(lastupdate,'%m') IN (".$months.") group by g_id) a1 where a1.gname is not NULL group by gcount order by gcount asc limit 10");

			return $query->result_array();
        }
		public function HighestPlaygames_M($months)
        {

		$query = $this->db->query("select gcount,group_concat(gname,' (',skill,' - ',grade,')') as gamelist from ( SELECT count(*) as gcount,g_id,(select gname from games where gid=g_id) gname,u.grade_id,(select classname from class where id=u.grade_id) as grade,gr.gs_id,(select name from category_skills where id=gr.gs_id) as skill from game_reports gr join users u on u.id=gr.gu_id where u.status=1 and u.visible=1 and u.academicyear=20 and u.sid in (select id from schools where status=1 and visible=1 and academic_id=20)  and gr.gs_id in (59,60,61,62,63) and DATE_FORMAT(lastupdate,'%m') IN (".$months.") group by g_id) a1 where a1.gname is not NULL group by gcount order by gcount desc limit 10");

			return $query->result_array();
        }
		
		public function LowestScoreGames_M($months)
        {

		$query = $this->db->query("select gname,grade,skill,gscore ,(select count(*) from game_reports ggr join users u on u.id=ggr.gu_id where u.status=1 and u.visible=1 and ggr.gs_id in (59,60,61,62,63) and ggr.g_id=a1.g_id  ) as playedcount from( SELECT round(avg(game_score),2) as gscore,g_id,(select gname from games where gid=g_id) gname,u.grade_id,(select classname from class where id=u.grade_id) as grade,gr.gs_id,(select name from category_skills where id=gr.gs_id) as skill from game_reports gr join users u on u.id=gr.gu_id where u.status=1 and u.visible=1 and u.academicyear=20 and u.sid in (select id from schools where status=1 and visible=1 and academic_id=20)  and gr.gs_id in (59,60,61,62,63) and DATE_FORMAT(lastupdate,'%m') IN (".$months.") group by g_id ) a1 where a1.gscore<25 and a1.gname is not NULL order by a1.gscore asc");

			return $query->result_array();
        }
		public function HighestScoreGames_M($months)
        {

		$query = $this->db->query("select gname,grade,skill,gscore,(select count(*) from game_reports ggr join users u on u.id=ggr.gu_id where u.status=1 and u.visible=1 and ggr.gs_id in (59,60,61,62,63) and ggr.g_id=a1.g_id  ) as playedcount   from( SELECT round(avg(game_score),2) as gscore,g_id,(select gname from games where gid=g_id) gname,u.grade_id,(select classname from class where id=u.grade_id) as grade,gr.gs_id,(select name from category_skills where id=gr.gs_id) as skill from game_reports gr join users u on u.id=gr.gu_id where u.status=1 and u.visible=1 and u.academicyear=20 and u.sid in (select id from schools where status=1 and visible=1 and academic_id=20)  and gr.gs_id in (59,60,61,62,63) and DATE_FORMAT(lastupdate,'%m') IN (".$months.") group by g_id ) a1 where a1.gscore>75 and a1.gname is not NULL order by a1.gscore desc");

			return $query->result_array();
        } 
		
		public function CurrentDaySchedule()
        {

		//$query = $this->db->query("select period,school_id, grade,gradeid, section,(select count((id)) from users where sid = a2.school_id and grade_id = a2.gradeid and section = a2.section and status=1)as ucount,(select count(distinct(gu_id)) from game_reports gr join users as u on u.id=gr.gu_id where u.sid=a2.school_id and u.grade_id=a2.gradeid and section=a2.section and date(lastupdate) =CURDATE() and gu_id!=0) as attcount from (SELECT period,school_id, grade,(select id from class where REPLACE(classname,'Grade ','')  = grade) as gradeid, section from (SELECT period, school_id, (CASE WHEN dayname(CURDATE()) = 'Monday' THEN monday_grade    WHEN dayname(CURDATE()) = 'Tuesday' THEN `tuesday_grade`  WHEN dayname(CURDATE()) = 'Wednesday' THEN `wednesday_grade` WHEN dayname(CURDATE()) = 'Thursday' THEN `thursday_grade` WHEN dayname(CURDATE()) = 'Friday' THEN friday_grade END ) as grade, (CASE WHEN dayname(CURDATE()) = 'Monday' THEN monday_section  WHEN dayname(CURDATE()) = 'Tuesday' THEN `tuesday_section` WHEN dayname(CURDATE()) = 'Wednesday' THEN `wednesday_section`  WHEN dayname(CURDATE()) = 'Thursday' THEN `thursday_section` WHEN dayname(CURDATE()) = 'Friday' THEN friday_section END) as section from schools_period_schedule WHERE   status = 'Y' and `academic_id` = 20 and `school_id` = (select id from schools where id=school_id) order by period) a1 where grade!='' order by  school_id, period) a2");
		
		$query = $this->db->query("select  period,school_id,  grade,gradeid, section,(select count((id)) from users where sid = a2.school_id and grade_id = a2.gradeid and section = a2.section and status=1 and visible=1)as regusers,(select count(distinct(gu_id)) from game_reports gr join users as u on u.id=gr.gu_id where u.sid=a2.school_id and u.status=1 and u.visible=1 and u.grade_id=a2.gradeid and section=a2.section and date(lastupdate) =CURDATE() and gu_id!=0) as attendusers, (select school_name from schools where id =a2.school_id and status=1 and visible=1 and active=1) as schoolname from (SELECT period,school_id, grade,(select id from class where REPLACE(classname,'Grade ','')  = grade) as gradeid, section from (SELECT period, school_id,  (CASE WHEN dayname(CURDATE()) = 'Monday' THEN monday_grade    WHEN dayname(CURDATE()) = 'Tuesday' THEN `tuesday_grade`  WHEN dayname(CURDATE()) = 'Wednesday' THEN `wednesday_grade` WHEN dayname(CURDATE()) = 'Thursday' THEN `thursday_grade` WHEN dayname(CURDATE()) = 'Friday' THEN friday_grade END ) as grade, (CASE WHEN dayname(CURDATE()) = 'Monday' THEN monday_section  WHEN dayname(CURDATE()) = 'Tuesday' THEN `tuesday_section` WHEN dayname(CURDATE()) = 'Wednesday' THEN `wednesday_section`  WHEN dayname(CURDATE()) = 'Thursday' THEN `thursday_section` WHEN dayname(CURDATE()) = 'Friday' THEN friday_section END) as section from schools_period_schedule WHERE   status = 'Y' and `academic_id` = 20 and `school_id` = (select id from schools where id=school_id and status=1 and visible=1 and active=1) order by period) a1 where grade!='' order by  school_id, period) a2");

			return $query->result_array();
        }
		
		public function trainingbspi($startdate,$enddate)
		{
			$query = $this->db->query('select AVG(bspiscore) as overallbspi from (select avg(score) as bspiscore,id,count(uid) as totstudent,school_name from (select (sum(score1)/5) as score,gu_id,s.id,u.id as uid,s.school_name  from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id in (59,60,61,62,63) and lastupdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id and status=1 join schools s on s.id=u.sid and s.active=1 and s.status=1 group by gu_id) a3 group by id ORDER BY bspiscore DESC) x1 ');
			//echo $this->db->last_query();
			return $query->result_array();
		}
		
		public function schoolwisebspi($startdate,$enddate)
		{
			$query = $this->db->query('select avg(score) as bspiscore,id,count(uid) as totstudent,school_name from (select (sum(score1)/5) as score,gu_id,s.id,u.id as uid,s.school_name  from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id in (59,60,61,62,63) and lastupdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id and status=1 join schools s on s.id=u.sid and s.active=1 and s.status=1 group by gu_id) a3 group by id ORDER BY bspiscore DESC');
			
		
			return $query->result_array();
		}
		
		public function skillwisetopper_memory($skillid,$startdate,$enddate)
		{
			$query = $this->db->query('select avg(score) as finalscore,id,count(uid) as totstu,school_name from (select AVG(score1) as score,gu_id,s.id,u.id as uid,s.school_name  from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id = "'.$skillid.'" and lastupdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id and status=1 join schools s on s.id=u.sid and s.active=1 and s.status=1 group by gu_id) a3 group by id ORDER BY finalscore DESC');
			
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		 public function getschools()
        {
			$query = $this->db->query('select * from schools where status=1 and active=1 and visible=1 and id!=2');
			
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
						
			$query = $this->db->query ('select DISTINCT(sid)  as schoolid, (select school_name from schools where id=schoolid) as schoolname from users u join game_reports gr on u.id=gr.gu_id join schools s on s.id=u.sid where lastupdate BETWEEN "'.$startdate.'" and "'.$enddate.'" and s.active=1 and u.status=1 order by schoolid');
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		
		 public function getgrades_chk($startdate,$enddate)
        {
						
			$query = $this->db->query ('(SELECT (AVG(game_score)) as score , gs_id , gu_id, (SELECT grade_id from users where id=gr.gu_id and status=1) as gradeid, (SELECT classname from class where id=gradeid) as gradename, lastupdate FROM game_reports gr WHERE gs_id in (59,60,61,62,63) and lastupdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" and gu_id in (select users.id FROM users JOIN schools as s ON users.sid=s.id WHERE users.status=1 and s.active=1 and s.status=1) group by gradeid)');	
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
		
			$query = $this->db->query('select avg(score) as bspiscore,id,count(uid) as totstudent,gradeid,(SELECT classname from class where id=gradeid) as gradename,school_name from (select (sum(score1)/5) as score,gu_id,s.id,u.id as uid,s.school_name,(SELECT grade_id from users where id=gu_id and users.status=1) as gradeid  from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id in (59,60,61,62,63) and lastupdate BETWEEN "'.$startdate.'" and "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id and status=1 join schools s on s.id=u.sid and s.active=1 and s.status=1 where s.id = "'.$schoolid.'" and u.grade_id = "'.$gradeid.'" and section="'.$sectionid.'" group by gu_id) a3 group by gradeid,id');
			
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
(select (AVG(score)) as skillscore_L, gu_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id =63 and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) s5 on s5.gu_id=mu.id where sid="'.$schoolid.'" and grade_id="'.$gradeid.'" and section="'.$sectionid.'" ORDER BY avgbspiset1 DESC');
//echo $this->db->last_query(); exit;
		return $query->result_array();
		 
}

public function skillscore_reports($schoolid,$gradeid,$skillid,$sectionid)
        {
				$query = $this->db->query('select id, fname, sid,(select school_name from schools where id = "'.$schoolid.'") as schoolname, (select name from category_skills where id ="'.$skillid.'") as skill, section, grade_id,(select classname from class where id=grade_id) as gradename,a2.score,a2.rstime from users mu left join (select (AVG(score)) as score, (AVG(restime)) as rstime, gu_id, gs_id, (select name from category_skills where id ="'.$skillid.'") as skillname, (SELECT sid from users where id=gu_id) as schoolid from (SELECT (AVG(`game_score`)) as score , (AVG(rtime)) as restime, gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id ="'.$skillid.'" and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) a2 on a2.gu_id=mu.id where sid="'.$schoolid.'" and grade_id="'.$gradeid.'" and section="'.$sectionid.'" ORDER BY a2.score DESC' );			
			
			//echo $this->db->last_query(); exit;
			return $query->result_array();
			
		}
		
		public function skillscore_skl_grade_sect_wise($startdate,$enddate,$schoolid,$gradeid,$skillid,$sectionid)
        {
				$query = $this->db->query('select avg(score) as finalscore,id,count(uid) as totstu,gradeid,(select name from category_skills where id ="'.$skillid.'" ) as skillname,(SELECT classname from class where id=gradeid) as gradename,school_name from (select AVG(score1) as score,gu_id,s.id,u.id as uid,s.school_name,(SELECT grade_id from users where id=gu_id and users.status=1) as gradeid from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id = "'.$skillid.'" and lastupdate BETWEEN "'.$startdate.'" and "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id and u.grade_id="'.$gradeid.'" and u.section="'.$sectionid.'" and  status=1 join schools s on s.id="'.$schoolid.'" and s.active=1 and s.status=1 group by gu_id) a3 group by gradeid,id');			
			
			//echo $this->db->last_query(); exit;
			return $query->result_array();
			
		}
		
		public function getClassPerformace_data($schoolid,$gradeid,$sectionid,$tablename,$rangefrom,$rangeto,$startdate,$enddate)
        {
			$query = $this->db->query('select  (@cnt := @cnt + 1) AS rowNumber,id, fname as name,lname,avatarimage, IF(avgbspiset1 IS NULL,0,avgbspiset1) as bspi from (select id as id, fname,lname,avatarimage, grade_id,(select classname from class where id=grade_id) as gradename,a3.finalscore as avgbspiset1 from users mu  left join 
 (SELECT SUM(score)/5 as finalscore, gu_id, (SELECT sid from users where id=gu_id) as schoolid from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM '.$tablename.' WHERE gs_id in (59,60,61,62,63) and lastupdate between "'.$startdate.'" and "'.$enddate.'" and gu_id in (select id from users) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id) a3   on a3.gu_id=mu.id where sid="'.$schoolid.'" and grade_id="'.$gradeid.'" and section="'.$sectionid.'" and a3.finalscore BETWEEN '.$rangefrom.' AND  '.$rangeto.' ORDER BY avgbspiset1 ASC ) as a5 CROSS JOIN (SELECT @cnt := 0) AS dummy');
 
			//echo $this->db->last_query(); 
			return $query->result_array();
		}
		
		 public function getsection($schoolid,$gradeid)
        {
			$query = $this->db->query('select id,section from skl_class_section where class_id="'.$gradeid.'" and school_id="'.$schoolid.'"');
		//	echo $this->db->last_query(); exit;
			return $query->result_array();
			
		}
		
		public function schoolwise_gradewise_bspi_avg($startdate,$enddate,$gradeids,$schoolids)
		{
			//echo $gradeids; 
			//echo $schoolids; exit;
			$where = "";
			if($gradeids=='' && $schoolids=='') 
			{	 $where = ""; } else {  $where="where s.id IN (".$schoolids.") and u.grade_id IN (".$gradeids.")";}
		
			$query = $this->db->query('select avg(score) as bspiscore,id,count(uid) as totstudent,gradeid,(SELECT classname from class where id=gradeid) as gradename,school_name from (select (sum(score1)/5) as score,gu_id,s.id,u.id as uid,s.school_name,(SELECT grade_id from users where id=gu_id and users.status=1) as gradeid  from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id in (59,60,61,62,63) and lastupdate BETWEEN "'.$startdate.'" and "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id and status=1 join schools s on s.id=u.sid and s.active=1 and s.status=1 '.$where.' group by gu_id) a3 group by gradeid,id');
		
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function gradewise_bspi_avg($startdate,$enddate,$schoolid)
		{
			$where = "";
			if($schoolid=='') 
			{	 $where = ""; } else {  $where="where id=".$schoolid."";}
		
			$query = $this->db->query('select avg(bspiscore) as overallbspi,id,gradeid,(SELECT classname from class where id=gradeid) as gradename from (select avg(score) as bspiscore,id,gradeid,(SELECT classname from class where id=gradeid) as gradename,school_name from (select (sum(score1)/5) as score,gu_id,s.id,u.id as uid,s.school_name,(SELECT grade_id from users where id=gu_id and users.status=1) as gradeid  from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id in (59,60,61,62,63) and lastupdate BETWEEN "'.$startdate.'" and "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id and status=1 join schools s on s.id=u.sid and s.active=1 and s.status=1 group by gu_id) a3 group by gradeid,id) a4 '.$where.' group by gradeid');
			
			
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function skl_gradewise_skillscore($skillid,$startdate,$enddate)
		{
			$query = $this->db->query('select avg(score) as finalscore,id,count(uid) as totstu,gradeid,(select name from category_skills where id ="'.$skillid.'" ) as skillname,(SELECT classname from class where id=gradeid) as gradename,school_name from (select AVG(score1) as score,gu_id,s.id,u.id as uid,s.school_name,(SELECT grade_id from users where id=gu_id and users.status=1) as gradeid from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id = "'.$skillid.'" and lastupdate BETWEEN "'.$startdate.'" and "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id and status=1 join schools s on s.id=u.sid and s.active=1 and s.status=1 group by gu_id) a3 group by gradeid,id');
			
			//(select (AVG(score)) as finalscore, skillname,(select school_name from schools where id=schoolid) as schoolname, gradeid, (SELECT classname from class where id=gradeid) as gradename, schoolid from (select (AVG(score)) as score, gu_id, gs_id, (select name from category_skills where id =gs_id ) as skillname, (SELECT sid from users where id=gu_id) as schoolid,(SELECT grade_id from users where id=gu_id and users.status=1) as gradeid from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id ="'.$skillid.'" and lastupdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" and gu_id in (select users.id FROM users JOIN schools as s ON users.sid=s.id WHERE users.status=1 and s.active=1 and s.status=1) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id )a2 group by schoolid,gradeid,gs_id) ORDER BY gradeid
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function gradewise_skillscore($skillid,$startdate,$enddate,$schoolid)
		{
			$where = "";
			if($schoolid=='') 
			{	 $where = ""; } else {  $where="where id=".$schoolid."";}
			
			$query = $this->db->query('SELECT avg(finalscore) as overallskillscore,id,gradeid,(select name from category_skills where id ="'.$skillid.'" ) as skillname,(SELECT classname from class where id=gradeid) as gradename from (select avg(score) as finalscore,id,count(uid) as totstu,gradeid,(SELECT classname from class where id=gradeid) as gradename,school_name from (select AVG(score1) as score,gu_id,s.id,u.id as uid,s.school_name,(SELECT grade_id from users where id=gu_id and users.status=1) as gradeid from(select AVG(score) as score1,gs_id,gu_id from (SELECT avg(game_score) as score,gu_id, gs_id from game_reports WHERE gs_id = "'.$skillid.'" and lastupdate BETWEEN "'.$startdate.'" and "'.$enddate.'" GROUP by gu_id,gs_id,lastupdate) a1 GROUP by gu_id,gs_id) as a2 join users u on u.id=a2.gu_id and status=1 join schools s on s.id=u.sid and s.active=1 and s.status=1 group by gu_id) a3 group by gradeid,id) a4 '.$where.'  group by gradeid');
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function getusercount($data0)
        {
			$query = $this->db->query("select count(*) as userCount from users where username LIKE (select concat('$data0_%'))");
			return $query->result_array();
		}
		
		public function userimport($shpassword,$salt1,$salt2,$data0,$data1,$data2,$data3,$data4,$schoolid,$ddlGradeType,$ceationkey)
        {
			$creationdate = date("Y-m-d H:i:s");
			$query = $this->db->query("INSERT INTO users(password,salt1,salt2,creation_date, fname, lname, gender, dob, status, gp_id, grade_id, username,  sid, section, academicyear, creationkey) VALUES ('$shpassword','$salt1','$salt2','$creationdate','$data0','$data1','$data2','$data3','1',(select id from g_plans where grade_id=$ddlGradeType limit 1),'$ddlGradeType',(select concat('$data0','.',(select school_code from schools limit 1))),'$schoolid','$data4',(select id from academic_year limit 1), '".$ceationkey."' )");
			
			//return $query->result_array();
		}
		
		public function userimport1($shpassword,$salt1,$salt2,$data0,$data1,$data2,$data3,$data4,$schoolid,$ddlGradeType,$ceationkey,$userexist)
        {
			$creationdate = date("Y-m-d H:i:s");
			$query = $this->db->query("INSERT INTO users(password,salt1,salt2,creation_date, fname, lname, gender, dob, status, gp_id, grade_id, username,  sid, section, academicyear,creationkey) VALUES ('$shpassword','$salt1','$salt2','$creationdate','$data0','$data1','$data2','$data3','1',(select id from g_plans where grade_id=$ddlGradeType limit 1),'$ddlGradeType',(select concat('$data0','_',($userexist+1),'.',(select school_code from schools limit 1))),'$schoolid','$data4',(select id from academic_year limit 1), '".$ceationkey."')");
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
			$query = $this->db->query("select id,school_name from schools where status=1");
			return $query->result_array();
		}
		public function GetSchoolWiseToppersBSPI($schoolqry,$gradeqry,$typeids,$monthqry)
		{ 	
			$query = $this->db->query("select bspi1.gu_id,bspi1.sid,bspi1.grade_id,bspi1.bspi,bspi1.monthNumber,bspi1.monthName,(select username from users where id = bspi1.gu_id) as username,(select section from users where id = bspi1.gu_id) as sectionname,(select classname from class where id = bspi1.grade_id)as classname,(select school_name from schools where id = bspi1.sid)as school_name  from vi_avguserbspiscore bspi1 join vi_monthwisebspi bspi2 on bspi1.bspi=bspi2.bspi where bspi1.sid=bspi2.sid and bspi1.grade_id=bspi2.grade_id and bspi1.monthNumber=bspi2.monthNumber ".$schoolqry." ".$gradeqry."  ".$monthqry." ");
			
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
			$query = $this->db->query("select count(distinct(u.id)) as regusers,  section, (select school_name from schools where id=u.sid) as schoolname, (select classname from class where id='".$gradeid."') as gradename from users u  where u.grade_id='".$gradeid."' and u.section='".$section."' and u.sid='".$schoolid."' and u.status = 1");
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
			
			$query = $this->db->query("select count(Distinct(gu_id)) as TrainingFullyTaken from(
select gu_id from(SELECT gu_id,set1 from(
SELECT gu_id,count(gr.id) as set1 FROM game_reports as gr 
join users as u on u.id=gr.gu_id where u.sid=".$schoolid." and u.section='".$section."' and u.grade_id='".$gradeid."' and date(lastupdate) =CURDATE() and gu_id!=0  group by gu_id)a1 where set1>=5)b1) c1");
			
			//echo $this->db->last_query(); exit; 
			return $query->result_array();
		
		}
		
		public function schoolcodes()
		{
			$query = $this->db->query("SELECT `id`, `school_name`, `school_code`   FROM `schools` WHERE `active` = 1 and `status` = 1 and visible=1 and id!=2 ");
			//echo $this->db->last_query(); exit; 
			return $query->result_array();
		
		}
		
		public function schoolsession()
		{
			$query = $this->db->query(" select  period,school_id, start_time, end_time, remarks,   grade,gradeid, section,(select count((id)) from users where sid = a2.school_id and grade_id = a2.gradeid and section = a2.section and status=1 and visible=1)as regusers,(select count((id)) from users where sid = a2.school_id and grade_id = a2.gradeid and section = a2.section and status=1 and visible=1 and login_date=CURDATE())as loginuser,(select count(distinct(gu_id)) from game_reports gr join users as u on u.id=gr.gu_id where u.sid=a2.school_id and u.status=1 and u.visible=1 and u.grade_id=a2.gradeid and section=a2.section and date(lastupdate) =CURDATE() and gu_id!=0) as attendusers, (select school_name from schools where id =a2.school_id and status=1 and visible=1 and active=1) as schoolname from (SELECT period,school_id, start_time, end_time, remarks,  grade,(select id from class where REPLACE(classname,'Grade ','')  = grade) as gradeid, section 
			
			from (SELECT period, school_id, start_time, end_time, remarks,   (CASE WHEN dayname(CURDATE()) = 'Monday' THEN monday_grade    WHEN dayname(CURDATE()) = 'Tuesday' THEN `tuesday_grade`  WHEN dayname(CURDATE()) = 'Wednesday' THEN `wednesday_grade` WHEN dayname(CURDATE()) = 'Thursday' THEN `thursday_grade` WHEN dayname(CURDATE()) = 'Friday' THEN friday_grade END ) as grade, 

(CASE WHEN dayname(CURDATE()) = 'Monday' THEN monday_section  WHEN dayname(CURDATE()) = 'Tuesday' THEN `tuesday_section` WHEN dayname(CURDATE()) = 'Wednesday' THEN `wednesday_section`  WHEN dayname(CURDATE()) = 'Thursday' THEN `thursday_section` WHEN dayname(CURDATE()) = 'Friday' THEN friday_section END) as section

from schools_period_schedule WHERE   status = 'Y' and `academic_id` = 20 and `school_id` = (select id from schools where id=school_id  and status=1 and visible=1 and active=1) order by period) a1 where grade!='' order by  school_id, period) a2 where  school_id NOT IN (select school_id from schools_leave_list where leave_date=date_format(curdate(), '%Y-%m-%d') and status=1 and academic_id = 20  )  order by  start_time");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function training_completedusers()
		{
		//	echo "select count(distinct(gu_id)) as cuser, sid, grade_id, section from (select gu_id, set1, sid, grade_id, section from (SELECT gu_id,count(gr.id) as set1, sid, grade_id, section FROM game_reports as gr join users as u on u.id=gr.gu_id where date(lastupdate) = CURDATE() and gu_id!=0 and u.status=1 and u.visible=1 group by gu_id) a1 where set1>=5) x1 group by sid, grade_id, section";
			$query = $this->db->query("select count(set1) as cuser,sid, grade_id, section from (select count(gu_id) as set1,gu_id,sid,section,grade_id from (SELECT gu_id,gs_id,u.sid,u.section,u.grade_id  FROM game_reports as gr 
join users as u on u.id=gr.gu_id 
where  gr.gu_id!=0 and u.status=1 and u.visible=1 and date(lastupdate) =  CURDATE()  group by gu_id,gs_id) a1 where gs_id in(59,60,61,62,63)  group by gu_id, sid, grade_id, section)a3 where set1>=5 group by sid, grade_id, section");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function schoolgrades($schoolid)
		{
			$query = $this->db->query("select  DISTINCT sc.class_id as id, c.classname from skl_class_section sc join class c ON sc.class_id = c.id Where sc.school_id = '".$schoolid."'");
		//	echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function tracking_report1($startdate,$enddate,$schoolid,$grade,$section)
		{
				if($grade==''){	$gradeqry='1=1';}else{$gradeqry='gradeid='.$grade;}
				if($section==''){$sectionqry='and 1=1';}else{$sectionqry='and section="'.$section.'" ';}
				
			$query = $this->db->query("select selected_date, gradename, gradeid,section,(select count(distinct(u.id)) as regusers from users u  where u.grade_id=gradeid and u.section=y1.section and u.sid='".$schoolid."' and u.status = 1 and u.visible=1) as totalusers,

(SELECT count(distinct(gu_id)) as com from game_reports as gd 
join users as u on u.id=gd.gu_id where u.sid='".$schoolid."'  and u.grade_id=gradeid and u.section=y1.section  and date(lastupdate) = selected_date and gd.gu_id!=0) as attenusers

from (select concat('Grade', '',monday_grade) as gradename, selected_date, (select id from class where REPLACE(classname,'Grade ','')  = monday_grade) as gradeid,section from (select * from (

select monday_grade,monday_section as section,'Monday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and monday_grade!=''

union select tuesday_grade,tuesday_section as section,'Tuesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and tuesday_grade!=''

union select wednesday_grade,wednesday_section as section,'Wednesday' as dayname1  from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and wednesday_grade!=''

union select thursday_grade,thursday_section as section,'Thursday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and thursday_grade!=''

union select friday_grade,friday_section as section,'Friday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and friday_grade!=''

union select saturday_grade,saturday_section as section,'Saturday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and saturday_grade!=''

union select sunday_grade,sunday_section as section,'Sunday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and sunday_grade!='')j1 cross join 

(select *,dayname(selected_date) as nameofday from 
(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
where selected_date between '".$startdate."' and '".$enddate."' and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = '".$schoolid."' and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1)y1 where ".$gradeqry." ".$sectionqry);
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function tracking_report1_cusers($startdate,$enddate,$schoolid,$grade,$section)
		{	
			if($grade==''){	$gradeqry='1=1';}else{$gradeqry='grade_id='.$grade;}
			if($section==''){$sectionqry='and 1=1';}else{$sectionqry='and section="'.$section.'" ';}
				
			$query = $this->db->query("select * from(

select count(set1) as cuser, 'Monday' as dayname1, grade_id,lastupdate,section, (select classname from class where id=grade_id) as gname from (select count(gu_id) as set1,gu_id,grade_id,section,lastupdate from (SELECT gu_id,gs_id,u.grade_id,u.section, lastupdate FROM game_reports as gr join users as u on u.id=gr.gu_id where gr.gu_id!=0 and u.status=1 and u.visible=1 and u.sid = '".$schoolid."' and dayname(gr.lastupdate) = 'Monday' and gr.lastupdate between '".$startdate."' and '".$enddate."' group by gu_id,gs_id,lastupdate) a1 where gs_id in(59,60,61,62,63) group by gu_id, grade_id, lastupdate)a3 where set1>=5 group by grade_id,section,lastupdate
union

select count(set1) as cuser, 'Tuesday' as dayname1, grade_id,lastupdate,section, (select classname from class where id=grade_id) as gname from (select count(gu_id) as set1,gu_id,grade_id,section,lastupdate from (SELECT gu_id,gs_id,u.grade_id,u.section,lastupdate FROM game_reports as gr join users as u on u.id=gr.gu_id where gr.gu_id!=0 and u.status=1 and u.visible=1 and u.sid = '".$schoolid."' and dayname(gr.lastupdate) = 'Tuesday' and gr.lastupdate between '".$startdate."' and '".$enddate."' group by gu_id,gs_id,lastupdate) a1 where gs_id in(59,60,61,62,63) group by gu_id, grade_id, lastupdate)a3 where set1>=5 group by grade_id,section,lastupdate

union

select count(set1) as cuser, 'Wednesday' as dayname1, grade_id,lastupdate,section, (select classname from class where id=grade_id) as gname from (select count(gu_id) as set1,gu_id,grade_id,section,lastupdate from (SELECT gu_id,gs_id,u.grade_id,u.section,lastupdate FROM game_reports as gr join users as u on u.id=gr.gu_id where gr.gu_id!=0 and u.status=1 and u.visible=1 and u.sid = '".$schoolid."' and dayname(gr.lastupdate) = 'Wednesday' and gr.lastupdate between '".$startdate."' and '".$enddate."' group by gu_id,gs_id,lastupdate) a1 where gs_id in(59,60,61,62,63) group by gu_id, grade_id, lastupdate)a3 where set1>=5 group by grade_id,section,lastupdate

union

select count(set1) as cuser, 'Thursday' as dayname1, grade_id,lastupdate,section, (select classname from class where id=grade_id) as gname from (select count(gu_id) as set1,gu_id,grade_id,section,lastupdate from (SELECT gu_id,gs_id,u.grade_id,u.section, lastupdate FROM game_reports as gr join users as u on u.id=gr.gu_id where gr.gu_id!=0 and u.status=1 and u.visible=1 and u.sid = '".$schoolid."' and dayname(gr.lastupdate) = 'Thursday' and gr.lastupdate between '".$startdate."' and '".$enddate."' group by gu_id,gs_id,lastupdate) a1 where gs_id in(59,60,61,62,63) group by gu_id, grade_id, lastupdate)a3 where set1>=5 group by grade_id,section,lastupdate

union

select count(set1) as cuser, 'Friday' as dayname1, grade_id,lastupdate,section,(select classname from class where id=grade_id) as gname from (select count(gu_id) as set1,gu_id,grade_id,section,lastupdate from (SELECT gu_id,gs_id,u.grade_id,u.section,lastupdate FROM game_reports as gr join users as u on u.id=gr.gu_id where gr.gu_id!=0 and u.status=1 and u.visible=1 and u.sid = '".$schoolid."' and dayname(gr.lastupdate) = 'Friday' and gr.lastupdate between '".$startdate."' and '".$enddate."' group by gu_id,gs_id,lastupdate) a1 where gs_id in(59,60,61,62,63) group by gu_id, grade_id, lastupdate)a3 where set1>=5 group by grade_id,section,lastupdate

union

select count(set1) as cuser, 'Saturday' as dayname1, grade_id,lastupdate,section, (select classname from class where id=grade_id) as gname from (select count(gu_id) as set1,gu_id,grade_id,section,lastupdate from (SELECT gu_id,gs_id,u.grade_id,u.section,lastupdate FROM game_reports as gr join users as u on u.id=gr.gu_id where gr.gu_id!=0 and u.status=1 and u.visible=1 and u.sid = '".$schoolid."' and dayname(gr.lastupdate) = 'Saturday' and gr.lastupdate between '".$startdate."' and '".$enddate."' group by gu_id,gs_id,lastupdate) a1 where gs_id in(59,60,61,62,63) group by gu_id, grade_id, lastupdate)a3 where set1>=5 group by grade_id,section,lastupdate
) 
j1 cross join 
(select *,dayname(selected_date) as nameofday from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where selected_date between '".$startdate."' and '".$enddate."') j2 on j1.lastupdate=j2.selected_date where ".$gradeqry." ".$sectionqry." order by selected_date asc");

			//echo $this->db->last_query(); exit;
			return $query->result_array();
			
			
		}
	public function getsectionajax($schoolid,$gradeid)
	{
		$query = $this->db->query("select id,section from skl_class_section where class_id='".$gradeid."' and school_id='".$schoolid."' ");
	//	echo $this->db->last_query(); exit;
		return $query->result_array();
		
	} 
	public function tracking_gamereport($startdate,$enddate,$schoolid,$grade,$section)
	{	
		if($grade==''){	$gradeqry='1=1';}else{$gradeqry='grade_id='.$grade;}
		if($section==''){$sectionqry='1=1';}else{$sectionqry='section="'.$section.'" ';}
		
		$query = $this->db->query("select g_id,gamename,playedcount,(select name from category_skills where id=a1.gs_id) as skill,(select classname from class where id=grade_id) as gradename,section,(select school_name from schools where id=sid) as schoolname,lastupdate from (select count(g_id) as playedcount,g_id,gs_id,(select gname from games where gid=gr.g_id) as gamename,u.grade_id,u.section,u.sid,gr.lastupdate from game_reports as gr join users as u on u.id=gr.gu_id where g_id!=0 and gu_id!=0 and u.status=1 and  u.visible=1 and lastupdate between '".$startdate."' and '".$enddate."' group by gr.g_id,u.grade_id ) a1 where ".$gradeqry." and ".$sectionqry." and sid=".$schoolid." order by playedcount desc ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
		
	}
	public function tracking_report2($schoolid,$startdate,$enddate)
        {
			$query = $this->db->query("select avg(game_score) as score,gs_id,(select classname from class where id=u.grade_id) as gradename, u.grade_id,section,sid from (select avg(game_score) as game_score,gu_id,gs_id,lastupdate from game_reports where gs_id in (59,60,61,62,63) and lastupdate between '".$startdate."' and '".$enddate."' and g_id!=0 and gs_id!=0 and gu_id!=0 group by gs_id,gu_id, lastupdate) a1 join users u on u.id=a1.gu_id and sid='".$schoolid."' group by gs_id,grade_id,section,sid");
			
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function bspi_report_lessthan_forty()
        {
			
			$query = $this->db->query("select username,name,(select school_name from schools where id=schoolid and status=1 and active=1 and visible=1) as schoolname,section,(select classname from class where id=grade_id) as grade,finalscore from (SELECT SUM(score)/5 as finalscore,count(gu_id) as playedcount, gu_id,(SELECT username from users where id=gu_id and status=1 and visible=1) as username,(SELECT fname from users where id=gu_id and status=1 and visible=1) as name,(SELECT sid from users where id=gu_id and status=1 and visible=1) as schoolid,(SELECT grade_id from users where id=gu_id and status=1 and visible=1) as grade_id,(SELECT section from users where id=gu_id and status=1 and visible=1) as section from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select u.id from users u join schools as s ON s.id=u.sid where u.status=1 and u.visible=1 and s.visible=1) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id)a1 where playedcount=5 and finalscore<40 order by finalscore");	
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function bspi_report_forty_to_sixty()
        {
			
			$query = $this->db->query("select username,name,(select school_name from schools where id=schoolid and status=1 and active=1 and visible=1) as schoolname,section,(select classname from class where id=grade_id) as grade,finalscore from (SELECT SUM(score)/5 as finalscore,count(gu_id) as playedcount, gu_id,(SELECT username from users where id=gu_id and status=1 and visible=1) as username,(SELECT fname from users where id=gu_id and status=1 and visible=1) as name,(SELECT sid from users where id=gu_id and status=1 and visible=1) as schoolid,(SELECT grade_id from users where id=gu_id and status=1 and visible=1) as grade_id,(SELECT section from users where id=gu_id and status=1 and visible=1) as section from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select u.id from users u join schools as s ON s.id=u.sid where u.status=1 and u.visible=1 and s.visible=1) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id)a1 where playedcount=5 and (finalscore>= 40 and finalscore<60) order by finalscore");	
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function bspi_report_sixty_to_eighty()
        {
			
			$query = $this->db->query("select username,name,(select school_name from schools where id=schoolid and status=1 and active=1 and visible=1) as schoolname,section,(select classname from class where id=grade_id) as grade,finalscore from (SELECT SUM(score)/5 as finalscore,count(gu_id) as playedcount, gu_id,(SELECT username from users where id=gu_id and status=1 and visible=1) as username,(SELECT fname from users where id=gu_id and status=1 and visible=1) as name,(SELECT sid from users where id=gu_id and status=1 and visible=1) as schoolid,(SELECT grade_id from users where id=gu_id and status=1 and visible=1) as grade_id,(SELECT section from users where id=gu_id and status=1 and visible=1) as section from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select u.id from users u join schools as s ON s.id=u.sid where u.status=1 and u.visible=1 and s.visible=1) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id)a1 where playedcount=5 and (finalscore>= 60 and finalscore<80) order by finalscore");	
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function bspi_report_more_than_eighty()
        {
			
			$query = $this->db->query("select username,name,(select school_name from schools where id=schoolid and status=1 and active=1 and visible=1) as schoolname,section,(select classname from class where id=grade_id) as grade,finalscore from (SELECT SUM(score)/5 as finalscore,count(gu_id) as playedcount, gu_id,(SELECT username from users where id=gu_id and status=1 and visible=1) as username,(SELECT fname from users where id=gu_id and status=1 and visible=1) as name,(SELECT sid from users where id=gu_id and status=1 and visible=1) as schoolid,(SELECT grade_id from users where id=gu_id and status=1 and visible=1) as grade_id,(SELECT section from users where id=gu_id and status=1 and visible=1) as section from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select u.id from users u join schools as s ON s.id=u.sid where u.status=1 and u.visible=1 and s.visible=1) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id)a1 where playedcount=5 and finalscore>=80 order by finalscore");	
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function skillscore_lessthan_forty($skillid)
        {
			$query = $this->db->query("select id, fname, username, sid,(select school_name from schools where id = schoolid and active=1 and status=1 and visible=1) as schoolname, (select name from category_skills where id ='".$skillid."') as skill, a2.section, grade_id,(select classname from class where id=gradeid) as gradename,a2.score from users mu left join (select (AVG(score)) as score, gu_id, gs_id, (select name from category_skills where id ='".$skillid."') as skillname, (SELECT sid from users where id=gu_id and status=1 and visible=1) as schoolid, (SELECT grade_id from users where id=gu_id and status=1 and visible=1) as gradeid, (SELECT section from users where id=gu_id and status=1 and visible=1) as section from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id ='".$skillid."' and gu_id in (select id from users where status=1 and visible=1 and sid!=2) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) a2 on a2.gu_id=mu.id where gs_id='".$skillid."' and status=1 and visible=1 and a2.score<40  ORDER BY a2.score");	
			//echo $this->db->last_query(); exit;
			return $query->result_array();
			
			
		}
		
		public function skillscore_forty_to_sixty($skillid)
        {
			$query = $this->db->query("select id, fname, username, sid,(select school_name from schools where id = schoolid and active=1 and status=1 and visible=1) as schoolname, (select name from category_skills where id ='".$skillid."') as skill, a2.section, grade_id,(select classname from class where id=gradeid) as gradename,a2.score from users mu left join (select (AVG(score)) as score, gu_id, gs_id, (select name from category_skills where id ='".$skillid."') as skillname, (SELECT sid from users where id=gu_id and status=1 and visible=1) as schoolid, (SELECT grade_id from users where id=gu_id and status=1 and visible=1) as gradeid, (SELECT section from users where id=gu_id and status=1 and visible=1) as section from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id ='".$skillid."' and gu_id in (select id from users where status=1 and visible=1 and sid!=2) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) a2 on a2.gu_id=mu.id where gs_id='".$skillid."' and status=1 and visible=1 and (a2.score>= 40 and a2.score<60)  ORDER BY a2.score");	
			//echo $this->db->last_query(); exit;
			return $query->result_array();
			
			
		}
		
		public function skillscore_sixty_to_eighty($skillid)
        {
			$query = $this->db->query("select id, fname, username, sid,(select school_name from schools where id = schoolid and active=1 and status=1 and visible=1) as schoolname, (select name from category_skills where id ='".$skillid."') as skill, a2.section, grade_id,(select classname from class where id=gradeid) as gradename,a2.score from users mu left join (select (AVG(score)) as score, gu_id, gs_id, (select name from category_skills where id ='".$skillid."') as skillname, (SELECT sid from users where id=gu_id and status=1 and visible=1) as schoolid, (SELECT grade_id from users where id=gu_id and status=1 and visible=1) as gradeid, (SELECT section from users where id=gu_id and status=1 and visible=1) as section from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id ='".$skillid."' and gu_id in (select id from users where status=1 and visible=1 and sid!=2) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) a2 on a2.gu_id=mu.id where gs_id='".$skillid."' and status=1 and visible=1 and (a2.score>= 60 and a2.score<80)  ORDER BY a2.score");	
			//echo $this->db->last_query(); exit;
			return $query->result_array();
			
		}
		
		public function skillscore_more_than_eighty($skillid)
        {
			$query = $this->db->query("select id, fname, username, sid,(select school_name from schools where id = schoolid and active=1 and status=1 and visible=1) as schoolname, (select name from category_skills where id ='".$skillid."') as skill, a2.section, grade_id,(select classname from class where id=gradeid) as gradename,a2.score from users mu left join (select (AVG(score)) as score, gu_id, gs_id, (select name from category_skills where id ='".$skillid."') as skillname, (SELECT sid from users where id=gu_id and status=1 and visible=1) as schoolid, (SELECT grade_id from users where id=gu_id and status=1 and visible=1) as gradeid, (SELECT section from users where id=gu_id and status=1 and visible=1) as section from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id ='".$skillid."' and gu_id in (select id from users where status=1 and visible=1 and sid!=2) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id) a2 on a2.gu_id=mu.id where gs_id='".$skillid."' and status=1 and visible=1 and a2.score>= 80   ORDER BY a2.score");	
			//echo $this->db->last_query(); exit;
			return $query->result_array();
			
		}
		
		public function getskills()
        {
			$query = $this->db->query("select id, name from category_skills where category_id=1");	
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function getacademicyearbyschoolid($sid)
		{
			$query = $this->db->query("select startdate,enddate,id from academic_year where id=(select academic_id from schools where id='".$sid."')order by id desc limit 1");
			return $query->result_array();
		}
		public function getacademicmonths($startdate,$enddate)
		{			 
		$query = $this->db->query("select m1 as startdate,LAST_DAY(m1) as enddate,DATE_FORMAT(m1, '%m') as monthNumber,DATE_FORMAT(m1, '%Y') as yearNumber,DATE_FORMAT(m1, '%b') as monthName from (select ('".$startdate."' - INTERVAL DAYOFMONTH('".$startdate."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from(select 1 union select 2 union select 3 union select 4) t1,(select 1 union select 2 union select 3 union select 4) t2,(select 1 union select 2 union select 3 union select 4) t3,(select 1 union select 2 union select 3 union select 4) t4,(select @rownum:=-1) t0) d1) d2 where m1<='".$enddate."' order by m1");
		//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
public function eom_utilizationreportbygrade($schoolid,$startdate,$enddate)
{ 
$query = $this->db->query("select weekval,sum(totalusers) as totalusers,selected_date,gradename,section,gradeid from (select selected_date,weekval,y1.gradename,y1.gradeid,y1.section,count(distinct(u.id)) as totalusers from 

(select concat('Grade', '',monday_grade) as gradename, selected_date,weekval,(select id from class where REPLACE(classname,'Grade ','') = monday_grade) as gradeid,section from (select * from ( select monday_grade,monday_section as section,'Monday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and monday_grade!='' union select tuesday_grade,tuesday_section as section,'Tuesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and tuesday_grade!='' union select wednesday_grade,wednesday_section as section,'Wednesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and wednesday_grade!='' union select thursday_grade,thursday_section as section,'Thursday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and thursday_grade!='' union select friday_grade,friday_section as section,'Friday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and friday_grade!='' union select saturday_grade,saturday_section as section,'Saturday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and saturday_grade!='' union select sunday_grade,sunday_section as section,'Sunday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and sunday_grade!='')j1 cross join (select selected_date,dayname(selected_date) as nameofday,
CASE WHEN MONTH('".$startdate."')=(select MONTH(start_date) from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) THEN (FLOOR((DAYOFMONTH(selected_date) - DAYOFMONTH((select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1))) / 7) + 1) ELSE (FLOOR((DAYOFMONTH(selected_date) - 1) / 7) + 1) END as weekval
 from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where selected_date between '".$startdate."' and '".$enddate."' and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = '".$schoolid."' and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1)

y1 join users as u on u.grade_id=y1.gradeid and u.section=y1.section and u.sid='".$schoolid."' and u.status = 1 and u.visible=1 group by y1.gradeid,y1.section,selected_date order by selected_date) a2 group by gradeid,section,weekval order by weekval,selected_date ");

//echo $this->db->last_query(); exit;
return $query->result_array();
}

public function eom_utilizationreportbygrade_nonschedule($schoolid,$startdate,$enddate)
{ 
$query = $this->db->query("select weekval,sum(totalusers) as totalusers,selected_date,gradename,section,gradeid from (select selected_date,weekval,y1.gradename,y1.gradeid,y1.section,count(distinct(u.id)) as totalusers from 

(select concat('Grade', '',monday_grade) as gradename, selected_date,weekval,(select id from class where REPLACE(classname,'Grade ','') = monday_grade) as gradeid,section from (select * from ( select monday_grade,monday_section as section,'Monday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and monday_grade!='' union select tuesday_grade,tuesday_section as section,'Tuesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and tuesday_grade!='' union select wednesday_grade,wednesday_section as section,'Wednesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and wednesday_grade!='' union select thursday_grade,thursday_section as section,'Thursday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and thursday_grade!='' union select friday_grade,friday_section as section,'Friday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and friday_grade!='' union select saturday_grade,saturday_section as section,'Saturday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and saturday_grade!='' union select sunday_grade,sunday_section as section,'Sunday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and sunday_grade!='')j1 cross join (select selected_date,dayname(selected_date) as nameofday,
CASE WHEN MONTH('".$startdate."')=(select MONTH(start_date) from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) THEN (FLOOR((DAYOFMONTH(selected_date) - DAYOFMONTH((select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1))) / 7) + 1) ELSE (FLOOR((DAYOFMONTH(selected_date) - 1) / 7) + 1) END as weekval
 from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where selected_date between '".$startdate."' and '".$enddate."' and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = '".$schoolid."' and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1)

y1 join users as u on u.grade_id=y1.gradeid and u.section=y1.section and u.sid='".$schoolid."' and u.status = 1 and u.visible=1 group by y1.gradeid,y1.section,selected_date order by selected_date) a2 group by gradeid,section,weekval order by weekval,selected_date ");

//echo $this->db->last_query(); exit;
return $query->result_array();
}
public function eom_utilizationreport($schoolid,$startdate,$enddate)
{ 
$query = $this->db->query("select selected_date,weekval,sum(totalusers) as totalusers from (select selected_date,weekval,y1.gradename,y1.gradeid,y1.section,count(distinct(u.id)) as totalusers from 

(select concat('Grade', '',monday_grade) as gradename, selected_date,weekval,(select id from class where REPLACE(classname,'Grade ','') = monday_grade) as gradeid,section from (select * from ( select monday_grade,monday_section as section,'Monday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and monday_grade!='' union select tuesday_grade,tuesday_section as section,'Tuesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and tuesday_grade!='' union select wednesday_grade,wednesday_section as section,'Wednesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and wednesday_grade!='' union select thursday_grade,thursday_section as section,'Thursday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and thursday_grade!='' union select friday_grade,friday_section as section,'Friday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and friday_grade!='' union select saturday_grade,saturday_section as section,'Saturday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and saturday_grade!='' union select sunday_grade,sunday_section as section,'Sunday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and sunday_grade!='')j1 cross join (select selected_date,dayname(selected_date) as nameofday,CASE WHEN MONTH('".$startdate."')=(select MONTH(start_date) from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) THEN (FLOOR((DAYOFMONTH(selected_date) - DAYOFMONTH((select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1))) / 7) + 1) ELSE (FLOOR((DAYOFMONTH(selected_date) - 1) / 7) + 1) END as weekval from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where selected_date between '".$startdate."' and '".$enddate."' and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = '".$schoolid."' and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1)

y1 join users as u on u.grade_id=y1.gradeid and u.section=y1.section and u.sid='".$schoolid."' and u.status = 1 and u.visible=1 group by y1.gradeid,y1.section,selected_date order by selected_date) a2  group by weekval order by weekval,selected_date ");

//echo $this->db->last_query(); exit;
return $query->result_array();
}
			
public function eom_utilizationreport_cusers($schoolid,$startdate,$enddate)
{	
$query = $this->db->query("select count(*) as completeduser,weekval,gradename,gradeid,section from (select count(*) as cntval,weekval,gradename,gradeid,section,id from ( select selected_date,weekval,a2.gradename,a2.gradeid,a2.section,a2.id,gs_id from 

(select selected_date,weekval,y1.gradename,y1.gradeid,y1.section,u.id from 

(select concat('Grade', '',monday_grade) as gradename, selected_date,weekval,(select id from class where REPLACE(classname,'Grade ','') = monday_grade) as gradeid,section from (select * from ( select monday_grade,monday_section as section,'Monday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and monday_grade!='' union select tuesday_grade,tuesday_section as section,'Tuesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and tuesday_grade!='' union select wednesday_grade,wednesday_section as section,'Wednesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and wednesday_grade!='' union select thursday_grade,thursday_section as section,'Thursday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and thursday_grade!='' union select friday_grade,friday_section as section,'Friday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and friday_grade!='' union select saturday_grade,saturday_section as section,'Saturday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and saturday_grade!='' union select sunday_grade,sunday_section as section,'Sunday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and sunday_grade!='')j1 cross join 

(select selected_date,dayname(selected_date) as nameofday,CASE WHEN MONTH('".$startdate."')=(select MONTH(start_date) from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) THEN (FLOOR((DAYOFMONTH(selected_date) - DAYOFMONTH((select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1))) / 7) + 1) ELSE (FLOOR((DAYOFMONTH(selected_date) - 1) / 7) + 1) END as weekval from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where selected_date between '".$startdate."' and '".$enddate."' and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = '".$schoolid."' and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1)

y1 join users as u on u.grade_id=y1.gradeid and u.section=y1.section and u.sid='".$schoolid."' and u.status = 1 and u.visible=1 group by y1.gradeid,y1.section,selected_date,u.id order by selected_date) a2 

join game_reports as gd on gd.gu_id=a2.id and date(gd.lastupdate) = a2.selected_date group by a2.gradeid,a2.section,selected_date,gs_id,gu_id)Z1

group by weekval,gradename,gradeid,section,id)zz1 where cntval>=5  group by weekval");
//echo $this->db->last_query(); exit;
			return $query->result_array();
	}
public function eom_utilizationreportbygrade_cusers($schoolid,$startdate,$enddate)
{	
$query = $this->db->query("select count(*) as completeduser,weekval,gradename,gradeid,section from (select count(*) as cntval,weekval,gradename,gradeid,section,id from ( select selected_date,weekval,a2.gradename,a2.gradeid,a2.section,a2.id,gs_id from 

(select selected_date,weekval,y1.gradename,y1.gradeid,y1.section,u.id from 

(select concat('Grade', '',monday_grade) as gradename, selected_date,weekval,(select id from class where REPLACE(classname,'Grade ','') = monday_grade) as gradeid,section from (select * from ( select monday_grade,monday_section as section,'Monday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and monday_grade!='' union select tuesday_grade,tuesday_section as section,'Tuesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and tuesday_grade!='' union select wednesday_grade,wednesday_section as section,'Wednesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and wednesday_grade!='' union select thursday_grade,thursday_section as section,'Thursday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and thursday_grade!='' union select friday_grade,friday_section as section,'Friday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and friday_grade!='' union select saturday_grade,saturday_section as section,'Saturday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and saturday_grade!='' union select sunday_grade,sunday_section as section,'Sunday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and sunday_grade!='')j1 cross join 

(select selected_date,dayname(selected_date) as nameofday,CASE WHEN MONTH('".$startdate."')=(select MONTH(start_date) from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) THEN (FLOOR((DAYOFMONTH(selected_date) - DAYOFMONTH((select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1))) / 7) + 1) ELSE (FLOOR((DAYOFMONTH(selected_date) - 1) / 7) + 1) END as weekval from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where selected_date between '".$startdate."' and '".$enddate."' and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = '".$schoolid."' and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1)

y1 join users as u on u.grade_id=y1.gradeid and u.section=y1.section and u.sid='".$schoolid."' and u.status = 1 and u.visible=1 group by y1.gradeid,y1.section,selected_date,u.id order by selected_date) a2 

join game_reports as gd on gd.gu_id=a2.id  and date(gd.lastupdate) = a2.selected_date group by a2.gradeid,a2.section,selected_date,gs_id,gu_id)Z1

group by weekval,gradename,gradeid,section,id)zz1 where cntval>=5  group by weekval,gradeid,section");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
}

public function eom_utilizationreportbygrade_cusers_nonschedule($schoolid,$startdate,$enddate)
{	
$query = $this->db->query("select count(*) as completeduser,weekval,gradename,gradeid,section from (select count(*) as cntval,weekval,gradename,gradeid,section,id from ( select selected_date,weekval,a2.gradename,a2.gradeid,a2.section,a2.id,gs_id from 

(select selected_date,weekval,y1.gradename,y1.gradeid,y1.section,u.id from 

(select concat('Grade', '',monday_grade) as gradename, selected_date,weekval,(select id from class where REPLACE(classname,'Grade ','') = monday_grade) as gradeid,section from (select * from ( select monday_grade,monday_section as section,'Monday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and monday_grade!='' union select tuesday_grade,tuesday_section as section,'Tuesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and tuesday_grade!='' union select wednesday_grade,wednesday_section as section,'Wednesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and wednesday_grade!='' union select thursday_grade,thursday_section as section,'Thursday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and thursday_grade!='' union select friday_grade,friday_section as section,'Friday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and friday_grade!='' union select saturday_grade,saturday_section as section,'Saturday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and saturday_grade!='' union select sunday_grade,sunday_section as section,'Sunday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and sunday_grade!='')j1 cross join 

(select selected_date,dayname(selected_date) as nameofday,CASE WHEN MONTH('".$startdate."')=(select MONTH(start_date) from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) THEN (FLOOR((DAYOFMONTH(selected_date) - DAYOFMONTH((select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1))) / 7) + 1) ELSE (FLOOR((DAYOFMONTH(selected_date) - 1) / 7) + 1) END as weekval from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where selected_date between '".$startdate."' and '".$enddate."' and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = '".$schoolid."' and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1)

y1 join users as u on u.grade_id=y1.gradeid and u.section=y1.section and u.sid='".$schoolid."' and u.status = 1 and u.visible=1 group by y1.gradeid,y1.section,selected_date,u.id order by selected_date) a2 

join game_reports as gd on gd.gu_id=a2.id  and date(gd.lastupdate) = a2.selected_date group by a2.gradeid,a2.section,selected_date,gs_id,gu_id)Z1

group by weekval,gradename,gradeid,section,id)zz1 where cntval>=5  group by weekval,gradeid,section");
			//echo $this->db->last_query(); exit;
			return $query->result_array();
}
public function eom_ureportbygrade_ausers($schoolid,$startdate,$enddate)
{	
	$query = $this->db->query("select weekval,selected_date,sum(attenusers) as attenusers,round(avg(bspi),2) as bspi,gradename,section,gradeid from
(select selected_date,weekval,a2.gradename,a2.gradeid,a2.section,count(distinct(gu_id)) as attenusers,(select avg(finalscore) as bspi from vii_daywiseuserbspiscore as ub where ub.grade_id=u1.grade_id and ub.section=u1.section and ub.sid=u1.sid  and ub.lastupdate=a2.selected_date) as bspi from 
(select concat('Grade', '',monday_grade) as gradename, selected_date,weekval,(select id from class where REPLACE(classname,'Grade ','') = monday_grade) as gradeid,section from(select * from 
( select monday_grade,monday_section as section,'Monday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and monday_grade!='' union select tuesday_grade,tuesday_section as section,'Tuesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and tuesday_grade!='' 
union select wednesday_grade,wednesday_section as section,'Wednesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and wednesday_grade!='' 
union select thursday_grade,thursday_section as section,'Thursday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and thursday_grade!='' 
union select friday_grade,friday_section as section,'Friday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and friday_grade!='' 
union select saturday_grade,saturday_section as section,'Saturday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and saturday_grade!='' 
union select sunday_grade,sunday_section as section,'Sunday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and sunday_grade!='')j1 cross join 
(select selected_date,dayname(selected_date) as nameofday,CASE WHEN MONTH('".$startdate."')=(select MONTH(start_date) from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) THEN (FLOOR((DAYOFMONTH(selected_date) - DAYOFMONTH((select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1))) / 7) + 1) ELSE (FLOOR((DAYOFMONTH(selected_date) - 1) / 7) + 1) END as weekval from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where selected_date between '".$startdate."' and '".$enddate."'  and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = '".$schoolid."' and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1)a2 
join users as u1 on u1.grade_id=a2.gradeid and u1.section=a2.section and u1.sid='".$schoolid."' and u1.status = 1 and u1.visible=1 join game_reports as gd on gd.gu_id=u1.id and date(gd.lastupdate) = a2.selected_date group by a2.gradeid,a2.section,selected_date)
 a5 group by gradeid,section,weekval order by weekval,selected_date");
	//echo $this->db->last_query(); exit;
	return $query->result_array();
}

public function eom_ureportbygrade_ausers_nonschedule($schoolid,$startdate,$enddate)
{	
	$query = $this->db->query("select weekval,selected_date,sum(attenusers) as attenusers,round(avg(bspi),2) as bspi,gradename,section,gradeid from
(select selected_date,weekval,a2.gradename,a2.gradeid,a2.section,count(distinct(gu_id)) as attenusers,(select avg(finalscore) as bspi from vii_daywiseuserbspiscore as ub where ub.grade_id=u1.grade_id and ub.section=u1.section and ub.sid=u1.sid  and ub.lastupdate=a2.selected_date) as bspi from 
(select concat('Grade', '',monday_grade) as gradename, selected_date,weekval,(select id from class where REPLACE(classname,'Grade ','') = monday_grade) as gradeid,section from(select * from 
( select monday_grade,monday_section as section,'Monday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and monday_grade!='' union select tuesday_grade,tuesday_section as section,'Tuesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and tuesday_grade!='' 
union select wednesday_grade,wednesday_section as section,'Wednesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and wednesday_grade!='' 
union select thursday_grade,thursday_section as section,'Thursday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and thursday_grade!='' 
union select friday_grade,friday_section as section,'Friday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and friday_grade!='' 
union select saturday_grade,saturday_section as section,'Saturday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and saturday_grade!='' 
union select sunday_grade,sunday_section as section,'Sunday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and sunday_grade!='')j1 cross join 
(select selected_date,dayname(selected_date) as nameofday,CASE WHEN MONTH('".$startdate."')=(select MONTH(start_date) from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) THEN (FLOOR((DAYOFMONTH(selected_date) - DAYOFMONTH((select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1))) / 7) + 1) ELSE (FLOOR((DAYOFMONTH(selected_date) - 1) / 7) + 1) END as weekval from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where selected_date between '".$startdate."' and '".$enddate."'  and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = '".$schoolid."' and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1)a2 
join users as u1 on u1.grade_id=a2.gradeid and u1.section=a2.section and u1.sid='".$schoolid."' and u1.status = 1 and u1.visible=1 join game_reports as gd on gd.gu_id=u1.id and date(gd.lastupdate) = a2.selected_date group by a2.gradeid,a2.section,selected_date)
 a5 group by gradeid,section,weekval order by weekval,selected_date");
	//echo $this->db->last_query(); exit;
	return $query->result_array();
}

public function eom_ureport_ausers($schoolid,$startdate,$enddate)
{	
	$query = $this->db->query("select weekval,selected_date,sum(attenusers) as attenusers,gradename,section,gradeid from
(select selected_date,weekval,a2.gradename,a2.gradeid,a2.section,count(distinct(gu_id)) as attenusers from 
(select concat('Grade', '',monday_grade) as gradename, selected_date,weekval,(select id from class where REPLACE(classname,'Grade ','') = monday_grade) as gradeid,section from (select * from 
( select monday_grade,monday_section as section,'Monday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and monday_grade!='' union select tuesday_grade,tuesday_section as section,'Tuesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and tuesday_grade!='' 
union select wednesday_grade,wednesday_section as section,'Wednesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and wednesday_grade!='' 
union select thursday_grade,thursday_section as section,'Thursday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and thursday_grade!='' 
union select friday_grade,friday_section as section,'Friday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and friday_grade!='' 
union select saturday_grade,saturday_section as section,'Saturday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and saturday_grade!='' 
union select sunday_grade,sunday_section as section,'Sunday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and sunday_grade!='')j1 cross join 
(select selected_date,dayname(selected_date) as nameofday,CASE WHEN MONTH('".$startdate."')=(select MONTH(start_date) from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) THEN (FLOOR((DAYOFMONTH(selected_date) - DAYOFMONTH((select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1))) / 7) + 1) ELSE (FLOOR((DAYOFMONTH(selected_date) - 1) / 7) + 1) END as weekval from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where selected_date between '".$startdate."' and '".$enddate."'  and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = '".$schoolid."' and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1)a2 
join users as u1 on u1.grade_id=a2.gradeid and u1.section=a2.section and u1.sid='".$schoolid."' and u1.status = 1 and u1.visible=1 
join game_reports as gd on gd.gu_id=u1.id and date(gd.lastupdate) = a2.selected_date group by a2.gradeid,a2.section,selected_date)
 a5 group by weekval order by weekval,selected_date");
	//echo $this->db->last_query(); exit;
	return $query->result_array();
}

public function eom_ureport_timetaken($schoolid,$startdate,$enddate)
{	
	$query = $this->db->query("select weekval,selected_date,round(avg(avgtimetaken),2) as avgtimetaken,gradename,section,gradeid from
(select selected_date,weekval,a2.gradename,a2.gradeid,a2.section,avg(rtime) as avgtimetaken from 
(select concat('Grade', '',monday_grade) as gradename, selected_date,weekval,(select id from class where REPLACE(classname,'Grade ','') = monday_grade) as gradeid,section from(select * from 
( select monday_grade,monday_section as section,'Monday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and monday_grade!='' union select tuesday_grade,tuesday_section as section,'Tuesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and tuesday_grade!='' 
union select wednesday_grade,wednesday_section as section,'Wednesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and wednesday_grade!='' 
union select thursday_grade,thursday_section as section,'Thursday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and thursday_grade!='' 
union select friday_grade,friday_section as section,'Friday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and friday_grade!='' 
union select saturday_grade,saturday_section as section,'Saturday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and saturday_grade!='' 
union select sunday_grade,sunday_section as section,'Sunday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and sunday_grade!='')j1 cross join 
(select selected_date,dayname(selected_date) as nameofday,CASE WHEN MONTH('".$startdate."')=(select MONTH(start_date) from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) THEN (FLOOR((DAYOFMONTH(selected_date) - DAYOFMONTH((select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1))) / 7) + 1) ELSE (FLOOR((DAYOFMONTH(selected_date) - 1) / 7) + 1) END as weekval from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where selected_date between '".$startdate."' and '".$enddate."'  and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = '".$schoolid."' and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1)a2 
join users as u1 on u1.grade_id=a2.gradeid and u1.section=a2.section and u1.sid='".$schoolid."' and u1.status = 1 and u1.visible=1 join game_reports as gd on gd.gu_id=u1.id and date(gd.lastupdate) = a2.selected_date group by a2.gradeid,a2.section,selected_date)
 a5 group by gradeid,section,weekval order by weekval,selected_date");
	//echo $this->db->last_query(); exit;
	return $query->result_array();
}


	public function trainingmonthwisebspi($schoolid,$monthNumber)
	{
		$query = $this->db->query("select round(avg(finalscore),2) as score,sid,grade_id,(select classname from class where id=grade_id) as gradename,section from vii_avguserbspiscorebymon where sid='".$schoolid."' and monthNumber='".$monthNumber."' group by grade_id, section");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function assessmentmonthwisebspi($schoolid,$monthNumber)
	{
		$query = $this->multipledb->db->query("select gu_id,set1,ROUND(avg(bspi),2) as avgbspi,grade_id,sid,section,school_name,CONCAT(grade_id,section) as rowval,(select classname from class where id=u.grade_id) as gradename  from(SELECT gu_id,count(id) as set1,sum(game_score)/5 as bspi FROM game_reports where gu_id!=0 group by gu_id)a1 join users u on u.id=a1.gu_id where set1>=5 and  u.sid='".$schoolid."'  group by u.grade_id,u.section");
		//echo $this->multipledb->db->last_query(); exit;
		return $query->result_array();
	}
	public function bspigradetoppers($schoolid,$monthNumber)
	{
		$query = $this->db->query("select bspi,monthName,monthNumber,sid,gu_id,grade_id,section,(select GROUP_CONCAT(CONCAT(fname,' ',lname)) from users where id = gu_id) as username,classname,school_name,section from
(select bspi,monthName,monthNumber,sid,gu_id,grade_id,(select CONCAT(fname,' ',lname) from users where id = gu_id) as username,(select classname from class where id = grade_id)as classname,(select school_name from schools where id = sid)as school_name,section from (select finalscore as bspi,gu_id,monthNumber,monthName,sid,grade_id,section from vii_avguserbspiscorebymon) as a1 where a1.gu_id in (select id from users where status=1 and visible=1) and a1.sid='".$schoolid."' and ROUND(a1.bspi,2)in(select bspi from vii_bspigradetoppersbysec as vv3 where vv3.monthNumber =a1.monthNumber and vv3.monthNumber='".$monthNumber."'  and vv3.sid='".$schoolid."' )) as a5 group by grade_id,section");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}	
	public function overallbspitoppers($schoolid,$monthNumber)
	{
		$query = $this->db->query("select bspi,monthName,monthNumber,sid,gu_id,grade_id,section,(select GROUP_CONCAT(CONCAT(fname,' ',lname)) from users where id = gu_id) as username,classname,school_name,section from (select bspi,monthName,monthNumber,sid,gu_id,grade_id,(select CONCAT(fname,' ',lname) from users where id = gu_id) as username,(select classname from class where id = grade_id)as classname,(select school_name from schools where id = sid)as school_name,section from(select finalscore as bspi,gu_id,monthNumber,monthName,sid,grade_id,section from vii_avguserbspiscorebymon where sid='".$schoolid."' and monthNumber='".$monthNumber."' order by finalscore desc limit 0,10) as a1 where a1.gu_id in (select id from users where status=1 and visible=1) and a1.sid='".$schoolid."') as a5 ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function bspiranges($schoolid,$monthNumber)
	{
		$query = $this->db->query("select scorerange, count(*) rangecount,schoolid,grade_id,(select classname from class where id=grade_id) as gradename,section from 
(SELECT SUM(score)/5 as finalscore, case when (SUM(score)/5) <=20 then '<=20' when (SUM(score)/5) >20 and (SUM(score)/5) <=40 then  '20-40' when (SUM(score)/5) >40 and (SUM(score)/5) <=60 then '40-60' when (SUM(score)/5) >60 and (SUM(score)/5) <=80 then '60-80' when (SUM(score)/5) >80 then '>80' end as scorerange,count(gu_id) as playedcount, gu_id,(SELECT username from users where id=gu_id and status=1 and visible=1) as username,(SELECT fname from users where id=gu_id and status=1 and visible=1) as name,(SELECT grade_id from users where id=gu_id and status=1 and visible=1) as grade_id,(SELECT section from users where id=gu_id and status=1 and visible=1) as section,(SELECT sid from users where id=gu_id and status=1 and visible=1) as schoolid from 
(select (AVG(score)) as score, gu_id, gs_id from 
(SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select id from users  where status=1 and visible=1 and sid='".$schoolid."' and month(lastupdate)='".$monthNumber."' ) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id)a1 group by scorerange,schoolid,grade_id,section");
//echo $this->db->last_query(); exit;
return $query->result_array();
	}
	public function notattendeduser($schoolid,$monthNumber)
	{
		$query = $this->db->query("select count(id) as notatteneduser,grade_id,section,username,fname,lname from users where id Not IN(select gu_id from game_reports where month(lastupdate)='".$monthNumber."') and sid='".$schoolid."' and status=1 and visible=1 group by grade_id,section");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function notattendeduserlist($schoolid,$monthNumber)
	{
		$query = $this->db->query("select id,grade_id,(select count(DISTINCT lastupdate) as countval from game_reports where gu_id=users.id and month(lastupdate)='".$monthNumber."') as playedcount,(select classname from class where id=grade_id) as gradename,section,username,fname,lname from users where id Not IN(select gu_id from game_reports where month(lastupdate)='".$monthNumber."') and sid='".$schoolid."' and status=1 and visible=1 ");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function regattenduser($schoolid,$month0,$month1)
	{ 
		$query = $this->db->query("select sum(totalusers) as totaluser,sum(attenusers) as attenusers from (select selected_date, gradename, gradeid,section,(select count(distinct(u.id)) as regusers from users u  where u.grade_id=gradeid and u.section=y1.section and u.sid='".$schoolid."' and u.status = 1 and u.visible=1) as totalusers,

(SELECT count(distinct(gu_id)) as com from game_reports as gd 
join users as u on u.id=gd.gu_id where u.sid='".$schoolid."'  and u.grade_id=gradeid and u.section=y1.section  and date(lastupdate) = selected_date and gd.gu_id!=0) as attenusers

from (select concat('Grade', '',monday_grade) as gradename, selected_date, (select id from class where REPLACE(classname,'Grade ','')  = monday_grade) as gradeid,section from (select * from (

select monday_grade,monday_section as section,'Monday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and monday_grade!=''

union select tuesday_grade,tuesday_section as section,'Tuesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and tuesday_grade!=''

union select wednesday_grade,wednesday_section as section,'Wednesday' as dayname1  from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and wednesday_grade!=''

union select thursday_grade,thursday_section as section,'Thursday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and thursday_grade!=''

union select friday_grade,friday_section as section,'Friday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and friday_grade!=''

union select saturday_grade,saturday_section as section,'Saturday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and saturday_grade!=''

union select sunday_grade,sunday_section as section,'Sunday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and sunday_grade!='')j1 cross join 

(select *,dayname(selected_date) as nameofday from 
(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
where selected_date between '".$month0."' and '".$month1."' and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = '".$schoolid."' and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1)y1)a1");
//echo $this->db->last_query(); exit;
return $query->result_array();
	}
	
	public function regattenduser_nonschedule($schoolid,$month0,$month1)
	{ 
		$query = $this->db->query("select sum(totalusers) as totaluser,sum(attenusers) as attenusers from (select selected_date, gradename, gradeid,section,(select count(distinct(u.id)) as regusers from users u  where u.grade_id=gradeid and u.section=y1.section and u.sid='".$schoolid."' and u.status = 1 and u.visible=1) as totalusers,

(SELECT count(distinct(gu_id)) as com from game_reports as gd 
join users as u on u.id=gd.gu_id where u.sid='".$schoolid."'  and u.grade_id=gradeid and u.section=y1.section  and date(lastupdate) = selected_date and gd.gu_id!=0) as attenusers

from (select concat('Grade', '',monday_grade) as gradename, selected_date, (select id from class where REPLACE(classname,'Grade ','')  = monday_grade) as gradeid,section from (select * from (

select monday_grade,monday_section as section,'Monday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and monday_grade!=''

union select tuesday_grade,tuesday_section as section,'Tuesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and tuesday_grade!=''

union select wednesday_grade,wednesday_section as section,'Wednesday' as dayname1  from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and wednesday_grade!=''

union select thursday_grade,thursday_section as section,'Thursday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and thursday_grade!=''

union select friday_grade,friday_section as section,'Friday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and friday_grade!=''

union select saturday_grade,saturday_section as section,'Saturday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and saturday_grade!=''

union select sunday_grade,sunday_section as section,'Sunday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and sunday_grade!='')j1 cross join 

(select *,dayname(selected_date) as nameofday from 
(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
where selected_date between '".$month0."' and '".$month1."' and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = '".$schoolid."' and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1)y1)a1");
//echo $this->db->last_query(); exit;
return $query->result_array();
	}
	 public function completeduser($schoolid,$month0,$month1)
	{
		$query = $this->db->query("select count(*) as completeduser from (select count(*) as cntval,weekval,gradename,gradeid,section,id from ( select selected_date,weekval,a2.gradename,a2.gradeid,a2.section,a2.id,gs_id from 

(select selected_date,weekval,y1.gradename,y1.gradeid,y1.section,u.id from 

(select concat('Grade', '',monday_grade) as gradename, selected_date,weekval,(select id from class where REPLACE(classname,'Grade ','') = monday_grade) as gradeid,section from (select * from ( select monday_grade,monday_section as section,'Monday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and monday_grade!='' union select tuesday_grade,tuesday_section as section,'Tuesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and tuesday_grade!='' union select wednesday_grade,wednesday_section as section,'Wednesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and wednesday_grade!='' union select thursday_grade,thursday_section as section,'Thursday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and thursday_grade!='' union select friday_grade,friday_section as section,'Friday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and friday_grade!='' union select saturday_grade,saturday_section as section,'Saturday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and saturday_grade!='' union select sunday_grade,sunday_section as section,'Sunday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and sunday_grade!='')j1 cross join 

(select selected_date,dayname(selected_date) as nameofday,CASE WHEN MONTH('".$month0."')=(select MONTH(start_date) from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) THEN (FLOOR((DAYOFMONTH(selected_date) - DAYOFMONTH((select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1))) / 7) + 1) ELSE (FLOOR((DAYOFMONTH(selected_date) - 1) / 7) + 1) END as weekval from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where selected_date between '".$month0."' and '".$month1."' and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = '".$schoolid."' and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1)

y1 join users as u on u.grade_id=y1.gradeid and u.section=y1.section and u.sid='".$schoolid."' and u.status = 1 and u.visible=1 group by y1.gradeid,y1.section,selected_date,u.id order by selected_date) a2 

join game_reports as gd on gd.gu_id=a2.id and date(gd.lastupdate) = a2.selected_date group by a2.gradeid,a2.section,selected_date,gs_id,gu_id)Z1

group by weekval,gradename,gradeid,section,id)zz1 where cntval>=5");
return $query->result_array();
	} 
	
	public function completeduser_nonschedule($schoolid,$month0,$month1)
	{
		$query = $this->db->query("select count(*) as completeduser from (select count(*) as cntval,weekval,gradename,gradeid,section,id from ( select selected_date,weekval,a2.gradename,a2.gradeid,a2.section,a2.id,gs_id from 

(select selected_date,weekval,y1.gradename,y1.gradeid,y1.section,u.id from 

(select concat('Grade', '',monday_grade) as gradename, selected_date,weekval,(select id from class where REPLACE(classname,'Grade ','') = monday_grade) as gradeid,section from (select * from ( select monday_grade,monday_section as section,'Monday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and monday_grade!='' union select tuesday_grade,tuesday_section as section,'Tuesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and tuesday_grade!='' union select wednesday_grade,wednesday_section as section,'Wednesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and wednesday_grade!='' union select thursday_grade,thursday_section as section,'Thursday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and thursday_grade!='' union select friday_grade,friday_section as section,'Friday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and friday_grade!='' union select saturday_grade,saturday_section as section,'Saturday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and saturday_grade!='' union select sunday_grade,sunday_section as section,'Sunday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and sunday_grade!='')j1 cross join 

(select selected_date,dayname(selected_date) as nameofday,CASE WHEN MONTH('".$month0."')=(select MONTH(start_date) from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) THEN (FLOOR((DAYOFMONTH(selected_date) - DAYOFMONTH((select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1))) / 7) + 1) ELSE (FLOOR((DAYOFMONTH(selected_date) - 1) / 7) + 1) END as weekval from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where selected_date between '".$month0."' and '".$month1."' and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = '".$schoolid."' and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1)

y1 join users as u on u.grade_id=y1.gradeid and u.section=y1.section and u.sid='".$schoolid."' and u.status = 1 and u.visible=1 group by y1.gradeid,y1.section,selected_date,u.id order by selected_date) a2 

join game_reports as gd on gd.gu_id=a2.id and date(gd.lastupdate) = a2.selected_date group by a2.gradeid,a2.section,selected_date,gs_id,gu_id)Z1

group by weekval,gradename,gradeid,section,id)zz1 where cntval>=5");
return $query->result_array();
	}
	public function bspilessthan_twentity($schoolid,$monthNumber)
	{
		$query = $this->db->query("select username,name,(select school_name from schools where id='18' and status=1 and active=1 and visible=1) as schoolname,section,(select classname from class where id=grade_id) as grade,finalscore from (SELECT SUM(score)/5 as finalscore,count(gu_id) as playedcount, gu_id,(SELECT username from users where id=gu_id and status=1 and visible=1) as username,(SELECT fname from users where id=gu_id and status=1 and visible=1) as name,(SELECT grade_id from users where id=gu_id and status=1 and visible=1) as grade_id,(SELECT section from users where id=gu_id and status=1 and visible=1) as section from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select id from users  where status=1 and visible=1 and sid='".$schoolid."' and month(lastupdate)='".$monthNumber."' ) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id)a1 where finalscore<=20  order by finalscore");
		return $query->result_array();
	}
	public function bspilessthan_twentytoforty($schoolid,$monthNumber)
	{
		$query = $this->db->query("select username,name,(select school_name from schools where id='18' and status=1 and active=1 and visible=1) as schoolname,section,(select classname from class where id=grade_id) as grade,finalscore from (SELECT SUM(score)/5 as finalscore,count(gu_id) as playedcount, gu_id,(SELECT username from users where id=gu_id and status=1 and visible=1) as username,(SELECT fname from users where id=gu_id and status=1 and visible=1) as name,(SELECT grade_id from users where id=gu_id and status=1 and visible=1) as grade_id,(SELECT section from users where id=gu_id and status=1 and visible=1) as section from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select id from users  where status=1 and visible=1 and sid='".$schoolid."' and month(lastupdate)='".$monthNumber."' ) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id)a1 where finalscore >20 and finalscore<=40  order by finalscore");
		return $query->result_array();
	}
	public function bspilessthan_fortytosixty($schoolid,$monthNumber)
	{
		$query = $this->db->query("select username,name,(select school_name from schools where id='18' and status=1 and active=1 and visible=1) as schoolname,section,(select classname from class where id=grade_id) as grade,finalscore from (SELECT SUM(score)/5 as finalscore,count(gu_id) as playedcount, gu_id,(SELECT username from users where id=gu_id and status=1 and visible=1) as username,(SELECT fname from users where id=gu_id and status=1 and visible=1) as name,(SELECT grade_id from users where id=gu_id and status=1 and visible=1) as grade_id,(SELECT section from users where id=gu_id and status=1 and visible=1) as section from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select id from users  where status=1 and visible=1 and sid='".$schoolid."' and month(lastupdate)='".$monthNumber."' ) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id)a1 where finalscore >40 and finalscore<=60 order by finalscore");
		return $query->result_array();
	}
	public function bspilessthan_sixtytoeighty($schoolid,$monthNumber)
	{
		$query = $this->db->query("select username,name,(select school_name from schools where id='18' and status=1 and active=1 and visible=1) as schoolname,section,(select classname from class where id=grade_id) as grade,finalscore from (SELECT SUM(score)/5 as finalscore,count(gu_id) as playedcount, gu_id,(SELECT username from users where id=gu_id and status=1 and visible=1) as username,(SELECT fname from users where id=gu_id and status=1 and visible=1) as name,(SELECT grade_id from users where id=gu_id and status=1 and visible=1) as grade_id,(SELECT section from users where id=gu_id and status=1 and visible=1) as section from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select id from users  where status=1 and visible=1 and sid='".$schoolid."' and month(lastupdate)='".$monthNumber."' ) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id)a1 where finalscore >60 and finalscore<=80 order by finalscore");
		return $query->result_array();
	}
	public function bspilessthan_aboveeighty($schoolid,$monthNumber)
	{
		$query = $this->db->query("select username,name,(select school_name from schools where id='18' and status=1 and active=1 and visible=1) as schoolname,section,(select classname from class where id=grade_id) as grade,finalscore from (SELECT SUM(score)/5 as finalscore,count(gu_id) as playedcount, gu_id,(SELECT username from users where id=gu_id and status=1 and visible=1) as username,(SELECT fname from users where id=gu_id and status=1 and visible=1) as name,(SELECT grade_id from users where id=gu_id and status=1 and visible=1) as grade_id,(SELECT section from users where id=gu_id and status=1 and visible=1) as section from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select id from users  where status=1 and visible=1 and sid='".$schoolid."' and month(lastupdate)='".$monthNumber."' ) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id)a1 where finalscore >80 order by finalscore");
		return $query->result_array();
	}
	public function userattendedcount($schoolid,$monthNumber)
	{
		$query = $this->db->query("Select username,gu_id,(select school_name from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) as schoolname,section,(select classname from class where id=grade_id) as grade, count(distinct lastupdate) as playedcount from users as u join game_reports as gr on u.id=gr.gu_id where u.sid='".$schoolid."' and month(gr.lastupdate)='".$monthNumber."'  group by  gu_id order by playedcount");
		return $query->result_array();
	}
	public function weekofday($schoolid,$startdate,$enddate)
	{
		$query = $this->db->query("select min(selected_date) as startdate,max(selected_date) as enddate,weekval from (select selected_date,dayname(selected_date) as nameofday, CASE WHEN MONTH('".$startdate."')=(select MONTH(start_date) from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) THEN (FLOOR((DAYOFMONTH(selected_date) - DAYOFMONTH((select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1))) / 7) + 1) ELSE (FLOOR((DAYOFMONTH(selected_date) - 1) / 7) + 1) END as weekval from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where selected_date between '".$startdate."' and '".$enddate."' and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1)) xx1 group by weekval");
		return $query->result_array();		
	}
	
	public function weekofday_nonschedule($schoolid,$startdate,$enddate)
	{
		$query = $this->db->query("select min(selected_date) as startdate,max(selected_date) as enddate,weekval from (select selected_date,dayname(selected_date) as nameofday, CASE WHEN MONTH('".$startdate."')=(select MONTH(start_date) from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) THEN (FLOOR((DAYOFMONTH(selected_date) - DAYOFMONTH((select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1))) / 7) + 1) ELSE (FLOOR((DAYOFMONTH(selected_date) - 1) / 7) + 1) END as weekval from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where selected_date between '".$startdate."' and '".$enddate."' and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1)) xx1 group by weekval");
		return $query->result_array();		
	}
	public function Reportisexist($schoolid,$monthNumber)
	{
		$query = $this->db->query("Select count(ID) as countval from  eom_report where School_id='".$schoolid."' and Month_no='".$monthNumber."' and Status=1");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function UpdateReport($schoolid,$monthno,$rcode,$msg,$isexist)
	{
		if($isexist>0)
		{
			$query = $this->db->query("UPDATE eom_report SET Message='".$msg."'  where School_id='".$schoolid."' and Month_no='".$monthno."' and RCode='".$rcode."'	");
			//echo $this->db->last_query(); exit;
		}
		else
		{
			$query = $this->db->query("INSERT INTO eom_report(School_id, Month_no, RCode, Message, Status) VALUES (".$schoolid.",'".$monthno."','".$rcode."','".$msg."','1')");
		}
	}
	public function GetReportMessage($schoolid,$monthno,$rcode)
	{
		$query = $this->db->query("Select Message,RCode from  eom_report where School_id='".$schoolid."' and Month_no='".$monthno."' and RCode='".$rcode."' and Status=1");
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}
	public function GetAttendedUserCount($schoolid)	
	{
		$query=$this->db->query("select sum(totalusers) as totaluser,sum(attenusers) as attenusers from (select selected_date, gradename, gradeid,section,(select count(distinct(u.id)) as regusers from users u  where u.grade_id=gradeid and u.section=y1.section and u.sid='".$schoolid."' and u.status = 1 and u.visible=1) as totalusers,

(SELECT count(distinct(gu_id)) as com from game_reports as gd 
join users as u on u.id=gd.gu_id where u.sid='".$schoolid."'  and u.grade_id=gradeid and u.section=y1.section  and date(lastupdate) = selected_date and gd.gu_id!=0) as attenusers

from (select concat('Grade', '',monday_grade) as gradename, selected_date, (select id from class where REPLACE(classname,'Grade ','')  = monday_grade) as gradeid,section from (select * from (

select monday_grade,monday_section as section,'Monday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and monday_grade!=''

union select tuesday_grade,tuesday_section as section,'Tuesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and tuesday_grade!=''

union select wednesday_grade,wednesday_section as section,'Wednesday' as dayname1  from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and wednesday_grade!=''

union select thursday_grade,thursday_section as section,'Thursday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and thursday_grade!=''

union select friday_grade,friday_section as section,'Friday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and friday_grade!=''

union select saturday_grade,saturday_section as section,'Saturday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and saturday_grade!=''

union select sunday_grade,sunday_section as section,'Sunday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and sunday_grade!='')j1 cross join 

(select *,dayname(selected_date) as nameofday from 
(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
where selected_date between (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and '".date('Y-m-d')."' and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = '".$schoolid."' and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1)y1)a1");

		return $query->result_array();
	}
	public function GetCompletedUserCount($schoolid)	
	{
		$query = $this->db->query("select sum(completeduser) as completeduser from(select count(*) as completeduser,selmonth from (select count(*) as cntval,weekval,gradename,gradeid,section,id,month(selected_date) as selmonth from ( select selected_date,weekval,a2.gradename,a2.gradeid,a2.section,a2.id,gs_id from (select selected_date,weekval,y1.gradename,y1.gradeid,y1.section,u.id from (select concat('Grade', '',monday_grade) as gradename, selected_date,weekval,(select id from class where REPLACE(classname,'Grade ','') = monday_grade) as gradeid,section from 

(select * from ( select monday_grade,monday_section as section,'Monday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and monday_grade!='' union select tuesday_grade,tuesday_section as section,'Tuesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and tuesday_grade!='' union select wednesday_grade,wednesday_section as section,'Wednesday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and wednesday_grade!='' union select thursday_grade,thursday_section as section,'Thursday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and thursday_grade!='' union select friday_grade,friday_section as section,'Friday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and friday_grade!='' union select saturday_grade,saturday_section as section,'Saturday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and saturday_grade!='' union select sunday_grade,sunday_section as section,'Sunday' as dayname1 from schools_period_schedule where school_id='".$schoolid."' and academic_id=20 and sunday_grade!='')j1 cross join 

(select selected_date,dayname(selected_date) as nameofday,CASE WHEN MONTH('".date('Y-m-d')."')=(select MONTH(start_date) from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) THEN (FLOOR((DAYOFMONTH(selected_date) - DAYOFMONTH((select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1))) / 7) + 1) ELSE (FLOOR((DAYOFMONTH(selected_date) - 1) / 7) + 1) END as weekval from (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3, (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v where selected_date between (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and '".date('Y-m-d')."' and selected_date >= (select start_date from schools where id='".$schoolid."' and status=1 and active=1 and visible=1) and selected_date NOT IN (select leave_date from schools_leave_list where school_id = '".$schoolid."' and status=1)) j2 on j1.dayname1=j2.nameofday order by selected_date asc) x1) y1 

join users as u on u.grade_id=y1.gradeid and u.section=y1.section and u.sid='".$schoolid."' and u.status = 1 and u.visible=1 group by y1.gradeid,y1.section,selected_date,u.id order by selected_date) a2 join game_reports as gd on gd.gu_id=a2.id and date(gd.lastupdate) = a2.selected_date group by a2.gradeid,a2.section,selected_date,gs_id,gu_id)Z1 group by weekval,gradename,gradeid,section,id,month(selected_date))zz1 where cntval>=5 group by selmonth)f1");
//echo $this->db->last_query(); exit;
			return $query->result_array();
	}
		
}
