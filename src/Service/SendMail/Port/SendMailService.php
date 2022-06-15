<?php

namespace FluxMailApi\Service\SendMail\Port;

use FluxMailApi\Adapter\Mail\MailDto;
use FluxMailApi\Adapter\Smtp\SmtpConfigDto;
use FluxMailApi\Service\SendMail\Command\SendMailCommand;

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
