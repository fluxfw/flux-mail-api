<?php

namespace FluxMailApi\Adapter\Api;

enum AttachmentDataEncoding: string
{

    case BASE64 = "base64";
    case PLAIN = "plain";
}
