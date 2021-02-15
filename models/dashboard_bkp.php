<div class="container" id="pagewrap">
<section class="content">
    
    
    
    
    <aside class="contentleft">
            	<!--BEGIN PROFILE IMAGE-->
                           
   	<section class="profileBg">
                		<!-- /#content --> 
								

   <!--<link rel="css/colorbox.css" type="text/css" />  
   <script type="text/javascript" src="js/jquery.colorbox-min.js"></script>-->
<script type="text/javascript" src="plugins/jqplot.pieRenderer.min.js"></script>

<script language="javascript">
$(document).ready(function(){
	
  var data = [['Memory',1],['Visual Processing',1],['Focus And Attention',1],['Problem Solving',1],['Linguistics',1]];
  var totalgam = 0;
  var lblflg = false;
  if(totalgam>0){
  		//lblflg = true;
  }
  var plot1 = jQuery.jqplot ('piechart1', [data],
    {
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: lblflg,
		   dataLabels: 'value',
		   padding: 2
        }
      },
	  seriesColors:['#00000','#00000','#00000','#00000','#00000'],
	  legend:{
            show:true,
            placement: 'inside',
            rendererOptions: {
                numberRows: 4
            },
            location:'s',
            marginTop: '15px'
        }  
      //legend: { show:true, location: 'e' }
    }
  );
  
  
  $('.closeArrow').click(function(){
	  window.location.href = window.location.href; 
	  });
  
});
</script>		

<?php //print_r($query); ?>

<img class="profileImg" src="<?php echo base_url(); ?>assets/<?php echo $query[0]->avatarimage; ?>" width="113" height="113" alt="Profile Image">

                       
<input type="button" id="btnchangeavatar" class="btnchangeavatar" name="btnchangeavatar" value="Change avatar">


        <div id="fade" class="black_overlay" style="display: none;"></div>
<script type="text/javascript">
      $('#btnchangeavatar').click(function(){
	  
	  $('#avatharimgs').css("top",'-80px').show().animate({'marginTop' : "+=150px" },800);
		//document.getElementById("fadeavatarpopup").style.display="block";
		$('#fade').show();
		
});//window.location.href = window.location.href;
$('.avatarprofileImg').click(function(){
	
	var avatarimg = $(this).attr('src');
	$.ajax
	({
			type:"POST",
			url:"avatarimage_upload.php",
			data:{Type:'A',avatarimg:avatarimg,id:1},
			success:function(result)
			{
				//alert (result);
				window.location.href = window.location.href;
				
			}
	
	});
	
	});
</script>
                   <h4><?php echo $this->lang->line("goodday"); ?><br> <?php echo $query[0]->fname; ?></h4> <p><?php echo $this->lang->line("lastplayed"); ?><br>  <?php echo $query[0]->pre_logindate; ?>.</p>
				   
				   
				   
<?php
$login_count = 3;
if($login_count<1)
{
echo '<p>'.$this->lang->line("greetingmessage1").'</p>';
}
elseif($login_count<=3)
{
 echo '<p>'.$this->lang->line("greetingmessage2").'</p>';
 
}
 
?>


				  		
	<!-- /#sidebar --></section>
    

			    <section class="myTrophies">
			      <div class="todayStatus" id="todayStatus">Your Overall <span class="hoverhelp">BSPI</span> as on <span><?php //echo $query[0]->login_date; ?>  : <span class="bspi_ratings">45.8</span></span><span class="bspi tool-tip slideIn right" id="bspi">BSPI - Brain Skill Power Index - Average of all skill scores</span></div>
             <div class="howtogetOuter"><a href="#" class="questionicon"></a><div class="howtoget_trophies" id="howtoget_trophies"><h3 class="gettrophiestext">How can I get stars and trophies</h3></div><div class="tool-tip slideIn right">
 
<p>Stars are awarded to the users based on the scores of each games played</p>
<p>Stars Awarded on a given day</p>
<ul>
<li>- based on score obtained in the game</li>
<li>- or based on average score in the game</li>
<li>- Every day the stars are refreshed </li>
</ul>
<p>Trophies are awarded based on the no of stars earned in each skill for the current month</p>
</div></div>

