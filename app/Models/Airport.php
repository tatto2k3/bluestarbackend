<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'place', 'img'];

    protected $keyType = 'string'; 
    public $incrementing = false;

    public function departingFlight() {
        return $this->hasMany(Flight::class, 'fromLocation', 'id');
    }

    public function arrivingFlight() {
        return $this->hasMany(Flight::class, 'toLocation', 'id');
    }
}

