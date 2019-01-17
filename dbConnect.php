<?php
	class dbConnect {
		function connect() {
			require_once('config.php');
			$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
			mysqli_select_db($conn, DB_DATABSE);
			if(!$conn)// testing the connection
			{
				die (mysqli_error());
			} 
			return $conn;
		}
		public function Close(){
			mysqli_close();
		}
	}
?>