<?php 
// Start session
session_start();

// Includes
require('private/core/init.php');
include('private/helpers/helpers.php');
include('private/helpers/sql.php');

// Variables
$imgsLimit = 16;

// Ceate new class with db connection and queries
// Get Image db
$image = new Img;
// Get Comments db
$comments = new Comment;
// Get PrivateUser db
$privateUser = new PrivateUser;

// GET
$image_id = $_GET['image_id'] ?? '';

$image_details = $image->getImage($image_id);


/*
** HANDLE POST
** AJAX REQUESTS
*/

$post_image_id = isset($_POST['image_id']) ? $_POST['image_id'] : '';
$post_love_image = isset($_POST['love_it']) ? true : false;
$post_save_image = isset($_POST['save_it']) ? true : false;

if(is_post_request())
{   
	// Update downloads
	if ($post_image_id) 
	{
		$image->increaseDownloads($post_image_id);

		if (is_user_logged_in())
		{
			// Get current list of likes as string
			$downloads_db_str = $privateUser->getUserLikesAndSaves($_SESSION['username'])[0]->user_downloads;

			// Convert string to array
			$downloads_arr = db_str_to_arr($downloads_db_str);
		
			// Remove empty items from array
			$filtered_downloads_arr = array_filter($downloads_arr);
		
			// Reindex the array to ensure indexes are sequential
			$filtered_downloads_arr = array_values($filtered_downloads_arr);
		
			// Does current image id is inside the loves array
			$is_id_in_arr = is_inside_arr($filtered_downloads_arr, $image_id);

			// If current image id is not in the loves db
			if (!$is_id_in_arr)
			{
				// If array is smaller than 30
				if (count($filtered_downloads_arr) < 30)
				{	
					// Add new image id to the end of the array
					array_push($filtered_downloads_arr, $image_id);

					// Convert array to db string
					$new_downloads_db_str = arr_to_db_str($filtered_downloads_arr);

					// Add new values to db
					$privateUser->updateUserDownloads($new_downloads_db_str ,$_SESSION['user_id']);
				}
				// Else if array has 30 items, remove the first item, than push the new item.
				else
				{
					// Remove the oldest item from array
					array_shift($filtered_downloads_arr);

					// Add new item to the end of the array
					array_push($filtered_downloads_arr, $image_id);

					// Convert array to db string
					$new_downloads_db_str = arr_to_db_str($filtered_downloads_arr);

					// Add new values to db
					$privateUser->updateUserDownloads($new_downloads_db_str ,$_SESSION['user_id']);
				}
			}
		}
	}

	// Update loves
	if ($post_love_image) 
	{   
		// If user is loggen in
		if (is_user_logged_in())
		{
			// Get current list of likes as string
		   	$loves_db_str = $privateUser->getUserLikesAndSaves($_SESSION['username'])[0]->user_likes;

			// Convert string to array
			$loves_arr = db_str_to_arr($loves_db_str);
		
			// Remove empty items from array
			$filtered_loves_arr = array_filter($loves_arr);
		
			// Reindex the array to ensure indexes are sequential
			$filtered_loves_arr = array_values($filtered_loves_arr);
		
			// Does current image id is inside the loves array
			$is_id_in_arr = is_inside_arr($filtered_loves_arr, $image_id);

			// If current image id is not in the loves db
			if (!$is_id_in_arr)
			{
				// If array is smaller than 30
				if (count($filtered_loves_arr) < 30)
				{	
					// Add new image id to the end of the array
					array_push($filtered_loves_arr, $image_id);

					// Convert array to db string
					$new_loves_db_str = arr_to_db_str($filtered_loves_arr);

					// Add new values to db
					$privateUser->updateUserLikes($new_loves_db_str ,$_SESSION['user_id']);

					// Increase the loves sum
					$image->increaseLoves($image_id);
				}
				// Else if array has 30 items, remove the first item, than push the new item.
				else
				{
					// Remove the oldest item from array
					array_shift($filtered_loves_arr);

					// Add new item to the end of the array
					array_push($filtered_loves_arr, $image_id);

					// Convert array to db string
					$new_loves_db_str = arr_to_db_str($filtered_loves_arr);

					// Add new values to db
					$privateUser->updateUserLikes($new_loves_db_str ,$_SESSION['user_id']);

					// Increase the loves sum
					$image->increaseLoves($image_id);
				}
			}
			// Else if image id is in the loves db
			else 
			{			
				// Remove item from array
				$filtered_loves_arr = array_diff($filtered_loves_arr, [$image_id]);
			
				// Reindex the array to ensure indexes are sequential
				$filtered_loves_arr = array_values($filtered_loves_arr);

				// Convert array to db string
				$new_loves_db_str = arr_to_db_str($filtered_loves_arr);
			
				// Add new values to db
				$privateUser->updateUserLikes($new_loves_db_str ,$_SESSION['user_id']);
			
				// Decrease the loves sum
				if ($image_details[0]->image_likes > 0)
				{
					$image->decreaseLoves($image_id);
				}
			}

		}
		else
		{		
			// Increase the loves sum
			$image->increaseLoves($image_id);
		}
	}

	// Update saves - SIMILAR AS ABOVE - LOVES
	// Update DB, NOT save an image (download)
	if ($post_save_image) 
	{   
		// If user is loggen in
		if (is_user_logged_in())
		{
			// Get current list of likes as string
		   	$saves_db_str = $privateUser->getUserLikesAndSaves($_SESSION['username'])[0]->user_saves;

			// Convert string to array
			$saves_arr = db_str_to_arr($saves_db_str);
		
			// Remove empty items from array
			$filtered_saves_arr = array_filter($saves_arr);
		
			// Reindex the array to ensure indexes are sequential
			$filtered_saves_arr = array_values($filtered_saves_arr);
		
			// Does current image id is inside the loves array
			$is_id_in_arr = is_inside_arr($filtered_saves_arr, $image_id);

			// If current image id is not in the loves db
			if (!$is_id_in_arr)
			{
				// If array is smaller than 30
				if (count($filtered_saves_arr) < 30)
				{	
					// Add new image id to the end of the array
					array_push($filtered_saves_arr, $image_id);

					// Convert array to db string
					$new_saves_db_str = arr_to_db_str($filtered_saves_arr);

					// Add new values to db
					$privateUser->updateUserSaves($new_saves_db_str ,$_SESSION['user_id']);
				}
				// Else if array has 30 items, remove the first item, than push the new item.
				else
				{
					// Remove the oldest item from array
					array_shift($filtered_saves_arr);

					// Add new item to the end of the array
					array_push($filtered_saves_arr, $image_id);

					// Convert array to db string
					$new_saves_db_str = arr_to_db_str($filtered_saves_arr);

					// Add new values to db
					$privateUser->updateUserSaves($new_saves_db_str ,$_SESSION['user_id']);
				}
			}
			// Else if image id is in the loves db
			else 
			{			
				// Remove item from array
				$filtered_saves_arr = array_diff($filtered_saves_arr, [$image_id]);
			
				// Reindex the array to ensure indexes are sequential
				$filtered_saves_arr = array_values($filtered_saves_arr);

				// Convert array to db string
				$new_saves_db_str = arr_to_db_str($filtered_saves_arr);
			
				// Add new values to db
				$privateUser->updateUserSaves($new_saves_db_str ,$_SESSION['user_id']);
			}
		}
	}
}


