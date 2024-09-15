<?php

$root = trim($_SERVER['APP_DOMAIN'], "/");



function route($route = null)

{

	global $root;

	$route = trim($route, "/");

	return ($route == null) ? $root : $root . "/" . $route;

}



function asset($asset)

{

	global $root;

	$asset = trim($asset, "/");

	return "{$root}/views/assets/{$asset}";

}



function upload($path)

{

	$path = trim($path, "/");



	$parts = explode("/", $path);

	$recursivePath = array();

	$dir = trim($_SERVER["UPLOAD_FOLDER"], "/");

	$fullPath = null;



	if (!file_exists("views/assets/{$dir}")) 

	{

		mkdir("views/assets/{$dir}", $_SERVER["FOLDER_PERMISSION"]);

	}



	foreach($parts as $part)

	{

		array_push($recursivePath, $part);

		$currentPath = implode("/", $recursivePath);

		$fullPath = "views/assets/{$dir}/{$currentPath}";

		

		if (!file_exists($fullPath)) 

		{

			mkdir($fullPath, $_SERVER["FOLDER_PERMISSION"]);

		}

	}



	return !is_null($fullPath) ? trim($fullPath, "/")."/" : null;

}



function uploadedFile($path)

{

	global $root;

	$path = trim($path, "/")."/";

	$dir = trim($_SERVER["UPLOAD_FOLDER"], "/");



	$relativePath = "views/assets/{$dir}/{$path}";

	$fullPath = "{$root}/views/assets/{$dir}";

	

	if(file_exists($relativePath) && !is_dir($relativePath)) 

	{

		return "{$fullPath}/{$path}";

	}

	return null;

}



function redirect(String $url, int $code = 301)

{

	header("Location: ". $url, true, $code);        

	exit();

}



function slug($string)

{

	$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';

	$b = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';	

	$string = utf8_decode($string);

	$string = strtr($string, utf8_decode($a), $b);

	$string = strip_tags(trim($string));

	$string = str_replace(" ","-",$string);

	$string = str_replace(array("-----","----","---","--"),"-",$string);

	return strtolower(utf8_encode($string));

}



function slugWithUnderscore($string)

{

	$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';

	$b = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';	

	$string = utf8_decode($string);

	$string = strtr($string, utf8_decode($a), $b);

	$string = strip_tags(trim($string));

	$string = str_replace(" ","_",$string);

	$string = str_replace(array("_____","____","___","__"),"_",$string);

	return strtolower(utf8_encode($string));

}



function resume($string, $words = '200')

{

	$string 	= trim(strip_tags($string));

	$count		= strlen($string);	

	

	if($count <= $words){

		return $string;	

	}else{

		$strpos = strrpos(substr($string,0,$words),' ');

		return trim(substr($string,0,$strpos)).'...';

	}		

}



function saveThumbnail($saveToDir, $imagePath, $imageName, $max_x, $max_y) {

	preg_match("'^(.*)\.(gif|jpeg|jpg|png)$'i", $imageName, $ext);

	switch (strtolower($ext[2])) {

		case 'jpg' :

					 $im   = imagecreatefromjpeg ($imagePath);

					 break;

		case 'jpeg': $im   = imagecreatefromjpeg ($imagePath);

					 break;

		case 'gif' : $im   = imagecreatefromgif  ($imagePath);

					 break;

		case 'png' : $im   = imagecreatefrompng  ($imagePath);

					 break;

		default    : $stop = true;

					 break;

	}

   

	if (!isset($stop)) {

		$x = imagesx($im);

		$y = imagesy($im);

   

		if (($max_x/$max_y) < ($x/$y)) {

			$save = imagecreatetruecolor($x/($x/$max_x), $y/($x/$max_x));

		}

		else {

			$save = imagecreatetruecolor($x/($y/$max_y), $y/($y/$max_y));

		}

		imagecopyresized($save, $im, 0, 0, 0, 0, imagesx($save), imagesy($save), $x, $y);

	   

		imagejpeg($save, "{$saveToDir}{$imageName}");

		imagedestroy($im);

		imagedestroy($save);

		

		return true;

	}

	

	return false;

}



function selectedOption($key, $value)

{

	if($key == $value)

		return 'selected="selected"';

}

function bytesToSize($bytes, $unit = null) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

    if ($unit && !in_array($unit, $units)) {
        return "Invalid unit specified";
    }

    $unitIndex = array_search($unit, $units);

    if ($unitIndex === false) {
        $unitIndex = floor(log($bytes, 1024));
    }

    return number_format($bytes / pow(1024, $unitIndex), 2) . ' ' . $units[$unitIndex];
}

function loanStatus($status) {
	$loanstatus = [
		"PENDING" => "Pendente",
		"APPROVED" => "Aprovado",
		"DISBURSED" => "Desembolsado",
		"AWAITING_DISBURSEMENT" => "Aguarda desembolso",
		"CANCELLED" => "Cancelado",
		"REJECTED" => "Rejeitado"
	];
	
	return $loanstatus[strtoupper($status)];
}

function loanStatusColor($status) {
	$loanstatus = [
		"PENDING" => "bg-warning text-dark",
		"APPROVED" => "bg-info text-dark",
		"DISBURSED" => "bg-success",
		"AWAITING_DISBURSEMENT" => "bg-info text-dark",
		"CANCELLED" => "bg-danger",
		"REJECTED" => "bg-danger"
	];
	
	return $loanstatus[strtoupper($status)];
}

function generateThumbnail($pdfUrl) {
	// Load the Imagick extension
	$imagick = new \Imagick();

	// Firestore Storage download URL

	// Download the PDF to a temporary file
	$tempPdf = tempnam(sys_get_temp_dir(), 'pdf');
	file_put_contents($tempPdf, file_get_contents($pdfUrl));

	// Read the first page of the PDF
	$imagick->readImage($tempPdf.'[0]');

	// Set the image format to jpg
	$imagick->setImageFormat('jpg');

	// Set the image resolution
	$imagick->setResolution(150, 150);

	// Generate a thumbnail (change 200 to the desired width)
	$imagick->thumbnailImage(200, 0);

	// Output the thumbnail to the browser
	header("Content-Type: image/jpeg");
	echo $imagick;

	// Clean up
	unlink($tempPdf);
	$imagick->clear();
	$imagick->destroy();
}