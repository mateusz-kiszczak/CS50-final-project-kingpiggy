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
$profiles = new Profiles;

// Get user nikname from SESSION
$user_nikname = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Declare arrays
$inputs = [];
$errors = [];

// Get all private user data
$getAllPrivateUserData = $privateUser->getAllPrivateUserByNikname($user_nikname);
// Get all profiles
$getAllprofiles = $profiles->getAllProfilesById($user_id);


/*
** HANDLE POST
*/

// If POST sanitize and validate inputs
if (is_post_request()) 
{
	$fields_sanitize = 
	[
		// 'username' => 'string',
		'name' => 'string',
		'surname' => 'string',
		'email' => 'email',
		'birthday' => 'string',
		'city' => 'string',
		'country' => 'string',
		'about-me' => 'string',
  	];

  	$fields_validate = 
	[
		// 'username' => 'required | alphanumeric | between: 3,255 | unique: users, user_nikname | forbidden: profane_words, profane_word | unique: 	reserved_usernames, reserved_username',
		'name' => 'required | alphanumeric | between: 2,255 | forbiddenWord: profane_words, profane_words_word | unique: reserved_usernames, 	reserved_usernames_username',
		'surname' => 'required | alphanumeric | between: 2,255 | forbiddenWord: profane_words, profane_words_word | unique: reserved_usernames, 	reserved_usernames_username',
		'email' => 'required | email | uniqueUpdate: users, user_email, user_nikname, ' . $user_nikname,
		'birthday' => 'required | adult',
		'city' => 'between: 2,64 | forbiddenWord: profane_words, profane_words_word | forbiddenPhrase: profane_phrases, profane_phrases_phrase',
		'country' => 'between: 2,64 | forbiddenWord: profane_words, profane_words_word | forbiddenPhrase: profane_phrases, profane_phrases_phrase',
		'about-me' => 'between: 0,1000 | forbiddenWord: profane_words, profane_words_word | forbiddenPhrase: profane_phrases, profane_phrases_phrase',
  	];

	$inputs = sanitize($_POST, $fields_sanitize);
	$errors = validate($_POST, $fields_validate);


 	if ($errors) 
	{
  		redirect_with('edit-profile.php?username=' . $_SESSION['username'], [
			'inputs' => $inputs,
			'errors' => $errors
  		]);
 	}

  	if (!$errors && $inputs) 
	{
		// Check if user inputs are different than the ones in database, if true, update user inputs
		// Update name
		set_new_input($inputs['name'], $getAllPrivateUserData[0]->user_name, $privateUser->updateName($inputs['name'], $user_nikname));

		// Update surname
		set_new_input($inputs['surname'], $getAllPrivateUserData[0]->user_surname, $privateUser->updateSurname($inputs['surname'], $user_nikname));

		// Update email
		set_new_input($inputs['email'], $getAllPrivateUserData[0]->user_email, $privateUser->updateEmail($inputs['email'], $user_nikname));

		// Update birthday
		// Format string to date
		$birthday_date = str_to_date($inputs['birthday']);

		set_new_input($birthday_date, $getAllPrivateUserData[0]->user_birthday, $privateUser->updateBirthday($inputs['birthday'], $user_nikname));

		// Update location
		$user_input_city = $inputs['city'] ?? '';
		$user_input_country = $inputs['country'] ?? '';
		$current_location = location_str_to_arr($getAllPrivateUserData[0]->user_location);

		$new_location = ($current_location) ? set_location($user_input_city, $user_input_country) : '';

		set_new_input($new_location, $getAllPrivateUserData[0]->user_location, $privateUser->updateLocation($new_location, $user_nikname));

		// Update description
		set_new_input($inputs['about-me'], $getAllPrivateUserData[0]->user_description, $privateUser->updateDescription($inputs['about-me'], $user_nikname));

		redirect_with_message(
	  		'edit-profile.php?username=' . $_SESSION['username'],
	  		'Your profile has been updated!'
		);
  	}

} 
else if (is_get_request()) 
{
  	[$inputs, $errors] = session_flash('inputs', 'errors');
}


// // Create template
$template = new Template('../templates/user_dashboard/edit-profile.php');

// // Assign Variables
$template->privateUser = $getAllPrivateUserData;
$template->profiles = $getAllprofiles;

// Assign Variables
$template->inputs = $inputs;
$template->errors = $errors;

// // Print HTML
echo $template;
