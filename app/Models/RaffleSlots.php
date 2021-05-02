<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RaffleSlots extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey   = 'slots_id';
    public $timestamps      = false;

    protected $fillable = [
        'raffle_id',
        'player_id',
        'price_id',
        'slot_number',
        'status'
    ];

}
