#!/usr/bin/php
<?php
$i = 1;
$arr = array();
foreach($argv as $elem)
{
	if ($i++ > 1)
	{
		$elem = preg_replace("/ +/", " ", $elem);
		$tmp = explode(" ", $elem);
		if ($tmp != "")
			$arr = array_merge($arr, $tmp);
	}
}
sort($arr);
foreach ($arr as $elem)
	echo "$elem\n";
?>