<?php 

// Start session
session_start();
// unset($_SESSION['FLASH_MESSAGES']);

// Includes
require('private/core/init.php');
require('private/helpers/helpers.php');

// Get PrivateUser db
$private_user = new PrivateUser;
$profiles = new Profiles;

/*
** HANDLE POST
*/

// Declare arrays
$inputs = [];
$errors = [];


// If POST sanitize and validate inputs
if (is_post_request()) {
  $fields_sanitize = [
    'username' => 'string',
    'email' => 'email',
    'password' => 'string',
    'password2' => 'string',
    'agree' => 'string'
  ];

  $fields_validate = [
    'username' => 'required | alphanumeric | between: 3,255 | unique: users, user_nikname | forbidden: profane_words, profane_words_word | unique: reserved_usernames, reserved_usernames_username',
    'email' => 'required | email | unique: users, user_email',
    'password' => 'required | secure',
    'password2' => 'required | same:password',
    'agree' => 'required'
  ];
  
  // custom messages
  $messages = [
    'password2' => [
      'required' => 'Please enter the password again',
      'same' => 'The password does not match'
    ],
    'agree' => [
      'required' => 'You need to agree to the term of services to register'
      ]
  ];
  
  $inputs = sanitize($_POST, $fields_sanitize);
  $errors = validate($_POST, $fields_validate, $messages);
  
  if ($errors) {
    redirect_with('register.php', [
      'inputs' => $inputs,
      'errors' => $errors
    ]);
  }
  
  if (!$errors && $inputs) {
    $private_user->registerUser($inputs['email'], $inputs['username'], $inputs['password']);
    
    // Set temporary avatar image

    // Get user's nikname first character
    $nikname_fisrt_char = $inputs['username'][0];

    // Check if the forst character is a letter, if not assign 'x'
    if (!ctype_alpha($nikname_fisrt_char)) {
      $nikname_fisrt_char = 'x';
    }

    $source = $_SERVER['DOCUMENT_ROOT'] . '/templates/src/avatar/' . $nikname_fisrt_char . '.png';
    $destination = $_SERVER['DOCUMENT_ROOT'] . '/images/avatars/' . $inputs['username'] . '.png';

    copy($source, $destination);

    clearstatcache();
    
    // Create a profile columns for the user
    $user_id = $private_user->getUserIdByNikname($inputs['username'])[0]->user_id;
    $profiles->createProfiles($user_id);

    redirect_with_message(
      'login.php',
      'Your account has been created successfully. Please login here.'
    );
  }
  
} else if (is_get_request()) {
  [$inputs, $errors] = session_flash('inputs', 'errors');
}


// Create template
$template = new Template('templates/register.php');

// Assign Variables
$template->inputs = $inputs;
$template->errors = $errors;


// Print HTML
echo $template;
