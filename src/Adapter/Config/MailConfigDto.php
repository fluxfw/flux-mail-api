<?php

namespace Fluxlabs\FluxMailApi\Adapter\Config;

class MailConfigDto
{

    const BOX_INBOX = "INBOX";
    const ENCRYPTION_TYPE_SSL = "ssl";
    const ENCRYPTION_TYPE_TLS = "tls";
    const ENCRYPTION_TYPE_TLS_AUTO = "tls-auto";
    const TYPE_IMAP = "imap";
    const TYPE_NNTP = "nntp";
    const TYPE_POP3 = "pop3";
    private string $box;
    private ?string $encryption_type;
    private string $host;
    private bool $mark_as_read;
    private string $password;
    private int $port;
    private string $type;
    private string $user_name;


    public static function new(string $host, int $port, string $type, string $user_name, string $password, ?string $encryption_type = null, ?string $box = null, ?bool $mark_as_read = null) : static
    {
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


    public function getEncryptionType() : ?string
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


    public function getType() : string
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
