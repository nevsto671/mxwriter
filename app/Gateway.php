<?php

/**
 * Developed by Sohel Rana
 * https://github.com/sohelrn
 */

class Gateway
{
    public $gateway;

    function __construct($provider)
    {
        spl_autoload_register([$this, 'autoload']);
        $gateway = DB::select('gateways', 'options', ['provider' => $provider], 'LIMIT 1');
        $options = !empty($gateway[0]['options']) ? json_decode($gateway[0]['options'], true) : [];
        if (empty($options)) return;
        $credential = [];
        foreach ($options as $option) {
            $credential[$option['key']] = $option['value'];
        }
        $classname = "\\Gateway\\$provider";
        if (class_exists($classname)) $this->gateway = new $classname($credential);
    }

    protected function autoload($class)
    {
        $prefix = 'Gateway\\';
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) return;
        $relative_class = substr($class, $len);
        $file = __DIR__ . "/Gateway/$relative_class.php";
        if (file_exists($file)) require_once $file;
    }
}
