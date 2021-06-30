<?php

namespace Fluxlabs\FluxMailApi\Adapter\Api;

use DateTime;
use JsonSerializable;

class MailDto implements JsonSerializable
{

    private string $subject;
    private string $body_html;
    private array $to;
    private array $attachments;
    private array $reply_to;
    private array $cc;
    private array $bcc;
    private ?AddressDto $from;
    private DateTime $time;
    private ?string $message_id;
    private string $body_text;


    public static function new(
        string $subject,
        string $body_html,
        array $to,
        ?array $attachments = null,
        ?array $reply_to = null,
        ?array $cc = null,
        ?array $bcc = null,
        ?AddressDto $from = null,
        ?DateTime $time = null,
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
        $dto->time = $time ?? new DateTime();
        $dto->message_id = $message_id;
        $dto->body_text = $body_text ?? "";

        return $dto;
    }


    public function getSubject() : string
    {
        return $this->subject;
    }


    public function getBodyHtml() : string
    {
        return $this->body_html;
    }


    /**
     * @return AddressDto[]
     */
    public function getTo() : array
    {
        return $this->to;
    }


    /**
     * @return AttachmentDto[]
     */
    public function getAttachments() : array
    {
        return $this->attachments;
    }


    /**
     * @return AddressDto[]
     */
    public function getReplyTo() : array
    {
        return $this->reply_to;
    }


    /**
     * @return AddressDto[]
     */
    public function getCc() : array
    {
        return $this->cc;
    }


    /**
     * @return AddressDto[]
     */
    public function getBcc() : array
    {
        return $this->bcc;
    }


    public function getFrom() : ?AddressDto
    {
        return $this->from;
    }


    public function getTime() : DateTime
    {
        return $this->time;
    }


    public function getMessageId() : ?string
    {
        return $this->message_id;
    }


    public function getBodyText() : string
    {
        return $this->body_text;
    }


    public function jsonSerialize() : array
    {
        $dto = get_object_vars($this);

        $dto["time"] = $this->time->getTimestamp();

        return $dto;
    }
}
