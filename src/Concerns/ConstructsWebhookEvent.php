<?php

namespace AllanDereal\PesaPal\Concerns;

interface ConstructsWebhookEvent
{
    public function constructEvent(string $jsonPayload, string $signature, string $secret);
}
