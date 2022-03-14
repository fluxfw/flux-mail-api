<?php

namespace FluxMailApi;

require_once __DIR__ . "/../libs/flux-autoload-api/autoload.php";

use FluxMailApi\Libs\FluxAutoloadApi\Adapter\Autoload\ComposerAutoload;
use FluxMailApi\Libs\FluxAutoloadApi\Adapter\Autoload\Psr4Autoload;
use FluxMailApi\Libs\FluxAutoloadApi\Adapter\Checker\PhpExtChecker;
use FluxMailApi\Libs\FluxAutoloadApi\Adapter\Checker\PhpVersionChecker;

PhpVersionChecker::new(
    ">=8.1"
)
    ->checkAndDie(
        __NAMESPACE__
    );
PhpExtChecker::new(
    [
        "imap",
        "json"
    ]
)
    ->checkAndDie(
        __NAMESPACE__
    );

Psr4Autoload::new(
    [
        __NAMESPACE__ => __DIR__
    ]
)
    ->autoload();

ComposerAutoload::new(
    __DIR__ . "/../libs/php-imap"
)
    ->autoload();
ComposerAutoload::new(
    __DIR__ . "/../libs/PHPMailer"
)
    ->autoload();
