<?php

namespace Fluxlabs\FluxMail\Channel\SendMail\Port;

use Fluxlabs\FluxMail\Adapter\Api\MailDto;
use Fluxlabs\FluxMail\Channel\SendMail\Command\SendMailCommand;
use Fluxlabs\FluxMail\Channel\SendMail\Command\SendMailCommandHandler;
use Fluxlabs\FluxMail\Config\SmtpServerEnv;

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
