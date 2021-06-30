<?php

namespace Fluxlabs\FluxMailApi\Config;

class ServerEnv
{

    private ?string $https_cert = null;
    private ?string $https_key = null;
    private string $listen;
    private int $port;


    public static function new(?string $https_cert = null, ?string $https_key = null, ?string $listen = null, ?int $port = null) : static
    {
        $env = new static();

        $env->https_cert = $https_cert;
        $env->https_key = $https_key;
        $env->listen = $listen ?? "0.0.0.0";
        $env->port = $port ?? 9501;

        return $env;
    }


    public function getHttpsCert() : ?string
    {
        return $this->https_cert;
    }


    public function getHttpsKey() : ?string
    {
        return $this->https_key;
    }


    public function getListen() : string
    {
        return $this->listen;
    }


    public function getPort() : int
    {
        return $this->port;
    }
}
