<?php

function ft_is_sort($arr)
{
	$tmp = sort($arr);
	if ($tmp == $arr)
		return (true);
	else
		return (false);
}
?>