<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Websocket extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'message',
        'timestamp',
    ];
}
