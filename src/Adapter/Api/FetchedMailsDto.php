<?php

namespace FluxMailApi\Adapter\Api;

class FetchedMailsDto
{

    /**
     * @var MailDto[]
     */
    public readonly array $mails;


    public static function new(array $mails) : static
    {
        $dto = new static();

        $dto->mails = $mails;

        return $dto;
    }
}
