<?php

/**
 * Developed by Sohel Rana
 * https://github.com/sohelrn
 */

// Define app directory
define('APP', __DIR__);

// Include necessary configuration files
require_once APP . '/Config.php';
require_once APP . '/Route.php';
require_once APP . '/Route/Web.php';

class Autoload
{
    // Mapping of namespace prefixes to directory paths.
    protected static $vendor = [
        'Gumlet' => 'php-image-resize/lib',
        'Firebase\JWT' => 'php-jwt/src',
        'PHPMailer\PHPMailer' => 'PHPMailer/src'
    ];

    // Registers the autoloader with SPL.
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'loadClass']);
    }

    // Loads the class file if it exists.
    protected static function loadClass($class)
    {
        // Handle classes without namespaces
        // if (strpos($class, '\\') === false) {
        //     $file = APP . '/' . str_replace('\\', '/', $class) . '.php';
        //     if (file_exists($file)) {
        //         require_once $file;
        //     }
        //     return;
        // }

        // Extract namespace and class name
        $pos = strrpos($class, '\\');
        $namespace = substr($class, 0, $pos);
        // Handle namespaced classes
        if (isset(self::$vendor[$namespace])) {
            $base_dir = self::$vendor[$namespace];
            $relative_class = substr($class, $pos + 1);
            $file = APP . "/Vendor/$base_dir/$relative_class.php";
        } else {
            $file = APP . '/' . str_replace('\\', '/', $class) . '.php';
        }

        if (file_exists($file)) {
            require_once $file;
        }
    }
}

// Register the autoloader
Autoload::register();
