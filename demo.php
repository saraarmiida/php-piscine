#!/usr/bin/php
<?php

/*			Regular expressions, video 1 */
$nb = preg_match("/t[oi]t[oi]$/", "akehgtoti");
// echo "$nb\n";

/* 			Variable variable, video 2 */
// $name = "key";
// $$name = "val";
// echo "$key\n";

/* 			Files, video 3 */
// $tab = file("data.csv");
// foreach ($tab as $elem)
// {
// 	echo $elem."\n";
// }
// file_get_contents reads entire file into a string
// fopen returns a "file descriptor" pointer, fgets reads one line from opened file
// fgetscsv fgets + explode

/* 			Eval, video 4 */
// eval("echo 'Hello World\n';");
// useful for when you get php commands that you dont know beforehand
// be cautious when using

/*			===, video 5 */
// if (0 === "World")
// 	echo "OK\n";
// else
// 	echo "KO\n";

// $mytab = array("yksi", "kaksi", "kolme");
// if (array_search("yksi", $mytab) !== FALSE)
// will do an additional check wich == doesnt do
// returns a boolen instead in cases where it would return a index for example

/*			Curl, video 6*/
$c = curl_init("https://www.42.fr/");
$str = curl_exec($c);
echo $str;

?>