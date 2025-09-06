<?php 
// Start session
session_start();

// Includes
require('private/core/init.php');

// Variables
$imgsLimit = 20;

// Ceate new class with db connection and queries
// Get User db
$user = new PublicUser;

// Get Image db
$image = new Img;

// Get Profile db
$profiles = new Profiles;

// GET
$user_nikname = $_GET['user'] ?? '';

$user_id = $user->getPublicUserByNikname($user_nikname)[0]->user_id;

// Create template
$template = new Template('templates/user.php');

// Assign Variables
$template->publicUser = $user->getPublicUserByNikname($user_nikname);
$template->userId = $user_id;
$template->userBgImg = $user->getRandomUserImage($user_id);
$template->images = $image->getLimitImages(0, $imgsLimit);
$template->user_images = $image->getImagesByUserId($user_id);
$template->profiles = $profiles->getAllProfilesById($user_id);
$template->allLikes = $image->getAllImagesLikesByUserId($user_id);
$template->allDownloads = $image->getAllImagesDownloadsByUserId($user_id);
$template->contributors = $user->getNumberOfRandomContributors(5, $user_id);


// Print HTML
echo $template;
