<?php

namespace FluxMailApi\Adapter\Config;

enum MailConfigType: string
{

    case IMAP = "imap";
    case NNTP = "nntp";
    case POP3 = "pop3";
}
