#!/usr/bin/env php
<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Fluxlabs\FluxMailApi\Adapter\Api\FluxMailApi;

FluxMailApi::new()
    ->initServer();
