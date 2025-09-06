<?php 
// Start session
session_start();

// Includes
require('private/core/init.php');

// Create template
$template = new Template('templates/license.php');

// Print HTML
echo $template;