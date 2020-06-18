<?php
function ft_split($str)
{
	$str = preg_replace("/ +/", " ", trim($str));
	$arr = explode(" ", $str);
	sort($arr);
	return ($arr);
}
?>