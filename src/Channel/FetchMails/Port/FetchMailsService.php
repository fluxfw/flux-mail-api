<?php

namespace Fluxlabs\FluxMailApi\Channel\FetchMails\Port;

use Fluxlabs\FluxMailApi\Adapter\Api\FetchedMailsDto;
use Fluxlabs\FluxMailApi\Adapter\Config\MailServerConfigDto;
use Fluxlabs\FluxMailApi\Channel\FetchMails\Command\FetchMailsCommand;
use Fluxlabs\FluxMailApi\Channel\FetchMails\Command\FetchMailsCommandHandler;

class FetchMailsService
{

    private MailServerConfigDto $mail_server_config;


    public static function new(MailServerConfigDto $mail_server_config) : static
    {
        $service = new static();

        $service->mail_server_config = $mail_server_config;

        return $service;
    }


    public function fetch() : FetchedMailsDto
    {
        return FetchMailsCommandHandler::new(
            $this->mail_server_config
        )
            ->handle(
                FetchMailsCommand::new()
            );
    }
}
