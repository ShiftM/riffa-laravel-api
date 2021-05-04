<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PrizeCategories extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey   = 'category_id';
    public $timestamps      = false;
    protected $guarded      = [];
}
