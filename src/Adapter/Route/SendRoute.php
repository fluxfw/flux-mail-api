<?php

namespace Fluxlabs\FluxMailApi\Adapter\Route;

use Fluxlabs\FluxMailApi\Adapter\Api\AddressDto;
use Fluxlabs\FluxMailApi\Adapter\Api\Api;
use Fluxlabs\FluxMailApi\Adapter\Api\AttachmentDto;
use Fluxlabs\FluxMailApi\Adapter\Api\MailDto;
use Fluxlabs\FluxRestApi\Body\BodyType;
use Fluxlabs\FluxRestApi\Body\JsonBodyDto;
use Fluxlabs\FluxRestApi\Body\TextBodyDto;
use Fluxlabs\FluxRestApi\Method\Method;
use Fluxlabs\FluxRestApi\Request\RequestDto;
use Fluxlabs\FluxRestApi\Response\ResponseDto;
use Fluxlabs\FluxRestApi\Route\Route;
use Fluxlabs\FluxRestApi\Status\Status;
use stdClass;

class SendRoute implements Route
{

    private Api $api;


    public static function new(Api $api) : static
    {
        $route = new static();

        $route->api = $api;

        return $route;
    }


    public function getDocuRequestBodyTypes() : ?array
    {
        return [
            BodyType::JSON
        ];
    }


    public function getDocuRequestQueryParams() : ?array
    {
        return null;
    }


    public function getMethod() : string
    {
        return Method::POST;
    }


    public function getRoute() : string
    {
        return "/send";
    }


    public function handle(RequestDto $request) : ?ResponseDto
    {
        if (!($request->getParsedBody() instanceof JsonBodyDto)) {
            return ResponseDto::new(
                TextBodyDto::new(
                    "No json body"
                ),
                Status::_400
            );
        }

        $post_data = $request->getParsedBody()->getData();

        $this->api->send(
            MailDto::new(
                $post_data->subject,
                $post_data->body_html,
                array_map(fn(stdClass $address) : AddressDto => AddressDto::new(
                    $address->email,
                    $address->name ?? null
                ), $post_data->to ?? []),
                array_map(fn(stdClass $attachment) : AttachmentDto => AttachmentDto::new(
                    $attachment->name,
                    $attachment->data,
                    $attachment->data_encoding ?? null,
                    $attachment->data_type ?? null
                ), $post_data->attachments ?? []),
                array_map(fn(stdClass $address) : AddressDto => AddressDto::new(
                    $address->email,
                    $address->name ?? null
                ), $post_data->reply_to ?? []),
                array_map(fn(stdClass $address) : AddressDto => AddressDto::new(
                    $address->email,
                    $address->name ?? null
                ), $post_data->cc ?? []),
                array_map(fn(stdClass $address) : AddressDto => AddressDto::new(
                    $address->email,
                    $address->name ?? null
                ), $post_data->bbc ?? []),
                null,
                null,
                null,
                $post_data->body_text ?? null
            )
        );

        return null;
    }
}
