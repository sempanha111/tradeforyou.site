<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'name',
        'email',
        'password',
        'perfect_money',
        'payeer',
        'bitcoin',
        'litecoin',
        'ethereum',
        'bitcoin_cash',
        'usdt_bsc_bep20',
        'sq',
        'sa',
        'remember_token',
        'link_from',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function withdraw(){
        return $this->hasMany(Withdraw::class);
    }
    public function deposit(){
        return $this->hasMany(Deposit::class);
    }
    public function earning(){
        return $this->hasMany(Earning::class);
    }
    public function history(){
        return $this->hasMany(History::class);
    }
    public function transaction(){
        return $this->hasMany(Transaction::class);
    }

}
