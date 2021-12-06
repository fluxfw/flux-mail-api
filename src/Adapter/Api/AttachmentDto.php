<?php

namespace FluxMailApi\Adapter\Api;

use JsonSerializable;

class AttachmentDto implements JsonSerializable
{

    public readonly string $data;
    public readonly AttachmentDataEncoding $data_encoding;
    public readonly ?string $data_type;
    public readonly string $name;


    public static function new(string $name, string $data, ?AttachmentDataEncoding $data_encoding, ?string $data_type = null) : static
    {
        $dto = new static();

        $dto->name = $name;
        $dto->data = $data;
        $dto->data_encoding = $data_encoding ?? AttachmentDataEncoding::PLAIN;
        $dto->data_type = $data_type;

        return $dto;
    }


    public function jsonSerialize() : array
    {
        return get_object_vars($this);
    }
}
