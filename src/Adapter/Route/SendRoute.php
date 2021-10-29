<?php

namespace FluxMailApi\Adapter\Route;

use FluxMailApi\Adapter\Api\AddressDto;
use FluxMailApi\Adapter\Api\Api;
use FluxMailApi\Adapter\Api\AttachmentDto;
use FluxMailApi\Adapter\Api\MailDto;
use FluxRestApi\Body\BodyType;
use FluxRestApi\Body\JsonBodyDto;
use FluxRestApi\Body\TextBodyDto;
use FluxRestApi\Method\Method;
use FluxRestApi\Request\RequestDto;
use FluxRestApi\Response\ResponseDto;
use FluxRestApi\Route\Route;
use FluxRestApi\Status\Status;

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

        $this->api->send(
            MailDto::new(
                $request->getParsedBody()->getData()->subject,
                $request->getParsedBody()->getData()->body_html,
                array_map(fn(object $address) : AddressDto => AddressDto::new(
                    $address->email,
                    $address->name ?? null
                ), $request->getParsedBody()->getData()->to ?? []),
                array_map(fn(object $attachment) : AttachmentDto => AttachmentDto::new(
                    $attachment->name,
                    $attachment->data,
                    $attachment->data_encoding ?? null,
                    $attachment->data_type ?? null
                ), $request->getParsedBody()->getData()->attachments ?? []),
                array_map(fn(object $address) : AddressDto => AddressDto::new(
                    $address->email,
                    $address->name ?? null
                ), $request->getParsedBody()->getData()->reply_to ?? []),
                array_map(fn(object $address) : AddressDto => AddressDto::new(
                    $address->email,
                    $address->name ?? null
                ), $request->getParsedBody()->getData()->cc ?? []),
                array_map(fn(object $address) : AddressDto => AddressDto::new(
                    $address->email,
                    $address->name ?? null
                ), $request->getParsedBody()->getData()->bbc ?? []),
                null,
                null,
                null,
                $request->getParsedBody()->getData()->body_text ?? null
            )
        );

        return null;
    }
}
