<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_ALL);
ini_set('display_errors', 'On');
ini_set("memory_limit","2048");

$temp = "converted.jpg";
$source = "/home/mkadam_admin/Documents/DSCN9126.JPG";
$destination = "/home/mkadam_admin/Documents/resized/".$temp;


//print_r(getimagesize($source));
//mkdir("/home/mkadam_admin/Documents/resized",0777);

$image = imagecreatefromjpeg($source);

//echo $source;
echo imagejpeg($image,$destination,90);
?>
