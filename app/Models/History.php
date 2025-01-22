<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function deposit()
    {
        return $this->belongsTo(Deposit::class);
    }

    protected $fillable = [
        'user_id',
        'deposit_id',
        'from',
        'type',
        'deposit',
        'amount',
        'money',
    ];
}
