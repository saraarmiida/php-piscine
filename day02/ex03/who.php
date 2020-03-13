#!/usr/bin/php
<?php
$bin = fopen("/var/run/utmpx", "r");
fseek($bin, 1256);
date_default_timezone_set("Europe/Helsinki");
while (feof($bin) != true)
{
	$data = fread($bin, 628);
	if (strlen($data) == 628)
	{
		$str = unpack("a256user/a4id/a32line/ipid/itype/itime", $data);
		if ($str["type"] == 7)
		{
			echo $str["user"]."  ";
			echo $str["line"]."  ";
			echo date("M d h:i", $str["time"]);
			echo "\n";
		}
	}
}
?>