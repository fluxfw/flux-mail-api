<?php

namespace Fluxlabs\FluxMailApi\Adapter\Server;

use Fluxlabs\FluxMailApi\Adapter\Api\Api;
use Fluxlabs\FluxMailApi\Adapter\Api\MailDtoBuilder;
use Fluxlabs\FluxMailApi\Adapter\Config\Config;
use Fluxlabs\FluxMailApi\Adapter\Config\EnvConfig;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server as SwooleServer;

class Server
{

    private Config $config;
    private Api $api;


    public static function new(?Config $config = null, ?Api $api = null) : static
    {
        $server = new static();

        $server->config = $config ?? EnvConfig::new();
        $server->api = $api ?? Api::new(
                $server->config
            );

        return $server;
    }


    public function init() : void
    {
        $options = [];
        $sock_type = SWOOLE_TCP;

        if ($this->config->getServerConfig()->getHttpsCert() !== null) {
            $options += [
                "ssl_cert_file" => $this->config->getServerConfig()->getHttpsCert(),
                "ssl_key_file"  => $this->config->getServerConfig()->getHttpsKey()
            ];
            $sock_type += SWOOLE_SSL;
        }

        $server = new SwooleServer($this->config->getServerConfig()->getListen(), $this->config->getServerConfig()->getPort(), SWOOLE_PROCESS, $sock_type);

        $server->set($options);

        $server->on("request", function (Request $request, Response $response) : void {
            $this->request($request, $response);
        });

        $server->start();
    }


    private function request(Request $request, Response $response) : void
    {
        switch (true) {
            case $request->server["request_uri"] === "/fetch" && $request->getMethod() === "GET":
                $this->fetchRequest($response);
                break;

            case $request->server["request_uri"] === "/send" && $request->getMethod() === "POST" && str_contains($request->header["content-type"], "application/json"):
                $this->sendRequest($request, $response);
                break;

            default:
                $response->status(403);
                $response->end();
                break;
        }
    }


    private function fetchRequest(Response $response) : void
    {
        $mails = $this->api->fetch()
            ->getMails();

        $response->header("Content-Type", "application/json;charset=utf-8");
        $response->write(json_encode($mails));
        $response->end();
    }


    private function sendRequest(Request $request, Response $response) : void
    {
        $post_data = json_decode($request->getContent(), true);

        $mail_builder = MailDtoBuilder::new(
            $post_data["subject"],
            $post_data["body_html"],
            $post_data["to"][0]["email"],
            $post_data["to"][0]["name"] ?? null
        );

        foreach ($post_data["to"] ?? [] as $to_i => $to) {
            if ($to_i === 0) {
                continue;
            }

            $mail_builder = $mail_builder->addTo(
                $to["email"],
                $to["name"] ?? null
            );
        }

        foreach ($post_data["attachments"] ?? [] as $attachment) {
            $mail_builder = $mail_builder->addAttachment(
                $attachment["name"],
                $attachment["data"],
                $attachment["data_encoding"] ?? null,
                $attachment["data_type"] ?? null
            );
        }

        foreach ($post_data["reply_to"] ?? [] as $reply_to) {
            $mail_builder = $mail_builder->addReplyTo(
                $reply_to["email"],
                $reply_to["name"] ?? null
            );
        }

        foreach ($post_data["cc"] ?? [] as $cc) {
            $mail_builder = $mail_builder->addCc(
                $cc["email"],
                $cc["name"] ?? null
            );
        }

        foreach ($post_data["bbc"] ?? [] as $bbc) {
            $mail_builder = $mail_builder->addBcc(
                $bbc["email"],
                $bbc["name"] ?? null
            );
        }

        $this->api->send(
            $mail_builder
                ->withBodyText(
                    $post_data["body_text"] ?? null
                )
                ->build()
        );

        $response->end();
    }
}
