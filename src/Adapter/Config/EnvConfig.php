<?php

namespace Fluxlabs\FluxMailApi\Adapter\Config;

use Fluxlabs\FluxMailApi\Adapter\Api\AddressDto;

class EnvConfig implements Config
{

    private static ?self $instance = null;
    private ?ServerConfigDto $server_config = null;
    private ?MailServerConfigDto $mail_server_config = null;
    private ?SmtpServerConfigDto $smtp_server_config = null;


    public static function new() : static
    {
        static::$instance ??= new static();

        return static::$instance;
    }


    public function getServerConfig() : ServerConfigDto
    {
        $this->server_config ??= ServerConfigDto::new(
            $_ENV["FLUX_MAIL_API_HTTPS_CERT"] ?? null,
            $_ENV["FLUX_MAIL_API_HTTPS_KEY"] ?? null,
            $_ENV["FLUX_MAIL_API_LISTEN"] ?? null,
            $_ENV["FLUX_MAIL_API_PORT"] ?? null
        );

        return $this->server_config;
    }


    public function getMailServerConfig() : MailServerConfigDto
    {
        $this->mail_server_config ??= MailServerConfigDto::new(
            $_ENV["FLUX_MAIL_API_FETCH_HOST"],
            $_ENV["FLUX_MAIL_API_FETCH_PORT"],
            $_ENV["FLUX_MAIL_API_FETCH_TYPE"],
            $_ENV["FLUX_MAIL_API_FETCH_USER_NAME"],
            $_ENV["FLUX_MAIL_API_FETCH_PASSWORD"],
            $_ENV["FLUX_MAIL_API_FETCH_ENCRYPTION_TYPE"] ?? null,
            $_ENV["FLUX_MAIL_API_FETCH_BOX"] ?? null,
            ($mark_as_read = $_ENV["FLUX_MAIL_API_FETCH_MARK_AS_READ"] ?? null) !== null ? in_array($mark_as_read, ["true", "1"]) : null
        );

        return $this->mail_server_config;
    }


    public function getSmtpServerConfig() : SmtpServerConfigDto
    {
        $this->smtp_server_config ??= SmtpServerConfigDto::new(
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

        return $this->smtp_server_config;
    }
}
