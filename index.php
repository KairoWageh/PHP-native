<?php

require_once('layout/header.php');
// include database connection file
require_once('Site_Model.php');

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
?>

<div>
	<a href="add.php" class="btn btn-info" style="float: right;">Add</a>
</div>
<div>
  <a href="logout.php" class="btn btn-info" style="float: right;">Logout</a>
</div>
<div class="clear"> </div>
<div id="tableData"></div>



<script>
  $(document).ready(function(){
    showAllUsers();
    //View Record
    function showAllUsers(){
      $.ajax({
        url : "Site_Controller.php",
        type: "GET",
        data : {action:"view"},
        success:function(response){
            $("#tableData").html(response);

            // remove hole div, input with its button 
            $('.delete_user').click(function(){  
              var remove_user_id = $(this).val();
              $.ajax({
                url : "Site_Controller.php",
                type: "POST",
                data : {action:"delete_user", remove_user_id: remove_user_id},
                success:function(response){
                    window.location.href = 'index.php';
                  }
                });
            });
          }
        });
      }      
    });


</script>

<?php
}else{
  header("location: login.php");
}
require_once('layout/footer.php');?>