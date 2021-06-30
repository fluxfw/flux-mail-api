<?php

namespace Fluxlabs\FluxMailApi\Channel\InitServer\Command;

class InitServerCommand
{

    public static function new() : static
    {
        $command = new static();

        return $command;
    }
}