<h2>My trophies</h2>
                <?php  //print_r($mytrophy); 
				
				foreach($mytrophy as $tro)
				{
					
					$mainclass='';
					$innerclass='';
					
					if($tro->catid==59)
					{ $mainclass = 'memoryOuter'; $innerclass = 'memory'; }
					elseif($tro->catid==60)
					{ $mainclass = 'visualOuter'; $innerclass = 'visualProcessing'; }
					elseif($tro->catid==61)
					{ $mainclass = 'focusOuter'; $innerclass = 'focus'; }
					elseif($tro->catid==62)
					{ $mainclass = 'problemOuter'; $innerclass = 'problemSolving'; }
					elseif($tro->catid==63)
					{ $mainclass = 'linguisticsOuter'; $innerclass = 'linguistics'; }
					
					
					
					
echo '<div class="trophiesList '.$mainclass.'">
<div class="trophiesName">
<h5><span class='.$innerclass.'></span> '.$tro->name.' </h5>
 </div>
<div class="trophiesCups">';

if($tro->diamond == 0)
{ echo '<span class="dimondCup"></span>'; } else { echo '<span class="defaultCup"></span>'; }

if($tro->gold > 0)
{ echo '<span class="goldcup"></span>'; } else { echo '<span class="defaultCup"></span>'; }

if($tro->silver > 0)
{ echo '<span class="silverCup"></span>'; } else { echo '<span class="defaultCup"></span>'; }

echo '</div>
</div>';
					
					
				}
				
				
				?>

						                    							
</section>
      
      
    
	           	    	
                
                <!--END PROFILE IMAGE-->
                <!--BEGIN MY TROPHIES-->
                
            </aside>
          
    <section class="contentCenter  ">
            
            <section class="mygames">
	<div id="content">

		<article class="widget3">
			<!-- Middle Content Starts-->

				 
                 	<h2>My Puzzles</h2>




					<div class="row1">						
						<div class="middlecontent">
							<div class="tabs" id="tabs-container" align="left">
								
								<ul class="tabs-menu">
											<li class="current">
			<a href="dispindex.php?act=mygames&amp;gid=1">Brain Skills			</a>
		</li>
	 
		
								<li class="style3">
			<a href="dispindex.php?act=mygames&amp;gid=5">Curriculum			</a>
		</li>
	 
		
								<li class="style3">
			<a href="dispindex.php?act=mygames&amp;gid=6">Life Skills			</a>
		</li>
	 
		
						 	
                        
			</ul>
             
             
			<div class="tab-content__1">
			<div class="tab-pane active" id="brainskills">
			<div class="row featured-boxes">
            
				
            
           <div class="tab">
                        	<div id="tab1" class="tab-content"> 
           
				
										<h2>The Puzzles Plan</h2>		
						
						
						
				                
                
                
               
													  
