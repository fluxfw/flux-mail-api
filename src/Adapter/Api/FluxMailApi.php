<?php

namespace Fluxlabs\FluxMailApi\Adapter\Api;

use Fluxlabs\FluxMailApi\Config\FluxMailApiConfig;

class FluxMailApi
{

    public static function new() : static
    {
        $api = new static();

        return $api;
    }


    public function initServer() : void
    {
        FluxMailApiConfig::new()
            ->getInitServerService()
            ->initServer();
    }


    public function fetch() : FetchedMailsDto
    {
        return FluxMailApiConfig::new()
            ->getFetchMailsService()
            ->fetch();
    }


    public function send(MailDto $mail) : void
    {
        FluxMailApiConfig::new()
            ->getSendMailService()
            ->send(
                $mail
            );
    }
}
