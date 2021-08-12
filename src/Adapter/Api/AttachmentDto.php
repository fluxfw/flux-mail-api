<?php

namespace Fluxlabs\FluxMailApi\Adapter\Api;

use JsonSerializable;

class AttachmentDto implements JsonSerializable
{

    const DATA_ENCODING_BASE64 = "base64";
    const DATA_ENCODING_PLAIN = "plain";
    private string $data;
    private string $data_encoding;
    private ?string $data_type;
    private string $name;


    public static function new(string $name, string $data, ?string $data_encoding, ?string $data_type = null) : static
    {
        $dto = new static();

        $dto->name = $name;
        $dto->data = $data;
        $dto->data_encoding = $data_encoding ?? static::DATA_ENCODING_PLAIN;
        $dto->data_type = $data_type;

        return $dto;
    }


    public function getData() : string
    {
        return $this->data;
    }


    public function getDataEncoding() : string
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
