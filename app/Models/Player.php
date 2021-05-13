<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Player extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $guard        = 'players';
    protected $primaryKey   = 'player_id';
    public $timestamps      = false;
    protected $guarded      = [];

    public function coin() {
        return $this->hasOne(Coins::class, 'player_id');
    }

    public function ticket() {
        return $this->hasOne(Ticket::class, 'player_id');
    }
}
