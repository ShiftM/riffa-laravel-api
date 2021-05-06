<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaffleType extends Model
{
    use HasFactory;

    protected $primaryKey   = 'raffle_type_id';
    public $timestamps      = false;
    protected $guarded      = [];

    public function raffle() {
        return $this->belongsTo('App\Models', 'raffle_type_id');
    }
}
