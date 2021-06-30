<?php

namespace Fluxlabs\FluxMailApi\Adapter\Api;

use Fluxlabs\FluxMailApi\Config\FluxMailConfig;

class FluxMailApi
{

    public static function new() : static
    {
        $api = new static();

        return $api;
    }


    public function fetch() : FetchedMailsDto
    {
        return FluxMailConfig::new()
            ->getFetchMailsService()
            ->fetch();
    }


    public function send(MailDto $mail) : void
    {
        FluxMailConfig::new()
            ->getSendMailService()
            ->send(
                $mail
            );
    }
}
