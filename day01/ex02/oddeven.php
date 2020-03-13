#!/usr/bin/php
<?php
while (1)
{
	echo ("Enter a number: ");
	$num = fgets(STDIN);
	$num = substr($num, 0, strlen($num) - 1);
	if (feof(STDIN))
	{
		echo "\n";
		exit();
	}
	if (is_numeric($num))
	{
		if (substr($num, -1) % 2 == 0)
			echo ("The number $num is even\n");
		else
			echo ("The number $num is odd\n");
	}
	else
		echo ("'$num' is not a number\n");
}
?>