<?php

namespace FluxMailApi\Channel\SendMail\Port;

use FluxMailApi\Adapter\Api\MailDto;
use FluxMailApi\Adapter\Config\SmtpConfigDto;
use FluxMailApi\Channel\SendMail\Command\SendMailCommand;

class SendMailService
{

    private function __construct(
        private readonly SmtpConfigDto $smtp_config
    ) {

    }


    public static function new(
        SmtpConfigDto $smtp_config
    ) : static {
        return new static(
            $smtp_config
        );
    }


    public function send(MailDto $mail) : void
    {
        SendMailCommand::new(
            $this->smtp_config
        )
            ->send(
                $mail
            );
    }
}
