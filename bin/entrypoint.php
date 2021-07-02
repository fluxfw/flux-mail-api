#!/usr/bin/env php
<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Fluxlabs\FluxMailApi\Adapter\Api\Api;
use Fluxlabs\FluxMailApi\Adapter\Config\EnvConfig;
use Fluxlabs\FluxMailApi\Adapter\Server\Server;

Server::new(
    Api::new(
        EnvConfig::new()
    ),
    EnvConfig::new()
)
    ->init();
