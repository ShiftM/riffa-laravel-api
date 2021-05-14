<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RafflesSchedule extends Model
{
    use HasFactory;

    const CREATED_AT        = 'created_at';
    const UPDATED_AT        = 'updated_at';

    protected $primaryKey   = 'schedule_id';
    public $timestamps      = false;
    protected $guarded      = [];

    public function raffle() {
        return $this->belongsTo('App\Models\Raffles', 'raffle_id');
    }

}