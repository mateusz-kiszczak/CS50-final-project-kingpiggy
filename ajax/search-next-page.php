<?php
// Get config file
require('../private/config/config.php');
require('../private/helpers/helpers.php');
require('../private/helpers/sql.php');

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

     $search_query = isset($_GET['search']) ? $_GET['search'] : '';
     $page_query = isset($_GET['page']) ? $_GET['page'] + 1 : '';
     $sort_query = isset($_GET['sort']) ? $_GET['sort'] : '';
     $type_query = isset($_GET['type']) ? $_GET['type'] : '';
     $orientation_query = isset($_GET['orientation']) ? $_GET['orientation'] : '';

     $total_results = isset($_GET['total_results']) ? $_GET['total_results'] : '';
     
     $total_pages = '';

	 $image_collection = '';


    $response = ['redirectUrl' => 'index.php']; 
    echo json_encode($response);
 }