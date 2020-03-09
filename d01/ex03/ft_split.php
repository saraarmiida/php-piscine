<?php

function ft_split($str)
{
	$arr = explode(" ", $str);
	$arr = array_filter($arr);
	sort($arr);
	return ($arr);
}
?>