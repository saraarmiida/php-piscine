#!/usr/bin/php
<?php
if ($argc == 2)
{
	$folder = rtrim($argv[1], "/");
	$ch = curl_init($argv[1]);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	$arr = array();
	preg_match_all('/<img src="(.*?.jpg)".*?>/', $data, $matches);
	$arr = array_merge($arr, $matches[1]);
	preg_match_all('/<img src="(.*?.svg)".*?>/', $data, $matches);
	$arr = array_merge($arr, $matches[1]);
	preg_match_all('/<img src="(.*?.png)".*?>/', $data, $matches);
	$arr = array_merge($arr, $matches[1]);
	preg_match_all('/<img src="(.*?.jpeg)".*?>/', $data, $matches);
	$arr = array_merge($arr, $matches[1]);
	preg_match_all('/<img src="(.*?.gif)".*?>/', $data, $matches);
	$arr = array_merge($arr, $matches[1]);
	$i = 1;
	if ($arr[0])
	{
		$foldername = strchr($argv[1], "w");
		if (preg_match('/\//', $foldername))
		{
			$pos = strpos($foldername, "/")."\n";
			$foldername = substr($foldername, 0, $pos - strlen($foldername));
		}
		mkdir($foldername);
	}
	foreach ($arr as $imagepath)
	{
		if (strncmp("//", $imagepath, 2) == 0)
			$imagepath = "https:".$imagepath;
		if (strncmp("https://", $imagepath, 8))
			$imagepath = $folder.$imagepath;
		$imagename = trim(strrchr($imagepath, "/"), "/");
		$image = file_get_contents($imagepath);
		if ($image)
		{
			file_put_contents($foldername."/".$imagename, $image);
		}
		$i++;
	}
	curl_close($ch);
}
?>