<?php

return [
    'base_url' => env('PESAPAL_BASE_URL'),
    'consumer_key' => env('PESAPAL_CONSUMER_KEY'),
    'consumer_secret' => env('PESAPAL_CONSUMER_SECRET'),
    'webhook_path' => env('PESAPAL_WEBHOOK_PATH', 'pesapal/webhook'),

    'table_prefix' => env('PESAPAL_TABLE_PREFIX', 'pesapal_'),

    'billing_address_model' => \AllanDereal\PesaPal\Models\PesaPalBillingAddresses::class,
];
