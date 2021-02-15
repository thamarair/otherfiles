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

        public function schools()
        {
					 
			$query = $this->db->query('select COUNT(id) as schoolscount FROM schools WHERE active=1 AND status=1');		
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		
		public function students()
        {
					 
			$query = $this->db->query('select COUNT(users.id) as studentscount FROM users  JOIN schools as s ON users.sid=s.id  WHERE users.status=1 and s.active=1 and s.status=1');		
			//echo $this->db->last_query(); exit;
			return $query->result_array();
        }
		
	/*	public function username()
		{
			$query = $this->multipledb->db->query('select fname FROM users  WHERE id=7440'); // running query using library.
			return $query->result_array();
		}
		*/
		
		public function schoolwisebspi()
		{
			$query = $this->db->query('SELECT (sum(`finalscore`))/(select count(id) from users where sid=schoolid and users.status=1) as bspiscore, schoolid,(select school_name from schools where id=schoolid) as schoolname,(select count(id) from users where sid=schoolid and users.status=1) as totstudent from (SELECT SUM(score)/5 as finalscore, gu_id, (SELECT sid from users where id=gu_id and users.status=1) as schoolid from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select users.id FROM users  JOIN schools as s ON users.sid=s.id  WHERE users.status=1 and s.active=1 and s.status=1) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id) a3 group by schoolid ORDER BY bspiscore DESC');
			//echo $this->db->last_query();
			return $query->result_array();
		}
		
		public function skillwisetopper_memory($skillid)
		{
			$query = $this->db->query('(select (AVG(score)) as finalscore, skillname,(select school_name from schools where id=schoolid) as schoolname, schoolid from (select (AVG(score)) as score, gu_id, gs_id, (select name from category_skills where id =gs_id ) as skillname, (SELECT sid from users where id=gu_id) as schoolid from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id ='.$skillid.' and gu_id in (select users.id FROM users  JOIN schools as s ON users.sid=s.id  WHERE users.status=1 and s.active=1 and s.status=1) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id )a2 group by schoolid,gs_id) ORDER BY finalscore DESC');
			//echo $this->db->last_query();
			return $query->result_array();
		}
		
		public function trainingbspi()
		{
			$query = $this->db->query('select avg(bspiscore) as overallbspi from

(SELECT (sum(`finalscore`))/(select count(id) from users where sid=schoolid and users.status=1) as bspiscore, schoolid,(select school_name from schools where id=schoolid) as schoolname,(select count(id) from users where sid=schoolid and users.status=1) as totstudent from (SELECT SUM(score)/5 as finalscore, gu_id, (SELECT sid from users where id=gu_id AND status =1) as schoolid from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select users.id FROM users  JOIN schools as s ON users.sid=s.id  WHERE users.status=1 and s.active=1 and s.status=1) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id) a4 group by schoolid ) a5');
			
			//echo $this->db->last_query();
			return $query->result_array();
		}
		
		public function assessment_schools()
		{
			$query = $this->multipledb->db->query('SELECT COUNT(school_id) as schoolcount FROM schooldetails');
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function assessment_students()
		{
			$query = $this->multipledb->db->query('SELECT COUNT(regno) as studentcount FROM registration');
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
	
		
		public function Assessment_skillscore($skilltype,$assesstype)
		{
			$query = $this->multipledb->db->query('SELECT (AVG(gscrval)) as score, (SELECT schoolname from schooldetails where school_id=schoolid) as schoolname, schoolid,skillid from (SELECT gscrval, schoolid, skillid from (SELECT gscrval, fk_regno,(SELECT fk_school_id from registration where regno=fk_regno) as schoolid, (select fk_skill_id from game_mapping where gm_id=fk_gmid) as skillid FROM gamescore WHERE fk_regno IN (select regno from registration WHERE regno=fk_regno) AND test_type = "'.$assesstype.'" group by fk_regno, gscrval) a1 where skillid = "'.$skilltype.'") a2 group by schoolid ORDER BY score DESC');
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function Assessment_sklavg($assestype)
		{
			$query = $this->multipledb->db->query('SELECT (AVG(score)) as finalscore, schoolid, (select count(regno) from registration where fk_school_id=schoolid ) as stucount, (SELECT schoolname from schooldetails where school_id=schoolid) as schoolname from (SELECT (SUM(gscrval)/5) as score, schoolid, fk_regno from (SELECT gscrval, fk_regno,(SELECT fk_school_id from registration where regno=fk_regno) as schoolid FROM gamescore WHERE fk_regno IN (select regno from registration WHERE regno=fk_regno) AND test_type = "'.$assestype.'" group by fk_regno, gscrval) a1 group by schoolid, fk_regno) a2 group by schoolid ORDER BY finalscore DESC');
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		public function Assessment_Overall_sklavg($assestype)
		{
			$query = $this->multipledb->db->query('select avg(finalscore) as finalscore from (SELECT (AVG(score)) as finalscore, schoolid, (select count(regno) from registration where fk_school_id=schoolid ) as stucount, (SELECT schoolname from schooldetails where school_id=schoolid) as schoolname from (SELECT (SUM(gscrval)/5) as score, schoolid, fk_regno from (SELECT gscrval, fk_regno,(SELECT fk_school_id from registration where regno=fk_regno) as schoolid FROM gamescore WHERE fk_regno IN (select regno from registration WHERE regno=fk_regno) AND test_type = "'.$assestype.'" group by fk_regno, gscrval) a1 group by schoolid, fk_regno) a2 group by schoolid ORDER BY finalscore DESC) a5 ');
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function schoolwise_gradewise_bspi_avg()
		{
			$query = $this->db->query('SELECT (sum(`finalscore`))/(select count(id) from users where sid=schoolid and users.status=1 and users.grade_id = gradeid ) as bspiscore, gradeid, (SELECT classname from class where id=gradeid) as gradename, schoolid,(select school_name from schools where id=schoolid) as schoolname,(select count(id) from users where sid=schoolid and users.status=1 and users.grade_id = gradeid ) as totstudent from (SELECT SUM(score)/5 as finalscore, gu_id, (SELECT sid from users where id=gu_id and users.status=1) as schoolid, (SELECT grade_id from users where id=gu_id and users.status=1) as gradeid from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select users.id FROM users JOIN schools as s ON users.sid=s.id WHERE users.status=1 and s.active=1 and s.status=1) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id) a3 group by gradeid, schoolid');
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function gradewise_bspi_avg()
		{
			
			$query = $this->db->query('SELECT AVG(bspiscore) as overallbspi, (SELECT classname from class where id=gradeid) as gradename, gradeid from (SELECT (sum(`finalscore`))/(select count(id) from users where sid=schoolid and users.status=1 and users.grade_id = gradeid ) as bspiscore, gradeid, schoolid,(select school_name from schools where id=schoolid) as schoolname,(select count(id) from users where sid=schoolid and users.status=1 and users.grade_id = gradeid ) as totstudent from (SELECT SUM(score)/5 as finalscore, gu_id, (SELECT sid from users where id=gu_id and users.status=1) as schoolid, (SELECT grade_id from users where id=gu_id and users.status=1) as gradeid from (select (AVG(score)) as score, gu_id, gs_id from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id in (59,60,61,62,63) and gu_id in (select users.id FROM users JOIN schools as s ON users.sid=s.id WHERE users.status=1 and s.active=1 and s.status=1) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id ) a2 group by gu_id) a3 group by gradeid, schoolid) a4 group by gradeid');
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function skl_gradewise_skillscore($skillid)
		{
			$query = $this->db->query('(select (AVG(score)) as finalscore, skillname,(select school_name from schools where id=schoolid) as schoolname, gradeid, (SELECT classname from class where id=gradeid) as gradename, schoolid from (select (AVG(score)) as score, gu_id, gs_id, (select name from category_skills where id =gs_id ) as skillname, (SELECT sid from users where id=gu_id) as schoolid,(SELECT grade_id from users where id=gu_id and users.status=1) as gradeid from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id ="'.$skillid.'" and gu_id in (select users.id FROM users JOIN schools as s ON users.sid=s.id WHERE users.status=1 and s.active=1 and s.status=1) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id )a2 group by schoolid,gradeid,gs_id) ORDER BY gradeid');
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function gradewise_skillscore($skillid)
		{
			$query = $this->db->query('(select (AVG(score)) as finalscore, skillname, (SELECT grade_id from users where id=gu_id and users.status=1) as gradeid, (SELECT classname from class where id=gradeid) as gradename  from (select (AVG(score)) as score, gu_id, gs_id, (select name from category_skills where id =gs_id ) as skillname, (SELECT sid from users where id=gu_id) as schoolid, (SELECT grade_id from users where id=gu_id and users.status=1) as gradeid  from (SELECT (AVG(`game_score`)) as score , gs_id , gu_id, lastupdate FROM `game_reports` WHERE gs_id ="'.$skillid.'" and gu_id in (select users.id FROM users  JOIN schools as s ON users.sid=s.id  WHERE users.status=1 and s.active=1 and s.status=1) group by gs_id , gu_id, lastupdate) a1 group by gs_id, gu_id )a2 group by gradeid,gs_id)');
			//echo $this->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function schoolwise_gradewise_bspi_A($assestype)
		{
			
			$query = $this->multipledb->db->query('SELECT (AVG(score)) as finalscore, schoolid, (select count(regno) from registration where fk_school_id=schoolid and std=(SELECT std from registration where regno=fk_regno)) as stucount, (SELECT std from registration where regno=fk_regno) as gradename, (SELECT schoolname from schooldetails where school_id=schoolid) as schoolname from (SELECT (SUM(gscrval)/5) as score, schoolid, fk_regno from (SELECT gscrval, fk_regno,(SELECT std from registration where regno=fk_regno) as gradename, (SELECT fk_school_id from registration where regno=fk_regno) as schoolid FROM gamescore WHERE fk_regno IN (select regno from registration WHERE regno=fk_regno) AND test_type = "'.$assestype.'" group by fk_regno, gscrval) a1 group by schoolid, fk_regno) a2 group by gradename,schoolid order by gradename');
			//echo $this->multipledb->db->last_query(); exit;
			return $query->result_array();
		}
		
		public function gradewise_bspi_A($assestype)
		{
			$query = $this->multipledb->db->query('SELECT (AVG(finalscore)) as overallavg, gradename from (SELECT (AVG(score)) as finalscore, schoolid, (select count(regno) from registration where fk_school_id=schoolid and std=(SELECT std from registration where regno=fk_regno)) as stucount, (SELECT std from registration where regno=fk_regno) as gradename, (SELECT schoolname from schooldetails where school_id=schoolid) as schoolname from (SELECT (SUM(gscrval)/5) as score, schoolid, fk_regno from (SELECT gscrval, fk_regno,(SELECT std from registration where regno=fk_regno) as gradename, (SELECT fk_school_id from registration where regno=fk_regno) as schoolid FROM gamescore WHERE fk_regno IN (select regno from registration WHERE regno=fk_regno) AND test_type = "'.$assestype.'" group by fk_regno, gscrval) a1 group by schoolid, fk_regno) a2 group by gradename,schoolid) a1 group by gradename');
			//echo $this->multipledb->db->last_query(); exit;
			return $query->result_array();
		}
		
		
}
