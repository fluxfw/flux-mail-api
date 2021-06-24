<?php

namespace Fluxlabs\FluxMail\Adapter\Api;

class FetchedMailsDto
{

    private array $mails;


    public static function new(array $mails) : static
    {
        $dto = new static();

        $dto->mails = $mails;

        return $dto;
    }


    /**
     * @return MailDto[]
     */
    public function getMails() : array
    {
        return $this->mails;
    }
}
