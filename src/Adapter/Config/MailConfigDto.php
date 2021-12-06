<?php

namespace FluxMailApi\Adapter\Config;

class MailConfigDto
{

    private const BOX_INBOX = "INBOX";
    public readonly string $box;
    public readonly ?EncryptionType $encryption_type;
    public readonly string $host;
    public readonly bool $mark_as_read;
    public readonly string $password;
    public readonly int $port;
    public readonly MailConfigType $type;
    public readonly string $user_name;


    public static function new(
        string $host,
        int $port,
        MailConfigType $type,
        string $user_name,
        string $password,
        ?EncryptionType $encryption_type = null,
        ?string $box = null,
        ?bool $mark_as_read = null
    ) : static {
        $dto = new static();

        $dto->host = $host;
        $dto->port = $port;
        $dto->type = $type;
        $dto->user_name = $user_name;
        $dto->password = $password;
        $dto->encryption_type = $encryption_type;
        $dto->box = $box ?? static::BOX_INBOX;
        $dto->mark_as_read = $mark_as_read ?? true;

        return $dto;
    }
}
