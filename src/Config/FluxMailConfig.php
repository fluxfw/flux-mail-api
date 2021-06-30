<?php

namespace Fluxlabs\FluxMailApi\Config;

use Fluxlabs\FluxMailApi\Adapter\Api\AddressDto;
use Fluxlabs\FluxMailApi\Channel\FetchMails\Port\FetchMailsService;
use Fluxlabs\FluxMailApi\Channel\SendMail\Port\SendMailService;

class FluxMailConfig
{

    private static ?self $instance = null;
    private ?MailServerEnv $mail_server = null;
    private ?SmtpServerEnv $smtp_server = null;


    public static function new() : static
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }


    private function getMailServer() : MailServerEnv
    {
        if ($this->mail_server === null) {
            $this->mail_server = MailServerEnv::new(
                $_ENV["FLUX_MAIL_API_FETCH_HOST"],
                $_ENV["FLUX_MAIL_API_FETCH_PORT"],
                $_ENV["FLUX_MAIL_API_FETCH_TYPE"],
                $_ENV["FLUX_MAIL_API_FETCH_USER_NAME"],
                $_ENV["FLUX_MAIL_API_FETCH_PASSWORD"],
                $_ENV["FLUX_MAIL_API_FETCH_ENCRYPTION_TYPE"] ?? null,
                $_ENV["FLUX_MAIL_API_FETCH_BOX"] ?? null,
                ($mark_as_read = $_ENV["FLUX_MAIL_API_FETCH_MARK_AS_READ"] ?? null) !== null ? in_array($mark_as_read, ["true", "1"]) : null
            );
        }

        return $this->mail_server;
    }


    private function getSmtpServer() : SmtpServerEnv
    {
        if ($this->smtp_server === null) {
            $this->smtp_server = SmtpServerEnv::new(
                $_ENV["FLUX_MAIL_API_SMTP_HOST"],
                $_ENV["FLUX_MAIL_API_SMTP_PORT"],
                AddressDto::new(
                    $_ENV["FLUX_MAIL_API_SEND_FROM"],
                    $_ENV["FLUX_MAIL_API_SEND_FROM_NAME"] ?? null
                ),
                $_ENV["FLUX_MAIL_API_SMTP_ENCRYPTION_TYPE"] ?? null,
                $_ENV["FLUX_MAIL_API_SMTP_USER_NAME"] ?? null,
                $_ENV["FLUX_MAIL_API_SMTP_PASSWORD"] ?? null,
                $_ENV["FLUX_MAIL_API_SMTP_AUTH_TYPE"] ?? null
            );
        }

        return $this->smtp_server;
    }


    public function getFetchMailsService() : FetchMailsService
    {
        return FetchMailsService::new(
            $this->getMailServer()
        );
    }


    public function getSendMailService() : SendMailService
    {
        return SendMailService::new(
            $this->getSmtpServer()
        );
    }
}
