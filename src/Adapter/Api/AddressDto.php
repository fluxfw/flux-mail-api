<?php

namespace FluxMailApi\Adapter\Api;

use JsonSerializable;

class AddressDto implements JsonSerializable
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


    public function jsonSerialize() : array
    {
        return get_object_vars($this);
    }
}
