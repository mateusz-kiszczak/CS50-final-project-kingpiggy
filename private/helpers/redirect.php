<?php
function redirect(string $url) : void
{
    header('Location: ' . $url);
    die();
};

// Adds the elements of the $items array to the $_SESSION variable and redirects to a URL
function redirect_with(string $url, array $items): void
{
    foreach ($items as $key => $value) {
        $_SESSION[$key] = $value;
    }

    redirect($url);
}

// Set a flash message and redirect to another page
function redirect_with_message(string $url, string $message, string $type=FLASH_SUCCESS)
{
    flash('flash_' . uniqid(), $message, $type);
    redirect($url);
}
