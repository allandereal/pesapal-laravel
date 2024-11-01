<?php

return [
    'base_url' => env('PESAPAL_BASE_URL'),
    'consumer_key' => env('PESAPAL_CONSUMER_KEY'),
    'consumer_secret' => env('PESAPAL_CONSUMER_SECRET'),
    'ipn_id' => env('PESAPAL_IPN_ID'),
    'ipn_path' => env('PESAPAL_IPN_PATH'),
    'webhook_path' => env('PESAPAL_WEBHOOK_PATH', 'pesapal/webhook'),
    'redirect_path' => env('PESAPAL_REDIRECT_PATH', 'panel/wallets'),

    'table_prefix' => env('PESAPAL_TABLE_PREFIX', 'pesapal_'),

    'billing_address_model' => \AllanDereal\PesaPal\Models\BillingAddress::class,
];
