<?php

namespace FluxMailApi\Adapter\Api;

use FluxMailApi\Adapter\Mail\MailDto;
use FluxMailApi\Channel\FetchMails\Port\FetchMailsService;
use FluxMailApi\Channel\SendMail\Port\SendMailService;

class MailApi
{

    private function __construct(
        private readonly MailApiConfigDto $mail_api_config
    ) {

    }


    public static function new(
        ?MailApiConfigDto $mail_api_config = null
    ) : static {
        return new static(
            $mail_api_config ?? MailApiConfigDto::newFromEnv()
        );
    }


    /**
     * @return MailDto[]
     */
    public function fetch() : array
    {
        return $this->getFetchMailsService()
            ->fetch();
    }


    public function send(MailDto $mail) : void
    {
        $this->getSendMailService()
            ->send(
                $mail
            );
    }


    private function getFetchMailsService() : FetchMailsService
    {
        return FetchMailsService::new(
            $this->mail_api_config->mail_config
        );
    }


    private function getSendMailService() : SendMailService
    {
        return SendMailService::new(
            $this->mail_api_config->smtp_config
        );
    }
}
