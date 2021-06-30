#!/usr/bin/env php
<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Fluxlabs\FluxMailApi\Adapter\Api\FluxMailApi;
use Fluxlabs\FluxMailApi\Adapter\Api\MailDtoBuilder;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

$options = [];
$sock_type = SWOOLE_TCP;

if (($_ENV["FLUX_MAIL_API_HTTPS_CERT"] ?? null) !== null) {
    $options += [
        "ssl_cert_file" => $_ENV["FLUX_MAIL_API_HTTPS_CERT"],
        "ssl_key_file"  => $_ENV["FLUX_MAIL_API_HTTPS_KEY"]
    ];
    $sock_type += SWOOLE_SSL;
}

$server = new Server($_ENV["FLUX_MAIL_API_LISTEN"] ?? "0.0.0.0", $_ENV["FLUX_MAIL_API_PORT"] ?? 9501, SWOOLE_PROCESS, $sock_type);

$server->set($options);

$server->on("request", "request");

$server->start();

function request(Request $request, Response $response) : void
{
    switch (true) {
        case $request->server["request_uri"] === "/fetch" && $request->getMethod() === "GET":
            fetchRequest($response);
            break;

        case $request->server["request_uri"] === "/send" && $request->getMethod() === "POST" && str_contains($request->header["content-type"], "application/json"):
            sendRequest($request, $response);
            break;

        default:
            $response->status(403);
            $response->end();
            break;
    }
}

function fetchRequest(Response $response) : void
{
    $mails = FluxMailApi::new()
        ->fetch()
        ->getMails();

    $response->header("Content-Type", "application/json;charset=utf-8");
    $response->write(json_encode($mails));
    $response->end();
}

function sendRequest(Request $request, Response $response) : void
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
