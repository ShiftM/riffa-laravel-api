<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Charity extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey   = 'charity_id';
    public $timestamps      = false;
    protected $guarded      = [];
}
