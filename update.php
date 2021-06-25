<?php
require_once('layout/header.php');
?>

<form name="update_user" id="update_user" method="post">
	<div id="user"></div>
	<div class="row">	
		<div class="col-md-4" id="phone">
			<div id="additional_phone_0"></div>
		</div>
	</div>
	<div class="row" style="margin-top:1%">
		<div class="col-md-8">
			<input type="submit" class="btn btn-info" name="update_user" id="update_user" value="Edit">
		</div>
	</div>
</form>

<script>  
 $(document).ready(function(){ 

 	getUser();
    //View Record
    function getUser(){
    	var query = window.location.search.substring(1);
		var vars = query.split("=");
		// get user id to get his data
		var ID= vars[1];
    	$.ajax({
        	url : "Site_Controller.php",
        	type: "GET",
        	data : {action:"edit_user", id: ID},
	        success:function(response){
	            $("#user").html(response);
	            $('.remove_phone').click(function(){  
					event.target.parentElement.remove();
					var remove_phone_id = $(this).siblings('input[type="hidden"]').val();
					$.ajax({
			            type: 'post',
			            url: 'Site_Controller.php',
			            data: {action: "delete_phone", remove_phone_id: remove_phone_id},
			            success: function () {
			              alert('form was submitted');
			            }
			        });

				}); 
			      var i=1;  
				$('#add_phone').click(function(){ 
				       $('#additional_phone_'+(i-1)).html('<div class="" style="margin-top: 10px">'+
				       	'<input type="hidden" name="phone_id[]" value="0">'+
				       	'<input type="tel" name="phone[]" class="form-control" pattern="[0-9]{11}" required=""></div>'+
				       	'<span name="remove_phone_'+i+'" class="btn btn-danger remove_phone" style="float: right;margin-right: -96px;margin-top: -38px;">Delete</span>');
				       	// remove hole div, input with its button 
				        $('.remove_phone').click(function(){  
						   event.target.parentElement.remove();
						});
				       var id = "additional_phone_"+i;
				       $('#phone').append('<div id="'+id+'" ></div>'); 
				    i++;    
				}); 
	        }
        });
    }      

    $("form").submit(function(e){
    	var query   = window.location.search.substring(1);
		var vars    = query.split("=");
		var user_id = vars[1];

    	var name     = document.querySelectorAll('input[name=name]')[0].value;
    	var email    = document.querySelectorAll('input[name=email]')[0].value;

    	var phone_id = $("input[name='phone_id[]']")
              .map(function(){return $(this).val();}).get();
    	var phone = $("input[name='phone[]']")
              .map(function(){return $(this).val();}).get();
    	
        if ($("#update_user")[0].checkValidity()) {
        	e.preventDefault();
	        $.ajax({
	            url : "Site_Controller.php",
	            type : "POST",
	            data : {user_id: user_id, name: name, email: email, phone_id: phone_id, phone: phone, action:"update_user"},
	            success:function(response){
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