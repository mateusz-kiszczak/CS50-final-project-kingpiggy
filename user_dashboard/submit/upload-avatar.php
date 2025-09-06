<?php 
// Start session
session_start();

// If no user set, redirect to home page
if (!isset($_SESSION['username'])) 
{
	redirect('../index.php');
}

// Get config file
require('../../private/config/config.php');

// Autoloaded Classes
spl_autoload_register(function ($class_name) {
	include '../../private/libraries/' . $class_name . '.php';
});

// Includes
include('../../private/helpers/helpers.php');
include('../../private/helpers/sql.php');

// Ceate new class with db connection and queries
// Get Private User db

$privateUser = new PrivateUser;

// Get user nikname from SESSION
$user_nikname = $_SESSION['username'];


// Declare arrays
$errors = [];


// Temp diorectory
$temp_dir = 'images/avatars/temp/';

// Uploaded image directory
$target_dir = 'images/avatars/';

// Get image extention
$image = strtolower($_FILES["file-to-upload"]["name"]);
$image_extention = strtolower(pathinfo($image, PATHINFO_EXTENSION));

// Uploaded image path. Image name is username
$image = $target_dir . basename($_SESSION['username'] . '.' . $image_extention);

// Prepare upload for later
$upload_ok = 1;

// Check if image is an actual image or fake image
if (is_post_request()) 
{
	$check_image = getimagesize($_FILES["file-to-upload"]["tmp_name"]);

	if ($check_image !== false) 
	{
		$upload_ok = 1;
	} 
	else 
	{
		// Add error
		$errors['file-to-upload'] = 'File is not an image';

		// Redirect with error message
		redirect_with('../edit-profile.php?user=' . $_SESSION['username'], [
			'errors' => $errors
		]);

		$upload_ok = 0;
	}
}

// Check file size
if ($_FILES["file-to-upload"]["size"] > 20000000) 
{
	// Add error
	$errors['file-to-upload'] = "Your file is too large. Max availible size is 20 MB";

	// Redirect with error message
	redirect_with('../edit-profile.php?user=' . $_SESSION['username'], [
		'errors' => $errors
	]);

	$upload_ok = 0;
}

// Allow certain file formats
if($image_extention != "jpg" && $image_extention != "png" && $image_extention != "jpeg"
&& $image_extention != "gif" && $image_extention != "webp" && $image_extention != "bmp" ) 
{
	// Add error
	$errors['file-to-upload'] = "Sorry, only JPG, JPEG, PNG, GIF & WEBP files are allowed.";

	// Redirect with error message
	redirect_with('../edit-profile.php?user=' . $_SESSION['username'], [
		'errors' => $errors
	]);

	$upload_ok = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($upload_ok == 0) 
{
	// Add error
	$errors['file-to-upload'] = "Sorry, your file was not uploaded.";

	// Redirect with error message
	redirect_with('../edit-profile.php?user=' . $_SESSION['username'], [
		'errors' => $errors
	]);

// if everything is ok, try to upload file
} 
else 
{
	// Remove the previous avatar.
	$existing_avatars = scandir($_SERVER['DOCUMENT_ROOT'] . '/' . $target_dir);

	foreach ($existing_avatars as $avatar) 
	{
		if (pathinfo($avatar, PATHINFO_FILENAME) === $_SESSION['username']) 
		{
			$existing_avatar_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $target_dir . '/' . $avatar;
			
			// Remove avatar
			// If cannot remove an avatar show error message
			if (!unlink($existing_avatar_path)) 
			{

				// Add error
				$errors['file-to-upload'] = "Error updating the avatar";

				// Redirect with error message
				redirect_with('../edit-profile.php?user=' . $_SESSION['username'], [
					'errors' => $errors
				]);
			}
		}
	}

	// Upload file to a temp folder
	if (move_uploaded_file($_FILES["file-to-upload"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/" . $temp_dir . basename($_SESSION['username'] . '.' . $image_extention))) 
	{

		// Resize the avatar.
		$reduce_sopurce = $_SERVER['DOCUMENT_ROOT'] . "/" . $temp_dir . basename($_SESSION['username'] . '.' . $image_extention);
		$reduce_destination = $_SERVER['DOCUMENT_ROOT'] . "/" . $image;
		reduce_image_size($reduce_sopurce, $reduce_destination, 300);

		// Update database - user avatar file name
		$privateUser->updateAvatar(basename($_SESSION['username'] . '.' . $image_extention), $user_nikname);

		// Update session avatar
		$_SESSION['user_avatar'] = $privateUser->getAllPrivateUserByNikname($user_nikname)[0]->user_avatar_url;

		// Clear cache
		clearstatcache();

		redirect_with_message(
			'../edit-profile.php?user=' . $_SESSION['username'],
			'Your avatar has been updated!'
		);
	} 
	else 
	{
		// Add error
		$errors['file-to-upload'] = "Sorry, there was an error uploading your file.";

		// Redirect with error message
		redirect_with('../edit-profile.php?user=' . $_SESSION['username'], [
			'errors' => $errors
		]);
	}
}
