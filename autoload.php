<?php

spl_autoload_register(function ($class) {

    if (substr(strtolower($class), 0, 6) !== 'paypal\\') {
        return;
    }
    $path = __DIR__ . '/src/PayPal/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require($path);
    }
});