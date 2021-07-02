<?php

namespace Fluxlabs\FluxMailApi\Adapter\Api;

use Fluxlabs\FluxMailApi\Adapter\Config\Config;
use Fluxlabs\FluxMailApi\Adapter\Config\EnvConfig;
use Fluxlabs\FluxMailApi\Channel\FetchMails\Port\FetchMailsService;
use Fluxlabs\FluxMailApi\Channel\SendMail\Port\SendMailService;

class Api
{

    private Config $config;


    public static function new(?Config $config = null) : static
    {
        $api = new static();

        $api->config = $config ?? EnvConfig::new();

        return $api;
    }


    public function fetch() : FetchedMailsDto
    {
        return FetchMailsService::new(
            $this->config->getMailServerConfig()
        )
            ->fetch();
    }


    public function send(MailDto $mail) : void
    {
        SendMailService::new(
            $this->config->getSmtpServerConfig()
        )
            ->send(
                $mail
            );
    }
}
