<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TicketTransaction extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey   = 'transaction_id';
    public $timestamps      = false;
    protected $guarded      = [];
}
