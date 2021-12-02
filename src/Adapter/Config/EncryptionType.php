<?php

namespace FluxMailApi\Adapter\Config;

enum EncryptionType: string
{

    case SSL = "ssl";
    case TLS = "tls";
    case TLS_AUTO = "tls-auto";
}
