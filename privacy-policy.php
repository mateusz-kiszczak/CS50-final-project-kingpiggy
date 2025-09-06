<?php 
// Start session
session_start();

// Includes
require('private/core/init.php');

// Create template
$template = new Template('templates/privacy-policy.php');

// Print HTML
echo $template;