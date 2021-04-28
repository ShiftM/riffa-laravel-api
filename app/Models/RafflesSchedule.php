<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RafflesSchedule extends Model
{
    use HasFactory;

    protected $primaryKey   = 'schedule_id';
    public $timestamps      = false;

    protected $dateFormat = 'Y-m-d';

}