<?php

namespace Fluxlabs\FluxMailApi\Adapter\Route;

use Fluxlabs\FluxMailApi\Adapter\Api\Api;
use Fluxlabs\FluxMailApi\Adapter\Api\MailDtoBuilder;
use Fluxlabs\FluxRestApi\Body\BodyType;
use Fluxlabs\FluxRestApi\Request\RequestDto;
use Fluxlabs\FluxRestApi\Response\ResponseDto;
use Fluxlabs\FluxRestApi\Route\Route;

class SendRoute implements Route
{

    private Api $api;


    public static function new(Api $api) : static
    {
        $route = new static();

        $route->api = $api;

        return $route;
    }


    public function getBodyType() : ?string
    {
        return BodyType::JSON;
    }


    public function getMethod() : string
    {
        return "POST";
    }


    public function getRoute() : string
    {
        return "/send";
    }


    public function handle(RequestDto $request) : ResponseDto
    {
        $post_data = $request->getParsedBody()->getData();

        $mail_builder = MailDtoBuilder::new(
            $post_data->subject,
            $post_data->body_html,
            $post_data->to[0]->email,
            $post_data->to[0]->name ?? null
        );

        foreach ($post_data->to ?? [] as $to_i => $to) {
            if ($to_i === 0) {
                continue;
            }

            $mail_builder = $mail_builder->addTo(
                $to->email,
                $to->name ?? null
            );
        }

        foreach ($post_data->attachments ?? [] as $attachment) {
            $mail_builder = $mail_builder->addAttachment(
                $attachment->name,
                $attachment->data,
                $attachment->data_encoding ?? null,
                $attachment->data_type ?? null
            );
        }

        foreach ($post_data->reply_to ?? [] as $reply_to) {
            $mail_builder = $mail_builder->addReplyTo(
                $reply_to->email,
                $reply_to->name ?? null
            );
        }

        foreach ($post_data->cc ?? [] as $cc) {
            $mail_builder = $mail_builder->addCc(
                $cc->email,
                $cc->name ?? null
            );
        }

        foreach ($post_data->bbc ?? [] as $bbc) {
            $mail_builder = $mail_builder->addBcc(
                $bbc->email,
                $bbc->name ?? null
            );
        }

        $mail_builder = $mail_builder
            ->withBodyText(
                $post_data->body_text ?? null
            );

        $this->api->send(
            $mail_builder->build()
        );

        return ResponseDto::new();
    }
}
