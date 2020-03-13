#!/usr/bin/php
<?php
if ($argc < 3)
	exit();
$key = $argv[1].":";
for($i = 2; $i < $argc; $i++)
{
	if (strncmp($key, $argv[$i], strlen($key)) == 0)
		$value = substr($argv[$i], strlen($key));
}
if ($value)
	echo "$value\n";
?>