<!-- game score star rating STARTS -->
  
	 
	 		
																			
																												
																												
																												
																												
																
			        
		<ul class="theGamePlan starsOfTheDay">
                                	<!--<li>
                                    	<h6>Memory</h6>
                                    	<a href="javascript:;"><img src="images/memory.jpg" width="117" height="93" alt="Memory"></a> 
                                        <p>Balloon Burst<span>Level1</span></p>
                                    </li>
                                    <li>
                                    	<h6>VISUAL PROCESSING</h6>
                                    	<a href="javascript:;"><img src="images/visualProcessing.jpg" width="117" height="93" alt="VISUAL PROCESSING"></a> 
                                        <p>EdCells<span>Level1</span></p>
                                    </li>
                                    <li class="borderZero">
                                    	<h6>FOCUS AND ATTENTION</h6>
                                    	<a href="javascript:;"><img src="images/focus&amp;Attention.jpg" width="117" height="93" alt="FOCUS AND ATTENTION"></a>
                                        <p>StarLight<span>Level1</span></p>
                                    </li>
                                    <li>
                                    	<h6>PROBLEM SOLVING</h6>
                                    	<a href="javascript:;"><img src="images/problemSolving.jpg" width="117" height="93" alt="PROBLEM SOLVING"></a>
                                        <p>Add Master<span>Level1</span></p>
                                    </li>
                                    <li>
                                    	<h6>LINGUISTICS</h6>
                                    	<a href="javascript:;"><img src="images/linguistics.jpg" width="117" height="93" alt="LINGUISTICS"></a>
                                        <p>WhoAmI-Shapes<span>Level1</span></p>
                                    </li>-->
                   	             
		 
			 
								                                
                                
                                
                                
                                
                                                                <li>
                                 <h6>MEMORY</h6>                                    	<!--<h6>Memory</h6>-->
                                    	<a href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=59&amp;gid=47&amp;gt=1#content"><img src="uploads/Fishing_4694063616.png" alt="Memory"></a> 
                                         <div align="center"> <a class="playgamelink" href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=59&amp;gid=47&amp;gt=1#content">Play</a> </div>
                                        <p>Fishing</p>
                                        	                                        <div align="center" class="stars"><span class="emptyStar"></span><span class="emptyStar"></span><span class="emptyStar"></span><span class="emptyStar"></span><span class="emptyStar"></span></div>

                                    </li>
                                
                                
								<!--<div class="box21">	
									<div class="featured-box featured-box-primary">
										<div class="box-content">											
											
											<div style="height:110px;"><a href="dispindex.php?act=playgames&uid=1&gsid=59&gid=47&gt=1#content"> 
											<img src="uploads/Fishing_4694063616.png" width="100" height="94">
											</a>
											</div>
											
											<div class="homegameh2">Fishing</div>
	                                        <div align="center"><span class='emptyStar'></span><span class='emptyStar'></span><span class='emptyStar'></span><span class='emptyStar'></span><span class='emptyStar'></span></div>
										</div>
									</div>
								</div>-->
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
																
								  
			 
								                                
                                
                                
                                
                                
                                                                <li>
                                 <h6>VISUAL PROCESSING</h6>                                    	<!--<h6>Memory</h6>-->
                                    	<a href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=60&amp;gid=56&amp;gt=1#content"><img src="uploads/Face2Face-Level2_9013552083.png" alt="Memory"></a> 
                                         <div align="center"> <a class="playgamelink" href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=60&amp;gid=56&amp;gt=1#content">Play</a> </div>
                                        <p>Face2Face-Level2</p>
                                        	                                        <div align="center" class="stars"><span class="emptyStar"></span><span class="emptyStar"></span><span class="emptyStar"></span><span class="emptyStar"></span><span class="emptyStar"></span></div>

                                    </li>
                                
                                
								<!--<div class="box21">	
									<div class="featured-box featured-box-secundary">
										<div class="box-content">											
											
											<div style="height:110px;"><a href="dispindex.php?act=playgames&uid=1&gsid=60&gid=56&gt=1#content"> 
											<img src="uploads/Face2Face-Level2_9013552083.png" width="100" height="94">
											</a>
											</div>
											
											<div class="homegameh2">Face2Face-Level2</div>
	                                        <div align="center"><span class='emptyStar'></span><span class='emptyStar'></span><span class='emptyStar'></span><span class='emptyStar'></span><span class='emptyStar'></span></div>
										</div>
									</div>
								</div>-->
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
																
								  
			 
								                                
                                
                                
                                
                                
                                                                <li class="borderZero">
                                 <h6>FOCUS AND ATTENTION</h6>                                    	<!--<h6>Memory</h6>-->
                                    	<a href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=61&amp;gid=61&amp;gt=1#content"><img src="uploads/DownUnder-Level2_5347298909.png" alt="Memory"></a> 
                                         <div align="center"> <a class="playgamelink" href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=61&amp;gid=61&amp;gt=1#content">Play</a> </div>
                                        <p>DownUnder-Level2</p>
                                        	                                        <div align="center" class="stars"><span class="emptyStar"></span><span class="emptyStar"></span><span class="emptyStar"></span><span class="emptyStar"></span><span class="emptyStar"></span></div>

                                    </li>
                                
                                
								<!--<div class="box21">	
									<div class="featured-box featured-box-quaternary">
										<div class="box-content">											
											
											<div style="height:110px;"><a href="dispindex.php?act=playgames&uid=1&gsid=61&gid=61&gt=1#content"> 
											<img src="uploads/DownUnder-Level2_5347298909.png" width="100" height="94">
											</a>
											</div>
											
											<div class="homegameh2">DownUnder-Level2</div>
	                                        <div align="center"><span class='emptyStar'></span><span class='emptyStar'></span><span class='emptyStar'></span><span class='emptyStar'></span><span class='emptyStar'></span></div>
										</div>
									</div>
								</div>-->
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
																
								  
			 
								                                
                                
                                
                                
                                
                                                                <li>
                                 <h6>PROBLEM SOLVING</h6>                                    	<!--<h6>Memory</h6>-->
                                    	<a href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=62&amp;gid=69&amp;gt=1#content"><img src="uploads/HeavyOrLight-Level2_607259180.png" alt="Memory"></a> 
                                         <div align="center"> <a class="playgamelink" href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=62&amp;gid=69&amp;gt=1#content">Play</a> </div>
                                        <p>HeavyOrLight-Level2</p>
                                        	                                        <div align="center" class="stars"><span class="emptyStar"></span><span class="emptyStar"></span><span class="emptyStar"></span><span class="emptyStar"></span><span class="emptyStar"></span></div>

                                    </li>
                                
                                
								<!--<div class="box21">	
									<div class="featured-box featured-box-tertiary">
										<div class="box-content">											
											
											<div style="height:110px;"><a href="dispindex.php?act=playgames&uid=1&gsid=62&gid=69&gt=1#content"> 
											<img src="uploads/HeavyOrLight-Level2_607259180.png" width="100" height="94">
											</a>
											</div>
											
											<div class="homegameh2">HeavyOrLight-Level2</div>
	                                        <div align="center"><span class='emptyStar'></span><span class='emptyStar'></span><span class='emptyStar'></span><span class='emptyStar'></span><span class='emptyStar'></span></div>
										</div>
									</div>
								</div>-->
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
																
								  
			 
								                                
                                
                                
                                
                                
                                                                <li>
                                 <h6>LINGUISTICS</h6>                                    	<!--<h6>Memory</h6>-->
                                    	<a href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=63&amp;gid=75&amp;gt=1#content"><img src="uploads/ArrangeTheWords-Level1_350359375.png" alt="Memory"></a> 
                                         <div align="center"> <a class="playgamelink" href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=63&amp;gid=75&amp;gt=1#content">Play</a> </div>
                                        <p>ArrangeTheWords-Level1</p>
                                        	                                        <div align="center" class="stars"><span class="emptyStar"></span><span class="emptyStar"></span><span class="emptyStar"></span><span class="emptyStar"></span><span class="emptyStar"></span></div>

                                    </li>
                                
                                
								<!--<div class="box21">	
									<div class="featured-box featured-box-quinary">
										<div class="box-content">											
											
											<div style="height:110px;"><a href="dispindex.php?act=playgames&uid=1&gsid=63&gid=75&gt=1#content"> 
											<img src="uploads/ArrangeTheWords-Level1_350359375.png" width="100" height="94">
											</a>
											</div>
											
											<div class="homegameh2">ArrangeTheWords-Level1</div>
	                                        <div align="center"><span class='emptyStar'></span><span class='emptyStar'></span><span class='emptyStar'></span><span class='emptyStar'></span><span class='emptyStar'></span></div>
										</div>
									</div>
								</div>-->
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
																
								  </ul> 								</div>
								
																
								<div id="light" class="white_content">
	
								<div align="right">
								<a class="closeArrow" href="javascript:void(0)" onclick="document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">&nbsp;</a></div>      
								
																	<div class="adminpopup"><h1>Welcome Aishu C!!!<span> Hope you are doing great!!!</span></h1>          
										
																			
																	<p>Play every day to earn trophies and badges</p> </div>
                                    
                                    <div class="myGamePopupGames">
									<h2>Click any of these puzzles and start your today's training session.</h2>         
									<div align="center"><div class="popgameimg"><div style="height:100px;"><a href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=59&amp;gid=47&amp;gt=1#content"><i><img src="uploads/Fishing_4694063616.png" width="100" height="94"></i></a></div><a class="playgamelink" href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=59&amp;gid=47&amp;gt=1#content">Play</a><div align="center" style="font-size:13px;padding-top:5px;"><b>Fishing</b></div></div><div class="popgameimg"><div style="height:100px;"><a href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=60&amp;gid=56&amp;gt=1#content"><i><img src="uploads/Face2Face-Level2_9013552083.png" width="100" height="94"></i></a></div><a class="playgamelink" href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=60&amp;gid=56&amp;gt=1#content">Play</a><div align="center" style="font-size:13px;padding-top:5px;"><b>Face2Face-Level2</b></div></div><div class="popgameimg"><div style="height:100px;"><a href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=61&amp;gid=61&amp;gt=1#content"><i><img src="uploads/DownUnder-Level2_5347298909.png" width="100" height="94"></i></a></div><a class="playgamelink" href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=61&amp;gid=61&amp;gt=1#content">Play</a><div align="center" style="font-size:13px;padding-top:5px;"><b>DownUnder-Level2</b></div></div><div class="popgameimg"><div style="height:100px;"><a href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=62&amp;gid=69&amp;gt=1#content"><i><img src="uploads/HeavyOrLight-Level2_607259180.png" width="100" height="94"></i></a></div><a class="playgamelink" href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=62&amp;gid=69&amp;gt=1#content">Play</a><div align="center" style="font-size:13px;padding-top:5px;"><b>HeavyOrLight-Level2</b></div></div><div class="popgameimg"><div style="height:100px;"><a href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=63&amp;gid=75&amp;gt=1#content"><i><img src="uploads/ArrangeTheWords-Level1_350359375.png" width="100" height="94"></i></a></div><a class="playgamelink" href="dispindex.php?act=playgames&amp;uid=1&amp;gsid=63&amp;gid=75&amp;gt=1#content">Play</a><div align="center" style="font-size:13px;padding-top:5px;"><b>ArrangeTheWords-Level1</b></div></div></div>
									
                                    </div>
													
		</div>
        
		<input type="hidden" name="hdnuserid" id="hdnuserid" value="1">
		<div id="fade" class="black_overlay"></div>
		<script type="text/javascript">
	
		var userid=document.getElementById("hdnuserid").value;
		
		if(userid!=""){
		//alert(sessionStorage.clickcount);
			if (sessionStorage.clickcount) {
				sessionStorage.clickcount = Number(sessionStorage.clickcount) + 1;
			} else {
				sessionStorage.clickcount = 1;
			}
		//	alert("as");
			
			if(sessionStorage.clickcount==1){
				//document.getElementById("light").style.display="block";
			//$('#light').show().css("top", "500px").animate({top: 100}, 800);
			$('#light').css("top",'-80px').show().animate({'marginTop' : "+=150px" },800);

				document.getElementById("fade").style.display="block";
			}
			
			//alert(sessionStorage.clickcount);
			}
		</script>
								

