<?php 
// Start session
session_start();

// Get config file
require('../private/config/config.php');

// Autoloaded Classes
spl_autoload_register(function ($class_name) {
  include '../private/libraries/' . $class_name . '.php';
});

// Includes
include('../private/helpers/helpers.php');
include('../private/helpers/sql.php');

// Ceate new class with db connection and queries
// Get Private User db

$privateUser = new PrivateUser;
$image = new Img;

// Get user nikname from SESSION
$user_nikname = $_SESSION['username'];


// // Create template
$template = new Template('../templates/user_dashboard/downloads.php');

// // Assign Variables
$template->privateUser = $privateUser->getAllPrivateUserByNikname($user_nikname);
$template->userLikesSaves = $privateUser->getUserLikesAndSaves($user_nikname);
$template->image = $image;

// // Print HTML
echo $template;
