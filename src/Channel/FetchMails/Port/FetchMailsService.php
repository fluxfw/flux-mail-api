<?php

namespace Fluxlabs\FluxMailApi\Channel\FetchMails\Port;

use Fluxlabs\FluxMailApi\Adapter\Api\FetchedMailsDto;
use Fluxlabs\FluxMailApi\Channel\FetchMails\Command\FetchMailsCommand;
use Fluxlabs\FluxMailApi\Channel\FetchMails\Command\FetchMailsCommandHandler;
use Fluxlabs\FluxMailApi\Config\MailServerEnv;

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
