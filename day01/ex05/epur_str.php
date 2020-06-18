#!/usr/bin/php
<?php
if ($argc != 2)
	exit();
$str = preg_replace("/ +/", " ", trim($argv[1]));
if (strlen($str) != 0)
	echo "$str\n";
?>