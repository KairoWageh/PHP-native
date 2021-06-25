<?php
	// require config.php file
	require_once('Site_Model.php');

	$model_obj = new SiteModel();

	// add new user	
	if (isset($_POST['action']) && $_POST['action'] == "admin_login") {

		// define variables and initialize with empty values
		$email = $password = "";
		$email_error = $password_error = "";

		// check if email is empty
	    if(empty(trim($_POST["email"]))){
	        $email_error = "Please enter email.";
	    } else{
	        $email = trim($_POST["email"]);
	    }
    
	    // check if password is empty
	    if(empty(trim($_POST["password"]))){
	        $password_error = "Please enter your password.";
	    } else{
	        $password = trim($_POST["password"]);
	    }

	    echo $email;
	    echo $password;
	    // validate credentials
	    if(empty($email_error) && empty($password_err)){
	    	$admin = $model_obj->login_admin($email, $password);
	          
	        if($admin == 1){ 
	            $_SESSION["loggedin"] = true; 
	            header("Location: index.php");
	        }  
	        else{  
	            echo "<h1> Login failed. Invalid email or password.</h1>";  
	        } 
	    }else{
	    	if(!empty($email_error)){
	    		return $email_error;
	    	}
	    	if(!empty($password_error)){
	    		return $password_error;
	    	}
	    }
	}


	// add new user	
	if (isset($_POST['action']) && $_POST['action'] == "insert") {

		$name     = $_POST['name'];
		$email    = $_POST['email'];
		$password = $_POST['password'];
		$phones[] = $_POST['phone'];
		//var_dump($phones);
		$user_phones = array();
		foreach( $phones as $key => $phone ) {
			foreach ($phone as $user_phone) {
				array_push($user_phones, $user_phone);
			}	
		}	
		$sql = $model_obj->insert_user($name, $email, $password, $user_phones);
	}

	// get all data	
	if (isset($_GET['action']) && $_GET['action'] == "view") {
		$output = "";
		$users = $model_obj->get_users();

		if ($model_obj->totalRowCount() > 0) {
			$output .= '<table class="table">
							<thead class="thead-dark">
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Name</th>
							      <th scope="col">Email</th>
							      <th scope="col">Phone</th>
							      <th scope="col">Action</th>
							    </tr>
							</thead>
							<tbody>';
			foreach ($users as $user) {
    			$output .= '<tr>
					<td>'.htmlentities($user[0]).'</td>
					<td>'.htmlentities($user[1]).'</td>
					<td>'.htmlentities($user[2]).'</td>
					<td>';
					//if(count($user['phone']) > 1){
						foreach ($user['phone'] as $phone) {
			            	$output .= '<li>'.$phone.'</li>';
			          	}
			          // }else{
			          // 	$output .= '<li>'.$user['phone'].'</li>';
			          // }
		        	
					$output .= '</td>
						<td>
						<a href="update.php?id='.htmlentities($user[0]).'" class="btn btn-info">Edit
						</a>
						<button value="'.htmlentities($user[0]).'"class="btn btn-danger delete_user">
											Delete
				        </button>
				    </td>
			    </tr>';
			}
			$output .= '</tbody>
						</table>';
		}
		else{
			$output = "<p style='text-align: center'>No users yet</p>";
		}
		echo $output;
	}
								
	// add new user	
	if (isset($_GET['action']) && $_GET['action'] == "edit_user") {

		$output = "";
		// Get the userid
		$userid = intval($_GET['id']);
		$sql = $model_obj->edit($userid);
		$old_phones_count = $sql['phones']->num_rows;

		while($row = mysqli_fetch_array($sql['user']))
  		{
  			$output .= '<div class="row">
							<div class="col-md-4"><b>Name</b>
								<input type="text" name="name" value="'.htmlentities($row['name']).'" class="form-control" required>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4"><b>Email</b>
								<input type="email" name="email" value="'.htmlentities($row['email']).'" class="form-control" required>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4" >
								<b>Phone</b>';
								$phones=mysqli_fetch_all($sql['phones']);
								for($i=0; $i<$old_phones_count; $i++){
									// Add button will be added only next to first phone
									if($i==0){
										$output .= '<input type="hidden" name="phone_id[]" value="'.htmlentities($phones[$i][0]).'">

										<input type="tel" name="phone[]"  value="'.htmlentities($phones[$i][2]).'" class="form-control" pattern="[0-9]{11}" required="">
										<span name="add_phone" id="add_phone" class="btn btn-primary" style="float: right;margin-right: -96px;margin-top: -38px;">Add</span>';
									}
					
								$output .= '</div>
							</div>
							<div class="row">	
								<div class="col-md-4">'; 
									if($i!=0){
										// add remove button next to other old phone
										$output .= '<input type="hidden" name="phone_id[]" value="'.htmlentities($phones[$i][0]).'">
											<input type="tel" name="phone[]"  value="'.htmlentities($phones[$i][2]).'" class="form-control" pattern="[0-9]{11}" required="">
										<span name="remove_phone" class="btn btn-danger remove_phone" style="float: right;margin-right: -96px;margin-top: -38px;">Remove</span>';
									}
					
								}
						$output .= '</div>
					</div>
					';
 				} 
 		echo $output;
	}


	// get all data	
	if (isset($_POST['action']) && $_POST['action'] == "update_user") {

		$userid     = $_POST['user_id'];
		$name       = $_POST['name'];
		$email      = $_POST['email'];
		$phones_ids = $_POST['phone_id'];
		$phones     = $_POST['phone'];

		$assoc_phones = array();

		$assoc_phones = array_combine($phones_ids, $phones);

		$sql = $model_obj->update($name, $email, $assoc_phones, $userid);
	}

	// delete phone in edit form
	if (isset($_POST['action']) && $_POST['action'] == "delete_phone") {
		$phone_id     = $_POST['remove_phone_id'];
		$sql = $model_obj->deletePhone($phone_id);
	}

	// delete phone in edit form
	if (isset($_POST['action']) && $_POST['action'] == "delete_user") {
		$user_id     = $_POST['remove_user_id'];
		$sql = $model_obj->deleteUser($user_id);
	}

	function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
