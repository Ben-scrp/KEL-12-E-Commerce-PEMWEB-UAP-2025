<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VirtualAccount extends Model
{
    protected $fillable = [
        'transaction_id',
        'va_number',
        'is_paid',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}