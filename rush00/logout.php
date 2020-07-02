<?php
	// Hardcore logs out user :D
	function logout() {
		session_unset();
		session_destroy();
		session_write_close();
		setcookie(session_name(),'',0,'/');
		session_regenerate_id(true);
		header('Location: ../rush00/index.php');
	}

	logout();
?>
