'.$this->config->item("asapdb").'.



31472	Shitanshu Demo
error: $ in undefined then use <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.js" type="text/javascript"></script> this before starting <script>  

BEGIN
	declare userid varchar(500);
	declare lid int(100);
    if((incheckboxchk = 1) && (inbrainydirectusername!='')) then
    
    INSERT INTO users(salt1,password,salt2,fname, lname,status,grade_id,username,sid,section,academicyear,creation_date,agreetermsandservice,academic_center_id,isapp,isnewuser,gp_id)VALUES (insalt1,inpwdhash,insalt2,infname,inlname,1,ingradename,inbrainydirectusername,2,'A',19,now(),1,inacademyname,'N','Y',inplanid);
    
    ELSE
    INSERT INTO users(salt1,password,salt2,fname, lname,status,grade_id,sid,section,academicyear,creation_date,agreetermsandservice,academic_center_id,isapp,isnewuser,gp_id)VALUES (insalt1,inpwdhash,insalt2,infname,inlname,1,ingradename,2,'A',19,now(),1,inacademyname,'N','Y',inplanid);     
		set lid=last_insert_id();
		set userid=concat('brainy','.',lid);
		update users set username=userid where id=lid;
        select userid;
        end if;
END

set lid=last_insert_id();
		set userid=concat('brainy','.',lid);
		update users set username=userid where id=lid;
        select userid;









BEGIN
	declare userid varchar(500);
	declare lid int(100);
    DECLARE ousername varchar(255);
    DECLARE otype int(11);      
    
    if((incheckboxchk = 1) && (inbrainydirectusername!='')) then
  	 	 set ousername = inbrainydirectusername;
   		 set otype = 1;
         
          INSERT INTO users(salt1,password,salt2,fname, lname,status,grade_id,username,sid,section,academicyear,creation_date,agreetermsandservice,academic_center_id,isapp,isnewuser,gp_id,is_direct_brainyuser)VALUES (insalt1,inpwdhash,insalt2,infname,inlname,1,ingradename,ousername,2,'A',19,now(),1,inacademyname,'N','Y',inplanid,otype);
          
          select ousername;
     
    ELSE
    	 set ousername = userid;
   		 set otype = 0;   
         
          INSERT INTO users(salt1,password,salt2,fname, lname,status,grade_id,username,sid,section,academicyear,creation_date,agreetermsandservice,academic_center_id,isapp,isnewuser,gp_id,is_direct_brainyuser)VALUES (insalt1,inpwdhash,insalt2,infname,inlname,1,ingradename,ousername,2,'A',19,now(),1,inacademyname,'N','Y',inplanid,otype);
         
         set lid=last_insert_id();
		set userid=concat('brainy','.',lid);
		update users set username=userid where id=lid;        
         select userid;       
         end if;
END


















