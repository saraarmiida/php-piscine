<?php
	include("auth.php");

	if(auth())
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