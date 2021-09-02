<?php

namespace Fluxlabs\FluxMailApi\Channel\FetchMails\Command;

use DateTime;
use Fluxlabs\FluxMailApi\Adapter\Api\AddressDto;
use Fluxlabs\FluxMailApi\Adapter\Api\AttachmentDto;
use Fluxlabs\FluxMailApi\Adapter\Api\FetchedMailsDto;
use Fluxlabs\FluxMailApi\Adapter\Api\MailDto;
use Fluxlabs\FluxMailApi\Adapter\Config\MailConfigDto;
use PhpImap\Mailbox;
use stdClass;

class FetchMailsCommand
{

    private MailConfigDto $mail_config;


    public static function new(MailConfigDto $mail_config) : static
    {
        $command = new static();

        $command->mail_config = $mail_config;

        return $command;
    }


    public function fetch() : FetchedMailsDto
    {
        $fetcher = null;
        try {
            $connection_string = "{";

            $connection_string .= $this->mail_config->getHost();
            $connection_string .= ":" . $this->mail_config->getPort();

            $connection_string .= "/" . $this->mail_config->getType();

            if ($this->mail_config->getEncryptionType() !== null) {
                if ($this->mail_config->getEncryptionType() === MailConfigDto::ENCRYPTION_TYPE_TLS_AUTO) {
                    $connection_string .= "/" . MailConfigDto::ENCRYPTION_TYPE_SSL;
                } else {
                    $connection_string .= "/" . $this->mail_config->getEncryptionType();
                    if ($this->mail_config->getEncryptionType() !== MailConfigDto::ENCRYPTION_TYPE_TLS) {
                        $connection_string .= "/notls";
                    }
                }
            }

            $connection_string .= "}";

            $connection_string .= $this->mail_config->getBox();

            $fetcher = new Mailbox($connection_string, $this->mail_config->getUserName(), $this->mail_config->getPassword());

            $mails = [];

            foreach ($fetcher->sortMails(SORTARRIVAL, false) as $number) {
                $mail = $fetcher->getMail($number, $this->mail_config->isMarkAsRead());

                $mails[] = MailDto::new(
                    $mail->subject,
                    $mail->textHtml,
                    array_map([AddressDto::class, "new"], array_keys($mail->to), $mail->to),
                    array_map(fn(stdClass $attachment) : AttachmentDto => AttachmentDto::new(
                        $attachment->name,
                        base64_encode($attachment->getContents()),
                        AttachmentDto::DATA_ENCODING_BASE64,
                        $attachment->mime
                    ), $mail->getAttachments()
                    ),
                    array_map([AddressDto::class, "new"], array_keys($mail->replyTo), $mail->replyTo),
                    array_map([AddressDto::class, "new"], array_keys($mail->cc), $mail->cc),
                    array_map([AddressDto::class, "new"], array_keys($mail->bcc), $mail->bcc),
                    AddressDto::new(
                        $mail->fromAddress,
                        $mail->fromName
                    ),
                    (new DateTime($mail->date))->getTimestamp(),
                    $mail->messageId,
                    $mail->textPlain
                );
            }

            return FetchedMailsDto::new(
                $mails
            );
        } finally {
            if ($fetcher !== null) {
                $fetcher->disconnect();
            }
        }
    }
}
