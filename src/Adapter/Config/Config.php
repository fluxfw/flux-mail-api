<?php

namespace Fluxlabs\FluxMailApi\Adapter\Config;

interface Config
{

    public function getServerConfig() : ServerConfigDto;


    public function getMailConfig() : MailConfigDto;


    public function getSmtpConfig() : SmtpConfigDto;
}
