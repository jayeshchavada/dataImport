<?php
//////////////////////////////////

// error_reporting(E_ALL | E_STRICT);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 'On');
ini_set("memory_limit","3072M");
ini_set('max_execution_time', 6000);

//////////////////////////////////

$lastPhotoDate = "2017-06-16";
$lastPhotoDate = strtotime($lastPhotoDate);
// echo $lastPhotoDate;exit;

$folderpath  =	"/var/www/html/myfolder";
// $dest 	=	"/var/www/html/myfolder/79c6909e580d33d2b01559229e6a15d5.jpg";


@chmod($folderpath,0777);

// $status = copy($folderpath,$dest);
// echo $status;exit;

$folders = glob("$folderpath/*",GLOB_BRACE);


foreach ($folders as $key => $eachfolderfiles)
{
	$image_data = glob("$eachfolderfiles/*");

	foreach ($image_data as $keys => $pics) {

		if(filemtime($pics) > $lastPhotoDate)
		{
			$NewPath = str_replace("myfolder","NewAddedPhotos",$pics);

			$picname = explode("/",$NewPath);

			$Destfilename = end($picname);

			$DestFolderPath = str_replace($Destfilename,'',$NewPath);

			@mkdir($DestFolderPath,0777,true);

			if(!file_exists($NewPath))
			{
				if(copy($pics,$NewPath)){
					
					echo "<pre>";
					print_r("Success");
					echo "</pre>";
				}
			}
		}
	}
}