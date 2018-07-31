<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherCode extends Model
{
    protected $fillable=["used_on"];
    function recipient()
    {
        return $this->belongsTo('App\Models\Recipient');
    }

    function offer()
    {
        return $this->belongsTo('App\Models\Offer');
    }
}
