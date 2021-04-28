<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CoinsTransaction extends Model
{
    use HasFactory,Notifiable;

    protected $primaryKey   = 'raffle_id';
    public $timestamps      = false;

}
