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
$img = new Img;

// Get user nikname from SESSION
$user_nikname = $_SESSION['username'];
// User current image updates allowance
$user_current_allowance = $privateUser->getAllPrivateUserByNikname($_SESSION['username'])[0]->user_allowance;
$user_uploaded_images = $privateUser->getAllPrivateUserByNikname($_SESSION['username'])[0]->user_images_uploaded;
// Declare arrays
$inputs = [];
$errors = [];


/*
** HANDLE POST
*/

// If POST sanitize and validate inputs
if (is_post_request()) 
{
	$fields_sanitize = 
	[
		'image-to-upload' => 'url',
		'name' => 'string',
		'camera-type' => 'string',
		'camera-model' => 'string',
		'country' => 'string',
		'city' => 'string',
		'place' => 'string',
		'tags' => 'string',
		'description' => 'string'
  	];

	$fields_validate = 
	[
		// 'image-to-upload' => 'required',
		'name' => 'required | between: 3,255 | forbiddenWord: profane_words, profane_words_word | forbiddenPhrase: profane_phrases, profane_phrases_phrase',
		'camera-type' => 'required',
		'camera-model' => 'required | between: 2,255 | forbiddenWord: profane_words, profane_words_word | forbiddenPhrase: profane_phrases, profane_phrases_phrase',
		'country' => 'between: 0,64 | forbiddenWord: profane_words, profane_words_word | forbiddenPhrase: profane_phrases, profane_phrases_phrase',
		'city' => 'between: 0,64 | forbiddenWord: profane_words, profane_words_word | forbiddenPhrase: profane_phrases, profane_phrases_phrase',
		'place' => 'between: 0,128 | forbiddenWord: profane_words, profane_words_word | forbiddenPhrase: profane_phrases, profane_phrases_phrase',
		'tags' => 'required | tag',
		'description' => 'between: 0,500 | forbiddenWord: profane_words, profane_words_word | forbiddenPhrase: profane_phrases, profane_phrases_phrase',
  	];

 	$inputs = sanitize($_POST, $fields_sanitize);
 	$errors = validate($_POST, $fields_validate);


	if ($errors) 
	{
		redirect_with('upload-image.php?username=' . $_SESSION['username'], [
			'inputs' => $inputs,
			'errors' => $errors
	 	]);
	}

 	if ($user_uploaded_images >= $user_current_allowance) 
	{
		// Add error
		$errors['image-to-upload'] = "You can not upload more images. Contact us to extend your allowance.";
		
	 	// Redirect with error message
	 	redirect_with('upload-image.php?username=' . $_SESSION['username'], [
			'inputs' => $inputs,
			'errors' => $errors
	 	]);
	}

  	if (!$errors && $inputs) 
	{
		// Thumbnail diorectory
		$thumbnail_dir = 'images/thumbnails/';

		// Uploaded image directory
		$target_dir = 'images/images/';

		// Get image extention
		$image = strtolower($_FILES["image-to-upload"]["name"]);
		$image_extention = strtolower(pathinfo($image, PATHINFO_EXTENSION));
		$image_no_extention = strtolower(pathinfo($image, PATHINFO_FILENAME));

		// Uploaded image path. Image name is an user input -> name (image title - formated)
		$image_name_no_extention = prepare_img_file_name($inputs['name']);
		$image_name = basename($image_name_no_extention . '.' . $image_extention);
		$image = $target_dir . $image_name;

		// Prepare upload for later
		$upload_ok = 1;

		// Check if image is an actual image or fake image
	  	$check_image = getimagesize($_FILES["image-to-upload"]["tmp_name"]);
	
	  	if ($check_image !== false) 
		{
			$upload_ok = 1;
	  	} 
		else 
		{
			// Add error
			$errors['image-to-upload'] = 'File is not an image';
			
			// Redirect with error message
			redirect_with('upload-image.php?username=' . $_SESSION['username'], [
		  		'inputs' => $inputs,
		  		'errors' => $errors
			]);
	  
			$upload_ok = 0;
	  	}

		// Check file size
		if ($_FILES["image-to-upload"]["size"] > 20000000) 
		{
	  		// Add error
	  		$errors['image-to-upload'] = "Your file is too large. Max availible size is 20 MB";
	
	 		// Redirect with error message
	 		redirect_with('upload-image.php?username=' . $_SESSION['username'], [
				'inputs' => $inputs,
				'errors' => $errors
	  		]);
	
	  		$upload_ok = 0;
		}

		// Allow certain file formats
		if($image_extention != "jpg" && $image_extention != "png" && $image_extention != "jpeg"
		&& $image_extention != "gif" && $image_extention != "webp" && $image_extention != "bmp" ) 
		{
	  		// Add error
	  		$errors['image-to-upload'] = "Sorry, only JPG, JPEG, PNG, GIF & WEBP files are allowed.";
	
	  		// Redirect with error message
	  		redirect_with('upload-image.php?username=' . $_SESSION['username'], [
				'inputs' => $inputs,
				'errors' => $errors
	  		]);
	
	  		$upload_ok = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($upload_ok == 0) 
		{
	  		// Add error
	  		$errors['image-to-upload'] = "Sorry, your file was not uploaded.";
	
	  		// Redirect with error message
	  		redirect_with('upload-image.php?username=' . $_SESSION['username'], [
				'inputs' => $inputs,
				'errors' => $errors
	  		]);
	
		} 
		// if everything is ok, check for a files with the same name to aviod duplications
		else 
		{
			// Check if an image with this name already axists
	  		// Get all the image files.
	  		$existing_images = scandir($_SERVER['DOCUMENT_ROOT'] . '/' . $target_dir);

	  		// Does it have an image with the same name
	  		$same_name_image = 0;

	  		// Loop throu the images to find if the is an image with same name
	  		foreach ($existing_images as $existing_imgage) 
	  		{
				// If have same name file already
				if ($image_name === $existing_imgage) 
				{
		  			// Get current date and time without special characters
		  			$current_datetime = date('YmdHis');
		  
		  			// Combine an image file name with datetime - UPDATE IMAGE
		  			$image_name_no_extention = $image_name_no_extention . '_' . $current_datetime;
		  			$image = $target_dir . $image_name_no_extention . '.' . $image_extention;
				}
	  		}
	
	  		// Upload image to destination
	  		if (move_uploaded_file($_FILES["image-to-upload"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/" . $image)) 
			{

				// Create thumbnail.
				$thumbnail_source = $_SERVER['DOCUMENT_ROOT'] . "/" . $image;
				$thumbnail_destination = $_SERVER['DOCUMENT_ROOT'] . "/" . $thumbnail_dir . $image_name_no_extention . ".webp";

				reduce_image_size(source: $thumbnail_source, destination: $thumbnail_destination, max: 600, convert_to_webp: true, quality: 70, remove_source: false);
		
				// Update database
				// Update Image info
				$imgName = $inputs['name'];
				$imgExt = $image_extention;
				$imgUrl = $image;
				$imgThumbUrl = $thumbnail_dir . $image_name_no_extention . ".webp";
				$imgHeight = get_image_height($thumbnail_source);
				$imgWidth = get_image_width($thumbnail_source);
				$imgRatio = get_image_ratio_fraction($thumbnail_source);
				$imgOrient = get_image_orientation($thumbnail_source);
				$imgCamType = $inputs['camera-type'];
				$imgCamName = $inputs['camera-model'];
				$imgLocation = set_image_location(array($inputs['country'], $inputs['city'], $inputs['place']));
				$imgDescription = $inputs['description'];
				$imgTags = tags_array_to_db_string(user_input_tags_to_array($inputs['tags']));
				$userId = $_SESSION['user_id'];

				$img->uploadImage($imgName, $imgExt, $imgUrl, $imgThumbUrl, $imgHeight, $imgWidth, $imgRatio, $imgOrient, $imgCamType, $imgCamName, $imgLocation, $imgDescription, $imgTags, $userId);

				// Update User Info
				$privateUser->updateLastActivity($_SESSION['username']);
				$privateUser->updateUploadedImagesNumber($user_uploaded_images + 1, $_SESSION['username']);
	  
				// Clear cache
				clearstatcache();
	  
				redirect_with_message(
		 		'upload-image.php?username=' . $_SESSION['username'],
		 		'Your image has been uploaded!'
				);
	  		} 
			else 
			{
				// Add error
				$errors['image-to-upload'] = "Sorry, there was an error uploading your file.";
	  
				// Redirect with error message
				redirect_with('upload-image.php?username=' . $_SESSION['username'], [
		  			'inputs' => $inputs,
		  			'errors' => $errors
				]);
	  		}
		}
  	}

} 
else if (is_get_request()) 
{
	[$inputs, $errors] = session_flash('inputs', 'errors');
}

// Create template
$template = new Template('../templates/user_dashboard/upload-image.php');

// Assign Variables
$template->privateUser = $privateUser->getAllPrivateUserByNikname($user_nikname);

// Assign Variables
$template->inputs = $inputs;
$template->errors = $errors;

// // Print HTML
echo $template;
