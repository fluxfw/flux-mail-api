<?php

namespace FluxMailApi;

require_once __DIR__ . "/../libs/FluxRestApi/autoload.php";

use FluxAutoloadApi\Adapter\Autoload\ComposerAutoload;
use FluxAutoloadApi\Adapter\Autoload\PhpExtChecker;
use FluxAutoloadApi\Adapter\Autoload\PhpVersionChecker;
use FluxAutoloadApi\Adapter\Autoload\Psr4Autoload;

PhpVersionChecker::new(
    ">=8.0",
    __NAMESPACE__
)
    ->check();
PhpExtChecker::new(
    [
        "imap",
        "json",
        "swoole"
    ],
    __NAMESPACE__
)
    ->check();

Psr4Autoload::new(
    [
        __NAMESPACE__ => __DIR__
    ]
)
    ->autoload();

ComposerAutoload::new(
    __DIR__ . "/../libs/PHPMailer"
)
    ->autoload();
ComposerAutoload::new(
    __DIR__ . "/../libs/php-imap"
)
    ->autoload();
