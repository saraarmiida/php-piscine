#!/usr/bin/php
<?PHP
// include("ft_split.php");
// print_r(ft_split("Hello    World AAA"));
include("ft_is_sort.php");
// $tab = array("!/@#;^", "42", "hi", "Hello World", "zZzZzZz");
// $tab[] = "What are we doing now ?";
// $tab = array("0", "2", "9");
// print_r($tab);
// sort($tab);
// print_r($tab);
// $tab = array("b", "c");
if (ft_is_sort($tab))
echo "The array is sorted\n";
else
echo "The array is not sorted\n";
?>