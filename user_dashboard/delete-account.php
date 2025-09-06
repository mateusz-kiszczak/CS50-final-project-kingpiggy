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

// Ceate new class with db connection and queries
// Get Private User db

$privateUser = new PrivateUser;

// Get user nikname from SESSION
$user_nikname = $_SESSION['username'];


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
		'email'  => 'string',
		'password' => 'string',
		'new-password' => 'string'
	];


	$fields_validate = 
	[
		'email' => 'required',
		'password'  => 'required',
		'new-password' => 'required | same:new-password',
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
	
	$private_user = $privateUser->getAllPrivateUserByNikname($user_nikname)[0];

	// Validate email
	$user_email = $private_user->user_email;

	if ($user_email !== $inputs['email'])
	{
		$errors['email'] = 'This email does not match our records';
	}


	// Validate current password
	$user_password = $private_user->user_password;

	if (!password_verify($inputs['password'],$user_password))
	{
		$errors['password'] = 'This password does not apear in our records';
	}


 	if ($errors) 
	{
		redirect_with('delete-account.php?user=' . $_SESSION['username'], [
			'inputs' => $inputs,
			'errors' => $errors
		]);
 	}

	if (!$errors && $inputs) 
	{	
		// Delete user avatar image 
		// Remove image file
		$user_avatar = $_SERVER['DOCUMENT_ROOT'] . '/' . $private_user->user_avatar_url;
	
		if (file_exists($user_avatar))
		{
			unlink($user_avatar);
		}

		// If no errors, delete user
		$privateUser->deleteUserByUsername($user_nikname);

		// Clear session
		session_destroy();

		redirect_with_message(
			'../index.php',
			'Your profile has been deleted!'
		);
	}

} 
else if (is_get_request())
{
	[$inputs, $errors] = session_flash('inputs', 'errors');
}



// // Create template
$template = new Template('../templates/user_dashboard/delete-account.php');

// // Assign Variables
$template->privateUser = $privateUser->getAllPrivateUserByNikname($user_nikname);

// Assign variables
$template->inputs = $inputs;
$template->errors = $errors;

// // Print HTML
echo $template;
