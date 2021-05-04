<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Prizes extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey   = 'prize_id';
    public $timestamps      = false;
    protected $guarded      = [];
}
