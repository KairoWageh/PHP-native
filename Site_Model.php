<?php

	// require DB_Connection.php file
	require_once('DB_Connection.php');

	/**
	 * 
	 */
	class SiteModel
	{
		public $db_con;

		function __construct()
	 	{
	 		$this->db_con = new DB_Connection();
	 	}
		
	 	//login admin

	 	public function login_admin($email, $password){
	 		var_dump($email);
	 		$admin = mysqli_query($this->db_con->con, "select * from admins where email = '$email' and password = '$password'");
	 		return $admin;
	 	}

	 	// add new user
		public function insert_user($name,$email, $password,$phones=[])
		{
			$new_user=mysqli_query($this->db_con->con,"insert into users(name,email, password) values('$name','$email', '$password')");
			if($new_user){
  				$last_id = mysqli_insert_id($this->db_con->con);
  				foreach ($phones as $key=>$phone) {
					$user_phone = mysqli_query($this->db_con->con,"insert into phones(phone, user_id) values('$phone','$last_id')");
				}
				return true;
  			}else{
  				return false;
  			}
  			
		}
		// get all users to view in index page
		public function get_users()
		{
			$users = mysqli_query($this->db_con->con, "select * from users");
			$all_users = mysqli_fetch_all($users);

			$phones = mysqli_query($this->db_con->con, "select * from phones");
			$all_phones = mysqli_fetch_all($phones);


			//var_dump($all_users);
				
			$return_users = array();
			foreach ($all_users as $key => $user) {
				foreach ($all_phones as $key => $phone) {
					if($phone[1] == $user[0]){
						$user['phone'][] = $phone[2];
					}	
				}
				array_push($return_users, $user);
			}
			return $return_users;
		}
		// get user data to edit
		public function edit($userid)
		{
			$user = mysqli_query($this->db_con->con,"select * from users where id=$userid");
			$user_phone = mysqli_query($this->db_con->con,"select * from phones where user_id=$userid");
			return ['user' => $user, 'phones' => $user_phone];
		}
		// update user data
		public function update($name, $email, $phones=[], $userid)
		{
			$update_user=mysqli_query($this->db_con->con, "update users set name='$name', email='$email' where id=$userid");
			if($update_user){
				foreach ($phones as $key=>$phone) {
					if($key != 0){
						$user_phone = mysqli_query($this->db_con->con, "update  phones set phone='$phone' where id=$key and user_id=$userid");
					}else if($key == 0){
						mysqli_query($this->db_con->con,"insert into phones(phone, user_id) values('$phone','$userid')");
					}
				}
			}
		}

		// delete user phone
		public function deletePhone($user_phone)
		{
			$phone_delete = mysqli_query($this->db_con->con,"delete from phones where id=$user_phone"); 
			return $phone_delete;
		}

		// delete user
		public function deleteUser($userid)
		{
			$phone_delete = mysqli_query($this->db_con->con,"delete from phones where user_id=$userid"); 
			$delete_user = mysqli_query($this->db_con->con,"delete from users where id=$userid");
			return $delete_user;
		}

		public function totalRowCount(){
			$sql = "select * from users";
			$query = $this->db_con->con->query($sql);
			$rowCount = $query->num_rows;
			return $rowCount;
		}
}
?>