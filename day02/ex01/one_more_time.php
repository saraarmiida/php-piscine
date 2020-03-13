#!/usr/bin/php
<?php
if ($argc == 2)
{
	date_default_timezone_set("Europe/Paris");
	$arr = explode(" ", $argv[1]);
	if (count($arr) != 5)
	{
		echo "Wrong Format\n";
		exit();
	}
	$nb = 0;
	if (preg_match("/^[lL]undi$/", $arr[0]))
		$nb = 1;
	elseif (preg_match("/^[mM]ardi$/", $arr[0]))
		$nb = 1;
	elseif (preg_match("/^[mM]ercredi$/", $arr[0]))
		$nb = 1;
	elseif (preg_match("/^[jJ]eudi$/", $arr[0]))
		$nb = 1;
	elseif (preg_match("/^[vV]endredi$/", $arr[0]))
		$nb = 1;
	elseif (preg_match("/^[sS]amedi$/", $arr[0]))
		$nb = 1;
	elseif (preg_match("/^[dD]imanche$/", $arr[0]))
		$nb = 1;
	if ($nb == 0)
	{
		echo "Wrong Format\n";
		exit();
	}
	if (preg_match("/^\d{1,2}$/", $arr[1]) == 0)
	{
		echo "Wrong Format\n";
		exit();
	}
	$nb = 0;
	if (preg_match("/^[jJ]anvier$/", $arr[2]))
		$nb = 1;
	if (preg_match("/^[fF][ée]vrier$/", $arr[2]))
		$nb = 1;
	if (preg_match("/^[mM]ars$/", $arr[2]))
		$nb = 1;
	if (preg_match("/^[aA]vril$/", $arr[2]))
		$nb = 1;
	if (preg_match("/^[mM]ai$/", $arr[2]))
		$nb = 1;
	if (preg_match("/^[jJ]uin$/", $arr[2]))
		$nb = 1;
	if (preg_match("/^[jJ]uillet$/", $arr[2]))
		$nb = 1;
	if (preg_match("/^[aA]out$/", $arr[2]))
		$nb = 1;
	if (preg_match("/^[sS]eptembre$/", $arr[2]))
		$nb = 1;
	if (preg_match("/^[oO]ctobre$/", $arr[2]))
		$nb = 1;
	if (preg_match("/^[nN]ovembre$/", $arr[2]))
		$nb = 1;
	if (preg_match("/^[dD][ée]cembre$/", $arr[2]))
		$nb = 1;
	if ($nb == 0)
	{
		echo "Wrong Format\n";
		exit();
	}
	if (preg_match("/^\d{4}$/", $arr[3]) == 0)
	{
		echo "Wrong Format\n";
		exit();
	}
	if (preg_match("/^\d{2}:\d{2}:\d{2}$/", $arr[4]) == 0)
	{
		echo "Wrong Format\n";
		exit();
	}
	$months = array(
		"01" => "janvier",
		"02" => "février",
		"02" => "fevrier",
		"03" => "mars",
		"04" => "avril",
		"05" => "mai",
		"06" => "juin",
		"07" => "juillet",
		"08" => "aout",
		"09" => "septembre",
		"10" => "octobre",
		"11" => "novembre",
		"12" => "décembre",
		"12" => "decembre",
	);
	foreach ($months as $key => $value)
	{
		if (strcasecmp($value, $arr[2]) == 0)
			$month = $key;
	}
	if (strlen($arr[1]) == 1)
		$day = "0".$arr[1];
	else
		$day = $arr[1];
	if (checkdate($month, $day, $arr[3]))
	{
		$date = $arr[3].":".$month.":".$day." ".$arr[4];
		$time = strtotime($date);
		if ($time)
			echo "$time\n";

	}
	else
	{
		echo "Wrong Format\n"; // ???
		exit();
	}
}
?>