<?php

namespace FluxMailApi\Adapter\Config;

class MailConfigDto
{

    private const BOX_INBOX = "INBOX";
    private readonly string $box;
    private readonly ?EncryptionType $encryption_type;
    private readonly string $host;
    private readonly bool $mark_as_read;
    private readonly string $password;
    private readonly int $port;
    private readonly MailConfigType $type;
    private readonly string $user_name;


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


    public function getBox() : string
    {
        return $this->box;
    }


    public function getEncryptionType() : ?EncryptionType
    {
        return $this->encryption_type;
    }


    public function getHost() : string
    {
        return $this->host;
    }


    public function getPassword() : string
    {
        return $this->password;
    }


    public function getPort() : int
    {
        return $this->port;
    }


    public function getType() : MailConfigType
    {
        return $this->type;
    }


    public function getUserName() : string
    {
        return $this->user_name;
    }


    public function isMarkAsRead() : bool
    {
        return $this->mark_as_read;
    }
}
