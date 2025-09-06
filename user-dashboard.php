<?php 
// Start session
session_start();

// Includes
require('private/core/init.php');
require('private/helpers/helpers.php');

// Ceate new class with db connection and queries
// Get Image db
$user = new PrivateUser();

// GET
$user_nikname = $_GET['user'] ?? '';
// $active_link = $_POST['activeLink'][0] ?? '';

// Create template
$template = new Template('templates/user-dashboard.php');

// Assign Variables
$template->privateUser = $user->getAllPrivateUserByNikname($user_nikname);


if ($_SESSION['username'] && $_SESSION['username'] === $user_nikname) {
  // Print HTML
  echo $template;
} else {
  redirect('index.php');
}
