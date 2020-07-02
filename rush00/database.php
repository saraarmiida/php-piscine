<?php 
	function connect_to_database() {
		// Retrieve db username & password from .env file (so no sensitive info is in the code);
		if (!file_exists('.env'))
			return ;
		foreach (file('.env') as $key => $line) {
			putenv(rtrim($line));
		}
		// Hardcoded like this so connection works from command line as well
		$servername = "127.0.0.1:3306";
		$username = getenv("db_user");
		$passwd = getenv("db_pw");
		$conn = mysqli_connect($servername, $username, $passwd);
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		return ($conn);
	}

	function close_connection($conn) {
		mysqli_close($conn);
	}
?>