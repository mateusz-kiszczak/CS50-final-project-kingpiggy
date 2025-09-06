<?php
// Start session
session_start();
phpinfo();
// Includes
require('private/core/init.php');
require('private/helpers/helpers.php');

// Variables
$imgsLimit = 20;

// Ceate new class with db connection and queries
$image = new Img;
$user = new PublicUser;


// Create template
$template = new Template('templates/index.php');

// Assign Variables
if (isset($_GET['sort']) && $_GET['sort'] === 'latest')
{
    $template->images = $image->getLimitImagesSortByDate($imgsLimit, 0);
}
elseif (isset($_GET['sort']) && $_GET['sort'] === 'random')
{   
    $template->images = $image->getLimitImagesRandom($imgsLimit, 0);
}
else
{
    $template->images = $image->getLimitImages($imgsLimit, 0);
}

$template->imgs_limit = $imgsLimit;


// Handle input search on submit
if (is_get_request() && isset($_GET['search']))
{
    redirect('./search.php?search=' . urlencode($_GET['search']));
}


// Print HTML
echo $template;