<!--<center><p style="margin-top:10px;color:#1E90FF;">Stars are awarded based on the average score of the game played in the skill</p></center>-->
 
<!-- game score star rating ENDS --> 
										 
									</div>
									
                                    </div>
                </div>
								</div>
							</div>
						</div>
						
						</div>
							


             
			<!-- Middle Content ends-->			
		</article>

			
	
		<!-- /.post -->
				
		<!-- /.post -->

	</div>
    
    
    </section> 
 




     
                                
                                
                                
                                
    
     </section>
    
        <section class="contentRight">
    
    
    		<!-- /#content --> 
	<aside id="sidebar">
		
						

						<div class="planner">
								<h2>My Daily Planner</h2>
							<div class="plannerCalender">
								 <table class="PlannerCalendar"><tbody><tr class="monthLabel"><td align="left" width="100%" colspan="7"><table><tbody><tr>
 <!--<td align='left'><a href='/projects/schools/dispindex.php?m=12&y=2016&act=mygames&gid=1&gsid='><<</a></td>-->
 <td align="center">January 2017</td>
<!-- <td  align='right'> <a href='/projects/schools/dispindex.php?m=2&y=2017&act=mygames&gid=1&gsid=' >>></a></td>-->
 
 </tr></tbody></table></td></tr><tr><td colspan="7"><table class="plannerDayList"><tbody><tr height="26px;"><td align="center" style="font-size:10px;" ;="" width="9%">SUN</td><td align="center" style="font-size:10px;" ;="" width="9%">MON</td><td align="center" style="font-size:10px;" ;="" width="9%">TUE</td><td align="center" style="font-size:10px;" ;="" width="9%">WED</td><td align="center" style="font-size:10px;" ;="" width="9%">THU</td><td align="center" style="font-size:10px;" ;="" width="9%">FRI</td><td align="center" style="font-size:10px;" width="9%">SAT</td></tr></tbody></table></td></tr><tr class="plannerDate"><td class="" style="font-size:14px;background: url(img/img/missed.png) no-repeat left bottom; background-size: 30px 30px;padding-left:4px;padding-bottom:20px;" align="center"> <span style="font-size:12px;font-weight:bold;">01</span> </td><td class="plannertodaycolor" style="font-size:14px;background: url(img/img/today.png) no-repeat left bottom #224687; background-size: 30px 30px;   box-shadow: 4px 5px 3px #74AFCC; padding-left:4px;;padding-bottom:20px;" align="center"> <span style="font-size:12px;font-weight:bold;">02</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">03</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">04</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">05</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">06</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">07</span> </td></tr><tr class="plannerDate"><td align="center"> <span style="font-size:12px;font-weight:bold;">08</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">09</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">10</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">11</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">12</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">13</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">14</span> </td></tr><tr class="plannerDate"><td align="center"> <span style="font-size:12px;font-weight:bold;">15</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">16</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">17</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">18</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">19</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">20</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">21</span> </td></tr><tr class="plannerDate"><td align="center"> <span style="font-size:12px;font-weight:bold;">22</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">23</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">24</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">25</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">26</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">27</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">28</span> </td></tr><tr class="plannerDate"><td align="center"> <span style="font-size:12px;font-weight:bold;">29</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">30</span> </td><td align="center"> <span style="font-size:12px;font-weight:bold;">31</span> </td><td align="center"> <span style="font-size:11px;font-weight:bold;">&nbsp;</span> </td><td align="center"> <span style="font-size:11px;font-weight:bold;">&nbsp;</span> </td><td align="center"> <span style="font-size:11px;font-weight:bold;">&nbsp;</span> </td><td align="center"> <span style="font-size:11px;font-weight:bold;">&nbsp;</span> </td></tr></tbody></table>								<ul class="statusDisplay">
                        		<li><span class="today"></span>Today</li>
                            	<li><span class="missedBus"></span>Missed the bus</li>
                            	<li><span class="brainTrained"></span>Brain trained</li>
                        		</ul>
                                
                                <ul>
                               
                                                                <li>
                        		<div class="badgeContainer">
                        			<p>Play every day to get badge	</p>
                               </div>
                               </li>
                                                                </ul>
                        	</div>
						</div>
                            <section class="pichartContainer">
                	<h2>My Skill Pie for the Day</h2>
								<div id="piechart1" class="jqplot-target" style="position: relative; height: 300px;"> <canvas width="281" height="300" class="jqplot-base-canvas" style="position: absolute; left: 0px; top: 0px;"></canvas><div class="jqplot-title" style="height: 0px; width: 0px;"></div><canvas width="281" height="300" class="jqplot-grid-canvas" style="position: absolute; left: 0px; top: 0px;"></canvas><canvas width="261" height="267" class="jqplot-series-shadowCanvas" style="position: absolute; left: 10px; top: 10px;"></canvas><canvas width="261" height="267" class="jqplot-series-canvas" style="position: absolute; left: 10px; top: 10px;"></canvas><table class="jqplot-table-legend" style="position: absolute; margin-top: 15px; left: 29px; bottom: 23px;"><tbody><tr class="jqplot-table-legend"><td class="jqplot-table-legend jqplot-table-legend-swatch" style="text-align: center; padding-top: 0px;"><div class="jqplot-table-legend-swatch-outline"><div class="jqplot-table-legend-swatch"></div></div></td><td class="jqplot-table-legend jqplot-table-legend-label" style="padding-top: 0px;">Memory</td><td class="jqplot-table-legend jqplot-table-legend-swatch" style="text-align: center; padding-top: 0px;"><div class="jqplot-table-legend-swatch-outline"><div class="jqplot-table-legend-swatch"></div></div></td><td class="jqplot-table-legend jqplot-table-legend-label" style="padding-top: 0px;">Visual Processing</td></tr><tr class="jqplot-table-legend"><td class="jqplot-table-legend jqplot-table-legend-swatch" style="text-align: center; padding-top: 0.5em;"><div class="jqplot-table-legend-swatch-outline"><div class="jqplot-table-legend-swatch"></div></div></td><td class="jqplot-table-legend jqplot-table-legend-label" style="padding-top: 0.5em;">Focus And Attention</td><td class="jqplot-table-legend jqplot-table-legend-swatch" style="text-align: center; padding-top: 0.5em;"><div class="jqplot-table-legend-swatch-outline"><div class="jqplot-table-legend-swatch"></div></div></td><td class="jqplot-table-legend jqplot-table-legend-label" style="padding-top: 0.5em;">Problem Solving</td></tr><tr class="jqplot-table-legend"><td class="jqplot-table-legend jqplot-table-legend-swatch" style="text-align: center; padding-top: 0.5em;"><div class="jqplot-table-legend-swatch-outline"><div class="jqplot-table-legend-swatch"></div></div></td><td class="jqplot-table-legend jqplot-table-legend-label" style="padding-top: 0.5em;">Linguistics</td></tr><tr class="jqplot-table-legend"></tr></tbody></table><canvas width="261" height="267" class="jqplot-pieRenderer-highlight-canvas" style="position: absolute; left: 10px; top: 10px;"></canvas><canvas width="261" height="267" class="jqplot-event-canvas" style="position: absolute; left: 10px; top: 10px;"></canvas></div>  
							</section>						
	</aside>
	<!-- /#sidebar -->
	            	<!--BEGIN SKILL PLANNER-->
                <!---->
                <!--END SKILL PLANNER-->
                <!--BEGIN STARS OF THE DAY-->
                <!--<section class="starsOfTheDay">
                	<h2>Your Stars for the Day..!</h2>
                    <ul>
                    	<li>
                        	<span class="memory"></span><h3>Memory</h3>
                            <div class="stars">
                            	<span class="memoryStar"></span>
                                <span class="memoryStar"></span>
                                <span class="memoryStar"></span>
                                <span class="emptyStar"></span>
                                <span class="emptyStar"></span>
                            </div>
                        </li>
                        <li class="alternateRow">
                        	<span class="visualProcessing"></span><h3>Visual Processing</h3>
                            <div class="stars">
                            	<span class="visualProcessingStar"></span>
                                <span class="emptyStar"></span>
                                <span class="emptyStar"></span>
                                <span class="emptyStar"></span>
                                <span class="emptyStar"></span>
                            </div>
                        </li>
                        <li>
                        	<span class="focus"></span><h3>Focus and Attention</h3>
                            <div class="stars">
                            	<span class="focusStar"></span>
                                <span class="focusStar"></span>
                                <span class="focusStar"></span>
                                <span class="focusStar"></span>
                                <span class="emptyStar"></span>
                            </div>
                        </li>
                        <li class="alternateRow">
                        	<span class="roblemSolving"></span><h3>Problem Solving</h3>
                            <div class="stars">
                            	<span class="roblemSolvingStar"></span>
                                <span class="roblemSolvingStar"></span>
                                <span class="emptyStar"></span>
                                <span class="emptyStar"></span>
                                <span class="emptyStar"></span>
                            </div>
                        </li>
                        <li>
                        	<span class="linguistics"></span><h3>Linguistics</h3>
                            <div class="stars">
                            	<span class="linguisticsStar"></span>
                                <span class="linguisticsStar"></span>
                                <span class="linguisticsStar"></span>
                                <span class="emptyStar"></span>
                                <span class="emptyStar"></span>
                            </div>
                        </li>
                    </ul>
                    <script type="text/javascript">
						$(".starsOfTheDay ul li:odd").addClass('alternateRow');
					</script>
                </section>-->
                <!--END STARS OF THE DAY-->
            </section>
    
    
    
    </section>
	</div>
                <!--END MY TROPHIES-->