<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{

    protected $table = 'food';
    public $timestamps = false;
    protected $primaryKey = 'F_ID';
    public $incrementing = false;


    protected $fillable = [
        'F_ID', 'F_NAME', 'F_PRICE'
    ];
}
