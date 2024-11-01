<?php

namespace AllanDereal\PesaPal\DataTransferObjects;

class PesaPalConfig
{
    public function __construct()
    {
        //
    }

    public function getBaseUrl(): string
    {
        return config('pesapal.base_url');
    }

    public function getConsumerKey(): string
    {
        return config('pesapal.consumer_key');
    }

    public function getConsumerSecret(): string
    {
        return config('pesapal.consumer_secret');
    }

    public function getWebhookUrl(): string
    {
        return url(config('pesapal.webhook_path'));
    }

    public function getIpnId(): string
    {
        return config('pesapal.ipn_id');
    }
}