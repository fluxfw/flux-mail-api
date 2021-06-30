<?php

namespace Fluxlabs\FluxMailApi\Channel\InitServer\Command;

use Fluxlabs\FluxMailApi\Adapter\Api\FluxMailApi;
use Fluxlabs\FluxMailApi\Adapter\Api\MailDtoBuilder;
use Fluxlabs\FluxMailApi\Config\ServerEnv;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

class InitServerCommandHandler
{

    private ServerEnv $server;


    public static function new(ServerEnv $server) : static
    {
        $handler = new static();

        $handler->server = $server;

        return $handler;
    }


    public function handle(InitServerCommand $command) : void
    {
        $options = [];
        $sock_type = SWOOLE_TCP;

        if ($this->server->getHttpsCert() !== null) {
            $options += [
                "ssl_cert_file" => $this->server->getHttpsCert(),
                "ssl_key_file"  => $this->server->getHttpsKey()
            ];
            $sock_type += SWOOLE_SSL;
        }

        $server = new Server($this->server->getListen(), $this->server->getPort(), SWOOLE_PROCESS, $sock_type);

        $server->set($options);

        $server->on("request", function (Request $request, Response $response) : void { $this->request($request, $response); });

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
        $mails = FluxMailApi::new()
            ->fetch()
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

        FluxMailApi::new()
            ->send(
                $mail_builder
                    ->withBodyText(
                        $post_data["body_text"] ?? null
                    )
                    ->build()
            );

        $response->end();
    }
}
