<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recordserver extends Model
{
    use HasFactory;
    protected $fillable = [
        'txhash',
        'my_adress',
        'from_adress',
        'crypto_type',
        'amount_crypto',
        'satoshis',
        'status',
        'details',
    ];
}
