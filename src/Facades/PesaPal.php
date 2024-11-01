<?php

namespace AllanDereal\PesaPal\Facades;

use Illuminate\Support\Facades\Facade;

/**
 */
class PesaPal extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return 'allandereal:pesapal';
    }
}
