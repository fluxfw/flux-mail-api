<?php

namespace Fluxlabs\FluxMail\Channel\FetchMails\Port;

use Fluxlabs\FluxMail\Adapter\Api\FetchedMailsDto;
use Fluxlabs\FluxMail\Channel\FetchMails\Command\FetchMailsCommand;
use Fluxlabs\FluxMail\Channel\FetchMails\Command\FetchMailsCommandHandler;
use Fluxlabs\FluxMail\Config\MailServerEnv;

class FetchMailsService
{

    private MailServerEnv $mail_server;


    public static function new(MailServerEnv $mail_server) : static
    {
        $service = new static();

        $service->mail_server = $mail_server;

        return $service;
    }


    public function fetch() : FetchedMailsDto
    {
        return FetchMailsCommandHandler::new(
            $this->mail_server
        )
            ->handle(
                FetchMailsCommand::new()
            );
    }
}
