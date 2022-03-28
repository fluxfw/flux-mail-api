<?php

namespace FluxMailApi\Adapter\Mail;

enum MailConfigType: string
{

    case IMAP = "imap";
    case NNTP = "nntp";
    case POP3 = "pop3";
}
