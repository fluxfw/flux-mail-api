<?php

namespace Fluxlabs\FluxMailApi\Channel\FetchMails\Command;

use DateTime;
use Fluxlabs\FluxMailApi\Adapter\Api\AttachmentDto;
use Fluxlabs\FluxMailApi\Adapter\Api\FetchedMailsDto;
use Fluxlabs\FluxMailApi\Adapter\Api\MailDtoBuilder;
use Fluxlabs\FluxMailApi\Config\MailServerEnv;
use PhpImap\Mailbox;

class FetchMailsCommandHandler
{

    private MailServerEnv $mail_server;


    public static function new(MailServerEnv $mail_server) : static
    {
        $handler = new static();

        $handler->mail_server = $mail_server;

        return $handler;
    }


    public function handle(FetchMailsCommand $command) : FetchedMailsDto
    {
        $fetcher = null;
        try {
            $connection_string = "{";

            $connection_string .= $this->mail_server->getHost();
            $connection_string .= ":" . $this->mail_server->getPort();

            $connection_string .= "/" . $this->mail_server->getType();

            if ($this->mail_server->getEncryptionType() !== null) {
                if ($this->mail_server->getEncryptionType() === MailServerEnv::ENCRYPTION_TYPE_TLS_AUTO) {
                    $connection_string .= "/" . MailServerEnv::ENCRYPTION_TYPE_SSL;
                } else {
                    $connection_string .= "/" . $this->mail_server->getEncryptionType();
                    if ($this->mail_server->getEncryptionType() !== MailServerEnv::ENCRYPTION_TYPE_TLS) {
                        $connection_string .= "/notls";
                    }
                }
            }

            $connection_string .= "}";

            $connection_string .= $this->mail_server->getBox();

            $fetcher = new Mailbox($connection_string, $this->mail_server->getUserName(), $this->mail_server->getPassword());

            $mails = [];

            foreach ($fetcher->sortMails(SORTARRIVAL, false) as $number) {
                $mail = $fetcher->getMail($number, $this->mail_server->isMarkAsRead());

                $mail_builder = MailDtoBuilder::new(
                    $mail->subject,
                    $mail->textHtml,
                    $to_email_first = array_key_first($mail->to),
                    $mail->to[$to_email_first]
                );

                foreach ($mail->to as $to_email => $to_name) {
                    if ($to_email === $to_email_first) {
                        continue;
                    }

                    $mail_builder = $mail_builder->addTo(
                        $to_email,
                        $to_name
                    );
                }

                foreach ($mail->getAttachments() as $attachment) {
                    $mail_builder = $mail_builder->addAttachment(
                        $attachment->name,
                        base64_encode($attachment->getContents()),
                        AttachmentDto::DATA_ENCODING_BASE64,
                        $attachment->mime
                    );
                }

                foreach ($mail->replyTo as $reply_to_email => $reply_to_name) {
                    $mail_builder = $mail_builder->addReplyTo(
                        $reply_to_email,
                        $reply_to_name
                    );
                }

                foreach ($mail->cc as $cc_email => $cc_name) {
                    $mail_builder = $mail_builder->addCc(
                        $cc_email,
                        $cc_name
                    );
                }

                foreach ($mail->bcc as $bbc_email => $bbc_name) {
                    $mail_builder = $mail_builder->addBcc(
                        $bbc_email,
                        $bbc_name
                    );
                }

                $mails[] = $mail_builder
                    ->withFrom(
                        $mail->fromAddress,
                        $mail->fromName
                    )
                    ->withTime(
                        new DateTime($mail->date)
                    )
                    ->withMessageId(
                        $mail->messageId
                    )
                    ->withBodyText(
                        $mail->textPlain
                    )
                    ->build();
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
