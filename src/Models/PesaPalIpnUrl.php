<?php

namespace AllanDereal\PesaPal\Models;

use Illuminate\Database\Eloquent\Model;

class PesaPalIpnUrl extends Model
{
    public function getTable(): string
    {
        return config('pesapal.table_prefix') . 'ipn_urls';
    }

    protected $guarded = [];
}