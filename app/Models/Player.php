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

    const CREATED_AT        = 'created_at';
    const UPDATED_AT        = 'updated_at';

    protected $guard        = 'players';
    protected $primaryKey   = 'player_id';
    public $timestamps      = false;
    protected $guarded      = [];
}
