<?php

namespace FluxMailApi\Adapter\Config;

use FluxMailApi\Adapter\Api\AddressDto;

class EnvConfig implements Config
{

    private static self $instance;
    private readonly MailConfigDto $mail_config;
    private readonly ServerConfigDto $server_config;
    private readonly SmtpConfigDto $smtp_config;


    public static function new() : static
    {
        static::$instance ??= new static();

        return static::$instance;
    }


    public function getMailConfig() : MailConfigDto
    {
        $this->mail_config ??= MailConfigDto::new(
            $_ENV["FLUX_MAIL_API_MAIL_HOST"],
            $_ENV["FLUX_MAIL_API_MAIL_PORT"],
            MailConfigType::from($_ENV["FLUX_MAIL_API_MAIL_TYPE"]),
            $_ENV["FLUX_MAIL_API_MAIL_USER_NAME"],
            $_ENV["FLUX_MAIL_API_MAIL_PASSWORD"],
            ($encryption_type = $_ENV["FLUX_MAIL_API_MAIL_ENCRYPTION_TYPE"] ?? null) ? EncryptionType::from($encryption_type) : null,
            $_ENV["FLUX_MAIL_API_MAIL_BOX"] ?? null,
            ($mark_as_read = $_ENV["FLUX_MAIL_API_MAIL_MARK_AS_READ"] ?? null) !== null ? in_array($mark_as_read, ["true", "1"]) : null
        );

        return $this->mail_config;
    }


    public function getServerConfig() : ServerConfigDto
    {
        $this->server_config ??= ServerConfigDto::new(
            $_ENV["FLUX_MAIL_API_SERVER_HTTPS_CERT"] ?? null,
            $_ENV["FLUX_MAIL_API_SERVER_HTTPS_KEY"] ?? null,
            $_ENV["FLUX_MAIL_API_SERVER_LISTEN"] ?? null,
            $_ENV["FLUX_MAIL_API_SERVER_PORT"] ?? null
        );

        return $this->server_config;
    }


    public function getSmtpConfig() : SmtpConfigDto
    {
        $this->smtp_config ??= SmtpConfigDto::new(
            $_ENV["FLUX_MAIL_API_SMTP_HOST"],
            $_ENV["FLUX_MAIL_API_SMTP_PORT"],
            AddressDto::new(
                $_ENV["FLUX_MAIL_API_SMTP_FROM"],
                $_ENV["FLUX_MAIL_API_SMTP_FROM_NAME"] ?? null
            ),
            ($encryption_type = $_ENV["FLUX_MAIL_API_SMTP_ENCRYPTION_TYPE"] ?? null) ? EncryptionType::from($encryption_type) : null,
            $_ENV["FLUX_MAIL_API_SMTP_USER_NAME"] ?? null,
            $_ENV["FLUX_MAIL_API_SMTP_PASSWORD"] ?? null,
            ($auth_type = $_ENV["FLUX_MAIL_API_SMTP_AUTH_TYPE"] ?? null) !== null ? SmtpConfigAuthType::from($auth_type) : null
        );

        return $this->smtp_config;
    }
}
