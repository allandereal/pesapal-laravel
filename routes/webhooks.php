<?php

use Illuminate\Support\Facades\Route;

Route::post(config('pesapal.webhook_path', 'pesapal/webhook'), \AllanDereal\PesaPal\Http\Controllers\WebhookController::class)
    ->middleware([\AllanDereal\PesaPal\Http\Middleware\PesaPalWebhookMiddleware::class, 'api'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('pesapal.webhook');
