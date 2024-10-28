<?php

namespace AllanDereal\PesaPal\Actions;

use AllanDereal\PesaPal\Concerns\ConstructsWebhookEvent;

class ConstructWebhookEvent implements ConstructsWebhookEvent
{
    public function constructEvent(string $jsonPayload, string $signature, string $secret)
    {
        //
    }
}
