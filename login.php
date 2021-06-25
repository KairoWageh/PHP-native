<?php
// initialize the session
session_start();

require_once('layout/header.php');
 
// check if the admin is already logged in, if yes then redirect him to index page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
?>
<div class="content">
	<h1>Admin Login</h1>
		<div class="main">
			<div class="profile-left wthree">
				<div class="sap_tabs">
					<div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
						<ul class="resp-tabs-list">
							<li class="resp-tab-item" aria-controls="tab_item-0" role="tab"><span>My Account</span></li>
							<div class="clear"> </div>
						</ul>			
						<div class="resp-tabs-container">
							<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-0">
								<div class="got">
									<h6>Enter your details below to login</h6>
								</div>
								<div class="login-top">
									<form name="admin_login_form" id="admin_login_form" method="post">
										<div class="form-group">
											<input type="email" name="email" class="form-control email" placeholder="Email" required=""/>
											<!-- <span class="help-block"><?php echo $email_error; ?></span> -->
										</div>

										<div class="form-group ">
										    <input type="password" name="password" class="form-control password" placeholder="Password">
										    <!-- <span class="help-block"><?php echo $password_error; ?></span> -->
										</div>
										<div class="login-bottom">
											<input type="submit" name = "admin_login" id = "admin_login" value="LOGIN"/>
											<div class="clear"></div>
										</div>
									</form>
										
								</div>
							</div>
						</div>	
					</div>
					<div class="clear"> </div>
				</div>
			</div>
			<div class="clear"> </div>
		</div>	
		<script>  
			$(document).ready(function(){  
				//insert ajax request data
				
				$("#admin_login").click(function(e){
    				if ($("#admin_login_form")[0].checkValidity()) {
    					e.preventDefault();
			            $.ajax({
				            url : "Site_Controller.php",
				            type : "POST",
				            data : $("#admin_login_form").serialize()+"&action=admin_login",
				            success:function(){
						        window.location.href = 'index.php';
				            }
			          	});
    				}
				});
			});
		</script>
<?php
require_once('layout/footer.php');
?>
