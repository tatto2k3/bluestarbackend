<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Luggage extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'mass', 'price'
    ];
}
