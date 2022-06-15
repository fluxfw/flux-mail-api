<?php

namespace FluxMailApi\Service\FetchMails\Port;

use FluxMailApi\Adapter\Mail\MailConfigDto;
use FluxMailApi\Adapter\Mail\MailDto;
use FluxMailApi\Service\FetchMails\Command\FetchMailsCommand;

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


    /**
     * @return MailDto[]
     */
    public function fetch() : array
    {
        return FetchMailsCommand::new(
            $this->mail_config
        )
            ->fetch();
    }
}
