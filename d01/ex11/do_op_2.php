#!/usr/bin/php
<?php

if ($argc == 2)
{
	$i = 0;
	$str = str_replace(" ", "", $argv[1]);
	$num1 = intval($str);
	$operator = substr(substr($str, strlen((string)$num1)), 0, 1);
	$num2 = substr(substr($str, strlen((string)$num1)), 1);
	if (!(is_numeric($num1)) || !(is_numeric($num2)) || !(strstr("+-*/%", "$operator")))
	{
		echo "Syntax Error\n";
		exit();
	}
	if ($operator == "+")
		echo $num1 + $num2."\n";
	if ($operator == "-")
		echo $num1 - $num2."\n";
	if ($operator == "*")
		echo $num1 * $num2."\n";
	if ($operator == "/")
		echo $num1 / $num2."\n";
	if ($operator == "%")
		echo $num1 % $num2."\n";
}
else
	echo "Incorrect Parameters\n";
?>