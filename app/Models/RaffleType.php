<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RaffleType extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey   = 'type_id';
    public $timestamps      = false;
    protected $guarded      = [];

}
