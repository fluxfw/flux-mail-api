<?php

namespace Fluxlabs\FluxMailApi\Channel\InitServer\Port;

use Fluxlabs\FluxMailApi\Channel\InitServer\Command\InitServerCommand;
use Fluxlabs\FluxMailApi\Channel\InitServer\Command\InitServerCommandHandler;
use Fluxlabs\FluxMailApi\Config\ServerEnv;

class InitServerService
{

    private ServerEnv $server;


    public static function new(ServerEnv $server) : static
    {
        $service = new static();

        $service->server = $server;

        return $service;
    }


    public function initServer() : void
    {
        InitServerCommandHandler::new(
            $this->server
        )
            ->handle(
                InitServerCommand::new()
            );
    }
}
