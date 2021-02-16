<footer>
<div class="container" id="footerpart">
<div class="row">
<div class="col-md-3 col-sm-6">

  <img src="<?php echo base_url(); ?>assets/images/Edsix.png" class="img-responsive"  width="193" height="67">
   
  <ul>
<li>Edsix BrainLab<sup>TM</sup> Pvt Ltd</li>
<li>Module #1, 3rd Floor, D Block,</li>
<li>Phase 2, IITM Research Park,</li>
<li>Kanagam Road, Taramani, Chennai - 600113</li>
  </ul>
  <?php //echo $this->lang->line("footeraddress"); ?> 
  </div>
<div class="col-md-3 col-sm-6">
<ul>
<li class="callicon"><?php echo $this->lang->line("ftphonenumber"); ?>, +91 95695 65454</li>
<li class="msgicon"><a href="mailto:support@skillangels.com"><?php echo 'support@skillangels.com';//$this->lang->line("ftemail"); ?></a></li>
</ul>
<div class="socialmedia">
<span><?php echo $this->lang->line("ftjoin"); ?></span>
<a href="https://www.facebook.com/skillangels" target="_blank"><img src="<?php echo base_url(); ?>assets/images/fb.png" width="33" height="33"></a> <a href="https://www.linkedin.com/company/edsix-brain-lab-pvt-ltd?trk=company_logo" target="_blank"><img src="<?php echo base_url(); ?>assets/images/icon_LinkedIn.png" width="33" height="33"></a>
</div>

</div>
<div class="col-md-3 col-sm-6">
<ul>
<li><a href="<?php echo base_url(); ?>index.php"><?php echo $this->lang->line("fthome"); ?></a></li>
<li><a href="<?php echo base_url(); ?>index.php/home/termsofservice" target="_blank"><?php echo $this->lang->line("ftterms"); ?></a></li>
<li><a href="<?php echo base_url(); ?>index.php/home/privacypolicy" target="_blank"><?php echo $this->lang->line("ftprivacy"); ?></a></li>
<li><a href="<?php echo base_url(); ?>index.php/home/faq" target="_blank"><?php echo $this->lang->line("ftfaq"); ?></a></li>
</ul>
</div>
<div class="col-md-3 col-sm-6">

  <img src="<?php echo base_url(); ?>assets/images/sklogo-web.png" class="img-responsive"  width="193" height="67">
   <br/>
<img src="<?php echo base_url(); ?>assets/images/logo_RTBI.png"  > <img src="<?php echo base_url(); ?>assets/images/logo_CJE.png"  ></div>
</div>
</div>

