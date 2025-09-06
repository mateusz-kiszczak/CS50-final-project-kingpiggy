<?php

// Get config file
require('../private/config/config.php');

// Autoloaded Classes
spl_autoload_register(function ($class_name) {
	include '../private/libraries/' . $class_name . '.php';
});

// Ceate new class with db connection and queries
$image = new Img;

/**
 *     HANDLE POST 
 **/

 if(isset($_GET['load_img_offset']) && isset($_GET['load_img_limit']))
 {   
	 $load_img_limit = intval($_GET['load_img_limit']);
	 $load_img_offset = intval($_GET['load_img_offset']);

	 $image_collection = '';

	 if (isset($_GET['sort']) && $_GET['sort'] === 'latest')
	 {
		$images_collection = $image->getLimitImagesSortByDate($load_img_limit, $load_img_offset);
	 }
	 elseif (isset($_GET['sort']) && $_GET['sort'] === 'random')
	 {
		$images_collection = $image->getLimitImagesRandom($load_img_limit, $load_img_offset);
	 }
	 else 
	 {
		$images_collection = $image->getLimitImages($load_img_limit, $load_img_offset);
	 }
	 
	
	 header('Content-Type: application/json');
	 echo json_encode($images_collection);
	 exit();
 }
 