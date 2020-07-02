<?php
	include_once('user.php');

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		session_start();
		// If user is authenticated, redirect to index.php after setting session information
		if ($_POST['login'] && $_POST['passwd'] && auth($_POST['login'], $_POST['passwd']))
		{
			$_SESSION['logged_in_user'] = $_POST['login'];
			$user = read_user($_POST['login']);
			$_SESSION['permission_level'] = $user['permission_level'];
			header('Location: ../rush00/index.php');
		}
		else
		{
			$_SESSION['logged_in_user'] = NULL;
			header('Location: ../rush00/index.php?error=LoginNotFound');
		}
	}
?>

