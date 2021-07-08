<?php

namespace Fluxlabs\FluxMailApi\Adapter\Config;

use Fluxlabs\FluxMailApi\Adapter\Api\AddressDto;

class SmtpConfigDto
{

    const ENCRYPTION_TYPE_SSL = "ssl";
    const ENCRYPTION_TYPE_TLS = "tls";
    const ENCRYPTION_TYPE_TLS_AUTO = "tls-auto";
    const AUTH_TYPE_PLAIN = "PLAIN";
    const AUTH_TYPE_LOGIN = "LOGIN";
    const AUTH_TYPE_CRAM_MD5 = "CRAM-MD5";
    const AUTH_TYPE_XOAUTH2 = "XOAUTH2";
    private string $host;
    private int $port;
    private AddressDto $default_from;
    private ?string $encryption_type;
    private ?string $user_name;
    private ?string $password;
    private ?string $auth_type;


    public static function new(
        string $host,
        int $port,
        AddressDto $default_from,
        ?string $encryption_type = null,
        ?string $user_name = null,
        ?string $password = null,
        ?string $auth_type = null
    ) : static {
        $dto = new static();

        $dto->host = $host;
        $dto->port = $port;
        $dto->default_from = $default_from;
        $dto->encryption_type = $encryption_type;
        $dto->user_name = $user_name;
        $dto->password = $password;
        $dto->auth_type = $auth_type;

        return $dto;
    }


    public function getHost() : string
    {
        return $this->host;
    }


    public function getPort() : int
    {
        return $this->port;
    }


    public function getDefaultFrom() : AddressDto
    {
        return $this->default_from;
    }


    public function getEncryptionType() : ?string
    {
        return $this->encryption_type;
    }


    public function getUserName() : ?string
    {
        return $this->user_name;
    }


    public function getPassword() : ?string
    {
        return $this->password;
    }


    public function getAuthType() : ?string
    {
        return $this->auth_type;
    }
}
