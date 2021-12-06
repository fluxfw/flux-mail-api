<?php

namespace FluxMailApi\Adapter\Api;

class MailDto
{

    /**
     * @var AttachmentDto[]
     */
    public readonly array $attachments;
    /**
     * @var AddressDto[]
     */
    public readonly array $bcc;
    public readonly string $body_html;
    public readonly string $body_text;
    /**
     * @var AddressDto[]
     */
    public readonly array $cc;
    public readonly ?AddressDto $from;
    public readonly ?string $message_id;
    /**
     * @var AddressDto[]
     */
    public readonly array $reply_to;
    public readonly string $subject;
    public readonly int $time;
    /**
     * @var AddressDto[]
     */
    public readonly array $to;


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
}
