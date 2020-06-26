<?php
if ($_POST["login"] && $_POST["oldpw"] && $_POST["newpw"] && $_POST["submit"] && $_POST["submit"] == "OK")
{
	$arr = unserialize(file_get_contents("../htdocs/private/passwd"));
	if ($arr)
	{
		$success = FALSE;
		foreach ($arr as $key => $value)
		{
			if ($value["login"] === $_POST["login"] && $value["passwd"] === hash("whirlpool", $_POST["oldpw"]))
			{
				$arr[$key]["passwd"] = hash("whirlpool", $_POST["newpw"]);
				file_put_contents("../htdocs/private/passwd", serialize($arr));
				echo "OK\n";
				header('Location: index.html');
				$success = TRUE;
			}
		}
		if ($success == FALSE)
		{
			echo "ERROR\n";
		}
	}
}
else
{
	echo "ERROR\n";
}
?>