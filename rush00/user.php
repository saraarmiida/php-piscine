<?php
	include_once('database.php');
	// Creates user to database with given information.
	// As login is uniquely constrained, no duplicates are allowed
	function create_user($type, $login, $passwd) {
		$conn = connect_to_database();
		$type = mysqli_real_escape_string($conn, $type);
		$login = mysqli_real_escape_string($conn, $login);
		$passwd = mysqli_real_escape_string($conn, $passwd);
		mysqli_select_db ($conn , 'rush00');
		$passwd_hashed = hash('sha512', $passwd);
		$permission_level = $type == 'admin' ? 1 : 0;
		$query = "INSERT INTO users (permission_level, login, passwd)
			VALUES ('$permission_level', '$login', '$passwd_hashed');";
		$result = mysqli_query($conn, $query);
		if ($result)
		{
			echo "Added user, type: $type; login: $login\n";
			return (true);
		}
		else
			echo (mysqli_error($conn));
		close_connection($conn);
		return (false);
	}

	// Returns in array form user data read by login
	function read_user($login) {
		$conn = connect_to_database();
		$login = mysqli_real_escape_string($conn, $login);
		mysqli_select_db ($conn , 'rush00');
		$query = "SELECT id, login, permission_level, passwd FROM users
				WHERE login='$login';";
		$result = mysqli_query($conn, $query);
		close_connection($conn);
		if ($result)
			return ($result->fetch_array(MYSQLI_ASSOC));
		else
			return (false);
	}

	function read_users() {
		$conn = connect_to_database();
		mysqli_select_db ($conn , 'rush00');
		$query = "SELECT id, login, permission_level, passwd FROM users;";
		$result = mysqli_query($conn, $query);
		close_connection($conn);
		if ($result)
			return ($result->fetch_all(MYSQLI_ASSOC));
		else
			return (false);
	}

	// Deletes user by login
	function delete_user($login) {
		$conn = connect_to_database();
		$login = mysqli_real_escape_string($conn, $login);
		mysqli_select_db ($conn , 'rush00');
		$query = "DELETE FROM users WHERE login='$login';";
		$result = mysqli_query($conn, $query);
		if ($result)
			echo "Deleted user $login if existed\n";
		else
			echo die(mysqli_error($conn));
		close_connection($conn);
	}

	// Updates user by user array
	function update_user($type, $login, $passwd) {
		if (read_user($login)) {
			delete_user($login);
			create_user($type, $login, $passwd);
		} else {
			echo "User with login $login not found\n";
		}
	}

	function auth($login, $passwd)
	{
		if (!$login || !$passwd)
			return FALSE;
		if ($user = read_user($login)) {
			return $user['passwd'] == hash('sha512', $passwd);
		}
		return FALSE;
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		session_start();
		if ($_POST['submit'] == 'add') {
			if ($_POST['login'] && $_POST['passwd'])
			{
				// Create user & if it fails, pass arbitrary error to index.php (hack!)
				if (create_user('common', $_POST['login'], $_POST['passwd']))
					header('Location: ../rush00/index.php');
				else
					header('Location: ../rush00/index.php?error=DuplicateUserError');
			}
			else
				echo "ERROR\n";	
		}
		else if ($_POST['submit'] == 'update') {
			if ($_POST['login'] && $_POST['passwd'])
			{
				if (update_user('common', $_POST['login'], $_POST['passwd']))
					header('Location: ../rush00/index.php');
				else
					header('Location: ../rush00/index.php?error=DuplicateUserError');
			}
			else
				echo "ERROR\n";	
		}
		else if ($_POST['submit'] == 'delete' && $_SESSION['permission_level'] == '1') {
			if ($_POST['login'])
			{
				delete_user($_POST['login']);
				if ($_POST['login'] == $_SESSION['logged_in_user']) {
					header('Location: ../rush00/logout.php?');
				} else
					header('Location: ../rush00/admin.php?');
			}
			else {
				header('Location: ../rush00/index.php?error=WrongPassWord');
			}
		}
		else if ($_POST['submit'] == 'delete' && $_SESSION['permission_level'] == '0') {
			if ($_POST['login'] && auth($_POST['login'], $_POST['passwd']))
			{
				delete_user($_POST['login']);
				header('Location: ../rush00/logout.php?');
			}
			else
				header('Location: ../rush00/index.php?error=WrongPassWord');
		}
	} else if ($_SERVER['REQUEST_METHOD'] == 'GET' && strpos($_SERVER['REQUEST_URI'], 'user.php') !== false) {
		session_start();
		if ($_GET['login'] && $_SESSION['logged_in_user'] && $_SESSION['permission_level'] == '1') {
			echo "<pre>";
			print_r(read_user($_GET['login']));
			echo "</pre>";
		}
		else if ($_SESSION['logged_in_user'] && $_SESSION['permission_level'] == '1' && strpos($_SERVER['REQUEST_URI'], 'user.php') !== false)
		{
			echo "<pre>";
			print_r(read_users());
			echo "</pre>";
		}
		header('Location: ../rush00/index.php');
	}

	// Validation & prints if this script is called from command line
	if (php_sapi_name() == "cli") {
		if ($argv[1] == 'add' && ($argv[2] == 'admin' || $argv[2] == 'common'))
		{
			if ($argv[3] && $argv[4])
				create_user($argv[2], $argv[3], $argv[4]);
			else
				echo "Invalid arguments\n";
		}
		else if ($argv[1] == 'update' && ($argv[2] == 'admin' || $argv[2] == 'common'))
		{
			if ($argv[3] && $argv[4])
				update_user($argv[2], $argv[3], $argv[4]);
			else
				echo "Invalid arguments\n";
		}
		else if ($argv[1] == 'delete')
		{
			if ($argv[2])
				delete_user($argv[2]);
			else
				echo "Invalid arguments\n";
		}
		else if ($argv[1] == 'read')
		{
			if ($argv[2])
			{
				if ($user = read_user($argv[2]))
					print_r($user);
				else
					echo "Could not fetch user\n";
			}
			else if ($users = read_users())
				print_r($users);
			else
				echo "Could not fetch users\n";
		}
		else
			echo "Invalid arguments\n";
	}
?>