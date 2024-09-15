<?php
namespace sprint\http\controllers;


class Thumbnail {	
	private $imagick;
	private $src;

	public function __construct($src) {
		$this->imagick = new \Imagick();
		$this->src = $src;
	}

	// Download the PDF to a temporary file
	$tempPdf = tempnam(sys_get_temp_dir(), 'pdf');
	file_put_contents($tempPdf, file_get_contents($this->src));

	// Read the first page of the PDF
	$this->imagick->readImage($tempPdf.'[0]');

	// Set the image format to jpg
	$this->imagick->setImageFormat('jpg');

	// Set the image resolution
	$this->imagick->setResolution(150, 150);

	// Generate a thumbnail (change 200 to the desired width)
	$this->imagick->thumbnailImage(200, 0);

	// Output the thumbnail to the browser
	header("Content-Type: image/jpeg");
	echo $this->imagick;

	// Clean up
	unlink($tempPdf);
	$this->imagick->clear();
	$this->imagick->destroy();
}

function generateThumbnail($src) {
	$thumbnail = new Thumbnail($src);
	
	return $thumbnail;
}