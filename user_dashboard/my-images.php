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
// Get Img db
$img = new Img;
$privateUser = new PrivateUser;

// Get user nikname from SESSION
$user_nikname = $_SESSION['username'];
$user_id = $_SESSION['user_id'];


// Declare arrays
$inputs = [];
$errors = [];


/*
** HANDLE POST
*/

// If POST sanitize and validate inputs
if (is_post_request() && isset($_GET['image_id'])) 
{	
	$image_id = urlencode($_GET['image_id']);

	$fields_sanitize = 
	[
		'city' => 'string',
		'country' => 'string',
		'place' => 'string',
		'tags' => 'string',
		'description' => 'string'
  	];

  	$fields_validate = 
	[
		'city' => 'required | forbiddenWord: profane_words, profane_words_word | forbiddenPhrase: profane_phrases, profane_phrases_phrase',
		'country' => 'required | forbiddenWord: profane_words, profane_words_word | forbiddenPhrase: profane_phrases, profane_phrases_phrase',
		'place' => 'forbiddenWord: profane_words, profane_words_word | forbiddenPhrase: profane_phrases, profane_phrases_phrase',
		'tags' => 'required | tags | forbiddenWord: profane_words, profane_words_word | forbiddenPhrase: profane_phrases, profane_phrases_phrase',
		'description' => 'between: 0,500 | forbiddenWord: profane_words, profane_words_word | forbiddenPhrase: profane_phrases, profane_phrases_phrase',
  	];

	$inputs = sanitize($_POST, $fields_sanitize);
	$errors = validate($_POST, $fields_validate);


 	if ($errors) 
	{
  		redirect_with('my-images.php?user=' . $_SESSION['username'] . '&image_id=' . $image_id , [
			'inputs' => $inputs,
			'errors' => $errors
  		]);
 	}

  	if (!$errors && $inputs) 
	{
		// Check if user inputs are different than the ones in database, if true, update user inputs
		// Update Location
		$user_input_city = $inputs['city'] ?? '';
		$user_input_country = $inputs['country'] ?? '';
		$user_input_place = $inputs['place'] ?? '';

		$user_input_location = array($user_input_country, $user_input_city, $user_input_place);

		// Locations in string
		$user_location = set_image_location($user_input_location);
		$current_location = $img->getImage($image_id)[0]->image_location;

		// Update Location
		set_new_input($user_location, $current_location, $img->updateLocation($user_location, $image_id));

		// Update tags
		$img_tags = tags_array_to_db_string(user_input_tags_to_array($inputs['tags']));

		// set_new_input($img_tags, $img->getImage($image_id)[0]->image_tags, $img->updateTags($img_tags, $image_id));

		// Update description
		// set_new_input($inputs['description'], $img->getImage($image_id)[0]->image_description, $img->updateDescription($inputs['description'], $image_id));


		redirect_with_message(
	  		'my-images.php?user=' . $_SESSION['username'],
	  		'Your profile has been updated!'
		);
  	}

} 
else if (is_get_request()) 
{
  	[$inputs, $errors] = session_flash('inputs', 'errors');
}

// Create template
$template = new Template('../templates/user_dashboard/my-images.php');

// Assign Variables
$template->imgs = $img->getImagesByUserId($user_id);
$template->img_class = $img;

// PrivateUser used in header include
$template->privateUser = $privateUser->getAllPrivateUserByNikname($user_nikname);

// Assign Variables
$template->inputs = $inputs;
$template->errors = $errors;

// Print HTML
echo $template;
