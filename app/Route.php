<?php

/**
 * Developed by Sohel Rana
 * https://github.com/sohelrn
 */

class Route
{
    public static $name;

    protected static $patterns = [
        'id'   => '[0-9]+',
        'name' => '[a-zA-Z]+',
        'slug' => '[a-zA-Z0-9_-]+',
        'any'  => '[^/]+',
        '*'    => '.*',
    ];

    protected static $routes = [
        'GET'    => [],
        'POST'   => [],
        'PUT'    => [],
        'DELETE' => [],
    ];

    public static function get($path, $handler)
    {
        self::$routes['GET'][$path] = $handler;
    }

    public static function post($path, $handler)
    {
        self::$routes['GET'][$path] = $handler;
        self::$routes['POST'][$path] = $handler;
    }

    public static function put($path, $handler)
    {
        self::$routes['PUT'][$path] = $handler;
    }

    public static function delete($path, $handler)
    {
        self::$routes['DELETE'][$path] = $handler;
    }

    protected static function regex($requestUri, $sourcePath)
    {
        $routePattern = preg_replace_callback('/{(.+?)}/', function ($matches) {
            return self::$patterns[$matches[1]] ?? '[^/]+';
        }, $sourcePath);
        $sourceSegments = explode('/', trim($sourcePath, '/'));
        $requestSegments = explode('/', trim($requestUri, '/'));
        $args = array_diff_assoc($requestSegments, $sourceSegments);
        return [array_values($args), $sourcePath, $routePattern];
    }

    public static function run()
    {
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $requestUri = '/' . trim(substr($requestPath, strlen($basePath)), '/');
        self::$name = $requestUri;
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $routes = self::$routes[$method] ?? [];
        foreach ($routes as $path => $handler) {
            $args = [];
            if (strpos($path, '{') !== false) {
                list($args, $sourcePath, $regexPath) = self::regex($requestUri, $path);
                $path = $regexPath;
            }
            // if (preg_match('/({.+?})/', $path)) {
            //     list($args, $uri, $path) = self::regex($requestUri, $path);
            // }
            if (preg_match("#^$path$#", $requestUri)) {
                return call_user_func_array([new $handler[0], $handler[1]], $args);
            }
        }
    }
}
