#!/usr/bin/php
<?php
if ($argc > 1)
{
	$str = trim($argv[1]);
	$str = preg_replace("/\s+/", " ", $str);
	if (strlen($str) > 0)
	{
		$arr = explode(" ", $str);
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
}
?>