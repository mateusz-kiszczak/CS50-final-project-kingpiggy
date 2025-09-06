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
$private_user = new PrivateUser;

// Get user id from SESSION
$username = $_SESSION['username'];

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
		'password'  => 'string',
		'new-password' => 'string',
		're-new-password' => 'string'
  	];


  	$fields_validate = 
	[
        'password' => 'required',
		'new-password'  => 'required | secure',
        're-new-password' => 'required | same:new-password',
  	];

    // custom messages
    $messages = [
      're-new-password' => [
        'required' => 'Please enter the password again',
        'same' => 'The password does not match'
      ]
    ];

    
	$inputs = sanitize($_POST, $fields_sanitize);
	$errors = validate($_POST, $fields_validate, $messages);
    
    // Validate current password
    $user_password = $private_user->getUserPasswordByNikname($username)[0]->user_password;

    if (!password_verify($inputs['password'],$user_password))
    {
        $errors['password'] = 'This password does not apear in our records';
    }


 	if ($errors) 
	{
  		redirect_with('../edit-profile.php?user=' . $_SESSION['username'], [
			'inputs' => $inputs,
			'errors' => $errors
  		]);
 	}

  	if (!$errors && $inputs) 
	{
		// If no errors, update password
        $private_user->updatePassword($inputs['new-password'], $username);

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
