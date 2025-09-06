<?php 
// Start session
session_start();

// Includes
require('private/core/init.php');

// Create template
$template = new Template('templates/terms-and-conditions.php');

// Print HTML
echo $template;
