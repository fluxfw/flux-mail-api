<?php

namespace FluxMailApi\Adapter\Api;

use JsonSerializable;

class AttachmentDto implements JsonSerializable
{

    private readonly string $data;
    private readonly AttachmentDataEncoding $data_encoding;
    private readonly ?string $data_type;
    private readonly string $name;


    public static function new(string $name, string $data, ?AttachmentDataEncoding $data_encoding, ?string $data_type = null) : static
    {
        $dto = new static();

        $dto->name = $name;
        $dto->data = $data;
        $dto->data_encoding = $data_encoding ?? AttachmentDataEncoding::PLAIN;
        $dto->data_type = $data_type;

        return $dto;
    }


    public function getData() : string
    {
        return $this->data;
    }


    public function getDataEncoding() : AttachmentDataEncoding
    {
        return $this->data_encoding;
    }


    public function getDataType() : ?string
    {
        return $this->data_type;
    }


    public function getName() : string
    {
        return $this->name;
    }


    public function jsonSerialize() : array
    {
        return get_object_vars($this);
    }
}
