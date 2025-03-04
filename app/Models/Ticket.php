<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'cccd', 'name', 'mail', 'fly_id', 'luggage_id','seat_id', 'food_id', 'price'
    ];

    public function flight() {
        return $this->belongsTo(Flight::class, 'fly_id', 'id');
    }

    public function luggage() {
        return $this->belongsTo(Luggage::class, 'luggage_id', 'id');
    }

    public function seat() {
        return $this->belongsTo(Seat::class, 'seat_id', 'id');
    }

    public function food() {
        return $this->belongsTo(Food::class, 'food_id', 'id');
    }
}
