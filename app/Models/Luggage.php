<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Luggage extends Model
{

    protected $table = 'luggage';
    public $timestamps = false;
    protected $primaryKey = 'LUGGAGE_CODE';
    public $incrementing = false;


    protected $fillable = [
        'LUGGAGE_CODE', 'MASS', 'PRICE'
    ];
}
