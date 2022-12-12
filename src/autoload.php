<?php

namespace FluxMailApi;

require_once __DIR__ . "/../libs/flux-autoload-api/autoload.php";

use FluxMailApi\Libs\FluxAutoloadApi\Adapter\Autoload\Psr4Autoload;
use FluxMailApi\Libs\FluxAutoloadApi\Adapter\Checker\PhpExtChecker;
use FluxMailApi\Libs\FluxAutoloadApi\Adapter\Checker\PhpVersionChecker;

PhpVersionChecker::new(
    ">=8.2"
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

require_once __DIR__ . "/../libs/php-imap/vendor/autoload.php";
require_once __DIR__ . "/../libs/PHPMailer/vendor/autoload.php";
