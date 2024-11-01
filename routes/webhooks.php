<?php

use AllanDereal\PesaPal\Http\Controllers\WebhookController;
use AllanDereal\PesaPal\Http\Middleware\PesaPalWebhookMiddleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::group([], function (){
    Route::match(
        ['post', 'get'],
        config('pesapal.webhook_path', 'pesapal/webhook'),
        [WebhookController::class, 'webhook']
    )->name('pesapal.webhook');

    Route::match(
        ['post', 'get'],
        config('pesapal.ipn_path','pesapal/ipn'),
        [WebhookController::class, 'ipn']
    )->name('pesapal.ipn');
})->middleware([PesaPalWebhookMiddleware::class, 'api']) //TODO: add middleware to check that request is from pesapal
    ->withoutMiddleware([VerifyCsrfToken::class]);
