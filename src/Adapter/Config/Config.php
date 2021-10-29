<?php

namespace FluxMailApi\Adapter\Config;

interface Config
{

    public function getMailConfig() : MailConfigDto;


    public function getServerConfig() : ServerConfigDto;


    public function getSmtpConfig() : SmtpConfigDto;
}
