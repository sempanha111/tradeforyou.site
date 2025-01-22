<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'plan',
        'amount',
        'money',              // New field
        'amount_crypto',   // New field
        'payer_account',   // New field
        'transaction_id',     // New field
        'status',
        'start_plan',
        'end_plan',
        'on_delete',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function history(){
        return $this->hasMany(History::class);
    }
}
