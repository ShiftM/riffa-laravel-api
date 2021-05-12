<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Coins extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey   = 'coin_id';
    public $timestamps      = false;
    protected $guarded      = [];
}
