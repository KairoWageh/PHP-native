<?php
require_once('layout/header.php');
?>

<div>
	<a href="index.php" class="btn btn-info" style="float: right;">Home</a>
</div>

<form name="insert_user" id="insert_user" method="post">
	<div class="row">
		<div class="col-md-4"><b>Name</b>
			<input type="text" name="name" class="form-control" pattern="/^[A-Za-z]+([\ A-Za-z]+)*/" required>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4"><b>Email</b>
			<input type="email" name="email" class="form-control" required>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4"><b>Password</b>
			<input type="password" name="password" class="form-control" required>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4" id="phone"><b>Phone</b>
			<input type="tel" name="phone[]" class="form-control" pattern="[0-9]{11}" required="">
			<span name="add_phone" id="add_phone" class="btn btn-primary">Add</span>
			<div id="additional_phone_0"></div>
		</div>
	</div>
	<div class="row" style="margin-top:1%">
		<div class="col-md-8">
			<input type="submit" class="btn btn-success" id="insert_user" name="insert_user" value="Insert">
		</div>
	</div>
</form>
<script>  
 $(document).ready(function(){  
 	//insert ajax request data
    $("#insert_user").click(function(e){
        if ($("#insert_user")[0].checkValidity()) {
        	e.preventDefault();
            $.ajax({
	            url : "Site_Controller.php",
	            type : "POST",
	            data : $("#insert_user").serialize()+"&action=insert",
	            success:function(response){
			        window.location.href = 'index.php';
	            }
          	});
        }
    });

    var i=1;  
    $('#add_phone').click(function(){ 
        $('#additional_phone_'+(i-1)).html('<div style="margin-top: 5px"><input type="tel" name="phone[]" class="form-control" pattern="[0-9]{11}" required="">'+
           	'<span name="remove_phone_'+i+'" class="btn btn-danger remove_phone">Remove</span></div>');
           // remove hole div, input with its button 
	        $('.remove_phone').click(function(){  
			   event.target.parentElement.remove();
			});
            var id = "additional_phone_"+i;
            $('#phone').append('<div id="'+id+'" ></div>'); 
        i++;    
    });   
 });  
 </script>

<?php
require_once('layout/footer.php');
?>