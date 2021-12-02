<?php

namespace FluxMailApi\Adapter\Api;

use JsonSerializable;

class MailDto implements JsonSerializable
{

    private readonly array $attachments;
    private readonly array $bcc;
    private readonly string $body_html;
    private readonly string $body_text;
    private readonly array $cc;
    private readonly ?AddressDto $from;
    private readonly ?string $message_id;
    private readonly array $reply_to;
    private readonly string $subject;
    private readonly int $time;
    private readonly array $to;


    public static function new(
        string $subject,
        string $body_html,
        array $to,
        ?array $attachments = null,
        ?array $reply_to = null,
        ?array $cc = null,
        ?array $bcc = null,
        ?AddressDto $from = null,
        ?int $time = null,
        ?string $message_id = null,
        ?string $body_text = null
    ) : static {
        $dto = new static();

        $dto->subject = $subject;
        $dto->body_html = $body_html;
        $dto->to = $to;
        $dto->attachments = $attachments ?? [];
        $dto->reply_to = $reply_to ?? [];
        $dto->cc = $cc ?? [];
        $dto->bcc = $bcc ?? [];
        $dto->from = $from;
        $dto->time = $time ?? time();
        $dto->message_id = $message_id;
        $dto->body_text = $body_text ?? "";

        return $dto;
    }


    public function getAttachments() : array
    {
        return $this->attachments;
    }


    public function getBcc() : array
    {
        return $this->bcc;
    }


    public function getBodyHtml() : string
    {
        return $this->body_html;
    }


    public function getBodyText() : string
    {
        return $this->body_text;
    }


    public function getCc() : array
    {
        return $this->cc;
    }


    public function getFrom() : ?AddressDto
    {
        return $this->from;
    }


    public function getMessageId() : ?string
    {
        return $this->message_id;
    }


    public function getReplyTo() : array
    {
        return $this->reply_to;
    }


    public function getSubject() : string
    {
        return $this->subject;
    }


    public function getTime() : int
    {
        return $this->time;
    }


    public function getTo() : array
    {
        return $this->to;
    }


    public function jsonSerialize() : array
    {
        return get_object_vars($this);
    }
}
