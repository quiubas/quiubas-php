<?php

namespace Quiubas;

$required_extensions = array(
    'openssl',
    'curl'
);

foreach ($required_extensions as $v) {
    if (extension_loaded($v) === false) {
        include __DIR__ . '/Quiubas/Exception.php';
        throw new \Quiubas\Exception(
            'The "' . $v . '" extension is required by Quiubas Library'
        );
        break;
    }
}

spl_autoload_register(function ($class) {
    $file = __DIR__ . DIRECTORY_SEPARATOR .
        str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    include $file;
}, false, true);
