<?php

namespace Fluxlabs\FluxMailApi\Channel\FetchMails\Port;

use Fluxlabs\FluxMailApi\Adapter\Api\FetchedMailsDto;
use Fluxlabs\FluxMailApi\Adapter\Config\MailConfigDto;
use Fluxlabs\FluxMailApi\Channel\FetchMails\Command\FetchMailsCommand;
use Fluxlabs\FluxMailApi\Channel\FetchMails\Command\FetchMailsCommandHandler;

class FetchMailsService
{

    private MailConfigDto $mail_config;


    public static function new(MailConfigDto $mail_config) : static
    {
        $service = new static();

        $service->mail_config = $mail_config;

        return $service;
    }


    public function fetch() : FetchedMailsDto
    {
        return FetchMailsCommandHandler::new(
            $this->mail_config
        )
            ->handle(
                FetchMailsCommand::new()
            );
    }
}
