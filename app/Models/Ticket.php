<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $fillable = [
        'id', 'cccd', 'name', 'mail', 'fly_id','seat_id', 'price'
    ];

    public function flight() {
        return $this->belongsTo(Flight::class, 'fly_id', 'id');
    }

    public function seat() {
        return $this->belongsTo(Seat::class, 'seat_id', 'id');
    }
}
