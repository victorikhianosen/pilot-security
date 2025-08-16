<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NsePrice extends Model
{
    protected $guarded = [];

    protected $casts = [
        'trade_date' => 'date',
        'payload' => 'array',
        // decimals as strings are fine; DB will coerce
    ];


}
