<?php

/**
 * Developed by Sohel Rana
 * https://github.com/sohelrn
 */

// Start the session
session_start();

// Define the root directory
define('DIR', __DIR__);

// Include the autoloader
require_once DIR . '/app/Autoload.php';

// Run the application
Route::run();
