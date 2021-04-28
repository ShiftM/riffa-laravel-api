<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Coins extends Model
{
    use HasFactory,Notifiable;

    protected $primaryKey   = 'raffle_id';
    protected $dateFormat = 'Y-m-d';

}
