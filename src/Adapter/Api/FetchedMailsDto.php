<?php

namespace FluxMailApi\Adapter\Api;

class FetchedMailsDto
{

    /**
     * @param MailDto[] $mails
     */
    private function __construct(
        public readonly array $mails
    ) {

    }


    public static function new(
        array $mails
    ) : static {
        return new static(
            $mails
        );
    }
}
