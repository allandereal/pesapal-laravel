##PesaPal Laravel package

## Minimum Requirements

- Laravel  `11.x`
- A [PesaPal](https://pesapal.com/) account with consumer key and secret

## Installation

### Require the composer package

```sh
composer require allandereal/pesapal-laravel
```

### Publish the configuration

This will publish the configuration under `config/pesapal.php`.

```sh
php artisan vendor:publish --tag=pesapal.config
```

### Publish the views (optional)

PesaPal comes with some helper components for you to use on your checkout, if you intend to edit the views they provide, you can publish them.

```sh
php artisan vendor:publish --tag=pesapal.components
```

### Add your PesaPal credentials

Make sure you have the PesaPal credentials set in `config/pesapal.php`

```php
'base_url' => env('PESAPAL_BASE_URL'),
'consumer_key' => env('PESAPAL_CONSUMER_KEY'),
'consumer_secret' => env('PESAPAL_CONSUMER_SECRET'),
'webhook_path' => env('PESAPAL_WEBHOOK_URL'),
```

> Keys can be found in your PesaPal account https://developers.pesapal.com/

## Contributing

Contributions are welcome, if you are thinking of adding a feature, please submit an issue first so we can determine whether it should be included.
