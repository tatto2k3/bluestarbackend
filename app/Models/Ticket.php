<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    protected $table = 'ticket';
    public $timestamps = false;
    protected $primaryKey = 'T_ID';
    public $incrementing = false;


    protected $fillable = [
        'T_ID', 'CCCD', 'Name', 'Fly_ID', 'Kg_ID','Seat_ID', 'Food_ID', 'Ticket_Price', 'Mail', 'Dis_ID'
    ];
}