/*
** HANDLE POST
** COMMENTS
*/

// Declare arrays
$inputs = [];
$errors = [];

if (is_post_request() && is_user_logged_in())
{
	$fields_sanitize = 
	[
		'comment-text' => 'string',
  	];

	$fields_validate = 
	[
		'comment-text' => 'required | between: 0,500 | forbiddenWord: profane_words, profane_words_word | forbiddenPhrase: profane_phrases, profane_phrases_phrase',
	];

	$inputs = sanitize($_POST, $fields_sanitize);
 	$errors = validate($_POST, $fields_validate);

	if ($errors) 
	{
		redirect_with('image.php?image_id=' . $image_id, [
			'inputs' => $inputs,
			'errors' => $errors
		]);
	}

	if (!$errors && $inputs) 
	{	
		// Add comment.
		$comments->addComment($_SESSION['username'], $inputs['comment-text'], $_SESSION['user_id'], $image_id);

		redirect_with_message(
			'image.php?image_id=' . $image_id,
			'You comment was succesfully added.'
		);
	}
}
else 
{
	[$inputs, $errors] = session_flash('inputs', 'errors');
}


/*
** Related Images
*/

$img_tags_str = $image_details[0]->image_tags;

$img_tags_arr = db_str_to_arr($img_tags_str);

$img_number_of_tags = count($img_tags_arr);

$related_images = $image->getRelatedImagesSortByDownloads($img_tags_arr, $image_id);


/*
** Temnplates
*/

// Increase number of image views
if (!is_post_request())
{
	if (!isset($_POST['love_it']) || !isset($_POST['save_it']) || !isset($_POST['image_id']))
	{
		$image->increaseViews($image_id);
	}
}


// Create template
$template = new Template('templates/image.php');

// Assign Variables
$template->imageDetails = $image_details;
$template->comments = $comments->getCommentsByImg($image_id);
$template->images = $image->getLimitImages(0, $imgsLimit);
if (isset($_SESSION['username']))
{
	$template->userLikesSaves = $privateUser->getUserLikesAndSaves($_SESSION['username']);
}
$template->related_images = $related_images;


// Assign Variables
$template->inputs = $inputs;
$template->errors = $errors;

// Print HTML
echo $template;
