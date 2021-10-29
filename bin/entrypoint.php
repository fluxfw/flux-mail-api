#!/usr/bin/env php
<?php

require_once __DIR__ . "/../src/init.php";

use FluxMailApi\Adapter\Server\Server;

Server::new()
    ->init();
