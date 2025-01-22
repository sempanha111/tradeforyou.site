<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'request_deposit_amount',
        'plan',
        'crypto',
        'amount_crypto',
        'status',
        'transaction_id',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
