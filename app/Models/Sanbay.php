<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanbay extends Model
{

    protected $table = 'sanbay';
    public $timestamps = false;
    protected $primaryKey = 'airportID';
    public $incrementing = false;


    protected $fillable = [
        'airportID', 'airportName', 'place'
    ];
}
