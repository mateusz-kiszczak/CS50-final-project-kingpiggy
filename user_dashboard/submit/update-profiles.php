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
$profiles = new Profiles;

// Get user id from SESSION
$user_id = $_SESSION['user_id'];

// Declare arrays
$inputs = [];
$errors = [];

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
		'facebook'  => 'url',
		'twitter'   => 'url',
		'instagram' => 'url',
		'youtube'   => 'url',
		'pinterest' => 'url',
		'website'   => 'url'
  	];

  	$fields_validate = 
	[
		'facebook'  => 'contains: facebook',
		'twitter'   => 'contains: x',
		'instagram' => 'contains: instagram',
		'youtube'   => 'contains: youtube',
		'pinterest' => 'contains: pinterest',
		'website' => 'forbiddenWord: profane_words, profane_words_word | forbiddenPhrase: profane_phrases, profane_phrases_phrase',
  	];

    // custom messages
    $messages = 
    [
        'facebook' => [
            'contains' => 'The provided URL is not a valid Facebook site',
        ],
        'twitter' => [
            'contains' => 'The provided URL is not a valid Twitter site',
        ],
        'instagram' => [
            'contains' => 'The provided URL is not a valid Instagram site',
        ],
        'youtube' => [
            'contains' => 'The provided URL is not a valid YouTube site',
        ],
        'pinterest' => [
            'contains' => 'The provided URL is not a valid Pinterest site',
        ],
    ];

	$inputs = sanitize($_POST, $fields_sanitize);
	$errors = validate($_POST, $fields_validate, $messages);


 	if ($errors) 
	{
  		redirect_with('../edit-profile.php?user=' . $_SESSION['username'], [
			'inputs' => $inputs,
			'errors' => $errors
  		]);
 	}

  	if (!$errors && $inputs) 
	{
		// Check if user inputs are different than the ones in database, if true, update user inputs
		// Update facebook
		set_new_input($inputs['facebook'], $getAllprofiles[0]->profile_facebook, $profiles->updateFacebook($inputs['facebook'], $user_id));

        // Update twitter
		set_new_input($inputs['twitter'], $getAllprofiles[0]->profile_twitter, $profiles->updateTwitter($inputs['twitter'], $user_id));

        // Update instagram
		set_new_input($inputs['instagram'], $getAllprofiles[0]->profile_instagram, $profiles->updateInstagram($inputs['instagram'], $user_id));

        // Update youtube
		set_new_input($inputs['youtube'], $getAllprofiles[0]->profile_youtube, $profiles->updateYoutube($inputs['youtube'], $user_id));

        // Update pinterest
		set_new_input($inputs['pinterest'], $getAllprofiles[0]->profile_pinterest, $profiles->updatePinterest($inputs['pinterest'], $user_id));

        // Update website
		set_new_input($inputs['website'], $getAllprofiles[0]->profile_website, $profiles->updateWebsite($inputs['website'], $user_id));

		redirect_with_message(
	  		'../edit-profile.php?user=' . $_SESSION['username'],
	  		'Your profile has been updated!'
		);
  	}

} 
else if (is_get_request()) 
{
  	[$inputs, $errors] = session_flash('inputs', 'errors');
}
