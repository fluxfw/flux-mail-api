<?php

namespace FluxMailApi\Adapter\Route;

use FluxMailApi\Adapter\Api\AddressDto;
use FluxMailApi\Adapter\Api\Api;
use FluxMailApi\Adapter\Api\AttachmentDataEncoding;
use FluxMailApi\Adapter\Api\AttachmentDto;
use FluxMailApi\Adapter\Api\MailDto;
use FluxRestApi\Body\JsonBodyDto;
use FluxRestApi\Body\TextBodyDto;
use FluxRestApi\Request\RequestDto;
use FluxRestApi\Response\ResponseDto;
use FluxRestApi\Route\Route;
use FluxRestBaseApi\Body\DefaultBodyType;
use FluxRestBaseApi\Method\DefaultMethod;
use FluxRestBaseApi\Method\Method;
use FluxRestBaseApi\Status\DefaultStatus;

class SendRoute implements Route
{

    private readonly Api $api;


    public static function new(Api $api) : static
    {
        $route = new static();

        $route->api = $api;

        return $route;
    }


    public function getDocuRequestBodyTypes() : ?array
    {
        return [
            DefaultBodyType::JSON
        ];
    }


    public function getDocuRequestQueryParams() : ?array
    {
        return null;
    }


    public function getMethod() : Method
    {
        return DefaultMethod::POST;
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
                DefaultStatus::_400
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
                    ($data_encoding = $attachment->data_encoding ?? null) !== null ? AttachmentDataEncoding::from($data_encoding) : null,
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
