<?php

namespace Fluxlabs\FluxMailApi\Channel\FetchMails\Command;

class FetchMailsCommand
{

    public static function new() : static
    {
        $command = new static();

        return $command;
    }
}
