#!/usr/bin/php
<?php

$i = 1;
$arr = array();

function is_sort($a, $b)
{
	$a = strtolower($a);
	$b = strtolower($b);
	$order = "abcdefghijklmnopqrstuvwxyz0123456789 !\"#$%&'()*+,-./:;<=>?@[\]^_`{|}~";
	$len = strlen($a) < strlen($b) ? strlen($a) : strlen($b);
	for ($i = 0; $i < $len; $i++)
	{
		$aa = substr($a, $i, 1);
		$bb = substr($b, $i, 1);
		$aval = strpos($order, $aa);
		$bval = strpos($order, $bb);
		if ($bval > $aval)
			return (true);
		if ($bval < $aval)
			return (false);
	}
	return strlen($a) <= strlen($b) ? true : false;
}
foreach($argv as $elem)
{
	if ($i++ > 1)
	{
		$tmp = preg_split("/ +/", trim($elem));
		if ($tmp != "")
			$arr = array_merge($arr, $tmp);
	}
}
for ($i = 0; $i < count($arr) - 1;)
{
	if (is_sort($arr[$i], $arr[$i + 1]))
		$i++;
	else
	{
		$tmp = $arr[$i];
		$arr[$i] = $arr[$i + 1];
		$arr[$i + 1] = $tmp;
		$i = 0;
	}
}
foreach ($arr as $elem)
	echo "$elem\n";
?>