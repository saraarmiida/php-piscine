<?php
function ft_is_sort($arr)
{
	$tmp = $arr;
	$tmp2 = $arr;
	sort($tmp);
	if ($tmp == $arr)
		return (true);
	else
		return (false);
}
?>