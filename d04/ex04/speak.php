<?php
	include("auth.php");

	session_start();

	if (!($_SESSION['loggued_on_user']) || $_SESSION['loggued_on_user'] === "")
	{
		exit("ERROR");
	}
	else
	{
		if ($_POST['msg'])
		{
			if (!file_exists("../private"))
			{
				mkdir("../private");
			}
			if (!file_exists("../private/chat"))
			{
				file_put_contents("../private/chat", null);
			}

			$fp = fopen("../private/chat", 'r+');
			if (flock($fp, LOCK_EX))
			{
				$arr = unserialize(file_get_contents("../private/chat"));
				$new_msg['login'] = $_SESSION['loggued_on_user'];
				$new_msg['time'] = time();
				$new_msg['msg'] = $_POST['msg'];
				$arr[] = $new_msg;
				file_put_contents("../private/chat", serialize($arr));

			}
			fclose($fp);
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<script langage="javascript">top.frames['chat'].location = 'chat.php';</script>
	</head>
	<body>
		<form action="speak.php" method="POST">
			<input type="text" name="msg" />
			<button type="submit">Send</button>
		</form>
	</body>
</html>