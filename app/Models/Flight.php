<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'fromLocation', 'toLocation', 'departureTime', 'arrivalTime', 'departureDay', 'originalPrice'
    ];

    public function fromAirport() {
        return $this->belongsTo(Airport::class, 'fromLocation', 'id');
    }

    public function toAirport() {
        return $this->belongsTo(Airport::class, 'toLocation', 'id');
    }
}
