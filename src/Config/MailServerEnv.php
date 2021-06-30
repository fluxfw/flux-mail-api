<?php

namespace Fluxlabs\FluxMailApi\Config;

class MailServerEnv
{

    const TYPE_IMAP = "imap";
    const TYPE_POP3 = "pop3";
    const TYPE_NNTP = "nntp";
    const ENCRYPTION_TYPE_SSL = "ssl";
    const ENCRYPTION_TYPE_TLS = "tls";
    const ENCRYPTION_TYPE_TLS_AUTO = "tls-auto";
    const BOX_INBOX = "INBOX";
    private string $host;
    private int $port;
    private string $type;
    private string $user_name;
    private string $password;
    private ?string $encryption_type;
    private string $box;
    private bool $mark_as_read;


    public static function new(string $host, int $port, string $type, string $user_name, string $password, ?string $encryption_type = null, ?string $box = null, ?bool $mark_as_read = null) : static
    {
        $env = new static();

        $env->host = $host;
        $env->port = $port;
        $env->type = $type;
        $env->user_name = $user_name;
        $env->password = $password;
        $env->encryption_type = $encryption_type;
        $env->box = $box ?? static::BOX_INBOX;
        $env->mark_as_read = $mark_as_read ?? true;

        return $env;
    }


    public function getHost() : string
    {
        return $this->host;
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


    public function getPassword() : string
    {
        return $this->password;
    }


    public function getEncryptionType() : ?string
    {
        return $this->encryption_type;
    }


    public function getBox() : string
    {
        return $this->box;
    }


    public function isMarkAsRead() : bool
    {
        return $this->mark_as_read;
    }
}
