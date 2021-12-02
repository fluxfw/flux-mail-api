<?php

namespace FluxMailApi\Adapter\Config;

use FluxMailApi\Adapter\Api\AddressDto;

class SmtpConfigDto
{

    private readonly ?SmtpConfigAuthType $auth_type;
    private readonly AddressDto $default_from;
    private readonly ?EncryptionType $encryption_type;
    private readonly string $host;
    private readonly ?string $password;
    private readonly int $port;
    private readonly ?string $user_name;


    public static function new(
        string $host,
        int $port,
        AddressDto $default_from,
        ?EncryptionType $encryption_type = null,
        ?string $user_name = null,
        ?string $password = null,
        ?SmtpConfigAuthType $auth_type = null
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


    public function getAuthType() : ?SmtpConfigAuthType
    {
        return $this->auth_type;
    }


    public function getDefaultFrom() : AddressDto
    {
        return $this->default_from;
    }


    public function getEncryptionType() : ?EncryptionType
    {
        return $this->encryption_type;
    }


    public function getHost() : string
    {
        return $this->host;
    }


    public function getPassword() : ?string
    {
        return $this->password;
    }


    public function getPort() : int
    {
        return $this->port;
    }


    public function getUserName() : ?string
    {
        return $this->user_name;
    }
}
