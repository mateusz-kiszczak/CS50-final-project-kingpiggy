<?php 
// Start session
session_start();

// If no user set, redirect to home page
if (!isset($_SESSION['username'])) 
{
    redirect('../../index.php');
} 

// Get config file
require('../../private/config/config.php');

// Autoloaded Classes
spl_autoload_register(function ($class_name) {
	include '../../private/libraries/' . $class_name . '.php';
});

// Includes
include('../../private/helpers/helpers.php');


// Ceate new class with db connection and queries
// Get Profiles db
$comment = new Comment;
$img = new Img;
$privateUser = new PrivateUser;

if (is_post_request() && isset($_GET['image_id'])) 
{
    $image_id = urlencode($_GET['image_id']);
    $get_image = $img->getImage($image_id)[0];
    $private_user = $privateUser->getAllPrivateUserByNikname($_SESSION['username'])[0];

    // Remove image file
    $image_url = $_SERVER['DOCUMENT_ROOT'] . '/' . $get_image->image_url;
    $image_thumbnail_img = $_SERVER['DOCUMENT_ROOT'] . '/' . $get_image->image_thumbnail_url;

    if (file_exists($image_url) && file_exists($image_thumbnail_img))
    {
        unlink($image_url);
        unlink($image_thumbnail_img);
    }
    else 
    {
        redirect_with_message(
            '../my-images.php?user=' . $_SESSION['username'],
            'Image could NOT be deleted!'
        );
    }

    // Delete all comments about image
    $comment->deleteCommentByImgId($image_id);

    // Delate image db
    $img->deleteImgById($image_id);

    // Decrease uploaded images in user db
    $current_uploads = $private_user->user_images_uploaded;
    $new_uploads = $current_uploads > 0 ? $current_uploads - 1 : 0;

    $privateUser->updateUploadedImagesNumber($new_uploads, $_SESSION['username']);
    
    redirect_with_message(
        '../my-images.php?user=' . $_SESSION['username'],
        'You deleted the image!'
  );
}
else if (is_get_request()) 
{
    redirect_with_message(
        '../my-images.php?user=' . $_SESSION['username'],
        'Image could NOT be deleted!'
    );
}