<?php

/**
 * Developed by Sohel Rana
 * https://github.com/sohelrn
 */

use Controller\Controller;

// Define the root directory
define('DIR', __DIR__ . '/../');

// Include the autoloader
require_once __DIR__ . '/Autoload.php';

// Instantiate and use the controller
$controller = new Controller();
$controller->refresh();
