<?php

namespace AllanDereal\PesaPal\Models;

use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    public function getTable(): string
    {
        return config('pesapal.table_prefix') . 'billing_addresses';
    }
    protected $guarded = [];
}