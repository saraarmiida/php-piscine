#!/usr/bin/php
<?php
if ($argc > 1)
{
	$arr = array_filter(explode(" ", trim($argv[1])));
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