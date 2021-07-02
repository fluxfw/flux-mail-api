<?php

namespace Fluxlabs\FluxMailApi\Channel\SendMail\Port;

use Fluxlabs\FluxMailApi\Adapter\Api\MailDto;
use Fluxlabs\FluxMailApi\Adapter\Config\SmtpServerConfigDto;
use Fluxlabs\FluxMailApi\Channel\SendMail\Command\SendMailCommand;
use Fluxlabs\FluxMailApi\Channel\SendMail\Command\SendMailCommandHandler;

class SendMailService
{

    private SmtpServerConfigDto $smtp_server_config;


    public static function new(SmtpServerConfigDto $smtp_server_config) : static
    {
        $service = new static();

        $service->smtp_server_config = $smtp_server_config;

        return $service;
    }


    public function send(MailDto $mail) : void
    {
        SendMailCommandHandler::new(
            $this->smtp_server_config
        )
            ->handle(
                SendMailCommand::new(
                    $mail
                )
            );
    }
}
