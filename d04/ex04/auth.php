<?php

function auth($login, $passwd)
{
	if (!$login || !$passwd)
	{
		return FALSE;
	}
	$arr = unserialize(file_get_contents("../htdocs/private/passwd"));
	foreach($arr as $key => $value)
	{
		if ($value["login"] == $login && $value["passwd"] == hash("whirlpool", $passwd))
		{
			return TRUE;
		}
	}
	return FALSE;
}
?>