<?php

namespace FluxMailApi\Channel\FetchMails\Port;

use FluxMailApi\Adapter\Api\FetchedMailsDto;
use FluxMailApi\Adapter\Config\MailConfigDto;
use FluxMailApi\Channel\FetchMails\Command\FetchMailsCommand;

class FetchMailsService
{

    private readonly MailConfigDto $mail_config;


    public static function new(MailConfigDto $mail_config) : static
    {
        $service = new static();

        $service->mail_config = $mail_config;

        return $service;
    }


    public function fetch() : FetchedMailsDto
    {
        return FetchMailsCommand::new(
            $this->mail_config
        )
            ->fetch();
    }
}
