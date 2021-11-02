<?php

namespace FluxMailApi;

if (version_compare(PHP_VERSION, ($min_php_version = "8.0"), "<")) {
    die(__NAMESPACE__ . " needs at least PHP " . $min_php_version);
}

foreach (["imap", "json", "swoole"] as $ext) {
    if (!extension_loaded($ext)) {
        die(__NAMESPACE__ . " needs PHP ext " . $ext);
    }
}

require_once __DIR__ . "/../libs/FluxRestApi/autoload.php";

spl_autoload_register(function (string $class) : void {
    if (str_starts_with($class, "PHPMailer\\PHPMailer\\")) {
        require_once __DIR__ . "/../libs/PHPMailer/src" . str_replace("\\", "/", substr($class, strlen("PHPMailer\\PHPMailer"))) . ".php";
    }
});

spl_autoload_register(function (string $class) : void {
    if (str_starts_with($class, "PhpImap\\")) {
        require_once __DIR__ . "/../libs/php-imap/src/PhpImap" . str_replace("\\", "/", substr($class, strlen("PhpImap"))) . ".php";
    }
});

spl_autoload_register(function (string $class) : void {
    if (str_starts_with($class, __NAMESPACE__ . "\\")) {
        require_once __DIR__ . str_replace("\\", "/", substr($class, strlen(__NAMESPACE__))) . ".php";
    }
});
