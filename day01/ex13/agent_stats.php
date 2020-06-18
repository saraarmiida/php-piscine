#!/usr/bin/php
<?php

if ($argc != 2)
	return (0);
$arr = file("php://stdin"); // reading file from stdin to an array
unset($arr[0]);
if ($argv[1] == "average")
{
	$i = 0; // to keep track of how many grades have been given
	$sum = 0; // adding all grades to this as a sum
	foreach ($arr as $line)
	{
		$line = explode(";", $line); // making an array of each line of the file to be able to access for example grade and user
		if ($line[1] != "" && $line[2] != "moulinette") // checking if there actually is a grade given, and that it's not given by moulinette
		{
			$sum += intval($line[1]); // adding grade to the sum of all grades
			$i++; // keeping track of how many grades there are
		}
	}
	if ($i > 0)
		echo $sum / $i."\n"; // printing out the average grade
}
elseif ($argv[1] == "average_user")
{
	$list = array();
	foreach ($arr as $line) // making a list of all users from the file
	{
		$line = explode(";", $line);
		$list[$line[0]] = 0; // saving only the username for now
	}
	ksort($list); // sorting the list
	foreach ($list as $user => $value) // going through the list of users, not sure why i have the $value there, since i dont use it, probably left it there by accident
	{
		$sum = 0;
		$count = 0;
		foreach ($arr as $elem) // with each user, i go through the original file and make a sum of grades given to them just like in the "average" option
		{
			$elem = explode(";", $elem);
			if ($elem[0] == $user && $elem[1] != "" && $elem[2] != "moulinette") // again making sure there is a grade and it's not from moulinette
			{
				$sum += $elem[1];
				$count++;
			}
		}
		if ($count > 0)
			echo $user.":".$sum / $count."\n";
	}
}
elseif ($argv[1] == "moulinette_variance")
{
	$list = array();
	foreach ($arr as $line) // same as in average_user
	{
		$line = explode(";", $line);
		$list[$line[0]] = 0;
	}
	ksort($list);
	foreach ($list as $user => $value) // again, not sure why i have $value there
	{
		$sum = 0;
		$count = 0;
		$mouli = 0;
		foreach ($arr as $elem) // exactly the same as with average_user, but i also save how moulinette graded them
		{
			$elem = explode(";", $elem);
			if ($elem[0] == $user && $elem[1] != "" && $elem[2] != "moulinette")
			{
				$sum += $elem[1];
				$count++;
			}
			if ($elem[0] == $user && $elem[1] != "" && $elem[2] == "moulinette")
			{
				$mouli = $elem[1]; // the system is same as our evaluation system, so you have multiple peer grades and only one grade by moulinette
			}
		}
		$res = ($sum / $count) - $mouli; // result is average of peer grades minus moulinette grade
		if ($count > 0)
			echo $user.":".$res."\n";
	}
}

?>