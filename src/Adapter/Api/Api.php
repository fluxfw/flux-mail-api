<?php

namespace FluxMailApi\Adapter\Api;

use FluxMailApi\Adapter\Config\Config;
use FluxMailApi\Adapter\Config\EnvConfig;
use FluxMailApi\Channel\FetchMails\Port\FetchMailsService;
use FluxMailApi\Channel\SendMail\Port\SendMailService;

class Api
{

    private readonly Config $config;


    public static function new(?Config $config = null) : static
    {
        $api = new static();

        $api->config = $config ?? EnvConfig::new();

        return $api;
    }


    public function fetch() : FetchedMailsDto
    {
        return FetchMailsService::new(
            $this->config->getMailConfig()
        )
            ->fetch();
    }


    public function send(MailDto $mail) : void
    {
        SendMailService::new(
            $this->config->getSmtpConfig()
        )
            ->send(
                $mail
            );
    }
}
