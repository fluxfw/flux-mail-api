<?php

namespace FluxMailApi\Adapter\Config;

use FluxMailApi\Adapter\Api\AddressDto;

class SmtpConfigDto
{

    public readonly ?SmtpConfigAuthType $auth_type;
    public readonly AddressDto $default_from;
    public readonly ?EncryptionType $encryption_type;
    public readonly string $host;
    public readonly ?string $password;
    public readonly int $port;
    public readonly ?string $user_name;


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
}
