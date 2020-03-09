#!/usr/bin/php
<?php

$i = 1;
$arr = array();
foreach($argv as $elem)
{
	if ($i++ > 1)
	{
		$tmp = array_filter(explode(" ", $elem));
		if ($tmp != "")
			$arr = array_merge($arr, $tmp);
	}
}
sort($arr);
foreach ($arr as $elem)
	echo "$elem\n";
?>