<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{

    protected $table = 'seat';
    public $timestamps = false;
    protected $primaryKey = 'SEAT_ID';
    public $incrementing = false;


    protected $fillable = [
        'SEAT_ID', 'SEAT_TYPE', 'FLIGHT_ID', 'ISBOOKED'
    ];
}
