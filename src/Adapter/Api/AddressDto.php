<?php

namespace FluxMailApi\Adapter\Api;

class AddressDto
{

    public readonly string $email;
    public readonly ?string $name;


    public static function new(string $email, ?string $name = null) : static
    {
        $dto = new static();

        $dto->email = $email;
        $dto->name = $name;

        return $dto;
    }
}
