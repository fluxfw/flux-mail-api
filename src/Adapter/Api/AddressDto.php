<?php

namespace FluxMailApi\Adapter\Api;

use JsonSerializable;

class AddressDto implements JsonSerializable
{

    private readonly string $email;
    private readonly ?string $name;


    public static function new(string $email, ?string $name = null) : static
    {
        $dto = new static();

        $dto->email = $email;
        $dto->name = $name;

        return $dto;
    }


    public function getEmail() : string
    {
        return $this->email;
    }


    public function getName() : ?string
    {
        return $this->name;
    }


    public function jsonSerialize() : array
    {
        return get_object_vars($this);
    }
}
