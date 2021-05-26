<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Raffles extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey   = 'raffle_id';
    public $timestamps      = false;
    protected $guarded      = [];

    public function schedule() {
        return $this->hasOne('App\Models\RafflesSchedule', 'raffle_id');
    }

    public function charity() {
        return $this->belongsTo('App\Models\Charity', 'charity_id');
    }

    public function type() {
        return $this->belongsTo('App\Models\RaffleType', 'type_id');
    }

    public function takenSlots() {
        return $this->hasMany(RaffleSlots::class, 'raffle_id');
    }
}
