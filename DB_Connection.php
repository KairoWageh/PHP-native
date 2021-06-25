<?php
	if(!isset($_SESSION)){
		session_start();
	}
	// data required to connect to server and database
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'roqay_task');

	class DB_connection
	{
	 	public $con;
	 	function __construct()
	 	{
	 		// setup connection
	 		$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	 		$this->con = $con;
	 		// check connection
	 		if(mysqli_connect_errno()) {  
        		die("Failed to connect with MySQL: ". mysqli_connect_error());  
    		} 
	 	}
	}
?>