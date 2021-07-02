<?php

namespace Fluxlabs\FluxMailApi\Adapter\Config;

interface Config
{

    public function getServerConfig() : ServerConfigDto;


    public function getMailServerConfig() : MailServerConfigDto;


    public function getSmtpServerConfig() : SmtpServerConfigDto;
}