</footer>
<style>
.notes { color:#000; margin:0 auto; }
.notesdiv { text-align: justify;}
</style>
<div class="footerBottom"><p>&copy; <?php echo date("Y"); ?> Skillangels. All rights reserved</p></div>

<script type="text/javascript">
  $(document).ready(function(e) { 
   $('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 6000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});
	/* $(".loginmodal-container .close").click(function(){
		//$("#primary-menu").trigger('click');
		//$(".loginLink").attr('style','background: #f92c8b !important;');
	}); */
});
</script>

<script>
/* ****************************** User Login *********************************** */	
$('#submit').click(function(){ 
var form=$("#form-login");
$(".loader").show();

/* $.ajax({
type:"POST",
url:"<?php echo base_url('index.php/home/chkportaltype') ?>",
data:form.serialize(),
success:function(result)
{  */
//alert(result); //return false;
	result='54545';
	if(result=='1819')
	{
		var url = 'https://schools.skillangels.com/1819/';
		//var url = 'https://schools.skillangels.com/';
		//shishuredirect(form,url); //shishu, redirect to new url
		checkportaltype_shishu(form,url)
	}
	else
	{
		var url = '<?php echo base_url(); ?>';
	}
	
	if(result=='PASAP')
	{
		ASAPuserlogin(form,url);	// redirect to old portal
	}
	else if(result=='asapnew')
	{
		asapnewurl(form,url); // grade 1 to 8, redirect to new url
	}
	else if(result=='asapo')
	{
		//var url = '<?php echo base_url(); ?>';
		asapo(form,url); // grade 1 to 8, redirect to new url
	}
	else 
	{
		islogin(form,url);
	}

/* }
}); */

});	


function checkportaltype_shishu(form,url)
{
	$.ajax({
type:"POST",

//url:"<?php echo base_url('index.php/home/chkportaltype') ?>",
url:url+'index.php/home/chkportaltype',
data:form.serialize(),
success:function(result)
{ 

	if(result=='PASAP')
	{
		ASAPuserlogin(form,url);	// redirect to old portal
	}
	else if(result=='asapnew')
	{
		asapnewurl(form,url); // grade 1 to 8, redirect to new url
	}
	else 
	{
		islogin(form,url);
	}

}
	});
}

function islogin(form,url)
{
	/* Avoid Multiple Login */	
$.ajax({
type:"POST",

//url:"<?php echo base_url('index.php/home/islogin') ?>",
url:url+'index.php/home/islogin',
data:form.serialize(),
success:function(isloginval)
{ //alert(isloginval);
	if(isloginval==0){
		if(($('#termscondition').is(':checked')))
		{	
			//userlogin(form);
			isUser(form,url);
		}
		else
		{
			termscheck(form,url);
		}
	}
	else
	{
			swal({
			  title: 'Are you sure?',
			  text: "You are logging into another system. Would you like to continue.",
			  //type: 'warning',
			  width: 800,
			padding:180,
		//	background: 'url(<?php echo base_url(); ?>/assets/images/popup/PUholder-leftatgame.png)',
			background: 'url('+url+'assets/images/popup/PUholder-leftatgame.png)',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Yes, continue !',
			  cancelButtonText: 'Cancel !',
			  confirmButtonClass: 'btn btn-success',
			  cancelButtonClass: 'btn btn-danger',
			  allowOutsideClick: false,
			  allowEscapeKey : false,
			  buttonsStyling: false
			}).then(function () {
					if(($('#termscondition').is(':checked')) )
					{
						//userlogin(form);
						userlogin(form,url);
					}
					else
					{
						termscheck(form,url);
					}
			  
			}, function (dismiss) {
			  if (dismiss === 'cancel') {
				/* swal(
				  'Cancelled',
				  'You are continuing with your previous login :)',
				  'error'
				); */
				$(".loader").hide();
			  }
			});
		
	}
}
});
}
/* swal({
			  title: 'Invalid IP Address',
			  text: "You are not allowed to login.",
			  //type: 'warning',
			  width: 800,
			padding:180,
		//	background: 'url(<?php echo base_url(); ?>/assets/images/popup/PUholder-leftatgame.png)',
			background: 'url('+url+'assets/images/popup/PUholder-leftatgame.png)',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
		//	  cancelButtonColor: '#d33',
			  confirmButtonText: 'Yes, continue !',
			  cancelButtonText: 'Cancel !',
			  confirmButtonClass: 'btn btn-success',
			  cancelButtonClass: 'btn btn-danger',
			  allowOutsideClick: false,
			  allowEscapeKey : false,
			  buttonsStyling: false
			})  .then(function () {function (dismiss) {
			  if (dismiss === 'cancel') {
				/* swal(
				  'Cancelled',
				  'You are continuing with your previous login :)',
				  'error'
				); */
				/* $(".loader").hide();
			  }
			});*/ 
function userlogin(form,url)
{	
		$.ajax({
				type:"POST",
				
				//url:"<?php echo base_url('index.php/home/userlogin') ?>",
				url:url+'index.php/home/userlogin',
				data:form.serialize(),
				success:function(result)
				{ 
					if(result=='BT')
					{
						//window.location.href= "<?php echo base_url();?>index.php/home/iaschallenge";
						window.location.href= url+'index.php/home/iaschallenge';
					}
					
					else if(result==1)
					{
						//window.location.href= "<?php echo base_url();?>index.php/home/dashboard#View";
						window.location.href= url+'index.php/home/dashboard#View';
					}
					else if(result==0)
					{
						//window.location.href= "<?php echo base_url();?>index.php/home/dashboard#View";
						window.location.href= url+'index.php/home/skillkit#View';
					}					
					else if(result=='IVIP')
					{
						$(".loader").hide();

							swal({
								title: 'Invalid IP Address',
								text: "You are not allowed to login.",
								//type: 'warning',
								width: 800,
								padding:180,
								//	background: 'url(<?php echo base_url(); ?>/assets/images/popup/PUholder-leftatgame.png)',
								background: 'url('+url+'assets/images/popup/PUholder-leftatgame.png)',
							//	showCancelButton: true,
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: 'Ok',
							//	cancelButtonText: 'Cancel !',
								confirmButtonClass: 'btn btn-success',
								cancelButtonClass: 'btn btn-danger',
								allowOutsideClick: false,
								allowEscapeKey : false,
								buttonsStyling: false
							})
					}
					else
					{
						$(".loader").hide();
						$("#errormsg").html('Invalid Credentials');
						$('.close').click();
						$('#invalidloginmodal').modal('show');
					}
				}
		}); 
	
}
function isUser(form,url)
{
		$.ajax({
				type:"POST",
				
				//url:"<?php echo base_url('index.php/home/isUser') ?>",
				url:url+'index.php/home/isUser',
				data:form.serialize(),
				dataType: "json",
				success:function(result)
				{ 
				if(result.isUser!=0 && result.popup==1)
					{	
				//$('.close').click();
						if(result.isschedule==0)
						{
							var scheduledaymsg='You have no schedule now, want to proceed ?';
						}
						else
						{
							var scheduledaymsg='';
						}
						swal({
						  title: 'User Confirmation',
						  /* text: "You are logging into another system.would you like to continue.", */
						 // type: 'warning',
						  width: 800,
						  padding:130,
						  //background: 'url(<?php echo base_url(); ?>/assets/images/popup/PUholder-userconfirm.png)',
						  background: 'url('+url+'assets/images/popup/PUholder-userconfirm.png)',
						  html: 'Username : <b>'+result.fname+'</b><br/>'+
								'Grade : <b>'+result.gradename+'</b><br/>'+
								'Section : <b>'+result.section+'</b><br/><br/>'+scheduledaymsg,
						  showCancelButton: true,
						  confirmButtonColor: '#3085d6',
						  cancelButtonColor: '#d33',
						  confirmButtonText: 'Yes, continue !',
						  cancelButtonText: 'Cancel !',
						  confirmButtonClass: 'btn btn-success',
						  cancelButtonClass: 'btn btn-danger',
						  allowOutsideClick: false,
						  allowEscapeKey : false,
						  buttonsStyling: false
						}).then(function () {
								//CaptureUserData(result.id,result.isschedule,'Y');
								$.ajax({
									type:"POST",
									
									//url:"<?php echo base_url('index.php/home/insertuserlog') ?>",
									url:url+'index.php/home/insertuserlog',
									data:{userid:result.id,isschedule:result.isschedule,type:'Y'},
									success:function(yesres)
									{
										userlogin(form,url);
									}
								});
		
						}, function (dismiss) {
						  if (dismiss === 'cancel') {
									/* swal({
											  title: 'Thank You',
											  width: 800,
											   padding:150,
						  background: 'url(<?php echo base_url(); ?>/assets/images/popup/PUholder-userconfirm.png)',
											  text: '',
											  timer: 20,
											  onOpen: function () {
												swal.showLoading()
											  }
									}); */
									$(".loader").hide();
								
						  }
						});
					}
					else { userlogin(form,url); }
				}
		}); 
	
}

function ASAPuserlogin(form,url)
{	
		$.ajax({
				type:"POST",
				
				//url:"<?php echo base_url('pasap/index.php/home/asapuserlogin') ?>",
				url:url+'index.php/home/asapuserlogin',
				data:form.serialize(),
				success:function(result)
				{ 
					if(result=='ASAP')
					{
						//window.location.href= "<?php echo base_url();?>pasap/index.php/mypuzzleset1/dashboard#View";
						window.location.href= url+'pasap/index.php/mypuzzleset1/dashboard#View';
					}
					else
					{	$(".loader").hide();
						$("#errormsg").html('Invalid Credentials');
					}
				}
		}); 
	
}

function asapnewurl(form,url)
{	
		$.ajax({
				type:"POST",
				//url:"<?php echo base_url('asap/index.php/home/asapuserlogin') ?>",
				
				url:url+'asap/index.php/home/asapuserlogin',
				data:form.serialize(),
				success:function(result)
				{ 
					if(result=='ASAP')
					{
						//window.location.href= "<?php echo base_url();?>asap/index.php/mypuzzleset1/dashboard#View";
						window.location.href= url+'asap/index.php/mypuzzleset1/dashboard#View';
					}
					else
					{	$(".loader").hide();
						$("#errormsg").html('Invalid Credentials');
					}
				}
		}); 
	
}

function asapo(form,url)
{	
		$.ajax({
				type:"POST",
				//url:"<?php echo base_url('asap/index.php/home/asapuserlogin') ?>",
				
				url:url+'asapo/index.php/home/asapuserlogin',
				data:form.serialize(),
				success:function(result)
				{ 
					if(result=='ASAP')
					{
						//window.location.href= "<?php echo base_url();?>asap/index.php/mypuzzleset1/dashboard#View";
						window.location.href= url+'asapo/index.php/mypuzzleset1/dashboard#View';
					}
					else
					{	$(".loader").hide();
						$("#errormsg").html('Invalid Credentials');
					}
				}
		}); 
}


function shishuredirect(form,url)
{	
		$.ajax({
				type:"POST",
				
				//url:"<?php echo base_url('asap/index.php/home/asapuserlogin') ?>",
				url:url+'asap/index.php/home/asapuserlogin',
				data:form.serialize(),
				success:function(result)
				{ 
					if(result=='ASAP')
					{
						//window.location.href= "<?php echo base_url();?>asap/index.php/mypuzzleset1/dashboard#View";
						window.location.href= url+'asap/index.php/mypuzzleset1/dashboard#View';
					}
					else
					{	$(".loader").hide();
						$("#errormsg").html('Invalid Credentials');
					}
				}
		}); 
	
}


function termscheck(form,url)
{
		$.ajax({
				type:"POST",
				
				//url:"<?php echo base_url('index.php/home/termscheck') ?>",
				url: url+'index.php/home/termscheck',
				data:form.serialize(),
				success:function(result)
				{
				//alert(result);
					if(result==0  && $.trim(result)!='')
					{	$(".loader").hide();
						$("#termschkbox").show();
						$("#terrormsg").html('Please check terms and conditions');
					}
					else
					{
						//userlogin(form);
						isUser(form,url);
					}

				}
		});
}
</script>
<script>
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    $("html,body").animate({scrollTop:$("#header").offset().top},"100");return false;
}

/* $(window).load(function(){        
$('#myModal').modal('show');
});  */


</script>


<!-- Cookie Alert---->
<link href="<?php echo base_url();?>assets/css/cookiealert/cookiealert.css" rel="stylesheet" type="text/css" /><!-- START Bootstrap-Cookie-Alert -->
<div class="alert text-center cookiealert" role="alert">
<b>Do you like cookies?</b> &#x1F36A; We use cookies to ensure you get the best experience on our website. 
<a href="<?php echo base_url();?>index.php/home/privacypolicy#cookie" target="_blank" >Learn more</a>
<button type="button" class="btn btn-primary btn-sm acceptcookies" aria-label="Close">        I agree</button>
</div>
<script src="<?php echo base_url();?>assets/js/cookiealert/cookiealert.js"></script>

</body>
</html>