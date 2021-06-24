<?php

namespace Fluxlabs\FluxMail\Channel\SendMail\Command;

use Fluxlabs\FluxMail\Adapter\Api\MailDto;

class SendMailCommand
{

    private MailDto $mail;


    public static function new(MailDto $mail) : static
    {
        $command = new static();

        $command->mail = $mail;

        return $command;
    }


    public function getMail() : MailDto
    {
        return $this->mail;
    }
}
