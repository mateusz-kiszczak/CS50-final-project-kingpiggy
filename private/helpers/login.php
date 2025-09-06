<?php

// $sql variable type?
function login(string $password, $sql): bool
{
    $user = $sql;

    // if user found, check the password
    if ($user && password_verify($password, $user->user_password)) {

        // prevent session fixation attack
        session_regenerate_id();

        // set username in the session
        $_SESSION['username'] = $user->user_nikname;
        $_SESSION['user_id']  = $user->user_id;
        $_SESSION['user_avatar']  = $user->user_avatar_url;


        return true;
    }

    return false;
}

function is_user_logged_in(): bool
{
    return isset($_SESSION['username']);
}

function require_login(): void
{
    if (!is_user_logged_in()) {
        redirect('login.php');
    }
}

function logout(): void
{
    if (is_user_logged_in()) {
        unset($_SESSION['username'], $_SESSION['user_id'], $_SESSION['user_avatar']);
        session_destroy();
        redirect('login.php');
    }
}

function current_user()
{
    if (is_user_logged_in()) {
        return $_SESSION['username'];
    }
    return null;
}
