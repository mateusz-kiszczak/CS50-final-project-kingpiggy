<?php
//Include Configuration
require_once('private/config/config.php');

// Autoloaded Classes
spl_autoload_register(function ($class_name) {
  include 'private/libraries/' . $class_name . '.php';
});
