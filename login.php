<?php

// Start session
session_start();

// Includes
require('private/core/init.php');
require('private/helpers/helpers.php');

// If user logged in, redirect to homepage
if (is_user_logged_in()) {
	redirect('index.php');
}

// Get PrivateUser db
$private_user = new PrivateUser;

$inputs = [];
$errors = [];
if (is_post_request()) {
	echo 'I am POST';
}
if (is_post_request()) {
	
	// sanitize & validate user inputs
	[$inputs, $errors] = filter($_POST, [
		'username' => 'string | required',
		'password' => 'string | required'
	]);
	
	if ($errors) {
		redirect_with('login.php', ['errors' => $errors, 'inputs' => $inputs]);
	}
	
	// if login fails
	if ($inputs['password'] && $inputs['username']) {

		if (!login($inputs['password'], $private_user->loginUser($inputs['username'])[0])) {
			$errors['login'] = 'Invalid username or password';
			
			redirect_with('login.php', [
				'errors' => $errors,
				'inputs' => $inputs
			]);
		}
	}

	// Update user ip
	$private_user->lastKnownIp(sanitize_ip_address(get_client_ip()), $inputs['username']);

	// login successfully
	redirect('index.php');

} else if (is_get_request()) {
	[$errors, $inputs] = session_flash('errors', 'inputs');
}


// Create template
$template = new Template('templates/login.php');

// Assign variables
$template->inputs = $inputs;
$template->errors = $errors;

// SESSION TEST
// echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';

// Print HTML
echo $template;
