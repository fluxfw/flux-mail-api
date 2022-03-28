<?php

namespace FluxMailApi\Channel\FetchMails\Port;

use FluxMailApi\Adapter\Mail\FetchedMailsDto;
use FluxMailApi\Adapter\Mail\MailConfigDto;
use FluxMailApi\Channel\FetchMails\Command\FetchMailsCommand;

class FetchMailsService
{

    private function __construct(
        private readonly MailConfigDto $mail_config
    ) {

    }


    public static function new(
        MailConfigDto $mail_config
    ) : static {
        return new static(
            $mail_config
        );
    }


    public function fetch() : FetchedMailsDto
    {
        return FetchMailsCommand::new(
            $this->mail_config
        )
            ->fetch();
    }
}
