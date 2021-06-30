<?php

namespace Fluxlabs\FluxMailApi\Channel\SendMail\Port;

use Fluxlabs\FluxMailApi\Adapter\Api\MailDto;
use Fluxlabs\FluxMailApi\Channel\SendMail\Command\SendMailCommand;
use Fluxlabs\FluxMailApi\Channel\SendMail\Command\SendMailCommandHandler;
use Fluxlabs\FluxMailApi\Config\SmtpServerEnv;

class SendMailService
{

    private SmtpServerEnv $smtp_server;


    public static function new(SmtpServerEnv $smtp_server) : static
    {
        $service = new static();

        $service->smtp_server = $smtp_server;

        return $service;
    }


    public function send(MailDto $mail) : void
    {
        SendMailCommandHandler::new(
            $this->smtp_server
        )
            ->handle(
                SendMailCommand::new(
                    $mail
                )
            );
    }
}
