#!/usr/bin/php
<?php
if ($argc > 1)
{
	$arr = preg_replace("/\s+/", " ", $argv[1]);
	$arr = explode(" ", $arr);
	$size = count($arr);
	$arr[$size] = $arr[0];
	unset($arr[0]);
	$i = 0;
	foreach ($arr as $elem)
	{
		$i++;
		if ($i < $size)
			echo "$elem ";
		else
			echo "$elem\n";
	}
}
?>