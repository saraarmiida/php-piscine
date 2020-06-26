<?php
if ($_POST["login"] && $_POST["passwd"] && $_POST["submit"] && $_POST["submit"] == "OK")
{
	if (!file_exists("../htdocs"))
	{
		mkdir("../htdocs");
	}
	if (!file_exists("../htdocs/private"))
	{
		mkdir("../htdocs/private");
	}
	if (file_exists("../htdocs/private/passwd"))
	{
		$arr = unserialize(file_get_contents("../htdocs/private/passwd"));
		foreach ($arr as $user)
		{
			if ($user["login"] === $_POST["login"])
			{
				echo "ERROR\n";
				return ;
			}
		}
	}
	$user["login"] = $_POST["login"];
	$user["passwd"] = hash("whirlpool", $_POST["passwd"]);
	$arr[] = $user;
	file_put_contents("../htdocs/private/passwd", serialize($arr));
	echo "OK\n";
	header('Location: index.html');
}
else
{
	echo "ERROR\n";
}
?>