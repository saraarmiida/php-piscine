<?php

date_default_timezone_set('Europe/Helsinki');

if (file_exists('../private/chat'))
{
	$arr = unserialize(file_get_contents('../private/chat'));
	foreach ($arr as $key => $value)
	{
		echo "[" . date('h:i', $value['time']) . "] <b>" . $value['login'] . "</b>: " . $value['msg'] . "<br />\n";
	}
}
?>