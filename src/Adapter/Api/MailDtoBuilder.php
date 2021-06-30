<?php

namespace Fluxlabs\FluxMailApi\Adapter\Api;

use DateTime;

class MailDtoBuilder
{

    private string $subject;
    private string $body_html;
    private array $to;
    private ?array $attachments;
    private ?array $reply_to;
    private ?array $cc;
    private ?array $bcc;
    private ?AddressDto $from;
    private ?DateTime $time;
    private ?string $message_id;
    private ?string $body_text;


    public static function new(string $subject, string $body_html, string $to_email, ?string $to_name = null) : static
    {
        $builder = new static();

        $builder->subject = $subject;
        $builder->body_html = $body_html;
        $builder->to = [];
        $builder->attachments = null;
        $builder->reply_to = null;
        $builder->cc = null;
        $builder->bcc = null;
        $builder->from = null;
        $builder->time = null;
        $builder->message_id = null;
        $builder->body_text = null;

        return $builder
            ->addTo(
                $to_email,
                $to_name
            );
    }


    public function addTo(string $email, ?string $name = null) : static
    {
        $this->to[] = AddressDto::new(
            $email,
            $name
        );

        return $this;
    }


    public function addAttachment(string $name, string $data, ?string $data_encoding = null, ?string $data_type = null) : static
    {
        $this->attachments ??= [];
        $this->attachments[] = AttachmentDto::new(
            $name,
            $data,
            $data_encoding,
            $data_type
        );

        return $this;
    }


    public function addReplyTo(string $email, ?string $name = null) : static
    {
        $this->reply_to ??= [];
        $this->reply_to[] = AddressDto::new(
            $email,
            $name
        );

        return $this;
    }


    public function addCc(string $email, ?string $name = null) : static
    {
        $this->cc ??= [];
        $this->cc[] = AddressDto::new(
            $email,
            $name
        );

        return $this;
    }


    public function addBcc(string $email, ?string $name = null) : static
    {
        $this->bcc ??= [];
        $this->bcc[] = AddressDto::new(
            $email,
            $name
        );

        return $this;
    }


    public function withFrom(string $email, ?string $name = null) : static
    {
        $this->from = AddressDto::new(
            $email,
            $name
        );

        return $this;
    }


    public function withTime(DateTime $time) : static
    {
        $this->time = $time;

        return $this;
    }


    public function withMessageId(string $message_id) : static
    {
        $this->message_id = $message_id;

        return $this;
    }


    public function withBodyText(string $body_text) : static
    {
        $this->body_text = $body_text;

        return $this;
    }


    public function build() : MailDto
    {
        return MailDto::new(
            $this->subject,
            $this->body_html,
            $this->to,
            $this->attachments,
            $this->reply_to,
            $this->cc,
            $this->bcc,
            $this->from,
            $this->time,
            $this->message_id,
            $this->body_text
        );
    }
}
