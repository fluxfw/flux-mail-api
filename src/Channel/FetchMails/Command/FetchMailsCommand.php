<?php

namespace Fluxlabs\FluxMail\Channel\FetchMails\Command;

class FetchMailsCommand
{

    public static function new() : static
    {
        $command = new static();

        return $command;
    }
}
