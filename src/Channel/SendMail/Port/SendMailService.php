<?php

namespace Fluxlabs\FluxMailApi\Channel\SendMail\Port;

use Fluxlabs\FluxMailApi\Adapter\Api\MailDto;
use Fluxlabs\FluxMailApi\Adapter\Config\SmtpConfigDto;
use Fluxlabs\FluxMailApi\Channel\SendMail\Command\SendMailCommand;
use Fluxlabs\FluxMailApi\Channel\SendMail\Command\SendMailCommandHandler;

class SendMailService
{

    private SmtpConfigDto $smtp_config;


    public static function new(SmtpConfigDto $smtp_config) : static
    {
        $service = new static();

        $service->smtp_config = $smtp_config;

        return $service;
    }


    public function send(MailDto $mail) : void
    {
        SendMailCommandHandler::new(
            $this->smtp_config
        )
            ->handle(
                SendMailCommand::new(
                    $mail
                )
            );
    }
}
